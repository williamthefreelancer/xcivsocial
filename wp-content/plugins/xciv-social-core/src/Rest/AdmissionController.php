<?php
/**
 * REST: submit Admission Intelligence applications.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Rest;

use XCIV\Core\Models\ApplicationTable;
use XCIV\Core\Services\RolesService;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

final class AdmissionController {

	private const VERTICALS = array(
		'mfo',
		'hospitality',
		'club_event',
		'nightlife',
		'marketplace',
		'property',
		'consulting',
		'organizer',
		'partygoer',
		'holding',
		'other',
	);

	private const ANSWER_KEYS = array(
		'city',
		'title_role',
		'organization',
		'sovereignty',
		'lifestyle',
		'bring',
		'seek',
		'proof_url',
		'how_heard',
	);

	public static function init(): void {
		add_action( 'rest_api_init', array( self::class, 'register_routes' ) );
	}

	public static function register_routes(): void {
		register_rest_route(
			'xciv/v1',
			'/admission',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'submit' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * @return WP_REST_Response|WP_Error
	 */
	public static function submit( WP_REST_Request $request ) {
		$full_name = trim( (string) $request->get_param( 'full_name' ) );
		$email     = sanitize_email( (string) $request->get_param( 'email' ) );
		$vertical  = sanitize_key( (string) $request->get_param( 'vertical' ) );

		if ( '' === $full_name ) {
			return new WP_Error( 'xciv_admission_name', __( 'Enter your full name.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		if ( ! is_email( $email ) ) {
			return new WP_Error( 'xciv_admission_email', __( 'Enter a valid email.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		if ( ! in_array( $vertical, self::VERTICALS, true ) ) {
			return new WP_Error( 'xciv_admission_vertical', __( 'Select a vertical.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		$answers = array();
		foreach ( self::ANSWER_KEYS as $key ) {
			$raw = $request->get_param( $key );
			if ( null === $raw ) {
				$answers[ $key ] = '';
				continue;
			}

			if ( 'proof_url' === $key ) {
				$url = esc_url_raw( (string) $raw );
				$answers[ $key ] = $url;
				continue;
			}

			$answers[ $key ] = sanitize_textarea_field( (string) $raw );
		}

		$required_text = array( 'city', 'title_role', 'sovereignty', 'lifestyle', 'bring', 'seek' );
		foreach ( $required_text as $key ) {
			if ( '' === trim( (string) $answers[ $key ] ) ) {
				return new WP_Error(
					'xciv_admission_incomplete',
					__( 'Complete every required field before submitting.', 'xciv-social-core' ),
					array( 'status' => 400 )
				);
			}
		}

		if ( ! empty( $answers['proof_url'] ) && ! filter_var( $answers['proof_url'], FILTER_VALIDATE_URL ) ) {
			return new WP_Error( 'xciv_admission_proof', __( 'Enter a valid proof URL or leave it blank.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		global $wpdb;
		$table = ApplicationTable::table_name();

		$existing = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE email = %s AND status = %s LIMIT 1",
				$email,
				'pending_review'
			)
		);

		if ( $existing ) {
			return new WP_Error(
				'xciv_admission_duplicate',
				__( 'An application with this email is already awaiting review.', 'xciv-social-core' ),
				array( 'status' => 409 )
			);
		}

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			$existing_user = get_user_by( 'email', $email );
			if ( $existing_user instanceof \WP_User ) {
				$user_id = (int) $existing_user->ID;
			}
		}

		$now = current_time( 'mysql' );

		$inserted = $wpdb->insert(
			$table,
			array(
				'user_id'    => $user_id ?: null,
				'email'      => $email,
				'full_name'  => $full_name,
				'vertical'   => $vertical,
				'answers'    => wp_json_encode( $answers ),
				'status'     => 'pending_review',
				'owner_notes'=> null,
				'created_at' => $now,
				'updated_at' => $now,
			),
			array( '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
		);

		if ( false === $inserted ) {
			return new WP_Error(
				'xciv_admission_save',
				__( 'Could not save your application. Try again.', 'xciv-social-core' ),
				array( 'status' => 500 )
			);
		}

		if ( $user_id && ! user_can( $user_id, 'manage_options' ) ) {
			$user = new \WP_User( $user_id );
			$roles = (array) $user->roles;
			if ( ! in_array( RolesService::ROLE_MEMBER, $roles, true ) ) {
				$user->set_role( RolesService::ROLE_PENDING );
			}
		}

		return new WP_REST_Response(
			array(
				'ok'      => true,
				'status'  => 'pending_review',
				'message' => __( 'Application received. We review every request manually and will follow up by email.', 'xciv-social-core' ),
			),
			201
		);
	}
}

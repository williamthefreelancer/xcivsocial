<?php
/**
 * REST: join event pre-sale waitlists.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Rest;

use XCIV\Core\Models\WaitlistTable;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

final class WaitlistController {

	private const ALLOWED_SERIES = array(
		'township-backways-route',
	);

	public static function init(): void {
		add_action( 'rest_api_init', array( self::class, 'register_routes' ) );
	}

	public static function register_routes(): void {
		register_rest_route(
			'xciv/v1',
			'/waitlist',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'join' ),
				'permission_callback' => static function (): bool {
					return is_user_logged_in();
				},
				'args'                => array(
					'series_id'      => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_key',
					),
					'occurrence_id'  => array(
						'required'          => false,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'email'          => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_email',
					),
					'full_name'      => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'source'         => array(
						'required'          => false,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_key',
					),
				),
			)
		);
	}

	/**
	 * @return WP_REST_Response|WP_Error
	 */
	public static function join( WP_REST_Request $request ) {
		$series_id = (string) $request->get_param( 'series_id' );
		if ( ! in_array( $series_id, self::ALLOWED_SERIES, true ) ) {
			return new WP_Error( 'xciv_waitlist_series', __( 'Unknown event series.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		$email = (string) $request->get_param( 'email' );
		if ( ! is_email( $email ) ) {
			return new WP_Error( 'xciv_waitlist_email', __( 'Enter a valid email.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		$full_name = trim( (string) $request->get_param( 'full_name' ) );
		if ( '' === $full_name ) {
			return new WP_Error( 'xciv_waitlist_name', __( 'Enter your name.', 'xciv-social-core' ), array( 'status' => 400 ) );
		}

		$occurrence_id = (string) ( $request->get_param( 'occurrence_id' ) ?: '' );
		$source        = (string) ( $request->get_param( 'source' ) ?: 'events' );
		$user_id       = get_current_user_id();

		global $wpdb;
		$table = WaitlistTable::table_name();

		$existing = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE series_id = %s AND email = %s LIMIT 1",
				$series_id,
				$email
			)
		);

		if ( $existing ) {
			return new WP_REST_Response(
				array(
					'ok'      => true,
					'joined'  => true,
					'already' => true,
					'message' => __( 'You are already on this pre-sale waitlist.', 'xciv-social-core' ),
				),
				200
			);
		}

		$inserted = $wpdb->insert(
			$table,
			array(
				'series_id'     => $series_id,
				'occurrence_id' => $occurrence_id !== '' ? $occurrence_id : null,
				'user_id'       => $user_id ?: null,
				'email'         => $email,
				'full_name'     => $full_name,
				'source'        => $source,
				'created_at'    => current_time( 'mysql' ),
			),
			array( '%s', '%s', '%d', '%s', '%s', '%s', '%s' )
		);

		if ( false === $inserted ) {
			return new WP_Error( 'xciv_waitlist_save', __( 'Could not join the waitlist. Try again.', 'xciv-social-core' ), array( 'status' => 500 ) );
		}

		return new WP_REST_Response(
			array(
				'ok'      => true,
				'joined'  => true,
				'already' => false,
				'message' => __( 'You are on the pre-sale waitlist. We will notify you when tickets open.', 'xciv-social-core' ),
			),
			201
		);
	}
}

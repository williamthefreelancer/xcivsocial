<?php
/**
 * WPGraphQL type registration (boilerplate stub).
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\GraphQL;

final class Register {

	public static function types(): void {
		register_graphql_object_type(
			'XcivAdmissionStatus',
			array(
				'description' => 'Current admission status for the viewer.',
				'fields'      => array(
					'status' => array(
						'type'        => 'String',
						'description' => 'none | applicant | pending_review | member',
					),
				),
			)
		);

		register_graphql_field(
			'RootQuery',
			'xcivAdmissionStatus',
			array(
				'type'        => 'XcivAdmissionStatus',
				'description' => 'Admission status for the logged-in user.',
				'resolve'     => static function () {
					$user_id = get_current_user_id();
					if ( ! $user_id ) {
						return array( 'status' => 'none' );
					}

					$user = get_userdata( $user_id );
					$roles = $user ? (array) $user->roles : array();

					if ( in_array( 'administrator', $roles, true ) || in_array( 'xciv_member', $roles, true ) ) {
						return array( 'status' => 'member' );
					}
					if ( in_array( 'xciv_pending', $roles, true ) ) {
						return array( 'status' => 'pending_review' );
					}
					if ( in_array( 'xciv_applicant', $roles, true ) ) {
						return array( 'status' => 'applicant' );
					}

					return array( 'status' => 'none' );
				},
			)
		);
	}
}

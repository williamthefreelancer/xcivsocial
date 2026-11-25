<?php
/**
 * Theme-side membership checks (plugin owns roles; theme gates views).
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Services;

final class MembershipGate {

	public static function is_member( ?int $user_id = null ): bool {
		$user_id = $user_id ?? get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}

		if ( user_can( $user_id, 'manage_options' ) ) {
			return true;
		}

		$user = get_userdata( $user_id );
		if ( ! $user ) {
			return false;
		}

		return in_array( 'xciv_member', (array) $user->roles, true );
	}

	public static function require_member(): void {
		if ( self::is_member() ) {
			return;
		}

		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
}

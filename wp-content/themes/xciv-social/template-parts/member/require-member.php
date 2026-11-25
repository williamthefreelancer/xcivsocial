<?php
/**
 * Gate member-only templates: login redirect + membership check.
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Services\MembershipGate;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	auth_redirect();
}

MembershipGate::require_member();

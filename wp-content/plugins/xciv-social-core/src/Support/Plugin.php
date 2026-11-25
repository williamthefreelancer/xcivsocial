<?php
/**
 * Plugin bootstrap.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Support;

use XCIV\Core\Admin\AdmissionsPage;
use XCIV\Core\Services\RolesService;
use XCIV\Core\GraphQL\Register;

final class Plugin {

	public static function init(): void {
		RolesService::register_roles();
		AdmissionsPage::init();

		add_action(
			'graphql_register_types',
			static function (): void {
				if ( class_exists( 'WPGraphQL' ) ) {
					Register::types();
				}
			}
		);

		add_action(
			'admin_notices',
			static function (): void {
				if ( ! current_user_can( 'manage_options' ) ) {
					return;
				}
				if ( class_exists( 'WPGraphQL' ) ) {
					return;
				}
				echo '<div class="notice notice-warning"><p>';
				echo esc_html__( 'XCIV Social Core works best with WPGraphQL installed and activated.', 'xciv-social-core' );
				echo '</p></div>';
			}
		);
	}
}

<?php
/**
 * Plugin bootstrap.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Support;

use XCIV\Core\Admin\AdmissionsPage;
use XCIV\Core\Admin\DashboardPage;
use XCIV\Core\Admin\SettingsPage;
use XCIV\Core\Admin\WaitlistPage;
use XCIV\Core\Models\ApplicationTable;
use XCIV\Core\Models\WaitlistTable;
use XCIV\Core\Rest\AdmissionController;
use XCIV\Core\Rest\WaitlistController;
use XCIV\Core\Services\RolesService;
use XCIV\Core\GraphQL\Register;

final class Plugin {

	public static function init(): void {
		RolesService::register_roles();
		self::maybe_upgrade();
		DashboardPage::init();
		SettingsPage::init();
		AdmissionsPage::init();
		WaitlistPage::init();
		AdmissionController::init();
		WaitlistController::init();

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

	private static function maybe_upgrade(): void {
		$current = (string) get_option( 'xciv_core_db_version', '' );
		if ( version_compare( $current, '0.1.2', '>=' ) ) {
			return;
		}

		ApplicationTable::create();
		WaitlistTable::create();
		update_option( 'xciv_core_db_version', '0.1.2', false );
	}
}

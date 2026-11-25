<?php
/**
 * XCIV Social admin hub.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Admin;

use XCIV\Core\Models\ApplicationTable;
use XCIV\Core\Models\WaitlistTable;

final class DashboardPage {

	public static function init(): void {
		add_action( 'admin_menu', array( self::class, 'menu' ), 9 );
		add_action( 'admin_enqueue_scripts', array( self::class, 'assets' ) );
	}

	public static function menu(): void {
		add_menu_page(
			__( 'XCIV Social', 'xciv-social-core' ),
			__( 'XCIV Social', 'xciv-social-core' ),
			'manage_options',
			'xciv-social',
			array( self::class, 'render' ),
			'dashicons-groups',
			26
		);

		add_submenu_page(
			'xciv-social',
			__( 'Dashboard', 'xciv-social-core' ),
			__( 'Dashboard', 'xciv-social-core' ),
			'manage_options',
			'xciv-social',
			array( self::class, 'render' )
		);
	}

	public static function assets( string $hook ): void {
		if ( ! self::is_xciv_screen( $hook ) ) {
			return;
		}

		wp_enqueue_style(
			'xciv-admin',
			XCIV_CORE_URL . 'assets/css/admin.css',
			array(),
			XCIV_CORE_VERSION
		);

		if ( false !== strpos( $hook, 'xciv-social-settings' ) ) {
			wp_enqueue_script(
				'xciv-admin-settings',
				XCIV_CORE_URL . 'assets/js/admin-settings.js',
				array(),
				XCIV_CORE_VERSION,
				true
			);
		}
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wpdb;

		$pending_admissions = 0;
		$waitlist_total     = 0;
		$member_count       = 0;

		$apps_table = ApplicationTable::table_name();
		if ( $apps_table === $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $apps_table ) ) ) {
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$pending_admissions = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$apps_table} WHERE status = 'pending_review'" );
		}

		$wait_table = WaitlistTable::table_name();
		if ( $wait_table === $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wait_table ) ) ) {
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$waitlist_total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wait_table}" );
		}

		$member_count = (int) count(
			get_users(
				array(
					'role'   => 'xciv_member',
					'fields' => 'ID',
					'number' => -1,
				)
			)
		);

		$settings = SettingsStore::all();
		$event    = $settings['event'];
		$tickets  = $settings['tickets'];
		$addons   = $settings['addons'];
		$upsells  = $settings['upsells'];
		$briefing = $settings['dashboard'];

		$gaps = self::missing_requirements( $settings );

		include XCIV_CORE_DIR . 'views/admin-dashboard.php';
	}

	/**
	 * @param array<string, mixed> $settings Full settings.
	 * @return list<array{label: string, fix: string}>
	 */
	public static function missing_requirements( array $settings ): array {
		$gaps = array();

		$briefing_url = (string) ( $settings['dashboard']['briefing_url'] ?? '' );
		if ( '' === $briefing_url ) {
			$gaps[] = array(
				'label' => __( 'Member dashboard briefing video URL is empty.', 'xciv-social-core' ),
				'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=dashboard' ),
			);
		}

		$meet = (string) ( $settings['event']['meet_url'] ?? '' );
		if ( '' === $meet || false !== strpos( $meet, 'lookup/xciv-salon-demo' ) ) {
			$gaps[] = array(
				'label' => __( 'Online event still uses the demo Google Meet link.', 'xciv-social-core' ),
				'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=event' ),
			);
		}

		$tickets = $settings['tickets'] ?? array();
		if ( ! is_array( $tickets ) || count( $tickets ) < 1 ) {
			$gaps[] = array(
				'label' => __( 'No ticket tiers configured for event sales.', 'xciv-social-core' ),
				'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=tickets' ),
			);
		}

		$payments = $settings['payments'] ?? array();
		$mode     = is_array( $payments ) ? (string) ( $payments['mode'] ?? 'demo' ) : 'demo';
		if ( 'stripe' === $mode ) {
			$pub = (string) ( $payments['stripe_publishable'] ?? '' );
			$sec = (string) ( $payments['stripe_secret'] ?? '' );
			if ( '' === $pub || '' === $sec ) {
				$gaps[] = array(
					'label' => __( 'Stripe mode is on but publishable/secret keys are missing.', 'xciv-social-core' ),
					'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=payments' ),
				);
			}
		} else {
			$gaps[] = array(
				'label' => __( 'Checkout is still in demo mode (no live payments).', 'xciv-social-core' ),
				'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=payments' ),
			);
		}

		$addons = $settings['addons'] ?? array();
		if ( ! is_array( $addons ) || count( $addons ) < 1 ) {
			$gaps[] = array(
				'label' => __( 'No ticket add-ons configured.', 'xciv-social-core' ),
				'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=addons' ),
			);
		}

		$upsells = $settings['upsells'] ?? array();
		if ( ! is_array( $upsells ) || count( $upsells ) < 1 ) {
			$gaps[] = array(
				'label' => __( 'No upsell offers configured.', 'xciv-social-core' ),
				'fix'   => admin_url( 'admin.php?page=xciv-social-settings&tab=upsells' ),
			);
		}

		return $gaps;
	}

	private static function is_xciv_screen( string $hook ): bool {
		return false !== strpos( $hook, 'xciv-social' );
	}
}

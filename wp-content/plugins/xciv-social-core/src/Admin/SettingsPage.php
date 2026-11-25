<?php
/**
 * XCIV Social settings (tickets, add-ons, upsells, event, dashboard).
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Admin;

final class SettingsPage {

	public const PAGE_SLUG = 'xciv-social-settings';

	public static function init(): void {
		add_action( 'admin_menu', array( self::class, 'menu' ), 11 );
		add_action( 'admin_init', array( self::class, 'register' ) );
		add_filter( 'allowed_options', array( self::class, 'allowed_options' ) );
	}

	/**
	 * Ensure our option is allow-listed for options.php saves.
	 *
	 * @param array<string, list<string>> $allowed Allowed options map.
	 * @return array<string, list<string>>
	 */
	public static function allowed_options( array $allowed ): array {
		$allowed['xciv_social_settings_group'] = array( SettingsStore::OPTION_KEY );
		return $allowed;
	}

	public static function menu(): void {
		add_submenu_page(
			'xciv-social',
			__( 'Settings', 'xciv-social-core' ),
			__( 'Settings', 'xciv-social-core' ),
			'manage_options',
			self::PAGE_SLUG,
			array( self::class, 'render' )
		);
	}

	public static function register(): void {
		register_setting(
			'xciv_social_settings_group',
			SettingsStore::OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( self::class, 'sanitize_option' ),
				'default'           => SettingsStore::defaults(),
			)
		);
	}

	/**
	 * @param mixed $value Incoming option value.
	 * @return array<string, mixed>
	 */
	public static function sanitize_option( $value ): array {
		if ( ! is_array( $value ) ) {
			return SettingsStore::all();
		}

		return SettingsStore::sanitize( $value );
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings = SettingsStore::all();
		$tab      = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( (string) $_GET['tab'] ) ) : 'general'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$tabs     = self::tabs();
		if ( ! isset( $tabs[ $tab ] ) ) {
			$tab = 'general';
		}

		include XCIV_CORE_DIR . 'views/admin-settings.php';
	}

	/**
	 * @return array<string, string>
	 */
	public static function tabs(): array {
		return array(
			'general'   => __( 'General', 'xciv-social-core' ),
			'event'     => __( 'Online event', 'xciv-social-core' ),
			'tickets'   => __( 'Tickets', 'xciv-social-core' ),
			'addons'    => __( 'Add-ons', 'xciv-social-core' ),
			'upsells'   => __( 'Upsells', 'xciv-social-core' ),
			'dashboard' => __( 'Member dashboard', 'xciv-social-core' ),
			'payments'  => __( 'Payments', 'xciv-social-core' ),
		);
	}
}

<?php
/**
 * Admin: event pre-sale waitlist audience.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Admin;

use XCIV\Core\Models\WaitlistTable;

final class WaitlistPage {

	private const SERIES_LABELS = array(
		'township-backways-route' => 'The Township Backways Route',
	);

	public static function init(): void {
		add_action( 'admin_menu', array( self::class, 'menu' ) );
	}

	public static function menu(): void {
		add_submenu_page(
			'xciv-social',
			'Event Waitlists',
			'Event Waitlists',
			'manage_options',
			'xciv-social-waitlists',
			array( self::class, 'render' )
		);
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wpdb;
		$table  = WaitlistTable::table_name();
		$filter = isset( $_GET['series'] ) ? sanitize_key( wp_unslash( (string) $_GET['series'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $filter && isset( self::SERIES_LABELS[ $filter ] ) ) {
			$rows = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$table} WHERE series_id = %s ORDER BY created_at DESC LIMIT 500",
					$filter
				),
				ARRAY_A
			);
		} else {
			$rows = $wpdb->get_results(
				"SELECT * FROM {$table} ORDER BY created_at DESC LIMIT 500",
				ARRAY_A
			);
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$counts = $wpdb->get_results(
			"SELECT series_id, COUNT(*) AS total FROM {$table} GROUP BY series_id",
			ARRAY_A
		);
		$count_map = array();
		$total     = 0;
		foreach ( (array) $counts as $row ) {
			$series_total                        = (int) $row['total'];
			$count_map[ (string) $row['series_id'] ] = $series_total;
			$total                              += $series_total;
		}

		include XCIV_CORE_DIR . 'views/admin-waitlists.php';
	}
}

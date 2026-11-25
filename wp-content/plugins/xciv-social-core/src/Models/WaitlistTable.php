<?php
/**
 * Event pre-sale waitlist table.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Models;

final class WaitlistTable {

	public static function table_name(): string {
		global $wpdb;
		return $wpdb->prefix . 'xciv_event_waitlist';
	}

	public static function create(): void {
		global $wpdb;

		$table   = self::table_name();
		$charset = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			series_id varchar(64) NOT NULL,
			occurrence_id varchar(96) NULL,
			user_id bigint(20) unsigned NULL,
			email varchar(190) NOT NULL,
			full_name varchar(190) NOT NULL,
			source varchar(64) NOT NULL DEFAULT 'events',
			created_at datetime NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY series_email (series_id, email),
			KEY series_id (series_id),
			KEY created_at (created_at)
		) {$charset};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
}

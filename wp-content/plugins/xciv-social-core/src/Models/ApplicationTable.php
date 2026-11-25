<?php
/**
 * Admissions applications table.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Models;

final class ApplicationTable {

	public static function table_name(): string {
		global $wpdb;
		return $wpdb->prefix . 'xciv_applications';
	}

	public static function create(): void {
		global $wpdb;

		$table   = self::table_name();
		$charset = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			user_id bigint(20) unsigned NULL,
			email varchar(190) NOT NULL,
			full_name varchar(190) NOT NULL,
			vertical varchar(64) NOT NULL,
			answers longtext NOT NULL,
			status varchar(32) NOT NULL DEFAULT 'pending_review',
			owner_notes longtext NULL,
			created_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY status (status),
			KEY email (email)
		) {$charset};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
}

<?php
/**
 * Admin review queue (boilerplate).
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Admin;

use XCIV\Core\Models\ApplicationTable;
use XCIV\Core\Services\RolesService;

final class AdmissionsPage {

	public static function init(): void {
		add_action( 'admin_menu', array( self::class, 'menu' ) );
		add_action( 'admin_post_xciv_review_admission', array( self::class, 'handle_review' ) );
	}

	public static function menu(): void {
		add_submenu_page(
			'xciv-social',
			__( 'Admissions', 'xciv-social-core' ),
			__( 'Admissions', 'xciv-social-core' ),
			'manage_options',
			'xciv-social-admissions',
			array( self::class, 'render' )
		);
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wpdb;
		$table = ApplicationTable::table_name();
		$rows  = $wpdb->get_results(
			"SELECT * FROM {$table} WHERE status = 'pending_review' ORDER BY created_at DESC LIMIT 50",
			ARRAY_A
		);

		include XCIV_CORE_DIR . 'views/admin-admissions.php';
	}

	public static function handle_review(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Forbidden', 'xciv-social-core' ) );
		}

		check_admin_referer( 'xciv_review_admission' );

		$id     = isset( $_POST['application_id'] ) ? absint( $_POST['application_id'] ) : 0;
		$action = isset( $_POST['review_action'] ) ? sanitize_key( wp_unslash( $_POST['review_action'] ) ) : '';
		$notes  = isset( $_POST['owner_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['owner_notes'] ) ) : '';

		if ( ! $id || ! in_array( $action, array( 'approve', 'reject' ), true ) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=xciv-social-admissions' ) );
			exit;
		}

		global $wpdb;
		$table = ApplicationTable::table_name();
		$row   = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ), ARRAY_A );

		if ( ! $row ) {
			wp_safe_redirect( admin_url( 'admin.php?page=xciv-social-admissions&error=missing' ) );
			exit;
		}

		$new_status = $action === 'approve' ? 'approved' : 'rejected';

		$wpdb->update(
			$table,
			array(
				'status'      => $new_status,
				'owner_notes' => $notes,
				'updated_at'  => current_time( 'mysql' ),
			),
			array( 'id' => $id ),
			array( '%s', '%s', '%s' ),
			array( '%d' )
		);

		if ( $action === 'approve' && ! empty( $row['user_id'] ) ) {
			$user = new \WP_User( (int) $row['user_id'] );
			$user->set_role( RolesService::ROLE_MEMBER );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=xciv-social-admissions&updated=1' ) );
		exit;
	}
}

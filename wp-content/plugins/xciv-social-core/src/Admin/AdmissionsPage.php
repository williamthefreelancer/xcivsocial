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

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$rows = $wpdb->get_results(
			"SELECT * FROM {$table} WHERE status = 'pending_review' ORDER BY created_at DESC LIMIT 50",
			ARRAY_A
		);

		$counts = array(
			'pending'  => 0,
			'approved' => 0,
			'rejected' => 0,
			'total'    => 0,
		);

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$status_rows = $wpdb->get_results(
			"SELECT status, COUNT(*) AS total FROM {$table} GROUP BY status",
			ARRAY_A
		);

		foreach ( (array) $status_rows as $status_row ) {
			$status = (string) $status_row['status'];
			$total  = (int) $status_row['total'];
			$counts['total'] += $total;

			if ( 'pending_review' === $status ) {
				$counts['pending'] = $total;
			} elseif ( 'approved' === $status ) {
				$counts['approved'] = $total;
			} elseif ( 'rejected' === $status ) {
				$counts['rejected'] = $total;
			}
		}

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
		$user_id    = ! empty( $row['user_id'] ) ? (int) $row['user_id'] : 0;

		if ( $action === 'approve' ) {
			$user_id = self::ensure_member_user( $row, $user_id );
		}

		$wpdb->update(
			$table,
			array(
				'user_id'     => $user_id ?: null,
				'status'      => $new_status,
				'owner_notes' => $notes,
				'updated_at'  => current_time( 'mysql' ),
			),
			array( 'id' => $id ),
			array( '%d', '%s', '%s', '%s' ),
			array( '%d' )
		);

		wp_safe_redirect( admin_url( 'admin.php?page=xciv-social-admissions&updated=1' ) );
		exit;
	}

	/**
	 * Resolve or create a WP user and grant membership on approve.
	 *
	 * @param array<string,mixed> $row Application row.
	 */
	private static function ensure_member_user( array $row, int $user_id ): int {
		$email     = sanitize_email( (string) $row['email'] );
		$full_name = sanitize_text_field( (string) $row['full_name'] );

		if ( ! $user_id && is_email( $email ) ) {
			$existing = get_user_by( 'email', $email );
			if ( $existing instanceof \WP_User ) {
				$user_id = (int) $existing->ID;
			} else {
				$login = sanitize_user( current( explode( '@', $email ) ), true );
				if ( '' === $login ) {
					$login = 'xciv';
				}
				$base = $login;
				$n    = 1;
				while ( username_exists( $login ) ) {
					$login = $base . $n;
					++$n;
				}

				$user_id = wp_create_user( $login, wp_generate_password( 24, true, true ), $email );
				if ( is_wp_error( $user_id ) ) {
					return 0;
				}
				$user_id = (int) $user_id;

				wp_update_user(
					array(
						'ID'           => $user_id,
						'display_name' => $full_name ?: $login,
						'nickname'     => $full_name ?: $login,
						'first_name'   => $full_name,
					)
				);

				if ( function_exists( 'wp_send_new_user_notifications' ) ) {
					wp_send_new_user_notifications( $user_id, 'user' );
				}
			}
		}

		if ( ! $user_id || user_can( $user_id, 'manage_options' ) ) {
			return $user_id;
		}

		$user = new \WP_User( $user_id );
		$user->set_role( RolesService::ROLE_MEMBER );

		return $user_id;
	}
}

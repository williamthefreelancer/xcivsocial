<?php
/**
 * Ensure member platform pages exist with the correct templates/slugs.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class PageSeeder {

	private const OPTION_KEY = 'xciv_seeded_pages_v1';

	public static function init(): void {
		add_action( 'after_switch_theme', array( self::class, 'seed' ) );
		add_action( 'admin_init', array( self::class, 'maybe_seed' ) );
	}

	public static function maybe_seed(): void {
		$seeded = get_option( self::OPTION_KEY );
		if ( $seeded === XCIV_THEME_VERSION ) {
			return;
		}

		self::seed();
	}

	public static function seed(): void {
		self::migrate_legacy_pages();

		foreach ( self::pages() as $page ) {
			self::ensure_page( $page );
		}

		update_option( self::OPTION_KEY, XCIV_THEME_VERSION, false );
	}

	/**
	 * Rename directory → people and retire the connections page.
	 */
	private static function migrate_legacy_pages(): void {
		$directory = get_page_by_path( 'directory' );
		$people    = get_page_by_path( 'people' );

		if ( $directory instanceof \WP_Post && ! ( $people instanceof \WP_Post ) ) {
			wp_update_post(
				array(
					'ID'         => $directory->ID,
					'post_title' => 'People',
					'post_name'  => 'people',
				)
			);
			update_post_meta( $directory->ID, '_wp_page_template', 'page-templates/profile-directory.php' );
		}

		$connections = get_page_by_path( 'connections' );
		if ( $connections instanceof \WP_Post ) {
			wp_trash_post( $connections->ID );
		}
	}

	/**
	 * @return array<int, array{title: string, slug: string, template: string}>
	 */
	private static function pages(): array {
		return array(
			array(
				'title'    => 'Dashboard',
				'slug'     => 'dashboard',
				'template' => 'page-templates/dashboard.php',
			),
			array(
				'title'    => 'Events',
				'slug'     => 'events',
				'template' => 'page-templates/event-listings.php',
			),
			array(
				'title'    => 'Event Calendar',
				'slug'     => 'event-calendar',
				'template' => 'page-templates/event-calendar.php',
			),
			array(
				'title'    => 'Profile',
				'slug'     => 'profile',
				'template' => 'page-templates/profile.php',
			),
			array(
				'title'    => 'Account Settings',
				'slug'     => 'account-settings',
				'template' => 'page-templates/account-settings.php',
			),
			array(
				'title'    => 'Profile Settings',
				'slug'     => 'profile-settings',
				'template' => 'page-templates/profile-settings.php',
			),
			array(
				'title'    => 'Messages',
				'slug'     => 'messages',
				'template' => 'page-templates/messages.php',
			),
			array(
				'title'    => 'People',
				'slug'     => 'people',
				'template' => 'page-templates/profile-directory.php',
			),
			array(
				'title'    => 'Member Feed',
				'slug'     => 'member-feed',
				'template' => 'page-templates/member-feed.php',
			),
			array(
				'title'    => 'Request Admission',
				'slug'     => 'request-admission',
				'template' => 'page-templates/admission.php',
			),
			array(
				'title'    => 'Event Sales',
				'slug'     => 'event-sales',
				'template' => 'page-templates/event-sales.php',
			),
			array(
				'title'    => 'Event Thank You',
				'slug'     => 'event-thank-you',
				'template' => 'page-templates/event-thank-you.php',
			),
			array(
				'title'    => 'Event Broadcast',
				'slug'     => 'event-broadcast',
				'template' => 'page-templates/event-broadcast.php',
			),
		);
	}

	/**
	 * @param array{title: string, slug: string, template: string} $page Page definition.
	 */
	private static function ensure_page( array $page ): void {
		$existing = get_page_by_path( $page['slug'] );

		if ( $existing instanceof \WP_Post ) {
			update_post_meta( $existing->ID, '_wp_page_template', $page['template'] );
			return;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'  => $page['title'],
				'post_name'   => $page['slug'],
				'post_status' => 'publish',
				'post_type'   => 'page',
				'post_content'=> '',
			),
			true
		);

		if ( is_wp_error( $page_id ) || ! $page_id ) {
			return;
		}

		update_post_meta( (int) $page_id, '_wp_page_template', $page['template'] );
	}
}

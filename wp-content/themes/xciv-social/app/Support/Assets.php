<?php
/**
 * Enqueue CSS / Vanilla JS.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class Assets {

	public static function init(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue' ) );
	}

	public static function enqueue(): void {
		wp_enqueue_style(
			'xciv-social',
			XCIV_THEME_URI . '/assets/css/main.css',
			array(),
			XCIV_THEME_VERSION
		);

		wp_enqueue_script(
			'xciv-graphql-client',
			XCIV_THEME_URI . '/assets/js/graphql-client.js',
			array(),
			XCIV_THEME_VERSION,
			true
		);

		wp_enqueue_script(
			'xciv-main',
			XCIV_THEME_URI . '/assets/js/main.js',
			array( 'xciv-graphql-client' ),
			XCIV_THEME_VERSION,
			true
		);

		$current_user = wp_get_current_user();
		$display_name = ( $current_user instanceof \WP_User && $current_user->exists() )
			? ( $current_user->display_name ?: $current_user->user_login )
			: '';

		wp_localize_script(
			'xciv-graphql-client',
			'xcivSocial',
			array(
				'graphqlUrl'  => home_url( '/graphql' ),
				'homeUrl'     => home_url( '/' ),
				'restNonce'   => wp_create_nonce( 'wp_rest' ),
				'isLoggedIn'  => is_user_logged_in(),
				'userId'      => get_current_user_id(),
				'displayName' => $display_name,
			)
		);

		self::enqueue_template_script(
			'page-templates/admission.php',
			'xciv-admission',
			'admission.js'
		);

		self::enqueue_template_script(
			'page-templates/member-feed.php',
			'xciv-feed',
			'feed.js'
		);

		self::enqueue_template_script(
			'page-templates/dashboard.php',
			'xciv-dashboard',
			'dashboard.js'
		);

		self::enqueue_template_script(
			array(
				'page-templates/event-calendar.php',
				'page-templates/event-listings.php',
			),
			'xciv-events',
			'events.js'
		);

		if ( wp_script_is( 'xciv-events', 'enqueued' ) ) {
			$next        = EventsCatalog::next_occurrence();
			$current     = wp_get_current_user();
			$full_name   = '';
			$user_email  = '';
			if ( $current instanceof \WP_User && $current->exists() ) {
				$full_name = trim( $current->first_name . ' ' . $current->last_name );
				if ( '' === $full_name ) {
					$full_name = (string) $current->display_name;
				}
				$user_email = (string) $current->user_email;
			}

			wp_localize_script(
				'xciv-events',
				'xcivEvents',
				array(
					'calendar'    => EventsCatalog::calendar_events( 16 ),
					'initialDate' => $next ? (string) $next['start'] : '',
					'waitlistUrl' => esc_url_raw( rest_url( 'xciv/v1/waitlist' ) ),
					'restNonce'   => wp_create_nonce( 'wp_rest' ),
					'fullName'    => $full_name,
					'email'       => $user_email,
				)
			);
		}

		self::enqueue_template_script(
			'page-templates/profile.php',
			'xciv-profile',
			'profile.js'
		);

		self::enqueue_template_script(
			array(
				'page-templates/account-settings.php',
				'page-templates/profile-settings.php',
			),
			'xciv-settings',
			'settings.js'
		);

		self::enqueue_template_script(
			'page-templates/messages.php',
			'xciv-messages',
			'messages.js'
		);

		self::enqueue_template_script(
			'page-templates/profile-directory.php',
			'xciv-directory',
			'directory.js'
		);

		self::enqueue_template_script(
			array(
				'page-templates/event-sales.php',
				'page-templates/event-thank-you.php',
				'page-templates/event-broadcast.php',
			),
			'xciv-event-funnel',
			'event-funnel.js'
		);
	}

	/**
	 * Enqueue a feature script when one or more page templates are active.
	 *
	 * @param string|string[] $templates Relative page template path(s).
	 * @param string          $handle    Script handle.
	 * @param string          $file      Filename under assets/js/.
	 */
	private static function enqueue_template_script( $templates, string $handle, string $file ): void {
		$templates = (array) $templates;
		$match     = false;

		foreach ( $templates as $template ) {
			if ( is_page_template( $template ) ) {
				$match = true;
				break;
			}
		}

		if ( ! $match ) {
			return;
		}

		wp_enqueue_script(
			$handle,
			XCIV_THEME_URI . '/assets/js/' . ltrim( $file, '/' ),
			array( 'xciv-graphql-client' ),
			XCIV_THEME_VERSION,
			true
		);
	}
}

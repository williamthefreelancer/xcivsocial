<?php
/**
 * Online event funnel data (sales → thank-you → broadcast).
 * Reads XCIV Social Core settings when available; falls back to theme defaults.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class OnlineEventFunnel {

	/**
	 * Example online event used across funnel pages.
	 *
	 * @return array<string, mixed>
	 */
	public static function event(): array {
		$settings = self::core_settings();
		$general  = is_array( $settings['general'] ?? null ) ? $settings['general'] : array();
		$event    = is_array( $settings['event'] ?? null ) ? $settings['event'] : array();

		$meet = self::meet_url_from( is_string( $event['meet_url'] ?? null ) ? (string) $event['meet_url'] : '' );

		$host       = (string) ( $general['host_company'] ?? __( 'THE SUPER NINETY FOUR EVENTS COMPANY', 'xciv-social' ) );
		$host_short = (string) ( $general['host_short'] ?? __( 'Super Ninety Four Events', 'xciv-social' ) );

		return array(
			'id'             => (string) ( $event['id'] ?? 'township-backways-route' ),
			'slug'           => (string) ( $event['slug'] ?? 'township-backways-route' ),
			'title'          => (string) ( $event['title'] ?? __( 'The Township Backways Route', 'xciv-social' ) ),
			'subtitle'       => (string) ( $event['subtitle'] ?? __( 'Private intimate gathering — meet William A. Johnson in Massachusetts or North Carolina. Saturday and Tuesday evenings.', 'xciv-social' ) ),
			'host'           => $host,
			'host_short'     => $host_short,
			'date_label'     => (string) ( $event['date_label'] ?? __( 'Saturdays & Tuesdays', 'xciv-social' ) ),
			'time_label'     => (string) ( $event['time_label'] ?? __( 'Evening', 'xciv-social' ) ),
			'format'         => (string) ( $event['format'] ?? __( 'In person · MA or NC', 'xciv-social' ) ),
			'meet_url'       => $meet,
			'capacity'       => (int) ( $event['capacity'] ?? 40 ),
			'seats_left'     => (int) ( $event['seats_left'] ?? 18 ),
			'cover'          => '',
			'sales_path'     => (string) ( $event['sales_path'] ?? '/event-sales/' ),
			'thanks_path'    => (string) ( $event['thanks_path'] ?? '/event-thank-you/' ),
			'broadcast_path' => (string) ( $event['broadcast_path'] ?? '/event-broadcast/' ),
		);
	}

	/**
	 * Ticket tiers for the sales page.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function tickets(): array {
		$settings = self::core_settings();
		$rows     = $settings['tickets'] ?? null;
		if ( is_array( $rows ) && $rows !== array() ) {
			return self::normalize_priced_rows( $rows, true );
		}

		return array(
			array(
				'id'      => 'meet-william-north-carolina',
				'name'    => __( 'Meet William A. Johnson — North Carolina', 'xciv-social' ),
				'price'   => 97,
				'desc'    => __( 'The Township Backways Route · meet William A. Johnson in North Carolina. Saturday and Tuesday evenings along Harrisburg / Harris Houston through Cary.', 'xciv-social' ),
				'popular' => true,
			),
			array(
				'id'      => 'meet-william-massachusetts',
				'name'    => __( 'Meet William A. Johnson — Massachusetts', 'xciv-social' ),
				'price'   => 97,
				'desc'    => __( 'The Township Backways Route · meet William A. Johnson in Massachusetts. Same Saturday and Tuesday cadence — choose the MA meetup window.', 'xciv-social' ),
				'popular' => false,
			),
		);
	}

	/**
	 * Optional add-ons.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function addons(): array {
		$settings = self::core_settings();
		$rows     = $settings['addons'] ?? null;
		if ( is_array( $rows ) && $rows !== array() ) {
			return self::normalize_priced_rows( $rows, false );
		}

		return array(
			array(
				'id'    => 'replay',
				'name'  => __( '48-hour replay pack', 'xciv-social' ),
				'price' => 15,
				'desc'  => __( 'Downloadable recording + slide deck after the broadcast.', 'xciv-social' ),
			),
			array(
				'id'    => 'intro-kit',
				'name'  => __( 'Warm intro kit', 'xciv-social' ),
				'price' => 25,
				'desc'  => __( 'Printed name card PDF, talking points, and host tip sheet.', 'xciv-social' ),
			),
			array(
				'id'    => 'follow-up',
				'name'  => __( 'Post-event follow-up list', 'xciv-social' ),
				'price' => 35,
				'desc'  => __( 'Curated attendee list (opt-in) for one week of warm outreach.', 'xciv-social' ),
			),
		);
	}

	/**
	 * Upsell offers shown on sales + thank-you.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function upsells(): array {
		$settings = self::core_settings();
		$rows     = $settings['upsells'] ?? null;
		if ( is_array( $rows ) && $rows !== array() ) {
			$out = array();
			foreach ( $rows as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$out[] = array(
					'id'    => (string) ( $row['id'] ?? '' ),
					'name'  => (string) ( $row['name'] ?? '' ),
					'price' => (float) ( $row['price'] ?? 0 ),
					'desc'  => (string) ( $row['desc'] ?? '' ),
					'cta'   => (string) ( $row['cta'] ?? __( 'Add', 'xciv-social' ) ),
				);
			}
			return $out;
		}

		return array(
			array(
				'id'    => 'membership',
				'name'  => __( 'XCIV member month', 'xciv-social' ),
				'price' => 49,
				'desc'  => __( 'Unlock the member feed, directory, and next three online rooms.', 'xciv-social' ),
				'cta'   => __( 'Add membership', 'xciv-social' ),
			),
		);
	}

	/**
	 * Member dashboard briefing fields.
	 *
	 * @return array{url: string, title: string, desc: string}
	 */
	public static function briefing(): array {
		$settings = self::core_settings();
		$dash     = is_array( $settings['dashboard'] ?? null ) ? $settings['dashboard'] : array();

		return array(
			'url'   => (string) ( $dash['briefing_url'] ?? '' ),
			'title' => (string) ( $dash['briefing_title'] ?? __( 'How warm intros compound inside a closed room', 'xciv-social' ) ),
			'desc'  => (string) ( $dash['briefing_desc'] ?? __( 'A short member briefing on cadence, reciprocity, and what to bring to the next gathering.', 'xciv-social' ) ),
		);
	}

	/**
	 * Seed questions for the broadcast Q&A panel.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function sample_questions(): array {
		return array(
			array(
				'id'     => 'q1',
				'author' => 'Maya R.',
				'text'   => __( 'How do you structure a warm intro without making it feel transactional?', 'xciv-social' ),
				'votes'  => 12,
			),
			array(
				'id'     => 'q2',
				'author' => 'Jordan K.',
				'text'   => __( 'What should first-time hosts bring to a virtual salon?', 'xciv-social' ),
				'votes'  => 8,
			),
		);
	}

	/**
	 * Seed poll for the broadcast room.
	 *
	 * @return array<string, mixed>
	 */
	public static function sample_poll(): array {
		return array(
			'id'       => 'poll-energy',
			'question' => __( 'What do you want more of in tonight’s room?', 'xciv-social' ),
			'options'  => array(
				array( 'id' => 'intros', 'label' => __( 'Faster warm intros', 'xciv-social' ), 'votes' => 18 ),
				array( 'id' => 'breaks', 'label' => __( 'Smaller breakout rooms', 'xciv-social' ), 'votes' => 14 ),
				array( 'id' => 'qa', 'label' => __( 'Longer open Q&A', 'xciv-social' ), 'votes' => 9 ),
				array( 'id' => 'follow', 'label' => __( 'Post-event follow-ups', 'xciv-social' ), 'votes' => 11 ),
			),
		);
	}

	/**
	 * Seed live feed messages.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function sample_feed(): array {
		return array(
			array(
				'author' => 'Alex',
				'text'   => __( 'Joined from Charlotte — ready for the salon.', 'xciv-social' ),
				'time'   => '7:58 PM',
			),
			array(
				'author' => 'Host',
				'text'   => __( 'Welcome in. Drop one line about who you want to meet tonight.', 'xciv-social' ),
				'time'   => '8:01 PM',
				'host'   => true,
			),
			array(
				'author' => 'Sam',
				'text'   => __( 'Looking for hospitality operators experimenting with private dinners.', 'xciv-social' ),
				'time'   => '8:03 PM',
			),
		);
	}

	/**
	 * Resolve Meet URL: ?meet=… query, then settings / theme mod, then demo placeholder.
	 */
	public static function meet_url(): string {
		$event = self::event();
		return (string) $event['meet_url'];
	}

	public static function is_allowed_meet_url( string $url ): bool {
		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( ! is_string( $host ) || '' === $host ) {
			return false;
		}

		$host = strtolower( $host );
		$ok   = array( 'meet.google.com', 'www.meet.google.com' );

		return in_array( $host, $ok, true );
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function core_settings(): array {
		if ( class_exists( '\\XCIV\\Core\\Admin\\SettingsStore' ) ) {
			return \XCIV\Core\Admin\SettingsStore::all();
		}

		$stored = get_option( 'xciv_social_settings', array() );
		return is_array( $stored ) ? $stored : array();
	}

	private static function meet_url_from( string $stored_setting ): string {
		if ( isset( $_GET['meet'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$raw = wp_unslash( (string) $_GET['meet'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$url = esc_url_raw( $raw );
			if ( $url && self::is_allowed_meet_url( $url ) ) {
				return $url;
			}
		}

		if ( $stored_setting && self::is_allowed_meet_url( $stored_setting ) ) {
			return $stored_setting;
		}

		$theme_mod = (string) get_theme_mod( 'xciv_online_event_meet_url', '' );
		if ( $theme_mod && self::is_allowed_meet_url( $theme_mod ) ) {
			return $theme_mod;
		}

		return 'https://meet.google.com/lookup/xciv-salon-demo';
	}

	/**
	 * @param array<int|string, mixed> $rows Raw rows.
	 * @return list<array<string, mixed>>
	 */
	private static function normalize_priced_rows( array $rows, bool $with_popular ): array {
		$out = array();
		foreach ( $rows as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$item = array(
				'id'    => (string) ( $row['id'] ?? '' ),
				'name'  => (string) ( $row['name'] ?? '' ),
				'price' => (float) ( $row['price'] ?? 0 ),
				'desc'  => (string) ( $row['desc'] ?? '' ),
			);
			if ( $with_popular ) {
				$item['popular'] = ! empty( $row['popular'] );
			}
			$out[] = $item;
		}
		return $out;
	}
}

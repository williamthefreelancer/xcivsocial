<?php
/**
 * Demo data for the online event funnel (sales → thank-you → broadcast).
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
		$meet = self::meet_url();

		return array(
			'id'           => 'virtual-salon-apr',
			'slug'         => 'virtual-salon',
			'title'        => __( 'Virtual Salon: Warm Intros After Dark', 'xciv-social' ),
			'subtitle'     => __( 'A live online room for members and invited guests — broadcast, polls, and Q&A in one place.', 'xciv-social' ),
			'host'         => __( 'THE SUPER NINETY FOUR EVENTS COMPANY', 'xciv-social' ),
			'host_short'   => __( 'Super Ninety Four Events', 'xciv-social' ),
			'date_label'   => __( 'Thursday, April 16, 2026', 'xciv-social' ),
			'time_label'   => __( '8:00–9:30 PM ET', 'xciv-social' ),
			'format'       => __( 'Online · Google Meet', 'xciv-social' ),
			'meet_url'     => $meet,
			'capacity'     => 120,
			'seats_left'   => 34,
			'cover'        => '',
			'sales_path'   => '/event-sales/',
			'thanks_path'  => '/event-thank-you/',
			'broadcast_path' => '/event-broadcast/',
		);
	}

	/**
	 * Ticket tiers for the sales page.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function tickets(): array {
		return array(
			array(
				'id'          => 'general',
				'name'        => __( 'General Admission', 'xciv-social' ),
				'price'       => 45,
				'desc'        => __( 'Live access to the salon, chat feed, and post-event replay link.', 'xciv-social' ),
				'popular'     => false,
			),
			array(
				'id'          => 'vip',
				'name'        => __( 'VIP Circle', 'xciv-social' ),
				'price'       => 95,
				'desc'        => __( 'Priority seating in Meet breakouts, name shout-out, and VIP Q&A lane.', 'xciv-social' ),
				'popular'     => true,
			),
			array(
				'id'          => 'host-pass',
				'name'        => __( 'Host Pass', 'xciv-social' ),
				'price'       => 180,
				'desc'        => __( 'Bring a +1, co-host a 5-minute intro, and unlock the private after-room.', 'xciv-social' ),
				'popular'     => false,
			),
		);
	}

	/**
	 * Optional add-ons.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function addons(): array {
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
		return array(
			array(
				'id'    => 'membership',
				'name'  => __( 'XCIV member month', 'xciv-social' ),
				'price' => 49,
				'desc'  => __( 'Unlock the member feed, directory, and next three online rooms.', 'xciv-social' ),
				'cta'   => __( 'Add membership', 'xciv-social' ),
			),
			array(
				'id'    => 'next-trip',
				'name'  => __( 'Harrisburg to Lynn pre-sale hold', 'xciv-social' ),
				'price' => 0,
				'desc'  => __( 'Free hold on the next paid road trip — convert when tickets drop.', 'xciv-social' ),
				'cta'   => __( 'Hold my seat', 'xciv-social' ),
			),
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
	 * Resolve Meet URL: ?meet=… query, then theme mod, then demo placeholder.
	 */
	public static function meet_url(): string {
		if ( isset( $_GET['meet'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$raw = wp_unslash( (string) $_GET['meet'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$url = esc_url_raw( $raw );
			if ( $url && self::is_allowed_meet_url( $url ) ) {
				return $url;
			}
		}

		$stored = (string) get_theme_mod( 'xciv_online_event_meet_url', '' );
		if ( $stored && self::is_allowed_meet_url( $stored ) ) {
			return $stored;
		}

		return 'https://meet.google.com/lookup/xciv-salon-demo';
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
}

<?php
/**
 * Theme / funnel settings stored as a single option.
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

namespace XCIV\Core\Admin;

final class SettingsStore {

	public const OPTION_KEY = 'xciv_social_settings';

	/**
	 * @return array<string, mixed>
	 */
	public static function defaults(): array {
		return array(
			'general'   => array(
				'community_name'    => 'XCIV Social',
				'host_company'      => 'THE SUPER NINETY FOUR EVENTS COMPANY',
				'host_short'        => 'Super Ninety Four Events',
				'support_email'     => 'support@xcivsocial.com',
				'currency_symbol'   => '$',
			),
			'event'     => array(
				'id'           => 'virtual-salon-apr',
				'slug'         => 'virtual-salon',
				'title'        => 'Virtual Salon: Warm Intros After Dark',
				'subtitle'     => 'A live online room for members and invited guests — broadcast, polls, and Q&A in one place.',
				'date_label'   => 'Thursday, April 16, 2026',
				'time_label'   => '8:00–9:30 PM ET',
				'format'       => 'Online · Google Meet',
				'meet_url'     => 'https://meet.google.com/lookup/xciv-salon-demo',
				'capacity'     => 120,
				'seats_left'   => 34,
				'sales_path'   => '/event-sales/',
				'thanks_path'  => '/event-thank-you/',
				'broadcast_path' => '/event-broadcast/',
			),
			'tickets'   => array(
				array(
					'id'      => 'township-backways-route',
					'name'    => 'The Township Backways Route',
					'price'   => 97,
					'desc'    => 'Private intimate party gathering — Harrisburg, NC / Harris Houston through Cary, NC. Saturday nights.',
					'popular' => false,
				),
				array(
					'id'      => 'harrisburg-to-lynn',
					'name'    => 'Harrisburg to Lynn',
					'price'   => 397,
					'desc'    => 'Main offer — paid roundtrip from Charlotte, NC to Lynn, MA. Four days, Sunday through Wednesday.',
					'popular' => true,
				),
			),
			'addons'    => array(
				array(
					'id'    => 'replay',
					'name'  => '48-hour replay pack',
					'price' => 15,
					'desc'  => 'Downloadable recording + slide deck after the broadcast.',
				),
				array(
					'id'    => 'intro-kit',
					'name'  => 'Warm intro kit',
					'price' => 25,
					'desc'  => 'Printed name card PDF, talking points, and host tip sheet.',
				),
				array(
					'id'    => 'follow-up',
					'name'  => 'Post-event follow-up list',
					'price' => 35,
					'desc'  => 'Curated attendee list (opt-in) for one week of warm outreach.',
				),
			),
			'upsells'   => array(
				array(
					'id'    => 'membership',
					'name'  => 'XCIV member month',
					'price' => 49,
					'desc'  => 'Unlock the member feed, directory, and next three online rooms.',
					'cta'   => 'Add membership',
				),
				array(
					'id'    => 'next-trip',
					'name'  => 'Harrisburg to Lynn',
					'price' => 397,
					'desc'  => 'Main offer — hold your seat on the Charlotte to Lynn, MA road trip.',
					'cta'   => 'Add Lynn trip',
				),
			),
			'dashboard' => array(
				'briefing_url'   => '',
				'briefing_title' => 'How warm intros compound inside a closed room',
				'briefing_desc'  => 'A short member briefing on cadence, reciprocity, and what to bring to the next gathering.',
			),
			'payments'  => array(
				'mode'                 => 'demo',
				'stripe_publishable'   => '',
				'stripe_secret'        => '',
				'checkout_success_note'=> 'Demo checkout — wire Stripe keys when ready to take live payments.',
			),
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	public static function all(): array {
		$stored = get_option( self::OPTION_KEY, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}

		return self::merge_defaults( $stored );
	}

	/**
	 * @param string $section Section key.
	 * @return array<string, mixed>|list<array<string, mixed>>
	 */
	public static function get( string $section ) {
		$all = self::all();
		return $all[ $section ] ?? array();
	}

	/**
	 * @param array<string, mixed> $input Raw POST data under xciv_settings.
	 * @return array<string, mixed>
	 */
	public static function sanitize( array $input ): array {
		$defaults   = self::defaults();
		$out        = self::all();
		$active_tab = isset( $input['_active_tab'] ) ? sanitize_key( (string) $input['_active_tab'] ) : '';

		if ( isset( $input['general'] ) && is_array( $input['general'] ) ) {
			$g = $input['general'];
			$out['general'] = array(
				'community_name'  => sanitize_text_field( (string) ( $g['community_name'] ?? $defaults['general']['community_name'] ) ),
				'host_company'    => sanitize_text_field( (string) ( $g['host_company'] ?? $defaults['general']['host_company'] ) ),
				'host_short'      => sanitize_text_field( (string) ( $g['host_short'] ?? $defaults['general']['host_short'] ) ),
				'support_email'   => sanitize_email( (string) ( $g['support_email'] ?? $defaults['general']['support_email'] ) ),
				'currency_symbol' => sanitize_text_field( (string) ( $g['currency_symbol'] ?? '$' ) ),
			);
		}

		if ( isset( $input['event'] ) && is_array( $input['event'] ) ) {
			$e = $input['event'];
			$out['event'] = array(
				'id'             => sanitize_key( (string) ( $e['id'] ?? 'virtual-salon' ) ),
				'slug'           => sanitize_title( (string) ( $e['slug'] ?? 'virtual-salon' ) ),
				'title'          => sanitize_text_field( (string) ( $e['title'] ?? '' ) ),
				'subtitle'       => sanitize_textarea_field( (string) ( $e['subtitle'] ?? '' ) ),
				'date_label'     => sanitize_text_field( (string) ( $e['date_label'] ?? '' ) ),
				'time_label'     => sanitize_text_field( (string) ( $e['time_label'] ?? '' ) ),
				'format'         => sanitize_text_field( (string) ( $e['format'] ?? '' ) ),
				'meet_url'       => esc_url_raw( (string) ( $e['meet_url'] ?? '' ) ),
				'capacity'       => max( 0, absint( $e['capacity'] ?? 0 ) ),
				'seats_left'     => max( 0, absint( $e['seats_left'] ?? 0 ) ),
				'sales_path'     => self::sanitize_path( (string) ( $e['sales_path'] ?? '/event-sales/' ) ),
				'thanks_path'    => self::sanitize_path( (string) ( $e['thanks_path'] ?? '/event-thank-you/' ) ),
				'broadcast_path' => self::sanitize_path( (string) ( $e['broadcast_path'] ?? '/event-broadcast/' ) ),
			);
		}

		if ( isset( $input['tickets'] ) && is_array( $input['tickets'] ) ) {
			$out['tickets'] = self::sanitize_priced_rows( $input['tickets'], true );
		} elseif ( 'tickets' === $active_tab ) {
			$out['tickets'] = array();
		}

		if ( isset( $input['addons'] ) && is_array( $input['addons'] ) ) {
			$out['addons'] = self::sanitize_priced_rows( $input['addons'], false );
		} elseif ( 'addons' === $active_tab ) {
			$out['addons'] = array();
		}

		if ( isset( $input['upsells'] ) && is_array( $input['upsells'] ) ) {
			$out['upsells'] = self::sanitize_upsells( $input['upsells'] );
		} elseif ( 'upsells' === $active_tab ) {
			$out['upsells'] = array();
		}

		if ( isset( $input['dashboard'] ) && is_array( $input['dashboard'] ) ) {
			$d = $input['dashboard'];
			$out['dashboard'] = array(
				'briefing_url'   => esc_url_raw( (string) ( $d['briefing_url'] ?? '' ) ),
				'briefing_title' => sanitize_text_field( (string) ( $d['briefing_title'] ?? '' ) ),
				'briefing_desc'  => sanitize_textarea_field( (string) ( $d['briefing_desc'] ?? '' ) ),
			);
		}

		if ( isset( $input['payments'] ) && is_array( $input['payments'] ) ) {
			$p    = $input['payments'];
			$mode = sanitize_key( (string) ( $p['mode'] ?? 'demo' ) );
			if ( ! in_array( $mode, array( 'demo', 'stripe' ), true ) ) {
				$mode = 'demo';
			}
			$out['payments'] = array(
				'mode'                  => $mode,
				'stripe_publishable'    => sanitize_text_field( (string) ( $p['stripe_publishable'] ?? '' ) ),
				'stripe_secret'         => sanitize_text_field( (string) ( $p['stripe_secret'] ?? '' ) ),
				'checkout_success_note' => sanitize_textarea_field( (string) ( $p['checkout_success_note'] ?? '' ) ),
			);
		}

		return $out;
	}

	/**
	 * @param array<string, mixed> $stored Stored option.
	 * @return array<string, mixed>
	 */
	private static function merge_defaults( array $stored ): array {
		$defaults = self::defaults();
		$merged   = $defaults;

		foreach ( array( 'general', 'event', 'dashboard', 'payments' ) as $key ) {
			if ( isset( $stored[ $key ] ) && is_array( $stored[ $key ] ) ) {
				$merged[ $key ] = array_merge( $defaults[ $key ], $stored[ $key ] );
			}
		}

		foreach ( array( 'tickets', 'addons', 'upsells' ) as $key ) {
			if ( isset( $stored[ $key ] ) && is_array( $stored[ $key ] ) && $stored[ $key ] !== array() ) {
				$merged[ $key ] = array_values( $stored[ $key ] );
			}
		}

		return $merged;
	}

	/**
	 * @param array<int|string, mixed> $rows Raw rows.
	 * @return list<array<string, mixed>>
	 */
	private static function sanitize_priced_rows( array $rows, bool $with_popular ): array {
		$clean = array();
		foreach ( $rows as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$name = sanitize_text_field( (string) ( $row['name'] ?? '' ) );
			if ( '' === $name ) {
				continue;
			}
			$id = sanitize_key( (string) ( $row['id'] ?? '' ) );
			if ( '' === $id ) {
				$id = sanitize_title( $name );
			}
			$item = array(
				'id'    => $id,
				'name'  => $name,
				'price' => max( 0, (float) ( $row['price'] ?? 0 ) ),
				'desc'  => sanitize_textarea_field( (string) ( $row['desc'] ?? '' ) ),
			);
			if ( $with_popular ) {
				$item['popular'] = ! empty( $row['popular'] );
			}
			$clean[] = $item;
		}

		return $clean;
	}

	/**
	 * @param array<int|string, mixed> $rows Raw upsell rows.
	 * @return list<array<string, mixed>>
	 */
	private static function sanitize_upsells( array $rows ): array {
		$clean = array();
		foreach ( $rows as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$name = sanitize_text_field( (string) ( $row['name'] ?? '' ) );
			if ( '' === $name ) {
				continue;
			}
			$id = sanitize_key( (string) ( $row['id'] ?? '' ) );
			if ( '' === $id ) {
				$id = sanitize_title( $name );
			}
			$clean[] = array(
				'id'    => $id,
				'name'  => $name,
				'price' => max( 0, (float) ( $row['price'] ?? 0 ) ),
				'desc'  => sanitize_textarea_field( (string) ( $row['desc'] ?? '' ) ),
				'cta'   => sanitize_text_field( (string) ( $row['cta'] ?? __( 'Add', 'xciv-social-core' ) ) ),
			);
		}

		return $clean;
	}

	private static function sanitize_path( string $path ): string {
		$path = trim( $path );
		if ( '' === $path ) {
			return '/';
		}
		if ( '/' !== $path[0] ) {
			$path = '/' . $path;
		}
		return untrailingslashit( $path ) . '/';
	}
}

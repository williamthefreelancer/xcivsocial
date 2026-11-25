<?php
/**
 * Production event catalog (series + calendar marks).
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class EventsCatalog {

	/**
	 * All production event series.
	 *
	 * @return list<array<string, mixed>>
	 */
	public static function all_series(): array {
		return array(
			array(
				'id'              => 'township-backways-route',
				'title'           => __( 'The Township Backways Route', 'xciv-social' ),
				'description'     => __( 'A private intimate party along the Township Backways Route — Harrisburg, NC / Harris Houston area through to Cary, NC. Saturday and Tuesday evenings. Option to meet William A. Johnson in Massachusetts or North Carolina.', 'xciv-social' ),
				'city'            => 'Harrisburg',
				'destination'     => 'Cary',
				'route'           => __( 'Meet William A. Johnson · MA or NC', 'xciv-social' ),
				'vertical'        => 'nightlife',
				'paid'            => true,
				'price'           => 97,
				'duration_days'   => 1,
				'interval_months' => 1,
				'weekday'         => 6, // Saturday (legacy single-day fallback)
				'weekdays'        => array( 2, 6 ), // Tuesday, Saturday
				'day_span'        => __( 'Sat & Tue', 'xciv-social' ),
				'recurrence'      => 'weekly_weekdays',
				'anchor'          => '2026-11-28',
				'host'            => __( 'THE SUPER NINETY FOUR EVENTS COMPANY', 'xciv-social' ),
				'host_short'      => __( 'Super Ninety Four Events', 'xciv-social' ),
				'time_label'      => __( 'Evening', 'xciv-social' ),
				'mark_label'      => __( 'Backways', 'xciv-social' ),
				'presale_waitlist' => true,
			),
		);
	}

	/**
	 * First series definition (legacy helper).
	 *
	 * @return array<string, mixed>
	 */
	public static function series(): array {
		$all = self::all_series();
		return $all[0] ?? array();
	}

	/**
	 * Upcoming occurrences across all series, soonest first.
	 *
	 * @param int $limit Max occurrences to return.
	 * @return list<array<string, mixed>>
	 */
	public static function occurrences( int $limit = 12 ): array {
		$today = new \DateTimeImmutable( 'today' );
		$pool  = array();

		foreach ( self::all_series() as $series ) {
			$pool = array_merge( $pool, self::occurrences_for_series( $series, $today, max( $limit * 2, 12 ) ) );
		}

		usort(
			$pool,
			static function ( array $a, array $b ): int {
				return strcmp( (string) $a['start'], (string) $b['start'] );
			}
		);

		return array_slice( $pool, 0, $limit );
	}

	/**
	 * Next upcoming occurrence, or null.
	 *
	 * @return array<string, mixed>|null
	 */
	public static function next_occurrence(): ?array {
		$items = self::occurrences( 1 );
		return $items[0] ?? null;
	}

	/**
	 * Calendar day → event payload map for JS.
	 *
	 * @param int $limit Occurrence count to expand into day marks.
	 * @return array<string, list<array<string, mixed>>>
	 */
	public static function calendar_events( int $limit = 12 ): array {
		$map = array();

		foreach ( self::occurrences( $limit ) as $trip ) {
			$start = \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $trip['start'] );
			$end   = \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $trip['end'] );
			if ( ! $start || ! $end ) {
				continue;
			}

			$paid     = ! empty( $trip['paid'] );
			$waitlist = ! empty( $trip['presale_waitlist'] );
			$price    = (float) ( $trip['price'] ?? 0 );
			$host     = $paid
				? sprintf(
					/* translators: 1: host name, 2: price label, 3: route label */
					__( '%1$s · %2$s · %3$s', 'xciv-social' ),
					(string) $trip['host_short'],
					$price > 0 ? '$' . number_format( $price, 0 ) : __( 'Paid', 'xciv-social' ),
					(string) $trip['route']
				)
				: sprintf(
					/* translators: 1: host name, 2: route label */
					__( '%1$s · Private · %2$s', 'xciv-social' ),
					(string) $trip['host_short'],
					(string) $trip['route']
				);

			for ( $day = $start; $day <= $end; $day = $day->modify( '+1 day' ) ) {
				$key           = $day->format( 'Y-m-d' );
				$map[ $key ]  = $map[ $key ] ?? array();
				$map[ $key ][] = array(
					'time'            => (string) $trip['time_label'],
					'city'            => (string) $trip['city'],
					'title'           => (string) $trip['title'],
					'host'            => $host,
					'going'           => false,
					'paid'            => $paid,
					'price'           => $price,
					'presaleWaitlist' => $waitlist,
					'seriesId'        => (string) $trip['series_id'],
					'occurrenceId'    => (string) $trip['id'],
					'mark'            => (string) $trip['mark_label'],
				);
			}
		}

		return $map;
	}

	/**
	 * Build a dashboard mini-cal for the month containing the next event start.
	 *
	 * @return array{label: string, year: int, month: int, days: list<array<string, mixed>>}
	 */
	public static function dashboard_calendar(): array {
		$next  = self::next_occurrence();
		$focus = $next
			? \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $next['start'] )
			: new \DateTimeImmutable( 'first day of this month' );

		if ( ! $focus ) {
			$focus = new \DateTimeImmutable( 'first day of this month' );
		}

		$year          = (int) $focus->format( 'Y' );
		$month         = (int) $focus->format( 'n' );
		$first         = new \DateTimeImmutable( sprintf( '%04d-%02d-01', $year, $month ) );
		$start_dow     = (int) $first->format( 'w' );
		$days_in_month = (int) $first->format( 't' );
		$grid_start    = $first->modify( '-' . $start_dow . ' days' );
		$today_key     = ( new \DateTimeImmutable( 'today' ) )->format( 'Y-m-d' );
		$marks         = self::calendar_events( 16 );
		$total         = (int) ( ceil( ( $start_dow + $days_in_month ) / 7 ) * 7 );
		$cells         = array();

		for ( $i = 0; $i < $total; $i++ ) {
			$date    = $grid_start->modify( '+' . $i . ' days' );
			$key     = $date->format( 'Y-m-d' );
			$outside = ( (int) $date->format( 'n' ) ) !== $month;
			$label   = ! empty( $marks[ $key ][0]['mark'] ) ? (string) $marks[ $key ][0]['mark'] : '';

			$cells[] = array(
				'day'     => (int) $date->format( 'j' ),
				'outside' => $outside,
				'today'   => $key === $today_key,
				'marks'   => $label ? array( $label ) : array(),
			);
		}

		return array(
			'label' => $focus->format( 'F Y' ),
			'year'  => $year,
			'month' => $month,
			'days'  => $cells,
		);
	}

	/**
	 * @param array<string, mixed> $series Series definition.
	 * @return list<array<string, mixed>>
	 */
	private static function occurrences_for_series( array $series, \DateTimeImmutable $today, int $limit ): array {
		$anchor = \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $series['anchor'] );
		if ( ! $anchor ) {
			return array();
		}

		$weekdays = self::series_weekdays( $series );
		$cursor   = self::snap_to_weekday( $anchor, $weekdays );
		$out      = array();
		$guard    = 0;

		while ( count( $out ) < $limit && $guard < 120 ) {
			++$guard;
			$end = $cursor->modify( '+' . ( (int) $series['duration_days'] - 1 ) . ' days' );

			if ( $end >= $today ) {
				$out[] = self::format_occurrence( $series, $cursor, $end, count( $out ) );
			}

			$cursor = self::advance_occurrence( $series, $cursor, $weekdays[0] );
		}

		return $out;
	}

	/**
	 * @param array<string, mixed> $series Series definition.
	 * @return array<string, mixed>
	 */
	private static function format_occurrence( array $series, \DateTimeImmutable $start, \DateTimeImmutable $end, int $index ): array {
		$paid     = ! empty( $series['paid'] );
		$waitlist = ! empty( $series['presale_waitlist'] );
		$price    = (float) ( $series['price'] ?? 0 );
		$same     = $start->format( 'Y-m-d' ) === $end->format( 'Y-m-d' );
		$range    = $same
			? $start->format( 'M j, Y' )
			: sprintf(
				/* translators: 1: start date, 2: end date */
				__( '%1$s – %2$s', 'xciv-social' ),
				$start->format( 'M j' ),
				$end->format( 'M j, Y' )
			);

		$status = $paid ? __( 'Paid', 'xciv-social' ) : __( 'Private', 'xciv-social' );
		if ( $waitlist ) {
			$status = __( 'Pre-sale', 'xciv-social' );
		}
		$price_label = $price > 0 ? '$' . number_format( $price, 0 ) : '';

		return array(
			'id'               => (string) $series['id'] . '-' . $start->format( 'Ymd' ),
			'series_id'        => (string) $series['id'],
			'title'            => (string) $series['title'],
			'description'      => (string) $series['description'],
			'city'             => (string) $series['city'],
			'destination'      => (string) $series['destination'],
			'route'            => (string) $series['route'],
			'vertical'         => (string) $series['vertical'],
			'paid'             => $paid,
			'price'            => $price,
			'price_label'      => $price_label,
			'presale_waitlist' => $waitlist,
			'host'             => (string) $series['host'],
			'host_short'       => (string) $series['host_short'],
			'time_label'       => (string) $series['time_label'],
			'mark_label'       => (string) $series['mark_label'],
			'start'            => $start->format( 'Y-m-d' ),
			'end'              => $end->format( 'Y-m-d' ),
			'month'            => $start->format( 'M' ),
			'day'              => $start->format( 'd' ),
			'weekday'          => $start->format( 'D' ),
			'range'            => $range,
			'meta'             => sprintf(
				/* translators: 1: day span, 2: date range, 3: route, 4: status, 5: price */
				__( '%1$s · %2$s · %3$s · %4$s%5$s', 'xciv-social' ),
				(string) $series['day_span'],
				$range,
				(string) $series['route'],
				$status,
				$price_label ? ' · ' . $price_label : ''
			),
			'scope'            => 'upcoming',
			'index'            => $index,
			'badge'            => $status,
			'cta'              => $waitlist ? 'waitlist' : ( $paid ? 'purchase' : 'rsvp' ),
		);
	}

	/**
	 * @param array<string, mixed> $series Series definition.
	 * @return list<int>
	 */
	private static function series_weekdays( array $series ): array {
		if ( ! empty( $series['weekdays'] ) && is_array( $series['weekdays'] ) ) {
			$days = array();
			foreach ( $series['weekdays'] as $day ) {
				$days[] = (int) $day;
			}
			$days = array_values( array_unique( $days ) );
			sort( $days );
			return $days !== array() ? $days : array( (int) ( $series['weekday'] ?? 0 ) );
		}

		return array( (int) ( $series['weekday'] ?? 0 ) );
	}

	/**
	 * @param list<int> $weekdays Allowed weekdays (0=Sun … 6=Sat).
	 */
	private static function snap_to_weekday( \DateTimeImmutable $from, array $weekdays ): \DateTimeImmutable {
		$dow = (int) $from->format( 'w' );
		if ( in_array( $dow, $weekdays, true ) ) {
			return $from;
		}

		return self::next_weekday_after( $from, $weekdays );
	}

	/**
	 * @param list<int> $weekdays Allowed weekdays (0=Sun … 6=Sat).
	 */
	private static function next_weekday_after( \DateTimeImmutable $from, array $weekdays ): \DateTimeImmutable {
		$cursor = $from;
		for ( $i = 1; $i <= 7; $i++ ) {
			$cursor = $from->modify( '+' . $i . ' days' );
			if ( in_array( (int) $cursor->format( 'w' ), $weekdays, true ) ) {
				return $cursor;
			}
		}

		return $from->modify( '+1 day' );
	}

	/**
	 * @param array<string, mixed> $series Series definition.
	 */
	private static function advance_occurrence( array $series, \DateTimeImmutable $from, int $weekday ): \DateTimeImmutable {
		$mode = (string) ( $series['recurrence'] ?? 'interval_snap' );

		if ( 'weekly_weekdays' === $mode ) {
			return self::next_weekday_after( $from, self::series_weekdays( $series ) );
		}

		if ( 'last_weekday_monthly' === $mode ) {
			$month = $from->modify( 'first day of next month' );
			return self::last_weekday_of_month( $month, $weekday );
		}

		$months = (int) ( $series['interval_months'] ?? 1 );
		$next   = $from->modify( '+' . $months . ' months' );
		$dow    = (int) $next->format( 'w' );
		$diff   = ( $dow - $weekday + 7 ) % 7;
		if ( 0 !== $diff ) {
			$next = $next->modify( '-' . $diff . ' days' );
		}
		if ( $next <= $from ) {
			$next = $next->modify( '+7 days' );
		}
		return $next;
	}

	private static function last_weekday_of_month( \DateTimeImmutable $month, int $weekday ): \DateTimeImmutable {
		$last = $month->modify( 'last day of this month' );
		$dow  = (int) $last->format( 'w' );
		$diff = ( $dow - $weekday + 7 ) % 7;
		return 0 === $diff ? $last : $last->modify( '-' . $diff . ' days' );
	}
}

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
				'id'              => 'harrisburg-to-lynn',
				'title'           => __( 'Harrisburg to Lynn', 'xciv-social' ),
				'description'     => __( 'Paid roundtrip from Charlotte, NC to Lynn, MA. Four days, Sunday through Wednesday. Recurs every four months.', 'xciv-social' ),
				'city'            => 'Charlotte',
				'destination'     => 'Lynn',
				'route'           => __( 'Charlotte, NC → Lynn, MA', 'xciv-social' ),
				'vertical'        => 'club_event',
				'paid'            => true,
				'duration_days'   => 4,
				'interval_months' => 4,
				'weekday'         => 0, // Sunday
				'day_span'        => __( 'Sun–Wed', 'xciv-social' ),
				'anchor'          => '2026-11-29',
				'host'            => __( 'THE SUPER NINETY FOUR EVENTS COMPANY', 'xciv-social' ),
				'host_short'      => __( 'Super Ninety Four Events', 'xciv-social' ),
				'time_label'      => __( 'All day', 'xciv-social' ),
				'mark_label'      => __( 'Harrisburg→Lynn', 'xciv-social' ),
				'presale_waitlist' => true,
			),
			array(
				'id'              => 'township-backways-route',
				'title'           => __( 'The Township Backways Route', 'xciv-social' ),
				'description'     => __( 'A private intimate party along the Township Backways Route — Harrisburg, NC / Harris Houston area through to Cary, NC. Saturday nights, once a month.', 'xciv-social' ),
				'city'            => 'Harrisburg',
				'destination'     => 'Cary',
				'route'           => __( 'Harrisburg, NC / Harris Houston → Cary, NC', 'xciv-social' ),
				'vertical'        => 'nightlife',
				'paid'            => false,
				'duration_days'   => 1,
				'interval_months' => 1,
				'weekday'         => 6, // Saturday
				'day_span'        => __( 'Sat', 'xciv-social' ),
				'recurrence'      => 'last_weekday_monthly',
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
			$host     = $paid
				? sprintf(
					/* translators: 1: host name, 2: route label */
					__( '%1$s · Paid · %2$s', 'xciv-social' ),
					(string) $trip['host_short'],
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

		$weekday = (int) ( $series['weekday'] ?? 0 );
		$cursor  = $anchor;
		$out     = array();
		$guard   = 0;

		while ( count( $out ) < $limit && $guard < 72 ) {
			++$guard;
			$end = $cursor->modify( '+' . ( (int) $series['duration_days'] - 1 ) . ' days' );

			if ( $end >= $today ) {
				$out[] = self::format_occurrence( $series, $cursor, $end, count( $out ) );
			}

			$cursor = self::advance_occurrence( $series, $cursor, $weekday );
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
				/* translators: 1: day span, 2: date range, 3: route, 4: status */
				__( '%1$s · %2$s · %3$s · %4$s', 'xciv-social' ),
				(string) $series['day_span'],
				$range,
				(string) $series['route'],
				$status
			),
			'scope'            => 'upcoming',
			'index'            => $index,
			'badge'            => $status,
			'cta'              => $waitlist ? 'waitlist' : ( $paid ? 'purchase' : 'rsvp' ),
		);
	}

	/**
	 * @param array<string, mixed> $series Series definition.
	 */
	private static function advance_occurrence( array $series, \DateTimeImmutable $from, int $weekday ): \DateTimeImmutable {
		$mode = (string) ( $series['recurrence'] ?? 'interval_snap' );

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

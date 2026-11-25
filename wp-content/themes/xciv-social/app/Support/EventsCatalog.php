<?php
/**
 * Production event catalog (paid series + calendar marks).
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class EventsCatalog {

	/**
	 * Canonical paid series definition.
	 *
	 * @return array<string, mixed>
	 */
	public static function series(): array {
		return array(
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
			'anchor'          => '2026-11-29',
			'host'            => __( 'THE SUPER NINETY FOUR EVENTS COMPANY', 'xciv-social' ),
			'host_short'      => __( 'Super Ninety Four Events', 'xciv-social' ),
			'time_label'      => __( 'All day', 'xciv-social' ),
			'mark_label'      => __( 'Harrisburg→Lynn', 'xciv-social' ),
		);
	}

	/**
	 * Upcoming trip occurrences (Sunday start → Wednesday end).
	 *
	 * @param int $limit Max occurrences to return.
	 * @return list<array<string, mixed>>
	 */
	public static function occurrences( int $limit = 6 ): array {
		$series = self::series();
		$anchor = \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $series['anchor'] );
		if ( ! $anchor ) {
			return array();
		}

		$today  = new \DateTimeImmutable( 'today' );
		$cursor = $anchor;
		$out    = array();
		$guard  = 0;

		while ( count( $out ) < $limit && $guard < 48 ) {
			++$guard;
			$end = $cursor->modify( '+' . ( (int) $series['duration_days'] - 1 ) . ' days' );

			if ( $end >= $today ) {
				$out[] = self::format_occurrence( $series, $cursor, $end, count( $out ) );
			}

			$cursor = self::next_sunday_start( $cursor, (int) $series['interval_months'] );
		}

		return $out;
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
	public static function calendar_events( int $limit = 6 ): array {
		$map = array();

		foreach ( self::occurrences( $limit ) as $trip ) {
			$start = \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $trip['start'] );
			$end   = \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $trip['end'] );
			if ( ! $start || ! $end ) {
				continue;
			}

			for ( $day = $start; $day <= $end; $day = $day->modify( '+1 day' ) ) {
				$key           = $day->format( 'Y-m-d' );
				$map[ $key ]  = $map[ $key ] ?? array();
				$map[ $key ][] = array(
					'time'  => (string) $trip['time_label'],
					'city'  => (string) $trip['city'],
					'title' => (string) $trip['title'],
					'host'  => sprintf(
						/* translators: 1: host name, 2: route label */
						__( '%1$s · Paid · %2$s', 'xciv-social' ),
						(string) $trip['host_short'],
						(string) $trip['route']
					),
					'going' => false,
					'paid'  => true,
					'mark'  => (string) $trip['mark_label'],
				);
			}
		}

		return $map;
	}

	/**
	 * Build a dashboard mini-cal for the month containing the next trip start.
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
		$marks         = self::calendar_events( 8 );
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
	 * @return array<string, mixed>
	 */
	private static function format_occurrence( array $series, \DateTimeImmutable $start, \DateTimeImmutable $end, int $index ): array {
		$range = sprintf(
			/* translators: 1: start date, 2: end date */
			__( '%1$s – %2$s', 'xciv-social' ),
			$start->format( 'M j' ),
			$end->format( 'M j, Y' )
		);

		return array(
			'id'          => (string) $series['id'] . '-' . $start->format( 'Ymd' ),
			'series_id'   => (string) $series['id'],
			'title'       => (string) $series['title'],
			'description' => (string) $series['description'],
			'city'        => (string) $series['city'],
			'destination' => (string) $series['destination'],
			'route'       => (string) $series['route'],
			'vertical'    => (string) $series['vertical'],
			'paid'        => true,
			'host'        => (string) $series['host'],
			'host_short'  => (string) $series['host_short'],
			'time_label'  => (string) $series['time_label'],
			'mark_label'  => (string) $series['mark_label'],
			'start'       => $start->format( 'Y-m-d' ),
			'end'         => $end->format( 'Y-m-d' ),
			'month'       => $start->format( 'M' ),
			'day'         => $start->format( 'd' ),
			'weekday'     => $start->format( 'D' ),
			'range'       => $range,
			'meta'        => sprintf(
				/* translators: 1: date range, 2: route */
				__( 'Sun–Wed · %1$s · %2$s · Paid', 'xciv-social' ),
				$range,
				(string) $series['route']
			),
			'scope'       => 'upcoming',
			'index'       => $index,
		);
	}

	private static function next_sunday_start( \DateTimeImmutable $from, int $months ): \DateTimeImmutable {
		$next = $from->modify( '+' . $months . ' months' );
		$dow  = (int) $next->format( 'w' );
		if ( 0 !== $dow ) {
			$next = $next->modify( '-' . $dow . ' days' );
		}
		return $next;
	}
}

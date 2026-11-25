<?php
/**
 * Template Name: Event Calendar
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\EventsCatalog;

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$weekday_labels = array(
	__( 'Sun', 'xciv-social' ),
	__( 'Mon', 'xciv-social' ),
	__( 'Tue', 'xciv-social' ),
	__( 'Wed', 'xciv-social' ),
	__( 'Thu', 'xciv-social' ),
	__( 'Fri', 'xciv-social' ),
	__( 'Sat', 'xciv-social' ),
);

$next = EventsCatalog::next_occurrence();
$initial_label = $next
	? ( \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $next['start'] ) ?: new \DateTimeImmutable() )->format( 'F Y' )
	: wp_date( 'F Y' );
$day_title = $next
	? ( \DateTimeImmutable::createFromFormat( '!Y-m-d', (string) $next['start'] ) ?: new \DateTimeImmutable() )->format( 'l, M j' )
	: __( 'Select a day', 'xciv-social' );
?>
<main id="main" class="xciv-shell xciv-events xciv-events--calendar" data-xciv-events-calendar>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Event calendar', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Paid member trips and Super Ninety Four Experiences.', 'xciv-social' ); ?></p>
		</div>
		<div class="xciv-section-head__actions">
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'List view', 'xciv-social' ); ?></a>
			<button type="button" class="xciv-btn xciv-btn--primary" data-create-event><?php esc_html_e( 'Create event', 'xciv-social' ); ?></button>
		</div>
	</header>

	<div class="xciv-calendar-layout">
		<section class="xciv-panel xciv-calendar" data-calendar>
			<header class="xciv-panel__head xciv-calendar__toolbar">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-cal-prev aria-label="<?php esc_attr_e( 'Previous month', 'xciv-social' ); ?>">&larr;</button>
				<h2 class="xciv-panel__title" data-cal-label><?php echo esc_html( $initial_label ); ?></h2>
				<button type="button" class="xciv-btn xciv-btn--ghost" data-cal-next aria-label="<?php esc_attr_e( 'Next month', 'xciv-social' ); ?>">&rarr;</button>
			</header>

			<div class="xciv-panel__body">
				<div class="xciv-calendar__weekdays" aria-hidden="true">
					<?php foreach ( $weekday_labels as $label ) : ?>
						<span><?php echo esc_html( $label ); ?></span>
					<?php endforeach; ?>
				</div>

				<div class="xciv-calendar__grid" data-cal-grid>
					<!-- Filled by events.js -->
				</div>
			</div>
		</section>

		<section class="xciv-panel" data-day-detail>
			<header class="xciv-panel__head">
				<h2 class="xciv-panel__title" data-day-title><?php echo esc_html( $day_title ); ?></h2>
				<p class="xciv-panel__desc"><?php esc_html_e( 'Events for the selected day.', 'xciv-social' ); ?></p>
			</header>
			<div class="xciv-panel__body xciv-day-events" data-day-events>
				<p class="xciv-muted"><?php esc_html_e( 'Loading schedule…', 'xciv-social' ); ?></p>
			</div>
		</section>
	</div>
</main>
<?php
get_footer();

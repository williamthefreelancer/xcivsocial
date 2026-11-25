<?php
/**
 * Template Name: Event Calendar
 *
 * @package XCIV_Social
 */

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
?>
<main id="main" class="xciv-shell xciv-events xciv-events--calendar" data-xciv-events-calendar>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Event calendar', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Private gatherings, club nights, and member-hosted experiences.', 'xciv-social' ); ?></p>
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
				<h2 class="xciv-panel__title" data-cal-label><?php esc_html_e( 'December 2026', 'xciv-social' ); ?></h2>
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
				<h2 class="xciv-panel__title" data-day-title><?php esc_html_e( 'Thursday, Dec 4', 'xciv-social' ); ?></h2>
				<p class="xciv-panel__desc"><?php esc_html_e( 'Events for the selected day.', 'xciv-social' ); ?></p>
			</header>
			<div class="xciv-panel__body xciv-day-events" data-day-events>
				<article class="xciv-day-event">
					<div class="xciv-day-event__time">
						<strong>7:30 PM</strong>
						<span class="xciv-muted"><?php esc_html_e( 'Miami', 'xciv-social' ); ?></span>
					</div>
					<div>
						<h3><?php esc_html_e( 'Table Dinner: One Intro Before Dessert', 'xciv-social' ); ?></h3>
						<p class="xciv-muted"><?php esc_html_e( 'Jonah Reyes · 18 going', 'xciv-social' ); ?></p>
					</div>
					<button type="button" class="xciv-btn xciv-btn--primary is-rsvped" data-rsvp><?php esc_html_e( 'Going', 'xciv-social' ); ?></button>
				</article>
			</div>
		</section>
	</div>
</main>
<?php
get_footer();

<?php
/**
 * Template Name: Event Listings
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\EventsCatalog;

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$occurrences = EventsCatalog::occurrences( 6 );
?>
<main id="main" class="xciv-shell xciv-events xciv-events--list" data-xciv-events-list>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Events', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Paid member trips and Super Ninety Four Experiences.', 'xciv-social' ); ?></p>
		</div>
		<div class="xciv-section-head__actions">
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/event-calendar/' ) ); ?>"><?php esc_html_e( 'Calendar', 'xciv-social' ); ?></a>
			<button type="button" class="xciv-btn xciv-btn--primary" data-create-event><?php esc_html_e( 'Create event', 'xciv-social' ); ?></button>
		</div>
	</header>

	<nav class="xciv-feed-filters xciv-events__tabs" data-event-tabs aria-label="<?php esc_attr_e( 'Event views', 'xciv-social' ); ?>">
		<button type="button" class="xciv-feed-filters__btn is-active" data-event-scope="upcoming" aria-pressed="true"><?php esc_html_e( 'Upcoming', 'xciv-social' ); ?></button>
		<button type="button" class="xciv-feed-filters__btn" data-event-scope="hosting" aria-pressed="false"><?php esc_html_e( 'Hosting', 'xciv-social' ); ?></button>
		<button type="button" class="xciv-feed-filters__btn" data-event-scope="going" aria-pressed="false"><?php esc_html_e( 'Going', 'xciv-social' ); ?></button>
		<button type="button" class="xciv-feed-filters__btn" data-event-scope="past" aria-pressed="false"><?php esc_html_e( 'Past', 'xciv-social' ); ?></button>
	</nav>

	<section class="xciv-panel xciv-filters" data-event-filters>
		<div class="xciv-panel__body">
			<form class="xciv-filter-row" action="#" method="get">
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'Search events', 'xciv-social' ); ?></span>
					<input type="search" name="q" placeholder="<?php esc_attr_e( 'Search events…', 'xciv-social' ); ?>" data-event-search>
				</label>
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'City', 'xciv-social' ); ?></span>
					<input type="text" name="city" placeholder="<?php esc_attr_e( 'City', 'xciv-social' ); ?>" data-event-city>
				</label>
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'Vertical', 'xciv-social' ); ?></span>
					<select name="vertical" data-event-vertical>
						<option value=""><?php esc_html_e( 'All verticals', 'xciv-social' ); ?></option>
						<option value="hospitality"><?php esc_html_e( 'Hospitality', 'xciv-social' ); ?></option>
						<option value="nightlife"><?php esc_html_e( 'Nightlife', 'xciv-social' ); ?></option>
						<option value="club_event"><?php esc_html_e( 'Club & event', 'xciv-social' ); ?></option>
						<option value="marketplace"><?php esc_html_e( 'Marketplace', 'xciv-social' ); ?></option>
						<option value="fintech"><?php esc_html_e( 'Fintech', 'xciv-social' ); ?></option>
					</select>
				</label>
				<button type="submit" class="xciv-btn"><?php esc_html_e( 'Apply', 'xciv-social' ); ?></button>
			</form>
		</div>
	</section>

	<section class="xciv-event-list" data-event-list>
		<?php foreach ( $occurrences as $trip ) : ?>
			<article
				class="xciv-event-card"
				data-event-id="<?php echo esc_attr( (string) $trip['id'] ); ?>"
				data-scope="<?php echo esc_attr( (string) $trip['scope'] ); ?>"
				data-vertical="<?php echo esc_attr( (string) $trip['vertical'] ); ?>"
				data-city="<?php echo esc_attr( (string) $trip['city'] ); ?>"
				data-paid="true"
			>
				<div class="xciv-event-card__date" aria-hidden="true">
					<span class="xciv-event-card__month"><?php echo esc_html( (string) $trip['month'] ); ?></span>
					<span class="xciv-event-card__day"><?php echo esc_html( (string) $trip['day'] ); ?></span>
				</div>
				<div class="xciv-event-card__body">
					<p class="xciv-event-card__meta xciv-muted"><?php echo esc_html( (string) $trip['meta'] ); ?></p>
					<h2 class="xciv-event-card__title">
						<?php echo esc_html( (string) $trip['title'] ); ?>
						<span class="xciv-event-card__badge"><?php esc_html_e( 'Paid', 'xciv-social' ); ?></span>
					</h2>
					<p class="xciv-event-card__desc"><?php echo esc_html( (string) $trip['description'] ); ?></p>
					<div class="xciv-event-card__people">
						<span class="xciv-avatar" aria-hidden="true"><span>S</span></span>
						<span class="xciv-muted">
							<?php
							printf(
								/* translators: %s: host organization */
								esc_html__( 'Hosted by %s · Club & event', 'xciv-social' ),
								esc_html( (string) $trip['host_short'] )
							);
							?>
						</span>
					</div>
				</div>
				<div class="xciv-event-card__actions">
					<button type="button" class="xciv-btn xciv-btn--ghost" data-event-detail><?php esc_html_e( 'Details', 'xciv-social' ); ?></button>
					<button type="button" class="xciv-btn xciv-btn--primary" data-purchase aria-pressed="false"><?php esc_html_e( 'Purchase', 'xciv-social' ); ?></button>
				</div>
			</article>
		<?php endforeach; ?>

		<p class="xciv-feed-empty xciv-muted" data-event-empty <?php echo $occurrences ? 'hidden' : ''; ?>>
			<?php esc_html_e( 'No events in this view. Try another filter.', 'xciv-social' ); ?>
		</p>
	</section>
</main>
<?php
get_footer();

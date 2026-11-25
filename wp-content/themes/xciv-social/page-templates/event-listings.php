<?php
/**
 * Template Name: Event Listings
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();
?>
<main id="main" class="xciv-shell xciv-events xciv-events--list" data-xciv-events-list>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Events', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Private dinners, club nights, and member-hosted experiences.', 'xciv-social' ); ?></p>
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
		<article class="xciv-event-card" data-event-id="e1" data-scope="upcoming going" data-vertical="hospitality" data-city="Miami">
			<div class="xciv-event-card__date" aria-hidden="true">
				<span class="xciv-event-card__month"><?php esc_html_e( 'Dec', 'xciv-social' ); ?></span>
				<span class="xciv-event-card__day">04</span>
			</div>
			<div class="xciv-event-card__body">
				<p class="xciv-event-card__meta xciv-muted"><?php esc_html_e( 'Thu · 7:30 PM · Miami · 18 going', 'xciv-social' ); ?></p>
				<h2 class="xciv-event-card__title"><?php esc_html_e( 'Table Dinner: One Intro Before Dessert', 'xciv-social' ); ?></h2>
				<p class="xciv-event-card__desc"><?php esc_html_e( 'Twelve-seat dinner with a hard rule — every guest offers one warm introduction before dessert. Hosted by Jonah Reyes.', 'xciv-social' ); ?></p>
				<div class="xciv-event-card__people">
					<span class="xciv-avatar" aria-hidden="true"><span>J</span></span>
					<span class="xciv-muted"><?php esc_html_e( 'Hosted by Jonah Reyes · Hospitality', 'xciv-social' ); ?></span>
				</div>
			</div>
			<div class="xciv-event-card__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-event-detail><?php esc_html_e( 'Details', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-btn xciv-btn--primary is-rsvped" data-rsvp aria-pressed="true"><?php esc_html_e( 'Going', 'xciv-social' ); ?></button>
			</div>
		</article>

		<article class="xciv-event-card" data-event-id="e2" data-scope="upcoming" data-vertical="nightlife" data-city="Dubai">
			<div class="xciv-event-card__date" aria-hidden="true">
				<span class="xciv-event-card__month"><?php esc_html_e( 'Dec', 'xciv-social' ); ?></span>
				<span class="xciv-event-card__day">11</span>
			</div>
			<div class="xciv-event-card__body">
				<p class="xciv-event-card__meta xciv-muted"><?php esc_html_e( 'Thu · 10:00 PM · Dubai · 42 going', 'xciv-social' ); ?></p>
				<h2 class="xciv-event-card__title"><?php esc_html_e( 'Members After Hours — DIFC Terrace', 'xciv-social' ); ?></h2>
				<p class="xciv-event-card__desc"><?php esc_html_e( 'Closed terrace night for operators in media, nightlife, and hospitality. No pitches; conversation only.', 'xciv-social' ); ?></p>
				<div class="xciv-event-card__people">
					<span class="xciv-avatar" aria-hidden="true"><span>A</span></span>
					<span class="xciv-muted"><?php esc_html_e( 'Hosted by Amira Haddad · Media', 'xciv-social' ); ?></span>
				</div>
			</div>
			<div class="xciv-event-card__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-event-detail><?php esc_html_e( 'Details', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-btn xciv-btn--primary" data-rsvp aria-pressed="false"><?php esc_html_e( 'RSVP', 'xciv-social' ); ?></button>
			</div>
		</article>

		<article class="xciv-event-card" data-event-id="e3" data-scope="upcoming hosting" data-vertical="fintech" data-city="Lagos">
			<div class="xciv-event-card__date" aria-hidden="true">
				<span class="xciv-event-card__month"><?php esc_html_e( 'Dec', 'xciv-social' ); ?></span>
				<span class="xciv-event-card__day">16</span>
			</div>
			<div class="xciv-event-card__body">
				<p class="xciv-event-card__meta xciv-muted"><?php esc_html_e( 'Tue · 4:00 PM · Lagos · 11 going', 'xciv-social' ); ?></p>
				<h2 class="xciv-event-card__title"><?php esc_html_e( 'Corridor Operators Roundtable', 'xciv-social' ); ?></h2>
				<p class="xciv-event-card__desc"><?php esc_html_e( 'Working session for remittance and payments operators clearing volume across West Africa. Compliance-first agenda.', 'xciv-social' ); ?></p>
				<div class="xciv-event-card__people">
					<span class="xciv-avatar" aria-hidden="true"><span>M</span></span>
					<span class="xciv-muted"><?php esc_html_e( 'Hosted by Maya Okonkwo · Fintech', 'xciv-social' ); ?></span>
				</div>
			</div>
			<div class="xciv-event-card__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-event-detail><?php esc_html_e( 'Details', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-btn xciv-btn--primary is-rsvped" data-rsvp aria-pressed="true"><?php esc_html_e( 'Hosting', 'xciv-social' ); ?></button>
			</div>
		</article>

		<article class="xciv-event-card" data-event-id="e4" data-scope="upcoming" data-vertical="club_event" data-city="London">
			<div class="xciv-event-card__date" aria-hidden="true">
				<span class="xciv-event-card__month"><?php esc_html_e( 'Jan', 'xciv-social' ); ?></span>
				<span class="xciv-event-card__day">09</span>
			</div>
			<div class="xciv-event-card__body">
				<p class="xciv-event-card__meta xciv-muted"><?php esc_html_e( 'Fri · 6:00 PM · London · 27 going', 'xciv-social' ); ?></p>
				<h2 class="xciv-event-card__title"><?php esc_html_e( 'New Year Operator Salon', 'xciv-social' ); ?></h2>
				<p class="xciv-event-card__desc"><?php esc_html_e( 'Salons for club and event leads — staffing, talent, and capital conversations without the public circuit.', 'xciv-social' ); ?></p>
				<div class="xciv-event-card__people">
					<span class="xciv-avatar" aria-hidden="true"><span>S</span></span>
					<span class="xciv-muted"><?php esc_html_e( 'Hosted by Sofia Berg · Design ops', 'xciv-social' ); ?></span>
				</div>
			</div>
			<div class="xciv-event-card__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-event-detail><?php esc_html_e( 'Details', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-btn xciv-btn--primary" data-rsvp aria-pressed="false"><?php esc_html_e( 'RSVP', 'xciv-social' ); ?></button>
			</div>
		</article>

		<article class="xciv-event-card" data-event-id="e5" data-scope="past going" data-vertical="marketplace" data-city="Montréal" hidden>
			<div class="xciv-event-card__date" aria-hidden="true">
				<span class="xciv-event-card__month"><?php esc_html_e( 'Nov', 'xciv-social' ); ?></span>
				<span class="xciv-event-card__day">12</span>
			</div>
			<div class="xciv-event-card__body">
				<p class="xciv-event-card__meta xciv-muted"><?php esc_html_e( 'Wed · 5:00 PM · Montréal · Ended', 'xciv-social' ); ?></p>
				<h2 class="xciv-event-card__title"><?php esc_html_e( 'Deal Memo Workshop', 'xciv-social' ); ?></h2>
				<p class="xciv-event-card__desc"><?php esc_html_e( 'Drafted lightweight first-conversation memos for operator-to-operator capital inside XCIV.', 'xciv-social' ); ?></p>
				<div class="xciv-event-card__people">
					<span class="xciv-avatar" aria-hidden="true"><span>T</span></span>
					<span class="xciv-muted"><?php esc_html_e( 'Hosted by Theo Marchand · Climate tech', 'xciv-social' ); ?></span>
				</div>
			</div>
			<div class="xciv-event-card__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-event-detail><?php esc_html_e( 'Recap', 'xciv-social' ); ?></button>
			</div>
		</article>

		<p class="xciv-feed-empty xciv-muted" data-event-empty hidden><?php esc_html_e( 'No events in this view. Try another filter.', 'xciv-social' ); ?></p>
	</section>
</main>
<?php
get_footer();

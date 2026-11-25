<?php
/**
 * Template Name: Member Dashboard
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : __( 'Member', 'xciv-social' );
$first_name   = $current_user->first_name ? $current_user->first_name : $display_name;

$weekday_labels = array(
	__( 'S', 'xciv-social' ),
	__( 'M', 'xciv-social' ),
	__( 'T', 'xciv-social' ),
	__( 'W', 'xciv-social' ),
	__( 'T', 'xciv-social' ),
	__( 'F', 'xciv-social' ),
	__( 'S', 'xciv-social' ),
);

/* Compact Dec 2026 grid: Wed start (offset 3). Marks on 4, 11, 16. */
$calendar_days = array();
for ( $i = 0; $i < 3; $i++ ) {
	$calendar_days[] = array(
		'day'     => 29 + $i,
		'outside' => true,
		'marks'   => array(),
	);
}
$event_marks = array(
	4  => __( 'Dinner', 'xciv-social' ),
	11 => __( 'Club', 'xciv-social' ),
	16 => __( 'Roundtable', 'xciv-social' ),
);
for ( $d = 1; $d <= 31; $d++ ) {
	$calendar_days[] = array(
		'day'     => $d,
		'outside' => false,
		'today'   => 24 === $d,
		'marks'   => isset( $event_marks[ $d ] ) ? array( $event_marks[ $d ] ) : array(),
	);
}
$trailing = 0;
while ( count( $calendar_days ) % 7 !== 0 ) {
	++$trailing;
	$calendar_days[] = array(
		'day'     => $trailing,
		'outside' => true,
		'marks'   => array(),
	);
}
?>
<main id="main" class="xciv-shell xciv-dashboard" data-xciv-dashboard>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Dashboard', 'xciv-social' ); ?></h1>
			<p>
				<?php
				printf(
					/* translators: %s: member first name */
					esc_html__( 'Welcome back, %s — your briefing, schedule, and recent network activity.', 'xciv-social' ),
					esc_html( $first_name )
				);
				?>
			</p>
		</div>
		<div class="xciv-section-head__actions">
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/member-feed/' ) ); ?>"><?php esc_html_e( 'Open feed', 'xciv-social' ); ?></a>
			<a class="xciv-btn xciv-btn--primary" href="<?php echo esc_url( home_url( '/messages/' ) ); ?>"><?php esc_html_e( 'Messages', 'xciv-social' ); ?></a>
		</div>
	</header>

	<div class="xciv-dashboard__layout">
		<div class="xciv-dashboard__primary">
			<section class="xciv-panel xciv-dashboard__feature" data-panel="feature">
				<header class="xciv-panel__head">
					<p class="xciv-dashboard__eyebrow xciv-muted"><?php esc_html_e( 'Featured briefing', 'xciv-social' ); ?></p>
					<h2 class="xciv-panel__title"><?php esc_html_e( 'How warm intros compound inside a closed room', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'A short member briefing on cadence, reciprocity, and what to bring to December dinners.', 'xciv-social' ); ?></p>
				</header>

				<div class="xciv-panel__body">
					<figure class="xciv-video" data-xciv-video>
						<?php
						// Set a hosted MP4 URL when the briefing asset is ready.
						$briefing_src = '';
						?>
						<div class="xciv-video__frame<?php echo $briefing_src ? '' : ' is-empty'; ?>">
							<?php if ( $briefing_src ) : ?>
								<video
									class="xciv-video__media"
									controls
									playsinline
									preload="metadata"
									data-video-el
								>
									<source src="<?php echo esc_url( $briefing_src ); ?>" type="video/mp4">
									<?php esc_html_e( 'Your browser does not support embedded video.', 'xciv-social' ); ?>
								</video>
							<?php else : ?>
								<div class="xciv-video__poster" aria-hidden="true"></div>
							<?php endif; ?>
							<button type="button" class="xciv-video__play" data-video-play aria-label="<?php esc_attr_e( 'Play briefing', 'xciv-social' ); ?>">
								<span class="xciv-video__play-icon" aria-hidden="true"></span>
							</button>
							<div class="xciv-video__meta" aria-hidden="true">
								<span><?php esc_html_e( 'XCIV Briefing', 'xciv-social' ); ?></span>
								<span><?php esc_html_e( '6:42', 'xciv-social' ); ?></span>
							</div>
						</div>
						<figcaption class="xciv-video__caption xciv-muted">
							<?php esc_html_e( 'Member briefing player — drop an MP4 URL into $briefing_src when ready.', 'xciv-social' ); ?>
						</figcaption>
					</figure>
				</div>
			</section>

			<section class="xciv-panel xciv-dashboard__activity" data-panel="activity">
				<header class="xciv-panel__head xciv-dashboard__panel-head">
					<div>
						<h2 class="xciv-panel__title"><?php esc_html_e( 'Recent activity', 'xciv-social' ); ?></h2>
						<p class="xciv-panel__desc"><?php esc_html_e( 'Feed highlights and introduction signals.', 'xciv-social' ); ?></p>
					</div>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/member-feed/' ) ); ?>"><?php esc_html_e( 'View all', 'xciv-social' ); ?></a>
				</header>
				<div class="xciv-panel__body xciv-profile-activity">
					<article class="xciv-activity-row">
						<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>M</span></span>
						<div>
							<p>
								<strong><?php esc_html_e( 'Maya Okonkwo', 'xciv-social' ); ?></strong>
								<?php esc_html_e( 'posted an opportunity on remittance corridors.', 'xciv-social' ); ?>
							</p>
							<small class="xciv-muted"><?php esc_html_e( '2h ago · Opportunity · 12 appreciations', 'xciv-social' ); ?></small>
						</div>
					</article>
					<article class="xciv-activity-row">
						<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>J</span></span>
						<div>
							<p>
								<strong><?php esc_html_e( 'Jonah Reyes', 'xciv-social' ); ?></strong>
								<?php esc_html_e( 'opened RSVPs for Table Dinner: One Intro Before Dessert.', 'xciv-social' ); ?>
							</p>
							<small class="xciv-muted"><?php esc_html_e( '5h ago · Event · Miami · 18 going', 'xciv-social' ); ?></small>
						</div>
					</article>
					<article class="xciv-activity-row">
						<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>A</span></span>
						<div>
							<p>
								<strong><?php esc_html_e( 'Amira Haddad', 'xciv-social' ); ?></strong>
								<?php esc_html_e( 'requested an introduction to logistics operators in GCC.', 'xciv-social' ); ?>
							</p>
							<small class="xciv-muted"><?php esc_html_e( 'Yesterday · Introduction', 'xciv-social' ); ?></small>
						</div>
					</article>
					<article class="xciv-activity-row">
						<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>L</span></span>
						<div>
							<p>
								<strong><?php esc_html_e( 'Leo Park', 'xciv-social' ); ?></strong>
								<?php esc_html_e( 'shared an idea on closed-room capital vs open venture theater.', 'xciv-social' ); ?>
							</p>
							<small class="xciv-muted"><?php esc_html_e( '2 days ago · Idea · 21 appreciations', 'xciv-social' ); ?></small>
						</div>
					</article>
				</div>
			</section>
		</div>

		<aside class="xciv-dashboard__aside">
			<section class="xciv-panel xciv-dashboard__schedule" data-panel="events">
				<header class="xciv-panel__head xciv-dashboard__panel-head">
					<div>
						<h2 class="xciv-panel__title"><?php esc_html_e( 'Event schedule', 'xciv-social' ); ?></h2>
						<p class="xciv-panel__desc"><?php esc_html_e( 'Next gatherings on your calendar.', 'xciv-social' ); ?></p>
					</div>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'All', 'xciv-social' ); ?></a>
				</header>
				<div class="xciv-panel__body xciv-dashboard-schedule">
					<article class="xciv-dashboard-schedule__item">
						<div class="xciv-event-card__date" aria-hidden="true">
							<span class="xciv-event-card__month"><?php esc_html_e( 'Dec', 'xciv-social' ); ?></span>
							<span class="xciv-event-card__day">04</span>
						</div>
						<div>
							<p class="xciv-muted xciv-dashboard-schedule__meta"><?php esc_html_e( 'Thu · 7:30 PM · Miami', 'xciv-social' ); ?></p>
							<strong><?php esc_html_e( 'Table Dinner: One Intro Before Dessert', 'xciv-social' ); ?></strong>
							<p class="xciv-muted"><?php esc_html_e( '18 going · You are going', 'xciv-social' ); ?></p>
						</div>
					</article>
					<article class="xciv-dashboard-schedule__item">
						<div class="xciv-event-card__date" aria-hidden="true">
							<span class="xciv-event-card__month"><?php esc_html_e( 'Dec', 'xciv-social' ); ?></span>
							<span class="xciv-event-card__day">11</span>
						</div>
						<div>
							<p class="xciv-muted xciv-dashboard-schedule__meta"><?php esc_html_e( 'Thu · 9:00 PM · Dubai', 'xciv-social' ); ?></p>
							<strong><?php esc_html_e( 'After-Hours Operators Club', 'xciv-social' ); ?></strong>
							<p class="xciv-muted"><?php esc_html_e( '24 interested', 'xciv-social' ); ?></p>
						</div>
					</article>
					<article class="xciv-dashboard-schedule__item">
						<div class="xciv-event-card__date" aria-hidden="true">
							<span class="xciv-event-card__month"><?php esc_html_e( 'Dec', 'xciv-social' ); ?></span>
							<span class="xciv-event-card__day">16</span>
						</div>
						<div>
							<p class="xciv-muted xciv-dashboard-schedule__meta"><?php esc_html_e( 'Tue · 6:00 PM · Lagos', 'xciv-social' ); ?></p>
							<strong><?php esc_html_e( 'Corridor Operators Roundtable', 'xciv-social' ); ?></strong>
							<p class="xciv-muted"><?php esc_html_e( '11 going · You are hosting', 'xciv-social' ); ?></p>
						</div>
					</article>
				</div>
			</section>

			<section class="xciv-panel xciv-dashboard__calendar" data-panel="calendar">
				<header class="xciv-panel__head xciv-dashboard__panel-head">
					<div>
						<h2 class="xciv-panel__title"><?php esc_html_e( 'Calendar', 'xciv-social' ); ?></h2>
						<p class="xciv-panel__desc"><?php esc_html_e( 'December 2026', 'xciv-social' ); ?></p>
					</div>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/event-calendar/' ) ); ?>"><?php esc_html_e( 'Expand', 'xciv-social' ); ?></a>
				</header>
				<div class="xciv-panel__body">
					<div class="xciv-mini-cal" data-mini-cal>
						<div class="xciv-mini-cal__weekdays" aria-hidden="true">
							<?php foreach ( $weekday_labels as $label ) : ?>
								<span><?php echo esc_html( $label ); ?></span>
							<?php endforeach; ?>
						</div>
						<div class="xciv-mini-cal__grid">
							<?php foreach ( $calendar_days as $cell ) : ?>
								<?php
								$classes = 'xciv-mini-cal__cell';
								if ( ! empty( $cell['outside'] ) ) {
									$classes .= ' is-outside';
								}
								if ( ! empty( $cell['today'] ) ) {
									$classes .= ' is-today';
								}
								if ( ! empty( $cell['marks'] ) ) {
									$classes .= ' has-event';
								}
								?>
								<span class="<?php echo esc_attr( $classes ); ?>">
									<span class="xciv-mini-cal__day"><?php echo esc_html( (string) $cell['day'] ); ?></span>
									<?php if ( ! empty( $cell['marks'] ) ) : ?>
										<span class="xciv-calendar__dot" title="<?php echo esc_attr( $cell['marks'][0] ); ?>"></span>
									<?php endif; ?>
								</span>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</section>

			<section class="xciv-panel xciv-dashboard__messages" data-panel="messages">
				<header class="xciv-panel__head xciv-dashboard__panel-head">
					<div>
						<h2 class="xciv-panel__title"><?php esc_html_e( 'Messages', 'xciv-social' ); ?></h2>
						<p class="xciv-panel__desc"><?php esc_html_e( 'Unread and pinned threads.', 'xciv-social' ); ?></p>
					</div>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/messages/' ) ); ?>"><?php esc_html_e( 'Inbox', 'xciv-social' ); ?></a>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-dashboard-threads">
						<li>
							<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>M</span></span>
							<span class="xciv-dashboard-threads__copy">
								<strong><?php esc_html_e( 'Maya Okonkwo', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Can you make that Lagos intro next week?', 'xciv-social' ); ?></small>
							</span>
							<span class="xciv-dashboard-threads__badge"><?php esc_html_e( '2', 'xciv-social' ); ?></span>
						</li>
						<li>
							<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>J</span></span>
							<span class="xciv-dashboard-threads__copy">
								<strong><?php esc_html_e( 'Jonah Reyes', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Seat confirmed for Dec 4 dinner.', 'xciv-social' ); ?></small>
							</span>
						</li>
						<li>
							<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>A</span></span>
							<span class="xciv-dashboard-threads__copy">
								<strong><?php esc_html_e( 'Amira Haddad', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Sharing the GCC logistics shortlist.', 'xciv-social' ); ?></small>
							</span>
							<span class="xciv-dashboard-threads__badge"><?php esc_html_e( '1', 'xciv-social' ); ?></span>
						</li>
					</ul>
				</div>
			</section>

			<section class="xciv-panel xciv-dashboard__actions" data-panel="actions">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Quick actions', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Shortcuts into core flows.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<div class="xciv-action-row">
						<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/member-feed/' ) ); ?>"><?php esc_html_e( 'Post to feed', 'xciv-social' ); ?></a>
						<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'Browse events', 'xciv-social' ); ?></a>
						<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/people/' ) ); ?>"><?php esc_html_e( 'People', 'xciv-social' ); ?></a>
					</div>
				</div>
			</section>
		</aside>
	</div>
</main>
<?php
get_footer();

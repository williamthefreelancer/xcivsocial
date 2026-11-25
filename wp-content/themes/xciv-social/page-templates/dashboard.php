<?php
/**
 * Template Name: Member Dashboard
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\AttendeeChats;
use XCIV\Theme\Support\EventsCatalog;
use XCIV\Theme\Support\VideoEmbed;

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

$upcoming_trips  = EventsCatalog::occurrences( 4 );
$mini_cal        = EventsCatalog::dashboard_calendar();
$calendar_days   = $mini_cal['days'];
$attendee_chats  = AttendeeChats::threads();
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
					<p class="xciv-panel__desc"><?php esc_html_e( 'A short member briefing on cadence, reciprocity, and what to bring to the next gathering.', 'xciv-social' ); ?></p>
				</header>

				<div class="xciv-panel__body">
					<?php
					/*
					 * Paste a YouTube, Vimeo, or Bunny Stream URL (watch / share / embed).
					 * Bunny example: https://iframe.mediadelivery.net/embed/{libraryId}/{videoId}
					 */
					$briefing_url   = '';
					$briefing_url   = (string) apply_filters( 'xciv_dashboard_briefing_embed', $briefing_url );
					$briefing_embed = VideoEmbed::resolve( $briefing_url );
					$has_embed      = is_array( $briefing_embed );
					?>
					<figure
						class="xciv-video"
						data-xciv-video
						<?php if ( $has_embed ) : ?>
							data-embed-provider="<?php echo esc_attr( (string) $briefing_embed['provider'] ); ?>"
							data-embed-src="<?php echo esc_url( (string) $briefing_embed['autoplay'] ); ?>"
						<?php endif; ?>
					>
						<div class="xciv-video__frame<?php echo $has_embed ? '' : ' is-empty'; ?>" data-video-frame>
							<div class="xciv-video__poster" data-video-poster aria-hidden="true"></div>
							<button
								type="button"
								class="xciv-video__play"
								data-video-play
								aria-label="<?php echo $has_embed ? esc_attr__( 'Play briefing', 'xciv-social' ) : esc_attr__( 'Briefing embed unavailable', 'xciv-social' ); ?>"
								<?php disabled( ! $has_embed ); ?>
							>
								<span class="xciv-video__play-icon" aria-hidden="true"></span>
							</button>
							<div class="xciv-video__meta" data-video-meta aria-hidden="true">
								<span><?php esc_html_e( 'XCIV Briefing', 'xciv-social' ); ?></span>
								<span><?php echo $has_embed ? esc_html( strtoupper( (string) $briefing_embed['provider'] ) ) : esc_html__( 'Embed', 'xciv-social' ); ?></span>
							</div>
						</div>
						<figcaption class="xciv-video__caption xciv-muted">
							<?php
							echo $has_embed
								? esc_html__( 'Member briefing — press play to watch.', 'xciv-social' )
								: esc_html__( 'Member briefing player — set a YouTube, Vimeo, or Bunny Stream URL via xciv_dashboard_briefing_embed.', 'xciv-social' );
							?>
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
					<?php if ( $upcoming_trips ) : ?>
						<article class="xciv-activity-row">
							<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span>S</span></span>
							<div>
								<p>
									<strong><?php esc_html_e( 'Super Ninety Four Events', 'xciv-social' ); ?></strong>
									<?php esc_html_e( 'opened purchases for Harrisburg to Lynn.', 'xciv-social' ); ?>
								</p>
								<small class="xciv-muted">
									<?php
									printf(
										/* translators: %s: trip meta line */
										esc_html__( 'Event · %s', 'xciv-social' ),
										esc_html( (string) $upcoming_trips[0]['meta'] )
									);
									?>
								</small>
							</div>
						</article>
					<?php endif; ?>
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
					<?php if ( $upcoming_trips ) : ?>
						<?php foreach ( $upcoming_trips as $trip ) : ?>
							<article class="xciv-dashboard-schedule__item">
								<div class="xciv-event-card__date" aria-hidden="true">
									<span class="xciv-event-card__month"><?php echo esc_html( (string) $trip['month'] ); ?></span>
									<span class="xciv-event-card__day"><?php echo esc_html( (string) $trip['day'] ); ?></span>
								</div>
								<div>
									<p class="xciv-muted xciv-dashboard-schedule__meta"><?php echo esc_html( (string) $trip['meta'] ); ?></p>
									<strong><?php echo esc_html( (string) $trip['title'] ); ?></strong>
									<p class="xciv-muted">
										<?php
										echo esc_html(
											! empty( $trip['paid'] )
												? __( 'Paid · Every 4 months', 'xciv-social' )
												: __( 'Private · Monthly Saturday', 'xciv-social' )
										);
										?>
									</p>
								</div>
							</article>
						<?php endforeach; ?>
					<?php else : ?>
						<p class="xciv-muted"><?php esc_html_e( 'No upcoming events scheduled.', 'xciv-social' ); ?></p>
					<?php endif; ?>
				</div>
			</section>

			<section class="xciv-panel xciv-dashboard__calendar" data-panel="calendar">
				<header class="xciv-panel__head xciv-dashboard__panel-head">
					<div>
						<h2 class="xciv-panel__title"><?php esc_html_e( 'Calendar', 'xciv-social' ); ?></h2>
						<p class="xciv-panel__desc"><?php echo esc_html( (string) $mini_cal['label'] ); ?></p>
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
						<h2 class="xciv-panel__title"><?php esc_html_e( 'Attendee chats', 'xciv-social' ); ?></h2>
						<p class="xciv-panel__desc"><?php esc_html_e( 'Radically honest updates for people coming.', 'xciv-social' ); ?></p>
					</div>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/messages/' ) ); ?>"><?php esc_html_e( 'Inbox', 'xciv-social' ); ?></a>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-dashboard-threads">
						<?php foreach ( $attendee_chats as $chat ) : ?>
							<li>
								<a class="xciv-dashboard-threads__link" href="<?php echo esc_url( home_url( '/messages/?chat=' . rawurlencode( (string) $chat['id'] ) ) ); ?>">
									<span class="xciv-avatar xciv-avatar--sm xciv-avatar--group" aria-hidden="true"><span><?php echo esc_html( (string) $chat['initial'] ); ?></span></span>
									<span class="xciv-dashboard-threads__copy">
										<strong><?php echo esc_html( (string) $chat['name'] ); ?></strong>
										<small class="xciv-muted"><?php echo esc_html( (string) $chat['preview'] ); ?></small>
									</span>
									<?php if ( ! empty( $chat['unread'] ) ) : ?>
										<span class="xciv-dashboard-threads__badge"><?php echo esc_html( (string) (int) $chat['unread'] ); ?></span>
									<?php endif; ?>
								</a>
							</li>
						<?php endforeach; ?>
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

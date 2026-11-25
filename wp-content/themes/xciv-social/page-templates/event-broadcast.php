<?php
/**
 * Template Name: Event Broadcast
 * Live online room: Google Meet stage, polls, live feed, and Q&A.
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\OnlineEventFunnel;

get_header();

$event     = OnlineEventFunnel::event();
$poll      = OnlineEventFunnel::sample_poll();
$questions = OnlineEventFunnel::sample_questions();
$feed      = OnlineEventFunnel::sample_feed();
$meet_url  = (string) $event['meet_url'];
$has_meet  = OnlineEventFunnel::is_allowed_meet_url( $meet_url );

// phpcs:disable WordPress.Security.NonceVerification.Recommended
$attendee = isset( $_GET['name'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['name'] ) ) : '';
// phpcs:enable WordPress.Security.NonceVerification.Recommended
if ( ! $attendee && is_user_logged_in() ) {
	$user = wp_get_current_user();
	$attendee = $user->display_name ?: $user->user_login;
}
if ( ! $attendee ) {
	$attendee = __( 'Guest', 'xciv-social' );
}
?>
<main
	id="main"
	class="xciv-shell xciv-funnel xciv-funnel--broadcast"
	data-xciv-event-broadcast
	data-attendee="<?php echo esc_attr( $attendee ); ?>"
	data-meet-url="<?php echo esc_attr( $meet_url ); ?>"
>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<p class="xciv-funnel__eyebrow xciv-funnel__eyebrow--inline">
				<span class="xciv-live-dot" aria-hidden="true"></span>
				<?php esc_html_e( 'Live broadcast', 'xciv-social' ); ?>
			</p>
			<h1><?php echo esc_html( (string) $event['title'] ); ?></h1>
			<p>
				<?php
				printf(
					/* translators: 1: date, 2: time, 3: host */
					esc_html__( '%1$s · %2$s · Hosted by %3$s', 'xciv-social' ),
					esc_html( (string) $event['date_label'] ),
					esc_html( (string) $event['time_label'] ),
					esc_html( (string) $event['host_short'] )
				);
				?>
			</p>
		</div>
		<div class="xciv-section-head__actions">
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( (string) $event['sales_path'] ) ); ?>"><?php esc_html_e( 'Sales page', 'xciv-social' ); ?></a>
			<?php if ( $has_meet ) : ?>
				<a class="xciv-btn xciv-btn--primary" href="<?php echo esc_url( $meet_url ); ?>" target="_blank" rel="noopener noreferrer" data-join-meet><?php esc_html_e( 'Join Google Meet', 'xciv-social' ); ?></a>
			<?php endif; ?>
		</div>
	</header>

	<section class="xciv-panel xciv-meet-config" aria-labelledby="xciv-meet-config-heading">
		<header class="xciv-panel__head">
			<h2 id="xciv-meet-config-heading" class="xciv-panel__title"><?php esc_html_e( 'Embed Google Meet', 'xciv-social' ); ?></h2>
			<p class="xciv-panel__desc"><?php esc_html_e( 'Paste a meet.google.com link — the video block below lights up with a join stage for your attendees.', 'xciv-social' ); ?></p>
		</header>
		<div class="xciv-panel__body">
			<form class="xciv-meet-config__form" data-meet-form action="" method="get">
				<label for="xciv-meet-input">
					<span class="screen-reader-text"><?php esc_html_e( 'Google Meet URL', 'xciv-social' ); ?></span>
					<input
						id="xciv-meet-input"
						type="url"
						name="meet"
						placeholder="https://meet.google.com/abc-defg-hij"
						value="<?php echo esc_attr( $has_meet ? $meet_url : '' ); ?>"
						data-meet-input
						required
					>
				</label>
				<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Apply Meet link', 'xciv-social' ); ?></button>
			</form>
		</div>
	</section>

	<div class="xciv-broadcast__layout">
		<section class="xciv-broadcast__stage" aria-labelledby="xciv-stage-heading">
			<h2 id="xciv-stage-heading" class="screen-reader-text"><?php esc_html_e( 'Video stage', 'xciv-social' ); ?></h2>
			<div class="xciv-meet-stage<?php echo $has_meet ? ' is-ready' : ' is-empty'; ?>" data-meet-stage>
				<?php if ( $has_meet ) : ?>
					<div class="xciv-meet-stage__frame">
						<div class="xciv-meet-stage__glow" aria-hidden="true"></div>
						<div class="xciv-meet-stage__card">
							<p class="xciv-meet-stage__brand"><?php esc_html_e( 'Google Meet', 'xciv-social' ); ?></p>
							<p class="xciv-meet-stage__title"><?php echo esc_html( (string) $event['title'] ); ?></p>
							<p class="xciv-meet-stage__url"><?php echo esc_html( $meet_url ); ?></p>
							<a class="xciv-btn xciv-btn--primary" href="<?php echo esc_url( $meet_url ); ?>" target="_blank" rel="noopener noreferrer" data-join-meet>
								<?php esc_html_e( 'Enter the room', 'xciv-social' ); ?>
							</a>
							<p class="xciv-muted xciv-meet-stage__note"><?php esc_html_e( 'Meet opens in a new tab. Keep this page open for polls, live feed, and Q&A.', 'xciv-social' ); ?></p>
						</div>
					</div>
				<?php else : ?>
					<div class="xciv-meet-stage__empty">
						<p><?php esc_html_e( 'No Meet link yet — paste one above to activate the video block.', 'xciv-social' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<aside class="xciv-broadcast__side">
			<div class="xciv-broadcast__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Broadcast tools', 'xciv-social' ); ?>" data-broadcast-tabs>
				<button type="button" class="xciv-broadcast__tab is-active" role="tab" aria-selected="true" data-tab="poll"><?php esc_html_e( 'Polls', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-broadcast__tab" role="tab" aria-selected="false" data-tab="feed"><?php esc_html_e( 'Live feed', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-broadcast__tab" role="tab" aria-selected="false" data-tab="qa"><?php esc_html_e( 'Q&A', 'xciv-social' ); ?></button>
			</div>

			<section class="xciv-panel xciv-broadcast-panel is-active" data-panel="poll" role="tabpanel">
				<header class="xciv-panel__head">
					<h3 class="xciv-panel__title"><?php echo esc_html( (string) $poll['question'] ); ?></h3>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-poll" data-poll data-poll-id="<?php echo esc_attr( (string) $poll['id'] ); ?>">
						<?php
						$total_votes = 0;
						foreach ( $poll['options'] as $opt ) {
							$total_votes += (int) $opt['votes'];
						}
						?>
						<ul class="xciv-poll__options">
							<?php foreach ( $poll['options'] as $opt ) : ?>
								<?php
								$votes = (int) $opt['votes'];
								$pct   = $total_votes > 0 ? (int) round( ( $votes / $total_votes ) * 100 ) : 0;
								?>
								<li>
									<label class="xciv-poll__option">
										<input type="radio" name="poll_option" value="<?php echo esc_attr( (string) $opt['id'] ); ?>" data-option-id="<?php echo esc_attr( (string) $opt['id'] ); ?>">
										<span class="xciv-poll__label"><?php echo esc_html( (string) $opt['label'] ); ?></span>
										<span class="xciv-poll__bar" aria-hidden="true"><span style="--poll-pct: <?php echo esc_attr( (string) $pct ); ?>%" data-poll-bar="<?php echo esc_attr( (string) $opt['id'] ); ?>"></span></span>
										<span class="xciv-poll__count" data-poll-count="<?php echo esc_attr( (string) $opt['id'] ); ?>" data-votes="<?php echo esc_attr( (string) $votes ); ?>"><?php echo esc_html( (string) $pct ); ?>%</span>
									</label>
								</li>
							<?php endforeach; ?>
						</ul>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Submit vote', 'xciv-social' ); ?></button>
						<p class="xciv-muted" data-poll-status hidden></p>
					</form>
				</div>
			</section>

			<section class="xciv-panel xciv-broadcast-panel" data-panel="feed" role="tabpanel" hidden>
				<header class="xciv-panel__head">
					<h3 class="xciv-panel__title"><?php esc_html_e( 'Live feed', 'xciv-social' ); ?></h3>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Room chat while the Meet is running.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-live-feed">
					<ul class="xciv-live-feed__list" data-feed-list>
						<?php foreach ( $feed as $item ) : ?>
							<li class="xciv-live-feed__item<?php echo ! empty( $item['host'] ) ? ' is-host' : ''; ?>">
								<strong><?php echo esc_html( (string) $item['author'] ); ?></strong>
								<span class="xciv-muted"><?php echo esc_html( (string) $item['time'] ); ?></span>
								<p><?php echo esc_html( (string) $item['text'] ); ?></p>
							</li>
						<?php endforeach; ?>
					</ul>
					<form class="xciv-live-feed__composer" data-feed-form>
						<label class="screen-reader-text" for="xciv-feed-input"><?php esc_html_e( 'Message', 'xciv-social' ); ?></label>
						<input id="xciv-feed-input" type="text" maxlength="280" placeholder="<?php esc_attr_e( 'Say something to the room…', 'xciv-social' ); ?>" data-feed-input required>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Send', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>

			<section class="xciv-panel xciv-broadcast-panel" data-panel="qa" role="tabpanel" hidden>
				<header class="xciv-panel__head">
					<h3 class="xciv-panel__title"><?php esc_html_e( 'Q&A', 'xciv-social' ); ?></h3>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Upvote questions for the host.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-qa">
					<ul class="xciv-qa__list" data-qa-list>
						<?php foreach ( $questions as $q ) : ?>
							<li class="xciv-qa__item" data-qa-id="<?php echo esc_attr( (string) $q['id'] ); ?>">
								<button type="button" class="xciv-qa__vote" data-qa-vote aria-label="<?php esc_attr_e( 'Upvote question', 'xciv-social' ); ?>">
									<span aria-hidden="true">▲</span>
									<span data-qa-votes><?php echo esc_html( (string) $q['votes'] ); ?></span>
								</button>
								<div>
									<p><?php echo esc_html( (string) $q['text'] ); ?></p>
									<span class="xciv-muted"><?php echo esc_html( (string) $q['author'] ); ?></span>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
					<form class="xciv-qa__composer" data-qa-form>
						<label class="screen-reader-text" for="xciv-qa-input"><?php esc_html_e( 'Your question', 'xciv-social' ); ?></label>
						<textarea id="xciv-qa-input" rows="2" maxlength="400" placeholder="<?php esc_attr_e( 'Ask the host…', 'xciv-social' ); ?>" data-qa-input required></textarea>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Ask', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>
		</aside>
	</div>
</main>
<?php
get_footer();

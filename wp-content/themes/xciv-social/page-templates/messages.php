<?php
/**
 * Template Name: Messages
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Support\AttendeeChats;

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$me_name      = $current_user->display_name ? $current_user->display_name : __( 'You', 'xciv-social' );
$me_initial   = strtoupper( substr( $me_name, 0, 1 ) );

$threads      = AttendeeChats::threads();
$requested    = isset( $_GET['chat'] ) ? sanitize_key( wp_unslash( (string) $_GET['chat'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$active_id    = $requested && AttendeeChats::by_id( $requested ) ? $requested : (string) ( $threads[0]['id'] ?? '' );
$active       = AttendeeChats::by_id( $active_id ) ?: ( $threads[0] ?? null );
?>
<main id="main" class="xciv-shell xciv-messages xciv-messages--ig" data-xciv-messages data-me-initial="<?php echo esc_attr( $me_initial ); ?>">
	<div class="xciv-dm" data-dm>
		<aside class="xciv-dm__inbox" data-message-inbox>
			<header class="xciv-dm__inbox-head">
				<div>
					<h1><?php esc_html_e( 'Messages', 'xciv-social' ); ?></h1>
					<p class="xciv-muted"><?php esc_html_e( 'Attendee group chats · stay updated', 'xciv-social' ); ?></p>
				</div>
				<button type="button" class="xciv-icon-btn" data-compose aria-label="<?php esc_attr_e( 'New message', 'xciv-social' ); ?>">
					<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 5v14M5 12h14"/>
					</svg>
				</button>
			</header>

			<label class="xciv-dm__search">
				<span class="screen-reader-text"><?php esc_html_e( 'Search messages', 'xciv-social' ); ?></span>
				<input type="search" name="q" placeholder="<?php esc_attr_e( 'Search attendee chats', 'xciv-social' ); ?>" data-inbox-search>
			</label>

			<p class="xciv-dm__section-label"><?php esc_html_e( 'Event attendees', 'xciv-social' ); ?></p>

			<ul class="xciv-dm__threads" data-thread-list>
				<?php foreach ( $threads as $thread ) : ?>
					<?php
					$is_active = (string) $thread['id'] === $active_id;
					$unread    = (int) ( $thread['unread'] ?? 0 );
					if ( $is_active ) {
						$unread = 0;
					}
					?>
					<li
						class="xciv-dm__thread<?php echo $is_active ? ' is-active' : ''; ?><?php echo $unread ? ' has-unread' : ''; ?><?php echo ! empty( $thread['group'] ) ? ' is-group' : ''; ?>"
						data-thread-id="<?php echo esc_attr( (string) $thread['id'] ); ?>"
						data-thread-name="<?php echo esc_attr( (string) $thread['name'] ); ?>"
						data-thread-meta="<?php echo esc_attr( (string) $thread['meta'] ); ?>"
						data-thread-online="<?php echo ! empty( $thread['online'] ) ? '1' : '0'; ?>"
						data-thread-group="<?php echo ! empty( $thread['group'] ) ? '1' : '0'; ?>"
						data-thread-messages="<?php echo esc_attr( wp_json_encode( $thread['messages'] ) ); ?>"
					>
						<span class="xciv-dm__avatar-wrap">
							<span class="xciv-avatar xciv-avatar--group" aria-hidden="true"><span><?php echo esc_html( (string) $thread['initial'] ); ?></span></span>
							<?php if ( ! empty( $thread['online'] ) ) : ?>
								<span class="xciv-dm__online" aria-hidden="true"></span>
							<?php endif; ?>
						</span>
						<span class="xciv-dm__thread-copy">
							<span class="xciv-dm__thread-top">
								<strong><?php echo esc_html( (string) $thread['name'] ); ?></strong>
								<time><?php echo esc_html( (string) $thread['time'] ); ?></time>
							</span>
							<small><?php echo esc_html( (string) $thread['preview'] ); ?></small>
						</span>
						<?php if ( $unread ) : ?>
							<span class="xciv-dm__badge"><?php echo esc_html( (string) $unread ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</aside>

		<section class="xciv-dm__box is-open" data-message-box aria-label="<?php esc_attr_e( 'Attendee conversation', 'xciv-social' ); ?>">
			<header class="xciv-dm__box-head">
				<button type="button" class="xciv-icon-btn xciv-dm__back" data-dm-back aria-label="<?php esc_attr_e( 'Back to inbox', 'xciv-social' ); ?>">
					<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
						<path d="M15 6l-6 6 6 6"/>
					</svg>
				</button>
				<div class="xciv-dm__peer">
					<span class="xciv-dm__avatar-wrap">
						<span class="xciv-avatar xciv-avatar--group" aria-hidden="true" data-thread-avatar><span><?php echo esc_html( (string) ( $active['initial'] ?? 'A' ) ); ?></span></span>
						<span class="xciv-dm__online" data-thread-online-dot aria-hidden="true" <?php echo empty( $active['online'] ) ? 'hidden' : ''; ?>></span>
					</span>
					<div>
						<h2 data-thread-title><?php echo esc_html( (string) ( $active['name'] ?? __( 'Attendees', 'xciv-social' ) ) ); ?></h2>
						<p class="xciv-muted" data-thread-meta>
							<?php
							echo esc_html(
								! empty( $active['online'] )
									? __( 'Active now · ', 'xciv-social' ) . (string) ( $active['meta'] ?? '' )
									: (string) ( $active['meta'] ?? '' )
							);
							?>
						</p>
					</div>
				</div>
				<button type="button" class="xciv-icon-btn" data-thread-info aria-label="<?php esc_attr_e( 'Conversation details', 'xciv-social' ); ?>">
					<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="9"/><path d="M12 10v6M12 7.5h.01"/>
					</svg>
				</button>
			</header>

			<div class="xciv-dm__pin" data-chat-pin>
				<strong><?php esc_html_e( 'House rule', 'xciv-social' ); ?></strong>
				<span class="xciv-muted"><?php esc_html_e( 'Highly engaged. Radically honest. Keep people updated on what is actually happening — no performance, no fluff.', 'xciv-social' ); ?></span>
			</div>

			<div class="xciv-dm__messages" data-thread-messages>
				<div class="xciv-dm__day"><span><?php esc_html_e( 'Today', 'xciv-social' ); ?></span></div>
				<?php if ( $active && ! empty( $active['messages'] ) ) : ?>
					<?php foreach ( $active['messages'] as $message ) : ?>
						<article class="xciv-bubble <?php echo ! empty( $message['mine'] ) ? 'xciv-bubble--mine' : 'xciv-bubble--theirs'; ?>">
							<?php if ( empty( $message['mine'] ) && ! empty( $message['from'] ) ) : ?>
								<span class="xciv-bubble__from"><?php echo esc_html( (string) $message['from'] ); ?></span>
							<?php endif; ?>
							<p><?php echo esc_html( (string) $message['text'] ); ?></p>
							<small class="xciv-muted"><?php echo esc_html( (string) $message['time'] ); ?></small>
						</article>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<footer class="xciv-dm__composer" data-message-composer>
				<label for="xciv-message-body" class="screen-reader-text"><?php esc_html_e( 'Write a message', 'xciv-social' ); ?></label>
				<div class="xciv-dm__composer-pill">
					<textarea id="xciv-message-body" rows="1" placeholder="<?php esc_attr_e( 'Say it straight…', 'xciv-social' ); ?>" data-message-body></textarea>
					<button type="button" class="xciv-dm__send" data-send-message><?php esc_html_e( 'Send', 'xciv-social' ); ?></button>
				</div>
			</footer>
		</section>
	</div>
</main>
<?php
get_footer();

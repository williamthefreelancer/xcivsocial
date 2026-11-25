<?php
/**
 * Template Name: Messages
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$me_name      = $current_user->display_name ? $current_user->display_name : __( 'You', 'xciv-social' );
$me_initial   = strtoupper( substr( $me_name, 0, 1 ) );

$threads = array(
	array(
		'id'       => 't1',
		'name'     => 'Maya Okonkwo',
		'initial'  => 'M',
		'preview'  => 'Can you intro me to that Lagos corridor team?',
		'time'     => '2m',
		'unread'   => 2,
		'online'   => true,
		'active'   => true,
		'meta'     => 'Fintech · Lagos',
		'messages' => array(
			array( 'mine' => false, 'text' => 'William — saw your note on West Africa corridors. Timing is good.', 'time' => '10:12 AM' ),
			array( 'mine' => true, 'text' => 'Glad it landed. Who should I connect you with first?', 'time' => '10:14 AM' ),
			array( 'mine' => false, 'text' => 'Can you intro me to that Lagos corridor team?', 'time' => '10:16 AM' ),
		),
	),
	array(
		'id'       => 't2',
		'name'     => 'Jonah Reyes',
		'initial'  => 'J',
		'preview'  => 'Table dinner seats are almost gone.',
		'time'     => '1h',
		'unread'   => 0,
		'online'   => true,
		'active'   => false,
		'meta'     => 'Hospitality · Miami',
		'messages' => array(
			array( 'mine' => false, 'text' => 'Still good for Dec 4?', 'time' => 'Yesterday' ),
			array( 'mine' => true, 'text' => 'Confirmed. I’ll bring one intro-ready guest.', 'time' => 'Yesterday' ),
			array( 'mine' => false, 'text' => 'Table dinner seats are almost gone.', 'time' => '1h ago' ),
		),
	),
	array(
		'id'       => 't3',
		'name'     => 'Amira Haddad',
		'initial'  => 'A',
		'preview'  => 'Sending Elise’s note over.',
		'time'     => 'Yesterday',
		'unread'   => 1,
		'online'   => false,
		'active'   => false,
		'meta'     => 'Media · Dubai',
		'messages' => array(
			array( 'mine' => false, 'text' => 'Elise is open to GCC logistics operators only.', 'time' => 'Yesterday' ),
			array( 'mine' => true, 'text' => 'Understood — keep it selective.', 'time' => 'Yesterday' ),
			array( 'mine' => false, 'text' => 'Sending Elise’s note over.', 'time' => 'Yesterday' ),
		),
	),
	array(
		'id'       => 't4',
		'name'     => 'Theo Marchand',
		'initial'  => 'T',
		'preview'  => 'Draft memo attached for review.',
		'time'     => 'Mon',
		'unread'   => 0,
		'online'   => false,
		'active'   => false,
		'meta'     => 'Climate tech · Montréal',
		'messages' => array(
			array( 'mine' => true, 'text' => 'Liked the closed-loop capital framing.', 'time' => 'Mon' ),
			array( 'mine' => false, 'text' => 'Draft memo attached for review.', 'time' => 'Mon' ),
		),
	),
	array(
		'id'       => 't5',
		'name'     => 'Sofia Berg',
		'initial'  => 'S',
		'preview'  => 'London salon invite is ready.',
		'time'     => 'Sun',
		'unread'   => 0,
		'online'   => false,
		'active'   => false,
		'meta'     => 'Design ops · Stockholm',
		'messages' => array(
			array( 'mine' => false, 'text' => 'London salon invite is ready.', 'time' => 'Sun' ),
			array( 'mine' => true, 'text' => 'Send it — I’ll RSVP tonight.', 'time' => 'Sun' ),
		),
	),
);
?>
<main id="main" class="xciv-shell xciv-messages xciv-messages--ig" data-xciv-messages data-me-initial="<?php echo esc_attr( $me_initial ); ?>">
	<div class="xciv-dm" data-dm>
		<aside class="xciv-dm__inbox" data-message-inbox>
			<header class="xciv-dm__inbox-head">
				<div>
					<h1><?php esc_html_e( 'Messages', 'xciv-social' ); ?></h1>
					<p class="xciv-muted"><?php echo esc_html( $me_name ); ?></p>
				</div>
				<button type="button" class="xciv-icon-btn" data-compose aria-label="<?php esc_attr_e( 'New message', 'xciv-social' ); ?>">
					<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 5v14M5 12h14"/>
					</svg>
				</button>
			</header>

			<label class="xciv-dm__search">
				<span class="screen-reader-text"><?php esc_html_e( 'Search messages', 'xciv-social' ); ?></span>
				<input type="search" name="q" placeholder="<?php esc_attr_e( 'Search', 'xciv-social' ); ?>" data-inbox-search>
			</label>

			<ul class="xciv-dm__threads" data-thread-list>
				<?php foreach ( $threads as $thread ) : ?>
					<li
						class="xciv-dm__thread<?php echo ! empty( $thread['active'] ) ? ' is-active' : ''; ?><?php echo $thread['unread'] ? ' has-unread' : ''; ?>"
						data-thread-id="<?php echo esc_attr( $thread['id'] ); ?>"
						data-thread-name="<?php echo esc_attr( $thread['name'] ); ?>"
						data-thread-meta="<?php echo esc_attr( $thread['meta'] ); ?>"
						data-thread-online="<?php echo ! empty( $thread['online'] ) ? '1' : '0'; ?>"
						data-thread-messages="<?php echo esc_attr( wp_json_encode( $thread['messages'] ) ); ?>"
					>
						<span class="xciv-dm__avatar-wrap">
							<span class="xciv-avatar" aria-hidden="true"><span><?php echo esc_html( $thread['initial'] ); ?></span></span>
							<?php if ( ! empty( $thread['online'] ) ) : ?>
								<span class="xciv-dm__online" aria-hidden="true"></span>
							<?php endif; ?>
						</span>
						<span class="xciv-dm__thread-copy">
							<span class="xciv-dm__thread-top">
								<strong><?php echo esc_html( $thread['name'] ); ?></strong>
								<time><?php echo esc_html( $thread['time'] ); ?></time>
							</span>
							<small><?php echo esc_html( $thread['preview'] ); ?></small>
						</span>
						<?php if ( $thread['unread'] ) : ?>
							<span class="xciv-dm__badge"><?php echo esc_html( (string) $thread['unread'] ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</aside>

		<section class="xciv-dm__box is-open" data-message-box aria-label="<?php esc_attr_e( 'Conversation', 'xciv-social' ); ?>">
			<header class="xciv-dm__box-head">
				<button type="button" class="xciv-icon-btn xciv-dm__back" data-dm-back aria-label="<?php esc_attr_e( 'Back to inbox', 'xciv-social' ); ?>">
					<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
						<path d="M15 6l-6 6 6 6"/>
					</svg>
				</button>
				<div class="xciv-dm__peer">
					<span class="xciv-dm__avatar-wrap">
						<span class="xciv-avatar" aria-hidden="true" data-thread-avatar><span>M</span></span>
						<span class="xciv-dm__online" data-thread-online-dot aria-hidden="true"></span>
					</span>
					<div>
						<h2 data-thread-title><?php esc_html_e( 'Maya Okonkwo', 'xciv-social' ); ?></h2>
						<p class="xciv-muted" data-thread-meta><?php esc_html_e( 'Active now · Fintech · Lagos', 'xciv-social' ); ?></p>
					</div>
				</div>
				<button type="button" class="xciv-icon-btn" data-thread-info aria-label="<?php esc_attr_e( 'Conversation details', 'xciv-social' ); ?>">
					<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="9"/><path d="M12 10v6M12 7.5h.01"/>
					</svg>
				</button>
			</header>

			<div class="xciv-dm__messages" data-thread-messages>
				<div class="xciv-dm__day"><span><?php esc_html_e( 'Today', 'xciv-social' ); ?></span></div>
				<?php foreach ( $threads[0]['messages'] as $message ) : ?>
					<article class="xciv-bubble <?php echo ! empty( $message['mine'] ) ? 'xciv-bubble--mine' : 'xciv-bubble--theirs'; ?>">
						<p><?php echo esc_html( $message['text'] ); ?></p>
						<small class="xciv-muted"><?php echo esc_html( $message['time'] ); ?></small>
					</article>
				<?php endforeach; ?>
			</div>

			<footer class="xciv-dm__composer" data-message-composer>
				<label for="xciv-message-body" class="screen-reader-text"><?php esc_html_e( 'Write a message', 'xciv-social' ); ?></label>
				<div class="xciv-dm__composer-pill">
					<textarea id="xciv-message-body" rows="1" placeholder="<?php esc_attr_e( 'Message…', 'xciv-social' ); ?>" data-message-body></textarea>
					<button type="button" class="xciv-dm__send" data-send-message><?php esc_html_e( 'Send', 'xciv-social' ); ?></button>
				</div>
			</footer>
		</section>
	</div>
</main>
<?php
get_footer();

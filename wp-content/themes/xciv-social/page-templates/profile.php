<?php
/**
 * Template Name: Member Profile
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : __( 'Member', 'xciv-social' );
$initial      = strtoupper( substr( $display_name, 0, 1 ) );
?>
<main id="main" class="xciv-shell xciv-profile" data-xciv-profile>
	<section class="xciv-profile-hero">
		<div class="xciv-profile-hero__banner" aria-hidden="true"></div>
		<div class="xciv-profile-hero__inner">
			<div class="xciv-avatar xciv-avatar--xl" aria-hidden="true">
				<span><?php echo esc_html( $initial ); ?></span>
			</div>
			<div class="xciv-profile-hero__copy">
				<p class="xciv-profile-hero__eyebrow xciv-muted"><?php esc_html_e( 'Approved member', 'xciv-social' ); ?></p>
				<h1><?php echo esc_html( $display_name ); ?></h1>
				<p class="xciv-profile-hero__headline"><?php esc_html_e( 'Network operator · Strategy & introductions', 'xciv-social' ); ?></p>
				<p class="xciv-muted"><?php esc_html_e( 'Consulting · New York · Open to intros', 'xciv-social' ); ?></p>
				<ul class="xciv-profile-stats">
					<li><strong>48</strong><span class="xciv-muted"><?php esc_html_e( 'People', 'xciv-social' ); ?></span></li>
					<li><strong>12</strong><span class="xciv-muted"><?php esc_html_e( 'Posts', 'xciv-social' ); ?></span></li>
					<li><strong>3</strong><span class="xciv-muted"><?php esc_html_e( 'Events hosted', 'xciv-social' ); ?></span></li>
				</ul>
				<div class="xciv-action-row">
					<a class="xciv-btn xciv-btn--primary" href="<?php echo esc_url( home_url( '/messages/' ) ); ?>"><?php esc_html_e( 'Message', 'xciv-social' ); ?></a>
					<button type="button" class="xciv-btn" data-connect><?php esc_html_e( 'Connect', 'xciv-social' ); ?></button>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/profile-settings/' ) ); ?>"><?php esc_html_e( 'Edit profile', 'xciv-social' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<div class="xciv-profile__layout">
		<aside class="xciv-profile__aside">
			<section class="xciv-panel">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Details', 'xciv-social' ); ?></h2>
				</header>
				<div class="xciv-panel__body">
					<dl class="xciv-detail-list">
						<div>
							<dt><?php esc_html_e( 'Company', 'xciv-social' ); ?></dt>
							<dd><?php esc_html_e( 'XCIV Advisory', 'xciv-social' ); ?></dd>
						</div>
						<div>
							<dt><?php esc_html_e( 'Markets', 'xciv-social' ); ?></dt>
							<dd><?php esc_html_e( 'US · EU · GCC', 'xciv-social' ); ?></dd>
						</div>
						<div>
							<dt><?php esc_html_e( 'Languages', 'xciv-social' ); ?></dt>
							<dd><?php esc_html_e( 'English, French', 'xciv-social' ); ?></dd>
						</div>
						<div>
							<dt><?php esc_html_e( 'Member since', 'xciv-social' ); ?></dt>
							<dd><?php esc_html_e( '2025', 'xciv-social' ); ?></dd>
						</div>
					</dl>
				</div>
			</section>

			<section class="xciv-panel">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Focus', 'xciv-social' ); ?></h2>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-tag-row">
						<li><?php esc_html_e( 'Introductions', 'xciv-social' ); ?></li>
						<li><?php esc_html_e( 'Operator capital', 'xciv-social' ); ?></li>
						<li><?php esc_html_e( 'Private dinners', 'xciv-social' ); ?></li>
						<li><?php esc_html_e( 'Hospitality', 'xciv-social' ); ?></li>
					</ul>
				</div>
			</section>
		</aside>

		<div class="xciv-profile__main">
			<section class="xciv-panel">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'About', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'How this member operates and what they bring.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-profile-about">
					<p><?php esc_html_e( 'I help operators make high-trust introductions inside closed rooms — dinners, roundtables, and selective capital conversations. Prefer contribution over spectacle.', 'xciv-social' ); ?></p>
					<div class="xciv-profile-split">
						<div>
							<h3><?php esc_html_e( 'What I bring', 'xciv-social' ); ?></h3>
							<p class="xciv-muted"><?php esc_html_e( 'Warm intros across hospitality, fintech, and private credit. Pattern recognition for who should meet whom.', 'xciv-social' ); ?></p>
						</div>
						<div>
							<h3><?php esc_html_e( 'What I seek', 'xciv-social' ); ?></h3>
							<p class="xciv-muted"><?php esc_html_e( 'Operators with clear asks, members who host well, and partners who follow through after the room.', 'xciv-social' ); ?></p>
						</div>
					</div>
				</div>
			</section>

			<section class="xciv-panel">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Activity', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Recent posts and hosted events.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body xciv-profile-activity">
					<article class="xciv-activity-row">
						<span class="xciv-feed-item__badge"><?php esc_html_e( 'Idea', 'xciv-social' ); ?></span>
						<div>
							<p><?php esc_html_e( 'Shared a thesis on closed-room capital vs open venture theater.', 'xciv-social' ); ?></p>
							<small class="xciv-muted"><?php esc_html_e( '2 days ago · 21 appreciations', 'xciv-social' ); ?></small>
						</div>
					</article>
					<article class="xciv-activity-row">
						<span class="xciv-feed-item__badge"><?php esc_html_e( 'Event', 'xciv-social' ); ?></span>
						<div>
							<p><?php esc_html_e( 'Hosting Corridor Operators Roundtable — Dec 16, Lagos.', 'xciv-social' ); ?></p>
							<small class="xciv-muted"><?php esc_html_e( '11 going', 'xciv-social' ); ?></small>
						</div>
					</article>
					<article class="xciv-activity-row">
						<span class="xciv-feed-item__badge"><?php esc_html_e( 'Intro', 'xciv-social' ); ?></span>
						<div>
							<p><?php esc_html_e( 'Opened an introduction lane for logistics operators in GCC.', 'xciv-social' ); ?></p>
							<small class="xciv-muted"><?php esc_html_e( 'Yesterday', 'xciv-social' ); ?></small>
						</div>
					</article>
				</div>
			</section>

			<section class="xciv-panel">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'People', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Shared introductions inside the network.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-feed-spotlight">
						<li>
							<span class="xciv-avatar" aria-hidden="true"><span>M</span></span>
							<span class="xciv-feed-spotlight__copy">
								<strong><?php esc_html_e( 'Maya Okonkwo', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Fintech · Lagos', 'xciv-social' ); ?></small>
							</span>
						</li>
						<li>
							<span class="xciv-avatar" aria-hidden="true"><span>J</span></span>
							<span class="xciv-feed-spotlight__copy">
								<strong><?php esc_html_e( 'Jonah Reyes', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Hospitality · Miami', 'xciv-social' ); ?></small>
							</span>
						</li>
						<li>
							<span class="xciv-avatar" aria-hidden="true"><span>A</span></span>
							<span class="xciv-feed-spotlight__copy">
								<strong><?php esc_html_e( 'Amira Haddad', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Media · Dubai', 'xciv-social' ); ?></small>
							</span>
						</li>
					</ul>
					<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/people/' ) ); ?>"><?php esc_html_e( 'Browse people', 'xciv-social' ); ?></a>
				</div>
			</section>
		</div>
	</div>
</main>
<?php
get_footer();

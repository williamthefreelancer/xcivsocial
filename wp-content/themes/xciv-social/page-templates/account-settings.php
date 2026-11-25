<?php
/**
 * Template Name: Account Settings
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : __( 'Member', 'xciv-social' );
$initial      = strtoupper( substr( $display_name, 0, 1 ) );
?>
<main id="main" class="xciv-shell xciv-settings xciv-settings--account" data-xciv-account-settings>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Settings', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Account security, notifications, and membership controls.', 'xciv-social' ); ?></p>
		</div>
		<div class="xciv-section-head__actions">
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/profile-settings/' ) ); ?>"><?php esc_html_e( 'Profile settings', 'xciv-social' ); ?></a>
		</div>
	</header>

	<div class="xciv-settings__layout">
		<aside class="xciv-settings__side">
			<div class="xciv-settings__identity">
				<span class="xciv-avatar xciv-avatar--lg" aria-hidden="true"><span><?php echo esc_html( $initial ); ?></span></span>
				<div>
					<strong><?php echo esc_html( $display_name ); ?></strong>
					<small class="xciv-muted"><?php echo esc_html( $current_user->user_email ); ?></small>
				</div>
			</div>
			<nav class="xciv-settings__nav" aria-label="<?php esc_attr_e( 'Settings sections', 'xciv-social' ); ?>" data-settings-nav>
				<a href="#account-login" class="is-active"><?php esc_html_e( 'Login', 'xciv-social' ); ?></a>
				<a href="#account-security"><?php esc_html_e( 'Security', 'xciv-social' ); ?></a>
				<a href="#account-notifications"><?php esc_html_e( 'Notifications', 'xciv-social' ); ?></a>
				<a href="#account-sessions"><?php esc_html_e( 'Sessions', 'xciv-social' ); ?></a>
				<a href="#account-danger"><?php esc_html_e( 'Danger zone', 'xciv-social' ); ?></a>
			</nav>
		</aside>

		<div class="xciv-settings__panels">
			<section class="xciv-panel" id="account-login">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Login', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Email used to access XCIV Social.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-form xciv-form--flush" data-account-login>
						<label>
							<span><?php esc_html_e( 'Email', 'xciv-social' ); ?></span>
							<input type="email" name="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" autocomplete="email">
						</label>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Save email', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>

			<section class="xciv-panel" id="account-security">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Security', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Password and account protection.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-form xciv-form--flush" data-account-security>
						<label>
							<span><?php esc_html_e( 'Current password', 'xciv-social' ); ?></span>
							<input type="password" name="current_password" autocomplete="current-password">
						</label>
						<label>
							<span><?php esc_html_e( 'New password', 'xciv-social' ); ?></span>
							<input type="password" name="new_password" autocomplete="new-password">
						</label>
						<label>
							<span><?php esc_html_e( 'Confirm new password', 'xciv-social' ); ?></span>
							<input type="password" name="new_password_confirm" autocomplete="new-password">
						</label>
						<label class="xciv-check">
							<input type="checkbox" name="two_factor">
							<span><?php esc_html_e( 'Enable two-factor authentication (coming soon)', 'xciv-social' ); ?></span>
						</label>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Update password', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>

			<section class="xciv-panel" id="account-notifications">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Notifications', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Choose what reaches your inbox.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-form xciv-form--flush" data-account-notifications>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="notify_messages" checked>
							<span>
								<strong><?php esc_html_e( 'Direct messages', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Alerts when members write you.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="notify_events" checked>
							<span>
								<strong><?php esc_html_e( 'Event reminders & RSVPs', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Reminders before gatherings you joined.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="notify_connections">
							<span>
								<strong><?php esc_html_e( 'Connection requests', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'When someone wants to connect.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="notify_digest">
							<span>
								<strong><?php esc_html_e( 'Weekly network digest', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'A short weekly pulse of the room.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Save notifications', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>

			<section class="xciv-panel" id="account-sessions">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Sessions', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Devices currently signed in.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<ul class="xciv-session-list">
						<li>
							<div>
								<strong><?php esc_html_e( 'Windows · Chrome', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'This device · Active now', 'xciv-social' ); ?></small>
							</div>
							<span class="xciv-pill"><?php esc_html_e( 'Current', 'xciv-social' ); ?></span>
						</li>
						<li>
							<div>
								<strong><?php esc_html_e( 'iPhone · Safari', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Last active 2 days ago', 'xciv-social' ); ?></small>
							</div>
							<button type="button" class="xciv-btn xciv-btn--ghost" data-revoke-session><?php esc_html_e( 'Sign out', 'xciv-social' ); ?></button>
						</li>
					</ul>
				</div>
			</section>

			<section class="xciv-panel xciv-panel--danger" id="account-danger">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Danger zone', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Irreversible membership actions.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<p class="xciv-muted"><?php esc_html_e( 'Deactivating hides your profile from the directory and pauses messages. Leaving the network permanently removes access.', 'xciv-social' ); ?></p>
					<div class="xciv-action-row">
						<button type="button" class="xciv-btn xciv-btn--ghost" data-deactivate><?php esc_html_e( 'Deactivate membership', 'xciv-social' ); ?></button>
						<button type="button" class="xciv-btn xciv-btn--danger" data-leave-network><?php esc_html_e( 'Leave network', 'xciv-social' ); ?></button>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>
<?php
get_footer();

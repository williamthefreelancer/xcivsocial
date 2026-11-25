<?php
/**
 * Template Name: Profile Settings
 *
 * @package XCIV_Social
 */

get_template_part( 'template-parts/member/require', 'member' );
get_header();

$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : __( 'Member', 'xciv-social' );
$initial      = strtoupper( substr( $display_name, 0, 1 ) );
?>
<main id="main" class="xciv-shell xciv-settings xciv-settings--profile" data-xciv-profile-settings>
	<header class="xciv-section-head xciv-section-head--split">
		<div>
			<h1><?php esc_html_e( 'Profile settings', 'xciv-social' ); ?></h1>
			<p><?php esc_html_e( 'Control how you appear in the directory and on your public profile.', 'xciv-social' ); ?></p>
		</div>
		<div class="xciv-section-head__actions">
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'View profile', 'xciv-social' ); ?></a>
			<a class="xciv-btn xciv-btn--ghost" href="<?php echo esc_url( home_url( '/account-settings/' ) ); ?>"><?php esc_html_e( 'Account settings', 'xciv-social' ); ?></a>
		</div>
	</header>

	<div class="xciv-settings__layout">
		<aside class="xciv-settings__side">
			<div class="xciv-settings__preview">
				<span class="xciv-avatar xciv-avatar--xl" aria-hidden="true"><span><?php echo esc_html( $initial ); ?></span></span>
				<strong data-preview-name><?php echo esc_html( $display_name ); ?></strong>
				<small class="xciv-muted" data-preview-headline><?php esc_html_e( 'Network operator · Strategy & introductions', 'xciv-social' ); ?></small>
			</div>
			<nav class="xciv-settings__nav" aria-label="<?php esc_attr_e( 'Profile settings sections', 'xciv-social' ); ?>" data-settings-nav>
				<a href="#profile-media" class="is-active"><?php esc_html_e( 'Photo', 'xciv-social' ); ?></a>
				<a href="#profile-basics"><?php esc_html_e( 'Basics', 'xciv-social' ); ?></a>
				<a href="#profile-story"><?php esc_html_e( 'Story', 'xciv-social' ); ?></a>
				<a href="#profile-visibility"><?php esc_html_e( 'Visibility', 'xciv-social' ); ?></a>
			</nav>
		</aside>

		<div class="xciv-settings__panels">
			<section class="xciv-panel" id="profile-media">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Photo', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Avatar and optional cover for your profile.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<div class="xciv-media-upload" data-profile-media>
						<div class="xciv-avatar xciv-avatar--xl" aria-hidden="true">
							<span><?php echo esc_html( $initial ); ?></span>
						</div>
						<div class="xciv-media-upload__copy">
							<p class="xciv-muted"><?php esc_html_e( 'Square image, at least 400×400. Members see this across the feed, directory, and messages.', 'xciv-social' ); ?></p>
							<div class="xciv-action-row">
								<button type="button" class="xciv-btn xciv-btn--primary" data-upload-avatar><?php esc_html_e( 'Upload avatar', 'xciv-social' ); ?></button>
								<button type="button" class="xciv-btn xciv-btn--ghost" data-upload-cover><?php esc_html_e( 'Upload cover', 'xciv-social' ); ?></button>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="xciv-panel" id="profile-basics">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Basics', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Name, headline, and operating vertical.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-form xciv-form--flush" data-profile-basics>
						<label>
							<span><?php esc_html_e( 'Display name', 'xciv-social' ); ?></span>
							<input type="text" name="display_name" value="<?php echo esc_attr( $display_name ); ?>" data-sync-preview="name">
						</label>
						<label>
							<span><?php esc_html_e( 'Headline', 'xciv-social' ); ?></span>
							<input type="text" name="headline" value="<?php esc_attr_e( 'Network operator · Strategy & introductions', 'xciv-social' ); ?>" data-sync-preview="headline">
						</label>
						<div class="xciv-form-grid">
							<label>
								<span><?php esc_html_e( 'Vertical', 'xciv-social' ); ?></span>
								<select name="vertical">
									<option value=""><?php esc_html_e( 'Select…', 'xciv-social' ); ?></option>
									<option value="mfo"><?php esc_html_e( 'Multi-family office (MFO)', 'xciv-social' ); ?></option>
									<option value="hospitality"><?php esc_html_e( 'Hospitality management', 'xciv-social' ); ?></option>
									<option value="club_event"><?php esc_html_e( 'Club & event management', 'xciv-social' ); ?></option>
									<option value="nightlife"><?php esc_html_e( 'Nightlife', 'xciv-social' ); ?></option>
									<option value="marketplace"><?php esc_html_e( 'Event & service marketplace', 'xciv-social' ); ?></option>
									<option value="property"><?php esc_html_e( 'Property management', 'xciv-social' ); ?></option>
									<option value="consulting" selected><?php esc_html_e( 'Management consulting', 'xciv-social' ); ?></option>
									<option value="other"><?php esc_html_e( 'Other', 'xciv-social' ); ?></option>
								</select>
							</label>
							<label>
								<span><?php esc_html_e( 'City', 'xciv-social' ); ?></span>
								<input type="text" name="city" value="<?php esc_attr_e( 'New York', 'xciv-social' ); ?>">
							</label>
						</div>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Save basics', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>

			<section class="xciv-panel" id="profile-story">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Story', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'What you bring and what you seek.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-form xciv-form--flush" data-profile-story>
						<label>
							<span><?php esc_html_e( 'About', 'xciv-social' ); ?></span>
							<textarea name="about" rows="5"><?php esc_html_e( 'I help operators make high-trust introductions inside closed rooms — dinners, roundtables, and selective capital conversations.', 'xciv-social' ); ?></textarea>
						</label>
						<label>
							<span><?php esc_html_e( 'What I bring', 'xciv-social' ); ?></span>
							<textarea name="bring" rows="4"><?php esc_html_e( 'Warm intros across hospitality, fintech, and private credit.', 'xciv-social' ); ?></textarea>
						</label>
						<label>
							<span><?php esc_html_e( 'What I seek', 'xciv-social' ); ?></span>
							<textarea name="seek" rows="4"><?php esc_html_e( 'Operators with clear asks and members who follow through after the room.', 'xciv-social' ); ?></textarea>
						</label>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Save story', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>

			<section class="xciv-panel" id="profile-visibility">
				<header class="xciv-panel__head">
					<h2 class="xciv-panel__title"><?php esc_html_e( 'Visibility', 'xciv-social' ); ?></h2>
					<p class="xciv-panel__desc"><?php esc_html_e( 'Who can find and contact you.', 'xciv-social' ); ?></p>
				</header>
				<div class="xciv-panel__body">
					<form class="xciv-form xciv-form--flush" data-profile-visibility>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="show_in_directory" checked>
							<span>
								<strong><?php esc_html_e( 'Appear in member directory', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Approved members can discover your profile.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="allow_messages" checked>
							<span>
								<strong><?php esc_html_e( 'Allow direct messages', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'Members can open a conversation with you.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<label class="xciv-check xciv-check--card">
							<input type="checkbox" name="show_events" checked>
							<span>
								<strong><?php esc_html_e( 'Show hosted events', 'xciv-social' ); ?></strong>
								<small class="xciv-muted"><?php esc_html_e( 'List gatherings you host on your profile.', 'xciv-social' ); ?></small>
							</span>
						</label>
						<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Save visibility', 'xciv-social' ); ?></button>
					</form>
				</div>
			</section>
		</div>
	</div>
</main>
<?php
get_footer();

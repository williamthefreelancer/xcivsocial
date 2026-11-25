<?php
/**
 * Template Name: Admission Intelligence
 *
 * @package XCIV_Social
 */

get_header();
?>
<main id="main" class="xciv-shell xciv-admission">
	<header class="xciv-section-head">
		<h1><?php esc_html_e( 'Admission Intelligence', 'xciv-social' ); ?></h1>
		<p><?php esc_html_e( 'A short process so we can learn who you are, what you build, and whether our standards align. Approval is manual.', 'xciv-social' ); ?></p>
	</header>

	<form id="xciv-admission-form" class="xciv-form" data-xciv-admission novalidate>
		<section class="xciv-step is-active" data-step="1">
			<h2><?php esc_html_e( '1. Identity & profession', 'xciv-social' ); ?></h2>
			<label>
				<span><?php esc_html_e( 'Full name', 'xciv-social' ); ?></span>
				<input type="text" name="full_name" required>
			</label>
			<label>
				<span><?php esc_html_e( 'Email', 'xciv-social' ); ?></span>
				<input type="email" name="email" required>
			</label>
			<label>
				<span><?php esc_html_e( 'Vertical', 'xciv-social' ); ?></span>
				<select name="vertical" required>
					<option value=""><?php esc_html_e( 'Select…', 'xciv-social' ); ?></option>
					<option value="mfo">Multi-family office (MFO)</option>
					<option value="hospitality">Hospitality management</option>
					<option value="club_event">Club &amp; event management</option>
					<option value="nightlife">Nightlife</option>
					<option value="marketplace">Event &amp; service marketplace</option>
					<option value="property">Property management</option>
					<option value="consulting">Management consulting</option>
					<option value="organizer">Party &amp; event organizer</option>
					<option value="partygoer">Partygoer</option>
					<option value="holding">Holding company</option>
					<option value="other">Other</option>
				</select>
			</label>
			<button type="button" class="xciv-btn" data-next><?php esc_html_e( 'Continue', 'xciv-social' ); ?></button>
		</section>

		<section class="xciv-step" data-step="2" hidden>
			<h2><?php esc_html_e( '2. Alignment', 'xciv-social' ); ?></h2>
			<label>
				<span><?php esc_html_e( 'What does full sovereignty mean in how you operate?', 'xciv-social' ); ?></span>
				<textarea name="sovereignty" rows="4" required></textarea>
			</label>
			<label>
				<span><?php esc_html_e( 'Describe the adventurous lifestyle you pursue.', 'xciv-social' ); ?></span>
				<textarea name="lifestyle" rows="4" required></textarea>
			</label>
			<button type="button" class="xciv-btn xciv-btn--ghost" data-prev><?php esc_html_e( 'Back', 'xciv-social' ); ?></button>
			<button type="button" class="xciv-btn" data-next><?php esc_html_e( 'Continue', 'xciv-social' ); ?></button>
		</section>

		<section class="xciv-step" data-step="3" hidden>
			<h2><?php esc_html_e( '3. Contribution', 'xciv-social' ); ?></h2>
			<label>
				<span><?php esc_html_e( 'What do you bring to this network?', 'xciv-social' ); ?></span>
				<textarea name="bring" rows="4" required></textarea>
			</label>
			<label>
				<span><?php esc_html_e( 'What are you seeking?', 'xciv-social' ); ?></span>
				<textarea name="seek" rows="4" required></textarea>
			</label>
			<label>
				<span><?php esc_html_e( 'Proof links (optional)', 'xciv-social' ); ?></span>
				<input type="url" name="proof_url" placeholder="https://">
			</label>
			<button type="button" class="xciv-btn xciv-btn--ghost" data-prev><?php esc_html_e( 'Back', 'xciv-social' ); ?></button>
			<button type="submit" class="xciv-btn xciv-btn--primary"><?php esc_html_e( 'Submit for review', 'xciv-social' ); ?></button>
		</section>

		<p class="xciv-form__status" data-status hidden></p>
	</form>
</main>
<?php
get_footer();

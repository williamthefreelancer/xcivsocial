<?php
/**
 * Template Name: Admission Intelligence
 *
 * @package XCIV_Social
 */

get_header();

$current = wp_get_current_user();
$prefill_name  = '';
$prefill_email = '';
if ( $current instanceof WP_User && $current->exists() ) {
	$prefill_name = trim( $current->first_name . ' ' . $current->last_name );
	if ( '' === $prefill_name ) {
		$prefill_name = (string) $current->display_name;
	}
	$prefill_email = (string) $current->user_email;
}
?>
<main id="main" class="xciv-shell xciv-admission">
	<header class="xciv-section-head xciv-admission__head">
		<p class="xciv-admission__eyebrow"><?php esc_html_e( 'Membership', 'xciv-social' ); ?></p>
		<h1><?php esc_html_e( 'Request admission', 'xciv-social' ); ?></h1>
		<p><?php esc_html_e( 'Four short steps. We review every application by hand and admit people who are a genuine fit — not everyone who applies.', 'xciv-social' ); ?></p>
	</header>

	<ol class="xciv-admission__progress" data-admission-progress aria-label="<?php esc_attr_e( 'Application progress', 'xciv-social' ); ?>">
		<li class="is-active" data-progress="1"><span>1</span> <?php esc_html_e( 'Identity', 'xciv-social' ); ?></li>
		<li data-progress="2"><span>2</span> <?php esc_html_e( 'Profession', 'xciv-social' ); ?></li>
		<li data-progress="3"><span>3</span> <?php esc_html_e( 'Fit', 'xciv-social' ); ?></li>
		<li data-progress="4"><span>4</span> <?php esc_html_e( 'Intent', 'xciv-social' ); ?></li>
	</ol>

	<form id="xciv-admission-form" class="xciv-form xciv-admission__form" data-xciv-admission novalidate>
		<section class="xciv-step is-active" data-step="1" aria-labelledby="xciv-admission-step-1">
			<div class="xciv-step__intro">
				<p class="xciv-step__kicker"><?php esc_html_e( 'Step 1 of 4', 'xciv-social' ); ?></p>
				<h2 id="xciv-admission-step-1"><?php esc_html_e( 'Identity', 'xciv-social' ); ?></h2>
				<p class="xciv-muted"><?php esc_html_e( 'Who you are and how we reach you after review.', 'xciv-social' ); ?></p>
			</div>
			<label>
				<span><?php esc_html_e( 'Full name', 'xciv-social' ); ?></span>
				<input type="text" name="full_name" autocomplete="name" required value="<?php echo esc_attr( $prefill_name ); ?>">
			</label>
			<label>
				<span><?php esc_html_e( 'Email', 'xciv-social' ); ?></span>
				<input type="email" name="email" autocomplete="email" required value="<?php echo esc_attr( $prefill_email ); ?>">
			</label>
			<label>
				<span><?php esc_html_e( 'City / primary base', 'xciv-social' ); ?></span>
				<input type="text" name="city" autocomplete="address-level2" required placeholder="<?php esc_attr_e( 'e.g. Miami, Dubai, London', 'xciv-social' ); ?>">
			</label>
			<div class="xciv-step__actions">
				<button type="button" class="xciv-btn xciv-btn--primary" data-next><?php esc_html_e( 'Continue', 'xciv-social' ); ?></button>
			</div>
		</section>

		<section class="xciv-step" data-step="2" hidden aria-labelledby="xciv-admission-step-2">
			<div class="xciv-step__intro">
				<p class="xciv-step__kicker"><?php esc_html_e( 'Step 2 of 4', 'xciv-social' ); ?></p>
				<h2 id="xciv-admission-step-2"><?php esc_html_e( 'Profession', 'xciv-social' ); ?></h2>
				<p class="xciv-muted"><?php esc_html_e( 'Where you operate so we can place you in the right circles.', 'xciv-social' ); ?></p>
			</div>
			<label>
				<span><?php esc_html_e( 'Vertical', 'xciv-social' ); ?></span>
				<select name="vertical" required>
					<option value=""><?php esc_html_e( 'Select…', 'xciv-social' ); ?></option>
					<option value="mfo"><?php esc_html_e( 'Multi-family office (MFO)', 'xciv-social' ); ?></option>
					<option value="hospitality"><?php esc_html_e( 'Hospitality management', 'xciv-social' ); ?></option>
					<option value="club_event"><?php esc_html_e( 'Club & event management', 'xciv-social' ); ?></option>
					<option value="nightlife"><?php esc_html_e( 'Nightlife', 'xciv-social' ); ?></option>
					<option value="marketplace"><?php esc_html_e( 'Event & service marketplace', 'xciv-social' ); ?></option>
					<option value="property"><?php esc_html_e( 'Property management', 'xciv-social' ); ?></option>
					<option value="consulting"><?php esc_html_e( 'Management consulting', 'xciv-social' ); ?></option>
					<option value="organizer"><?php esc_html_e( 'Party & event organizer', 'xciv-social' ); ?></option>
					<option value="partygoer"><?php esc_html_e( 'Partygoer', 'xciv-social' ); ?></option>
					<option value="holding"><?php esc_html_e( 'Holding company', 'xciv-social' ); ?></option>
					<option value="other"><?php esc_html_e( 'Other', 'xciv-social' ); ?></option>
				</select>
			</label>
			<label>
				<span><?php esc_html_e( 'Title / role', 'xciv-social' ); ?></span>
				<input type="text" name="title_role" required placeholder="<?php esc_attr_e( 'e.g. Managing partner, Creative director', 'xciv-social' ); ?>">
			</label>
			<label>
				<span><?php esc_html_e( 'Organization (optional)', 'xciv-social' ); ?></span>
				<input type="text" name="organization" autocomplete="organization">
			</label>
			<div class="xciv-step__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-prev><?php esc_html_e( 'Back', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-btn xciv-btn--primary" data-next><?php esc_html_e( 'Continue', 'xciv-social' ); ?></button>
			</div>
		</section>

		<section class="xciv-step" data-step="3" hidden aria-labelledby="xciv-admission-step-3">
			<div class="xciv-step__intro">
				<p class="xciv-step__kicker"><?php esc_html_e( 'Step 3 of 4', 'xciv-social' ); ?></p>
				<h2 id="xciv-admission-step-3"><?php esc_html_e( 'Fit', 'xciv-social' ); ?></h2>
				<p class="xciv-muted"><?php esc_html_e( 'Tell us how you live and operate — this is how we judge alignment.', 'xciv-social' ); ?></p>
			</div>
			<label>
				<span><?php esc_html_e( 'What does full sovereignty mean in how you operate?', 'xciv-social' ); ?></span>
				<textarea name="sovereignty" rows="4" required></textarea>
			</label>
			<label>
				<span><?php esc_html_e( 'Describe the adventurous lifestyle you pursue.', 'xciv-social' ); ?></span>
				<textarea name="lifestyle" rows="4" required></textarea>
			</label>
			<div class="xciv-step__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-prev><?php esc_html_e( 'Back', 'xciv-social' ); ?></button>
				<button type="button" class="xciv-btn xciv-btn--primary" data-next><?php esc_html_e( 'Continue', 'xciv-social' ); ?></button>
			</div>
		</section>

		<section class="xciv-step" data-step="4" hidden aria-labelledby="xciv-admission-step-4">
			<div class="xciv-step__intro">
				<p class="xciv-step__kicker"><?php esc_html_e( 'Step 4 of 4', 'xciv-social' ); ?></p>
				<h2 id="xciv-admission-step-4"><?php esc_html_e( 'Intent', 'xciv-social' ); ?></h2>
				<p class="xciv-muted"><?php esc_html_e( 'What you offer, what you want, and optional proof we can verify.', 'xciv-social' ); ?></p>
			</div>
			<label>
				<span><?php esc_html_e( 'What do you bring to this network?', 'xciv-social' ); ?></span>
				<textarea name="bring" rows="4" required></textarea>
			</label>
			<label>
				<span><?php esc_html_e( 'What are you seeking?', 'xciv-social' ); ?></span>
				<textarea name="seek" rows="4" required></textarea>
			</label>
			<label>
				<span><?php esc_html_e( 'Proof link (optional)', 'xciv-social' ); ?></span>
				<input type="url" name="proof_url" placeholder="https://">
			</label>
			<label>
				<span><?php esc_html_e( 'How did you hear about XCIV? (optional)', 'xciv-social' ); ?></span>
				<input type="text" name="how_heard" placeholder="<?php esc_attr_e( 'Member name, event, search…', 'xciv-social' ); ?>">
			</label>
			<label class="xciv-check">
				<input type="checkbox" name="manual_review" value="1" required>
				<span><?php esc_html_e( 'I understand admission is selective and manually reviewed.', 'xciv-social' ); ?></span>
			</label>
			<div class="xciv-step__actions">
				<button type="button" class="xciv-btn xciv-btn--ghost" data-prev><?php esc_html_e( 'Back', 'xciv-social' ); ?></button>
				<button type="submit" class="xciv-btn xciv-btn--primary" data-submit><?php esc_html_e( 'Submit for review', 'xciv-social' ); ?></button>
			</div>
		</section>

		<p class="xciv-form__status" data-status hidden role="status"></p>
	</form>

	<div class="xciv-admission__success" data-admission-success hidden>
		<p class="xciv-admission__eyebrow"><?php esc_html_e( 'Received', 'xciv-social' ); ?></p>
		<h2><?php esc_html_e( 'Your application is in review', 'xciv-social' ); ?></h2>
		<p class="xciv-muted"><?php esc_html_e( 'We read every submission. If you are a fit, you will hear from us by email. No automatic approvals.', 'xciv-social' ); ?></p>
		<p><a class="xciv-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'xciv-social' ); ?></a></p>
	</div>
</main>
<?php
get_footer();

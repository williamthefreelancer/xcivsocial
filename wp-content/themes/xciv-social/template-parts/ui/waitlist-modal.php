<?php
/**
 * Pre-sale waitlist join modal.
 *
 * @package XCIV_Social
 */

$current_user = wp_get_current_user();
$full_name    = '';
$email        = '';

if ( $current_user instanceof WP_User && $current_user->exists() ) {
	$full_name = trim( $current_user->first_name . ' ' . $current_user->last_name );
	if ( '' === $full_name ) {
		$full_name = (string) $current_user->display_name;
	}
	$email = (string) $current_user->user_email;
}
?>
<dialog class="xciv-waitlist-dialog" data-waitlist-dialog aria-labelledby="xciv-waitlist-title">
	<form class="xciv-waitlist-dialog__panel xciv-form" method="post" action="#" data-waitlist-form>
		<header class="xciv-waitlist-dialog__head">
			<div>
				<p class="xciv-muted xciv-waitlist-dialog__eyebrow"><?php esc_html_e( 'Pre-sale waitlist', 'xciv-social' ); ?></p>
				<h2 id="xciv-waitlist-title" data-waitlist-title><?php esc_html_e( 'Join the waitlist', 'xciv-social' ); ?></h2>
				<p class="xciv-muted" data-waitlist-copy><?php esc_html_e( 'Be first in line when tickets open.', 'xciv-social' ); ?></p>
			</div>
			<button type="button" class="xciv-btn xciv-btn--ghost" data-waitlist-close aria-label="<?php esc_attr_e( 'Close', 'xciv-social' ); ?>">&times;</button>
		</header>

		<input type="hidden" name="series_id" data-waitlist-series value="">
		<input type="hidden" name="occurrence_id" data-waitlist-occurrence value="">

		<label>
			<span><?php esc_html_e( 'Full name', 'xciv-social' ); ?></span>
			<input type="text" name="full_name" required autocomplete="name" value="<?php echo esc_attr( $full_name ); ?>" data-waitlist-name>
		</label>
		<label>
			<span><?php esc_html_e( 'Email', 'xciv-social' ); ?></span>
			<input type="email" name="email" required autocomplete="email" value="<?php echo esc_attr( $email ); ?>" data-waitlist-email>
		</label>

		<p class="xciv-form__status xciv-muted" data-waitlist-status hidden></p>

		<footer class="xciv-waitlist-dialog__actions">
			<button type="button" class="xciv-btn xciv-btn--ghost" data-waitlist-close><?php esc_html_e( 'Cancel', 'xciv-social' ); ?></button>
			<button type="submit" class="xciv-btn xciv-btn--primary" data-waitlist-submit><?php esc_html_e( 'Join waitlist', 'xciv-social' ); ?></button>
		</footer>
	</form>
</dialog>

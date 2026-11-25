<?php
/**
 * Upsell repeater row.
 *
 * @package XCIV_Social_Core
 * @var int|string           $i
 * @var array<string, mixed> $upsell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$option = \XCIV\Core\Admin\SettingsStore::OPTION_KEY;
$base   = $option . '[upsells][' . $i . ']';
?>
<article class="xciv-admin__row" data-xciv-row>
	<div class="xciv-admin__row-grid">
		<p>
			<label><?php esc_html_e( 'ID', 'xciv-social-core' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $base ); ?>[id]" value="<?php echo esc_attr( (string) ( $upsell['id'] ?? '' ) ); ?>" placeholder="membership">
		</p>
		<p>
			<label><?php esc_html_e( 'Name', 'xciv-social-core' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $base ); ?>[name]" value="<?php echo esc_attr( (string) ( $upsell['name'] ?? '' ) ); ?>" required>
		</p>
		<p>
			<label><?php esc_html_e( 'Price', 'xciv-social-core' ); ?></label>
			<input type="number" min="0" step="1" name="<?php echo esc_attr( $base ); ?>[price]" value="<?php echo esc_attr( (string) ( $upsell['price'] ?? 0 ) ); ?>">
		</p>
		<p>
			<label><?php esc_html_e( 'CTA label', 'xciv-social-core' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $base ); ?>[cta]" value="<?php echo esc_attr( (string) ( $upsell['cta'] ?? '' ) ); ?>" placeholder="Add membership">
		</p>
		<p class="xciv-admin__row-full">
			<label><?php esc_html_e( 'Description', 'xciv-social-core' ); ?></label>
			<textarea rows="2" name="<?php echo esc_attr( $base ); ?>[desc]"><?php echo esc_textarea( (string) ( $upsell['desc'] ?? '' ) ); ?></textarea>
		</p>
	</div>
	<button type="button" class="button-link-delete" data-xciv-remove-row><?php esc_html_e( 'Remove', 'xciv-social-core' ); ?></button>
</article>

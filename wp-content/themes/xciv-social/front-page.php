<?php
/**
 * Landing — brand-first hero.
 *
 * @package XCIV_Social
 */

use XCIV\Theme\Controllers\HomeController;

get_header();

$data = HomeController::landing();
?>
<main id="main" class="xciv-hero">
	<div class="xciv-hero__plane" aria-hidden="true"></div>
	<div class="xciv-hero__content">
		<p class="xciv-hero__brand"><?php echo esc_html( $data['brand'] ); ?></p>
		<h1 class="xciv-hero__headline"><?php echo esc_html( $data['headline'] ); ?></h1>
		<p class="xciv-hero__subhead"><?php echo esc_html( $data['subhead'] ); ?></p>
		<div class="xciv-hero__cta">
			<a class="xciv-btn xciv-btn--primary" href="<?php echo esc_url( $data['cta_url'] ); ?>">
				<?php echo esc_html( $data['cta_label'] ); ?>
			</a>
		</div>
	</div>
</main>
<?php
get_footer();

<?php
/**
 * Fallback index.
 *
 * @package XCIV_Social
 */

get_header();
?>
<main id="main" class="xciv-shell">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'xciv-article' ); ?>>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'xciv-social' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();

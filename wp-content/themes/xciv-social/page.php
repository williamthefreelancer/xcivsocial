<?php
/**
 * Default page template.
 *
 * @package XCIV_Social
 */

get_header();
?>
<main id="main" class="xciv-shell">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class( 'xciv-article' ); ?>>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();

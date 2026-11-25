<?php
/**
 * Reusable elevated panel shell.
 *
 * Expected $args keys:
 * - title       (string)  Panel heading
 * - description (string)  Optional muted subcopy under the heading
 * - class       (string)  Extra classes on the panel root
 * - attrs       (string)  Extra HTML attributes (e.g. data hooks)
 * - id          (string)  Optional element id
 * - placeholder (string)  Body placeholder when no custom content is passed
 * - content     (string)  Optional pre-rendered HTML for the body (escaped by caller)
 *
 * @package XCIV_Social
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'title'       => '',
		'description' => '',
		'class'       => '',
		'attrs'       => '',
		'id'          => '',
		'placeholder' => __( 'Boilerplate ready — drop your content here.', 'xciv-social' ),
		'content'     => '',
	)
);

$classes = trim( 'xciv-panel ' . $args['class'] );
?>
<section
	class="<?php echo esc_attr( $classes ); ?>"
	<?php
	if ( $args['id'] ) {
		echo ' id="' . esc_attr( $args['id'] ) . '"';
	}
	if ( $args['attrs'] ) {
		echo ' ' . $args['attrs']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-controlled attrs for data hooks.
	}
	?>
>
	<?php if ( $args['title'] || $args['description'] ) : ?>
		<header class="xciv-panel__head">
			<?php if ( $args['title'] ) : ?>
				<h2 class="xciv-panel__title"><?php echo esc_html( $args['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( $args['description'] ) : ?>
				<p class="xciv-panel__desc"><?php echo esc_html( $args['description'] ); ?></p>
			<?php endif; ?>
		</header>
	<?php endif; ?>

	<div class="xciv-panel__body">
		<?php
		if ( $args['content'] ) {
			echo $args['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller supplies escaped markup.
		} else {
			?>
			<p class="xciv-panel__placeholder"><?php echo esc_html( $args['placeholder'] ); ?></p>
			<?php
		}
		?>
	</div>
</section>

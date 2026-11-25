<?php
/**
 * Site footer.
 *
 * @package XCIV_Social
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="xciv-footer">
	<div class="xciv-footer__inner">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> XCIV Social. A platform of SUPR XCIV PLATFORM HOLDINGS LLC &amp; THE SUPER NINETY FOUR EVENTS COMPANY. Admission by invitation and review.</p>
	</div>
</footer>
<?php if ( is_user_logged_in() ) : ?>
			</div><!-- .xciv-app-content -->
		</div><!-- .xciv-app-main -->
	</div><!-- .xciv-app-shell -->
	<div class="xciv-sidebar-backdrop" data-sidebar-backdrop hidden></div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>

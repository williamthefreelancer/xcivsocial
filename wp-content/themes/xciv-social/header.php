<?php
/**
 * Site header.
 *
 * @package XCIV_Social
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_member_app = is_user_logged_in();
$current_user  = $is_member_app ? wp_get_current_user() : null;
$display_name  = $current_user ? ( $current_user->display_name ?: $current_user->user_login ) : '';
$initial       = $display_name ? strtoupper( substr( $display_name, 0, 1 ) ) : 'M';
$logo_url      = XCIV_THEME_URI . '/assets/img/xciv-logo.svg';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $is_member_app ? 'xciv-app' : 'xciv-public' ); ?>>
<?php wp_body_open(); ?>
<a class="xciv-skip" href="#main"><?php esc_html_e( 'Skip to content', 'xciv-social' ); ?></a>

<?php if ( $is_member_app ) : ?>
	<div class="xciv-app-shell">
		<?php get_template_part( 'template-parts/ui/sidebar' ); ?>

		<div class="xciv-app-main">
			<header class="xciv-topbar">
				<div class="xciv-topbar__inner">
					<button type="button" class="xciv-topbar__menu" data-sidebar-toggle aria-expanded="false" aria-controls="xciv-sidebar-drawer">
						<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'xciv-social' ); ?></span>
						<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
							<path d="M4 7h16M4 12h16M4 17h16"/>
						</svg>
					</button>

					<a class="xciv-brand" href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>">
						<img class="xciv-brand__logo" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'XCIV Social', 'xciv-social' ); ?>" width="36" height="40">
					</a>

					<div class="xciv-user-menu" data-user-menu>
						<button
							type="button"
							class="xciv-user-menu__trigger"
							data-user-menu-toggle
							aria-expanded="false"
							aria-haspopup="menu"
							aria-controls="xciv-user-menu-panel"
						>
							<span class="xciv-avatar xciv-avatar--sm" aria-hidden="true"><span><?php echo esc_html( $initial ); ?></span></span>
							<span class="xciv-user-menu__name"><?php echo esc_html( $display_name ); ?></span>
							<svg class="xciv-user-menu__caret" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
								<path d="M6 9l6 6 6-6"/>
							</svg>
						</button>

						<div class="xciv-user-menu__panel" id="xciv-user-menu-panel" role="menu" hidden data-user-menu-panel>
							<div class="xciv-user-menu__who">
								<span class="xciv-avatar" aria-hidden="true"><span><?php echo esc_html( $initial ); ?></span></span>
								<div>
									<strong><?php echo esc_html( $display_name ); ?></strong>
									<small class="xciv-muted"><?php echo esc_html( $current_user->user_email ); ?></small>
								</div>
							</div>
							<a role="menuitem" href="<?php echo esc_url( home_url( '/profile/' ) ); ?>"><?php esc_html_e( 'View profile', 'xciv-social' ); ?></a>
							<a role="menuitem" href="<?php echo esc_url( home_url( '/profile-settings/' ) ); ?>"><?php esc_html_e( 'Profile settings', 'xciv-social' ); ?></a>
							<a role="menuitem" href="<?php echo esc_url( home_url( '/account-settings/' ) ); ?>"><?php esc_html_e( 'Account settings', 'xciv-social' ); ?></a>
							<a role="menuitem" class="xciv-user-menu__danger" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log out', 'xciv-social' ); ?></a>
						</div>
					</div>
				</div>
			</header>

			<div class="xciv-app-content">
<?php else : ?>
	<header class="xciv-header">
		<div class="xciv-header__inner">
			<a class="xciv-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img class="xciv-brand__logo" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'XCIV Social', 'xciv-social' ); ?>" width="36" height="40">
			</a>
			<nav class="xciv-nav" aria-label="<?php esc_attr_e( 'Primary', 'xciv-social' ); ?>">
				<a href="<?php echo esc_url( home_url( '/request-admission/' ) ); ?>"><?php esc_html_e( 'Request Admission', 'xciv-social' ); ?></a>
				<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Log in', 'xciv-social' ); ?></a>
			</nav>
		</div>
	</header>
<?php endif; ?>

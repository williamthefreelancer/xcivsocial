<?php
/**
 * Theme supports and menus.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

namespace XCIV\Theme\Support;

final class ThemeSetup {

	public static function init(): void {
		add_action( 'after_setup_theme', array( self::class, 'setup' ) );
		add_action( 'init', array( self::class, 'register_menus' ) );
		add_action( 'wp_head', array( self::class, 'site_icons' ), 1 );
		add_action( 'admin_head', array( self::class, 'site_icons' ), 1 );
		add_action( 'login_head', array( self::class, 'site_icons' ), 1 );
	}

	public static function setup(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
	}

	/**
	 * Output browser favicon / site icon tags.
	 */
	public static function site_icons(): void {
		$icon = XCIV_THEME_URI . '/assets/img/site-icon.png';
		$ver  = XCIV_THEME_VERSION;
		printf(
			'<link rel="icon" href="%1$s?v=%2$s" type="image/png" sizes="any">' . "\n" .
			'<link rel="apple-touch-icon" href="%1$s?v=%2$s">' . "\n" .
			'<link rel="shortcut icon" href="%1$s?v=%2$s">' . "\n",
			esc_url( $icon ),
			esc_attr( $ver )
		);
	}

	public static function register_menus(): void {
		register_nav_menus(
			array(
				'primary' => __( 'Primary', 'xciv-social' ),
				'member'  => __( 'Member', 'xciv-social' ),
			)
		);
	}
}

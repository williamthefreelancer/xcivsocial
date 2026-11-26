<?php
/**
 * XCIV Social theme bootstrap.
 *
 * @package XCIV_Social
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XCIV_THEME_VERSION', '0.3.5' );
define( 'XCIV_THEME_DIR', get_template_directory() );
define( 'XCIV_THEME_URI', get_template_directory_uri() );

require_once XCIV_THEME_DIR . '/app/Support/Autoloader.php';
\XCIV\Theme\Support\Autoloader::register();

\XCIV\Theme\Support\ThemeSetup::init();
\XCIV\Theme\Support\Assets::init();
\XCIV\Theme\Support\PageSeeder::init();

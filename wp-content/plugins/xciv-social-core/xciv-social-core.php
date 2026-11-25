<?php
/**
 * Plugin Name: XCIV Social Core
 * Description: Admission Intelligence, membership roles, community domain, and WPGraphQL extensions for XCIV Social.
 * Version: 0.2.0
 * Author: XCIV
 * Requires at least: 6.4
 * Requires PHP: 8.1
 * Text Domain: xciv-social-core
 *
 * @package XCIV_Social_Core
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'XCIV_CORE_VERSION', '0.2.1' );
define( 'XCIV_CORE_FILE', __FILE__ );
define( 'XCIV_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'XCIV_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once XCIV_CORE_DIR . 'src/Support/Autoloader.php';
\XCIV\Core\Support\Autoloader::register();

register_activation_hook( __FILE__, array( \XCIV\Core\Support\Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( \XCIV\Core\Support\Activator::class, 'deactivate' ) );

add_action(
	'plugins_loaded',
	static function (): void {
		\XCIV\Core\Support\Plugin::init();
	}
);

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/valentinzm
 * @since             1.0.0
 * @package           Wps
 *
 * @wordpress-plugin
 * Plugin Name:       WP Slider
 * Plugin URI:        https://github.com/valentinzm/wp-slider
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            valentine
 * Author URI:        https://github.com/valentinzm
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wps
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WPS_VERSION', '1.0.0' );

define( 'WPS_PLUGIN', __FILE__ );

define( 'WPS_PLUGIN_DIR', untrailingslashit( dirname( WPS_PLUGIN ) ) );

define( 'WPS_PLUGIN_TABLE', 'wps_table' );

define( 'WPS_PLUGIN_FOLDER', 'wps-slider' );

function activate_wps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wps-activator.php';
	Wps_Activator::activate();
}

function deactivate_wps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wps-deactivator.php';
	Wps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wps' );
register_deactivation_hook( __FILE__, 'deactivate_wps' );

require plugin_dir_path( __FILE__ ) . 'includes/class-wps.php';

function run_wps() {

	$plugin = new Wps();
	$plugin->run();

}
run_wps();

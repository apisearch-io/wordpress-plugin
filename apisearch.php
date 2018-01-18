<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://apisearch.io
 * @since             0.1.0
 * @package           Apisearch
 *
 * @wordpress-plugin
 * Plugin Name:       Search by Apisearch
 * Plugin URI:        http://apisearch.io/plugin/wordpress
 * Description:       Create a amazing search bar in your blog
 * Version:           0.1.0
 * Author:            Apisearch Team
 * Author URI:        http://apisearch.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       apisearch
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '0.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-apisearch-activator.php
 */
function activate_apisearch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-apisearch-activator.php';
	Apisearch_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-apisearch-deactivator.php
 */
function deactivate_apisearch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-apisearch-deactivator.php';
	Apisearch_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_apisearch' );
register_deactivation_hook( __FILE__, 'deactivate_apisearch' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-apisearch.php';
require plugin_dir_path( __FILE__ ) . 'includes/apisearch-client.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_apisearch() {

	$plugin = new Apisearch();
	$plugin->run();

}
run_apisearch();

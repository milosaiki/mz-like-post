<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rs.linkedin.com/in/milos-zivic-2586a174
 * @since             1.0.0
 * @package           Mz_Like_Post
 *
 * @wordpress-plugin
 * Plugin Name:       MZ Like Post
 * Plugin URI:        https://github.com/milosaiki
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Milos Zivic
 * Author URI:        https://rs.linkedin.com/in/milos-zivic-2586a174
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mz-like-post
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mz-like-post-activator.php
 */
function activate_mz_like_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mz-like-post-activator.php';
	Mz_Like_Post_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mz-like-post-deactivator.php
 */
function deactivate_mz_like_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mz-like-post-deactivator.php';
	Mz_Like_Post_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mz_like_post' );
register_deactivation_hook( __FILE__, 'deactivate_mz_like_post' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mz-like-post.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mz_like_post() {

	$plugin = new Mz_Like_Post();
	$plugin->run();

}
run_mz_like_post();

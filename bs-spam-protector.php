<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://neuropassenger.ru
 * @since             1.0.0
 * @package           Bs_Spam_Protector
 *
 * @wordpress-plugin
 * Plugin Name:       BS SPAM Protector
 * Description:       This plugin protects Contact Form 7 from spam.
 * Version:           1.7.2
 * Author:            Oleg Sokolov
 * Author URI:        https://neuropassenger.ru
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bs-spam-protector
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
define( 'BS_SPAM_PROTECTOR_VERSION', '1.7.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bs-spam-protector-activator.php
 */
function activate_bs_spam_protector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bs-spam-protector-activator.php';
	Bs_Spam_Protector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bs-spam-protector-deactivator.php
 */
function deactivate_bs_spam_protector() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bs-spam-protector-deactivator.php';
	Bs_Spam_Protector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bs_spam_protector' );
register_deactivation_hook( __FILE__, 'deactivate_bs_spam_protector' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bs-spam-protector.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bs_spam_protector() {

	$plugin = new Bs_Spam_Protector();
	$plugin->run();

}
run_bs_spam_protector();

<?php

/**
 *
 * @link              http://reloadedpc.com
 * @since             1.0.0
 * @package           Give_Square_Gateway
 *
 * @wordpress-plugin
 * Plugin Name:       Give Square Gateway
 * Plugin URI:        http://reloadedpc.com
 * Description:       Square Payment Gateway for Give Wordpress plugin
 * Version:           1.0.0
 * Author:            Joe McFrederick
 * Author URI:        http://reloadedpc.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       give-square-gateway
 * Domain Path:       /languages
 */

require_once('vendor/autoload.php');

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-give-square-gateway-activator.php
 */
function activate_give_square_gateway() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-give-square-gateway-activator.php';
	Give_Square_Gateway_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-give-square-gateway-deactivator.php
 */
function deactivate_give_square_gateway() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-give-square-gateway-deactivator.php';
	Give_Square_Gateway_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_give_square_gateway' );
register_deactivation_hook( __FILE__, 'deactivate_give_square_gateway' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-give-square-gateway.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_give_square_gateway() {

	$plugin = new Give_Square_Gateway();
	$plugin->run();

}
run_give_square_gateway();
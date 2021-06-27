<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://dev.technology-architects.com/petgolu/
 * @since             1.0.0
 * @package           Ap_Ss
 *
 * @wordpress-plugin
 * Plugin Name:		  Add Pet
 * Plugin URI:        http://dev.technology-architects.com/petgolu/
 * Description:       User can add woocommerce product from client side
 * Version:           1.0.0
 * Author:            Technology Architects
 * Author URI:        http://technology-architects.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ap
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AP_VERSION', '1.0.0' );
define( 'AP_URL', plugins_url('/', __FILE__) );
define( 'AP_DIR', dirname(__FILE__) );
define( 'AP_DEV_MODE', false );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ap-ss-activator.php
 */
function activate_ap_ss() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ap-ss-activator.php';
	Ap_Ss_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ap-ss-deactivator.php
 */
function deactivate_ap_ss() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ap-ss-deactivator.php';
	Ap_Ss_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ap_ss' );
register_deactivation_hook( __FILE__, 'deactivate_ap_ss' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ap-ss.php';
include_once(plugin_dir_path( __FILE__ ).'includes/ap-ajax-api.php');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ap_ss() {

	$plugin = new Ap_Ss();
	$plugin->run();

}

run_ap_ss();

// function verify(){

// 	add_action( 'template_redirect', 'redirect_if_user_not_logged_in' );
 
// 	function redirect_if_user_not_logged_in() {
	 
// 		if ( !is_user_logged_in() ) { //example can be is_page(23) where 23 is page ID
	 
// 			wp_redirect( site_url() . '/my-account' );
// 	    exit;
	   
// 	   }
// 	   else {
// 	   	run_ap_ss();
// 	   }
// 	}

// }
// verify();







// register_activation_hook( __FILE__, 'add_pet_register_activation_hook');
// register_deactivation_hook( __FILE__, 'add_pet_register_deactivation_hook' );
// register_uninstall_hook( __FILE__, 'add_pet_register_uninstall_hook');

// function add_pet_register_activation_hook(){

// }

// function add_pet_register_deactivation_hook(){
	
// }

// function add_pet_register_uninstall_hook(){
	
// }


// add_action('init', 'add_pet_init');

// function add_pet_init(){
// 	add_shortcode('test','add_pet_shortcode');
// }


// function add_pet_shortcode($atts){
// 	return ' Hello World!';
// }
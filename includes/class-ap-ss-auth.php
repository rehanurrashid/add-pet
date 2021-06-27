<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://dev.technology-architects.com/petgolu/
 * @since      1.0.0
 *
 * @package    Ap_Ss
 * @subpackage Ap_Ss/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ap_Ss
 * @subpackage Ap_Ss/includes
 * @author     Technology Architects
 */
class Ap_Ss_Auth {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ap_ss    The ID of this plugin.
	 */
	private $ap_ss;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $ap_ss       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $ap_ss, $version ) {

		$this->ap_ss = $ap_ss;
		$this->version = $version;

	}

// 	function ap_login_redirect( $redirect_to, $request, $user ) {
//     //is there a user to check?
//     if ( isset( $user->roles ) && is_array( $user->roles ) ) {
//         //check for admins
//         if ( in_array( 'administrator', $user->roles ) ) {
//             // redirect them to the default place
//             return $redirect_to;
//         } else {
//             return home_url().'/petgolu/add-pet/';
//         }
//     } else {
//         return $redirect_to;
//     }
// }


	public function auth_user(){


	    if (  is_page('add-pet') && ! is_page( 'login' ) && ! is_page('register') && ! is_user_logged_in() ) {

	    	// wp_redirect( esc_url( add_query_arg( 'add-pet', 'true', home_url().'/petgolu/my-account/' ) ) );

		    wp_redirect( '/petgolu/my-account/?add-pet=true' );
		    
		}
	}


}

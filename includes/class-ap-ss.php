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
class Ap_Ss {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ap_Ss_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $ap_ss    The string used to uniquely identify this plugin.
	 */
	protected $ap_ss;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AP_VERSION' ) ) {
			$this->version = AP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->ap_ss = 'add-pet';

		$this->load_dependencies();

		$this->authtenticated_users();
		
		// print_r($test);

		// exit;

		$this->set_locale();
		// Test if string contains the word 
		
		$this->define_admin_hooks();
		
		// if(strpos($_SERVER['REQUEST_URI'], 'add-pet') !== false){
			$this->define_public_hooks();
		// }
		

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ap_ss_Loader. Orchestrates the hooks of the plugin.
	 * - Ap_ss_i18n. Defines internationalization functionality.
	 * - Ap_ss_Admin. Defines all hooks for the admin area.
	 * - Ap_ss_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ap-ss-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ap-ss-i18n.php';

		/**
		 * The class responsible for authtentication.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ap-ss-auth.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ap-ss-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ap-ss-public.php';

		$this->loader = new Ap_Ss_Loader();

	}

	/**
	 * Register all of the hooks related to the authentication functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function authtenticated_users() {

		$auth = new Ap_Ss_Auth( $this->get_ap_ss(), $this->get_version() );

		// $this->loader->add_filter( 'authenticate', $auth, 'auth_user', 3, 3 );

		// $this->loader->add_filter( 'wp', $auth, 'redirect_after_login');
		$this->loader->add_action( 'template_redirect', $auth, 'auth_user' );
		// $this->loader->add_filter( 'login_redirect', 'ap_login_redirect', 10, 3 );
	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ap_ss_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ap_ss_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$admin = new Ap_Ss_Admin( $this->get_ap_ss(), $this->get_version() );

		if(strpos($_SERVER['REQUEST_URI'], 'post.php?post=') !== false || strpos($_SERVER['REQUEST_URI'], 'edit.php?post_type=ap-pet') !== false){
			$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );	
		}
		
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );

		// create menu links
		$this->loader->add_action('admin_menu', $admin, 'create_menu');

		// create post pet type
		$this->loader->add_action( 'init', $admin, 'create_pet_post_type' );

		// create post pet video type
		$this->loader->add_action( 'init', $admin, 'create_pet_video_post_type' );

		// register pet categories
		$this->loader->add_action( 'init', $admin, 'create_pet_taxonomies' );
		
		// add thumbnail column
		$this->loader->add_filter('manage_ap-pet_posts_columns', $admin, 'posts_columns', 5);
		$this->loader->add_action('manage_ap-pet_posts_custom_column', $admin, 'posts_custom_columns', 5, 2);
 
		// add dublicate link
		$this->loader->add_filter( 'post_row_actions', $admin, 'duplicate_post_link', 10, 2 );
		// post dublicate admin action
		$this->loader->add_action( 'admin_action_duplicate_post_as_draft', $admin, 'duplicate_post_as_draft' );

		// create metabox for configuration
		$this->loader->add_action('add_meta_boxes', $admin, 'create_pet_metabox');
		// update metabox on update
		$this->loader->add_action('save_post', $admin, 'save_pet_metadata', 10, 3);



		// // register post type for fonts
		// $this->loader->add_action('init', $admin, 'register_pet_font');
		// // fonts metabox
		// $this->loader->add_action('add_meta_boxes', $admin, 'pet_font_metabox');
		// $this->loader->add_action('save_post', $admin, 'save_pet_font_metadata', 10, 3);

		// // order page 
		// $this->loader->add_action('woocommerce_after_order_itemmeta', $admin, 'lbd_order_item');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$public = new Ap_Ss_Public( $this->get_ap_ss(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles', 50 );
		// $this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );


		// create post type
		// $this->loader->add_action( 'init', $public, 'auth_user', );

		add_shortcode( 'ap_show_add_form', array($public, 'show_add_form'));

		add_shortcode( 'ap_show_edit_form', array($public, 'show_edit_form'));

		add_shortcode( 'ap_show_pets', array($public, 'show_pets'));

		add_shortcode( 'ap_my_pets', array($public, 'my_pets'));
		// add_shortcode( 'ap_show_search_form', array($public, 'show_search_form'));
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_ap_ss() {
		return $this->ap_ss;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ap_ss_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

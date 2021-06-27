<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://dev.technology-architects.com/petgolu/
 * @since      1.0.0
 *
 * @package    Ap_Ss
 * @subpackage Ap_Ss/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ap_Ss
 * @subpackage Ap_Ss/admin
 * @author     Technology Architects
 */
class Ap_Ss_Admin {
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
	 * @param      string    $ap_ss       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $ap_ss, $version ) {

		$this->ap_ss = $ap_ss;
		$this->version = $version;

		// print_r($this->ap_ss);
		// exit;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ap_Ss_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ap_Ss_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->ap_ss, plugin_dir_url( __FILE__ ) . 'css/ap-ss-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ap_Ss_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ap_Ss_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->ap_ss, plugin_dir_url( __FILE__ ) . 'js/ap-ss-admin.js', array( 'jquery' ), $this->version, false );

	}

// Hooking up our function to theme setup
// add_action( 'init', 'create_posttype' );
	public function create_pet_post_type() {
		$labels = array(
			'name'               => __( 'Pets', 'ap' ),
			'singular_name'      => __( 'Pet', 'ap' ),
			'add_new'            => _x( 'Add New Pet', 'ap', 'ap' ),
			'add_new_item'       => __( 'Add New Pet', 'ap' ),
			'edit_item'          => __( 'Edit Pet', 'ap' ),
			'new_item'           => __( 'New Pet', 'ap' ),
			'view_item'          => __( 'View Pet', 'ap' ),
			'search_items'       => __( 'Search Pet Name', 'ap' ),
			'not_found'          => __( 'No Pet Name found', 'ap' ),
			'not_found_in_trash' => __( 'No Pet Name found in Trash', 'ap' ),
			'parent_item_colon'  => __( 'Parent Pet:', 'ap' ),
			'menu_name'          => __( 'Pet', 'ap' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'Pets',
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'          => true,        // showing in rest api
			// 'menu_position'       => null,
			// 'menu_icon'           => null,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			// 'has_archive'         => true,
			'query_var'           => true,
			// 'can_export'          => true,
			// 'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
				// 'editor',
				// 'author',
				'thumbnail',
				// 'excerpt',
				// 'custom-fields',
				// 'trackbacks',
				// 'comments',
				// 'revisions',
				// 'page-attributes',
				// 'post-formats',
			),
		);
	
		register_post_type( 'ap-pet', $args );
	}


			// creating pet categories

	function create_pet_taxonomies() {
		register_taxonomy(
        'ap_cat',
        'ap-pet',
        array(
            'labels' => array(
                'name' => 'Pet Genre',
                'add_new_item' => 'Add New Pet Genre',
                'new_item_name' => "New Pet Type Genre"
            ),
            'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true
        )
    );

	}

	/**
	 * Youtube Pet Videos
	 */

	public function create_pet_video_post_type() {
		$labels = array(
			'name'               => __( 'Pet Videos', 'ap' ),
			'singular_name'      => __( 'Pet Video', 'ap' ),
			'add_new'            => _x( 'Add New Pet Video', 'ap', 'ap' ),
			'add_new_item'       => __( 'Add New Pet Video', 'ap' ),
			'edit_item'          => __( 'Edit Pet Video', 'ap' ),
			'new_item'           => __( 'New Pet Video', 'ap' ),
			'view_item'          => __( 'View Pet Video', 'ap' ),
			'search_items'       => __( 'Search Pet Video Name', 'ap' ),
			'not_found'          => __( 'No Pet Video Name found', 'ap' ),
			'not_found_in_trash' => __( 'No Pet Video Name found in Trash', 'ap' ),
			'parent_item_colon'  => __( 'Parent Pet Video:', 'ap' ),
			'menu_name'          => __( 'Pet Video', 'ap' ),
		);
	
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'Pet Videos',
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'          => true,        // showing in rest api
			// 'menu_position'       => null,
			// 'menu_icon'           => null,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			// 'has_archive'         => true,
			'query_var'           => true,
			// 'can_export'          => true,
			// 'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
				'editor',
				// 'author',
				'thumbnail',
				// 'excerpt',
				// 'custom-fields',
				// 'trackbacks',
				// 'comments',
				// 'revisions',
				// 'page-attributes',
				// 'post-formats',
			),
		);
	
		register_post_type( 'ap-pet-videos', $args );
	}

	/**
	 * Thumbnail column
	 */
	public function posts_columns($defaults){
		$tem = array();
		$tem['cb'] = $defaults['cb'];
		unset($defaults['cb']);
		$tem['ap-thumb'] = __('Thumbnail');
		// $tem['ap-categories'] = __('Categories');
	    return array_merge($tem, $defaults);
	}
	 
	public function posts_custom_columns($column_name, $id){
	    if($column_name === 'ap-thumb'){
	        echo '<img width="100px" height="80px" src="'.get_the_post_thumbnail_url( $id, 'thumbnail' ).'">';
	    }
	    // if($column_name === 'ap-categories'){
	    	
	    //     $cat = wp_get_post_categories( $id , 'ap_cat');
	    //     print_r($cat);

	    // }
	}

	public function create_menu() {
		add_menu_page( 
			__('Manage Your Pet', 'ap'), 
			__('Pets', 'ap'), 
			'manage_options', 
			'edit.php?post_type=ap-pet', 
			'', 
			'dashicons-pets',
			2
		);

		add_submenu_page( 
			'edit.php?post_type=ap-pet', 
			__('All Pets'), 
			'All Pets', 
			'manage_options', 
			'edit.php?post_type=ap-pet'			
		);

		add_submenu_page( 
			'edit.php?post_type=ap-pet', 
			__('Pet Videos'), 
			'Pet Videos', 
			'manage_options', 
			'edit.php?post_type=ap-pet-videos'			
		);

		add_submenu_page( 
			'edit.php?post_type=ap-pet', 
			__('Manage Pet/Breed Categories'), 
			'Pet Category', 
			'manage_options', 
			'edit-tags.php?taxonomy=ap_cat&post_type=ap-pet',
			false
		);

		add_submenu_page( 
			'edit.php?post_type=ap-pet', 
			'Settings', 
			'Settings', 
			'manage_options', 
			'settings', 
			array($this, 'apmanage_options') 
		);
	}

	public function apmanage_options() {
		$notices = array();
		$baseurl = wp_upload_dir()['baseurl'];

		if(isset($_POST) && !empty($_POST)) {
			$selected_theme = $_POST['ap-selected_theme'];
			update_option( 'ap-selected_theme', $selected_theme );
			
			$filter_opt = $_POST['ap-filter-option'];
			update_option( 'ap-filter-option', $filter_opt );


			$notices[] = array(
				"type" => "success",
				"message" => "Save Successfully!!!"
			);
		}

		$theme_options = array(
			array(
				'id' => 'dark',
				'name' => 'Dark Theme',
				'background-color' => '#f9ecd4',
			),
			array(
				'id' => 'light',
				'name' => 'Light Theme',
				'background-color' => '#fff',
			)
		);

		$selected_theme = get_option( 'ap-selected_theme' );
		$filter_opt = get_option( 'ap-filter-option' );
		
		require_once AP_DIR.'/admin/settings.php';
	}

	public function create_pet_metabox() {
		add_meta_box( 
			'pet_meta', 
			'Pet Details', 
			array($this, 'create_pet_metabox_content'), 
			'ap-pet',
			'normal',
			'default'
		);
	}

	public function create_pet_metabox_content() {
		include_once(AP_DIR.'/admin/pet_metabox_content.php');
	}

	public function save_pet_metadata($post_id){

		global $post;
		global $wpdb;

		$post_type = 'ap-pet';
		$table = $wpdb->prefix.'posts';

		$query = "UPDATE $table SET post_type = $post_type  WHERE ID = $post->ID";		

		if(isset($_POST['_description']) && !empty($_POST['_description']))
			update_post_meta( $post_id, '_description', $_POST['_description'] );

		if(isset($_POST['_gender']) && !empty($_POST['_gender']))
			update_post_meta( $post_id, '_gender', $_POST['_gender'] );

		if(isset($_POST['_sell_adopt']) && !empty($_POST['_sell_adopt']))
			update_post_meta( $post_id, '_sell_adopt', $_POST['_sell_adopt'] );

		if(isset($_POST['_price']) && !empty($_POST['_price']))
			update_post_meta( $post_id, '_price', $_POST['_price'] );

		if(isset($_POST['_location']) && !empty($_POST['_location']))
			update_post_meta( $post_id, '_location', $_POST['_location'] );

		if(isset($_POST['_startDate']) && !empty($_POST['_startDate']))
			update_post_meta( $post_id, '_startDate', $_POST['_startDate'] );

		if(isset($_POST['_endDate']) && !empty($_POST['_endDate']))
			update_post_meta( $post_id, '_endDate', $_POST['_endDate'] );

		if(isset($_POST['_featured']) && !empty($_POST['_featured']))
			update_post_meta( $post_id, '_featured', $_POST['_featured'] );
		
		if(isset($_POST['image_gallary']) && !empty($_POST['image_gallary']))
			update_post_meta( $post_id, '_image_gallary', $_POST['image_gallary'] );

		$wpdb->query($query);
	}

	/**
	 * dublicate link for posttype=ap-pet
	 */
	public function duplicate_post_link($actions, $post)
	{
		if (current_user_can('edit_posts') && $post->post_type == 'ap-pet') {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
		}
		return $actions;
	}

	/**
	 * dublicate post admin action
	 */
	public function duplicate_post_as_draft()
	{
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
	 
		/*
		 * Nonce verification
		 */
		if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
			return;
	 
		/*
		 * get the original post id
		 */
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );
	 
		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
	 
		/*
		 * if post data exists, create the post duplicate
		 */
		if (isset( $post ) && $post != null) {
	 
			/*
			 * new post data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
	 
			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );
	 
			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
	 
			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");

			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ", $sql_query_sel);
				// echo $sql_query;
				$wpdb->query($sql_query);
			}
	 		// die();
	 
			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}


}

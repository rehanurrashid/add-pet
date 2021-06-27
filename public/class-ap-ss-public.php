<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://dev.technology-architects.com/petgolu/
 * @since      1.0.0
 *
 * @package    Ap_Ss
 * @subpackage Ap_Ss/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ap_Ss
 * @subpackage Ap_Ss/public
 * @author     Technology Architects
 */
class Ap_Ss_Public {

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

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		

		// wp_enqueue_style( 'bootstrap4', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), true, 'all' );
		// wp_enqueue_style( $this->ap_ss, plugin_dir_url( __FILE__ ) . 'css/ap-ss-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'add-pet-form', plugin_dir_url( __FILE__ ) . '/css/main.css', array(), true, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		// wp_enqueue_script( $this->ap_ss, plugin_dir_url( __FILE__ ) . 'js/ap-ss-public.js', array( 'jquery' ), $this->version, false );

	}

	// public function auth_user(){

	//     if (  is_page('add-pet') && ! is_page( 'login' ) && ! is_page('register') && ! is_user_logged_in() ) {

	// 	    auth_redirect(); 

	// 	}
	// }

	public function show_add_form() {

		global $wpdb;
		$query = @unserialize (file_get_contents('http://ip-api.com/php/'));
		if ($query && $query['status'] == 'success') {
		    $location =  $query['country'] .', '. $query['city'];
		}

		$theme_options = get_option( 'ap-selected_theme' );

		$pets= get_terms( array(
		    'taxonomy' => 'ap_cat',
		    'hide_empty' => false,
		    'parent' => 0
		) );
		$countriesQuery="select * from countries";
		$countries=$wpdb->get_results($countriesQuery);
		// echo '<pre>',print_r($countries[0]);exit;
		require_once(AP_DIR.'/public/add_form.php');

		// add_action('wp_footer', function(){
	 		 include_once(AP_DIR.'/public/footer.php');
		// });
	}

	public function show_edit_form() {

		global $current_user;
		global $wpdb;

		$pet_id = $_GET['id'];


		$query = 'SELECT * FROM '.$wpdb->prefix.'posts WHERE ID ='.$pet_id.' AND post_author = '.$current_user->ID;
		$countriesQuery="SELECT * FROM countries";
		$current_user_post = $wpdb->get_results($query);
		$countries= $wpdb->get_results($countriesQuery);
		$PostMeta=get_post_meta($pet_id);
		$_image_gallary = get_post_meta( $pet_id, '_image_gallary', true );
		if(!empty($current_user_post)){

			$query = @unserialize (file_get_contents('http://ip-api.com/php/'));
			if ($query && $query['status'] == 'success') {
			    $location =  $query['country'] .', '. $query['city'];
			}
			if(isset($PostMeta["_country_id"]) && isset($PostMeta["_country_id"][0]))
			{
				$country_id=$PostMeta["_country_id"][0];
				$selectCitiesQuery="SELECT * FROM cities WHERE country_id='$country_id'";
				$cities= $wpdb->get_results($selectCitiesQuery);
			}

			$theme_options = get_option( 'ap-selected_theme' );

			$pets= get_terms( array(
			    'taxonomy' => 'ap_cat',
			    'hide_empty' => false,
			    'parent' => 0
			));
			$parent_term_list = wp_get_post_terms( $pet_id, 'ap_cat', array( 'parent' => 0, 'hide_empty' => 0,'fields' => 'ids' ) );

			if(!empty($parent_term_list)){

				$breeds=get_terms( array(
				    'taxonomy' => 'ap_cat',
				    'hide_empty' => false,
				    'parent' => $parent_term_list[0],
				));	
			}


			$child_term_list=wp_get_post_terms( $pet_id, 'ap_cat', array( 'parent' => $parent_term_list[0], 'hide_empty' => 0,'fields' => 'ids' ) );

			// echo "<pre>",
			// print_r($countries);
			// exit;

			require_once(AP_DIR.'/public/edit_form.php');

		// add_action('wp_footer', function(){
	 		 include_once(AP_DIR.'/public/footer.php');
		// });

		}
		else{

			$url = site_url().'/my-pets';
			echo "
		        <script>
		                window.location = '".$url."';
		        </script>
		    ";
		}	

		
	}

	// public function show_search_form() {
		

		// $pets= get_terms( array(
		//     'taxonomy' => 'ap_cat',
		//     'hide_empty' => false,
		//     'parent' => 0
		// ) );	

		// require_once(AP_DIR.'/public/search_form.php');

		// add_action('wp_footer', function(){
	 		 // include_once(AP_DIR.'/public/footer.php');
		// });
	// }

	public function show_pets() {
		
		global $wpdb;

	    $pet_id = $_GET['cid'];
	    $breed_id = $_GET['bid'];
	    $city = $_GET['city'];
	    $gender = $_GET['g'];
	    $sell_adopt = $_GET['type'];

	    if(!empty($pet_id) && !empty($breed_id)){
	       $query = 'SELECT * FROM '.$wpdb->prefix.'posts WHERE post_type="ap-pet" AND post_status = "publish" AND ID IN (
	            SELECT object_id FROM '.$wpdb->prefix.'term_relationships WHERE term_taxonomy_id IN (
	            SELECT term_taxonomy_id FROM '.$wpdb->prefix.'term_taxonomy WHERE taxonomy = "ap_cat" AND term_id IN (
	                    SELECT t.term_id FROM '.$wpdb->prefix.'terms t WHERE t.term_id IN ('.$breed_id.')
	                )
	            )
	        )'; 
	    }
	    else if(!empty($pet_id) && empty($breed_id)){
	       $query = 'SELECT * FROM '.$wpdb->prefix.'posts WHERE post_type="ap-pet" AND post_status = "publish" AND ID IN (
	            SELECT object_id FROM '.$wpdb->prefix.'term_relationships WHERE term_taxonomy_id IN (
	            SELECT term_taxonomy_id FROM '.$wpdb->prefix.'term_taxonomy WHERE taxonomy = "ap_cat" AND term_id IN (
	                    SELECT t.term_id FROM '.$wpdb->prefix.'terms t WHERE t.term_id IN ('.$pet_id.')
	                )
	            )
	        )'; 
	    }


	    $results = $wpdb->get_results($query);

	    $pets = [];

	    // echo "<pre>", print_r($query); exit;
	    if(!empty($results)){
		    foreach ($results as $key => $value) {

		        $value->city = get_post_meta($value->ID, '_city', true);
		        $value->gender = get_post_meta($value->ID, '_gender', true);
		        $value->sell_adopt = get_post_meta($value->ID, '_sell_adopt', true);
		        $value->price = get_post_meta($value->ID, '_price', true);
		        $value->phone = get_post_meta($value->ID, '_phone', true);

		        $value->src = get_the_post_thumbnail_url($value->ID);
		        // 

		        if(!empty($city) && !empty($gender) && !empty($sell_adopt) ){

		        	if($value->gender == $gender &&  strpos($value->city, $city) !== false &&  $value->sell_adopt == $sell_adopt){
			            $pets[] = $value;
			        }
		        }
		        else if(empty($city) && !empty($gender) && !empty($sell_adopt) ){

		        	if($value->gender == $gender &&  $value->sell_adopt == $sell_adopt){
			            $pets[] = $value;
			        }
		        }
		        else if(!empty($city) && empty($gender) && !empty($sell_adopt) ){

		        	if(strpos($value->city, $city) !== false &&  $value->sell_adopt == $sell_adopt){
			            $pets[] = $value;
			        }
		        }
		        else if(empty($city) && empty($gender) && !empty($sell_adopt) ){

		        	if( $value->sell_adopt == $sell_adopt){
			            $pets[] = $value;
			        }
		        }
		        
		    }
		}
		$pets_cat= get_terms( array(
  		    'taxonomy' => 'ap_cat',
  		    'hide_empty' => false,
  		    'parent' => 0
  		  ) );

		require_once(AP_DIR.'/public/show_pets.php');

		add_action('wp_footer', function(){
	 		 include_once(AP_DIR.'/public/footer.php');
		});
	}

	public function my_pets() {
		
		global $wpdb;

	    global $current_user;                     

		$query = 'SELECT * FROM '.$wpdb->prefix.'posts WHERE post_type="ap-pet" AND ( post_status = "publish" OR post_status = "pending" ) AND post_author = '.$current_user->ID.' ORDER BY post_date DESC';


		$current_user_posts = $wpdb->get_results($query);

	    foreach ($current_user_posts as $key => $value) {

	        $value->location = get_post_meta($value->ID, '_location', true);
	        $value->gender = get_post_meta($value->ID, '_gender', true);
	        $value->sell_adopt = get_post_meta($value->ID, '_sell_adopt', true);
	        $value->price = get_post_meta($value->ID, '_price', true);
	        $value->phone = get_post_meta($value->ID, '_phone', true);
	        $value->src = get_the_post_thumbnail_url($value->ID);

		}

		require_once(AP_DIR.'/public/my_pets.php');

		add_action('wp_footer', function(){
	 		 include_once(AP_DIR.'/public/footer.php');
		});
	}

}

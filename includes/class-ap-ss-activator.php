<?php

/**
 * Fired during plugin activation
 *
 * @link       http://dev.technology-architects.com/petgolu/
 * @since      1.0.0
 *
 * @package    Ap_Ss
 * @subpackage Ap_Ss/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ap_Ss
 * @subpackage Ap_Ss/includes
 * @author     Technology Architects
 */
class Ap_Ss_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// add jersey-tool-page
	
		$add_pet_page = get_page_by_title('Add Pet');
		$edit_pet_page = get_page_by_title('Edit Pet');
		$pets = get_page_by_title('Pets');
		$mypets = get_page_by_title('My Pets');

		if(!$add_pet_page) {
			//insert page 
			wp_insert_post(array(
				'post_title' => 'Add Pet',
				'post_content' => '[ap_show_add_form]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed'
			));
		}
		if(!$edit_pet_page) {
			//insert page 
			wp_insert_post(array(
				'post_title' => 'Edit Pet',
				'post_content' => '[ap_show_edit_form]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed'
			));
		}
		else if(!$pets) {
			//insert page 
			wp_insert_post(array(
				'post_title' => 'Pets',
				'post_content' => '[ap_show_pets]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed'
			));
		}
		else if(!$mypets) {
			//insert page 
			wp_insert_post(array(
				'post_title' => 'My Pets',
				'post_content' => '[ap_my_pets]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed'
			));
		}
		else { // if page in trashed, draft

			$add_pet_page->post_status = 'publish';
			$edit_pet_page->post_status = 'publish';
			$pets->post_status = 'publish';
			$mypets->post_status = 'publish';

			wp_update_post($add_pet_page);
			wp_update_post($edit_pet_page);
			wp_update_post($pets);
			wp_update_post($mypets);

		}
	}

}

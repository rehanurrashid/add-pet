<?php 

add_action('wp_ajax_nopriv_ap_post_by_id', 'ap_get_ap_post_by_id');
add_action('wp_ajax_ap_post_by_id', 'ap_get_ap_post_by_id');
function ap_get_ap_post_by_id() {
    $id = $_POST['id'];
    
    if(!isset($id) && empty($id)) die('{"error":"id is empty."}');
    
    $tpl = get_post_meta( $id, '_ap_post', true );
    echo json_encode($tpl);
    
    die();
}

add_action('wp_ajax_nopriv_ap_city_list', 'ap_city_list');
add_action('wp_ajax_ap_city_list', 'ap_city_list');
function ap_city_list()
{
    global $wpdb;
    $id = $_GET['id'];
    $query="SELECT * from cities where country_id='$id'";
    $results = $wpdb->get_results($query);
    wp_send_json_success( $results);
}

add_action( 'wp_ajax_nopriv_upload', 'ap_upload' );
add_action( 'wp_ajax_upload', 'ap_upload' );
function ap_upload() {
    $uploadpath = wp_upload_dir();
    $upload_dir = $uploadpath['basedir'].'/ap_postupload';
    $upload_url = $uploadpath['baseurl'].'/ap_postupload';

    if(!is_dir($upload_dir))
        mkdir($upload_dir);

    $img = $_POST['form1_data1'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $name = uniqid().$_POST['form1_data2'];
    $file = $upload_dir.'/'. $name;
    $success = file_put_contents($file, $data);
    echo $upload_url.'/'.$name;
    die();
}

###########################################################################################################################

//  not using when used I wil remove comment...
add_action('wp_ajax_nopriv_search_pets', 'ap_search_pets');
add_action('wp_ajax_search_pets', 'ap_search_pets');

function ap_search_pets() {

    global $wpdb;

    $pet_id = $_POST['pet_id'];
    $breed_id = $_POST['breed_id'];
    $location = $_POST['location'];
    $gender = $_POST['gender'];
    $sell_adopt = $_POST['sell_adopt'];

    $query = 'SELECT * FROM '.$wpdb->prefix.'posts WHERE post_type="ap-pet" AND post_status = "publish" AND ID IN (
        SELECT object_id FROM '.$wpdb->prefix.'term_relationships WHERE term_taxonomy_id IN (
        SELECT term_taxonomy_id FROM '.$wpdb->prefix.'term_taxonomy WHERE taxonomy = "ap_cat" AND term_id IN (
                SELECT t.term_id FROM '.$wpdb->prefix.'terms t WHERE t.term_id IN ('.$breed_id.')
            )
        )
    )';

    $results = $wpdb->get_results($query);


    $filterd_results = [];

    foreach ($results as $key => $value) {

        $value->location = get_post_meta($value->ID, '_location', true);
        $value->gender = get_post_meta($value->ID, '_gender', true);
        $value->sell_adopt = get_post_meta($value->ID, '_sell_adopt', true);
        $value->price = get_post_meta($value->ID, '_price', true);
        $value->description = get_post_meta($value->ID, '_description', true);

        if($value->gender == $gender && strpos($value->location, $location) !== false &&  $value->sell_adopt == $sell_adopt){
            $filterd_results[] = $value;
        }
    }

    wp_send_json_success( $filterd_results);

    die();
}
 //  Fetching pet breeds
add_action('wp_ajax_nopriv_pet_child_cat', 'ap_pet_child_cat');
add_action('wp_ajax_pet_child_cat', 'ap_pet_child_cat');
function ap_pet_child_cat() {
    $id = $_POST['id'];
    $pets= get_terms( array(
            'taxonomy' => 'ap_cat',
            'hide_empty' => false,
            'parent' => $id
        ) );
    wp_send_json_success( $pets);
    die();
}

// delete pet by id

add_action('wp_ajax_nopriv_delete_pet_by_id', 'ap_delete_pet_by_id');

add_action('wp_ajax_delete_pet_by_id', 'ap_delete_pet_by_id');

function ap_delete_pet_by_id() {

    global $wpdb;

    $pet_id = $_POST['pet_id'];

    $wpdb->delete( $wpdb->prefix.'posts', array(

        'ID' => $pet_id 

    ));

    echo '{"pet_id":'.$pet_id.', "message":"Pet Deleted, Successfully!"}';

    die();

}


//  save pet post
add_action('wp_ajax_nopriv_save_ap_post', 'ap_save_ap_post');
add_action('wp_ajax_save_ap_post', 'ap_save_ap_post');
function ap_save_ap_post() {

    global $wpdb;
    // echo "<pre>",print_r($_POST);exit;
    $user_id = $_POST['user_id'];
    $pet = $_POST['pet_category_id'];
    $breed = $_POST['pet_breed_id'];
    $gender = $_POST['pet_gender_input'];
    $title = $_POST['post_title'];
    $description = $_POST['description'];
    $sell_adopt = $_POST['sell_adopt'];
    $price = (isset($_POST['price']))? $_POST['price'] : '';
    $image_gallary = ( isset($_FILES['image_gallary']) )? $_FILES['image_gallary'] : '';
    $featured_image = (isset($_FILES['featured_image']) && $_FILES['featured_image']['name'] !== null)? $_FILES['featured_image'] : '';
    $country = (isset($_POST['country']))? $_POST['country'] : '';
    $country_id = (isset($_POST['country_id']))? $_POST['country_id'] : '';
    $city = (isset($_POST['city']))? $_POST['city'] : '';
    $city_id = (isset($_POST['city_id']))? $_POST['city_id'] : '';
    $phone = $_POST["carrierCode"].' '.preg_replace('/\s+/', '', $_POST['phoneNumber']);
    $startDate = (isset($_POST['startDate']))? $_POST['startDate'] : '';
    $endDate = (isset($_POST['endDate']))? $_POST['endDate'] : '';
    

    $post = array(
        'post_author' => $user_id,
        'post_title' => isset($title)?$title:'No title',
        'post_content' => isset($content)?$content:'No Content',
        'post_status' => "pending",
        'post_type' => 'ap-pet',
    );

    $post_id = wp_insert_post( $post, $wp_error );

    if($post_id){
        if(isset($gender))
            add_post_meta( $post_id, '_gender', $gender );

        if(isset($sell_adopt))
            add_post_meta( $post_id, '_sell_adopt', $sell_adopt );

        if(isset($price))
            add_post_meta( $post_id, '_price', $price );

        if(isset($country))
            add_post_meta( $post_id, '_country', $country );

        if(isset($country_id))
            add_post_meta( $post_id, '_country_id', $country_id );

        if(isset($city))
            add_post_meta( $post_id, '_city', $city );

        if(isset($city_id))
            add_post_meta( $post_id, '_city_id', $city_id );

        if(isset($phone))
            add_post_meta( $post_id, '_phone', $phone );

        if(isset($startDate))
            add_post_meta( $post_id, '_startDate', $startDate );

        if(isset($endDate))
            add_post_meta( $post_id, '_endDate', $endDate );

        if(isset($description))
            add_post_meta( $post_id, '_description', $description );

        $table = $wpdb->prefix.'term_relationships';
        $datae = array('object_id' => $post_id, 'term_taxonomy_id' => $pet);
        $formate = array('%s','%d');
        $wpdb->insert($table,$datae,$formate);

        $data = array('object_id' => $post_id, 'term_taxonomy_id' => $breed);
        $format = array('%s','%d');
        $wpdb->insert($table,$data,$format);

        if(isset($featured_image) && $featured_image['name'] !== '' ){

            $thumbnail_id = upload_featured_image($featured_image);
            if($thumbnail_id)
                update_post_meta($post_id, '_thumbnail_id', $thumbnail_id);

        }

        if(isset($image_gallary) && !empty($image_gallary) && count($image_gallary) > 0 ){

            $attach_ids = upload_gallary_images($image_gallary);

            if($attach_ids)
                update_post_meta($post_id, '_image_gallary', $attach_ids);
        }

        echo json_encode(array(
            'status' => 'success',
            'id' => $post_id,
        ));

    } else {
        echo json_encode(array(
            'status' => 'error',
            'error' => 'Please try later, something got wrong!'
        ));
    }

    die();
}

// update pet post

add_action('wp_ajax_nopriv_update_ap_post', 'ap_update_ap_post');
add_action('wp_ajax_update_ap_post', 'ap_update_ap_post');
function ap_update_ap_post() {

    global $wpdb;
    // echo "<pre>",print_r($_POST);exit;
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $pet = $_POST['pet_category_id'];
    $breed = $_POST['pet_breed_id'];
    $gender = $_POST['pet_gender_input'];
    $title = $_POST['post_title'];
    $description = $_POST['description'];
    $sell_adopt = $_POST['sell_adopt'];
    $price = (isset($_POST['price']))? $_POST['price'] : '';
    $image_gallary = ( isset($_FILES['image_gallary']) )? $_FILES['image_gallary'] : '';
    $featured_image = (isset($_FILES['featured_image']) && $_FILES['featured_image']['name'] !== null)? $_FILES['featured_image'] : '';
    $country = (isset($_POST['country']))? $_POST['country'] : '';
    $country_id = (isset($_POST['country_id']))? $_POST['country_id'] : '';
    $city = (isset($_POST['city']))? $_POST['city'] : '';
    $city_id = (isset($_POST['city_id']))? $_POST['city_id'] : '';
    $phone = $_POST["carrierCode"].' '.preg_replace('/\s+/', '', $_POST['phoneNumber']);
    $startDate = (isset($_POST['startDate']))? $_POST['startDate'] : '';
    $endDate = (isset($_POST['endDate']))? $_POST['endDate'] : '';

    $post = array(
        'ID' => $post_id,
        'post_author' => $user_id,
        'post_title' => isset($title)?$title:'No title',
        'post_content' => isset($content)?$content:'No Content',
        'post_status' => "pending",
        'post_type' => 'ap-pet',
    );

    $post_id = wp_update_post( $post, $wp_error );

    if($post_id){
        if(isset($gender))
            update_post_meta( $post_id, '_gender', $gender );

        if(isset($sell_adopt))
            update_post_meta( $post_id, '_sell_adopt', $sell_adopt );

        if(isset($price))
            update_post_meta( $post_id, '_price', $price );

        if(isset($country))
            update_post_meta( $post_id, '_country', $country );

        if(isset($country_id))
            update_post_meta( $post_id, '_country_id', $country_id );

        if(isset($city))
            update_post_meta( $post_id, '_city', $city );

        if(isset($city_id))
            update_post_meta( $post_id, '_city_id', $city_id );

        if(isset($phone))
            update_post_meta( $post_id, '_phone', $phone );

        if(isset($startDate))
            update_post_meta( $post_id, '_startDate', $startDate );

        if(isset($endDate))
            update_post_meta( $post_id, '_endDate', $endDate );

        if(isset($description))
            update_post_meta( $post_id, '_description', $description );

        // updating categories
        $term_name = get_term( $pet )->name;
        wp_set_object_terms($post_id, $term_name, 'ap_cat');

        $table = $wpdb->prefix.'term_relationships';
        $data = array('object_id' => $post_id, 'term_taxonomy_id' => $breed);
        $format = array('%s','%d');
        $wpdb->insert($table,$data,$format);

         


        if(isset($featured_image) && $featured_image['name'] !== '' ){

            $thumbnail_id = upload_featured_image($featured_image);


            if($thumbnail_id)
                update_post_meta($post_id, '_thumbnail_id', $thumbnail_id);

        }

        

        if(isset($image_gallary) && !empty($image_gallary) && count($image_gallary) > 0 ){


            $attach_ids = upload_gallary_images($image_gallary);

            if($attach_ids)
                update_post_meta($post_id, '_image_gallary', $attach_ids);
        }

        echo json_encode(array(
            'status' => 'success',
            'id' => $image_gallary,
        ));

    } else {
        echo json_encode(array(
            'status' => 'error',
            'error' => 'Please try later, something got wrong!'
        ));
    }

    die();
}

// upload pets images
function upload_gallary_images($image_gallary){

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $attach_ids = [];

    foreach ($image_gallary['name'] as $key => $value) {
        if ($image_gallary['name'][$key]) {
            $file = array(
                'name' => $image_gallary['name'][$key],
                'type' => $image_gallary['type'][$key],
                'tmp_name' => $image_gallary['tmp_name'][$key],
                'error' => $image_gallary['error'][$key],
                'size' => $image_gallary['size'][$key]
            );

            $_FILES = array("image_gallary" => $file);

            $attachment_id = media_handle_upload("image_gallary", 0);
            

            if (is_wp_error($attachment_id)) {
                // There was an error uploading the image.
            } else {
                // The image was uploaded successfully!
                $attach_ids[] = $attachment_id;
                // wp_get_attachment_image($attachment_id, array(800, 600)) . "<br>"; //Display the uploaded image with a size you wish. In this case it is 800x600
            }
        }
    }

    return $attach_ids;
}

// upload single image
function upload_featured_image($featured_image){

    $wordpress_upload_dir = wp_upload_dir();

    $i = 1; // number of tries when the file with the same name is already exists
 
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $featured_image['name'];
    $new_file_mime = mime_content_type( $featured_image['tmp_name'] );
    
    if( empty( $featured_image ) )
        die( 'File is not selected.' );
     
    if( $featured_image['error'] )
        die( $featured_image['error'] );
     
    if( $featured_image['size'] > wp_max_upload_size() )
        die( 'It is too large than expected.' );
     
    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
        die( 'WordPress doesn\'t allow this type of uploads.' );
     
    while( file_exists( $new_file_path ) ) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $featured_image['name'];
    }

    // looks like everything is OK
    if( move_uploaded_file( $featured_image['tmp_name'], $new_file_path ) ) {
     
     
        $attachment_id = wp_insert_attachment( array(
            'guid'           => $new_file_path, 
            'post_mime_type' => $new_file_mime,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $featured_image['name'] ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ), $new_file_path );
     
        // wp_generate_attachment_metadata() won't work if you do not include this file
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
     
        // Generate and save the attachment metas into the database
        wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $new_file_path ) );
     
        // Show the uploaded file in browser
        // wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
        
        return $attachment_id;
    }

}
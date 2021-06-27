<?php
/**
 * @author: Technology Architects
 * @version: 1.0
 * @link: http://dev.technology-architects.com/petgolu/
 * 
 * License: GPL-2.0+
 */
    
    $ap_form_bg = get_option( 'ap-selected_theme' );
    
?>
<head>
    <meta charset="utf-8">

</head>
<script>
    window.ap = {
        post_id: "<?php echo $_GET['id'] ?>",
        user_id: "<?php echo get_current_user_id(); ?>",
        site_url:"<?php echo site_url() ?>",
        url:"<?php echo AP_URL; ?>",
        ajax_url:"<?php echo admin_url('admin-ajax.php'); ?>",
        user_location:"<?php echo $location; ?>",
        _phone:"<?php echo (isset($PostMeta["_phone"]) && isset($PostMeta["_phone"][0]))? $PostMeta["_phone"][0] : '' ; ?>",
    };
</script>
    <div class="main">
        <section class="ap">
            <a class="btn my-pets" href="<?php echo site_url().'/my-pets'?>">My Pets</a>
            <div class="container box">
                <div class="ap-content" style="background-color: <?php echo $ap_form_bg; ?>">
                    <form method="POST" id="edit_ap_post" class="ap-form" enctype="multipart/form-data">
                        <h2 class="form-title">Edit Pet</h2>
                            <div class="form-group">
                                <select required name="pet_category_id" id="pet_category_id" class="form-control">
                                  <option value="">--Select Pet--</option>
                                  <?php if(isset($pets) && !empty($pets)): ?>
                                    
                                    <?php foreach ($pets as $value): ?>

                                      <option <?=(isset($parent_term_list) && !empty($parent_term_list) && in_array($value->term_id,$parent_term_list))?'selected':''?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>

                                    <?php endforeach; endif; ?>
                              </select>
                           </div>
                           <div class="form-group">
                              <select required  name="pet_breed_id" id="pet_breed_id" class="form-control">
                                 <option value="">Please Select Breed</option>
                                 <?php if(isset($breeds) && !empty($breeds)){ 
                                     foreach($breeds as $breed) { ?>
                                        <option <?=(isset($child_term_list) && !empty($child_term_list) && in_array($breed->term_id,$child_term_list))?'selected':''?> value="<?=$breed->term_id?>"><?=$breed->name?></option>
                                <?php   } } ?>
                              </select>
                           </div>
                           <p id="pet_breed_error" class="mb-2 ml-1" style="display:none; color:#B81111;">
                              Pet Breed is required.
                            </p>
                           <div class="form-group">
                              <select  required  class="form-control" name="pet_gender_input" id="pet_gender_input">
                                 <option <?=(isset($PostMeta["_gender"]) && isset($PostMeta["_gender"][0])   && $PostMeta["_gender"][0]=="male")?'selected':''?> value="male">Male</option>
                                 <option  <?=(isset($PostMeta["_gender"]) && isset($PostMeta["_gender"][0])   && $PostMeta["_gender"][0]=="female")?'selected':''?> value="female">Female</option>
                              </select>
                           </div>
                           <p id="pet_gender_error" class="mb-2 ml-1" style="display:none; color:#B81111;">
                              Pet gender is required.
                            </p>
                        <div class="form-group">
                            <input value="<?=(isset($current_user_post[0]->post_title)) ?$current_user_post[0]->post_title:''?>" type="text" class="form-input" name="post_title" id="post_title"  placeholder="Title" required />
                            <small class="text-muted">
                              Mention the key features of your pet (e.g. brand, model, age, type)
                            </small>
                            <p id="title_required" class="mt-1 ml-1" style="display:none; color:#B81111;">
                              Title is required!
                            </p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="description" rows="6" placeholder="Description" required><?=(isset($PostMeta["_description"]) && isset($PostMeta["_description"][0]))?$PostMeta["_description"][0]:''?></textarea>
                            <small class="text-muted">
                              Include condition, features and reason for selling
                            </small>
                            <p id="description_error" class="mt-1 ml-1" style="display:none; color:#B81111;">
                              Description is required!
                            </p>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input pointer" type="radio" name="sell_adopt" id="sell" value="sell" <?=(isset($PostMeta["_sell_adopt"]) && isset($PostMeta["_sell_adopt"][0]) && $PostMeta["_sell_adopt"][0]=="sell")?'checked':''?>>
                              <label class="form-check-label pointer" for="sell">
                                You want to sell?
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input pointer" type="radio" name="sell_adopt" id="adopt" value="adopt" <?=(isset($PostMeta["_sell_adopt"]) && isset($PostMeta["_sell_adopt"][0]) && $PostMeta["_sell_adopt"][0]=="adopt")?'checked':''?>>
                              <label class="form-check-label pointer" for="adopt">
                                You want someone to adopt?
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input pointer" type="radio" name="sell_adopt" id="pet-sitting" value="pet-sitting" <?=(isset($PostMeta["_sell_adopt"]) && isset($PostMeta["_sell_adopt"][0]) && $PostMeta["_sell_adopt"][0]=="pet-sitting")?'checked':''?>>
                              <label class="form-check-label pointer" for="pet-sitting">
                                Pet sitting?
                              </label>
                            </div>
                        </div>
                        <div class="form-group price-div" style="display:<?=(isset($PostMeta["_sell_adopt"]) && isset($PostMeta["_sell_adopt"][0]) && $PostMeta["_sell_adopt"][0]=="sell")?'block':'none'?>">
                         <div class="col-auto">
                          <label class="sr-only" for="inlineFormInputGroup">Price</label>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">Rs.</div>
                            </div>
                            <input type="number" min="50" value="<?=(isset($PostMeta["_price"]) && isset($PostMeta["_price"][0]))?$PostMeta["_price"][0]:''?>" step="any" name="price" class="form-control" id="price"  placeholder="Price"/>
                          </div>
                          <p id="price_error_required" class="mt-1 ml-1" style="display:none; color:#B81111;">
                              Price is required!
                            </p>
                        </div>
                        </div>
                        <div class="form-group pet-sitting-div" style="display:<?=(isset($PostMeta["_sell_adopt"]) && isset($PostMeta["_sell_adopt"][0]) && $PostMeta["_sell_adopt"][0]=="pet-sitting")?'block':'none'?>">
                        <hr class="mt-3">
                         <div class="col-auto">
                         	<p class="mb-4 text-dark">Select date between which some take care of your pet.</p>
                        	<label for="birthday"><b>From:</b></label>
            							<input type="date" id="startDate" value="<?=(isset($PostMeta["_startDate"]) && isset($PostMeta["_startDate"][0]))?$PostMeta["_startDate"][0]:''?>" name="startDate">
            							<label for="birthday"><b>Till:</b></label>
            							<input type="date" id="endDate" value="<?=(isset($PostMeta["_endDate"]) && isset($PostMeta["_endDate"][0]))?$PostMeta["_endDate"][0]:''?>" name="endDate">

            							<p id="valid_startDate" class="mt-1 ml-1" style="display:none; color:#B81111;">
	                              Start date must be equal or greater than today!
	                        </p>

	                        <p id="valid_endDate" class="mt-1 ml-1" style="display:none; color:#B81111;">
	                              End date must be greater than today!
	                        </p>

	                        <p id="startDate_endDate" class="mt-1 ml-1" style="display:none; color:#B81111;">
	                              End date must be greater than start Date!
	                        </p>

	                        <p id="select_startDate" class="mt-1 ml-1" style="display:none; color:#B81111;">
	                              Please select start date first!
	                        </p>

	                        <p id="start_end_date_required" class="mt-1 ml-1" style="display:none; color:#B81111;">
	                              End date is required!
	                        </p>
                        </div>
                        </div>
                        <hr class="mt-3">
                        <div class="form-group image-upload text-center">
                        <label for="image_gallary">
                            <h4 class="mt-4">Reference (attachment-optional)</h4>
                            <h6>Formate: PNG,JPG,JPEG ,Max File Size: 5MB</h6>
                            <h6>Select All Images At Once</h6>'
                            <div class="upload-btn">
                            <i class="fa fa-upload "></i> <span  style="font-size: 18px; font-weight: 600;">Upload</span>
                            </div>
                        </label>

                        <input type="file" accept="image/jpg, image/jpeg, image/png" name="image_gallary[]" id="image_gallary" multiple>

                        <p id="image_gallary_error1" style="display:none; color:#B81111;">
                          Invalid File Format! File Format Must Be PNG,JPG,JPEG.
                        </p>

                        <p id="image_gallary_error2" style="display:none; color:#B81111;">
                           Maximum File Size Limit is 5MB.
                        </p>
                        </div>
                        <div id="gallary_image_output">

                          <?php 

                          if(isset($_image_gallary) && !empty($_image_gallary)) : 
                            foreach($_image_gallary as $key => $value) : 
                              $src = wp_get_attachment_url($value);
                          ?>

                          <img src="<?php echo $src; ?>" class="img-thumbnail" />

                          <?php
                            endforeach; 
                            endif;
                          ?>

                        </div>

                        <div class="form-group image-upload text-center">
                        <label for="featured_image">
                            <h4 class="mt-4">Featured Image</h4>
                            <h6>Formate: PNG,JPG,JPEG ,Max File Size: 5MB</h6>
                            <div class="upload-btn f_img_u_btn">
                            <i class="fa fa-upload "></i> <span  style="font-size: 18px; font-weight: 600;">Upload</span>
                            </div>
                        </label>

                        <input  type="file" accept="image/jpg, image/jpeg, image/png" name="featured_image" id="featured_image">

                        <p id="featured_image_error1" style="display:none; color:#B81111;">
                          Invalid File Format! File Format Must Be PNG,JPG,JPEG.
                        </p>

                        <p id="featured_image_error2" style="display:none; color:#B81111;">
                           Maximum File Size Limit is 5MB.
                        </p>

                        <p id="featured_image_error3" style="display:none; color:#B81111;">
                           Featured Image is required.
                        </p>

                        <div id="featured_image_output_div">
                          <img src="<?=(isset($PostMeta["_thumbnail_id"]) && isset($PostMeta["_thumbnail_id"][0]))?wp_get_attachment_image_src($PostMeta["_thumbnail_id"][0],"thumbnail")[0]:''?>" class="img-thumbnail" id="featured_image_output" width="320" /> 
                        </div>
                        </div>
                      
                        <hr class="">
                        <!-- <div class="form-group">
                            <a class="btn location selected_location" value="location_list">List</a>
                            <a class="btn location" value="location_current" >Current Location</a>
                        </div> -->
                          <div class="form-group">
                             <label>Country</label>
                              <select class="form-control" name="country" required id="country">
                                <?php foreach($countries as $country){ ?>
                                  <option <?=(isset($PostMeta["_country"]) && isset($PostMeta["_country"][0]) && in_array($country->name,$PostMeta["_country"]))?'selected':''?> data-countryid="<?=$country->id?>" value="<?=$country->name?>"><span><?=$country->emoji?></span> <?=$country->name?> </option>
                                <?php } ?>
                              </select>
                           </div>
                           <div class="form-group">
                              <label>City</label>
                              <select class="form-control" name="city" required id="city">
                                  <option value="">Choose City</option>
                                  <?php if(isset($cities) && !empty($cities)){ 
                                     foreach($cities as $city) { ?>
                                        <option <?=(isset($PostMeta["_city"]) && !empty($PostMeta["_city"]) && in_array($city->name,$PostMeta["_city"]))?'selected':''?> value="<?=$city->name?>" data-cityid="<?=$city->id?>" ><?=$city->name?></option>
                                <?php   } } ?>
                              </select>
                        </div>
                        <div class="form-group" id="location_current">
                            <h6 class="text-muted">Your current location is <?php echo $location; ?>.</h6>
                        </div>
                        <p id="location_error" class="mb-2 ml-1" style="display:none; color:#B81111;">
                            Location is required.
                        </p>
                        <div class="input-phone"></div>
                        <p id="phoneNumber_error" class="mt-1 ml-1" style="display:none; color:#B81111;">
                              Phone number is required!
                        </p>
                        <div class="form-check mt-5 mb-2 d-none">
                            <input checked type="checkbox" class="form-check-input" id="agree_term" name="agree_term" required>
                            <label class="form-check-label" for="exampleCheck1">I agree all statements in  <a href="#" class="text-primary">Terms of service</a></label>

                            <p id="agree_term_error" class="mt-1 ml-1" style="display:none; color:#B81111;">
                              You must accept our Terms of service.
                            </p>

                        </div>
                      
                        <div class="form-group  mt-5 submit-div">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <input type="submit" class="form-submit" value="Update Pet" id="btn-update-form" />
                        </div>

                        <div class="form-group response_alerts">
                            <div class="alert mt-1 font-weight-bold response_message" role="alert" style="display: none;">
                            </div>
                            <div class="alert alert-warning mt-1 font-weight-bold" role="alert" style="display: none;">
                              Please fill out complete form. Required field is missing!
                            </div>
                        </div>

                        <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
                        <?php wp_nonce_field( 'wps-frontend-post' ); ?>

                    </form>
                </div>
            </div>
        </section>

    </div>


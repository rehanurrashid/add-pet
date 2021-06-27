<?php
/**
 * @author: Technology Architects
 * @version: 1.0
 * @link: http://dev.technology-architects.com/petgolu/
 * 
 * License: GPL-2.0+
 */
    
    $ap_form_bg = get_option( 'ap-selected_theme' );
    $filter_opt = get_option( 'ap-filter-option' );

?>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo AP_URL.'public/css/main.css'?>">
</head>
<script>
    window.ap = {
        id: "<?php echo $_GET['id'] ?>",
        user_id: "<?php echo get_current_user_id(); ?>",
        site_url:"<?php echo site_url() ?>",
        url:"<?php echo AP_URL; ?>",
        ajax_url:"<?php echo admin_url('admin-ajax.php'); ?>",
        user_location:"<?php echo $location; ?>",
    };
</script>

    <div class="main" id="show_pets">
        <section class="filter_pets" style="width:<?php echo (isset($filter_opt) && $filter_opt=='YES')?'':'100%'; ?>">
            <div class="container box">
                <div class="ap-content" style="background-color: <?php echo $ap_form_bg; ?>">
                        
                    <?php if(isset($pets) && !empty($pets)): ?>
                    <div class="row">
                    <?php foreach($pets as $pet): ?>
                             <div class="col-3 pet_post" style="width: <?= (count($pets) < 3)? '50%':''; ?>">
                                 <div class="img-wrap">
                                    <img class="card-img-top" src="<?php echo $pet->src; ?>" alt="Card image cap">
                                </div>
                                <div class="card-body">
                                  <h5 class="card-title"><?php echo $pet->post_title; ?></h5>

                                  <?php $type = get_post_meta($post->ID, '_sell_adopt', true); ?>
                                  <?php if($type == 'sell'): ?>
                                  <p class="card-text">Price: <b class="text-muted">Rs.<?php echo $pet->price; ?></b></p>
                                  <?php endif;?>
                                  
                                  <?php if($type == 'adopt'): ?>
                                  <p class="card-text"><b class="text-muted">Available to Adopt</b></p>
                                  <?php endif;?>

                                  <?php if($type == 'pet-sitting'): ?>
                                  <p class="card-text"><b class="text-muted">Available for Pet Setting</b></p>
                                  <?php endif;?>

                                  <a class="btn-view"  href="<?php echo $pet->guid; ?>">View Pet</a>
                                </div>
                              </div>
                    <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="row">
                            <h3>No Pets Found. Please Try Again !</h3>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>
        <?php if(isset($filter_opt) && $filter_opt=='YES'): ?>
        <section class="filters">
            <h3>Filters: </h3>
            <form method="post" action="<?php echo site_url().'/pets'?>">
              <div class="row text-center">
                <div class="col-20">
                  <div class="dropdown" id="location_list">
                    <div class="select">
                      <span>Location</span>
                      <i class="fa fa-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu">
                      <li value="Islamabad">Islamabad</li>
                      <li value="Karachi">Karachi</li>
                      <li value="Lahore">Lahore</li>
                    </ul>
                  </div>
                  <input type="hidden" name="location_input" id="location_input">
                </div>
                <div class="col-20">
                  <div class="dropdown" id="pet_cat">
                    <div class="select">
                      <span>Pet</span>
                      <i class="fa fa-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu">
                      <?php if(isset($pets_cat) && !empty($pets_cat)): ?>
                        <?php foreach ($pets_cat as $value): ?>
                          <li value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></li>
                        <?php endforeach; ?>
                        <?php else: ?>
                          <li value="-1">Loading...</li>
                        <?php endif;  ?>
                      </ul>
                    </div>
                    <p id="pet_category_req" >
                        Pet field is requied*
                    </p>
                  </div>
                  <input type="hidden" name="pet_category_id" id="pet_category_id">
                  <div class="col-20">
                    <div class="dropdown" id="pet_breed">
                      <div class="select">
                        <span>Breed</span>
                        <i class="fa fa-chevron-down"></i>
                      </div>
                      <ul class="dropdown-menu">
                        <li value="-1">Please Select Pet</li>
                      </ul>
                    </div>
                    <input type="hidden" name="pet_breed_id" id="pet_breed_id">
                  </div>
                  <div class="col-20">
                    <div class="dropdown" id="pet_gender">
                      <div class="select">
                        <span>Gender</span>
                        <i class="fa fa-chevron-down"></i>
                      </div>
                      <ul class="dropdown-menu">
                        <li value="male">Male</li>
                        <li value="female">Female</li>
                      </ul>
                    </div>
                    <input type="hidden" name="pet_gender_input" id="pet_gender_input">
                  </div>
                </div>
                <div class="row text-center">
                  <div class="form-check">
                    <input class="form-check-input pointer" type="radio" name="sell_adopt" id="sell" value="sell" checked>
                    <label class="form-check-label pointer" for="sell">BUY</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input pointer" type="radio" name="sell_adopt" id="adopt" value="adopt">
                    <label class="form-check-label pointer" for="adopt">ADOPT</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input pointer" type="radio" name="sell_adopt" id="petSell" value="petSell">
                    <label class="form-check-label pointer" for="petSell">PET SITTING</label>
                  </div>
                </div>
                <div class="search-pet">
                  <input type="submit" name="submit" value="Search" id="search_pet">
                </div>
              </form>
        </section>
      <?php endif; ?>
    </div>

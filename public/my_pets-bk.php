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

    <div class="main" id="my_pets">
        <section class="ap">
            <div class="container box">
                <div class="ap-content" style="background-color: <?php echo $ap_form_bg; ?>">
                        
                    <?php if(isset($current_user_posts) && !empty($current_user_posts)): ?>
                    <div class="row">
                    <?php foreach($current_user_posts as $pet): ?>
                        
                             <div class="col-3 pet_post">
                              <div class="img-wrap">
                                <img class="card-img-top" src="<?php echo $pet->src; ?>" alt="Card image cap">
                              </div>
                                <div class="card-body">
                                  <h5 class="card-title"><?php echo $pet->post_title; ?></h5>

                                  <?php $type = get_post_meta($pet->ID, '_sell_adopt', true); ?>
                                  <?php if($type == 'sell'): ?>
                                  <p class="card-text">Price: <b class="text-muted">Rs.<?php echo $pet->price; ?></b></p>
                                  <?php endif;?>

                                  <?php if($type == 'adopt'): ?>
                                  <p class="card-text"><b class="text-muted">Available to Adopt</b></p>
                                  <?php endif;?>

                                  <?php if($type == 'pet-sitting'): ?>
                                  <p class="card-text"><b class="text-muted">Available for Pet Setting</b></p>
                                  <?php endif;?>


                                  <a class="btn-view"  href="<?php echo $pet->guid; ?>">View</a>
                                  <a class="btn-edit"  href="<?php echo site_url().'/edit-pet/?id='.$pet->ID?>">Edit</a>
                                  <br>
                                  <a  class="btn-delete" href="#" data-id="<?php echo $pet->ID?>">Remove</a>
                                </div>
                              </div>
                        
                    <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="row">
                            <h3>You have no pets rightnow! Click below to add your pet.</h3>
                            <a class="btn my-pets" href="<?php echo site_url().'/add-pet/'?>">Add Pet</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    </div>

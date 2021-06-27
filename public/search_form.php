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
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo AP_URL.'public/css/bootstrap.min.css'?>"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo AP_URL.'public/css/search_form.css'?>">
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

<div class="container" id="app_pet_search_section">
	<div class="row">
		<h4 class="search_heading">Find you new pet</h4>

		<div class="custom-dropdown" id="pet_category">
           <div class="select">
              <span>Pet</span>
              <i class="fa fa-chevron-left"></i>
           </div>
           <ul class="dropdown-menu">
             <?php if(isset($pets) && !empty($pets)): ?>
                                  
               <?php foreach ($pets as $value): ?>

                 <li value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></li>

               <?php endforeach; ?>
                                  
             <?php else: ?>
               <li value="-1">Loading...</li>
             <?php endif; ?>
           </ul>
        </div>

	</div>
	
</div>
<script type="text/javascript" src="<?php echo AP_URL.'public/js/search.js'?>"></script>

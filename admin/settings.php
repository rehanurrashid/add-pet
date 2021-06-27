<div class="wrap theme-options">
	<h1>PLUGIN SETTINGS</h1>

<?php if(isset($notices) && !empty($notices)): 
	foreach($notices as $notice) : ?>
	<div class="notice <?php echo $notice['type']=='success'?'updated':'error'; ?> ap-notice is-dismissible" >
        <p><?php _e( $notice['message'], 'ap' ); ?></p>
    </div>
<?php endforeach;
endif; ?>

	<form action="" method="post" class="bt mt">
		<table class="form-table">
	        <tr valign="top">
	        	<th scope="row">Choose Theme : </th>
	        	<td>
	        		<select id="ap-selected_theme" name="ap-selected_theme" class="regular-text">
						<?php foreach ($theme_options as $option): ?>
							<option value="<?php echo $option['background-color']; ?>" <?php echo $option['background-color']===$selected_theme ? 'selected' : '' ?>><?php echo $option['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description" id="timezone-description">Choose Color Theme for your Add Pet Form.</p>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Show Filters : </th>
	        	<td>
	        		<input name="ap-filter-option" type="checkbox" <?php echo (isset($filter_opt) && $filter_opt=="YES")?'checked':''; ?> value="YES">
	        		<p class="description" id="filter-description">Display Filters(sidebar) on searched pets page</p>
	        	</td>
	        </tr> 
	        <!-- <tr valign="top">
	        	<th scope="row">Background Image for DesignArea : </th>
	        	<td>
        			<button class="button upload_image">Add Image</button>
        			<span class="addfile-parent">
				        <img width="50px" height="50px" src="<?php echo (isset($design_background) && !empty($design_background))?$baseurl.$design_background:AP_URL.'/admin/images/placeholder.png' ?>" alt="">
				        <input type="hidden" name="ap-design_background" value="<?php echo (isset($design_background) && !empty($design_background))?$design_background:'' ?>" required>
				        <span class="loader"></span>
			        </span>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row"> LOGO for Discount : </th>
	        	<td>
	        		<span class="inline-sec">
		        		<button class="button upload_image">Add Image</button>
		        		<span class="addfile-parent">
					        <img width="50px" height="50px" src="<?php echo (isset($logo['image']) && !empty($logo['image']))?$baseurl.$logo['image']:AP_URL.'/admin/images/placeholder.png' ?>" alt="">
					        <input type="hidden" name="ap-logo[image]" value="<?php echo (isset($logo['image']) && !empty($logo['image']))?$logo['image']:'' ?>" required>
					        <span class="loader"></span>
				       	</span>
	        		</span>
	        		<span class="inline-sec ml bl pl">
		        		<button class="button upload_svg">Add SVG</button>
		        		<span class="addfile-parent">
						    <img width="50px" height="50px" src="<?php echo (isset($logo['svg']) && !empty($logo['svg']))?$baseurl.$logo['svg']:AP_URL.'/admin/images/placeholder.png' ?>" alt="">
					        <input type="hidden" name="ap-logo[svg]" value="<?php echo (isset($logo['svg']) && !empty($logo['svg']))?$logo['svg']:'' ?>" required>
					        <span class="loader"></span>
					    </span>
					     <button class="button remove-file">x</button> 
	        		</span>
	        		<p class="description" id="timezone-description">You will needed to upload both files, .png and .svg file. By default it will used default png and svg file.</p>
	        	</td>
	        </tr>-->
	    </table>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>

</div>
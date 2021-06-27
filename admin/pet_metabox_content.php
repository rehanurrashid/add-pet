<script>
	var so = window.so || {};
	so.ap_url = "<?php echo AP_URL ?>";
</script>

<pre>
<?php 
	
	global $post;

	$_description = get_post_meta( $post->ID, '_description', true );
	$_gender = get_post_meta( $post->ID, '_gender', true );
	$_sell_adopt = get_post_meta( $post->ID, '_sell_adopt', true );
	$_price = get_post_meta( $post->ID, '_price', true );
	$_phone = get_post_meta( $post->ID, '_phone', true );
	$_country = get_post_meta( $post->ID, '_country', true );
	$_city = get_post_meta( $post->ID, '_city', true );
	$_startDate = get_post_meta( $post->ID, '_startDate', true );
	$_endDate = get_post_meta( $post->ID, '_endDate', true );
	$_featured = get_post_meta( $post->ID, '_featured', true );
	$_image_gallary = get_post_meta( $post->ID, '_image_gallary', true );
	
	if(!empty($_country)){

		$_location = $_country; 

		if(!empty($_city)){

			$_location = $_country . ', ' . $_city;

		}

	}

?>
</pre>

<div class="jersey-panel">
	<p class="jfield">
		<label class="jlabel">Description :</label>
		<textarea class="form-control" name="_description" id="description" rows="6" placeholder="Include condition, features and reason for selling" > <?php echo (isset($_description))? $_description:'' ?></textarea>
	</p>
	<p class="jfield">
		<label class="jlabel">Pet Gender :</label>
		<label><input name="_gender" type="radio" value="male" <?php echo (isset($_gender) || $_gender=='male')?'checked':'' ?> > Male</label>
		<label><input name="_gender" type="radio" value="female" <?php echo ($_gender=='female')?'checked':'' ?> > Female</label>
	</p>
	 
	<p class="jfield">
		<label class="jlabel">Sell/ Adopt :</label>
		<label><input name="_sell_adopt" type="radio" value="sell" <?php echo (isset($_sell_adopt) && $_sell_adopt=='sell')?'checked':'' ?> > You want to sell?</label>
		<label><input name="_sell_adopt" type="radio" value="adopt" <?php echo ($_sell_adopt=='adopt')?'checked':'' ?> > You want someone to adopt?</label>
		<label><input name="_sell_adopt" type="radio" value="pet-sitting" <?php echo ($_sell_adopt=='pet-sitting')?'checked':'' ?> > Pet Sitting?</label>
	</p>
	
	<p class="jfield price-div" style="display: <?php echo (isset($_sell_adopt) && $_sell_adopt=='sell')? '' :'none'; ?>">
		<label class="jlabel">Price :</label>
		<input type="number" min="50" step="any" name="_price" class="form-control" id="price" placeholder="Price" value="<?php echo (isset($_price))? $_price:'' ?>">
	</p>

	<p class="jfield pet-sitting-div" style="display: <?php echo (isset($_sell_adopt) && $_sell_adopt=='pet-sitting')? 'block' :'none'; ?>">
		<label class="jlabel">From :</label>
		<label >
			<input type="date"  name="_startDate" class="form-control" id="startDate"  placeholder="Price" value="<?php echo (isset($_startDate))? $_startDate:'' ?>">
		</label>

	</p>

	<p class="jfield pet-sitting-div" style="display: <?php echo (isset($_sell_adopt) && $_sell_adopt=='pet-sitting')? 'block' :'none'; ?>">

		<label class="jlabel">Till :</label>
		<label >
			<input type="date" name="_endDate" class="form-control" id="price"  placeholder="Price" value="<?php echo (isset($_endDate))? $_endDate:'' ?>">
		</label>

	</p>

	<p class="jfield">
		<label class="jlabel">Featured :</label>
		<label >
			<input type="checkbox" name="_featured" value="true" <?php echo (isset($_featured) && $_featured=='true')? 'checked' :''; ?>>
		</label>
	</p>

	<p class="jfield">
		<label class="jlabel">Location :</label>
		<label >
			<b><?php if(isset($_location)) { echo $_location; } else { echo ' No Location Selected!'; } ?> </b>
		</label>
	</p>

	<p class="jfield">
		<label class="jlabel">Phone Number :</label>
		<label >
			<b><?php if(isset($_phone)) { echo $_phone; } else { echo ' No phone number!'; } ?> </b>
		</label>
	</p>

	<div class="pet-images">
		<h3 class="bb pb">Pet Images :<button class="button add-btn">Add New Image</button></h3>
		<div class="jlist">
			<?php if(isset($_image_gallary) && !empty($_image_gallary)) : 
				foreach($_image_gallary as $key => $value) : 

					$src = wp_get_attachment_url($value);

					?>

				<div class="jitem p10" data-index="<?php echo $key ?>">
					<button class="button vm upload_image">Add Image</button>
				    <img class="vm" width="150px" height="150px" src="<?php echo (isset($src) && !empty($src))?$src:AP_URL.'/admin/images/placeholder.png' ?>" alt="">
				        <input name="image_gallary[]" type="hidden" value="<?php echo $value; ?>">
					<button class="button fr btn-delete">x</button>
				</div>
			<?php endforeach; 
			endif; ?>
		</div>
	</div>

</div>

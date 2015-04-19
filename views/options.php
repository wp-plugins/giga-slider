<div class="form-group">
	<label class="label"><?php _e('height', 'rc_slider') ?></label>
	<input class="widefat" type="text" name="options[height]" id="height" value="<?php echo esc_attr($height) ?>" />
</div>

<div class="form-group">
	<label class="label"><?php _e('Time', 'rc_slider') ?></label>
	<label class="label value" id="time_value"><?php echo esc_attr($time) ?> sec</label>
	<div class="rc-slider" id="time_slider"></div>
	<input type="hidden" name="options[time]" id="time" value="<?php echo esc_attr($time) ?>" />
	<span class="note"><?php _e('Seconds between the end of the sliding effect and the start of the nex one', 'rc_slider') ?></span>
</div>

<div class="form-group">
	<label class="label"><?php _e('Transition period', 'rc_slider') ?></label>
	<label class="label value" id="transition_period_value"><?php echo esc_attr($transition_period) ?> sec</label>
	<div class="rc-slider" id="transition_period_slider"></div>
	<input type="hidden" name="options[transition_period]" id="transition_period" value="<?php echo esc_attr($transition_period) ?>" />
	<span class="note"><?php _e('Length of the sliding effect in seconds', 'rc_slider') ?></span>
</div>

<div class="form-group">
	<label class="label" for="skin_color"><?php _e('Skin color', 'rc_slider') ?></label></th>
	<select class="widefat" name="options[skin_color]" id="skin_color">
	<?php
	foreach($rcs_skin_colors as $key => $val){
	?>
	<option value="<?php echo $key ?>" <?php selected($skin_color, $key) ?>><?php echo $val ?></option>
	<?php
	}
	?>
	</select>
</div>

<div class="form-group">
	<label>
	<input type="checkbox" name="options[auto_advance]" id="auto_advance" value="1" <?php checked((int) $auto_advance, 1) ?> />
	<?php _e('Auto advance', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label class="label" for="easing"><?php _e('Easing', 'rc_slider') ?></label></th>
	<select class="widefat" name="options[easing]" id="easing">
	<?php
	foreach($rcs_easing_features as $key => $val){
	?>
	<option value="<?php echo $key ?>" <?php selected($easing, $key) ?>><?php echo $val ?></option>
	<?php
	}
	?>
	</select>
</div>
	
<div class="form-group">
	<label class="label" for="fx"><?php _e('Effects', 'rc_slider') ?></label></th>
	<select class="widefat" name="options[fx][]" id="fx" multiple="multiple" size="5">
	<?php
	foreach($rcs_fx_features as $key => $val){
	?>
	<option value="<?php echo $key ?>" <?php echo (in_array($key, $fx))? 'selected' : ''; ?>><?php echo $val ?></option>
	<?php
	}
	?>
	</select>
</div>
	
<div class="form-group">
	<label class="label"><?php _e('Indexing style', 'rc_slider') ?></label></th>
	
	<label>
	<input type="radio" name="options[indexing_style]" id="pagination" value="pagination" <?php checked($indexing_style, 'pagination') ?> 
	onchange="rcs_handleIndexingChange(this.value)" />
	<?php _e('Pagination', 'rc_slider') ?></label>
	
	<label>
	<input type="radio" name="options[indexing_style]" id="thumbnails" value="thumbnails" <?php checked($indexing_style, 'thumbnails') ?> 
	onchange="rcs_handleIndexingChange(this.value)" />
	<?php _e('Thumbnails', 'rc_slider') ?></label>
	
	<label>
	<input type="radio" name="options[indexing_style]" id="none" value="none" <?php checked($indexing_style, 'none') ?> 
	onchange="rcs_handleIndexingChange(this.value)" />
	<?php _e('None', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label class="label" for="skin_color"><?php _e('Thumbnail size', 'rc_slider') ?></label></th>
	<select class="widefat" name="options[thumbnail_size]" id="thumbnail_size">
		<option value="extraLarge" <?php selected($thumbnail_size, 'extraLarge') ?>><?php _e('extra large', 'rc_slider') ?></option>
		<option value="large" <?php selected($thumbnail_size, 'large') ?>><?php _e('large', 'rc_slider') ?></option>
		<option value="medium" <?php selected($thumbnail_size, 'medium') ?>><?php _e('medium', 'rc_slider') ?></option>
		<option value="small" <?php selected($thumbnail_size, 'small') ?>><?php _e('small', 'rc_slider') ?></option>
		<option value="extraSmall" <?php selected($thumbnail_size, 'extraSmall') ?>><?php _e('extra small', 'rc_slider') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="label"><?php _e('Loader', 'rc_slider') ?></label></th>
	
	<label>
	<input type="radio" name="options[loader]" id="pie" value="pie" <?php checked($loader, 'pie') ?>  onchange="rcs_handleLoaderChange(this.value)" />
	<?php _e('Pie', 'rc_slider') ?></label>
	
	<label>
	<input type="radio" name="options[loader]" id="bar" value="bar" <?php checked($loader, 'bar') ?>  onchange="rcs_handleLoaderChange(this.value)" />
	<?php _e('Bar', 'rc_slider') ?></label>
	
	<label>
	<input type="radio" name="options[loader]" id="none" value="none" <?php checked($loader, 'none') ?> onchange="rcs_handleLoaderChange(this.value)" />
	<?php _e('None', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label class="label" for="skin_color"><?php _e('Bar position', 'rc_slider') ?></label></th>
	<select class="widefat" name="options[bar_position]" id="bar_position" <?php echo ($loader == 'bar')? '' : 'disabled="disabled"'; ?>>
		<option value="bottom" <?php selected($bar_position, 'bottom') ?>><?php _e('Bottom', 'rc_slider') ?></option>
		<option value="left" <?php selected($bar_position, 'left') ?>><?php _e('Left', 'rc_slider') ?></option>
		<option value="right" <?php selected($bar_position, 'right') ?>><?php _e('Right', 'rc_slider') ?></option>
		<option value="top" <?php selected($bar_position, 'top') ?>><?php _e('Top', 'rc_slider') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="label" for="skin_color"><?php _e('Bar direction', 'rc_slider') ?></label></th>
	<select class="widefat" name="options[bar_direction]" id="bar_direction" <?php echo ($loader == 'bar')? '' : 'disabled="disabled"'; ?>>
		<option value="leftToRight" <?php selected($bar_direction, 'leftToRight') ?>><?php _e('Left to right', 'rc_slider') ?></option>
		<option value="rightToLeft" <?php selected($bar_direction, 'rightToLeft') ?>><?php _e('Right to left', 'rc_slider') ?></option>
		<option value="topToBottom" <?php selected($bar_direction, 'topToBottom') ?>><?php _e('Top to bottom', 'rc_slider') ?></option>
		<option value="bottomToTop" <?php selected($bar_direction, 'bottomToTop') ?>><?php _e('Bottom to top', 'rc_slider') ?></option>
	</select>
</div>
					
<div class="form-group">
	<label class="label"><?php _e('Loader color', 'rc_slider') ?></label>
	<div id="loaderColor" class="colorPicker"></div>
	<input type="hidden" id="loader_color" name="options[loader_color]" value="<?php echo $loader_color ?>" />
</div>

<div class="form-group">
	<label class="label"><?php _e('Loader background color', 'rc_slider') ?></label>
	<div id="loaderBGColor" class="colorPicker"></div>
	<input type="hidden" id="loader_bg_color" name="options[loader_bg_color]" value="<?php echo $loader_bg_color ?>" />
</div>

<div class="form-group">
	<label>
	<input type="checkbox" name="options[navigation]" id="navigation" value="1" <?php checked((int) $navigation, 1) ?> 
	onchange="rcs_handleNavigationChange(this)" />
	<?php _e('Navigation', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label>
	<input type="checkbox" name="options[navigation_on_hover]" id="navigation_on_hover" value="1" <?php checked((int) $navigation_on_hover, 1) ?> 
	<?php echo ($navigation)? '' : 'disabled="disabled"'; ?> />
	<?php _e('Navigation appears on hover only', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label>
	<input type="checkbox" name="options[play_pause]" id="play_pause" value="1" <?php checked((int) $play_pause, 1) ?> />
	<?php _e('Display the play/pause button', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label>
	<input type="checkbox" name="options[pause_on_hover]" id="pause_on_hover" value="1" <?php checked((int) $pause_on_hover, 1) ?> />
	<?php _e('Pause on state hover', 'rc_slider') ?></label>
</div>

<div class="form-group">
	<label>
	<input type="checkbox" name="options[pause_on_click]" id="pause_on_click" value="1" <?php checked((int) $pause_on_click, 1) ?> />
	<?php _e('Pause on click', 'rc_slider') ?></label>
</div>

<div class="watermark_container">
	<button type="button" class="button-secondary" id="add_watermark" 
	onclick="rcs_addWatermark()"><?php _e('Add watermark', 'rc_slider') ?></button>
	
	<div class="watermark_holder" id="watermark_holder">
		<input type="hidden" name="options[watermark_id]" id="watermark_id" value="<?php echo $watermark_id ?>" />
			<?php if(!empty($watermark_id)){
					$img = wp_get_attachment_image_src($watermark_id, 'large');
			?>
			<img src="<?php echo $img[0] ?>" id="watermark" />
			<?php } ?>
	</div>
	
	<a href="javascript:rcs_deleteWatermark()" id="deleteWatermark" class="deleteWatermark" 
	style="display: <?php echo (!empty($watermark_id))? 'block' : 'none'; ?>"><?php _e('remove watermark', 'rc_slider') ?></a>
</div>
<br />
<input type="hidden" name="__rc_slider_form" value="<?php echo uniqid() ?>" />
<input type="hidden" id="imageEditorGoal" value="" />

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#time_slider').slider({
		max: 15,
		min: 5,
		step: 1,
		value: parseFloat(<?php echo $time ?>),
		stop: function(evt, ui){
			jQuery('#time').val(ui.value);
			jQuery('#time_value').html(ui.value + " sec");
		}
	});
	
	jQuery('#transition_period_slider').slider({
		max: 2.5,
		min: 0.5,
		step: 0.5,
		value: parseFloat(<?php echo $transition_period ?>),
		stop: function(evt, ui){
			jQuery('#transition_period').val(ui.value);
			jQuery('#transition_period_value').html(ui.value + " sec");
		}
	});
	
});
</script>
<div class="form-group">
	<label class="label"><?php _e('Slider shortcode', 'rc_slider') ?></label>
	<input class="widefat" type="text" readonly value='<?php echo (!empty($slider_id))? '[rcs_slider id="'.$slider_id.'"]' : ''; ?>' />
	<span class="note"><?php _e('Copy and past this shortcode anywhere you want to display the slider', 'rc_slider') ?></span>
</div>

<div class="form-group last">
	<label class="label"><?php _e('Slider php code', 'rc_slider') ?></label>
	<input class="widefat" type="text" readonly 
	value="<?php echo (!empty($slider_id))? '<?php if(function_exists(\'rc_slider\')){ rc_slider(\''.$slider_id.'\'); } ?>' : ''; ?>" />
	<span class="note"><?php _e('Copy and past this php code anywhere you want to display the slider in the template files', 'rc_slider') ?></span>
</div>
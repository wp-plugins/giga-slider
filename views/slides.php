<?php
$captionClasses = rcs_get_caption_example_options();
?>
<div style=" color:#090; padding:10px; -webkit-border-radius: 10px;
-moz-border-radius: 10px; border-radius: 10px; font-size:15px; margin-bottom:20px">&nbsp;<b style="color:#C00">limited time offer!</b><br  /><br  />If you want to add youtube & vimeo videos, links, caption text and new effects please <a href="http://www.wp-buy.com/product/giga-slider-pro" target="_blank">upgrade to the pro</a> version and save 40%, The premium version of GIGA Slider is completely different from the free version as there are a lot more features included</div>
<ul id="sortable-slides">
	<?php
	$i = 0;
	$o = 1;
	foreach($slides as $slide){
		$i++;
		$o++;
		$title = '';
		switch($slide['type']){
			case 'image':
			$title = 'Image';
			break;
			
			case 'youtube':
			$title = 'YouTube';
			break;
			
			case 'vimeo':
			$title = 'Vimeo';
			break;
		}
		
		$type = (isset($slide['type']))? $slide['type'] : NULL;
		$caption = (isset($slide['caption']))? $slide['caption'] : NULL;
		$caption_url = (isset($slide['caption_url']))? $slide['caption_url'] : NULL;
		$caption_css = (isset($slide['caption_css']))? $slide['caption_css'] : NULL;
		$caption_url_target = (isset($slide['caption_url_target']))? $slide['caption_url_target'] : NULL;
		$alignment = (isset($slide['alignment']))? $slide['alignment'] : NULL;
		$url = (isset($slide['url']))? $slide['url'] : NULL;
		$target = (isset($slide['target']))? $slide['target'] : NULL;
		$default_effects = (isset($slide['default_effects']))? $slide['default_effects'] : NULL;
		$time = (isset($slide['time']) && !empty($slide['time']))? $slide['time'] : $time_default;
		$transition_period = (isset($slide['transition_period']) && !empty($slide['transition_period']))? $slide['transition_period'] : $transition_period_default;
		$easing = (isset($slide['easing']))? $slide['easing'] : NULL;
		$fx = (isset($slide['fx']))? $slide['fx'] : NULL;
		$image_id = (isset($slide['image_id']))? $slide['image_id'] : NULL;
		$youtube_id = (isset($slide['youtube_id']))? $slide['youtube_id'] : NULL;
		$vimeo_id = (isset($slide['vimeo_id']))? $slide['vimeo_id'] : NULL;
		
		$iconClass = $type;
		$disabled = ($default_effects)? ' disabled="disabled"' : '';
		$disld = ($default_effects);
	?>
	<li id="slide_element_<?php echo $i ?>">
    
		<div class="collapsible-panel">
			<div class="header"><span class="icon <?php echo $iconClass ?> colapsingToggle">&nbsp;</span><span class="colapsingToggle"><?php echo $title ?></span>
			<span class="delete" onclick="rcs_removeSlide(<?php echo $i ?>, event)">&nbsp;</span></div>
			<div class="body">
				<input type="hidden" name="slides[<?php echo $i ?>][order]" id="slides_order_<?php echo $i ?>" value="<?php echo $o ?>" />
				<div class="form-group">
					<label class="label" for="slides_type_<?php echo $i ?>"><?php _e('Type', 'rc_slider') ?></label></th>
					<select style="width: 200px;" name="slides[<?php echo $i ?>][type]" id="slides_type_<?php echo $i ?>" 
					onchange="rcs_slideTypeChange(this)">
						<option value="image" <?php selected($type, 'image') ?>><?php _e('Image', 'rc_slider') ?></option>
						
					</select>
				</div>
				<br />
				
				<!-- begin image form container -->
				<div class="container" style="display: <?php echo (($type == 'image')? 'block' : 'none') ?>;" 
				id="image_container_<?php echo $i ?>">
					<div class="form_container">
						
						
						<br /><br />
						
						<div class="form-group slide">
							<label>
							<input type="checkbox" name="slides[<?php echo $i ?>][default_effects]" id="slides_default_effects_<?php echo $i ?>" value="1" 
							onchange="rcs_customEffectsChange(this)" <?php checked($default_effects, true) ?> />
							<?php _e('Slide has the slider effects as default', 'rc_slider') ?></label>
						</div>
						
						<div class="form-group slide">
							<label class="label"><?php _e('Time', 'rc_slider') ?></label>
							<label class="label value" id="slides_time_value_<?php echo $i ?>"><?php echo esc_attr($time) ?> sec</label>
							<div class="rc-slider" id="slides_time_slider_<?php echo $i ?>"></div>
							<input type="hidden" name="slides[<?php echo $i ?>][time]" id="slides_time_<?php echo $i ?>" 
							value="<?php echo esc_attr($time) ?>" />
							<span class="note"><?php _e('Seconds between the end of the sliding effect and the start of the nex one', 'rc_slider') ?></span>
						</div>
						
						<div class="form-group slide">
							<label class="label"><?php _e('Transition', 'rc_slider') ?></label>
							<label class="label value" id="slides_transition_period_value_<?php echo $i ?>"><?php echo esc_attr($transition_period) ?> sec</label>
							<div class="rc-slider" id="slides_transition_period_slider_<?php echo $i ?>"></div>
							<input type="hidden" name="slides[<?php echo $i ?>][transition_period]" id="slides_transition_period_<?php echo $i ?>" 
							value="<?php echo esc_attr($transition_period) ?>" />
							<span class="note"><?php _e('Length of the sliding effect in seconds', 'rc_slider') ?></span>
						</div>
						
						<div class="form-group slide">
							<label class="label" for="slides_easing_<?php echo $i ?>"><?php _e('Easing', 'rc_slider') ?></label></th>
							<select class="widefat" name="slides[<?php echo $i ?>][easing]" id="slides_easing_<?php echo $i ?>" 
							<?php echo $disabled ?>>
								<option value="">...</option>
							<?php
							foreach($rcs_easing_features as $key => $val){
							?>
								<option value="<?php echo $key ?>" <?php selected($easing, $key) ?>><?php echo $val ?></option>
							<?php
							}
							?>
							</select>
						</div>
						
						<div class="form-group slide">
							<label class="label" for="slides_fx_<?php echo $i ?>"><?php _e('Effect', 'rc_slider') ?></label></th>
							<select class="widefat" name="slides[<?php echo $i ?>][fx]" id="slides_fx_<?php echo $i ?>" <?php echo $disabled ?> >
								<option value="">...</option>
							<?php
							foreach($rcs_slide_fx as $key => $val){
							?>
								<option value="<?php echo $key ?>" <?php selected($fx, $key) ?>><?php echo $val ?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					
					<!-- begin image -->
					<div class="image_container">
						<button type="button" class="button-secondary" id="add_image_<?php echo $i ?>" 
						onclick="rcs_addImage(this.id)"><?php _e('Add image', 'rc_slider') ?></button>
						
						<div class="image_holder" id="image_holder_<?php echo $i ?>">
							<input type="hidden" name="slides[<?php echo $i ?>][image_id]" id="slides_image_id_<?php echo $i ?>" value="<?php echo $image_id ?>" />
								<?php if(!empty($slide['image_id'])){
										$img = wp_get_attachment_image_src($image_id, 'medium');
								?>
								<img src="<?php echo $img[0] ?>" id="slide_image_<?php echo $i ?>" />
								<?php } ?>
						</div>
						
						
					</div>
					<!-- end image -->
					
					<div class="cleaner"></div>
					
				</div>
				<!-- end image form container -->
				
				<!-- begin youtube container -->
				<div class="container" id="youtube_container_<?php echo $i ?>" style="display: <?php echo (($type == 'youtube')? 'block' : 'none') ?>;">
					<div class="form_container">
						<div class="form-group slide">
							<label class="label"><?php _e('YouTube url or video id', 'rc_slider') ?></label>
							<input class="widefat" type="text" name="slides[<?php echo $i ?>][youtube_id]" 
							id="slides_youtube_id_<?php echo $i ?>" value="<?php echo $youtube_id ?>" />
						</div>
					</div>
					
					<div class="cleaner"></div>
				</div>
				<!-- end youtube container -->
				
				<!-- begin vimeo container -->
				<div class="container" id="vimeo_container_<?php echo $i ?>" style="display: <?php echo (($type == 'vimeo')? 'block' : 'none') ?>;">
					<div class="form_container">
						<div class="form-group slide">
							<label class="label"><?php _e('Vimeo url or video id', 'rc_slider') ?></label>
							<input class="widefat" type="text" name="slides[<?php echo $i ?>][vimeo_id]" 
							id="slides_vimeo_id_<?php echo $i ?>" value="<?php echo $vimeo_id ?>" />
						</div>
					</div>
					
					<div class="cleaner"></div>
				</div>
				<!-- end vimeo container -->
				
			</div>
		</div>
		<div class="cleaner"></div>
	</li>
	
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#slides_time_slider_<?php echo $i ?>').slider({
			max: 15,
			min: 5,
			step: 1,
			value: parseFloat(<?php echo esc_attr($time) ?>),
			disabled: '<?php echo $disld ?>',
			stop: function(evt, ui){
				jQuery('#slides_time_<?php echo $i ?>').val(ui.value);
				jQuery('#slides_time_value_<?php echo $i ?>').html(ui.value + " sec");
			}
		});
		
		jQuery('#slides_transition_period_slider_<?php echo $i ?>').slider({
			max: 2.5,
			min: 0.5,
			step: 0.5,
			value: parseFloat(<?php echo esc_attr($transition_period) ?>),
			disabled: '<?php echo $disld ?>',
			stop: function(evt, ui){
				jQuery('#slides_transition_period_<?php echo $i ?>').val(ui.value);
				jQuery('#slides_transition_period_value_<?php echo $i ?>').html(ui.value + " sec");
			}
		});
		
	});
	</script>
	<?php
	}
	?>
</ul>
<input type="hidden" id="slides_index" value="<?php echo $i ?>" />
<input type="hidden" id="slides_order" value="<?php echo $o ?>" />

<input type="hidden" id="imageFormIndex" value="" />

<br /><br /><br />
<button type="button" class="button-secondary" id="add_new_slide" onclick="rcs_addNewSlide()"><?php _e('Add slide', 'rc_slider') ?></button>

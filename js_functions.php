<?php
	$settings = get_option('rcs_slider_settings');
	$time = $settings['default_options']['time'];
	$transition_period = $settings['default_options']['transition_period'];
?>
<script type="text/javascript">
var RCS_ADMIN_URL = '<?php echo admin_url() ?>';
var TIME_DEFAULT = <?php echo $time ?>;
var TRANSITION_PERIOD_DEFAULT = <?php echo $transition_period ?>;
var WORDPRESS_VER = "<?php echo get_bloginfo("version") ?>"
var captionClasses = '<?php echo rcs_get_caption_example_options() ?>';

function rcs_addNewSlide(){
	var i = Number(jQuery('#slides_index').val()) + 1;
	jQuery('#slides_index').val(i);
	var o = Number(jQuery('#slides_order').val()) + 1;
	jQuery('#slides_order').val(o);
	var slide = '<li id="slide_element_' + i + '">' +
		'<div class="collapsible-panel">' +
			'<div class="header"><span class="icon image colapsingToggle">&nbsp;</span><span class="colapsingToggle">Slide</span>' +
			'<span class="delete" onclick="rcs_removeSlide(' + i + ', event)">&nbsp;</span></div>' +
			'<div class="body">' +
				'<input type="hidden" name="slides[' + i + '][order]" id="slides_order_' + i + '" value="' + o + '" />' +
				'<div class="form-group">' +
					'<label class="label" for="slides_type_' + i + '"><?php _e('Type', 'rc_slider') ?></label></th>' +
					'<select style="width: 200px;" name="slides[' + i + '][type]" id="slides_type_' + i + '" ' +
					'onchange="rcs_slideTypeChange(this)">' +
						'<option value="image" ><?php _e('Image', 'rc_slider') ?></option>' +
						
					'</select>' +
				'</div>' +
				'<br />' +
				'<div class="container" id="image_container_' + i + '">' +
					'<div class="form_container">' +
						'<div class="form-group slide">' +
							'<label class="label" for="slides_alignment_' + i + '"><?php _e('Alignment', 'rc_slider') ?></label></th>' +
							'<select class="widefat" name="slides[' + i + '][alignment]" id="slides_alignment_' + i + '">' +
								'<option value="">...</option>' +
							<?php
							foreach($rcs_alignments as $key => $val){
							?>
								'<option value="<?php echo $key ?>"><?php echo $val ?></option>' +
							<?php
							}
							?>
							'</select>' +
						'</div>' +
						
						'<div class="form-group slide">' +
							'<label>' +
							'<input type="checkbox" name="slides[' + i + '][default_effects]" id="slides_default_effects_' + i + '" value="1" ' +
							'onchange="rcs_customEffectsChange(this)" checked />' +
							'<?php _e('Slide has the slider effects as default', 'rc_slider') ?></label>' +
						'</div>' +
						'<div class="form-group slide">' +
							'<label class="label"><?php _e('Time', 'rc_slider') ?></label>' +
							'<label class="label value" id="slides_time_value_' + i + '"><?php echo $time ?> sec</label>' +
							'<div class="rc-slider" id="slides_time_slider_' + i + '"></div>' +
							'<input type="hidden" name="slides[' + i + '][time]" id="slides_time_' + i + '" />' +
							'<span class="note"><?php _e('Seconds between the end of the sliding effect and the start of the nex one', 'rc_slider') ?></span>' + 
						'</div>' +
						'<div class="form-group slide">' +
							'<label class="label"><?php _e('Transition period', 'rc_slider') ?></label>' +
							'<label class="label value" id="slides_transition_period_value_' + i + '"><?php echo $transition_period ?> sec</label>' +
							'<div class="rc-slider" id="slides_transition_period_slider_' + i + '"></div>' +
							'<input type="hidden" name="slides[' + i + '][transition_period]" id="slides_transition_period_' + i + '" />' +
							'<span class="note"><?php _e('Length of the sliding effect in seconds', 'rc_slider') ?></span>' +
						'</div>' +
						
						'<div class="form-group slide">' +
							'<label class="label" for="slides_easing_' + i + '"><?php _e('Easing', 'rc_slider') ?></label></th>' +
							'<select class="widefat" name="slides[' + i + '][easing]" id="slides_easing_' + i + '" disabled="disabled" >' +
								'<option value="">...</option>' +
							<?php
							foreach($rcs_easing_features as $key => $val){
							?>
								'<option value="<?php echo $key ?>"><?php echo $val ?></option>' +
							<?php
							}
							?>
							'</select>' +
						'</div>' +
						'<div class="form-group slide">' +
							'<label class="label" for="slides_fx_' + i + '"><?php _e('Effect', 'rc_slider') ?></label></th>' +
							'<select class="widefat" name="slides[' + i + '][fx]" id="slides_fx_' + i + '" disabled="disabled">' +
								'<option value="">...</option>' +
							<?php
							foreach($rcs_slide_fx as $key => $val){
							?>
								'<option value="<?php echo $key ?>"><?php echo $val ?></option>' +
							<?php
							}
							?>
							'</select>' +
						'</div>' +
					'</div>' +
					'<div class="image_container">' +
						'<button type="button" class="button-secondary" id="add_image_' + i + '" ' +
						'onclick="rcs_addImage(this.id)"><?php _e('Add image', 'rc_slider') ?></button>' +
						'<div class="image_holder" id="image_holder_' + i + '">' +
							'<input type="hidden" name="slides[' + i + '][image_id]" id="slides_image_id_' + i + '" />' +
						'</div>' +
						
						
					'</div>' +
					'<div class="cleaner"></div>' +
					'</div>' +
				
			'</div>' +
		'</div>' +
		'<div class="cleaner"></div>' +
	'</li>';
	
	jQuery('#sortable-slides').append(slide);
    jQuery('#slide_element_' + i + ' div.collapsible-panel div.header').click(function(e){
		if(!IN_SORTING){
			jQuery(this).next('.collapsible-panel div.body').slideToggle(400);
			jQuery(this).toggleClass('active');
			e.preventDefault();
		} else{
			IN_SORTING = false;
		}
    });
	
	jQuery('#slides_time_slider_' + i).slider({
		max: 15,
		min: 5,
		step: 1,
		disabled: true,
		value: parseFloat(<?php echo $time ?>),
		stop: function(evt, ui){
			jQuery('#slides_time_' + i).val(ui.value);
			jQuery('#slides_time_value_' + i).html(ui.value + " sec");
		}
	});
	
	jQuery('#slides_transition_period_slider_' + i).slider({
		max: 2.5,
		min: 0.5,
		step: 0.5,
		disabled: true,
		value: parseFloat(<?php echo $transition_period ?>),
		stop: function(evt, ui){
			jQuery('#slides_transition_period_' + i).val(ui.value);
			jQuery('#slides_transition_period_value_' + i).html(ui.value + " sec");
		}
	});
	
	jQuery('.slides_style_template').on('change', function(evt){
		rcs_selectCaptionExample(jQuery(this).attr('id'), jQuery(this).val());
	});
	
	jQuery('.slides_caption_css').on('blur', function(evt){
		rcs_styleCaptionExample(jQuery(this).attr('id'));
	});
	
	/* click event handler for the caption CSS reviewer */
	jQuery('.captionExampleCont').on('click', function(evt){
		rcs_styleCaptionExample(jQuery(this).attr('id'));
	});
	
}
</script>
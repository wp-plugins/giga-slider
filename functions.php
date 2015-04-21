<?php

/**
 * To enqueue scripts and styles in the admin pages and dequeue unwanted scripts from other plugins
 *
 * @uses wp_enqueue_style()
 * @uses wp_enqueue_script()
 * @uses wp_dequeue_script()
 * @uses wp_deregister_script()
 * @uses plugins_url()
 *
 * @return void
 */
function rcs_admin_styles_scripts(){
	global $post_type, $current_screen, $wp_scripts, $wp_styles, $rcs_wordpress_scripts, $rcs_wordpress_scripts_35;
	$version = get_bloginfo('version');
	$version = substr($version, 0, 3);
	$version = (float) $version;
	$wp_reg_scripts = ($version >= 3.5)? $rcs_wordpress_scripts_35 : $rcs_wordpress_scripts;
	
	if($post_type == 'rc_slider'){
		$registeredScripts = array();
		foreach($wp_scripts->registered as $reg){
			$registeredScripts[] = $reg->handle;
		}
		
		$queuedScripts = array();
		foreach($wp_scripts->queue as $q){
			$queuedScripts[] = $q;
		}
		
		foreach($queuedScripts as $q){
			if(!in_array($q, $wp_reg_scripts)){
				wp_dequeue_script($q);
			}
		}
		
		foreach($registeredScripts as $r){
			if(!in_array($r, $wp_reg_scripts)){
				wp_deregister_script($r);
			}
		}
		
		wp_enqueue_style('camera-css', plugins_url('lib/camera/css/camera.css', RCS_PLUGIN_MAIN_FILE));
		wp_enqueue_style('colpick-css', plugins_url('lib/colpick-jQuery-Color-Picker/css/colpick.css', RCS_PLUGIN_MAIN_FILE));
		wp_enqueue_style('rcs-admin-css', plugins_url('css/admin.css', RCS_PLUGIN_MAIN_FILE));
		wp_enqueue_style('jquery-ui-css', plugins_url('lib/jquery-ui.css', RCS_PLUGIN_MAIN_FILE));
		wp_enqueue_style('thickbox');
		
		if(!in_array('jquery', $queuedScripts)){
			wp_enqueue_script('jquery');
		}
		
		if(!in_array('jquery-ui', $queuedScripts)){
			if(!in_array('jquery-effects-core', $queuedScripts)){
				wp_enqueue_script('jquery-effects-core');
			}
			
			if(!in_array('jquery-ui-core', $queuedScripts)){
				wp_enqueue_script('jquery-ui-core');
			}
			
			if(!in_array('jquery-ui-widget', $queuedScripts)){
				wp_enqueue_script('jquery-ui-widget');
			}
			
			if(!in_array('jquery-ui-mouse', $queuedScripts)){
				wp_enqueue_script('jquery-ui-mouse');
			}
			
			if(!in_array('jquery-ui-slider', $queuedScripts)){
				wp_enqueue_script('jquery-ui-slider');
			}
			
			if(!in_array('jquery-ui-sortable', $queuedScripts)){
				wp_enqueue_script('jquery-ui-sortable');
			}
		}
		
		wp_enqueue_script('jquery-mobile', plugins_url('lib/camera/scripts/jquery.mobile.customized.min.js', RCS_PLUGIN_MAIN_FILE), array('jquery'));
		wp_enqueue_script('camera-js', plugins_url('lib/camera/scripts/camera.js', RCS_PLUGIN_MAIN_FILE), array('jquery', 'jquery-mobile', 'jquery-effects-core'));
		wp_enqueue_script('colpick-js', plugins_url('lib/colpick-jQuery-Color-Picker/js/colpick.js', RCS_PLUGIN_MAIN_FILE));
		wp_enqueue_script('rcs-admin-js', plugins_url('js/admin.js', RCS_PLUGIN_MAIN_FILE));
		
		if(!in_array('media-upload', $queuedScripts)){
			wp_enqueue_script('media-upload');
		}
		if(!in_array('thickbox', $queuedScripts)){
			wp_enqueue_script('thickbox');
		}
		
		wp_enqueue_media();
		//wp_deregister_script('autosave');
	}
}
//---------------------------------------------------
/**
 * To enqueue scripts and styles in the client pages
 *
 * @uses wp_enqueue_style()
 * @uses wp_enqueue_script()
 * @uses plugins_url()
 *
 * @return void
 */
function rcs_styles_scripts(){
	global $post_type, $current_screen, $wp_scripts, $wp_styles;
	
		$queuedScripts = array();
		foreach($wp_scripts->queue as $q){
			$queuedScripts[] = $q;
		}
		
	wp_enqueue_style('camera-css', plugins_url('lib/camera/css/camera.css', RCS_PLUGIN_MAIN_FILE));
	wp_enqueue_style('rcs-client-css', plugins_url('css/client.css', RCS_PLUGIN_MAIN_FILE));
	
	if(!in_array('jquery', $queuedScripts)){
		wp_enqueue_script('jquery');
	}
	$cam_dep = array('jquery', 'jquery-mobile');
	if(!in_array('jquery-effects-core', $queuedScripts)){
		wp_enqueue_script('jquery-easing', plugins_url('lib/camera/scripts/jquery.easing.1.3.js', RCS_PLUGIN_MAIN_FILE), array('jquery'));
		$cam_dep[] = 'jquery-easing';
	} else{
		$cam_dep[] = 'jquery-effects-core';
	}
	wp_enqueue_script('jquery-mobile', plugins_url('lib/camera/scripts/jquery.mobile.customized.min.js', RCS_PLUGIN_MAIN_FILE), array('jquery'));
	wp_enqueue_script('camera-js', plugins_url('lib/camera/scripts/camera.js', RCS_PLUGIN_MAIN_FILE), $cam_dep);
	wp_enqueue_script('rcs-client-js', plugins_url('js/client.js', RCS_PLUGIN_MAIN_FILE));
}
//---------------------------------------------------
/**
 * Called when plugin is activated or upgraded
 *
 * @uses add_option()
 * @uses get_option()
 * @uses update_option()
 *
 * @return void
 */
function rcs_set_settings(){
	$defaults = array('height' => 450, 'skin_color' => 'camera_graphite_skin', 'easing' => 'easeInOutExpo', 'fx' => array('random'),
					'indexing_style' => 'pagination', 'pause_on_hover' => 0, 'loader' => 'pie', 'loader_color' => 'eeeeee',
					'loader_bg_color' => '222222', 'navigation' => 0, 'navigation_on_hover' => 0, 'play_pause' => 0,
					'pause_on_click' => 0, 'time' => 7, 'transition_period' => 1.5, 'bar_position' => 'bottom',
					'bar_direction' => 'leftToRight', 'thumbnail_size' => 'medium', 'watermark_id' => NULL, 'auto_advance' => 1);
					
	$options = array('version' => '1.0', 'default_options' => $defaults);
	if(get_option('rcs_slider_settings') === false){
		add_option('rcs_slider_settings', $options);
	} else{
		update_option('rcs_slider_settings', $options);
	}
}
//---------------------------------------------------
/**
 * Registers the rc_slider post type
 *
 * @uses post_type_exists()
 * @uses register_post_type()
 * @uses plugins_url()
 *
 * @return void
 */
function rcs_register_rc_slider(){
	if(!post_type_exists('rc_slider')){
		$args = array(
				'public' => false,
				'show_ui' => true,
				'supports' => array('title'),
				'query_var' => 'rc_slider',
				'menu_icon' => 'dashicons-format-gallery',
				'menu_position' => 60,
				'can_export' => false,
				'register_meta_box_cb' => 'rcs_add_boxes',
				'capability_type' => 'post',
				'labels' => array(
								'name' => __('GIGA Slider'),
								'singular_name' => __('GIGA Slider'),
								'add_new' => __('Add New Slider'),
								'add_new_item' => __('Add New Slider'),
								'edit_item' => __('Edit Slider'),
								'new_item' => __('New Slider'),
								'view_item' => __('View Slider'),
								'search_items' => __('Search Sliders'),
								'not_found' => __('No Sliders Found'),
								'not_found_in_trash' => __('No Sliders Found In Trash')
								)
				);
		register_post_type('rc_slider', $args);
	}
}
//---------------------------------------------------
/**
 * Adds admin meta boxes
 *
 * @uses add_meta_box()
 *
 * @return void
 */
function rcs_add_boxes(){
	add_meta_box('slider_options', 'Slider options', 'rcs_build_options_box', 'rc_slider', 'side', 'default');
	add_meta_box('slider_code', 'Slider code', 'rcs_build_code_box', 'rc_slider', 'side', 'default');
	add_meta_box('slider_slides', 'Slides', 'rcs_build_slides_box', 'rc_slider', 'normal', 'default');
	add_meta_box('slider_preview', 'Slider preview', 'rcs_build_preview_box', 'rc_slider', 'normal', 'default');
}
//---------------------------------------------------
/**
 * Renders slider option box
 *
 * @uses get_option()
 * @uses get_post_meta()
 * @uses wp_parse_args()
 *
 * @return void
 */
function rcs_build_options_box($post){
	global $rcs_skin_colors, $rcs_easing_features, $rcs_fx_features;
	$settings = get_option('rcs_slider_settings');
	$slider_options = array();
	if(is_object($post)){
		$slider_options = get_post_meta($post->ID, '_rcs_slider_options', true);
		$slider_options = unserialize(base64_decode($slider_options));
	}
	
	$slider_options = wp_parse_args($slider_options, $settings['default_options']);
	extract($slider_options);
						
	include(RCS_PLUGIN_ROOT_DIR.RCS_DS.'views'.RCS_DS.'options.php');
}
//---------------------------------------------------
/**
 * Renders slider codes box
 *
 * @return void
 */
function rcs_build_code_box($post){
	$slider_id = '';
	if(is_object($post) && $post->post_status == 'publish'){
		$slider_id = $post->ID;
	}
	include(RCS_PLUGIN_ROOT_DIR.RCS_DS.'views'.RCS_DS.'codes.php');
}
//---------------------------------------------------
/**
 * Renders|returns a slider
 *
 * @uses get_option()
 * @uses get_post_meta()
 * @uses wp_parse_args()
 * @uses plugins_url()
 *
 * @return string|void
 */
function rc_slider($slider_id, $echo = true){
	$settings = get_option('rcs_slider_settings');
	$slider_options = get_post_meta($slider_id, '_rcs_slider_options', true);
	$slider_options = unserialize(base64_decode($slider_options));
	$slider_options = wp_parse_args($slider_options, $settings['default_options']);
					
	$unique = uniqid();
	$slider = '
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(\'#rc_slider_container'.$unique.'\').rc_camera({
					autoAdvance: '.(($slider_options['auto_advance'])? 'true' : 'false').',
					mobileAutoAdvance: '.(($slider_options['auto_advance'])? 'true' : 'false').',
					barDirection: \''.$slider_options['bar_direction'].'\',
					barPosition: \''.$slider_options['bar_position'].'\',
					easing: \''.$slider_options['easing'].'\',
					mobileEasing: \'\',
					mobileFx: \'\',
					fx: \''.implode(', ', $slider_options['fx']).'\',
					pagination: '.(($slider_options['indexing_style'] == 'pagination')? 'true' : 'false').',
					thumbnails: '.(($slider_options['indexing_style'] == 'thumbnails')? 'true' : 'false').',
					loader: \''.$slider_options['loader'].'\',
					hover: '.(($slider_options['pause_on_hover'])? 'true' : 'false').',
					imagePath: \''.plugins_url('lib/camera/images/', RCS_PLUGIN_MAIN_FILE).'\',
					loaderColor: \'#'.$slider_options['loader_color'].'\',
					loaderBgColor: \'#'.$slider_options['loader_bg_color'].'\',
					navigation: '.(($slider_options['navigation'])? 'true' : 'false').',
					navigationHover: '.(($slider_options['navigation_on_hover'])? 'true' : 'false').',
					mobileNavHover: '.(($slider_options['navigation_on_hover'])? 'true' : 'false').',
					playPause: '.(($slider_options['play_pause'])? 'true' : 'false').',
					pauseOnClick: '.(($slider_options['pause_on_click'])? 'true' : 'false').',
					time: '.((float) $slider_options['time'] * 1000).',
					transPeriod: '.((float) $slider_options['transition_period'] * 1000);
	$slider .= (!empty($slider_options['height']))? ', height: \''.$slider_options['height'].'px\'' : '';
	$slider .= '});';
	$slider .= 'jQuery(\'.camera_caption > div\').css(\'background\', \'transparent\');
				jQuery(\'img.camera_thumb\').addClass("'.$slider_options['thumbnail_size'].'");
			});
		</script>
		<div id="rc_slider_container'.$unique.'" class="camera_wrap camera_emboss '.$slider_options['skin_color'].'" style="display: block;">';
	
	$vimeos = array();
	$images = array();
	$slides = rcs_get_slider_slides($slider_id);
	foreach($slides as $slide){
		switch($slide['type']){
			case 'image':
			$images[] = $slide['image_info']['large_image'];
			$slider .= rcs_build_image_slide($slide, $slider_options);
			break;
			
			case 'youtube':
			$slider .= rcs_build_youtube_slide($slide, $slider_options);
			break;
			
			case 'vimeo':
			if(empty($slide['image_info']['large_image']) || empty($slide['image_info']['thumbnail'])){
				$vimeos[] = $slide;
			}
			$slider .= rcs_build_vimeo_slide($slide, $slider_options);
			break;
		}
	}
	$slider .= '</div>';
	
	if(!empty($vimeos)){
		$slider .= '<script type="text/javascript">
						jQuery(document).ready(function(){';
		foreach($vimeos as $vimeo){
		$videoId = rcs_get_vimeo_id_from_url($vimeo['vimeo_id']);
		$videoId = (empty($videoId))? $vimeo['vimeo_id'] : $videoId;
		$slider .= 'rcs_getVimeoThumbnails(\''.$videoId.'\', \''.$vimeo['slide_id'].'\', \''.$slider_id.'\');';
		}
		$slider .= '});;
				</script>';
	}
	
	if($echo){
		echo $slider;
	} else{
		return $slider;
	}
}
//---------------------------------------------------
/**
 * Saves slider options
 *
 * @uses get_option()
 * @uses wp_parse_args()
 * @uses update_post_meta()
 *
 * @return void
 */
function rcs_save_slider($post_id){
	$settings = get_option('rcs_slider_settings');
	$defaults = $settings['default_options'];
	if(isset($_POST['__rc_slider_form']) && isset($_POST['options']) && is_array($_POST['options'])){
		$options = rcs_stripslashes($_POST['options']);
		
		$options['height'] = (isset($options['height']) && !empty($options['height']))? $options['height'] : $defaults['height'];
		$options['time'] = (isset($options['time']))? $options['time'] : $defaults['time'];
		$options['transition_period'] = (isset($options['transition_period']))? $options['transition_period'] : $defaults['transition_period'];
		$options['skin_color'] = (isset($options['skin_color']))? $options['skin_color'] : $defaults['skin_color'];
		$options['easing'] = (isset($options['easing']))? $options['easing'] : $defaults['easing'];
		$options['fx'] = (isset($options['fx']))? $options['fx'] : $defaults['fx'];
		$options['indexing_style'] = (isset($options['indexing_style']))? $options['indexing_style'] : $defaults['indexing_style'];
		$options['thumbnail_size'] = (isset($options['thumbnail_size']))? $options['thumbnail_size'] : $defaults['thumbnail_size'];
		$options['loader'] = (isset($options['loader']))? $options['loader'] : $defaults['loader'];
		$options['bar_position'] = (isset($options['bar_position']))? $options['bar_position'] : $defaults['bar_position'];
		$options['bar_direction'] = (isset($options['bar_direction']))? $options['bar_direction'] : $defaults['bar_direction'];
		$options['loader_color'] = (isset($options['loader_color']))? $options['loader_color'] : $defaults['loader_color'];
		$options['loader_bg_color'] = (isset($options['loader_bg_color']))? $options['loader_bg_color'] : $defaults['loader_bg_color'];
		$options['navigation'] = (isset($options['navigation']))? $options['navigation'] : 0;
		$options['navigation_on_hover'] = (isset($options['navigation_on_hover']))? $options['navigation_on_hover'] : 0;
		$options['play_pause'] = (isset($options['play_pause']))? $options['play_pause'] : 0;
		$options['pause_on_hover'] = (isset($options['pause_on_hover']))? $options['pause_on_hover'] : 0;
		$options['pause_on_click'] = (isset($options['pause_on_click']))? $options['pause_on_click'] : 0;
		$options['auto_advance'] = (isset($options['auto_advance']))? $options['auto_advance'] : 0;
	
		if(isset($options['watermark_id']) && !empty($options['watermark_id'])){
			$img = wp_get_attachment_image_src($options['watermark_id'], 'large');
			if(!$img[3]){
				$img = wp_get_attachment_image_src($options['watermark_id'], 'medium');
			}
			if(!$img[3]){
				$img = wp_get_attachment_image_src($options['watermark_id'], 'small');
			}
			
			$options['watermark_url'] = $img[3];
		}
		$options = wp_parse_args($options, $settings['default_options']);
		update_post_meta($post_id, '_rcs_slider_options', base64_encode(serialize($options)));
		
		rcs_save_slides($post_id, $options);
	}
}
//---------------------------------------------------
/**
 * Saves slider slides
 *
 * @return void
 */
function rcs_save_slides($post_id, $sliderOptions){
	rcs_delete_slides($post_id);
	if(isset($_POST['slides'])){
		$slides = rcs_sort_slides(rcs_stripslashes($_POST['slides']));
		foreach($slides as $slide){
			switch($slide['type']){
				case 'image':
				rcs_save_image_slide($post_id, $slide, $sliderOptions);
				break;
				
				case 'youtube':
				rcs_save_youtube_slide($post_id, $slide);
				break;
				
				case 'vimeo':
				rcs_save_vimeo_slide($post_id, $slide);
				break;
			}
		}
	}
}
//---------------------------------------------------
/**
 * Saves image type slide
 *
 * @uses add_post_meta()
 *
 * @return void
 */
function rcs_save_image_slide($post_id, $slide, $sliderOptions){
	$slide['image_id'] = (int) $slide['image_id'];
	$image_info = NULL;
	if($slide['image_id'] > 0){
		try{
			$attch = new RC_Attachment($slide['image_id'], $sliderOptions['height'], $sliderOptions['watermark_id']);
			$image_info = $attch->generateOtherSizes();
		} catch(Exception $e){
		}
	}
	
	$arr = array(
				'slide_id' => uniqid(),
				'order' => (int) $slide['order'],
				'type' => $slide['type'],
				'caption' => $slide['caption'],
				'caption_url' => $slide['caption_url'],
				'caption_css' => $slide['caption_css'],
				'caption_url_target' => $slide['caption_url_target'],
				'alignment' => $slide['alignment'],
				'url' => $slide['url'],
				'target' => $slide['target'],
				'default_effects' => (isset($slide['default_effects'])),
				'time' => (isset($slide['time']))? $slide['time'] : '',
				'transition_period' => (isset($slide['transition_period']))? $slide['transition_period'] : '',
				'easing' => (isset($slide['easing']))? $slide['easing'] : '',
				'fx' => (isset($slide['fx']))? $slide['fx'] : '',
				'image_id' => (isset($slide['image_id']))? $slide['image_id'] : '',
				'image_info' => $image_info
				); // esc_url_raw(

	add_post_meta($post_id, '_rcs_slider_slide', base64_encode(serialize($arr)));
}
//---------------------------------------------------
/**
 * Saves youtube type slide
 *
 * @uses add_post_meta()
 *
 * @return void
 */
function rcs_save_youtube_slide($post_id, $slide){
	$videoId = rcs_get_youtube_id_from_url($slide['youtube_id']);
	$videoId = (empty($videoId))? $slide['youtube_id'] : $videoId;
	$arr = array(
				'slide_id' => uniqid(),
				'order' => (int) $slide['order'],
				'type' => $slide['type'],
				'youtube_id' => $slide['youtube_id'],
				'image_info' => array(
									'large_image' => 'http://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg',
									'thumbnail' => 'http://img.youtube.com/vi/'.$videoId.'/default.jpg'
									)
				);
				
	add_post_meta($post_id, '_rcs_slider_slide', base64_encode(serialize($arr)));
}
//---------------------------------------------------
/**
 * Saves vimeo type slide
 *
 * @uses add_post_meta()
 *
 * @return void
 */
function rcs_save_vimeo_slide($post_id, $slide){
	$arr = array(
				'slide_id' => uniqid(),
				'order' => (int) $slide['order'],
				'type' => $slide['type'],
				'vimeo_id' => $slide['vimeo_id'],
				'image_info' => array(
									'large_image' => '',
									'thumbnail' => ''
									)
				);
				
	add_post_meta($post_id, '_rcs_slider_slide', base64_encode(serialize($arr)));
}
//---------------------------------------------------
/**
 * Deletes slider slides
 *
 * @uses delete_post_meta()
 *
 * @return void
 */
function rcs_delete_slides($post_id){
	delete_post_meta($post_id, '_rcs_slider_slide');
}
//---------------------------------------------------
/**
 * Sorts slider slides
 *
 * @return array
 */
function rcs_sort_slides($slides){
	return $slides;
	$length = count($slides);
	$newOrder = array();
	$slides = array_values($slides);
	while(count($slides) > 0){
		$s = 99999999;
		$index = NULL;
		for($i = 0; $i < $length; $i++){
			if((int) $slides[$i]['order'] < $s){
				$s = $slides[$i]['order'];
				$index = $i;
			}
		}
		$newOrder[] = $slides[$index];
		unset($slides[$index]);
	}
	return $newOrder;
}

//---------------------------------------------------
/**
 * Unserializes slides
 *
 * @return array
 */
function rcs_unserialize_slides($slides){
	$slides = array_values($slides);
	$arr = array();
	for($i = 0; $i < count($slides); $i++){
		$arr[$i] = unserialize(base64_decode($slides[$i]));
	}
	return $arr;
}
//---------------------------------------------------
/**
 * Renders slides box
 *
 * @return void
 */
function rcs_build_slides_box($post){
	global $rcs_alignments, $rcs_easing_features, $rcs_slide_fx;
	$slides = rcs_get_slider_slides($post->ID);
	$settings = get_option('rcs_slider_settings');
	$time_default = $settings['default_options']['time'];
	$transition_period_default = $settings['default_options']['transition_period'];
	include(RCS_PLUGIN_ROOT_DIR.RCS_DS.'views'.RCS_DS.'slides.php');
	include(RCS_PLUGIN_ROOT_DIR.RCS_DS.'js_functions.php');
}
//---------------------------------------------------
/**
 * Renders preview box
 *
 * @return void
 */
function rcs_build_preview_box($post){
	if(rcs_count_postmeta($post->ID, '_rcs_slider_slide') > 0){
		rc_slider($post->ID);
		echo '<div style="clear: both;"></div>';
	}
}
//---------------------------------------------------
/**
 * Returns slider using shortcode
 *
 * @return string
 */
function rcs_render_by_shortcode($atts){
	return rc_slider($atts['id'], false).'<div style="clear: both;"></div>';
}
//---------------------------------------------------
/**
 * Registers widget
 *
 * @return void
 */
function rcs_register_slider_widget(){
	register_widget('RCS_Slider_Widget');
}
//---------------------------------------------------
/**
 * Sets grid columns' values
 *
 * @return void
 */
function rcs_set_columns_values($column){
	global $post;
	switch($column){
		case 'slides_num':
		echo '<span style="padding: 0 30px;">'.rcs_count_postmeta($post->ID, '_rcs_slider_slide').'</span>';
		break;
		
		case 'shortcode':
		echo '[rcs_slider id="'.$post->ID.'"]';
		break;
	}
}
//---------------------------------------------------
/**
 * Returns postmeta count
 *
 * @uses wpdb::get_results()
 * @uses wpdb::prepare()
 *
 * @return integer
 */
function rcs_count_postmeta($post_id, $meta_key){
	global $wpdb;
	$sql = "SELECT COUNT(meta_id) total FROM ".$wpdb->postmeta." WHERE post_id = %d AND meta_key = '%s'";;
	$results = $wpdb->get_results($wpdb->prepare($sql, $post_id, $meta_key));
	if($results !== false){
		return $results[0]->total;
	}
}
//---------------------------------------------------
/**
 * Sets grid columns' labels
 *
 * @return void
 */
function rcs_set_columns_labels($columns){
	unset($columns['date']);
	return array_merge($columns, array(
										'title' => __('Slider name', 'rc_slider'),
										'slides_num' => __('Number of slides', 'rc_slider'),
										'shortcode' => __('Shortcode', 'rc_slider')
									));
}
//---------------------------------------------------
/**
 * Returns a slider's slides
 *
 * @uses get_post_meta()
 *
 * @return array
 */
function rcs_get_slider_slides($post_id){
$slides = get_post_meta($post_id, '_rcs_slider_slide');
	$slides = rcs_unserialize_slides(get_post_meta($post_id, '_rcs_slider_slide'));
	if(is_array($slides)){
		$slides = rcs_sort_slides($slides);
	} else{
		$slides = array();
	}
	return $slides;
}
//---------------------------------------------------
/**
 * returns youtube video id from url
 *
 * @return string
 */
function rcs_get_youtube_id_from_url($url){
	if(!filter_var($url, FILTER_VALIDATE_URL)) {
		return NULL;
	}
	$parsedUrl = parse_url($url);
	
	$video_id = '';
	if(strpos($parsedUrl['host'], 'youtube.com') !== false){
		if(strpos($parsedUrl['path'], '/watch') !== false){
			parse_str($parsedUrl['query'], $parsedStr);
			if(isset($parsedStr['v']) and !empty($parsedStr['v'])){
				$video_id = $parsedStr['v'];
			}
		}
		else if(strpos($parsedUrl['path'], '/v/') !== false){
			$vidId = str_replace('/v/', '', $parsedUrl['path']);
			if(!empty($vidId)){
				$video_id = $vidId;
			}
		}
		else if(strpos($parsedUrl['path'], '/embed/') !== false){
			$video_id = str_replace('/embed/', '', $parsedUrl['path']);
		}
	}
	else if(strpos($parsedUrl['host'], 'youtu.be') !== false){
		$video_id = str_replace('/', '', $parsedUrl['path']);
	}
	
	$video_id = explode('/', $video_id);
	$video_id = rcs_remove_empty_elements_from_array($video_id);
	if(!empty($video_id)){
		return $video_id[count($video_id) - 1];
	}
	return NULL;
}
//---------------------------------------------------
/**
 * returns vimeo video id from url
 *
 * @return string
 */
function rcs_get_vimeo_id_from_url($url){
	if(!filter_var($url, FILTER_VALIDATE_URL)) {
		return NULL;
	}
	$video_id = '';
	$parsedUrl = parse_url($url);
	if($parsedUrl['host'] == 'vimeo.com'){
		$video_id = ltrim($parsedUrl['path'], '/');
	}
	
	$video_id = explode('/', $video_id);
	$video_id = rcs_remove_empty_elements_from_array($video_id);
	if(!empty($video_id)){
		return $video_id[count($video_id) - 1];
	}
	return NULL;
}
//---------------------------------------------------
/**
 * Returns HTML of an image type slide
 *
 * @uses get_post_meta()
 *
 * @return string
 */
function rcs_build_image_slide($slide, $sider_options){
	$out = '';
	if(!empty($slide['image_info'])){
		$out .= '<div data-src="'.$slide['image_info']['large_image'].'" ';
		if($sider_options['indexing_style'] == 'thumbnails'){
			$out .= ' data-thumb="'.$slide['image_info']['thumbnail'].'" ';
		}
		
		if(!empty($slide['alignment'])){
			$out .= ' data-alignment="'.$slide['alignment'].'" ';
		}
		
		if(!$slide['default_effects'] && isset($slide['easing'])){
			if(!empty($slide['easing'])){
				$out .= ' data-easing="'.$slide['easing'].'" ';
			}
			if(!empty($slide['fx'])){
				$out .= ' data-fx="'.$slide['fx'].'" ';
			}
			
			if(!empty($slide['time'])){
				$out .= ' data-time="'.((float) $slide['time'] * 1000).'" ';
			}
			
			if(!empty($slide['transition_period'])){
				$out .= ' data-transPeriod="'.((float) $slide['transition_period'] * 1000).'" ';
			}
		}
		
		if(!empty($slide['url'])){
			$out .= ' data-link="'.$slide['url'].'" ';
			$out .= ' data-target="'.$slide['target'].'" ';
		}
			
		$out .= '>';
		if(!empty($slide['caption'])){
			$out .= '<div class="camera_caption" style="'.$slide['caption_css'].'">';
			if(!empty($slide['caption_url'])){
				$out .= '<a href="'.$slide['caption_url'].'" target="'.$slide['caption_url_target'].'" >'; // style="'.ltrim($slide['caption_css'], ';').'; padding: 0; margin: 0; background: transparent;"
			}
			$out .= $slide['caption'];
			if(!empty($slide['caption_url'])){
				$out .= '</a>';
			}
			$out .= '</div>';
		}
		
		$out .= '</div>';
	}
	return $out;
}
//---------------------------------------------------
/**
 * Returns HTML of a youtube type slide
 *
 * @uses get_post_meta()
 *
 * @return string
 */
function rcs_build_youtube_slide($slide, $slider_options){
	$videoId = rcs_get_youtube_id_from_url($slide['youtube_id']);
	$videoId = (empty($videoId))? $slide['youtube_id'] : $videoId;
	$out = '';
	if(!empty($videoId)){
		$out .= '<div data-src="'.$slide['image_info']['large_image'].'"';
		if($slider_options['indexing_style'] == 'thumbnails'){
			$out .= ' data-thumb="'.$slide['image_info']['thumbnail'].'" ';
		}
		$out .= ' >
					<iframe src="http://www.youtube.com/embed/'.$videoId.'" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>';
	}
	return $out;
}
//---------------------------------------------------
/**
 * Returns HTML of a vimeo type slide
 *
 * @uses get_post_meta()
 *
 * @return string
 */
function rcs_build_vimeo_slide($slide, $slider_options){
	$videoId = rcs_get_vimeo_id_from_url($slide['vimeo_id']);
	$videoId = (empty($videoId))? $slide['vimeo_id'] : $videoId;
	$out = '';
	if(!empty($videoId)){
		$largeImage = (empty($slide['image_info']['large_image']))? plugins_url('images/vimeo_large_image.png', RCS_PLUGIN_MAIN_FILE) : $slide['image_info']['large_image'];
		$thumbnail = (empty($slide['image_info']['thumbnail']))? plugins_url('images/vimeo_thumbnail.png', RCS_PLUGIN_MAIN_FILE) : $slide['image_info']['thumbnail'];
		$out .= '<div id="'.$slide['slide_id'].'" data-src="'.$largeImage.'"';
		$out .= ' data-thumb="'.$thumbnail.'" >
					<iframe src="http://player.vimeo.com/video/'.$videoId.'" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>';
	}
	return $out;
}
//---------------------------------------------------
/**
 * echo the medium image by attachment id to use it after selecting an attachment
 *
 * @uses wp_get_attachment_image_src()
 *
 * @return void
 */
function rcs_get_medium_image(){
	$attch_url = (isset($_POST['attch_url']))? $_POST['attch_url'] : '';
	if(!empty($attch_url)){
		$attch_id = rcs_get_attachment_id_from_url(urldecode($attch_url));
		if($attch_id){
			$img = wp_get_attachment_image_src($attch_id, 'medium');
			if(empty($img[0])){
				$img = wp_get_attachment_image_src($attch_id, 'small');
			}
			echo $attch_id.'--++##++--'.$img[0];
		}
	}
	die();
}
//---------------------------------------------------
/**
 * echo the large image by attachment id to use it after selecting an attachment
 *
 * @uses wp_get_attachment_image_src()
 *
 * @return void
 */
function rcs_get_large_image(){
	$attch_url = (isset($_POST['attch_url']))? $_POST['attch_url'] : '';
	if(!empty($attch_url)){
		$attch_id = rcs_get_attachment_id_from_url(urldecode($attch_url));
		if($attch_id){
			$img = wp_get_attachment_image_src($attch_id, 'large');
			if(empty($img[0])){
				$img = wp_get_attachment_image_src($attch_id, 'medium');
			}
			if(empty($img[0])){
				$img = wp_get_attachment_image_src($attch_id, 'small');
			}
			
			echo $attch_id.'--++##++--'.$img[0];
		}
	}
	die();
}
//---------------------------------------------------
/**
 * Gets thumbnails of a vimeo video from vimeo API
 *
 * @uses wp_remote_get()
 *
 * @return array
 */
function rcs_get_vimeo_image_info($vimeo_id){
	$url = 'https://vimeo.com/api/v2/video/'.$vimeo_id.'.json';
	$res = wp_remote_get($url);
	$response = array('large_image' => '', 'thumbnail' => '');
	if($res instanceof WP_Error){
	} else{
		$data = json_decode($res, true);
		$response['large_image'] = $data['thumbnail_large'];
		$response['thumbnail'] = $data['thumbnail_small'];
	}
	return $response;
}
//---------------------------------------------------
/**
 * Sets thumbnails of a vimeo video came from the client side javascript that made a request to vimeo API
 *
 * @uses update_post_meta()
 *
 * @return void
 */
function rcs_set_vimeo_thumbnails(){
	$slider_id = (isset($_POST['slider_id']))? $_POST['slider_id'] : 0;
	$slide_id = (isset($_POST['slide_id']))? $_POST['slide_id'] : 0;
	$thumbnail_small = (isset($_POST['thumbnail_small']))? $_POST['thumbnail_small'] : '';
	$thumbnail_large = (isset($_POST['thumbnail_large']))? $_POST['thumbnail_large'] : '';
	$slds = rcs_get_slider_slides($slider_id);
	$slides = array_values($slds);
	for($i = 0; $i < count($slides); $i++){
		if($slides[$i]['slide_id'] == $slide_id){
			$orgn = base64_encode(serialize($slides[$i]));
			$slides[$i]['image_info']['large_image'] = $thumbnail_large;
			$slides[$i]['image_info']['thumbnail'] = $thumbnail_small;
			$res = update_post_meta($slider_id, '_rcs_slider_slide', base64_encode(serialize($slides[$i])), $orgn);
		}
	}
	echo true;
	die();
}
//---------------------------------------------------
/**
 * Retrieves attachment id from url
 *
 * @uses wp_upload_dir()
 * @uses wpdb::get_var()
 * @uses wpdb::prepare()
 *
 * @return integer|boolean
 */
function rcs_get_attachment_id_from_url($attachment_url){
	global $wpdb;
	$upload_dir_paths = wp_upload_dir();
	if(strpos($attachment_url, $upload_dir_paths['baseurl']) !== false){
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
		
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
		
		$attachment_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM ".$wpdb->posts." wposts, ".$wpdb->postmeta." wpostmeta 
														WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' 
														AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
														
		return $attachment_id;
	}
	return false;
}
//---------------------------------------------------
/**
 * used to remove out elements that have null values
 *
 * @return array
 */
function rcs_remove_empty_elements_from_array($array){
	foreach($array as $key => $value){
		if($value == NULL || $value == ''){
			unset($array[$key]);
		}
	}
	return $array;
}
//---------------------------------------------------
/**
 * returns the available templates for slide caption in html option elements
 *
 * @return string
 */
function rcs_get_caption_example_options(){
	global $captionExampleClasses;
	$options = '';
	foreach($captionExampleClasses as $key => $val){
		$options .= '<option value="'.$key.'">'.$val.'</option>';
	}
	return $options;
}
//---------------------------------------------------
/**
 * add slashes
 *
 * @return mixed
 */
function rcs_addslashes($arr){
	if(is_array($arr)){
		$arr = array_map('rcs_addslashes', $arr);
	}
	else if(is_string($arr)){
		$arr = addslashes($arr);
	}
	return $arr;
}
//---------------------------------------------------
/**
 * strip slashes
 *
 * @return mixed
 */
function rcs_stripslashes($arr){
	if(is_array($arr)){
		$arr = array_map('rcs_stripslashes', $arr);
	}
	else if(is_string($arr)){
		$arr = stripslashes($arr);
	}
	return $arr;
}
//---------------------------------------------------
/**
 * add gradient support for 9IE
 *
 * @return void
 */
function rcs_IEgradientSupport(){
	echo '<!--[if gte IE 9]
		<style type="text/css">
			.gradient{
				filter: none;
			}
		</style>
		<![endif]-->';
}
//---------------------------------------------------
?>
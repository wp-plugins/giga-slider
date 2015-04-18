<?php
	
	$rcs_skin_colors = array('camera_graphite_skin' => 'graphite', 'camera_amber_skin' => 'amber', 'camera_ash_skin' => 'ash', 'camera_azure_skin' => 'azure',
						'camera_beige_skin' => 'beige', 'camera_black_skin' => 'black', 'camera_blue_skin' => 'blue', 'camera_brown_skin' => 'brown',
						'camera_burgundy_skin' => 'burgundy', 'camera_charcoal_skin' => 'charcoal', 'camera_chocolate_skin' => 'chocolate',
						'camera_coffee_skin' => 'coffee', 'camera_cyan_skin' => 'cyan', 'camera_fuchsia_skin' => 'fuchsia', 'camera_gold_skin' => 'gold',
						'camera_green_skin' => 'green', 'camera_grey_skin' => 'grey', 'camera_indigo_skin' => 'indigo', 'camera_khaki_skin' => 'khaki',
						'camera_lime_skin' => 'lime', 'camera_magenta_skin' => 'magenta', 'camera_maroon_skin' => 'maroon', 'camera_orange_skin' => 'orange',
						'camera_olive_skin' => 'olive', 'camera_pink_skin' => 'pink', 'camera_pistachio_skin' => 'pistachio', 'camera_red_skin' => 'red',
						'camera_tangerine_skin' => 'tangerine', 'camera_turquoise_skin' => 'turquoise', 'camera_violet_skin' => 'violet',
						'camera_white_skin' => 'white', 'camera_yellow_skin' => 'yellow');
						
	$rcs_easing_features = array('linear' => 'liner', 'swing' => 'swing', 'easeInQuad' => 'ease in quad', 'easeOutQuad' => 'ease out quad',
							'easeInOutQuad' => 'ease in out quad', 'easeInCubic' => 'ease in cubic', 'easeOutCubic' => 'ease out cubic',
							'easeInOutCubic' => 'ease in out cubic', 'easeInQuart' => 'ease in quart', 'easeOutQuart' => 'ease out quart',
							'easeInOutQuart' => 'ease in out quart', 'easeInQuint' => 'ease in quint', 'easeOutQuint' => 'ease out quint',
							'easeInOutQuint' => 'ease in out quint', 'easeInExpo' => 'ease in expo', 'easeOutExpo' => 'ease out expo',
							'easeInOutExpo' => 'ease in out expo', 'easeInSine' => 'ease in sine', 'easeOutSine' => 'ease out sine',
							'easeInOutSine' => 'ease in out sine', 'easeInCirc' => 'ease in circ', 'easeOutCirc' => 'ease out circ',
							'easeInOutCirc' => 'ease in out circ', 'easeInElastic' => 'ease in elastic', 'easeOutElastic' => 'ease out elastic',
							'easeInOutElastic' => 'ease in out elastic', 'easeInBack' => 'ease in back', 'easeOutBack' => 'ease out back',
							'easeInOutBack' => 'ease in out back', 'easeInBounce' => 'ease in bounce', 'easeOutBounce' => 'ease out bounce');
					
	$rcs_fx_features = array('random' => 'random', 'simpleFade' => 'simple fade', 'curtainTopLeft' => 'curtain top left', 'curtainTopRight' => 'curtain top right',
						'curtainBottomLeft' => 'curtain bottom left', 'curtainBottomRight' => 'curtain bottom right', 'curtainSliceLeft' => 'curtain slice left',
						'curtainSliceRight' => 'curtain slice right', 'blindCurtainTopLeft' => 'blind curtain top left',
						'blindCurtainTopRight' => 'blind curtain top right', 'blindCurtainBottomLeft' => 'blind curtain bottom left',
						'blindCurtainBottomRight' => 'blind curtain bottom right', 'blindCurtainSliceBottom' => 'blind curtain slice bottom',
						'blindCurtainSliceTop' => 'blind curtain slice top', 'stampede' => 'stampede', 'mosaic' => 'mosaic',
						'mosaicReverse' => 'mosaic reverse', 'mosaicRandom' => 'mosaic random', 'mosaicSpiral' => 'mosaic spiral',
						'mosaicSpiralReverse' => 'mosaic spiral reverse', 'topLeftBottomRight' => 'top left bottom right',
						'bottomRightTopLeft' => 'bottom right top left', 'bottomLeftTopRight' => 'bottom left top right',
						'scrollLeft' => 'scroll left', 'scrollRight' => 'scroll right', 'scrollHorz' => 'scroll horz',
						'scrollBottom' => 'scroll bottom', 'scrollTop' => 'scroll top');
					
	$rcs_slide_fx = array('random' => 'random', 'simpleFade' => 'simple fade', 'curtainTopLeft' => 'curtain top left', 'curtainTopRight' => 'curtain top right',
							'curtainBottomLeft' => 'curtain bottom left', 'curtainBottomRight' => 'curtain bottom right', 'curtainSliceLeft' => 'curtainSliceLeft',
							'curtainSliceRight' => 'curtain slice right', 'blindCurtainTopLeft' => 'blind curtain top left', 'blindCurtainTopRight' => 'blind curtain top right',
							'blindCurtainBottomLeft' => 'blind curtain bottom left', 'blindCurtainBottomRight' => 'blind curtain bottom right',
							'blindCurtainSliceBottom' => 'blind curtain slice bottom', 'blindCurtainSliceTop' => 'blind curtain slice top', 'stampede' => 'stampede',
							'mosaic' => 'mosaic', 'mosaicReverse' => 'mosaic reverse', 'mosaicRandom' => 'mosaic random', 'mosaicSpiral' => 'mosaic spiral',
							'mosaicSpiralReverse' => 'mosaic spiral reverse', 'topLeftBottomRight' => 'top left bottom right', 'bottomRightTopLeft' => 'bottom right top left',
							'bottomLeftTopRight' => 'bottom left top right');

	$rcs_alignments = array('topLeft' => 'top left', 'topCenter' => 'top center', 'topRight' => 'top right', 'centerLeft' => 'center left',
						'center' => 'center', 'centerRight' => 'center right', 'bottomLeft' => 'bottom left', 'bottomCenter' => 'bottom center',
						'bottomRight' => 'bottom right');
						
	$rcs_wordpress_scripts = array('Image cropper', 'jcrop', 'swfobject', 'swfupload', 'swfupload-degrade', 'swfupload-queue', 'swfupload-handlers',
									'jquery', 'jquery-form', 'jquery-color', 'jquery-masonry', 'masonry', 'jquery-ui-core', 'jquery-ui-widget',
									'jquery-ui-accordion', 'jquery-ui-autocomplete', 'jquery-ui-button', 'jquery-ui-datepicker', 'jquery-ui-dialog',
									'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-menu', 'jquery-ui-mouse', 'jquery-ui-position',
									'jquery-ui-progressbar', 'jquery-ui-selectable', 'jquery-ui-resizable', 'jquery-ui-selectmenu', 'jquery-ui-sortable',
									'jquery-ui-slider', 'jquery-ui-tooltip', 'jquery-ui-tabs', 'jquery-effects-core', 'jquery-effects-blind',
									'jquery-effects-bounce', 'jquery-effects-clip', 'jquery-effects-drop', 'jquery-effects-explode',
									'jquery-effects-fade', 'jquery-effects-fold', 'jquery-effects-highlight', 'jquery-effects-pulsate',
									'jquery-effects-scale', 'jquery-effects-shake', 'jquery-effects-slide', 'jquery-effects-transfer',
									'wp-mediaelement', 'schedule', 'suggest', 'suggest', 'hoverIntent', 'jquery-hotkeys', 'sack', 'quicktags', 'iris',
									'farbtastic', 'colorpicker', 'tiny_mce', 'autosave', 'wp-ajax-response', 'wp-lists', 'common', 'editorremov',
									'editor-functions', 'ajaxcat', 'admin-categories', 'admin-tags', 'admin-custom-fields', 'password-strength-meter',
									'admin-comments', 'admin-users', 'admin-forms', 'xfn', 'upload', 'postbox', 'slug', 'post', 'page', 'link', 'comment',
									'comment-reply', 'admin-gallery', 'media-upload', 'admin-widgets', 'word-count', 'theme-preview', 'json2', 'plupload',
									'plupload-all', 'plupload-html4', 'plupload-html5', 'plupload-flash', 'plupload-silverlight', 'underscore', 'backbone');
									
	
	$rcs_wordpress_scripts_35 = array('utils', 'common', 'sack', 'quicktags', 'colorpicker', 'editor', 'wp-fullscreen', 'wp-ajax-response', 'wp-pointer',
									'autosave', 'heartbeat', 'wp-auth-check', 'wp-lists', 'prototype', 'scriptaculous-root', 'scriptaculous-builder',
									'scriptaculous-dragdrop', 'scriptaculous-effects', 'scriptaculous-slider', 'scriptaculous-sound', 'scriptaculous-controls',
									'scriptaculous', 'cropper', 'jquery', 'jquery-core', 'jquery-migrate', 'jquery-core', 'jquery-migrate', 'jquery-ui-core',
									'jquery-effects-core', 'jquery-effects-blind', 'jquery-effects-bounce', 'jquery-effects-clip', 'jquery-effects-drop',
									'jquery-effects-explode', 'jquery-effects-fade', 'jquery-effects-fold', 'jquery-effects-highlight', 'jquery-effects-pulsate',
									'jquery-effects-scale', 'jquery-effects-shake', 'jquery-effects-slide', 'jquery-effects-transfer', 'jquery-ui-accordion',
									'jquery-ui-autocomplete', 'jquery-ui-button', 'jquery-ui-datepicker', 'jquery-ui-dialog', 'jquery-ui-draggable',
									'jquery-ui-droppable', 'jquery-ui-menu', 'jquery-ui-mouse', 'jquery-ui-position', 'jquery-ui-progressbar', 'jquery-ui-resizable',
									'jquery-ui-selectable', 'jquery-ui-slider', 'jquery-ui-sortable', 'jquery-ui-spinner', 'jquery-ui-tabs', 'jquery-ui-tooltip',
									'jquery-ui-widget', 'jquery-form', 'jquery-color', 'suggest', 'schedule', 'jquery-query', 'jquery-serialize-object',
									'jquery-hotkeys', 'jquery-table-hotkeys', 'jquery-touch-punch', 'jquery-masonry', 'thickbox', 'jcrop', 'swfobject',
									'plupload', 'plupload-html5', 'plupload-flash', 'plupload-silverlight', 'plupload-html4', 'plupload-all', 'plupload',
									'plupload-html5', 'plupload-flash', 'plupload-silverlight', 'plupload-html4', 'plupload-handlers', 'wp-plupload',
									'swfupload', 'swfupload-swfobject', 'swfupload-queue', 'swfupload-speed', 'swfupload-all', 'swfupload-handlers',
									'comment-reply', 'json2', 'underscore', 'backbone', 'wp-util', 'wp-backbone', 'revisions', 'imgareaselect', 'mediaelement',
									'wp-mediaelement', 'zxcvbn-async', 'password-strength-meter', 'user-profile', 'user-suggest', 'admin-bar', 'wplink',
									'wpdialogs', 'wpdialogs-popup', 'word-count', 'media-upload', 'hoverIntent', 'customize-base', 'customize-loader',
									'customize-preview', 'customize-controls', 'accordion', 'shortcode', 'media-models', 'media-views', 'media-editor',
									'mce-view', 'admin-tags', 'admin-comments', 'xfn', 'postbox', 'post', 'link', 'comment', 'admin-gallery', 'admin-widgets',
									'theme', 'theme-install', 'inline-edit-post', 'inline-edit-tax', 'plugin-install', 'farbtastic', 'iris', 'wp-color-picker',
									'dashboard', 'list-revisions', 'media', 'image-edit', 'set-post-thumbnail', 'nav-menu', 'custom-header', 'custom-background',
									'media-gallery', 'svg-painter');
									
									
	$captionExampleClasses = array('black_shadow_whiteGradientBG' => 'black, shadow, white gradient BG', 'black_shadow_redGradientBG' => 'black, shadow, red gradient BG',
									'black_shadow_gradientBG' => 'black, shadow, gradient BG', 'large_white_greyBG_opacity' => 'large, white, grey BG, opacity',
									'large_black_shadow' => 'large, black, shadow', 'large_white_bold_trBG' => 'large, white, bold, transparent BG',
									'medium_white_bold_trBG' => 'medium, white, bold, transparent BG', 'dark_blue_shadow_blueGradientBG' => 'dark, blue, shadow, blue gradient BG',
									'black_blackTransparentGradientBG' => 'black, black transparent gradient BG', 'black_blackTransparentLTRGradientBG' => 'black, black transparent LTR gradient BG',
									'black_rainbowOpacityBG' => 'black, rainbow colours opacity BG',
									'small_white_bold_trBG' => 'small, white, bold, transparent BG', 'large_white_redBG' => 'large, white, red BG',
									'large_white_blueBG' => 'large, white, blue BG', 'large_white_greyBG' => 'large, white, grey BG',
									'large_white_blackBG' => 'large, white, black BG', 'large_white_blackBG_opacity' => 'large, white, black BG, opacity',
									'large_black_trBG' => 'large, black, transparent BG', 'medium_black_trBG' => 'medium, black, transparent BG',
									'small_black_trBG' => 'small, black, transparent BG', 'large_black_greenBG' => 'large, black, green BG',
									'large_white_orangeBG' => 'large, white, orange BG', 'large_white_greyBG' => 'large, white, grey BG',
									'medium_red_trBG' => 'medium, red, transparent BG', 'medium_blue_trBG' => 'medium, blue, transparent BG',
									'medium_darkgrey_trBG' => 'medium, dark grey, transparent BG', 'medium_move_trBG' => 'medium, move, transparent BG'
									);
									
									
?>

var IN_SORTING = false;

jQuery(function(){
	/* begin options */
	jQuery('#loaderColor').colpick({
		colorScheme: 'dark',
		layout: 'hex',
		color: jQuery('#loader_color').val(),
		onSubmit:function(hsb, hex, rgb, el){
			jQuery('#loader_color').val(hex);
			jQuery(el).css('background-color', '#' + hex);
			jQuery(el).colpickHide();
		}
	}).css('background-color', '#' + jQuery('#loader_color').val());


	jQuery('#loaderBGColor').colpick({
		colorScheme: 'dark',
		layout: 'hex',
		color: jQuery('#loader_bg_color').val(),
		onSubmit:function(hsb, hex, rgb, el){
			jQuery('#loader_bg_color').val(hex);
			jQuery(el).css('background-color', '#' + hex);
			jQuery(el).colpickHide();
		}
	}).css('background-color', '#' + jQuery('#loader_bg_color').val());
	/* end options */
	
	/* begin slides */
    jQuery('.collapsible-panel div.body').hide();
	
    jQuery('.collapsible-panel div.header').click(function(e){;
		if(!IN_SORTING){
			jQuery(this).next('.collapsible-panel div.body').slideToggle(400);
			jQuery(this).toggleClass('active');
			e.preventDefault();
		} else{
			IN_SORTING = false;
		}
    });
	
	jQuery("#sortable-slides").sortable({
		axis: 'y',
		cursor: 'move',
		stop: function(evt, ui){
			var o = 0;
			jQuery('#sortable-slides li').each(function(index){
				var i = (new String(jQuery(this).attr('id'))).split('_').reverse()[0];
				jQuery('#slides_order_' + i).val(++o);
			});
			jQuery('#slides_order').val(o);
			IN_SORTING = true;
		}
	});
	
	window.original_send_to_editor = window.send_to_editor;

	window.send_to_editor = function(html){
		var imageFormIndex = jQuery('#imageFormIndex').val();
		var imageEditorGoal = jQuery('#imageEditorGoal').val();
		if((imageFormIndex != null && imageFormIndex != '') || imageEditorGoal == 'watermark'){
			var fileurl = '';
			fileurl = jQuery('img', html).attr('src');
			if(!fileurl){
				var regex = /src="(.+?)"/;
				var rslt = html.match(regex);
				fileurl = rslt[1];
			}
			
			if(imageEditorGoal == 'watermark'){
				var img = jQuery('#watermark');
			} else{
				var img = jQuery('#image_holder_' + imageFormIndex + ' img');
			}
			if(img){
				img.remove();
			}
			
			if(imageEditorGoal == 'watermark'){
				rcs_addLargeImage(fileurl);
				jQuery('#deleteWatermark').css('display', 'block');
			} else{
				rcs_addMediumImage(fileurl);
			}
			
			tb_remove();
			jQuery('html').removeClass('Image');
		} else{
			window.original_send_to_editor(html);
		}
	}
	
	/* begin caption example */
	
	jQuery('.slides_style_template').on('change', function(evt){
		rcs_selectCaptionExample(jQuery(this).attr('id'), jQuery(this).val());
	});
	
	jQuery('.slides_caption_css').on('blur', function(evt){
		rcs_styleCaptionExample(jQuery(this).attr('id'));
	});
		
	/* end caption example */
	
	/* click event handler for the caption CSS reviewer */
	jQuery('.captionExampleCont').on('click', function(evt){
		rcs_styleCaptionExample(jQuery(this).attr('id'));
	});
});

//---------------------------------------------------------
//---------------------------------------------------------
//---------------------------------------------------------
function rcs_handleNavigationChange(ch){
	jQuery('#navigation_on_hover').prop('disabled', !ch.checked);
}
//---------------------------------------------------------
function rcs_handleLoaderChange(val){
	var disabled = true;
	if(val == 'bar'){
		disabled = false;
	}
	jQuery('#bar_position').prop('disabled', disabled);
	jQuery('#bar_direction').prop('disabled', disabled);
}
//---------------------------------------------------------
function rcs_handleIndexingChange(val){
	var disabled = true;
	if(val == 'thumbnails'){
		disabled = false;
	}
	jQuery('#thumbnail_width').prop('disabled', disabled);
	jQuery('#thumbnail_height').prop('disabled', disabled);
}
//---------------------------------------------------------
function rcs_customEffectsChange(el){
	var checked = el.checked;
	var index = (new String(el.id)).split('_').reverse()[0];
	var sts = (checked)? "disable" : "enable";
	var tme = jQuery('#slides_time_' + index);
	var trn_prd = jQuery('#slides_transition_period_' + index);
	var tme_sld = jQuery('#slides_time_slider_' + index);
	var trn_prd_sld = jQuery('#slides_transition_period_slider_' + index);
	tme_sld.slider(sts);
	trn_prd_sld.slider(sts);
	if(checked){
		tme.val("");
		trn_prd.val("");
	}
	else if(tme.val() == ""){
		tme.val(tme_sld.slider("value"));
		trn_prd.val(trn_prd_sld.slider("value"));
	}
	jQuery('#slides_easing_' + index).prop('disabled', checked);
	jQuery('#slides_fx_' + index).prop('disabled', checked);
}
//---------------------------------------------------------
function rcs_slideTypeChange(el){
	var type = rcs_getFieldValue((new String(el.name)).replace(/(\[|\])/g, '\\$1'));
	var index = (new String(el.id)).split('_').reverse()[0];
	jQuery('#image_container_' + index).css('display', 'none');
	jQuery('#youtube_container_' + index).css('display', 'none');
	jQuery('#vimeo_container_' + index).css('display', 'none');
	
	jQuery('#slide_element_' + index + ' div.header span.icon').removeClass('image');
	jQuery('#slide_element_' + index + ' div.header span.icon').removeClass('vimeo');
	jQuery('#slide_element_' + index + ' div.header span.icon').removeClass('youtube');
	
	jQuery('#' + type + '_container_' + index).css('display', 'block');
	
	jQuery('#slide_element_' + index + ' div.header span.icon').addClass(type);
}
//---------------------------------------------------------
function rcs_getFieldValue(fieldName){
	var  fields = jQuery('[name=' + fieldName + ']');
	var tagName = fields.prop('tagName');
	
	switch(tagName){
		case 'SELECT':
		case 'TEXTAREA':
		return fields.val();
		break;
		
		case 'INPUT':
		var type = fields.prop('type');
		switch(type){
			case 'text':
			case 'password':
			case 'hidden':
			return fields.val();
			break;
			
			case 'radio':
			return jQuery('[name=' + fieldName + ']:checked').val();
			break;
			
			case 'checkbox':
			var items = [];
			jQuery('[name=' + fieldName + ']:checked').each(function(){
				items.push($(this).val());
			});
			return items;
			break;
			
			default:
			return fields.val();
		}
		break;
		
		default:
		return fields.val();
	}
}
//---------------------------------------------------------
function rcs_addImage(btn_id){
	var imageFormIndex = (new String(btn_id)).split('_').reverse()[0];
	jQuery('#imageFormIndex').val(imageFormIndex);
	jQuery('#imageEditorGoal').val('slide_image');
	jQuery('html').addClass('Image');
	
	var frame;
	if (WORDPRESS_VER >= "3.5") {
		if (frame) {
			frame.open();
			return;
		}
		frame = wp.media();
		frame.on("select", function(){
			var attachment = frame.state().get("selection").first();
			var fileurl = attachment.attributes.url;
			frame.close();
			
			var img = jQuery('#image_holder_' + imageFormIndex + ' img');
			if(img){
				img.remove();
			}
			
			rcs_addMediumImage(fileurl);
		});
		frame.open();
	}
	else {
		tb_show("", "media-upload.php?type=image&amp;TB_iframe=true&amp;tab=library");
		return false;
	}
}
//---------------------------------------------------------
function rcs_addWatermark(){
	jQuery('#imageEditorGoal').val('watermark');
	jQuery('html').addClass('Image');
	
	var frame;
	if (WORDPRESS_VER >= "3.5") {
		if (frame) {
			frame.open();
			return;
		}
		frame = wp.media();
		frame.on("select", function(){
			var attachment = frame.state().get("selection").first();
			var fileurl = attachment.attributes.url;
			frame.close();
			
			var img = jQuery('#watermark');
			if(img){
				img.remove();
			}
			
			rcs_addLargeImage(fileurl);
		});
		frame.open();
	}
	else {
		tb_show("", "media-upload.php?type=image&amp;TB_iframe=true&amp;tab=library");
		return false;
	}
}
//---------------------------------------------------------
function rcs_removeSlide(index, evt){
	jQuery('#slide_element_' + index).remove();
	evt.preventDefault();
}
//---------------------------------------------------------
function rcs_addMediumImage(attch_url){
	jQuery.ajax({
		type: 'POST',
		url: RCS_ADMIN_URL + 'admin-ajax.php',
		data: {
			action: 'RCS_GET_MEDIUM_IMG_I',
			attch_url: encodeURIComponent(attch_url)
		},
		success: function(data){
			var res = (new String(data)).split('--++##++--');
			var imageFormIndex = jQuery('#imageFormIndex').val();
			jQuery('#image_holder_' + imageFormIndex).append('<img src="' + res[1] + '" id="slide_image_' + imageFormIndex + '" />');
			jQuery('#slides_image_id_' + imageFormIndex).val(res[0]);
		}
	});
}
//---------------------------------------------------------
function rcs_addLargeImage(attch_url){
	jQuery.ajax({
		type: 'POST',
		url: RCS_ADMIN_URL + 'admin-ajax.php',
		data: {
			action: 'RCS_GET_LARGE_IMG_I',
			attch_url: encodeURIComponent(attch_url)
		},
		success: function(data){
			var res = (new String(data)).split('--++##++--');
			jQuery('#watermark_holder').append('<img src="' + res[1] + '" id="watermark" />');
			jQuery('#watermark_id').val(res[0]);
			jQuery('#deleteWatermark').css('display', 'block');
		}
	});
}
//---------------------------------------------------------
function rcs_getVimeoThumbnails(vimeoId, slide_id, slider_id){
	jQuery.get('https://vimeo.com/api/v2/video/' + vimeoId + '.json', {},
	function(response){
		var result = new Object(response[0]);
		if(typeof result == 'object' && result != null && result.thumbnail_small && result.thumbnail_large){
			var slide = jQuery('#' + slide_id);
			if(slide){
				slide.data('src', result.thumbnail_large);
				slide.data('thumb', result.thumbnail_small);
			}
			setVimeoThumbnails(slider_id, slide_id, result.thumbnail_large, result.thumbnail_small);
		}
	});
}
//---------------------------------------------------------
function setVimeoThumbnails(slider_id, slide_id, thumbnail_large, thumbnail_small){
	jQuery.post(RCS_ADMIN_URL + 'admin-ajax.php', {
		action: 'RCS_SET_VIMEO_THUMBNAILS',
		slider_id: slider_id,
		slide_id: slide_id,
		thumbnail_small: thumbnail_small,
		thumbnail_large: thumbnail_large
	},
	function(response){
	});
}
//---------------------------------------------------------
function rcs_deleteWatermark(){
	jQuery('#watermark_id').val('');
	jQuery('#watermark').remove();
	jQuery('#deleteWatermark').css('display', 'none');
}
//---------------------------------------------------------
/* begin caption example */

var rcs_captionClass = {
					"large_white_greyBG_opacity": "color: #FFF; font-size: 48px; background-color: #7A7B7F;" +
					"opacity: 0.7; filter: alpha(opacity=70); padding: 20px;",
					"large_black_shadow": "color: #474545; font-size: 48px; background-color: #FFF; opacity: 0.5; " +
					"filter: alpha(opacity=50); padding: 30px; text-shadow: 2px 2px 4px #000000;",
					
					"black_shadow_gradientBG": "background: rgba(237,237,237,1);" +
					"background: -moz-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 46%, rgba(255,255,255,1) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(237,237,237,1)), color-stop(46%, rgba(246,246,246,1)), color-stop(100%, rgba(255,255,255,1)));" +
					"background: -webkit-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 46%, rgba(255,255,255,1) 100%);" +
					"background: -o-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 46%, rgba(255,255,255,1) 100%);" +
					"background: -ms-linear-gradient(left, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 46%, rgba(255,255,255,1) 100%);" +
					"background: linear-gradient(to right, rgba(237,237,237,1) 0%, rgba(246,246,246,1) 46%, rgba(255,255,255,1) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ededed', endColorstr='#ffffff', GradientType=1 );" +
					"padding: 30px; color: #3F3D3D; font-size: 48px; text-shadow: 2px 2px 4px #000000;",
					
					"black_shadow_redGradientBG": "background: rgba(248,80,50,0.15);" +
					"background: -moz-linear-gradient(left, rgba(248,80,50,0.15) 0%, rgba(246,41,12,0.26) 13%, rgba(240,48,23,0.46) 37%, rgba(241,111,92,0.83) 80%, rgba(231,56,39,1) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(248,80,50,0.15)), color-stop(13%, rgba(246,41,12,0.26)), color-stop(37%, rgba(240,48,23,0.46)), color-stop(80%, rgba(241,111,92,0.83)), color-stop(100%, rgba(231,56,39,1)));" +
					"background: -webkit-linear-gradient(left, rgba(248,80,50,0.15) 0%, rgba(246,41,12,0.26) 13%, rgba(240,48,23,0.46) 37%, rgba(241,111,92,0.83) 80%, rgba(231,56,39,1) 100%);" +
					"background: -o-linear-gradient(left, rgba(248,80,50,0.15) 0%, rgba(246,41,12,0.26) 13%, rgba(240,48,23,0.46) 37%, rgba(241,111,92,0.83) 80%, rgba(231,56,39,1) 100%);" +
					"background: -ms-linear-gradient(left, rgba(248,80,50,0.15) 0%, rgba(246,41,12,0.26) 13%, rgba(240,48,23,0.46) 37%, rgba(241,111,92,0.83) 80%, rgba(231,56,39,1) 100%);" +
					"background: linear-gradient(to right, rgba(248,80,50,0.15) 0%, rgba(246,41,12,0.26) 13%, rgba(240,48,23,0.46) 37%, rgba(241,111,92,0.83) 80%, rgba(231,56,39,1) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f85032', endColorstr='#e73827', GradientType=1 );" +
					"padding: 30px; color: #3F3D3D; font-size: 48px; text-shadow: 2px 2px 4px #000000;",
					
					"black_shadow_whiteGradientBG" : "background: rgba(255,255,255,1);" +
					"background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,0.62) 47%, rgba(237,237,237,0.2) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,0.62)), color-stop(100%, rgba(237,237,237,0.2)));" +
					"background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,0.62) 47%, rgba(237,237,237,0.2) 100%);" +
					"background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,0.62) 47%, rgba(237,237,237,0.2) 100%);" +
					"background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(246,246,246,0.62) 47%, rgba(237,237,237,0.2) 100%);" +
					"background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(246,246,246,0.62) 47%, rgba(237,237,237,0.2) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=1 );" +
					"padding: 30px; color: #3F3D3D; font-size: 48px; text-shadow: 2px 2px 4px #000000;",
					
					"dark_blue_shadow_blueGradientBG": "background: rgba(147,206,222,0.2);" +
					"background: -moz-linear-gradient(left, rgba(147,206,222,0.2) 0%, rgba(73,165,191,0.2) 0%, rgba(117,189,209,1) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(147,206,222,0.2)), color-stop(0%, rgba(73,165,191,0.2)), color-stop(100%, rgba(117,189,209,1)));" +
					"background: -webkit-linear-gradient(left, rgba(147,206,222,0.2) 0%, rgba(73,165,191,0.2) 0%, rgba(117,189,209,1) 100%);" +
					"background: -o-linear-gradient(left, rgba(147,206,222,0.2) 0%, rgba(73,165,191,0.2) 0%, rgba(117,189,209,1) 100%);" +
					"background: -ms-linear-gradient(left, rgba(147,206,222,0.2) 0%, rgba(73,165,191,0.2) 0%, rgba(117,189,209,1) 100%);" +
					"background: linear-gradient(to right, rgba(147,206,222,0.2) 0%, rgba(73,165,191,0.2) 0%, rgba(117,189,209,1) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#93cede', endColorstr='#75bdd1', GradientType=1 );" +
					"padding: 30px; color: #005168; font-size: 48px; text-shadow: 2px 2px 4px #000000;",
					
					"black_blackTransparentGradientBG": "background: rgba(0,0,0,0);" +
					"background: -moz-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(0,0,0,0.53) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,0,0,0)), color-stop(100%, rgba(0,0,0,0.53)));" +
					"background: -webkit-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(0,0,0,0.53) 100%);" +
					"background: -o-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(0,0,0,0.53) 100%);" +
					"background: -ms-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(0,0,0,0.53) 100%);" +
					"background: linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,0.53) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000', GradientType=1 );" +
					"padding: 30px; color: #3F3D3D; font-size: 48px; text-shadow: 2px 2px 4px #000000;",
					
					"black_blackTransparentLTRGradientBG": "background: rgba(0,0,0,0.53);" +
					"background: -moz-linear-gradient(left, rgba(0,0,0,0.53) 0%, rgba(0,0,0,0) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,0,0,0.53)), color-stop(100%, rgba(0,0,0,0)));" +
					"background: -webkit-linear-gradient(left, rgba(0,0,0,0.53) 0%, rgba(0,0,0,0) 100%);" +
					"background: -o-linear-gradient(left, rgba(0,0,0,0.53) 0%, rgba(0,0,0,0) 100%);" +
					"background: -ms-linear-gradient(left, rgba(0,0,0,0.53) 0%, rgba(0,0,0,0) 100%);" +
					"background: linear-gradient(to right, rgba(0,0,0,0.53) 0%, rgba(0,0,0,0) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000', GradientType=1 );" +
					"padding: 30px; color: #3F3D3D; font-size: 48px; text-shadow: 2px 2px 4px #000000;",
					
					"black_rainbowOpacityBG": "background: rgba(254,0,0,0.7);" +
					"background: -moz-linear-gradient(left, rgba(254,0,0,0.7) 0%, rgba(255,157,0,0.68) 14%, rgba(247,255,0,0.67) 29%, rgba(60,241,14,0.65) 43%, rgba(1,255,230,0.64) 57%, rgba(0,34,255,0.62) 71%, rgba(196,0,255,0.61) 85%, rgba(255,0,157,0.59) 100%);" +
					"background: -webkit-gradient(left top, right top, color-stop(0%, rgba(254,0,0,0.7)), color-stop(14%, rgba(255,157,0,0.68)), color-stop(29%, rgba(247,255,0,0.67)), color-stop(43%, rgba(60,241,14,0.65)), color-stop(57%, rgba(1,255,230,0.64)), color-stop(71%, rgba(0,34,255,0.62)), color-stop(85%, rgba(196,0,255,0.61)), color-stop(100%, rgba(255,0,157,0.59)));" +
					"background: -webkit-linear-gradient(left, rgba(254,0,0,0.7) 0%, rgba(255,157,0,0.68) 14%, rgba(247,255,0,0.67) 29%, rgba(60,241,14,0.65) 43%, rgba(1,255,230,0.64) 57%, rgba(0,34,255,0.62) 71%, rgba(196,0,255,0.61) 85%, rgba(255,0,157,0.59) 100%);" +
					"background: -o-linear-gradient(left, rgba(254,0,0,0.7) 0%, rgba(255,157,0,0.68) 14%, rgba(247,255,0,0.67) 29%, rgba(60,241,14,0.65) 43%, rgba(1,255,230,0.64) 57%, rgba(0,34,255,0.62) 71%, rgba(196,0,255,0.61) 85%, rgba(255,0,157,0.59) 100%);" +
					"background: -ms-linear-gradient(left, rgba(254,0,0,0.7) 0%, rgba(255,157,0,0.68) 14%, rgba(247,255,0,0.67) 29%, rgba(60,241,14,0.65) 43%, rgba(1,255,230,0.64) 57%, rgba(0,34,255,0.62) 71%, rgba(196,0,255,0.61) 85%, rgba(255,0,157,0.59) 100%);" +
					"background: linear-gradient(to right, rgba(254,0,0,0.7) 0%, rgba(255,157,0,0.68) 14%, rgba(247,255,0,0.67) 29%, rgba(60,241,14,0.65) 43%, rgba(1,255,230,0.64) 57%, rgba(0,34,255,0.62) 71%, rgba(196,0,255,0.61) 85%, rgba(255,0,157,0.59) 100%);" +
					"filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fe0000', endColorstr='#ff009d', GradientType=1 );" +
					"padding: 30px; color: #3F3D3D; font-size: 48px; text-shadow: 2px 2px 4px #000000;",

					"large_white_bold_trBG": "color: #FFF; font-size: 48px; background-color: transparent; padding: 30px;",
					"medium_white_bold_trBG": "color: #FFF; font-size: 40px; background-color: transparent; padding: 25px;",
					"small_white_bold_trBG": "color: #FFF; font-size: 20px; background-color: transparent; padding: 15px; font-weight: bold;",
					"large_white_redBG": "color: #FFF; font-size: 48px; background-color: #EF3636; padding: 30px;",
					"large_white_blueBG": "color: #FFF; font-size: 48px; background-color: #0292E6; padding: 30px;",
					"large_white_greyBG": "color: #FFF; font-size: 48px; background-color: #8C8983; padding: 30px;",
					"large_white_blackBG": "color: #FFF; font-size: 48px; background-color: #000; padding: 50px;",
					"large_white_blackBG_opacity": "color: #FFF; font-size: 48px; background-color: #000; opacity: 0.7; filter: alpha(opacity=70); padding: 30px;",
					"large_black_trBG": "color: #FFF; font-size: 48px; background-color: transparent; padding: 30px;",
					"medium_black_trBG": "color: #FFF; font-size: 40px; background-color: transparent; padding: 25px;",
					"small_black_trBG": "color: #FFF; font-size: 20px; background-color: transparent; padding: 15px;",
					"large_black_greenBG": "color: #FFF; font-size: 48px; background-color: #3B8D59; padding: 30px;",
					"large_white_orangeBG": "color: #FFF; font-size: 48px; background-color: #F5655C; padding: 30px;",
					"large_white_greyBG": "color: #FFF; font-size: 48px; background-color: #8C8983; padding: 30px;",
					"medium_red_trBG": "color: #BF0000; font-size: 40px; background-color: transparent; padding: 25px;",
					"medium_blue_trBG": "color: #006BB7; font-size: 40px; background-color: transparent; padding: 25px;",
					"medium_darkgrey_trBG": "color: #4D4D4D; font-size: 40px; background-color: transparent; padding: 25px;",
					"medium_move_trBG": "color: #8C354C; font-size: 40px; background-color: transparent; padding: 25px;"
						};
						
						
function rcs_styleCaptionExample(id){
	var index = (new String(id)).split('_').reverse()[0];
	var elm = '<div id="slideCaptionExample_' + index + '" class="captionExample" style="' +
				jQuery('#slides_caption_css_' + index).val() + '">example</div>';
	jQuery('#slideCaptionExample_' + index).remove();
	jQuery('#slideCaptionExampleCon_' + index).html(elm);
}

function rcs_selectCaptionExample(id, val){
	var index = (new String(id)).split('_').reverse()[0];
	jQuery('#slides_caption_css_' + index).val(rcs_captionClass[val]);
	rcs_styleCaptionExample(id)
}

/* end caption example */


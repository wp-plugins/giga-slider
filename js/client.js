
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
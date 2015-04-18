<?php

class RC_Attachment{
	
	var $attachmentId;
	var $watermarkImageId;
	var $imageEditor;
	var $requiredHeight;
	var $url;
	var $width;
	var $height;
	
	/**
	 * Class constructor
	 *
	 * @uses get_attached_file()
	 * @uses wp_get_image_editor()
	 * @uses WP_Image_Editor::get_error_message()
	 * @uses WP_Image_Editor::get_error_code()
	 * @uses wp_get_attachment_url()
	 *
	 * @return void
	 */
	function RC_Attachment($imgId, $height, $watermarkImgId = NULL){
		$this->attachmentId = $imgId;
		$this->watermarkImageId = $watermarkImgId;
		$this->requiredHeight = $height;
		
		$this->imageEditor = wp_get_image_editor(get_attached_file($this->attachmentId));
		if(!($this->imageEditor instanceof WP_Image_Editor)){
			throw new Exception($this->imageEditor->get_error_message($this->imageEditor->get_error_code()));
		}
		
		//$parsed = parse_url(wp_get_attachment_url($this->attachmentId));
		//$this->url = dirname($parsed['path']);
		
		$this->url = dirname(wp_get_attachment_url($this->attachmentId));
	}
	
	/**
	 * Generates other needed size for the attachment
	 *
	 * @uses imageEditor::save()
	 * @uses imageEditor::generate_filename()
	 * @uses imageEditor::get_size()
	 * @uses get_attached_file()
	 * @uses wp_get_image_editor()
	 * @uses WP_Image_Editor::get_error_message()
	 * @uses WP_Image_Editor::get_error_code()
	 *
	 * @return array
	 */
	function generateOtherSizes(){
		$image_info = array();
		
		$result = $this->imageEditor->save($this->imageEditor->generate_filename());
		$image_info['large_image'] = $this->url.'/'.$result['file'];
		
		$dimension = $this->imageEditor->get_size();
		$this->width = $dimension['width'];
		$this->height = $dimension['height'];
		
		$thumb = $this->_generateThumbnail();
		$image_info['thumbnail'] =  $this->url.'/'.$thumb['file'];
		
		if(!empty($this->watermarkImageId)){
			set_time_limit(120);
			$this->_addWatermark(dirname(get_attached_file($this->attachmentId)).DIRECTORY_SEPARATOR.$result['file'],
									get_attached_file($this->watermarkImageId));
		}
		
		return $image_info;
	}
	
	/**
	 * Generates thumbnail for the attachment
	 *
	 * @uses wp_get_image_editor()
	 * @uses get_attached_file()
	 * @uses WP_Image_Editor()
	 * @uses WP_Image_Editor::get_error_message()
	 * @uses WP_Image_Editor::get_error_code()
	 * @uses WP_Image_Editor::resize()
	 * @uses WP_Image_Editor::set_quality()
	 * @uses WP_Image_Editor::save()
	 * @uses WP_Image_Editor::generate_filename()
	 *
	 * @return array
	 */
	function _generateThumbnail(){
		$editor = wp_get_image_editor(get_attached_file($this->attachmentId));
		if(!($editor instanceof WP_Image_Editor)){
			throw new Exception($editor->get_error_message($editor->get_error_code()));
		}
		
		$editor->resize(125, 90, true);
		$editor->set_quality(100);
		$result = $editor->save($editor->generate_filename());
		return array('file' => $result['file'], 'widht' => $result['width'], 'height' => $result['height']);
	}
	
	/**
	 * add watermark image
	 *
	 * @return void
	 */
	function _addWatermark($imgPath, $wmarkPath){
		$img = $wmark = NULL;
		$imgExt = strtolower($this->_getFileExtenstion($imgPath));
		$wmarkExt = strtolower($this->_getFileExtenstion($wmarkPath));
		if($imgExt == 'png'){
			$img = imagecreatefrompng($imgPath);
		}
		else if($imgExt == 'jpeg' || $imgExt == 'jpg'){
			$img = imagecreatefromjpeg($imgPath);
		}
		else if($imgExt == 'gif'){
			$img = imagecreatefromgif($imgPath);
		}
		
		if($wmarkExt == 'png'){
			$wmark = imagecreatefrompng($wmarkPath);
		}
		else if($wmarkExt == 'jpeg' || $wmarkExt == 'jpg'){
			$wmark = imagecreatefromjpeg($wmarkPath);
		}
		else if($wmarkExt == 'gif'){
			$wmark = imagecreatefromgif($wmarkPath);
		}
		
		$marge_right = 100;
		$marge_bottom = 100;
		$sx = imagesx($wmark);
		$sy = imagesy($wmark);
		
		imagecopy($img, $wmark, imagesx($img) - $sx - $marge_right, imagesy($img) - $sy - $marge_bottom, 0, 0, $sx, $sy);
		
		if($imgExt == 'png'){
			imagepng($img, $imgPath, 100);
		}
		else if($imgExt == 'jpeg' || $imgExt == 'jpg'){
			imagejpeg($img, $imgPath, 100);
		}
		else if($imgExt == 'gif'){
			imagegif($img, $imgPath, 100);
		}
	}
	
	/**
	 * returns file extension
	 *
	 * @return string
	 */
	function _getFileExtenstion($fileName){
		return substr(strrchr($fileName, '.'), 1);
	}
}
<?php

 class RCS_Slider_Widget extends WP_Widget{
	
	
	function RCS_Slider_Widget(){
		$w_options = array(
			'classname' => 'RCS_Slider_Widget',
			'description' => 'Display RC Slider',
			'name' => 'RC Slider'
		);
		$this->WP_Widget('rcs_slider_widget', '', $w_options);
	}
	
	function form($instance){
		extract($instance);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><b>Title</b></label>
			<input type="text" class="widefat" 
			id="<?php echo $this->get_field_id('title'); ?>" 
			name="<?php echo $this->get_field_name('title'); ?>" 
			value="<?php if(isset($title)) echo esc_attr($title); ?>" />
		</p>
		
		<?php
		$slider_id = (isset($slider_id))? $slider_id : 0;
		$loop = new WP_Query(array('post_type' => 'rc_slider', 'post_status' => 'publish'));
		?>
		<p>
			<label for="<?php echo $this->get_field_id('slider_id'); ?>"><b>Slider</b></label>
			<select type="text" class="widefat" id="<?php echo $this->get_field_id('slider_id'); ?>" 
			name="<?php echo $this->get_field_name('slider_id'); ?>">
			<?php
			if($loop->have_posts()){
				while($loop->have_posts()){
					$loop->the_post();
					$title = get_the_title();
					$title = (!empty($title))? $title : '(no title)';
					?>
					<option value="<?php echo get_the_ID() ?>" <?php selected(get_the_ID(), $slider_id) ?>><?php echo $title ?></option>
					<?php
				}
			}
			?>
			</select>
		</p>
		
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('show_header'); ?>" 
			id="<?php echo $this->get_field_id('show_header'); ?>" value="1" <?php checked($show_header, '1'); ?> />
			<label for="<?php echo $this->get_field_id('show_header'); ?>">Show widget header</label>
		</p>
		
		<?php
	}
	
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance){
		extract($args);
		extract($instance);
		
		$title = apply_filters('widget_title', $title);
		
		echo $before_widget;
		
		if($show_header == '1') echo $before_title.$title.$after_title;
		
		rc_silder($slider_id);
		
		echo $after_widget;
	}
 }
 
?>
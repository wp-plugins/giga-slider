<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
	exit();
} else{
	global $wpdb;
	if(get_option('rcs_slider_settings') !== false){
		delete_option('rcs_slider_settings');
	}
}
?>
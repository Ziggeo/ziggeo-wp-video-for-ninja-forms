<?php

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

function ziggeoninjaforms_global() {

	//local assets
	wp_register_style('ziggeoninjaforms-css', ZIGGEONINJAFORMS_ROOT_URL . 'assets/css/styles.css', array());    
	wp_enqueue_style('ziggeoninjaforms-css');

	wp_register_script('ziggeoninjaforms-js', ZIGGEONINJAFORMS_ROOT_URL . 'assets/js/codes.js', array());
	wp_enqueue_script('ziggeoninjaforms-js');
}

//Load the admin scripts (and local)
function ziggeoninjaforms_admin() {

	ziggeoninjaforms_global();

	wp_register_script('ziggeoninjaforms-adminjs', ZIGGEONINJAFORMS_ROOT_URL . 'assets/js/admin-codes.js', array());
	wp_enqueue_script('ziggeoninjaforms-adminjs');
}

add_action('wp_enqueue_scripts', "ziggeoninjaforms_global");
add_action('admin_enqueue_scripts', "ziggeoninjaforms_admin");

?>
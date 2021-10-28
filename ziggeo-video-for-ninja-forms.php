<?php
/*
Plugin Name: Ziggeo Video for Ninja Forms
Plugin URI: https://ziggeo.com/integrations/wordpress
Description: Add award winning Ziggeo video service platform to your Ninja Forms form builder and forms
Author: Ziggeo
Version: 1.5
Author URI: https://ziggeo.com
*/

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


//rooth path
define('ZIGGEONINJAFORMS_ROOT_PATH', plugin_dir_path(__FILE__) );

//Setting up the URL so that we can get/built on it later on from the plugin root
define('ZIGGEONINJAFORMS_ROOT_URL', plugins_url('', __FILE__) . '/');

//plugin version - this way other plugins can get it as well and we will be updating this file for each version change as is
define('ZIGGEONINJAFORMS_VERSION', '1.5');

//Include files
include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'core/run.php');

if(is_admin()) {
	include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'admin/dashboard.php');
	include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'admin/plugins.php');
	include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'admin/validation.php');
}


?>
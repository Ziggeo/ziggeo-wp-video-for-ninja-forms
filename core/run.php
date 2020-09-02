<?php

//
//	This file represents the integration module for Ninja Forms and Ziggeo
//

// Index
//	1. Hooks
//		1.1. ziggeo_list_integration
//		1.2. plugins_loaded
//	2. Functionality
//		2.1. ziggeoninjaforms_get_version()
//		2.2. ziggeoninjaforms_init()
//		2.3. ziggeoninjaforms_run()

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//Show the entry in the integrations panel
add_filter('ziggeo_list_integration', function($integrations) {

	$current = array(
		//This section is related to the plugin that we are combining with the Ziggeo, not the plugin/module that does it
		'integration_title'		=> 'Ninja Forms', //Name of the plugin
		'integration_origin'	=> 'https://ninjaforms.com', //Where you can download it from

		//This section is related to the plugin or module that is making the connection between Ziggeo and the other plugin.
		'title'					=> 'Ziggeo Video for Ninja Forms', //the name of the module
		'author'				=> 'Ziggeo', //the name of the author
		'author_url'			=> 'https://ziggeo.com/', //URL for author website
		'message'				=> 'Add video to form builder and your forms', //Any sort of message to show to customers
		'status'				=> true, //Is it turned on or off?
		'slug'					=> 'ziggeo-video-for-ninja-forms', //slug of the module
		//URL to image (not path). Can be of the original plugin, or the bridge
		'logo'					=> ZIGGEONINJAFORMS_ROOT_URL . 'assets/images/logo.png',
		'version'				=> ZIGGEONINJAFORMS_VERSION
	);

	//Check current Ziggeo version
	if(ziggeoninjaforms_run() === true) {
		$current['status'] = true;
	}
	else {
		$current['status'] = false;
	}

	$integrations[] = $current;

	return $integrations;
});

//add_action('plugins_loaded', function() {
add_action('plugins_loaded', function() {
	ziggeoninjaforms_run();
}, 8);

//Checks if the WPForms exists and returns the version of it
function ziggeoninjaforms_get_version() {

	if(!class_exists('Ninja_Forms')) {
		return 0;
	}

	return Ninja_Forms::VERSION;
}

//Include all of the needed plugin files
function ziggeoninjaforms_include_plugin_files() {

	//Include the files only if we are running this plugin

	include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'core/simplifiers.php');
	include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'core/assets.php');
	include_once(ZIGGEONINJAFORMS_ROOT_PATH . 'core/ajax.php');

	//Fields specific
	require_once(ZIGGEONINJAFORMS_ROOT_PATH . 'extend/class-video-recorder.php');
	require_once(ZIGGEONINJAFORMS_ROOT_PATH . 'extend/class-video-player.php');
	require_once(ZIGGEONINJAFORMS_ROOT_PATH . 'extend/class-ziggeo-template.php');


	//Check if there is VideoWalls plugin present or not and include additional field(s) if so
	if(defined('VIDEOWALLSZ_VERSION')) {
		require_once(ZIGGEONINJAFORMS_ROOT_PATH . 'extend/class-videowall.php');
	}
}

//We add all of the hooks we need
function ziggeoninjaforms_init() {

	//Lets include all of the files we need
	ziggeoninjaforms_include_plugin_files();

	//Adding Ziggeo Fields section in the builder
	add_filter( 'ninja_forms_field_type_sections', function($sections) {

		$tmp = array(
			'ziggeo' => array(
				'id'			=> 'ziggeo_fields',
				'nicename'		=> 'Ziggeo Fields',
				'fieldTypes'	=> array()
			)
		);

		$sections = array_slice($sections, 0, 4, true) + $tmp + array_slice($sections, 4, count($sections)-1, true);

		return $sections;
	}, 8);

	//Add the field
	add_filter( 'ninja_forms_register_fields', function ($fields) {
		$fields['ziggeo-video-player'] = new Ninja_Forms_Field_Video_Player();
		$fields['ziggeo-video-recorder'] = new Ninja_Forms_Field_Video_Recorder();
		$fields['ziggeo-template'] = new Ninja_Forms_Field_Ziggeo_Templates();

		if(defined('VIDEOWALLSZ_VERSION')) {
			$fields['videowall'] = new Ninja_Forms_Field_Videowall();
		}

		return $fields;
	});

	//Works on front end when it loads the template
	add_filter( 'ninja_forms_field_template_file_paths', function($paths) {

		//Let us set the path to our templates
		$paths[] = ZIGGEONINJAFORMS_ROOT_PATH . 'templates/';

		return $paths;
	});

}


//Function that we use to run the module 
function ziggeoninjaforms_run() {

	//Needed during activation of the plugin
	if(!function_exists('ziggeo_get_version')) {
		add_action( 'admin_notices', function() {
			?>
			<div class="error notice">
				<p><?php _e( 'Please install <a href="https://wordpress.org/plugins/ziggeo/">Ziggeo plugin</a>. It is required for this plugin (Ziggeo Video for Ninja Forms) to work properly!', 'ziggeoninjaforms' ); ?></p>
			</div>
			<?php
		});

		return false;
	}

	//Check current Ziggeo version
	if( version_compare(ziggeo_get_version(), '2.0') >= 0 &&
		//check the WPForms version
		version_compare(ziggeoninjaforms_get_version(), '3.4.23') >= 0) {

		if(ziggeo_integration_is_enabled('ziggeo-video-for-ninja-forms')) {
			ziggeoninjaforms_init();
			return true;
		}
	}

	return false;
}


?>
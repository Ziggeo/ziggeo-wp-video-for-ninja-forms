<?php

//Helps us with the options that we offer with Ninja Forms

// Index
//	1. Hooks
//		1.1. admin_init
//		1.2. admin_menu
//	2. Fields and sections
//		2.1. ziggeoninjaforms_show_form()
//		2.2. ziggeoninjaforms_d_hooks()
//		2.3. ziggeoninjaforms_o_forum_content()
//		2.4. ziggeoninjaforms_o_topic_content()
//		2.5. ziggeoninjaforms_o_reply_content()

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();



/////////////////////////////////////////////////
//	1. HOOKS
/////////////////////////////////////////////////

	//Add plugin options
	add_action('admin_init', function() {
		//Register settings
		register_setting('ziggeoninjaforms', 'ziggeoninjaforms', 'ziggeoninjaforms_validate');

		//Active hooks
		add_settings_section('ziggeoninjaforms_section_hooks', '', 'ziggeoninjaforms_d_hooks', 'ziggeoninjaforms');


			// The type of data that is captured once the video is recorded
			add_settings_field('ziggeoninjaforms_captured_content',
								__('Choose the data that is saved once video is recorded', 'ziggeoninjaforms'),
								'ziggeoninjaforms_g_captured_content',
								'ziggeoninjaforms',
								'ziggeoninjaforms_section_hooks');

	});

	add_action('admin_menu', function() {
		add_submenu_page(
			'ziggeo_video',						//parent slug
			'Ziggeo Video for Ninja Forms',		//page title
			'Ziggeo Video for Ninja Forms',		//menu title
			'manage_options',					//min capability to view
			'ziggeoninjaforms',					//menu slug
			'ziggeoninjaforms_show_form'		//function
		);
	});




/////////////////////////////////////////////////
//	2. FIELDS AND SECTIONS
/////////////////////////////////////////////////

	//Dashboard form
	function ziggeoninjaforms_show_form() {
		?>
		<div>
			<h2>Ziggeo Video for Ninja Forms</h2>

			<form action="options.php" method="post" class="ziggeoninjaforms_form">
				<?php
				wp_nonce_field('ziggeoninjaforms_nonce_action', 'ziggeoninjaforms_video_nonce');
				get_settings_errors();
				settings_fields('ziggeoninjaforms');
				do_settings_sections('ziggeoninjaforms');
				submit_button('Save Changes');
				?>
			</form>
		</div>
		<?php
	}

		function ziggeoninjaforms_d_hooks() {
			?>
			<h3><?php _e('Settings', 'ziggeoninjaforms'); ?></h3>
			<?php
			_e('Use settings bellow to fine tune how some settings specific for Ziggeo within Ninja Forms should be set.', 'ziggeoninjaforms');
		}

			function ziggeoninjaforms_g_captured_content() {
				$option = ziggeoninjaforms_get_plugin_options('capture_content');
				?>
				<select id="ziggeoninjaforms_capture_content" name="ziggeoninjaforms[capture_content]">
					<option value="embed_wp" <?php ziggeo_echo_selected($option, 'embed_wp'); ?>>WP Embed code</option>
					<option value="embed_html" <?php ziggeo_echo_selected($option, 'embed_html'); ?>>HTML Embed code</option>
					<option value="video_url" <?php ziggeo_echo_selected($option, 'video_url'); ?>>Video URL</option>
					<option value="video_token" <?php ziggeo_echo_selected($option, 'video_token'); ?>>Video Token</option>
				</select>
				<label for="ziggeoninjaforms_capture_content"><?php _e('Depending on your choice here you will change what is captured once the video is recorded'); ?></label>
				<?php
			}

?>
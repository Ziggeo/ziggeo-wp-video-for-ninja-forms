<?php

// Video player class

class Ninja_Forms_Field_Video_Player extends NF_Abstracts_Field {
	protected $_name = 'ziggeo-video-player';
	protected $_section = 'ziggeo_fields'; // section in backend
	protected $_type = 'ziggeoplayer'; // field type
	protected $_templates = array( 'video-player' );
	protected $_icon = 'play'; //fa-play

	public function __construct() {
		parent::__construct();

		$this->_nicename = __( 'Video Player', 'ziggeo' );

		// The primary settings
		/////////////////////////

		//Get the default settings
		$__settings = $this->load_settings( array(
			'label',
			'label_pos',
			'required',
			'classes',
			'admin_label',
			'help',
			'description',
		));

		//Video token
		$__settings['videotoken'] = array(
			'name'			=> 'videotoken',
			'type'			=> 'textbox',
			'group'			=> 'primary',
			'label'			=> 'Video Token',
			'placeholder'	=> 'Add your video token here',
			'value'			=> '',
			'help'			=> 'You can find video token in your Ziggeo dashboard > Application > Videos',
			'width'			=> 'full'
		);

		// Style / Display
		////////////////////

		//Player theme
		$__settings['player_theme'] = array(
			'name'			=> 'player_theme',
			'type'			=> 'select',
				'options'	=>  array(
					array('label' => 'Modern',		'value' => 'modern'),
					array('label' => 'Cube',		'value' => 'cube'),
					array('label' => 'Theatre',		'value' => 'theatre'),
					array('label' => 'Space',		'value' => 'space'),
					array('label' => 'Minimalist',	'value' => 'minimalist'),
					array('label' => 'Elevate',		'value' => 'elevate')
				),
			'group'			=> 'display',
			'label'			=> 'Select Video Player Theme',
			'help'			=> 'Select one of the pre-defined Video Player themes',
			'width'			=> 'full'
		);

		//Player theme color
		$__settings['themecolor'] = array(
			'name'			=> 'themecolor',
			'type'			=> 'select',
				'options'	=>  array(
					array('label' => 'Blue',		'value' => 'blue'),
					array('label' => 'Green',		'value' => 'green'),
					array('label' => 'Red',			'value' => 'red')
				),
			'group'			=> 'display',
			'label'			=> 'Select Video Player Theme Color',
			'help'			=> 'Select one of the pre-defined theme colors',
			'width'			=> 'full'
		);

		//Player width
		$__settings['width'] = array(
			'name'			=> 'width',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Select Video Player Width',
			'width'			=> 'full',
			'value'			=> '100%',
			'help'			=> 'Number with % sign for percentages (100%) and just number for pixel value (100)'
		);

		//Player height
		$__settings['height'] = array(
			'name'			=> 'height',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Select Video Player Width',
			'width'			=> 'full',
			'value'			=> '',
			'help'			=> 'Number with % sign for percentages (100%) and just number for pixel value (100)'
		);

		//Player popup
		$__settings['popup'] = array(
			'name'			=> 'popup',
			'type'			=> 'toggle',
			'group'			=> 'display',
			'label'			=> 'Turn on to use popup flavor of the video player',
			'value'			=> 0,
			'width'			=> 'full'
		);

		//Player popup width
		$__settings['popup_width'] = array(
			'name'			=> 'popup_width',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Width of the video player popup',
			'value'			=> '640',
			'width'			=> 'full'
		);

		//Player popup height
		$__settings['popup_height'] = array(
			'name'			=> 'popup_height',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Height of the video player popup',
			'value'			=> '480',
			'width'			=> 'full'
		);

		// Advanced
		/////////////

		//Player effect profile to load
		$__settings['effect_profiles'] = array(
			'name'			=> 'effect_profiles',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Effect profile key or token',
			'value'			=> '',
			'width'			=> 'full'
		);

		//Player video profile to load
		$__settings['video_profile'] = array(
			'name'			=> 'video_profile',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Video profile key or token',
			'value'			=> '',
			'width'			=> 'full'
		);

		// Client auth to use
		$__settings['client_auth'] = array(
			'name'			=> 'client_auth',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Client auth token',
			'value'			=> '',
			'width'			=> 'full'
		);

		// Server auth to use
		$__settings['server_auth'] = array(
			'name'			=> 'server_auth',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Server auth token',
			'value'			=> '',
			'width'			=> 'full'
		);

		$this->_settings = apply_filters('ziggeoninjaforms_video_player_settings', $__settings);

	}

		public function filter_default_value( $default_value, $field_class, $settings ) {
			return '';
		}

		//Fires when editing the form submission
		public function admin_form_element($id, $value) {

			//Let's get the form we are on
			$form_id = get_post_meta( absint( $_GET[ 'post' ] ), '_form_id', true );

			//Now let's get our field
			$field = Ninja_Forms()->form( $form_id )->get_field( $id );

			//Now we get the settings of our field
			$settings = $field->get_settings();

			//Allowing others to make changes through code
			$options = array();
			$options = apply_filters( 'ninja_forms_render_options', $options, $settings );
			$options = apply_filters( 'ninja_forms_render_options_' . $this->_type, $options, $settings );

			$output = '<input type="hidden" name="fields[' . absint( $id ) . ']" name="fields[' . absint( $id ) . ']" value="">';

			$output .= '<ziggeoplayer class="widefat" ' . ziggeoninjaforms_get_player_code($settings) . '></ziggeoplayer>';

			if($value === '') {
				$output .= '<div class="ziggeoninjaforms_submitted_info dashicons dashicons-hidden"></div>';
			}
			else {
				$output .= '<div class="ziggeoninjaforms_submitted_info dashicons dashicons-visibility"></div>';
			}

			return $output;

		}

		//public function process($action_settings, $form_id, $data) {
		public function process($field, $data) { //NF_Abstracts_Field
			return $data;
		}
}
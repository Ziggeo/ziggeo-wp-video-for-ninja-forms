<?php

// Video recorder class

class Ninja_Forms_Field_Video_Recorder extends NF_Abstracts_Field {
	protected $_name = 'ziggeo-video-recorder';
	protected $_section = 'ziggeo_fields'; // section in backend
	protected $_type = 'ziggeorecorder'; // field type
	protected $_templates = array( 'video-recorder' );
	protected $_icon = 'video-camera'; //fa-video-camera

	public function __construct() {
		parent::__construct();

		$this->_nicename = __( 'Video Recorder', 'ziggeo' );

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


		// Style / Display
		////////////////////

		//Recorder theme
		$__settings['recorder_theme'] = array(
			'name'			=> 'recorder_theme',
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
			'label'			=> 'Select Video Recorder Theme',
			'help'			=> 'Select one of the pre-defined Video Recorder themes',
			'width'			=> 'full'
		);

		//Recorder theme color
		$__settings['themecolor'] = array(
			'name'			=> 'themecolor',
			'type'			=> 'select',
				'options'	=>  array(
					array('label' => 'Blue',		'value' => 'blue'),
					array('label' => 'Green',		'value' => 'green'),
					array('label' => 'Red',			'value' => 'red')
				),
			'group'			=> 'display',
			'label'			=> 'Select Video Recorder Theme Color',
			'help'			=> 'Select one of the pre-defined theme colors',
			'width'			=> 'full'
		);

		//Recorder width
		$__settings['width'] = array(
			'name'			=> 'width',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Select Video Recorder Width',
			'width'			=> 'full',
			'value'			=> '100%',
			'help'			=> 'Number with % sign for percentages (100%) and just number for pixel value (100)'
		);

		//Recorder height
		$__settings['height'] = array(
			'name'			=> 'height',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Select Video Recorder Width',
			'width'			=> 'full',
			'value'			=> '',
			'help'			=> 'Number with % sign for percentages (100%) and just number for pixel value (100)'
		);

		//Recorder popup
		$__settings['popup'] = array(
			'name'			=> 'popup',
			'type'			=> 'toggle',
			'group'			=> 'display',
			'label'			=> 'Turn on to use popup flavor of the video recorder',
			'value'			=> 0,
			'width'			=> 'full'
		);

		//Recorder popup width
		$__settings['popup_width'] = array(
			'name'			=> 'popup_width',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Width of the video recorder popup',
			'value'			=> '640',
			'width'			=> 'full'
		);

		//Recorder popup height
		$__settings['popup_height'] = array(
			'name'			=> 'popup_height',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Height of the video recorder popup',
			'value'			=> '480',
			'width'			=> 'full'
		);


		$__settings['faceoutline'] = array(
			'name'			=> 'faceoutline',
			'type'			=> 'toggle',
			'group'			=> 'display',
			'label'			=> 'Use faceoutline during recording?',
			'value'			=> 0,
			'width'			=> 'full'
		);

		// Advanced
		/////////////


		// Video Title to set
		$__settings['video_title'] = array(
			'name'			=> 'video_title',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Video Title',
			'value'			=> '',
			'width'			=> 'full'
		);

		// Video Description to set
		$__settings['video_description'] = array(
			'name'			=> 'video_description',
			'type'			=> 'textarea',
			'group'			=> 'advanced',
			'label'			=> 'Video Description',
			'value'			=> '',
			'width'			=> 'full'
		);

		// Video Tags
		$__settings['video_tags'] = array(
			'name'			=> 'video_tags',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Video Tags',
			'value'			=> '',
			'width'			=> 'full'
		);

		// Video custom data
		$__settings['custom_data'] = array(
			'name'			=> 'custom_data',
			'type'			=> 'textarea',
			'group'			=> 'advanced',
			'label'			=> 'Custom data',
			'value'			=> '',
			'width'			=> 'full',
			'help'			=> 'Custom (JSON format only) data'
		);

		//Recording width
		$__settings['recording_width'] = array(
			'name'			=> 'recording_width',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Select Video Recording Width',
			'width'			=> 'full',
			'value'			=> '640',
			'help'			=> 'Integer number used as pixel value'
		);

		//Recording height
		$__settings['recording_height'] = array(
			'name'			=> 'recording_height',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Select Video Recording Width',
			'width'			=> 'full',
			'value'			=> '640',
			'help'			=> 'Integer number used as pixel value'
		);

		//Recording time (max)
		$__settings['recording_time_max'] = array(
			'name'			=> 'recording_time_max',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Max time of recording',
			'width'			=> 'full',
			'value'			=> '',
			'help'			=> '0 for indefinite (or leave empty), round number of seconds otherwise'
		);

		//Recording time (min)
		$__settings['recording_time_min'] = array(
			'name'			=> 'recording_time_min',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Min time of recording',
			'width'			=> 'full',
			'value'			=> '',
			'help'			=> '0 for indefinite (or leave empty), round number of seconds otherwise'
		);

		//Recording time (min)
		$__settings['recording_countdown'] = array(
			'name'			=> 'recording_countdown',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Seconds before recording starts',
			'width'			=> 'full',
			'value'			=> ''
		);

		//Number of recordings allowed
		$__settings['recording_amount'] = array(
			'name'			=> 'recording_amount',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Seconds before recording starts',
			'width'			=> 'full',
			'value'			=> '',
			'help'			=> 'Leave empty or 0 for unlimited otherwise you can limit re-recording number (number includes recording)'
		);

		//Recorder effect profile to load
		$__settings['effect_profiles'] = array(
			'name'			=> 'effect_profiles',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Effect profile key or token',
			'value'			=> '',
			'width'			=> 'full'
		);

		//Recorder video profile to load
		$__settings['video_profile'] = array(
			'name'			=> 'video_profile',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Video profile key or token',
			'value'			=> '',
			'width'			=> 'full'
		);

		//Recorder meta profile to load
		$__settings['meta_profile'] = array(
			'name'			=> 'meta_profile',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Meta profile key or token',
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

		// Custom tags
		$__settings['nf_custom_tags'] = array(
			'name'			=> 'nf_custom_tags',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Custom Tags',
			'value'			=> '',
			'width'			=> 'full'
		);

		// Dynamic Custom data 
		$__settings['nf_custom_data'] = array(
			'name'			=> 'nf_custom_data',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Dynamic Custom Data',
			'value'			=> '',
			'width'			=> 'full',
			'help'          => 'Add custom data based on the example in plugin\'s readme/info. It should be provided as "key": field_ID. Multiple fields are separated by comma'
		);

		$this->_settings = apply_filters('ziggeoninjaforms_video_recorder_settings', $__settings);

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

			//This is in place to allow people to get the code as it is submitted.
			if(strlen($value) === 32) {
				$output .= '<ziggeoplayer class="widefat" ' . ziggeoninjaforms_get_recorder_code($settings) . ' ziggeo-video="' . $value . '"></ziggeoplayer>';
			}
			else {
				$output .= $value;
			}

			return $output;

		}

		//public function process($action_settings, $form_id, $data) {
		public function process($field, $data) { //NF_Abstracts_Field
			return $data;
		}
}

?>
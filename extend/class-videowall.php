<?php

// VideoWalls field

class Ninja_Forms_Field_Videowall extends NF_Abstracts_Field {
	protected $_name = 'videowall';
	protected $_section = 'ziggeo_fields'; // section in backend
	protected $_type = 'ziggeovideowall'; // field type
	protected $_templates = array( 'videowall' );
	protected $_icon = 'caret-square-o-right'; //fa-caret-square-o-right

	public function __construct() {
		parent::__construct();

		$this->_nicename = __( 'Video Wall', 'ziggeo' );

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

		// Design
		///////////

		$__settings['title'] = array(
			'name'			=> 'title',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'VideoWall title',
			'help'			=> 'Title of a videowall',
			'width'			=> 'full',
			'value'			=> ''
		);

		$__settings['design'] = array(
			'name'			=> 'design',
			'type'			=> 'select',
				'options'	=>  array(
					array('label' => 'Default',				'value' => 'default'),
					array('label' => 'Show Pages',			'value' => 'show_pages'),
					array('label' => 'Mosaic Grid',			'value' => 'mosaic_grid'),
					array('label' => 'Chessboard Grid',		'value' => 'chessboard_grid'),
					array('label' => 'Videosite Playlist',	'value' => 'videosite_playlist')
				),
			'group'			=> 'display',
			'label'			=> 'VideoWall Design',
			'help'			=> 'Choose one of the pre-defined templates',
			'width'			=> 'full'
		);

		$__settings['videowidth'] = array(
			'name'			=> 'videowidth',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'VideoWall videos width',
			'help'			=> 'This is the width that is passed to the videos within the video wall',
			'width'			=> 'full',
			'value'			=> ''
		);

		$__settings['videoheight'] = array(
			'name'			=> 'videoheight',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'VideoWall videos height',
			'help'			=> 'This is the height that is passed to the videos within the video wall',
			'width'			=> 'full',
			'value'			=> ''
		);

		$__settings['videos_per_page'] = array(
			'name'			=> 'videos_per_page',
			'type'			=> 'textbox',
			'group'			=> 'display',
			'label'			=> 'Number of videos per page',
			'help'			=> 'Each design has defaults and some might ignore this.',
			'width'			=> 'full',
			'value'			=> ''
		);

		// Advanced
		/////////////

		$__settings['autoplay'] = array(
			'name'			=> 'autoplay',
			'type'			=> 'toggle',
			'group'			=> 'advanced',
			'label'			=> 'Autoplay videos in videowall',
			'value'			=> 0,
			'width'			=> 'full',
			'help'			=> 'Browsers tend to block autoplay or disable audio, so you should expect that to happen. If it works fine with autoplay == great - we did everything we could about it.'
		);

		$__settings['show'] = array(
			'name'			=> 'show',
			'type'			=> 'toggle',
			'group'			=> 'advanced',
			'label'			=> 'Show video on page load',
			'value'			=> 0,
			'width'			=> 'full',
			'help'			=> 'By default the video wall is hidden until you record some video (in comments). Turn this on to show right away.'
		);

		$__settings['no_videos'] = array(
			'name'			=> 'no_videos',
			'type'			=> 'select',
				'options'	=>  array(
					array('label' => 'ShowMessage',			'value' => 'ShowMessage'),
					array('label' => 'ShowTemplate',		'value' => 'ShowTemplate'),
					array('label' => 'HideWall',			'value' => 'HideWall')
				),
			'group'			=> 'advanced',
			'label'			=> 'What do do it no videos are found?',
			'value'			=> 0,
			'width'			=> 'full',
			'help'			=> 'Helps to decide what should happen if your video has 0 videos found'
		);

		$__settings['message'] = array(
			'name'			=> 'message',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'What message should be shown?',
			'help'			=> 'The message to shown when no videos are found',
			'width'			=> 'full',
			'value'			=> ''
		);

		$__settings['template_name'] = array(
			'name'			=> 'template_name',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'What template should be shown?',
			'help'			=> 'Set the template name to be used when no videos are found',
			'width'			=> 'full',
			'value'			=> ''
		);

		$__settings['show_videos'] = array(
			'name'			=> 'show_videos',
			'type'			=> 'select',
				'options'	=> array(
					array('label' => 'All',			'value' => 'all'),
					array('label' => 'Approved',	'value' => 'approved'),
					array('label' => 'Rejected',	'value' => 'rejected'),
					array('label' => 'Pending',		'value' => 'pending')
				),
			'group'			=> 'advanced',
			'label'			=> 'Type of videos to show',
			'help'			=> 'This is based on the moderation status of the video',
			'width'			=> 'full',
			'value'			=> ''
		);

		$__settings['videos_to_show'] = array(
			'name'			=> 'videos_to_show',
			'type'			=> 'textbox',
			'group'			=> 'advanced',
			'label'			=> 'Videos to show',
			'help'			=> 'Utilizes the video tags to show the videos. You can use POST ID or other video tag.',
			'width'			=> 'full',
			'value'			=> ''
		);

		$this->_settings = apply_filters('ziggeoninjaforms_videowall_settings', $__settings);

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

			$output = '<input type="text" name="fields[' . absint( $id ) . ']" name="fields[' . absint( $id ) . ']" value="' . $value . '">';

			return $output;

		}

		//public function process($action_settings, $form_id, $data) {
		public function process($field, $data) { //NF_Abstracts_Field
			return $data;
		}
}
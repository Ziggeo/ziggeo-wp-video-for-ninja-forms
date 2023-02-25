<?php

// Templates field

class Ninja_Forms_Field_Ziggeo_Templates extends NF_Abstracts_Field {

	protected $_name = 'ziggeo-template';
	protected $_section = 'ziggeo_fields'; // section in backend
	protected $_type = 'ziggeotemplates'; // field type
	protected $_templates = array( 'ziggeo-template' );
	protected $_icon = 'code'; //fa-code

	public function __construct() {
		parent::__construct();

		$this->_nicename = __( 'Ziggeo Templates', 'ziggeo' );

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

		//Show the templates
		$list = ziggeo_p_templates_index();
		$templates = array();
		if($list) {
			foreach($list as $template_id => $template_code)
			{
				if($template_id !== '') {
					$templates[] = array('label' => $template_id, 'value' => $template_id);
				}
			}
		}

		if(count($templates) == 0) {
			$templates[] = 'No Templates Found';
		}

		$__settings['template_name'] = array(
			'name'			=> 'template_name',
			'type'			=> 'select',
				'options'	=>  $templates,
			'group'			=> 'primary',
			'label'			=> 'Template Name',
			'help'			=> 'By selecting the template name, this template will then be used on your form',
			'width'			=> 'full'
		);

		$this->_settings = apply_filters('ziggeoninjaforms_ziggeo_template_settings', $__settings);

		// lazyload support, we only add it if this is a frontend request using GET, otherwise we do nothing
		if($_SERVER['REQUEST_METHOD'] === 'GET') {
			// We must add it for delayed output since otherwise it will print it before any other content
			add_action('wp_head', "ziggeoninjaforms_lazyload_support");
		}
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

?>
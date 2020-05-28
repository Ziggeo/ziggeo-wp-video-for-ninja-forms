<?php


add_filter('ziggeo_ajax_call_client', function($rez, $operation) {
	if($operation === 'ziggeoninjaforms_get_template_code') {
		if(isset($_POST['template'])) {
			$rez = ziggeo_p_template_exists($_POST['template']);

			if($rez) {
				$rez = ziggeo_p_content_filter($rez);
			}
		}
	}

	return $rez;
}, 10, 2);

add_filter('ziggeo_ajax_call', function($rez, $operation) {
	if($operation === 'ziggeoninjaforms_get_template_code') {
		if(isset($_POST['template'])) {
			$rez = ziggeo_p_template_exists($_POST['template']);

			if($rez) {
				$rez = ziggeo_p_content_filter($rez);
			}
		}
	}

	return $rez;
}, 10, 2);

?>
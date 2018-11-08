<?php
require_once get_template_directory() . '/includes/options-config.php';
require_once get_template_directory() . '/admin/control-icon-picker.php';

	if( ! class_exists('Tech_Literacy_Customizer_API_Wrapper') ) {
			require_once get_template_directory() . '/admin/class.tech-literacy-customizer-api-wrapper.php';
	}


Tech_Literacy_Customizer_API_Wrapper::getInstance($options);

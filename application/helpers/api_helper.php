<?php
defined('BASEPATH') or exit('no direct scripts are allowed');


if (!function_exists('get_body_json')){
	function get_body_json()
	{
    	return json_decode(file_get_contents('php://input'), true);
	}
}


if (!function_exists('response_json')) {
	function response_json($data, $status_code = 200)
	{
		$ci =& get_instance();
		$ci->output->set_content_type('application/json');
		$ci->output->set_status_header($status_code);
		
		$ci->output->set_output(json_encode($data));
	}
}


if(!function_exists('response_api')) {
	function response_api($meta_status_code = 200, $meta_message = '', $data = '')
	{
		$ci =& get_instance();
		$ci->output->set_content_type('application/json');
		$ci->output->set_status_header(200);
		
		$response_api = [
			'response' => $data,
			'metadata' => [
				'status' => $meta_status_code,
				'message' => $meta_message
			]
		];
		
		$ci->output->set_output(json_encode($response_api));
	}
}
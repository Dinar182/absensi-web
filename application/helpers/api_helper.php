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
if(!function_exists('security_ini')) {
	function security_ini()
	{
		return [
			'encryption_key' => 4987632563987124,
			'iv' => 4532879263570159,
			'encryption_mechanism' => 'aes-256-cbc'
		];
	}
}

if(!function_exists('token_encrypt')) {
	function token_encrypt($string)
	{
		$output = false;
	
		$security = security_ini();
		# Hasil parsing masukkan kedalam variable
		$secret_key     = $security['encryption_key'];
		$secret_iv      = $security['iv'];
		$encrypt_method = $security['encryption_mechanism'];
	
		# hash $secret_key dengan algoritma sha256 
		$key = hash("sha256", $secret_key);
	
		# iv(initialize vector), encrypt iv dengan encrypt method AES-256-CBC (16 bytes)
		$iv     = substr(hash("sha256", $secret_iv), 0, 16);
		$result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($result);
		return $output;
	}
}

if(!function_exists('token_decrypt')) {
	function token_decrypt($string)
	{
		$output = false;
	
		$security = $security = security_ini();
		# Hasil parsing masukkan kedalam variable
		$secret_key     = $security['encryption_key'];
		$secret_iv      = $security['iv'];
		$encrypt_method = $security['encryption_mechanism'];
	
		# hash $secret_key dengan algoritma sha256 
		$key = hash("sha256", $secret_key);
	
		# iv(initialize vector), encrypt $secret_iv dengan encrypt method AES-256-CBC (16 bytes)
		$iv     = substr(hash("sha256", $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		return $output;
	}
}

if(!function_exists('generate_jwt')) {
	function generate_jwt($headers, $payload, $secret = 'secret') {
		$headers_encoded = base64url_encode(json_encode($headers));
		
		$payload_encoded = base64url_encode(json_encode($payload));
		
		$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
		$signature_encoded = base64url_encode($signature);
		
		$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
		
		return $jwt;
	}
}

if(!function_exists('is_jwt_valid')) {
	function is_jwt_valid($jwt, $secret = 'secret') {
		$tokenParts = explode('.', $jwt);
		$header = base64_decode($tokenParts[0]);
		$payload = base64_decode($tokenParts[1]);
		$signature_provided = $tokenParts[2];

		$expiration = json_decode($payload)->exp;
		$is_token_expired = ($expiration - time()) < 0;

		$base64_url_header = base64url_encode($header);
		$base64_url_payload = base64url_encode($payload);
		$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
		$base64_url_signature = base64url_encode($signature);
		
		$is_signature_valid = ($base64_url_signature === $signature_provided);
		
		if ($is_token_expired || !$is_signature_valid) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

if(!function_exists('base64url_encode')) {
	function base64url_encode($str) {
		return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
	}
}
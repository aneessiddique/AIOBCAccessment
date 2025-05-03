<?php
function authorize_request()
{
    $CI =& get_instance();
    $headers = $CI->input->request_headers();
    if (!isset($headers['Authorization'])) {
		api_error('Authorization header missing', 401);
	}
    $token = str_replace('Bearer ', '', $headers['Authorization']);
	if ($token != 'AIOBIC_ASSESSMENT_TOKEN') {
		api_error('Invalid or expired token', 401);
    }
}

function api_error($message = 'An error occurred', $code = 400)
{
    $response = [
        'status' => false,
        'message' => $message
    ];
    header("Content-Type: application/json");
    http_response_code($code);
    echo json_encode($response);
    die(); 
}

function api_response($data = [], $code = 200)
{
    $response = [
        'status' => true,
        'data' => $data
    ];
    header("Content-Type: application/json");
    http_response_code($code);
    echo json_encode($response);
    die();
}

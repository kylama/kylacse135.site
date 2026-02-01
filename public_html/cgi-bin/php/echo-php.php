<?php
header("Content-Type: application/json");

$response = [
    "hostname" => gethostname(),
    "datetime" => date('Y-m-d H:i:s'),
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "IP_address" => $_SERVER['REMOTE_ADDR'],
    "method" => $_SERVER['REQUEST_METHOD'],
    "query_params" => $_GET,
];

$rawInput = file_get_contents('php://input');
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if (str_contains($contentType, 'application/json')) {
    $response['payload'] = json_decode($rawInput, true);
} else {
    parse_str($rawInput, $parsed);
    $response['payload'] = !empty($parsed) ? $parsed : $_POST;
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
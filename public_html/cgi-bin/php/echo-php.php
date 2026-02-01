<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = file_get_contents('php://input');

$response = [
    "method" => $method,
    "hostname" => gethostname(),
    "datetime" => date('Y-m-d H:i:s'),
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "IP" => $_SERVER['REMOTE_ADDR'],
    "payload" => $input
];

echo json_encode($response);
?>
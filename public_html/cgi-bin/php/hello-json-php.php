<?php
header("Content-Type: application/json");
$data = [
    "title" => "PHP Hello HTML",
    "heading" => "Hello HTML World",
    "message" => "This page was generated with the PHP programming language"
    "time" => date('Y-m-d H:i:s'),
    "IP" => $_SERVER['REMOTE_ADDR']
];
echo json_encode($data);
?>
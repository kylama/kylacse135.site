<?php
header("Content-Type: application/json");
$data = [
    "title" => "PHP Hello JSON",
    "heading" => "Hello, PHP!",
    "message" => "This page was generated with the PHP programming language",
    "time" => date('Y-m-d H:i:s'),
    "IP" => $_SERVER['REMOTE_ADDR']
];
echo json_encode($data);
?>
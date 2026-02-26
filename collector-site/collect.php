<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $host = 'localhost';
    $db = 'analytics_db';
    $user = 'kyla';
    $pass = '$DSrZ&Fj4Tu&g@';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        $sessionId = $data['sessionId'];
        $type = $data['type'];
        $payload = json_encode($data['data']);

        if ($type === 'initial') {
            $stmt = $pdo->prepare("INSERT INTO initial_data (session_id, payload) VALUES (?, ?)");
            $stmt->execute([$sessionId, $payload]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO activity_data (session_id, activity_type, payload) VALUES (?, ?, ?)");
            $stmt->execute([$sessionId, $type, $payload]);
        }

        echo json_encode(["status" => "success"]);
    } catch (PDOException $e) {
        error_log("Database Error: ", $e->getMessage());
    }
}
?>
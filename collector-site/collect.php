<?php
$allowed_origin = 'https://test.kylacse135.site'; 
$request_origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if ($request_origin === $allowed_origin) {
    header("Access-Control-Allow-Origin: $request_origin");
}

header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$raw_input = file_get_contents('php://input');

if (empty($raw_input)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Empty payload']);
    exit;
}

$data = json_decode($raw_input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

$type = $data['type'] ?? 'unknown';
$session_id = $data['session_id'] ?? 'none';
$payload = $raw_input; 

$config = require __DIR__ . '/config.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $config['username'], $config['password'], $options);

    $sql = "INSERT INTO activity_data (type, session_id, payload) 
            VALUES (:type, :session_id, :payload)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':type'       => $type,
        ':session_id' => $session_id,
        ':payload'    => $payload
    ]);

    echo json_encode(['status' => 'success']);

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Internal server error']);
}
<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';
$segments = explode('/', trim($path, '/'));

$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;

$valid_resources = ['static', 'performance', 'activity'];
if (!in_array($resource, $valid_resources)) {
    http_response_code(404);
    echo json_encode(["error" => "Invalid resource: Choose static, performance, or activity"]);
    exit;
}

$config = require __DIR__ . '/config.php';
try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM analytics_log WHERE id = ? AND type = ?");
                $stmt->execute([$id, $resource]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $stmt = $pdo->prepare("SELECT * FROM analytics_log WHERE type = ?");
                $stmt->execute([$resource]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode($result ?: ["message" => "No records found"]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(["error" => "ID required for DELETE"]);
            } else {
                $stmt = $pdo->prepare("DELETE FROM analytics_log WHERE id = ? AND type = ?");
                $stmt->execute([$id, $resource]);
                echo json_encode(["status" => "deleted", "id" => $id]);
            }
            break;

        case 'POST':
            if ($id){
                http_response_code(400);
                echo json_encode(["error" => "ID should not be included in a POST request"]);
                break;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                http_response_code(400);
                echo json_encode(["error" => "Invalid JSON input"]);
                break;
            }

            $session_id = $input['session_id'] ?? 'unknown';
            $payload = json_encode($input['payload'] ?? $input);

            $sql = "INSERT INTO analytics_log (type, session_id, payload) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$resource, $session_id, $payload]);

            http_response_code(201);
            echo json_encode(["status" => "created", "id" => $pdo->lastInsertId()]);
            break;

        case 'PUT':
            if (!$id) {
                http_response_code(400);
                echo json_encode(["error" => "ID required for PUT"]);
                break;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                http_response_code(400);
                echo json_encode(["error" => "Invalid JSON input"]);
                break;
            }

            $session_id = $input['session_id'] ?? null;
            $payload = isset($input['payload']) ? json_encode($input['payload']) : null;

            if (!$session_id && !$payload) {
                http_response_code(400);
                echo json_encode(["error" => "No data provided for update"]);
                break;
            }

            $sql = "UPDATE analytics_log SET session_id = COALESCE(?, session_id), payload = COALESCE(?, payload) WHERE id = ? AND type = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$session_id, $payload, $id, $resource]);

            echo json_encode(["status" => "updated", "id" => $id]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
}
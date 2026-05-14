<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$name    = trim($data['name'] ?? '');
$email   = trim($data['email'] ?? '');
$message = trim($data['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

if (strlen($name) > 100 || strlen($email) > 150) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Input too long.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
    $stmt->execute([
        ':name'    => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        ':email'   => $email,
        ':message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
    ]);
    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save your message. Please try again.']);
}
?>

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT id, title, description, image_url, demo_link, repo_link, created_at FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();
    echo json_encode(['success' => true, 'data' => $projects]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to fetch projects.']);
}
?>

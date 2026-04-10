<?php
// api/save_business.php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$place_id = $data['place_id'] ?? '';
$action = $data['action'] ?? 'save';
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['success' => false, 'login_required' => true]);
    exit;
}

if (!$place_id) {
    echo json_encode(['success' => false, 'error' => 'Missing place_id']);
    exit;
}

// Create table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS saved_businesses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    place_id VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_save (user_id, place_id),
    INDEX idx_user_id (user_id)
)";
mysqli_query($conn, $createTable);

if ($action === 'save') {
    $sql = "INSERT IGNORE INTO saved_businesses (user_id, place_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $place_id);
} else {
    $sql = "DELETE FROM saved_businesses WHERE user_id = ? AND place_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $place_id);
}

$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo json_encode(['success' => $success]);
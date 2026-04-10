<?php
// api/log_contact.php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$place_id = $data['place_id'] ?? '';
$contact_type = $data['contact_type'] ?? 'call';
$user_id = $_SESSION['user_id'] ?? null;

if (!$place_id) {
    echo json_encode(['success' => false, 'error' => 'Missing place_id']);
    exit;
}

// Create table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS contact_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    place_id VARCHAR(255) NOT NULL,
    user_id INT NULL,
    contact_type ENUM('call', 'whatsapp', 'website', 'directions', 'location_share') DEFAULT 'call',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_place_id (place_id),
    INDEX idx_user_id (user_id)
)";
mysqli_query($conn, $createTable);

$sql = "INSERT INTO contact_logs (place_id, user_id, contact_type) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sis", $place_id, $user_id, $contact_type);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo json_encode(['success' => $success]);
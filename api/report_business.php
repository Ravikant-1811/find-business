<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['place_id']) || !isset($input['reason'])) {
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

// Database connection
$host = "localhost";
$dbname = "u792021313_directory";
$db_username = "u792021313_directory";
$db_password = "Directory@2025";

$conn = new mysqli($host, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS business_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    place_id VARCHAR(255) NOT NULL,
    reason VARCHAR(255) NOT NULL,
    reported_at DATETIME NOT NULL,
    status ENUM('pending', 'reviewed', 'resolved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Insert report
$stmt = $conn->prepare("INSERT INTO business_reports (place_id, reason, reported_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $input['place_id'], $input['reason'], $input['reported_at']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Report submitted successfully']);
} else {
    echo json_encode(['error' => 'Failed to submit report']);
}

$stmt->close();
$conn->close();
?>
<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$placeId = $data['place_id'] ?? '';
$reportType = $data['report_type'] ?? '';

if (!$placeId || !$reportType) {
    echo json_encode(['error' => 'Missing data']);
    exit;
}

$conn = new mysqli("localhost", "u792021313_directory", "Directory@2025", "u792021313_directory");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database error']);
    exit;
}

$userId = $_SESSION['user_id'] ?? 'anonymous_' . session_id();
$ip = $_SERVER['REMOTE_ADDR'] ?? '';

$stmt = $conn->prepare("INSERT INTO business_reports (place_id, report_type, user_id, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())");
if ($stmt) {
    $stmt->bind_param("ssss", $placeId, $reportType, $userId, $ip);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
echo json_encode(['success' => true]);
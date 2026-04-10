<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$placeId = $data['place_id'] ?? '';
$type = $data['type'] ?? 'call';

if (!$placeId) {
    echo json_encode(['error' => 'Missing place_id']);
    exit;
}

// Track in session
if (!isset($_SESSION['contacted_businesses'])) {
    $_SESSION['contacted_businesses'] = [];
}

$_SESSION['contacted_businesses'][] = [
    'place_id' => $placeId,
    'type' => $type,
    'time' => time()
];

// Mark that user called
if (isset($_SESSION['last_search'])) {
    $_SESSION['last_search']['called'] = true;
}

// Update database
$conn = new mysqli("localhost", "u792021313_directory", "Directory@2025", "u792021313_directory");
if (!$conn->connect_error) {
    $stmt = $conn->prepare("UPDATE places SET contact_count = contact_count + 1 WHERE place_id = ?");
    if ($stmt) {
        $stmt->bind_param("s", $placeId);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
}

echo json_encode(['success' => true]);
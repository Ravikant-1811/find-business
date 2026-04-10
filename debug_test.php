<?php
header('Content-Type: application/json');

echo json_encode([
    'request_method' => $_SERVER['REQUEST_METHOD'],
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'not set',
    'post_data' => $_POST,
    'raw_input' => file_get_contents('php://input'),
    'get_data' => $_GET
]);
?>
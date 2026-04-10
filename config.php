<?php
$host = "localhost";
$user = "u792021313_directory";
$pass = "Directory@2025";
$db   = "u792021313_directory";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ADD THIS LINE - Google API Key
define('GOOGLE_API_KEY', 'AIzaSyCk4bKhUMpUQ7Sef-s_gv8EBAVSSQFz0Q4');
?>
<?php
require_once 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS `data_places` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `place_id` VARCHAR(255) NOT NULL UNIQUE,
    `name` VARCHAR(500) NOT NULL,
    `formatted_address` TEXT,
    `vicinity` VARCHAR(500),
    `city` VARCHAR(255),
    `state` VARCHAR(100),
    `phone` VARCHAR(50),
    `international_phone` VARCHAR(50),
    `website` VARCHAR(500),
    `rating` DECIMAL(2,1) DEFAULT 0,
    `total_ratings` INT DEFAULT 0,
    `price_level` TINYINT,
    `types` TEXT,
    `primary_type` VARCHAR(100),
    `latitude` DECIMAL(10,8),
    `longitude` DECIMAL(11,8),
    `business_status` VARCHAR(50),
    `google_url` VARCHAR(500),
    `opening_hours` TEXT,
    `photos` TEXT,
    `reviews` TEXT,
    `is_open_now` TINYINT(1),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conn, $sql)) {
    echo "✅ data_places table created successfully!";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>
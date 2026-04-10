<?php
session_start();
include_once 'app-detect.php';

$detectedLocation = '';

if (!empty($_GET['location']) && $_GET['location'] !== '') {
    $detectedLocation = trim($_GET['location']);
    $_SESSION['user_city'] = $detectedLocation;
} elseif (!empty($_SESSION['user_city']) && $_SESSION['user_city'] !== '') {
    $detectedLocation = $_SESSION['user_city'];
} else {
    $detectedLocation = 'Vapi';
}

require_once 'key.php';

$host = "localhost";
$dbname = "u792021313_directory";
$db_username = "u792021313_directory";
$db_password = "Directory@2025";

$conn = new mysqli($host, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getCachedData($conn, $cacheKey, $callback, $expireMinutes = 60) {
    $stmt = $conn->prepare("SELECT cache_data FROM api_cache WHERE cache_key = ? AND expires_at > NOW()");
    if (!$stmt) return $callback();
    $stmt->bind_param("s", $cacheKey);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return json_decode($row['cache_data'], true);
    }
    $stmt->close();
    $data = $callback();
    if (empty($data)) return $data;
    $expiresAt = date('Y-m-d H:i:s', strtotime("+{$expireMinutes} minutes"));
    $createdAt = date('Y-m-d H:i:s');
    $cacheData = json_encode($data);
    $stmt = $conn->prepare("INSERT INTO api_cache (cache_key, cache_data, created_at, expires_at) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE cache_data = VALUES(cache_data), expires_at = VALUES(expires_at)");
    if ($stmt) {
        $stmt->bind_param("ssss", $cacheKey, $cacheData, $createdAt, $expiresAt);
        $stmt->execute();
        $stmt->close();
    }
    return $data;
}

function fetchGooglePlaces($query, $location = '', $limit = 6) {
    $apiKey = GOOGLE_PLACES_API_KEY;
    if ($location != '') {
        $encodedQuery = urlencode($query . ' in ' . $location);
    } else {
        $encodedQuery = urlencode($query);
    }
    $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$encodedQuery}&key={$apiKey}&region=in";
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 5
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if (isset($data['results'])) {
        return array_slice($data['results'], 0, $limit);
    }
    return [];
}

function getPhotoUrl($photos, $maxWidth = 400) {
    if (!empty($photos) && isset($photos[0]['photo_reference'])) {
        $photoRef = $photos[0]['photo_reference'];
        $apiKey = GOOGLE_PLACES_API_KEY;
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photo_reference={$photoRef}&key={$apiKey}";
    }
    return 'https://ui-avatars.com/api/?name=Business&background=e8f5e9&color=2e7d32&size=400';
}

function generateStars($rating) {
    $rating = floatval($rating);
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    $html = '';
    for ($i = 0; $i < $fullStars; $i++) $html .= '<i class="fas fa-star"></i>';
    if ($halfStar) $html .= '<i class="fas fa-star-half-alt"></i>';
    for ($i = 0; $i < $emptyStars; $i++) $html .= '<i class="far fa-star"></i>';
    return $html;
}

// ============================================
// FETCH ALL DATA WITH CACHING
// ============================================
$loc = $detectedLocation;

$popularBusinesses = getCachedData($conn, 'popular_biz_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('top rated popular businesses', $loc, 8);
}, 120);

$restaurants = getCachedData($conn, 'restaurants_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('best restaurants', $loc, 6);
}, 120);

$hospitals = getCachedData($conn, 'hospitals_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('hospitals clinics', $loc, 6);
}, 120);

$hotels = getCachedData($conn, 'hotels_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('hotels lodges', $loc, 6);
}, 120);

$touristPlaces = getCachedData($conn, 'tourist_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('tourist places attractions things to do', $loc, 8);
}, 180);

$homeServices = getCachedData($conn, 'home_services_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('electrician plumber carpenter home repair services', $loc, 6);
}, 120);

$industrial = getCachedData($conn, 'industrial_' . md5($loc), function() use ($loc) {
    return fetchGooglePlaces('industrial companies factories manufacturing', $loc, 6);
}, 180);

$conn->close();

// Emergency services
$emergencyServices = [
    ['name' => 'Ambulance', 'number' => '108', 'icon' => 'fa-ambulance', 'color' => '#dc2626', 'bg' => '#fef2f2'],
    ['name' => 'Police', 'number' => '100', 'icon' => 'fa-shield-alt', 'color' => '#1d4ed8', 'bg' => '#eff6ff'],
    ['name' => 'Fire', 'number' => '101', 'icon' => 'fa-fire-extinguisher', 'color' => '#ea580c', 'bg' => '#fff7ed'],
    ['name' => 'Women Help', 'number' => '1091', 'icon' => 'fa-female', 'color' => '#db2777', 'bg' => '#fdf2f8'],
    ['name' => 'Gas Leak', 'number' => '1906', 'icon' => 'fa-burn', 'color' => '#ca8a04', 'bg' => '#fefce8'],
    ['name' => 'Disaster', 'number' => '1078', 'icon' => 'fa-house-damage', 'color' => '#7c3aed', 'bg' => '#f5f3ff']
];

// Categories
$categories = [
    ['name' => 'Doctor', 'icon' => 'fa-user-md', 'color' => '#dc2626', 'bg' => '#fef2f2', 'query' => 'doctors+clinic'],
    ['name' => 'Hospital', 'icon' => 'fa-hospital', 'color' => '#059669', 'bg' => '#ecfdf5', 'query' => 'hospitals'],
    ['name' => 'Electrician', 'icon' => 'fa-bolt', 'color' => '#d97706', 'bg' => '#fffbeb', 'query' => 'electrician'],
    ['name' => 'Plumber', 'icon' => 'fa-wrench', 'color' => '#2563eb', 'bg' => '#eff6ff', 'query' => 'plumber'],
    ['name' => 'Restaurant', 'icon' => 'fa-utensils', 'color' => '#ea580c', 'bg' => '#fff7ed', 'query' => 'restaurants'],
    ['name' => 'Hotel', 'icon' => 'fa-bed', 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'query' => 'hotels'],
    ['name' => 'Petrol Pump', 'icon' => 'fa-gas-pump', 'color' => '#0891b2', 'bg' => '#ecfeff', 'query' => 'petrol+pump'],
    ['name' => 'ATM', 'icon' => 'fa-credit-card', 'color' => '#4f46e5', 'bg' => '#eef2ff', 'query' => 'atm+bank'],
    ['name' => 'Pharmacy', 'icon' => 'fa-pills', 'color' => '#16a34a', 'bg' => '#f0fdf4', 'query' => 'pharmacy+medical+store'],
    ['name' => 'Salon', 'icon' => 'fa-cut', 'color' => '#e11d48', 'bg' => '#fff1f2', 'query' => 'salon+parlour'],
    ['name' => 'Gym', 'icon' => 'fa-dumbbell', 'color' => '#0d9488', 'bg' => '#f0fdfa', 'query' => 'gym+fitness'],
    ['name' => 'More', 'icon' => 'fa-th', 'color' => '#6b7280', 'bg' => '#f3f4f6', 'query' => '']
];

// Quick services
$quickServices = [
    ['name' => 'AC Repair', 'icon' => 'fa-snowflake', 'query' => 'ac+repair+service'],
    ['name' => 'Car Service', 'icon' => 'fa-car', 'query' => 'car+repair+service'],
    ['name' => 'Painter', 'icon' => 'fa-paint-roller', 'query' => 'house+painter'],
    ['name' => 'Pest Control', 'icon' => 'fa-bug', 'query' => 'pest+control'],
    ['name' => 'Carpenter', 'icon' => 'fa-hammer', 'query' => 'carpenter+furniture'],
    ['name' => 'Packers Movers', 'icon' => 'fa-truck', 'query' => 'packers+movers'],
    ['name' => 'Tutor', 'icon' => 'fa-chalkboard-teacher', 'query' => 'home+tutor+tuition'],
    ['name' => 'Lawyer', 'icon' => 'fa-gavel', 'query' => 'lawyer+advocate'],
    ['name' => 'CA', 'icon' => 'fa-calculator', 'query' => 'chartered+accountant'],
    ['name' => 'Vet', 'icon' => 'fa-paw', 'query' => 'veterinary+pet+doctor'],
    ['name' => 'Tailor', 'icon' => 'fa-tshirt', 'query' => 'tailor+stitching'],
    ['name' => 'Courier', 'icon' => 'fa-box', 'query' => 'courier+delivery+service']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Find Business - <?php echo htmlspecialchars($detectedLocation); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
        }
        html {
            touch-action: pan-y;
            overflow-x: hidden;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f5f5f7;
            color: #1a1a2e;
            line-height: 1.5;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            padding: 0;
            margin: 0;
        }

        /* ===== LOCATION PILL ===== */
        .location-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 13px;
            color: #374151;
            font-weight: 500;
            margin: 14px 16px 0;
        }
        .location-pill i {
            color: #dc2626;
            font-size: 13px;
        }
        .location-pill strong {
            color: #1a1a2e;
            font-weight: 700;
        }

        /* ===== SECTION ===== */
        .section {
            padding: 18px 16px 0;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .section-title .emoji {
            font-size: 19px;
        }
        .see-all {
            font-size: 13px;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .see-all i { font-size: 10px; }

        /* ===== EMERGENCY ===== */
        .emergency-banner {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .emergency-banner-icon {
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }
        .emergency-banner-text h3 {
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }
        .emergency-banner-text p {
            color: rgba(255,255,255,0.85);
            font-size: 12px;
            margin-top: 2px;
        }
        .emergency-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .emergency-card {
            text-align: center;
            padding: 14px 8px 12px;
            border-radius: 14px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            border: 1px solid #f0f0f0;
            background: #fff;
        }
        .emergency-card .e-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }
        .emergency-card .e-name {
            font-size: 11px;
            font-weight: 600;
            color: #374151;
            line-height: 1.2;
        }
        .emergency-card .e-number {
            font-size: 15px;
            font-weight: 800;
            color: #dc2626;
            letter-spacing: 0.5px;
        }

        /* ===== CATEGORY GRID ===== */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        .category-item {
            text-align: center;
            text-decoration: none;
            padding: 14px 4px 10px;
            border-radius: 14px;
            background: #fff;
            border: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .category-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }
        .category-name {
            font-size: 11px;
            font-weight: 600;
            color: #374151;
            line-height: 1.2;
        }

        /* ===== TRENDING CHIPS ===== */
        .trending-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .trend-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 8px 14px;
            font-size: 13px;
            color: #374151;
            font-weight: 500;
            text-decoration: none;
        }
        .trend-chip .fire { font-size: 14px; }

        /* ===== HORIZONTAL SCROLL ===== */
        .h-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 4px;
            scrollbar-width: none;
        }
        .h-scroll::-webkit-scrollbar { display: none; }

        /* ===== BUSINESS CARD ===== */
        .biz-card {
            flex-shrink: 0;
            width: 260px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            scroll-snap-align: start;
            text-decoration: none;
            color: inherit;
            border: 1px solid #f0f0f0;
        }
        .biz-card-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            background: #e5e7eb;
            display: block;
        }
        .biz-card-body { padding: 12px; }
        .biz-card-name {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .biz-card-address {
            font-size: 12px;
            color: #6b7280;
            margin-top: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .biz-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }
        .biz-card-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .biz-card-rating .stars {
            color: #f59e0b;
            font-size: 11px;
        }
        .biz-card-rating .count {
            color: #9ca3af;
            font-weight: 400;
        }
        .biz-card-status {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
        }
        .status-open { background: #ecfdf5; color: #059669; }
        .status-closed { background: #fef2f2; color: #dc2626; }
        .biz-card-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #f3f4f6;
        }
        .biz-action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 8px 0;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-call { background: #059669; color: #fff; }
        .btn-direction { background: #eff6ff; color: #2563eb; }

        /* ===== TOURIST CARD ===== */
        .tourist-card {
            flex-shrink: 0;
            width: 200px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            scroll-snap-align: start;
            text-decoration: none;
            color: inherit;
            border: 1px solid #f0f0f0;
        }
        .tourist-card-img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            background: #e5e7eb;
            display: block;
        }
        .tourist-card-body { padding: 10px 12px 12px; }
        .tourist-card-name {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .tourist-card-loc {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 3px;
        }
        .tourist-card-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 6px;
            font-size: 12px;
        }
        .tourist-card-rating .stars { color: #f59e0b; font-size: 11px; }
        .tourist-card-rating span { font-weight: 600; color: #1a1a2e; }

        /* ===== SERVICE GRID ===== */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        .service-item {
            text-align: center;
            text-decoration: none;
            padding: 14px 4px 10px;
            border-radius: 14px;
            background: #fff;
            border: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .service-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #f0f9ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #0369a1;
        }
        .service-name {
            font-size: 10.5px;
            font-weight: 600;
            color: #374151;
            line-height: 1.2;
        }

        /* ===== FULL WIDTH CARD ===== */
        .full-cards {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .full-biz-card {
            display: flex;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            border: 1px solid #f0f0f0;
        }
        .full-biz-img {
            width: 110px;
            min-height: 110px;
            object-fit: cover;
            background: #e5e7eb;
            flex-shrink: 0;
        }
        .full-biz-body {
            flex: 1;
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }
        .full-biz-name {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .full-biz-address {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .full-biz-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
        }
        .full-biz-rating {
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .full-biz-rating .stars { color: #f59e0b; font-size: 11px; }
        .full-biz-actions {
            display: flex;
            gap: 6px;
            margin-top: 8px;
        }
        .full-biz-actions .biz-action-btn {
            padding: 6px 12px;
            font-size: 11px;
        }

        /* ===== PROMO BANNER ===== */
        .promo-banner {
            margin: 18px 16px 0;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }
        .promo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            flex-shrink: 0;
        }
        .promo-text h3 { color: #fff; font-size: 15px; font-weight: 700; }
        .promo-text p { color: rgba(255,255,255,0.85); font-size: 12px; margin-top: 2px; }
        .promo-arrow { color: #fff; font-size: 18px; margin-left: auto; }

        /* ===== STATS BAR ===== */
        .stats-bar {
            background: #fff;
            border-radius: 14px;
            padding: 18px 16px;
            border: 1px solid #f0f0f0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .stat-item { text-align: center; }
        .stat-number { font-size: 22px; font-weight: 800; }
        .stat-label { font-size: 11px; color: #6b7280; margin-top: 2px; }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            padding: 30px;
            text-align: center;
            color: #9ca3af;
            width: 100%;
        }
        .empty-state i {
            font-size: 28px;
            margin-bottom: 8px;
            display: block;
        }

        /* ===== BOTTOM SPACER ===== */
        .bottom-spacer { height: 24px; }

        /* ===== NO ZOOM ===== */
        input, select, textarea { font-size: 16px !important; }
    </style>
</head>
<body>

<!-- ===== LOCATION PILL ===== -->
<div class="location-pill">
    <i class="fas fa-map-marker-alt"></i>
    <strong><?php echo htmlspecialchars($detectedLocation); ?></strong>
    <span>• Your Location</span>
</div>

<!-- ===== 1. EMERGENCY SERVICES ===== -->
<div class="section">
    <div class="emergency-banner">
        <div class="emergency-banner-icon">
            <i class="fas fa-phone-alt"></i>
        </div>
        <div class="emergency-banner-text">
            <h3>Emergency Helplines</h3>
            <p>Tap to call instantly • Available 24/7</p>
        </div>
    </div>
    <div class="emergency-grid">
        <?php foreach ($emergencyServices as $es): ?>
        <a href="tel:<?php echo $es['number']; ?>" class="emergency-card">
            <div class="e-icon" style="background:<?php echo $es['bg']; ?>;color:<?php echo $es['color']; ?>">
                <i class="fas <?php echo $es['icon']; ?>"></i>
            </div>
            <div class="e-name"><?php echo $es['name']; ?></div>
            <div class="e-number"><?php echo $es['number']; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== 2. CATEGORIES ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">📂</span> Categories</div>
    </div>
    <div class="category-grid">
        <?php foreach ($categories as $cat): ?>
        <a href="<?php echo $cat['query'] !== '' ? 'search.php?q=' . $cat['query'] . '&location=' . urlencode($detectedLocation) : 'categories.php'; ?>" class="category-item">
            <div class="category-icon" style="background:<?php echo $cat['bg']; ?>;color:<?php echo $cat['color']; ?>">
                <i class="fas <?php echo $cat['icon']; ?>"></i>
            </div>
            <div class="category-name"><?php echo $cat['name']; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== 3. TRENDING NOW ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🔥</span> Trending Now</div>
    </div>
    <div class="trending-chips">
        <a href="search.php?q=electrician&location=<?php echo urlencode($detectedLocation); ?>" class="trend-chip"><span class="fire">⚡</span> Electrician</a>
        <a href="search.php?q=doctor&location=<?php echo urlencode($detectedLocation); ?>" class="trend-chip"><span class="fire">🩺</span> Doctor</a>
        <a href="search.php?q=plumber&location=<?php echo urlencode($detectedLocation); ?>" class="trend-chip"><span class="fire">🔧</span> Plumber</a>
        <a href="search.php?q=restaurant&location=<?php echo urlencode($detectedLocation); ?>" class="trend-chip"><span class="fire">🍽️</span> Restaurant</a>
        <a href="search.php?q=ac+repair&location=<?php echo urlencode($detectedLocation); ?>" class="trend-chip"><span class="fire">❄️</span> AC Repair</a>
        <a href="search.php?q=pet+doctor&location=<?php echo urlencode($detectedLocation); ?>" class="trend-chip"><span class="fire">🐾</span> Pet Doctor</a>
    </div>
</div>

<!-- ===== 4. POPULAR BUSINESSES NEAR YOU ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">📍</span> Popular in <?php echo htmlspecialchars($detectedLocation); ?></div>
        <a href="search.php?q=popular+businesses&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="h-scroll">
        <?php if (!empty($popularBusinesses)): ?>
            <?php foreach ($popularBusinesses as $biz): ?>
            <div class="biz-card">
                <img class="biz-card-img" src="<?php echo getPhotoUrl($biz['photos'] ?? [], 400); ?>" alt="<?php echo htmlspecialchars($biz['name']); ?>" loading="lazy">
                <div class="biz-card-body">
                    <div class="biz-card-name"><?php echo htmlspecialchars($biz['name']); ?></div>
                    <div class="biz-card-address">
                        <i class="fas fa-map-pin"></i>
                        <?php echo htmlspecialchars(substr($biz['formatted_address'] ?? '', 0, 40)); ?>
                    </div>
                    <div class="biz-card-meta">
                        <div class="biz-card-rating">
                            <div class="stars"><?php echo generateStars($biz['rating'] ?? 0); ?></div>
                            <span><?php echo number_format($biz['rating'] ?? 0, 1); ?></span>
                            <span class="count">(<?php echo $biz['user_ratings_total'] ?? 0; ?>)</span>
                        </div>
                        <?php if (isset($biz['opening_hours']['open_now'])): ?>
                            <span class="biz-card-status <?php echo $biz['opening_hours']['open_now'] ? 'status-open' : 'status-closed'; ?>">
                                <?php echo $biz['opening_hours']['open_now'] ? 'Open' : 'Closed'; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="biz-card-actions">
                        <a href="place_details.php?place_id=<?php echo urlencode($biz['place_id']); ?>" class="biz-action-btn btn-direction"><i class="fas fa-info-circle"></i> Details</a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo ($biz['geometry']['location']['lat'] ?? 0); ?>,<?php echo ($biz['geometry']['location']['lng'] ?? 0); ?>" class="biz-action-btn btn-call" target="_blank"><i class="fas fa-directions"></i> Direction</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state"><i class="fas fa-store"></i>No businesses found nearby</div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== 5. TOP RESTAURANTS ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🍽️</span> Top Restaurants</div>
        <a href="search.php?q=restaurants&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="h-scroll">
        <?php if (!empty($restaurants)): ?>
            <?php foreach ($restaurants as $biz): ?>
            <div class="biz-card">
                <img class="biz-card-img" src="<?php echo getPhotoUrl($biz['photos'] ?? [], 400); ?>" alt="<?php echo htmlspecialchars($biz['name']); ?>" loading="lazy">
                <div class="biz-card-body">
                    <div class="biz-card-name"><?php echo htmlspecialchars($biz['name']); ?></div>
                    <div class="biz-card-address"><i class="fas fa-map-pin"></i> <?php echo htmlspecialchars(substr($biz['formatted_address'] ?? '', 0, 40)); ?></div>
                    <div class="biz-card-meta">
                        <div class="biz-card-rating">
                            <div class="stars"><?php echo generateStars($biz['rating'] ?? 0); ?></div>
                            <span><?php echo number_format($biz['rating'] ?? 0, 1); ?></span>
                            <span class="count">(<?php echo $biz['user_ratings_total'] ?? 0; ?>)</span>
                        </div>
                        <?php if (isset($biz['opening_hours']['open_now'])): ?>
                            <span class="biz-card-status <?php echo $biz['opening_hours']['open_now'] ? 'status-open' : 'status-closed'; ?>">
                                <?php echo $biz['opening_hours']['open_now'] ? 'Open' : 'Closed'; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="biz-card-actions">
                        <a href="detail.php?place_id=<?php echo urlencode($biz['place_id']); ?>" class="biz-action-btn btn-direction"><i class="fas fa-info-circle"></i> Details</a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo ($biz['geometry']['location']['lat'] ?? 0); ?>,<?php echo ($biz['geometry']['location']['lng'] ?? 0); ?>" class="biz-action-btn btn-call" target="_blank"><i class="fas fa-directions"></i> Direction</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- ===== 6. PROMO BANNER ===== -->
<a href="add_business.php" class="promo-banner">
    <div class="promo-icon"><i class="fas fa-store"></i></div>
    <div class="promo-text">
        <h3>List Your Business FREE</h3>
        <p>Reach thousands of customers in <?php echo htmlspecialchars($detectedLocation); ?></p>
    </div>
    <i class="fas fa-chevron-right promo-arrow"></i>
</a>

<!-- ===== 7. TOURIST PLACES ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🏛️</span> Places to Visit</div>
        <a href="search.php?q=tourist+places&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="h-scroll">
        <?php if (!empty($touristPlaces)): ?>
            <?php foreach ($touristPlaces as $place): ?>
            <a href="detail.php?place_id=<?php echo urlencode($place['place_id']); ?>" class="tourist-card">
                <img class="tourist-card-img" src="<?php echo getPhotoUrl($place['photos'] ?? [], 300); ?>" alt="<?php echo htmlspecialchars($place['name']); ?>" loading="lazy">
                <div class="tourist-card-body">
                    <div class="tourist-card-name"><?php echo htmlspecialchars($place['name']); ?></div>
                    <div class="tourist-card-loc"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars(substr($place['formatted_address'] ?? '', 0, 30)); ?></div>
                    <div class="tourist-card-rating">
                        <div class="stars"><?php echo generateStars($place['rating'] ?? 0); ?></div>
                        <span><?php echo number_format($place['rating'] ?? 0, 1); ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state"><i class="fas fa-landmark"></i>No tourist places found</div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== 8. HOSPITALS & CLINICS ===== -
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🏥</span> Hospitals & Clinics</div>
        <a href="search.php?q=hospitals&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="full-cards">
        <?php if (!empty($hospitals)): ?>
            <?php foreach (array_slice($hospitals, 0, 4) as $biz): ?>
            <a href="detail.php?place_id=<?php echo urlencode($biz['place_id']); ?>" class="full-biz-card">
                <img class="full-biz-img" src="<?php echo getPhotoUrl($biz['photos'] ?? [], 300); ?>" alt="<?php echo htmlspecialchars($biz['name']); ?>" loading="lazy">
                <div class="full-biz-body">
                    <div class="full-biz-name"><?php echo htmlspecialchars($biz['name']); ?></div>
                    <div class="full-biz-address"><?php echo htmlspecialchars(substr($biz['formatted_address'] ?? '', 0, 45)); ?></div>
                    <div class="full-biz-meta">
                        <div class="full-biz-rating">
                            <div class="stars"><?php echo generateStars($biz['rating'] ?? 0); ?></div>
                            <span><?php echo number_format($biz['rating'] ?? 0, 1); ?></span>
                        </div>
                        <?php if (isset($biz['opening_hours']['open_now'])): ?>
                            <span class="biz-card-status <?php echo $biz['opening_hours']['open_now'] ? 'status-open' : 'status-closed'; ?>">
                                <?php echo $biz['opening_hours']['open_now'] ? 'Open' : 'Closed'; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="full-biz-actions">
                        <span class="biz-action-btn btn-direction"><i class="fas fa-info-circle"></i> Details</span>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo ($biz['geometry']['location']['lat'] ?? 0); ?>,<?php echo ($biz['geometry']['location']['lng'] ?? 0); ?>" class="biz-action-btn btn-call" onclick="event.stopPropagation();event.preventDefault();window.open(this.href,'_blank');" target="_blank"><i class="fas fa-directions"></i> Go</a>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>----->

<!-- ===== 9. HOTELS & STAYS ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🏨</span> Hotels & Stays</div>
        <a href="search.php?q=hotels&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="h-scroll">
        <?php if (!empty($hotels)): ?>
            <?php foreach ($hotels as $biz): ?>
            <div class="biz-card">
                <img class="biz-card-img" src="<?php echo getPhotoUrl($biz['photos'] ?? [], 400); ?>" alt="<?php echo htmlspecialchars($biz['name']); ?>" loading="lazy">
                <div class="biz-card-body">
                    <div class="biz-card-name"><?php echo htmlspecialchars($biz['name']); ?></div>
                    <div class="biz-card-address"><i class="fas fa-map-pin"></i> <?php echo htmlspecialchars(substr($biz['formatted_address'] ?? '', 0, 40)); ?></div>
                    <div class="biz-card-meta">
                        <div class="biz-card-rating">
                            <div class="stars"><?php echo generateStars($biz['rating'] ?? 0); ?></div>
                            <span><?php echo number_format($biz['rating'] ?? 0, 1); ?></span>
                            <span class="count">(<?php echo $biz['user_ratings_total'] ?? 0; ?>)</span>
                        </div>
                        <?php if (isset($biz['opening_hours']['open_now'])): ?>
                            <span class="biz-card-status <?php echo $biz['opening_hours']['open_now'] ? 'status-open' : 'status-closed'; ?>">
                                <?php echo $biz['opening_hours']['open_now'] ? 'Open' : 'Closed'; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="biz-card-actions">
                        <a href="place_details.php?place_id=<?php echo urlencode($biz['place_id']); ?>" class="biz-action-btn btn-direction"><i class="fas fa-info-circle"></i> Details</a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo ($biz['geometry']['location']['lat'] ?? 0); ?>,<?php echo ($biz['geometry']['location']['lng'] ?? 0); ?>" class="biz-action-btn btn-call" target="_blank"><i class="fas fa-directions"></i> Direction</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- ===== 10. QUICK SERVICES ===== -->
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🛠️</span> Quick Services</div>
    </div>
    <div class="service-grid">
        <?php foreach ($quickServices as $svc): ?>
        <a href="search.php?q=<?php echo $svc['query']; ?>&location=<?php echo urlencode($detectedLocation); ?>" class="service-item">
            <div class="service-icon"><i class="fas <?php echo $svc['icon']; ?>"></i></div>
            <div class="service-name"><?php echo $svc['name']; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== 11. HOME SERVICES ===== -->
<?php if (!empty($homeServices)): ?>
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🏠</span> Home Services</div>
        <a href="search.php?q=home+services&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="h-scroll">
        <?php foreach ($homeServices as $biz): ?>
        <div class="biz-card">
            <img class="biz-card-img" src="<?php echo getPhotoUrl($biz['photos'] ?? [], 400); ?>" alt="<?php echo htmlspecialchars($biz['name']); ?>" loading="lazy">
            <div class="biz-card-body">
                <div class="biz-card-name"><?php echo htmlspecialchars($biz['name']); ?></div>
                <div class="biz-card-address"><i class="fas fa-map-pin"></i> <?php echo htmlspecialchars(substr($biz['formatted_address'] ?? '', 0, 40)); ?></div>
                <div class="biz-card-meta">
                    <div class="biz-card-rating">
                        <div class="stars"><?php echo generateStars($biz['rating'] ?? 0); ?></div>
                        <span><?php echo number_format($biz['rating'] ?? 0, 1); ?></span>
                    </div>
                    <?php if (isset($biz['opening_hours']['open_now']) && $biz['opening_hours']['open_now']): ?>
                        <span class="biz-card-status status-open">Open</span>
                    <?php endif; ?>
                </div>
                <div class="biz-card-actions">
                    <a href="place_details.php?place_id=<?php echo urlencode($biz['place_id']); ?>" class="biz-action-btn btn-direction"><i class="fas fa-info-circle"></i> Details</a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo ($biz['geometry']['location']['lat'] ?? 0); ?>,<?php echo ($biz['geometry']['location']['lng'] ?? 0); ?>" class="biz-action-btn btn-call" target="_blank"><i class="fas fa-directions"></i> Direction</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===== 12. INDUSTRIAL ===== -->
<?php if (!empty($industrial)): ?>
<div class="section">
    <div class="section-header">
        <div class="section-title"><span class="emoji">🏭</span> Industrial & Manufacturing</div>
        <a href="search.php?q=industrial+companies&location=<?php echo urlencode($detectedLocation); ?>" class="see-all">See All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="full-cards">
        <?php foreach (array_slice($industrial, 0, 4) as $biz): ?>
        <a href="place_details.php?place_id=<?php echo urlencode($biz['place_id']); ?>" class="full-biz-card">
            <img class="full-biz-img" src="<?php echo getPhotoUrl($biz['photos'] ?? [], 300); ?>" alt="<?php echo htmlspecialchars($biz['name']); ?>" loading="lazy">
            <div class="full-biz-body">
                <div class="full-biz-name"><?php echo htmlspecialchars($biz['name']); ?></div>
                <div class="full-biz-address"><?php echo htmlspecialchars(substr($biz['formatted_address'] ?? '', 0, 45)); ?></div>
                <div class="full-biz-meta">
                    <div class="full-biz-rating">
                        <div class="stars"><?php echo generateStars($biz['rating'] ?? 0); ?></div>
                        <span><?php echo number_format($biz['rating'] ?? 0, 1); ?></span>
                    </div>
                    <?php if (isset($biz['opening_hours']['open_now']) && $biz['opening_hours']['open_now']): ?>
                        <span class="biz-card-status status-open">Open</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===== 13. STATS ===== -->
<div class="section">
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-number" style="color:#1e40af;">50,000+</div>
            <div class="stat-label">Businesses Listed</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" style="color:#059669;">500+</div>
            <div class="stat-label">Cities Covered</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" style="color:#d97706;">1M+</div>
            <div class="stat-label">Monthly Searches</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" style="color:#dc2626;">4.8★</div>
            <div class="stat-label">User Rating</div>
        </div>
    </div>
</div>

<div class="bottom-spacer"></div>

</body>
</html>
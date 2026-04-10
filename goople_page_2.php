<?php include_once 'app-detect.php'; ?>

<?php
// =============================================
// FIND BUSINESS - SEARCH RESULTS PAGE
// API ONLY DISPLAY + AUTO SAVE TO DATABASE
// =============================================

// Error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// ============================
// API KEY
// ============================
$API_KEY = "AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU"; // ⚠️ CHANGE THIS

// ============================
// DATABASE CONNECTION
// ============================
$host = "localhost";
$dbname = "u792021313_directory";
$db_username = "u792021313_directory";
$db_password = "Directory@2025";

$conn = new mysqli($host, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ============================
// GET SEARCH PARAMETERS
// ============================
$q         = trim($_GET['q'] ?? '');
$pagetoken = $_GET['pagetoken'] ?? '';
$type      = $_GET['type'] ?? '';
$location  = trim($_GET['location'] ?? '');
$sort      = $_GET['sort'] ?? 'relevance';
$rating    = $_GET['rating'] ?? '';
$open_now  = $_GET['open_now'] ?? '';
$price     = $_GET['price'] ?? '';

// Redirect if no query
if (empty($q)) {
    header("Location: index.php");
    exit;
}

// ============================
// INITIALIZE VARIABLES
// ============================
$results    = [];
$nextPage   = "";
$status     = "ERROR";
$dataSource = "api";

// =============================================
// ALWAYS CALL GOOGLE API
// =============================================

// Build API query
$queryString = $q;
if (!empty($location)) {
    $queryString .= " in " . $location;
}
if (!empty($type)) {
    $queryString .= " " . $type;
}

$apiUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
$apiUrl .= "query=" . urlencode($queryString);
$apiUrl .= "&key=" . $API_KEY;
$apiUrl .= "&region=in";

if ($open_now === 'true') {
    $apiUrl .= "&opennow=true";
}

if ($pagetoken != "") {
    $apiUrl .= "&pagetoken=" . urlencode($pagetoken);
    sleep(2);
}

// =============================================
// CALL API
// =============================================
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Mozilla/5.0'
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$results  = $data['results'] ?? [];
$nextPage = $data['next_page_token'] ?? "";
$status   = $data['status'] ?? "ERROR";

// =============================================
// SAVE API DATA TO DATABASE
// =============================================
if ($status === 'OK' && !empty($results)) {
    saveToDatabase($conn, $results, $q);
}

// =============================================
// APPLY FILTERS
// =============================================
if (!empty($rating)) {
    $results = array_filter($results, function($item) use ($rating) {
        return isset($item['rating']) && $item['rating'] >= floatval($rating);
    });
    $results = array_values($results);
}

if ($price !== '') {
    $results = array_filter($results, function($item) use ($price) {
        return isset($item['price_level']) && $item['price_level'] <= intval($price);
    });
    $results = array_values($results);
}

// =============================================
// SORT RESULTS
// =============================================
if ($sort === 'rating') {
    usort($results, function($a, $b) {
        return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
    });
} elseif ($sort === 'reviews') {
    usort($results, function($a, $b) {
        return ($b['user_ratings_total'] ?? 0) <=> ($a['user_ratings_total'] ?? 0);
    });
}

$totalResults = count($results);

// =============================================
// AUTO SAVE FUNCTION
// =============================================
function saveToDatabase($conn, $places, $searchQuery) {
    $stmt = $conn->prepare(
        "INSERT IGNORE INTO places
        (place_id, name, address, lat, lng, rating, user_ratings_total,
         price_level, types, photo_reference, search_query)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) return false;

    foreach ($places as $place) {
        $place_id = $place['place_id'] ?? '';
        $name     = $place['name'] ?? '';
        $address  = $place['formatted_address'] ?? '';
        $lat      = $place['geometry']['location']['lat'] ?? 0;
        $lng      = $place['geometry']['location']['lng'] ?? 0;
        $rating   = $place['rating'] ?? 0;
        $reviews  = $place['user_ratings_total'] ?? 0;
        $price    = $place['price_level'] ?? 0;
        $types    = implode(",", $place['types'] ?? []);

        $photo_reference = '';
        if (!empty($place['photos'][0]['photo_reference'])) {
            $photo_reference = $place['photos'][0]['photo_reference'];
        }

        $stmt->bind_param(
            "sssdddiisss",
            $place_id,
            $name,
            $address,
            $lat,
            $lng,
            $rating,
            $reviews,
            $price,
            $types,
            $photo_reference,
            $searchQuery
        );
        $stmt->execute();
    }

    $stmt->close();
    return true;
}

// =============================================
// HELPER FUNCTIONS
// =============================================
function getPhotoUrl($photos, $apiKey, $maxWidth = 400) {
    if (!empty($photos[0]['photo_reference'])) {
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photoreference="
            . $photos[0]['photo_reference'] . "&key={$apiKey}";
    }
    return "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=300&fit=crop";
}

function getTypeIcon($types) {
    $iconMap = [
        'restaurant'=>'fa-utensils','food'=>'fa-utensils','cafe'=>'fa-coffee',
        'hotel'=>'fa-hotel','lodging'=>'fa-bed','hospital'=>'fa-hospital',
        'doctor'=>'fa-user-md','health'=>'fa-heartbeat','school'=>'fa-graduation-cap',
        'store'=>'fa-store','gym'=>'fa-dumbbell','spa'=>'fa-spa',
        'pharmacy'=>'fa-pills','bank'=>'fa-university',
        'airport'=>'fa-plane','train_station'=>'fa-train','bus_station'=>'fa-bus',
        'electrician'=>'fa-bolt','plumber'=>'fa-wrench','mechanic'=>'fa-car'
    ];
    foreach ($types ?? [] as $type) {
        if (isset($iconMap[$type])) return $iconMap[$type];
    }
    return 'fa-building';
}

function formatType($types) {
    $priorityTypes = ['hospital', 'restaurant', 'hotel', 'doctor', 'pharmacy', 'gym', 'bank', 'school'];
    foreach ($priorityTypes as $priority) {
        if (in_array($priority, $types ?? [])) {
            return ucwords(str_replace('_', ' ', $priority));
        }
    }
    foreach ($types ?? [] as $type) {
        if (!in_array($type, ['point_of_interest', 'establishment'])) {
            return ucwords(str_replace('_', ' ', $type));
        }
    }
    return 'Business';
}

function getPriceLevel($level) {
    $prices = ['Free','₹','₹₹','₹₹₹','₹₹₹₹'];
    return $prices[$level] ?? '';
}

function truncateText($text, $length = 100) {
    return strlen($text) <= $length ? $text : substr($text,0,$length).'...';
}

function makeSlug($string) {
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $string)));
    return trim($slug, '-');
}

// Shorten Address Function
function shortenAddress($fullAddress) {
    // Remove common prefixes like SURVEY NO., PLOT NO., etc.
    $address = preg_replace('/^(SURVEY NO\.|S\.NO\.|PLOT NO\.|NO\.|SHOP NO\.)\s*[\d\-\/]+,?\s*/i', '', $fullAddress);
    
    // Split by comma
    $parts = explode(',', $address);
    
    // Get meaningful parts
    $meaningful = [];
    foreach ($parts as $part) {
        $part = trim($part);
        // Skip parts that are mostly numbers or too short
        if (strlen($part) > 3 && !preg_match('/^[\d\-\/\s]+$/', $part)) {
            $meaningful[] = $part;
            if (count($meaningful) >= 2) break;
        }
    }
    
    // Return meaningful parts or fallback
    if (count($meaningful) > 0) {
        return implode(', ', $meaningful);
    }
    
    // Fallback: return first 40 chars
    return strlen($fullAddress) > 40 ? substr($fullAddress, 0, 40) . '...' : $fullAddress;
}

// Check if emergency category
function isEmergencyCategory($type) {
    $emergencyTypes = ['hospital', 'doctor', 'pharmacy', 'clinic', 'health', 'dentist', 'physiotherapist'];
    return in_array(strtolower($type), $emergencyTypes);
}

// Check if urgent service category
function isUrgentServiceCategory($type) {
    $urgentTypes = ['plumber', 'electrician', 'mechanic', 'locksmith', 'towing'];
    return in_array(strtolower($type), $urgentTypes);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Search: <?= htmlspecialchars($q) ?><?= $location ? ' in ' . htmlspecialchars($location) : '' ?> - Find Business</title>
    <meta name="description" content="Find <?= htmlspecialchars($q) ?> businesses on Find Business - India's leading business directory.">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* ========================================
           CSS RESET & VARIABLES
        ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #ff6b35;
            --primary-dark: #e55a2b;
            --primary-light: #ff8c5a;
            --primary-gradient: linear-gradient(135deg, #ff6b35, #e55a2b);
            --secondary: #138808;
            --secondary-light: #1ba50d;
            --secondary-gradient: linear-gradient(135deg, #138808, #1ba50d);
            --accent: #000080;
            --accent-light: #1a1a9e;
            --dark: #1a1a2e;
            --dark-light: #16213e;
            --gray-900: #1e293b;
            --gray-800: #1e293b;
            --gray-700: #334155;
            --gray-600: #475569;
            --gray-500: #64748b;
            --gray-400: #94a3b8;
            --gray-300: #cbd5e1;
            --gray-200: #e2e8f0;
            --gray-100: #f1f5f9;
            --gray-50: #f8fafc;
            --light: #f8fafc;
            --white: #ffffff;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #3b82f6;
            --info-light: #dbeafe;
            --whatsapp: #25D366;
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-primary: 0 10px 40px rgba(255, 107, 53, 0.3);
            --transition-fast: all 0.15s ease;
            --transition: all 0.3s ease;
            --transition-slow: all 0.5s ease;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-2xl: 24px;
            --radius-3xl: 32px;
            --radius-full: 9999px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--gray-700);
            background: var(--light);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        ul {
            list-style: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        /* ========================================
           SEARCH HEADER
        ======================================== */
        .search-header {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 50%, #1e3a5f 100%);
            padding: 100px 5% 50px;
            position: relative;
            overflow: hidden;
        }

        .search-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(ellipse, rgba(255, 107, 53, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .search-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 60%;
            height: 150%;
            background: radial-gradient(ellipse, rgba(19, 136, 8, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .search-header-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb a:hover {
            color: var(--white);
        }

        .breadcrumb-separator {
            color: rgba(255, 255, 255, 0.3);
            font-size: 10px;
        }

        .breadcrumb-current {
            color: var(--primary);
            font-weight: 500;
        }

        .search-header-title {
            font-size: 36px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .search-header-title .highlight {
            color: var(--primary);
        }

        .search-header-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            margin-bottom: 30px;
        }

        .search-header-subtitle strong {
            color: var(--white);
            font-weight: 700;
        }

        /* Main Search Box */
        .search-box-main {
            background: var(--white);
            border-radius: var(--radius-2xl);
            padding: 8px;
            display: flex;
            align-items: center;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            max-width: 900px;
        }

        .search-input-group {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            gap: 12px;
            min-width: 0;
        }

        .search-input-group i {
            color: var(--gray-400);
            font-size: 18px;
            flex-shrink: 0;
        }

        .search-input-group input {
            border: none;
            outline: none;
            font-size: 16px;
            width: 100%;
            color: var(--gray-800);
            background: transparent;
        }

        .search-input-group input::placeholder {
            color: var(--gray-400);
        }

        .search-divider {
            width: 1px;
            height: 40px;
            background: var(--gray-200);
            flex-shrink: 0;
        }

        .search-btn-main {
            background: var(--primary-gradient);
            color: var(--white);
            border: none;
            padding: 16px 32px;
            border-radius: var(--radius-xl);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .search-btn-main:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow-primary);
        }

        /* Quick Search Tags */
        .quick-search-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
        }

        .quick-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
        }

        .quick-tag:hover {
            background: var(--white);
            color: var(--primary);
            border-color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(255, 255, 255, 0.35);
        }

        .quick-tag:active {
            transform: scale(0.96);
        }

        .quick-tag i {
            font-size: 12px;
            opacity: 0.9;
        }

        /* ========================================
           MAIN CONTENT LAYOUT
        ======================================== */
        .main-wrapper {
            max-width: 1500px;
            margin: 0 auto;
            padding: 40px 5%;
            display: flex;
            gap: 35px;
        }

        /* ========================================
           SIDEBAR FILTERS
        ======================================== */
        .sidebar {
            width: 300px;
            flex-shrink: 0;
        }

        .sidebar-sticky {
            position: sticky;
            top: 90px;
        }

        .filter-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 25px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 25px;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title i {
            color: var(--primary);
        }

        .filter-clear {
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-clear:hover {
            text-decoration: underline;
        }

        .filter-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--gray-100);
        }

        .filter-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .filter-section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-section-title i {
            color: var(--gray-400);
            font-size: 14px;
        }

        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
        }

        .filter-option:hover {
            background: var(--gray-50);
        }

        .filter-option.active {
            background: rgba(255, 107, 53, 0.08);
            border-color: var(--primary);
        }

        .filter-option input {
            display: none;
        }

        .filter-checkbox,
        .filter-radio {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-300);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .filter-radio {
            border-radius: var(--radius-full);
        }

        .filter-option.active .filter-checkbox,
        .filter-option.active .filter-radio {
            background: var(--primary);
            border-color: var(--primary);
        }

        .filter-option.active .filter-checkbox::after,
        .filter-option.active .filter-radio::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--white);
            font-size: 10px;
        }

        .filter-option-content {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-option-label {
            font-size: 14px;
            color: var(--gray-700);
            font-weight: 500;
        }

        .filter-option-count {
            font-size: 12px;
            color: var(--gray-400);
            background: var(--gray-100);
            padding: 2px 8px;
            border-radius: var(--radius-full);
        }

        /* Rating Stars Filter */
        .rating-option {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-option i {
            color: var(--warning);
            font-size: 14px;
        }

        .rating-option span {
            font-size: 14px;
            color: var(--gray-600);
            margin-left: 5px;
        }

        /* Apply Filters Button */
        .filter-apply-btn {
            width: 100%;
            padding: 16px;
            background: var(--primary-gradient);
            color: var(--white);
            border: none;
            border-radius: var(--radius-lg);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .filter-apply-btn:hover {
            box-shadow: var(--shadow-primary);
            transform: translateY(-2px);
        }

        /* Popular Searches Card */
        .popular-card {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
            border-radius: var(--radius-xl);
            padding: 25px;
            color: var(--white);
        }

        .popular-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .popular-title i {
            color: var(--primary);
        }

        .popular-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .popular-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            transition: var(--transition);
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .popular-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .popular-link i {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        /* ========================================
           RESULTS SECTION
        ======================================== */
        .results-section {
            flex: 1;
            min-width: 0;
        }

        /* Results Header */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .results-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .results-count {
            font-size: 16px;
            color: var(--gray-600);
        }

        .results-count strong {
            color: var(--dark);
            font-weight: 700;
        }

        .results-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 18px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
            white-space: nowrap;
        }

        .results-badge.success {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        .results-badge.warning {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        .results-badge i {
            font-size: 13px;
        }

        .results-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Mobile Filter Toggle */
        .mobile-filter-toggle {
            display: none;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
        }

        .mobile-filter-toggle i {
            color: var(--primary);
        }

        /* View Toggle */
        .view-toggle {
            display: flex;
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 4px;
            box-shadow: var(--shadow-sm);
        }

        .view-btn {
            width: 44px;
            height: 40px;
            border: none;
            background: transparent;
            color: var(--gray-400);
            cursor: pointer;
            border-radius: var(--radius-md);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .view-btn.active {
            background: var(--primary);
            color: var(--white);
        }

        .view-btn:hover:not(.active) {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        /* Sort Dropdown */
        .sort-dropdown {
            position: relative;
        }

        .sort-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            min-width: 180px;
        }

        .sort-trigger:hover {
            border-color: var(--primary);
        }

        .sort-trigger i:last-child {
            margin-left: auto;
            font-size: 12px;
            transition: var(--transition);
        }

        .sort-dropdown.active .sort-trigger i:last-child {
            transform: rotate(180deg);
        }

        .sort-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 100;
            overflow: hidden;
        }

        .sort-dropdown.active .sort-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .sort-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            font-size: 14px;
            color: var(--gray-600);
            cursor: pointer;
            transition: var(--transition);
        }

        .sort-option:hover {
            background: var(--gray-100);
        }

        .sort-option.active {
            background: rgba(255, 107, 53, 0.1);
            color: var(--primary);
        }

        .sort-option i {
            width: 20px;
            color: var(--gray-400);
        }

        .sort-option.active i {
            color: var(--primary);
        }

        /* ========================================
           EMERGENCY TOGGLE BAR
        ======================================== */
        .emergency-toggle-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 2px solid #fecaca;
            border-radius: var(--radius-xl);
            margin-bottom: 25px;
        }

        .emergency-toggle-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .emergency-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            animation: pulse-emergency 2s infinite;
        }

        @keyframes pulse-emergency {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        }

        .emergency-toggle-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: #991b1b;
            margin-bottom: 2px;
        }

        .emergency-toggle-text p {
            font-size: 12px;
            color: #b91c1c;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 56px;
            height: 30px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #d1d5db;
            border-radius: 9999px;
            transition: 0.3s;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .toggle-switch input:checked + .toggle-slider {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        /* ========================================
           RESULTS GRID
        ======================================== */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 25px;
        }

        .results-grid.list-view {
            grid-template-columns: 1fr;
        }

        /* ========================================
           BUSINESS CARD
        ======================================== */
        .business-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
        }

        .business-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
        }

        .card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .business-card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,0.6) 100%);
            pointer-events: none;
        }

        .card-badges {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 2;
        }

        .card-badges-left {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-badge {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-badge.open {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--success), #059669);
            color: var(--white);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .card-badge.closed {
            background: var(--danger);
            color: var(--white);
        }

        .card-badge.verified {
            background: var(--white);
            color: var(--success);
        }

        .card-badge.featured {
            background: var(--warning);
            color: var(--white);
        }

        /* Save Button (Wishlist) */
        .card-favorite {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius-full);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            flex-shrink: 0;
            position: relative;
        }

        .card-favorite:hover {
            transform: scale(1.1);
        }

        .card-favorite i {
            font-size: 16px;
            color: var(--danger);
            transition: var(--transition);
        }

        .card-favorite.saved i {
            font-weight: 900;
        }

        .save-label {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .card-favorite:hover .save-label {
            opacity: 1;
            bottom: -35px;
        }

        /* Image Count Badge */
        .card-image-count {
            position: absolute;
            bottom: 15px;
            right: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 9999px;
            color: var(--white);
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }

        .card-image-count i {
            font-size: 11px;
        }

        .card-category-tag {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-700);
            z-index: 2;
        }

        .card-category-tag i {
            color: var(--primary);
        }

        .card-content {
            padding: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            gap: 15px;
        }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.3;
            margin: 0;
            flex: 1;
        }

        .card-title a:hover {
            color: var(--primary);
        }

        .card-price {
            background: var(--gray-100);
            padding: 5px 10px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            color: var(--secondary);
            flex-shrink: 0;
        }

        .card-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .card-stars {
            display: flex;
            gap: 2px;
        }

        .card-stars i {
            font-size: 13px;
            color: var(--warning);
        }

        .card-stars i.empty {
            color: var(--gray-300);
        }

        .card-rating-score {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
        }

        .card-rating-count {
            font-size: 12px;
            color: var(--gray-500);
        }

        /* Distance Badge */
        .distance-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            color: #1d4ed8;
            border: 1px solid rgba(29, 78, 216, 0.15);
            margin-bottom: 12px;
        }

        .distance-badge i {
            font-size: 11px;
        }

        .distance-badge .separator {
            width: 4px;
            height: 4px;
            background: currentColor;
            border-radius: 50%;
            opacity: 0.5;
        }

        /* Shortened Address */
        .card-address-short {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 14px;
            color: var(--gray-600);
            margin-bottom: 12px;
        }

        .card-address-short .address-main {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .card-address-short .address-main i {
            color: var(--primary);
            margin-top: 3px;
            flex-shrink: 0;
        }

        .card-address-short .address-text {
            line-height: 1.4;
        }

        .view-full-address {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            padding-left: 24px;
            transition: all 0.3s ease;
        }

        .view-full-address:hover {
            text-decoration: underline;
        }

        .full-address-popup {
            display: none;
            background: var(--gray-100);
            padding: 12px;
            border-radius: var(--radius-md);
            font-size: 13px;
            color: var(--gray-700);
            margin-top: 8px;
            line-height: 1.5;
        }

        .full-address-popup.show {
            display: block;
        }

        /* Facility Chips */
        .card-facility-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 15px;
        }

        .facility-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .facility-chip.emergency {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .facility-chip.verified {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            color: #16a34a;
            border: 1px solid rgba(22, 163, 74, 0.2);
        }

        .facility-chip.feature {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb;
            border: 1px solid rgba(37, 99, 235, 0.2);
        }

        .facility-chip.premium {
            background: linear-gradient(135deg, #fefce8, #fef9c3);
            color: #ca8a04;
            border: 1px solid rgba(202, 138, 4, 0.2);
        }

        /* Direct Contact Buttons */
        .card-direct-contact {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            padding: 12px;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .contact-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-btn.call-btn {
            background: linear-gradient(135deg, var(--success), #059669);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .contact-btn.call-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .contact-btn.call-btn .phone-number {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .contact-btn.whatsapp-btn {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .contact-btn.whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }

        /* Send Location Button */
        .send-location-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 12px;
        }

        .send-location-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        /* Card Actions */
        .card-actions {
            display: flex;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid var(--gray-100);
        }

        .card-btn {
            flex: 1;
            padding: 12px 14px;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .card-btn.primary {
            background: var(--primary-gradient);
            color: var(--white);
        }

        .card-btn.primary:hover {
            box-shadow: var(--shadow-primary);
            transform: translateY(-2px);
        }

        .card-btn.secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .card-btn.secondary:hover {
            background: var(--gray-200);
        }

        /* Social Share Icons */
        .card-share-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--gray-100);
        }

        .card-share-icons {
            display: flex;
            gap: 8px;
        }

        .share-icon-btn {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .share-icon-btn.facebook {
            background: #1877f2;
            color: white;
        }

        .share-icon-btn.twitter {
            background: #1da1f2;
            color: white;
        }

        .share-icon-btn.whatsapp-share {
            background: #25D366;
            color: white;
        }

        .share-icon-btn.copy-link {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .share-icon-btn:hover {
            transform: scale(1.1);
        }

        /* Report Button */
        .report-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--gray-400);
            cursor: pointer;
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
        }

        .report-btn:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .report-btn i {
            font-size: 10px;
        }

        /* ========================================
           LIST VIEW STYLES
        ======================================== */
        .results-grid.list-view .business-card {
            display: grid;
            grid-template-columns: 280px 1fr;
        }

        .results-grid.list-view .card-image {
            height: 100%;
            min-height: 280px;
        }

        .results-grid.list-view .card-content {
            display: flex;
            flex-direction: column;
        }

        .results-grid.list-view .card-actions {
            margin-top: auto;
        }

        /* ========================================
           NO RESULTS
        ======================================== */
        .no-results {
            text-align: center;
            padding: 80px 40px;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
        }

        .no-results-icon {
            width: 140px;
            height: 140px;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .no-results-icon i {
            font-size: 60px;
            color: var(--gray-300);
        }

        .no-results h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .no-results p {
            color: var(--gray-500);
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .no-results-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-top: 30px;
        }

        .suggestion-btn {
            padding: 12px 24px;
            background: var(--gray-100);
            border: none;
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
        }

        .suggestion-btn:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* ========================================
           LOAD MORE
        ======================================== */
        .load-more-section {
            text-align: center;
            margin-top: 50px;
        }

        .load-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 50px;
            background: var(--white);
            border: 2px solid var(--primary);
            border-radius: var(--radius-xl);
            color: var(--primary);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .load-more-btn:hover {
            background: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-primary);
        }

        /* ========================================
           MAP VIEW TOGGLE
        ======================================== */
        .map-toggle-btn {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 16px 34px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--dark), var(--dark-light));
            color: var(--white);
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            white-space: nowrap;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .map-toggle-btn:hover {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            transform: translateX(-50%) translateY(-4px);
            box-shadow: 0 18px 45px rgba(255, 107, 53, 0.45);
        }

        .map-toggle-btn:active {
            transform: translateX(-50%) scale(0.96);
        }

        .map-toggle-btn i {
            font-size: 16px;
        }

        /* ========================================
           TOAST NOTIFICATION
        ======================================== */
        .toast-notification {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark);
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateX(-50%) translateY(20px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 1; transform: translateX(-50%) translateY(0); }
            to { opacity: 0; transform: translateX(-50%) translateY(20px); }
        }

        /* ========================================
           BACK TO TOP
        ======================================== */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-gradient);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
            box-shadow: var(--shadow-primary);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            text-decoration: none;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 1200px) {
            .main-wrapper {
                gap: 25px;
            }

            .sidebar {
                width: 280px;
            }

            .results-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }

            .results-grid.list-view .business-card {
                grid-template-columns: 260px 1fr;
            }
        }

        @media (max-width: 1024px) {
            .main-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                display: none;
            }

            .sidebar.mobile-visible {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1002;
                background: var(--white);
                overflow-y: auto;
                padding: 80px 20px 30px;
            }

            .mobile-filter-toggle {
                display: flex;
            }

            .results-grid.list-view .business-card {
                grid-template-columns: 1fr;
            }

            .results-grid.list-view .card-image {
                height: 200px;
                min-height: 200px;
            }

            .map-toggle-btn {
                bottom: 20px;
                padding: 14px 24px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .search-header {
                padding: 90px 5% 40px;
            }

            .search-header-title {
                font-size: 28px;
            }

            .search-box-main {
                flex-direction: column;
                padding: 15px;
                border-radius: var(--radius-xl);
            }

            .search-input-group {
                width: 100%;
                padding: 12px 15px;
            }

            .search-divider {
                width: 100%;
                height: 1px;
            }

            .search-btn-main {
                width: 100%;
                justify-content: center;
                border-radius: var(--radius-lg);
            }

            .quick-search-tags {
                justify-content: center;
            }

            .results-header {
                flex-direction: column;
                align-items: stretch;
            }

            .results-controls {
                justify-content: space-between;
            }

            .sort-trigger {
                min-width: 150px;
            }

            .results-grid {
                grid-template-columns: 1fr;
            }

            .emergency-toggle-bar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .card-direct-contact {
                flex-direction: column;
                gap: 8px;
                padding: 10px;
            }

            .contact-btn {
                padding: 14px;
                font-size: 14px;
            }

            .card-facility-chips {
                gap: 5px;
            }

            .facility-chip {
                padding: 4px 8px;
                font-size: 9px;
            }

            .card-share-section {
                flex-direction: column;
                gap: 10px;
            }

            .card-share-icons {
                justify-content: center;
            }

            .distance-badge {
                font-size: 11px;
                padding: 6px 12px;
            }

            .map-toggle-btn {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .search-header {
                padding: 85px 4% 30px;
            }

            .search-header-title {
                font-size: 24px;
            }

            .main-wrapper {
                padding: 20px 4%;
            }

            .card-content {
                padding: 16px;
            }

            .card-title {
                font-size: 16px;
            }

            .card-actions {
                flex-wrap: wrap;
            }

            .card-btn {
                padding: 10px 12px;
                font-size: 12px;
            }

            .no-results {
                padding: 50px 25px;
            }

            .no-results-icon {
                width: 100px;
                height: 100px;
            }

            .no-results-icon i {
                font-size: 40px;
            }

            .no-results h2 {
                font-size: 22px;
            }

            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }

            .contact-btn .phone-number {
                font-size: 13px;
            }

            .card-image-count {
                padding: 5px 10px;
                font-size: 11px;
            }
        }

        /* Mobile Sidebar Close */
        .sidebar-mobile-header {
            display: none;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            margin: -80px -20px 20px;
            background: var(--white);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .sidebar.mobile-visible .sidebar-mobile-header {
            display: flex;
        }

        .sidebar-mobile-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
        }

        .sidebar-close {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            color: var(--gray-600);
        }

        .sidebar-close:hover {
            background: var(--gray-200);
        }

        /* ========================================
           APP VIEW STYLES
        ======================================== */
        .app-view .mobile-footer,
        .app-view footer {
            display: none !important;
        }

        .app-view body {
            padding-bottom: 70px;
        }

        .app-view header,
        .app-view .header,
        .app-view .navbar,
        .app-view .site-header {
            display: none !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        .app-view .hero,
        .app-view .hero-section,
        .app-view #hero,
        .app-view .home-hero {
            display: none !important;
            height: 0 !important;
            overflow: hidden !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .app-view body {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        .app-view .search-header {
            display: none !important;
            height: 0 !important;
            overflow: hidden !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .app-view * {
            animation: none !important;
            scroll-behavior: auto !important;
        }
    </style>
</head>
<body class="<?php echo isset($isApp) && $isApp ? 'app-view' : 'web-view'; ?>">

    <?php include 'header.php';?>

    <!-- SEARCH HEADER -->
    <section class="search-header">
        <div class="search-header-container">
            <nav class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">Search Results</span>
            </nav>

            <h1 class="search-header-title">
                Results for "<span class="highlight"><?= htmlspecialchars($q) ?></span>"
                <?php if ($location): ?>
                in <span class="highlight"><?= htmlspecialchars($location) ?></span>
                <?php endif; ?>
            </h1>

            <p class="search-header-subtitle">
                <?php if ($totalResults > 0): ?>
                Found <strong><?= number_format($totalResults) ?></strong> businesses matching your search
                <?php else: ?>
                No businesses found for your search. Try different keywords.
                <?php endif; ?>
            </p>

            <form class="search-box-main" action="google_results.php" method="GET">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Search businesses, services, products..." value="<?= htmlspecialchars($q) ?>" required>
                </div>
                <div class="search-divider"></div>
                <div class="search-input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="location" placeholder="City, State or ZIP code" value="<?= htmlspecialchars($location) ?>">
                </div>
                <button type="submit" class="search-btn-main">
                    <i class="fas fa-search"></i>
                    Search
                </button>
            </form>

            <div class="quick-search-tags">
                <a href="google_results.php?q=restaurants&location=<?= urlencode($location) ?>" class="quick-tag">
                    <i class="fas fa-utensils"></i> Restaurants
                </a>
                <a href="google_results.php?q=hotels&location=<?= urlencode($location) ?>" class="quick-tag">
                    <i class="fas fa-hotel"></i> Hotels
                </a>
                <a href="google_results.php?q=hospitals&location=<?= urlencode($location) ?>" class="quick-tag">
                    <i class="fas fa-hospital"></i> Hospitals
                </a>
                <a href="google_results.php?q=shopping&location=<?= urlencode($location) ?>" class="quick-tag">
                    <i class="fas fa-shopping-bag"></i> Shopping
                </a>
                <a href="google_results.php?q=gym&location=<?= urlencode($location) ?>" class="quick-tag">
                    <i class="fas fa-dumbbell"></i> Gyms
                </a>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="filterSidebar">
            <div class="sidebar-sticky">
                <!-- Mobile Header -->
                <div class="sidebar-mobile-header">
                    <h3>Filters</h3>
                    <button class="sidebar-close" id="sidebarClose">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="filter-card">
                    <div class="filter-header">
                        <h3 class="filter-title">
                            <i class="fas fa-sliders-h"></i>
                            Filters
                        </h3>
                        <span class="filter-clear" onclick="clearAllFilters()">Clear All</span>
                    </div>

                    <form id="filterForm" action="google_results.php" method="GET">
                        <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
                        <input type="hidden" name="location" value="<?= htmlspecialchars($location) ?>">

                        <!-- Rating Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-star"></i>
                                Rating
                            </h4>
                            <div class="filter-options">
                                <?php
                                $ratingOptions = [
                                    '4.5' => '4.5 & up',
                                    '4' => '4.0 & up',
                                    '3.5' => '3.5 & up',
                                    '3' => '3.0 & up',
                                ];
                                foreach ($ratingOptions as $value => $label):
                                    $isActive = ($rating == $value);
                                ?>
                                <label class="filter-option <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="rating" value="<?= $value ?>" <?= $isActive ? 'checked' : '' ?>>
                                    <span class="filter-radio"></span>
                                    <div class="filter-option-content">
                                        <div class="rating-option">
                                            <?php
                                            $stars = floor(floatval($value));
                                            $halfStar = (floatval($value) - $stars) >= 0.5;
                                            for ($i = 0; $i < $stars; $i++) echo '<i class="fas fa-star"></i>';
                                            if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                                            ?>
                                            <span><?= $label ?></span>
                                        </div>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Availability Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-clock"></i>
                                Availability
                            </h4>
                            <div class="filter-options">
                                <label class="filter-option <?= $open_now == 'true' ? 'active' : '' ?>">
                                    <input type="checkbox" name="open_now" value="true" <?= $open_now == 'true' ? 'checked' : '' ?>>
                                    <span class="filter-checkbox"></span>
                                    <div class="filter-option-content">
                                        <span class="filter-option-label">Open Now</span>
                                    </div>
                                </label>
                                                        </div>
                        </div>

                        <!-- Sort Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-sort"></i>
                                Sort By
                            </h4>
                            <div class="filter-options">
                                <?php
                                $sortOptions = [
                                    'relevance' => 'Most Relevant',
                                    'rating' => 'Highest Rated',
                                    'reviews' => 'Most Reviews',
                                ];
                                foreach ($sortOptions as $value => $label):
                                    $isActive = ($sort == $value);
                                ?>
                                <label class="filter-option <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="sort" value="<?= $value ?>" <?= $isActive ? 'checked' : '' ?>>
                                    <span class="filter-radio"></span>
                                    <div class="filter-option-content">
                                        <span class="filter-option-label"><?= $label ?></span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="filter-section">
                            <h4 class="filter-section-title">
                                <i class="fas fa-th-large"></i>
                                Category
                            </h4>
                            <div class="filter-options">
                                <?php
                                $categories = [
                                    'restaurant' => 'Restaurants',
                                    'hotel' => 'Hotels',
                                    'hospital' => 'Healthcare',
                                    'shopping' => 'Shopping',
                                    'education' => 'Education',
                                    'gym' => 'Fitness',
                                ];
                                foreach ($categories as $value => $label):
                                    $isActive = ($type == $value);
                                ?>
                                <label class="filter-option <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="type" value="<?= $value ?>" <?= $isActive ? 'checked' : '' ?>>
                                    <span class="filter-radio"></span>
                                    <div class="filter-option-content">
                                        <span class="filter-option-label"><?= $label ?></span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button type="submit" class="filter-apply-btn">
                            <i class="fas fa-check"></i>
                            Apply Filters
                        </button>
                    </form>
                </div>

                <!-- Popular Searches -->
                <div class="popular-card">
                    <h4 class="popular-title">
                        <i class="fas fa-fire"></i>
                        Popular Searches
                    </h4>
                    <div class="popular-links">
                        <a href="google_results.php?q=restaurants&location=<?= urlencode($location) ?>" class="popular-link">
                            <i class="fas fa-utensils"></i>
                            Restaurants
                        </a>
                        <a href="google_results.php?q=hotels&location=<?= urlencode($location) ?>" class="popular-link">
                            <i class="fas fa-hotel"></i>
                            Hotels
                        </a>
                        <a href="google_results.php?q=hospitals&location=<?= urlencode($location) ?>" class="popular-link">
                            <i class="fas fa-hospital"></i>
                            Hospitals
                        </a>
                        <a href="google_results.php?q=shopping+mall&location=<?= urlencode($location) ?>" class="popular-link">
                            <i class="fas fa-shopping-bag"></i>
                            Shopping Malls
                        </a>
                        <a href="google_results.php?q=gym&location=<?= urlencode($location) ?>" class="popular-link">
                            <i class="fas fa-dumbbell"></i>
                            Gyms
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- RESULTS SECTION -->
        <section class="results-section">
            <!-- Results Header -->
            <div class="results-header">
                <div class="results-info">
                    <span class="results-count">
                        Showing <strong><?= number_format($totalResults) ?></strong> results
                    </span>
                    <?php if ($status === 'OK'): ?>
                    <span class="results-badge success">
                        <i class="fas fa-check-circle"></i>
                        Verified Results
                    </span>
                    <?php elseif ($status !== 'ZERO_RESULTS'): ?>
                    <span class="results-badge warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($status) ?>
                    </span>
                    <?php endif; ?>
                </div>

                <div class="results-controls">
                    <!-- Mobile Filter Toggle -->
                    <button class="mobile-filter-toggle" id="mobileFilterToggle">
                        <i class="fas fa-filter"></i>
                        Filters
                    </button>

                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid" title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="view-btn" data-view="list" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="sort-dropdown" id="sortDropdown">
                        <button type="button" class="sort-trigger">
                            <i class="fas fa-sort-amount-down"></i>
                            <span>Sort By</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="sort-menu">
                            <div class="sort-option <?= $sort == 'relevance' ? 'active' : '' ?>" data-sort="relevance">
                                <i class="fas fa-fire"></i>
                                Most Relevant
                            </div>
                            <div class="sort-option <?= $sort == 'rating' ? 'active' : '' ?>" data-sort="rating">
                                <i class="fas fa-star"></i>
                                Highest Rated
                            </div>
                            <div class="sort-option <?= $sort == 'reviews' ? 'active' : '' ?>" data-sort="reviews">
                                <i class="fas fa-comments"></i>
                                Most Reviews
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
            // Check if this is an emergency/urgent search
            $emergencyKeywords = ['hospital', 'doctor', 'emergency', 'ambulance', 'pharmacy', 'clinic', 'plumber', 'electrician', 'mechanic'];
            $isEmergencySearch = false;
            foreach ($emergencyKeywords as $keyword) {
                if (stripos($q, $keyword) !== false) {
                    $isEmergencySearch = true;
                    break;
                }
            }
            ?>

            <?php if ($isEmergencySearch): ?>
            <!-- Emergency Toggle Bar -->
            <div class="emergency-toggle-bar">
                <div class="emergency-toggle-left">
                    <div class="emergency-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="emergency-toggle-text">
                        <h4>🚨 Emergency / Urgent Service</h4>
                        <p>Show only open & available services</p>
                    </div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="emergencyToggle" onchange="filterEmergency(this.checked)">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <?php endif; ?>

            <?php if (!empty($results)): ?>
            <!-- Results Grid -->
            <div class="results-grid" id="resultsGrid">
                <?php foreach ($results as $index => $business): ?>
                <?php
                    $photo = getPhotoUrl($business['photos'] ?? [], $API_KEY);
                    $businessRating = $business['rating'] ?? 0;
                    $totalRatings = $business['user_ratings_total'] ?? 0;
                    $priceLevel = $business['price_level'] ?? null;
                    $isOpen = $business['opening_hours']['open_now'] ?? null;
                    $types = $business['types'] ?? [];
                    $typeIcon = getTypeIcon($types);
                    $formattedType = formatType($types);
                    
                    $fullStars = floor($businessRating);
                    $halfStar = ($businessRating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                    
                    // Phone number (placeholder - you'll get this from Place Details API or your database)
                    $phoneNumber = $business['formatted_phone_number'] ?? '';
                    $displayPhone = $phoneNumber ?: '+91 90000000';
                    
                    // WhatsApp enabled (from your database)
                    $whatsappEnabled = $business['whatsapp_enabled'] ?? true; // Default true for demo
                    $whatsappNumber = $business['whatsapp_number'] ?? preg_replace('/[^0-9]/', '', $displayPhone);
                    
                    // Photo count
                    $photoCount = count($business['photos'] ?? []);
                    if ($photoCount == 0) $photoCount = rand(3, 12); // Random for demo
                    
                    // Full and short address
                    $fullAddress = $business['formatted_address'] ?? 'Address not available';
                    $shortAddress = shortenAddress($fullAddress);
                    
                    // SEO URL
                    $slugName = makeSlug($business['name']);
                    $seoUrl = "https://find-business.com/business/" . $slugName . "-" . $business['place_id'];
                    
                    // Check if emergency category
                    $isEmergencyType = isEmergencyCategory($formattedType) || isUrgentServiceCategory($formattedType);
                ?>
                <article class="business-card" data-index="<?= $index ?>" data-place-id="<?= htmlspecialchars($business['place_id']) ?>">
                    <!-- Card Image Section -->
                    <div class="card-image">
                        <img src="<?= htmlspecialchars($photo) ?>" alt="<?= htmlspecialchars($business['name']) ?>" loading="lazy">
                        <div class="card-image-overlay"></div>
                        
                        <!-- Top Badges -->
                        <div class="card-badges">
                            <div class="card-badges-left">
                                <?php if ($isOpen === true): ?>
                                <span class="card-badge open">
                                    <i class="fas fa-clock"></i> Open
                                </span>
                                <?php elseif ($isOpen === false): ?>
                                <span class="card-badge closed">
                                    <i class="fas fa-clock"></i> Closed
                                </span>
                                <?php endif; ?>
                                <?php if ($businessRating >= 4.5): ?>
                                <span class="card-badge verified">
                                    <i class="fas fa-check-circle"></i> Top Rated
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Save/Wishlist Button -->
                            <button class="card-favorite" title="Save for Later" data-place-id="<?= htmlspecialchars($business['place_id']) ?>">
                                <i class="far fa-heart"></i>
                                <span class="save-label">Save</span>
                            </button>
                        </div>
                        
                        <!-- Image Count Badge -->
                        <div class="card-image-count">
                            <i class="fas fa-camera"></i>
                            <?= $photoCount ?> Photos
                        </div>
                        
                        <!-- Category Tag -->
                        <div class="card-category-tag">
                            <i class="fas <?= $typeIcon ?>"></i>
                            <?= htmlspecialchars($formattedType) ?>
                        </div>
                    </div>

                    <!-- Card Content Section -->
                    <div class="card-content">
                        <!-- Title and Price -->
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="<?= $seoUrl ?>"><?= htmlspecialchars($business['name']) ?></a>
                            </h3>
                            <?php if ($priceLevel !== null): ?>
                            <span class="card-price"><?= getPriceLevel($priceLevel) ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Rating -->
                        <?php if ($businessRating > 0): ?>
                        <div class="card-rating">
                            <div class="card-stars">
                                <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                <i class="fas fa-star"></i>
                                <?php endfor; ?>
                                <?php if ($halfStar): ?>
                                <i class="fas fa-star-half-alt"></i>
                                <?php endif; ?>
                                <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                                <i class="fas fa-star empty"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="card-rating-score"><?= number_format($businessRating, 1) ?></span>
                            <span class="card-rating-count">(<?= number_format($totalRatings) ?> reviews)</span>
                        </div>
                        <?php endif; ?>

                        <!-- Distance Badge (Feature #9) -->
                        <div class="distance-badge">
                            <i class="fas fa-location-arrow"></i>
                            <span class="distance-value">1.2 km</span> away
                            <span class="separator"></span>
                            <i class="fas fa-car"></i>
                            <span class="time-value">5 min</span> drive
                        </div>

                        <!-- Shortened Address (Feature #3) -->
                        <div class="card-address-short">
                            <div class="address-main">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="address-text"><?= htmlspecialchars($shortAddress) ?></span>
                            </div>
                            <span class="view-full-address" onclick="toggleFullAddress(this)">
                                <i class="fas fa-chevron-down"></i> View Full Address
                            </span>
                            <div class="full-address-popup">
                                <?= htmlspecialchars($fullAddress) ?>
                            </div>
                        </div>

                        <!-- Facility Chips (Feature #4) -->
                        <div class="card-facility-chips">
                            <span class="facility-chip feature">
                                <i class="fas <?= $typeIcon ?>"></i>
                                <?= htmlspecialchars($formattedType) ?>
                            </span>
                            
                            <?php if ($isOpen === true && $isEmergencyType): ?>
                            <span class="facility-chip emergency">
                                <i class="fas fa-bolt"></i>
                                24×7 Available
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($businessRating >= 4.5): ?>
                            <span class="facility-chip verified">
                                <i class="fas fa-award"></i>
                                Top Rated
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($businessRating >= 4.0 && $totalRatings > 100): ?>
                            <span class="facility-chip premium">
                                <i class="fas fa-crown"></i>
                                Popular
                            </span>
                            <?php endif; ?>
                        </div>

                        <!-- Direct Contact Buttons (Features #1 & #2) -->
                        <div class="card-direct-contact">
                            <!-- Call Button -->
                            <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $displayPhone)) ?>" class="contact-btn call-btn">
                                <i class="fas fa-phone-alt"></i>
                                <span class="phone-number"><?= htmlspecialchars($displayPhone) ?></span>
                            </a>
                            
                            <!-- WhatsApp Button (only if enabled) -->
                            <?php if ($whatsappEnabled): ?>
                            <a href="https://wa.me/91<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $whatsappNumber)) ?>?text=<?= urlencode("Hi, I found your business on Find Business. I need more information about " . $business['name']) ?>" 
                               class="contact-btn whatsapp-btn" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                            <?php endif; ?>
                        </div>

                        <!-- Send Location Button (Feature #12) -->
                        <button class="send-location-btn" onclick="sendLocation('<?= htmlspecialchars(addslashes($business['name'])) ?>', '91<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $whatsappNumber)) ?>')">
                            <i class="fas fa-map-pin"></i>
                            Send My Location
                        </button>

                        <!-- Action Buttons -->
                        <div class="card-actions">
                            <a href="<?= $seoUrl ?>" class="card-btn primary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                            <a href="https://www.google.com/maps/dir/?api=1&destination_place_id=<?= urlencode($business['place_id']) ?>" target="_blank" rel="noopener" class="card-btn secondary">
                                <i class="fas fa-directions"></i>
                                Directions
                            </a>
                        </div>

                        <!-- Share & Report Section (Features #6 & #18) -->
                        <div class="card-share-section">
                            <div class="card-share-icons">
                                <button class="share-icon-btn facebook" onclick="shareOnFacebook('<?= $seoUrl ?>')" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button class="share-icon-btn x" onclick="shareOnX('<?= $seoUrl ?>', '<?= htmlspecialchars(addslashes($business['name'])) ?>')" title="Share on X">
                                    <i class="fab fa-x"></i>
                                </button>
                                <button class="share-icon-btn whatsapp-share" onclick="shareOnWhatsApp('<?= $seoUrl ?>', '<?= htmlspecialchars(addslashes($business['name'])) ?>')" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button class="share-icon-btn copy-link" onclick="copyLink('<?= $seoUrl ?>')" title="Copy Link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                            <div class="report-btn" onclick="reportBusiness('<?= htmlspecialchars($business['place_id']) ?>')">
                                <i class="fas fa-flag"></i>
                                Report incorrect info
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <!-- Load More -->
            <?php if ($nextPage): ?>
            <div class="load-more-section">
                <a href="google_results.php?q=<?= urlencode($q) ?>&location=<?= urlencode($location) ?>&pagetoken=<?= urlencode($nextPage) ?>&sort=<?= urlencode($sort) ?>&rating=<?= urlencode($rating) ?>&open_now=<?= urlencode($open_now) ?>&type=<?= urlencode($type) ?>" class="load-more-btn">
                    <i class="fas fa-sync-alt"></i>
                    Load More Results
                </a>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <!-- No Results -->
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2>No Results Found</h2>
                <p>We couldn't find any businesses matching "<strong><?= htmlspecialchars($q) ?></strong>". Try a different search or browse popular categories.</p>
                <a href="index.php" class="card-btn primary" style="display: inline-flex; padding: 16px 32px;">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
                <div class="no-results-suggestions">
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=restaurants&location=<?= urlencode($location) ?>'">Restaurants</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=hotels&location=<?= urlencode($location) ?>'">Hotels</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=hospitals&location=<?= urlencode($location) ?>'">Hospitals</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=shopping&location=<?= urlencode($location) ?>'">Shopping</button>
                    <button class="suggestion-btn" onclick="location.href='google_results.php?q=gym&location=<?= urlencode($location) ?>'">Gyms</button>
                </div>
            </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Map View Toggle Button -->
    <a href="map_view.php?q=<?= urlencode($q) ?>&location=<?= urlencode($location) ?>" class="map-toggle-btn">
        <i class="fas fa-map-marked-alt"></i>
        View on Map
    </a>

    <!-- FOOTER -->
    <?php include 'footer.php';?>

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
    <script>
        // ========================================
        // DOM ELEMENTS
        // ========================================
        const backToTop = document.getElementById('backToTop');
        const sortDropdown = document.getElementById('sortDropdown');
        const resultsGrid = document.getElementById('resultsGrid');
        const viewBtns = document.querySelectorAll('.view-btn');
        const filterSidebar = document.getElementById('filterSidebar');
        const mobileFilterToggle = document.getElementById('mobileFilterToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const filterOptions = document.querySelectorAll('.filter-option');

        // ========================================
        // MOBILE FILTER SIDEBAR
        // ========================================
        function openFilterSidebar() {
            filterSidebar.classList.add('mobile-visible');
            document.body.style.overflow = 'hidden';
        }

        function closeFilterSidebar() {
            filterSidebar.classList.remove('mobile-visible');
            document.body.style.overflow = '';
        }

        mobileFilterToggle?.addEventListener('click', openFilterSidebar);
        sidebarClose?.addEventListener('click', closeFilterSidebar);

        // ========================================
        // BACK TO TOP
        // ========================================
        function handleBackToTop() {
            if (window.scrollY > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', handleBackToTop);

        backToTop?.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ========================================
        // SORT DROPDOWN
        // ========================================
        sortDropdown?.querySelector('.sort-trigger')?.addEventListener('click', () => {
            sortDropdown.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!sortDropdown?.contains(e.target)) {
                sortDropdown?.classList.remove('active');
            }
        });

        sortDropdown?.querySelectorAll('.sort-option').forEach(option => {
            option.addEventListener('click', () => {
                const sortValue = option.dataset.sort;
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortValue);
                window.location.href = url.toString();
            });
        });

        // ========================================
        // VIEW TOGGLE (Grid/List)
        // ========================================
        viewBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                viewBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const view = btn.dataset.view;
                if (view === 'list') {
                    resultsGrid?.classList.add('list-view');
                } else {
                    resultsGrid?.classList.remove('list-view');
                }

                localStorage.setItem('viewPreference', view);
            });
        });

        // Load saved view preference
        const savedView = localStorage.getItem('viewPreference');
        if (savedView) {
            viewBtns.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.view === savedView) {
                    btn.classList.add('active');
                    if (savedView === 'list') {
                        resultsGrid?.classList.add('list-view');
                    }
                }
            });
        }

        // ========================================
        // FILTER OPTIONS
        // ========================================
        filterOptions.forEach(option => {
            option.addEventListener('click', function() {
                const input = this.querySelector('input');
                if (!input) return;

                if (input.type === 'radio') {
                    const name = input.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
                        inp.closest('.filter-option')?.classList.remove('active');
                    });
                    input.checked = true;
                    this.classList.add('active');
                } else if (input.type === 'checkbox') {
                    input.checked = !input.checked;
                    this.classList.toggle('active', input.checked);
                }
            });
        });

        // ========================================
        // CLEAR FILTERS
        // ========================================
        function clearAllFilters() {
            const url = new URL(window.location.href);
            const q = url.searchParams.get('q');
            const location = url.searchParams.get('location');
            
            let newUrl = 'google_results.php?q=' + encodeURIComponent(q || '');
            if (location) {
                newUrl += '&location=' + encodeURIComponent(location);
            }
            window.location.href = newUrl;
        }

        // ========================================
        // TOGGLE FULL ADDRESS (Feature #3)
        // ========================================
        function toggleFullAddress(element) {
            const popup = element.nextElementSibling;
            const icon = element.querySelector('i');
            
            popup.classList.toggle('show');
            
            if (popup.classList.contains('show')) {
                element.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Full Address';
            } else {
                element.innerHTML = '<i class="fas fa-chevron-down"></i> View Full Address';
            }
        }

        // ========================================
        // SOCIAL SHARE FUNCTIONS (Feature #6)
        // ========================================
        function shareOnFacebook(url) {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank', 'width=600,height=400');
        }

        function shareOnTwitter(url, title) {
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent('Check out ' + title + ' on Find Business!'), '_blank', 'width=600,height=400');
        }

        function shareOnWhatsApp(url, title) {
            window.open('https://wa.me/?text=' + encodeURIComponent('Check out ' + title + ' on Find Business! ' + url), '_blank');
        }

        function copyLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                showToast('✓ Link copied to clipboard!');
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('✓ Link copied to clipboard!');
            });
        }

        // ========================================
        // EMERGENCY TOGGLE FILTER (Feature #11)
        // ========================================
        function filterEmergency(enabled) {
            const cards = document.querySelectorAll('.business-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                if (enabled) {
                    const hasOpenBadge = card.querySelector('.card-badge.open');
                    const hasEmergencyChip = card.querySelector('.facility-chip.emergency');
                    
                    if (hasOpenBadge || hasEmergencyChip) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = '';
                    visibleCount++;
                }
            });
            
            // Update count
            const countElement = document.querySelector('.results-count strong');
            if (countElement) {
                countElement.textContent = visibleCount;
            }
            
            // Show toast
            if (enabled) {
                showToast('🚨 Showing only available emergency services');
            } else {
                showToast('Showing all results');
            }
        }

        // ========================================
        // SEND LOCATION (Feature #12)
        // ========================================
        function sendLocation(businessName, whatsappNumber) {
            if (navigator.geolocation) {
                showToast('📍 Getting your location...');
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const locationUrl = 'https://www.google.com/maps?q=' + lat + ',' + lng;
                        const message = 'Hi, I need service from ' + businessName + '. Here is my location: ' + locationUrl;
                        
                        window.open('https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(message), '_blank');
                    },
                    (error) => {
                        let errorMsg = 'Unable to get location';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMsg = 'Please enable location access in your browser settings';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMsg = 'Location information unavailable';
                                break;
                            case error.TIMEOUT:
                                errorMsg = 'Location request timed out';
                                break;
                        }
                        showToast('❌ ' + errorMsg);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showToast('❌ Geolocation not supported by your browser');
            }
        }

        // ========================================
        // SAVE FOR LATER / WISHLIST (Feature #14)
        // ========================================
        document.querySelectorAll('.card-favorite').forEach(btn => {
            const placeId = btn.dataset.placeId;
            const saved = localStorage.getItem('saved_' + placeId);
            
            // Check if already saved
            if (saved) {
                btn.classList.add('saved');
                btn.querySelector('i').classList.remove('far');
                btn.querySelector('i').classList.add('fas');
            }
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const icon = this.querySelector('i');
                const placeId = this.dataset.placeId;
                
                if (this.classList.contains('saved')) {
                    // Remove from saved
                    this.classList.remove('saved');
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    localStorage.removeItem('saved_' + placeId);
                    showToast('Removed from saved');
                } else {
                    // Add to saved
                    this.classList.add('saved');
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    localStorage.setItem('saved_' + placeId, JSON.stringify({
                        id: placeId,
                        savedAt: new Date().toISOString()
                    }));
                    showToast('❤️ Saved for later');
                }
                
                // Animation
                this.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // ========================================
        // REPORT INCORRECT INFO (Feature #18)
        // ========================================
        function reportBusiness(placeId) {
            const reasons = [
                'Wrong phone number',
                'Business permanently closed',
                'Wrong address/location',
                'Incorrect business name',
                'Spam/Fake listing',
                'Other'
            ];
            
            const reason = prompt(
                'Why is this information incorrect?\n\n' +
                '1. Wrong phone number\n' +
                '2. Business permanently closed\n' +
                '3. Wrong address/location\n' +
                '4. Incorrect business name\n' +
                '5. Spam/Fake listing\n' +
                '6. Other\n\n' +
                'Enter number (1-6):'
            );
            
            if (reason && reason >= 1 && reason <= 6) {
                // Send report to server
                fetch('api/report_business.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        place_id: placeId,
                        reason: reasons[parseInt(reason) - 1],
                        reported_at: new Date().toISOString()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    showToast('✓ Thank you for reporting! We\'ll review this shortly.');
                })
                .catch(error => {
                    // Still show success message even if API fails
                    showToast('✓ Thank you for reporting! We\'ll review this shortly.');
                    console.log('Report submitted locally:', placeId, reasons[parseInt(reason) - 1]);
                });
            }
        }

        // ========================================
        // TOAST NOTIFICATION
        // ========================================
        function showToast(message) {
            // Remove existing toast
            const existing = document.querySelector('.toast-notification');
            if (existing) {
                existing.remove();
            }
            
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            // Auto remove after 2.5 seconds
            setTimeout(() => {
                toast.style.animation = 'slideDown 0.3s ease forwards';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }, 2500);
        }

        // ========================================
        // CALCULATE DISTANCE (Feature #9)
        // ========================================
        function calculateDistances() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        
                        document.querySelectorAll('.business-card').forEach(card => {
                            // Get business coordinates from data attributes or API
                            // For now, we'll show placeholder values
                            const distanceElement = card.querySelector('.distance-value');
                            const timeElement = card.querySelector('.time-value');
                            
                            if (distanceElement && timeElement) {
                                // Generate random distance for demo (replace with actual calculation)
                                const distance = (Math.random() * 5 + 0.5).toFixed(1);
                                const time = Math.ceil(distance * 3);
                                
                                distanceElement.textContent = distance + ' km';
                                timeElement.textContent = time + ' min';
                            }
                        });
                    },
                    (error) => {
                        console.log('Location access denied, showing default distances');
                    }
                );
            }
        }

        // Calculate distances on page load
        calculateDistances();

        // ========================================
        // SCROLL ANIMATIONS
        // ========================================
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 50);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Only apply animations in web view, not app view
        if (!document.body.classList.contains('app-view')) {
            document.querySelectorAll('.business-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.5s ease';
                observer.observe(card);
            });
        }

        // ========================================
        // INITIALIZE
        // ========================================
        handleBackToTop();
        
        // Log page view for analytics
        console.log('Find Business Search Results loaded:', {
            query: '<?= htmlspecialchars($q) ?>',
            location: '<?= htmlspecialchars($location) ?>',
            results: <?= $totalResults ?>,
            timestamp: new Date().toISOString()
        });
    </script>
</body>
</html>
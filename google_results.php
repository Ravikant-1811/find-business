<?php include_once 'app-detect.php'; ?>

<?php
// =============================================
// FIND BUSINESS - SEARCH RESULTS PAGE (OPTIMIZED)
// API ONLY DISPLAY + AUTO SAVE TO DATABASE
// WITH PLACE DETAILS FOR PHONE NUMBERS
// =============================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ============================
// API KEY
// ============================
$API_KEY = "AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU"; // ⚠️ CHANGE THIS

// ============================
// DATABASE CONNECTION (with persistent connection)
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
$user_lat  = $_GET['lat'] ?? '';
$user_lng  = $_GET['lng'] ?? '';

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
// OPTIMIZED: Batch fetch place details using multi-curl
// =============================================
function batchGetPlaceDetails($placeIds, $apiKey) {
    $fields = "place_id,name,formatted_address,formatted_phone_number,international_phone_number,website,url,opening_hours,geometry,photos,rating,user_ratings_total,price_level,types,business_status";
    
    $mh = curl_multi_init();
    $handles = [];
    $results = [];
    
    foreach ($placeIds as $index => $placeId) {
        $detailsUrl = "https://maps.googleapis.com/maps/api/place/details/json?";
        $detailsUrl .= "place_id=" . urlencode($placeId);
        $detailsUrl .= "&fields=" . urlencode($fields);
        $detailsUrl .= "&key=" . $apiKey;
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $detailsUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => 'Mozilla/5.0',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0 // Use HTTP/2
        ]);
        
        curl_multi_add_handle($mh, $ch);
        $handles[$index] = $ch;
    }
    
    // Execute all queries simultaneously
    $running = null;
    do {
        curl_multi_exec($mh, $running);
        curl_multi_select($mh);
    } while ($running > 0);
    
    // Collect results
    foreach ($handles as $index => $ch) {
        $response = curl_multi_getcontent($ch);
        $data = json_decode($response, true);
        
        if ($data['status'] === 'OK' && isset($data['result'])) {
            $results[$index] = $data['result'];
        } else {
            $results[$index] = null;
        }
        
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);
    }
    
    curl_multi_close($mh);
    return $results;
}

// =============================================
// FUNCTION: Calculate Distance between two points
// =============================================
function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit = 'km') {
    if (empty($lat1) || empty($lon1) || empty($lat2) || empty($lon2)) {
        return null;
    }
    
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos(min(1, max(-1, $dist)));
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    
    if ($unit == 'km') {
        return round($miles * 1.609344, 1);
    } else {
        return round($miles, 1);
    }
}

// =============================================
// FUNCTION: Estimate travel time (rough estimate)
// =============================================
function estimateTravelTime($distanceKm, $mode = 'driving') {
    if (empty($distanceKm)) return null;
    
    // Average speeds in km/h
    $speeds = [
        'driving' => 30,  // City driving average
        'walking' => 5,
        'cycling' => 15
    ];
    
    $speed = $speeds[$mode] ?? 30;
    $timeHours = $distanceKm / $speed;
    $timeMinutes = round($timeHours * 60);
    
    if ($timeMinutes < 1) return '< 1 min';
    if ($timeMinutes < 60) return $timeMinutes . ' min';
    
    $hours = floor($timeMinutes / 60);
    $mins = $timeMinutes % 60;
    return $hours . 'h ' . $mins . 'm';
}

// =============================================
// FUNCTION: Format phone for WhatsApp
// =============================================
function formatPhoneForWhatsApp($phone) {
    // Remove all non-numeric characters except +
    $clean = preg_replace('/[^0-9+]/', '', $phone);
    
    // Remove leading + if present
    $clean = ltrim($clean, '+');
    
    // If starts with 0, assume India and replace with 91
    if (substr($clean, 0, 1) === '0') {
        $clean = '91' . substr($clean, 1);
    }
    
    // If doesn't start with country code, add 91 for India
    if (strlen($clean) === 10) {
        $clean = '91' . $clean;
    }
    
    return $clean;
}

// =============================================
// CALL GOOGLE PLACES TEXT SEARCH API
// =============================================
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

// Call API
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Mozilla/5.0',
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0 // Use HTTP/2
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$results  = $data['results'] ?? [];
$nextPage = $data['next_page_token'] ?? "";
$status   = $data['status'] ?? "ERROR";

// =============================================
// OPTIMIZED: Batch fetch all place details at once
// =============================================
$detailedResults = [];

if (!empty($results)) {
    // Extract all place IDs
    $placeIds = array_column($results, 'place_id');
    
    // Batch fetch details for all places
    $detailsArray = batchGetPlaceDetails($placeIds, $API_KEY);
    
    // Merge details with basic search data
    foreach ($results as $index => $place) {
        $details = $detailsArray[$index] ?? null;
        
        if ($details) {
            // Merge basic search data with detailed data
            $mergedPlace = array_merge($place, [
                'formatted_phone_number' => $details['formatted_phone_number'] ?? '',
                'international_phone_number' => $details['international_phone_number'] ?? '',
                'website' => $details['website'] ?? '',
                'url' => $details['url'] ?? '',
                'opening_hours' => $details['opening_hours'] ?? ($place['opening_hours'] ?? []),
                'business_status' => $details['business_status'] ?? 'OPERATIONAL'
            ]);
        } else {
            $mergedPlace = $place;
            $mergedPlace['formatted_phone_number'] = '';
            $mergedPlace['website'] = '';
        }
        
        // Calculate distance if user location is available
        $businessLat = $place['geometry']['location']['lat'] ?? 0;
        $businessLng = $place['geometry']['location']['lng'] ?? 0;
        
        if (!empty($user_lat) && !empty($user_lng)) {
            $distance = calculateDistance($user_lat, $user_lng, $businessLat, $businessLng);
            $mergedPlace['distance_km'] = $distance;
            $mergedPlace['travel_time'] = estimateTravelTime($distance);
        }
        
        $detailedResults[] = $mergedPlace;
    }
}

$results = $detailedResults;

// =============================================
// SAVE API DATA TO DATABASE (Async/Deferred)
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
} elseif ($sort === 'distance') {
    usort($results, function($a, $b) {
        $distA = $a['distance_km'] ?? 9999;
        $distB = $b['distance_km'] ?? 9999;
        return $distA <=> $distB;
    });
}

$totalResults = count($results);

// =============================================
// AUTO SAVE FUNCTION (Updated with phone)
// =============================================
function saveToDatabase($conn, $places, $searchQuery) {
    
    // Check and add missing columns
    $columnsToAdd = [
        'phone' => "ALTER TABLE places ADD COLUMN phone VARCHAR(50) DEFAULT NULL",
        'website' => "ALTER TABLE places ADD COLUMN website VARCHAR(500) DEFAULT NULL",
        'google_maps_url' => "ALTER TABLE places ADD COLUMN google_maps_url VARCHAR(500) DEFAULT NULL"
    ];
    
    foreach ($columnsToAdd as $column => $sql) {
        $checkColumn = $conn->query("SHOW COLUMNS FROM places LIKE '$column'");
        if ($checkColumn && $checkColumn->num_rows == 0) {
            $conn->query($sql);
        }
    }
    
    // Check which columns exist
    $hasPhone = $conn->query("SHOW COLUMNS FROM places LIKE 'phone'")->num_rows > 0;
    $hasWebsite = $conn->query("SHOW COLUMNS FROM places LIKE 'website'")->num_rows > 0;
    $hasGoogleMapsUrl = $conn->query("SHOW COLUMNS FROM places LIKE 'google_maps_url'")->num_rows > 0;
    
    // Build query based on available columns
    if ($hasPhone && $hasWebsite && $hasGoogleMapsUrl) {
        // Full query with all new columns
        $stmt = $conn->prepare(
            "INSERT INTO places
            (place_id, name, address, lat, lng, rating, user_ratings_total,
             price_level, types, photo_reference, phone, website, google_maps_url, search_query)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            address = VALUES(address),
            rating = VALUES(rating),
            user_ratings_total = VALUES(user_ratings_total),
            phone = VALUES(phone),
            website = VALUES(website),
            google_maps_url = VALUES(google_maps_url)"
        );
        
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

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
            $phone    = $place['formatted_phone_number'] ?? '';
            $website  = $place['website'] ?? '';
            $mapsUrl  = $place['url'] ?? '';

            $photo_reference = '';
            if (!empty($place['photos'][0]['photo_reference'])) {
                $photo_reference = $place['photos'][0]['photo_reference'];
            }

            $stmt->bind_param(
                "sssdddiissssss",
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
                $phone,
                $website,
                $mapsUrl,
                $searchQuery
            );
            
            $stmt->execute();
        }
        
        $stmt->close();
        
    } else {
        // Fallback: Original query without new columns
        $stmt = $conn->prepare(
            "INSERT IGNORE INTO places
            (place_id, name, address, lat, lng, rating, user_ratings_total,
             price_level, types, photo_reference, search_query)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

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
    }
    
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

function shortenAddress($fullAddress) {
    $address = preg_replace('/^(SURVEY NO\.|S\.NO\.|PLOT NO\.|NO\.|SHOP NO\.)\s*[\d\-\/]+,?\s*/i', '', $fullAddress);
    $parts = explode(',', $address);
    $meaningful = [];
    foreach ($parts as $part) {
        $part = trim($part);
        if (strlen($part) > 3 && !preg_match('/^[\d\-\/\s]+$/', $part)) {
            $meaningful[] = $part;
            if (count($meaningful) >= 2) break;
        }
    }
    if (count($meaningful) > 0) {
        return implode(', ', $meaningful);
    }
    return strlen($fullAddress) > 40 ? substr($fullAddress, 0, 40) . '...' : $fullAddress;
}

function isEmergencyCategory($type) {
    $emergencyTypes = ['hospital', 'doctor', 'pharmacy', 'clinic', 'health', 'dentist', 'physiotherapist'];
    return in_array(strtolower($type), $emergencyTypes);
}

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
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="stylesheet" href="/assets/css/google.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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

            <!-- Location Status -->
            <div class="location-status" id="locationStatus">
                <i class="fas fa-spinner fa-spin"></i>
                <span>Getting your location...</span>
            </div>

            <p class="search-header-subtitle">
                <?php if ($totalResults > 0): ?>
                Found <strong><?= number_format($totalResults) ?></strong> businesses matching your search
                <?php else: ?>
                No businesses found for your search. Try different keywords.
                <?php endif; ?>
            </p>

            <form class="search-box-main" action="google_results.php" method="GET" id="searchForm">
                <input type="hidden" name="lat" id="searchLat" value="<?= htmlspecialchars($user_lat) ?>">
                <input type="hidden" name="lng" id="searchLng" value="<?= htmlspecialchars($user_lng) ?>">
                
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
                        <input type="hidden" name="lat" id="filterLat" value="<?= htmlspecialchars($user_lat) ?>">
                        <input type="hidden" name="lng" id="filterLng" value="<?= htmlspecialchars($user_lng) ?>">

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
                                    'distance' => 'Nearest First',
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
                            <div class="sort-option <?= $sort == 'distance' ? 'active' : '' ?>" data-sort="distance">
                                <i class="fas fa-location-arrow"></i>
                                Nearest First
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
                    
                    // Phone number from Place Details API
                    $phoneNumber = $business['formatted_phone_number'] ?? '';
                    $internationalPhone = $business['international_phone_number'] ?? '';
                    $hasPhone = !empty($phoneNumber);
                    
                    // Format for WhatsApp
                    $whatsappNumber = '';
                    if ($hasPhone) {
                        $whatsappNumber = formatPhoneForWhatsApp($internationalPhone ?: $phoneNumber);
                    }
                    
                    // Website
                    $website = $business['website'] ?? '';
                    $googleMapsUrl = $business['url'] ?? '';
                    
                    // Photo count
                    $photoCount = count($business['photos'] ?? []);
                    if ($photoCount == 0) $photoCount = 1;
                    
                    // Full and short address
                    $fullAddress = $business['formatted_address'] ?? 'Address not available';
                    $shortAddress = shortenAddress($fullAddress);
                    
                    // Business coordinates for directions
                    $businessLat = $business['geometry']['location']['lat'] ?? 0;
                    $businessLng = $business['geometry']['location']['lng'] ?? 0;
                    
                    // Distance (from PHP calculation or will be updated by JS)
                    $distanceKm = $business['distance_km'] ?? null;
                    $travelTime = $business['travel_time'] ?? null;
                    
                    // SEO URL
                    $slugName = makeSlug($business['name']);
                    $seoUrl = "business/" . $slugName . "-" . $business['place_id'];
                    
                    // Check if emergency category
                    $isEmergencyType = isEmergencyCategory($formattedType) || isUrgentServiceCategory($formattedType);
                    
                    // Business status
                    $businessStatus = $business['business_status'] ?? 'OPERATIONAL';
                    $isPermanentlyClosed = ($businessStatus === 'CLOSED_PERMANENTLY');
                ?>
                <article class="business-card" 
                         data-index="<?= $index ?>" 
                         data-place-id="<?= htmlspecialchars($business['place_id']) ?>"
                         data-lat="<?= $businessLat ?>"
                         data-lng="<?= $businessLng ?>"
                         data-name="<?= htmlspecialchars($business['name']) ?>">
                    <!-- Card Image Section -->
                    <div class="card-image">
                        <img src="<?= htmlspecialchars($photo) ?>" alt="<?= htmlspecialchars($business['name']) ?>" loading="lazy">
                        <div class="card-image-overlay"></div>
                        
                        <!-- Top Badges -->
                        <div class="card-badges">
                            <div class="card-badges-left">
                                <?php if ($isPermanentlyClosed): ?>
                                <span class="card-badge closed">
                                    <i class="fas fa-times-circle"></i> Permanently Closed
                                </span>
                                <?php elseif ($isOpen === true): ?>
                                <span class="card-badge open">
                                    <i class="fas fa-clock"></i> Open Now
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
                            <?= $photoCount ?> Photo<?= $photoCount > 1 ? 's' : '' ?>
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

                        <!-- Distance Badge (will be updated by JavaScript) -->
                        <div class="distance-badge <?= empty($distanceKm) ? 'loading' : '' ?>" id="distance-<?= $index ?>">
                            <i class="fas fa-location-arrow"></i>
                            <span class="distance-value"><?= $distanceKm ? $distanceKm . ' km' : 'Calculating...' ?></span>
                            <span class="separator"></span>
                            <i class="fas fa-car"></i>
                            <span class="time-value"><?= $travelTime ?: '...' ?></span>
                        </div>

                        <!-- Shortened Address -->
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

                        <!-- Facility Chips -->
                        <div class="card-facility-chips">
                            <span class="facility-chip feature">
                                <i class="fas <?= $typeIcon ?>"></i>
                                <?= htmlspecialchars($formattedType) ?>
                            </span>
                            
                            <?php if ($isOpen === true && $isEmergencyType): ?>
                            <span class="facility-chip emergency">
                                <i class="fas fa-bolt"></i>
                                Available Now
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

                            <?php if ($website): ?>
                            <span class="facility-chip feature">
                                <i class="fas fa-globe"></i>
                                Website
                            </span>
                            <?php endif; ?>
                        </div>

                        <!-- Direct Contact Buttons -->
                        <?php if ($hasPhone): ?>
                        <div class="card-direct-contact">
                            <!-- Call Button -->
                            <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $phoneNumber)) ?>" class="contact-btn call-btn">
                                <i class="fas fa-phone-alt"></i>
                                <span class="phone-number"><?= htmlspecialchars($phoneNumber) ?></span>
                            </a>
                            
                            <!-- WhatsApp Button -->
                            <a href="https://wa.me/<?= htmlspecialchars($whatsappNumber) ?>?text=<?= urlencode("Hi, I found your business '" . $business['name'] . "' on Find Business. I need more information.") ?>" 
                               class="contact-btn whatsapp-btn" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="no-phone-msg">
                            <i class="fas fa-info-circle"></i>
                            Phone number not available. Use directions to visit.
                        </div>
                        <?php endif; ?>

                        <!-- Send Location Button (only if phone available) -->
                        <?php if ($hasPhone): ?>
                        <button class="send-location-btn" onclick="sendLocation('<?= htmlspecialchars(addslashes($business['name'])) ?>', '<?= htmlspecialchars($whatsappNumber) ?>')">
                            <i class="fas fa-map-pin"></i>
                            Send My Location via WhatsApp
                        </button>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="card-actions">
                            <a href="<?= $seoUrl ?>" class="card-btn primary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                            
                            <!-- Directions Button - Opens Google Maps with user's current location -->
                            <a href="#" 
                               class="card-btn directions" 
                               onclick="getDirections(<?= $businessLat ?>, <?= $businessLng ?>, '<?= htmlspecialchars(addslashes($business['name'])) ?>'); return false;">
                                <i class="fas fa-directions"></i>
                                Directions
                            </a>
                        </div>

                        <!-- Website Link (if available) -->
                        <?php if ($website): ?>
                        <div style="margin-top: 10px;">
                            <a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener" 
                               style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: var(--info); font-weight: 500;">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Website
                            </a>
                        </div>
                        <?php endif; ?>

                        <!-- Share & Report Section -->
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
                <a href="google_results.php?q=<?= urlencode($q) ?>&location=<?= urlencode($location) ?>&pagetoken=<?= urlencode($nextPage) ?>&sort=<?= urlencode($sort) ?>&rating=<?= urlencode($rating) ?>&open_now=<?= urlencode($open_now) ?>&type=<?= urlencode($type) ?>&lat=<?= urlencode($user_lat) ?>&lng=<?= urlencode($user_lng) ?>" class="load-more-btn">
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
        // GLOBAL VARIABLES
        // ========================================
        let userLat = <?= !empty($user_lat) ? floatval($user_lat) : 'null' ?>;
        let userLng = <?= !empty($user_lng) ? floatval($user_lng) : 'null' ?>;
        let locationObtained = <?= (!empty($user_lat) && !empty($user_lng)) ? 'true' : 'false' ?>;

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
        const locationStatus = document.getElementById('locationStatus');

        // ========================================
        // GET USER LOCATION ON PAGE LOAD
        // ========================================
        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;
                        locationObtained = true;
                        
                        // Update location status
                        locationStatus.innerHTML = '<i class="fas fa-check-circle"></i> <span>Location detected - Distances calculated</span>';
                        locationStatus.classList.remove('error');
                        
                        // Update hidden form fields
                        document.getElementById('searchLat').value = userLat;
                        document.getElementById('searchLng').value = userLng;
                        document.getElementById('filterLat').value = userLat;
                        document.getElementById('filterLng').value = userLng;
                        
                        // Calculate distances for all cards
                        calculateAllDistances();
                        
                        // Store in session for future use
                        sessionStorage.setItem('userLat', userLat);
                        sessionStorage.setItem('userLng', userLng);
                    },
                    (error) => {
                        let errorMsg = 'Location access denied';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMsg = 'Location access denied. Enable to see distances.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMsg = 'Location unavailable';
                                break;
                            case error.TIMEOUT:
                                errorMsg = 'Location request timed out';
                                break;
                        }
                        
                        locationStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>' + errorMsg + '</span>';
                        locationStatus.classList.add('error');
                        
                        // Try to get from session storage
                        const storedLat = sessionStorage.getItem('userLat');
                        const storedLng = sessionStorage.getItem('userLng');
                        if (storedLat && storedLng) {
                            userLat = parseFloat(storedLat);
                            userLng = parseFloat(storedLng);
                            locationObtained = true;
                            calculateAllDistances();
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 300000 // 5 minutes cache
                    }
                );
            } else {
                locationStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>Geolocation not supported</span>';
                locationStatus.classList.add('error');
            }
        }

        // ========================================
        // CALCULATE DISTANCE (Haversine Formula)
        // ========================================
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of Earth in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return (R * c).toFixed(1);
        }

        // ========================================
        // ESTIMATE TRAVEL TIME
        // ========================================
        function estimateTravelTime(distanceKm) {
            // Assume average city speed of 25-30 km/h
            const avgSpeed = 28;
            const timeMinutes = Math.round((distanceKm / avgSpeed) * 60);
            
            if (timeMinutes < 1) return '< 1 min';
            if (timeMinutes < 60) return timeMinutes + ' min';
            
            const hours = Math.floor(timeMinutes / 60);
            const mins = timeMinutes % 60;
            return hours + 'h ' + mins + 'm';
        }

        // ========================================
        // CALCULATE DISTANCES FOR ALL CARDS
        // ========================================
        function calculateAllDistances() {
            if (!locationObtained || !userLat || !userLng) return;
            
            document.querySelectorAll('.business-card').forEach((card, index) => {
                const businessLat = parseFloat(card.dataset.lat);
                const businessLng = parseFloat(card.dataset.lng);
                
                if (businessLat && businessLng) {
                    const distance = calculateDistance(userLat, userLng, businessLat, businessLng);
                    const travelTime = estimateTravelTime(parseFloat(distance));
                    
                    const distanceBadge = document.getElementById('distance-' + index);
                    if (distanceBadge) {
                        distanceBadge.classList.remove('loading');
                        distanceBadge.querySelector('.distance-value').textContent = distance + ' km';
                        distanceBadge.querySelector('.time-value').textContent = travelTime;
                    }
                    
                    // Store for sorting
                    card.dataset.distance = distance;
                }
            });
        }

        // ========================================
        // GET DIRECTIONS (Opens Google Maps from current location)
        // ========================================
        function getDirections(destLat, destLng, businessName) {
            if (locationObtained && userLat && userLng) {
                // Open Google Maps with directions from current location to destination
                const url = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${destLat},${destLng}&travelmode=driving`;
                window.open(url, '_blank');
            } else {
                // Get location first, then open directions
                if (navigator.geolocation) {
                    showToast('📍 Getting your location...');
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            const url = `https://www.google.com/maps/dir/?api=1&origin=${lat},${lng}&destination=${destLat},${destLng}&travelmode=driving`;
                            window.open(url, '_blank');
                        },
                        (error) => {
                            // Fallback: Open without origin (user can set manually)
                            showToast('⚠️ Could not get your location. Opening destination only.');
                            const url = `https://www.google.com/maps/dir/?api=1&destination=${destLat},${destLng}&travelmode=driving`;
                            window.open(url, '_blank');
                        },
                        { enableHighAccuracy: true, timeout: 5000 }
                    );
                } else {
                    // No geolocation support - open destination only
                    const url = `https://www.google.com/maps/dir/?api=1&destination=${destLat},${destLng}&travelmode=driving`;
                    window.open(url, '_blank');
                }
            }
        }

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
                
                // Add lat/lng if available
                if (userLat && userLng) {
                    url.searchParams.set('lat', userLat);
                    url.searchParams.set('lng', userLng);
                }
                
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
            if (userLat && userLng) {
                newUrl += '&lat=' + userLat + '&lng=' + userLng;
            }
            window.location.href = newUrl;
        }

        // ========================================
        // TOGGLE FULL ADDRESS
        // ========================================
        function toggleFullAddress(element) {
            const popup = element.nextElementSibling;
            
            popup.classList.toggle('show');
            
            if (popup.classList.contains('show')) {
                element.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Full Address';
            } else {
                element.innerHTML = '<i class="fas fa-chevron-down"></i> View Full Address';
            }
        }

        // ========================================
        // SOCIAL SHARE FUNCTIONS
        // ========================================
        function shareOnFacebook(url) {
            const fullUrl = window.location.origin + '/' + url;
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(fullUrl), '_blank', 'width=600,height=400');
        }

        function shareOnTwitter(url, title) {
            const fullUrl = window.location.origin + '/' + url;
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(fullUrl) + '&text=' + encodeURIComponent('Check out ' + title + ' on Find Business!'), '_blank', 'width=600,height=400');
        }

        function shareOnWhatsApp(url, title) {
            const fullUrl = window.location.origin + '/' + url;
            window.open('https://wa.me/?text=' + encodeURIComponent('Check out ' + title + ' on Find Business! ' + fullUrl), '_blank');
        }

        function copyLink(url) {
            const fullUrl = window.location.origin + '/' + url;
            navigator.clipboard.writeText(fullUrl).then(() => {
                showToast('✓ Link copied to clipboard!');
            }).catch(() => {
                const textArea = document.createElement('textarea');
                textArea.value = fullUrl;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('✓ Link copied to clipboard!');
            });
        }

        // ========================================
        // EMERGENCY TOGGLE FILTER
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
            
            const countElement = document.querySelector('.results-count strong');
            if (countElement) {
                countElement.textContent = visibleCount;
            }
            
            if (enabled) {
                showToast('🚨 Showing only available emergency services');
            } else {
                showToast('Showing all results');
            }
        }

        // ========================================
        // SEND LOCATION VIA WHATSAPP
        // ========================================
        function sendLocation(businessName, whatsappNumber) {
            if (navigator.geolocation) {
                showToast('📍 Getting your location...');
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const locationUrl = 'https://www.google.com/maps?q=' + lat + ',' + lng;
                        const message = 'Hi, I need service from ' + businessName + '. Here is my current location: ' + locationUrl;
                        
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
        // SAVE FOR LATER / WISHLIST
        // ========================================
        document.querySelectorAll('.card-favorite').forEach(btn => {
            const placeId = btn.dataset.placeId;
            const saved = localStorage.getItem('saved_' + placeId);
            
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
                    this.classList.remove('saved');
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    localStorage.removeItem('saved_' + placeId);
                    showToast('Removed from saved');
                } else {
                    this.classList.add('saved');
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    localStorage.setItem('saved_' + placeId, JSON.stringify({
                        id: placeId,
                        savedAt: new Date().toISOString()
                    }));
                    showToast('❤️ Saved for later');
                }
                
                this.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // ========================================
        // REPORT INCORRECT INFO
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
                console.log('Report submitted:', placeId, reasons[parseInt(reason) - 1]);
                showToast('✓ Thank you for reporting! We\'ll review this shortly.');
            }
        }

        // ========================================
        // TOAST NOTIFICATION
        // ========================================
        function showToast(message) {
            const existing = document.querySelector('.toast-notification');
            if (existing) {
                existing.remove();
            }
            
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
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
        document.addEventListener('DOMContentLoaded', function() {
            // Get user location
            getUserLocation();
            
            // Initialize other functions
            handleBackToTop();
            
            console.log('Find Business Search Results loaded:', {
                query: '<?= htmlspecialchars($q) ?>',
                location: '<?= htmlspecialchars($location) ?>',
                results: <?= $totalResults ?>,
                timestamp: new Date().toISOString()
            });
        });
    </script>
</body>
</html>
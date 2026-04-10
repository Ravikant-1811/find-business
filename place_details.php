<?php include_once 'app-detect.php'; ?>

<?php
// =============================================
// GOOGLE PLACE DETAILS PAGE WITH AUTO-SAVE
// =============================================

require_once 'config.php';

$API_KEY = "AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU"; // ADD YOUR SERVER KEY

$place_id = $_GET['place_id'] ?? '';

// Get user location for distance calculation
$user_lat = $_GET['user_lat'] ?? ($_COOKIE['user_lat'] ?? null);
$user_lng = $_GET['user_lng'] ?? ($_COOKIE['user_lng'] ?? null);

if (!$place_id) {
    header("Location: index.php");
    exit;
}

// =============================================
// HELPER: Calculate Distance Between Two Points
// =============================================
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    if (!$lat1 || !$lon1 || !$lat2 || !$lon2) return null;
    
    $earthRadius = 6371; // km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}

// =============================================
// HELPER: Estimate Travel Time
// =============================================
function estimateTravelTime($distanceKm) {
    if (!$distanceKm) return null;
    
    // Assume average speed of 25 km/h in city
    $minutes = round(($distanceKm / 25) * 60);
    
    if ($minutes < 1) return "1 min";
    if ($minutes < 60) return $minutes . " min";
    
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours . " hr " . ($mins > 0 ? $mins . " min" : "");
}

// =============================================
// HELPER: Shorten Address
// =============================================
function shortenAddress($fullAddress, $vicinity = '') {
    if ($vicinity && strlen($vicinity) < strlen($fullAddress)) {
        return $vicinity;
    }
    
    // Try to extract key parts
    $parts = explode(',', $fullAddress);
    if (count($parts) >= 3) {
        // Take 2nd and 3rd parts usually contain locality info
        $short = trim($parts[1]) . ', ' . trim($parts[2]);
        // Remove postal codes
        $short = preg_replace('/\d{6}/', '', $short);
        return trim($short, ', ');
    }
    
    // If address is too long, truncate
    if (strlen($fullAddress) > 50) {
        return substr($fullAddress, 0, 47) . '...';
    }
    
    return $fullAddress;
}

// =============================================
// FUNCTION TO SAVE PLACE TO DATABASE
// =============================================
function savePlace($conn, $place) {
    // Extract city and state
    $city = '';
    $state = '';
    if (!empty($place['address_components'])) {
        foreach ($place['address_components'] as $component) {
            if (in_array('locality', $component['types'])) {
                $city = $component['long_name'];
            }
            if (in_array('administrative_area_level_1', $component['types'])) {
                $state = $component['short_name'];
            }
        }
    }
    
    // Get primary type
    $primaryType = 'Business';
    $excludeTypes = ['point_of_interest', 'establishment', 'premise', 'political'];
    if (!empty($place['types'])) {
        foreach ($place['types'] as $type) {
            if (!in_array($type, $excludeTypes)) {
                $primaryType = ucwords(str_replace('_', ' ', $type));
                break;
            }
        }
    }
    
    // Prepare data
    $place_id = $place['place_id'];
    $name = $place['name'] ?? 'Unknown';

    // SAFE SLUG
    if (!empty($name) && !empty($place_id)) {
        $slugName = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name)));
        $slugName = trim($slugName, '-');
    } else {
        $slugName = 'business';
    }

    $seoUrl = "https://find-business.com/business/" . $slugName . "-" . $place_id;

    $formatted_address = $place['formatted_address'] ?? null;
    $vicinity = $place['vicinity'] ?? null;
    $phone = $place['formatted_phone_number'] ?? null;
    $international_phone = $place['international_phone_number'] ?? null;
    $website = $place['website'] ?? null;
    $rating = $place['rating'] ?? 0;
    $total_ratings = $place['user_ratings_total'] ?? 0;
    $price_level = $place['price_level'] ?? null;
    $types = !empty($place['types']) ? json_encode($place['types']) : null;
    $latitude = $place['geometry']['location']['lat'] ?? null;
    $longitude = $place['geometry']['location']['lng'] ?? null;
    $business_status = $place['business_status'] ?? 'OPERATIONAL';
    $google_url = $place['url'] ?? null;
    $opening_hours = !empty($place['opening_hours']) ? json_encode($place['opening_hours']) : null;
    $photos = !empty($place['photos']) ? json_encode($place['photos']) : null;
    $reviews = !empty($place['reviews']) ? json_encode($place['reviews']) : null;
    $is_open_now = isset($place['opening_hours']['open_now']) ? ($place['opening_hours']['open_now'] ? 1 : 0) : null;
    
    // Check if exists in data_places
    $checkSql = "SELECT id FROM data_places WHERE place_id = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "s", $place_id);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $exists = mysqli_fetch_assoc($result);
    mysqli_stmt_close($checkStmt);
    
    if ($exists) {
        // UPDATE existing record
        $sql = "UPDATE data_places SET 
            name = ?, formatted_address = ?, vicinity = ?, city = ?, state = ?,
            phone = ?, international_phone = ?, website = ?, rating = ?, total_ratings = ?,
            price_level = ?, types = ?, primary_type = ?, latitude = ?, longitude = ?,
            business_status = ?, google_url = ?, opening_hours = ?, photos = ?, reviews = ?,
            is_open_now = ?, updated_at = NOW()
            WHERE place_id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssdiissddsssssis",
            $name, $formatted_address, $vicinity, $city, $state,
            $phone, $international_phone, $website, $rating, $total_ratings,
            $price_level, $types, $primaryType, $latitude, $longitude,
            $business_status, $google_url, $opening_hours, $photos, $reviews,
            $is_open_now, $place_id
        );
    } else {
        // INSERT new record
        $sql = "INSERT INTO data_places (
            place_id, name, formatted_address, vicinity, city, state,
            phone, international_phone, website, rating, total_ratings,
            price_level, types, primary_type, latitude, longitude,
            business_status, google_url, opening_hours, photos, reviews, is_open_now
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssssdissddssssssi",
            $place_id, $name, $formatted_address, $vicinity, $city, $state,
            $phone, $international_phone, $website, $rating, $total_ratings,
            $price_level, $types, $primaryType, $latitude, $longitude,
            $business_status, $google_url, $opening_hours, $photos, $reviews, $is_open_now
        );
    }
    
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return $success;
}

// =============================================
// FUNCTION TO LOG CONTACT/CALL
// =============================================
function logContact($conn, $place_id, $user_id, $contact_type) {
    $sql = "INSERT INTO contact_logs (place_id, user_id, contact_type, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sis", $place_id, $user_id, $contact_type);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// =============================================
// FUNCTION TO CHECK IF BUSINESS HAS WHATSAPP
// =============================================
function hasWhatsApp($conn, $place_id) {
    $sql = "SELECT whatsapp_number, whatsapp_enabled FROM business_details WHERE place_id = ? AND whatsapp_enabled = 1";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $place_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row;
    }
    return null;
}

// =============================================
// FUNCTION TO GET CUSTOM BUSINESS TAGS
// =============================================
function getBusinessTags($conn, $place_id) {
    $sql = "SELECT tags FROM business_details WHERE place_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $place_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        if ($row && $row['tags']) {
            return json_decode($row['tags'], true) ?? [];
        }
    }
    return [];
}

// =============================================
// FUNCTION TO GET SIMILAR/RELATED BUSINESSES
// =============================================
function getSimilarBusinesses($conn, $place_id, $primaryType, $city, $limit = 6) {
    $sql = "SELECT * FROM data_places 
            WHERE place_id != ? 
            AND (primary_type = ? OR city = ?)
            AND business_status = 'OPERATIONAL'
            ORDER BY rating DESC, total_ratings DESC
            LIMIT ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $place_id, $primaryType, $city, $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $businesses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $businesses[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $businesses;
    }
    return [];
}

// =============================================
// FUNCTION TO CHECK USER'S PREVIOUS CONTACT
// =============================================
function getUserPreviousContact($conn, $place_id, $user_id) {
    if (!$user_id) return null;
    
    $sql = "SELECT contact_type, created_at FROM contact_logs 
            WHERE place_id = ? AND user_id = ? 
            ORDER BY created_at DESC LIMIT 1";
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $place_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row;
    }
    return null;
}

// =============================================
// FUNCTION TO CHECK IF SAVED
// =============================================
function isBusinessSaved($conn, $place_id, $user_id) {
    if (!$user_id) return false;
    
    $sql = "SELECT id FROM saved_businesses WHERE place_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $place_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $saved = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $saved ? true : false;
    }
    return false;
}

// =============================================
// FETCH PLACE DETAILS FROM API
// =============================================
$fields = "place_id,name,formatted_address,formatted_phone_number,international_phone_number,geometry,opening_hours,photos,rating,reviews,types,url,user_ratings_total,website,price_level,address_components,business_status,vicinity";

$detailsUrl = "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . urlencode($place_id) . "&fields=" . urlencode($fields) . "&key=" . $API_KEY;

$response = @file_get_contents($detailsUrl);
$data = json_decode($response, true);

if ($data['status'] !== 'OK' || empty($data['result'])) {
    $error = true;
    $errorMessage = $data['status'] ?? 'Unable to fetch business details';
} else {
    $error = false;
    $place = $data['result'];

    // ===============================
    // SEO SLUG + REDIRECT
    // ===============================
    $name = $place['name'] ?? 'Business';

    if (!empty($name) && !empty($place_id)) {
        $slugName = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name)));
        $slugName = trim($slugName, '-');
    } else {
        $slugName = 'business';
    }

    $seoUrl = "https://find-business.com/business/" . $slugName . "-" . $place_id;

    // FORCE REDIRECT ONLY IF USER IS ON OLD URL
    if (strpos($_SERVER['REQUEST_URI'], 'place_details') !== false) {
        header("Location: $seoUrl", true, 301);
        exit;
    }

    // AUTO-SAVE TO DATABASE
    $saved = savePlace($conn, $place);
    
    // Get WhatsApp info
    $whatsappInfo = hasWhatsApp($conn, $place_id);
    $hasWhatsapp = $whatsappInfo ? true : false;
    $whatsappNumber = $whatsappInfo['whatsapp_number'] ?? null;
    
    // Get custom business tags
    $customTags = getBusinessTags($conn, $place_id);
    
    // Get user session
    $user_id = $_SESSION['user_id'] ?? null;
    
    // Check previous contact
    $previousContact = getUserPreviousContact($conn, $place_id, $user_id);
    
    // Check if saved
    $isSaved = isBusinessSaved($conn, $place_id, $user_id);
}

// Helper Functions
function getPhotoUrl($photoRef, $apiKey, $maxWidth = 800) {
    if ($photoRef) {
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photoreference=" . $photoRef . "&key=" . $apiKey;
    }
    return "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=500&fit=crop";
}

function getTypeIcon($types) {
    $iconMap = [
        'restaurant' => 'fa-utensils',
        'food' => 'fa-utensils',
        'cafe' => 'fa-coffee',
        'hotel' => 'fa-hotel',
        'lodging' => 'fa-bed',
        'hospital' => 'fa-hospital',
        'doctor' => 'fa-user-md',
        'health' => 'fa-heartbeat',
        'school' => 'fa-graduation-cap',
        'university' => 'fa-university',
        'store' => 'fa-store',
        'shopping' => 'fa-shopping-bag',
        'gym' => 'fa-dumbbell',
        'spa' => 'fa-spa',
        'beauty' => 'fa-cut',
        'car' => 'fa-car',
        'gas_station' => 'fa-gas-pump',
        'bank' => 'fa-university',
        'atm' => 'fa-credit-card',
        'pharmacy' => 'fa-pills',
        'lawyer' => 'fa-balance-scale',
        'real_estate' => 'fa-home',
        'electronics' => 'fa-laptop',
        'park' => 'fa-tree',
        'movie_theater' => 'fa-film',
        'bar' => 'fa-glass-martini-alt',
        'plumber' => 'fa-wrench',
        'electrician' => 'fa-bolt',
    ];
    
    if ($types) {
        foreach ($types as $type) {
            if (isset($iconMap[$type])) {
                return $iconMap[$type];
            }
        }
    }
    return 'fa-building';
}

function formatType($types) {
    if (empty($types)) return 'Business';
    $excludeTypes = ['point_of_interest', 'establishment', 'premise', 'political'];
    foreach ($types as $type) {
        if (!in_array($type, $excludeTypes)) {
            return ucwords(str_replace('_', ' ', $type));
        }
    }
    return 'Business';
}

function getPriceLevel($level) {
    $prices = ['Free', '₹', '₹₹', '₹₹₹', '₹₹₹₹'];
    return $prices[$level] ?? '';
}

function getBusinessStatus($status) {
    $statuses = [
        'OPERATIONAL' => ['text' => 'Operational', 'color' => '#10b981', 'icon' => 'fa-check-circle'],
        'CLOSED_TEMPORARILY' => ['text' => 'Temporarily Closed', 'color' => '#f59e0b', 'icon' => 'fa-clock'],
        'CLOSED_PERMANENTLY' => ['text' => 'Permanently Closed', 'color' => '#ef4444', 'icon' => 'fa-times-circle'],
    ];
    return $statuses[$status] ?? ['text' => 'Unknown', 'color' => '#64748b', 'icon' => 'fa-question-circle'];
}

function timeAgo($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    if ($diff < 2592000) return floor($diff / 604800) . ' weeks ago';
    if ($diff < 31536000) return floor($diff / 2592000) . ' months ago';
    return floor($diff / 31536000) . ' years ago';
}

// Check if emergency category
function isEmergencyCategory($types) {
    $emergencyTypes = ['hospital', 'doctor', 'pharmacy', 'veterinary_care', 'police', 'fire_station'];
    if ($types) {
        foreach ($types as $type) {
            if (in_array($type, $emergencyTypes)) {
                return true;
            }
        }
    }
    return false;
}

// Extract place data if available
if (!$error) {
    $name = $place['name'] ?? 'Unknown Business';
    
    if (!empty($name) && !empty($place_id)) {
        $slugName = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name)));
        $slugName = trim($slugName, '-');
    } else {
        $slugName = 'business';
    }

    $seoUrl = "https://find-business.com/business/" . $slugName . "-" . $place_id;

    $address = $place['formatted_address'] ?? 'Address not available';
    $shortAddress = shortenAddress($address, $place['vicinity'] ?? '');
    $phone = $place['formatted_phone_number'] ?? null;
    $intlPhone = $place['international_phone_number'] ?? null;
    // Clean phone for direct calling
    $cleanPhone = preg_replace('/[^0-9+]/', '', $intlPhone ?? $phone ?? '');
    $website = $place['website'] ?? null;
    $rating = $place['rating'] ?? 0;
    $totalRatings = $place['user_ratings_total'] ?? 0;
    $priceLevel = $place['price_level'] ?? null;
    $types = $place['types'] ?? [];
    $photos = $place['photos'] ?? [];
    $photoCount = count($photos);
    $reviews = $place['reviews'] ?? [];
    $hours = $place['opening_hours'] ?? null;
    $isOpen = $hours['open_now'] ?? null;
    $weekdayText = $hours['weekday_text'] ?? [];
    $googleUrl = $place['url'] ?? '#';
    $lat = $place['geometry']['location']['lat'] ?? 0;
    $lng = $place['geometry']['location']['lng'] ?? 0;
    $businessStatus = $place['business_status'] ?? 'OPERATIONAL';
    $vicinity = $place['vicinity'] ?? '';
    
    $typeIcon = getTypeIcon($types);
    $formattedType = formatType($types);
    $statusInfo = getBusinessStatus($businessStatus);
    $isEmergency = isEmergencyCategory($types);
    
    // Calculate distance if user location available
    $distance = null;
    $travelTime = null;
    if ($user_lat && $user_lng && $lat && $lng) {
        $distance = calculateDistance($user_lat, $user_lng, $lat, $lng);
        $travelTime = estimateTravelTime($distance);
    }
    
    // Calculate star ratings
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    
    // Get city from address components
    $city = '';
    $state = '';
    if (!empty($place['address_components'])) {
        foreach ($place['address_components'] as $component) {
            if (in_array('locality', $component['types'])) {
                $city = $component['long_name'];
            }
            if (in_array('administrative_area_level_1', $component['types'])) {
                $state = $component['short_name'];
            }
        }
    }
    
    // Get similar businesses
    $similarBusinesses = getSimilarBusinesses($conn, $place_id, $formattedType, $city, 6);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $error ? 'Business Not Found' : htmlspecialchars($name) ?> - Find Business</title>
    <meta name="description" content="<?= $error ? 'Business not found' : htmlspecialchars($name . ' - ' . $formattedType . ' in ' . $address) ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($name ?? 'Find Business') ?>">
    <meta property="og:description" content="<?= $error ? 'Business not found' : htmlspecialchars($formattedType . ' in ' . $address) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($seoUrl ?? '') ?>">
    <meta property="og:type" content="business.business">
    <?php if (!$error && !empty($photos)): ?>
    <meta property="og:image" content="<?= getPhotoUrl($photos[0]['photo_reference'], $API_KEY) ?>">
    <?php endif; ?>
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($name ?? 'Find Business') ?>">
    <meta name="twitter:description" content="<?= $error ? 'Business not found' : htmlspecialchars($formattedType . ' in ' . $shortAddress) ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="canonical" href="<?= htmlspecialchars($seoUrl ?? '') ?>">
    
    <!-- Preconnect for faster loading -->
    <link rel="preconnect" href="https://maps.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Critical CSS inline for faster FCP -->
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:#f8fafc}
        .loading-skeleton{background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:loading 1.5s infinite}
        @keyframes loading{0%{background-position:200% 0}100%{background-position:-200% 0}}
    </style>
    <link rel="stylesheet" href="/assets/css/place.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<?= htmlspecialchars($name ?? '') ?>",
      "image": "<?= !empty($photos) ? getPhotoUrl($photos[0]['photo_reference'], $API_KEY) : '' ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= htmlspecialchars($address ?? '') ?>",
        "addressLocality": "<?= htmlspecialchars($city ?? '') ?>",
        "addressRegion": "<?= htmlspecialchars($state ?? '') ?>",
        "addressCountry": "IN"
      },
      <?php if ($phone): ?>
      "telephone": "<?= htmlspecialchars($phone) ?>",
      <?php endif; ?>
      <?php if ($website): ?>
      "url": "<?= htmlspecialchars($website) ?>",
      <?php endif; ?>
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "<?= $lat ?>",
        "longitude": "<?= $lng ?>"
      },
      <?php if ($rating > 0): ?>
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?= $rating ?>",
        "reviewCount": "<?= $totalRatings ?>"
      },
      <?php endif; ?>
      "priceRange": "<?= getPriceLevel($priceLevel ?? 0) ?>"
    }
    </script>

</head>
<body class="<?php echo $isApp ? 'app-view' : 'web-view'; ?>">

    <!-- OFFLINE BANNER -->
    <div class="offline-banner" id="offlineBanner">
        <i class="fas fa-wifi-slash"></i> You're offline. Showing cached data.
    </div>

    <!-- NAVBAR -->
    <?php include 'header.php';?>

    <?php if ($error): ?>
    <!-- ERROR STATE -->
    <div class="error-section">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1>Business Not Found</h1>
        <p>We couldn't find the business you're looking for. It may have been removed or the link is incorrect.</p>
        <a href="index.php" class="btn btn-primary btn-lg">
            <i class="fas fa-home"></i>
            Back to Home
        </a>
    </div>

    <?php else: ?>

    <!-- GALLERY SECTION -->
    <section class="hero-gallery">
        <div class="gallery-container">
            <?php if (!$isApp): ?>
            <nav class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="google_results.php?q=<?= urlencode($formattedType) ?>">
                    <?= htmlspecialchars($formattedType) ?>
                </a>
                <i class="fas fa-chevron-right"></i>
                <span><?= htmlspecialchars($name) ?></span>
            </nav>
            <?php endif; ?>
        </div>

        <!-- FULL WIDTH IMAGE SLIDER -->
        <div class="full-width-slider">
            <div class="gallery-main slider" id="imageSlider">
                <?php if (!empty($photos)): ?>
                    <?php foreach ($photos as $index => $photo): ?>
                        <div class="slide" onclick="openLightbox(<?= $index ?>)">
                            <img 
                                src="<?= $index < 2 ? getPhotoUrl($photo['photo_reference'], $API_KEY) : '' ?>"
                                data-src="<?= getPhotoUrl($photo['photo_reference'], $API_KEY) ?>"
                                alt="<?= htmlspecialchars($name) ?> - Photo <?= $index + 1 ?>"
                                class="<?= $index >= 2 ? 'lazy' : '' ?>"
                                loading="<?= $index >= 2 ? 'lazy' : 'eager' ?>"
                            >
                            <?php if ($index === 0): ?>
                            <!-- Photo Count Badge (Feature #5) -->
                            <div class="photo-count-badge" onclick="event.stopPropagation(); openLightbox(0);">
                                <i class="fas fa-images"></i>
                                <?= $photoCount ?> Photos
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="slide">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=500&fit=crop" alt="<?= htmlspecialchars($name) ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- LEFT COLUMN - Business Info -->
        <div class="business-info-section">
            
            <!-- Previous Contact Banner (Feature #16) -->
            <?php if ($previousContact): ?>
            <div class="previous-contact-banner">
                <div class="info">
                    <i class="fas fa-history"></i>
                    <span>You contacted this business <?= timeAgo(strtotime($previousContact['created_at'])) ?></span>
                </div>
                <div class="actions">
                    <?php if ($phone): ?>
                    <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-phone"></i> Call Again
                    </a>
                    <?php endif; ?>
                    <?php if ($hasWhatsapp): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>?text=Hi, I contacted you earlier regarding your services." class="btn btn-sm btn-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i> Follow Up
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Business Header Card -->
            <div class="business-header-card">
                <div class="business-header-top">
                    <div class="business-title-area">
                        <div class="business-badges-row">
                            <?php if ($businessStatus === 'OPERATIONAL'): ?>
                            <span class="badge badge-verified">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($isOpen === true): ?>
                            <span class="badge badge-open">
                                <i class="fas fa-clock"></i> Open Now
                            </span>
                            <?php elseif ($isOpen === false): ?>
                            <span class="badge badge-closed">
                                <i class="fas fa-clock"></i> Closed
                            </span>
                            <?php endif; ?>
                            
                            <span class="badge badge-category">
                                <i class="fas <?= $typeIcon ?>"></i> <?= htmlspecialchars($formattedType) ?>
                            </span>
                            
                            <?php if ($priceLevel !== null): ?>
                            <span class="badge badge-price">
                                <?= getPriceLevel($priceLevel) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <h1 class="business-name"><?= htmlspecialchars($name) ?></h1>
                        
                        <!-- Distance + Travel Time (Feature #9) -->
                        <?php if ($distance !== null): ?>
                        <div class="distance-badge" style="margin-bottom: 15px;">
                            <i class="fas fa-location-arrow"></i>
                            <?= number_format($distance, 1) ?> km away
                            <?php if ($travelTime): ?>
                            • <?= $travelTime ?> drive
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="business-rating-row">
                            <?php if ($rating > 0): ?>
                            <div class="rating-stars">
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
                            <span class="rating-score"><?= number_format($rating, 1) ?></span>
                            <span class="rating-count">
                                <a href="#reviews"><?= number_format($totalRatings) ?> reviews</a>
                            </span>
                            <?php else: ?>
                            <span class="rating-count">No reviews yet</span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Custom Useful Tags (Feature #4) -->
                        <div class="useful-tags">
                            <?php if ($isEmergency): ?>
                            <span class="useful-tag tag-emergency">
                                <i class="fas fa-ambulance"></i> Emergency Service
                            </span>
                            <?php endif; ?>
                            
                            <?php 
                            // Check for 24x7 in opening hours
                            $is24x7 = false;
                            if (!empty($weekdayText)) {
                                foreach ($weekdayText as $day) {
                                    if (stripos($day, '24 hours') !== false || stripos($day, 'Open 24') !== false) {
                                        $is24x7 = true;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?php if ($is24x7): ?>
                            <span class="useful-tag tag-24x7">
                                <i class="fas fa-clock"></i> 24×7 Available
                            </span>
                            <?php endif; ?>
                            
                            <!-- Custom tags from admin panel -->
                            <?php if (!empty($customTags)): ?>
                                <?php foreach ($customTags as $tag): ?>
                                <span class="useful-tag tag-custom">
                                    <i class="fas fa-check"></i> <?= htmlspecialchars($tag) ?>
                                </span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="business-actions-header">
                        <!-- Save Button (Feature #14) -->
                        <button class="btn btn-secondary btn-icon <?= $isSaved ? 'saved' : '' ?>" id="saveBtn" title="Save" data-placeid="<?= htmlspecialchars($place_id) ?>">
                            <i class="<?= $isSaved ? 'fas' : 'far' ?> fa-bookmark"></i>
                        </button>
                        <!-- Share Button (Feature #6) -->
                        <button class="btn btn-secondary btn-icon" id="shareBtn" title="Share" 
                            data-name="<?= htmlspecialchars($name) ?>"
                            data-placeid="<?= htmlspecialchars($place_id) ?>">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Phone Number Visible (Feature #1) -->
                <?php if ($phone): ?>
                <div class="phone-display">
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" class="phone-number" onclick="logCall('<?= htmlspecialchars($place_id) ?>')">
                        <?= htmlspecialchars($phone) ?>
                    </a>
                    <!-- WhatsApp Icon Only if Enabled (Feature #2) -->
                    <?php if ($hasWhatsapp): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>?text=Hi, I found your business on Find Business. I would like to know more about your services." class="btn btn-whatsapp btn-sm" target="_blank" style="margin-left: auto;" onclick="logContact('<?= htmlspecialchars($place_id) ?>', 'whatsapp')">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="business-quick-info">
                    <!-- Short Address (Feature #3) -->
                    <div class="quick-info-item">
                        <div class="quick-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Location</h4>
                            <div class="address-short">
                                <span class="address-text"><?= htmlspecialchars($shortAddress) ?></span>
                            </div>
                            <span class="view-full-address" onclick="toggleFullAddress()">
                                <i class="fas fa-chevron-down"></i> View Full Address
                            </span>
                            <div class="full-address" id="fullAddress">
                                <?= htmlspecialchars($address) ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($website): ?>
                    <div class="quick-info-item">
                        <div class="quick-info-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Website</h4>
                            <p><a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener">Visit Website</a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="quick-info-item">
                        <div class="quick-info-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.15)); color: var(--success);">
                            <i class="fas <?= $statusInfo['icon'] ?>"></i>
                        </div>
                        <div class="quick-info-content">
                            <h4>Status</h4>
                            <p style="color: <?= $statusInfo['color'] ?>"><?= $statusInfo['text'] ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Send Location Button (Feature #12) -->
                <?php if ($hasWhatsapp): ?>
                <button class="send-location-btn" onclick="sendLocation()" style="margin-top: 20px;">
                    <i class="fas fa-location-arrow"></i>
                    Send My Location via WhatsApp
                </button>
                <?php endif; ?>
            </div>

            <!-- About Section -->
            <div class="content-card">
                <div class="content-card-header">
                    <div class="content-card-title">
                        <i class="fas fa-info-circle"></i>
                        <h2>About This Business</h2>
                    </div>
                </div>
                <p class="about-text">
                    Welcome to <strong><?= htmlspecialchars($name) ?></strong>, a trusted <?= strtolower($formattedType) ?> located in <?= htmlspecialchars($city ?: $vicinity) ?>.
                    <?php if ($rating >= 4.5): ?>
                    With an excellent rating of <?= number_format($rating, 1) ?> stars based on <?= number_format($totalRatings) ?> reviews, we are committed to providing exceptional service to all our customers.
                    <?php elseif ($rating >= 4): ?>
                    Highly rated with <?= number_format($rating, 1) ?> stars from <?= number_format($totalRatings) ?> satisfied customers.
                    <?php elseif ($rating > 0): ?>
                    Rated <?= number_format($rating, 1) ?> stars by our <?= number_format($totalRatings) ?> customers.
                    <?php else: ?>
                    We look forward to serving you and earning your valuable feedback.
                    <?php endif; ?>
                </p>
                <p class="about-text">
                    <?php if ($isOpen === true): ?>
                    We are currently <strong style="color: var(--success);">open</strong> and ready to serve you. 
                    <?php elseif ($isOpen === false): ?>
                    We are currently <strong style="color: var(--danger);">closed</strong>. Please check our opening hours below.
                    <?php endif; ?>
                    For more information, feel free to call us or visit our location.
                </p>
                
                <?php if (!empty($types)): ?>
                <div class="about-tags">
                    <?php 
                    $excludeTypes = ['point_of_interest', 'establishment', 'premise', 'political', 'locality', 'sublocality'];
                    foreach ($types as $type): 
                        if (!in_array($type, $excludeTypes)):
                    ?>
                    <span class="about-tag"><?= ucwords(str_replace('_', ' ', $type)) ?></span>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Opening Hours -->
            <?php if (!empty($weekdayText)): ?>
            <div class="content-card">
                <div class="content-card-header">
                    <div class="content-card-title">
                        <i class="fas fa-clock"></i>
                        <h2>Opening Hours</h2>
                    </div>
                    <?php if ($isOpen === true): ?>
                    <span class="badge badge-open"><i class="fas fa-door-open"></i> Open Now</span>
                    <?php elseif ($isOpen === false): ?>
                    <span class="badge badge-closed"><i class="fas fa-door-closed"></i> Closed</span>
                    <?php endif; ?>
                </div>
                <div class="hours-list">
                    <?php 
                    $today = date('l');
                    
                    foreach ($weekdayText as $dayHours):
                        $parts = explode(': ', $dayHours, 2);
                        $day = $parts[0] ?? '';
                        $time = $parts[1] ?? '';
                        $isToday = (strpos($day, $today) !== false);
                        $isClosed = (stripos($time, 'closed') !== false);
                    ?>
                    <div class="hours-item <?= $isToday ? 'today' : '' ?>">
                        <span class="hours-day">
                            <?= htmlspecialchars($day) ?>
                            <?php if ($isToday): ?>
                            <span class="today-badge">TODAY</span>
                            <?php endif; ?>
                        </span>
                        <span class="hours-time <?= $isClosed ? 'closed' : '' ?>">
                            <?= htmlspecialchars($time) ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- People Also Contacted Section (Feature #10) -->
            <?php if (!empty($similarBusinesses)): ?>
            <div class="people-also-section">
                <h3><i class="fas fa-users"></i> People Also Contacted</h3>
                <div class="people-also-grid">
                    <?php foreach (array_slice($similarBusinesses, 0, 4) as $similar): ?>
                    <?php
                        $simPhotos = json_decode($similar['photos'] ?? '[]', true);
                        $simPhotoUrl = !empty($simPhotos[0]['photo_reference']) 
                            ? getPhotoUrl($simPhotos[0]['photo_reference'], $API_KEY, 200) 
                            : 'https://via.placeholder.com/70';
                        $simDistance = null;
                        if ($user_lat && $user_lng && $similar['latitude'] && $similar['longitude']) {
                            $simDistance = calculateDistance($user_lat, $user_lng, $similar['latitude'], $similar['longitude']);
                        }
                    ?>
                    <a href="/business/<?= strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $similar['name']), '-')) ?>-<?= $similar['place_id'] ?>" class="people-also-card">
                        <img src="<?= $simPhotoUrl ?>" alt="<?= htmlspecialchars($similar['name']) ?>" loading="lazy">
                        <div class="info">
                            <h4><?= htmlspecialchars($similar['name']) ?></h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <span><?= number_format($similar['rating'] ?? 0, 1) ?></span>
                                <small>(<?= number_format($similar['total_ratings'] ?? 0) ?>)</small>
                            </div>
                            <?php if ($simDistance): ?>
                            <div class="distance">
                                <i class="fas fa-location-arrow"></i> <?= number_format($simDistance, 1) ?> km away
                            </div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Report Incorrect Info (Feature #18) -->
            <div class="report-section">
                <a href="report.php?place_id=<?= urlencode($place_id) ?>&name=<?= urlencode($name) ?>">
                    <i class="fas fa-flag"></i> Report Incorrect Information
                </a>
            </div>
        </div>

        <!-- RIGHT COLUMN - Sidebar -->
        <aside class="sidebar">
            <!-- Contact Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-address-card"></i>
                    Contact Information
                </h3>
                
                <?php if ($phone): ?>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-content">
                        <h4>Phone</h4>
                        <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" onclick="logCall('<?= htmlspecialchars($place_id) ?>')"><?= htmlspecialchars($phone) ?></a>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($website): ?>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="contact-content">
                        <h4>Website</h4>
                        <a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener">
                            <?= parse_url($website, PHP_URL_HOST) ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="contact-content">
                        <h4>Google Maps</h4>
                        <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank">View on Google</a>
                    </div>
                </div>
                
                <div class="contact-buttons">
                    <?php if ($phone): ?>
                    <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" class="btn btn-success btn-lg" onclick="logCall('<?= htmlspecialchars($place_id) ?>')">
                        <i class="fas fa-phone-alt"></i>
                        Call Now
                    </a>
                    <?php endif; ?>
                    
                    <!-- WhatsApp Button Only if Enabled (Feature #2) -->
                    <?php if ($hasWhatsapp): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>?text=Hi, I found your business on Find Business. I would like to know more about your services." class="btn btn-whatsapp btn-lg" target="_blank" onclick="logContact('<?= htmlspecialchars($place_id) ?>', 'whatsapp')">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions"></i>
                        Get Directions
                    </a>
                    <?php if ($website): ?>
                    <a href="<?= htmlspecialchars($website) ?>" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-globe"></i>
                        Visit Website
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Map Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Location
                </h3>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed/v1/place?key=<?= $API_KEY ?>&q=place_id:<?= urlencode($place_id) ?>"
                        allowfullscreen 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="map-address">
                    <i class="fas fa-map-marker-alt"></i>
                    <p><?= htmlspecialchars($shortAddress) ?></p>
                </div>
                
                <!-- Distance Display (Feature #9) -->
                <?php if ($distance !== null): ?>
                <div class="distance-badge" style="margin-bottom: 15px; width: 100%; justify-content: center;">
                    <i class="fas fa-car"></i>
                    <?= number_format($distance, 1) ?> km • <?= $travelTime ?>
                </div>
                <?php endif; ?>
                
                <div class="map-actions">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($address) ?>&destination_place_id=<?= urlencode($place_id) ?>" target="_blank" class="btn btn-primary">
                        <i class="fas fa-directions"></i>
                        Directions
                    </a>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-external-link-alt"></i>
                        Open Map
                    </a>
                </div>
            </div>

            <!-- Share Card (Feature #6) -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-share-alt"></i>
                    Share This Business
                </h3>
                <div class="share-buttons">
                    <button class="share-btn facebook" onclick="shareOn('facebook')" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="share-btn x" onclick="shareOn('x')" title="Share on X">
                        <i class="fab fa-x-twitter"></i>
                    </button>
                    <button class="share-btn whatsapp" onclick="shareOn('whatsapp')" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="share-btn linkedin" onclick="shareOn('linkedin')" title="Share on LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </button>
                    <button class="share-btn copy" onclick="copyLink()" title="Copy Link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">
                    <i class="fas fa-bolt"></i>
                    Quick Links
                </h3>
                <div class="quick-links-list">
                    <a href="#reviews" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fas fa-star"></i>
                            <span>Reviews</span>
                        </div>
                        <i class="fas fa-chevron-right quick-link-right"></i>
                    </a>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fab fa-google"></i>
                            <span>Google Maps</span>
                        </div>
                        <i class="fas fa-external-link-alt quick-link-right"></i>
                    </a>
                    <a href="/search?q=<?= urlencode($formattedType . ' near ' . ($city ?: $vicinity)) ?>" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fas fa-search"></i>
                            <span>Similar Nearby</span>
                        </div>
                        <i class="fas fa-chevron-right quick-link-right"></i>
                    </a>
                    <a href="report.php?place_id=<?= urlencode($place_id) ?>" class="quick-link">
                        <div class="quick-link-left">
                            <i class="fas fa-flag"></i>
                            <span>Report Issue</span>
                        </div>
                        <i class="fas fa-chevron-right quick-link-right"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>

    <!-- Floating Action Buttons for Mobile (Feature #1) -->
    <div class="floating-actions">
        <?php if ($phone): ?>
        <a href="tel:<?= htmlspecialchars($cleanPhone) ?>" class="fab-btn fab-call" onclick="logCall('<?= htmlspecialchars($place_id) ?>')">
            <i class="fas fa-phone-alt"></i>
            <span>Call</span>
        </a>
        <?php endif; ?>
        
        <?php if ($hasWhatsapp): ?>
        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>?text=Hi, I found your business on Find Business." class="fab-btn fab-whatsapp" target="_blank" onclick="logContact('<?= htmlspecialchars($place_id) ?>', 'whatsapp')">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <?php endif; ?>
        
        <a href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($address) ?>&destination_place_id=<?= urlencode($place_id) ?>" class="fab-btn fab-directions" target="_blank">
            <i class="fas fa-directions"></i>
            <span>Directions</span>
        </a>
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <button class="lightbox-nav lightbox-prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="lightbox-content">
            <img src="" alt="Gallery Image" id="lightboxImage">
        </div>
        <button class="lightbox-nav lightbox-next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="lightbox-counter">
            <span id="currentSlide">1</span> / <span id="totalSlides"><?= $photoCount ?></span>
        </div>
    </div>

    <!-- Missed Call Modal (Feature #13) -->
    <div class="missed-call-modal" id="missedCallModal">
        <div class="missed-call-content">
            <i class="fas fa-phone-slash"></i>
            <h3>Couldn't reach them?</h3>
            <p>No worries! Get a callback on WhatsApp when they're available.</p>
            <div class="actions">
                <?php if ($hasWhatsapp): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>?text=Hi, I tried calling but couldn't reach you. Please call me back when available." class="btn btn-whatsapp btn-lg" target="_blank">
                    <i class="fab fa-whatsapp"></i> Get Callback on WhatsApp
                </a>
                <?php endif; ?>
                <button class="btn btn-secondary" onclick="closeMissedCallModal()">
                    Maybe Later
                </button>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <!-- FOOTER -->
    <?php include 'footer.php';?>

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
    <script>
        // ========================================
        // BUSINESS DATA
        // ========================================
        const businessData = {
            name: <?= json_encode($name ?? '') ?>,
            url: <?= json_encode($seoUrl ?? '') ?>,
            address: <?= json_encode($address ?? '') ?>,
            phone: <?= json_encode($cleanPhone ?? '') ?>,
            placeId: <?= json_encode($place_id ?? '') ?>,
            hasWhatsapp: <?= json_encode($hasWhatsapp ?? false) ?>,
            whatsappNumber: <?= json_encode($whatsappNumber ?? '') ?>,
            lat: <?= json_encode($lat ?? 0) ?>,
            lng: <?= json_encode($lng ?? 0) ?>
        };

        // ========================================
        // PHOTO GALLERY DATA
        // ========================================
        const photos = [
            <?php if (!empty($photos)): ?>
            <?php foreach ($photos as $photo): ?>
            "<?= getPhotoUrl($photo['photo_reference'] ?? '', $API_KEY) ?>",
            <?php endforeach; ?>
            <?php endif; ?>
        ];
        let currentSlideIndex = 0;

        // ========================================
        // TOAST NOTIFICATION
        // ========================================
        function showToast(message, type = '') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast show ' + type;
            setTimeout(() => {
                toast.className = 'toast';
            }, 3000);
        }

        // ========================================
        // TOGGLE FULL ADDRESS (Feature #3)
        // ========================================
        function toggleFullAddress() {
            const fullAddress = document.getElementById('fullAddress');
            const toggle = document.querySelector('.view-full-address');
            
            if (fullAddress.classList.contains('show')) {
                fullAddress.classList.remove('show');
                toggle.innerHTML = '<i class="fas fa-chevron-down"></i> View Full Address';
            } else {
                fullAddress.classList.add('show');
                toggle.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Full Address';
            }
        }

        // ========================================
        // SEND LOCATION (Feature #12)
        // ========================================
        function sendLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const mapsLink = `https://www.google.com/maps?q=${lat},${lng}`;
                        const message = `Hi, I'm interested in your services. Here's my location: ${mapsLink}`;
                        const whatsappUrl = `https://wa.me/${businessData.whatsappNumber.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(message)}`;
                        window.open(whatsappUrl, '_blank');
                        logContact(businessData.placeId, 'location_share');
                    },
                    (error) => {
                        showToast('Unable to get your location. Please enable location services.', 'error');
                    }
                );
            } else {
                showToast('Geolocation is not supported by your browser.', 'error');
            }
        }

        // ========================================
        // CONTACT LOGGING (Feature #13, #16)
        // ========================================
        let callStartTime = null;

        function logCall(placeId) {
            callStartTime = Date.now();
            logContact(placeId, 'call');
            
            // Check for missed call after 30 seconds
            setTimeout(() => {
                if (callStartTime && (Date.now() - callStartTime) < 35000) {
                    // Call lasted less than 35 seconds - might be missed
                    if (businessData.hasWhatsapp) {
                        document.getElementById('missedCallModal').classList.add('active');
                    }
                }
            }, 30000);
        }

        function logContact(placeId, type) {
            fetch('api/log_contact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ place_id: placeId, contact_type: type })
            }).catch(console.error);
        }

        function closeMissedCallModal() {
            document.getElementById('missedCallModal').classList.remove('active');
        }

        // ========================================
        // SAVE BUSINESS (Feature #14)
        // ========================================
        document.getElementById('saveBtn')?.addEventListener('click', async function() {
            const placeId = this.dataset.placeid;
            const icon = this.querySelector('i');
            const isSaved = icon.classList.contains('fas');
            
            try {
                const response = await fetch('api/save_business.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        place_id: placeId, 
                        action: isSaved ? 'remove' : 'save' 
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                    
                    if (icon.classList.contains('fas')) {
                        this.style.background = 'rgba(255, 107, 53, 0.1)';
                        icon.style.color = 'var(--primary)';
                        showToast('Business saved to your favorites!', 'success');
                    } else {
                        this.style.background = '';
                        icon.style.color = '';
                        showToast('Removed from favorites');
                    }
                } else if (data.login_required) {
                    showToast('Please login to save businesses');
                    // Optionally redirect to login
                }
            } catch (error) {
                console.error('Save error:', error);
                // Fallback for non-logged in users - use localStorage
                let saved = JSON.parse(localStorage.getItem('savedBusinesses') || '[]');
                
                if (isSaved) {
                    saved = saved.filter(id => id !== placeId);
                    localStorage.setItem('savedBusinesses', JSON.stringify(saved));
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.style.background = '';
                    icon.style.color = '';
                    showToast('Removed from favorites');
                } else {
                    saved.push(placeId);
                    localStorage.setItem('savedBusinesses', JSON.stringify(saved));
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.style.background = 'rgba(255, 107, 53, 0.1)';
                    icon.style.color = 'var(--primary)';
                    showToast('Business saved to your favorites!', 'success');
                }
            }
        });

        // ========================================
        // LIGHTBOX FUNCTIONS
        // ========================================
        function openLightbox(index) {
            currentSlideIndex = index;
            updateLightbox();
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        function changeSlide(direction) {
            currentSlideIndex += direction;
            if (currentSlideIndex < 0) currentSlideIndex = photos.length - 1;
            if (currentSlideIndex >= photos.length) currentSlideIndex = 0;
            updateLightbox();
        }

        function updateLightbox() {
            document.getElementById('lightboxImage').src = photos[currentSlideIndex] || photos[0];
            document.getElementById('currentSlide').textContent = currentSlideIndex + 1;
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('lightbox').classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') changeSlide(-1);
                if (e.key === 'ArrowRight') changeSlide(1);
            }
        });

        // Close lightbox on overlay click
        document.getElementById('lightbox')?.addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') closeLightbox();
        });

        // ========================================
        // SHARE FUNCTIONS (Feature #6)
        // ========================================
        function shareOn(platform) {
            const url = encodeURIComponent(businessData.url);
            const text = encodeURIComponent(`Check out ${businessData.name} on Find Business!`);
            
            let shareUrl;
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'x':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${text}%20${url}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
            }
            
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        function copyLink() {
            navigator.clipboard.writeText(businessData.url).then(() => {
                showToast('Link copied to clipboard!', 'success');
            }).catch(() => {
                // Fallback
                const input = document.createElement('input');
                input.value = businessData.url;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                showToast('Link copied to clipboard!', 'success');
            });
        }

        // Native share if available
        document.getElementById('shareBtn')?.addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: businessData.name,
                        text: `Check out ${businessData.name} on Find Business!`,
                        url: businessData.url
                    });
                } catch (err) {
                    console.log('Share cancelled');
                }
            } else {
                document.querySelector('.share-buttons')?.scrollIntoView({ behavior: 'smooth' });
            }
        });

        // ========================================
        // BACK TO TOP
        // ========================================
        const backToTop = document.getElementById('backToTop');

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
        // SMOOTH SCROLL
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offsetTop = target.offsetTop - 100;
                        window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                    }
                }
            });
        });

        // ========================================
        // LAZY LOAD IMAGES
        // ========================================
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img.lazy').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // ========================================
        // OFFLINE MODE (Feature #17)
        // ========================================
        function updateOnlineStatus() {
            const banner = document.getElementById('offlineBanner');
            if (!navigator.onLine) {
                banner.classList.add('show');
            } else {
                banner.classList.remove('show');
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        updateOnlineStatus();

        // Cache business data for offline
        if ('caches' in window) {
            caches.open('find-business-business-v1').then(cache => {
                cache.put(window.location.href, new Response(document.documentElement.outerHTML, {
                    headers: { 'Content-Type': 'text/html' }
                }));
            });
        }

        // ========================================
        // GET USER LOCATION FOR DISTANCE
        // ========================================
        function getUserLocation() {
            if (navigator.geolocation && !document.cookie.includes('user_lat')) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Store in cookies for 1 day
                        document.cookie = `user_lat=${lat};max-age=86400;path=/`;
                        document.cookie = `user_lng=${lng};max-age=86400;path=/`;
                        
                        // Reload if distance not shown
                        if (!document.querySelector('.distance-badge')) {
                            window.location.reload();
                        }
                    },
                    (error) => {
                        console.log('Location access denied');
                    }
                );
            }
        }

        // Ask for location after 2 seconds
        setTimeout(getUserLocation, 2000);

        // ========================================
        // IMAGE SLIDER AUTO-SCROLL
        // ========================================
        const slider = document.getElementById("imageSlider");
        if (slider) {
            let index = 0;
            setInterval(() => {
                const width = slider.offsetWidth;
                index++;
                if (index >= slider.children.length) index = 0;
                slider.scrollTo({
                    left: width * index,
                    behavior: "smooth"
                });
            }, 4000);
        }

        // ========================================
        // ANIMATE ON SCROLL (Web View Only)
        // ========================================
        if (!document.body.classList.contains('app-view')) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.content-card, .sidebar-card, .similar-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });
        }

        // Initialize
        handleBackToTop();
    </script>
</body>
</html>
<?php include_once 'app-detect.php'; ?>

<?php
// ============================================
// DIALIKIYA - CATEGORY DETAILS PAGE
// Shows all businesses by current location
// ============================================

ob_start();

$API_KEY = "AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU";

// Category mapping
$categoryMapping = [
    'restaurant' => ['types' => 'restaurant', 'title' => 'Restaurants', 'icon' => 'fa-utensils', 'color' => '#FF6B35', 'desc' => 'Discover amazing dining experiences near you', 'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200&q=80'],
    'cafe' => ['types' => 'cafe', 'title' => 'Cafes', 'icon' => 'fa-coffee', 'color' => '#8B4513', 'desc' => 'Best coffee shops and cozy cafes', 'image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1200&q=80'],
    'bakery' => ['types' => 'bakery', 'title' => 'Bakeries', 'icon' => 'fa-bread-slice', 'color' => '#D2691E', 'desc' => 'Fresh baked goods and pastries', 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=1200&q=80'],
    'bar' => ['types' => 'bar', 'title' => 'Bars & Pubs', 'icon' => 'fa-glass-martini-alt', 'color' => '#800080', 'desc' => 'Nightlife spots and cocktail lounges', 'image' => 'https://images.unsplash.com/photo-1572116469696-31de0f17cc34?w=1200&q=80'],
    'hotel' => ['types' => 'lodging', 'title' => 'Hotels', 'icon' => 'fa-hotel', 'color' => '#3B82F6', 'desc' => 'Find comfortable stays and accommodations', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80'],
    'hospital' => ['types' => 'hospital', 'title' => 'Hospitals', 'icon' => 'fa-hospital', 'color' => '#EF4444', 'desc' => 'Quality healthcare services when you need them', 'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&q=80'],
    'pharmacy' => ['types' => 'pharmacy', 'title' => 'Pharmacies', 'icon' => 'fa-pills', 'color' => '#10B981', 'desc' => 'Medicines and health products nearby', 'image' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=1200&q=80'],
    'doctor' => ['types' => 'doctor', 'title' => 'Doctors & Clinics', 'icon' => 'fa-user-md', 'color' => '#06B6D4', 'desc' => 'Medical consultations and healthcare', 'image' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=1200&q=80'],
    'dentist' => ['types' => 'dentist', 'title' => 'Dentists', 'icon' => 'fa-tooth', 'color' => '#14B8A6', 'desc' => 'Professional dental care services', 'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&q=80'],
    'veterinary' => ['types' => 'veterinary_care', 'title' => 'Veterinary Clinics', 'icon' => 'fa-paw', 'color' => '#F97316', 'desc' => 'Pet care and animal hospitals', 'image' => 'https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?w=1200&q=80'],
    'salon' => ['types' => 'beauty_salon', 'title' => 'Beauty Salons', 'icon' => 'fa-cut', 'color' => '#EC4899', 'desc' => 'Professional beauty and grooming services', 'image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1200&q=80'],
    'spa' => ['types' => 'spa', 'title' => 'Spas & Wellness', 'icon' => 'fa-spa', 'color' => '#A855F7', 'desc' => 'Relaxation and rejuvenation awaits you', 'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=1200&q=80'],
    'gym' => ['types' => 'gym', 'title' => 'Gyms & Fitness', 'icon' => 'fa-dumbbell', 'color' => '#EF4444', 'desc' => 'Stay fit and healthy with top fitness centers', 'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&q=80'],
    'bank' => ['types' => 'bank', 'title' => 'Banks', 'icon' => 'fa-university', 'color' => '#1E3A5F', 'desc' => 'Banking and financial services', 'image' => 'https://images.unsplash.com/photo-1541354329998-f4d9a9f9297f?w=1200&q=80'],
    'atm' => ['types' => 'atm', 'title' => 'ATMs', 'icon' => 'fa-credit-card', 'color' => '#0EA5E9', 'desc' => 'Find nearest cash withdrawal points', 'image' => 'https://images.unsplash.com/photo-1589758438368-0ad531db3366?w=1200&q=80'],
    'store' => ['types' => 'store', 'title' => 'Stores', 'icon' => 'fa-store', 'color' => '#84CC16', 'desc' => 'Local retail shops and stores', 'image' => 'https://images.unsplash.com/photo-1604719312566-8912e9227c6a?w=1200&q=80'],
    'supermarket' => ['types' => 'supermarket', 'title' => 'Supermarkets', 'icon' => 'fa-shopping-cart', 'color' => '#22C55E', 'desc' => 'Groceries and daily essentials', 'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=1200&q=80'],
    'mall' => ['types' => 'shopping_mall', 'title' => 'Shopping Malls', 'icon' => 'fa-building', 'color' => '#6366F1', 'desc' => 'Premium shopping destinations', 'image' => 'https://images.unsplash.com/photo-1519567241046-7f570eee3ce6?w=1200&q=80'],
    'electronics' => ['types' => 'electronics_store', 'title' => 'Electronics Stores', 'icon' => 'fa-mobile-alt', 'color' => '#3B82F6', 'desc' => 'Gadgets and electronic devices', 'image' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=1200&q=80'],
    'jewelry' => ['types' => 'jewelry_store', 'title' => 'Jewelry Stores', 'icon' => 'fa-gem', 'color' => '#F59E0B', 'desc' => 'Fine jewelry and accessories', 'image' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1200&q=80'],
    'florist' => ['types' => 'florist', 'title' => 'Florists', 'icon' => 'fa-seedling', 'color' => '#EC4899', 'desc' => 'Fresh flowers and bouquets', 'image' => 'https://images.unsplash.com/photo-1487530811176-3780de880c2d?w=1200&q=80'],
    'school' => ['types' => 'school', 'title' => 'Schools', 'icon' => 'fa-school', 'color' => '#8B5CF6', 'desc' => 'Top educational institutions', 'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80'],
    'college' => ['types' => 'university', 'title' => 'Colleges & Universities', 'icon' => 'fa-graduation-cap', 'color' => '#1E40AF', 'desc' => 'Higher education institutions', 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=1200&q=80'],
    'electrician' => ['types' => 'electrician', 'title' => 'Electricians', 'icon' => 'fa-bolt', 'color' => '#FBBF24', 'desc' => 'Electrical repair services', 'image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1200&q=80'],
    'plumber' => ['types' => 'plumber', 'title' => 'Plumbers', 'icon' => 'fa-wrench', 'color' => '#0284C7', 'desc' => 'Plumbing repair services', 'image' => 'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?w=1200&q=80'],
    'laundry' => ['types' => 'laundry', 'title' => 'Laundry Services', 'icon' => 'fa-tshirt', 'color' => '#38BDF8', 'desc' => 'Professional cleaning and laundry', 'image' => 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f?w=1200&q=80'],
    'petrol' => ['types' => 'gas_station', 'title' => 'Petrol Pumps', 'icon' => 'fa-gas-pump', 'color' => '#DC2626', 'desc' => 'Fuel stations and gas pumps nearby', 'image' => 'https://images.unsplash.com/photo-1565793298595-6a879b1d9492?w=1200&q=80'],
    'car_repair' => ['types' => 'car_repair', 'title' => 'Car Repair & Service', 'icon' => 'fa-car', 'color' => '#64748B', 'desc' => 'Auto repair and maintenance', 'image' => 'https://images.unsplash.com/photo-1625047509168-a7026f36de04?w=1200&q=80'],
    'parking' => ['types' => 'parking', 'title' => 'Parking', 'icon' => 'fa-parking', 'color' => '#2563EB', 'desc' => 'Vehicle parking spaces nearby', 'image' => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=1200&q=80'],
    'lawyer' => ['types' => 'lawyer', 'title' => 'Lawyers & Advocates', 'icon' => 'fa-gavel', 'color' => '#7C3AED', 'desc' => 'Legal services and consultation', 'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1200&q=80'],
    'travel' => ['types' => 'travel_agency', 'title' => 'Travel Agencies', 'icon' => 'fa-plane', 'color' => '#0891B2', 'desc' => 'Travel planning and bookings', 'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1200&q=80'],
    'movie' => ['types' => 'movie_theater', 'title' => 'Movie Theaters', 'icon' => 'fa-film', 'color' => '#7C3AED', 'desc' => 'Cinemas and entertainment venues', 'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1200&q=80'],
    'park' => ['types' => 'park', 'title' => 'Parks & Gardens', 'icon' => 'fa-tree', 'color' => '#16A34A', 'desc' => 'Outdoor recreation and green spaces', 'image' => 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?w=1200&q=80'],
    'temple' => ['types' => 'hindu_temple', 'title' => 'Temples', 'icon' => 'fa-place-of-worship', 'color' => '#EA580C', 'desc' => 'Sacred Hindu temples and shrines', 'image' => 'https://images.unsplash.com/photo-1591018653367-7d9e5e15d68a?w=1200&q=80'],
    'mosque' => ['types' => 'mosque', 'title' => 'Mosques', 'icon' => 'fa-mosque', 'color' => '#059669', 'desc' => 'Islamic worship places', 'image' => 'https://images.unsplash.com/photo-1585036156261-1e2ac76e3ff6?w=1200&q=80'],
    'church' => ['types' => 'church', 'title' => 'Churches', 'icon' => 'fa-church', 'color' => '#7C2D12', 'desc' => 'Christian worship places', 'image' => 'https://images.unsplash.com/photo-1548625149-fc4a29cf7092?w=1200&q=80'],
];

// Get category from URL
$categorySlug = isset($_GET['category']) ? strtolower(trim($_GET['category'])) : 'restaurant';
$categoryData = isset($categoryMapping[$categorySlug]) ? $categoryMapping[$categorySlug] : $categoryMapping['restaurant'];

// Default India coordinates (New Delhi)
$defaultLat = 28.6139;
$defaultLng = 77.2090;

// Handle AJAX request
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    header('Content-Type: application/json');
    header('Cache-Control: no-cache');
    
    $lat = isset($_GET['lat']) ? floatval($_GET['lat']) : $defaultLat;
    $lng = isset($_GET['lng']) ? floatval($_GET['lng']) : $defaultLng;
    $pageToken = isset($_GET['page_token']) ? $_GET['page_token'] : null;
    $type = $categoryData['types'];
    
    $apiUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?";
    $params = [
        'location' => "$lat,$lng",
        'radius' => 5000,
        'type' => $type,
        'key' => $API_KEY
    ];
    
    if ($pageToken) {
        $params['pagetoken'] = $pageToken;
    }
    
    $apiUrl .= http_build_query($params);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_ENCODING => 'gzip, deflate'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        echo json_encode(['success' => false, 'error' => 'API request failed']);
        exit;
    }
    
    $result = json_decode($response, true);
    
    if ($result['status'] === 'OK' || $result['status'] === 'ZERO_RESULTS') {
        $places = isset($result['results']) ? array_slice($result['results'], 0, 20) : [];
        $nextPageToken = isset($result['next_page_token']) ? $result['next_page_token'] : null;
        
        $placesData = [];
        foreach ($places as $place) {
            $photoUrl = '';
            if (isset($place['photos'][0]['photo_reference'])) {
                $photoUrl = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=" . $place['photos'][0]['photo_reference'] . "&key=" . $API_KEY;
            }
            
            $placesData[] = [
                'place_id' => $place['place_id'],
                'name' => $place['name'],
                'photo' => $photoUrl,
                'rating' => isset($place['rating']) ? $place['rating'] : 0,
                'reviews' => isset($place['user_ratings_total']) ? $place['user_ratings_total'] : 0,
                'address' => isset($place['vicinity']) ? $place['vicinity'] : 'Address not available',
                'is_open' => isset($place['opening_hours']['open_now']) ? $place['opening_hours']['open_now'] : null,
                'price_level' => isset($place['price_level']) ? $place['price_level'] : null,
                'lat' => isset($place['geometry']['location']['lat']) ? $place['geometry']['location']['lat'] : null,
                'lng' => isset($place['geometry']['location']['lng']) ? $place['geometry']['location']['lng'] : null
            ];
        }
        
        echo json_encode([
            'success' => true,
            'places' => $placesData,
            'next_page_token' => $nextPageToken,
            'count' => count($placesData),
            'category' => [
                'slug' => $categorySlug,
                'title' => $categoryData['title'],
                'icon' => $categoryData['icon'],
                'color' => $categoryData['color']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No results found']);
    }
    exit;
}

$pageTitle = $categoryData['title'] . " Near Me - Find Best " . $categoryData['title'] . " | Find Business";
$pageDescription = $categoryData['desc'] . ". Find top-rated " . strtolower($categoryData['title']) . " with reviews, ratings, contact details on Find Business India.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="keywords" content="<?php echo $categoryData['title']; ?>, <?php echo $categorySlug; ?> near me, best <?php echo $categorySlug; ?>, India, Find Business">
    <meta name="author" content="Find Business">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="<?php echo $categoryData['color']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:image" content="<?php echo $categoryData['image']; ?>">
    <meta property="og:type" content="website">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://maps.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <?php
$isApp = false;

if (isset($_SERVER['HTTP_USER_AGENT'])) {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'FindBusinessApp') !== false) {
        $isApp = true;
    }
}
?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F81NMHGBRZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-F81NMHGBRZ');
</script>
    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #E85A2A;
            --category-color: <?php echo $categoryData['color']; ?>;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --white: #FFFFFF;
            --radius: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        
        /* ==========================================
           HEADER
           ========================================== */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gray-200);
        }
        
        .header.scrolled {
            box-shadow: var(--shadow-md);
        }
        
        .header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: var(--gray-900);
        }
        
        .logo-text span { color: var(--primary); }
        
        .nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nav-link {
            padding: 10px 18px;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-radius: var(--radius);
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            color: var(--gray-900);
            background: var(--gray-100);
        }
        
        .nav-link.active {
            color: var(--primary);
            background: rgba(255, 107, 53, 0.08);
        }
        
        .mobile-toggle {
            display: none;
            width: 44px;
            height: 44px;
            background: var(--gray-100);
            border: none;
            border-radius: var(--radius-md);
            font-size: 20px;
            color: var(--gray-700);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        
        /* ==========================================
           HERO BANNER - GRAY WITH CATEGORY ACCENT
           ========================================== */
        .hero {
            padding-top: 72px;
            background: linear-gradient(165deg, 
                #ffffff 0%, 
                #f8fafc 20%, 
                #f1f5f9 45%, 
                #e2e8f0 70%,
                #cbd5e1 100%
            );
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.02;
            pointer-events: none;
        }
        
        .hero-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }
        
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            pointer-events: none;
        }
        
        .hero-orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, <?php echo $categoryData['color']; ?>20, <?php echo $categoryData['color']; ?>10);
            top: -150px;
            right: -100px;
            animation: float 20s ease-in-out infinite;
        }
        
        .hero-orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(100, 116, 139, 0.15), rgba(148, 163, 184, 0.1));
            bottom: -100px;
            left: -100px;
            animation: float 25s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, 20px); }
        }
        
        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 24px 100px;
            position: relative;
            z-index: 2;
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .hero-left {
            max-width: 600px;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: var(--gray-500);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .breadcrumb a:hover {
            color: var(--primary);
        }
        
        .breadcrumb span {
            color: var(--gray-400);
        }
        
        .breadcrumb .current {
            color: var(--gray-700);
            font-weight: 500;
        }
        
        /* Category Badge */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 100px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            animation: fadeInDown 0.6s ease;
        }
        
        .hero-badge-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--category-color), var(--category-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 16px;
            box-shadow: 0 4px 12px <?php echo $categoryData['color']; ?>40;
        }
        
        .hero-badge-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-800);
        }
        
        .hero-title {
            font-size: 48px;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease 0.1s both;
        }
        
        .hero-title .highlight {
            color: var(--category-color);
            position: relative;
        }
        
        .hero-title .highlight::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 0;
            right: 0;
            height: 10px;
            background: <?php echo $categoryData['color']; ?>25;
            border-radius: 5px;
            z-index: -1;
        }
        
        .hero-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: var(--gray-600);
            margin-bottom: 32px;
            line-height: 1.7;
            animation: fadeInUp 0.6s ease 0.2s both;
        }
        
        /* Location Badge */
        .hero-location {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 100px;
            margin-bottom: 32px;
            animation: fadeInUp 0.6s ease 0.3s both;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .hero-location:hover {
            border-color: var(--category-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .location-icon {
            width: 36px;
            height: 36px;
            background: var(--category-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 14px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .location-text {
            font-size: 15px;
            color: var(--gray-700);
        }
        
        .location-text strong {
            color: var(--gray-900);
        }
        
        .location-change {
            font-size: 13px;
            color: var(--category-color);
            font-weight: 600;
            margin-left: 8px;
        }
        
        /* Stats */
        .hero-stats {
            display: flex;
            gap: 40px;
            animation: fadeInUp 0.6s ease 0.4s both;
        }
        
        .stat-item {
            text-align: left;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1;
            margin-bottom: 6px;
        }
        
        .stat-value span {
            color: var(--category-color);
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--gray-500);
        }
        
        /* Hero Right - Visual Card */
        .hero-right {
            position: relative;
            animation: fadeInRight 0.8s ease 0.3s both;
        }
        
        .hero-image-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
        }
        
        .hero-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
        }
        
        .hero-image-content {
            padding: 24px;
        }
        
        .hero-image-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }
        
        .hero-image-desc {
            font-size: 14px;
            color: var(--gray-500);
            margin-bottom: 16px;
        }
        
        .hero-image-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .hero-tag {
            padding: 6px 14px;
            background: var(--gray-100);
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .hero-tag i {
            color: var(--category-color);
        }
        
        /* Floating Stats Cards */
        .floating-stat {
            position: absolute;
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: float 4s ease-in-out infinite;
        }
        
        .floating-stat-1 {
            top: 20px;
            right: -30px;
            animation-delay: 0s;
        }
        
        .floating-stat-2 {
            bottom: 80px;
            left: -40px;
            animation-delay: 1.5s;
        }
        
        .floating-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .floating-stat-icon.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .floating-stat-icon.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .floating-stat-text h5 {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-900);
        }
        
        .floating-stat-text p {
            font-size: 12px;
            color: var(--gray-500);
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        /* ==========================================
           MAIN CONTENT
           ========================================== */
        .main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            padding-bottom: 80px;
        }
        
        /* ==========================================
           FILTER BAR
           ========================================== */
        .filter-bar {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 28px 32px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
        }
        
        .filter-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .filter-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        
        .filter-title-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--category-color), var(--category-color));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 20px;
            box-shadow: 0 4px 12px <?php echo $categoryData['color']; ?>30;
        }
        
        .filter-title-text h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
        }
        
        .filter-title-text p {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 2px;
        }
        
        .results-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--gray-100);
            padding: 12px 20px;
            border-radius: 100px;
            font-size: 14px;
            color: var(--gray-600);
        }
        
        .results-badge i {
            color: var(--category-color);
        }
        
        .results-badge strong {
            color: var(--category-color);
            font-weight: 700;
        }
        
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: flex-end;
        }
        
        .filter-group {
            flex: 1;
            min-width: 160px;
        }
        
        .filter-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .filter-select {
            width: 100%;
            padding: 14px 44px 14px 16px;
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--category-color);
            background-color: var(--white);
        }
        
        .filter-actions {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }
        
        .filter-btn {
            padding: 14px 20px;
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            white-space: nowrap;
        }
        
        .filter-btn:hover {
            border-color: var(--category-color);
            color: var(--category-color);
        }
        
        .filter-btn.active {
            background: var(--category-color);
            border-color: var(--category-color);
            color: var(--white);
        }
        
        .filter-clear {
            padding: 14px 20px;
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-500);
            cursor: pointer;
            font-family: inherit;
            transition: color 0.2s;
        }
        
        .filter-clear:hover {
            color: var(--danger);
        }
        
        /* ==========================================
           BUSINESS CARDS GRID
           ========================================== */
        .cards-section {
            margin-bottom: 40px;
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        .business-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .business-card.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        
        .business-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            border-color: var(--category-color);
        }
        
        .card-image {
            position: relative;
            height: 180px;
            background: var(--gray-100);
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .business-card:hover .card-image img {
            transform: scale(1.08);
        }
        
        .card-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
            gap: 10px;
        }
        
        .card-placeholder i {
            font-size: 40px;
            color: var(--gray-400);
        }
        
        .card-placeholder span {
            font-size: 12px;
            color: var(--gray-400);
        }
        
        /* Status Badge */
        .card-status {
            position: absolute;
            top: 14px;
            right: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        .card-status.open {
            background: rgba(16, 185, 129, 0.9);
            color: var(--white);
        }
        
        .card-status.closed {
            background: rgba(239, 68, 68, 0.9);
            color: var(--white);
        }
        
        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            animation: blink 1.5s infinite;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        
        /* Category Tag */
        .card-category {
            position: absolute;
            bottom: 14px;
            left: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--category-color);
            color: var(--white);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Card Body */
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 10px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 48px;
        }
        
        /* Rating */
        .card-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        
        .stars {
            display: flex;
            gap: 2px;
            color: var(--warning);
            font-size: 13px;
        }
        
        .stars .empty {
            color: var(--gray-300);
        }
        
        .rating-score {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
        }
        
        .rating-count {
            font-size: 13px;
            color: var(--gray-500);
        }
        
        /* Address */
        .card-address {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            color: var(--gray-600);
            margin-bottom: 16px;
            line-height: 1.5;
        }
        
        .card-address i {
            color: var(--category-color);
            margin-top: 3px;
            flex-shrink: 0;
        }
        
        .card-address span {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Distance */
        .card-distance {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--gray-500);
            margin-bottom: 16px;
        }
        
        .card-distance i {
            color: var(--success);
        }
        
        /* Card Footer */
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 16px;
            border-top: 1px solid var(--gray-100);
        }
        
        .card-price {
            font-size: 16px;
            font-weight: 700;
            color: var(--success);
        }
        
        .card-price .empty {
            color: var(--gray-300);
        }
        
        .card-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--category-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .card-btn:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px <?php echo $categoryData['color']; ?>40;
        }
        
        .card-btn i {
            font-size: 11px;
            transition: transform 0.2s;
        }
        
        .card-btn:hover i {
            transform: translateX(4px);
        }
        
        /* ==========================================
           SKELETON LOADING
           ========================================== */
        .skeleton-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--gray-200);
        }
        
        .skeleton-image {
            height: 180px;
            background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
        }
        
        .skeleton-body {
            padding: 20px;
        }
        
        .skeleton-line {
            height: 14px;
            background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        
        .skeleton-line.lg { height: 20px; width: 85%; }
        .skeleton-line.md { width: 65%; }
        .skeleton-line.sm { width: 45%; }
        .skeleton-line.xs { width: 30%; }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* ==========================================
           EMPTY & ERROR STATES
           ========================================== */
        .empty-state {
            text-align: center;
            padding: 80px 24px;
            background: var(--white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
        }
        
        .empty-icon {
            width: 120px;
            height: 120px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
        }
        
        .empty-icon i {
            font-size: 48px;
            color: var(--gray-400);
        }
        
        .empty-icon.error i {
            color: var(--danger);
        }
        
        .empty-state h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 12px;
        }
        
        .empty-state p {
            font-size: 16px;
            color: var(--gray-500);
            margin-bottom: 28px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .retry-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            background: var(--category-color);
            color: var(--white);
            border: none;
            border-radius: 100px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .retry-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px <?php echo $categoryData['color']; ?>40;
        }
        
        /* ==========================================
           LOAD MORE
           ========================================== */
        .load-more {
            text-align: center;
            margin-top: 48px;
        }
        
        .load-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 48px;
            background: var(--white);
            border: 2px solid var(--category-color);
            color: var(--category-color);
            border-radius: 100px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .load-more-btn:hover {
            background: var(--category-color);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px <?php echo $categoryData['color']; ?>30;
        }
        
        .load-more-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .load-more-btn .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid currentColor;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        
        .load-more-btn.loading .spinner {
            display: block;
        }
        
        .load-more-btn.loading .btn-text {
            display: none;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* ==========================================
           FOOTER
           ========================================== */
        .footer {
            background: var(--gray-900);
            color: var(--white);
            padding: 70px 24px 30px;
            margin-top: 100px;
        }
        
        .footer-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 50px;
        }
        
        .footer-brand p {
            color: var(--gray-400);
            font-size: 15px;
            line-height: 1.8;
            margin-top: 20px;
            max-width: 320px;
        }
        
        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }
        
        .footer-social a {
            width: 44px;
            height: 44px;
            background: var(--gray-800);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 16px;
            transition: all 0.2s;
        }
        
        .footer-social a:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }
        
        .footer-section h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--white);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 14px;
        }
        
        .footer-links a {
            color: var(--gray-400);
            text-decoration: none;
            font-size: 15px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-links a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }
        
        .footer-links a i {
            font-size: 10px;
        }
        
        .footer-bottom {
            max-width: 1400px;
            margin: 50px auto 0;
            padding-top: 30px;
            border-top: 1px solid var(--gray-800);
            text-align: center;
            color: var(--gray-500);
            font-size: 14px;
        }
        
        .footer-bottom a {
            color: var(--primary);
            text-decoration: none;
        }
        
        /* ==========================================
           MOBILE MENU
           ========================================== */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .mobile-menu.active {
            opacity: 1;
            visibility: visible;
        }
        
        .mobile-menu-content {
            position: absolute;
            top: 0;
            right: 0;
            width: 320px;
            max-width: 85%;
            height: 100%;
            background: var(--white);
            padding: 28px;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s;
        }
        
        .mobile-menu.active .mobile-menu-content {
            transform: translateX(0);
        }
        
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }
        
        .mobile-close {
            width: 44px;
            height: 44px;
            background: var(--gray-100);
            border: none;
            border-radius: var(--radius-md);
            font-size: 20px;
            color: var(--gray-600);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 18px;
            color: var(--gray-700);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            border-radius: var(--radius-md);
            margin-bottom: 6px;
            transition: all 0.2s;
        }
        
        .mobile-nav-link:hover {
            background: var(--gray-100);
            color: var(--primary);
        }
        
        .mobile-nav-link i {
            width: 24px;
            text-align: center;
            font-size: 18px;
        }
        
        /* ==========================================
           RESPONSIVE
           ========================================== */
        @media (max-width: 1200px) {
            .cards-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .footer-inner {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .floating-stat-1 {
                right: 0;
            }
            
            .floating-stat-2 {
                left: -20px;
            }
        }
        
        @media (max-width: 1024px) {
            .nav {
                display: none;
            }
            
            .mobile-toggle {
                display: flex;
            }
            
            .hero-content {
                grid-template-columns: 1fr;
            }
            
            .hero-right {
                display: none;
            }
            
            .hero-left {
                max-width: 100%;
                text-align: center;
            }
            
            .hero-stats {
                justify-content: center;
            }
            
            .hero-location {
                margin-left: auto;
                margin-right: auto;
            }
            
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .header-inner {
                height: 68px;
            }
            
            .hero {
                padding-top: 68px;
            }
            
            .hero-container {
                padding: 40px 20px 80px;
            }
            
            .hero-title {
                font-size: 32px;
            }
            
            .hero-subtitle {
                font-size: 16px;
            }
            
            .hero-stats {
                flex-wrap: wrap;
                gap: 24px;
            }
            
            .stat-item {
                text-align: center;
            }
            
            .filter-bar {
                padding: 24px 20px;
            }
            
            .filter-top {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-row {
                flex-direction: column;
            }
            
            .filter-group {
                width: 100%;
            }
            
            .filter-actions {
                width: 100%;
                flex-wrap: wrap;
            }
            
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .footer-inner {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 40px;
            }
            
            .footer-brand p {
                max-width: 100%;
            }
            
            .footer-social {
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .hero-title {
                font-size: 28px;
            }
            
            .hero-badge {
                padding: 10px 18px;
            }
            
            .hero-stats {
                flex-direction: column;
            }
            
            .breadcrumb {
                font-size: 12px;
            }
        }
        
        .app-view .mobile-footer,
.app-view footer {
    display: none !important;
}

/* Fix bottom spacing only for app */
.app-view body {
    padding-bottom: 70px;
}

/* ===============================
   APP VIEW – ONLY CARDS VISIBLE
   (NO HEADER, NO HERO, NO BANNER)
================================ */

.app-view .header,
.app-view .hero,
.app-view .filter-bar,
.app-view .breadcrumb,
.app-view .footer,
.app-view footer {
    display: none !important;
    height: 0 !important;
    overflow: hidden !important;
    visibility: hidden !important;
}

/* Remove top spacing created by hidden sections */
.app-view .main {
    margin-top: 0 !important;
    padding-top: 16px !important;
}

/* Make cards full width in app */
.app-view .cards-grid {
    grid-template-columns: 1fr !important;
    gap: 16px;
}

/* Remove any background gaps */
.app-view body {
    background: #f9fafb;
}

/* APP VIEW – PERFECT CLEAN LOOK */
.app-view .main {
    margin-top: 0 !important;
    padding-top: 8px !important;
}

/* Move cards little down for beauty */
.app-view .cards-section {
    margin-top: 12px !important;
}

/* Remove extra white gap */
.app-view body {
    padding-top: 0 !important;
}

    </style>
</head>
<body class="<?php echo $isApp ? 'app-view' : 'web-view'; ?>">
    <!-- Header -->
    <header class="header" id="header">
        <div class="header-inner">
            <a href="index.php" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <span class="logo-text">Dial<span>Kiya</span></span>
            </a>
            
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="categories.php" class="nav-link">Categories</a>
                <a href="hotels.php" class="nav-link">Hotels</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
            </nav>
            
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <a href="index.php" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <span class="logo-text">Dial<span>Kiya</span></span>
                </a>
                <button class="mobile-close" id="mobileClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <a href="index.php" class="mobile-nav-link"><i class="fas fa-home"></i> Home</a>
            <a href="categories.php" class="mobile-nav-link"><i class="fas fa-th-large"></i>Categories</a>
            <a href="category.php?category=restaurant" class="mobile-nav-link"><i class="fas fa-utensils"></i> Restaurants</a>
            <a href="category.php?category=hotel" class="mobile-nav-link"><i class="fas fa-hotel"></i> Hotels</a>
            <a href="category.php?category=hospital" class="mobile-nav-link"><i class="fas fa-hospital"></i> Hospitals</a>
            <a href="help.php" class="mobile-nav-link"><i class="fas fa-info-circle"></i> Help</a>
        </div>
    </div>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        
        <div class="hero-container">
            <div class="hero-content">
                <!-- Left Content -->
                <div class="hero-left">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="index.php">Home</a>
                        <span>/</span>
                        <a href="categories.php">Categories</a>
                        <span>/</span>
                        <span class="current"><?php echo $categoryData['title']; ?></span>
                    </div>
                    
                    <!-- Category Badge -->
                    <div class="hero-badge">
                        <div class="hero-badge-icon">
                            <i class="fas <?php echo $categoryData['icon']; ?>"></i>
                        </div>
                        <span class="hero-badge-text"><?php echo $categoryData['title']; ?></span>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="hero-title">
                        Find Best <span class="highlight"><?php echo $categoryData['title']; ?></span> Near You
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="hero-subtitle">
                        <?php echo $categoryData['desc']; ?>. Get verified reviews, ratings, directions & contact details.
                    </p>
                    
                    <!-- Location -->
                    <div class="hero-location" id="locationBadge">
                        <div class="location-icon">
                            <i class="fas fa-location-arrow"></i>
                        </div>
                        <div class="location-text">
                            <span id="locationText">Detecting your location...</span>
                        </div>
                        <span class="location-change">Change</span>
                    </div>
                    
                    <!-- Stats -->
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-value" id="statCount">--<span>+</span></div>
                            <div class="stat-label">Places Found</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">5<span>km</span></div>
                            <div class="stat-label">Search Radius</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">4.5<span>★</span></div>
                            <div class="stat-label">Avg Rating</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Visual -->
                <div class="hero-right">
                    <div class="hero-image-card">
                        <img src="<?php echo $categoryData['image']; ?>" alt="<?php echo $categoryData['title']; ?>" class="hero-image">
                        <div class="hero-image-content">
                            <h3 class="hero-image-title">Top <?php echo $categoryData['title']; ?></h3>
                            <p class="hero-image-desc">Explore highly rated businesses in your area</p>
                            <div class="hero-image-tags">
                                <span class="hero-tag"><i class="fas fa-check-circle"></i> Verified</span>
                                <span class="hero-tag"><i class="fas fa-star"></i> Top Rated</span>
                                <span class="hero-tag"><i class="fas fa-map-marker-alt"></i> Nearby</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Stats -->
                    <div class="floating-stat floating-stat-1">
                        <div class="floating-stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="floating-stat-text">
                            <h5>Verified Listings</h5>
                            <p>100% Authentic</p>
                        </div>
                    </div>
                    
                    <div class="floating-stat floating-stat-2">
                        <div class="floating-stat-icon warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="floating-stat-text">
                            <h5>Top Rated</h5>
                            <p>4.5+ Stars</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <main class="main">
        <!-- Filter Bar --->
        
        <div class="filter-bar">
            <div class="filter-top">
                <div class="filter-title">
                    <div class="filter-title-icon">
                        <i class="fas <?php echo $categoryData['icon']; ?>"></i>
                    </div>
                    <div class="filter-title-text">
                        <h3><?php echo $categoryData['title']; ?> Near You</h3>
                        <p>Based on your current location</p>
                    </div>
                </div>
                <div class="results-badge">
                    <i class="fas fa-store"></i>
                    Showing <strong id="resultsCount">0</strong> results
                </div>
            </div>
            
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Rating</label>
                    <select class="filter-select" id="filterRating">
                        <option value="">All Ratings</option>
                        <option value="4.5">4.5+ Stars</option>
                        <option value="4">4+ Stars</option>
                        <option value="3">3+ Stars</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Price Level</label>
                    <select class="filter-select" id="filterPrice">
                        <option value="">All Prices</option>
                        <option value="0">₹ Budget</option>
                        <option value="1">₹₹ Moderate</option>
                        <option value="2">₹₹₹ Expensive</option>
                        <option value="3">₹₹₹₹ Luxury</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Sort By</label>
                    <select class="filter-select" id="sortBy">
                        <option value="rating">Highest Rated</option>
                        <option value="reviews">Most Popular</option>
                        <option value="distance">Nearest First</option>
                        <option value="name">Name (A-Z)</option>
                    </select>
                </div>
                
                <div class="filter-actions">
                    <button class="filter-btn" id="filterOpenNow">
                        <i class="fas fa-clock"></i>
                        Open Now
                    </button>
                    <button class="filter-clear" id="clearFilters">
                        <i class="fas fa-undo"></i>
                        Reset All
                    </button>
                </div>
            </div>
        </div>
        
        
        <!-- Cards Section -->
        <div class="cards-section">
            <!-- Skeleton Loader -->
            <div class="cards-grid" id="skeletonGrid">
                <?php for ($i = 0; $i < 8; $i++): ?>
                <div class="skeleton-card">
                    <div class="skeleton-image"></div>
                    <div class="skeleton-body">
                        <div class="skeleton-line lg"></div>
                        <div class="skeleton-line md"></div>
                                                <div class="skeleton-line sm"></div>
                        <div class="skeleton-line xs"></div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            
            <!-- Business Cards Grid -->
            <div class="cards-grid" id="cardsGrid" style="display: none;"></div>
            
            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <i class="fas <?php echo $categoryData['icon']; ?>"></i>
                </div>
                <h3>No <?php echo $categoryData['title']; ?> Found</h3>
                <p>We couldn't find any <?php echo strtolower($categoryData['title']); ?> in your area. Try expanding your search or changing location.</p>
                <button class="retry-btn" id="retryBtn">
                    <i class="fas fa-redo"></i>
                    Try Again
                </button>
            </div>
            
            <!-- Error State -->
            <div class="empty-state" id="errorState" style="display: none;">
                <div class="empty-icon error">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3>Something Went Wrong</h3>
                <p id="errorMsg">Failed to load businesses. Please check your connection and try again.</p>
                <button class="retry-btn" id="errorRetryBtn">
                    <i class="fas fa-redo"></i>
                    Retry
                </button>
            </div>
        </div>
        
        <!-- Load More -->
        <div class="load-more" id="loadMoreWrap" style="display: none;">
            <button class="load-more-btn" id="loadMoreBtn">
                <span class="btn-text">Load More <?php echo $categoryData['title']; ?></span>
                <div class="spinner"></div>
            </button>
        </div>
    </main>
    
    <!-- Footer -->
    <?php include 'footer.php';?>
    
    <script>
    (function() {
        'use strict';
        
        // ==========================================
        // CONFIGURATION
        // ==========================================
        const CONFIG = {
            category: '<?php echo $categorySlug; ?>',
            title: '<?php echo $categoryData['title']; ?>',
            icon: '<?php echo $categoryData['icon']; ?>',
            color: '<?php echo $categoryData['color']; ?>',
            defaultLat: 28.6139,
            defaultLng: 77.2090
        };
        
        // ==========================================
        // STATE
        // ==========================================
        const state = {
            lat: CONFIG.defaultLat,
            lng: CONFIG.defaultLng,
            places: [],
            filtered: [],
            nextToken: null,
            loading: false,
            locationName: 'New Delhi, India'
        };
        
        // ==========================================
        // DOM ELEMENTS
        // ==========================================
        const $ = id => document.getElementById(id);
        const DOM = {
            skeleton: $('skeletonGrid'),
            cards: $('cardsGrid'),
            empty: $('emptyState'),
            error: $('errorState'),
            errorMsg: $('errorMsg'),
            loadWrap: $('loadMoreWrap'),
            loadBtn: $('loadMoreBtn'),
            results: $('resultsCount'),
            statCount: $('statCount'),
            location: $('locationText'),
            locationBadge: $('locationBadge'),
            filterRating: $('filterRating'),
            filterPrice: $('filterPrice'),
            sortBy: $('sortBy'),
            filterOpen: $('filterOpenNow'),
            clearBtn: $('clearFilters'),
            retryBtn: $('retryBtn'),
            errorRetry: $('errorRetryBtn'),
            mobileToggle: $('mobileToggle'),
            mobileMenu: $('mobileMenu'),
            mobileClose: $('mobileClose'),
            header: $('header')
        };
        
        // ==========================================
        // INITIALIZE
        // ==========================================
        function init() {
            bindEvents();
            getLocation();
        }
        
        // ==========================================
        // EVENT BINDINGS
        // ==========================================
        function bindEvents() {
            // Filters
            DOM.filterRating.onchange = applyFilters;
            DOM.filterPrice.onchange = applyFilters;
            DOM.sortBy.onchange = applyFilters;
            DOM.filterOpen.onclick = toggleOpenFilter;
            DOM.clearBtn.onclick = clearFilters;
            
            // Load More
            DOM.loadBtn.onclick = loadMore;
            
            // Retry
            DOM.retryBtn.onclick = retry;
            DOM.errorRetry.onclick = retry;
            
            // Mobile Menu
            DOM.mobileToggle.onclick = openMobileMenu;
            DOM.mobileClose.onclick = closeMobileMenu;
            DOM.mobileMenu.onclick = e => {
                if (e.target === DOM.mobileMenu) closeMobileMenu();
            };
            
            // Header scroll
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    DOM.header.classList.add('scrolled');
                } else {
                    DOM.header.classList.remove('scrolled');
                }
            });
            
            // Escape key
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeMobileMenu();
            });
        }
        
        function openMobileMenu() {
            DOM.mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenu() {
            DOM.mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        function toggleOpenFilter() {
            DOM.filterOpen.classList.toggle('active');
            applyFilters();
        }
        
        // ==========================================
        // GEOLOCATION
        // ==========================================
        function getLocation() {
            DOM.location.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detecting location...';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        state.lat = position.coords.latitude;
                        state.lng = position.coords.longitude;
                        reverseGeocode(state.lat, state.lng);
                        fetchData();
                    },
                    error => {
                        console.log('Geolocation error:', error.message);
                        DOM.location.innerHTML = '<strong>New Delhi, India</strong> (Default)';
                        fetchData();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 300000
                    }
                );
            } else {
                DOM.location.innerHTML = '<strong>New Delhi, India</strong> (Default)';
                fetchData();
            }
        }
        
        function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            let city =
                data.address.city ||
                data.address.town ||
                data.address.village ||
                data.address.county ||
                data.address.state ||
                'Your Location';

            DOM.location.innerHTML = `<strong>${city}</strong>`;
            state.locationName = city;
        })
        .catch(() => {
            DOM.location.innerHTML = '<strong>Your Location</strong>';
        });
}

        
        // ==========================================
        // FETCH DATA
        // ==========================================
        function fetchData(token = null) {
            if (state.loading) return;
            state.loading = true;
            
            if (!token) {
                showSkeleton();
            } else {
                DOM.loadBtn.classList.add('loading');
            }
            
            let url = `?ajax=1&category=${CONFIG.category}&lat=${state.lat}&lng=${state.lng}`;
            if (token) url += `&page_token=${token}`;
            
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    state.loading = false;
                    DOM.loadBtn.classList.remove('loading');
                    
                    if (data.success) {
                        if (!token) {
                            state.places = [];
                        }
                        
                        // Add places with distance calculation
                        data.places.forEach(place => {
                            if (place.lat && place.lng) {
                                place.distance = calculateDistance(state.lat, state.lng, place.lat, place.lng);
                            } else {
                                place.distance = null;
                            }
                            state.places.push(place);
                        });
                        
                        state.nextToken = data.next_page_token;
                        
                        // Update stats
                        DOM.statCount.innerHTML = state.places.length + '<span>+</span>';
                        
                        // Apply filters and render
                        applyFilters();
                        hideSkeleton();
                        
                        // Show/hide load more
                        DOM.loadWrap.style.display = state.nextToken ? 'block' : 'none';
                        
                    } else {
                        showError(data.error || 'Failed to load data');
                    }
                })
                .catch(error => {
                    state.loading = false;
                    DOM.loadBtn.classList.remove('loading');
                    console.error('Fetch error:', error);
                    showError('Network error. Please check your connection.');
                });
        }
        
        // ==========================================
        // CALCULATE DISTANCE (Haversine formula)
        // ==========================================
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLng/2) * Math.sin(dLng/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
        function formatDistance(km) {
            if (km === null) return '';
            if (km < 1) {
                return Math.round(km * 1000) + ' m away';
            }
            return km.toFixed(1) + ' km away';
        }
        
        // ==========================================
        // RENDER CARDS
        // ==========================================
        function renderCards() {
            if (state.filtered.length === 0) {
                if (state.places.length === 0) {
                    DOM.cards.style.display = 'none';
                    DOM.empty.style.display = 'block';
                } else {
                    DOM.cards.innerHTML = `
                        <div class="empty-state" style="grid-column: 1/-1;">
                            <div class="empty-icon">
                                <i class="fas fa-filter"></i>
                            </div>
                            <h3>No Matching Results</h3>
                            <p>No businesses match your current filters. Try adjusting or clearing filters.</p>
                            <button class="retry-btn" onclick="document.getElementById('clearFilters').click()">
                                <i class="fas fa-undo"></i>
                                Clear Filters
                            </button>
                        </div>
                    `;
                    DOM.cards.style.display = 'grid';
                    DOM.empty.style.display = 'none';
                }
                DOM.results.textContent = '0';
                return;
            }
            
            let html = '';
            state.filtered.forEach((place, index) => {
                const stars = renderStars(place.rating);
                const price = renderPrice(place.price_level);
                const statusBadge = renderStatus(place.is_open);
                const distance = formatDistance(place.distance);
                
                html += `
                <div class="business-card" style="transition-delay: ${index * 0.05}s">
                    <div class="card-image">
                        ${place.photo 
                            ? `<img src="${place.photo}" alt="${escapeHtml(place.name)}" loading="lazy" onerror="this.parentElement.innerHTML='<div class=\\'card-placeholder\\'><i class=\\'fas ${CONFIG.icon}\\'></i><span>No Image</span></div>'">`
                            : `<div class="card-placeholder"><i class="fas ${CONFIG.icon}"></i><span>No Image</span></div>`
                        }
                        ${statusBadge}
                        <div class="card-category">
                            <i class="fas ${CONFIG.icon}"></i>
                            ${CONFIG.title}
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">${escapeHtml(place.name)}</h3>
                        
                        <div class="card-rating">
                            <div class="stars">${stars}</div>
                            <span class="rating-score">${place.rating.toFixed(1)}</span>
                            <span class="rating-count">(${formatNumber(place.reviews)})</span>
                        </div>
                        
                        <div class="card-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${escapeHtml(place.address)}</span>
                        </div>
                        
                        ${distance ? `
                        <div class="card-distance">
                            <i class="fas fa-route"></i>
                            ${distance}
                        </div>
                        ` : ''}
                        
                        <div class="card-footer">
                            <div class="card-price">${price}</div>
                            <a href="place_details.php?place_id=${place.place_id}" class="card-btn">
                                View Details
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                `;
            });
            
            DOM.cards.innerHTML = html;
            DOM.cards.style.display = 'grid';
            DOM.empty.style.display = 'none';
            DOM.results.textContent = state.filtered.length;
            
            // Animate cards
            setTimeout(() => {
                document.querySelectorAll('.business-card').forEach((card, i) => {
                    setTimeout(() => {
                        card.classList.add('loaded');
                    }, i * 50);
                });
            }, 100);
        }
        
        // ==========================================
        // HELPER FUNCTIONS
        // ==========================================
        function renderStars(rating) {
            let html = '';
            const fullStars = Math.floor(rating);
            const hasHalf = rating - fullStars >= 0.5;
            const emptyStars = 5 - fullStars - (hasHalf ? 1 : 0);
            
            for (let i = 0; i < fullStars; i++) {
                html += '<i class="fas fa-star"></i>';
            }
            if (hasHalf) {
                html += '<i class="fas fa-star-half-alt"></i>';
            }
            for (let i = 0; i < emptyStars; i++) {
                html += '<i class="far fa-star empty"></i>';
            }
            return html;
        }
        
        function renderPrice(level) {
            if (level === null || level === undefined) {
                return '<span>₹</span><span class="empty">₹₹₹</span>';
            }
            const filled = level + 1;
            const empty = 4 - filled;
            return '<span>' + '₹'.repeat(filled) + '</span><span class="empty">' + '₹'.repeat(empty) + '</span>';
        }
        
        function renderStatus(isOpen) {
            if (isOpen === null || isOpen === undefined) return '';
            return `
                <div class="card-status ${isOpen ? 'open' : 'closed'}">
                    <span class="status-dot"></span>
                    ${isOpen ? 'Open Now' : 'Closed'}
                </div>
            `;
        }
        
        function escapeHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
        
        function formatNumber(num) {
            if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
            if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
            return num.toString();
        }
        
        // ==========================================
        // FILTERS
        // ==========================================
        function applyFilters() {
            const ratingFilter = parseFloat(DOM.filterRating.value) || 0;
            const priceFilter = DOM.filterPrice.value;
            const sortBy = DOM.sortBy.value;
            const openOnly = DOM.filterOpen.classList.contains('active');
            
            // Filter
            state.filtered = state.places.filter(place => {
                if (ratingFilter > 0 && place.rating < ratingFilter) return false;
                if (priceFilter !== '' && place.price_level !== parseInt(priceFilter)) return false;
                if (openOnly && !place.is_open) return false;
                return true;
            });
            
            // Sort
            state.filtered.sort((a, b) => {
                switch (sortBy) {
                    case 'rating':
                        return b.rating - a.rating;
                    case 'reviews':
                        return b.reviews - a.reviews;
                    case 'distance':
                        if (a.distance === null) return 1;
                        if (b.distance === null) return -1;
                        return a.distance - b.distance;
                    case 'name':
                        return a.name.localeCompare(b.name);
                    default:
                        return 0;
                }
            });
            
            renderCards();
        }
        
        function clearFilters() {
            DOM.filterRating.value = '';
            DOM.filterPrice.value = '';
            DOM.sortBy.value = 'rating';
            DOM.filterOpen.classList.remove('active');
            applyFilters();
        }
        
        // ==========================================
        // LOAD MORE
        // ==========================================
        function loadMore() {
            if (state.nextToken && !state.loading) {
                DOM.loadBtn.classList.add('loading');
                // Google requires delay between pagination requests
                setTimeout(() => {
                    fetchData(state.nextToken);
                }, 2000);
            }
        }
        
        // ==========================================
        // UI STATES
        // ==========================================
        function showSkeleton() {
            DOM.skeleton.style.display = 'grid';
            DOM.cards.style.display = 'none';
            DOM.empty.style.display = 'none';
            DOM.error.style.display = 'none';
            DOM.loadWrap.style.display = 'none';
        }
        
        function hideSkeleton() {
            DOM.skeleton.style.display = 'none';
            DOM.cards.style.display = 'grid';
        }
        
        function showError(message) {
            DOM.skeleton.style.display = 'none';
            DOM.cards.style.display = 'none';
            DOM.empty.style.display = 'none';
            DOM.loadWrap.style.display = 'none';
            DOM.error.style.display = 'block';
            DOM.errorMsg.textContent = message;
        }
        
        function retry() {
            state.places = [];
            state.filtered = [];
            state.nextToken = null;
            getLocation();
        }
        
        // ==========================================
        // START
        // ==========================================
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
    </script>
</body>
</html>
<?php ob_end_flush(); ?>
<?php $currentPage = 'discount'; ?>
<?php include_once 'app-detect.php'; ?>
<?php
// =============================================
// FIND BUSINESS - DISCOUNT PAGE WITH DETAILED OFFERS
// =============================================

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// ============================
// API KEY
// ============================
$API_KEY = "AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU"; // Your API key

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
// GET PARAMETERS
// ============================
$city = trim($_GET['city'] ?? '');
if (empty($city)) {
    $city = $_SESSION['user_city'] ?? 'vapi';
}
$city = preg_replace('/[^a-zA-Z0-9\s]/', '', $city);
$city = strtolower($city);

$category = $_GET['category'] ?? 'all';
$is_app = isset($_GET['app']) || isset($_GET['webview']) || (isset($isApp) && $isApp);

// ============================
// OFFER TEMPLATES - REALISTIC DEALS
// ============================
$offerTemplates = [
    'restaurant' => [
        ['type' => 'combo', 'title' => 'Combo Meal Deal', 'discount' => '20% OFF', 'desc' => 'Get 20% off on all combo meals', 'valid' => 'Valid till month end', 'code' => 'COMBO20'],
        ['type' => 'family', 'title' => 'Family Pack Offer', 'discount' => '₹200 OFF', 'desc' => 'Flat ₹200 off on orders above ₹800', 'valid' => 'Weekends only', 'code' => 'FAMILY200'],
        ['type' => 'lunch', 'title' => 'Lunch Special', 'discount' => '15% OFF', 'desc' => 'Special lunch discount 12PM-3PM', 'valid' => 'Mon-Fri', 'code' => 'LUNCH15'],
        ['type' => 'first', 'title' => 'First Visit Offer', 'discount' => '25% OFF', 'desc' => 'First time customers get 25% off', 'valid' => 'New customers only', 'code' => 'FIRST25'],
        ['type' => 'couple', 'title' => 'Couple Dining Deal', 'discount' => 'Buy 1 Get 1', 'desc' => 'Buy 1 main course, get 1 free', 'valid' => 'Tue & Wed', 'code' => 'COUPLE'],
    ],
    'hotel' => [
        ['type' => 'stay', 'title' => 'Extended Stay Offer', 'discount' => '30% OFF', 'desc' => 'Stay 3 nights, pay for 2', 'valid' => 'Book 7 days advance', 'code' => 'STAY30'],
        ['type' => 'weekend', 'title' => 'Weekend Getaway', 'discount' => '25% OFF', 'desc' => 'Special weekend room rates', 'valid' => 'Fri-Sun', 'code' => 'WEEKEND25'],
        ['type' => 'early', 'title' => 'Early Bird Discount', 'discount' => '20% OFF', 'desc' => 'Book 15 days in advance', 'valid' => 'Limited rooms', 'code' => 'EARLY20'],
        ['type' => 'couple', 'title' => 'Honeymoon Package', 'discount' => '₹1500 OFF', 'desc' => 'Special couple package with dinner', 'valid' => 'Include breakfast', 'code' => 'HONEY'],
        ['type' => 'business', 'title' => 'Business Traveler', 'discount' => '15% OFF', 'desc' => 'Corporate booking discount', 'valid' => 'With company ID', 'code' => 'BIZ15'],
    ],
    'salon' => [
        ['type' => 'haircut', 'title' => 'Haircut + Styling', 'discount' => '40% OFF', 'desc' => 'Haircut with free styling', 'valid' => 'First visit', 'code' => 'HAIR40'],
        ['type' => 'spa', 'title' => 'Spa Day Package', 'discount' => '₹500 OFF', 'desc' => 'Full body spa + facial combo', 'valid' => 'Weekdays', 'code' => 'SPA500'],
        ['type' => 'bridal', 'title' => 'Bridal Makeup', 'discount' => '20% OFF', 'desc' => 'Complete bridal package', 'valid' => 'Advance booking', 'code' => 'BRIDE20'],
        ['type' => 'facial', 'title' => 'Premium Facial', 'discount' => 'Buy 2 Get 1', 'desc' => 'Book 2 facials, get 1 free', 'valid' => 'Any facial', 'code' => 'FACIAL'],
        ['type' => 'grooming', 'title' => 'Men\'s Grooming', 'discount' => '30% OFF', 'desc' => 'Beard + haircut combo', 'valid' => 'All days', 'code' => 'MEN30'],
    ],
    'hospital' => [
        ['type' => 'checkup', 'title' => 'Health Checkup', 'discount' => '50% OFF', 'desc' => 'Complete body checkup package', 'valid' => 'Book online', 'code' => 'HEALTH50'],
        ['type' => 'dental', 'title' => 'Dental Care', 'discount' => '30% OFF', 'desc' => 'Teeth cleaning & checkup', 'valid' => 'First visit', 'code' => 'DENTAL30'],
        ['type' => 'eye', 'title' => 'Eye Checkup', 'discount' => 'FREE', 'desc' => 'Free eye examination', 'valid' => 'With glasses purchase', 'code' => 'EYEFREE'],
        ['type' => 'vaccine', 'title' => 'Vaccination Camp', 'discount' => '25% OFF', 'desc' => 'All vaccinations discounted', 'valid' => 'Limited period', 'code' => 'VAX25'],
        ['type' => 'consult', 'title' => 'Online Consultation', 'discount' => '₹100 OFF', 'desc' => 'First online doctor consult', 'valid' => 'New users', 'code' => 'DOC100'],
    ],
    'gym' => [
        ['type' => 'annual', 'title' => 'Annual Membership', 'discount' => '40% OFF', 'desc' => '12 months at price of 7', 'valid' => 'Limited slots', 'code' => 'GYM40'],
        ['type' => 'couple', 'title' => 'Couple Membership', 'discount' => '50% OFF', 'desc' => 'Partner joins at half price', 'valid' => 'Join together', 'code' => 'FIT50'],
        ['type' => 'trainer', 'title' => 'Personal Training', 'discount' => '3 FREE Sessions', 'desc' => 'Free PT sessions with membership', 'valid' => 'New members', 'code' => 'PT3FREE'],
        ['type' => 'morning', 'title' => 'Early Bird Batch', 'discount' => '25% OFF', 'desc' => 'Morning 5AM-8AM slot discount', 'valid' => 'Mon-Sat', 'code' => 'EARLY25'],
        ['type' => 'student', 'title' => 'Student Offer', 'discount' => '35% OFF', 'desc' => 'Special student membership', 'valid' => 'With ID proof', 'code' => 'STUDENT35'],
    ],
    'shopping' => [
        ['type' => 'sale', 'title' => 'Season Sale', 'discount' => 'Up to 60% OFF', 'desc' => 'End of season clearance', 'valid' => 'While stocks last', 'code' => 'SEASON60'],
        ['type' => 'bogo', 'title' => 'Buy 1 Get 1 Free', 'discount' => 'BOGO', 'desc' => 'On selected items', 'valid' => 'Limited period', 'code' => 'BOGO'],
        ['type' => 'cashback', 'title' => 'Cashback Offer', 'discount' => '₹300 Cashback', 'desc' => 'On purchase above ₹1500', 'valid' => 'Card payments', 'code' => 'CASH300'],
        ['type' => 'member', 'title' => 'Member Exclusive', 'discount' => 'Extra 10% OFF', 'desc' => 'Additional discount for members', 'valid' => 'Loyalty members', 'code' => 'MEMBER10'],
        ['type' => 'weekend', 'title' => 'Weekend Special', 'discount' => '20% OFF', 'desc' => 'All products discounted', 'valid' => 'Sat & Sun only', 'code' => 'WKND20'],
    ],
    'cafe' => [
        ['type' => 'coffee', 'title' => 'Coffee Lovers', 'discount' => 'Buy 1 Get 1', 'desc' => 'On all coffee beverages', 'valid' => '3PM-6PM', 'code' => 'COFFEE'],
        ['type' => 'combo', 'title' => 'Snack Combo', 'discount' => '25% OFF', 'desc' => 'Coffee + snack combo deal', 'valid' => 'All day', 'code' => 'SNACK25'],
        ['type' => 'happy', 'title' => 'Happy Hours', 'discount' => '30% OFF', 'desc' => 'All beverages discounted', 'valid' => '4PM-7PM', 'code' => 'HAPPY30'],
        ['type' => 'loyalty', 'title' => 'Loyalty Reward', 'discount' => '5th Coffee FREE', 'desc' => 'Every 5th coffee on us', 'valid' => 'With loyalty card', 'code' => 'LOYAL5'],
        ['type' => 'breakfast', 'title' => 'Breakfast Deal', 'discount' => '₹99 Combo', 'desc' => 'Coffee + sandwich at ₹99', 'valid' => '8AM-11AM', 'code' => 'BFAST99'],
    ],
    'other' => [
        ['type' => 'new', 'title' => 'New Customer Offer', 'discount' => '15% OFF', 'desc' => 'Welcome discount for new customers', 'valid' => 'First purchase', 'code' => 'NEW15'],
        ['type' => 'refer', 'title' => 'Refer & Earn', 'discount' => '₹200 OFF', 'desc' => 'Refer a friend, both get ₹200', 'valid' => 'Unlimited referrals', 'code' => 'REFER200'],
        ['type' => 'app', 'title' => 'App Exclusive', 'discount' => '10% OFF', 'desc' => 'Extra discount on app booking', 'valid' => 'App users only', 'code' => 'APP10'],
    ]
];

// ============================
// CATEGORY TYPES
// ============================
$categoryTypes = [
    'all' => ['restaurant', 'hotel', 'beauty_salon', 'hospital', 'gym', 'shopping_mall', 'cafe'],
    'restaurant' => ['restaurant', 'food', 'meal_takeaway'],
    'hotel' => ['hotel', 'lodging'],
    'salon' => ['beauty_salon', 'hair_care', 'spa'],
    'hospital' => ['hospital', 'doctor', 'dentist', 'pharmacy'],
    'gym' => ['gym', 'fitness_center'],
    'shopping' => ['shopping_mall', 'store', 'clothing_store'],
    'cafe' => ['cafe', 'bakery', 'coffee_shop']
];

$searchTypes = $categoryTypes[$category] ?? $categoryTypes['all'];

// ============================
// FETCH FROM GOOGLE API
// ============================
$allResults = [];
$categoryCounts = [];

foreach ($searchTypes as $type) {
    $queryString = $type . " in " . $city;
    
    $apiUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
    $apiUrl .= "query=" . urlencode($queryString);
    $apiUrl .= "&key=" . $API_KEY;
    $apiUrl .= "&region=in";
    
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
    
    if (isset($data['results'])) {
        foreach ($data['results'] as $place) {
            $placeId = $place['place_id'];
            if (!isset($allResults[$placeId])) {
                // Detect category
                $placeCategory = detectPlaceCategory($place['types'] ?? []);
                $place['detected_category'] = $placeCategory;
                
                // Generate detailed offers
                $place['offers'] = generateDetailedOffers($place, $placeCategory, $offerTemplates);
                
                // Check if has valid offers
                $place['has_offer'] = !empty($place['offers']);
                
                // Primary offer (for card display)
                $place['primary_offer'] = $place['offers'][0] ?? null;
                
                $allResults[$placeId] = $place;
                
                // Count categories
                if (!isset($categoryCounts[$placeCategory])) {
                    $categoryCounts[$placeCategory] = 0;
                }
                $categoryCounts[$placeCategory]++;
            }
        }
    }
}

// Convert to array and filter
$results = array_values($allResults);
$results = array_filter($results, fn($p) => $p['has_offer']);
$results = array_values($results);

// Sort by rating
usort($results, fn($a, $b) => ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0));

$totalResults = count($results);
$categoryCounts['all'] = $totalResults;

// ============================
// HELPER FUNCTIONS
// ============================
function detectPlaceCategory($types) {
    $map = [
        'restaurant' => ['restaurant', 'food', 'meal_takeaway', 'meal_delivery'],
        'hotel' => ['lodging', 'hotel'],
        'salon' => ['beauty_salon', 'hair_care', 'spa'],
        'hospital' => ['hospital', 'doctor', 'dentist', 'pharmacy', 'health'],
        'gym' => ['gym', 'fitness_center'],
        'shopping' => ['shopping_mall', 'store', 'clothing_store', 'shop'],
        'cafe' => ['cafe', 'bakery', 'coffee']
    ];
    
    foreach ($map as $cat => $keywords) {
        foreach ($types as $type) {
            foreach ($keywords as $keyword) {
                if (stripos($type, $keyword) !== false) {
                    return $cat;
                }
            }
        }
    }
    return 'other';
}

function generateDetailedOffers($place, $category, $templates) {
    $offers = [];
    $categoryTemplates = $templates[$category] ?? $templates['other'];
    
    // Determine number of offers based on rating and reviews
    $rating = $place['rating'] ?? 0;
    $reviews = $place['user_ratings_total'] ?? 0;
    
    $numOffers = 1;
    if ($rating >= 4.5 && $reviews >= 100) {
        $numOffers = 3;
    } elseif ($rating >= 4.0 && $reviews >= 50) {
        $numOffers = 2;
    } elseif ($rating >= 3.5 || $reviews >= 20) {
        $numOffers = 1;
    } else {
        return []; // No offers for low-rated places
    }
    
    // Shuffle and pick offers
    shuffle($categoryTemplates);
    $selectedOffers = array_slice($categoryTemplates, 0, $numOffers);
    
    foreach ($selectedOffers as $template) {
        $offers[] = [
            'type' => $template['type'],
            'title' => $template['title'],
            'discount' => $template['discount'],
            'description' => $template['desc'],
            'validity' => $template['valid'],
            'code' => $template['code'],
            'terms' => generateTerms($template['type']),
            'saves' => rand(50, 500), // Random savings
        ];
    }
    
    return $offers;
}

function generateTerms($type) {
    $commonTerms = [
        'Cannot be combined with other offers',
        'Subject to availability',
        'Management reserves right to modify offer'
    ];
    
    $specificTerms = [
        'combo' => 'Valid on dine-in only',
        'family' => 'Minimum 4 members required',
        'stay' => 'Blackout dates may apply',
        'haircut' => 'Prior appointment required',
        'checkup' => 'Fasting required for some tests',
        'annual' => 'Non-refundable, non-transferable',
        'sale' => 'No exchange or return on sale items',
        'coffee' => 'Second beverage of equal or lesser value',
    ];
    
    $terms = $commonTerms;
    if (isset($specificTerms[$type])) {
        array_unshift($terms, $specificTerms[$type]);
    }
    
    return $terms;
}

function getPhotoUrl($photos, $apiKey, $maxWidth = 400) {
    if (!empty($photos[0]['photo_reference'])) {
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photoreference=" 
            . $photos[0]['photo_reference'] . "&key={$apiKey}";
    }
    return "";
}

function makeSlug($string) {
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $string)));
    return trim($slug, '-');
}

function getOfferIcon($type) {
    $icons = [
        'combo' => 'fa-utensils',
        'family' => 'fa-users',
        'lunch' => 'fa-sun',
        'first' => 'fa-star',
        'couple' => 'fa-heart',
        'stay' => 'fa-bed',
        'weekend' => 'fa-calendar-week',
        'early' => 'fa-clock',
        'haircut' => 'fa-cut',
        'spa' => 'fa-spa',
        'bridal' => 'fa-ring',
        'checkup' => 'fa-stethoscope',
        'dental' => 'fa-tooth',
        'annual' => 'fa-dumbbell',
        'trainer' => 'fa-running',
        'sale' => 'fa-percent',
        'bogo' => 'fa-gift',
        'coffee' => 'fa-coffee',
        'happy' => 'fa-glass-cheers',
    ];
    return $icons[$type] ?? 'fa-tag';
}

function getOfferColor($discount) {
    if (strpos($discount, 'FREE') !== false || strpos($discount, 'BOGO') !== false) {
        return '#10B981'; // Green
    }
    if (strpos($discount, '50') !== false || strpos($discount, '60') !== false) {
        return '#EF4444'; // Red - Hot deal
    }
    if (strpos($discount, '40') !== false || strpos($discount, '30') !== false) {
        return '#F59E0B'; // Orange
    }
    return '#FF6B35'; // Primary
}

// SEO
$pageTitle = "Best Discounts & Offers in " . ucfirst($city) . " - Find Business";
$pageDesc = "Find exclusive discounts, deals & offers in " . ucfirst($city) . ". Save on restaurants, hotels, salons, gyms and more!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <link rel="canonical" href="https://find-business.com/discounts/<?php echo $city; ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #E85A2A;
            --dark: #1a1a1a;
            --gray: #666;
            --light: #f5f5f5;
            --white: #fff;
            --green: #10B981;
            --red: #EF4444;
            --orange: #F59E0B;
            --shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: #333;
            line-height: 1.6;
        }

        <?php if($is_app): ?>
        .site-header, .site-footer, header, footer { display: none !important; }
        <?php endif; ?>

        /* ========================================
           HERO SECTION - GRAY THEME
           ======================================== */
        .hero {
            background: linear-gradient(160deg, #0a0a0a 0%, #1a1a1a 30%, #2a2a2a 60%, #333 100%);
            padding: 80px 20px 100px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,107,53,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 50px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
        }

        .hero-badge i { color: var(--primary); }

        .hero-badge .dot {
            width: 8px;
            height: 8px;
            background: var(--green);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.2); }
        }

        .hero h1 {
            font-size: clamp(28px, 6vw, 48px);
            font-weight: 800;
            color: #fff;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero h1 span { color: var(--primary); }

        .hero p {
            font-size: 16px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .location-btn {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: #fff;
            padding: 15px 30px;
            border-radius: 16px;
            cursor: pointer;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }

        .location-btn:hover {
            transform: translateY(-3px);
        }

        .location-btn .icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
        }

        .location-btn .text { text-align: left; }
        .location-btn .label { font-size: 12px; color: #888; }
        .location-btn .city-name {
            font-size: 20px;
            font-weight: 700;
            color: #222;
            text-transform: capitalize;
        }
        .location-btn .change { color: var(--primary); font-size: 12px; font-weight: 600; }

        /* ========================================
           CATEGORIES
           ======================================== */
        .categories-section {
            background: #fff;
            padding: 50px 20px 30px;
            margin-top: -40px;
            border-radius: 40px 40px 0 0;
            position: relative;
            z-index: 10;
        }

        .container { max-width: 1200px; margin: 0 auto; }

        .section-head {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-head h2 {
            font-size: 24px;
            font-weight: 700;
            color: #222;
            margin-bottom: 5px;
        }

        .section-head p { color: #888; font-size: 14px; }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
            gap: 12px;
        }

        .cat-card {
            background: var(--light);
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 20px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .cat-card:hover, .cat-card.active {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .cat-card.active {
            background: var(--primary);
        }

        .cat-card.active .cat-icon,
        .cat-card.active .cat-name,
        .cat-card.active .cat-count { color: #fff; }

        .cat-card.active .cat-icon { background: rgba(255,255,255,0.2); }

        .cat-icon {
            width: 50px;
            height: 50px;
            background: #fff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 22px;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .cat-name { font-size: 12px; font-weight: 600; color: #444; }
        .cat-count { font-size: 11px; color: #999; }

        /* ========================================
           DISCOUNTS SECTION
           ======================================== */
        .discounts-section {
            background: var(--light);
            padding: 30px 20px 80px;
        }

        .stats-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            background: #fff;
            padding: 15px 20px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stats-text { font-size: 15px; color: #666; }
        .stats-text strong { color: #222; font-weight: 700; }

        .sort-select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            cursor: pointer;
        }

        .discounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        @media (max-width: 700px) {
            .discounts-grid { grid-template-columns: 1fr; }
        }

        /* ========================================
           DISCOUNT CARD - ENHANCED
           ======================================== */
        .discount-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .discount-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }

        .card-header {
            position: relative;
            height: 160px;
            overflow: hidden;
        }

        .card-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-header .placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: linear-gradient(135deg, #e0e0e0, #f0f0f0);
            font-size: 50px;
            color: #ccc;
        }

        .card-header .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
        }

        .card-header .business-name {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 3px;
        }

        .card-header .business-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: rgba(255,255,255,0.8);
        }

        .card-header .rating {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(255,255,255,0.2);
            padding: 3px 8px;
            border-radius: 5px;
        }

        .card-header .rating i { color: #FFD700; font-size: 10px; }

        .card-header .category-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(0,0,0,0.6);
            color: #fff;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Offers Section */
        .card-offers {
            padding: 15px;
        }

        .offer-item {
            background: linear-gradient(135deg, #FFF7ED, #FFEDD5);
            border: 1px solid #FED7AA;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
        }

        .offer-item.hot {
            background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
            border-color: #FECACA;
        }

        .offer-item.green {
            background: linear-gradient(135deg, #ECFDF5, #D1FAE5);
            border-color: #A7F3D0;
        }

        .offer-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
        }

        .offer-item.hot::before { background: var(--red); }
        .offer-item.green::before { background: var(--green); }

        .offer-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .offer-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .offer-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
        }

        .offer-item.hot .offer-icon { background: var(--red); }
        .offer-item.green .offer-icon { background: var(--green); }

        .offer-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .offer-discount {
            background: var(--primary);
            color: #fff;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .offer-item.hot .offer-discount { background: var(--red); }
        .offer-item.green .offer-discount { background: var(--green); }

        .offer-desc {
            font-size: 13px;
            color: #555;
            margin-bottom: 8px;
            padding-left: 46px;
        }

        .offer-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 46px;
        }

        .offer-validity {
            font-size: 11px;
            color: #888;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .offer-validity i { color: var(--orange); }

        .offer-code {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px dashed #ccc;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            transition: all 0.3s;
        }

        .offer-code:hover {
            border-color: var(--primary);
            background: #FFF7ED;
        }

        .offer-code i { color: var(--primary); font-size: 10px; }

        /* More Offers Button */
        .more-offers-btn {
            width: 100%;
            padding: 10px;
            background: #f5f5f5;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s;
            font-family: inherit;
        }

        .more-offers-btn:hover {
            background: #eee;
        }

        /* Card Footer */
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-top: 1px solid #f0f0f0;
            background: #FAFAFA;
        }

        .card-location {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #888;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .btn-details {
            display: flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255,107,53,0.3);
        }

        .btn-details:hover {
            transform: scale(1.05);
        }

        .btn-save {
            width: 40px;
            height: 40px;
            border: 2px solid #ddd;
            background: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-save:hover {
            border-color: var(--red);
            color: var(--red);
        }

        .btn-save.saved {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        /* ========================================
           OFFER DETAIL MODAL
           ======================================== */
        .offer-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 20px;
        }

        .offer-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .offer-modal-box {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 500px;
            max-height: 85vh;
            overflow: hidden;
            transform: translateY(30px);
            transition: all 0.3s;
        }

        .offer-modal.show .offer-modal-box {
            transform: translateY(0);
        }

        .offer-modal-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 25px;
            position: relative;
        }

        .offer-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .offer-modal-discount {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .offer-modal-title {
            font-size: 18px;
            font-weight: 600;
            opacity: 0.9;
        }

        .offer-modal-body {
            padding: 25px;
            max-height: 50vh;
            overflow-y: auto;
        }

        .offer-detail-row {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .offer-detail-icon {
            width: 40px;
            height: 40px;
            background: #f5f5f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 16px;
            flex-shrink: 0;
        }

        .offer-detail-content h4 {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .offer-detail-content p {
            font-size: 13px;
            color: #666;
        }

        .offer-code-box {
            background: #FFF7ED;
            border: 2px dashed var(--primary);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }

        .offer-code-label {
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
        }

        .offer-code-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 3px;
        }

        .offer-copy-btn {
            margin-top: 10px;
            padding: 10px 25px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.3s;
        }

        .offer-copy-btn:hover {
            background: var(--primary-dark);
        }

        .offer-terms {
            background: #f5f5f5;
            border-radius: 12px;
            padding: 15px;
        }

        .offer-terms h4 {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .offer-terms ul {
            list-style: none;
            font-size: 12px;
            color: #666;
        }

        .offer-terms li {
            padding: 5px 0;
            padding-left: 20px;
            position: relative;
        }

        .offer-terms li::before {
            content: '•';
            position: absolute;
            left: 5px;
            color: var(--primary);
        }

        /* ========================================
           EMPTY STATE
           ======================================== */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            grid-column: 1 / -1;
        }

        .empty-state .icon {
            width: 100px;
            height: 100px;
            background: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 40px;
            color: #aaa;
        }

        .empty-state h3 { font-size: 22px; color: #333; margin-bottom: 10px; }
        .empty-state p { color: #888; max-width: 350px; margin: 0 auto; }

        /* ========================================
           CITY MODAL
           ======================================== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 20px;
        }

        .modal-overlay.show { opacity: 1; visibility: visible; }

        .modal-box {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 420px;
            max-height: 80vh;
            overflow: hidden;
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 { font-size: 20px; font-weight: 700; }

        .modal-close {
            width: 40px;
            height: 40px;
            border: none;
            background: #f0f0f0;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            color: #666;
        }

        .modal-content {
            padding: 25px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .search-input-wrap {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input-wrap input {
            width: 100%;
            padding: 14px 18px 14px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 14px;
            font-size: 15px;
            font-family: inherit;
        }

        .search-input-wrap input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-input-wrap i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .detect-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 16px;
            background: rgba(255,107,53,0.1);
            border: 2px dashed var(--primary);
            border-radius: 14px;
            color: var(--primary);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            margin-bottom: 25px;
        }

        .cities-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .city-item {
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            transition: all 0.3s;
            background: #fff;
        }

        .city-item:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #222;
            color: #fff;
            padding: 14px 30px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            z-index: 10000;
            opacity: 0;
            transition: all 0.3s;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero { padding: 60px 15px 80px; }
            .hero h1 { font-size: 26px; }
            .categories-grid { grid-template-columns: repeat(4, 1fr); }
            .discounts-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php if(!$is_app): ?>
    <?php @include 'header.php'; ?>
<?php endif; ?>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <i class="fas fa-bolt"></i>
            <span>Exclusive Local Offers</span>
            <span class="dot"></span>
        </div>
        <h1>Discover Amazing <span>Discounts</span><br>Near You</h1>
        <p>Find verified offers from local businesses in your city. Hotels, restaurants, salons, and more!</p>
        <div class="location-btn" onclick="openCityModal()">
            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="text">
                <div class="label">Showing offers in</div>
                <div>
                    <span class="city-name"><?php echo ucfirst($city); ?></span>
                    <span class="change">• Change</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORIES -->
<section class="categories-section">
    <div class="container">
        <div class="section-head">
            <h2>Browse by Category</h2>
            <p>Find the best deals in your favorite categories</p>
        </div>
        <div class="categories-grid">
            <?php
            $cats = [
                'all' => ['icon' => 'fa-th-large', 'name' => 'All'],
                'restaurant' => ['icon' => 'fa-utensils', 'name' => 'Food'],
                'hotel' => ['icon' => 'fa-hotel', 'name' => 'Hotels'],
                'salon' => ['icon' => 'fa-cut', 'name' => 'Salon'],
                'hospital' => ['icon' => 'fa-hospital', 'name' => 'Health'],
                'gym' => ['icon' => 'fa-dumbbell', 'name' => 'Fitness'],
                'shopping' => ['icon' => 'fa-shopping-bag', 'name' => 'Shop'],
                'cafe' => ['icon' => 'fa-coffee', 'name' => 'Cafe'],
            ];
            foreach ($cats as $catKey => $catInfo):
            ?>
            <a href="?city=<?php echo $city; ?>&category=<?php echo $catKey; ?>" 
               class="cat-card <?php echo $category === $catKey ? 'active' : ''; ?>">
                <div class="cat-icon"><i class="fas <?php echo $catInfo['icon']; ?>"></i></div>
                <div class="cat-name"><?php echo $catInfo['name']; ?></div>
                <div class="cat-count"><?php echo $categoryCounts[$catKey] ?? 0; ?></div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- DISCOUNTS -->
<section class="discounts-section">
    <div class="container">
        <div class="stats-bar">
            <span class="stats-text">
                Found <strong><?php echo $totalResults; ?></strong> offers in 
                <strong><?php echo ucfirst($city); ?></strong>
            </span>
            <select class="sort-select" id="sortSelect" onchange="sortResults()">
                <option value="rating">Highest Rated</option>
                <option value="offers">Most Offers</option>
                <option value="name">Name A-Z</option>
            </select>
        </div>
        
        <div class="discounts-grid" id="discountsGrid">
            <?php if (empty($results)): ?>
                <div class="empty-state">
                    <div class="icon"><i class="fas fa-search"></i></div>
                    <h3>No offers found</h3>
                    <p>We couldn't find any offers in <?php echo ucfirst($city); ?>. Try a different city or category.</p>
                </div>
            <?php else: ?>
                <?php foreach ($results as $place): ?>
                    <?php 
                    $photoUrl = getPhotoUrl($place['photos'] ?? [], $API_KEY);
                    $area = explode(',', $place['formatted_address'] ?? '')[0];
                    $slug = makeSlug($place['name']);
                    $catName = ucfirst($place['detected_category']);
                    $detailUrl = "/place/" . $slug . "-" . $place['place_id'];
                    $offers = $place['offers'];
                    $primaryOffer = $offers[0] ?? null;
                    $offerCount = count($offers);
                    ?>
                    <article class="discount-card" 
                             data-rating="<?php echo $place['rating'] ?? 0; ?>" 
                             data-offers="<?php echo $offerCount; ?>" 
                             data-name="<?php echo htmlspecialchars($place['name']); ?>">
                        
                        <!-- Card Header with Image -->
                        <div class="card-header">
                            <?php if ($photoUrl): ?>
                                <img src="<?php echo $photoUrl; ?>" alt="<?php echo htmlspecialchars($place['name']); ?>" loading="lazy">
                            <?php else: ?>
                                <div class="placeholder"><i class="fas fa-store"></i></div>
                            <?php endif; ?>
                            
                            <span class="category-tag"><?php echo $catName; ?></span>
                            
                            <div class="overlay">
                                <div class="business-name"><?php echo htmlspecialchars($place['name']); ?></div>
                                <div class="business-info">
                                    <?php if (isset($place['rating'])): ?>
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        <?php echo number_format($place['rating'], 1); ?>
                                    </span>
                                    <?php endif; ?>
                                    <span><?php echo $place['user_ratings_total'] ?? 0; ?> reviews</span>
                                    <span><?php echo $offerCount; ?> offer<?php echo $offerCount > 1 ? 's' : ''; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Offers Section -->
                        <div class="card-offers">
                            <?php 
                            $displayOffers = array_slice($offers, 0, 2);
                            foreach ($displayOffers as $index => $offer): 
                                $offerClass = '';
                                if (strpos($offer['discount'], 'FREE') !== false || strpos($offer['discount'], '50') !== false) {
                                    $offerClass = 'hot';
                                } elseif (strpos($offer['discount'], 'BOGO') !== false) {
                                    $offerClass = 'green';
                                }
                            ?>
                            <div class="offer-item <?php echo $offerClass; ?>">
                                <div class="offer-header">
                                    <div class="offer-title-wrap">
                                        <div class="offer-icon">
                                            <i class="fas <?php echo getOfferIcon($offer['type']); ?>"></i>
                                        </div>
                                        <span class="offer-title"><?php echo $offer['title']; ?></span>
                                    </div>
                                    <span class="offer-discount"><?php echo $offer['discount']; ?></span>
                                </div>
                                <p class="offer-desc"><?php echo $offer['description']; ?></p>
                                <div class="offer-meta">
                                    <span class="offer-validity">
                                        <i class="fas fa-clock"></i>
                                        <?php echo $offer['validity']; ?>
                                    </span>
                                    <span class="offer-code" onclick="showOfferDetail(<?php echo htmlspecialchars(json_encode($offer)); ?>, '<?php echo htmlspecialchars($place['name']); ?>')">
                                        <i class="fas fa-ticket-alt"></i>
                                        <?php echo $offer['code']; ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <?php if ($offerCount > 2): ?>
                            <button class="more-offers-btn" onclick="showAllOffers(<?php echo htmlspecialchars(json_encode($offers)); ?>, '<?php echo htmlspecialchars($place['name']); ?>')">
                                <i class="fas fa-plus-circle"></i>
                                View <?php echo $offerCount - 2; ?> more offer<?php echo ($offerCount - 2) > 1 ? 's' : ''; ?>
                            </button>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <div class="card-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($area); ?>
                            </div>
                            <div class="card-actions">
                                <button class="btn-save" onclick="toggleSave(this)" title="Save">
                                    <i class="far fa-heart"></i>
                                </button>
                                <a href="<?php echo $detailUrl; ?>" class="btn-details">
                                    View Details <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- OFFER DETAIL MODAL -->
<div class="offer-modal" id="offerModal">
    <div class="offer-modal-box">
        <div class="offer-modal-header">
            <button class="offer-modal-close" onclick="closeOfferModal()">
                <i class="fas fa-times"></i>
            </button>
            <div class="offer-modal-discount" id="modalDiscount">50% OFF</div>
            <div class="offer-modal-title" id="modalTitle">Combo Meal Deal</div>
        </div>
        <div class="offer-modal-body">
            <div class="offer-detail-row">
                <div class="offer-detail-icon"><i class="fas fa-store"></i></div>
                <div class="offer-detail-content">
                    <h4>Business</h4>
                    <p id="modalBusiness">Restaurant Name</p>
                </div>
            </div>
            <div class="offer-detail-row">
                <div class="offer-detail-icon"><i class="fas fa-info-circle"></i></div>
                <div class="offer-detail-content">
                    <h4>Offer Details</h4>
                    <p id="modalDesc">Get 50% off on all combo meals</p>
                </div>
            </div>
            <div class="offer-detail-row">
                <div class="offer-detail-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="offer-detail-content">
                    <h4>Validity</h4>
                    <p id="modalValidity">Valid till month end</p>
                </div>
            </div>
            
            <div class="offer-code-box">
                <div class="offer-code-label">Use this code to avail offer</div>
                <div class="offer-code-value" id="modalCode">COMBO50</div>
                <button class="offer-copy-btn" onclick="copyCode()">
                    <i class="fas fa-copy"></i> Copy Code
                </button>
            </div>
            
            <div class="offer-terms">
                <h4><i class="fas fa-file-alt"></i> Terms & Conditions</h4>
                <ul id="modalTerms">
                    <li>Valid on dine-in only</li>
                    <li>Cannot be combined with other offers</li>
                    <li>Subject to availability</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- CITY MODAL -->
<div class="modal-overlay" id="cityModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Select City</h3>
            <button class="modal-close" onclick="closeCityModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-content">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="citySearch" placeholder="Search city..." oninput="filterCities()">
            </div>
            <button class="detect-btn" onclick="detectLocation()">
                <i class="fas fa-crosshairs"></i>
                <span id="detectText">Detect My Location</span>
            </button>
            <div class="cities-list" id="citiesList">
                <div class="city-item" onclick="selectCity('mumbai')">Mumbai</div>
                <div class="city-item" onclick="selectCity('delhi')">Delhi</div>
                <div class="city-item" onclick="selectCity('bangalore')">Bangalore</div>
                <div class="city-item" onclick="selectCity('chennai')">Chennai</div>
                <div class="city-item" onclick="selectCity('hyderabad')">Hyderabad</div>
                <div class="city-item" onclick="selectCity('pune')">Pune</div>
                <div class="city-item" onclick="selectCity('ahmedabad')">Ahmedabad</div>
                <div class="city-item" onclick="selectCity('surat')">Surat</div>
                <div class="city-item" onclick="selectCity('vapi')">Vapi</div>
                <div class="city-item" onclick="selectCity('jaipur')">Jaipur</div>
                <div class="city-item" onclick="selectCity('lucknow')">Lucknow</div>
                <div class="city-item" onclick="selectCity('kolkata')">Kolkata</div>
            </div>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<?php if(!$is_app): ?>
    <?php @include 'footer.php'; ?>
<?php endif; ?>

<script>
// ========================================
// OFFER MODAL FUNCTIONS
// ========================================
function showOfferDetail(offer, businessName) {
    document.getElementById('modalDiscount').textContent = offer.discount;
    document.getElementById('modalTitle').textContent = offer.title;
    document.getElementById('modalBusiness').textContent = businessName;
    document.getElementById('modalDesc').textContent = offer.description;
    document.getElementById('modalValidity').textContent = offer.validity;
    document.getElementById('modalCode').textContent = offer.code;
    
    // Terms
    const termsList = document.getElementById('modalTerms');
    termsList.innerHTML = '';
    (offer.terms || []).forEach(term => {
        const li = document.createElement('li');
        li.textContent = term;
        termsList.appendChild(li);
    });
    
    document.getElementById('offerModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeOfferModal() {
    document.getElementById('offerModal').classList.remove('show');
    document.body.style.overflow = '';
}

function showAllOffers(offers, businessName) {
    // For simplicity, show the first additional offer
    if (offers.length > 2) {
        showOfferDetail(offers[2], businessName);
    }
}

function copyCode() {
    const code = document.getElementById('modalCode').textContent;
    navigator.clipboard.writeText(code).then(() => {
        showToast('Code copied: ' + code);
    }).catch(() => {
        showToast('Failed to copy code');
    });
}

// ========================================
// SAVE/BOOKMARK
// ========================================
function toggleSave(btn) {
    btn.classList.toggle('saved');
    const icon = btn.querySelector('i');
    if (btn.classList.contains('saved')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        showToast('Saved to favorites');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        showToast('Removed from favorites');
    }
}

// ========================================
// SORT FUNCTION
// ========================================
function sortResults() {
    const sortBy = document.getElementById('sortSelect').value;
    const grid = document.getElementById('discountsGrid');
    const cards = Array.from(grid.querySelectorAll('.discount-card'));
    
    cards.sort((a, b) => {
        if (sortBy === 'rating') {
            return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        } else if (sortBy === 'offers') {
            return parseInt(b.dataset.offers) - parseInt(a.dataset.offers);
        } else if (sortBy === 'name') {
            return a.dataset.name.localeCompare(b.dataset.name);
        }
        return 0;
    });
    
    cards.forEach(card => grid.appendChild(card));
}

// ========================================
// CITY MODAL
// ========================================
function openCityModal() {
    document.getElementById('cityModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeCityModal() {
    document.getElementById('cityModal').classList.remove('show');
    document.body.style.overflow = '';
}

function selectCity(city) {
    window.location.href = '/discounts/' + city.toLowerCase();
}

function filterCities() {
    const search = document.getElementById('citySearch').value.toLowerCase();
    document.querySelectorAll('.city-item').forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(search) ? 'block' : 'none';
    });
}

function detectLocation() {
    const btn = document.getElementById('detectText');
    btn.textContent = 'Detecting...';
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${pos.coords.latitude},${pos.coords.longitude}&key=<?php echo $API_KEY; ?>`)
                    .then(res => res.json())
                    .then(data => {
                        let city = '';
                        if (data.results && data.results[0]) {
                            for (let comp of data.results[0].address_components) {
                                if (comp.types.includes('locality')) {
                                    city = comp.long_name.toLowerCase();
                                    break;
                                }
                            }
                        }
                        if (city) {
                            selectCity(city);
                        } else {
                            showToast('Could not detect city');
                            btn.textContent = 'Detect My Location';
                        }
                    });
            },
            function() {
                showToast('Location access denied');
                btn.textContent = 'Detect My Location';
            }
        );
    }
}

// ========================================
// TOAST
// ========================================
function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// ========================================
// MODAL CLOSE ON BACKDROP
// ========================================
document.getElementById('cityModal').addEventListener('click', function(e) {
    if (e.target === this) closeCityModal();
});

document.getElementById('offerModal').addEventListener('click', function(e) {
    if (e.target === this) closeOfferModal();
});
</script>

</body>
</html>
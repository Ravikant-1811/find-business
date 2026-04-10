<?php
session_start();
include_once 'app-detect.php';

$detectedLocation = '';

// 1. From URL (highest priority)
if (!empty($_GET['location']) && $_GET['location'] !== '') {
    $detectedLocation = trim($_GET['location']);
    $_SESSION['user_city'] = $detectedLocation; // update session
}

// 2. From session (only if URL not present)
elseif (!empty($_SESSION['user_city']) && $_SESSION['user_city'] !== '') {
    $detectedLocation = $_SESSION['user_city'];
}

// 3. Final fallback
else {
    $detectedLocation = 'Vapi';
}

/**
 * ============================================
 * BHARAT DIRECTORY - OPTIMIZED INDEX PAGE
 * Fast Loading with Database Caching
 * ============================================
 */

// Include API key
require_once 'key.php';

// ============================================
// DATABASE CONNECTION
// ============================================
$host = "localhost";
$dbname = "u792021313_directory";  // Change this
$db_username = "u792021313_directory";       // Change this
$db_password = "Directory@2025";           // Change this

$conn = new mysqli($host, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ============================================
// CACHING FUNCTIONS
// ============================================

/**
 * Get cached data or fetch from API
 */
function getCachedData($conn, $cacheKey, $callback, $expireMinutes = 60) {
    // Check cache first
    $stmt = $conn->prepare("SELECT cache_data FROM api_cache WHERE cache_key = ? AND expires_at > NOW()");
    if (!$stmt) {
        return $callback();
    }
    
    $stmt->bind_param("s", $cacheKey);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return json_decode($row['cache_data'], true);
    }
    $stmt->close();
    
    // Not in cache, fetch fresh data
    $data = $callback();
    
    if (empty($data)) {
        return $data;
    }
    
    // Calculate expiry time
    $expiresAt = date('Y-m-d H:i:s', strtotime("+{$expireMinutes} minutes"));
    $createdAt = date('Y-m-d H:i:s');
    
    // Save to cache
    $cacheData = json_encode($data);
    $stmt = $conn->prepare("INSERT INTO api_cache (cache_key, cache_data, created_at, expires_at) 
                            VALUES (?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE 
                            cache_data = VALUES(cache_data), 
                            expires_at = VALUES(expires_at)");
    if ($stmt) {
        $stmt->bind_param("ssss", $cacheKey, $cacheData, $createdAt, $expiresAt);
        $stmt->execute();
        $stmt->close();
    }
    
    return $data;
}

/**
 * Fetch from Google Places API
 */
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
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [];
    }
    
    $data = json_decode($response, true);
    
    if (isset($data['results'])) {
        return array_slice($data['results'], 0, $limit);
    }
    
    return [];
}

/**
 * Get photo URL from Google Places
 */
function getPhotoUrl($photos, $maxWidth = 400) {
    if (!empty($photos) && isset($photos[0]['photo_reference'])) {
        $photoRef = $photos[0]['photo_reference'];
        $apiKey = GOOGLE_PLACES_API_KEY;
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth={$maxWidth}&photo_reference={$photoRef}&key={$apiKey}";
    }
    return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=300&fit=crop';
}

/**
 * Generate star rating HTML
 */
function generateStars($rating) {
    $rating = floatval($rating);
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    
    $html = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<i class="fas fa-star"></i>';
    }
    if ($halfStar) {
        $html .= '<i class="fas fa-star-half-alt"></i>';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<i class="far fa-star"></i>';
    }
    
    return $html;
}

/**
 * Truncate text safely
 */
function truncateText($text, $length = 50) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// ============================================
// STATIC DATA (NO API CALLS NEEDED)
// ============================================

// Categories with static counts
$categories = [
    ['name' => 'Restaurants', 'icon' => 'fa-utensils', 'query' => 'restaurants', 'color' => '#ef4444', 'count' => '15,000+'],
    ['name' => 'Hotels', 'icon' => 'fa-hotel', 'query' => 'hotels', 'color' => '#8b5cf6', 'count' => '8,500+'],
    ['name' => 'Hospitals', 'icon' => 'fa-hospital', 'query' => 'hospitals', 'color' => '#10b981', 'count' => '5,200+'],
    ['name' => 'IT Companies', 'icon' => 'fa-laptop-code', 'query' => 'IT companies', 'color' => '#3b82f6', 'count' => '12,000+'],
    ['name' => 'Chemical Industries', 'icon' => 'fa-flask', 'query' => 'chemical industries', 'color' => '#f59e0b', 'count' => '3,800+'],
    ['name' => 'Pharma Companies', 'icon' => 'fa-pills', 'query' => 'pharmaceutical companies', 'color' => '#ec4899', 'count' => '4,500+'],
    ['name' => 'Manufacturing', 'icon' => 'fa-industry', 'query' => 'manufacturing units', 'color' => '#6366f1', 'count' => '9,200+'],
    ['name' => 'Automobile', 'icon' => 'fa-car', 'query' => 'automobile services', 'color' => '#14b8a6', 'count' => '7,100+']
];

// Industries
$industries = [
    ['name' => 'IT Industry', 'query' => 'IT companies software Bangalore', 'icon' => 'fa-laptop-code'],
    ['name' => 'Chemical Industry', 'query' => 'chemical industries Gujarat', 'icon' => 'fa-flask'],
    ['name' => 'Pharmaceutical', 'query' => 'pharmaceutical companies Hyderabad', 'icon' => 'fa-pills'],
    ['name' => 'Manufacturing', 'query' => 'manufacturing industries Pune', 'icon' => 'fa-industry'],
    ['name' => 'Automobile', 'query' => 'automobile companies Chennai', 'icon' => 'fa-car']
];

// Testimonials (Static)
$testimonials = [
    [
        'name' => 'Rajesh Kumar Sharma',
        'role' => 'Business Owner, Delhi',
        'image' => 'https://randomuser.me/api/portraits/men/32.jpg',
        'text' => 'Bharat Directory helped my electronics shop reach thousands of customers. Best decision for my business!',
        'rating' => 5
    ],
    [
        'name' => 'Priya Patel',
        'role' => 'Restaurant Owner, Mumbai',
        'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
        'text' => 'Since listing on Bharat Directory, our restaurant bookings increased by 40%. Highly recommended!',
        'rating' => 5
    ],
    [
        'name' => 'Amit Agarwal',
        'role' => 'IT Company CEO, Bangalore',
        'image' => 'https://randomuser.me/api/portraits/men/67.jpg',
        'text' => 'The visibility we got through Bharat Directory is unmatched. Our client inquiries doubled!',
        'rating' => 5
    ],
    [
        'name' => 'Sunita Reddy',
        'role' => 'Healthcare Professional, Hyderabad',
        'image' => 'https://randomuser.me/api/portraits/women/68.jpg',
        'text' => 'Patients find our clinic easily through Bharat Directory. The listing process was seamless.',
        'rating' => 5
    ]
];

// Statistics (Static)
$stats = [
    ['number' => '50,000+', 'label' => 'Businesses Listed', 'icon' => 'fa-building'],
    ['number' => '1M+', 'label' => 'Monthly Searches', 'icon' => 'fa-search'],
    ['number' => '500+', 'label' => 'Cities Covered', 'icon' => 'fa-map-marker-alt'],
    ['number' => '4.8/5', 'label' => 'User Rating', 'icon' => 'fa-star']
];

// Popular searches
$popularSearches = [
    ['text' => 'Restaurants in Mumbai', 'query' => 'restaurants', 'location' => 'Mumbai'],
    ['text' => 'IT Companies Bangalore', 'query' => 'IT companies', 'location' => 'Bangalore'],
    ['text' => 'Hospitals in Delhi', 'query' => 'hospitals', 'location' => 'Delhi'],
    ['text' => 'Hotels in Goa', 'query' => 'hotels', 'location' => 'Goa'],
    ['text' => 'Chemical Industries Vapi', 'query' => 'chemical industries', 'location' => 'Vapi']
];

// ============================================
// FETCH DATA WITH CACHING (Only 1 API call)
// ============================================

// Featured businesses - cached for 2 hours
$featuredBusinesses = getCachedData($conn, 'featured_businesses_v2', function() {
    return fetchGooglePlaces('top rated businesses India', 8);
}, 120);

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find Business - India's leading business directory. Find restaurants, hotels, hospitals, IT companies, manufacturing units and more across India.">
    <meta name="keywords" content="business directory, india, local business, restaurants, hotels, hospitals, IT companies">
    <meta name="author" content="Find Business">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Find Business - India's Premier Business Directory">
    <meta property="og:description" content="Find and connect with businesses across India.">
    <meta property="og:type" content="website">
    
    <title>Find Business - India's Premier Business Directory | Find Local Businesses</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    
    <!-- Preconnect for faster loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://maps.googleapis.com">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/css/index.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
setInterval(() => {
  const threshold = 160;
  if (window.outerWidth - window.innerWidth > threshold) {
    document.body.innerHTML = "<h1 style='text-align:center;margin-top:40vh;'>Content Unavailable</h1>";
  }
}, 500);
</script>
<script>
setInterval(() => {
  const threshold = 160;
  if (window.outerWidth - window.innerWidth > threshold) {
    document.body.innerHTML = "<h1 style='text-align:center;margin-top:40vh;'>Content Unavailable</h1>";
  }
}, 500);
</script>
</head>
<body class="<?php echo $isApp ? 'app-view' : 'web-view'; ?>">

    <!-- ============================================
         HEADER
    ============================================ -->
    <?php $currentPage = 'home'; ?>
<?php include 'header.php'; ?>


    <!-- ============================================
         HERO SECTION
    ============================================ -->
    <section class="hero" id="home">
        <!-- Animated Background -->
        <div class="hero-bg"></div>
        
        <!-- Floating Shapes -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <!-- Overlay -->
        <div class="hero-overlay"></div>

        <!-- Hero Content -->
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i>
                India's #1 Trusted Business Directory
            </div>

            <h1 class="hero-title">
                Discover <span>Local Businesses</span> Across India
            </h1>

            <p class="hero-subtitle">
                Find restaurants, hotels, hospitals, IT companies, manufacturers & more. Connect with 50,000+ verified businesses.
            </p>

            <!-- Search Box -->
            <div class="search-box">
                <form class="search-form" action="/search" method="GET">
                    <div class="search-input-group">
                        <i class="fas fa-search"></i>
                        <input 
                            type="text" 
                            name="q" 
                            id="searchQuery"
                            placeholder="Search businesses, services..."
                            required
                            autocomplete="off"
                        >
                    </div>

                    <div class="search-input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input 
                            type="text" 
                            name="location" 
                            id="searchLocation"
                            placeholder="City, State or Area"
                            autocomplete="off"
                        >
                    </div>

                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </form>
            </div>

            <!-- Popular Searches -->
            <div class="popular-searches">
                <p><i class="fas fa-fire"></i> Popular Searches:</p>
                <div class="popular-tags">
                    <?php foreach ($popularSearches as $search): ?>
                    <a href="/search?q=<?= urlencode($search['query']) ?>&location=<?= urlencode($search['location']) ?>" class="popular-tag">
                        <?= htmlspecialchars($search['text']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <a href="#stats">
                <span>Scroll Down</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- ============================================
         STATISTICS SECTION
    ============================================ -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="stats-grid">
                <?php foreach ($stats as $stat): ?>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas <?= $stat['icon'] ?>"></i>
                    </div>
                    <div class="stat-number"><?= $stat['number'] ?></div>
                    <div class="stat-label"><?= $stat['label'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         CATEGORIES SECTION
    ============================================ -->
    <section class="categories-section section" id="categories">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-th-large"></i>
                    Browse Categories
                </div>
                <h2 class="section-title">Explore Popular Categories</h2>
                <p class="section-subtitle">Find businesses across various industries and sectors in India</p>
            </div>

            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                <a href="/search?q=<?= urlencode($category['query']) ?>&location=<?= urlencode($detectedLocation) ?>" class="category-card">
                    <div class="category-icon" style="background: <?= $category['color'] ?>;">
                        <i class="fas <?= $category['icon'] ?>"></i>
                    </div>
                    <h3 class="category-name"><?= htmlspecialchars($category['name']) ?></h3>
                    <span class="category-count">
                        <i class="fas fa-building"></i>
                        <?= $category['count'] ?> listings
                    </span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         FEATURED BUSINESSES SECTION
    ============================================ -->
    <section class="featured-section section" id="featured">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-star"></i>
                    Featured Listings
                </div>
                <h2 class="section-title">Top Rated Businesses</h2>
                <p class="section-subtitle">Discover highly rated and verified businesses across India</p>
            </div>

            <div class="business-grid">
                <?php if (!empty($featuredBusinesses)): ?>
                    <?php foreach ($featuredBusinesses as $business): ?>
                    <?php
                        $photoUrl = getPhotoUrl($business['photos'] ?? []);
                        $rating = $business['rating'] ?? 0;
                        $reviewsCount = $business['user_ratings_total'] ?? 0;
                        $isOpen = isset($business['opening_hours']['open_now']) ? $business['opening_hours']['open_now'] : null;
                        $placeId = $business['place_id'] ?? '';
                    ?>
                    <article class="business-card">
                        <a href="place_details.php?place_id=<?= urlencode($placeId) ?>">
                            <div class="business-image">
                                <img src="<?= htmlspecialchars($photoUrl) ?>" alt="<?= htmlspecialchars($business['name']) ?>" loading="lazy">
                                <span class="business-badge">Featured</span>
                                <?php if ($isOpen !== null): ?>
                                <span class="business-status <?= $isOpen ? 'status-open' : 'status-closed' ?>">
                                    <?= $isOpen ? 'Open Now' : 'Closed' ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class="business-content">
                            <h3 class="business-name">
                                <a href="/place/PLACE_ID?place_id=<?= urlencode($placeId) ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($business['name']) ?>
                                </a>
                            </h3>
                            <?php if ($rating > 0): ?>
                            <div class="business-rating">
                                <span class="stars"><?= generateStars($rating) ?></span>
                                <span class="rating-value"><?= number_format($rating, 1) ?></span>
                                <span class="reviews-count">(<?= number_format($reviewsCount) ?>)</span>
                            </div>
                            <?php endif; ?>
                            <div class="business-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= htmlspecialchars(truncateText($business['formatted_address'] ?? 'India', 60)) ?></span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Skeleton Loading -->
                    <?php for ($i = 0; $i < 8; $i++): ?>
                    <div class="business-card">
                        <div class="business-image skeleton" style="height: 200px;"></div>
                        <div class="business-content">
                            <div class="skeleton" style="height: 24px; width: 80%; margin-bottom: 12px;"></div>
                            <div class="skeleton" style="height: 18px; width: 60%; margin-bottom: 12px;"></div>
                            <div class="skeleton" style="height: 16px; width: 90%;"></div>
                        </div>
                    </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================================
         TESTIMONIALS SECTION
    ============================================ --
    <section class="testimonials-section section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-comments"></i>
                    Testimonials
                </div>
                <h2 class="section-title">What Our Users Say</h2>
                <p class="section-subtitle">Trusted by thousands of businesses and customers across India</p>
            </div>

            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <div class="testimonial-quote">"</div>
                    <div class="testimonial-rating">
                        <?= generateStars($testimonial['rating']) ?>
                    </div>
                    <p class="testimonial-text">"<?= htmlspecialchars($testimonial['text']) ?>"</p>
                    <div class="testimonial-author">
                        <img src="<?= htmlspecialchars($testimonial['image']) ?>" alt="<?= htmlspecialchars($testimonial['name']) ?>" class="testimonial-avatar" loading="lazy">
                        <div class="testimonial-info">
                            <h4><?= htmlspecialchars($testimonial['name']) ?></h4>
                            <p><?= htmlspecialchars($testimonial['role']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>--->

    <!-- ============================================
         CTA SECTION
    ============================================ -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-content">
                <div class="cta-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h2 class="cta-title">List Your Business Today</h2>
                <p class="cta-text">
                    Join 50,000+ businesses already listed on Find Business. Get discovered by millions of potential customers across India.
                </p>
                <div class="cta-buttons">
                    <a href="add_business.php" class="cta-btn-primary">
                        <i class="fas fa-plus"></i>
                        Add Your Business - Free
                    </a>
                    <a href="contact.php" class="cta-btn-secondary">
                        <i class="fas fa-phone"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         FOOTER
    ============================================ -->
    <?php include 'footer.php'; ?>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- ============================================
         JAVASCRIPT
    ============================================ -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Back to Top Button
    const backToTop = document.getElementById('backToTop');
    
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Lazy load images with faster transition
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '1';
                    img.style.transform = 'translateX(0)';
                    imageObserver.unobserve(img);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });
        
        images.forEach(function(img) {
            img.style.opacity = '0';
            img.style.transform = 'translateX(-20px)';
            img.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            imageObserver.observe(img);
            
            img.addEventListener('load', function() {
                this.style.opacity = '1';
                this.style.transform = 'translateX(0)';
            });
        });
    }
    
    // ==========================================
    // FASTER SCROLL ANIMATIONS FROM LEFT SIDE
    // ==========================================
    const animatedElements = document.querySelectorAll('.category-card, .business-card, .testimonial-card, .stat-card, .popular-item, .hotel-card');
    
    // Detect mobile device
    const isMobile = window.innerWidth <= 768;
    
    if ('IntersectionObserver' in window) {
        const animationObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    // Get index for staggered animation
                    const cards = Array.from(animatedElements);
                    const index = cards.indexOf(entry.target);
                    
                    // Faster delay on mobile
                    const delay = isMobile ? index * 30 : index * 50;
                    
                    setTimeout(function() {
                        entry.target.classList.add('card-visible');
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateX(0) translateY(0)';
                    }, delay);
                    
                    animationObserver.unobserve(entry.target);
                }
            });
        }, { 
            threshold: 0.05, // Trigger earlier
            rootMargin: '100px 0px' // Start animation before element is in view
        });
        
        animatedElements.forEach(function(el, index) {
            // Start from left side
            el.style.opacity = '0';
            el.style.transform = isMobile ? 'translateX(-30px)' : 'translateX(-50px)';
            // Faster transition on mobile
            el.style.transition = isMobile 
                ? 'opacity 0.25s ease-out, transform 0.25s ease-out' 
                : 'opacity 0.4s ease-out, transform 0.4s ease-out';
            animationObserver.observe(el);
        });
    }
    
    // ==========================================
    // HORIZONTAL SCROLL FOR MOBILE CARDS
    // ==========================================
    const horizontalScrollContainers = document.querySelectorAll('.popular-grid, .cards-grid, .category-grid');
    
    horizontalScrollContainers.forEach(container => {
        // Enable smooth horizontal scroll on touch devices
        let isDown = false;
        let startX;
        let scrollLeft;
        
        container.addEventListener('mousedown', (e) => {
            isDown = true;
            container.classList.add('grabbing');
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });
        
        container.addEventListener('mouseleave', () => {
            isDown = false;
            container.classList.remove('grabbing');
        });
        
        container.addEventListener('mouseup', () => {
            isDown = false;
            container.classList.remove('grabbing');
        });
        
        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed multiplier
            container.scrollLeft = scrollLeft - walk;
        });
        
        // Touch events for mobile
        let touchStartX = 0;
        let touchScrollLeft = 0;
        
        container.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].pageX;
            touchScrollLeft = container.scrollLeft;
        }, { passive: true });
        
        container.addEventListener('touchmove', (e) => {
            const touchX = e.touches[0].pageX;
            const walk = (touchStartX - touchX) * 1.5; // Faster scroll
            container.scrollLeft = touchScrollLeft + walk;
        }, { passive: true });
    });
    
    // ==========================================
    // FAST CARD REVEAL ON SCROLL (MOBILE)
    // ==========================================
    if (isMobile) {
        let ticking = false;
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    revealCardsOnScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        function revealCardsOnScroll() {
            const cards = document.querySelectorAll('.business-card:not(.card-visible), .category-card:not(.card-visible)');
            const windowHeight = window.innerHeight;
            
            cards.forEach((card, index) => {
                const cardTop = card.getBoundingClientRect().top;
                const cardVisible = cardTop < windowHeight - 50;
                
                if (cardVisible) {
                    setTimeout(() => {
                        card.classList.add('card-visible');
                        card.style.opacity = '1';
                        card.style.transform = 'translateX(0)';
                    }, index * 20); // Very fast stagger
                }
            });
        }
        
        // Initial check
        revealCardsOnScroll();
    }
    
    // ==========================================
    // COUNTER ANIMATION FOR STATS
    // ==========================================
    const statNumbers = document.querySelectorAll('.stat-number, .stat-value, .hero-stat-value');
    
    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    // Animate from left
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                    
                    // Counter animation
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        statNumbers.forEach(function(num) {
            num.style.opacity = '0';
            num.style.transform = 'translateX(-30px)';
            num.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            counterObserver.observe(num);
        });
    }
    
    function animateCounter(element) {
        const text = element.textContent;
        const match = text.match(/(\d+)/);
        if (!match) return;
        
        const target = parseInt(match[0]);
        const suffix = text.replace(/\d+/, '');
        let current = 0;
        const increment = target / 30;
        const duration = 1000;
        const stepTime = duration / 30;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + suffix;
        }, stepTime);
    }
    
    // ==========================================
    // SWIPE CARDS LEFT/RIGHT ON MOBILE
    // ==========================================
    const swipeableCards = document.querySelectorAll('.business-card, .category-card, .hotel-card');
    
    swipeableCards.forEach(card => {
        let startX = 0;
        let currentX = 0;
        
        card.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        }, { passive: true });
        
        card.addEventListener('touchmove', (e) => {
            currentX = e.touches[0].clientX;
            const diff = currentX - startX;
            
            // Subtle card tilt effect while swiping
            if (Math.abs(diff) < 100) {
                card.style.transform = `translateX(${diff * 0.3}px) rotate(${diff * 0.02}deg)`;
            }
        }, { passive: true });
        
        card.addEventListener('touchend', () => {
            card.style.transform = '';
            card.style.transition = 'transform 0.3s ease';
            
            setTimeout(() => {
                card.style.transition = '';
            }, 300);
        });
    });
    
    console.log('Find Business loaded successfully! 🚀');
});

// ==========================================
// LOAD GOOGLE PLACES AUTOCOMPLETE
// ==========================================
let autocompleteLoaded = false;

const searchLocationInput = document.getElementById('searchLocation');
if (searchLocationInput) {
    searchLocationInput.addEventListener('focus', function() {
        if (!autocompleteLoaded && typeof google === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_PLACES_API_KEY ?>&libraries=places';
            script.onload = function() {
                new google.maps.places.Autocomplete(document.getElementById('searchLocation'), {
                    types: ['(cities)'],
                    componentRestrictions: { country: 'in' }
                });
                autocompleteLoaded = true;
            };
            document.head.appendChild(script);
        }
    }, { once: true });
}

// ==========================================
// PERFORMANCE: PASSIVE SCROLL LISTENER
// ==========================================
window.addEventListener('scroll', function() {}, { passive: true });
</script>

<!-- ==========================================
     ADD THIS CSS FOR CARD ANIMATIONS
     ========================================== -->
<style>
/* Card Animation Base Styles */
.category-card,
.business-card,
.testimonial-card,
.stat-card,
.popular-item,
.hotel-card {
    opacity: 0;
    transform: translateX(-30px);
    transition: opacity 0.3s ease-out, transform 0.3s ease-out;
    will-change: transform, opacity;
}

.card-visible {
    opacity: 1 !important;
    transform: translateX(0) translateY(0) !important;
}

/* Faster animations on mobile */
@media (max-width: 768px) {
    .category-card,
    .business-card,
    .testimonial-card,
    .stat-card,
    .popular-item,
    .hotel-card {
        transform: translateX(-20px);
        transition: opacity 0.2s ease-out, transform 0.2s ease-out;
    }
    
    /* Horizontal scroll improvements */
    .cards-grid,
    .popular-grid,
    .category-grid {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x proximity;
    }
    
    .cards-grid > *,
    .popular-grid > *,
    .category-grid > * {
        scroll-snap-align: start;
    }
    
    /* Grabbing cursor */
    .grabbing {
        cursor: grabbing !important;
    }
}

/* Staggered animation keyframes */
@keyframes slideInFromLeft {
    0% {
        opacity: 0;
        transform: translateX(-40px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInFromLeftFast {
    0% {
        opacity: 0;
        transform: translateX(-20px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Apply animation on load */
.business-card:nth-child(1) { animation-delay: 0s; }
.business-card:nth-child(2) { animation-delay: 0.05s; }
.business-card:nth-child(3) { animation-delay: 0.1s; }
.business-card:nth-child(4) { animation-delay: 0.15s; }
.business-card:nth-child(5) { animation-delay: 0.2s; }
.business-card:nth-child(6) { animation-delay: 0.25s; }
.business-card:nth-child(7) { animation-delay: 0.3s; }
.business-card:nth-child(8) { animation-delay: 0.35s; }

/* Hover lift effect */
.business-card:hover,
.category-card:hover,
.hotel-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Touch feedback for mobile */
@media (max-width: 768px) {
    .business-card:active,
    .category-card:active,
    .hotel-card:active {
        transform: scale(0.98) !important;
        transition: transform 0.1s ease;
    }
}

/* Smooth horizontal scroll container */
.horizontal-scroll {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scroll-snap-type: x mandatory;
    gap: 16px;
    padding: 10px 0;
}

.horizontal-scroll::-webkit-scrollbar {
    display: none;
}

.horizontal-scroll > * {
    flex-shrink: 0;
    scroll-snap-align: start;
}

/* Card slide in animation */
.slide-in-left {
    animation: slideInFromLeft 0.4s ease-out forwards;
}

@media (max-width: 768px) {
    .slide-in-left {
        animation: slideInFromLeftFast 0.25s ease-out forwards;
    }
}

/* Skeleton loading animation */
.skeleton-loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1s infinite;
}

@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Fast fade in */
.fade-in-fast {
    animation: fadeIn 0.2s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Back to top button */
#backToTop {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #FF6B35, #E85A2A);
    border: none;
    border-radius: 50%;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
    transition: all 0.3s ease;
    z-index: 999;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
}

#backToTop.visible {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

#backToTop:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.5);
}

@media (max-width: 768px) {
    #backToTop {
        bottom: 20px;
        right: 20px;
        width: 44px;
        height: 44px;
        font-size: 18px;
    }
}
</style>

<!-- Back to Top Button HTML -->
<button id="backToTop" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

</body>
</html>
<?php 
// End output buffering and send output
ob_end_flush(); 
?>
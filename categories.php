<?php include_once 'app-detect.php'; ?>

<?php
// ============================================
// DIALIKIYA - ALL CATEGORIES PAGE
// Premium Gray Design with Orange Accent
// ============================================

// All Categories Data with Groups
$categories = [
    'Food & Dining' => [
        'icon' => 'fa-utensils',
        'color' => '#FF6B35',
        'items' => [
            ['slug' => 'restaurant', 'title' => 'Restaurants', 'icon' => 'fa-utensils', 'desc' => 'Dine-in & takeaway', 'count' => '15K+'],
            ['slug' => 'cafe', 'title' => 'Cafes', 'icon' => 'fa-coffee', 'desc' => 'Coffee & snacks', 'count' => '8K+'],
            ['slug' => 'bakery', 'title' => 'Bakeries', 'icon' => 'fa-bread-slice', 'desc' => 'Fresh baked goods', 'count' => '5K+'],
            ['slug' => 'bar', 'title' => 'Bars & Pubs', 'icon' => 'fa-glass-martini-alt', 'desc' => 'Nightlife & drinks', 'count' => '3K+'],
        ]
    ],
    'Hotels & Travel' => [
        'icon' => 'fa-hotel',
        'color' => '#3B82F6',
        'items' => [
            ['slug' => 'hotel', 'title' => 'Hotels', 'icon' => 'fa-hotel', 'desc' => 'Stays & accommodation', 'count' => '12K+'],
            ['slug' => 'travel', 'title' => 'Travel Agencies', 'icon' => 'fa-plane', 'desc' => 'Trip planning', 'count' => '4K+'],
        ]
    ],
    'Healthcare' => [
        'icon' => 'fa-heartbeat',
        'color' => '#EF4444',
        'items' => [
            ['slug' => 'hospital', 'title' => 'Hospitals', 'icon' => 'fa-hospital', 'desc' => 'Medical centers', 'count' => '10K+'],
            ['slug' => 'pharmacy', 'title' => 'Pharmacies', 'icon' => 'fa-pills', 'desc' => 'Medicines & health', 'count' => '18K+'],
            ['slug' => 'doctor', 'title' => 'Doctors', 'icon' => 'fa-user-md', 'desc' => 'Clinics & consultations', 'count' => '25K+'],
            ['slug' => 'dentist', 'title' => 'Dentists', 'icon' => 'fa-tooth', 'desc' => 'Dental care', 'count' => '8K+'],
            ['slug' => 'veterinary', 'title' => 'Veterinary', 'icon' => 'fa-paw', 'desc' => 'Pet care', 'count' => '3K+'],
        ]
    ],
    'Beauty & Wellness' => [
        'icon' => 'fa-spa',
        'color' => '#EC4899',
        'items' => [
            ['slug' => 'salon', 'title' => 'Salons', 'icon' => 'fa-cut', 'desc' => 'Hair & beauty', 'count' => '20K+'],
            ['slug' => 'spa', 'title' => 'Spas', 'icon' => 'fa-spa', 'desc' => 'Relaxation & wellness', 'count' => '6K+'],
            ['slug' => 'gym', 'title' => 'Gyms', 'icon' => 'fa-dumbbell', 'desc' => 'Fitness centers', 'count' => '9K+'],
        ]
    ],
    'Banking & Finance' => [
        'icon' => 'fa-university',
        'color' => '#10B981',
        'items' => [
            ['slug' => 'bank', 'title' => 'Banks', 'icon' => 'fa-university', 'desc' => 'Banking services', 'count' => '15K+'],
            ['slug' => 'atm', 'title' => 'ATMs', 'icon' => 'fa-credit-card', 'desc' => 'Cash withdrawal', 'count' => '50K+'],
        ]
    ],
    'Shopping' => [
        'icon' => 'fa-shopping-bag',
        'color' => '#8B5CF6',
        'items' => [
            ['slug' => 'store', 'title' => 'Stores', 'icon' => 'fa-store', 'desc' => 'Retail shops', 'count' => '30K+'],
            ['slug' => 'supermarket', 'title' => 'Supermarkets', 'icon' => 'fa-shopping-cart', 'desc' => 'Groceries', 'count' => '8K+'],
            ['slug' => 'mall', 'title' => 'Malls', 'icon' => 'fa-building', 'desc' => 'Shopping centers', 'count' => '2K+'],
            ['slug' => 'electronics', 'title' => 'Electronics', 'icon' => 'fa-mobile-alt', 'desc' => 'Gadgets & devices', 'count' => '12K+'],
            ['slug' => 'jewelry', 'title' => 'Jewelry', 'icon' => 'fa-gem', 'desc' => 'Gold & diamonds', 'count' => '6K+'],
            ['slug' => 'florist', 'title' => 'Florists', 'icon' => 'fa-seedling', 'desc' => 'Flowers & gifts', 'count' => '4K+'],
        ]
    ],
    'Education' => [
        'icon' => 'fa-graduation-cap',
        'color' => '#F59E0B',
        'items' => [
            ['slug' => 'school', 'title' => 'Schools', 'icon' => 'fa-school', 'desc' => 'K-12 education', 'count' => '15K+'],
            ['slug' => 'college', 'title' => 'Colleges', 'icon' => 'fa-graduation-cap', 'desc' => 'Higher education', 'count' => '5K+'],
        ]
    ],
    'Home Services' => [
        'icon' => 'fa-home',
        'color' => '#06B6D4',
        'items' => [
            ['slug' => 'electrician', 'title' => 'Electricians', 'icon' => 'fa-bolt', 'desc' => 'Electrical work', 'count' => '10K+'],
            ['slug' => 'plumber', 'title' => 'Plumbers', 'icon' => 'fa-wrench', 'desc' => 'Plumbing services', 'count' => '8K+'],
            ['slug' => 'laundry', 'title' => 'Laundry', 'icon' => 'fa-tshirt', 'desc' => 'Dry cleaning', 'count' => '6K+'],
        ]
    ],
    'Automotive' => [
        'icon' => 'fa-car',
        'color' => '#64748B',
        'items' => [
            ['slug' => 'petrol', 'title' => 'Petrol Pumps', 'icon' => 'fa-gas-pump', 'desc' => 'Fuel stations', 'count' => '20K+'],
            ['slug' => 'car_repair', 'title' => 'Car Repair', 'icon' => 'fa-car', 'desc' => 'Auto services', 'count' => '12K+'],
            ['slug' => 'parking', 'title' => 'Parking', 'icon' => 'fa-parking', 'desc' => 'Parking spaces', 'count' => '8K+'],
        ]
    ],
    'Professional Services' => [
        'icon' => 'fa-briefcase',
        'color' => '#6366F1',
        'items' => [
            ['slug' => 'lawyer', 'title' => 'Lawyers', 'icon' => 'fa-gavel', 'desc' => 'Legal services', 'count' => '8K+'],
        ]
    ],
    'Entertainment' => [
        'icon' => 'fa-film',
        'color' => '#A855F7',
        'items' => [
            ['slug' => 'movie', 'title' => 'Movie Theaters', 'icon' => 'fa-film', 'desc' => 'Cinemas', 'count' => '3K+'],
            ['slug' => 'park', 'title' => 'Parks', 'icon' => 'fa-tree', 'desc' => 'Recreation', 'count' => '5K+'],
        ]
    ],
    'Religious Places' => [
        'icon' => 'fa-place-of-worship',
        'color' => '#F97316',
        'items' => [
            ['slug' => 'temple', 'title' => 'Temples', 'icon' => 'fa-place-of-worship', 'desc' => 'Hindu temples', 'count' => '25K+'],
            ['slug' => 'mosque', 'title' => 'Mosques', 'icon' => 'fa-mosque', 'desc' => 'Islamic mosques', 'count' => '10K+'],
            ['slug' => 'church', 'title' => 'Churches', 'icon' => 'fa-church', 'desc' => 'Christian churches', 'count' => '8K+'],
        ]
    ],
];

// Count totals
$totalCategories = 0;
$totalGroups = count($categories);
foreach ($categories as $group) {
    $totalCategories += count($group['items']);
}

// Popular categories for quick access
$popularCategories = ['restaurant', 'hotel', 'hospital', 'salon', 'gym', 'cafe', 'pharmacy', 'atm', 'petrol', 'bank'];

$pageTitle = "All Categories - Explore " . $totalCategories . " Business Categories | Find Business";
$pageDescription = "Browse all business categories on Find Business. Find restaurants, hotels, hospitals, salons, and more near you across India.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="business categories, local business, Find Business, restaurants near me, hotels, hospitals, India">
    <meta name="author" content="Find Business">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#FF6B35">
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Find Business">
    <title><?php echo $pageTitle; ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/categories.css">
    <?php
$isApp = false;

if (isset($_SERVER['HTTP_USER_AGENT'])) {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'FindBusinessApp') !== false) {
        $isApp = true;
    }
}
?>

</head>
<body class="<?php echo $isApp ? 'app-view' : 'web-view'; ?>">
    <!-- Header -->
    <?php if (!$isApp) { include 'header.php'; } ?>
    
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
            <a href="categories.php" class="mobile-nav-link"><i class="fas fa-th-large"></i> All Categories</a>
            <a href="hotels.php" class="mobile-nav-link"><i class="fas fa-hotel"></i> Hotels</a>
            <a href="category.php?category=restaurant" class="mobile-nav-link"><i class="fas fa-utensils"></i> Restaurants</a>
            <a href="category.php?category=hospital" class="mobile-nav-link"><i class="fas fa-hospital"></i> Hospitals</a>
            <a href="about.php" class="mobile-nav-link"><i class="fas fa-info-circle"></i> About</a>
            <a href="contact.php" class="mobile-nav-link"><i class="fas fa-envelope"></i> Contact</a>
        </div>
    </div>
    
    <!-- Hero Section -->
    <?php if (!$isApp): ?>
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        
        <div class="hero-container">
            <div class="hero-badge">
                <div class="hero-badge-icon">
                    <i class="fas fa-th-large"></i>
                </div>
                <span class="hero-badge-text">Browse All Categories</span>
            </div>
            
            <h1 class="hero-title">
                Explore <span class="highlight"><?php echo $totalCategories; ?>+</span> Business Categories
            </h1>
            
            <p class="hero-subtitle">
                Find exactly what you're looking for. From restaurants to hospitals, salons to banks - discover trusted local businesses near you.
            </p>
            
            <!-- Search Box -->
            <div class="hero-search">
                <div class="search-box">
                    <input type="text" class="search-input" id="categorySearch" placeholder="Search categories... (e.g., restaurant, hotel, hospital)">
                    <button class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-value"><?php echo $totalCategories; ?><span>+</span></div>
                    <div class="stat-label">Categories</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-value"><?php echo $totalGroups; ?></div>
                    <div class="stat-label">Industry Groups</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-value">50K<span>+</span></div>
                    <div class="stat-label">Businesses Listed</div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="main">
        <?php if (!$isApp): ?>
        <!-- Popular Categories -->
        <section class="popular-section">
            <div class="popular-card">
                <div class="popular-header">
                    <div class="popular-title">
                        <div class="popular-title-icon">
                            <i class="fas fa-fire"></i>
                        </div>
                        <div>
                            <h2>Popular Categories</h2>
                            <p>Most searched by users</p>
                        </div>
                    </div>
                </div>
                
                <div class="popular-grid">
                    <?php
                    $popularData = [
                        ['slug' => 'restaurant', 'title' => 'Restaurants', 'icon' => 'fa-utensils', 'count' => '15K+'],
                        ['slug' => 'hotel', 'title' => 'Hotels', 'icon' => 'fa-hotel', 'count' => '12K+'],
                        ['slug' => 'hospital', 'title' => 'Hospitals', 'icon' => 'fa-hospital', 'count' => '10K+'],
                        ['slug' => 'salon', 'title' => 'Salons', 'icon' => 'fa-cut', 'count' => '20K+'],
                        ['slug' => 'gym', 'title' => 'Gyms', 'icon' => 'fa-dumbbell', 'count' => '9K+'],
                        ['slug' => 'cafe', 'title' => 'Cafes', 'icon' => 'fa-coffee', 'count' => '8K+'],
                        ['slug' => 'pharmacy', 'title' => 'Pharmacies', 'icon' => 'fa-pills', 'count' => '18K+'],
                        ['slug' => 'atm', 'title' => 'ATMs', 'icon' => 'fa-credit-card', 'count' => '50K+'],
                        ['slug' => 'petrol', 'title' => 'Petrol Pumps', 'icon' => 'fa-gas-pump', 'count' => '20K+'],
                        ['slug' => 'bank', 'title' => 'Banks', 'icon' => 'fa-university', 'count' => '15K+'],
                    ];
                    
                    foreach ($popularData as $item):
                    ?>
                    <a href="category.php?category=<?php echo $item['slug']; ?>" class="popular-item">
                        <div class="popular-item-icon">
                            <i class="fas <?php echo $item['icon']; ?>"></i>
                        </div>
                        <span class="popular-item-name"><?php echo $item['title']; ?></span>
                        <span class="popular-item-count"><?php echo $item['count']; ?> listings</span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- All Category Groups -->
        <?php foreach ($categories as $groupName => $groupData): ?>
        <section class="category-section" id="<?php echo strtolower(str_replace(' ', '-', $groupName)); ?>">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background: <?php echo $groupData['color']; ?>;">
                        <i class="fas <?php echo $groupData['icon']; ?>"></i>
                    </div>
                    <div>
                        <h3><?php echo $groupName; ?></h3>
                    </div>
                    <span class="section-count"><?php echo count($groupData['items']); ?> categories</span>
                </div>
            </div>
            
            <div class="category-grid">
                <?php foreach ($groupData['items'] as $index => $cat): ?>
                <a href="category.php?category=<?php echo $cat['slug']; ?>" 
                   class="category-card" 
                   style="--card-color: <?php echo $groupData['color']; ?>;"
                   data-category="<?php echo strtolower($cat['title'] . ' ' . $cat['desc']); ?>">
                    <div class="card-top">
                        <div class="card-icon">
                            <i class="fas <?php echo $cat['icon']; ?>"></i>
                        </div>
                        <div class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <h4 class="card-title"><?php echo $cat['title']; ?></h4>
                    <p class="card-desc"><?php echo $cat['desc']; ?></p>
                    <div class="card-meta">
                        <span class="card-count"><?php echo $cat['count']; ?> listings</span>
                        <?php if ($index === 0): ?>
                        <span class="card-badge">Popular</span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endforeach; ?>
        
        <!-- CTA Section -->
        <?php if (!$isApp): ?>
        <section class="cta-section">
            <div class="cta-content">
                <div class="cta-text">
                    <h3>Can't Find Your Category?</h3>
                    <p>We're constantly adding new business categories. Let us know what you're looking for and we'll help you find it.</p>
                </div>
                <div class="cta-actions">
                    <a href="contact.php" class="btn-cta btn-cta-primary">
                        <i class="fas fa-envelope"></i>
                        Contact Us
                    </a>
                    <a href="index.php" class="btn-cta btn-cta-secondary">
                        <i class="fas fa-home"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>
    
    <!-- Footer -->
    <?php include 'footer.php';?>
    
    <script>
    (function() {
        'use strict';
        
        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Mobile menu
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileClose = document.getElementById('mobileClose');
        
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        mobileClose.addEventListener('click', closeMobileMenu);
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) closeMobileMenu();
        });
        
        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Category search filter
        const searchInput = document.getElementById('categorySearch');
        const searchBtn = document.getElementById('searchBtn');
        const categoryCards = document.querySelectorAll('.category-card');
        const categorySections = document.querySelectorAll('.category-section');
        const popularItems = document.querySelectorAll('.popular-item');
        
        function filterCategories() {
            const query = searchInput.value.toLowerCase().trim();
            
            if (query === '') {
                // Show all
                categoryCards.forEach(card => {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.4s ease forwards';
                });
                categorySections.forEach(section => section.style.display = 'block');
                popularItems.forEach(item => item.style.display = 'flex');
                return;
            }
            
            // Filter cards
            categoryCards.forEach(card => {
                const text = card.dataset.category || '';
                if (text.includes(query)) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.4s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Hide empty sections
            categorySections.forEach(section => {
                const visibleCards = section.querySelectorAll('.category-card[style*="display: block"], .category-card:not([style*="display: none"])');
                let hasVisible = false;
                visibleCards.forEach(c => {
                    if (c.style.display !== 'none') hasVisible = true;
                });
                
                const cards = section.querySelectorAll('.category-card');
                let show = false;
                cards.forEach(c => {
                    if (c.style.display !== 'none') show = true;
                });
                section.style.display = show ? 'block' : 'none';
            });
            
            // Filter popular items
            popularItems.forEach(item => {
                const name = item.querySelector('.popular-item-name').textContent.toLowerCase();
                if (name.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        searchInput.addEventListener('input', filterCategories);
        searchBtn.addEventListener('click', filterCategories);
        
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                filterCategories();
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        
        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        categoryCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `opacity 0.5s ease ${index * 0.05}s, transform 0.5s ease ${index * 0.05}s`;
            observer.observe(card);
        });
    })();
    </script>
</body>
</html>
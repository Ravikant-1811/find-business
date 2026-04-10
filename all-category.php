<?php include_once 'app-detect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Business - India's Trusted Business Directory</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/all-category.css">

</head>
<body class="<?php echo $isApp ? 'app-view' : 'web-view'; ?>">
    <!-- Header -->
    <?php include 'header.php';?>
    
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
            <a href="categories.php" class="mobile-nav-link"><i class="fas fa-th-large"></i> Categories</a>
            <a href="hotels.php" class="mobile-nav-link"><i class="fas fa-hotel"></i> Hotels</a>
            <a href="category.php?category=restaurant" class="mobile-nav-link"><i class="fas fa-utensils"></i> Restaurants</a>
            <a href="category.php?category=hospital" class="mobile-nav-link"><i class="fas fa-hospital"></i> Hospitals</a>
            <a href="about.php" class="mobile-nav-link"><i class="fas fa-info-circle"></i> About</a>
            <a href="contact.php" class="mobile-nav-link"><i class="fas fa-envelope"></i> Contact</a>
        </div>
    </div>
    
    <!-- Hero Section -->
    <section class="hero">
        <!-- Background Effects -->
        <div class="hero-grid"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>
        
        <div class="hero-container">
            <div class="hero-content">
                <!-- Left Content -->
                <div class="hero-left">
                    <!-- Badge -->
                    <div class="hero-badge">
                        <div class="badge-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span class="badge-text">India's Trusted Business Directory</span>
                        <div class="badge-dot"></div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="hero-title">
                        Find Trusted <span class="highlight">Local Businesses</span> Near You
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="hero-subtitle">
                        Discover verified restaurants, hospitals, services & professionals across India. Connect with the best businesses in your city.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-actions">
                        <a href="categories.php" class="btn-hero-primary">
                            <i class="fas fa-search"></i>
                            Search Businesses
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="categories.php" class="btn-hero-secondary">
                            <i class="fas fa-th-large"></i>
                            Browse Categories
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-value">50K<span>+</span></div>
                            <div class="stat-label">Businesses Listed</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value">500<span>+</span></div>
                            <div class="stat-label">Cities Covered</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value">1M<span>+</span></div>
                            <div class="stat-label">Happy Users</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Visual -->
                <div class="hero-right">
                    <div class="hero-visual">
                        <!-- Main Card -->
                        <div class="visual-card">
                            <div class="visual-card-header">
                                <div class="visual-card-icon">
                                    <i class="fas fa-search-location"></i>
                                </div>
                                <div class="visual-card-title">
                                    <h4>Find Nearby</h4>
                                    <p>Discover businesses around you</p>
                                </div>
                            </div>
                            
                            <div class="visual-card-search">
                                <input type="text" class="search-input-visual" placeholder="Search restaurants, hotels...">
                                <button class="search-btn-visual">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            
                            <div class="visual-categories">
                                <div class="category-pill">
                                    <i class="fas fa-utensils"></i>
                                    Restaurants
                                </div>
                                <div class="category-pill">
                                    <i class="fas fa-hotel"></i>
                                    Hotels
                                </div>
                                <div class="category-pill">
                                    <i class="fas fa-hospital"></i>
                                    Hospitals
                                </div>
                                <div class="category-pill">
                                    <i class="fas fa-spa"></i>
                                    Spas
                                </div>
                                <div class="category-pill">
                                    <i class="fas fa-dumbbell"></i>
                                    Gyms
                                </div>
                                <div class="category-pill">
                                    <i class="fas fa-ellipsis-h"></i>
                                    More
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Cards -->
                        <div class="floating-card floating-card-1">
                            <div class="floating-icon green">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="floating-text">
                                <h5>Verified Listings</h5>
                                <p>100% Authentic</p>
                            </div>
                        </div>
                        
                        <div class="floating-card floating-card-2">
                            <div class="floating-icon blue">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="floating-text">
                                <h5>Pan India</h5>
                                <p>500+ Cities</p>
                            </div>
                        </div>
                        
                        <div class="floating-card floating-card-3">
                            <div class="floating-icon orange">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="floating-text">
                                <h5>Top Rated</h5>
                                <p>4.8/5 Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
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
        
        mobileClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Category pills hover effect
        const categoryPills = document.querySelectorAll('.category-pill');
        categoryPills.forEach(pill => {
            pill.addEventListener('click', () => {
                const category = pill.textContent.trim().toLowerCase();
                window.location.href = `category.php?category=${category}`;
            });
        });
        
        // Search functionality
        const searchBtn = document.querySelector('.search-btn-visual');
        const searchInput = document.querySelector('.search-input-visual');
        
        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', () => {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `search.php?q=${encodeURIComponent(query)}`;
                }
            });
            
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const query = searchInput.value.trim();
                    if (query) {
                        window.location.href = `search.php?q=${encodeURIComponent(query)}`;
                    }
                }
            });
        }
    })();
    </script>
</body>
</html>
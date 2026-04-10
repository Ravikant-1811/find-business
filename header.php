<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title>Find Business - Discover Local Businesses</title>
    <link rel="apple-touch-icon" sizes="180x180" href="photos/d-logo-url.png">
    <link rel="icon" sizes="32x32" href="photos/d-logo-url.png">
    <link rel="icon" sizes="16x16" href="photos/d-logo-url.png">
    <link rel="stylesheet" href="/assets/css/header.css?v=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F81NMHGBRZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-F81NMHGBRZ');
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
<body>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="index.php" class="<?= ($currentPage == 'home') ? 'active' : '' ?>"<i class="fas fa-home"></i> Home</a></li>
            <li><a href="categories.php" class="<?= ($currentPage == 'Categories') ? 'active' : '' ?>"</i> Categories</a></li>
            <li><a href="add_business.php" class="<?= ($currentPage == 'Businesses') ? 'active' : '' ?>"</i> Businesses</a></li>
            <li><a href="help.php" class="<?= ($currentPage == 'blog') ? 'active' : '' ?>"</i> Help</a></li>
        </ul>

        <div class="mobile-buttons">
            <a href="add_business.php" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Business
            </a>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">Dial<span>Kiya</span></span>
        </a>

        <!-- Desktop Nav Links -->
        <ul class="nav-links" id="navLinks">
            <li><a href="index.php" class="<?= ($currentPage == 'home') ? 'active' : '' ?>">Home</a></li>
            <li><a href="try-app.php" class="<?= ($currentPage == 'try app') ? 'active' : '' ?>">Try App</a></li>
            
            <!-- Dropdown: Categories -->
            <li class="nav-dropdown">
                <a href="#">
                    Categories
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="category.php?category=restaurant"><i class="fas fa-utensils"></i> Restaurants</a></li>
                    <li><a href="category.php?category=hotel"><i class="fas fa-hotel"></i> Hotels</a></li>
                    <li><a href="category.php?category=hospitals"><i class="fas fa-hospital"></i> Hospitals</a></li>
                    <li><a href="category.php?category=IT&company"><i class="fas fa-laptop-code"></i> IT Companies</a></li>
                    <li><a href="category.php?category=Industries"><i class="fas fa-industry"></i> Industries</a></li>
                    <li><a href="categories.php"><i class="fas fa-th-large"></i> View All</a></li>
                </ul>
            </li>

            <!-- Dropdown: Businesses -->
            <li class="nav-dropdown">
                <a href="#">
                    Businesses
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/search?q=business"><i class="fas fa-search"></i> Search Business</a></li>
                    <li><a href="/search?q=top-rated"><i class="fas fa-star"></i> Top Rated</a></li>
                    <li><a href="/search?q=nearby"><i class="fas fa-map-marker-alt"></i> Near Me</a></li>
                    <li><a href="/search?q=popular"><i class="fas fa-fire"></i> Popular</a></li>
                </ul>
            </li>

            <li><a href="faq.php" class="<?= ($currentPage == 'faq') ? 'active' : '' ?>">FAQ</a></li>
            <li><a href="contact.php" class="<?= ($currentPage == 'contact') ? 'active' : '' ?>">Contact</a></li>
        </ul>

        <!-- Desktop Nav Buttons -->
        <div class="nav-buttons" id="navButtons">
            <a href="add_business.php" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Business
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <!-- JavaScript -->
    <script>
        (function() {
            'use strict';

            // Elements
            const navbar = document.getElementById('navbar');
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // State
            let isMenuOpen = false;

            /**
             * Handle Navbar Scroll
             */
            function handleNavbarScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }

            /**
             * Toggle Mobile Menu
             */
            function toggleMobileMenu() {
                isMenuOpen = !isMenuOpen;
                
                menuToggle.classList.toggle('active', isMenuOpen);
                mobileMenu.classList.toggle('active', isMenuOpen);
                mobileOverlay.classList.toggle('active', isMenuOpen);
                
                // Prevent body scroll when menu is open
                document.body.style.overflow = isMenuOpen ? 'hidden' : '';
            }

            /**
             * Close Mobile Menu
             */
            function closeMobileMenu() {
                if (!isMenuOpen) return;
                
                isMenuOpen = false;
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            /**
             * Handle Window Resize
             */
            function handleResize() {
                if (window.innerWidth > 900 && isMenuOpen) {
                    closeMobileMenu();
                }
            }

            /**
             * Handle Escape Key
             */
            function handleEscapeKey(e) {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeMobileMenu();
                }
            }

            // Event Listeners
            window.addEventListener('scroll', handleNavbarScroll);
            window.addEventListener('resize', handleResize);
            document.addEventListener('keydown', handleEscapeKey);

            menuToggle.addEventListener('click', toggleMobileMenu);
            mobileOverlay.addEventListener('click', closeMobileMenu);

            // Close menu when clicking nav links
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            // Initial scroll check
            handleNavbarScroll();

        })();
    </script>
    <script>
(function () {
    var ua = navigator.userAgent || '';
    if (ua.includes('FindBusinessApp')) {
        document.documentElement.classList.add('app-view');
    }
})();
</script>
<!-- Cloudflare Web Analytics --><script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "d2061c1baa804e95ba8c5d9b31ef02a6"}'></script><!-- End Cloudflare Web Analytics -->
</body>
</html>
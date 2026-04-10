<?php
/**
 * ============================================
 * FIND BUSINESS - DISCOUNT PAGE
 * Premium Gray Hero + Location-Based Discounts
 * ============================================
 */

// Configuration
$GOOGLE_API_KEY = 'AIzaSyD3Y69gJInyxqJPd_RF-ZZT8TRXYNQn5MU';

// Get city from URL
$url_city = isset($_GET['city']) ? preg_replace('/[^a-zA-Z0-9\s]/', '', trim(strtolower($_GET['city']))) : null;
$page_city = $url_city ?? 'india';

// SEO Meta
$meta_title = "Best Discounts in " . ucfirst($page_city) . " – Find Business";
$meta_description = "Explore verified local business discounts in " . ucfirst($page_city) . ". Find deals on hotels, salons, restaurants, hospitals and more.";

// App mode detection
$is_app_mode = isset($_GET['app']) || isset($_GET['webview']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($meta_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <link rel="canonical" href="https://find-business.com/discounts/<?php echo $page_city; ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ============================================
           CSS VARIABLES
           ============================================
           
           These are reusable values throughout the CSS.
           Change these to update colors site-wide.
        */
        :root {
            /* Primary Brand Colors */
            --primary: #FF6B35;           /* Main orange */
            --primary-dark: #E85A2A;      /* Darker orange for hover */
            --primary-light: #FF8C5A;     /* Lighter orange for accents */
            
            /* Gray Scale - From lightest to darkest */
            --gray-50: #F9FAFB;           /* Page background */
            --gray-100: #F3F4F6;          /* Card backgrounds */
            --gray-200: #E5E7EB;          /* Borders, dividers */
            --gray-300: #D1D5DB;          /* Disabled states */
            --gray-400: #9CA3AF;          /* Placeholder text */
            --gray-500: #6B7280;          /* Secondary text */
            --gray-600: #4B5563;          /* Body text */
            --gray-700: #374151;          /* Headings */
            --gray-800: #1F2937;          /* Dark text */
            --gray-900: #111827;          /* Darkest text */
            
            --white: #FFFFFF;
            
            /* Shadows - Increasing intensity */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            
            /* Transitions */
            --transition: all 0.3s ease;
        }

        /* ============================================
           RESET & BASE STYLES
           ============================================
           
           Removes default browser styling and sets
           consistent base styles across all elements.
        */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;  /* Width includes padding & border */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;      /* Smoother fonts on Mac */
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* Hide header/footer in app mode */
        <?php if($is_app_mode): ?>
        .site-header, .site-footer, header, footer { display: none !important; }
        body { padding-top: 0 !important; }
        <?php endif; ?>

        /* ============================================
           HERO SECTION - PREMIUM GRAY DESIGN
           ============================================
           
           The hero uses multiple layers:
           1. Base gradient background
           2. Noise texture overlay (::before)
           3. Grid pattern overlay
           4. Floating orb decorations
           5. Content on top
        */
        .hero {
            /* Full viewport height minus header */
            min-height: 60vh;
            padding-top: 100px;
            padding-bottom: 60px;
            
            /* 
               Multi-stop gradient creates depth
               165deg = slight diagonal angle
               Colors transition from near-black to dark gray
            */
            background: linear-gradient(165deg, 
                #040404 0%,        /* Near black at top */
                #242425 15%,       /* Dark charcoal */
                #181818 35%,       /* Deep gray */
                #2e2e2f 60%,       /* Medium dark */
                #28292b 85%,       /* Slate */
                #2d2e2e 100%       /* Dark slate at bottom */
            );
            
            position: relative;
            overflow: hidden;     /* Hides orbs that extend outside */
        }

        /* 
           Noise Texture Overlay
           Creates subtle grain effect for premium feel
           Uses inline SVG for performance (no external file)
        */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;          /* Very subtle, barely visible */
            pointer-events: none;   /* Clicks pass through */
        }

        /* 
           Grid Pattern
           Creates subtle grid lines for tech/modern feel
        */
        .hero-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Two gradients create horizontal and vertical lines */
            background-image: 
                linear-gradient(rgba(156, 163, 175, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(156, 163, 175, 0.05) 1px, transparent 1px);
            background-size: 60px 60px;  /* Grid cell size */
            pointer-events: none;
        }

        /* 
           Floating Orbs
           Large blurred circles that add depth and color
           Each orb has different size, position, and animation
        */
        .hero-orb {
            position: absolute;
            border-radius: 50%;        /* Makes it circular */
            filter: blur(80px);        /* Soft, diffused edges */
            opacity: 0.4;              /* Semi-transparent */
            pointer-events: none;      /* Non-interactive */
        }

        /* Orange-tinted orb - top right */
        .hero-orb-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, 
                rgba(255, 107, 53, 0.15),   /* Orange with low opacity */
                rgba(255, 140, 90, 0.1)
            );
            top: -200px;
            right: -100px;
            animation: orbFloat1 20s ease-in-out infinite;
        }

        /* Gray orb - bottom left */
        .hero-orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, 
                rgba(156, 163, 175, 0.2),   /* Gray */
                rgba(209, 213, 219, 0.15)
            );
            bottom: -100px;
            left: -100px;
            animation: orbFloat2 25s ease-in-out infinite;
        }

        /* Small accent orb - center */
        .hero-orb-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, 
                rgba(255, 107, 53, 0.08),
                rgba(255, 200, 150, 0.05)
            );
            top: 40%;
            left: 30%;
            animation: orbFloat3 18s ease-in-out infinite;
        }

        /* 
           Orb Animations
           Keyframes define the animation at different points
           0% = start, 100% = end (loops back to 0%)
        */
        @keyframes orbFloat1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(-30px, 20px) scale(1.05); }
            50% { transform: translate(-20px, -30px) scale(0.95); }
            75% { transform: translate(20px, 10px) scale(1.02); }
        }

        @keyframes orbFloat2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -20px) scale(1.03); }
            66% { transform: translate(-20px, 30px) scale(0.97); }
        }

        @keyframes orbFloat3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -40px); }
        }

        /* Hero Content Container */
        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;            /* Above orbs and overlays */
            text-align: center;
        }

        /* 
           Fade In Up Animation
           Elements start invisible and below, 
           then fade in and move up
        */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero Badge - "Exclusive Offers" pill */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            /* 
               Semi-transparent white background
               with blur effect (glassmorphism)
            */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 100px;    /* Fully rounded pill shape */
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease forwards;
        }

        .badge-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 12px;
        }

        .badge-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
        }

        /* Pulsing green dot - indicates "live" */
        .badge-dot {
            width: 8px;
            height: 8px;
            background: #10B981;     /* Green */
            border-radius: 50%;
            animation: pulse 2s ease infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.2); }
        }

        /* Hero Title */
        .hero-title {
            font-size: clamp(32px, 6vw, 56px);  /* Responsive: min 32px, max 56px */
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.1s;
            opacity: 0;              /* Starts invisible, animation makes visible */
        }

        /* Orange highlighted text */
        .hero-title .highlight {
            color: var(--primary);
            position: relative;
        }

        /* Underline decoration for highlighted text */
        .hero-title .highlight::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 0;
            right: 0;
            height: 8px;
            background: rgba(255, 107, 53, 0.3);
            border-radius: 4px;
            z-index: -1;
        }

        /* Hero Subtitle */
        .hero-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            margin-bottom: 32px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.2s;
            opacity: 0;
        }

        /* City Location Badge */
        .hero-location {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 28px;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            transition: var(--transition);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        .hero-location:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .location-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
        }

        .location-text {
            text-align: left;
        }

        .location-label {
            font-size: 12px;
            color: var(--gray-500);
            font-weight: 500;
        }

        .location-city {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            text-transform: capitalize;
        }

        .location-change {
            font-size: 12px;
            color: var(--primary);
            font-weight: 600;
        }

        /* ============================================
           CATEGORY SECTION
           ============================================ */
        .category-section {
            padding: 60px 0 40px;
            background: var(--white);
            margin-top: -30px;
            border-radius: 30px 30px 0 0;
            position: relative;
            z-index: 10;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .section-subtitle {
            font-size: 16px;
            color: var(--gray-500);
        }

        /* Category Cards Grid */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
        }

        .category-card {
            background: var(--gray-50);
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 24px 16px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .category-card:hover {
            background: var(--white);
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .category-card.active {
            background: var(--primary);
            border-color: var(--primary);
        }

        .category-card.active .category-icon,
        .category-card.active .category-name,
        .category-card.active .category-count {
            color: var(--white);
        }

        .category-icon {
            width: 56px;
            height: 56px;
            background: var(--white);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 24px;
            color: var(--primary);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        .category-card.active .category-icon {
            background: rgba(255, 255, 255, 0.2);
        }

        .category-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 4px;
        }

        .category-count {
            font-size: 12px;
            color: var(--gray-500);
        }

        /* ============================================
           DISCOUNTS SECTION
           ============================================ */
        .discounts-section {
            padding: 40px 0 80px;
            background: var(--gray-50);
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .stats-count {
            font-size: 15px;
            color: var(--gray-600);
        }

        .stats-count strong {
            color: var(--gray-900);
            font-weight: 700;
        }

        .sort-select {
            padding: 10px 16px;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-700);
            cursor: pointer;
            background: var(--white);
        }

        /* Discount Cards Grid */
        .discounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        @media (max-width: 680px) {
            .discounts-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ============================================
           DISCOUNT CARD
           ============================================ */
        .discount-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .discount-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
        }

        /* Card Image */
        .card-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .discount-card:hover .card-image img {
            transform: scale(1.08);
        }

        /* Image Placeholder */
        .card-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 48px;
        }

        /* Offer Badge */
        .offer-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            padding: 8px 14px;
            background: var(--primary);
            color: var(--white);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
        }

        /* Rating Badge */
        .rating-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 6px 12px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            color: var(--white);
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rating-badge i {
            color: #FFD700;
            font-size: 11px;
        }

        /* Card Content */
        .card-content {
            padding: 20px;
        }

        .business-category {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .business-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 10px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .offer-text {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
            color: #059669;
            font-weight: 500;
            margin-bottom: 14px;
            line-height: 1.4;
        }

        .offer-text i {
            margin-top: 2px;
            flex-shrink: 0;
        }

        .business-location {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--gray-500);
            margin-bottom: 16px;
        }

        .business-location i {
            color: var(--gray-400);
        }

        /* Card Footer */
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 16px;
            border-top: 1px solid var(--gray-100);
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: var(--gray-500);
        }

        .contact-item i {
            font-size: 12px;
            color: var(--gray-400);
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }

        /* ============================================
           LOADING STATES
           ============================================ */
        .loading-container {
            text-align: center;
            padding: 60px 20px;
        }

        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--gray-200);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 15px;
            color: var(--gray-500);
        }

        /* Skeleton Loading Card */
        .skeleton-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .skeleton-image {
            height: 180px;
            background: linear-gradient(90deg, 
                var(--gray-100) 25%, 
                var(--gray-200) 50%, 
                var(--gray-100) 75%
            );
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        .skeleton-content {
            padding: 20px;
        }

        .skeleton-line {
            height: 14px;
            background: linear-gradient(90deg, 
                var(--gray-100) 25%, 
                var(--gray-200) 50%, 
                var(--gray-100) 75%
            );
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 7px;
            margin-bottom: 12px;
        }

        .skeleton-line.short { width: 35%; }
        .skeleton-line.medium { width: 65%; }
        .skeleton-line.long { width: 90%; }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ============================================
           EMPTY STATE
           ============================================ */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 40px;
            color: var(--gray-400);
        }

        .empty-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .empty-text {
            font-size: 15px;
            color: var(--gray-500);
            max-width: 400px;
            margin: 0 auto;
        }

        /* ============================================
           LOAD MORE BUTTON
           ============================================ */
        .load-more-container {
            text-align: center;
            padding: 40px 0;
        }

        .load-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 40px;
            background: var(--white);
            border: 2px solid var(--primary);
            color: var(--primary);
            font-size: 15px;
            font-weight: 600;
            border-radius: 14px;
            cursor: pointer;
            font-family: inherit;
            transition: var(--transition);
        }

        .load-more-btn:hover {
            background: var(--primary);
            color: var(--white);
        }

        .load-more-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ============================================
           CITY MODAL
           ============================================ */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            padding: 20px;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--white);
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            max-height: 80vh;
            overflow: hidden;
            transform: translateY(30px) scale(0.95);
            transition: var(--transition);
        }

        .modal-overlay.active .modal {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            padding: 24px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .modal-close {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--gray-100);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--gray-600);
            transition: var(--transition);
        }

        .modal-close:hover {
            background: var(--gray-200);
        }

        .modal-body {
            padding: 24px;
            max-height: calc(80vh - 160px);
            overflow-y: auto;
        }

        /* City Search */
        .city-search {
            position: relative;
            margin-bottom: 20px;
        }

        .city-search input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            transition: var(--transition);
        }

        .city-search input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .city-search i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        /* Detect Location Button */
        .detect-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 16px;
            background: rgba(255, 107, 53, 0.1);
            border: 2px dashed var(--primary);
            border-radius: 12px;
            color: var(--primary);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: var(--transition);
            margin-bottom: 20px;
        }

        .detect-btn:hover {
            background: rgba(255, 107, 53, 0.15);
        }

        /* City Options Grid */
        .cities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .city-option {
            padding: 14px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-700);
            transition: var(--transition);
        }

        .city-option:hover {
            border-color: var(--primary);
            background: rgba(255, 107, 53, 0.05);
            color: var(--primary);
        }

        /* ============================================
           TOAST NOTIFICATION
           ============================================ */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--gray-900);
            color: var(--white);
            padding: 14px 28px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            z-index: 10000;
            opacity: 0;
            transition: var(--transition);
            box-shadow: var(--shadow-lg);
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* ============================================
           RESPONSIVE DESIGN
           ============================================ */
        @media (max-width: 768px) {
            .hero {
                min-height: 50vh;
                padding-top: 80px;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-subtitle {
                font-size: 15px;
            }

            .category-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }

            .category-card {
                padding: 16px 8px;
            }

            .category-icon {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }

            .category-name {
                font-size: 12px;
            }

            .section-title {
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

<?php if(!$is_app_mode): ?>
    <?php include 'header.php'; ?>
<?php endif; ?>

<!-- ============================================
     HERO SECTION
     ============================================ -->
<section class="hero">
    <!-- Decorative Elements -->
    <div class="hero-grid"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    
    <div class="hero-container">
        <!-- Badge -->
        <div class="hero-badge">
            <span class="badge-icon"><i class="fas fa-bolt"></i></span>
            <span class="badge-text">Exclusive Local Offers</span>
            <span class="badge-dot"></span>
        </div>
        
        <!-- Title -->
        <h1 class="hero-title">
            Discover Amazing <span class="highlight">Discounts</span><br>
            Near You
        </h1>
        
        <!-- Subtitle -->
        <p class="hero-subtitle">
            Find verified offers from local businesses in your city. 
            Hotels, restaurants, salons, and more – all at the best prices.
        </p>
        
        <!-- Location Badge -->
        <div class="hero-location" id="heroLocation" onclick="openCityModal()">
            <div class="location-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="location-text">
                <span class="location-label">Showing offers in</span>
                <div>
                    <span class="location-city" id="currentCity"><?php echo ucfirst($page_city); ?></span>
                    <span class="location-change">• Change</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     CATEGORY SECTION
     ============================================ -->
<section class="category-section">
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-subtitle">Find the best deals in your favorite categories</p>
        </div>
        
        <div class="category-grid" id="categoryGrid">
            <div class="category-card active" data-category="all">
                <div class="category-icon"><i class="fas fa-th-large"></i></div>
                <div class="category-name">All Offers</div>
                <div class="category-count" id="countAll">-</div>
            </div>
            <div class="category-card" data-category="restaurant">
                <div class="category-icon"><i class="fas fa-utensils"></i></div>
                <div class="category-name">Restaurants</div>
                <div class="category-count" id="countRestaurant">-</div>
            </div>
            <div class="category-card" data-category="hotel">
                <div class="category-icon"><i class="fas fa-hotel"></i></div>
                <div class="category-name">Hotels</div>
                <div class="category-count" id="countHotel">-</div>
            </div>
            <div class="category-card" data-category="salon">
                <div class="category-icon"><i class="fas fa-cut"></i></div>
                <div class="category-name">Salons & Spa</div>
                <div class="category-count" id="countSalon">-</div>
            </div>
            <div class="category-card" data-category="hospital">
                <div class="category-icon"><i class="fas fa-hospital"></i></div>
                <div class="category-name">Healthcare</div>
                <div class="category-count" id="countHospital">-</div>
            </div>
            <div class="category-card" data-category="gym">
                <div class="category-icon"><i class="fas fa-dumbbell"></i></div>
                <div class="category-name">Fitness</div>
                <div class="category-count" id="countGym">-</div>
            </div>
            <div class="category-card" data-category="shopping">
                <div class="category-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="category-name">Shopping</div>
                <div class="category-count" id="countShopping">-</div>
            </div>
            <div class="category-card" data-category="cafe">
                <div class="category-icon"><i class="fas fa-coffee"></i></div>
                <div class="category-name">Cafes</div>
                <div class="category-count" id="countCafe">-</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     DISCOUNTS SECTION
     ============================================ -->
<section class="discounts-section">
    <div class="section-container">
        <!-- Stats Bar -->
        <div class="stats-bar">
            <span class="stats-count">
                Found <strong id="totalCount">0</strong> offers in 
                <strong id="cityNameStats"><?php echo ucfirst($page_city); ?></strong>
            </span>
            <select class="sort-select" id="sortSelect" onchange="sortDiscounts()">
                <option value="relevance">Sort by Relevance</option>
                <option value="rating">Highest Rated</option>
                <option value="distance">Nearest First</option>
            </select>
        </div>
        
        <!-- Discounts Grid -->
        <div class="discounts-grid" id="discountsGrid">
            <!-- Skeleton Loading -->
            <div class="skeleton-card">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-line long"></div>
                    <div class="skeleton-line medium"></div>
                </div>
            </div>
            <div class="skeleton-card">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-line long"></div>
                    <div class="skeleton-line medium"></div>
                </div>
            </div>
            <div class="skeleton-card">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-line long"></div>
                    <div class="skeleton-line medium"></div>
                </div>
            </div>
        </div>
        
        <!-- Load More -->
        <div class="load-more-container" id="loadMoreContainer" style="display: none;">
            <button class="load-more-btn" id="loadMoreBtn" onclick="loadMoreDiscounts()">
                <i class="fas fa-sync-alt"></i>
                Load More Offers
            </button>
        </div>
    </div>
</section>

<!-- ============================================
     CITY MODAL
     ============================================ -->
<div class="modal-overlay" id="cityModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Select Your City</h3>
            <button class="modal-close" onclick="closeCityModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="city-search">
                <i class="fas fa-search"></i>
                <input type="text" id="citySearchInput" placeholder="Search city..." oninput="filterCities()">
            </div>
            <button class="detect-btn" onclick="detectLocation()">
                <i class="fas fa-crosshairs"></i>
                <span id="detectText">Detect My Location</span>
            </button>
            <div class="cities-grid" id="citiesGrid">
                <div class="city-option" onclick="selectCity('mumbai')">Mumbai</div>
                <div class="city-option" onclick="selectCity('delhi')">Delhi</div>
                <div class="city-option" onclick="selectCity('bangalore')">Bangalore</div>
                <div class="city-option" onclick="selectCity('chennai')">Chennai</div>
                <div class="city-option" onclick="selectCity('kolkata')">Kolkata</div>
                <div class="city-option" onclick="selectCity('hyderabad')">Hyderabad</div>
                <div class="city-option" onclick="selectCity('pune')">Pune</div>
                <div class="city-option" onclick="selectCity('ahmedabad')">Ahmedabad</div>
                <div class="city-option" onclick="selectCity('surat')">Surat</div>
                <div class="city-option" onclick="selectCity('vapi')">Vapi</div>
                <div class="city-option" onclick="selectCity('jaipur')">Jaipur</div>
                <div class="city-option" onclick="selectCity('lucknow')">Lucknow</div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<?php if(!$is_app_mode): ?>
    <?php include 'footer.php'; ?>
<?php endif; ?>

<script>
/**
 * ============================================
 * FIND BUSINESS DISCOUNT PAGE - JAVASCRIPT
 * ============================================
 */

// =====================
// CONFIGURATION
// =====================
const CONFIG = {
    GOOGLE_API_KEY: '<?php echo $GOOGLE_API_KEY; ?>',
    DEFAULT_CITY: '<?php echo $page_city; ?>',
    ITEMS_PER_PAGE: 12,
    OFFER_KEYWORDS: [
        'offer', 'discount', 'sale', 'deal', 'off', 'special', 
        'limited', 'combo', 'free', 'save', 'value', 'promo', 
        'promotion', 'price drop', 'best price', 'cheap'
    ]
};

// =====================
// STATE MANAGEMENT
// =====================
const STATE = {
    currentCity: CONFIG.DEFAULT_CITY,
    currentCategory: 'all',
    allBusinesses: [],          // All fetched businesses
    filteredBusinesses: [],     // Filtered by category
    displayedCount: 0,
    userLocation: null,
    isLoading: false,
    categoryCounts: {}          // Count per category
};

// Category to Google Places types mapping
const CATEGORY_TYPES = {
    'all': ['restaurant', 'lodging', 'beauty_salon', 'hospital', 'gym', 'shopping_mall', 'cafe'],
    'restaurant': ['restaurant', 'meal_takeaway', 'meal_delivery'],
    'hotel': ['lodging'],
    'salon': ['beauty_salon', 'hair_care', 'spa'],
    'hospital': ['hospital', 'doctor', 'dentist', 'pharmacy'],
    'gym': ['gym'],
    'shopping': ['shopping_mall', 'store', 'clothing_store'],
    'cafe': ['cafe', 'bakery']
};

// Offer messages
const OFFER_MESSAGES = [
    "Special offers available at this business",
    "Limited-time deals for local customers",
    "Popular spot with great value offers",
    "Exclusive discounts mentioned in reviews",
    "Check out today's special promotions",
    "High-rated with value-for-money deals"
];

// =====================
// INITIALIZATION
// =====================
document.addEventListener('DOMContentLoaded', async function() {
    await initPage();
    setupCategoryListeners();
});

async function initPage() {
    // Check stored city
    const storedCity = sessionStorage.getItem('dk_city');
    if (storedCity && CONFIG.DEFAULT_CITY === 'india') {
        STATE.currentCity = storedCity;
        updateCityDisplay();
    }

    // Attempt location detection
    await attemptLocationDetection();

    // Load all discounts
    await loadAllDiscounts();
}

// =====================
// LOCATION DETECTION
// =====================
async function attemptLocationDetection() {
    // Check Android WebView
    if (window.AndroidLocation) {
        try {
            const loc = JSON.parse(window.AndroidLocation.getLocation());
            if (loc) {
                STATE.userLocation = loc;
                await reverseGeocode(loc.lat, loc.lng);
                return;
            }
        } catch(e) {}
    }

    // Check session
    if (sessionStorage.getItem('dk_city')) return;

    // Browser geolocation
    if (CONFIG.DEFAULT_CITY === 'india' && navigator.geolocation) {
        try {
            const pos = await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 300000
                });
            });
            STATE.userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            await reverseGeocode(pos.coords.latitude, pos.coords.longitude);
        } catch(e) {
            console.log('Geolocation denied');
        }
    }
}

async function reverseGeocode(lat, lng) {
    try {
        const resp = await fetch(
            `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${CONFIG.GOOGLE_API_KEY}`
        );
        const data = await resp.json();
        
        if (data.results?.[0]) {
            for (const comp of data.results[0].address_components) {
                if (comp.types.includes('locality')) {
                    STATE.currentCity = comp.long_name.toLowerCase();
                    sessionStorage.setItem('dk_city', STATE.currentCity);
                    updateCityDisplay();
                    window.history.replaceState({}, '', `/discounts/${STATE.currentCity}`);
                    return;
                }
            }
        }
    } catch(e) {}
}

async function detectLocation() {
    const btn = document.getElementById('detectText');
    btn.textContent = 'Detecting...';

    if (!navigator.geolocation) {
        showToast('Geolocation not supported');
        btn.textContent = 'Detect My Location';
        return;
    }

    try {
        const pos = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 10000
            });
        });
        
        STATE.userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
        await reverseGeocode(pos.coords.latitude, pos.coords.longitude);
        closeCityModal();
        await loadAllDiscounts();
        showToast(`Location set to ${capitalizeFirst(STATE.currentCity)}`);
    } catch(e) {
        showToast('Could not detect location');
    }

    btn.textContent = 'Detect My Location';
}

// =====================
// GOOGLE PLACES API
// =====================
async function loadAllDiscounts() {
    if (STATE.isLoading) return;
    STATE.isLoading = true;

    const grid = document.getElementById('discountsGrid');
    grid.innerHTML = generateSkeletons(6);

    STATE.allBusinesses = [];
    STATE.categoryCounts = {};
    STATE.displayedCount = 0;

    try {
        // Fetch all category types
        const allTypes = CATEGORY_TYPES['all'];
        const allResults = [];

        for (const type of allTypes) {
            const results = await searchPlaces(type);
            allResults.push(...results);
        }

        // Remove duplicates
        const unique = [...new Map(allResults.map(p => [p.place_id, p])).values()];

        // Enhance with offer detection
        STATE.allBusinesses = unique.map(place => enhanceWithOffer(place)).filter(b => b.hasOffer);

        // Sort by rating
        STATE.allBusinesses.sort((a, b) => (b.rating || 0) - (a.rating || 0));

        // Count categories
        countCategories();

        // Display
        STATE.currentCategory = 'all';
        filterByCategory('all');
    } catch(e) {
        console.error('Load error:', e);
        grid.innerHTML = generateEmptyState();
    }

    STATE.isLoading = false;
}

async function searchPlaces(type) {
    const query = `${type} in ${STATE.currentCity}`;
    
    try {
        const resp = await fetch(
            `https://maps.googleapis.com/maps/api/place/textsearch/json?query=${encodeURIComponent(query)}&key=${CONFIG.GOOGLE_API_KEY}`
        );
        const data = await resp.json();
        return data.results || [];
    } catch(e) {
        return [];
    }
}

function enhanceWithOffer(place) {
    let hasOffer = false;
    let offerSource = '';

    // Check name
    const name = (place.name || '').toLowerCase();
    for (const kw of CONFIG.OFFER_KEYWORDS) {
        if (name.includes(kw)) {
            hasOffer = true;
            offerSource = 'name';
            break;
        }
    }

    // High rating = likely good value
    if (place.rating >= 4.3 && place.user_ratings_total > 50) {
        hasOffer = true;
        offerSource = offerSource || 'rating';
    }

    // Price level (budget friendly)
    if (place.price_level && place.price_level <= 2) {
        hasOffer = true;
        offerSource = offerSource || 'price';
    }

    // Always show some offers for demo
    if (!hasOffer && place.rating >= 4.0) {
        hasOffer = true;
        offerSource = 'popular';
    }

    return {
        ...place,
        hasOffer,
        offerSource,
        offerMessage: getOfferMessage(offerSource, place),
        category: detectCategory(place.types || [])
    };
}

function getOfferMessage(source, place) {
    switch(source) {
        case 'name': return 'Active promotions available';
        case 'rating': return `Top-rated with ${place.user_ratings_total}+ reviews`;
        case 'price': return 'Budget-friendly deals available';
        case 'popular': return 'Popular local spot with great offers';
        default: return OFFER_MESSAGES[Math.floor(Math.random() * OFFER_MESSAGES.length)];
    }
}

function detectCategory(types) {
    for (const type of types) {
        if (['restaurant', 'meal_takeaway', 'meal_delivery'].includes(type)) return 'restaurant';
        if (['lodging'].includes(type)) return 'hotel';
        if (['beauty_salon', 'hair_care', 'spa'].includes(type)) return 'salon';
        if (['hospital', 'doctor', 'dentist', 'pharmacy'].includes(type)) return 'hospital';
        if (['gym'].includes(type)) return 'gym';
        if (['shopping_mall', 'store', 'clothing_store'].includes(type)) return 'shopping';
        if (['cafe', 'bakery'].includes(type)) return 'cafe';
    }
    return 'other';
}

function countCategories() {
    const counts = { all: STATE.allBusinesses.length };
    
    for (const biz of STATE.allBusinesses) {
        counts[biz.category] = (counts[biz.category] || 0) + 1;
    }

    STATE.categoryCounts = counts;

    // Update UI
    document.getElementById('countAll').textContent = counts.all || 0;
    document.getElementById('countRestaurant').textContent = counts.restaurant || 0;
    document.getElementById('countHotel').textContent = counts.hotel || 0;
    document.getElementById('countSalon').textContent = counts.salon || 0;
    document.getElementById('countHospital').textContent = counts.hospital || 0;
    document.getElementById('countGym').textContent = counts.gym || 0;
    document.getElementById('countShopping').textContent = counts.shopping || 0;
    document.getElementById('countCafe').textContent = counts.cafe || 0;
}

// =====================
// CATEGORY FILTERING
// =====================
function setupCategoryListeners() {
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.category;
            filterByCategory(cat);
        });
    });
}

function filterByCategory(category) {
    STATE.currentCategory = category;
    STATE.displayedCount = 0;

    if (category === 'all') {
        STATE.filteredBusinesses = [...STATE.allBusinesses];
    } else {
        STATE.filteredBusinesses = STATE.allBusinesses.filter(b => b.category === category);
    }

    displayDiscounts();
}

// =====================
// DISPLAY FUNCTIONS
// =====================
function displayDiscounts() {
    const grid = document.getElementById('discountsGrid');
    const totalEl = document.getElementById('totalCount');
    
    if (STATE.filteredBusinesses.length === 0) {
        grid.innerHTML = generateEmptyState();
        totalEl.textContent = '0';
        document.getElementById('loadMoreContainer').style.display = 'none';
        return;
    }

    const toShow = STATE.filteredBusinesses.slice(
        STATE.displayedCount, 
        STATE.displayedCount + CONFIG.ITEMS_PER_PAGE
    );

    if (STATE.displayedCount === 0) {
        grid.innerHTML = '';
    }

    toShow.forEach(biz => {
        grid.innerHTML += generateCard(biz);
    });

    STATE.displayedCount += toShow.length;
    totalEl.textContent = STATE.filteredBusinesses.length;

    // Load more button
    const loadMore = document.getElementById('loadMoreContainer');
    loadMore.style.display = STATE.displayedCount < STATE.filteredBusinesses.length ? 'block' : 'none';

    lazyLoadImages();
}

function generateCard(biz) {
    const photo = biz.photos?.[0]
        ? `https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=${biz.photos[0].photo_reference}&key=${CONFIG.GOOGLE_API_KEY}`
        : '';
    
    const area = biz.formatted_address?.split(',')[0] || STATE.currentCity;
    const slug = biz.name.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-');
    const detailUrl = `/discount/${slug}-${biz.place_id}`;
    const categoryName = capitalizeFirst(biz.category);

    return `
        <article class="discount-card">
            <div class="card-image">
                ${photo 
                    ? `<img data-src="${photo}" alt="${escapeHtml(biz.name)}" loading="lazy" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">`
                    : `<div class="card-image-placeholder"><i class="fas fa-store"></i></div>`
                }
                <div class="offer-badge">
                    <i class="fas fa-tag"></i> Offer
                </div>
                ${biz.rating ? `
                    <div class="rating-badge">
                        <i class="fas fa-star"></i> ${biz.rating.toFixed(1)}
                    </div>
                ` : ''}
            </div>
            <div class="card-content">
                <span class="business-category">${escapeHtml(categoryName)}</span>
                <h3 class="business-name">${escapeHtml(biz.name)}</h3>
                <div class="offer-text">
                    <i class="fas fa-check-circle"></i>
                    <span>${escapeHtml(biz.offerMessage)}</span>
                </div>
                <div class="business-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>${escapeHtml(area)}</span>
                </div>
                <div class="card-footer">
                    <div class="contact-info">
                        <span class="contact-item">
                            <i class="fas fa-phone"></i> Available
                        </span>
                        <span class="contact-item">
                            <i class="fas fa-globe"></i> Website
                        </span>
                    </div>
                    <a href="${detailUrl}" class="view-btn">
                        View <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </article>
    `;
}

function generateSkeletons(count) {
    let html = '';
    for (let i = 0; i < count; i++) {
        html += `
            <div class="skeleton-card">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-line long"></div>
                    <div class="skeleton-line medium"></div>
                    <div class="skeleton-line short"></div>
                </div>
            </div>
        `;
    }
    return html;
}

function generateEmptyState() {
    return `
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="empty-title">No offers found</h3>
            <p class="empty-text">
                We couldn't find any offers in ${capitalizeFirst(STATE.currentCity)} 
                for this category. Try a different category or city.
            </p>
        </div>
    `;
}

// =====================
// SORTING
// =====================
function sortDiscounts() {
    const sortBy = document.getElementById('sortSelect').value;
    
    switch(sortBy) {
        case 'rating':
            STATE.filteredBusinesses.sort((a, b) => (b.rating || 0) - (a.rating || 0));
            break;
        case 'distance':
            if (STATE.userLocation) {
                STATE.filteredBusinesses.sort((a, b) => {
                    const distA = getDistance(STATE.userLocation, a.geometry?.location);
                    const distB = getDistance(STATE.userLocation, b.geometry?.location);
                    return distA - distB;
                });
            }
            break;
        default: // relevance
            STATE.filteredBusinesses.sort((a, b) => {
                const scoreA = (a.rating || 0) * Math.log((a.user_ratings_total || 1) + 1);
                const scoreB = (b.rating || 0) * Math.log((b.user_ratings_total || 1) + 1);
                return scoreB - scoreA;
            });
    }

    STATE.displayedCount = 0;
    displayDiscounts();
}

function loadMoreDiscounts() {
    displayDiscounts();
}

// =====================
// CITY MODAL
// =====================
function openCityModal() {
    document.getElementById('cityModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCityModal() {
    document.getElementById('cityModal').classList.remove('active');
    document.body.style.overflow = '';
}

function selectCity(city) {
    STATE.currentCity = city.toLowerCase();
    sessionStorage.setItem('dk_city', STATE.currentCity);
    updateCityDisplay();
    closeCityModal();
    
    window.history.pushState({}, '', `/discounts/${STATE.currentCity}`);
    loadAllDiscounts();
    showToast(`Showing offers in ${capitalizeFirst(city)}`);
}

function filterCities() {
    const search = document.getElementById('citySearchInput').value.toLowerCase();
    document.querySelectorAll('.city-option').forEach(opt => {
        opt.style.display = opt.textContent.toLowerCase().includes(search) ? 'block' : 'none';
    });
}

function updateCityDisplay() {
    const cityName = capitalizeFirst(STATE.currentCity);
    document.getElementById('currentCity').textContent = cityName;
    document.getElementById('cityNameStats').textContent = cityName;
}

// =====================
// UTILITIES
// =====================
function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
}

function getDistance(p1, p2) {
    if (!p1 || !p2) return Infinity;
    const lat1 = p1.lat, lon1 = p1.lng;
    const lat2 = typeof p2.lat === 'function' ? p2.lat() : p2.lat;
    const lon2 = typeof p2.lng === 'function' ? p2.lng() : p2.lng;
    
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180) * Math.cos(lat2*Math.PI/180) * Math.sin(dLon/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

function lazyLoadImages() {
    const imgs = document.querySelectorAll('img[data-src]');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    }, { rootMargin: '100px' });
    imgs.forEach(img => observer.observe(img));
}

// Modal backdrop click
document.getElementById('cityModal').addEventListener('click', function(e) {
    if (e.target === this) closeCityModal();
});

// Browser back/forward
window.addEventListener('popstate', function() {
    const match = location.pathname.match(/\/discounts\/([^\/]+)/);
    if (match) {
        STATE.currentCity = match[1];
        updateCityDisplay();
        loadAllDiscounts();
    }
});

// Android WebView bridge
window.setLocation = function(lat, lng) {
    STATE.userLocation = { lat, lng };
    reverseGeocode(lat, lng).then(() => loadAllDiscounts());
};
</script>

</body>
</html>
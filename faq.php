<?php include_once 'app-detect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Frequently Asked Questions about Find Business - India's free local business directory. Find answers about listings, accounts, and more.">
    <meta name="keywords" content="Find Business FAQ, business directory help, listing questions, Find Business support">
    <title>FAQ - Frequently Asked Questions | Find Business </title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* ==============================================
           CSS VARIABLES
           ============================================== */
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #ffedd5;
            --primary-50: #fff7ed;
            
            --dark-900: #0f172a;
            --dark-800: #1e293b;
            --dark-700: #334155;
            
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --success: #10b981;
            --success-light: #d1fae5;
            --info: #3b82f6;
            --info-light: #dbeafe;
            
            --font-display: 'Poppins', sans-serif;
            --font-body: 'Inter', sans-serif;
            
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
            
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 9999px;
        }

        /* ==============================================
           RESET & BASE
           ============================================== */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            color: var(--gray-700);
            background: var(--gray-50);
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            background: none;
        }

        /* ==============================================
           ANIMATIONS
           ============================================== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        @keyframes slideDown {
            from { opacity: 0; max-height: 0; }
            to { opacity: 1; max-height: 500px; }
        }

        /* ==============================================
           CONTAINER
           ============================================== */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
        }

        /* ==============================================
           HERO SECTION
           ============================================== */
        .faq-hero {
            background: linear-gradient(135deg, var(--dark-900) 0%, var(--dark-800) 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .faq-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 15s ease-in-out infinite;
        }

        .faq-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(251,191,36,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 12s ease-in-out infinite reverse;
        }

        /* Floating shapes */
        .hero-shapes {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.5;
        }

        .shape-1 { width: 8px; height: 8px; background: var(--primary); top: 20%; left: 10%; animation: float 5s ease-in-out infinite; }
        .shape-2 { width: 12px; height: 12px; background: #fbbf24; top: 60%; left: 5%; animation: float 7s ease-in-out infinite 1s; }
        .shape-3 { width: 6px; height: 6px; background: var(--primary); top: 30%; right: 15%; animation: float 6s ease-in-out infinite 0.5s; }
        .shape-4 { width: 10px; height: 10px; background: #fbbf24; top: 70%; right: 10%; animation: float 8s ease-in-out infinite 2s; }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-full);
            font-size: 14px;
            margin-bottom: 24px;
            animation: fadeInUp 0.6s ease both;
        }

        .breadcrumb a {
            color: var(--primary);
            font-weight: 500;
            transition: color 0.2s;
        }

        .breadcrumb a:hover { color: #fbbf24; }

        .breadcrumb-sep {
            color: var(--gray-500);
            display: flex;
        }

        .breadcrumb-current { color: var(--gray-300); }

        /* Hero Icon */
        .hero-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, var(--primary) 0%, #fbbf24 100%);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 40px rgba(249,115,22,0.3);
            animation: fadeInUp 0.6s ease 0.1s both;
        }

        .hero-icon svg {
            width: 36px;
            height: 36px;
            color: var(--white);
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 5vw, 42px);
            font-weight: 800;
            color: var(--white);
            margin-bottom: 12px;
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--primary) 0%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 18px;
            color: var(--gray-400);
            max-width: 500px;
            margin: 0 auto;
            animation: fadeInUp 0.6s ease 0.3s both;
        }

        /* ==============================================
           SEARCH SECTION
           ============================================== */
        .search-section {
            margin-top: -30px;
            position: relative;
            z-index: 10;
            margin-bottom: 48px;
        }

        .search-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-xl);
            max-width: 700px;
            margin: 0 auto;
            animation: fadeInUp 0.6s ease 0.4s both;
        }

        .search-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
        }

        .search-icon svg {
            width: 22px;
            height: 22px;
        }

        .search-input {
            width: 100%;
            padding: 18px 20px 18px 56px;
            font-size: 16px;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            outline: none;
            transition: all 0.3s ease;
            background: var(--gray-50);
        }

        .search-input::placeholder { color: var(--gray-400); }

        .search-input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(249,115,22,0.1);
        }

        .search-clear {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            background: var(--gray-200);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            transition: all 0.2s;
        }

        .search-clear:hover {
            background: var(--gray-300);
            color: var(--gray-700);
        }

        .search-clear.visible { display: flex; }

        .search-clear svg { width: 14px; height: 14px; }

        /* Search Results Count */
        .search-results {
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
            color: var(--gray-500);
            display: none;
        }

        .search-results.visible { display: block; }

        .search-results strong { color: var(--primary); }

        /* ==============================================
           MAIN CONTENT
           ============================================== */
        .faq-main {
            padding: 0 0 80px;
        }

        /* Category Tabs */
        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-bottom: 48px;
            animation: fadeInUp 0.6s ease 0.5s both;
        }

        .category-tab {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-600);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .category-tab:hover {
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .category-tab.active {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        }

        .category-tab svg { width: 18px; height: 18px; }

        .category-tab .count {
            background: rgba(0,0,0,0.1);
            padding: 2px 8px;
            border-radius: var(--radius-full);
            font-size: 12px;
        }

        .category-tab.active .count { background: rgba(255,255,255,0.2); }

        /* FAQ Container */
        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* FAQ Category */
        .faq-category {
            margin-bottom: 48px;
            animation: fadeInUp 0.6s ease both;
        }

        .faq-category[data-category] {
            display: block;
        }

        .faq-category.hidden { display: none; }

        .category-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .category-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .category-icon svg { width: 26px; height: 26px; }

        .category-info h2 {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .category-info p {
            font-size: 14px;
            color: var(--gray-500);
            margin-top: 2px;
        }

        /* FAQ Items */
        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .faq-item {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--gray-200);
        }

        .faq-item.active {
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .faq-item.hidden { display: none; }

        .faq-question {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 24px;
            text-align: left;
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-800);
            background: transparent;
            transition: all 0.2s;
        }

        .faq-question:hover { color: var(--primary); }

        .faq-item.active .faq-question { color: var(--primary); }

        .question-text {
            flex: 1;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .question-icon {
            width: 28px;
            height: 28px;
            background: var(--primary-light);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
            font-weight: 700;
            font-size: 14px;
        }

        .faq-item.active .question-icon {
            background: var(--primary);
            color: var(--white);
        }

        .toggle-icon {
            width: 32px;
            height: 32px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .toggle-icon svg {
            width: 18px;
            height: 18px;
            transition: transform 0.3s ease;
        }

        .faq-item.active .toggle-icon {
            background: var(--primary);
            color: var(--white);
        }

        .faq-item.active .toggle-icon svg { transform: rotate(180deg); }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
        }

        .answer-content {
            padding: 0 24px 24px 64px;
            font-size: 15px;
            line-height: 1.7;
            color: var(--gray-600);
        }

        .answer-content p { margin-bottom: 12px; }
        .answer-content p:last-child { margin-bottom: 0; }

        .answer-content strong { color: var(--gray-800); }

        .answer-content a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .answer-content a:hover { color: var(--primary-dark); }

        /* Highlight match */
        .highlight {
            background: var(--primary-light);
            padding: 2px 4px;
            border-radius: 4px;
            color: var(--primary-dark);
            font-weight: 600;
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 60px 20px;
            display: none;
        }

        .no-results.visible { display: block; }

        .no-results-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .no-results-icon svg { width: 40px; height: 40px; }

        .no-results h3 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .no-results p {
            color: var(--gray-500);
            margin-bottom: 24px;
        }

        .no-results-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.3s;
        }

        .no-results-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* ==============================================
           CTA SECTION
           ============================================== */
        .cta-section {
            margin-top: 60px;
            animation: fadeInUp 0.6s ease both;
        }

        .cta-card {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-xl);
            padding: 48px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .cta-card:hover {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-lg);
        }

        .cta-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .cta-icon svg { width: 32px; height: 32px; }

        .cta-title {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .cta-text {
            font-size: 16px;
            color: var(--gray-500);
            margin-bottom: 28px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.3s ease;
        }

        .cta-btn svg { width: 20px; height: 20px; }

        .cta-btn.primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        }

        .cta-btn.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(249,115,22,0.4);
        }

        .cta-btn.secondary {
            background: var(--white);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
        }

        .cta-btn.secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-50);
        }

        /* ==============================================
           QUICK LINKS
           ============================================== */
        .quick-links {
            margin-top: 48px;
            padding: 32px;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
        }

        .quick-links-title {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 20px;
            text-align: center;
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: var(--gray-50);
            border-radius: var(--radius-md);
            color: var(--gray-700);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .quick-link:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateX(4px);
        }

        .quick-link-icon {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }

        .quick-link-icon svg { width: 20px; height: 20px; }

        /* ==============================================
           SCROLL TO TOP
           ============================================== */
        .scroll-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 100;
            cursor: pointer;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .scroll-top svg { width: 24px; height: 24px; }

        /* ==============================================
           RESPONSIVE
           ============================================== */
        @media (max-width: 768px) {
            .faq-hero { padding: 60px 0 50px; }
            
            .hero-icon { width: 60px; height: 60px; }
            .hero-icon svg { width: 30px; height: 30px; }
            
            .search-card { padding: 16px; }
            .search-input { padding: 14px 16px 14px 48px; }
            
            .category-tabs { gap: 8px; }
            .category-tab { padding: 10px 16px; font-size: 13px; }
            .category-tab .count { display: none; }
            
            .category-header { gap: 12px; }
            .category-icon { width: 44px; height: 44px; }
            .category-icon svg { width: 22px; height: 22px; }
            .category-info h2 { font-size: 18px; }
            
            .faq-question { padding: 16px; }
            .answer-content { padding: 0 16px 16px 16px; }
            .question-icon { display: none; }
            
            .cta-card { padding: 32px 20px; }
            .cta-buttons { flex-direction: column; }
            .cta-btn { width: 100%; justify-content: center; }
            
            .quick-links { padding: 24px 16px; }
        }

        /* ==============================================
           ACCESSIBILITY
           ============================================== */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        :focus-visible {
            outline: 3px solid var(--primary);
            outline-offset: 2px;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            border: 0;
        }
        
        .app-view .mobile-footer,
.app-view footer {
    display: none !important;
}

/* Fix bottom spacing only for app */
.app-view body {
    padding-bottom: 70px;
}

    </style>
</head>
<body class="<?php echo $isApp ? 'app-view' : 'web-view'; ?>">
   <?php include 'header.php';?>
    <!-- ==============================================
         HERO SECTION
         ============================================== -->
    <section class="faq-hero">
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>

        <div class="container">
            <div class="hero-content">
                <!-- Breadcrumb -->
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="/">Home</a>
                    <span class="breadcrumb-sep">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                    </span>
                    <span class="breadcrumb-current">FAQ</span>
                </nav>

                <!-- Icon -->
                <div class="hero-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="hero-title">Frequently Asked <span>Questions</span></h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">Everything you need to know about using Find Business</p>
            </div>
        </div>
    </section>

    <!-- ==============================================
         SEARCH SECTION
         ============================================== -->
    <section class="search-section">
        <div class="container">
            <div class="search-card">
                <div class="search-wrapper">
                    <span class="search-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        class="search-input" 
                        id="faqSearch" 
                        placeholder="Search FAQ... (e.g., 'add business', 'free', 'listing')"
                        autocomplete="off"
                    >
                    <button class="search-clear" id="searchClear" aria-label="Clear search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                </div>
                <div class="search-results" id="searchResults">
                    Found <strong id="resultCount">0</strong> results
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================================
         MAIN FAQ CONTENT
         ============================================== -->
    <main class="faq-main">
        <div class="container">

            <!-- Category Tabs -->
            <div class="category-tabs" id="categoryTabs">
                <button class="category-tab active" data-category="all">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    All
                    <span class="count" id="countAll">13</span>
                </button>
                <button class="category-tab" data-category="general">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    General
                    <span class="count">3</span>
                </button>
                <button class="category-tab" data-category="listings">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Listings
                    <span class="count">4</span>
                </button>
                <button class="category-tab" data-category="managing">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Managing
                    <span class="count">2</span>
                </button>
                <button class="category-tab" data-category="users">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Users
                    <span class="count">1</span>
                </button>
                <button class="category-tab" data-category="account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Account
                    <span class="count">2</span>
                </button>
                <button class="category-tab" data-category="policy">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Policy
                    <span class="count">1</span>
                </button>
            </div>

            <!-- FAQ Container -->
            <div class="faq-container" id="faqContainer">

                <!-- Category 1: General Questions -->
                <div class="faq-category" data-category="general">
                    <div class="category-header">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="16" x2="12" y2="12"/>
                                <line x1="12" y1="8" x2="12.01" y2="8"/>
                            </svg>
                        </div>
                        <div class="category-info">
                            <h2>General Questions</h2>
                            <p>Basic information about Find Business</p>
                        </div>
                    </div>

                    <div class="faq-list">
                        <!-- FAQ Item 1 -->
                        <div class="faq-item" data-keywords="what is find-business about platform">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    What is Find-Business.com?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p><strong>Find-Business.com</strong> is a free online local business directory that helps users find businesses and services across India quickly and easily.</p>
                                    <p>Whether you're looking for a restaurant, plumber, doctor, or any local service, Find Business connects you with verified businesses in your area with complete contact details, reviews, and more.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="faq-item" data-keywords="free cost price charge payment">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Is Find-Business.com free to use?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p><strong>Yes, absolutely!</strong> Find-Business.com is completely free for both users and business owners.</p>
                                    <p>There are <strong>no listing fees</strong>, <strong>no premium plans</strong>, and <strong>no hidden charges</strong>. You can search for businesses, add your own business listing, and manage your profile entirely for free.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="faq-item" data-keywords="who can use eligibility users business owners">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Who can use Find-Business.com?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>Anyone can use Find-Business.com! Our platform serves:</p>
                                    <p><strong>• Customers</strong> — Search and discover local businesses and services in your area</p>
                                    <p><strong>• Business Owners</strong> — List your business for free and gain online visibility to reach more customers</p>
                                    <p><strong>• Service Providers</strong> — Showcase your services and connect with potential clients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 2: Business Listings -->
                <div class="faq-category" data-category="listings">
                    <div class="category-header">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div class="category-info">
                            <h2>Business Listings</h2>
                            <p>How to add and manage your business</p>
                        </div>
                    </div>

                    <div class="faq-list">
                        <!-- FAQ Item 4 -->
                        <div class="faq-item" data-keywords="add business how to list submit register">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    How do I add my business to Find-Business.com?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>Adding your business is simple and takes just a few minutes:</p>
                                    <p><strong>Step 1:</strong> Click on <a href="add_business.php">"Add Business"</a> button on the website</p>
                                    <p><strong>Step 2:</strong> Log in to your account or create a new one</p>
                                    <p><strong>Step 3:</strong> Fill in your business details (name, category, address, contact info)</p>
                                    <p><strong>Step 4:</strong> Submit the listing for review</p>
                                    <p>That's it! Your listing will be reviewed and published within 24-48 hours.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 5 -->
                        <div class="faq-item" data-keywords="how long time approval live publish">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    How long does it take for my business to go live?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>Most listings are <strong>approved within 24–48 hours</strong> after our team reviews the submission.</p>
                                    <p>During the review, we verify the basic details to ensure the listing meets our quality guidelines. Once approved, your business will be visible to all users on Find Business.</p>
                                    <p>You'll receive an email notification once your listing goes live!</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 6 -->
                        <div class="faq-item" data-keywords="multiple more than one many businesses">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Can I list more than one business?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p><strong>Yes!</strong> You can add multiple businesses using the same Find Business account.</p>
                                    <p>Simply go to your dashboard and click "Add New Business" for each additional listing. There's no limit to how many businesses you can list, and all listings are completely free.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 7 -->
                        <div class="faq-item" data-keywords="website need required mandatory url">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Do I need a website to list my business?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p><strong>No, a website is not mandatory.</strong></p>
                                    <p>You can list your business using just your basic contact details like phone number, address, and email. Many small businesses don't have websites, and Find Business serves as your online presence to help customers find you.</p>
                                    <p>However, if you do have a website, you can add it to your listing for additional visibility.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 3: Managing Listings -->
                <div class="faq-category" data-category="managing">
                    <div class="category-header">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </div>
                        <div class="category-info">
                            <h2>Managing Listings</h2>
                            <p>Edit, update, and verify your business</p>
                        </div>
                    </div>

                    <div class="faq-list">
                        <!-- FAQ Item 8 -->
                        <div class="faq-item" data-keywords="edit update change modify details">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Can I edit or update my business details later?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p><strong>Yes, absolutely!</strong> Business owners can update their details anytime from their dashboard.</p>
                                    <p>You can modify:</p>
                                    <p>• Business name, description, and category</p>
                                    <p>• Contact information (phone, email, website)</p>
                                    <p>• Address and operating hours</p>
                                    <p>• Photos and logo</p>
                                    <p>• Social media links</p>
                                    <p>Changes are typically reflected immediately or within a few hours.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 9 -->
                        <div class="faq-item" data-keywords="verified verification authentic genuine">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Are businesses on Find-Business.com verified?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>We perform <strong>basic checks before publishing</strong> any listing to ensure quality and accuracy.</p>
                                    <p>However, users are encouraged to verify business details independently before making any decisions. Look for the <strong>"Verified" badge</strong> on listings that have completed additional verification steps.</p>
                                    <p>Business owners can request enhanced verification by contacting our support team.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 4: Users & Search -->
                <div class="faq-category" data-category="users">
                    <div class="category-header">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div class="category-info">
                            <h2>Users & Search</h2>
                            <p>Finding and contacting businesses</p>
                        </div>
                    </div>

                    <div class="faq-list">
                        <!-- FAQ Item 10 -->
                        <div class="faq-item" data-keywords="contact call phone email reach business">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    How do I contact a business listed on Find-Business.com?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>You can contact businesses through multiple channels:</p>
                                    <p><strong>📞 Phone Number</strong> — Call directly using the listed phone number</p>
                                    <p><strong>✉️ Email</strong> — Send an email if the business has provided one</p>
                                    <p><strong>🌐 Website</strong> — Visit their website for more information</p>
                                    <p><strong>📱 WhatsApp</strong> — Some businesses offer WhatsApp contact</p>
                                    <p><strong>📍 Address</strong> — Visit their physical location</p>
                                    <p>All contact options are displayed on the business listing page.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 5: Account & Support -->
                <div class="faq-category" data-category="account">
                    <div class="category-header">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <div class="category-info">
                            <h2>Account & Support</h2>
                            <p>Login, password, and help</p>
                        </div>
                    </div>

                    <div class="faq-list">
                        <!-- FAQ Item 11 -->
                        <div class="faq-item" data-keywords="forgot password reset login access">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    I forgot my password. What should I do?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>Don't worry! Resetting your password is easy:</p>
                                    <p><strong>Step 1:</strong> Go to the <a href="/login">Login page</a></p>
                                    <p><strong>Step 2:</strong> Click on <strong>"Forgot Password"</strong></p>
                                    <p><strong>Step 3:</strong> Enter your registered email address</p>
                                    <p><strong>Step 4:</strong> Check your inbox for the reset link</p>
                                    <p><strong>Step 5:</strong> Click the link and create a new password</p>
                                    <p>If you don't receive the email, check your spam folder or contact our support team.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 12 -->
                        <div class="faq-item" data-keywords="report fake incorrect wrong listing problem issue">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    How can I report incorrect or fake listings?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>We take data accuracy seriously. You can report issues in two ways:</p>
                                    <p><strong>Option 1:</strong> Click the <strong>"Report Issue"</strong> button on any business listing page</p>
                                    <p><strong>Option 2:</strong> Contact our support team directly at <a href="mailto:support@find-business.com">support@find-business.com</a></p>
                                    <p>Please provide as much detail as possible about the issue. Our team will investigate and take appropriate action within 24-48 hours.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 6: Platform Policy -->
                <div class="faq-category" data-category="policy">
                    <div class="category-header">
                        <div class="category-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div class="category-info">
                            <h2>Platform Policy</h2>
                            <p>Terms, pricing, and future plans</p>
                        </div>
                    </div>

                    <div class="faq-list">
                        <!-- FAQ Item 13 -->
                        <div class="faq-item" data-keywords="paid premium subscription future pricing">
                            <button class="faq-question" aria-expanded="false">
                                <span class="question-text">
                                    <span class="question-icon">Q</span>
                                    Will Find-Business.com introduce paid features in the future?
                                </span>
                                <span class="toggle-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <div class="answer-content">
                                    <p>Currently, <strong>Find-Business.com operates as a completely free platform</strong> with no paid features.</p>
                                    <p>Our mission is to help businesses gain online visibility without any financial barrier. If we ever introduce premium features in the future, they will be:</p>
                                    <p>• <strong>Optional</strong> — Core features will always remain free</p>
                                    <p>• <strong>Clearly communicated</strong> — We'll notify all users well in advance</p>
                                    <p>• <strong>Value-driven</strong> — Only for enhanced features that provide significant additional value</p>
                                    <p>Rest assured, listing your business on Find Business will always be free!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Results Message -->
                <div class="no-results" id="noResults">
                    <div class="no-results-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            <line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                    </div>
                    <h3>No results found</h3>
                    <p>We couldn't find any FAQs matching your search. Try different keywords or browse all questions.</p>
                    <button class="no-results-btn" id="clearSearchBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                        </svg>
                        Show All FAQs
                    </button>
                </div>

            </div>

            <!-- ==============================================
                 CTA SECTION
                 ============================================== -->
            <div class="cta-section">
                <div class="cta-card">
                    <div class="cta-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <h3 class="cta-title">Still have questions?</h3>
                    <p class="cta-text">Can't find what you're looking for? Our support team is here to help you.</p>
                    <div class="cta-buttons">
                        <a href="/contact" class="cta-btn primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                            Contact Support
                        </a>
                        <a href="/add-business" class="cta-btn secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Add Your Business
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="quick-links">
                    <h4 class="quick-links-title">Quick Links</h4>
                    <div class="quick-links-grid">
                        <a href="/add_business" class="quick-link">
                            <div class="quick-link-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                            </div>
                            Add Business
                        </a>
                        <a href="/categories" class="quick-link">
                            <div class="quick-link-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"/>
                                    <rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/>
                                    <rect x="3" y="14" width="7" height="7"/>
                                </svg>
                            </div>
                            Browse Categories
                        </a>
                        <a href="/contact" class="quick-link">
                            <div class="quick-link-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            Contact Us
                        </a>
                        <a href="/term" class="quick-link">
                            <div class="quick-link-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            Terms & Conditions
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
<?php include 'footer.php';?>
    <!-- ==============================================
         SCROLL TO TOP
         ============================================== -->
    <button class="scroll-top" id="scrollTop" aria-label="Scroll to top">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m18 15-6-6-6 6"/>
        </svg>
    </button>

    <!-- ==============================================
         JAVASCRIPT
         ============================================== -->
    <script>
        (function() {
            'use strict';

            // ==============================================
            // DOM ELEMENTS
            // ==============================================
            const $ = s => document.querySelector(s);
            const $$ = s => document.querySelectorAll(s);

            const faqItems = $$('.faq-item');
            const faqCategories = $$('.faq-category');
            const categoryTabs = $$('.category-tab');
            const searchInput = $('#faqSearch');
            const searchClear = $('#searchClear');
            const searchResults = $('#searchResults');
            const resultCount = $('#resultCount');
            const noResults = $('#noResults');
            const clearSearchBtn = $('#clearSearchBtn');
            const scrollTopBtn = $('#scrollTop');
            const countAll = $('#countAll');

            let currentCategory = 'all';

            // ==============================================
            // ACCORDION FUNCTIONALITY
            // ==============================================
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Close all other items
                    faqItems.forEach(i => {
                        i.classList.remove('active');
                        i.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
                    });
                    
                    // Toggle current item
                    if (!isActive) {
                        item.classList.add('active');
                        question.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            // ==============================================
            // CATEGORY TABS
            // ==============================================
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const category = tab.dataset.category;
                    
                    // Update active tab
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    // Filter categories
                    currentCategory = category;
                    filterByCategory(category);
                    
                    // Clear search
                    searchInput.value = '';
                    searchClear.classList.remove('visible');
                    searchResults.classList.remove('visible');
                    noResults.classList.remove('visible');
                    
                    // Show all items in filtered categories
                    faqItems.forEach(item => item.classList.remove('hidden'));
                });
            });

            function filterByCategory(category) {
                faqCategories.forEach(cat => {
                    if (category === 'all' || cat.dataset.category === category) {
                        cat.classList.remove('hidden');
                    } else {
                        cat.classList.add('hidden');
                    }
                });
            }

            // ==============================================
            // SEARCH FUNCTIONALITY
            // ==============================================
            searchInput.addEventListener('input', debounce(handleSearch, 300));

            searchClear.addEventListener('click', clearSearch);
            clearSearchBtn.addEventListener('click', clearSearch);

            function handleSearch() {
                const query = searchInput.value.toLowerCase().trim();
                
                // Toggle clear button
                searchClear.classList.toggle('visible', query.length > 0);
                
                if (query.length === 0) {
                    clearSearch();
                    return;
                }
                
                // Show all categories for search
                faqCategories.forEach(cat => cat.classList.remove('hidden'));
                
                // Reset category tabs
                categoryTabs.forEach(t => t.classList.remove('active'));
                categoryTabs[0].classList.add('active');
                currentCategory = 'all';
                
                let matchCount = 0;
                
                faqItems.forEach(item => {
                    const questionText = item.querySelector('.question-text').textContent.toLowerCase();
                    const answerText = item.querySelector('.answer-content').textContent.toLowerCase();
                    const keywords = item.dataset.keywords || '';
                    
                    const searchText = questionText + ' ' + answerText + ' ' + keywords;
                    
                    if (searchText.includes(query)) {
                        item.classList.remove('hidden');
                        matchCount++;
                        highlightMatch(item, query);
                    } else {
                        item.classList.add('hidden');
                        removeHighlight(item);
                    }
                });
                
                // Show/hide categories based on visible items
                faqCategories.forEach(cat => {
                    const visibleItems = cat.querySelectorAll('.faq-item:not(.hidden)');
                    cat.classList.toggle('hidden', visibleItems.length === 0);
                });
                
                // Update results count
                resultCount.textContent = matchCount;
                searchResults.classList.add('visible');
                noResults.classList.toggle('visible', matchCount === 0);
            }

            function clearSearch() {
                searchInput.value = '';
                searchClear.classList.remove('visible');
                searchResults.classList.remove('visible');
                noResults.classList.remove('visible');
                
                // Show all items
                faqItems.forEach(item => {
                    item.classList.remove('hidden');
                    removeHighlight(item);
                });
                
                // Apply current category filter
                filterByCategory(currentCategory);
            }

            function highlightMatch(item, query) {
                // Simple highlight - can be enhanced
                const questionSpan = item.querySelector('.question-text');
                // For performance, we'll skip actual highlighting
            }

            function removeHighlight(item) {
                // Remove highlights
            }

            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // ==============================================
            // SCROLL TO TOP
            // ==============================================
            window.addEventListener('scroll', () => {
                scrollTopBtn.classList.toggle('visible', window.scrollY > 500);
            });

            scrollTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // ==============================================
            // KEYBOARD NAVIGATION
            // ==============================================
            document.addEventListener('keydown', (e) => {
                // Focus search on '/'
                if (e.key === '/' && document.activeElement !== searchInput) {
                    e.preventDefault();
                    searchInput.focus();
                }
                
                // Clear search on Escape
                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    clearSearch();
                    searchInput.blur();
                }
            });

            // ==============================================
            // ACCORDION KEYBOARD NAV
            // ==============================================
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        question.click();
                    }
                });
            });

            // ==============================================
            // URL HASH NAVIGATION
            // ==============================================
            function handleHash() {
                const hash = window.location.hash;
                if (hash) {
                    const targetCategory = hash.replace('#', '');
                    const tab = document.querySelector(`[data-category="${targetCategory}"]`);
                    if (tab) {
                        tab.click();
                    }
                }
            }

            window.addEventListener('hashchange', handleHash);
            handleHash();

            // ==============================================
            // INTERSECTION OBSERVER FOR ANIMATIONS
            // ==============================================
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            faqCategories.forEach((cat, i) => {
                cat.style.opacity = '0';
                cat.style.transform = 'translateY(20px)';
                cat.style.transition = `opacity 0.5s ease ${i * 0.1}s, transform 0.5s ease ${i * 0.1}s`;
                observer.observe(cat);
            });

        })();
    </script>

</body>
</html>
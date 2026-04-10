<?php include_once 'app-detect.php'; ?>

<?php if (!$isApp) { include 'header.php'; } ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <meta name="description" content="Find Business Help Center - Find answers, guides, and support for using India's trusted local business directory platform.">
    <meta name="keywords" content="Find Business help, business listing support, directory help, FAQ, contact support">
    <title>Help Center - Find Business | India's Trusted Business Directory</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #f97316;
            --primary-light: #fb923c;
            --primary-dark: #ea580c;
            --primary-bg: #fff7ed;
            --gray-50: #f9fafb;
            --gray-100: rgb(235, 239, 242);
            --gray-200: rgb(238, 240, 243);
            --gray-300: #c9d9f3;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--gray-800);
            background: var(--white);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
/* ===== FORCE GRAY HERO — FINAL OVERRIDE ===== */
body .help-hero {
    background: linear-gradient(
        180deg,
        #f9fafb 0%,
        #f3f4f6 60%,
        #eef0f3 100%
    ) !important;

    padding: 110px 0 85px !important;
    border-bottom: 1px solid #e5e7eb !important;
}

body .help-hero::before {
    content: "";
    position: absolute;
    top: -120px;
    right: -120px;
    width: 420px;
    height: 420px;
    background: radial-gradient(
        circle,
        rgba(249,115,22,0.08) 0%,
        transparent 70%
    ) !important;
    border-radius: 50%;
}

body .help-hero::after {
    content: "";
    position: absolute;
    bottom: -120px;
    left: -120px;
    width: 360px;
    height: 360px;
    background: radial-gradient(
        circle,
        rgba(0,0,0,0.04) 0%,
        transparent 70%
    ) !important;
    border-radius: 50%;
}

     /* ===== MODERN GRAY HERO BANNER ===== */
.help-hero {
    background: linear-gradient(
        180deg,
        #f9fafb 0%,
        #f3f4f6 60%,
        #eef0f3 100%
    );
    position: relative;
    padding: 100px 0 80px;
    border-bottom: 1px solid #e5e7eb;
}

/* soft background shapes */
.help-hero::before {
    content: "";
    position: absolute;
    top: -120px;
    right: -120px;
    width: 420px;
    height: 420px;
    background: radial-gradient(
        circle,
        rgba(249,115,22,0.08) 0%,
        transparent 70%
    );
    border-radius: 50%;
}

.help-hero::after {
    content: "";
    position: absolute;
    bottom: -120px;
    left: -120px;
    width: 360px;
    height: 360px;
    background: radial-gradient(
        circle,
        rgba(0,0,0,0.04) 0%,
        transparent 70%
    );
    border-radius: 50%;
}

        .help-hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: var(--gray-500);
            background: var(--white);
            padding: 8px 16px;
            border-radius: 50px;
            box-shadow: var(--shadow-sm);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb a:hover { text-decoration: underline; }

        .help-hero h1 {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .help-hero h1 span { color: var(--primary); }

        .help-hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Hero Stats */
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .hero-stat {
            text-align: center;
            background: var(--white);
            padding: 16px 24px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            min-width: 120px;
        }

        .hero-stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
        }

        .hero-stat-label {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        /* ========== SEARCH SECTION ========== */
        .search-section {
            position: relative;
            z-index: 10;
            margin-top: -35px;
            margin-bottom: 20px;
        }

        .search-wrapper {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 8px;
            box-shadow: var(--shadow-xl);
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid var(--gray-200);
        }

        .search-inner {
            display: flex;
            align-items: center;
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: 4px 4px 4px 20px;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .search-inner:focus-within {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(249,115,22,0.1);
        }

        .search-icon {
            color: var(--gray-400);
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 16px;
            font-size: 16px;
            font-family: inherit;
            color: var(--gray-800);
            outline: none;
        }

        .search-input::placeholder { color: var(--gray-400); }

        .search-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249,115,22,0.4);
        }

        .search-suggestions {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 700px;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            margin-top: 8px;
            padding: 8px 0;
            z-index: 100;
            border: 1px solid var(--gray-200);
        }

        .search-suggestions.active { display: block; }

        .suggestion-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .suggestion-item:hover { background: var(--primary-bg); }

        .suggestion-icon {
            width: 36px;
            height: 36px;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .suggestion-title {
            font-weight: 500;
            color: var(--gray-800);
            font-size: 14px;
        }

        .suggestion-category {
            font-size: 12px;
            color: var(--gray-500);
        }

        .no-results {
            padding: 24px;
            text-align: center;
            color: var(--gray-500);
        }

        /* ========== SECTION STYLES ========== */
        .section-padding { padding: 80px 0; }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-label {
            display: inline-block;
            background: var(--primary-bg);
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 12px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }

        /* ========== CATEGORIES SECTION ========== */
        .categories-section { background: var(--white); }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 24px;
        }

        .category-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 28px;
            border: 1px solid var(--gray-200);
            transition: all 0.25s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform 0.25s ease;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(249,115,22,0.2);
        }

        .category-card:hover::before { transform: scaleX(1); }

        .category-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .category-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
            transition: all 0.25s ease;
        }

        .category-card:hover .category-icon {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            transform: scale(1.1);
        }

        .category-card:hover .category-icon span {
            filter: grayscale(1) brightness(10);
        }

        .category-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .category-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .category-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 14px;
            padding: 10px 14px;
            background: var(--gray-50);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .category-link:hover {
            background: var(--primary-bg);
            color: var(--primary);
            padding-left: 18px;
        }

        .category-link svg {
            width: 16px;
            height: 16px;
            opacity: 0.5;
        }

        .category-link:hover svg {
            opacity: 1;
            color: var(--primary);
        }

        /* ========== FAQ SECTION ========== */
        .faq-section { background: var(--gray-50); }

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-item {
            background: var(--white);
            border-radius: var(--radius-md);
            margin-bottom: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .faq-item:hover { box-shadow: var(--shadow-md); }

        .faq-item.active {
            box-shadow: var(--shadow-lg);
            border-color: rgba(249,115,22,0.3);
        }

        .faq-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 22px 28px;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
            transition: background 0.2s ease;
        }

        .faq-question:hover { background: var(--gray-50); }
        .faq-item.active .faq-question { background: var(--primary-bg); }

        .faq-question-content {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .faq-number {
            width: 32px;
            height: 32px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-500);
            flex-shrink: 0;
            transition: all 0.25s ease;
        }

        .faq-item.active .faq-number {
            background: var(--primary);
            color: white;
        }

        .faq-question-text {
            font-size: 16px;
            font-weight: 500;
            color: var(--gray-800);
        }

        .faq-icon {
            width: 24px;
            height: 24px;
            color: var(--gray-400);
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease;
        }

        .faq-item.active .faq-answer { max-height: 500px; }

        .faq-answer-content {
            padding: 0 28px 24px 76px;
            color: var(--gray-600);
            font-size: 15px;
            line-height: 1.7;
        }

        .faq-answer-content p { margin-bottom: 12px; }
        .faq-answer-content p:last-child { margin-bottom: 0; }
        .faq-answer-content ul { margin: 12px 0; padding-left: 20px; }
        .faq-answer-content li { margin-bottom: 6px; }
        .faq-answer-content a { color: var(--primary); }

        /* ========== CONTACT SECTION ========== */
        .contact-section { background: var(--white); }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .contact-card {
            background: linear-gradient(135deg, var(--white) 0%, var(--gray-50) 100%);
            border-radius: var(--radius-lg);
            padding: 36px;
            text-align: center;
            border: 1px solid var(--gray-200);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .contact-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .contact-icon-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            transition: all 0.25s ease;
        }

        .contact-card:hover .contact-icon-wrapper {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            transform: scale(1.1);
        }

        .contact-icon-wrapper svg {
            width: 36px;
            height: 36px;
            color: var(--primary);
            transition: color 0.25s ease;
        }

        .contact-card:hover .contact-icon-wrapper svg { color: white; }

        .contact-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 12px;
        }

        .contact-card p {
            color: var(--gray-600);
            font-size: 15px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .contact-info {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid var(--gray-200);
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--gray-800);
            font-weight: 500;
            font-size: 15px;
        }

        .contact-info-item svg {
            width: 18px;
            height: 18px;
            color: var(--primary);
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249,115,22,0.4);
        }

        .contact-btn-secondary {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .contact-btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 50%, var(--gray-100) 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249,115,22,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .cta-content {
            text-align: center;
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 10px 30px rgba(249,115,22,0.3);
        }

        .cta-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .cta-title {
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 16px;
        }

        .cta-text {
            font-size: 1.1rem;
            color: var(--gray-600);
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.2s ease;
            font-family: inherit;
            cursor: pointer;
            border: none;
        }

        .cta-btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        }

        .cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(249,115,22,0.4);
        }

        .cta-btn-secondary {
            background: var(--white);
            color: var(--gray-800);
            box-shadow: var(--shadow-md);
        }

        .cta-btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        /* ========== QUICK LINKS ========== */
        .quick-links-section {
            background: var(--white);
            padding: 50px 0;
            border-top: 1px solid var(--gray-200);
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            text-align: center;
        }

        .quick-link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 24px;
            background: var(--gray-50);
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--gray-800);
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .quick-link-item:hover {
            background: var(--primary-bg);
            border-color: rgba(249,115,22,0.2);
            transform: translateY(-4px);
        }

        .quick-link-icon {
            width: 48px;
            height: 48px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .quick-link-item:hover .quick-link-icon {
            background: var(--primary);
            transform: scale(1.1);
        }

        .quick-link-item:hover .quick-link-icon span {
            filter: grayscale(1) brightness(10);
        }

        .quick-link-text {
            font-weight: 500;
            font-size: 15px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .help-hero { padding: 80px 0 60px; }
            .section-padding { padding: 50px 0; }
            .hero-stats { gap: 20px; }
            .hero-stat { min-width: 100px; padding: 12px 16px; }
            .hero-stat-number { font-size: 1.5rem; }
            .search-section { margin-top: -30px; }
            
            .search-inner {
                flex-direction: column;
                padding: 12px;
                gap: 12px;
            }
            
            .search-input { width: 100%; text-align: center; }
            .search-btn { width: 100%; justify-content: center; }
            .categories-grid { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
            
            .faq-question { padding: 18px 20px; }
            .faq-answer-content { padding: 0 20px 20px 20px; }
            .faq-number { display: none; }
            
            .cta-buttons { flex-direction: column; }
            .cta-btn { width: 100%; justify-content: center; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 16px; }
            .help-hero { padding: 60px 0 50px; }
            .category-card { padding: 20px; }
            .contact-card { padding: 28px 20px; }
            
            .quick-links-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            
            .quick-link-item { padding: 16px; }
            .quick-link-icon { width: 40px; height: 40px; font-size: 18px; }
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

    <!-- ========== HERO SECTION ========== -->
    <?php if (!$isApp): ?>
    <section class="help-hero">
        <div class="container">
            <div class="help-hero-content">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="index.php">Home</a>
                    <span>→</span>
                    <span>Help Center</span>
                </nav>
                <h1>Help <span>Center</span></h1>
                <p class="help-hero-subtitle">Find answers, guides, and support for using Find Business — India's trusted local business directory platform</p>
                
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">50+</div>
                        <div class="hero-stat-label">Help Articles</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">24/7</div>
                        <div class="hero-stat-label">Support</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">2hr</div>
                        <div class="hero-stat-label">Avg Response</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SEARCH SECTION ========== -->
    <section class="search-section">
        <div class="container">
            <div class="search-wrapper">
                <div class="search-inner">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" class="search-input" id="helpSearch" placeholder="Search help topics, business listing, account, support..." autocomplete="off">
                    <button class="search-btn" type="button" id="searchBtn">
                        <span>Search</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
                <div class="search-suggestions" id="searchSuggestions"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== CATEGORIES SECTION ========== -->
    <section class="categories-section section-padding">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Browse Topics</span>
                <h2 class="section-title">How Can We Help You?</h2>
                <p class="section-subtitle">Choose a category below to quickly find the answers you're looking for</p>
            </div>

            <div class="categories-grid">
                <!-- Category 1 -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon"><span>🏢</span></div>
                        <h3 class="category-title">About Find Business</h3>
                    </div>
                    <div class="category-links">
                        <a href="#faq-1" class="category-link faq-link" data-faq="1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            What is Find Business?
                        </a>
                        <a href="#faq-2" class="category-link faq-link" data-faq="2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Is Find Business free to use?
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Our mission & vision
                        </a>
                    </div>
                </div>

                <!-- Category 2 -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon"><span>🧾</span></div>
                        <h3 class="category-title">For Business Owners</h3>
                    </div>
                    <div class="category-links">
                        <a href="#faq-3" class="category-link faq-link" data-faq="3">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            How to add a business
                        </a>
                        <a href="#faq-5" class="category-link faq-link" data-faq="5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Edit business details
                        </a>
                        <a href="#faq-4" class="category-link faq-link" data-faq="4">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Listing approval time
                        </a>
                    </div>
                </div>

                <!-- Category 3 -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon"><span>👥</span></div>
                        <h3 class="category-title">For Users</h3>
                    </div>
                    <div class="category-links">
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            How to contact businesses
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Are listings verified?
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Search tips & filters
                        </a>
                    </div>
                </div>

                <!-- Category 4 -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon"><span>🔐</span></div>
                        <h3 class="category-title">Account & Security</h3>
                    </div>
                    <div class="category-links">
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Forgot password
                        </a>
                        <a href="#faq-6" class="category-link faq-link" data-faq="6">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Account safety & privacy
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Two-factor authentication
                        </a>
                    </div>
                </div>

                <!-- Category 5 -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon"><span>⚠️</span></div>
                        <h3 class="category-title">Report an Issue</h3>
                    </div>
                    <div class="category-links">
                        <a href="#faq-7" class="category-link faq-link" data-faq="7">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Report fake listings
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Incorrect information
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Technical issues
                        </a>
                    </div>
                </div>

                <!-- Category 6 -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon"><span>💬</span></div>
                        <h3 class="category-title">Feedback & Suggestions</h3>
                    </div>
                    <div class="category-links">
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Submit feedback
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Feature requests
                        </a>
                        <a href="#" class="category-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            Platform improvements
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FAQ SECTION ========== -->
    <?php if (!$isApp): ?>
    <section class="faq-section section-padding" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="section-label">FAQ</span>
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Quick answers to the most common questions about Find Business</p>
            </div>

            <div class="faq-container">
                <!-- FAQ 1 -->
                <div class="faq-item" id="faq-1">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">01</span>
                            <span class="faq-question-text">What is Find-Business.com?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Find-Business.com is India's trusted local business directory platform that connects customers with verified local businesses across the country. Whether you're looking for a nearby restaurant, doctor, plumber, or any other service provider, Find Business helps you find the right business quickly and easily.</p>
                            <p>Our platform provides detailed business information including contact details, addresses, working hours, customer reviews, and more — all in one convenient place.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item" id="faq-2">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">02</span>
                            <span class="faq-question-text">Is Find Business completely free?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p><strong>Yes, Find Business is 100% free for both users and businesses!</strong></p>
                            <ul>
                                <li><strong>For Users:</strong> Search, browse, and contact any business completely free of charge.</li>
                                <li><strong>For Business Owners:</strong> Create your basic business listing at no cost.</li>
                            </ul>
                            <p>We may offer premium features in the future, but core directory features will always remain free.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item" id="faq-3">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">03</span>
                            <span class="faq-question-text">How do I list my business on Find Business?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Listing your business on Find Business is quick and simple! Follow these steps:</p>
                            <ul>
                                <li><strong>Step 1:</strong> Click on "Add Your Business" or "Free Listing" button</li>
                                <li><strong>Step 2:</strong> Fill in your business details (name, category, address, contact info)</li>
                                <li><strong>Step 3:</strong> Add photos of your business (optional but recommended)</li>
                                <li><strong>Step 4:</strong> Submit your listing for review</li>
                                <li><strong>Step 5:</strong> Once approved, your business will be live on Find Business!</li>
                            </ul>
                            <p>The entire process takes less than 5 minutes.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item" id="faq-4">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">04</span>
                            <span class="faq-question-text">How long does listing approval take?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Our team reviews all business listings to ensure quality and accuracy. The typical approval timeline is:</p>
                            <ul>
                                <li><strong>Standard Review:</strong> 24-48 hours (business days)</li>
                                <li><strong>Complete Listings:</strong> Listings with complete information and photos are often approved faster</li>
                            </ul>
                            <p>You'll receive an email notification once your listing is approved.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item" id="faq-5">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">05</span>
                            <span class="faq-question-text">Can I edit my business listing after submission?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p><strong>Yes, absolutely!</strong> You can edit your business information anytime after your listing is live.</p>
                            <ul>
                                <li>Log in to your Find Business account</li>
                                <li>Go to "My Business" or "Dashboard"</li>
                                <li>Click "Edit" on your listing</li>
                                <li>Make your changes and save</li>
                            </ul>
                            <p>Some changes may require re-approval, but most updates go live immediately.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item" id="faq-6">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">06</span>
                            <span class="faq-question-text">Is my personal data safe on Find Business?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p><strong>Your privacy and data security are our top priorities.</strong></p>
                            <ul>
                                <li><strong>Secure Encryption:</strong> All data is encrypted using industry-standard SSL/TLS protocols</li>
                                <li><strong>Privacy Controls:</strong> You choose what information to display publicly</li>
                                <li><strong>No Data Selling:</strong> We never sell your personal information to third parties</li>
                                <li><strong>Regular Security Audits:</strong> Our systems are regularly tested and updated</li>
                            </ul>
                            <p>For more details, please read our <a href="privacy-policy.php">Privacy Policy</a>.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="faq-item" id="faq-7">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">07</span>
                            <span class="faq-question-text">How can I report a fake or incorrect listing?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We take listing accuracy very seriously. If you find a fake or incorrect listing, please report it:</p>
                            <ul>
                                <li>Click the "Report" button on the business listing page</li>
                                <li>Or email us at <a href="mailto:support@find-business.com">support@find-business.com</a></li>
                                <li>Provide as much detail as possible about the issue</li>
                            </ul>
                            <p>Our team will investigate and take appropriate action within 48 hours.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="faq-item" id="faq-8">
                    <button class="faq-question" aria-expanded="false">
                        <div class="faq-question-content">
                            <span class="faq-number">08</span>
                            <span class="faq-question-text">Which cities and areas does Find Business cover?</span>
                        </div>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p><strong>Find Business covers businesses across all of India!</strong></p>
                            <ul>
                                <li>All major metropolitan cities (Delhi, Mumbai, Bangalore, Chennai, Kolkata, etc.)</li>
                                <li>Tier 2 and Tier 3 cities</li>
                                <li>Growing coverage in smaller towns and rural areas</li>
                            </ul>
                            <p>Our goal is to make local business discovery easy for every Indian. If your area doesn't have many listings yet, be the first to add your business!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== CONTACT SECTION ========== -->
    <section class="contact-section section-padding">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Get in Touch</span>
                <h2 class="section-title">Contact Our Support Team</h2>
                <p class="section-subtitle">Can't find what you're looking for? Our friendly support team is here to help</p>
            </div>

            <div class="contact-grid">
                <!-- Email -->
                <div class="contact-card">
                    <div class="contact-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <h3>Email Support</h3>
                    <p>Send us an email and we'll get back to you within 24-48 hours</p>
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            support@find-business.com
                        </div>
                    </div>
                    <a href="mailto:support@find-business.com" class="contact-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        Send Email
                    </a>
                </div>

                <!-- Phone -->
                <div class="contact-card">
                    <div class="contact-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <h3>Phone Support</h3>
                    <p>Speak directly with our support team during business hours</p>
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            +91 97145 84578
                        </div>
                    </div>
                    <a href="tel:+919800000000" class="contact-btn contact-btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        Call Now
                    </a>
                </div>

                <!-- Service Area -->
                <div class="contact-card">
                    <div class="contact-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <h3>Service Area</h3>
                    <p>Find Business proudly serves businesses and users across India</p>
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                            🇮🇳 All India
                        </div>
                    </div>
                     <?php if (!$isApp): ?>
                    <a href="contact.php" class="contact-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                        Contact Support
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA SECTION ========== -->
    <?php if (!$isApp): ?>
    <section class="cta-section section-padding">
        <div class="container">
            <div class="cta-content">
                <div class="cta-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                </div>
                <h2 class="cta-title">Still Need Help?</h2>
                <p class="cta-text">Our dedicated support team is always ready to assist you. Don't hesitate to reach out — we're here to make your Find Business experience seamless!</p>
                <div class="cta-buttons">
                    <a href="contact.php" class="cta-btn cta-btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                        Go to Contact Page
                    </a>
                    <a href="add-business.php" class="cta-btn cta-btn-secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Add Your Business
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== QUICK LINKS ========== -->
    <section class="quick-links-section">
        <div class="container">
            <div class="quick-links-grid">
                <a href="index.php" class="quick-link-item">
                    <div class="quick-link-icon"><span>🏠</span></div>
                    <span class="quick-link-text">Home</span>
                </a>
                <a href="categories.php" class="quick-link-item">
                    <div class="quick-link-icon"><span>📂</span></div>
                    <span class="quick-link-text">Categories</span>
                </a>
                <a href="add-business.php" class="quick-link-item">
                    <div class="quick-link-icon"><span>➕</span></div>
                    <span class="quick-link-text">Add Business</span>
                </a>
                <a href="about.php" class="quick-link-item">
                    <div class="quick-link-icon"><span>ℹ️</span></div>
                    <span class="quick-link-text">About Us</span>
                </a>
                <a href="contact.php" class="quick-link-item">
                    <div class="quick-link-icon"><span>📞</span></div>
                    <span class="quick-link-text">Contact</span>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== FAST OPTIMIZED JAVASCRIPT ========== -->
    <script>
    (function() {
        'use strict';
        
        // Cache DOM elements once
        const $ = (sel, ctx = document) => ctx.querySelector(sel);
        const $$ = (sel, ctx = document) => ctx.querySelectorAll(sel);
        
        const searchInput = $('#helpSearch');
        const searchSuggestions = $('#searchSuggestions');
        const faqItems = $$('.faq-item');
        const faqLinks = $$('.faq-link');
        
        // Search data
        const searchData = [
            { t: 'What is Find Business?', c: 'About', i: '🏢', f: 1 },
            { t: 'Is Find Business free?', c: 'About', i: '🏢', f: 2 },
            { t: 'How to add a business', c: 'Business', i: '🧾', f: 3 },
            { t: 'Listing approval time', c: 'Business', i: '🧾', f: 4 },
            { t: 'Edit business listing', c: 'Business', i: '🧾', f: 5 },
            { t: 'Account safety', c: 'Security', i: '🔐', f: 6 },
            { t: 'Report fake listings', c: 'Report', i: '⚠️', f: 7 },
            { t: 'Service area coverage', c: 'About', i: '🏢', f: 8 },
            { t: 'Forgot password', c: 'Security', i: '🔐', f: 0 },
            { t: 'Contact businesses', c: 'Users', i: '👥', f: 0 },
            { t: 'Verified listings', c: 'Users', i: '👥', f: 0 },
            { t: 'Submit feedback', c: 'Feedback', i: '💬', f: 0 }
        ];

        // FAQ Accordion - Event Delegation
        $('.faq-container').addEventListener('click', function(e) {
            const question = e.target.closest('.faq-question');
            if (!question) return;
            
            const item = question.closest('.faq-item');
            const isActive = item.classList.contains('active');
            
            // Close all
            faqItems.forEach(i => {
                i.classList.remove('active');
                i.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            });
            
            // Open clicked if wasn't active
            if (!isActive) {
                item.classList.add('active');
                question.setAttribute('aria-expanded', 'true');
            }
        });

        // FAQ Links - Navigate to FAQ
        faqLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const faqId = this.dataset.faq;
                const target = $('#faq-' + faqId);
                
                if (target) {
                    faqItems.forEach(i => i.classList.remove('active'));
                    target.classList.add('active');
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });

        // Search - Debounced
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase().trim();
            
            if (query.length < 2) {
                searchSuggestions.classList.remove('active');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                const results = searchData.filter(item => 
                    item.t.toLowerCase().includes(query) || 
                    item.c.toLowerCase().includes(query)
                );
                
                if (results.length) {
                    searchSuggestions.innerHTML = results.slice(0, 6).map(item => `
                        <div class="suggestion-item" data-faq="${item.f}">
                            <div class="suggestion-icon">${item.i}</div>
                            <div>
                                <div class="suggestion-title">${item.t}</div>
                                <div class="suggestion-category">${item.c}</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    searchSuggestions.innerHTML = `
                        <div class="no-results">
                            No results found for "${query}"<br>
                            <small>Try different keywords or <a href="contact.php" style="color:var(--primary)">contact support</a></small>
                        </div>
                    `;
                }
                searchSuggestions.classList.add('active');
            }, 150);
        });

        // Search suggestions click - Event Delegation
        searchSuggestions.addEventListener('click', function(e) {
            const item = e.target.closest('.suggestion-item');
            if (!item) return;
            
            const faqId = item.dataset.faq;
            if (faqId && faqId !== '0') {
                const target = $('#faq-' + faqId);
                if (target) {
                    faqItems.forEach(i => i.classList.remove('active'));
                    target.classList.add('active');
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            searchSuggestions.classList.remove('active');
            searchInput.value = '';
        });

        // Close suggestions on outside click
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                searchSuggestions.classList.remove('active');
            }
        });

        // Search button
        $('#searchBtn').addEventListener('click', () => {
            if (searchInput.value.trim()) {
                searchInput.dispatchEvent(new Event('input'));
            }
        });

        // Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.trim()) {
                    this.dispatchEvent(new Event('input'));
                }
            }
        });

        // Handle hash on load
        if (location.hash) {
            const target = $(location.hash);
            if (target && target.classList.contains('faq-item')) {
                setTimeout(() => {
                    faqItems.forEach(i => i.classList.remove('active'));
                    target.classList.add('active');
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            }
        }

    })();
    </script>

</body>
</html>

<?php include 'footer.php'; ?>
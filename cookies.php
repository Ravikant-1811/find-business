<?php include_once 'app-detect.php'; ?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cookies Policy for Find Business - Learn how we use cookies to improve your browsing experience on India's trusted business directory.">
    <meta name="keywords" content="Find Business cookies policy, cookie usage, website cookies, browser cookies India">
    <meta name="robots" content="index, follow">
    
    <title>Cookies Policy – Find Business | India's Trusted Business Directory </title> 
    <!-- Open Graph / WhatsApp Preview -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://find-business.com/cookies">
<meta property="og:title" content="Cookies Policy – Find Business">
<meta property="og:description" content="Learn how Find Business uses cookies to improve your browsing experience on India’s trusted business directory.">
<meta property="og:image" content="https://find-business.com/assets/images/find-business-preview.png">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://find-business.com/cookies">
<meta name="twitter:title" content="Cookies Policy – Find Business">
<meta name="twitter:description" content="Learn how Find Business uses cookies to enhance your browsing experience.">
<meta name="twitter:image" content="https://find-business.com/assets/images/find-business-preview.png">
<!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ==============================================
           CSS CUSTOM PROPERTIES
           ============================================== */
        :root {
            /* Brand Colors */
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #ffedd5;
            --primary-50: #fff7ed;
            --primary-100: #ffedd5;
            --primary-200: #fed7aa;
            
            /* Dark Colors for Hero */
            --dark-950: #020617;
            --dark-900: #0f172a;
            --dark-800: #1e293b;
            --dark-700: #334155;
            --dark-600: #475569;
            
            /* Neutrals */
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
            
            /* Semantic */
            --success: #10b981;
            --success-light: #d1fae5;
            --info: #3b82f6;
            --info-light: #dbeafe;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            
            /* Typography */
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 40px rgba(249, 115, 22, 0.3);
            
            /* Border Radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 9999px;
        }

        /* ==============================================
           RESET & BASE STYLES
           ============================================== */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            font-family: var(--font-family);
            font-size: 16px;
            line-height: 1.7;
            color: var(--gray-700);
            background-color: var(--white);
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--primary-dark);
        }

        /* ==============================================
           ANIMATIONS
           ============================================== */
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

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 30px rgba(249, 115, 22, 0.3); }
            50% { box-shadow: 0 0 50px rgba(249, 115, 22, 0.5); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
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
            .container {
                padding: 0 16px;
            }
        }

        /* ==============================================
           🌑 DARK GRAY HERO SECTION
           ============================================== */
        .cookies-hero {
            position: relative;
            background: linear-gradient(135deg, var(--dark-900) 0%, var(--dark-800) 50%, var(--dark-700) 100%);
            padding: 80px 0 70px;
            overflow: hidden;
            min-height: 380px;
            display: flex;
            align-items: center;
        }

        /* Animated Background Glow */
        .cookies-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -25%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        .cookies-hero::after {
            content: '';
            position: absolute;
            bottom: -40%;
            left: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 15s ease-in-out infinite reverse;
            pointer-events: none;
        }

        /* Grid Pattern Overlay */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }

        /* Floating Cookie Decorations */
        .hero-shapes {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
        }

        .shape-1 {
            width: 10px;
            height: 10px;
            background: var(--primary);
            top: 18%;
            left: 8%;
            animation: float 5s ease-in-out infinite;
        }

        .shape-2 {
            width: 14px;
            height: 14px;
            background: #fbbf24;
            top: 65%;
            left: 5%;
            animation: float 7s ease-in-out infinite 1s;
        }

        .shape-3 {
            width: 8px;
            height: 8px;
            background: var(--primary);
            top: 25%;
            right: 12%;
            animation: float 6s ease-in-out infinite 0.5s;
        }

        .shape-4 {
            width: 12px;
            height: 12px;
            background: #fbbf24;
            top: 72%;
            right: 8%;
            animation: float 8s ease-in-out infinite 2s;
        }

        .shape-5 {
            width: 6px;
            height: 6px;
            background: var(--primary-light);
            top: 45%;
            right: 22%;
            animation: float 4s ease-in-out infinite 1.5s;
        }

        .shape-6 {
            width: 16px;
            height: 16px;
            background: rgba(249, 115, 22, 0.4);
            top: 38%;
            left: 18%;
            animation: float 9s ease-in-out infinite 0.8s;
        }

        /* Cookie Emoji Decorations */
        .cookie-emoji {
            position: absolute;
            font-size: 32px;
            opacity: 0.2;
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
        }

        .cookie-emoji-1 { top: 20%; left: 12%; animation-delay: 0s; }
        .cookie-emoji-2 { top: 60%; left: 6%; animation-delay: 1s; }
        .cookie-emoji-3 { top: 15%; right: 15%; animation-delay: 0.5s; }
        .cookie-emoji-4 { top: 70%; right: 10%; animation-delay: 1.5s; }

        /* Hero Content */
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
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 28px;
            animation: fadeInDown 0.6s ease forwards;
        }

        .breadcrumb a {
            color: var(--primary);
            transition: color 0.2s;
        }

        .breadcrumb a:hover {
            color: #fbbf24;
        }

        .breadcrumb-separator {
            color: var(--gray-500);
            display: flex;
            align-items: center;
        }

        .breadcrumb-separator svg {
            width: 14px;
            height: 14px;
        }

        .breadcrumb-current {
            color: var(--gray-300);
        }

        /* Hero Icon */
        .hero-icon {
            width: 88px;
            height: 88px;
            margin: 0 auto 28px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-glow);
            animation: fadeInUp 0.6s ease 0.1s forwards, glow 3s ease-in-out infinite;
            opacity: 0;
            position: relative;
        }

        .hero-icon::before {
            content: '';
            position: absolute;
            inset: -4px;
            background: linear-gradient(135deg, var(--primary), #fbbf24, var(--primary));
            border-radius: var(--radius-xl);
            z-index: -1;
            opacity: 0.4;
            filter: blur(15px);
        }

        .hero-icon svg {
            width: 44px;
            height: 44px;
            color: var(--white);
        }

        /* Hero Title */
        .hero-title {
            font-size: clamp(32px, 5vw, 50px);
            font-weight: 800;
            color: var(--white);
            margin-bottom: 16px;
            letter-spacing: -0.5px;
            animation: fadeInUp 0.6s ease 0.2s forwards;
            opacity: 0;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--primary) 0%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Hero Subtitle */
        .hero-subtitle {
            font-size: 18px;
            color: var(--gray-400);
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.7;
            animation: fadeInUp 0.6s ease 0.3s forwards;
            opacity: 0;
        }

        /* Last Updated Badge */
        .last-updated {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 28px;
            padding: 12px 22px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: var(--radius-full);
            font-size: 13px;
            font-weight: 600;
            color: var(--success);
            animation: fadeInUp 0.6s ease 0.4s forwards;
            opacity: 0;
        }

        .last-updated svg {
            width: 16px;
            height: 16px;
        }

        /* Hero Stats */
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 48px;
            margin-top: 40px;
            animation: fadeInUp 0.6s ease 0.5s forwards;
            opacity: 0;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 13px;
            color: var(--gray-400);
            margin-top: 6px;
        }

        @media (max-width: 768px) {
            .cookies-hero {
                padding: 60px 0 50px;
                min-height: auto;
            }

            .hero-icon {
                width: 72px;
                height: 72px;
            }

            .hero-icon svg {
                width: 36px;
                height: 36px;
            }

            .hero-stats {
                gap: 32px;
            }

            .hero-stat-value {
                font-size: 24px;
            }

            .cookie-emoji {
                display: none;
            }
        }

        /* ==============================================
           MAIN CONTENT
           ============================================== */
        .cookies-main {
            padding: 60px 0 80px;
            background: var(--white);
        }

        .cookies-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }

        @media (min-width: 1024px) {
            .cookies-layout {
                grid-template-columns: 260px 1fr;
                gap: 50px;
            }
        }

        /* ==============================================
           TABLE OF CONTENTS SIDEBAR
           ============================================== */
        .toc-sidebar {
            display: none;
        }

        @media (min-width: 1024px) {
            .toc-sidebar {
                display: block;
            }
        }

        .toc-card {
            position: sticky;
            top: 100px;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-md);
        }

        .toc-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 2px solid var(--gray-100);
        }

        .toc-header-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-50) 100%);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .toc-header-icon svg {
            width: 17px;
            height: 17px;
        }

        .toc-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--gray-800);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .toc-list {
            list-style: none;
        }

        .toc-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-600);
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
            position: relative;
        }

        .toc-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            border-radius: 2px;
            transition: height 0.2s ease;
        }

        .toc-link:hover {
            background: var(--gray-50);
            color: var(--primary);
        }

        .toc-link.active {
            background: var(--primary-50);
            color: var(--primary);
        }

        .toc-link.active::before {
            height: 24px;
        }

        .toc-number {
            width: 24px;
            height: 24px;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--gray-500);
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .toc-link.active .toc-number,
        .toc-link:hover .toc-number {
            background: var(--primary);
            color: var(--white);
        }

        .toc-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ==============================================
           CONTENT CARD
           ============================================== */
        .cookies-content {
            max-width: 820px;
        }

        .content-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        /* Content Header */
        .content-header {
            background: linear-gradient(135deg, var(--dark-800) 0%, var(--dark-900) 100%);
            padding: 30px 36px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .content-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .content-header-inner {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .content-header-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
        }

        .content-header-icon svg {
            width: 28px;
            height: 28px;
        }

        .content-header-text h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .content-header-text p {
            font-size: 14px;
            color: var(--gray-400);
        }

        /* Content Body */
        .content-body {
            padding: 44px;
        }

        @media (max-width: 768px) {
            .content-header {
                padding: 24px;
            }

            .content-body {
                padding: 24px;
            }
        }

        /* ==============================================
           POLICY SECTIONS
           ============================================== */
        .policy-section {
            margin-bottom: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid var(--gray-200);
            scroll-margin-top: 100px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .policy-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .policy-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        /* Section Header */
        .section-header {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-50) 100%);
            border: 2px solid var(--primary-200);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }

        .section-icon svg {
            width: 24px;
            height: 24px;
        }

        .section-title-wrap {
            flex: 1;
        }

        .section-number {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            background: var(--primary-50);
            padding: 4px 12px;
            border-radius: var(--radius-full);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.3;
        }

        /* Section Content */
        .section-content {
            padding-left: 64px;
        }

        @media (max-width: 640px) {
            .section-content {
                padding-left: 0;
            }

            .section-header {
                flex-direction: column;
                gap: 12px;
            }
        }

        .section-content p {
            font-size: 15px;
            line-height: 1.8;
            color: var(--gray-600);
            margin-bottom: 16px;
        }

        .section-content p:last-child {
            margin-bottom: 0;
        }

        .section-content strong {
            color: var(--gray-800);
            font-weight: 600;
        }

        /* Info Lists */
        .info-list {
            list-style: none;
            margin: 20px 0;
            padding: 0;
        }

        .info-list li {
            position: relative;
            padding: 14px 0 14px 46px;
            font-size: 15px;
            color: var(--gray-600);
            border-bottom: 1px dashed var(--gray-200);
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--success-light) 0%, #a7f3d0 100%);
            border-radius: 50%;
        }

        .info-list li::after {
            content: '✓';
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            font-weight: 700;
            color: var(--success);
        }

        /* Cookie Type Cards */
        .cookie-types {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 24px 0;
        }

        .cookie-type-card {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 22px 26px;
            transition: all 0.3s ease;
        }

        .cookie-type-card:hover {
            border-color: var(--primary-200);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .cookie-type-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .cookie-type-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cookie-type-icon svg {
            width: 22px;
            height: 22px;
        }

        .cookie-type-icon.essential {
            background: linear-gradient(135deg, var(--success-light) 0%, #a7f3d0 100%);
            color: var(--success);
        }

        .cookie-type-icon.analytics {
            background: linear-gradient(135deg, var(--info-light) 0%, #93c5fd 100%);
            color: var(--info);
        }

        .cookie-type-icon.functional {
            background: linear-gradient(135deg, var(--warning-light) 0%, #fde68a 100%);
            color: var(--warning);
        }

        .cookie-type-info {
            flex: 1;
        }

        .cookie-type-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .cookie-type-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: var(--radius-full);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .cookie-type-badge.required {
            background: var(--success-light);
            color: var(--success);
        }

        .cookie-type-badge.optional {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .cookie-type-description {
            font-size: 14px;
            color: var(--gray-600);
            line-height: 1.7;
            padding-left: 56px;
        }

        @media (max-width: 640px) {
            .cookie-type-description {
                padding-left: 0;
                margin-top: 12px;
            }

            .cookie-type-badge {
                display: none;
            }
        }

        /* Highlight Box */
        .highlight-box {
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--primary-100) 100%);
            border-left: 4px solid var(--primary);
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
            padding: 20px 24px;
            margin: 24px 0;
        }

        .highlight-box p {
            margin: 0;
            color: var(--gray-700);
        }

        .highlight-box.info {
            background: linear-gradient(135deg, var(--info-light) 0%, #bfdbfe 100%);
            border-left-color: var(--info);
        }

        .highlight-box.warning {
            background: linear-gradient(135deg, var(--warning-light) 0%, #fde68a 100%);
            border-left-color: var(--warning);
        }

        .highlight-box.success {
            background: linear-gradient(135deg, var(--success-light) 0%, #a7f3d0 100%);
            border-left-color: var(--success);
        }

        /* Info Card */
        .info-card {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 22px;
            margin: 24px 0;
        }

        .info-card-icon {
            width: 44px;
            height: 44px;
            background: var(--white);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }

        .info-card-icon svg {
            width: 22px;
            height: 22px;
        }

        .info-card-content {
            flex: 1;
        }

        .info-card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 4px;
        }

        .info-card-text {
            font-size: 14px;
            color: var(--gray-600);
            margin: 0;
            line-height: 1.6;
        }

        /* Browser Settings Table */
        .browser-table {
            width: 100%;
            margin: 24px 0;
            border-collapse: collapse;
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .browser-table th {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: 16px 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .browser-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--gray-600);
            border-bottom: 1px solid var(--gray-100);
        }

        .browser-table tr:last-child td {
            border-bottom: none;
        }

        .browser-table tr:hover td {
            background: var(--gray-50);
        }

        .browser-name {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            color: var(--gray-800);
        }

        .browser-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        @media (max-width: 640px) {
            .browser-table {
                display: block;
                overflow-x: auto;
            }
        }

        /* ==============================================
           CONTACT SECTION
           ============================================== */
        .contact-section {
            background: linear-gradient(135deg, var(--dark-900) 0%, var(--dark-800) 100%);
            border-radius: var(--radius-xl);
            padding: 48px;
            margin-top: 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .contact-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .contact-content {
            position: relative;
            z-index: 1;
        }

        .contact-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            background: rgba(249, 115, 22, 0.15);
            border: 1px solid rgba(249, 115, 22, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .contact-icon svg {
            width: 34px;
            height: 34px;
        }

        .contact-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 10px;
        }

        .contact-text {
            font-size: 16px;
            color: var(--gray-400);
            margin-bottom: 28px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }

        .contact-email {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 28px;
        }

        .contact-email svg {
            width: 24px;
            height: 24px;
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(249, 115, 22, 0.35);
        }

        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(249, 115, 22, 0.5);
            color: var(--white);
        }

        .contact-btn svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 640px) {
            .contact-section {
                padding: 36px 24px;
            }

            .contact-email {
                font-size: 17px;
                flex-direction: column;
                gap: 10px;
            }
        }

        /* ==============================================
           SCROLL TO TOP BUTTON
           ============================================== */
        .scroll-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 50%;
            color: var(--white);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-lg), var(--shadow-glow);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl), 0 0 50px rgba(249, 115, 22, 0.4);
        }

        .scroll-top svg {
            width: 24px;
            height: 24px;
        }

        /* ==============================================
           TRUST FOOTER BADGE
           ============================================== */
        .trust-footer {
            text-align: center;
            padding: 48px 0;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
        }

        .trust-badge {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 20px 32px;
            background: var(--white);
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-lg);
        }

        .trust-badge-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--success-light) 0%, #a7f3d0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--success);
        }

        .trust-badge-icon svg {
            width: 24px;
            height: 24px;
        }

        .trust-badge-text {
            font-size: 16px;
            color: var(--gray-600);
        }

        .trust-badge-text strong {
            color: var(--gray-900);
        }

        /* ==============================================
           MOBILE TABLE OF CONTENTS
           ============================================== */
        .mobile-toc {
            display: block;
            margin-bottom: 28px;
        }

        @media (min-width: 1024px) {
            .mobile-toc {
                display: none;
            }
        }

        .mobile-toc-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .mobile-toc-btn:hover {
            border-color: var(--primary);
        }

        .mobile-toc-btn svg {
            width: 20px;
            height: 20px;
            color: var(--gray-500);
            transition: transform 0.2s ease;
        }

        .mobile-toc-btn.active svg {
            transform: rotate(180deg);
        }

        .mobile-toc-content {
            display: none;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-top: none;
            border-radius: 0 0 var(--radius-md) var(--radius-md);
            padding: 16px;
            max-height: 350px;
            overflow-y: auto;
        }

        .mobile-toc-content.visible {
            display: block;
        }

        .mobile-toc-list {
            list-style: none;
        }

        .mobile-toc-list li {
            border-bottom: 1px solid var(--gray-100);
        }

        .mobile-toc-list li:last-child {
            border-bottom: none;
        }

        .mobile-toc-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 10px;
            font-size: 14px;
            color: var(--gray-600);
            transition: all 0.2s ease;
            border-radius: var(--radius-sm);
        }

        .mobile-toc-link:hover {
            color: var(--primary);
            background: var(--primary-50);
        }

        .mobile-toc-link span {
            font-weight: 700;
            color: var(--primary);
            min-width: 28px;
        }

        /* ==============================================
           ACCESSIBILITY
           ============================================== */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }

            html {
                scroll-behavior: auto;
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
            clip: rect(0, 0, 0, 0);
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

    <!-- ==============================================
         🌑 DARK GRAY HERO SECTION
         ============================================== -->
    <section class="cookies-hero">
        <!-- Grid Pattern -->
        <div class="hero-grid"></div>

        <!-- Floating Shapes -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
            <div class="shape shape-6"></div>
        </div>

        <!-- Cookie Emoji Decorations -->
        <span class="cookie-emoji cookie-emoji-1">🍪</span>
        <span class="cookie-emoji cookie-emoji-2">🍪</span>
        <span class="cookie-emoji cookie-emoji-3">🍪</span>
        <span class="cookie-emoji cookie-emoji-4">🍪</span>

        <div class="container">
            <div class="hero-content">
                <!-- Breadcrumb -->
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="/">Home</a>
                    <span class="breadcrumb-separator" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </span>
                    <span class="breadcrumb-current">Cookies Policy</span>
                </nav>

                <!-- Hero Icon -->
                <div class="hero-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <circle cx="8" cy="9" r="1" fill="currentColor"/>
                        <circle cx="15" cy="8" r="1" fill="currentColor"/>
                        <circle cx="10" cy="14" r="1" fill="currentColor"/>
                        <circle cx="16" cy="13" r="1" fill="currentColor"/>
                        <circle cx="12" cy="17" r="1" fill="currentColor"/>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="hero-title">Cookies <span>Policy</span></h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">
                    How Find Business uses cookies to improve your browsing experience on our platform
                </p>

                <!-- Last Updated -->
                <div class="last-updated">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Last Updated: January 15, 2025
                </div>

                <!-- Hero Stats -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">Minimal</div>
                        <div class="hero-stat-label">Cookie Usage</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">100%</div>
                        <div class="hero-stat-label">Transparent</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">You</div>
                        <div class="hero-stat-label">In Control</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================================
         MAIN CONTENT
         ============================================== -->
    <main class="cookies-main">
        <div class="container">
            <div class="cookies-layout">

                <!-- TABLE OF CONTENTS SIDEBAR -->
                <aside class="toc-sidebar">
                    <div class="toc-card">
                        <div class="toc-header">
                            <div class="toc-header-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="8" y1="6" x2="21" y2="6"/>
                                    <line x1="8" y1="12" x2="21" y2="12"/>
                                    <line x1="8" y1="18" x2="21" y2="18"/>
                                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                                </svg>
                            </div>
                            <h2 class="toc-title">Contents</h2>
                        </div>
                        <nav>
                            <ul class="toc-list" id="tocList">
                                <li><a href="#introduction" class="toc-link active"><span class="toc-number">01</span><span class="toc-text">Introduction</span></a></li>
                                <li><a href="#what-are-cookies" class="toc-link"><span class="toc-number">02</span><span class="toc-text">What Are Cookies?</span></a></li>
                                <li><a href="#how-we-use" class="toc-link"><span class="toc-number">03</span><span class="toc-text">How We Use Cookies</span></a></li>
                                <li><a href="#types-of-cookies" class="toc-link"><span class="toc-number">04</span><span class="toc-text">Types of Cookies</span></a></li>
                                <li><a href="#third-party" class="toc-link"><span class="toc-number">05</span><span class="toc-text">Third-Party Cookies</span></a></li>
                                <li><a href="#managing-cookies" class="toc-link"><span class="toc-number">06</span><span class="toc-text">Managing Cookies</span></a></li>
                                <li><a href="#no-misuse" class="toc-link"><span class="toc-number">07</span><span class="toc-text">No Data Misuse</span></a></li>
                                <li><a href="#policy-updates" class="toc-link"><span class="toc-number">08</span><span class="toc-text">Policy Updates</span></a></li>
                                <li><a href="#contact" class="toc-link"><span class="toc-number">09</span><span class="toc-text">Contact Us</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <!-- COOKIES CONTENT -->
                <div class="cookies-content">

                    <!-- Mobile TOC -->
                    <div class="mobile-toc">
                        <button class="mobile-toc-btn" id="mobileTocBtn" aria-expanded="false">
                            <span>📑 Table of Contents</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="mobile-toc-content" id="mobileTocContent">
                            <ul class="mobile-toc-list">
                                <li><a href="#introduction" class="mobile-toc-link"><span>01</span> Introduction</a></li>
                                <li><a href="#what-are-cookies" class="mobile-toc-link"><span>02</span> What Are Cookies?</a></li>
                                <li><a href="#how-we-use" class="mobile-toc-link"><span>03</span> How We Use Cookies</a></li>
                                <li><a href="#types-of-cookies" class="mobile-toc-link"><span>04</span> Types of Cookies</a></li>
                                <li><a href="#third-party" class="mobile-toc-link"><span>05</span> Third-Party Cookies</a></li>
                                <li><a href="#managing-cookies" class="mobile-toc-link"><span>06</span> Managing Cookies</a></li>
                                <li><a href="#no-misuse" class="mobile-toc-link"><span>07</span> No Data Misuse</a></li>
                                <li><a href="#policy-updates" class="mobile-toc-link"><span>08</span> Policy Updates</a></li>
                                <li><a href="#contact" class="mobile-toc-link"><span>09</span> Contact Us</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Content Card -->
                    <div class="content-card">
                        <!-- Content Header -->
                        <div class="content-header">
                            <div class="content-header-inner">
                                <div class="content-header-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <circle cx="8" cy="9" r="1" fill="currentColor"/>
                                        <circle cx="15" cy="8" r="1" fill="currentColor"/>
                                        <circle cx="10" cy="14" r="1" fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="content-header-text">
                                    <h2>Find Business Cookies Policy</h2>
                                    <p>Understanding how we use cookies on our platform</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Body -->
                        <div class="content-body">

                            <!-- Section 1: Introduction -->
                            <section class="policy-section" id="introduction">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 01</span>
                                        <h3 class="section-title">Introduction</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>This Cookies Policy explains how <strong>Find Business</strong> ("we", "us", or "our") uses cookies and similar technologies when you visit our website at <strong>find-business.com</strong>.</p>
                                    <p>We believe in being transparent about how we collect and use data. This policy provides you with clear information about what cookies are, why we use them, and how you can control them.</p>
                                    <div class="highlight-box success">
                                        <p><strong>Our Commitment:</strong> We only use cookies that are necessary for the proper functioning of our website and to enhance your browsing experience. We respect your privacy.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 2: What Are Cookies? -->
                            <section class="policy-section" id="what-are-cookies">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="16" x2="12" y2="12"/>
                                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 02</span>
                                        <h3 class="section-title">What Are Cookies?</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p><strong>Cookies</strong> are small text files that are stored on your device (computer, tablet, or mobile phone) when you visit a website. They are widely used to make websites work efficiently and provide useful information to website owners.</p>
                                    <p>Cookies help websites remember your actions and preferences (such as login details, language, and display settings) over a period of time, so you don't have to keep re-entering them whenever you return to the site.</p>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Similar Technologies</p>
                                            <p class="info-card-text">Besides cookies, we may also use similar technologies like web beacons, pixels, and local storage to collect and store information about your visit.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 3: How Find Business Uses Cookies -->
                            <section class="policy-section" id="how-we-use">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="3"/>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 03</span>
                                        <h3 class="section-title">How Find Business Uses Cookies</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We use cookies for the following purposes:</p>
                                    <ul class="info-list">
                                        <li><strong>Website Functionality</strong> — Ensuring the website works properly and remembers your preferences</li>
                                        <li><strong>Performance Optimization</strong> — Improving website speed and loading times</li>
                                        <li><strong>User Experience</strong> — Personalizing content and remembering your settings</li>
                                        <li><strong>Security</strong> — Protecting your account and preventing fraud</li>
                                        <li><strong>Analytics</strong> — Understanding how visitors use our website to improve it</li>
                                        <li><strong>Session Management</strong> — Keeping you logged in during your visit</li>
                                    </ul>
                                </div>
                            </section>

                            <!-- Section 4: Types of Cookies Used -->
                            <section class="policy-section" id="types-of-cookies">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="7" height="7"/>
                                            <rect x="14" y="3" width="7" height="7"/>
                                            <rect x="14" y="14" width="7" height="7"/>
                                            <rect x="3" y="14" width="7" height="7"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 04</span>
                                        <h3 class="section-title">Types of Cookies We Use</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We use different types of cookies on our website:</p>
                                    <div class="cookie-types">
                                        <!-- Essential Cookies -->
                                        <div class="cookie-type-card">
                                            <div class="cookie-type-header">
                                                <div class="cookie-type-icon essential">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                                        <polyline points="9 12 11 14 15 10"/>
                                                    </svg>
                                                </div>
                                                <div class="cookie-type-info">
                                                    <span class="cookie-type-title">Essential Cookies</span>
                                                </div>
                                                <span class="cookie-type-badge required">Required</span>
                                            </div>
                                            <p class="cookie-type-description">These cookies are necessary for the website to function properly. They enable basic features like page navigation, secure login, and access to protected areas. The website cannot function properly without these cookies.</p>
                                        </div>

                                        <!-- Performance Cookies -->
                                        <div class="cookie-type-card">
                                            <div class="cookie-type-header">
                                                <div class="cookie-type-icon analytics">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <line x1="18" y1="20" x2="18" y2="10"/>
                                                        <line x1="12" y1="20" x2="12" y2="4"/>
                                                        <line x1="6" y1="20" x2="6" y2="14"/>
                                                    </svg>
                                                </div>
                                                <div class="cookie-type-info">
                                                    <span class="cookie-type-title">Performance & Analytics Cookies</span>
                                                </div>
                                                <span class="cookie-type-badge optional">Optional</span>
                                            </div>
                                            <p class="cookie-type-description">These cookies help us understand how visitors interact with our website by collecting anonymous information about page visits, traffic sources, and user behavior. This data helps us improve website performance.</p>
                                        </div>

                                        <!-- Functional Cookies -->
                                        <div class="cookie-type-card">
                                            <div class="cookie-type-header">
                                                <div class="cookie-type-icon functional">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="3"/>
                                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.26.604.852.997 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09c-.658.003-1.25.396-1.51 1z"/>
                                                    </svg>
                                                </div>
                                                <div class="cookie-type-info">
                                                    <span class="cookie-type-title">Functional Cookies</span>
                                                </div>
                                                <span class="cookie-type-badge optional">Optional</span>
                                            </div>
                                            <p class="cookie-type-description">These cookies enable enhanced functionality and personalization, such as remembering your language preference, location, or display settings. They may be set by us or by third-party services we use.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 5: Third-Party Cookies -->
                            <section class="policy-section" id="third-party">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="18" cy="5" r="3"/>
                                            <circle cx="6" cy="12" r="3"/>
                                            <circle cx="18" cy="19" r="3"/>
                                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 05</span>
                                        <h3 class="section-title">Third-Party Cookies</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>Some cookies on our website are placed by third-party services that we use:</p>
                                    <ul class="info-list">
                                        <li><strong>Google Analytics</strong> — Helps us understand website traffic and user behavior</li>
                                        <li><strong>Social Media Plugins</strong> — Enable sharing content on social platforms</li>
                                        <li><strong>Security Services</strong> — Protect against spam and malicious activity</li>
                                    </ul>
                                    <div class="highlight-box warning">
                                        <p><strong>Important:</strong> We do not control third-party cookies. These services have their own privacy and cookie policies. We recommend reviewing their policies for more information about how they use cookies.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 6: Managing Cookies -->
                            <section class="policy-section" id="managing-cookies">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 06</span>
                                        <h3 class="section-title">Managing Cookies</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>You have control over cookies. Here's how you can manage them:</p>
                                    <ul class="info-list">
                                        <li><strong>Accept Cookies</strong> — Continue using our website normally</li>
                                        <li><strong>Block Cookies</strong> — Configure your browser to block cookies</li>
                                        <li><strong>Delete Cookies</strong> — Clear existing cookies through browser settings</li>
                                    </ul>
                                    <p style="margin-top: 24px;"><strong>Browser Cookie Settings:</strong></p>
                                    <table class="browser-table">
                                        <thead>
                                            <tr>
                                                <th>Browser</th>
                                                <th>How to Manage Cookies</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="browser-name"><span class="browser-icon">🌐</span>Google Chrome</span></td>
                                                <td>Settings → Privacy and Security → Cookies</td>
                                            </tr>
                                            <tr>
                                                <td><span class="browser-name"><span class="browser-icon">🦊</span>Mozilla Firefox</span></td>
                                                <td>Settings → Privacy & Security → Cookies</td>
                                            </tr>
                                            <tr>
                                                <td><span class="browser-name"><span class="browser-icon">🧭</span>Safari</span></td>
                                                <td>Preferences → Privacy → Cookies</td>
                                            </tr>
                                            <tr>
                                                <td><span class="browser-name"><span class="browser-icon">🔷</span>Microsoft Edge</span></td>
                                                <td>Settings → Cookies and Site Permissions</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                                                        <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                <line x1="12" y1="9" x2="12" y2="13"/>
                                                <line x1="12" y1="17" x2="12.01" y2="17"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Impact of Disabling Cookies</p>
                                            <p class="info-card-text">Please note that blocking or deleting cookies may affect your browsing experience. Some features of our website may not work properly without cookies.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 7: No Personal Data Misuse -->
                            <section class="policy-section" id="no-misuse">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                            <path d="m9 12 2 2 4-4"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 07</span>
                                        <h3 class="section-title">No Personal Data Misuse</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We are committed to protecting your privacy. Here's what we <strong>DO NOT</strong> do with cookies:</p>
                                    <ul class="info-list">
                                        <li><strong>No sensitive data collection</strong> — We never collect sensitive personal information like Aadhaar numbers, financial details, or health records through cookies</li>
                                        <li><strong>No password storage</strong> — We never store your passwords in cookies</li>
                                        <li><strong>No data selling</strong> — We never sell cookie data or any personal information to third parties</li>
                                        <li><strong>No unauthorized tracking</strong> — We only track anonymous usage data for improving our services</li>
                                    </ul>
                                    <div class="highlight-box success">
                                        <p><strong>Your Trust Matters:</strong> We use cookies responsibly and only for legitimate purposes. Your data is safe with us.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 8: Policy Updates -->
                            <section class="policy-section" id="policy-updates">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 08</span>
                                        <h3 class="section-title">Policy Updates</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We may update this Cookies Policy from time to time to reflect changes in our practices or for legal, technical, or operational reasons.</p>
                                    <ul class="info-list">
                                        <li>The "Last Updated" date at the top of this page will be revised when changes are made</li>
                                        <li>We encourage you to review this policy periodically to stay informed</li>
                                        <li>Continued use of our website after updates constitutes acceptance of the revised policy</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Stay Informed</p>
                                            <p class="info-card-text">For significant changes, we may notify registered users via email. Bookmark this page to check for updates.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 9: Contact Information -->
                            <section class="policy-section" id="contact">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 09</span>
                                        <h3 class="section-title">Contact Information</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>If you have any questions about this Cookies Policy or how we use cookies, please don't hesitate to contact us:</p>

                                    <!-- Contact Card -->
                                    <div class="contact-section">
                                        <div class="contact-content">
                                            <div class="contact-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                </svg>
                                            </div>
                                            <h4 class="contact-title">Have Questions?</h4>
                                            <p class="contact-text">Our team is happy to answer your questions about cookies and data privacy.</p>
                                            <div class="contact-email">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                </svg>
                                                support@find-business.com
                                            </div>
                                            <a href="/contact" class="contact-btn">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                                </svg>
                                                Contact Support
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ==============================================
         TRUST FOOTER BADGE
         ============================================== -->
    <section class="trust-footer">
        <div class="container">
            <div class="trust-badge">
                <div class="trust-badge-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>
                <p class="trust-badge-text">
                    <strong>We respect your privacy.</strong> Cookies are used responsibly to improve your experience.
                </p>
            </div>
        </div>
    </section>

    <!-- ==============================================
         SCROLL TO TOP BUTTON
         ============================================== -->
    <button class="scroll-top" id="scrollTopBtn" aria-label="Scroll to top">
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
            const $ = selector => document.querySelector(selector);
            const $$ = selector => document.querySelectorAll(selector);

            const scrollTopBtn = $('#scrollTopBtn');
            const tocLinks = $$('.toc-link');
            const sections = $$('.policy-section');
            const mobileTocBtn = $('#mobileTocBtn');
            const mobileTocContent = $('#mobileTocContent');
            const mobileLinks = $$('.mobile-toc-link');

            // ==============================================
            // THROTTLE FUNCTION
            // ==============================================
            function throttle(func, limit) {
                let inThrottle;
                return function(...args) {
                    if (!inThrottle) {
                        func.apply(this, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                };
            }

            // ==============================================
            // SCROLL HANDLING
            // ==============================================
            function handleScroll() {
                const scrollY = window.scrollY;

                // Show/hide scroll to top button
                if (scrollTopBtn) {
                    scrollTopBtn.classList.toggle('visible', scrollY > 400);
                }

                // Update active TOC link
                updateActiveTocLink();

                // Animate sections on scroll
                animateSections();
            }

            // Throttled scroll listener
            window.addEventListener('scroll', throttle(handleScroll, 100));

            // ==============================================
            // SCROLL TO TOP
            // ==============================================
            function scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            if (scrollTopBtn) {
                scrollTopBtn.addEventListener('click', scrollToTop);
            }

            // ==============================================
            // ACTIVE TOC LINK TRACKING
            // ==============================================
            function updateActiveTocLink() {
                let currentSection = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 150;
                    const sectionHeight = section.offsetHeight;

                    if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                        currentSection = section.getAttribute('id');
                    }
                });

                // Update desktop TOC
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentSection}`) {
                        link.classList.add('active');
                    }
                });
            }

            // ==============================================
            // ANIMATE SECTIONS ON SCROLL
            // ==============================================
            function animateSections() {
                sections.forEach(section => {
                    const sectionTop = section.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (sectionTop < windowHeight * 0.85) {
                        section.classList.add('visible');
                    }
                });
            }

            // ==============================================
            // SMOOTH SCROLL FOR ANCHOR LINKS
            // ==============================================
            function smoothScrollToAnchor(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = $(targetId);

                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 100;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });

                    // Close mobile TOC if open
                    if (mobileTocContent && mobileTocContent.classList.contains('visible')) {
                        mobileTocContent.classList.remove('visible');
                        mobileTocBtn.classList.remove('active');
                        mobileTocBtn.setAttribute('aria-expanded', 'false');
                    }
                }
            }

            // Desktop TOC links
            tocLinks.forEach(link => {
                link.addEventListener('click', smoothScrollToAnchor);
            });

            // Mobile TOC links
            mobileLinks.forEach(link => {
                link.addEventListener('click', smoothScrollToAnchor);
            });

            // ==============================================
            // MOBILE TABLE OF CONTENTS TOGGLE
            // ==============================================
            if (mobileTocBtn && mobileTocContent) {
                mobileTocBtn.addEventListener('click', () => {
                    const isExpanded = mobileTocBtn.classList.toggle('active');
                    mobileTocContent.classList.toggle('visible');
                    mobileTocBtn.setAttribute('aria-expanded', isExpanded);
                });
            }

            // ==============================================
            // KEYBOARD NAVIGATION
            // ==============================================
            document.addEventListener('keydown', (e) => {
                const activeElement = document.activeElement;
                const isInput = activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA';

                if (!isInput) {
                    // Press 'T' to scroll to top
                    if (e.key === 't' || e.key === 'T') {
                        scrollToTop();
                    }

                    // Press 'Escape' to close mobile TOC
                    if (e.key === 'Escape' && mobileTocContent?.classList.contains('visible')) {
                        mobileTocContent.classList.remove('visible');
                        mobileTocBtn.classList.remove('active');
                        mobileTocBtn.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            // ==============================================
            // URL HASH HANDLING
            // ==============================================
            function handleHash() {
                const hash = window.location.hash;
                if (hash) {
                    const targetElement = $(hash);
                    if (targetElement) {
                        setTimeout(() => {
                            const offsetTop = targetElement.offsetTop - 100;
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                        }, 100);
                    }
                }
            }

            window.addEventListener('hashchange', handleHash);

            // Handle hash on page load
            if (window.location.hash) {
                handleHash();
            }

            // ==============================================
            // PRINT SUPPORT
            // ==============================================
            window.addEventListener('beforeprint', () => {
                sections.forEach(section => {
                    section.classList.add('visible');
                });
            });

            // ==============================================
            // INITIALIZE
            // ==============================================
            function init() {
                // Initial scroll handling
                handleScroll();

                // Animate first visible sections
                setTimeout(() => {
                    sections.forEach((section, index) => {
                        if (index < 2) {
                            section.classList.add('visible');
                        }
                    });
                }, 200);

                // Add staggered animation delays
                sections.forEach((section, index) => {
                    section.style.transitionDelay = `${index * 0.05}s`;
                });
            }

            // Run on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

        })();
    </script>

</body>
</html>

<?php include 'footer.php'; ?>
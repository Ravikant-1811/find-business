<?php include_once 'app-detect.php'; ?>

<?php include 'header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terms and Conditions for Find Business - India's trusted business directory platform. Read our terms of service, user responsibilities, and legal policies.">
    <meta name="keywords" content="Find Business terms, terms and conditions, business directory terms, legal terms India">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Find Business">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Terms & Conditions | Find Business">
    <meta property="og:description" content="Read the terms and conditions for using Find Business - India's trusted business directory.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://find-business.com/terms">
    
    <title>Terms & Conditions | Find Business - India's Business Directory</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* ==============================================
           🎨 CSS CUSTOM PROPERTIES
           ============================================== */
        :root {
            /* Primary Colors */
            --primary-50: #FFF7ED;
            --primary-100: #FFEDD5;
            --primary-200: #FED7AA;
            --primary-300: #FDBA74;
            --primary-400: #FB923C;
            --primary-500: #F97316;
            --primary-600: #EA580C;
            --primary-700: #C2410C;
            --primary-800: #9A3412;
            
            /* Dark Theme Colors */
            --dark-900: #0F172A;
            --dark-800: #1E293B;
            --dark-700: #334155;
            --dark-600: #475569;
            
            /* Neutral Colors */
            --white: #FFFFFF;
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
            
            /* Semantic Colors */
            --success: #10B981;
            --success-light: #D1FAE5;
            --info: #3B82F6;
            --info-light: #DBEAFE;
            --warning: #F59E0B;
            --warning-light: #FEF3C7;
            
            /* Gradients */
            --gradient-dark: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
            --gradient-primary: linear-gradient(135deg, #F97316 0%, #FB923C 50%, #FBBF24 100%);
            --gradient-glass: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            
            /* Typography */
            --font-display: 'Poppins', sans-serif;
            --font-body: 'Inter', sans-serif;
            
            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
            
            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --radius-full: 9999px;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-glow: 0 0 40px rgba(249,115,22,0.15);
            
            /* Transitions */
            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --duration-fast: 150ms;
            --duration-normal: 300ms;
            --duration-slow: 500ms;
        }

        /* ==============================================
           🔄 CSS RESET
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
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.7;
            color: var(--gray-700);
            background: var(--gray-50);
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
        }

        /* ==============================================
           🎭 ANIMATIONS
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

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* ==============================================
           📦 CONTAINER
           ============================================== */
        .dk-container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 var(--space-6);
        }

        @media (max-width: 768px) {
            .dk-container {
                padding: 0 var(--space-4);
            }
        }

        /* ==============================================
           🦸 HERO SECTION
           ============================================== */
        .terms-hero {
            position: relative;
            background: var(--gradient-dark);
            padding: var(--space-16) 0 var(--space-12);
            overflow: hidden;
            min-height: 320px;
            display: flex;
            align-items: center;
        }

        /* Animated Background Pattern */
        .hero-pattern {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .hero-pattern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
        }

        .hero-pattern::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(251,191,36,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 15s ease-in-out infinite reverse;
        }

        /* Grid Pattern Overlay */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            opacity: 0.5;
        }

        /* Floating Shapes */
        .hero-shapes {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
        }

        .shape-1 {
            width: 8px;
            height: 8px;
            background: var(--primary-400);
            top: 20%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            width: 12px;
            height: 12px;
            background: var(--primary-300);
            top: 60%;
            left: 5%;
            animation: float 8s ease-in-out infinite 1s;
        }

        .shape-3 {
            width: 6px;
            height: 6px;
            background: var(--primary-500);
            top: 30%;
            right: 15%;
            animation: float 7s ease-in-out infinite 0.5s;
        }

        .shape-4 {
            width: 10px;
            height: 10px;
            background: var(--primary-400);
            top: 70%;
            right: 10%;
            animation: float 9s ease-in-out infinite 2s;
        }

        .shape-5 {
            width: 14px;
            height: 14px;
            background: var(--primary-200);
            top: 45%;
            right: 25%;
            animation: float 5s ease-in-out infinite 1.5s;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-4);
            background: var(--gradient-glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            margin-bottom: var(--space-6);
            animation: fadeInUp 0.6s var(--ease-out) both;
        }

        .breadcrumb a {
            color: var(--primary-400);
            font-weight: 500;
            transition: color var(--duration-fast);
        }

        .breadcrumb a:hover {
            color: var(--primary-300);
        }

        .breadcrumb-sep {
            color: var(--gray-500);
            display: flex;
        }

        .breadcrumb-sep svg {
            width: 16px;
            height: 16px;
        }

        .breadcrumb-current {
            color: var(--gray-300);
        }

        /* Hero Icon */
        .hero-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-6);
            background: var(--gradient-primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-glow);
            animation: fadeInUp 0.6s var(--ease-out) 0.1s both;
        }

        .hero-icon svg {
            width: 40px;
            height: 40px;
            color: var(--white);
        }

        /* Hero Title */
        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: var(--white);
            margin-bottom: var(--space-4);
            animation: fadeInUp 0.6s var(--ease-out) 0.2s both;
        }

        .hero-title span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: var(--gray-400);
            max-width: 600px;
            margin: 0 auto;
            animation: fadeInUp 0.6s var(--ease-out) 0.3s both;
        }

        /* Last Updated Badge */
        .last-updated {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            margin-top: var(--space-6);
            padding: var(--space-2) var(--space-4);
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(16,185,129,0.3);
            border-radius: var(--radius-full);
            font-size: 0.8125rem;
            color: var(--success);
            animation: fadeInUp 0.6s var(--ease-out) 0.4s both;
        }

        .last-updated svg {
            width: 14px;
            height: 14px;
        }

        /* ==============================================
           📄 MAIN CONTENT LAYOUT
           ============================================== */
        .terms-main {
            padding: var(--space-12) 0 var(--space-16);
            margin-top: -var(--space-8);
            position: relative;
        }

        .terms-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-8);
        }

        @media (min-width: 1024px) {
            .terms-layout {
                grid-template-columns: 280px 1fr;
                gap: var(--space-10);
            }
        }

        /* ==============================================
           📑 SIDEBAR NAVIGATION
           ============================================== */
        .terms-sidebar {
            display: none;
        }

        @media (min-width: 1024px) {
            .terms-sidebar {
                display: block;
            }
        }

        .sidebar-card {
            position: sticky;
            top: 100px;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: var(--space-6);
            border: 1px solid var(--gray-100);
            animation: fadeInLeft 0.6s var(--ease-out) both;
        }

        .sidebar-title {
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: var(--space-4);
            padding-bottom: var(--space-3);
            border-bottom: 2px solid var(--gray-100);
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: var(--space-1);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            font-size: 0.875rem;
            color: var(--gray-600);
            border-radius: var(--radius-md);
            transition: all var(--duration-normal) var(--ease-out);
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--gradient-primary);
            transform: scaleY(0);
            transition: transform var(--duration-normal) var(--ease-out);
        }

        .sidebar-link:hover {
            background: var(--primary-50);
            color: var(--primary-600);
        }

        .sidebar-link.active {
            background: var(--primary-50);
            color: var(--primary-600);
            font-weight: 600;
        }

        .sidebar-link.active::before {
            transform: scaleY(1);
        }

        .sidebar-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: 0.7;
        }

        .sidebar-link-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-link-number {
            font-size: 0.6875rem;
            font-weight: 700;
            color: var(--gray-400);
            background: var(--gray-100);
            padding: 2px 8px;
            border-radius: var(--radius-full);
        }

        .sidebar-link.active .sidebar-link-number {
            background: var(--primary-100);
            color: var(--primary-600);
        }

        /* Progress Indicator */
        .reading-progress {
            margin-top: var(--space-6);
            padding-top: var(--space-4);
            border-top: 1px solid var(--gray-100);
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-2);
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .progress-bar {
            height: 6px;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: var(--gradient-primary);
            border-radius: var(--radius-full);
            transition: width var(--duration-normal);
        }

        /* ==============================================
           📜 CONTENT SECTIONS
           ============================================== */
        .terms-content {
            animation: fadeInRight 0.6s var(--ease-out) 0.2s both;
        }

        .terms-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            border: 1px solid var(--gray-100);
        }

        /* Card Header */
        .terms-header {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
            padding: var(--space-8);
            border-bottom: 1px solid var(--gray-100);
        }

        .terms-header-content {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .terms-header-icon {
            width: 56px;
            height: 56px;
            background: var(--gradient-primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .terms-header-icon svg {
            width: 28px;
            height: 28px;
        }

        .terms-header-info h2 {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .terms-header-info p {
            font-size: 0.875rem;
            color: var(--gray-500);
            margin-top: var(--space-1);
        }

        /* Content Body */
        .terms-body {
            padding: var(--space-8);
        }

        @media (max-width: 768px) {
            .terms-header {
                padding: var(--space-6);
            }

            .terms-body {
                padding: var(--space-5);
            }
        }

        /* Individual Section */
        .terms-section {
            margin-bottom: var(--space-10);
            padding-bottom: var(--space-10);
            border-bottom: 1px dashed var(--gray-200);
            scroll-margin-top: 100px;
        }

        .terms-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        /* Section Header */
        .section-header {
            display: flex;
            align-items: flex-start;
            gap: var(--space-4);
            margin-bottom: var(--space-5);
        }

        .section-number {
            width: 40px;
            height: 40px;
            background: var(--primary-50);
            border: 2px solid var(--primary-200);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-600);
            flex-shrink: 0;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-100);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-600);
            flex-shrink: 0;
        }

        .section-icon svg {
            width: 20px;
            height: 20px;
        }

        .section-title-wrap {
            flex: 1;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.3;
        }

        .section-meta {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-top: var(--space-2);
        }

        .section-tag {
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius-sm);
        }

        .tag-important {
            background: var(--warning-light);
            color: var(--warning);
        }

        .tag-legal {
            background: var(--info-light);
            color: var(--info);
        }

        /* Section Content */
        .section-content {
            padding-left: 56px;
        }

        @media (max-width: 640px) {
            .section-content {
                padding-left: 0;
            }
        }

        .section-content p {
            font-size: 0.9375rem;
            color: var(--gray-600);
            line-height: 1.8;
            margin-bottom: var(--space-4);
        }

        .section-content p:last-child {
            margin-bottom: 0;
        }

        .section-content strong {
            color: var(--gray-800);
            font-weight: 600;
        }

        /* Styled Lists */
        .terms-list {
            list-style: none;
            margin: var(--space-4) 0;
        }

        .terms-list li {
            position: relative;
            padding: var(--space-3) 0 var(--space-3) var(--space-8);
            font-size: 0.9375rem;
            color: var(--gray-600);
            border-left: 2px solid var(--gray-100);
        }

        .terms-list li::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background: var(--primary-500);
            border-radius: 50%;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 2px var(--primary-200);
        }

        .terms-list li:hover {
            border-left-color: var(--primary-300);
        }

        /* Highlight Box */
        .highlight-box {
            background: linear-gradient(135deg, var(--primary-50) 0%, rgba(255,237,213,0.5) 100%);
            border: 1px solid var(--primary-200);
            border-left: 4px solid var(--primary-500);
            border-radius: var(--radius-md);
            padding: var(--space-5);
            margin: var(--space-5) 0;
        }

        .highlight-box p {
            color: var(--gray-700);
            margin: 0;
        }

        .highlight-box.warning {
            background: linear-gradient(135deg, var(--warning-light) 0%, rgba(254,243,199,0.5) 100%);
            border-color: var(--warning);
            border-left-color: var(--warning);
        }

        .highlight-box.info {
            background: linear-gradient(135deg, var(--info-light) 0%, rgba(219,234,254,0.5) 100%);
            border-color: var(--info);
            border-left-color: var(--info);
        }

        /* Info Card */
        .info-card {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: var(--space-5);
            margin: var(--space-5) 0;
            display: flex;
            align-items: flex-start;
            gap: var(--space-4);
        }

        .info-card-icon {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-500);
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }

        .info-card-icon svg {
            width: 20px;
            height: 20px;
        }

        .info-card-content {
            flex: 1;
        }

        .info-card-title {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: var(--space-2);
        }

        .info-card-text {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin: 0;
        }

        /* Contact Card */
        .contact-card {
            background: var(--gradient-dark);
            border-radius: var(--radius-xl);
            padding: var(--space-8);
            margin-top: var(--space-8);
            position: relative;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(249,115,22,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .contact-card-content {
            position: relative;
            z-index: 1;
        }

        .contact-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: var(--space-3);
        }

        .contact-text {
            font-size: 0.9375rem;
            color: var(--gray-400);
            margin-bottom: var(--space-6);
        }

        .contact-methods {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-4);
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-4) var(--space-6);
            background: var(--gradient-glass);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--radius-md);
            color: var(--white);
            font-weight: 500;
            font-size: 0.9375rem;
            transition: all var(--duration-normal) var(--ease-out);
        }

        .contact-btn:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .contact-btn svg {
            width: 20px;
            height: 20px;
        }

        .contact-btn.primary {
            background: var(--gradient-primary);
            border: none;
            box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        }

        .contact-btn.primary:hover {
            box-shadow: 0 8px 25px rgba(249,115,22,0.4);
        }

        /* ==============================================
           🔝 SCROLL TO TOP
           ============================================== */
        .scroll-top {
            position: fixed;
            bottom: var(--space-6);
            right: var(--space-6);
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border: none;
            border-radius: var(--radius-full);
            color: var(--white);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all var(--duration-normal) var(--ease-out);
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
            box-shadow: var(--shadow-xl), var(--shadow-glow);
        }

        .scroll-top svg {
            width: 24px;
            height: 24px;
        }

        /* ==============================================
           🔒 PRIVACY FOOTER
           ============================================== */
        .terms-footer {
            text-align: center;
            padding: var(--space-8) 0;
            margin-top: -var(--space-8);
        }

        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-4) var(--space-6);
            background: var(--white);
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-lg);
            animation: fadeInUp 0.6s var(--ease-out) 0.5s both;
        }

        .footer-badge-icon {
            width: 40px;
            height: 40px;
            background: var(--success-light);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--success);
        }

        .footer-badge-icon svg {
            width: 20px;
            height: 20px;
        }

        .footer-badge-text {
            font-size: 0.9375rem;
            color: var(--gray-600);
        }

        .footer-badge-text strong {
            color: var(--gray-800);
        }

        /* ==============================================
           📱 MOBILE TABLE OF CONTENTS
           ============================================== */
        .mobile-toc {
            display: block;
            margin-bottom: var(--space-6);
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
            padding: var(--space-4) var(--space-5);
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-800);
            cursor: pointer;
            transition: all var(--duration-fast);
        }

        .mobile-toc-btn:hover {
            border-color: var(--primary-300);
        }

        .mobile-toc-btn svg {
            width: 20px;
            height: 20px;
            color: var(--gray-500);
            transition: transform var(--duration-fast);
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
            padding: var(--space-4);
            max-height: 300px;
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
            gap: var(--space-3);
            padding: var(--space-3);
            font-size: 0.875rem;
            color: var(--gray-600);
            transition: all var(--duration-fast);
        }

        .mobile-toc-link:hover {
            color: var(--primary-600);
            background: var(--primary-50);
        }

        .mobile-toc-link span {
            font-weight: 600;
            color: var(--primary-500);
            min-width: 24px;
        }

        /* ==============================================
           ♿ ACCESSIBILITY
           ============================================== */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        :focus-visible {
            outline: 3px solid var(--primary-400);
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
            white-space: nowrap;
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
         🦸 HERO SECTION
         ============================================== -->
    <section class="terms-hero">
        <!-- Background Pattern -->
        <div class="hero-pattern"></div>
        <div class="hero-grid"></div>
        
        <!-- Floating Shapes -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
        </div>

        <div class="dk-container">
            <div class="hero-content">
                <!-- Breadcrumb -->
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="/">Home</a>
                    <span class="breadcrumb-sep" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </span>
                    <span class="breadcrumb-current">Terms & Conditions</span>
                </nav>

                <!-- Icon -->
                <div class="hero-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="hero-title">Terms & <span>Conditions</span></h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">
                    Please read these terms carefully before using Find Business. By accessing or using our platform, you agree to be bound by these terms.
                </p>

                <!-- Last Updated -->
                <div class="last-updated">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Last Updated: January 15, 2025
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================================
         📄 MAIN CONTENT
         ============================================== -->
    <main class="terms-main">
        <div class="dk-container">
            <div class="terms-layout">

                <!-- ==============================================
                     📑 SIDEBAR NAVIGATION
                     ============================================== -->
                <aside class="terms-sidebar">
                    <div class="sidebar-card">
                        <h2 class="sidebar-title">Table of Contents</h2>
                        <nav>
                            <ul class="sidebar-nav" id="sidebarNav">
                                <li>
                                    <a href="#introduction" class="sidebar-link active">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                        </svg>
                                        <span class="sidebar-link-text">Introduction</span>
                                        <span class="sidebar-link-number">01</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#about" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="16" x2="12" y2="12"/>
                                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                                        </svg>
                                        <span class="sidebar-link-text">About Find Business</span>
                                        <span class="sidebar-link-number">02</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#eligibility" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="8.5" cy="7" r="4"/>
                                            <line x1="20" y1="8" x2="20" y2="14"/>
                                            <line x1="23" y1="11" x2="17" y2="11"/>
                                        </svg>
                                        <span class="sidebar-link-text">Eligibility</span>
                                        <span class="sidebar-link-number">03</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#listings" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        <span class="sidebar-link-text">Listings & Accuracy</span>
                                        <span class="sidebar-link-number">04</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#thirdparty" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="16 3 21 3 21 8"/>
                                            <line x1="4" y1="20" x2="21" y2="3"/>
                                            <polyline points="21 16 21 21 16 21"/>
                                            <line x1="15" y1="15" x2="21" y2="21"/>
                                            <line x1="4" y1="4" x2="9" y2="9"/>
                                        </svg>
                                        <span class="sidebar-link-text">Third-Party Data</span>
                                        <span class="sidebar-link-number">05</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#claiming" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                            <polyline points="9 12 11 14 15 10"/>
                                        </svg>
                                        <span class="sidebar-link-text">Claiming & Updates</span>
                                        <span class="sidebar-link-number">06</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#responsibilities" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                        <span class="sidebar-link-text">User Responsibilities</span>
                                        <span class="sidebar-link-number">07</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#reviews" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                        <span class="sidebar-link-text">Reviews & Ratings</span>
                                        <span class="sidebar-link-number">08</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#warranty" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                            <line x1="12" y1="9" x2="12" y2="13"/>
                                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                                        </svg>
                                        <span class="sidebar-link-text">No Warranty</span>
                                        <span class="sidebar-link-number">09</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#ip" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <path d="M14.31 8l5.74 9.94"/>
                                            <path d="M9.69 8h11.48"/>
                                            <path d="M7.38 12l5.74-9.94"/>
                                            <path d="M9.69 16L3.95 6.06"/>
                                            <path d="M14.31 16H2.83"/>
                                            <path d="M16.62 12l-5.74 9.94"/>
                                        </svg>
                                        <span class="sidebar-link-text">Intellectual Property</span>
                                        <span class="sidebar-link-number">10</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#links" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                        </svg>
                                        <span class="sidebar-link-text">Third-Party Links</span>
                                        <span class="sidebar-link-number">11</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#liability" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                        </svg>
                                        <span class="sidebar-link-text">Limitation of Liability</span>
                                        <span class="sidebar-link-number">12</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#termination" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="15" y1="9" x2="9" y2="15"/>
                                            <line x1="9" y1="9" x2="15" y2="15"/>
                                        </svg>
                                        <span class="sidebar-link-text">Termination</span>
                                        <span class="sidebar-link-number">13</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#changes" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        <span class="sidebar-link-text">Changes to Terms</span>
                                        <span class="sidebar-link-number">14</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#governing" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="10" r="3"/>
                                            <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
                                        </svg>
                                        <span class="sidebar-link-text">Governing Law</span>
                                        <span class="sidebar-link-number">15</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#contact" class="sidebar-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                        <span class="sidebar-link-text">Contact Us</span>
                                        <span class="sidebar-link-number">16</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <!-- Reading Progress -->
                        <div class="reading-progress">
                            <div class="progress-label">
                                <span>Reading Progress</span>
                                <span id="progressPercent">0%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="progressFill"></div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- ==============================================
                     📜 MAIN CONTENT
                     ============================================== -->
                <div class="terms-content">

                    <!-- Mobile Table of Contents -->
                    <div class="mobile-toc">
                        <button class="mobile-toc-btn" id="mobileTocBtn">
                            <span>📑 Table of Contents</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div class="mobile-toc-content" id="mobileTocContent">
                            <ul class="mobile-toc-list">
                                <li><a href="#introduction" class="mobile-toc-link"><span>01</span> Introduction</a></li>
                                <li><a href="#about" class="mobile-toc-link"><span>02</span> About Find Business</a></li>
                                <li><a href="#eligibility" class="mobile-toc-link"><span>03</span> Eligibility to Use</a></li>
                                <li><a href="#listings" class="mobile-toc-link"><span>04</span> Business Listings</a></li>
                                <li><a href="#thirdparty" class="mobile-toc-link"><span>05</span> Third-Party Data</a></li>
                                <li><a href="#claiming" class="mobile-toc-link"><span>06</span> Claiming & Updates</a></li>
                                <li><a href="#responsibilities" class="mobile-toc-link"><span>07</span> User Responsibilities</a></li>
                                <li><a href="#reviews" class="mobile-toc-link"><span>08</span> Reviews & Ratings</a></li>
                                <li><a href="#warranty" class="mobile-toc-link"><span>09</span> No Warranty</a></li>
                                <li><a href="#ip" class="mobile-toc-link"><span>10</span> Intellectual Property</a></li>
                                <li><a href="#links" class="mobile-toc-link"><span>11</span> Third-Party Links</a></li>
                                <li><a href="#liability" class="mobile-toc-link"><span>12</span> Limitation of Liability</a></li>
                                <li><a href="#termination" class="mobile-toc-link"><span>13</span> Termination</a></li>
                                <li><a href="#changes" class="mobile-toc-link"><span>14</span> Changes to Terms</a></li>
                                <li><a href="#governing" class="mobile-toc-link"><span>15</span> Governing Law</a></li>
                                <li><a href="#contact" class="mobile-toc-link"><span>16</span> Contact Information</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Terms Card -->
                    <div class="terms-card">
                        <!-- Card Header -->
                        <div class="terms-header">
                            <div class="terms-header-content">
                                <div class="terms-header-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                </div>
                                <div class="terms-header-info">
                                    <h2>Find Business Terms of Service</h2>
                                    <p>Legal agreement between you and Find Business</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="terms-body">

                            <!-- Section 1: Introduction -->
                            <section class="terms-section" id="introduction">
                                <div class="section-header">
                                    <div class="section-number">01</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Introduction</h3>
                                        <div class="section-meta">
                                            <span class="section-tag tag-important">Important</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Welcome to <strong>Find Business</strong> ("we," "us," or "our"). These Terms and Conditions ("Terms") govern your access to and use of our website, mobile applications, and all related services (collectively, the "Platform").
                                    </p>
                                    <p>
                                        By accessing or using Find Business, you acknowledge that you have read, understood, and agree to be bound by these Terms. If you do not agree with any part of these Terms, you must not use our Platform.
                                    </p>
                                    <div class="highlight-box">
                                        <p>
                                            <strong>Legal Disclaimer:</strong> These Terms constitute a legally binding agreement between you and Find Business. Your continued use of the Platform signifies your acceptance of these Terms and any modifications thereof.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 2: About Find Business -->
                            <section class="terms-section" id="about">
                                <div class="section-header">
                                    <div class="section-number">02</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">About Find Business</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Find Business is an <strong>online business directory and discovery platform</strong> designed to help users find and connect with local businesses across India. Our platform provides:
                                    </p>
                                    <ul class="terms-list">
                                        <li>Business listings with contact information, addresses, and operating hours</li>
                                        <li>User reviews and ratings for listed businesses</li>
                                        <li>Search and discovery features to find relevant services</li>
                                        <li>Business verification and claiming services</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="12" y1="16" x2="12" y2="12"/>
                                                <line x1="12" y1="8" x2="12.01" y2="8"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Important Note</p>
                                            <p class="info-card-text">
                                                Find Business is a directory platform only. We do not provide any products or services directly. Any transactions or interactions between users and listed businesses are conducted independently of Find Business.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 3: Eligibility -->
                            <section class="terms-section" id="eligibility">
                                <div class="section-header">
                                    <div class="section-number">03</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Eligibility to Use</h3>
                                        <div class="section-meta">
                                            <span class="section-tag tag-legal">Legal Requirement</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        To use Find Business, you must meet the following eligibility requirements:
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Age Requirement:</strong> You must be at least 18 years of age or the age of majority in your jurisdiction to use our Platform</li>
                                        <li><strong>Legal Capacity:</strong> You must have the legal capacity to enter into binding contracts</li>
                                        <li><strong>Accurate Information:</strong> You agree to provide truthful, accurate, and complete information when using our services</li>
                                        <li><strong>Lawful Use:</strong> You agree to use the Platform only for lawful purposes and in compliance with all applicable laws</li>
                                    </ul>
                                    <div class="highlight-box warning">
                                        <p>
                                            <strong>Warning:</strong> Providing false or misleading information may result in immediate termination of your access to Find Business and may subject you to legal action.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 4: Business Listings -->
                            <section class="terms-section" id="listings">
                                <div class="section-header">
                                    <div class="section-number">04</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Business Listings & Information Accuracy</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Business information displayed on Find Business may be sourced from various channels, including:
                                    </p>
                                    <ul class="terms-list">
                                        <li>Direct submissions by business owners</li>
                                        <li>Publicly available data and directories</li>
                                        <li>Third-party data providers and aggregators</li>
                                        <li>User contributions and suggestions</li>
                                    </ul>
                                    <p>
                                        While we strive to maintain accurate and up-to-date information, <strong>Find Business does not guarantee the accuracy, completeness, or reliability</strong> of any business listing. Information may be outdated, incomplete, or contain errors.
                                    </p>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                <line x1="12" y1="9" x2="12" y2="13"/>
                                                <line x1="12" y1="17" x2="12.01" y2="17"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Disclaimer</p>
                                            <p class="info-card-text">
                                                Users are advised to verify business information independently before making any decisions or transactions based on listings found on Find Business.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 5: Third-Party Data -->
                            <section class="terms-section" id="thirdparty">
                                <div class="section-header">
                                    <div class="section-number">05</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Third-Party Data & Aggregation</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Find Business may display publicly available business information aggregated from various sources. This includes but is not limited to business names, addresses, phone numbers, websites, and operating hours.
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Ownership:</strong> All business data, logos, trademarks, and intellectual property remain the sole property of their respective owners</li>
                                        <li><strong>Display Rights:</strong> Find Business displays this information for informational purposes to facilitate business discovery</li>
                                        <li><strong>Correction Rights:</strong> Business owners may request corrections or updates to their listing information</li>
                                        <li><strong>Removal Rights:</strong> Business owners may request removal of their listing by contacting us with proper verification</li>
                                    </ul>
                                </div>
                            </section>

                            <!-- Section 6: Claiming & Updates -->
                            <section class="terms-section" id="claiming">
                                <div class="section-header">
                                    <div class="section-number">06</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Claiming, Updating & Removal of Listings</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Business owners have the right to claim and manage their business listings on Find Business:
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Claim Your Business:</strong> Verified business owners can claim their listings to gain control over the displayed information</li>
                                        <li><strong>Update Information:</strong> Claimed business owners can update their contact details, hours, services, and other information</li>
                                        <li><strong>Respond to Reviews:</strong> Business owners may respond to user reviews on their claimed listings</li>
                                        <li><strong>Request Removal:</strong> Business owners may request complete removal of their listing from the Platform</li>
                                    </ul>
                                    <div class="highlight-box info">
                                        <p>
                                            <strong>Note:</strong> Find Business reserves the right to modify, update, or remove any business listing at its sole discretion, including for reasons of accuracy, legal compliance, or policy violations.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 7: User Responsibilities -->
                            <section class="terms-section" id="responsibilities">
                                <div class="section-header">
                                    <div class="section-number">07</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">User Responsibilities</h3>
                                        <div class="section-meta">
                                            <span class="section-tag tag-important">Must Read</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        By using Find Business, you agree to the following responsibilities and prohibited activities:
                                    </p>
                                    <p><strong>You agree NOT to:</strong></p>
                                    <ul class="terms-list">
                                        <li>Submit false, misleading, or fraudulent information</li>
                                        <li>Impersonate any person, business, or entity</li>
                                        <li>Post spam, advertisements, or promotional content in reviews</li>
                                        <li>Engage in data scraping, crawling, or automated data collection</li>
                                        <li>Attempt to hack, disrupt, or compromise the Platform's security</li>
                                        <li>Use the Platform for any illegal or unauthorized purpose</li>
                                        <li>Harass, abuse, or threaten other users or business owners</li>
                                        <li>Violate any applicable local, state, national, or international laws</li>
                                    </ul>
                                    <div class="highlight-box warning">
                                        <p>
                                            <strong>Violation Consequences:</strong> Violation of these terms may result in immediate account suspension, permanent ban, legal action, and reporting to appropriate authorities.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 8: Reviews & Ratings -->
                            <section class="terms-section" id="reviews">
                                <div class="section-header">
                                    <div class="section-number">08</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Reviews, Ratings & User Content</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Find Business allows users to submit reviews, ratings, and other content about businesses. By submitting content, you agree to the following:
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Genuine Experience:</strong> Reviews must be based on genuine, firsthand experiences with the business</li>
                                        <li><strong>Truthfulness:</strong> All content must be truthful, accurate, and not misleading</li>
                                        <li><strong>Ownership:</strong> You grant Find Business a non-exclusive, royalty-free license to use, display, and distribute your content</li>
                                        <li><strong>Compliance:</strong> Content must not violate any laws, infringe copyrights, or contain defamatory statements</li>
                                    </ul>
                                    <p>
                                        <strong>Content Moderation:</strong> Find Business reserves the right to remove or modify any user content that violates our policies, including but not limited to:
                                    </p>
                                    <ul class="terms-list">
                                        <li>Fake or fraudulent reviews</li>
                                        <li>Abusive, offensive, or discriminatory content</li>
                                        <li>Content containing personal attacks or threats</li>
                                        <li>Spam, advertisements, or irrelevant content</li>
                                        <li>Content that violates intellectual property rights</li>
                                    </ul>
                                </div>
                            </section>

                            <!-- Section 9: No Warranty -->
                            <section class="terms-section" id="warranty">
                                <div class="section-header">
                                    <div class="section-number">09</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">No Warranty or Guarantee</h3>
                                        <div class="section-meta">
                                            <span class="section-tag tag-legal">Legal</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Find Business provides the Platform on an <strong>"AS IS" and "AS AVAILABLE"</strong> basis without any warranties of any kind, either express or implied.
                                    </p>
                                    <ul class="terms-list">
                                        <li>We do not warrant that the Platform will be uninterrupted, error-free, or secure</li>
                                        <li>We do not guarantee the quality, safety, or legality of any listed business</li>
                                        <li>We are not responsible for the accuracy of business information or user reviews</li>
                                        <li>We do not endorse any business, product, or service listed on the Platform</li>
                                    </ul>
                                    <div class="highlight-box warning">
                                        <p>
                                            <strong>Dispute Disclaimer:</strong> Find Business is not responsible for any disputes, damages, losses, or issues arising from interactions between users and businesses found through our Platform. All transactions are conducted at your own risk.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 10: Intellectual Property -->
                            <section class="terms-section" id="ip">
                                <div class="section-header">
                                    <div class="section-number">10</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Intellectual Property Rights</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        The Find Business Platform, including its design, features, functionality, and content, is protected by intellectual property laws:
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Find Business Property:</strong> The Find Business name, logo, brand elements, website design, software, and original content are the exclusive property of Find Business</li>
                                        <li><strong>Third-Party Property:</strong> Business names, logos, trademarks, and other intellectual property displayed on the Platform belong to their respective owners</li>
                                        <li><strong>User Content:</strong> Users retain ownership of their original content but grant Find Business a license to use it on the Platform</li>
                                    </ul>
                                    <p>
                                        <strong>Prohibited Uses:</strong> You may not copy, reproduce, distribute, modify, or create derivative works from any part of the Platform without express written permission from Find Business.
                                    </p>
                                </div>
                            </section>

                                                       <!-- Section 11: Third-Party Links -->
                            <section class="terms-section" id="links">
                                <div class="section-header">
                                    <div class="section-number">11</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Third-Party Links</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        The Find Business Platform may contain links to third-party websites, applications, or services that are not owned or controlled by Find Business.
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>No Control:</strong> Find Business has no control over the content, privacy policies, or practices of any third-party websites</li>
                                        <li><strong>No Endorsement:</strong> The inclusion of any link does not imply endorsement or recommendation by Find Business</li>
                                        <li><strong>User Responsibility:</strong> You access third-party links entirely at your own risk</li>
                                        <li><strong>Independent Terms:</strong> Third-party websites have their own terms of service and privacy policies that you should review</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                                <polyline points="15 3 21 3 21 9"/>
                                                <line x1="10" y1="14" x2="21" y2="3"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">External Links Notice</p>
                                            <p class="info-card-text">
                                                We strongly recommend reviewing the terms and privacy policies of any third-party website before providing any personal information or engaging in any transactions.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 12: Limitation of Liability -->
                            <section class="terms-section" id="liability">
                                <div class="section-header">
                                    <div class="section-number">12</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Limitation of Liability</h3>
                                        <div class="section-meta">
                                            <span class="section-tag tag-legal">Legal</span>
                                            <span class="section-tag tag-important">Important</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        To the maximum extent permitted by applicable law, Find Business and its directors, officers, employees, agents, and affiliates shall not be liable for:
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Direct Damages:</strong> Any direct, indirect, incidental, special, consequential, or punitive damages</li>
                                        <li><strong>Loss of Data:</strong> Loss of profits, data, use, goodwill, or other intangible losses</li>
                                        <li><strong>Service Issues:</strong> Any interruption, suspension, or termination of the Platform</li>
                                        <li><strong>Third-Party Actions:</strong> Any conduct or content of any third party on the Platform</li>
                                        <li><strong>Business Disputes:</strong> Any disputes between users and businesses listed on Find Business</li>
                                        <li><strong>Unauthorized Access:</strong> Unauthorized access, use, or alteration of your data or content</li>
                                    </ul>
                                    <div class="highlight-box warning">
                                        <p>
                                            <strong>Use at Your Own Risk:</strong> You expressly understand and agree that your use of the Find Business Platform is at your sole risk. Find Business makes no representations or warranties about the suitability, reliability, or accuracy of the information contained on the Platform.
                                        </p>
                                    </div>
                                    <p>
                                        In jurisdictions where limitations of liability are not permitted, our liability shall be limited to the maximum extent permitted by law. In no event shall our total liability exceed ₹1,000 (Indian Rupees One Thousand) or the amount you paid to Find Business in the past 12 months, whichever is greater.
                                    </p>
                                </div>
                            </section>

                            <!-- Section 13: Termination -->
                            <section class="terms-section" id="termination">
                                <div class="section-header">
                                    <div class="section-number">13</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Termination of Access</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Find Business reserves the right to suspend, restrict, or terminate your access to the Platform at any time, with or without cause, and with or without notice, for any reason including but not limited to:
                                    </p>
                                    <ul class="terms-list">
                                        <li>Violation of these Terms and Conditions</li>
                                        <li>Engaging in fraudulent or illegal activities</li>
                                        <li>Providing false or misleading information</li>
                                        <li>Abusing or harassing other users or business owners</li>
                                        <li>Attempting to compromise the security of the Platform</li>
                                        <li>Any other conduct deemed inappropriate by Find Business</li>
                                    </ul>
                                    <p>
                                        <strong>Effect of Termination:</strong> Upon termination, your right to use the Platform will immediately cease. All provisions of these Terms that by their nature should survive termination shall survive, including ownership provisions, warranty disclaimers, and limitations of liability.
                                    </p>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="12" y1="8" x2="12" y2="12"/>
                                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Account Data</p>
                                            <p class="info-card-text">
                                                Upon termination, we may delete your account information and any content you have submitted. We are not obligated to retain or provide copies of your data after termination.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 14: Changes to Terms -->
                            <section class="terms-section" id="changes">
                                <div class="section-header">
                                    <div class="section-number">14</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Changes to Terms</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        Find Business reserves the right to modify, update, or replace these Terms and Conditions at any time at our sole discretion. Changes may be made for various reasons including:
                                    </p>
                                    <ul class="terms-list">
                                        <li>Changes in applicable laws or regulations</li>
                                        <li>Introduction of new features or services</li>
                                        <li>Security or operational improvements</li>
                                        <li>Clarification of existing terms</li>
                                        <li>Business or organizational changes</li>
                                    </ul>
                                    <p>
                                        <strong>Notification of Changes:</strong> We will make reasonable efforts to notify users of significant changes through:
                                    </p>
                                    <ul class="terms-list">
                                        <li>Posting a notice on our website</li>
                                        <li>Updating the "Last Updated" date at the top of this page</li>
                                        <li>Sending email notifications (for registered users)</li>
                                    </ul>
                                    <div class="highlight-box info">
                                        <p>
                                            <strong>Acceptance of Changes:</strong> Your continued use of the Find Business Platform after any changes to these Terms constitutes your acceptance of the revised Terms. We encourage you to review this page periodically for any updates.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 15: Governing Law -->
                            <section class="terms-section" id="governing">
                                <div class="section-header">
                                    <div class="section-number">15</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Governing Law & Jurisdiction</h3>
                                        <div class="section-meta">
                                            <span class="section-tag tag-legal">Legal</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        These Terms and Conditions shall be governed by and construed in accordance with the laws of <strong>India</strong>, without regard to its conflict of law provisions.
                                    </p>
                                    <ul class="terms-list">
                                        <li><strong>Jurisdiction:</strong> Any disputes arising from these Terms or your use of the Platform shall be subject to the exclusive jurisdiction of the courts located in New Delhi, India</li>
                                        <li><strong>Dispute Resolution:</strong> Before initiating any legal proceedings, parties agree to attempt to resolve disputes through good-faith negotiation</li>
                                        <li><strong>Arbitration:</strong> Certain disputes may be subject to binding arbitration in accordance with the Arbitration and Conciliation Act, 1996</li>
                                        <li><strong>Class Action Waiver:</strong> You agree to resolve any disputes on an individual basis and waive any right to participate in class action lawsuits</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="10" r="3"/>
                                                <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Applicable Laws</p>
                                            <p class="info-card-text">
                                                These Terms comply with the Information Technology Act, 2000, Consumer Protection Act, 2019, and other applicable Indian laws and regulations.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 16: Contact Information -->
                            <section class="terms-section" id="contact">
                                <div class="section-header">
                                    <div class="section-number">16</div>
                                    <div class="section-title-wrap">
                                        <h3 class="section-title">Contact Information</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>
                                        If you have any questions, concerns, or feedback regarding these Terms and Conditions or any aspect of the Find Business Platform, please contact us through the following channels:
                                    </p>

                                    <!-- Contact Card -->
                                    <div class="contact-card">
                                        <div class="contact-card-content">
                                            <h4 class="contact-title">Get in Touch with Find Business</h4>
                                            <p class="contact-text">
                                                Our support team is available Monday through Saturday, 9:00 AM to 6:00 PM IST. We typically respond within 24-48 business hours.
                                            </p>
                                            <div class="contact-methods">
                                                <a href="mailto:support@find-business.com" class="contact-btn primary">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                    </svg>
                                                    support@find-business.com
                                                </a>
                                                <a href="mailto:legal@find-business.com" class="contact-btn">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                        <polyline points="14 2 14 8 20 8"/>
                                                    </svg>
                                                    legal@find-business.com
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-card" style="margin-top: var(--space-6);">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Registered Office</p>
                                            <p class="info-card-text">
                                                Find Business Technologies Pvt. Ltd.<br>
                                                123, Business Tower, Sector 62<br>
                                                Noida, Uttar Pradesh 201301<br>
                                                India
                                            </p>
                                        </div>
                                    </div>

                                    <p style="margin-top: var(--space-6); font-size: 0.875rem; color: var(--gray-500);">
                                        For legal notices and formal communications, please send correspondence to our registered office address or email <a href="mailto:legal@find-business.com" style="color: var(--primary-500); text-decoration: underline;">legal@find-business.com</a>.
                                    </p>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ==============================================
         🔒 PRIVACY FOOTER
         ============================================== -->
    <section class="terms-footer">
        <div class="dk-container">
            <div class="footer-badge">
                <div class="footer-badge-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <polyline points="9 12 11 14 15 10"/>
                    </svg>
                </div>
                <p class="footer-badge-text">
                    <strong>Your trust matters.</strong> These terms protect both you and Find Business.
                </p>
            </div>
        </div>
    </section>
    <?php include 'footer.php';?>

    <!-- ==============================================
         🔝 SCROLL TO TOP BUTTON
         ============================================== -->
    <button class="scroll-top" id="scrollTopBtn" aria-label="Scroll to top">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m18 15-6-6-6 6"/>
        </svg>
    </button>

    <!-- ==============================================
         📜 JAVASCRIPT
         ============================================== -->
    <script>
        // ==============================================
// 🚀 FIND BUSINESS TERMS & CONDITIONS - JAVASCRIPT
// ==============================================

(function() {
    'use strict';

    // ==============================================
    // DOM ELEMENTS
    // ==============================================
    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => document.querySelectorAll(selector);

    const scrollTopBtn = $('#scrollTopBtn');
    const progressFill = $('#progressFill');
    const progressPercent = $('#progressPercent');
    const mobileTocBtn = $('#mobileTocBtn');
    const mobileTocContent = $('#mobileTocContent');
    const sections = $$('.terms-section');
    const sidebarLinks = $$('.sidebar-link');

    // ==============================================
    // SCROLL TO TOP
    // ==============================================
    function handleScroll() {
        const scrollY = window.scrollY;

        // Show/hide scroll button
        if (scrollTopBtn) {
            scrollTopBtn.classList.toggle('visible', scrollY > 500);
        }

        // Update progress
        updateProgress();

        // Update active link
        updateActiveLink();
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ==============================================
    // READING PROGRESS
    // ==============================================
    function updateProgress() {
        const winHeight = window.innerHeight;
        const docHeight = document.documentElement.scrollHeight - winHeight;
        const scrolled = window.scrollY;
        const progress = Math.min((scrolled / docHeight) * 100, 100);

        if (progressFill) progressFill.style.width = `${progress}%`;
        if (progressPercent) progressPercent.textContent = `${Math.round(progress)}%`;
    }

    // ==============================================
    // ACTIVE SIDEBAR LINK
    // ==============================================
    function updateActiveLink() {
        let current = '';

        sections.forEach(section => {
            const top = section.offsetTop - 150;
            if (window.scrollY >= top) {
                current = section.id;
            }
        });

        sidebarLinks.forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === `#${current}`);
        });
    }

    // ==============================================
    // SMOOTH SCROLL
    // ==============================================
    function smoothScroll(e) {
        const href = this.getAttribute('href');
        if (!href.startsWith('#')) return;

        e.preventDefault();
        const target = $(href);

        if (target) {
            window.scrollTo({
                top: target.offsetTop - 100,
                behavior: 'smooth'
            });

            // Close mobile TOC
            if (mobileTocContent?.classList.contains('visible')) {
                mobileTocContent.classList.remove('visible');
                mobileTocBtn?.classList.remove('active');
            }
        }
    }

    // ==============================================
    // MOBILE TOC TOGGLE
    // ==============================================
    function toggleMobileToc() {
        mobileTocBtn?.classList.toggle('active');
        mobileTocContent?.classList.toggle('visible');
    }

    // ==============================================
    // SECTION ANIMATIONS
    // ==============================================
    function initAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1, rootMargin: '-50px' });

        sections.forEach((section, i) => {
            section.style.cssText = `
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.5s ease ${i * 0.05}s, transform 0.5s ease ${i * 0.05}s;
            `;
            observer.observe(section);
        });
    }

    // ==============================================
    // KEYBOARD SHORTCUTS
    // ==============================================
    function handleKeyboard(e) {
        const tag = document.activeElement.tagName;
        if (tag === 'INPUT' || tag === 'TEXTAREA') return;

        switch(e.key.toLowerCase()) {
            case 't':
                scrollToTop();
                break;
            case 'escape':
                if (mobileTocContent?.classList.contains('visible')) {
                    toggleMobileToc();
                }
                break;
        }
    }

    // ==============================================
    // PRINT SUPPORT
    // ==============================================
    function handlePrint() {
        sections.forEach(s => {
            s.style.opacity = '1';
            s.style.transform = 'none';
        });
    }

    // ==============================================
    // EVENT LISTENERS
    // ==============================================
    function init() {
        // Scroll events (throttled)
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Click events
        scrollTopBtn?.addEventListener('click', scrollToTop);
        mobileTocBtn?.addEventListener('click', toggleMobileToc);

        // Smooth scroll for all anchor links
        $$('a[href^="#"]').forEach(link => {
            link.addEventListener('click', smoothScroll);
        });

        // Keyboard
        document.addEventListener('keydown', handleKeyboard);

        // Print
        window.addEventListener('beforeprint', handlePrint);

        // Initialize
        updateProgress();
        updateActiveLink();
        initAnimations();
    }

    // ==============================================
    // START
    // ==============================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
    </script>

</body>
</html>
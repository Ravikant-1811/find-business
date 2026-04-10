<?php include_once 'app-detect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Privacy Policy for Find Business - Learn how we collect, use, and protect your personal information on India's trusted business directory.">
    <meta name="keywords" content="Find Business privacy policy, data protection, business directory privacy, user data India">
    <meta name="robots" content="index, follow">
    
    <title>Privacy Policy – Find Business | India's Trusted Business Directory </title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ==============================================
           CSS VARIABLES
           ============================================== */
        :root {
            /* Brand Colors */
            --primary: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #ffedd5;
            --primary-50: #fff7ed;
            --primary-100: #ffedd5;
            
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
            
            /* Typography */
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 40px rgba(249, 115, 22, 0.2);
            
            /* Border Radius */
            --radius-sm: 6px;
            --radius-md: 10px;
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
            scroll-padding-top: 80px;
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
            50% { transform: translateY(-15px) rotate(3deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 30px rgba(249, 115, 22, 0.3); }
            50% { box-shadow: 0 0 50px rgba(249, 115, 22, 0.5); }
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
           🌑 DARK HERO SECTION
           ============================================== */
        .privacy-hero {
            position: relative;
            background: linear-gradient(135deg, var(--dark-900) 0%, var(--dark-800) 50%, var(--dark-700) 100%);
            padding: 80px 0 70px;
            overflow: hidden;
            min-height: 360px;
            display: flex;
            align-items: center;
        }

        /* Animated Background Elements */
        .privacy-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        .privacy-hero::after {
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
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        /* Floating Decorative Shapes */
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
            top: 15%;
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
            top: 75%;
            right: 8%;
            animation: float 8s ease-in-out infinite 2s;
        }

        .shape-5 {
            width: 6px;
            height: 6px;
            background: var(--primary-light);
            top: 45%;
            right: 20%;
            animation: float 4s ease-in-out infinite 1.5s;
        }

        .shape-6 {
            width: 16px;
            height: 16px;
            background: rgba(249, 115, 22, 0.3);
            top: 35%;
            left: 15%;
            animation: float 9s ease-in-out infinite 0.8s;
        }

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
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-glow);
            animation: fadeInUp 0.6s ease 0.1s forwards, glow 3s ease-in-out infinite;
            opacity: 0;
        }

        .hero-icon svg {
            width: 40px;
            height: 40px;
            color: var(--white);
        }

        /* Hero Title */
        .hero-title {
            font-size: clamp(32px, 5vw, 48px);
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
            max-width: 550px;
            margin: 0 auto;
            line-height: 1.7;
            animation: fadeInUp 0.6s ease 0.3s forwards;
            opacity: 0;
        }

        /* Last Updated Badge */
        .last-updated {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 28px;
            padding: 10px 20px;
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

        /* Hero Stats (Optional) */
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
            .privacy-hero {
                padding: 60px 0 50px;
                min-height: auto;
            }

            .hero-icon {
                width: 68px;
                height: 68px;
            }

            .hero-icon svg {
                width: 34px;
                height: 34px;
            }

            .hero-stats {
                gap: 32px;
            }

            .hero-stat-value {
                font-size: 24px;
            }
        }

        /* ==============================================
           MAIN CONTENT
           ============================================== */
        .privacy-main {
            padding: 60px 0 80px;
            background: var(--white);
        }

        .privacy-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }

        @media (min-width: 1024px) {
            .privacy-layout {
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

        .toc-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--gray-100);
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
        .privacy-content {
            max-width: 800px;
        }

        .content-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .content-header {
            background: linear-gradient(135deg, var(--dark-800) 0%, var(--dark-900) 100%);
            padding: 32px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .content-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 300px;
            height: 300px;
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
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
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

        .content-body {
            padding: 40px;
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
            padding: 14px 0 14px 44px;
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
            font-size: 12px;
            font-weight: 700;
            color: var(--success);
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
            padding: 20px;
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
            width: 36px;
            height: 36px;
        }

        .contact-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 8px;
        }

        .contact-text {
            font-size: 16px;
            color: var(--gray-400);
            margin-bottom: 28px;
            max-width: 450px;
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
            gap: 10px;
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
            box-shadow: 0 8px 30px rgba(249, 115, 22, 0.45);
            color: var(--white);
        }

        .contact-btn svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 640px) {
            .contact-section {
                padding: 32px 24px;
            }

            .contact-email {
                font-size: 16px;
                flex-direction: column;
                gap: 8px;
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
            margin-bottom: 32px;
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
            padding: 12px 8px;
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
  <?php include 'header.php';?>
    <!-- ==============================================
         🌑 DARK HERO SECTION
         ============================================== -->
    <section class="privacy-hero">
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
                    <span class="breadcrumb-current">Privacy Policy</span>
                </nav>

                <!-- Hero Icon -->
                <div class="hero-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="hero-title">Privacy <span>Policy</span></h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">
                    Your privacy matters to us at Find Business. Learn how we collect, use, and protect your personal information. note, This privacy policy also applies to the Find Business mobile application.
                </p>

                <!-- Last Updated -->
                <div class="last-updated">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Last Updated: January 15, 2026
                </div>

                <!-- Optional: Hero Stats -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">100%</div>
                        <div class="hero-stat-label">Transparent</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">Zero</div>
                        <div class="hero-stat-label">Data Selling</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">SSL</div>
                        <div class="hero-stat-label">Encrypted</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================================
         MAIN CONTENT
         ============================================== -->
    <main class="privacy-main">
        <div class="container">
            <div class="privacy-layout">

                <!-- ==============================================
                     TABLE OF CONTENTS (SIDEBAR)
                     ============================================== -->
                <aside class="toc-sidebar">
                    <div class="toc-card">
                        <h2 class="toc-title">Table of Contents</h2>
                        <nav>
                            <ul class="toc-list" id="tocList">
                                <li><a href="#introduction" class="toc-link active"><span class="toc-number">01</span><span class="toc-text">Introduction</span></a></li>
                                <li><a href="#info-collect" class="toc-link"><span class="toc-number">02</span><span class="toc-text">Information We Collect</span></a></li>
                                <li><a href="#business-display" class="toc-link"><span class="toc-number">03</span><span class="toc-text">Business Info Display</span></a></li>
                                <li><a href="#how-we-use" class="toc-link"><span class="toc-number">04</span><span class="toc-text">How We Use Info</span></a></li>
                                <li><a href="#cookies" class="toc-link"><span class="toc-number">05</span><span class="toc-text">Cookies Policy</span></a></li>
                                <li><a href="#third-party-data" class="toc-link"><span class="toc-number">06</span><span class="toc-text">Third-Party Data</span></a></li>
                                <li><a href="#data-sharing" class="toc-link"><span class="toc-number">07</span><span class="toc-text">Data Sharing</span></a></li>
                                <li><a href="#data-security" class="toc-link"><span class="toc-number">08</span><span class="toc-text">Data Security</span></a></li>
                                <li><a href="#user-responsibility" class="toc-link"><span class="toc-number">09</span><span class="toc-text">User Responsibility</span></a></li>
                                <li><a href="#third-party-links" class="toc-link"><span class="toc-number">10</span><span class="toc-text">Third-Party Links</span></a></li>
                                <li><a href="#children-privacy" class="toc-link"><span class="toc-number">11</span><span class="toc-text">Children's Privacy</span></a></li>
                                <li><a href="#policy-updates" class="toc-link"><span class="toc-number">12</span><span class="toc-text">Policy Updates</span></a></li>
                                <li><a href="#contact" class="toc-link"><span class="toc-number">13</span><span class="toc-text">Contact Us</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <!-- ==============================================
                     PRIVACY CONTENT
                     ============================================== -->
                <div class="privacy-content">

                    <!-- Mobile TOC -->
                    <div class="mobile-toc">
                        <button class="mobile-toc-btn" id="mobileTocBtn" aria-expanded="false">
                            <span>📑 Table of Contents</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="mobile-toc-content" id="mobileTocContent">
                            <ul class="mobile-toc-list">
                                <li><a href="#introduction" class="mobile-toc-link"><span>01</span> Introduction</a></li>
                                <li><a href="#info-collect" class="mobile-toc-link"><span>02</span> Information We Collect</a></li>
                                <li><a href="#business-display" class="mobile-toc-link"><span>03</span> Business Information Display</a></li>
                                <li><a href="#how-we-use" class="mobile-toc-link"><span>04</span> How We Use Information</a></li>
                                <li><a href="#cookies" class="mobile-toc-link"><span>05</span> Cookies Policy</a></li>
                                <li><a href="#third-party-data" class="mobile-toc-link"><span>06</span> Third-Party & Public Data</a></li>
                                <li><a href="#data-sharing" class="mobile-toc-link"><span>07</span> Data Sharing Policy</a></li>
                                <li><a href="#data-security" class="mobile-toc-link"><span>08</span> Data Security</a></li>
                                <li><a href="#user-responsibility" class="mobile-toc-link"><span>09</span> User Responsibility</a></li>
                                <li><a href="#third-party-links" class="mobile-toc-link"><span>10</span> Third-Party Links</a></li>
                                <li><a href="#children-privacy" class="mobile-toc-link"><span>11</span> Children's Privacy</a></li>
                                <li><a href="#policy-updates" class="mobile-toc-link"><span>12</span> Policy Updates</a></li>
                                <li><a href="#contact" class="mobile-toc-link"><span>13</span> Contact Information</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Content Card -->
                    <div class="content-card">
                        <div class="content-header">
                            <div class="content-header-inner">
                                <div class="content-header-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                </div>
                                <div class="content-header-text">
                                    <h2>Find Business Privacy Policy</h2>
                                    <p>How we protect and handle your information</p>
                                </div>
                            </div>
                        </div>

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
                                    <p>Welcome to <strong>Find Business</strong>. We are committed to protecting your privacy and ensuring that your personal information is handled responsibly and transparently.</p>
                                    <p>This Privacy Policy explains how we collect, use, share, and protect your information when you use our website and services. By using Find Business, you agree to the practices described in this policy.</p>
                                    <div class="highlight-box success">
                                        <p><strong>Our Promise:</strong> We believe in transparency and will never sell your personal data to third parties. Your trust is important to us.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 2: Information We Collect -->
                            <section class="policy-section" id="info-collect">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                            <line x1="16" y1="13" x2="8" y2="13"/>
                                            <line x1="16" y1="17" x2="8" y2="17"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 02</span>
                                        <h3 class="section-title">Information We Collect</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>When you use Find Business, we may collect the following types of information:</p>
                                    <p><strong>Personal Information (provided by you):</strong></p>
                                    <ul class="info-list">
                                        <li>Full name</li>
                                        <li>Email address</li>
                                        <li>Phone number (optional)</li>
                                        <li>Business listing details (name, address, category)</li>
                                        <li>Account login credentials</li>
                                    </ul>
                                    <p><strong>Technical Information (collected automatically):</strong></p>
                                    <ul class="info-list">
                                        <li>IP address</li>
                                        <li>Browser type and version</li>
                                        <li>Device information</li>
                                        <li>Pages visited and time spent</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Why We Collect This</p>
                                            <p class="info-card-text">This information helps us provide better services, improve user experience, and ensure the security of our platform.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 3: Business Information Display -->
                            <section class="policy-section" id="business-display">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 03</span>
                                        <h3 class="section-title">Business Information Display</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>Find Business is a business directory platform. When you submit a business listing, please understand that:</p>
                                    <ul class="info-list">
                                        <li>Business listings are <strong>publicly visible</strong> to all users</li>
                                        <li>Information may be indexed by search engines</li>
                                        <li>Contact details are displayed for customer contact</li>
                                        <li>Business owners can update or remove listings anytime</li>
                                    </ul>
                                    <div class="highlight-box info">
                                        <p><strong>Note:</strong> Only submit information you're comfortable making public. Do not include sensitive personal details in your business listing.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 4: How We Use Information -->
                            <section class="policy-section" id="how-we-use">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="3"/>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 04</span>
                                        <h3 class="section-title">How We Use Your Information</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We use the collected information for the following purposes:</p>
                                    <ul class="info-list">
                                        <li><strong>Display business listings</strong> — Show your business to potential customers</li>
                                        <li><strong>Improve our services</strong> — Enhance features and user experience</li>
                                        <li><strong>Respond to queries</strong> — Answer your questions and support requests</li>
                                        <li><strong>Prevent fraud</strong> — Detect and prevent misuse of the platform</li>
                                        <li><strong>Analytics</strong> — Understand usage patterns to improve our platform</li>
                                    </ul>
                                </div>
                            </section>

                            <!-- Section 5: Cookies Policy -->
                            <section class="policy-section" id="cookies">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                                            <line x1="9" y1="9" x2="9.01" y2="9"/>
                                            <line x1="15" y1="9" x2="15.01" y2="9"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 05</span>
                                        <h3 class="section-title">Cookies Policy</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p><strong>What are cookies?</strong> Cookies are small text files stored on your device when you visit a website. They help us remember your preferences.</p>
                                    <p><strong>Why Find Business uses cookies:</strong></p>
                                    <ul class="info-list">
                                        <li>Remember your login session</li>
                                        <li>Store your preferences (language, location)</li>
                                        <li>Analyze website traffic and usage patterns</li>
                                        <li>Improve website performance</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/></svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Your Control</p>
                                            <p class="info-card-text">You can control cookies through your browser settings. However, disabling cookies may affect some website features.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 6: Third-Party & Public Data -->
                            <section class="policy-section" id="third-party-data">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="16 3 21 3 21 8"/>
                                            <line x1="4" y1="20" x2="21" y2="3"/>
                                            <polyline points="21 16 21 21 16 21"/>
                                            <line x1="15" y1="15" x2="21" y2="21"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 06</span>
                                        <h3 class="section-title">Third-Party & Public Data</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>Find Business may display publicly available business information sourced from:</p>
                                    <ul class="info-list">
                                        <li>Government business registries</li>
                                        <li>Publicly available directories</li>
                                        <li>Business websites and social media</li>
                                        <li>User submissions and contributions</li>
                                    </ul>
                                    <p><strong>Our Commitment:</strong></p>
                                    <ul class="info-list">
                                        <li>We do not scrape or collect private personal data</li>
                                        <li>We respect copyright and intellectual property laws</li>
                                        <li>Business owners can request corrections or removal</li>
                                    </ul>
                                </div>
                            </section>

                            <!-- Section 7: Data Sharing Policy -->
                            <section class="policy-section" id="data-sharing">
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
                                        <span class="section-number">Section 07</span>
                                        <h3 class="section-title">Data Sharing Policy</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p><strong>We do NOT sell or rent your personal data to anyone.</strong></p>
                                    <p>We may share your information only in the following circumstances:</p>
                                    <ul class="info-list">
                                        <li><strong>Legal obligations</strong> — When required by law or government authorities</li>
                                        <li><strong>Service providers</strong> — Trusted partners who help us operate the platform</li>
                                        <li><strong>Business transfers</strong> — In case of merger, acquisition, or sale</li>
                                        <li><strong>Your consent</strong> — When you explicitly authorize us</li>
                                    </ul>
                                    <div class="highlight-box">
                                        <p>All service providers are required to maintain confidentiality and protect your data according to our standards.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 8: Data Security -->
                            <section class="policy-section" id="data-security">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 08</span>
                                        <h3 class="section-title">Data Security</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We take reasonable measures to protect your information:</p>
                                    <ul class="info-list">
                                        <li>Secure HTTPS encryption for data transmission</li>
                                        <li>Regular security audits and updates</li>
                                        <li>Access controls and authentication systems</li>
                                        <li>Secure data storage practices</li>
                                    </ul>
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        </div>
                                        <div class="info-card-content">
                                            <p class="info-card-title">Important Disclaimer</p>
                                            <p class="info-card-text">While we implement reasonable safeguards, no system is 100% secure. We cannot guarantee absolute security of data transmitted over the internet.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 9: User Responsibility -->
                            <section class="policy-section" id="user-responsibility">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 09</span>
                                        <h3 class="section-title">User Responsibility Disclaimer</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p><strong>Find Business is a business directory platform.</strong> We provide information to help users discover local businesses.</p>
                                    <ul class="info-list">
                                        <li>We do not endorse or guarantee any listed business</li>
                                        <li>Users must verify business details independently</li>
                                        <li>We are not responsible for transactions between users and businesses</li>
                                        <li>Reviews and ratings are user-generated</li>
                                    </ul>
                                    <div class="highlight-box info">
                                        <p>Always do your own due diligence before engaging with any business.</p>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 10: Third-Party Links -->
                            <section class="policy-section" id="third-party-links">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                            <polyline points="15 3 21 3 21 9"/>
                                            <line x1="10" y1="14" x2="21" y2="3"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 10</span>
                                        <h3 class="section-title">Third-Party Links</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>Our website may contain links to third-party websites.</p>
                                    <ul class="info-list">
                                        <li>We are not responsible for external website content</li>
                                        <li>Third-party sites have their own privacy policies</li>
                                        <li>We do not control or endorse external websites</li>
                                        <li>Clicking external links is at your own risk</li>
                                    </ul>
                                </div>
                            </section>

                            <!-- Section 11: Children's Privacy -->
                            <section class="policy-section" id="children-privacy">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 11</span>
                                        <h3 class="section-title">Children's Privacy</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>Find Business is <strong>not intended for use by individuals under 18 years of age</strong>.</p>
                                    <p>We do not knowingly collect personal information from children. If you are a parent or guardian and believe your child has provided us with personal information, please contact us at <a href="mailto:support@find-business.com">support@find-business.com</a>.</p>
                                </div>
                            </section>

                            <!-- Section 12: Policy Updates -->
                            <section class="policy-section" id="policy-updates">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 12</span>
                                        <h3 class="section-title">Policy Updates</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>We may update this Privacy Policy from time to time.</p>
                                    <ul class="info-list">
                                        <li>The "Last Updated" date at the top will be revised</li>
                                        <li>Significant changes may be notified via email or website notice</li>
                                        <li>Continued use of Find Business after changes constitutes acceptance</li>
                                    </ul>
                                    <p>We encourage you to review this policy periodically.</p>
                                </div>
                            </section>

                            <!-- Section 13: Contact Information -->
                            <section class="policy-section" id="contact">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                    </div>
                                    <div class="section-title-wrap">
                                        <span class="section-number">Section 13</span>
                                        <h3 class="section-title">Contact Information</h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <p>If you have any questions about this Privacy Policy or how we handle your data, please contact us:</p>

                                    <!-- Contact Card -->
                                    <div class="contact-section">
                                        <div class="contact-content">
                                            <div class="contact-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                </svg>
                                            </div>
                                            <h4 class="contact-title">Get in Touch</h4>
                                            <p class="contact-text">Our team is here to help with any privacy-related questions or concerns.</p>
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
         TRUST FOOTER
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
                    <strong>Your privacy is protected.</strong> We're committed to keeping your data safe.
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

    <?php include 'footer.php';?>

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

            const scrollTopBtn = $('#scrollTopBtn');
            const tocLinks = $$('.toc-link');
            const sections = $$('.policy-section');
            const mobileTocBtn = $('#mobileTocBtn');
            const mobileTocContent = $('#mobileTocContent');
            const mobileLinks = $$('.mobile-toc-link');

            // ==============================================
            // SCROLL HANDLING
            // ==============================================
            let ticking = false;

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

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        handleScroll();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

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
                sections.forEach((section, index) => {
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
                handleScroll();
                updateActiveTocLink();
                animateSections();

                // Trigger initial animation for first few sections
                setTimeout(() => {
                    sections.forEach((section, index) => {
                        if (index < 2) {
                            section.classList.add('visible');
                        }
                    });
                }, 300);
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
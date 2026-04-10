<?php $currentPage = 'app'; ?>
<?php include_once 'app-detect.php'; ?>

<?php
session_start();
$is_app = isset($_GET['app']) || (isset($isApp) && $isApp);

$pageTitle = "Find Business App - Find & Call Local Businesses Instantly";
$pageDesc = "Download Find Business App to discover nearby shops, services, hospitals, hotels, and professionals. One-tap calling, verified listings, and local offers.";
$playStoreUrl = "https://play.google.com/store/apps/details?id=com.find-business.app";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDesc ?>">
    <link rel="canonical" href="https://find-business.com/app">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= $pageTitle ?>">
    <meta property="og:description" content="<?= $pageDesc ?>">
    <meta property="og:image" content="https://find-business.com/assets/app/og-image.png">
    <meta property="og:type" content="website">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MobileApplication",
        "name": "Find Business",
        "operatingSystem": "Android",
        "applicationCategory": "BusinessApplication",
        "offers": {"@type": "Offer", "price": "0"},
        "aggregateRating": {"@type": "AggregateRating", "ratingValue": "4.8", "ratingCount": "1200"}
    }
    </script>
    
    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #E85A2A;
            --dark: #1a1a1a;
            --gray: #666;
            --light: #f8f9fa;
            --white: #fff;
            --green: #10B981;
        }
        
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:var(--white);color:#333;line-height:1.7;overflow-x:hidden}
        a{text-decoration:none;color:inherit}
        <?php if($is_app): ?>.hdr,.ftr,header,footer{display:none!important}<?php endif; ?>
        
        .container{max-width:1200px;margin:0 auto;padding:0 20px}
        
        /* ==========================================
           HERO SECTION
           ========================================== */
        .hero{
            background:linear-gradient(135deg,#0a0a0a 0%,#1a1a1a 40%,#2a2a2a 100%);
            min-height:100vh;
            display:flex;
            align-items:center;
            position:relative;
            overflow:hidden;
            padding:100px 0 60px;
        }
        
        /* Decorative orbs */
        .hero::before{
            content:'';
            position:absolute;
            top:-200px;
            right:-150px;
            width:600px;
            height:600px;
            background:radial-gradient(circle,rgba(255,107,53,0.15),transparent 70%);
            border-radius:50%;
            animation:float 15s ease-in-out infinite;
        }
        .hero::after{
            content:'';
            position:absolute;
            bottom:-100px;
            left:-100px;
            width:400px;
            height:400px;
            background:radial-gradient(circle,rgba(255,255,255,0.03),transparent 70%);
            border-radius:50%;
        }
        
        @keyframes float{
            0%,100%{transform:translate(0,0)}
            50%{transform:translate(-30px,30px)}
        }
        
        .hero-content{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:60px;
            align-items:center;
            position:relative;
            z-index:2;
        }
        
        .hero-left{max-width:550px}
        
        .hero-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:rgba(255,107,53,0.15);
            border:1px solid rgba(255,107,53,0.3);
            padding:10px 20px;
            border-radius:50px;
            color:var(--primary);
            font-size:13px;
            font-weight:600;
            margin-bottom:25px;
        }
        .hero-badge i{font-size:16px}
        
        .hero h1{
            font-size:clamp(32px,5vw,52px);
            font-weight:800;
            color:#fff;
            line-height:1.15;
            margin-bottom:20px;
        }
        .hero h1 span{color:var(--primary)}
        
        .hero-text{
            font-size:17px;
            color:rgba(255,255,255,0.7);
            margin-bottom:35px;
            line-height:1.8;
        }
        
        .hero-buttons{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
            margin-bottom:30px;
        }
        
        .btn-download{
            display:inline-flex;
            align-items:center;
            gap:12px;
            padding:16px 28px;
            border-radius:14px;
            font-size:15px;
            font-weight:600;
            transition:all 0.3s;
        }
        .btn-download i{font-size:24px}
        
        .btn-playstore{
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            color:#fff;
            box-shadow:0 8px 25px rgba(255,107,53,0.35);
        }
        .btn-playstore:hover{
            transform:translateY(-3px);
            box-shadow:0 12px 35px rgba(255,107,53,0.45);
        }
        
        .btn-appstore{
            background:rgba(255,255,255,0.1);
            color:#fff;
            border:1px solid rgba(255,255,255,0.2);
        }
        .btn-appstore:hover{background:rgba(255,255,255,0.15)}
        
        .hero-stats{
            display:flex;
            gap:30px;
            padding-top:20px;
            border-top:1px solid rgba(255,255,255,0.1);
        }
        .stat{text-align:center}
        .stat-num{font-size:28px;font-weight:800;color:var(--primary)}
        .stat-text{font-size:12px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px}
        
        /* Phone Mockup */
        .hero-right{
            display:flex;
            justify-content:center;
            position:relative;
        }
        
        .phone-mockup{
            position:relative;
            width:280px;
        }
        .phone-frame{
            width:100%;
            filter:drop-shadow(0 30px 60px rgba(0,0,0,0.5));
            animation:phoneFloat 6s ease-in-out infinite;
        }
        @keyframes phoneFloat{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-15px)}
        }
        
        .phone-glow{
            position:absolute;
            bottom:-50px;
            left:50%;
            transform:translateX(-50%);
            width:200px;
            height:100px;
            background:radial-gradient(ellipse,rgba(255,107,53,0.3),transparent 70%);
            filter:blur(20px);
        }
        
        /* App icon floating */
        .app-icon-float{
            position:absolute;
            top:-30px;
            left:-40px;
            width:80px;
            height:80px;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            border-radius:20px;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 15px 40px rgba(255,107,53,0.4);
            animation:iconFloat 4s ease-in-out infinite;
        }
        .app-icon-float img{width:50px;height:50px}
        @keyframes iconFloat{
            0%,100%{transform:translateY(0) rotate(-5deg)}
            50%{transform:translateY(-10px) rotate(5deg)}
        }
        
        /* ==========================================
           ABOUT SECTION
           ========================================== */
        .about{
            padding:100px 0;
            background:var(--light);
        }
        
        .section-header{
            text-align:center;
            max-width:700px;
            margin:0 auto 60px;
        }
        .section-tag{
            display:inline-block;
            background:rgba(255,107,53,0.1);
            color:var(--primary);
            padding:8px 20px;
            border-radius:50px;
            font-size:13px;
            font-weight:600;
            margin-bottom:15px;
        }
        .section-title{
            font-size:clamp(28px,4vw,40px);
            font-weight:800;
            color:var(--dark);
            margin-bottom:15px;
        }
        .section-subtitle{
            font-size:16px;
            color:var(--gray);
            line-height:1.8;
        }
        
        .about-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
            gap:25px;
        }
        
        .about-card{
            background:var(--white);
            padding:30px;
            border-radius:20px;
            box-shadow:0 5px 25px rgba(0,0,0,0.06);
            transition:all 0.3s;
            display:flex;
            align-items:flex-start;
            gap:20px;
        }
        .about-card:hover{
            transform:translateY(-5px);
            box-shadow:0 15px 40px rgba(0,0,0,0.1);
        }
        .about-icon{
            width:55px;
            height:55px;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:22px;
            flex-shrink:0;
        }
        .about-card h3{font-size:17px;font-weight:700;color:var(--dark);margin-bottom:8px}
        .about-card p{font-size:14px;color:var(--gray);line-height:1.7}
        
        /* ==========================================
           FEATURES SECTION
           ========================================== */
        .features{
            padding:100px 0;
            background:var(--white);
        }
        
        .features-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:20px;
        }
        
        .feature-item{
            background:var(--light);
            padding:25px;
            border-radius:16px;
            display:flex;
            align-items:center;
            gap:15px;
            transition:all 0.3s;
            border:2px solid transparent;
        }
        .feature-item:hover{
            border-color:var(--primary);
            background:var(--white);
            box-shadow:0 10px 30px rgba(255,107,53,0.1);
        }
        .feature-icon{
            width:50px;
            height:50px;
            background:var(--white);
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--primary);
            font-size:20px;
            flex-shrink:0;
            box-shadow:0 3px 10px rgba(0,0,0,0.08);
        }
        .feature-item:hover .feature-icon{
            background:var(--primary);
            color:#fff;
        }
        .feature-text{font-size:15px;font-weight:600;color:var(--dark)}
        
        /* ==========================================
           SCREENSHOTS SECTION
           ========================================== */
        .screenshots{
            padding:100px 0;
            background:linear-gradient(135deg,#1a1a1a,#2d2d2d);
            overflow:hidden;
        }
        
        .screenshots .section-title,.screenshots .section-subtitle{color:#fff}
        .screenshots .section-subtitle{opacity:0.7}
        
        .screenshots-slider{
            display:flex;
            gap:25px;
            padding:20px 0;
            animation:scroll 30s linear infinite;
        }
        
        @keyframes scroll{
            0%{transform:translateX(0)}
            100%{transform:translateX(-50%)}
        }
        
        .screenshot-item{
            flex-shrink:0;
            width:220px;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 20px 50px rgba(0,0,0,0.4);
            transition:transform 0.3s;
        }
        .screenshot-item:hover{transform:scale(1.05)}
        .screenshot-item img{width:100%;display:block}
        
        /* Placeholder for screenshots */
        .screenshot-placeholder{
            width:220px;
            height:440px;
            background:linear-gradient(135deg,#333,#444);
            border-radius:24px;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            color:#666;
            font-size:14px;
            flex-shrink:0;
        }
        .screenshot-placeholder i{font-size:40px;margin-bottom:10px}
        
        /* ==========================================
           DOWNLOAD SECTION
           ========================================== */
        .download{
            padding:100px 0;
            background:var(--light);
        }
        
        .download-box{
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            border-radius:30px;
            padding:60px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:40px;
            position:relative;
            overflow:hidden;
        }
        .download-box::before{
            content:'';
            position:absolute;
            top:-100px;
            right:-100px;
            width:300px;
            height:300px;
            background:rgba(255,255,255,0.1);
            border-radius:50%;
        }
        
        .download-content{position:relative;z-index:2;max-width:500px}
        .download-content h2{font-size:32px;font-weight:800;color:#fff;margin-bottom:15px}
        .download-content p{font-size:16px;color:rgba(255,255,255,0.85);margin-bottom:30px}
        
        .download-buttons{display:flex;gap:15px;flex-wrap:wrap}
        
        .btn-store{
            display:inline-flex;
            align-items:center;
            gap:12px;
            padding:14px 24px;
            background:rgba(0,0,0,0.3);
            border-radius:12px;
            color:#fff;
            transition:all 0.3s;
        }
        .btn-store:hover{background:rgba(0,0,0,0.5);transform:translateY(-2px)}
        .btn-store i{font-size:28px}
        .btn-store-text{text-align:left}
        .btn-store-text span{display:block;font-size:11px;opacity:0.8}
        .btn-store-text strong{font-size:16px;font-weight:700}
        
        .download-image{
            position:relative;
            z-index:2;
        }
        .download-image img{
            height:350px;
            filter:drop-shadow(0 20px 40px rgba(0,0,0,0.3));
        }
        
        /* ==========================================
           WHY SECTION
           ========================================== */
        .why{
            padding:100px 0;
            background:var(--white);
        }
        
        .why-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:30px;
        }
        
        .why-card{
            padding:35px;
            background:var(--light);
            border-radius:20px;
            transition:all 0.3s;
            position:relative;
            overflow:hidden;
        }
        .why-card::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            width:4px;
            height:100%;
            background:var(--primary);
            transform:scaleY(0);
            transition:transform 0.3s;
        }
        .why-card:hover::before{transform:scaleY(1)}
        .why-card:hover{box-shadow:0 15px 40px rgba(0,0,0,0.08)}
        
        .why-icon{
            width:60px;
            height:60px;
            background:var(--white);
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--primary);
            font-size:24px;
            margin-bottom:20px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }
        .why-card h3{font-size:18px;font-weight:700;color:var(--dark);margin-bottom:10px}
        .why-card p{font-size:14px;color:var(--gray);line-height:1.7}
        
        /* ==========================================
           HOW IT WORKS
           ========================================== */
        .how{
            padding:100px 0;
            background:var(--light);
        }
        
        .steps{
            display:flex;
            justify-content:space-between;
            gap:30px;
            flex-wrap:wrap;
        }
        
        .step{
            flex:1;
            min-width:180px;
            text-align:center;
            position:relative;
        }
        .step:not(:last-child)::after{
            content:'';
            position:absolute;
            top:40px;
            right:-15px;
            width:30px;
            height:2px;
            background:linear-gradient(90deg,var(--primary),transparent);
        }
        
        .step-num{
            width:80px;
            height:80px;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:28px;
            font-weight:800;
            margin:0 auto 20px;
            box-shadow:0 10px 30px rgba(255,107,53,0.3);
        }
        .step-icon{
            width:50px;
            height:50px;
            background:var(--white);
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--primary);
            font-size:20px;
            margin:0 auto 15px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }
        .step h4{font-size:16px;font-weight:700;color:var(--dark);margin-bottom:8px}
        .step p{font-size:13px;color:var(--gray)}
        
        /* ==========================================
           TRUST SECTION
           ========================================== */
        .trust{
            padding:80px 0;
            background:var(--white);
        }
        
        .trust-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:20px;
        }
        
        .trust-item{
            display:flex;
            align-items:center;
            gap:15px;
            padding:25px;
            background:var(--light);
            border-radius:16px;
        }
        .trust-icon{
            width:50px;
            height:50px;
            background:var(--green);
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:20px;
            flex-shrink:0;
        }
        .trust-item span{font-size:15px;font-weight:600;color:var(--dark)}
        
        /* ==========================================
           DEVELOPER SECTION
           ========================================== */
        .developer{
            padding:80px 0;
            background:linear-gradient(135deg,#1a1a1a,#2a2a2a);
            text-align:center;
        }
        
        .dev-card{
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.1);
            border-radius:24px;
            padding:50px;
            max-width:500px;
            margin:0 auto;
        }
        
        .dev-avatar{
            width:100px;
            height:100px;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:36px;
            font-weight:800;
            margin:0 auto 25px;
            box-shadow:0 15px 40px rgba(255,107,53,0.3);
        }
        
        .dev-label{color:rgba(255,255,255,0.5);font-size:13px;margin-bottom:10px}
        .dev-name{color:#fff;font-size:28px;font-weight:800;margin-bottom:8px}
        .dev-role{color:var(--primary);font-size:15px;font-weight:600;margin-bottom:20px}
        .dev-quote{color:rgba(255,255,255,0.7);font-size:15px;font-style:italic;line-height:1.8}
        .dev-flag{font-size:24px;margin-top:15px}
        
        /* ==========================================
           FAQ SECTION
           ========================================== */
        .faq{
            padding:100px 0;
            background:var(--light);
        }
        
        .faq-grid{
            max-width:800px;
            margin:0 auto;
        }
        
        .faq-item{
            background:var(--white);
            border-radius:16px;
            margin-bottom:15px;
            overflow:hidden;
            box-shadow:0 3px 15px rgba(0,0,0,0.05);
        }
        
        .faq-question{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:22px 25px;
            cursor:pointer;
            font-size:16px;
            font-weight:600;
            color:var(--dark);
            transition:color 0.3s;
        }
        .faq-question:hover{color:var(--primary)}
        .faq-question i{
            color:var(--primary);
            transition:transform 0.3s;
        }
        .faq-item.active .faq-question i{transform:rotate(180deg)}
        
        .faq-answer{
            max-height:0;
            overflow:hidden;
            transition:max-height 0.3s;
        }
        .faq-item.active .faq-answer{max-height:200px}
        .faq-answer p{
            padding:0 25px 22px;
            font-size:15px;
            color:var(--gray);
            line-height:1.8;
        }
        
        /* ==========================================
           FINAL CTA
           ========================================== */
        .final-cta{
            padding:100px 0;
            background:var(--white);
            text-align:center;
        }
        
        .cta-content h2{
            font-size:clamp(28px,4vw,42px);
            font-weight:800;
            color:var(--dark);
            margin-bottom:15px;
        }
        .cta-content h2 span{color:var(--primary)}
        .cta-content p{
            font-size:17px;
            color:var(--gray);
            margin-bottom:35px;
        }
        
        .cta-btn{
            display:inline-flex;
            align-items:center;
            gap:12px;
            padding:20px 40px;
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            color:#fff;
            border-radius:16px;
            font-size:17px;
            font-weight:700;
            box-shadow:0 10px 35px rgba(255,107,53,0.35);
            transition:all 0.3s;
        }
        .cta-btn:hover{
            transform:translateY(-4px);
            box-shadow:0 15px 45px rgba(255,107,53,0.45);
        }
        .cta-btn i{font-size:24px}
        
        /* ==========================================
           RESPONSIVE
           ========================================== */
        @media(max-width:900px){
            .hero-content{grid-template-columns:1fr;text-align:center}
            .hero-left{max-width:100%}
            .hero-buttons{justify-content:center}
            .hero-stats{justify-content:center}
            .hero-right{margin-top:40px}
            .download-box{flex-direction:column;text-align:center;padding:40px 25px}
            .download-content{max-width:100%}
            .download-buttons{justify-content:center}
            .step:not(:last-child)::after{display:none}
        }
        
        @media(max-width:600px){
            .hero{padding:80px 0 50px}
            .phone-mockup{width:220px}
            .app-icon-float{width:60px;height:60px;left:-20px;top:-20px}
            .app-icon-float img{width:35px;height:35px}
            .section-header{margin-bottom:40px}
            .download-image img{height:250px}
            .dev-card{padding:35px 25px}
        }
    </style>
</head>
<body>

<?php if(!$is_app) @include 'header.php'; ?>

<!-- ==========================================
     HERO SECTION
     ========================================== -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-badge">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Available on Android</span>
                </div>
                
                <h1>Find Business App — <span>Find & Call</span> Local Businesses Instantly</h1>
                
                <p class="hero-text">Discover nearby shops, services, hospitals, hotels, and professionals — all in one powerful app. Search, explore, and connect with verified local businesses.</p>
                
                <div class="hero-buttons">
                    <a href="<?= $playStoreUrl ?>" target="_blank" class="btn-download btn-playstore">
                        <i class="fab fa-google-play"></i>
                        <span>Download on Play Store</span>
                    </a>
                    <div class="btn-download btn-appstore">
                        <i class="fab fa-apple"></i>
                        <span>Coming Soon</span>
                    </div>
                </div>
                
                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-num">--</div>
                        <div class="stat-text">Downloads</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">--</div>
                        <div class="stat-text">Rating</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">50K+</div>
                        <div class="stat-text">Businesses</div>
                    </div>
                </div>
            </div>
            
            <div class="hero-right">
                <div class="phone-mockup">
                    <div class="app-icon-float">
                        <img src="/assets/app/app-icon.png" alt="Find Business Icon" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>📱</text></svg>'">
                    </div>
                    <img src="/assets/app/app-icon.png" alt="Find Business App" class="phone-frame" onerror="this.parentElement.innerHTML='<div style=\'width:280px;height:560px;background:linear-gradient(135deg,#333,#222);border-radius:40px;border:8px solid #444;display:flex;align-items:center;justify-content:center;color:#666;font-size:40px\'><i class=\'fas fa-mobile-alt\'></i></div>'">
                    <div class="phone-glow"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     ABOUT SECTION
     ========================================== -->
<section class="about">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">About The App</span>
            <h2 class="section-title">What is Find Business?</h2>
            <p class="section-subtitle">India's smart local business discovery platform designed to help users quickly find trusted businesses near their location.</p>
        </div>
        
        <div class="about-grid">
            <div class="about-card">
                <div class="about-icon"><i class="fas fa-search-location"></i></div>
                <div>
                    <h3>Search Nearby Services</h3>
                    <p>Find businesses, shops, and services near your current location instantly.</p>
                </div>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fas fa-phone-alt"></i></div>
                <div>
                    <h3>Call Instantly</h3>
                    <p>One-tap calling to connect with businesses without saving numbers.</p>
                </div>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fas fa-th-large"></i></div>
                <div>
                    <h3>Explore Categories</h3>
                    <p>Browse restaurants, hotels, salons, hospitals, gyms, and more.</p>
                </div>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fas fa-check-circle"></i></div>
                <div>
                    <h3>Verified Listings</h3>
                    <p>All businesses are verified with accurate contact information.</p>
                </div>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fas fa-tags"></i></div>
                <div>
                    <h3>Discover Offers</h3>
                    <p>Find exclusive local discounts and deals near you.</p>
                </div>
            </div>
            <div class="about-card">
                <div class="about-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <h3>Location Detection</h3>
                    <p>Smart location detection shows results relevant to your city.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     FEATURES SECTION
     ========================================== -->
<section class="features">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Features</span>
            <h2 class="section-title">Key Features</h2>
            <p class="section-subtitle">Everything you need to discover and connect with local businesses</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-location-arrow"></i></div>
                <span class="feature-text">Find businesses near you</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-phone"></i></div>
                <span class="feature-text">One-tap call to business</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-city"></i></div>
                <span class="feature-text">City-based results</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <span class="feature-text">Verified listings</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-th"></i></div>
                <span class="feature-text">Business categories</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-feather"></i></div>
                <span class="feature-text">Fast & lightweight app</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-hand-pointer"></i></div>
                <span class="feature-text">Easy-to-use interface</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-wifi"></i></div>
                <span class="feature-text">Works on slow internet</span>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SCREENSHOTS SECTION
     ========================================== -->
<section class="screenshots">
    <div class="container">
        <div class="section-header">
            <span class="section-tag" style="background:rgba(255,255,255,0.1);color:#fff">Preview</span>
            <h2 class="section-title">App Screenshots</h2>
            <p class="section-subtitle">Take a look at the beautiful and intuitive interface</p>
        </div>
    </div>
    
    <div class="screenshots-slider">
        <!-- Add your actual screenshots here -->
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 1</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 2</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 3</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 4</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 5</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 6</div>
        <!-- Duplicate for infinite scroll -->
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 1</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 2</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 3</div>
        <div class="screenshot-placeholder"><i class="fas fa-image"></i>Screenshot 4</div>
    </div>
</section>

<!-- ==========================================
     DOWNLOAD SECTION
     ========================================== -->
<section class="download">
    <div class="container">
        <div class="download-box">
            <div class="download-content">
                <h2>Download Find Business App Now</h2>
                <p>Get the app and start discovering amazing local businesses and exclusive discounts in your city today!</p>
                
                <div class="download-buttons">
                    <a href="<?= $playStoreUrl ?>" target="_blank" class="btn-store">
                        <i class="fab fa-google-play"></i>
                        <div class="btn-store-text">
                            <span>Get it on</span>
                            <strong>Google Play</strong>
                        </div>
                    </a>
                    <div class="btn-store" style="opacity:0.7;cursor:default">
                        <i class="fab fa-apple"></i>
                        <div class="btn-store-text">
                            <span>Coming soon on</span>
                            <strong>App Store</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="download-image">
                <img src="/assets/app/phone-mockup.png" alt="Download Find Business" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     WHY SECTION
     ========================================== -->
<section class="why">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Benefits</span>
            <h2 class="section-title">Why Choose Find Business?</h2>
            <p class="section-subtitle">Built specifically for Indian users and local businesses</p>
        </div>
        
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon"><i class="fas fa-flag"></i></div>
                <h3>Made for India</h3>
                <p>Designed specifically for Indian local businesses and users across all cities.</p>
            </div>
            <div class="why-card">
                <div class="why-icon"><i class="fas fa-bolt"></i></div>
                <h3>Faster Than Google</h3>
                <p>Get direct business contacts without scrolling through irrelevant results.</p>
            </div>
            <div class="why-card">
                <div class="why-icon"><i class="fas fa-phone-volume"></i></div>
                <h3>Easy Calling</h3>
                <p>Call businesses instantly without saving their numbers to your phone.</p>
            </div>
            <div class="why-card">
                <div class="why-icon"><i class="fas fa-map-pin"></i></div>
                <h3>Location Based</h3>
                <p>Results are filtered based on your current city for relevant suggestions.</p>
            </div>
            <div class="why-card">
                <div class="why-icon"><i class="fas fa-palette"></i></div>
                <h3>Simple & Clean UI</h3>
                <p>Beautiful, intuitive interface that anyone can use without confusion.</p>
            </div>
            <div class="why-card">
                <div class="why-icon"><i class="fas fa-store"></i></div>
                <h3>Support Local</h3>
                <p>Built to help small and medium businesses get discovered by nearby customers.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     HOW IT WORKS
     ========================================== -->
<section class="how">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Simple Steps</span>
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Finding local businesses has never been easier</p>
        </div>
        
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-icon"><i class="fas fa-download"></i></div>
                <h4>Open App</h4>
                <p>Download and open Find Business app</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-icon"><i class="fas fa-location-arrow"></i></div>
                <h4>Allow Location</h4>
                <p>Enable location for better results</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-icon"><i class="fas fa-search"></i></div>
                <h4>Search or Browse</h4>
                <p>Find what you need by category</p>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <div class="step-icon"><i class="fas fa-building"></i></div>
                <h4>Choose Business</h4>
                <p>Select from verified listings</p>
            </div>
            <div class="step">
                <div class="step-num">5</div>
                <div class="step-icon"><i class="fas fa-phone-alt"></i></div>
                <h4>Call Directly</h4>
                <p>One tap to connect instantly</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     TRUST SECTION
     ========================================== -->
<section class="trust">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Security</span>
            <h2 class="section-title">Trusted & Secure</h2>
            <p class="section-subtitle">Your privacy and security is our priority</p>
        </div>
        
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-check"></i></div>
                <span>Safe browsing experience</span>
            </div>
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-check"></i></div>
                <span>No spam calling</span>
            </div>
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-check"></i></div>
                <span>Secure connections</span>
            </div>
            <div class="trust-item">
                <div class="trust-icon"><i class="fas fa-check"></i></div>
                <span>Privacy protected</span>
            </div>
        </div>
        
        <p style="text-align:center;margin-top:30px;color:var(--gray);font-size:14px">
            <i class="fas fa-lock" style="color:var(--green);margin-right:8px"></i>
            Your data is never sold or misused. We respect your privacy.
        </p>
    </div>
</section>

<!-- ==========================================
     DEVELOPER SECTION
     ========================================== -->
     <!-------
<section class="developer">
    <div class="container">
        <div class="dev-card">
            <div class="dev-avatar">A</div>
            <div class="dev-label">Developed & Designed By</div>
            <div class="dev-name">Afraj Charaniya</div>
            <div class="dev-role">Software Developer</div>
            <p class="dev-quote">"Built with passion to support local businesses across India"</p>
            <div class="dev-flag">🇮🇳</div>
        </div>
    </div>
</section>------->

<!-- ==========================================
     FAQ SECTION
     ========================================== -->
<section class="faq">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">FAQ</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Got questions? We have answers</p>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item active">
                <div class="faq-question">
                    <span>Is Find Business free to use?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, Find Business is completely free to download and use. There are no hidden charges or subscription fees.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Does Find Business require login?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>No login is required for searching businesses. You can start exploring immediately after installing the app.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Which cities are supported?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Find Business is currently available across major Indian cities and we are expanding to more locations daily.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Is the app available on iPhone?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>The iOS version is coming soon. Currently, Find Business is available on Android devices via Google Play Store.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>How can I list my business?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Business listings are sourced from verified databases. Contact us to add or update your business information.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     FINAL CTA
     ========================================== -->
<section class="final-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Start Discovering <span>Local Businesses</span> Today</h2>
            <p>Join thousands of users who find and connect with businesses using Find Business</p>
            <a href="<?= $playStoreUrl ?>" target="_blank" class="cta-btn">
                <i class="fab fa-google-play"></i>
                Download on Google Play
            </a>
        </div>
    </div>
</section>

<?php if(!$is_app) @include 'footer.php'; ?>

<script>
// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
        const item = q.parentElement;
        const isActive = item.classList.contains('active');
        
        // Close all
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
        
        // Open clicked if wasn't active
        if (!isActive) item.classList.add('active');
    });
});

// Pause screenshot animation on hover
const slider = document.querySelector('.screenshots-slider');
if (slider) {
    slider.addEventListener('mouseenter', () => slider.style.animationPlayState = 'paused');
    slider.addEventListener('mouseleave', () => slider.style.animationPlayState = 'running');
}
</script>

</body>
</html>
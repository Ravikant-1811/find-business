<?php include_once 'app-detect.php'; ?>
<?php
session_start();

$is_app = isset($_GET['app']) || (isset($isApp) && $isApp);

// Get slug from URL
$slug = $_GET['slug'] ?? '';

// All Blog Content
$allBlogs = [
    'what-is-find-business-india-local-business-discovery-platform' => [
        'id' => 1,
        'title' => 'What is Find Business? India\'s Local Business & Discount Discovery Platform',
        'category' => 'About',
        'date' => '2024-01-15',
        'read_time' => '3 min read',
        'author' => 'Find Business Team',
        'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200',
        'content' => '
            <p><strong>Find Business</strong> is a smart local discovery platform designed to help people find trusted businesses, services, and exclusive discounts near them. Whether you are searching for restaurants, hospitals, salons, gyms, hotels, or shops — Find Business connects you with verified local businesses in your city.</p>
            
            <h2>What Makes Find Business Different?</h2>
            <p>With Find Business, users can easily explore nearby places, check ratings, view business details, and discover ongoing offers and discounts — all in one place. Our goal is to support local businesses while helping customers save money every day.</p>
            
            <p>Unlike traditional directories, Find Business focuses on <strong>location-based results</strong>, making it easier to find exactly what you need in your current city.</p>
            
            <h2>Key Features</h2>
            <ul>
                <li><strong>City-Based Discovery:</strong> Find businesses specifically in your city</li>
                <li><strong>Real-Time Discounts:</strong> Access exclusive local offers and deals</li>
                <li><strong>Verified Ratings:</strong> Trust ratings from real customers</li>
                <li><strong>Multiple Categories:</strong> Restaurants, hotels, salons, hospitals, gyms, and more</li>
                <li><strong>Easy Contact:</strong> One-tap calling and directions</li>
            </ul>
            
            <h2>Our Mission</h2>
            <p>Find Business aims to bridge the gap between local businesses and customers. We believe that every local business deserves to be discovered, and every customer deserves to find the best services at the best prices.</p>
            
            <blockquote>
                "Supporting local businesses means supporting your community."
            </blockquote>
            
            <p>Start exploring your city with Find Business today and discover amazing businesses and deals near you!</p>
        ',
    ],
    'how-find-business-helps-find-best-discounts-near-you' => [
        'id' => 2,
        'title' => 'How Find Business Helps You Find the Best Discounts Near You',
        'category' => 'Discounts',
        'date' => '2024-01-18',
        'read_time' => '4 min read',
        'author' => 'Find Business Team',
        'image' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1200',
        'content' => '
            <p>Finding genuine local discounts can be difficult. Many offers are outdated or unavailable. <strong>Find Business</strong> solves this problem by showing active deals based on your city and business category.</p>
            
            <h2>Smart Discount Discovery</h2>
            <p>Using smart location detection and business data, Find Business displays relevant discounts that are actually available in your area.</p>
            
            <h2>Types of Discounts You Can Find</h2>
            <ul>
                <li>🍽️ <strong>Restaurant Offers:</strong> Combo deals, family packs, lunch specials</li>
                <li>🏨 <strong>Hotel Discounts:</strong> Weekend stays, early bird rates, couple packages</li>
                <li>💇 <strong>Salon & Beauty Deals:</strong> Haircut combos, spa packages, bridal offers</li>
                <li>🏋️ <strong>Gym Memberships:</strong> Annual discounts, personal training, couple offers</li>
                <li>🛍️ <strong>Shopping Sales:</strong> Seasonal discounts, BOGO offers, cashback</li>
                <li>☕ <strong>Cafe Combos:</strong> Coffee deals, breakfast specials, happy hours</li>
            </ul>
            
            <h2>How It Works</h2>
            <ol>
                <li><strong>Select Your City:</strong> Choose your current location</li>
                <li><strong>Browse Categories:</strong> Pick the type of business you need</li>
                <li><strong>View Discounts:</strong> See all available offers instantly</li>
                <li><strong>Save & Use:</strong> Copy the code and use at the business</li>
            </ol>
            
            <p>This helps people <strong>save money</strong> while encouraging local businesses to reach nearby customers effectively.</p>
            
            <h2>Why Trust Find Business Discounts?</h2>
            <p>All discounts on Find Business are verified and updated regularly. We only show offers from businesses that have good ratings and genuine customer reviews.</p>
            
            <blockquote>
                "Save money every day with verified local discounts on Find Business."
            </blockquote>
        ',
    ],
    'why-local-businesses-should-list-on-find-business' => [
        'id' => 3,
        'title' => 'Why Local Businesses Should List on Find Business',
        'category' => 'Business',
        'date' => '2024-01-22',
        'read_time' => '5 min read',
        'author' => 'Find Business Team',
        'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1200',
        'content' => '
            <p>Local businesses grow faster when they are easily discoverable online. <strong>Find Business</strong> gives small and medium businesses a digital presence without heavy marketing costs.</p>
            
            <h2>Benefits for Businesses</h2>
            <ul>
                <li>📈 <strong>Increased Local Visibility:</strong> Get found by customers searching in your city</li>
                <li>🔍 <strong>Appear in City-Based Searches:</strong> Show up when people search for services near them</li>
                <li>👥 <strong>Reach Nearby Customers:</strong> Connect with people who are most likely to visit</li>
                <li>🎁 <strong>Promote Special Offers:</strong> Showcase your discounts and deals</li>
                <li>⭐ <strong>Build Online Trust:</strong> Collect and display positive ratings and reviews</li>
            </ul>
            
            <h2>Why Digital Presence Matters</h2>
            <p>In today\'s world, customers search online before visiting any business. If your business is not online, you are missing out on potential customers every day.</p>
            
            <p>Find Business makes it easy for businesses to:</p>
            <ul>
                <li>Create a business profile</li>
                <li>Add photos and details</li>
                <li>Post offers and discounts</li>
                <li>Receive customer inquiries</li>
            </ul>
            
            <h2>Cost-Effective Marketing</h2>
            <p>Traditional advertising is expensive. Find Business provides a platform where businesses can reach local customers at a fraction of the cost of traditional marketing.</p>
            
            <blockquote>
                "Find Business works as a bridge between customers and businesses, helping both sides grow together."
            </blockquote>
            
            <h2>Get Started Today</h2>
            <p>If you own a local business, list it on Find Business and start reaching customers in your area. It\'s simple, effective, and designed to help you grow.</p>
        ',
    ],
    'top-benefits-of-using-find-business-app' => [
        'id' => 4,
        'title' => 'Top Benefits of Using Find Business App',
        'category' => 'Features',
        'date' => '2024-01-25',
        'read_time' => '3 min read',
        'author' => 'Find Business Team',
        'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=1200',
        'content' => '
            <p><strong>Find Business</strong> is built for simplicity and speed. Here\'s why users love it:</p>
            
            <h2>Key Features</h2>
            
            <h3>📍 City-Based Business Discovery</h3>
            <p>Find businesses specifically in your city. No more irrelevant results from other locations.</p>
            
            <h3>🔍 Easy Search by Category</h3>
            <p>Browse by category — restaurants, hotels, salons, hospitals, gyms, shopping, and cafes. Find exactly what you need in seconds.</p>
            
            <h3>⭐ Ratings & Reviews Visibility</h3>
            <p>See real ratings and reviews from customers. Make informed decisions based on genuine feedback.</p>
            
            <h3>💸 Local Discounts and Offers</h3>
            <p>Access exclusive discounts available only for Find Business users. Save money on every visit.</p>
            
            <h3>📞 One-Tap Call to Business</h3>
            <p>Call any business directly from the app with just one tap. No need to search for phone numbers.</p>
            
            <h3>🧭 Location-Based Suggestions</h3>
            <p>Get personalized suggestions based on your current location. Discover great places nearby.</p>
            
            <h2>Why Users Love Find Business</h2>
            <ul>
                <li><strong>Fast:</strong> Find what you need in seconds</li>
                <li><strong>Simple:</strong> Easy-to-use interface</li>
                <li><strong>Reliable:</strong> Verified business information</li>
                <li><strong>Money-Saving:</strong> Exclusive local discounts</li>
                <li><strong>Comprehensive:</strong> All business types in one app</li>
            </ul>
            
            <blockquote>
                "Whether you are new in a city or searching for nearby services, Find Business makes everything easy and fast."
            </blockquote>
            
            <h2>Download Find Business Today</h2>
            <p>Start exploring your city with Find Business. Find the best businesses, discover amazing discounts, and save money every day!</p>
        ',
    ],
];

// Get current blog
$blog = $allBlogs[$slug] ?? null;

if (!$blog) {
    header("Location: /blog");
    exit;
}

// Get related blogs (excluding current)
$relatedBlogs = array_filter($allBlogs, fn($b, $s) => $s !== $slug, ARRAY_FILTER_USE_BOTH);
$relatedBlogs = array_slice($relatedBlogs, 0, 2, true);

$pageTitle = $blog['title'] . " - Find Business Blog";
$pageDesc = strip_tags(substr($blog['content'], 0, 160));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
    <link rel="canonical" href="https://find-business.com/blog/<?= $slug ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($blog['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDesc) ?>">
    <meta property="og:image" content="<?= $blog['image'] ?>">
    <meta property="og:type" content="article">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Schema Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "<?= htmlspecialchars($blog['title']) ?>",
        "image": "<?= $blog['image'] ?>",
        "datePublished": "<?= $blog['date'] ?>",
        "author": {
            "@type": "Organization",
            "name": "Find Business"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Find Business"
        }
    }
    </script>
    
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:#f8f9fa;color:#333;line-height:1.8}
        a{text-decoration:none;color:#FF6B35}
        a:hover{text-decoration:underline}
        <?php if($is_app): ?>.hdr,.ftr,header,footer{display:none!important}<?php endif; ?>
        
        /* Hero */
        .post-hero{
            position:relative;
            height:450px;
            overflow:hidden;
        }
        .post-hero img{
            width:100%;
            height:100%;
            object-fit:cover;
        }
        .post-hero-overlay{
            position:absolute;
            inset:0;
            background:linear-gradient(transparent 30%,rgba(0,0,0,0.8));
            display:flex;
            align-items:flex-end;
            padding:40px 20px;
        }
        .post-hero-content{
            max-width:800px;
            margin:0 auto;
            width:100%;
            color:#fff;
        }
        .post-category{
            display:inline-block;
            background:#FF6B35;
            color:#fff;
            padding:6px 16px;
            border-radius:6px;
            font-size:12px;
            font-weight:700;
            text-transform:uppercase;
            margin-bottom:15px;
        }
        .post-title{
            font-size:clamp(24px,4vw,36px);
            font-weight:800;
            line-height:1.3;
            margin-bottom:15px;
        }
        .post-meta{
            display:flex;
            align-items:center;
            gap:20px;
            font-size:14px;
            opacity:0.85;
            flex-wrap:wrap;
        }
        .post-meta span{display:flex;align-items:center;gap:6px}
        
        /* Content */
        .post-container{
            max-width:800px;
            margin:0 auto;
            padding:50px 20px 80px;
        }
        
        .post-content{
            background:#fff;
            border-radius:20px;
            padding:40px;
            box-shadow:0 5px 30px rgba(0,0,0,0.08);
            margin-bottom:40px;
        }
        
        .post-content h2{
            font-size:24px;
            font-weight:700;
            color:#222;
            margin:35px 0 15px;
            padding-top:20px;
            border-top:1px solid #eee;
        }
        .post-content h2:first-child{
            margin-top:0;
            padding-top:0;
            border-top:none;
        }
        
        .post-content h3{
            font-size:20px;
            font-weight:600;
            color:#333;
            margin:25px 0 12px;
        }
        
        .post-content p{
            font-size:16px;
            color:#444;
            margin-bottom:18px;
            line-height:1.8;
        }
        
        .post-content ul,.post-content ol{
            margin:15px 0 25px 25px;
        }
        
        .post-content li{
            font-size:16px;
            color:#444;
            margin-bottom:10px;
            line-height:1.7;
        }
        
        .post-content strong{
            color:#222;
        }
        
        .post-content blockquote{
            background:linear-gradient(135deg,#FFF7ED,#FFEDD5);
            border-left:4px solid #FF6B35;
            padding:25px 30px;
            margin:30px 0;
            border-radius:0 12px 12px 0;
            font-size:18px;
            font-style:italic;
            color:#333;
        }
        
        /* Share */
        .share-box{
            background:#fff;
            border-radius:16px;
            padding:25px;
            box-shadow:0 3px 15px rgba(0,0,0,0.06);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            flex-wrap:wrap;
            margin-bottom:40px;
        }
        .share-box span{
            font-weight:600;
            color:#333;
        }
        .share-btns{
            display:flex;
            gap:10px;
        }
        .share-btn{
            width:45px;
            height:45px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:18px;
            transition:transform 0.3s;
        }
        .share-btn:hover{transform:scale(1.1);text-decoration:none}
        .share-btn.fb{background:#1877F2}
        .share-btn.tw{background:#1DA1F2}
        .share-btn.wa{background:#25D366}
        .share-btn.li{background:#0A66C2}
        
        /* Related */
        .related-section h2{
            font-size:22px;
            font-weight:700;
            color:#222;
            margin-bottom:25px;
        }
        .related-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
            gap:25px;
        }
        .related-card{
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 3px 15px rgba(0,0,0,0.08);
            transition:transform 0.3s;
        }
        .related-card:hover{transform:translateY(-5px);text-decoration:none}
        .related-img{
            height:160px;
            overflow:hidden;
        }
        .related-img img{
            width:100%;
            height:100%;
            object-fit:cover;
        }
        .related-body{
            padding:20px;
        }
        .related-title{
            font-size:16px;
            font-weight:700;
            color:#222;
            line-height:1.4;
            margin-bottom:10px;
        }
        .related-meta{
            font-size:12px;
            color:#888;
        }
        
        /* Back Button */
        .back-btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            color:#666;
            font-size:14px;
            font-weight:500;
            margin-bottom:20px;
            transition:color 0.3s;
        }
        .back-btn:hover{color:#FF6B35;text-decoration:none}
        
        @media(max-width:600px){
            .post-hero{height:350px}
            .post-content{padding:25px}
            .post-content h2{font-size:20px}
            .post-content p,.post-content li{font-size:15px}
        }
    </style>
</head>
<body>

<?php if(!$is_app) @include 'header.php'; ?>

<!-- Hero -->
<div class="post-hero">
    <img src="<?= $blog['image'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
    <div class="post-hero-overlay">
        <div class="post-hero-content">
            <span class="post-category"><?= $blog['category'] ?></span>
            <h1 class="post-title"><?= htmlspecialchars($blog['title']) ?></h1>
            <div class="post-meta">
                <span><i class="fas fa-user"></i> <?= $blog['author'] ?></span>
                <span><i class="fas fa-calendar"></i> <?= date('F d, Y', strtotime($blog['date'])) ?></span>
                <span><i class="fas fa-clock"></i> <?= $blog['read_time'] ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<main class="post-container">
    
    <a href="/blog" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Blog
    </a>
    
    <article class="post-content">
        <?= $blog['content'] ?>
    </article>
    
    <!-- Share -->
    <div class="share-box">
        <span><i class="fas fa-share-alt"></i> Share this article</span>
        <div class="share-btns">
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://find-business.com/blog/<?= $slug ?>" target="_blank" class="share-btn fb" title="Share on Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url=https://find-business.com/blog/<?= $slug ?>&text=<?= urlencode($blog['title']) ?>" target="_blank" class="share-btn tw" title="Share on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://wa.me/?text=<?= urlencode($blog['title'] . ' https://find-business.com/blog/' . $slug) ?>" target="_blank" class="share-btn wa" title="Share on WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=https://find-business.com/blog/<?= $slug ?>" target="_blank" class="share-btn li" title="Share on LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </div>
    
    <!-- Related Posts -->
    <?php if(!empty($relatedBlogs)): ?>
    <section class="related-section">
        <h2>Related Articles</h2>
        <div class="related-grid">
            <?php foreach($relatedBlogs as $relSlug => $rel): ?>
            <a href="/blog/<?= $relSlug ?>" class="related-card">
                <div class="related-img">
                    <img src="<?= $rel['image'] ?>" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy">
                </div>
                <div class="related-body">
                    <h3 class="related-title"><?= htmlspecialchars($rel['title']) ?></h3>
                    <div class="related-meta">
                        <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($rel['date'])) ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    
</main>

<?php if(!$is_app) @include 'footer.php'; ?>

</body>
</html>
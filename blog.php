<?php include_once 'app-detect.php'; ?>
<?php
session_start();

$is_app = isset($_GET['app']) || (isset($isApp) && $isApp);

// Blog Data
$blogs = [
    [
        'id' => 1,
        'slug' => 'what-is-find-business-india-local-business-discovery-platform',
        'title' => 'What is Find Business? India\'s Local Business & Discount Discovery Platform',
        'excerpt' => 'Find Business is a smart local discovery platform designed to help people find trusted businesses, services, and exclusive discounts near them.',
        'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800',
        'category' => 'About',
        'date' => '2024-01-15',
        'read_time' => '3 min read',
        'author' => 'Find Business Team',
    ],
    [
        'id' => 2,
        'slug' => 'how-find-business-helps-find-best-discounts-near-you',
        'title' => 'How Find Business Helps You Find the Best Discounts Near You',
        'excerpt' => 'Finding genuine local discounts can be difficult. Find Business solves this problem by showing active deals based on your city and business category.',
        'image' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800',
        'category' => 'Discounts',
        'date' => '2024-01-18',
        'read_time' => '4 min read',
        'author' => 'Find Business Team',
    ],
    [
        'id' => 3,
        'slug' => 'why-local-businesses-should-list-on-find-business',
        'title' => 'Why Local Businesses Should List on Find Business',
        'excerpt' => 'Local businesses grow faster when they are easily discoverable online. Find Business gives small and medium businesses a digital presence.',
        'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800',
        'category' => 'Business',
        'date' => '2024-01-22',
        'read_time' => '5 min read',
        'author' => 'Find Business Team',
    ],
    [
        'id' => 4,
        'slug' => 'top-benefits-of-using-find-business-app',
        'title' => 'Top Benefits of Using Find Business App',
        'excerpt' => 'Find Business is built for simplicity and speed. Discover why millions of users love using Find Business for local discovery.',
        'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800',
        'category' => 'Features',
        'date' => '2024-01-25',
        'read_time' => '3 min read',
        'author' => 'Find Business Team',
    ],
];

$pageTitle = "Blog - Find Business | Local Business Tips & Updates";
$pageDesc = "Read the latest articles about local business discovery, discounts, and tips on Find Business blog.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDesc ?>">
    <link rel="canonical" href="https://find-business.com/blog">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Schema Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "Find Business Blog",
        "description": "<?= $pageDesc ?>",
        "url": "https://find-business.com/blog",
        "publisher": {
            "@type": "Organization",
            "name": "Find Business"
        }
    }
    </script>
    
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:#f8f9fa;color:#333;line-height:1.7}
        a{text-decoration:none;color:inherit}
        <?php if($is_app): ?>.hdr,.ftr,header,footer{display:none!important}<?php endif; ?>
        
        /* Hero */
        .blog-hero{
            background:linear-gradient(135deg,#1a1a1a 0%,#2d2d2d 50%,#1a1a1a 100%);
            padding:80px 20px;
            text-align:center;
            position:relative;
            overflow:hidden;
        }
        .blog-hero::before{
            content:'';
            position:absolute;
            top:-50%;
            right:-20%;
            width:500px;
            height:500px;
            background:radial-gradient(circle,rgba(255,107,53,0.15),transparent 70%);
            border-radius:50%;
        }
        .blog-hero h1{
            font-size:clamp(28px,5vw,42px);
            font-weight:800;
            color:#fff;
            margin-bottom:15px;
            position:relative;
            z-index:1;
        }
        .blog-hero h1 span{color:#FF6B35}
        .blog-hero p{
            color:rgba(255,255,255,0.7);
            font-size:16px;
            max-width:500px;
            margin:0 auto;
            position:relative;
            z-index:1;
        }
        
        /* Main Container */
        .blog-container{
            max-width:1100px;
            margin:0 auto;
            padding:40px 20px 80px;
        }
        
        /* Featured Post */
        .featured-post{
            background:#fff;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 10px 40px rgba(0,0,0,0.1);
            margin-bottom:50px;
            display:grid;
            grid-template-columns:1.2fr 1fr;
        }
        .featured-img{
            height:100%;
            min-height:350px;
            position:relative;
            overflow:hidden;
        }
        .featured-img img{
            width:100%;
            height:100%;
            object-fit:cover;
            transition:transform 0.5s;
        }
        .featured-post:hover .featured-img img{
            transform:scale(1.05);
        }
        .featured-badge{
            position:absolute;
            top:20px;
            left:20px;
            background:#FF6B35;
            color:#fff;
            padding:8px 16px;
            border-radius:8px;
            font-size:12px;
            font-weight:700;
            text-transform:uppercase;
        }
        .featured-content{
            padding:40px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }
        .featured-meta{
            display:flex;
            align-items:center;
            gap:15px;
            margin-bottom:15px;
            font-size:13px;
            color:#888;
        }
        .featured-meta span{display:flex;align-items:center;gap:5px}
        .featured-meta i{color:#FF6B35}
        .featured-title{
            font-size:26px;
            font-weight:700;
            color:#222;
            margin-bottom:15px;
            line-height:1.3;
        }
        .featured-title:hover{color:#FF6B35}
        .featured-excerpt{
            font-size:15px;
            color:#666;
            margin-bottom:25px;
            line-height:1.7;
        }
        .read-more{
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:linear-gradient(135deg,#FF6B35,#E85A2A);
            color:#fff;
            padding:14px 28px;
            border-radius:12px;
            font-size:14px;
            font-weight:600;
            transition:all 0.3s;
            width:fit-content;
            box-shadow:0 5px 20px rgba(255,107,53,0.3);
        }
        .read-more:hover{
            transform:translateY(-3px);
            box-shadow:0 8px 25px rgba(255,107,53,0.4);
        }
        
        /* Section Title */
        .section-title{
            font-size:24px;
            font-weight:700;
            color:#222;
            margin-bottom:30px;
            display:flex;
            align-items:center;
            gap:12px;
        }
        .section-title::after{
            content:'';
            flex:1;
            height:2px;
            background:linear-gradient(90deg,#FF6B35,transparent);
        }
        
        /* Blog Grid */
        .blog-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
            gap:30px;
        }
        
        /* Blog Card */
        .blog-card{
            background:#fff;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.08);
            transition:all 0.3s;
        }
        .blog-card:hover{
            transform:translateY(-8px);
            box-shadow:0 15px 40px rgba(0,0,0,0.12);
        }
        .card-img{
            height:200px;
            position:relative;
            overflow:hidden;
        }
        .card-img img{
            width:100%;
            height:100%;
            object-fit:cover;
            transition:transform 0.5s;
        }
        .blog-card:hover .card-img img{
            transform:scale(1.08);
        }
        .card-category{
            position:absolute;
            top:15px;
            left:15px;
            background:rgba(255,107,53,0.95);
            color:#fff;
            padding:6px 14px;
            border-radius:6px;
            font-size:11px;
            font-weight:700;
            text-transform:uppercase;
        }
        .card-body{
            padding:25px;
        }
        .card-meta{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:12px;
            font-size:12px;
            color:#999;
        }
        .card-meta span{display:flex;align-items:center;gap:4px}
        .card-meta i{font-size:11px;color:#FF6B35}
        .card-title{
            font-size:18px;
            font-weight:700;
            color:#222;
            margin-bottom:12px;
            line-height:1.4;
            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical;
            overflow:hidden;
        }
        .card-title:hover{color:#FF6B35}
        .card-excerpt{
            font-size:14px;
            color:#666;
            line-height:1.6;
            display:-webkit-box;
            -webkit-line-clamp:3;
            -webkit-box-orient:vertical;
            overflow:hidden;
            margin-bottom:20px;
        }
        .card-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding-top:15px;
            border-top:1px solid #f0f0f0;
        }
        .author{
            display:flex;
            align-items:center;
            gap:10px;
        }
        .author-avatar{
            width:35px;
            height:35px;
            background:linear-gradient(135deg,#FF6B35,#E85A2A);
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:14px;
            font-weight:700;
        }
        .author-name{font-size:13px;font-weight:600;color:#333}
        .read-link{
            display:flex;
            align-items:center;
            gap:5px;
            color:#FF6B35;
            font-size:13px;
            font-weight:600;
            transition:gap 0.3s;
        }
        .read-link:hover{gap:10px}
        
        /* Newsletter */
        .newsletter{
            background:linear-gradient(135deg,#FF6B35,#E85A2A);
            border-radius:24px;
            padding:50px 40px;
            margin-top:60px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:40px;
            flex-wrap:wrap;
        }
        .newsletter-text h3{
            font-size:24px;
            font-weight:700;
            color:#fff;
            margin-bottom:8px;
        }
        .newsletter-text p{
            color:rgba(255,255,255,0.85);
            font-size:14px;
        }
        .newsletter-form{
            display:flex;
            gap:12px;
            flex:1;
            max-width:450px;
        }
        .newsletter-form input{
            flex:1;
            padding:16px 20px;
            border:none;
            border-radius:12px;
            font-size:14px;
            font-family:inherit;
            min-width:200px;
        }
        .newsletter-form input:focus{outline:none}
        .newsletter-form button{
            padding:16px 30px;
            background:#222;
            color:#fff;
            border:none;
            border-radius:12px;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
            font-family:inherit;
            transition:all 0.3s;
            white-space:nowrap;
        }
        .newsletter-form button:hover{
            background:#000;
            transform:scale(1.02);
        }
        
        /* Responsive */
        @media(max-width:900px){
            .featured-post{grid-template-columns:1fr}
            .featured-img{min-height:250px}
            .featured-content{padding:30px}
            .featured-title{font-size:22px}
        }
        @media(max-width:600px){
            .blog-hero{padding:60px 20px}
            .blog-grid{grid-template-columns:1fr}
            .newsletter{padding:35px 25px;flex-direction:column;text-align:center}
            .newsletter-form{flex-direction:column;width:100%}
            .newsletter-form input,.newsletter-form button{width:100%}
        }
    </style>
</head>
<body>

<?php if(!$is_app) @include 'header.php'; ?>

<!-- Hero -->
<section class="blog-hero">
    <h1>The <span>Find Business</span> Blog</h1>
    <p>Tips, updates, and insights about local business discovery and exclusive deals</p>
</section>

<!-- Main Content -->
<main class="blog-container">
    
    <!-- Featured Post -->
    <a href="/blog/<?= $blogs[0]['slug'] ?>" class="featured-post">
        <div class="featured-img">
            <img src="<?= $blogs[0]['image'] ?>" alt="<?= htmlspecialchars($blogs[0]['title']) ?>" loading="lazy">
            <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
        </div>
        <div class="featured-content">
            <div class="featured-meta">
                <span><i class="fas fa-folder"></i> <?= $blogs[0]['category'] ?></span>
                <span><i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($blogs[0]['date'])) ?></span>
                <span><i class="fas fa-clock"></i> <?= $blogs[0]['read_time'] ?></span>
            </div>
            <h2 class="featured-title"><?= htmlspecialchars($blogs[0]['title']) ?></h2>
            <p class="featured-excerpt"><?= htmlspecialchars($blogs[0]['excerpt']) ?></p>
            <span class="read-more">Read Article <i class="fas fa-arrow-right"></i></span>
        </div>
    </a>
    
    <!-- Latest Posts -->
    <h2 class="section-title">Latest Articles</h2>
    
    <div class="blog-grid">
        <?php foreach(array_slice($blogs, 1) as $blog): ?>
        <article class="blog-card">
            <a href="/blog/<?= $blog['slug'] ?>">
                <div class="card-img">
                    <img src="<?= $blog['image'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>" loading="lazy">
                    <span class="card-category"><?= $blog['category'] ?></span>
                </div>
            </a>
            <div class="card-body">
                <div class="card-meta">
                    <span><i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($blog['date'])) ?></span>
                    <span><i class="fas fa-clock"></i> <?= $blog['read_time'] ?></span>
                </div>
                <a href="/blog/<?= $blog['slug'] ?>">
                    <h3 class="card-title"><?= htmlspecialchars($blog['title']) ?></h3>
                </a>
                <p class="card-excerpt"><?= htmlspecialchars($blog['excerpt']) ?></p>
                <div class="card-footer">
                    <div class="author">
                        <div class="author-avatar">D</div>
                        <span class="author-name"><?= $blog['author'] ?></span>
                    </div>
                    <a href="blog-single.php" class="read-link">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    
    <!-- Newsletter -->
    <div class="newsletter">
        <div class="newsletter-text">
            <h3>Subscribe to Our Newsletter</h3>
            <p>Get the latest updates on local deals and business tips</p>
        </div>
        <form class="newsletter-form" onsubmit="return subscribeNewsletter(event)">
            <input type="email" id="emailInput" placeholder="Enter your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </div>
    
</main>

<!-- Toast -->
<div class="toast" id="toast" style="position:fixed;bottom:25px;left:50%;transform:translateX(-50%) translateY(80px);background:#222;color:#fff;padding:12px 25px;border-radius:25px;font-size:13px;opacity:0;transition:.3s;z-index:10000"></div>

<?php if(!$is_app) @include 'footer.php'; ?>

<script>
function subscribeNewsletter(e){
    e.preventDefault();
    const email = document.getElementById('emailInput').value;
    // Here you would send to your backend
    showToast('Thanks for subscribing!');
    document.getElementById('emailInput').value = '';
    return false;
}

function showToast(msg){
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.opacity = '1';
    t.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(() => {
        t.style.opacity = '0';
        t.style.transform = 'translateX(-50%) translateY(80px)';
    }, 3000);
}
</script>

</body>
</html>
<?php
// api/category.php - API Endpoint for Category Data

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get category slug from URL
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/api\/category\/([a-z0-9-]+)/', $request_uri, $matches);
$category_slug = $matches[1] ?? 'hospitals';

// Category data
$categories = [
    'hospitals' => [
        'name' => 'Hospitals & Healthcare',
        'icon' => 'hospital',
        'description' => 'Find the best hospitals, clinics, and healthcare centers across India. From multi-specialty hospitals to specialized care facilities.',
        'total_listings' => 1250
    ],
    'hotels' => [
        'name' => 'Hotels & Resorts',
        'icon' => 'hotel',
        'description' => 'Discover luxury hotels, budget stays, and premium resorts. Book your perfect accommodation across India.',
        'total_listings' => 2340
    ],
    'it-companies' => [
        'name' => 'IT Companies & Tech',
        'icon' => 'laptop-code',
        'description' => 'Explore top IT companies, software firms, and tech startups across India.',
        'total_listings' => 890
    ],
    'restaurants' => [
        'name' => 'Restaurants & Dining',
        'icon' => 'utensils',
        'description' => 'Discover the finest restaurants, cafes, and dining experiences across India.',
        'total_listings' => 3450
    ],
    'education' => [
        'name' => 'Schools & Education',
        'icon' => 'graduation-cap',
        'description' => 'Find top schools, colleges, universities, and coaching centers across India.',
        'total_listings' => 1560
    ],
    'real-estate' => [
        'name' => 'Real Estate & Properties',
        'icon' => 'building',
        'description' => 'Browse properties, apartments, commercial spaces across India.',
        'total_listings' => 780
    ],
    'automotive' => [
        'name' => 'Automotive & Dealers',
        'icon' => 'car',
        'description' => 'Find car dealers, service centers, and automotive services across India.',
        'total_listings' => 920
    ],
    'banking' => [
        'name' => 'Banks & Financial Services',
        'icon' => 'landmark',
        'description' => 'Explore banks, NBFCs, and financial services across India.',
        'total_listings' => 450
    ],
    'legal' => [
        'name' => 'Legal & Law Firms',
        'icon' => 'scale-balanced',
        'description' => 'Connect with top lawyers and law firms across India.',
        'total_listings' => 320
    ],
    'manufacturing' => [
        'name' => 'Manufacturing & Industries',
        'icon' => 'industry',
        'description' => 'Discover manufacturers and industrial suppliers across India.',
        'total_listings' => 670
    ]
];

$category = $categories[$category_slug] ?? $categories['hospitals'];

// Response
$response = [
    'success' => true,
    'data' => [
        'category' => [
            'slug' => $category_slug,
            'name' => $category['name'],
            'icon' => $category['icon'],
            'description' => $category['description'],
            'total_listings' => $category['total_listings']
        ],
        'tabs' => [
            ['id' => 'all', 'label' => 'All', 'icon' => 'th-large', 'count' => $category['total_listings']],
            ['id' => 'top-rated', 'label' => 'Top Rated', 'icon' => 'trophy', 'count' => intval($category['total_listings'] * 0.2)],
            ['id' => 'verified', 'label' => 'Verified', 'icon' => 'badge-check', 'count' => intval($category['total_listings'] * 0.6)],
            ['id' => 'featured', 'label' => 'Featured', 'icon' => 'crown', 'count' => intval($category['total_listings'] * 0.1)],
            ['id' => 'new', 'label' => 'New', 'icon' => 'sparkles', 'count' => intval($category['total_listings'] * 0.15)]
        ],
        'cities' => [
            'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai',
            'Kolkata', 'Pune', 'Ahmedabad', 'Jaipur', 'Lucknow',
            'Chandigarh', 'Noida', 'Gurgaon', 'Indore', 'Bhopal'
        ],
        'filters' => [
            'rating' => [
                'title' => 'Rating',
                'options' => [
                    ['value' => '4.5', 'label' => '4.5+ Stars', 'stars' => 4.5, 'count' => 89],
                    ['value' => '4', 'label' => '4+ Stars', 'stars' => 4, 'count' => 156],
                    ['value' => '3', 'label' => '3+ Stars', 'stars' => 3, 'count' => 287]
                ]
            ],
            'features' => [
                'title' => 'Features',
                'options' => [
                    ['value' => 'verified', 'label' => 'Verified Business', 'icon' => 'badge-check', 'color' => 'green'],
                    ['value' => 'open_now', 'label' => 'Open Now', 'icon' => 'clock', 'color' => 'blue'],
                    ['value' => 'featured', 'label' => 'Featured', 'icon' => 'crown', 'color' => 'orange']
                ]
            ]
        ]
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT);
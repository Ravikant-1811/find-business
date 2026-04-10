<?php
// api/listings.php - API Endpoint for Listings Data

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get parameters
$category = $_GET['category'] ?? 'hospitals';
$city = $_GET['city'] ?? '';
$tab = $_GET['tab'] ?? 'all';
$sort = $_GET['sort'] ?? 'relevance';
$page = intval($_GET['page'] ?? 1);
$per_page = intval($_GET['per_page'] ?? 9);
$rating = $_GET['rating'] ?? '';

// Sample listings data based on category
$sample_data = [
    'hospitals' => [
        ['id' => 1, 'name' => 'Apollo Hospitals', 'category' => 'Multi-Specialty Hospital', 'city' => 'Chennai', 'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=500&h=350&fit=crop', 'rating' => 4.8, 'reviews' => 2845, 'address' => 'Greams Road, Thousand Lights, Chennai, Tamil Nadu', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Emergency', '24/7', 'ICU', 'Pharmacy'], 'phone' => '+914428290200'],
        ['id' => 2, 'name' => 'Fortis Healthcare', 'category' => 'Super Specialty Hospital', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=500&h=350&fit=crop', 'rating' => 4.7, 'reviews' => 1923, 'address' => 'Sector 44, Gurgaon, Delhi NCR', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Cardiology', 'Oncology', 'Neurology'], 'phone' => '+911142776222'],
        ['id' => 3, 'name' => 'Manipal Hospital', 'category' => 'Multi-Specialty Hospital', 'city' => 'Bangalore', 'image' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=500&h=350&fit=crop', 'rating' => 4.6, 'reviews' => 1567, 'address' => 'HAL Airport Road, Bangalore, Karnataka', 'is_verified' => true, 'is_featured' => false, 'is_open' => true, 'features' => ['Orthopedics', 'Pediatrics'], 'phone' => '+918025024444'],
        ['id' => 4, 'name' => 'Max Super Specialty', 'category' => 'Super Specialty Hospital', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=500&h=350&fit=crop', 'rating' => 4.5, 'reviews' => 1234, 'address' => 'Saket, New Delhi', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Cancer Care', 'Heart Surgery'], 'phone' => '+911126515050'],
        ['id' => 5, 'name' => 'AIIMS Delhi', 'category' => 'Government Hospital', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=500&h=350&fit=crop', 'rating' => 4.9, 'reviews' => 5678, 'address' => 'Ansari Nagar, New Delhi', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Research', 'Teaching', 'All Specialties'], 'phone' => '+911126588500'],
        ['id' => 6, 'name' => 'Medanta Hospital', 'category' => 'Multi-Specialty Hospital', 'city' => 'Gurgaon', 'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=500&h=350&fit=crop', 'rating' => 4.7, 'reviews' => 2134, 'address' => 'Sector 38, Gurgaon, Haryana', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Robotics Surgery', 'Liver Transplant'], 'phone' => '+911244141414']
    ],
    'hotels' => [
        ['id' => 1, 'name' => 'The Taj Mahal Palace', 'category' => '5 Star Luxury Hotel', 'city' => 'Mumbai', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&h=350&fit=crop', 'rating' => 4.9, 'reviews' => 3567, 'address' => 'Apollo Bunder, Colaba, Mumbai', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Sea View', 'Spa', 'Pool', 'Fine Dining'], 'phone' => '+912266653366'],
        ['id' => 2, 'name' => 'The Oberoi', 'category' => '5 Star Luxury Hotel', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=500&h=350&fit=crop', 'rating' => 4.8, 'reviews' => 2134, 'address' => 'Dr Zakir Hussain Marg, New Delhi', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Luxury Rooms', 'Restaurant', 'Bar'], 'phone' => '+911124363030'],
        ['id' => 3, 'name' => 'ITC Grand Chola', 'category' => '5 Star Luxury Hotel', 'city' => 'Chennai', 'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=500&h=350&fit=crop', 'rating' => 4.8, 'reviews' => 1876, 'address' => 'Mount Road, Guindy, Chennai', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Convention Center', 'Spa', 'Multiple Restaurants'], 'phone' => '+914422200000']
    ],
    'it-companies' => [
        ['id' => 1, 'name' => 'Tata Consultancy Services', 'category' => 'IT Services & Consulting', 'city' => 'Mumbai', 'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=500&h=350&fit=crop', 'rating' => 4.5, 'reviews' => 4523, 'address' => 'TCS House, Fort, Mumbai', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Fortune 500', 'Global', 'Consulting'], 'phone' => '+912267789999'],
        ['id' => 2, 'name' => 'Infosys Limited', 'category' => 'IT Services & Consulting', 'city' => 'Bangalore', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=500&h=350&fit=crop', 'rating' => 4.4, 'reviews' => 3876, 'address' => 'Electronics City, Bangalore', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Fortune 500', 'Software Development'], 'phone' => '+918028520261'],
        ['id' => 3, 'name' => 'Wipro Technologies', 'category' => 'IT Services', 'city' => 'Bangalore', 'image' => 'https://images.unsplash.com/photo-1554469384-e58fac16e23a?w=500&h=350&fit=crop', 'rating' => 4.3, 'reviews' => 2987, 'address' => 'Sarjapur Road, Bangalore', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Cloud Services', 'Digital Transformation'], 'phone' => '+918028440011']
    ],
    'restaurants' => [
        ['id' => 1, 'name' => 'Indian Accent', 'category' => 'Fine Dining', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=500&h=350&fit=crop', 'rating' => 4.9, 'reviews' => 2341, 'address' => 'The Lodhi, Lodhi Road, New Delhi', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Award Winning', 'Valet Parking', 'Bar'], 'phone' => '+911126255151'],
        ['id' => 2, 'name' => 'Bukhara', 'category' => 'North Indian', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500&h=350&fit=crop', 'rating' => 4.8, 'reviews' => 3456, 'address' => 'ITC Maurya, Sardar Patel Marg, Delhi', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Iconic Restaurant', 'Kebabs', 'Dal Bukhara'], 'phone' => '+911126112233']
    ],
    'education' => [
        ['id' => 1, 'name' => 'IIT Delhi', 'category' => 'Engineering Institute', 'city' => 'Delhi', 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=500&h=350&fit=crop', 'rating' => 4.9, 'reviews' => 5678, 'address' => 'Hauz Khas, New Delhi', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Top Ranked', 'Research', 'NIRF #1'], 'phone' => '+911126591999'],
        ['id' => 2, 'name' => 'IIM Ahmedabad', 'category' => 'Management Institute', 'city' => 'Ahmedabad', 'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&h=350&fit=crop', 'rating' => 4.9, 'reviews' => 4321, 'address' => 'Vastrapur, Ahmedabad', 'is_verified' => true, 'is_featured' => true, 'is_open' => true, 'features' => ['Top MBA', 'Case Study Method'], 'phone' => '+917966324000']
    ]
];

// Get data for category
$data = $sample_data[$category] ?? $sample_data['hospitals'];

// Filter by city
if (!empty($city)) {
    $data = array_filter($data, function($item) use ($city) {
        return strtolower($item['city']) === strtolower($city);
    });
    $data = array_values($data);
}

// Filter by rating
if (!empty($rating)) {
    $data = array_filter($data, function($item) use ($rating) {
        return $item['rating'] >= floatval($rating);
    });
    $data = array_values($data);
}

// Filter by tab
switch ($tab) {
    case 'top-rated':
        $data = array_filter($data, fn($item) => $item['rating'] >= 4.5);
        break;
    case 'verified':
        $data = array_filter($data, fn($item) => $item['is_verified']);
        break;
    case 'featured':
        $data = array_filter($data, fn($item) => $item['is_featured']);
        break;
}
$data = array_values($data);

// Sort
switch ($sort) {
    case 'rating':
        usort($data, fn($a, $b) => $b['rating'] <=> $a['rating']);
        break;
    case 'reviews':
        usort($data, fn($a, $b) => $b['reviews'] <=> $a['reviews']);
        break;
    case 'name':
        usort($data, fn($a, $b) => strcmp($a['name'], $b['name']));
        break;
    case 'newest':
        $data = array_reverse($data);
        break;
}

// Duplicate for pagination demo
$extended_data = [];
for ($i = 0; $i < 5; $i++) {
    foreach ($data as $idx => $item) {
        $new_item = $item;
        $new_item['id'] = $item['id'] + ($i * 100);
        if ($i > 0) {
            $new_item['name'] = $item['name'] . ' - Branch ' . ($i + 1);
        }
        $extended_data[] = $new_item;
    }
}

$total = count($extended_data);
$total_pages = ceil($total / $per_page);

// Paginate
$offset = ($page - 1) * $per_page;
$paginated_data = array_slice($extended_data, $offset, $per_page);

// Response
$response = [
    'success' => true,
    'data' => [
        'listings' => $paginated_data,
        'pagination' => [
            'current_page' => $page,
            'per_page' => $per_page,
            'total' => $total,
            'total_pages' => $total_pages
        ]
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT);
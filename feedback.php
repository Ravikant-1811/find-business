<?php include_once 'app-detect.php'; ?>

<?php
// ============================================
// DIALIKIYA - FEEDBACK PAGE
// Database: directory | Table: feedbacks
// ============================================

// Database Configuration
$DB_HOST = 'localhost';
$DB_NAME = 'u792021313_directory';
$DB_USER = 'u792021313_directory';
$DB_PASS = 'Directory@2025';

// Upload Configuration
$UPLOAD_DIR = 'uploads/feedback/';
$ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
$MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// Create upload directory if not exists
if (!file_exists($UPLOAD_DIR)) {
    mkdir($UPLOAD_DIR, 0755, true);
}

// Database Connection
function getDBConnection() {
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;
    
    try {
        $pdo = new PDO(
            "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
            $DB_USER,
            $DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        return null;
    }
}

// Create Table if not exists
function createFeedbackTable() {
    $pdo = getDBConnection();
    if (!$pdo) return false;
    
    $sql = "CREATE TABLE IF NOT EXISTS `feedbacks` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(100) DEFAULT NULL,
        `email` VARCHAR(150) DEFAULT NULL,
        `mobile` VARCHAR(20) DEFAULT NULL,
        `feedback_type` VARCHAR(50) NOT NULL,
        `subject` VARCHAR(255) NOT NULL,
        `message` TEXT NOT NULL,
        `business_name` VARCHAR(200) DEFAULT NULL,
        `listing_url` VARCHAR(500) DEFAULT NULL,
        `attachment` VARCHAR(255) DEFAULT NULL,
        `ip_address` VARCHAR(45) DEFAULT NULL,
        `user_agent` TEXT DEFAULT NULL,
        `status` ENUM('pending', 'reviewed', 'resolved') DEFAULT 'pending',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        INDEX `idx_feedback_type` (`feedback_type`),
        INDEX `idx_status` (`status`),
        INDEX `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    try {
        $pdo->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Initialize table
createFeedbackTable();

// Handle AJAX Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    
    $response = ['success' => false, 'message' => '', 'errors' => []];
    
    try {
        // Get and sanitize inputs
        $name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
        $email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
        $mobile = isset($_POST['mobile']) ? trim(preg_replace('/[^0-9+\-\s]/', '', $_POST['mobile'])) : '';
        $feedback_type = isset($_POST['feedback_type']) ? trim(htmlspecialchars($_POST['feedback_type'])) : '';
        $subject = isset($_POST['subject']) ? trim(htmlspecialchars($_POST['subject'])) : '';
        $message = isset($_POST['message']) ? trim(htmlspecialchars($_POST['message'])) : '';
        $business_name = isset($_POST['business_name']) ? trim(htmlspecialchars($_POST['business_name'])) : '';
        $listing_url = isset($_POST['listing_url']) ? trim(filter_var($_POST['listing_url'], FILTER_SANITIZE_URL)) : '';
        $consent = isset($_POST['consent']) ? true : false;
        
        // Validation
        $errors = [];
        
        // Validate email if provided
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        
        // Validate mobile if provided
        if (!empty($mobile) && strlen(preg_replace('/[^0-9]/', '', $mobile)) < 10) {
            $errors['mobile'] = 'Please enter a valid mobile number';
        }
        
        // Required fields
        if (empty($feedback_type)) {
            $errors['feedback_type'] = 'Please select feedback type';
        }
        
        if (empty($subject)) {
            $errors['subject'] = 'Subject is required';
        } elseif (strlen($subject) < 5) {
            $errors['subject'] = 'Subject must be at least 5 characters';
        }
        
        if (empty($message)) {
            $errors['message'] = 'Feedback message is required';
        } elseif (strlen($message) < 20) {
            $errors['message'] = 'Message must be at least 20 characters';
        }
        
        // Validate URL if provided
        if (!empty($listing_url) && !filter_var($listing_url, FILTER_VALIDATE_URL)) {
            $errors['listing_url'] = 'Please enter a valid URL';
        }
        
        // Consent check
        if (!$consent) {
            $errors['consent'] = 'Please confirm the information is accurate';
        }
        
        // Handle file upload
        $attachment = '';
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['attachment'];
            
            // Check file size
            if ($file['size'] > $MAX_FILE_SIZE) {
                $errors['attachment'] = 'File size must be less than 5MB';
            }
            
            // Check file type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $ALLOWED_TYPES)) {
                $errors['attachment'] = 'Only JPG, PNG, GIF, and PDF files are allowed';
            }
            
            if (empty($errors['attachment'])) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'feedback_' . time() . '_' . uniqid() . '.' . $ext;
                $filepath = $UPLOAD_DIR . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $attachment = $filename;
                } else {
                    $errors['attachment'] = 'Failed to upload file';
                }
            }
        }
        
        // If validation errors, return them
        if (!empty($errors)) {
            $response['errors'] = $errors;
            $response['message'] = 'Please fix the errors below';
            echo json_encode($response);
            exit;
        }
        
        // Database insert
        $pdo = getDBConnection();
        if (!$pdo) {
            throw new Exception('Database connection failed');
        }
        
        $sql = "INSERT INTO feedbacks (name, email, mobile, feedback_type, subject, message, business_name, listing_url, attachment, ip_address, user_agent) 
                VALUES (:name, :email, :mobile, :feedback_type, :subject, :message, :business_name, :listing_url, :attachment, :ip_address, :user_agent)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name ?: null,
            ':email' => $email ?: null,
            ':mobile' => $mobile ?: null,
            ':feedback_type' => $feedback_type,
            ':subject' => $subject,
            ':message' => $message,
            ':business_name' => $business_name ?: null,
            ':listing_url' => $listing_url ?: null,
            ':attachment' => $attachment ?: null,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
        
        $response['success'] = true;
        $response['message'] = 'Thank you for your feedback! Our team will review it shortly.';
        
    } catch (Exception $e) {
        $response['message'] = 'An error occurred. Please try again later.';
        error_log('Feedback Error: ' . $e->getMessage());
    }
    
    echo json_encode($response);
    exit;
}

$pageTitle = "Feedback - Share Your Experience | Find Business";
$pageDescription = "Help us improve Find Business by sharing your feedback, suggestions, or reporting issues. We value your input!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="feedback, suggestions, report issue, Find Business, contact">
    <meta name="author" content="Find Business">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#FF6B35">
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    <meta property="og:type" content="website">
    <title><?php echo $pageTitle; ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="photos/d-logo-url.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #E85A2A;
            --primary-light: #FF8C5A;
            --primary-bg: rgba(255, 107, 53, 0.08);
            --success: #10B981;
            --success-bg: rgba(16, 185, 129, 0.1);
            --danger: #EF4444;
            --danger-bg: rgba(239, 68, 68, 0.1);
            --warning: #F59E0B;
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
            --white: #FFFFFF;
            --radius: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        
        /* ==========================================
           HEADER
           ========================================== */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gray-200);
            transition: box-shadow 0.3s;
        }
        
        .header.scrolled {
            box-shadow: var(--shadow-md);
        }
        
        .header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: var(--gray-900);
        }
        
        .logo-text span {
            color: var(--primary);
        }
        
        .nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nav-link {
            padding: 10px 18px;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-radius: var(--radius);
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            color: var(--gray-900);
            background: var(--gray-100);
        }
        
        .nav-link.active {
            color: var(--primary);
            background: var(--primary-bg);
        }
        
        .mobile-toggle {
            display: none;
            width: 44px;
            height: 44px;
            background: var(--gray-100);
            border: none;
            border-radius: var(--radius-md);
            font-size: 20px;
            color: var(--gray-700);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        
        /* ==========================================
           HERO SECTION - GRAY THEME
           ========================================== */
        .hero {
            padding-top: 72px;
            background: linear-gradient(165deg, 
                #353333ff 0%, 
                #383a3bff 15%, 
                #2e2e2fff 35%, 
                #313232ff 60%, 
                #242424ff 100%
            );
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.02;
            pointer-events: none;
        }
        
        .hero-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }
        
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            pointer-events: none;
        }
        
        .hero-orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.15), rgba(255, 140, 90, 0.08));
            top: -100px;
            right: -50px;
        }
        
        .hero-orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.05));
            bottom: -50px;
            left: -50px;
        }
        
        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 24px 120px;
            position: relative;
            z-index: 2;
            text-align: center;
        }
        
        .hero-icon {
            width: 80px;
            height: 80px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: var(--shadow-lg);
            animation: bounce 2s ease infinite;
        }
        
        .hero-icon i {
            font-size: 36px;
            color: var(--primary);
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .hero-title {
            font-size: 48px;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1.2;
            letter-spacing: -1.5px;
            margin-bottom: 18px;
            animation: fadeInUp 0.6s ease;
        }
        
        .hero-title .highlight {
            color: var(--primary);
            position: relative;
        }
        
        .hero-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
            animation: fadeInUp 0.6s ease 0.1s both;
        }
        
        /* Rounded bottom */
        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--gray-50);
            border-radius: 60px 60px 0 0;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* ==========================================
           MAIN CONTENT
           ========================================== */
        .main {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 24px;
            margin-top: -60px;
            position: relative;
            z-index: 10;
            padding-bottom: 80px;
        }
        
        /* ==========================================
           FEEDBACK FORM CARD
           ========================================== */
        .form-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 48px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 32px;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .form-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }
        
        .form-header p {
            font-size: 15px;
            color: var(--gray-500);
        }
        
        /* Form Sections */
        .form-section {
            margin-bottom: 36px;
        }
        
        .form-section:last-child {
            margin-bottom: 0;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .section-title-icon {
            width: 36px;
            height: 36px;
            background: var(--primary-bg);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 14px;
        }
        
        .section-title h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-800);
        }
        
        .section-title span {
            font-size: 12px;
            color: var(--gray-400);
            font-weight: 400;
        }
        
        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .form-grid.single {
            grid-template-columns: 1fr;
        }
        
        /* Form Group */
        .form-group {
            position: relative;
        }
        
        .form-group.full {
            grid-column: 1 / -1;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 8px;
        }
        
        .form-label .required {
            color: var(--danger);
            margin-left: 2px;
        }
        
        .form-label .optional {
            color: var(--gray-400);
            font-weight: 400;
            font-size: 12px;
            margin-left: 4px;
        }
        
        /* Input Styles */
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 14px 18px;
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 15px;
            font-family: inherit;
            color: var(--gray-800);
            transition: all 0.2s;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }
        
        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--gray-400);
        }
        
        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: var(--danger);
            background: var(--danger-bg);
        }
        
        .form-input.success,
        .form-select.success,
        .form-textarea.success {
            border-color: var(--success);
        }
        
        /* Select */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 50px;
            cursor: pointer;
        }
        
        /* Textarea */
        .form-textarea {
            min-height: 140px;
            resize: vertical;
            line-height: 1.6;
        }
        
        /* Error Message */
        .error-message {
            display: none;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 13px;
            color: var(--danger);
        }
        
        .error-message i {
            font-size: 12px;
        }
        
        .error-message.show {
            display: flex;
        }
        
        /* Character Count */
        .char-count {
            text-align: right;
            font-size: 12px;
            color: var(--gray-400);
            margin-top: 6px;
        }
        
        /* File Upload */
        .file-upload {
            position: relative;
        }
        
        .file-upload-area {
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-md);
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--gray-50);
        }
        
        .file-upload-area:hover {
            border-color: var(--primary);
            background: var(--primary-bg);
        }
        
        .file-upload-area.dragover {
            border-color: var(--primary);
            background: var(--primary-bg);
        }
        
        .file-upload-area.has-file {
            border-color: var(--success);
            background: var(--success-bg);
        }
        
        .file-upload-icon {
            width: 56px;
            height: 56px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: var(--shadow);
        }
        
        .file-upload-icon i {
            font-size: 24px;
            color: var(--primary);
        }
        
        .file-upload-text h4 {
            font-size: 15px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 6px;
        }
        
        .file-upload-text p {
            font-size: 13px;
            color: var(--gray-500);
        }
        
        .file-upload-text .browse {
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-preview {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: var(--gray-50);
            border-radius: var(--radius);
            margin-top: 12px;
        }
        
        .file-preview.show {
            display: flex;
        }
        
        .file-preview-icon {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 18px;
        }
        
        .file-preview-info {
            flex: 1;
        }
        
        .file-preview-info h5 {
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-800);
            margin-bottom: 2px;
        }
        
        .file-preview-info p {
            font-size: 12px;
            color: var(--gray-500);
        }
        
        .file-preview-remove {
            width: 32px;
            height: 32px;
            background: var(--danger-bg);
            border: none;
            border-radius: 50%;
            color: var(--danger);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .file-preview-remove:hover {
            background: var(--danger);
            color: var(--white);
        }
        
        /* Checkbox */
        .form-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
        }
        
        .form-checkbox input {
            display: none;
        }
        
        .checkbox-custom {
            width: 22px;
            height: 22px;
            min-width: 22px;
            background: var(--gray-100);
            border: 2px solid var(--gray-300);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            margin-top: 2px;
        }
        
        .checkbox-custom i {
            font-size: 12px;
            color: var(--white);
            opacity: 0;
            transform: scale(0);
            transition: all 0.2s;
        }
        
        .form-checkbox input:checked + .checkbox-custom {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .form-checkbox input:checked + .checkbox-custom i {
            opacity: 1;
            transform: scale(1);
        }
        
        .checkbox-label {
            font-size: 14px;
            color: var(--gray-600);
            line-height: 1.5;
        }
        
        .checkbox-label a {
            color: var(--primary);
            text-decoration: none;
        }
        
        /* Submit Button */
        .form-submit {
            margin-top: 36px;
            padding-top: 32px;
            border-top: 1px solid var(--gray-200);
        }
        
        .submit-btn {
            width: 100%;
            padding: 18px 32px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: var(--radius-md);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.35);
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 107, 53, 0.45);
        }
        
        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .submit-btn .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        .submit-btn.loading .spinner {
            display: block;
        }
        
        .submit-btn.loading .btn-text {
            display: none;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* ==========================================
           SUCCESS MESSAGE
           ========================================== */
        .success-message {
            display: none;
            text-align: center;
            padding: 60px 40px;
        }
        
        .success-message.show {
            display: block;
            animation: fadeInUp 0.5s ease;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: var(--success-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            animation: scaleIn 0.5s ease;
        }
        
        .success-icon i {
            font-size: 48px;
            color: var(--success);
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        
        .success-message h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 12px;
        }
        
        .success-message p {
            font-size: 16px;
            color: var(--gray-600);
            margin-bottom: 32px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .success-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .success-btn {
            padding: 14px 28px;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .success-btn-primary {
            background: var(--primary);
            border: none;
            color: var(--white);
        }
        
        .success-btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .success-btn-secondary {
            background: var(--white);
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }
        
        .success-btn-secondary:hover {
            border-color: var(--gray-400);
            background: var(--gray-50);
        }
        
        /* ==========================================
           MOBILE MENU
           ========================================== */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .mobile-menu.active {
            opacity: 1;
            visibility: visible;
        }
        
        .mobile-menu-content {
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            max-width: 85%;
            height: 100%;
            background: var(--white);
            padding: 28px;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s;
        }
        
        .mobile-menu.active .mobile-menu-content {
            transform: translateX(0);
        }
        
        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }
        
        .mobile-close {
            width: 44px;
            height: 44px;
            background: var(--gray-100);
            border: none;
            border-radius: var(--radius-md);
            font-size: 20px;
            color: var(--gray-600);
            cursor: pointer;
        }
        
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 18px;
            color: var(--gray-700);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            border-radius: var(--radius-md);
            margin-bottom: 6px;
            transition: all 0.2s;
        }
        
        .mobile-nav-link:hover {
            background: var(--gray-100);
            color: var(--primary);
        }
        
        .mobile-nav-link i {
            width: 24px;
            text-align: center;
        }
        
        /* ==========================================
           RESPONSIVE
           ========================================== */
        @media (max-width: 1024px) {
            .nav {
                display: none;
            }
            
            .mobile-toggle {
                display: flex;
            }
        }
        
        @media (max-width: 768px) {
            .header-inner {
                height: 68px;
            }
            
            .hero {
                padding-top: 68px;
            }
            
            .hero-container {
                padding: 60px 20px 100px;
            }
            
            .hero-title {
                font-size: 32px;
            }
            
            .hero-subtitle {
                font-size: 16px;
            }
            
            .main {
                margin-top: -50px;
            }
            
            .form-card {
                padding: 32px 24px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-inner {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .hero-title {
                font-size: 28px;
            }
            
            .hero-icon {
                width: 70px;
                height: 70px;
            }
            
            .hero-icon i {
                font-size: 30px;
            }
            
            .form-card {
                padding: 24px 20px;
            }
            
            .file-upload-area {
                padding: 24px;
            }
            
            .success-actions {
                flex-direction: column;
            }
            
            .success-btn {
                width: 100%;
                justify-content: center;
            }
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
    <!-- Header -->
    <?php include 'header.php';?>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        
        <div class="hero-container">
            <div class="hero-icon">
                <i class="fas fa-comment-dots"></i>
            </div>
            
            <h1 class="hero-title">
                We Value Your <span class="highlight">Feedback</span>
            </h1>
            
            <p class="hero-subtitle">
                Help us improve Find Business by sharing your experience, suggestions, or issues. Your feedback matters to us!
            </p>
        </div>
    </section>
    
    <!-- Main Content -->
    <main class="main">
        <div class="form-card">
            <!-- Form -->
            <form id="feedbackForm" enctype="multipart/form-data">
                <div class="form-header">
                    <h2>Submit Your Feedback</h2>
                    <p>Fill out the form below and we'll get back to you soon</p>
                </div>
                
                <!-- Section 1: Basic Details -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-title-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Your Details <span>(Optional)</span></h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Full Name <span class="optional">(Optional)</span>
                            </label>
                            <input type="text" name="name" class="form-input" placeholder="Enter your name" maxlength="100">
                            <div class="error-message" id="error-name">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Email Address <span class="optional">(Optional)</span>
                            </label>
                            <input type="email" name="email" class="form-input" placeholder="your@email.com" maxlength="150">
                            <div class="error-message" id="error-email">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Mobile Number <span class="optional">(Optional)</span>
                            </label>
                            <input type="tel" name="mobile" class="form-input" placeholder="+91 98765 43210" maxlength="20">
                            <div class="error-message" id="error-mobile">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section 2: Feedback Details -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-title-icon">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <h3>Feedback Details</h3>
                    </div>
                    
                    <div class="form-grid single">
                        <div class="form-group">
                            <label class="form-label">
                                Type of Feedback <span class="required">*</span>
                            </label>
                            <select name="feedback_type" class="form-select" required>
                                <option value="">Select feedback type</option>
                                <option value="general">General Feedback</option>
                                <option value="suggestion">Suggestion / Improvement</option>
                                <option value="issue">Report an Issue</option>
                                <option value="incorrect_info">Incorrect Business Information</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="error-message" id="error-feedback_type">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Subject <span class="required">*</span>
                            </label>
                            <input type="text" name="subject" class="form-input" placeholder="Brief subject of your feedback" maxlength="255" required>
                            <div class="error-message" id="error-subject">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Your Feedback <span class="required">*</span>
                            </label>
                            <textarea name="message" class="form-textarea" placeholder="Please describe your feedback, suggestion, or issue in detail..." maxlength="5000" required></textarea>
                            <div class="char-count"><span id="charCount">0</span> / 5000 characters</div>
                            <div class="error-message" id="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section 3: Additional Info -->
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-title-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h3>Additional Information <span>(Optional)</span></h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Business Name <span class="optional">(If applicable)</span>
                            </label>
                            <input type="text" name="business_name" class="form-input" placeholder="Name of the business" maxlength="200">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Listing URL <span class="optional">(Optional)</span>
                            </label>
                            <input type="url" name="listing_url" class="form-input" placeholder="https://find-business.com/business/...">
                            <div class="error-message" id="error-listing_url">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="form-group full">
                            <label class="form-label">
                                Upload Screenshot <span class="optional">(Optional)</span>
                            </label>
                            <div class="file-upload">
                                <div class="file-upload-area" id="fileUploadArea">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">
                                        <h4>Drag & drop file here or <span class="browse">browse</span></h4>
                                        <p>Supported: JPG, PNG, GIF, PDF (Max 5MB)</p>
                                    </div>
                                </div>
                                <input type="file" name="attachment" id="fileInput" accept=".jpg,.jpeg,.png,.gif,.pdf">
                                
                                <div class="file-preview" id="filePreview">
                                    <div class="file-preview-icon">
                                        <i class="fas fa-file-image"></i>
                                    </div>
                                    <div class="file-preview-info">
                                        <h5 id="fileName">filename.jpg</h5>
                                        <p id="fileSize">2.5 MB</p>
                                    </div>
                                    <button type="button" class="file-preview-remove" id="fileRemove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="error-message" id="error-attachment">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Consent -->
                <div class="form-section">
                    <label class="form-checkbox">
                        <input type="checkbox" name="consent" id="consentCheck" required>
                        <span class="checkbox-custom">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="checkbox-label">
                            I confirm that the information provided is accurate and I agree to the 
                            <a href="privacy.php" target="_blank">Privacy Policy</a> and 
                            <a href="terms.php" target="_blank">Terms of Service</a>.
                        </span>
                    </label>
                    <div class="error-message" id="error-consent" style="margin-left: 34px;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="form-submit">
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span class="btn-text">
                            <i class="fas fa-paper-plane"></i>
                            Submit Feedback
                        </span>
                        <div class="spinner"></div>
                    </button>
                </div>
            </form>
            
            <!-- Success Message -->
            <div class="success-message" id="successMessage">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h3>Thank You!</h3>
                <p>Your feedback has been submitted successfully. Our team will review it shortly.</p>
                <div class="success-actions">
                    <a href="index.php" class="success-btn success-btn-primary">
                        <i class="fas fa-home"></i>
                        Back to Home
                    </a>
                    <button type="button" class="success-btn success-btn-secondary" id="newFeedbackBtn">
                        <i class="fas fa-plus"></i>
                        Submit Another
                    </button>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <?php include 'footer.php';?>
    
    <script>
    (function() {
        'use strict';
        
        // ==========================================
        // DOM ELEMENTS
        // ==========================================
        const form = document.getElementById('feedbackForm');
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');
        const newFeedbackBtn = document.getElementById('newFeedbackBtn');
        const fileInput = document.getElementById('fileInput');
        const fileUploadArea = document.getElementById('fileUploadArea');
        const filePreview = document.getElementById('filePreview');
        const fileRemove = document.getElementById('fileRemove');
        const messageTextarea = document.querySelector('textarea[name="message"]');
        const charCount = document.getElementById('charCount');
        const header = document.getElementById('header');
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileClose = document.getElementById('mobileClose');
        
        // ==========================================
        // INITIALIZE
        // ==========================================
        function init() {
            bindEvents();
        }
        
        // ==========================================
        // EVENT BINDINGS
        // ==========================================
        function bindEvents() {
            // Form submit
            form.addEventListener('submit', handleSubmit);
            
            // Character count
            messageTextarea.addEventListener('input', updateCharCount);
            
            // File upload
            fileInput.addEventListener('change', handleFileSelect);
            fileRemove.addEventListener('click', removeFile);
            
            // Drag and drop
            fileUploadArea.addEventListener('dragover', handleDragOver);
            fileUploadArea.addEventListener('dragleave', handleDragLeave);
            fileUploadArea.addEventListener('drop', handleDrop);
            
            // New feedback button
            newFeedbackBtn.addEventListener('click', resetForm);
            
            // Header scroll
            window.addEventListener('scroll', () => {
                header.classList.toggle('scrolled', window.scrollY > 50);
            });
            
            // Mobile menu
            mobileToggle.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            mobileClose.addEventListener('click', closeMobileMenu);
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) closeMobileMenu();
            });
            
            // Real-time validation on blur
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', () => validateField(input));
                input.addEventListener('input', () => clearError(input.name));
            });
        }
        
        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // ==========================================
        // CHARACTER COUNT
        // ==========================================
        function updateCharCount() {
            const count = messageTextarea.value.length;
            charCount.textContent = count;
        }
        
        // ==========================================
        // FILE HANDLING
        // ==========================================
        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                displayFilePreview(file);
            }
        }
        
        function handleDragOver(e) {
            e.preventDefault();
            fileUploadArea.classList.add('dragover');
        }
        
        function handleDragLeave(e) {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
        }
        
        function handleDrop(e) {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
            
            const file = e.dataTransfer.files[0];
            if (file) {
                fileInput.files = e.dataTransfer.files;
                displayFilePreview(file);
            }
        }
        
        function displayFilePreview(file) {
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const previewIcon = filePreview.querySelector('.file-preview-icon i');
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            // Update icon based on file type
            if (file.type === 'application/pdf') {
                previewIcon.className = 'fas fa-file-pdf';
            } else {
                previewIcon.className = 'fas fa-file-image';
            }
            
            fileUploadArea.classList.add('has-file');
            filePreview.classList.add('show');
            clearError('attachment');
        }
        
        function removeFile() {
            fileInput.value = '';
            fileUploadArea.classList.remove('has-file');
            filePreview.classList.remove('show');
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // ==========================================
        // VALIDATION
        // ==========================================
        function validateField(field) {
            const name = field.name;
            const value = field.value.trim();
            
            // Clear previous error
            clearError(name);
            
            // Validate based on field
            switch (name) {
                case 'email':
                    if (value && !isValidEmail(value)) {
                        showError(name, 'Please enter a valid email address');
                        return false;
                    }
                    break;
                    
                case 'mobile':
                    if (value && value.replace(/[^0-9]/g, '').length < 10) {
                        showError(name, 'Please enter a valid mobile number');
                        return false;
                    }
                    break;
                    
                case 'feedback_type':
                    if (!value) {
                        showError(name, 'Please select feedback type');
                        return false;
                    }
                    break;
                    
                case 'subject':
                    if (!value) {
                        showError(name, 'Subject is required');
                        return false;
                    } else if (value.length < 5) {
                        showError(name, 'Subject must be at least 5 characters');
                        return false;
                    }
                    break;
                    
                case 'message':
                    if (!value) {
                        showError(name, 'Feedback message is required');
                        return false;
                    } else if (value.length < 20) {
                        showError(name, 'Message must be at least 20 characters');
                        return false;
                    }
                    break;
                    
                case 'listing_url':
                    if (value && !isValidUrl(value)) {
                        showError(name, 'Please enter a valid URL');
                        return false;
                    }
                    break;
            }
            
            // Mark as valid
            if (value) {
                field.classList.add('success');
            }
            
            return true;
        }
        
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
        
        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch {
                return false;
            }
        }
        
        function showError(fieldName, message) {
            const errorDiv = document.getElementById('error-' + fieldName);
            const input = form.querySelector(`[name="${fieldName}"]`);
            
            if (errorDiv) {
                errorDiv.querySelector('span').textContent = message;
                errorDiv.classList.add('show');
            }
            
            if (input) {
                input.classList.add('error');
                input.classList.remove('success');
            }
        }
        
        function clearError(fieldName) {
            const errorDiv = document.getElementById('error-' + fieldName);
            const input = form.querySelector(`[name="${fieldName}"]`);
            
            if (errorDiv) {
                errorDiv.classList.remove('show');
            }
            
            if (input) {
                input.classList.remove('error');
            }
        }
        
        function clearAllErrors() {
            const errors = form.querySelectorAll('.error-message');
            errors.forEach(error => error.classList.remove('show'));
            
            const inputs = form.querySelectorAll('.error, .success');
            inputs.forEach(input => {
                input.classList.remove('error', 'success');
            });
        }
        
        // ==========================================
        // FORM SUBMISSION
        // ==========================================
        async function handleSubmit(e) {
            e.preventDefault();
            
            // Clear all errors
            clearAllErrors();
            
            // Validate all required fields
            let isValid = true;
            const requiredFields = ['feedback_type', 'subject', 'message'];
            
            requiredFields.forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                if (!validateField(field)) {
                    isValid = false;
                }
            });
            
            // Validate optional fields if filled
            const optionalFields = ['email', 'mobile', 'listing_url'];
            optionalFields.forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                if (field.value.trim() && !validateField(field)) {
                    isValid = false;
                }
            });
            
            // Check consent
            const consent = document.getElementById('consentCheck');
            if (!consent.checked) {
                showError('consent', 'Please confirm the information is accurate');
                isValid = false;
            }
            
            if (!isValid) {
                // Scroll to first error
                const firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                formData.append('ajax', '1');
                
                const response = await fetch('feedback.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    form.style.display = 'none';
                    successMessage.classList.add('show');
                    
                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    // Show errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError(field, data.errors[field]);
                        });
                        
                        // Scroll to first error
                        const firstError = form.querySelector('.error');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Submit error:', error);
                alert('An error occurred. Please check your connection and try again.');
            } finally {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        }
        
        // ==========================================
        // RESET FORM
        // ==========================================
        function resetForm() {
            form.reset();
            clearAllErrors();
            removeFile();
            updateCharCount();
            
            form.style.display = 'block';
            successMessage.classList.remove('show');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        // ==========================================
        // START
        // ==========================================
        init();
    })();
    </script>
</body>
</html>
<?php
header('Content-Type: application/json');

// Database
$conn = new mysqli("localhost", "u792021313_directory", "Directory@2025", "u792021313_directory");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'errors' => ['Database connection failed']]);
    exit;
}
$conn->set_charset("utf8mb4");

// Check POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'errors' => ['Invalid request method']]);
    exit;
}

// Get data
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$business_name = trim($_POST['business_name'] ?? '');
$category = trim($_POST['category'] ?? '');
$business_place = trim($_POST['business_place'] ?? '');
$city = trim($_POST['city'] ?? '');
$state = trim($_POST['state'] ?? '');
$pincode = trim($_POST['pincode'] ?? '');
$website = trim($_POST['website'] ?? '');

// Check if data received
if (empty($full_name)) {
    echo json_encode(['status' => 'error', 'errors' => ['Please fill all required fields']]);
    exit;
}

// Validation
$errors = [];
if (strlen($full_name) < 3) $errors[] = "Full name must be at least 3 characters";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email";
if (strlen($phone) < 10) $errors[] = "Please enter a valid phone number";
if (strlen($business_name) < 2) $errors[] = "Business name is required";
if (empty($category)) $errors[] = "Please select a category";
if (empty($business_place)) $errors[] = "Business address is required";
if (empty($city)) $errors[] = "City is required";
if (empty($state)) $errors[] = "Please select a state";
if (!preg_match('/^[0-9]{6}$/', $pincode)) $errors[] = "Please enter a valid 6-digit pincode";

// Check duplicate
if (empty($errors)) {
    $stmt = $conn->prepare("SELECT id FROM businesses WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This email is already registered";
    }
    $stmt->close();
}

if (!empty($errors)) {
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit;
}

// Insert
$stmt = $conn->prepare("INSERT INTO businesses (full_name, email, phone, business_name, category, business_place, city, state, pincode, website, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
$stmt->bind_param("ssssssssss", $full_name, $email, $phone, $business_name, $category, $business_place, $city, $state, $pincode, $website);

if ($stmt->execute()) {
    $id = $stmt->insert_id;
    $ref = 'BD' . str_pad($id, 6, '0', STR_PAD_LEFT);
    $date = date('d M Y, h:i A');
    
    // Send Admin Email
    sendAdminEmail($ref, $full_name, $email, $phone, $business_name, $category, $business_place, $city, $state, $pincode, $website, $date);
    
    // Send User Email
    sendUserEmail($ref, $full_name, $email, $business_name, $category, $city, $state);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Business submitted successfully!',
        'business_id' => $id,
        'reference' => $ref
    ]);
} else {
    echo json_encode(['status' => 'error', 'errors' => ['Failed to save. Please try again.']]);
}

$stmt->close();
$conn->close();

// =============================================
// ADMIN EMAIL - Professional Dashboard Style
// =============================================
function sendAdminEmail($ref, $full_name, $email, $phone, $business_name, $category, $business_place, $city, $state, $pincode, $website, $date) {
    
    $to = "info@mohphrettechnologies.com";
    $subject = "🆕 New Business Listing: $business_name [$ref]";
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, sans-serif; background-color: #f0f4f8;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0f4f8; padding: 40px 20px;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.1);">
                        
                        <!-- Header -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                                <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700;">
                                    🏢 New Business Submission
                                </h1>
                                <p style="color: rgba(255,255,255,0.9); margin: 15px 0 0; font-size: 16px;">
                                    A new business listing requires your review
                                </p>
                                <div style="background: rgba(255,255,255,0.2); display: inline-block; padding: 10px 25px; border-radius: 50px; margin-top: 20px;">
                                    <span style="color: #ffffff; font-size: 18px; font-weight: 600;">Reference: '.$ref.'</span>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Quick Stats -->
                        <tr>
                            <td style="padding: 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50%" style="padding: 10px;">
                                            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; border-radius: 12px; text-align: center;">
                                                <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Status</p>
                                                <p style="color: #ffffff; margin: 8px 0 0; font-size: 18px; font-weight: 700;">⏳ Pending Review</p>
                                            </div>
                                        </td>
                                        <td width="50%" style="padding: 10px;">
                                            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 20px; border-radius: 12px; text-align: center;">
                                                <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Submitted</p>
                                                <p style="color: #ffffff; margin: 8px 0 0; font-size: 18px; font-weight: 700;">📅 '.date('d M Y').'</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Business Details -->
                        <tr>
                            <td style="padding: 0 30px 30px;">
                                <div style="background: #f8fafc; border-radius: 12px; padding: 25px; border-left: 4px solid #667eea;">
                                    <h2 style="color: #1e293b; margin: 0 0 20px; font-size: 18px; display: flex; align-items: center;">
                                        <span style="background: #667eea; color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;">🏪</span>
                                        Business Information
                                    </h2>
                                    
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                                <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Business Name</span><br>
                                                <span style="color: #1e293b; font-size: 16px; font-weight: 600;">'.$business_name.'</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                                <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Category</span><br>
                                                <span style="background: #ddd6fe; color: #7c3aed; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500; display: inline-block; margin-top: 5px;">'.$category.'</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                                <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Address</span><br>
                                                <span style="color: #1e293b; font-size: 15px;">'.$business_place.'</span><br>
                                                <span style="color: #64748b; font-size: 14px;">'.$city.', '.$state.' - '.$pincode.'</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px 0;">
                                                <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Website</span><br>
                                                <span style="color: #667eea; font-size: 15px;">'.($website ? '<a href="'.$website.'" style="color: #667eea;">'.$website.'</a>' : '<em style="color: #94a3b8;">Not provided</em>').'</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Contact Person -->
                        <tr>
                            <td style="padding: 0 30px 30px;">
                                <div style="background: #f0fdf4; border-radius: 12px; padding: 25px; border-left: 4px solid #10b981;">
                                    <h2 style="color: #1e293b; margin: 0 0 20px; font-size: 18px;">
                                        <span style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;">👤</span>
                                        Contact Person
                                    </h2>
                                    
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="33%" style="padding: 10px; text-align: center;">
                                                <div style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                                    <p style="color: #64748b; margin: 0 0 5px; font-size: 12px;">NAME</p>
                                                    <p style="color: #1e293b; margin: 0; font-weight: 600; font-size: 14px;">'.$full_name.'</p>
                                                </div>
                                            </td>
                                            <td width="33%" style="padding: 10px; text-align: center;">
                                                <div style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                                    <p style="color: #64748b; margin: 0 0 5px; font-size: 12px;">EMAIL</p>
                                                    <p style="color: #1e293b; margin: 0; font-weight: 600; font-size: 14px;"><a href="mailto:'.$email.'" style="color: #667eea; text-decoration: none;">'.$email.'</a></p>
                                                </div>
                                            </td>
                                            <td width="33%" style="padding: 10px; text-align: center;">
                                                <div style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                                    <p style="color: #64748b; margin: 0 0 5px; font-size: 12px;">PHONE</p>
                                                    <p style="color: #1e293b; margin: 0; font-weight: 600; font-size: 14px;"><a href="tel:'.$phone.'" style="color: #667eea; text-decoration: none;">'.$phone.'</a></p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Action Button -->
                        <tr>
                            <td style="padding: 0 30px 40px; text-align: center;">
                                <a href="https://find-business.com/admin" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 50px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                    📋 Review in Admin Panel
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background: #1e293b; padding: 30px; text-align: center;">
                                <p style="color: #94a3b8; margin: 0 0 10px; font-size: 14px;">
                                    <strong style="color: #ffffff;">Find Business</strong> - Business Directory
                                </p>
                                <p style="color: #64748b; margin: 0; font-size: 12px;">
                                    This is an automated notification • '.$date.'
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Find Business <noreply@find-business.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    @mail($to, $subject, $message, $headers);
}

// =============================================
// USER EMAIL - Beautiful Confirmation
// =============================================
function sendUserEmail($ref, $full_name, $email, $business_name, $category, $city, $state) {
    
    $subject = "🎉 Welcome to Find Business! Your Business is Under Review [$ref]";
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, sans-serif; background-color: #f0f4f8;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0f4f8; padding: 40px 20px;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.1);">
                        
                        <!-- Header with Celebration -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 30px; text-align: center;">
                                <div style="font-size: 60px; margin-bottom: 20px;">🎊</div>
                                <h1 style="color: #ffffff; margin: 0; font-size: 32px; font-weight: 700;">
                                    Thank You!
                                </h1>
                                <p style="color: rgba(255,255,255,0.9); margin: 15px 0 0; font-size: 18px;">
                                    Your business has been submitted successfully
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Greeting -->
                        <tr>
                            <td style="padding: 40px 30px 20px;">
                                <p style="color: #1e293b; font-size: 18px; margin: 0;">
                                    Hello <strong>'.$full_name.'</strong>,
                                </p>
                                <p style="color: #64748b; font-size: 16px; margin: 15px 0 0; line-height: 1.6;">
                                    We\'re excited to have <strong style="color: #667eea;">'.$business_name.'</strong> join the Find Business directory! Your listing is now being reviewed by our team.
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Reference Box -->
                        <tr>
                            <td style="padding: 10px 30px 30px;">
                                <div style="background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%); border: 2px dashed #667eea; border-radius: 16px; padding: 30px; text-align: center;">
                                    <p style="color: #64748b; margin: 0 0 8px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Your Reference Number</p>
                                    <h2 style="color: #667eea; margin: 0; font-size: 36px; font-weight: 700; letter-spacing: 3px;">'.$ref.'</h2>
                                    <p style="color: #94a3b8; margin: 10px 0 0; font-size: 13px;">📌 Save this for future reference</p>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Business Summary -->
                        <tr>
                            <td style="padding: 0 30px 30px;">
                                <div style="background: #f8fafc; border-radius: 12px; padding: 25px;">
                                    <h3 style="color: #1e293b; margin: 0 0 20px; font-size: 16px;">📋 Submission Summary</h3>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">Business Name</td>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; color: #1e293b; font-weight: 600; text-align: right;">'.$business_name.'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">Category</td>
                                            <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; color: #1e293b; font-weight: 600; text-align: right;">'.$category.'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 0; color: #64748b; font-size: 14px;">Location</td>
                                            <td style="padding: 10px 0; color: #1e293b; font-weight: 600; text-align: right;">'.$city.', '.$state.'</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- What Happens Next -->
                        <tr>
                            <td style="padding: 0 30px 30px;">
                                <h3 style="color: #1e293b; margin: 0 0 20px; font-size: 18px;">🚀 What Happens Next?</h3>
                                
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding: 15px 0;">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="width: 50px; vertical-align: top;">
                                                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 36px; height: 36px; border-radius: 50%; text-align: center; line-height: 36px; font-weight: bold;">1</div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <p style="margin: 0; color: #1e293b; font-weight: 600;">Review Process</p>
                                                        <p style="margin: 5px 0 0; color: #64748b; font-size: 14px;">Our team will review your submission within 24-48 hours</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 15px 0;">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="width: 50px; vertical-align: top;">
                                                        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; width: 36px; height: 36px; border-radius: 50%; text-align: center; line-height: 36px; font-weight: bold;">2</div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <p style="margin: 0; color: #1e293b; font-weight: 600;">Verification</p>
                                                        <p style="margin: 5px 0 0; color: #64748b; font-size: 14px;">We may contact you if we need any additional information</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 15px 0;">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="width: 50px; vertical-align: top;">
                                                        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; width: 36px; height: 36px; border-radius: 50%; text-align: center; line-height: 36px; font-weight: bold;">3</div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <p style="margin: 0; color: #1e293b; font-weight: 600;">Go Live!</p>
                                                        <p style="margin: 5px 0 0; color: #64748b; font-size: 14px;">Once approved, your business will be visible to thousands of users</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- CTA Button -->
                        <tr>
                            <td style="padding: 0 30px 40px; text-align: center;">
                                <a href="https://find-business.com" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 50px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                    🌐 Visit Find Business
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Help Box -->
                        <tr>
                            <td style="padding: 0 30px 30px;">
                                <div style="background: #fef3c7; border-radius: 12px; padding: 20px; text-align: center;">
                                    <p style="color: #92400e; margin: 0; font-size: 14px;">
                                        💡 <strong>Need Help?</strong> Reply to this email or contact us at 
                                        <a href="mailto:info@mohphrettechnologies.com" style="color: #92400e;">info@mohphrettechnologies.com</a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background: #1e293b; padding: 40px 30px; text-align: center;">
                                <h3 style="color: #ffffff; margin: 0 0 10px; font-size: 22px;">Find Business</h3>
                                <p style="color: #94a3b8; margin: 0 0 20px; font-size: 14px;">Your Local Business Directory</p>
                                
                                <div style="margin: 20px 0;">
                                    <a href="https://find-business.com" style="color: #94a3b8; text-decoration: none; margin: 0 10px; font-size: 14px;">Website</a>
                                    <span style="color: #475569;">•</span>
                                    <a href="mailto:info@mohphrettechnologies.com" style="color: #94a3b8; text-decoration: none; margin: 0 10px; font-size: 14px;">Contact</a>
                                    <span style="color: #475569;">•</span>
                                    <a href="https://find-business.com/about" style="color: #94a3b8; text-decoration: none; margin: 0 10px; font-size: 14px;">About Us</a>
                                </div>
                                
                                <p style="color: #475569; margin: 20px 0 0; font-size: 12px;">
                                    © '.date('Y').' Find Business. All rights reserved.<br>
                                    Powered by Mohphre Technologies
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Find Business <noreply@find-business.com>\r\n";
    $headers .= "Reply-To: info@mohphrettechnologies.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    @mail($email, $subject, $message, $headers);
}
?>
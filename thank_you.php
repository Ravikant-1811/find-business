<?php
$id = $_GET['id'] ?? '';
$ref = 'BD' . str_pad($id, 6, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Find Business</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background Elements */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }
        
        .shape-1 {
            top: 10%;
            left: 10%;
            width: 300px;
            height: 300px;
            background: white;
            border-radius: 50%;
            animation-delay: 0s;
        }
        
        .shape-2 {
            top: 60%;
            right: 10%;
            width: 200px;
            height: 200px;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: -5s;
        }
        
        .shape-3 {
            bottom: 10%;
            left: 20%;
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            animation-delay: -10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(20px) rotate(-5deg); }
        }
        
        /* Confetti Animation */
        .confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .confetti-piece {
            position: absolute;
            width: 10px;
            height: 20px;
            top: -20px;
            animation: confetti-fall 5s linear infinite;
        }
        
        @keyframes confetti-fall {
            0% { top: -20px; transform: rotate(0deg) translateX(0); opacity: 1; }
            100% { top: 100vh; transform: rotate(720deg) translateX(100px); opacity: 0; }
        }
        
        /* Main Card */
        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 600px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.3) inset;
            animation: cardAppear 0.8s ease-out;
        }
        
        @keyframes cardAppear {
            0% { opacity: 0; transform: translateY(50px) scale(0.9); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        /* Success Icon */
        .success-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 55px;
            color: white;
            box-shadow: 
                0 15px 40px rgba(16, 185, 129, 0.4),
                0 0 0 8px rgba(16, 185, 129, 0.1);
            animation: iconBounce 0.8s ease-out 0.3s both, iconPulse 2s ease-in-out infinite 1.1s;
            position: relative;
        }
        
        .success-icon::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            border-radius: 50%;
            border: 3px solid rgba(16, 185, 129, 0.3);
            animation: ripple 2s ease-out infinite;
        }
        
        @keyframes iconBounce {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes ripple {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.3); opacity: 0; }
        }
        
        /* Celebration Emojis */
        .celebration {
            font-size: 40px;
            margin-bottom: 20px;
            animation: celebrate 1s ease-out 0.5s both;
        }
        
        @keyframes celebrate {
            0% { transform: scale(0) rotate(-180deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        
        /* Title */
        h1 {
            font-size: 38px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            animation: titleAppear 0.8s ease-out 0.4s both;
        }
        
        @keyframes titleAppear {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .subtitle {
            color: #64748b;
            font-size: 18px;
            margin-bottom: 35px;
            animation: subtitleAppear 0.8s ease-out 0.5s both;
        }
        
        @keyframes subtitleAppear {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        /* Reference Box */
        .reference-box {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
            border: 3px dashed #667eea;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
            overflow: hidden;
            animation: refAppear 0.8s ease-out 0.6s both;
        }
        
        .reference-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        @keyframes refAppear {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .reference-box .label {
            color: #64748b;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        
        .reference-box .ref-number {
            font-size: 42px;
            font-weight: 800;
            color: #667eea;
            letter-spacing: 4px;
            text-shadow: 2px 2px 4px rgba(102, 126, 234, 0.2);
        }
        
        .reference-box .copy-hint {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        /* Timeline Steps */
        .timeline {
            background: #f8fafc;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            text-align: left;
            animation: timelineAppear 0.8s ease-out 0.7s both;
        }
        
        @keyframes timelineAppear {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .timeline-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .step {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #e2e8f0;
            position: relative;
            opacity: 0;
            animation: stepAppear 0.5s ease-out forwards;
        }
        
        .step:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .step:nth-child(2) { animation-delay: 0.9s; }
        .step:nth-child(3) { animation-delay: 1.1s; }
        .step:nth-child(4) { animation-delay: 1.3s; }
        .step:nth-child(5) { animation-delay: 1.5s; }
        
        @keyframes stepAppear {
            0% { opacity: 0; transform: translateX(-20px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        .step-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }
        
        .step-1 .step-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .step-2 .step-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .step-3 .step-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .step-4 .step-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        
        .step-content h4 {
            color: #1e293b;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .step-content p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Buttons */
        .buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
            animation: buttonsAppear 0.8s ease-out 1.7s both;
        }
        
        @keyframes buttonsAppear {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }
        
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
        }
        
        /* Contact Box */
        .contact-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            animation: contactAppear 0.8s ease-out 1.9s both;
        }
        
        @keyframes contactAppear {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .contact-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        
        .contact-box a {
            color: #92400e;
            font-weight: 600;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            animation: footerAppear 0.8s ease-out 2.1s both;
        }
        
        @keyframes footerAppear {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .footer p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .card {
                padding: 40px 25px;
                border-radius: 25px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .reference-box .ref-number {
                font-size: 32px;
            }
            
            .buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <!-- Confetti -->
    <div class="confetti" id="confetti"></div>
    
    <!-- Main Content -->
    <div class="container">
        <div class="card">
            <!-- Success Icon -->
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <!-- Celebration -->
            <div class="celebration">🎊 🎉 🎊</div>
            
            <!-- Title -->
            <h1>Thank You!</h1>
            <p class="subtitle">Your business has been submitted successfully</p>
            
            <!-- Reference Box -->
            <div class="reference-box">
                <p class="label">Your Reference Number</p>
                <p class="ref-number"><?php echo htmlspecialchars($ref); ?></p>
                <p class="copy-hint">
                    <i class="fas fa-bookmark"></i>
                    Save this for future reference
                </p>
            </div>
            
            <!-- Timeline -->
            <div class="timeline">
                <h3 class="timeline-title">
                    <i class="fas fa-rocket"></i>
                    What Happens Next?
                </h3>
                
                <div class="step step-1">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="step-content">
                        <h4>Review Process</h4>
                        <p>Our team will review your submission within 24-48 hours</p>
                    </div>
                </div>
                
                <div class="step step-2">
                    <div class="step-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="step-content">
                        <h4>Verification</h4>
                        <p>We may contact you if we need any additional information</p>
                    </div>
                </div>
                
                <div class="step step-3">
                    <div class="step-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div class="step-content">
                        <h4>Approval</h4>
                        <p>Once verified, your business will be approved for listing</p>
                    </div>
                </div>
                
                <div class="step step-4">
                    <div class="step-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="step-content">
                        <h4>Go Live!</h4>
                        <p>Your business will be visible to thousands of potential customers</p>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="buttons">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
                <a href="/add_business" class="btn btn-secondary">
                    <i class="fas fa-plus"></i>
                    Add Another
                </a>
            </div>
            
            <!-- Contact Box -->
            <div class="contact-box">
                <p>
                    <i class="fas fa-headset"></i>
                    Need help? Contact us at 
                    <a href="tel:+91 97145 84578" class="call-btn">
    <i class="fas fa-phone-alt"></i> Call Now
</a>

                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>
                © <?php echo date('Y'); ?> <a href="/">Find Business</a> • Powered by 
                <a href="https://mohphrettechnologies.com" target="_blank">Mohphre Technologies</a>
            </p>
        </div>
    </div>
    
    <!-- Confetti Script -->
    <script>
        // Create confetti
        function createConfetti() {
            const confettiContainer = document.getElementById('confetti');
            const colors = ['#667eea', '#764ba2', '#f093fb', '#10b981', '#fbbf24', '#ef4444', '#06b6d4'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti-piece';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDuration = (Math.random() * 3 + 3) + 's';
                confetti.style.animationDelay = Math.random() * 5 + 's';
                confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';
                confettiContainer.appendChild(confetti);
            }
        }
        
        // Run confetti on load
        window.onload = function() {
            createConfetti();
            
            // Stop confetti after 10 seconds
            setTimeout(() => {
                document.getElementById('confetti').style.display = 'none';
            }, 10000);
        };
    </script>
</body>
</html>
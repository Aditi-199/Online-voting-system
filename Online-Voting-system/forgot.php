<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVote - Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2A2F4F;
            --secondary-color: #917FB3;
            --accent-color: #E5BEEC;
            --background-gradient: linear-gradient(135deg, #2A2F4F 0%, #917FB3 100%);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            color: white;
        }

        .sv-floating-circles {
            position: fixed;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .sv-floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            animation: sv-float 20s infinite linear;
        }

        @keyframes sv-float {
            0%, 100% { transform: translate(0,0) rotate(0); }
            25% { transform: translate(100px,-50px) rotate(45deg); }
            50% { transform: translate(-50px,80px) rotate(-30deg); }
            75% { transform: translate(-80px,-100px) rotate(60deg); }
        }

        .sv-container {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            z-index: 1;
        }

        .sv-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .sv-main-logo {
            font-size: 3.5rem;
            margin: 0;
            letter-spacing: 2px;
            color: white;
        }

        .sv-logo-accent {
            color: var(--accent-color);
        }

        .sv-tagline {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        .sv-auth-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2rem;
            transition: transform 0.3s ease;
            border: 2px solid var(--accent-color);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .sv-auth-card:hover {
            transform: translateY(-5px);
        }

        .sv-form-group {
            margin-bottom: 1.5rem;
        }

        .sv-form-input {
            width: 100%;
            padding: 1rem;
            background: rgba(255,255,255,0.9);
            border: 2px solid transparent;
            border-radius: 8px;
            color: var(--primary-color);
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .sv-form-input:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 8px rgba(145,127,179,0.3);
        }

        .sv-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: var(--secondary-color);
            border: 2px solid transparent;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            justify-content: center;
            font-size: 1rem;
            font-weight: 600;
        }

        .sv-btn:hover {
            background: var(--primary-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
        }

        .sv-page-transition {
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: var(--secondary-color);
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 1s ease;
            z-index: 9999;
            pointer-events: none;
        }

        .sv-back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .sv-back-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .sv-back-link a:hover {
            text-decoration: underline;
        }

        .sv-otp-group {
            display: flex;
            justify-content: space-between;
            margin: 1.5rem 0;
            gap: 0.5rem;
        }

        .sv-otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 8px;
            border: 2px solid var(--secondary-color);
            background: rgba(255,255,255,0.9);
            flex: 1;
        }

        .sv-otp-input:focus {
            border-color: var(--accent-color);
            outline: none;
        }

        .sv-otp-timer {
            text-align: center;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: var(--accent-color);
        }

        .sv-resend-otp {
            text-align: center;
            margin-top: 1rem;
        }

        .sv-resend-otp a {
            color: var(--accent-color);
            cursor: pointer;
            text-decoration: none;
        }

        .sv-resend-otp a:hover {
            text-decoration: underline;
        }

        .sv-error-message {
            color: #ff6b6b;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            display: none;
        }

        .sv-success-message {
            color: #4BB543;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            display: none;
        }

        .sv-card-title {
            margin-top: 0;
            margin-bottom: 1rem;
            color: white;
        }

        .sv-card-description {
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .sv-main-logo {
                font-size: 2.5rem;
            }
            
            .sv-auth-card {
                padding: 1.5rem;
            }

            .sv-otp-input {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        @keyframes sv-shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
    <div class="sv-page-transition"></div>
    <div class="sv-floating-circles">
        <div class="sv-floating-circle" style="width: 200px; height: 200px; top:20%; left:10%"></div>
        <div class="sv-floating-circle" style="width: 150px; height: 150px; top:60%; left:80%"></div>
    </div>

    <div class="sv-container">
        <header class="sv-header">
            <h1 class="sv-main-logo">Secure<span class="sv-logo-accent">Vote</span></h1>
            <p class="sv-tagline">Reset Your Password</p>
        </header>

        <div class="sv-auth-card">
            <div id="svEmailPhoneForm">
                <h2 class="sv-card-title">Forgot Password</h2>
                <p class="sv-card-description">Enter your registered email or phone number to receive an OTP</p>
                <div class="sv-form-group">
                    <input type="text" class="sv-form-input" id="svRecoveryInput" placeholder="Email or Phone Number" required>
                </div>
                <button class="sv-btn" id="svSendOtpBtn">
                    <i class="fas fa-paper-plane"></i> Send OTP
                </button>
                <div class="sv-back-link">
                    <a href="frontpage.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            </div>
            
            <!-- OTP Verification Section (initially hidden) -->
            <div id="svOtpSection" style="display: none;">
                <h2 class="sv-card-title">Verify OTP</h2>
                <p class="sv-card-description">Enter the 6-digit OTP sent to your email/phone</p>
                <div class="sv-otp-group">
                    <input type="text" class="sv-otp-input" maxlength="1" data-index="1">
                    <input type="text" class="sv-otp-input" maxlength="1" data-index="2">
                    <input type="text" class="sv-otp-input" maxlength="1" data-index="3">
                    <input type="text" class="sv-otp-input" maxlength="1" data-index="4">
                    <input type="text" class="sv-otp-input" maxlength="1" data-index="5">
                    <input type="text" class="sv-otp-input" maxlength="1" data-index="6">
                </div>
                <div class="sv-otp-timer" id="svOtpTimer">OTP expires in: 02:00</div>
                <button class="sv-btn" id="svVerifyOtpBtn">
                    <i class="fas fa-check-circle"></i> Verify OTP
                </button>
                <div class="sv-resend-otp">
                    <a href="#" id="svResendOtpLink">Resend OTP</a>
                </div>
                <div class="sv-error-message" id="svOtpErrorMessage">
                    Invalid OTP. Please try again.
                </div>
            </div>
            
            <!-- Password Reset Section (initially hidden) -->
            <div id="svPasswordResetSection" style="display: none;">
                <h2 class="sv-card-title">Set New Password</h2>
                <div class="sv-form-group">
                    <input type="password" class="sv-form-input" id="svNewPassword" placeholder="New Password" required>
                </div>
                <div class="sv-form-group">
                    <input type="password" class="sv-form-input" id="svConfirmPassword" placeholder="Confirm New Password" required>
                </div>
                <button class="sv-btn" id="svResetPasswordBtn">
                    <i class="fas fa-sync-alt"></i> Reset Password
                </button>
                <div class="sv-error-message" id="svPasswordErrorMessage">
                    Passwords don't match!
                </div>
                <div class="sv-success-message" id="svPasswordSuccessMessage">
                    Password reset successfully! Redirecting to login...
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const svEmailPhoneForm = document.getElementById('svEmailPhoneForm');
        const svOtpSection = document.getElementById('svOtpSection');
        const svPasswordResetSection = document.getElementById('svPasswordResetSection');
        const svSendOtpBtn = document.getElementById('svSendOtpBtn');
        const svVerifyOtpBtn = document.getElementById('svVerifyOtpBtn');
        const svResetPasswordBtn = document.getElementById('svResetPasswordBtn');
        const svResendOtpLink = document.getElementById('svResendOtpLink');
        const svRecoveryInput = document.getElementById('svRecoveryInput');
        const svOtpInputs = document.querySelectorAll('.sv-otp-input');
        const svOtpTimer = document.getElementById('svOtpTimer');
        const svOtpErrorMessage = document.getElementById('svOtpErrorMessage');
        const svPasswordErrorMessage = document.getElementById('svPasswordErrorMessage');
        const svPasswordSuccessMessage = document.getElementById('svPasswordSuccessMessage');
        const svNewPassword = document.getElementById('svNewPassword');
        const svConfirmPassword = document.getElementById('svConfirmPassword');

        let svGeneratedOtp = '';
        let svTimerInterval;
        let svTimeLeft = 120; // 2 minutes in seconds
        let svRecoveryMethod = ''; // Will be 'email' or 'phone'

        // Send OTP button click handler
        svSendOtpBtn.addEventListener('click', function() {
            const recoveryValue = svRecoveryInput.value.trim();
            
            if (!recoveryValue) {
                alert('Please enter your email or phone number');
                return;
            }
            
            // Determine if input is email or phone
            if (recoveryValue.includes('@')) {
                svRecoveryMethod = 'email';
            } else {
                svRecoveryMethod = 'phone';
            }
            
            // Generate a random OTP
            svGeneratedOtp = Math.floor(100000 + Math.random() * 900000).toString();
            console.log('Generated OTP (for demo purposes):', svGeneratedOtp);
            
            // Hide email/phone form and show OTP section
            svEmailPhoneForm.style.display = 'none';
            svOtpSection.style.display = 'block';
            
            // Start timer
            svStartTimer();
            
            // Simulate sending OTP
            setTimeout(() => {
                alert(`OTP sent to ${recoveryValue}: ${svGeneratedOtp} (This is a demo)`);
            }, 1000);
        });

        // Verify OTP button click handler
        svVerifyOtpBtn.addEventListener('click', function() {
            const enteredOtp = Array.from(svOtpInputs).map(input => input.value).join('');
            
            if (enteredOtp === svGeneratedOtp) {
                // OTP is correct
                svOtpErrorMessage.style.display = 'none';
                svOtpSection.style.display = 'none';
                svPasswordResetSection.style.display = 'block';
                clearInterval(svTimerInterval);
            } else {
                // OTP is incorrect
                svOtpErrorMessage.style.display = 'block';
                // Shake animation for error
                svOtpSection.style.animation = 'sv-shake 0.5s';
                setTimeout(() => {
                    svOtpSection.style.animation = '';
                }, 500);
            }
        });

        // Reset Password button click handler
        svResetPasswordBtn.addEventListener('click', function() {
            if (svNewPassword.value !== svConfirmPassword.value) {
                svPasswordErrorMessage.style.display = 'block';
                svPasswordSuccessMessage.style.display = 'none';
                return;
            }
            
            if (svNewPassword.value.length < 8) {
                svPasswordErrorMessage.textContent = 'Password must be at least 8 characters';
                svPasswordErrorMessage.style.display = 'block';
                svPasswordSuccessMessage.style.display = 'none';
                return;
            }
            
            // Password is valid
            svPasswordErrorMessage.style.display = 'none';
            svPasswordSuccessMessage.style.display = 'block';
            
            // Simulate password reset and redirect to login
            setTimeout(() => {
                document.querySelector('.sv-page-transition').style.clipPath = 'circle(150% at 50% 50%)';
                setTimeout(() => window.location.href = 'login.html', 800);
            }, 1500);
        });

        // Resend OTP link click handler
        svResendOtpLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Generate new OTP
            svGeneratedOtp = Math.floor(100000 + Math.random() * 900000).toString();
            console.log('New OTP (for demo purposes):', svGeneratedOtp);
            
            // Reset timer
            clearInterval(svTimerInterval);
            svTimeLeft = 120;
            svUpdateTimerDisplay();
            svStartTimer();
            
            // Clear inputs
            svOtpInputs.forEach(input => input.value = '');
            svOtpErrorMessage.style.display = 'none';
            
            // Focus first OTP input
            svOtpInputs[0].focus();
            
            // Simulate resending OTP
            setTimeout(() => {
                alert(`New OTP sent: ${svGeneratedOtp} (This is a demo)`);
            }, 500);
        });

        // OTP input navigation
        svOtpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1) {
                    if (index < svOtpInputs.length - 1) {
                        svOtpInputs[index + 1].focus();
                    }
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0) {
                    if (index > 0) {
                        svOtpInputs[index - 1].focus();
                    }
                }
            });
        });

        // Start OTP countdown timer
        function svStartTimer() {
            clearInterval(svTimerInterval);
            svTimerInterval = setInterval(() => {
                svTimeLeft--;
                svUpdateTimerDisplay();
                
                if (svTimeLeft <= 0) {
                    clearInterval(svTimerInterval);
                    svOtpErrorMessage.textContent = 'OTP has expired. Please request a new one.';
                    svOtpErrorMessage.style.display = 'block';
                    svVerifyOtpBtn.disabled = true;
                }
            }, 1000);
        }

        // Update timer display
        function svUpdateTimerDisplay() {
            const minutes = Math.floor(svTimeLeft / 60);
            const seconds = svTimeLeft % 60;
            svOtpTimer.textContent = `OTP expires in: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        // Floating Animation
        document.querySelectorAll('.sv-floating-circle').forEach(circle => {
            circle.style.animationDuration = `${Math.random() * 10 + 15}s`;
        });

        // Page load animation
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.sv-page-transition').style.clipPath = 'circle(150% at 50% 50%)';
            setTimeout(() => {
                document.querySelector('.sv-page-transition').style.clipPath = 'circle(0% at 50% 50%)';
            }, 100);
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVote - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2A2F4F;
            --secondary-color: #917FB3;
            --accent-color: #E5BEEC;
            --background-gradient: linear-gradient(135deg, #2A2F4F 0%, #917FB3 100%);
            --error-color: #ff6b6b;
            --success-color:rgb(57, 158, 94);
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--background-gradient);
            font-family: 'Arial', sans-serif;
            color: white;
            overflow-x: hidden;
        }

        .floating-circles {
            position: fixed;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0%, 100% { transform: translate(0,0) rotate(0); }
            25% { transform: translate(100px,-50px) rotate(45deg); }
            50% { transform: translate(-50px,80px) rotate(-30deg); }
            75% { transform: translate(-80px,-100px) rotate(60deg); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .main-logo {
            font-size: 3.5rem;
            margin: 0;
            letter-spacing: 2px;
        }

        .logo-accent {
            color: var(--accent-color);
        }

        .tagline {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .auth-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 4rem;
        }

        .auth-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2rem;
            transition: transform 0.3s ease;
            border: 2px solid var(--accent-color);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .auth-card:hover {
            transform: translateY(-10px);
        }

        .login-form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .login-input {
            width: 90%;
            padding: 1rem;
            background: rgba(255,255,255,0.9);
            border: 2px solid transparent;
            border-radius: 8px;
            color: var(--primary-color);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .login-input:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 8px rgba(145,127,179,0.3);
        }

        .password-toggle {
            position: absolute;
            right: 12%;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
        }

        .login-btn {
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
            font-weight: 600;
        }

        .login-btn:hover {
            background: var(--primary-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
        }

        .signup-card {
            background: rgba(255,255,255,0.15);
        }

        .signup-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: transparent;
            border: 2px solid var(--accent-color);
            border-radius: 50px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 90%;
            justify-content: center;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link-btn:hover {
            background: var(--accent-color);
            color: var(--primary-color);
        }

        .page-transition {
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: var(--secondary-color);
            clip-path: circle(0% at 50% 50%);
            transition: clip-path 1s ease;
            z-index: 9999;
            pointer-events: none;
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
            margin-bottom: 0;
        }

        .forgot-password a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--primary-color);
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            border: 2px solid var(--accent-color);
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--accent-color);
            transition: transform 0.3s ease;
        }

        .close-modal:hover {
            transform: scale(1.2);
        }

        .otp-input-group {
            display: flex;
            justify-content: space-between;
            margin: 1.5rem 0;
            gap: 0.5rem;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 8px;
            border: 2px solid var(--secondary-color);
            background: rgba(255,255,255,0.9);
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: var(--accent-color);
            outline: none;
            transform: scale(1.05);
        }

        .otp-timer {
            text-align: center;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: var(--accent-color);
        }

        .resend-otp {
            text-align: center;
            margin-top: 1rem;
        }

        .resend-otp a {
            color: var(--accent-color);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .resend-otp a:hover {
            text-decoration: underline;
            color: white;
        }

        .error-message {
            color: var(--error-color);
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            display: none;
            animation: shake 0.5s;
        }

        .success-message {
            color: var(--success-color);
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            display: none;
        }

        .password-reset-group {
            margin: 1.5rem 0;
            position: relative;
        }

        .password-strength {
            height: 5px;
            background: #ddd;
            border-radius: 3px;
            margin-top: 5px;
            overflow: hidden;
        }

        .password-strength-fill {
            height: 100%;
            width: 0%;
            background: var(--error-color);
            transition: width 0.3s ease;
        }

        .password-strength.weak .password-strength-fill {
            width: 30%;
            background: var(--error-color);
        }

        .password-strength.medium .password-strength-fill {
            width: 60%;
            background: orange;
        }

        .password-strength.strong .password-strength-fill {
            width: 100%;
            background: var(--success-color);
        }

        .password-criteria {
            font-size: 0.8rem;
            color: #ccc;
            margin-top: 0.5rem;
        }

        .password-criteria ul {
            padding-left: 1.5rem;
            margin: 0.5rem 0;
        }

        .password-criteria li {
            margin-bottom: 0.3rem;
        }

        .password-criteria li.valid {
            color: var(--success-color);
        }

        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
            }
            
            .main-logo {
                font-size: 2.5rem;
            }
            
            .auth-card {
                padding: 1.5rem;
            }

            .otp-input {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-transition"></div>
    <div class="floating-circles">
        <div class="floating-circle" style="width: 200px; height: 200px; top:20%; left:10%"></div>
        <div class="floating-circle" style="width: 150px; height: 150px; top:60%; left:80%"></div>
    </div>

    <div class="container">
        <header class="header">
            <h1 class="main-logo">Secure<span class="logo-accent">Vote</span></h1>
            <p class="tagline">Your Trusted Digital Voting Platform</p>
        </header>

        <div class="auth-container">
            <div class="auth-card">
                <h2>Voter Login</h2>
                <form id="loginForm">
                    <div class="login-form-group">
                        <input type="text" class="login-input" placeholder="Voter ID" id="voterId" required>
                    </div>
                    <div class="login-form-group">
                        <input type="password" class="login-input" placeholder="Password" id="password" required>
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    <div class="forgot-password">
                        <a href="#" id="forgotPasswordLink">Forgot Password?</a>
                    </div>
                </form>
            </div>

            <div class="auth-card signup-card">
                <h2>New Voter?</h2>
                <a href="signup.php" class="signup-link-btn" id="signupLink">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal" id="forgotPasswordModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Reset Password</h2>
            
            <!-- Step 1: Enter Voter ID -->
            <div id="voterIdSection">
                <p>Enter your registered Voter ID</p>
                <input type="text" class="login-input" id="recoveryInput" placeholder="Voter ID">
                <button class="login-btn" id="sendOtpBtn" style="margin-top: 1rem;">
                    <i class="fas fa-paper-plane"></i> Send OTP
                </button>
                <div class="error-message" id="voterIdError">
                    Voter ID not found. Please check and try again.
                </div>
            </div>
            
            <!-- Step 2: OTP Verification -->
            <div id="otpSection" style="display: none;">
                <p>Enter the 6-digit OTP sent to your registered email/phone</p>
                <div class="otp-input-group">
                    <input type="text" class="otp-input" maxlength="1" data-index="1">
                    <input type="text" class="otp-input" maxlength="1" data-index="2">
                    <input type="text" class="otp-input" maxlength="1" data-index="3">
                    <input type="text" class="otp-input" maxlength="1" data-index="4">
                    <input type="text" class="otp-input" maxlength="1" data-index="5">
                    <input type="text" class="otp-input" maxlength="1" data-index="6">
                </div>
                <div class="otp-timer" id="otpTimer">OTP expires in: 02:00</div>
                <button class="login-btn" id="verifyOtpBtn">
                    <i class="fas fa-check-circle"></i> Verify OTP
                </button>
                <div class="resend-otp">
                    <a href="#" id="resendOtpLink">Resend OTP</a>
                </div>
                <div class="error-message" id="otpErrorMessage">
                    Invalid OTP. Please try again.
                </div>
            </div>
            
            <!-- Step 3: Reset Password -->
            <div id="passwordResetSection" style="display: none;">
                <p>Set your new password</p>
                
                <div class="password-reset-group">
                    <input type="password" class="login-input" id="newPassword" placeholder="New Password" required>
                    <div class="password-strength">
                        <div class="password-strength-fill"></div>
                    </div>
                    <div class="password-criteria">
                        <p>Password must contain:</p>
                        <ul>
                            <li id="lengthCriteria">At least 8 characters</li>
                            <li id="uppercaseCriteria">One uppercase letter</li>
                            <li id="numberCriteria">One number</li>
                            <li id="specialCriteria">One special character</li>
                        </ul>
                    </div>
                </div>
                
                <div class="password-reset-group">
                    <input type="password" class="login-input" id="confirmPassword" placeholder="Confirm New Password" required>
                </div>
                
                <button class="login-btn" id="updatePasswordBtn">
                    <i class="fas fa-key"></i> Update Password
                </button>
                
                <div class="error-message" id="passwordError">
                    Passwords do not match or do not meet requirements.
                </div>
                
                <div class="success-message" id="passwordSuccess">
                    Password updated successfully! You can now login with your new password.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Login Validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const storedData = JSON.parse(localStorage.getItem('voterData'));
            const enteredId = document.getElementById('voterId').value;
            const enteredPass = document.getElementById('password').value;

            if(storedData && enteredId === storedData.voterId && enteredPass === storedData.password) {
                document.querySelector('.page-transition').style.clipPath = 'circle(150% at 50% 50%)';
                setTimeout(() => window.location.href = 'voting-boothh.php', 800);
            } else {
                alert('Invalid Voter ID or Password!');
                this.reset();
            }
        });

        // Password toggle visibility
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');
        
        passwordToggle.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                passwordToggle.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });

        // Floating Animation
        document.querySelectorAll('.floating-circle').forEach(circle => {
            circle.style.animationDuration = (Math.random() * 10 + 15) + 's';
        });

        // Forgot Password Modal
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const forgotPasswordModal = document.getElementById('forgotPasswordModal');
        const closeModal = document.querySelector('.close-modal');
        const sendOtpBtn = document.getElementById('sendOtpBtn');
        const voterIdSection = document.getElementById('voterIdSection');
        const otpSection = document.getElementById('otpSection');
        const passwordResetSection = document.getElementById('passwordResetSection');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        const resendOtpLink = document.getElementById('resendOtpLink');
        const voterIdError = document.getElementById('voterIdError');
        const otpErrorMessage = document.getElementById('otpErrorMessage');
        const passwordError = document.getElementById('passwordError');
        const passwordSuccess = document.getElementById('passwordSuccess');
        const otpTimer = document.getElementById('otpTimer');
        const recoveryInput = document.getElementById('recoveryInput');
        const otpInputs = document.querySelectorAll('.otp-input');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const updatePasswordBtn = document.getElementById('updatePasswordBtn');
        const passwordStrength = document.querySelector('.password-strength');
        const strengthFill = document.querySelector('.password-strength-fill');
        const criteriaItems = {
            length: document.getElementById('lengthCriteria'),
            uppercase: document.getElementById('uppercaseCriteria'),
            number: document.getElementById('numberCriteria'),
            special: document.getElementById('specialCriteria')
        };

        let generatedOtp = '';
        let timerInterval;
        let timeLeft = 120; // 2 minutes in seconds
        let currentRecoveryVoterId = '';

        // Open modal when forgot password is clicked
        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            forgotPasswordModal.style.display = 'flex';
            resetModal();
        });

        // Close modal when X is clicked
        closeModal.addEventListener('click', function() {
            forgotPasswordModal.style.display = 'none';
            resetModal();
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === forgotPasswordModal) {
                forgotPasswordModal.style.display = 'none';
                resetModal();
            }
        });

        // Send OTP button click handler
        sendOtpBtn.addEventListener('click', function() {
            const voterId = recoveryInput.value.trim();
            const storedData = JSON.parse(localStorage.getItem('voterData'));
            
            if (!voterId) {
                voterIdError.textContent = 'Please enter your Voter ID';
                voterIdError.style.display = 'block';
                return;
            }
            
            // Check if voter ID exists in localStorage
            if (storedData && storedData.voterId === voterId) {
                currentRecoveryVoterId = voterId;
                voterIdError.style.display = 'none';
                
                // Generate OTP
                generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
                console.log('Generated OTP (for demo purposes):', generatedOtp);
                
                // Show OTP section, hide voter ID section
                voterIdSection.style.display = 'none';
                otpSection.style.display = 'block';
                
                // Start timer
                startTimer();
                
                // Simulate sending OTP (in real app, this would be an API call)
                setTimeout(() => {
                    alert(`OTP sent to your registered email/phone: ${generatedOtp} (This is a demo)`);
                }, 1000);
            } else {
                voterIdError.textContent = 'Voter ID not found. Please check and try again.';
                voterIdError.style.display = 'block';
            }
        });

        // Verify OTP button click handler
        verifyOtpBtn.addEventListener('click', function() {
            const enteredOtp = Array.from(otpInputs).map(input => input.value).join('');
            
            if (enteredOtp === generatedOtp) {
                // OTP is correct
                otpErrorMessage.style.display = 'none';
                
                // Hide OTP section, show password reset section
                otpSection.style.display = 'none';
                passwordResetSection.style.display = 'block';
                
                // Clear timer
                clearInterval(timerInterval);
            } else {
                // OTP is incorrect
                otpErrorMessage.style.display = 'block';
                // Shake animation for error
                otpSection.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    otpSection.style.animation = '';
                }, 500);
            }
        });

        // Resend OTP link click handler
        resendOtpLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Generate new OTP
            generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
            console.log('New OTP (for demo purposes):', generatedOtp);
            
            // Reset timer
            clearInterval(timerInterval);
            timeLeft = 120;
            updateTimerDisplay();
            startTimer();
            
            // Clear inputs
            otpInputs.forEach(input => input.value = '');
            otpErrorMessage.style.display = 'none';
            
            // Focus first OTP input
            otpInputs[0].focus();
            
            // Simulate resending OTP
            setTimeout(() => {
                alert(`New OTP sent: ${generatedOtp} (This is a demo)`);
            }, 500);
        });

        // OTP input navigation
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0) {
                    if (index > 0) {
                        otpInputs[index - 1].focus();
                    }
                }
            });
        });

        // Password strength indicator
        newPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let validCriteria = {
                length: false,
                uppercase: false,
                number: false,
                special: false
            };
            
            // Criteria checks
            if (password.length >= 8) {
                strength += 25;
                validCriteria.length = true;
                criteriaItems.length.classList.add('valid');
            } else {
                criteriaItems.length.classList.remove('valid');
            }
            
            if (/[A-Z]/.test(password)) {
                strength += 25;
                validCriteria.uppercase = true;
                criteriaItems.uppercase.classList.add('valid');
            } else {
                criteriaItems.uppercase.classList.remove('valid');
            }
            
            if (/\d/.test(password)) {
                strength += 25;
                validCriteria.number = true;
                criteriaItems.number.classList.add('valid');
            } else {
                criteriaItems.number.classList.remove('valid');
            }
            
            if (/[!@#$%^&*]/.test(password)) {
                strength += 25;
                validCriteria.special = true;
                criteriaItems.special.classList.add('valid');
            } else {
                criteriaItems.special.classList.remove('valid');
            }
            
            // Update strength meter
            strengthFill.style.width = strength + '%';
            
            // Update strength class
            passwordStrength.className = 'password-strength';
            if (strength > 75) {
                passwordStrength.classList.add('strong');
                strengthFill.style.background = 'var(--success-color)';
            } else if (strength > 50) {
                passwordStrength.classList.add('medium');
                strengthFill.style.background = 'orange';
            } else if (password.length > 0) {
                passwordStrength.classList.add('weak');
                strengthFill.style.background = 'var(--error-color)';
            }
        });

        // Update password button click handler
        updatePasswordBtn.addEventListener('click', function() {
            const newPass = newPassword.value;
            const confirmPass = confirmPassword.value;
            
            // Validate password
            if (!newPass || !confirmPass) {
                passwordError.textContent = 'Please enter and confirm your new password';
                passwordError.style.display = 'block';
                return;
            }
            
            if (newPass !== confirmPass) {
                passwordError.textContent = 'Passwords do not match';
                passwordError.style.display = 'block';
                return;
            }
            
            // Check password strength criteria
            const hasUppercase = /[A-Z]/.test(newPass);
            const hasNumber = /\d/.test(newPass);
            const hasSpecial = /[!@#$%^&*]/.test(newPass);
            const hasMinLength = newPass.length >= 8;
            
            if (!hasUppercase || !hasNumber || !hasSpecial || !hasMinLength) {
                passwordError.textContent = 'Password does not meet requirements';
                passwordError.style.display = 'block';
                return;
            }
            
            // Update password in localStorage
            const storedData = JSON.parse(localStorage.getItem('voterData'));
            if (storedData && storedData.voterId === currentRecoveryVoterId) {
                storedData.password = newPass;
                localStorage.setItem('voterData', JSON.stringify(storedData));
                
                // Show success message
                passwordError.style.display = 'none';
                passwordSuccess.style.display = 'block';
                
                // Clear inputs
                newPassword.value = '';
                confirmPassword.value = '';
                
                // Auto close modal after 3 seconds
                setTimeout(() => {
                    forgotPasswordModal.style.display = 'none';
                    resetModal();
                }, 3000);
            } else {
                passwordError.textContent = 'Failed to update password. Please try again.';
                passwordError.style.display = 'block';
            }
        });

        // Start OTP countdown timer
        function startTimer() {
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    otpErrorMessage.textContent = 'OTP has expired. Please request a new one.';
                    otpErrorMessage.style.display = 'block';
                    verifyOtpBtn.disabled = true;
                }
            }, 1000);
        }

        // Update timer display
        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            otpTimer.textContent = `OTP expires in: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        // Reset modal to initial state
        function resetModal() {
            // Show voter ID section, hide others
            voterIdSection.style.display = 'block';
            otpSection.style.display = 'none';
            passwordResetSection.style.display = 'none';
            
            // Clear inputs
            recoveryInput.value = '';
            otpInputs.forEach(input => input.value = '');
            newPassword.value = '';
            confirmPassword.value = '';
            
            // Reset criteria display
            Object.values(criteriaItems).forEach(item => item.classList.remove('valid'));
            passwordStrength.className = 'password-strength';
            strengthFill.style.width = '0';
            
            // Hide messages
            voterIdError.style.display = 'none';
            otpErrorMessage.style.display = 'none';
            passwordError.style.display = 'none';
            passwordSuccess.style.display = 'none';
            
            // Reset timer
            clearInterval(timerInterval);
            timeLeft = 120;
            updateTimerDisplay();
            verifyOtpBtn.disabled = false;
            
            // Reset current voter ID
            currentRecoveryVoterId = '';
        }
    </script>
</body>
</html>
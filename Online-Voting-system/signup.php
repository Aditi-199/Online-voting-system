<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVote - Voter Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2A2F4F;
            --secondary-color: #917FB3;
            --accent-color: #E5BEEC;
            --success-color: #4CAF50;
            --error-color: #F44336;
            --warning-color: #FFC107;
            --background-gradient: linear-gradient(135deg, #1a1f3d 0%, #4a3b6e 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: var(--background-gradient);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            overflow-x: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .floating-circles {
            position: fixed;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite linear;
            filter: blur(15px);
        }

        @keyframes float {
            0%, 100% { transform: translate(0,0) rotate(0); }
            25% { transform: translate(100px,-50px) rotate(45deg); }
            50% { transform: translate(-50px,80px) rotate(-30deg); }
            75% { transform: translate(-80px,-100px) rotate(60deg); }
        }

        .container {
            max-width: 800px;
            width: 100%;
            z-index: 1;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease-out;
        }

        .header-title {
            font-size: 3.2rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--accent-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .header-subtitle {
            font-size: 1.3rem;
            opacity: 0.85;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
            font-weight: 300;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid rgba(229, 190, 236, 0.3);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.8s ease-out;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 10px;
            font-size: 1.1rem;
            color: var(--accent-color);
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid transparent;
            border-radius: 12px;
            color: var(--primary-color);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(145, 127, 179, 0.3);
            outline: none;
        }

        .age-box {
            padding: 18px;
            border-radius: 12px;
            margin: 25px 0;
            background: rgba(0, 0, 0, 0.2);
            border-left: 4px solid var(--accent-color);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .age-box i {
            margin-right: 12px;
            font-size: 1.4rem;
        }

        .eligible {
            background: rgba(76, 175, 80, 0.15);
            border-left: 4px solid var(--success-color);
        }

        .not-eligible {
            background: rgba(244, 67, 54, 0.15);
            border-left: 4px solid var(--error-color);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--primary-color);
        }

        .password-strength {
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            margin-top: 12px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s;
        }

        .password-rules {
            font-size: 0.9rem;
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: var(--secondary-color);
            border: none;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(145, 127, 179, 0.4);
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .submit-btn i {
            margin-right: 10px;
            font-size: 1.4rem;
        }

        .submit-btn:hover {
            background: #7d68a5;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(145, 127, 179, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .voter-id-container {
            background: var(--primary-color);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin: 30px 0;
            display: none;
            animation: fadeIn 0.8s ease-out;
        }

        .voter-id-label {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.8);
        }

        .voter-id-value {
            font-family: 'Courier New', monospace;
            font-size: 1.5rem;
            letter-spacing: 1.5px;
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .voter-id-value:hover {
            background: rgba(0, 0, 0, 0.4);
            border-color: var(--accent-color);
        }

        .copy-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            margin-top: 10px;
        }

        .copy-btn i {
            margin-right: 8px;
        }

        .copy-btn:hover {
            background: #7d68a5;
            transform: translateY(-2px);
        }

        .redirect-message {
            text-align: center;
            margin-top: 25px;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            display: none;
        }

        .success-animation {
            text-align: center;
            margin-bottom: 30px;
            display: none;
        }

        .success-animation i {
            font-size: 5rem;
            color: var(--success-color);
            animation: pulse 1.5s infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .header-title {
                font-size: 2.5rem;
            }
            
            .header-subtitle {
                font-size: 1.1rem;
            }
            
            .card {
                padding: 30px 20px;
            }
            
            .form-input {
                padding: 14px 16px;
            }
            
            .submit-btn {
                padding: 16px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-circles">
        <div class="floating-circle" style="width:200px;height:200px;top:15%;left:5%"></div>
        <div class="floating-circle" style="width:180px;height:180px;top:65%;left:85%"></div>
        <div class="floating-circle" style="width:150px;height:150px;top:40%;left:75%"></div>
        <div class="floating-circle" style="width:220px;height:220px;top:75%;left:10%"></div>
    </div>

    <div class="container">
        <header class="header">
            <h1 class="header-title">
                <i class="fas fa-vote-yea"></i> SecureVote Registration
            </h1>
            <p class="header-subtitle">Register to exercise your democratic rights. Your vote is your voice!</p>
        </header>

        <div class="card">
            <div class="success-animation" id="successAnimation">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <form id="signupForm">
                <div class="form-group">
                    <label class="form-label" for="fullName">
                        <i class="fas fa-user"></i> Full Name
                    </label>
                    <input type="text" class="form-input" placeholder="Enter your full name" id="fullName" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" class="form-input" placeholder="your.email@example.com" id="email" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="dob">
                        <i class="fas fa-calendar-alt"></i> Date of Birth
                    </label>
                    <input type="date" class="form-input" id="dob" required>
                </div>

                <div class="age-box" id="ageMessage">
                    <i class="fas fa-info-circle"></i>
                    <span>Select your date of birth for age verification</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock"></i> Create Password
                    </label>
                    <div class="password-container">
                        <input type="password" class="form-input" placeholder="Create a strong password" id="password" required>
                        <span class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <div class="password-rules">
                        Password must be at least 8 characters with a mix of uppercase, lowercase, numbers and symbols
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirmPassword">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <div class="password-container">
                        <input type="password" class="form-input" placeholder="Re-enter your password" id="confirmPassword" required>
                        <span class="toggle-password" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="voter-id-container" id="voterIdContainer">
                    <div class="voter-id-label">Your Voter ID:</div>
                    <div class="voter-id-value" id="voterIdValue"></div>
                    <button type="button" class="copy-btn" id="copyBtn">
                        <i class="fas fa-copy"></i> Copy to Clipboard
                    </button>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check-circle"></i> Complete Registration
                </button>
                
                <div class="redirect-message" id="redirectMessage">
                    You will be automatically logged in to the system in <span id="countdown">5</span> seconds...
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signupForm');
            const dobInput = document.getElementById('dob');
            const ageMessage = document.getElementById('ageMessage');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const voterIdContainer = document.getElementById('voterIdContainer');
            const voterIdValue = document.getElementById('voterIdValue');
            const copyBtn = document.getElementById('copyBtn');
            const redirectMessage = document.getElementById('redirectMessage');
            const countdownEl = document.getElementById('countdown');
            const successAnimation = document.getElementById('successAnimation');
            
            // Set max date to today for DOB
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());
            dobInput.max = maxDate.toISOString().split('T')[0];
            
            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
            
            // Calculate age based on DOB
            dobInput.addEventListener('change', function() {
                const dob = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                
                if (age >= 18) {
                    ageMessage.innerHTML = '<i class="fas fa-check-circle"></i> Congratulations! You are eligible to vote.';
                    ageMessage.classList.add('eligible');
                    ageMessage.classList.remove('not-eligible');
                } else {
                    ageMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i> Sorry, you must be at least 18 years old to register.';
                    ageMessage.classList.add('not-eligible');
                    ageMessage.classList.remove('eligible');
                }
            });
            
            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Length check
                if (password.length >= 8) strength += 20;
                if (password.length >= 12) strength += 10;
                
                // Character diversity
                if (/[A-Z]/.test(password)) strength += 20;
                if (/[a-z]/.test(password)) strength += 20;
                if (/[0-9]/.test(password)) strength += 20;
                if (/[^A-Za-z0-9]/.test(password)) strength += 20;
                
                // Cap at 100
                strength = Math.min(strength, 100);
                
                passwordStrengthBar.style.width = strength + '%';
                
                // Color coding
                if (strength < 40) {
                    passwordStrengthBar.style.backgroundColor = 'var(--error-color)';
                } else if (strength < 70) {
                    passwordStrengthBar.style.backgroundColor = 'var(--warning-color)';
                } else {
                    passwordStrengthBar.style.backgroundColor = 'var(--success-color)';
                }
            });
            
            // Copy Voter ID to clipboard
            copyBtn.addEventListener('click', function() {
                const textArea = document.createElement('textarea');
                textArea.value = voterIdValue.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                // Show copied feedback
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Check password match
                if (passwordInput.value !== confirmPasswordInput.value) {
                    alert('Passwords do not match. Please try again.');
                    passwordInput.focus();
                    return;
                }
                
                // Check if eligible
                const dob = new Date(dobInput.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                
                if (age < 18) {
                    alert('You must be at least 18 years old to register to vote.');
                    return;
                }
                
                // Generate Voter ID
                const voterId = 'VID-' + Math.random().toString(36).substr(2, 8).toUpperCase();
                
                // Show Voter ID container
                voterIdValue.textContent = voterId;
                voterIdContainer.style.display = 'block';
                successAnimation.style.display = 'block';
                
                // Scroll to voter ID
                voterIdContainer.scrollIntoView({ behavior: 'smooth' });
                
                // Store data (in a real system, this would be sent to a server)
                const userData = {
                    fullName: document.getElementById('fullName').value,
                    email: document.getElementById('email').value,
                    dob: dobInput.value,
                    voterId: voterId,
                    password: passwordInput.value
                };
                
                // Store in localStorage for login simulation
                localStorage.setItem('voterData', JSON.stringify(userData));
                
                // Show redirect message
                redirectMessage.style.display = 'block';
                
                // Countdown and redirect
                let countdown = 5;
                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownEl.textContent = countdown;
                    
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        
                        // Redirect to login page with credentials
                        window.location.href = 'frontpage.php?' + 
                            `voterId=${encodeURIComponent(voterId)}&` +
                            `password=${encodeURIComponent(passwordInput.value)}`;
                    }
                }, 1000);
            });
        });
    </script>
</body>
</html>
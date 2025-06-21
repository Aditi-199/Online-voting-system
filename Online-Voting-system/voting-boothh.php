<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVote - Voting Booth</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a1f3d;
            --secondary-color: #917FB3;
            --accent-color: #E5BEEC;
            --success-color: #4CAF50;
            --error-color: #F44336;
            --background-gradient: linear-gradient(135deg, #1a1f3d 0%, #4a3b6e 100%);
            --card-bg: rgba(255, 255, 255, 0.08);
            --card-border: rgba(229, 190, 236, 0.3);
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
            padding: 20px;
            position: relative;
        }

        .floating-circles {
            position: fixed;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto 30px;
        }

        .header-title {
            font-size: 2.5rem;
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(to right, var(--accent-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid var(--card-border);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(5px);
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .voting-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .info-banner {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0 40px;
            border-left: 4px solid var(--accent-color);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .info-banner p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .party-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .party-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 30px 25px;
            text-align: center;
            transition: all 0.4s ease;
            border: 2px solid var(--card-border);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .party-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--accent-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .party-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .party-card:hover::before {
            transform: scaleX(1);
        }

        .party-logo {
            width: 150px;
            
            object-fit: contain;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: rgb(255, 255, 255);
            padding: 15px;
            border: 2px solid var(--card-border);
        }

        .party-name {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 600;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vote-btn {
            background: var(--secondary-color);
            padding: 14px 30px;
            border: none;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .vote-btn:hover {
            background: #7d68a5;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(145, 127, 179, 0.4);
        }

        .verification-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .verification-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            backdrop-filter: blur(15px);
            border: 2px solid var(--accent-color);
            text-align: center;
            animation: modalAppear 0.5s ease-out;
        }

        @keyframes modalAppear {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .verification-box h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: var(--accent-color);
        }

        .verification-box p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .camera-options {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin: 30px 0;
        }

        .doc-upload-btn {
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 15px 25px;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .doc-upload-btn:hover {
            background: #d0a3d8;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(229, 190, 236, 0.4);
        }

        .dob-section {
            background: rgba(0, 0, 0, 0.3);
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
            display: none;
        }

        .dob-input {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid transparent;
            border-radius: 10px;
            color: white;
            font-size: 1.1rem;
            margin: 15px 0;
            transition: all 0.3s ease;
        }

        .dob-input:focus {
            border-color: var(--accent-color);
            outline: none;
            background: rgba(255, 255, 255, 0.2);
        }

        .success-message {
            text-align: center;
            padding: 40px 30px;
            background: rgba(76, 175, 80, 0.15);
            border-radius: 20px;
            margin-top: 40px;
            display: none;
            border: 2px solid var(--success-color);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.8s ease-out;
        }

        .success-message h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #a5d6a7;
        }

        .success-message p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .success-icon {
            font-size: 4rem;
            color: var(--success-color);
            margin-bottom: 20px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            color: var(--accent-color);
            transform: rotate(90deg);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .header-title {
                font-size: 2rem;
            }
            
            .verification-box {
                padding: 30px 20px;
            }
            
            .camera-options {
                flex-direction: column;
                gap: 15px;
            }
            
            .party-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="floating-circles">
        <div class="floating-circle" style="width:220px;height:220px;top:10%;left:5%;animation-duration:25s"></div>
        <div class="floating-circle" style="width:180px;height:180px;top:70%;left:85%;animation-duration:22s"></div>
        <div class="floating-circle" style="width:160px;height:160px;top:40%;left:75%;animation-duration:30s"></div>
        <div class="floating-circle" style="width:200px;height:200px;top:75%;left:15%;animation-duration:27s"></div>
    </div>

    <div class="header">
        <h1 class="header-title">
            <i class="fas fa-vote-yea"></i> Indian General Election 2024
        </h1>
        <button class="logout-btn" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>

    <div class="voting-container">
        <div class="info-banner">
            <p>Welcome to the SecureVote digital voting platform. Cast your vote securely and anonymously. Your vote is confidential and will be recorded without any personal identification.</p>
        </div>

        <div class="party-grid">
            <!-- BJP -->
            <div class="party-card">
                <img src="Assets/images/bjp.png" 
                     alt="BJP Logo" class="party-logo">
                <h3 class="party-name">Bharatiya Janata Party</h3>
                <button class="vote-btn" onclick="startVotingProcess('Bharatiya Janata Party')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- Congress -->
            <div class="party-card">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Indian_National_Congress_hand_logo.svg/1200px-Indian_National_Congress_hand_logo.svg.png" 
                     alt="Congress Logo" class="party-logo">
                <h3 class="party-name">Indian National Congress</h3>
                <button class="vote-btn" onclick="startVotingProcess('Indian National Congress')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- AAP -->
            <div class="party-card">
                <img src="Assets/images/aap.png" 
                     alt="AAP Logo" class="party-logo">
                <h3 class="party-name">Aam Aadmi Party</h3>
                <button class="vote-btn" onclick="startVotingProcess('Aam Aadmi Party')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- BSP -->
            <div class="party-card">
                <img src="Assets/images/bsp.png" 
                     alt="BSP Logo" class="party-logo">
                <h3 class="party-name">Bahujan Samaj Party</h3>
                <button class="vote-btn" onclick="startVotingProcess('Bahujan Samaj Party')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- TMC -->
            <div class="party-card">
                <img src="Assets/images/tc.png" 
                     alt="TMC Logo" class="party-logo">
                <h3 class="party-name">Trinamool Congress</h3>
                <button class="vote-btn" onclick="startVotingProcess('Trinamool Congress')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- Shiv Sena -->
            <div class="party-card">
                <img src="Assets/images/shiv.png" 
                     alt="Shiv Sena Logo" class="party-logo">
                <h3 class="party-name">Shiv Sena</h3>
                <button class="vote-btn" onclick="startVotingProcess('Shiv Sena')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- TDP -->
            <div class="party-card">
                <img src="Assets/images/tdp.png" 
                     alt="TDP Logo" class="party-logo">
                <h3 class="party-name">Telugu Desam Party</h3>
                <button class="vote-btn" onclick="startVotingProcess('Telugu Desam Party')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>

            <!-- CPI(M) -->
            <div class="party-card">
                <img src="Assets/images/cpi.png" 
                     alt="CPI(M) Logo" class="party-logo">
                <h3 class="party-name">Communist Party of India (Marxist)</h3>
                <button class="vote-btn" onclick="startVotingProcess('Communist Party of India (Marxist)')">
                    <i class="fas fa-check"></i> Vote Now
                </button>
            </div>
        </div>

        <!-- Verification Modal -->
        <div class="verification-modal" id="verificationModal">
            <div class="verification-box">
                <button class="close-modal" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
                <h2>Identity Verification</h2>
                <p>Please verify your identity to cast your vote. You can either capture a photo of your ID or upload a document.</p>
                
                <div class="camera-options">
                    <button class="doc-upload-btn" onclick="openCamera()">
                        <i class="fas fa-camera"></i> Capture ID Photo
                    </button>
                    <button class="doc-upload-btn" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>

                <input type="file" 
                       id="fileInput" 
                       accept="image/*" 
                       hidden 
                       onchange="handleDocumentUpload(event)">

                <div class="dob-section" id="dobSection">
                    <p>Please enter your date of birth for age verification:</p>
                    <input type="date" 
                           id="dobInput" 
                           class="dob-input" 
                           required>
                    
                    <button class="vote-btn" onclick="verifyAge()">
                        <i class="fas fa-check-circle"></i> Verify & Submit Vote
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle success-icon"></i>
            <h2>Vote Submitted Successfully!</h2>
            <p>Thank you for participating in the democratic process. Your vote has been securely recorded.</p>
            <p>Redirecting to homepage in <span id="countdown">5</span> seconds...</p>
        </div>
    </div>

    <script>
        let selectedParty = '';
        
        function startVotingProcess(party) {
            selectedParty = party;
            document.getElementById('verificationModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('verificationModal').style.display = 'none';
        }

        function openCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    // Handle camera stream here
                    alert('Camera access granted. This demo would normally capture your ID photo.');
                    document.getElementById('dobSection').style.display = 'block';
                })
                .catch(err => {
                    console.error('Error accessing camera:', err);
                    alert('Camera access denied. Please upload document instead.');
                });
        }

        function handleDocumentUpload(event) {
            const file = event.target.files[0];
            if(file) {
                // Show the date input section
                document.getElementById('dobSection').style.display = 'block';
            }
        }

        function verifyAge() {
            const dobInput = document.getElementById('dobInput');
            if (!dobInput.value) {
                alert('Please enter your date of birth');
                return;
            }
            
            const dob = new Date(dobInput.value);
            const today = new Date();
            const age = today.getFullYear() - dob.getFullYear();
            
            // Check if birthday has occurred this year
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            
            if(age < 18) {
                alert('Age verification failed! You must be at least 18 years old to vote.');
                return;
            }

            // Store vote in localStorage
            const votes = JSON.parse(localStorage.getItem('votes') || '[]');
            votes.push({
                party: selectedParty,
                timestamp: new Date().toISOString()
            });
            localStorage.setItem('votes', JSON.stringify(votes));

            // Show success message and redirect
            document.getElementById('verificationModal').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';
            
            // Countdown redirect
            let countdown = 5;
            const countdownEl = document.getElementById('countdown');
            const countdownInterval = setInterval(() => {
                countdown--;
                countdownEl.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = 'frontpage.php';
                }
            }, 1000);
        }
        
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'index.php';
            }
        }

        // Set max date for DOB input
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
            document.getElementById('dobInput').max = maxDate.toISOString().split('T')[0];
        });
    </script>
</body>
</html>
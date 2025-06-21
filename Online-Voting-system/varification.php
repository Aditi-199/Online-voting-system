<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVote - Identity Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Maintain existing color scheme and base styles */
        :root {
            --primary-color: #2A2F4F;
            --secondary-color: #917FB3;
            --accent-color: #E5BEEC;
            --background-gradient: linear-gradient(135deg, #2A2F4F 0%, #917FB3 100%);
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--background-gradient);
            font-family: 'Arial', sans-serif;
            color: white;
            overflow-x: hidden;
        }

        /* Reuse floating circles animation */
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
            background: rgba(255,255,255,0.1);
            animation: float 20s infinite linear;
            filter: blur(15px);
        }

        @keyframes float {
            0%, 100% { transform: translate(0,0) rotate(0); }
            25% { transform: translate(100px,-50px) rotate(45deg); }
            50% { transform: translate(-50px,80px) rotate(-30deg); }
            75% { transform: translate(-80px,-100px) rotate(60deg); }
        }

        /* Verification specific styles */
        .verify-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .verify-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .verify-title {
            font-size: 2.8rem;
            margin: 0;
            letter-spacing: 1.5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .verify-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2.5rem;
            border: 2px solid var(--accent-color);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        .upload-section {
            border: 2px dashed var(--accent-color);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin: 2rem 0;
            transition: all 0.3s ease;
        }

        .upload-section:hover {
            background: rgba(255,255,255,0.05);
        }

        .upload-options {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: var(--secondary-color);
            border: none;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            transform: translateY(-3px);
            background: var(--primary-color);
        }

        .preview-container {
            margin: 2rem 0;
            text-align: center;
        }

        .document-preview {
            max-width: 100%;
            border-radius: 10px;
            border: 2px solid var(--accent-color);
            display: none;
        }

        .verify-info {
            color: var(--accent-color);
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        /* Maintain existing page transition styles */
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

        @media (max-width: 768px) {
            .verify-container {
                padding: 1.5rem;
            }
            
            .verify-title {
                font-size: 2rem;
            }
            
            .upload-options {
                flex-direction: column;
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

    <div class="verify-container">
        <header class="verify-header">
            <h1 class="verify-title">
                <i class="fas fa-id-card"></i>
                Identity Verification
            </h1>
            <p class="verify-info">Please upload your Aadhaar or PAN card for age verification</p>
        </header>

        <div class="verify-card">
            <div class="upload-section" id="dropZone">
                <i class="fas fa-cloud-upload-alt fa-3x"></i>
                <h3>Drag & Drop Documents Here</h3>
                <p>or</p>
                
                <div class="upload-options">
                    <button class="upload-btn" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-folder-open"></i> Choose File
                    </button>
                    <button class="upload-btn" onclick="openCamera()">
                        <i class="fas fa-camera"></i> Use Camera
                    </button>
                </div>
                
                <input type="file" id="fileInput" accept="image/*" hidden>
            </div>

            <div class="preview-container">
                <img id="documentPreview" class="document-preview" alt="Document Preview">
            </div>

            <div id="verificationResult"></div>

            <button class="upload-btn" style="width: 100%" onclick="verifyDocument()" id="verifyBtn" disabled>
                <i class="fas fa-check-circle"></i> Verify Document
            </button>
        </div>
    </div>

    <script>
        // Simulated DOB from previous registration (should come from backend)
        const registeredDOB = localStorage.getItem('userDOB') || '2000-01-01';

        // File handling
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('documentPreview');
        const verifyBtn = document.getElementById('verifyBtn');

        fileInput.addEventListener('change', function(e) {
            handleFile(e.target.files[0]);
        });

        function handleFile(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                verifyBtn.disabled = false;
            };
            reader.readAsDataURL(file);
        }

        // Camera access
        async function openCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                // Implement camera capture logic here
                alert('Camera functionality needs implementation');
            } catch (error) {
                alert('Error accessing camera: ' + error.message);
            }
        }

        // Drag & drop
        const dropZone = document.getElementById('dropZone');
        
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.background = rgba(255,255,255,0.1);
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            handleFile(e.dataTransfer.files[0]);
            dropZone.style.background = '';
        });

        // Verification logic (simulated)
        function verifyDocument() {
            // In real implementation, use OCR to extract DOB from document
            const documentDOB = prompt("Enter DOB from document (YYYY-MM-DD):");
            
            if(documentDOB === registeredDOB) {
                showAlert('Verification Successful! DOB matches records.', 'success');
                setTimeout(() => {
                    window.location.href = 'voting.html';
                }, 2000);
            } else {
                showAlert('Verification Failed: DOB does not match registration records', 'error');
            }
        }

        // Reuse existing alert system
        function showAlert(message, type) {
            const alertBox = document.createElement('div');
            alertBox.style.position = 'fixed';
            alertBox.style.top = '20px';
            alertBox.style.right = '20px';
            alertBox.style.padding = '1rem 2rem';
            alertBox.style.borderRadius = '8px';
            alertBox.style.color = 'white';
            alertBox.style.zIndex = '10000';
            alertBox.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
            alertBox.style.backgroundColor = type === 'success' ? '#00C851' : '#ff4444';
            alertBox.textContent = message;
            alertBox.style.animation = 'slideIn 0.3s ease';
            
            document.body.appendChild(alertBox);
            setTimeout(() => {
                alertBox.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    alertBox.remove();
                }, 300);
            }, 2500);
        }

        // Add animation styles dynamically
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
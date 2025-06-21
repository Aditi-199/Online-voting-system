<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVote - National Elections 2024</title>
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

        /* Voting Page Specific Styles */
        .parties-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: 3rem;
            margin: 1rem 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .party-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .party-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 1.5rem;
            border: 2px solid var(--accent-color);
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .party-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .party-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin: 1rem auto;
            border-radius: 50%;
            border: 3px solid var(--accent-color);
        }

        .party-name {
            font-size: 1.5rem;
            margin: 1rem 0;
            color: var(--accent-color);
        }

        .vote-button {
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
            font-size: 1.1rem;
            margin: 1rem 0;
        }

        .vote-button:hover {
            background: var(--primary-color);
            transform: scale(1.05);
        }

        /* Page transition styles */
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
            .parties-container {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .party-grid {
                grid-template-columns: 1fr;
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

    <div class="parties-container">
        <header class="page-header">
            <h1 class="page-title">
                <i class="fas fa-vote-yea"></i>
                National Elections 2024
            </h1>
            <p>Cast your vote securely for your preferred party</p>
        </header>

        <div class="party-grid" id="partyGrid">
            <!-- Party cards will be dynamically generated here -->
        </div>
    </div>

    <script>
        // Sample party data (replace with actual data)
        const parties = [
            {
                name: "Bharatiya Janata Party",
                logo: "https://upload.wikimedia.org/wikipedia/en/thumb/1/1e/Bharatiya_Janata_Party_logo.svg/1200px-Bharatiya_Janata_Party_logo.svg.png",
                symbol: "Lotus"
            },
            {
                name: "Indian National Congress",
                logo: "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Indian_National_Congress_hand_logo.svg/1024px-Indian_National_Congress_hand_logo.svg.png",
                symbol: "Hand"
            },
            // Add more parties as needed
        ];

        // Generate party cards
        const partyGrid = document.getElementById('partyGrid');
        
        parties.forEach(party => {
            const card = document.createElement('div');
            card.className = 'party-card';
            card.innerHTML = `
                <img src="${party.logo}" alt="${party.name} logo" class="party-logo">
                <h2 class="party-name">${party.name}</h2>
                <p>Election Symbol: ${party.symbol}</p>
                <button class="vote-button" onclick="handleVoteClick('${party.name}')">
                    <i class="fas fa-check-to-slot"></i> Vote Now
                </button>
            `;
            partyGrid.appendChild(card);
        });

        // Handle vote button click
        function handleVoteClick(partyName) {
            // Trigger page transition
            const transition = document.querySelector('.page-transition');
            transition.style.clipPath = 'circle(150% at 50% 50%)';
            
            // Redirect to verification page after transition
            setTimeout(() => {
                window.location.href = 'varification.php'; // Your verification page
            }, 1000);
        }

        // Page load transition
        window.addEventListener('load', () => {
            const transition = document.querySelector('.page-transition');
            transition.style.clipPath = 'circle(0% at 50% 50%)';
        });
    </script>
</body>
</html>
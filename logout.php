<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Logout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f8ff 0%, #e1f0ff 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px 0;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
            text-align: center;
        }
        
        .header-container h1 {
            color: #4d93c2ff;
            font-size: 32px;
            margin-bottom: 4px;
        }
        
        .header-container p {
            color: #666;
            font-size: 16px;
        }
        
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }
        
        .logout-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            padding: 48px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        
        .logout-icon {
            width: 80px;
            height: 80px;
            background-color: #ffebee;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            border: 3px solid #ff6b6b;
        }
        
        .logout-icon svg {
            width: 40px;
            height: 40px;
            fill: #ff6b6b;
        }
        
        .logout-container h2 {
            color: #4d93c2ff;
            font-size: 28px;
            margin-bottom: 16px;
        }
        
        .logout-container p {
            color: #666;
            margin-bottom: 32px;
            font-size: 16px;
        }
        
        .button-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-bottom: 24px;
        }
        
        button {
            padding: 14px 32px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }
        
        .btn-logout {
            background-color: #ff6b6b;
            color: white;
        }
        
        .btn-logout:hover {
            background-color: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
        }
        
        .btn-cancel {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .btn-cancel:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .logout-info {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 16px;
            margin-top: 24px;
        }
        
        .logout-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 0;
        }
        
        .countdown {
            color: #4d93c2ff;
            font-weight: 600;
        }
        
        footer {
            background-color: #1d4159ff;
            color: white;
            text-align: center;
            padding: 24px 0;
            margin-top: auto;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }
        
        footer p {
            color: white;
        }
        
        /* Animation for the logout container */
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
        
        .logout-container {
            animation: fadeInUp 0.5s ease-out;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .logout-container {
                padding: 32px 24px;
                margin: 0 16px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            button {
                width: 100%;
            }
            
            .header-container h1 {
                font-size: 28px;
            }
            
            .logout-container h2 {
                font-size: 24px;
            }
        }
        
        @media (max-width: 480px) {
            .logout-container {
                padding: 24px 16px;
            }
            
            .logout-icon {
                width: 60px;
                height: 60px;
            }
            
            .logout-icon svg {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>NexusCare</h1>
            <p>Doctor Portal</p>
        </div>
    </header>

    <main>
        <div class="logout-container">
            <div class="logout-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
            </div>
            
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to logout from your account?</p>
            
            <div class="button-group">
                <form action="process_logout.php" method="post">
                    <button type="submit" class="btn-logout">Yes, Logout</button>
                </form>
                
                <a href="doctor_dashboard.php" style="text-decoration: none;">
                    <button type="button" class="btn-cancel">Cancel</button>
                </a>
            </div>
            
            <div class="logout-info">
                <p>You will be redirected to the login page.</p>
                <p>Auto-redirect in <span class="countdown" id="countdown">10</span> seconds</p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Countdown timer for auto-redirect
        document.addEventListener('DOMContentLoaded', function() {
            let countdown = 10;
            const countdownElement = document.getElementById('countdown');
            const countdownInterval = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = 'login.php';
                }
            }, 1000);
            
            // Clear interval if user clicks cancel
            document.querySelector('.btn-cancel').addEventListener('click', function() {
                clearInterval(countdownInterval);
            });
        });
    </script>
</body>
</html>
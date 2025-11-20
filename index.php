<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4d93c2;
            --primary-dark: #1d5a8a;
            --primary-light: #e6f2fa;
            --secondary: #1d4159;
            --accent: #ff6b6b;
            --light: #f8f9fa;
            --dark: #333;
            --gray: #666;
            --white: #ffffff;
            --success: #28a745;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background-color: var(--white);
            box-shadow: var(--shadow);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        header img {
            height: 60px;
            width: auto;
        }
        
        header h1 {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .tagline {
            color: var(--gray);
            font-size: 1rem;
            font-style: italic;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }
        
        nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
            transition: var(--transition);
        }
        
        nav a:hover {
            color: var(--primary);
        }
        
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: var(--transition);
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--primary);
        }
        
        main {
            flex: 1;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
            margin-bottom: 4rem;
        }
        
        .portal-access {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 400px;
            transition: var(--transition);
            border-top: 4px solid var(--primary);
        }
        
        .portal-access:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .portal-access h2 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .portal-access p {
            color: var(--gray);
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--white);
            color: var(--dark);
            border: 2px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }
        
        #about {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            min-height: 400px;
            border-top: 4px solid var(--primary);
        }
        
        #about h2 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-light);
            text-align: center;
        }
        
        #about p {
            margin-bottom: 1.5rem;
            color: var(--gray);
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            border-top: 4px solid var(--primary);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .feature-card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .feature-card p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        footer {
            background-color: var(--secondary);
            color: var(--white);
            text-align: center;
            padding: 2.5rem 0;
            margin-top: 4rem;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        footer p {
            color: var(--white);
            margin: 0;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                max-width: 100%;
            }
            
            header h1 {
                font-size: 1.5rem;
            }
            
            #about, .portal-access {
                padding: 2rem;
                min-height: auto;
            }
            
            nav ul {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: var(--white);
                flex-direction: column;
                padding: 1rem;
                box-shadow: var(--shadow);
            }
            
            nav ul.active {
                display: flex;
            }
            
            .mobile-menu {
                display: block;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo-container">
                <img src="Picture/NexusCareLogo_withoutbg.png" alt="NexusCare Logo">
                <div>
                    <h1>NexusCare</h1>
                    <p class="tagline">Your health is our priority</p>
                </div>
            </div>
            
            <nav>
                <ul id="nav-menu">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="login.php" class="btn-primary" style="color: white; padding: 0.5rem 1rem;">Login</a></li>
                </ul>
                <div class="mobile-menu" id="mobile-menu">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="content-grid">
            <section class="portal-access">
                <h2>Access Your Portal</h2>
                <p>Login to your account or register as a new patient to access our healthcare services. Manage your appointments, view medical records, and communicate with healthcare professionals through our secure online portal.</p>
                
                <div class="button-group">
                    <a href="login.php" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login to Your Account
                    </a>
                    <a href="register.php" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Register as New Patient
                    </a>
                </div>
            </section>

            <section id="about">
                <h2>About Us</h2>
                <p>At NexusCare, we are dedicated to providing compassionate and comprehensive healthcare for you and your family. Our team of experienced doctors and nurses utilizes a modern, patient-centered approach to ensure you receive the highest quality of care in a comfortable environment.</p>
                <p>We believe in leveraging technology to make healthcare more accessible and efficient.</p>
                <p>Your health is our journey together.</p>
            </section>
        </div>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3>Expert Doctors</h3>
                <p>Our team of experienced healthcare professionals is dedicated to your well-being.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-laptop-medical"></i>
                </div>
                <h3>Digital Healthcare</h3>
                <p>Manage appointments and access your health records through our secure online portal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>24/7 Access</h3>
                <p>Book appointments and access your medical information anytime, anywhere.</p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu').addEventListener('click', function() {
            const navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('active');
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if(window.innerWidth <= 768) {
                        document.getElementById('nav-menu').classList.remove('active');
                    }
                }
            });
        });
    </script>
</body>
</html>
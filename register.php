<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Patient Registration</title>
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
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--light) 100%);
        }
        
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }
        
        .register-container {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            border-top: 4px solid var(--primary);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-header img {
            height: 80px;
            margin-bottom: 1rem;
        }
        
        .register-container h2 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .register-subtitle {
            color: var(--gray);
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        input, textarea, select {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(77, 147, 194, 0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
            padding-left: 1rem;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
        }
        
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }
        
        .strength-bar {
            height: 5px;
            background-color: #eee;
            border-radius: 5px;
            margin-top: 0.25rem;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            width: 0;
            transition: var(--transition);
        }
        
        .strength-weak {
            background-color: #ff6b6b;
            width: 33%;
        }
        
        .strength-medium {
            background-color: #f9a825;
            width: 66%;
        }
        
        .strength-strong {
            background-color: #28a745;
            width: 100%;
        }
        
        .register-btn {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .register-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            padding: 0.75rem;
            border: 2px solid var(--primary);
            border-radius: 8px;
            transition: var(--transition);
            width: 100%;
            margin-top: 1rem;
        }
        
        .back-home:hover {
            background-color: var(--primary-light);
        }
        
        .login-link {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .login-link p {
            color: var(--gray);
            margin-bottom: 0.5rem;
        }
        
        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        footer {
            background-color: var(--secondary);
            color: var(--white);
            text-align: center;
            padding: 1.5rem 0;
        }
        
        .footer-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        footer p {
            color: var(--white);
            margin: 0;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .register-container {
                padding: 2rem 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .register-container {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>

    <main>
        <section class="register-container">
            <div class="register-header">
                <img src="Picture/NexusCareLogo_withoutbg.png" alt="NexusCare Logo">
                <h2>Patient Registration</h2>
                <p class="register-subtitle">Create your account to access healthcare services</p>
            </div>
            
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="name" name="name" required placeholder="Enter your full name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" required placeholder="Enter your email address">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar input-icon"></i>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter your full address"></textarea>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" required placeholder="Create a password">
                        <button type="button" class="password-toggle" id="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <span id="strength-text">Password strength: </span>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">
                    </div>
                    <div id="password-match" style="font-size: 0.8rem; margin-top: 0.25rem;"></div>
                </div>

                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
                
                <a href="index.php" class="back-home">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </form>
            
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Password visibility toggle
        document.getElementById('password-toggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            
            // Reset
            strengthFill.className = 'strength-fill';
            strengthText.textContent = 'Password strength: ';
            
            if (password.length === 0) {
                return;
            }
            
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength++;
            
            // Contains lowercase
            if (/[a-z]/.test(password)) strength++;
            
            // Contains uppercase
            if (/[A-Z]/.test(password)) strength++;
            
            // Contains numbers
            if (/[0-9]/.test(password)) strength++;
            
            // Contains special characters
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Update UI
            if (strength <= 2) {
                strengthFill.classList.add('strength-weak');
                strengthText.textContent += 'Weak';
            } else if (strength <= 4) {
                strengthFill.classList.add('strength-medium');
                strengthText.textContent += 'Medium';
            } else {
                strengthFill.classList.add('strength-strong');
                strengthText.textContent += 'Strong';
            }
        });
        
        // Password confirmation check
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const matchElement = document.getElementById('password-match');
            
            if (confirmPassword.length === 0) {
                matchElement.textContent = '';
                matchElement.style.color = '';
            } else if (password === confirmPassword) {
                matchElement.textContent = 'Passwords match';
                matchElement.style.color = 'var(--success)';
            } else {
                matchElement.textContent = 'Passwords do not match';
                matchElement.style.color = 'var(--accent)';
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const dob = document.getElementById('dob').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (!name || !email || !dob || !password || !confirmPassword) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match.');
                return;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return;
            }
        });
    </script>
</body>
</html>
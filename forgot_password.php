<?php
session_start();
require_once 'db_connection.php';

$error   = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email            = trim($_POST['email'] ?? '');
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($email === '' || $new_password === '' || $confirm_password === '') {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirm password do not match.";
    } elseif (strlen($new_password) < 8) {
        $error = "New password should be at least 8 characters.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT user_id FROM user WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $error = "No active account found with that email.";
            } else {
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $upd = $pdo->prepare("UPDATE user SET password_hash = ? WHERE user_id = ?");
                $upd->execute([$new_hash, $user['user_id']]);
                $success = true;
            }
        } catch (PDOException $e) {
            error_log("DB error in forgot_password: " . $e->getMessage());
            $error = "Error updating password. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
        
        .login-container {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            border-top: 4px solid var(--primary);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header img {
            height: 80px;
            margin-bottom: 1rem;
        }
        
        .login-container h2 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: var(--gray);
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
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
        
        input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(77, 147, 194, 0.2);
        }
        
        .login-btn {
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
        
        .login-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .back-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: var(--transition);
            margin-top: 0.5rem;
            justify-content: center;
            width: 100%;
        }
        
        .back-login:hover {
            background-color: var(--primary-light);
        }
        
        footer {
            background-color: var(--secondary);
            color: var(--white);
            text-align: center;
            padding: 1.5rem 0;
        }
        
        .footer-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        footer p {
            color: var(--white);
            margin: 0;
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
        
        @media (max-width: 768px) {
            .login-container {
                padding: 2rem 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>

    <main>
        <section class="login-container">
            <div class="login-header">
                <img src="Picture/NexusCareLogo_withoutbg.png" alt="NexusCare Logo">
                <h2>Forgot Password</h2>
                <p class="login-subtitle">Reset your account password using your email</p>
            </div>

            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Registered Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" required placeholder="Enter your registered email"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" id="new_password" name="new_password" required placeholder="Enter a new password">
                    </div>
                    <div class="password-strength">
                        <span id="strength-text">Password strength: </span>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Re-enter the new password">
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-unlock-alt"></i> Reset Password
                </button>
                
                <a href="login.php" class="back-login">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Password Reset Successful</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your password has been reset successfully.<br>
                    You can now log in with your new password.
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Password Reset Error</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($error)): ?>
                        <?php echo htmlspecialchars($error); ?>
                    <?php else: ?>
                        There was a problem resetting your password. Please try again.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($success): ?>
                const successModalEl = document.getElementById('successModal');
                if (successModalEl) {
                    const successModal = new bootstrap.Modal(successModalEl);
                    successModal.show();
                    setTimeout(function () {
                        window.location.href = 'login.php';
                    }, 2000);
                }
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                const errorModalEl = document.getElementById('errorModal');
                if (errorModalEl) {
                    const errorModal = new bootstrap.Modal(errorModalEl);
                    errorModal.show();
                }
            <?php endif; ?>

            const passwordInput = document.getElementById('new_password');
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            
            if (passwordInput && strengthFill && strengthText) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    
                    strengthFill.className = 'strength-fill';
                    strengthText.textContent = 'Password strength: ';
                    
                    if (password.length === 0) {
                        return;
                    }
                    
                    let strength = 0;
                    
                    if (password.length >= 8) strength++;
                    if (/[a-z]/.test(password)) strength++;
                    if (/[A-Z]/.test(password)) strength++;
                    if (/[0-9]/.test(password)) strength++;
                    if (/[^A-Za-z0-9]/.test(password)) strength++;
                    
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
            }
        });
    </script>
</body>
</html>

<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php?error=please_login");
    exit();
}

if ($_SESSION['role'] !== 'patient') {
    header("Location: login.php?error=unauthorized");
    exit();
}

$user_id = $_SESSION['user_id'];
$error   = '';
$success = '';


try {
    $stmt = $pdo->prepare("SELECT email, password_hash FROM user WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
} catch (PDOException $e) {
    error_log("DB error in change_password: " . $e->getMessage());
    die("Error loading data. Please try again later.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($current_password === '' || $new_password === '' || $confirm_password === '') {
        $error = "Please fill in all password fields.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirm password do not match.";
    } elseif (strlen($new_password) < 8) {
        $error = "New password should be at least 8 characters.";
    } else {
        
        if (!password_verify($current_password, $user['password_hash'])) {
            $error = "Current password is incorrect.";
        } else {
            
            try {
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $upd = $pdo->prepare("UPDATE user SET password_hash = ? WHERE user_id = ?");
                $upd->execute([$new_hash, $user_id]);
                $success = "Your password has been updated successfully.";
            } catch (PDOException $e) {
                error_log("DB error updating password: " . $e->getMessage());
                $error = "Error updating password. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Change Password</title>
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

        input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
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
        
        .back-profile {
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
        
        .back-profile:hover {
            background-color: var(--primary-light);
        }
        
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #ff6b6b;
            font-size: 0.9rem;
        }

        .success-message {
            background-color: #e6f4ea;
            color: #0f5132;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #28a745;
            font-size: 0.9rem;
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
                <h2>Change Password</h2>
                <p class="login-subtitle">Update your account password securely</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email (read only)</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="current_password" name="current_password" required placeholder="Enter your current password">
                        <button type="button" class="password-toggle" data-target="current_password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" id="new_password" name="new_password" required placeholder="Enter a new password">
                        <button type="button" class="password-toggle" data-target="new_password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Re-enter the new password">
                        <button type="button" class="password-toggle" data-target="confirm_password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-save"></i> Update Password
                </button>
                
                <a href="patient_profile.php" class="back-profile">
                    <i class="fas fa-arrow-left"></i> Back to My Profile
                </a>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        
        document.querySelectorAll('.password-toggle').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon  = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>

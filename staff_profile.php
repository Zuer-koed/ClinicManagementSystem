<?php
session_start();
require_once 'db_connection.php';
$database = new Database();
$pdo = $database->getConnection();

// Check if user is logged in and is a staff member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit();
}

// Get staff information using user_id from session
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT s.*, u.email, u.phone_number as user_phone, u.created_at 
    FROM staff s 
    JOIN user u ON s.user_id = u.user_id 
    WHERE s.user_id = ?
");
$stmt->execute([$user_id]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

// If staff not found, redirect to login
if (!$staff) {
    header('Location: login.php');
    exit();
}

// Set staff_id in session if not already set
if (!isset($_SESSION['staff_id'])) {
    $_SESSION['staff_id'] = $staff['staff_id'];
}

$staff_id = $_SESSION['staff_id'];

// Handle profile update
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $position = $_POST['position'];
        
        try {
            $pdo->beginTransaction();
            
            // Update staff table
            $stmt = $pdo->prepare("UPDATE staff SET full_name = ?, position = ? WHERE staff_id = ?");
            $stmt->execute([$full_name, $position, $staff_id]);
            
            // Update user table
            $stmt = $pdo->prepare("UPDATE user SET email = ?, phone_number = ? WHERE user_id = ?");
            $stmt->execute([$email, $phone_number, $user_id]);
            
            $pdo->commit();
            $success = "Profile updated successfully!";
            
            // Refresh staff data
            $stmt = $pdo->prepare("
                SELECT s.*, u.email, u.phone_number as user_phone, u.created_at 
                FROM staff s 
                JOIN user u ON s.user_id = u.user_id 
                WHERE s.user_id = ?
            ");
            $stmt->execute([$user_id]);
            $staff = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Error updating profile: " . $e->getMessage();
        }
    }
    
    // Handle password change
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        $stmt = $pdo->prepare("SELECT password_hash FROM user WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($current_password, $user['password_hash'])) {
            if ($new_password === $confirm_password) {
                if (strlen($new_password) >= 6) {
                    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE user SET password_hash = ? WHERE user_id = ?");
                    $stmt->execute([$new_password_hash, $user_id]);
                    $success = "Password changed successfully!";
                } else {
                    $error = "New password must be at least 6 characters long.";
                }
            } else {
                $error = "New passwords do not match.";
            }
        } else {
            $error = "Current password is incorrect.";
        }
    }
}

// Get staff activity stats - FIXED QUERIES
$today = date('Y-m-d');

// Count appointments processed today (confirmed or cancelled)
$appointmentsProcessed = $pdo->query("
    SELECT COUNT(*) FROM appointment 
    WHERE preferred_date = '$today' 
    AND status IN ('confirmed', 'cancelled')
")->fetchColumn();

// Count patients registered today - check if patient table has created_at
$patientsRegistered = 0;
try {
    $patientsRegistered = $pdo->query("
        SELECT COUNT(*) FROM patient 
        WHERE DATE(created_at) = '$today'
    ")->fetchColumn();
} catch (Exception $e) {
    // If created_at doesn't exist in patient table, use alternative query
    $patientsRegistered = $pdo->query("
        SELECT COUNT(*) FROM patient 
        WHERE patient_id IN (
            SELECT DISTINCT patient_id FROM appointment 
            WHERE preferred_date = '$today'
        )
    ")->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - My Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f0f8ff;
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 16px 0;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
            flex-wrap: wrap;
        }
        
        .logo {
            height: 150px;
            width: 150px;
        }
        
        .welcome-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .welcome-message {
            text-align: right;
        }
        
        .welcome-message h1 {
            font-size: 24px;
            color: #4d93c2ff;
            margin-bottom: 4px;
        }
        
        .welcome-message p {
            color: #666;
            font-size: 14.4px;
        }
        
        .logout-link {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 16px;
            border: 1px solid #ff6b6b;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .logout-link:hover {
            background-color: #ff6b6b;
            color: white;
        }
        
        nav {
            width: 100%;
            margin-top: 16px;
            background-color: #4d93c2ff;
            border-radius: 4px;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav li {
            margin-right: 1px;
            flex: 1;
            text-align: center;
        }
        
        nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 16px 8px;
            transition: background-color 0.3s;
        }
        
        nav a:hover, nav a.active {
            background-color: #1d5a8a;
        }
        
        main {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 16px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .page-header h1 {
            color: #4d93c2ff;
            font-size: 28.8px;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .profile-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 24px;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            height: fit-content;
        }
        
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #4d93c2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 48px;
            font-weight: bold;
        }
        
        .staff-info {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .staff-info h2 {
            color: #4d93c2ff;
            margin-bottom: 8px;
        }
        
        .staff-info .position {
            color: #666;
            font-size: 16px;
            margin-bottom: 4px;
        }
        
        .staff-info .permission {
            display: inline-block;
            background-color: #e9ecef;
            color: #495057;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .stats {
            margin-top: 20px;
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .stat-item:last-child {
            border-bottom: none;
        }
        
        .stat-value {
            font-weight: bold;
            color: #4d93c2ff;
        }
        
        .content {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        
        .section-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
        }
        
        .section-card h2 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .section-card h3 {
            color: #4d93c2ff;
            margin-bottom: 16px;
            font-size: 18px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 2px rgba(77, 147, 194, 0.2);
        }
        
        input:disabled {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        .button-group {
            display: flex;
            gap: 16px;
            margin-top: 24px;
        }
        
        button {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .btn-danger {
            background-color: #ff6b6b;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #ff5252;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .info-item {
            background-color: #f8f9fa;
            padding: 16px;
            border-radius: 6px;
            border-left: 4px solid #4d93c2ff;
        }
        
        .info-item strong {
            color: #4d93c2ff;
            display: block;
            margin-bottom: 4px;
        }
        
        footer {
            background-color: #1d4159ff;
            color: white;
            text-align: center;
            padding: 24px 0;
            margin-top: 48px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }
        
        footer p {
            color: white;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
            }
            
            .header-container {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-section {
                flex-direction: column;
                margin-top: 16px;
            }
            
            .welcome-message {
                text-align: center;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .profile-container {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <img src="Picture/NexusCareLogo_withoutbg.png" alt="NexusCare Logo" class="logo">
            <div class="welcome-section">
                <div class="welcome-message">
                    <h1>Staff Portal</h1>
                    <p>Welcome, <?php 
                        // Get any staff member's name from the database
                        $stmt = $pdo->query("SELECT full_name FROM staff LIMIT 1");
                        $staff_name = $stmt->fetch(PDO::FETCH_COLUMN);
                        echo htmlspecialchars($staff_name ?? 'Staff Member');
                    ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="staff_dashboard.php">Dashboard</a></li>
                        <li><a href="staff_manage_appointment.php">Manage Appointments</a></li>
                        <li><a href="staff_patient_list.php">Patient List</a></li>
                        <li><a href="staff_profile.php" class="active">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>My Profile</h1>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="profile-container">
            <!-- Sidebar with profile info -->
            <div class="sidebar">
                <div class="profile-picture">
                    <?php echo strtoupper(substr($staff['full_name'], 0, 1)); ?>
                </div>
                <div class="staff-info">
                    <h2><?php echo htmlspecialchars($staff['full_name']); ?></h2>
                    <div class="position"><?php echo htmlspecialchars($staff['position']); ?></div>
                    <span class="permission"><?php echo ucfirst($staff['permission']); ?> Access</span>
                </div>
                
                <div class="stats">
                    <div class="stat-item">
                        <span>Staff ID:</span>
                        <span class="stat-value">S-<?php echo str_pad($staff['staff_id'], 3, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="stat-item">
                        <span>Member Since:</span>
                        <span class="stat-value"><?php echo date('M Y', strtotime($staff['created_at'])); ?></span>
                    </div>
                    <div class="stat-item">
                        <span>Today's Appointments:</span>
                        <span class="stat-value"><?php echo $appointmentsProcessed; ?></span>
                    </div>
                    <div class="stat-item">
                        <span>Patients Registered:</span>
                        <span class="stat-value"><?php echo $patientsRegistered; ?></span>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <!-- Profile Information Section -->
                <section class="section-card">
                    <h2>Profile Information</h2>
                    <form action="" method="post">
                        <input type="hidden" name="update_profile" value="1">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($staff['full_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($staff['user_phone'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($staff['position']); ?>" required>
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="btn-primary">Update Profile</button>
                            <button type="reset" class="btn-secondary">Reset Changes</button>
                        </div>
                    </form>
                </section>

                <!-- Account Information Section -->
                <section class="section-card">
                    <h2>Account Information</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>User ID</strong>
                            <span>U-<?php echo str_pad($staff['user_id'], 3, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Account Role</strong>
                            <span><?php echo ucfirst($staff['permission']); ?> Staff</span>
                        </div>
                        <div class="info-item">
                            <strong>Account Created</strong>
                            <span><?php echo date('F j, Y', strtotime($staff['created_at'])); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Last Login</strong>
                            <span><?php echo date('F j, Y g:i A'); ?> (Current)</span>
                        </div>
                    </div>
                </section>

                <!-- Change Password Section -->
                <section class="section-card">
                    <h2>Change Password</h2>
                    <form action="" method="post">
                        <input type="hidden" name="change_password" value="1">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" required minlength="6">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                            </div>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="btn-primary">Change Password</button>
                            <button type="reset" class="btn-secondary">Clear</button>
                        </div>
                    </form>
                </section>

                <!-- System Information Section -->
                <section class="section-card">
                    <h2>System Information</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>Staff Permissions</strong>
                            <span>
                                <?php 
                                $permissions = [
                                    'admin' => 'Full system access',
                                    'reception' => 'Appointment and patient management',
                                    'nurse' => 'Patient care and medical records'
                                ];
                                echo $permissions[$staff['permission']] ?? 'Limited access';
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <strong>License Number</strong>
                            <span><?php echo htmlspecialchars($staff['license_number'] ?? 'Not required'); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Emergency Contact</strong>
                            <span><?php echo htmlspecialchars($staff['emergency_contact_name'] ?? 'Not set'); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Profile Status</strong>
                            <span style="color: #28a745;">● Active</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password confirmation validation
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            
            function validatePassword() {
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity("Passwords don't match");
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
            
            newPassword.addEventListener('change', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);
        });
    </script>
</body>
</html>
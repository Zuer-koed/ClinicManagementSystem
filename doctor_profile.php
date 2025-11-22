<?php
session_start();
require_once 'db_connection.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Get doctor information
$stmt = $pdo->prepare("
    SELECT d.*, u.email 
    FROM doctor d 
    JOIN user u ON d.user_id = u.user_id 
    WHERE d.doctor_id = ?
");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        // Update basic profile information
        $phone_number = $_POST['phone_number'];
        $bio = $_POST['bio'];
        $education = $_POST['education'];
        $qualifications = $_POST['qualifications'];
        $specialization = $_POST['specialization'];
        
        $stmt = $pdo->prepare("
            UPDATE doctor 
            SET phone_number = ?, bio = ?, education = ?, qualifications = ?, specialization = ?
            WHERE doctor_id = ?
        ");
        $stmt->execute([$phone_number, $bio, $education, $qualifications, $specialization, $doctor_id]);
        
        $success = "Profile updated successfully!";
        
    } elseif (isset($_POST['update_password'])) {
        // Update password
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        $stmt = $pdo->prepare("SELECT password_hash FROM user WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($current_password, $user['password_hash'])) {
            if ($new_password === $confirm_password) {
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE user SET password_hash = ? WHERE user_id = ?");
                $stmt->execute([$new_password_hash, $_SESSION['user_id']]);
                $success = "Password updated successfully!";
            } else {
                $error = "New passwords do not match!";
            }
        } else {
            $error = "Current password is incorrect!";
        }
        
    } elseif (isset($_POST['update_notifications'])) {
        // Update notification preferences
        $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
        $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;
        $appointment_reminders = isset($_POST['appointment_reminders']) ? 1 : 0;
        
        $notification_preferences = json_encode([
            'email' => $email_notifications,
            'sms' => $sms_notifications,
            'appointment_reminders' => $appointment_reminders
        ]);
        
        $stmt = $pdo->prepare("UPDATE doctor SET notification_preferences = ? WHERE doctor_id = ?");
        $stmt->execute([$notification_preferences, $doctor_id]);
        
        $success = "Notification preferences updated successfully!";
        
    } elseif (isset($_POST['update_emergency_contact'])) {
        // Update emergency contact
        $emergency_contact_name = $_POST['emergency_contact_name'];
        $emergency_contact_phone = $_POST['emergency_contact_phone'];
        $emergency_contact_relationship = $_POST['emergency_contact_relationship'];
        $emergency_contact_email = $_POST['emergency_contact_email'];
        
        $stmt = $pdo->prepare("
            UPDATE doctor 
            SET emergency_contact_name = ?, emergency_contact_phone = ?, 
                emergency_contact_relationship = ?, emergency_contact_email = ?
            WHERE doctor_id = ?
        ");
        $stmt->execute([
            $emergency_contact_name, 
            $emergency_contact_phone, 
            $emergency_contact_relationship, 
            $emergency_contact_email, 
            $doctor_id
        ]);
        
        $success = "Emergency contact updated successfully!";
    }
    
    // Refresh doctor data
    $stmt = $pdo->prepare("SELECT d.*, u.email FROM doctor d JOIN user u ON d.user_id = u.user_id WHERE d.doctor_id = ?");
    $stmt->execute([$doctor_id]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get doctor's weekly availability
$stmt = $pdo->prepare("SELECT * FROM doctor_availability WHERE doctor_id = ? ORDER BY FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')");
$stmt->execute([$doctor_id]);
$weekly_availability = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Parse notification preferences
$notification_prefs = $doctor['notification_preferences'] ? json_decode($doctor['notification_preferences'], true) : [
    'email' => 1,
    'sms' => 1,
    'appointment_reminders' => 1
];
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
            margin-bottom: 32px;
        }
        
        .page-header h1 {
            color: #4d93c2ff;
            font-size: 28.8px;
            margin-bottom: 8px;
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
            grid-template-columns: 1fr 2fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        
        .profile-sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            height: fit-content;
        }
        
        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        
        .section-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
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
            margin-bottom: 12px;
            font-size: 18px;
        }
        
        .profile-photo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4d93c2ff;
            margin-bottom: 12px;
        }
        
        .btn-change-photo {
            background-color: #4d93c2ff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .btn-change-photo:hover {
            background-color: #1d5a8a;
        }
        
        .personal-info {
            margin-top: 16px;
        }
        
        .info-item {
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-item strong {
            color: #333;
            display: inline-block;
            width: 140px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
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
        
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 2px rgba(77, 147, 194, 0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .checkbox-group input {
            width: auto;
        }
        
        .action-buttons {
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
        
        .btn-outline {
            background-color: white;
            color: #4d93c2ff;
            border: 1px solid #4d93c2ff;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            line-height: normal;
        }
        
        .btn-outline:hover {
            background-color: #4d93c2ff;
            color: white;
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
            .profile-container {
                grid-template-columns: 1fr;
            }
            
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
            
            .action-buttons {
                flex-direction: column;
            }
            
            .info-grid {
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
                    <h1>Doctor Portal</h1>
                    <p>Welcome, Dr. <?php 
                        $doctorName = $doctor['full_name'] ?? 'Doctor';
                        $cleanedName = preg_replace('/^Dr\.\s*/i', '', $doctorName);
                        echo htmlspecialchars($cleanedName); 
                    ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="doctor_dashboard.php">Dashboard</a></li>
                        <li><a href="doctor_calendar.php">My Calendar</a></li>
                        <li><a href="patient_list.php">Patient List</a></li>
                        <li><a href="doctor_profile.php" class="active">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>My Profile</h1>
            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="profile-container">
            <!-- Sidebar with Personal Info -->
            <div class="profile-sidebar">
                <div class="profile-photo">
                    <img src="<?php echo htmlspecialchars($doctor['profile_picture'] ?? 'default_doctor_avatar.jpg'); ?>" alt="Doctor Profile Photo">
                    <button class="btn-change-photo">Change Photo</button>
                </div>
                <div class="personal-info">
                    <div class="info-item">
                        <strong>Full Name:</strong> Dr. <?php echo htmlspecialchars($cleanedName); ?>
                    </div>
                    <div class="info-item">
                        <strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?>
                    </div>
                    <div class="info-item">
                        <strong>Phone:</strong> <?php echo htmlspecialchars($doctor['phone_number'] ?? 'Not set'); ?>
                    </div>
                    <div class="info-item">
                        <strong>License No:</strong> <?php echo htmlspecialchars($doctor['license_number']); ?>
                    </div>
                    <div class="info-item">
                        <strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialization'] ?? 'Not specified'); ?>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="profile-main">
                <!-- Professional Information -->
                <section class="section-card">
                    <h2>Professional Information</h2>
                    <form method="POST">
                        <input type="hidden" name="update_profile" value="1">
                        <div class="info-grid">
                            <div class="form-group">
                                <label for="education">Education:</label>
                                <textarea id="education" name="education" placeholder="Enter your educational background..."><?php echo htmlspecialchars($doctor['education'] ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="qualifications">Qualifications:</label>
                                <textarea id="qualifications" name="qualifications" placeholder="Enter your professional qualifications..."><?php echo htmlspecialchars($doctor['qualifications'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization:</label>
                            <input type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($doctor['specialization'] ?? ''); ?>" placeholder="Enter your medical specialization">
                        </div>
                        <div class="form-group">
                            <label for="bio">Professional Bio:</label>
                            <textarea id="bio" name="bio" placeholder="Write about your professional experience and expertise..."><?php echo htmlspecialchars($doctor['bio'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($doctor['phone_number'] ?? ''); ?>" placeholder="+6012-345-6789">
                        </div>
                        <button type="submit" class="btn-primary">Update Professional Information</button>
                    </form>
                </section>

                <!-- Work Schedule -->
                <section class="section-card">
                    <h2>Work Schedule</h2>
                    <div class="info-grid">
                        <div>
                            <h3>Regular Hours</h3>
                            <?php if (count($weekly_availability) > 0): ?>
                                <?php foreach ($weekly_availability as $slot): ?>
                                    <p><?php echo ucfirst($slot['day_of_week']); ?>: 
                                        <?php echo date('g:i A', strtotime($slot['start_time'])) . ' - ' . date('g:i A', strtotime($slot['end_time'])); ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No regular hours set</p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3>Appointment Settings</h3>
                            <p>Consultation Duration: <?php echo $doctor['consultation_duration'] ?? 30; ?> minutes</p>
                            <p>Max Daily Appointments: <?php echo $doctor['max_daily_appointments'] ?? 15; ?> patients</p>
                        </div>
                    </div>
                </section>

                <!-- Account Settings -->
                <section class="section-card">
                    <h2>Account Settings</h2>
                    
                    <form method="POST">
                        <input type="hidden" name="update_password" value="1">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label for="current-password">Current Password:</label>
                            <input type="password" id="current-password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new-password">New Password:</label>
                            <input type="password" id="new-password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm New Password:</label>
                            <input type="password" id="confirm-password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn-primary">Update Password</button>
                    </form>
                    
                    <form method="POST" style="margin-top: 24px;">
                        <input type="hidden" name="update_notifications" value="1">
                        <h3>Notification Preferences</h3>
                        <div class="checkbox-group">
                            <input type="checkbox" id="email-notifications" name="email_notifications" <?php echo $notification_prefs['email'] ? 'checked' : ''; ?>>
                            <label for="email-notifications">Email Notifications</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="sms-notifications" name="sms_notifications" <?php echo $notification_prefs['sms'] ? 'checked' : ''; ?>>
                            <label for="sms-notifications">SMS Notifications</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="appointment-reminders" name="appointment_reminders" <?php echo $notification_prefs['appointment_reminders'] ? 'checked' : ''; ?>>
                            <label for="appointment-reminders">Appointment Reminders</label>
                        </div>
                        <button type="submit" class="btn-primary">Save Preferences</button>
                    </form>
                </section>

                <!-- Emergency Contact -->
                <section class="section-card">
                    <h2>Emergency Contact</h2>
                    <form method="POST">
                        <input type="hidden" name="update_emergency_contact" value="1">
                        <div class="info-grid">
                            <div class="form-group">
                                <label for="emergency_contact_name">Contact Person:</label>
                                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($doctor['emergency_contact_name'] ?? ''); ?>" placeholder="Full name">
                            </div>
                            <div class="form-group">
                                <label for="emergency_contact_relationship">Relationship:</label>
                                <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" value="<?php echo htmlspecialchars($doctor['emergency_contact_relationship'] ?? ''); ?>" placeholder="Spouse, Parent, etc.">
                            </div>
                            <div class="form-group">
                                <label for="emergency_contact_phone">Phone Number:</label>
                                <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo htmlspecialchars($doctor['emergency_contact_phone'] ?? ''); ?>" placeholder="+6012-345-6789">
                            </div>
                            <div class="form-group">
                                <label for="emergency_contact_email">Email:</label>
                                <input type="email" id="emergency_contact_email" name="emergency_contact_email" value="<?php echo htmlspecialchars($doctor['emergency_contact_email'] ?? ''); ?>" placeholder="email@example.com">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">Update Emergency Contact</button>
                    </form>
                </section>

                <!-- Action Buttons -->
                <section class="section-card">
                    <div class="action-buttons">
                        <button class="btn-primary" onclick="document.querySelector('form [name=\"update_profile\"]').closest('form').scrollIntoView({behavior: 'smooth'})">Edit Profile</button>
                        <a href="doctor_calendar.php" class="btn-outline">Update Schedule</a>
                        <button class="btn-secondary">Download Profile Data</button>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Add smooth scrolling for the Edit Profile button
        document.addEventListener('DOMContentLoaded', function() {
            const editProfileBtn = document.querySelector('.btn-primary[onclick*="update_profile"]');
            if (editProfileBtn) {
                editProfileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetForm = document.querySelector('form [name="update_profile"]').closest('form');
                    if (targetForm) {
                        targetForm.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>
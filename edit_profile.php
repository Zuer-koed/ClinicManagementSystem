<?php
// Start session and include database connection
session_start();
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Fetch current patient data
try {
    $stmt = $pdo->prepare("
        SELECT 
            p.patient_id,
            p.full_name,
            p.date_of_birth,
            u.email,
            p.phone_number,
            p.address,
            p.emergency_contact_name,
            p.emergency_contact_phone,
            p.blood_type,
            p.primary_care_physician,
            p.gender
        FROM patient p
        JOIN user u ON p.user_id = u.user_id
        WHERE p.user_id = ?
    ");
    
    $stmt->execute([$user_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$patient) {
        die("Patient profile not found.");
    }
    
} catch(PDOException $e) {
    error_log("Error fetching patient data: " . $e->getMessage());
    die("Error loading profile data.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $full_name = $_POST['full_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $phone_number = $_POST['phone'];
        $address = $_POST['address'];
        $emergency_contact_name = $_POST['emergency_contact_name'];
        $emergency_contact_phone = $_POST['emergency_contact_phone'];
        $blood_type = $_POST['blood_type'];
        $primary_care_physician = $_POST['primary_physician'];
        
        // Update patient data
        $update_stmt = $pdo->prepare("
            UPDATE patient 
            SET 
                full_name = ?,
                date_of_birth = ?,
                phone_number = ?,
                address = ?,
                emergency_contact_name = ?,
                emergency_contact_phone = ?,
                blood_type = ?,
                primary_care_physician = ?
            WHERE user_id = ?
        ");
        
        $update_stmt->execute([
            $full_name,
            $date_of_birth,
            $phone_number,
            $address,
            $emergency_contact_name,
            $emergency_contact_phone,
            $blood_type,
            $primary_care_physician,
            $user_id
        ]);
        
        // Update email in user table if changed
        if (isset($_POST['email']) && $_POST['email'] !== $patient['email']) {
            $email = $_POST['email'];
            $email_stmt = $pdo->prepare("UPDATE user SET email = ? WHERE user_id = ?");
            $email_stmt->execute([$email, $user_id]);
        }
        
        $success_message = "Profile updated successfully!";
        
        // Refresh patient data after update
        $stmt->execute([$user_id]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Error updating patient data: " . $e->getMessage());
        $error_message = "There was an error updating your profile. Please try again.";
    }
}

// Format data for form
$display_patient_id = "P-" . str_pad($patient['patient_id'], 4, '0', STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - Edit Profile</title>
    <style>
        /* Your existing CSS remains exactly the same */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
        }
        
        body {
            background-color: #f0f8ff;
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px 0;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            flex-wrap: wrap;
        }
        
        .logo {
            height: 180px;
            width: 180px;
        }
        
        .welcome-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .welcome-message {
            text-align: right;
        }
        
        .welcome-message h1 {
            font-size: 28px;
            color: #4d93c2ff;
            margin-bottom: 5px;
        }
        
        .welcome-message p {
            color: #666;
            font-size: 16px;
        }
        
        .logout-link {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border: 1px solid #ff6b6b;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 16px;
        }
        
        .logout-link:hover {
            background-color: #ff6b6b;
            color: white;
        }
        
        nav {
            width: 100%;
            margin-top: 20px;
            background-color: #4d93c2ff;
            border-radius: 6px;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        nav li {
            flex: 1;
            text-align: center;
        }
        
        nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 16px 10px;
            transition: background-color 0.3s;
            font-size: 16px;
            font-weight: 500;
        }
        
        nav a:hover, nav a.active {
            background-color: #1d5a8a;
        }
        
        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .page-title {
            color: #4d93c2ff;
            font-size: 32px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .profile-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            background-color: #f0f8ff;
            padding: 15px;
            margin: -30px -30px 25px -30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 22px;
            color: #4d93c2ff;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .required {
            color: #ff6b6b;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
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
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 140px;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #4d93c2ff;
            border: 2px solid #4d93c2ff;
        }
        
        .btn-outline:hover {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
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
        
        .readonly-field {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }
        
        footer {
            background-color: #1d4159ff;
            color: white;
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        footer p {
            color: white;
            font-size: 16px;
        }
        
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
                margin-top: 20px;
                gap: 15px;
            }
            
            .welcome-message {
                text-align: center;
            }
            
            nav a {
                padding: 14px 8px;
                font-size: 15px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <img src="Logo.png" alt="Nexus Care Clinic Logo" class="logo">
            <div class="welcome-section">
                <div class="welcome-message">
                    <h1>Edit Profile</h1>
                    <p>Welcome, <?php echo htmlspecialchars($patient['full_name']); ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="patient_dashboard.php">Dashboard</a></li>
                        <li><a href="my_appointment.php">My Appointments</a></li>
                        <li><a href="book_appointment.php">Book Appointment</a></li>
                        <li><a href="patient_profile.php">My Profile</a></li>
                        <li><a href="medical_history.php">Medical History</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <h1 class="page-title">Update Your Profile</h1>
        
        <div class="profile-section">
            <h2 class="section-title">Edit Personal Information</h2>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="edit_profile.php">
                <div class="form-group">
                    <label for="patient_id">Patient ID <span class="required">*</span></label>
                    <input type="text" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($display_patient_id); ?>" class="readonly-field" readonly>
                    <small style="color: #666; font-size: 14px;">Patient ID cannot be changed</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name">Full Name <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($patient['full_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone_number']); ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Address <span class="required">*</span></label>
                    <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="emergency_contact_name">Emergency Contact Name <span class="required">*</span></label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($patient['emergency_contact_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="emergency_contact_phone">Emergency Contact Phone <span class="required">*</span></label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo htmlspecialchars($patient['emergency_contact_phone']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="blood_type">Blood Type <span class="required">*</span></label>
                        <select id="blood_type" name="blood_type" required>
                            <option value="">Select Blood Type</option>
                            <option value="A+" <?php echo $patient['blood_type'] === 'A+' ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo $patient['blood_type'] === 'A-' ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo $patient['blood_type'] === 'B+' ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo $patient['blood_type'] === 'B-' ? 'selected' : ''; ?>>B-</option>
                            <option value="AB+" <?php echo $patient['blood_type'] === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo $patient['blood_type'] === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                            <option value="O+" <?php echo $patient['blood_type'] === 'O+' ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo $patient['blood_type'] === 'O-' ? 'selected' : ''; ?>>O-</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="primary_physician">Primary Care Physician</label>
                        <input type="text" id="primary_physician" name="primary_physician" value="<?php echo htmlspecialchars($patient['primary_care_physician']); ?>">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="patient_profile.php" class="btn btn-secondary">Cancel</a>
                    <button type="reset" class="btn btn-outline">Reset Changes</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Your existing JavaScript remains the same
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ff6b6b';
                    } else {
                        field.style.borderColor = '#ddd';
                    }
                });
                
                const emailField = document.getElementById('email');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailField.value && !emailRegex.test(emailField.value)) {
                    isValid = false;
                    emailField.style.borderColor = '#ff6b6b';
                    alert('Please enter a valid email address.');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
            
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.style.borderColor = '#ddd';
                });
            });
        });
    </script>
</body>
</html><?php
// Start session and include database connection
session_start();
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Fetch current patient data
try {
    $stmt = $pdo->prepare("
        SELECT 
            p.patient_id,
            p.full_name,
            p.date_of_birth,
            u.email,
            p.phone_number,
            p.address,
            p.emergency_contact_name,
            p.emergency_contact_phone,
            p.blood_type,
            p.primary_care_physician,
            p.gender
        FROM patient p
        JOIN user u ON p.user_id = u.user_id
        WHERE p.user_id = ?
    ");
    
    $stmt->execute([$user_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$patient) {
        die("Patient profile not found.");
    }
    
} catch(PDOException $e) {
    error_log("Error fetching patient data: " . $e->getMessage());
    die("Error loading profile data.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $full_name = $_POST['full_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $phone_number = $_POST['phone'];
        $address = $_POST['address'];
        $emergency_contact_name = $_POST['emergency_contact_name'];
        $emergency_contact_phone = $_POST['emergency_contact_phone'];
        $blood_type = $_POST['blood_type'];
        $primary_care_physician = $_POST['primary_physician'];
        
        // Update patient data
        $update_stmt = $pdo->prepare("
            UPDATE patient 
            SET 
                full_name = ?,
                date_of_birth = ?,
                phone_number = ?,
                address = ?,
                emergency_contact_name = ?,
                emergency_contact_phone = ?,
                blood_type = ?,
                primary_care_physician = ?
            WHERE user_id = ?
        ");
        
        $update_stmt->execute([
            $full_name,
            $date_of_birth,
            $phone_number,
            $address,
            $emergency_contact_name,
            $emergency_contact_phone,
            $blood_type,
            $primary_care_physician,
            $user_id
        ]);
        
        // Update email in user table if changed
        if (isset($_POST['email']) && $_POST['email'] !== $patient['email']) {
            $email = $_POST['email'];
            $email_stmt = $pdo->prepare("UPDATE user SET email = ? WHERE user_id = ?");
            $email_stmt->execute([$email, $user_id]);
        }
        
        $success_message = "Profile updated successfully!";
        
        // Refresh patient data after update
        $stmt->execute([$user_id]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Error updating patient data: " . $e->getMessage());
        $error_message = "There was an error updating your profile. Please try again.";
    }
}

// Format data for form
$display_patient_id = "P-" . str_pad($patient['patient_id'], 4, '0', STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - Edit Profile</title>
    <style>
        /* Your existing CSS remains exactly the same */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
        }
        
        body {
            background-color: #f0f8ff;
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px 0;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            flex-wrap: wrap;
        }
        
        .logo {
            height: 180px;
            width: 180px;
        }
        
        .welcome-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .welcome-message {
            text-align: right;
        }
        
        .welcome-message h1 {
            font-size: 28px;
            color: #4d93c2ff;
            margin-bottom: 5px;
        }
        
        .welcome-message p {
            color: #666;
            font-size: 16px;
        }
        
        .logout-link {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border: 1px solid #ff6b6b;
            border-radius: 4px;
            transition: all 0.3s;
            font-size: 16px;
        }
        
        .logout-link:hover {
            background-color: #ff6b6b;
            color: white;
        }
        
        nav {
            width: 100%;
            margin-top: 20px;
            background-color: #4d93c2ff;
            border-radius: 6px;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        nav li {
            flex: 1;
            text-align: center;
        }
        
        nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 16px 10px;
            transition: background-color 0.3s;
            font-size: 16px;
            font-weight: 500;
        }
        
        nav a:hover, nav a.active {
            background-color: #1d5a8a;
        }
        
        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .page-title {
            color: #4d93c2ff;
            font-size: 32px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .profile-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            background-color: #f0f8ff;
            padding: 15px;
            margin: -30px -30px 25px -30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 22px;
            color: #4d93c2ff;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .required {
            color: #ff6b6b;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
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
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-width: 140px;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #4d93c2ff;
            border: 2px solid #4d93c2ff;
        }
        
        .btn-outline:hover {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 25px;
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
        
        .readonly-field {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }
        
        footer {
            background-color: #1d4159ff;
            color: white;
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        footer p {
            color: white;
            font-size: 16px;
        }
        
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
                margin-top: 20px;
                gap: 15px;
            }
            
            .welcome-message {
                text-align: center;
            }
            
            nav a {
                padding: 14px 8px;
                font-size: 15px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <img src="Logo.png" alt="Nexus Care Clinic Logo" class="logo">
            <div class="welcome-section">
                <div class="welcome-message">
                    <h1>Edit Profile</h1>
                    <p>Welcome, <?php echo htmlspecialchars($patient['full_name']); ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="patient_dashboard.php">Dashboard</a></li>
                        <li><a href="my_appointment.php">My Appointments</a></li>
                        <li><a href="book_appointment.php">Book Appointment</a></li>
                        <li><a href="patient_profile.php">My Profile</a></li>
                        <li><a href="medical_history.php">Medical History</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <h1 class="page-title">Update Your Profile</h1>
        
        <div class="profile-section">
            <h2 class="section-title">Edit Personal Information</h2>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="edit_profile.php">
                <div class="form-group">
                    <label for="patient_id">Patient ID <span class="required">*</span></label>
                    <input type="text" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($display_patient_id); ?>" class="readonly-field" readonly>
                    <small style="color: #666; font-size: 14px;">Patient ID cannot be changed</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name">Full Name <span class="required">*</span></label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($patient['full_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone_number']); ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Address <span class="required">*</span></label>
                    <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="emergency_contact_name">Emergency Contact Name <span class="required">*</span></label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($patient['emergency_contact_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="emergency_contact_phone">Emergency Contact Phone <span class="required">*</span></label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo htmlspecialchars($patient['emergency_contact_phone']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="blood_type">Blood Type <span class="required">*</span></label>
                        <select id="blood_type" name="blood_type" required>
                            <option value="">Select Blood Type</option>
                            <option value="A+" <?php echo $patient['blood_type'] === 'A+' ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo $patient['blood_type'] === 'A-' ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo $patient['blood_type'] === 'B+' ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo $patient['blood_type'] === 'B-' ? 'selected' : ''; ?>>B-</option>
                            <option value="AB+" <?php echo $patient['blood_type'] === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo $patient['blood_type'] === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                            <option value="O+" <?php echo $patient['blood_type'] === 'O+' ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo $patient['blood_type'] === 'O-' ? 'selected' : ''; ?>>O-</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="primary_physician">Primary Care Physician</label>
                        <input type="text" id="primary_physician" name="primary_physician" value="<?php echo htmlspecialchars($patient['primary_care_physician']); ?>">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="patient_profile.php" class="btn btn-secondary">Cancel</a>
                    <button type="reset" class="btn btn-outline">Reset Changes</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Your existing JavaScript remains the same
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ff6b6b';
                    } else {
                        field.style.borderColor = '#ddd';
                    }
                });
                
                const emailField = document.getElementById('email');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailField.value && !emailRegex.test(emailField.value)) {
                    isValid = false;
                    emailField.style.borderColor = '#ff6b6b';
                    alert('Please enter a valid email address.');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
            
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.style.borderColor = '#ddd';
                });
            });
        });
    </script>
</body>
</html>
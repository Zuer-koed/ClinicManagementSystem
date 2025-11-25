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

$staff_id = $_SESSION['user_id'];

// Get staff information
$stmt = $pdo->prepare("SELECT * FROM staff WHERE staff_id = ?");
$stmt->execute([$staff_id]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'confirm' && isset($_POST['request_id'])) {
            // Confirm appointment request
            $appointment_id = $_POST['request_id'];
            $doctor_id = $_POST['doctor_id'];
            $appointment_time = $_POST['appointment_time'];
            
            $stmt = $pdo->prepare("UPDATE appointment SET doctor_id = ?, preferred_time = ?, status = 'confirmed' WHERE appointment_id = ?");
            $stmt->execute([$doctor_id, $appointment_time, $appointment_id]);
            $success = "Appointment confirmed successfully!";
            
        } elseif ($action === 'reject' && isset($_POST['request_id'])) {
            // Reject appointment request
            $appointment_id = $_POST['request_id'];
            $stmt = $pdo->prepare("UPDATE appointment SET status = 'cancelled' WHERE appointment_id = ?");
            $stmt->execute([$appointment_id]);
            $success = "Appointment request rejected!";
            
        } elseif ($action === 'walkin') {
            // Register walk-in patient
            $patient_type = $_POST['patient_type'];
            $doctor_id = $_POST['walkin_doctor'];
            $reason = $_POST['walkin_reason'];
            
            if ($patient_type === 'existing') {
                $search_term = $_POST['search_patient'];
                // Search for existing patient
                $stmt = $pdo->prepare("SELECT patient_id FROM patient WHERE full_name LIKE ? OR patient_id = ? LIMIT 1");
                $stmt->execute(["%$search_term%", $search_term]);
                $patient = $stmt->fetch(PDO::FETCH_ASSOC);
                $patient_id = $patient ? $patient['patient_id'] : null;
            } else {
                // Create new patient record
                $walkin_name = $_POST['walkin_name'];
                $walkin_phone = $_POST['walkin_phone'];
                
                // First create user account
                $stmt = $pdo->prepare("INSERT INTO user (email, password_hash, role) VALUES (?, ?, 'patient')");
                $temp_email = uniqid() . '@walkin.com';
                $temp_password = password_hash('temp123', PASSWORD_DEFAULT);
                $stmt->execute([$temp_email, $temp_password]);
                $user_id = $pdo->lastInsertId();
                
                // Then create patient record
                $stmt = $pdo->prepare("INSERT INTO patient (user_id, full_name, phone_number) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $walkin_name, $walkin_phone]);
                $patient_id = $pdo->lastInsertId();
            }
            
            if ($patient_id) {
                $stmt = $pdo->prepare("INSERT INTO appointment (patient_id, doctor_id, preferred_date, preferred_time, reason, status) VALUES (?, ?, CURDATE(), NOW(), ?, 'walk_in')");
                $stmt->execute([$patient_id, $doctor_id, $reason]);
                $success = "Walk-in patient registered successfully!";
            }
            
        } elseif ($action === 'emergency') {
            // Register emergency case
            $emergency_name = $_POST['emergency_name'];
            $doctor_id = $_POST['emergency_doctor'];
            $emergency_reason = $_POST['emergency_reason'];
            $priority = $_POST['emergency_priority'];
            
            // Create temporary patient record for emergency
            $stmt = $pdo->prepare("INSERT INTO user (email, password_hash, role) VALUES (?, ?, 'patient')");
            $temp_email = uniqid() . '@emergency.com';
            $temp_password = password_hash('temp123', PASSWORD_DEFAULT);
            $stmt->execute([$temp_email, $temp_password]);
            $user_id = $pdo->lastInsertId();
            
            $stmt = $pdo->prepare("INSERT INTO patient (user_id, full_name) VALUES (?, ?)");
            $stmt->execute([$user_id, $emergency_name]);
            $patient_id = $pdo->lastInsertId();
            
            $stmt = $pdo->prepare("INSERT INTO appointment (patient_id, doctor_id, preferred_date, preferred_time, reason, status) VALUES (?, ?, CURDATE(), NOW(), ?, 'emergency')");
            $stmt->execute([$patient_id, $doctor_id, $emergency_reason]);
            $success = "Emergency case registered successfully!";
        }
    }
}

// Get pending appointment requests
$pendingStmt = $pdo->query("
    SELECT a.*, p.full_name as patient_name, p.phone_number, u.email 
    FROM appointment a 
    JOIN patient p ON a.patient_id = p.patient_id 
    JOIN user u ON p.user_id = u.user_id 
    WHERE a.status = 'pending' 
    ORDER BY a.created_at DESC
");
$pendingRequests = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

// Get today's appointments
$todayStmt = $pdo->query("
    SELECT a.*, p.full_name as patient_name, d.full_name as doctor_name 
    FROM appointment a 
    JOIN patient p ON a.patient_id = p.patient_id 
    JOIN doctor d ON a.doctor_id = d.doctor_id 
    WHERE a.preferred_date = CURDATE() AND a.status IN ('confirmed', 'emergency', 'walk_in')
    ORDER BY a.preferred_time
");
$todayAppointments = $todayStmt->fetchAll(PDO::FETCH_ASSOC);

// Get doctors for dropdowns
$doctorsStmt = $pdo->query("SELECT * FROM doctor");
$doctors = $doctorsStmt->fetchAll(PDO::FETCH_ASSOC);

// Get queue by doctor
$queueStmt = $pdo->query("
    SELECT a.*, p.full_name as patient_name, d.full_name as doctor_name 
    FROM appointment a 
    JOIN patient p ON a.patient_id = p.patient_id 
    JOIN doctor d ON a.doctor_id = d.doctor_id 
    WHERE a.preferred_date = CURDATE() AND a.status IN ('confirmed', 'emergency', 'walk_in')
    ORDER BY d.doctor_id, a.status DESC, a.preferred_time
");
$queueData = $queueStmt->fetchAll(PDO::FETCH_ASSOC);

// Group queue by doctor
$doctorQueues = [];
foreach ($queueData as $appointment) {
    $doctorName = $appointment['doctor_name'];
    if (!isset($doctorQueues[$doctorName])) {
        $doctorQueues[$doctorName] = [];
    }
    $doctorQueues[$doctorName][] = $appointment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Manage Appointments</title>
    <style>
        /* ... (keep all the existing CSS styles) ... */
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
        
        .section-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 24px;
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
        
        .quick-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        button {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
        
        .btn-link {
            background-color: transparent;
            color: #4d93c2ff;
            text-decoration: underline;
            padding: 8px 16px;
        }
        
        .btn-link:hover {
            color: #1d5a8a;
        }
        
        .request-card {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 16px;
            border-left: 4px solid #4d93c2ff;
        }
        
        .request-card h4 {
            color: #4d93c2ff;
            margin-bottom: 12px;
        }
        
        .form-group {
            margin-bottom: 16px;
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
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin-bottom: 16px;
        }
        
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
        }
        
        .radio-group input {
            width: auto;
        }
        
        .queue-section {
            margin-bottom: 24px;
        }
        
        .queue-card {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 16px;
        }
        
        .queue-card h4 {
            color: #4d93c2ff;
            margin-bottom: 12px;
        }
        
        .queue-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background-color: white;
            border-radius: 4px;
            margin-bottom: 8px;
            border-left: 4px solid #4d93c2ff;
        }
        
        .queue-item-emergency {
            border-left-color: #ff6b6b;
            background-color: #ffebee;
        }
        
        .queue-item-walkin {
            border-left-color: #28a745;
        }
        
        .queue-actions {
            display: flex;
            gap: 8px;
        }
        
        .queue-actions button {
            padding: 6px 12px;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background-color: #f0f8ff;
            color: #4d93c2ff;
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-emergency {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-walkin {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-waiting {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .table-actions a {
            color: #4d93c2ff;
            text-decoration: none;
            margin-right: 10px;
            font-weight: 500;
        }
        
        .table-actions a:hover {
            text-decoration: underline;
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
            
            .quick-actions {
                flex-direction: column;
            }
            
            .queue-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .queue-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            table {
                display: block;
                overflow-x: auto;
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
                    <p>Welcome, <?php echo htmlspecialchars($staff['full_name'] ?? 'Staff Member'); ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="staff_dashboard.php">Dashboard</a></li>
                        <li><a href="staff_manage_appointment.php" class="active">Manage Appointments</a></li>
                        <li><a href="staff_patient_list.php">Patient List</a></li>
                        <li><a href="staff_profile.php">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>Appointment Management Center</h1>
        </div>

        <?php if (isset($success)): ?>
            <div class="section-card" style="background-color: #d4edda; color: #155724;">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Quick Action Buttons -->
        <section class="section-card">
            <h2>Quick Actions</h2>
            <div class="quick-actions">
                <button onclick="showWalkInForm()" class="btn-primary">New Walk-in Patient</button>
                <button onclick="showEmergencyForm()" class="btn-primary">New Emergency Case</button>
                <a href="#pending-requests" class="btn-link">View Pending Requests (<?php echo count($pendingRequests); ?>)</a>
                <a href="#queue-management" class="btn-link">Manage Queues</a>
            </div>
        </section>

        <!-- Pending Appointment Requests Section -->
        <section id="pending-requests" class="section-card">
            <h2>Pending Appointment Requests</h2>
            
            <?php if (count($pendingRequests) > 0): ?>
                <?php foreach ($pendingRequests as $request): ?>
                <div class="request-card">
                    <h4>Request #R-<?php echo str_pad($request['appointment_id'], 3, '0', STR_PAD_LEFT); ?></h4>
                    <p><strong>Patient:</strong> <?php echo htmlspecialchars($request['patient_name']); ?></p>
                    <p><strong>Preferred Date/Time:</strong> <?php echo $request['preferred_date'] . ', ' . $request['preferred_time']; ?></p>
                    <p><strong>Reason:</strong> <?php echo htmlspecialchars($request['reason']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($request['email']); ?> | <?php echo htmlspecialchars($request['phone_number'] ?? 'N/A'); ?></p>
                    
                    <form action="" method="post">
                        <input type="hidden" name="request_id" value="<?php echo $request['appointment_id']; ?>">
                        <div class="form-group">
                            <label for="doctor<?php echo $request['appointment_id']; ?>">Assign Doctor:</label>
                            <select id="doctor<?php echo $request['appointment_id']; ?>" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo htmlspecialchars($doctor['full_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appointment_time<?php echo $request['appointment_id']; ?>">Appointment Time:</label>
                            <input type="datetime-local" id="appointment_time<?php echo $request['appointment_id']; ?>" name="appointment_time" required>
                        </div>
                        <div class="quick-actions">
                            <button type="submit" name="action" value="confirm" class="btn-primary">Confirm Appointment</button>
                            <button type="submit" name="action" value="reject" class="btn-danger">Reject Request</button>
                        </div>
                    </form>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No pending appointment requests.</p>
            <?php endif; ?>
        </section>

        <!-- Walk-in Registration Form (Initially Hidden) -->
        <section id="walkin-form" class="section-card" style="display: none;">
            <h2>Register Walk-in Patient</h2>
            <form action="" method="post">
                <div class="radio-group">
                    <label><input type="radio" name="patient_type" value="existing" checked> Existing Patient</label>
                    <label><input type="radio" name="patient_type" value="new"> New Patient</label>
                </div>
                
                <div id="existing-patient">
                    <div class="form-group">
                        <label for="search_patient">Search Patient:</label>
                        <input type="text" id="search_patient" name="search_patient" placeholder="Enter patient name or ID">
                    </div>
                </div>
                
                <div id="new-patient" style="display: none;">
                    <div class="form-group">
                        <label for="walkin_name">Full Name:</label>
                        <input type="text" id="walkin_name" name="walkin_name">
                    </div>
                    <div class="form-group">
                        <label for="walkin_phone">Phone Number:</label>
                        <input type="tel" id="walkin_phone" name="walkin_phone">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="walkin_doctor">Assign to Doctor:</label>
                    <select id="walkin_doctor" name="walkin_doctor" required>
                        <option value="">Select Doctor</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo htmlspecialchars($doctor['full_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="walkin_reason">Reason for Visit:</label>
                    <input type="text" id="walkin_reason" name="walkin_reason" required>
                </div>
                
                <div class="quick-actions">
                    <button type="submit" name="action" value="walkin" class="btn-primary">Register Walk-in</button>
                    <button type="button" onclick="hideWalkInForm()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </section>

        <!-- Emergency Registration Form (Initially Hidden) -->
        <section id="emergency-form" class="section-card" style="display: none;">
            <h2>Register Emergency Case</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="emergency_name">Patient Name:</label>
                    <input type="text" id="emergency_name" name="emergency_name" required>
                </div>
                
                <div class="form-group">
                    <label for="emergency_doctor">Assign to Doctor:</label>
                    <select id="emergency_doctor" name="emergency_doctor" required>
                        <option value="">Select Doctor</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo htmlspecialchars($doctor['full_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="emergency_reason">Emergency Details:</label>
                    <textarea id="emergency_reason" name="emergency_reason" required placeholder="Describe the emergency situation"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="emergency_priority">Priority Level:</label>
                    <select id="emergency_priority" name="emergency_priority">
                        <option value="high">High Priority</option>
                        <option value="critical">Critical (Immediate)</option>
                    </select>
                </div>
                
                <div class="quick-actions">
                    <button type="submit" name="action" value="emergency" class="btn-primary">Register Emergency</button>
                    <button type="button" onclick="hideEmergencyForm()" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </section>

        <!-- Queue Management Section -->
        <section id="queue-management" class="section-card">
            <h2>Current Queues</h2>
            
            <?php foreach ($doctorQueues as $doctorName => $queue): ?>
            <div class="queue-section">
                <h3><?php echo htmlspecialchars($doctorName); ?>'s Queue</h3>
                <div class="queue-card">
                    <?php foreach ($queue as $appointment): ?>
                    <div class="queue-item <?php echo $appointment['status'] === 'emergency' ? 'queue-item-emergency' : ($appointment['status'] === 'walk_in' ? 'queue-item-walkin' : ''); ?>">
                        <div>
                            <strong><?php echo htmlspecialchars($appointment['patient_name']); ?></strong> 
                            (<?php echo strtoupper($appointment['status']); ?>) - 
                            <?php echo htmlspecialchars($appointment['reason']); ?>
                        </div>
                        <div class="queue-actions">
                            <button class="btn-primary">Move Up</button>
                            <button class="btn-secondary">Move Down</button>
                            <button class="btn-danger">Remove</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- Today's Appointments Overview -->
        <section class="section-card">
            <h2>Today's Appointments Summary</h2>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($todayAppointments) > 0): ?>
                        <?php foreach ($todayAppointments as $appointment): ?>
                        <tr>
                            <td><?php echo date('g:i A', strtotime($appointment['preferred_time'])); ?></td>
                            <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $appointment['status']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $appointment['status'])); ?>
                                </span>
                            </td>
                            <td><span class="status-badge status-waiting">Waiting</span></td>
                            <td class="table-actions">
                                <a href="#">Edit</a> | <a href="#">Cancel</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No appointments for today.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function showWalkInForm() {
            document.getElementById('walkin-form').style.display = 'block';
            document.getElementById('emergency-form').style.display = 'none';
        }
        
        function showEmergencyForm() {
            document.getElementById('emergency-form').style.display = 'block';
            document.getElementById('walkin-form').style.display = 'none';
        }
        
        function hideWalkInForm() {
            document.getElementById('walkin-form').style.display = 'none';
        }
        
        function hideEmergencyForm() {
            document.getElementById('emergency-form').style.display = 'none';
        }

        // Handle patient type radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            const patientTypeRadios = document.querySelectorAll('input[name="patient_type"]');
            const existingPatientDiv = document.getElementById('existing-patient');
            const newPatientDiv = document.getElementById('new-patient');
            
            patientTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'existing') {
                        existingPatientDiv.style.display = 'block';
                        newPatientDiv.style.display = 'none';
                    } else {
                        existingPatientDiv.style.display = 'none';
                        newPatientDiv.style.display = 'block';
                    }
                });
            });
        });
    </script>
</body>
</html>
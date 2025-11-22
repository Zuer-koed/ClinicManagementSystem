<?php
session_start();
require_once 'db_connection.php';

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$patient_id = $_GET['patient_id'] ?? 0;

// Get doctor information
$stmt = $pdo->prepare("SELECT * FROM doctor WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

// Get patient details
$stmt = $pdo->prepare("
    SELECT p.*, u.email 
    FROM patient p 
    JOIN user u ON p.user_id = u.user_id 
    WHERE p.patient_id = ?
");
$stmt->execute([$patient_id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header('Location: patient_list.php');
    exit();
}

// Calculate age
$age = '';
if ($patient['date_of_birth']) {
    $dob = new DateTime($patient['date_of_birth']);
    $today = new DateTime();
    $age = $today->diff($dob)->y;
}

// Get medical history for this patient with current doctor
$stmt = $pdo->prepare("
    SELECT mh.*, a.preferred_date as appointment_date, a.reason as visit_reason, d.full_name as doctor_name
    FROM medical_history mh 
    LEFT JOIN appointment a ON mh.appointment_id = a.appointment_id 
    LEFT JOIN doctor d ON mh.doctor_id = d.doctor_id 
    WHERE mh.patient_id = ? AND mh.doctor_id = ?
    ORDER BY mh.diagnosis_date DESC
");
$stmt->execute([$patient_id, $doctor_id]);
$medical_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for new medical record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_record'])) {
    $diagnosis_date = $_POST['diagnosis_date'];
    $diagnosis = $_POST['diagnosis'];
    $medication_name = $_POST['medication_name'];
    $dosage = $_POST['dosage'];
    $frequency = $_POST['frequency'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $instructions = $_POST['instructions'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];
    
    $stmt = $pdo->prepare("
        INSERT INTO medical_history 
        (patient_id, doctor_id, diagnosis_date, diagnosis, medication_name, dosage, frequency, start_date, end_date, instructions, status, notes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $patient_id, $doctor_id, $diagnosis_date, $diagnosis, $medication_name, 
        $dosage, $frequency, $start_date, $end_date, $instructions, $status, $notes
    ]);
    
    $success = "Medical record added successfully!";
    
    // Refresh medical history
    $stmt = $pdo->prepare("
        SELECT mh.*, a.preferred_date as appointment_date, a.reason as visit_reason, d.full_name as doctor_name
        FROM medical_history mh 
        LEFT JOIN appointment a ON mh.appointment_id = a.appointment_id 
        LEFT JOIN doctor d ON mh.doctor_id = d.doctor_id 
        WHERE mh.patient_id = ? AND mh.doctor_id = ?
        ORDER BY mh.diagnosis_date DESC
    ");
    $stmt->execute([$patient_id, $doctor_id]);
    $medical_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Patient Details</title>
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
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #4d93c2ff;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 24px;
            padding: 8px 16px;
            border: 1px solid #4d93c2ff;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            background-color: #4d93c2ff;
            color: white;
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
        
        .section-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
            margin-bottom: 24px;
        }
        
        .section-container h2 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .section-container h3 {
            color: #4d93c2ff;
            margin-bottom: 16px;
            font-size: 18px;
        }
        
        .patient-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
        }
        
        .info-item {
            margin-bottom: 12px;
        }
        
        .info-item strong {
            color: #333;
            display: inline-block;
            width: 160px;
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
        
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status.active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status.resolved {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status.chronic {
            background-color: #fff3cd;
            color: #856404;
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
            min-height: 80px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        .button-group {
            display: flex;
            gap: 16px;
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
            
            .patient-info {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .form-row {
                grid-template-columns: 1fr;
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
                        <li><a href="patient_list.php" class="active">Patient List</a></li>
                        <li><a href="doctor_profile.php">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>Patient Details</h1>
        </div>
        
        <a href="patient_list.php" class="back-link">← Back to Patient List</a>

        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Patient Profile Section -->
        <section class="section-container">
            <h2>Patient Profile</h2>
            <div class="patient-info">
                <div>
                    <div class="info-item"><strong>Patient ID:</strong> P-<?php echo str_pad($patient['patient_id'], 3, '0', STR_PAD_LEFT); ?></div>
                    <div class="info-item"><strong>Full Name:</strong> <?php echo htmlspecialchars($patient['full_name']); ?></div>
                    <div class="info-item"><strong>Date of Birth:</strong> <?php echo $patient['date_of_birth'] . ($age ? " (Age: $age)" : ''); ?></div>
                    <div class="info-item"><strong>Gender:</strong> <?php echo ucfirst($patient['gender'] ?? 'Not specified'); ?></div>
                    <div class="info-item"><strong>Contact Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></div>
                </div>
                <div>
                    <div class="info-item"><strong>Phone Number:</strong> <?php echo htmlspecialchars($patient['phone_number'] ?? 'Not provided'); ?></div>
                    <div class="info-item"><strong>Address:</strong> <?php echo htmlspecialchars($patient['address'] ?? 'Not provided'); ?></div>
                </div>
            </div>
        </section>

        <!-- Medical History Section -->
        <section class="section-container">
            <h2>Medical History</h2>
            <?php if (count($medical_history) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Diagnosis</th>
                            <th>Medication</th>
                            <th>Dosage</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medical_history as $record): ?>
                            <tr>
                                <td><?php echo $record['diagnosis_date']; ?></td>
                                <td><?php echo htmlspecialchars($record['diagnosis']); ?></td>
                                <td><?php echo htmlspecialchars($record['medication_name']); ?></td>
                                <td><?php echo htmlspecialchars($record['dosage']); ?></td>
                                <td><span class="status <?php echo $record['status']; ?>"><?php echo ucfirst($record['status']); ?></span></td>
                                <td><?php echo htmlspecialchars($record['notes']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No medical history records found for this patient.</p>
            <?php endif; ?>
        </section>

        <!-- Add Medical Record Form -->
        <section class="section-container">
            <h2>Add Medical Record</h2>
            <form action="" method="post">
                <input type="hidden" name="add_record" value="1">
                <div class="form-row">
                    <div class="form-group">
                        <label for="diagnosis_date">Diagnosis Date:</label>
                        <input type="date" id="diagnosis_date" name="diagnosis_date" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="resolved">Resolved</option>
                            <option value="chronic">Chronic</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="diagnosis">Diagnosis:</label>
                    <textarea id="diagnosis" name="diagnosis" rows="3" placeholder="Enter diagnosis details" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="medication_name">Medication Name:</label>
                        <input type="text" id="medication_name" name="medication_name" placeholder="Enter medication name">
                    </div>
                    <div class="form-group">
                        <label for="dosage">Dosage:</label>
                        <input type="text" id="dosage" name="dosage" placeholder="e.g., 500mg">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="frequency">Frequency:</label>
                        <input type="text" id="frequency" name="frequency" placeholder="e.g., Twice daily">
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date">
                    </div>
                </div>
                <div class="form-group">
                    <label for="instructions">Instructions:</label>
                    <textarea id="instructions" name="instructions" rows="2" placeholder="Special instructions for medication"></textarea>
                </div>
                <div class="form-group">
                    <label for="notes">Additional Notes:</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Additional observations and recommendations"></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-primary">Add Medical Record</button>
                    <button type="reset" class="btn-secondary">Clear Form</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
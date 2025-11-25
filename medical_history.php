<?php
session_start();
require_once 'db_connection.php';
$database = new Database();
$pdo = $database->getConnection();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

try {
    // Get patient info
    $stmt = $pdo->prepare("
        SELECT p.full_name, p.patient_id
        FROM patient p
        WHERE p.user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        header("Location: logout.php");
        exit();
    }

    $patient_name = $patient['full_name'];
    $patient_id   = $patient['patient_id'];

    // Get medical history
    $mhStmt = $pdo->prepare("
        SELECT 
            mh.diagnosis_date,
            mh.diagnosis,
            mh.medication_name,
            mh.dosage,
            mh.frequency,
            mh.notes,
            mh.status,
            d.full_name AS doctor_name,
            d.specialization
        FROM medical_history mh
        JOIN doctor d ON mh.doctor_id = d.doctor_id
        WHERE mh.patient_id = ?
        ORDER BY mh.diagnosis_date DESC, mh.mhistory_id DESC
    ");
    $mhStmt->execute([$patient_id]);
    $history = $mhStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $patient_name = "Patient";
    $history = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - Medical History</title>
    <style>
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
        
        .history-section {
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
        
        .medical-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .medical-table th, .medical-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        
        .medical-table th {
            background-color: #f0f8ff;
            color: #4d93c2ff;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        .medical-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .empty-row {
            color: #999;
            font-style: italic;
            text-align: center;
        }
        
        .notes-cell {
            max-width: 300px;
            word-wrap: break-word;
        }
        
        /* Status indicator for records */
        .record-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }
        
        .status-active {
            background-color: #fff4e6;
            color: #cc5c00;
        }
        
        .status-resolved {
            background-color: #e7f7ef;
            color: #0d6832;
        }
        
        .status-chronic {
            background-color: #e6f0ff;
            color: #0d3f68;
        }
        
        .doctor-specialty {
            display: block;
            font-size: 12px;
            color: #666;
            margin-top: 5px;
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
        
        .info-message {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            border-left: 4px solid #4d93c2ff;
        }
        
        .info-message p {
            margin: 0;
            color: #4d93c2ff;
            font-size: 14px;
        }
        
        @media print {
            .logout-link, nav {
                display: none;
            }
            
            .history-section {
                box-shadow: none;
                border: 1px solid #ddd;
            }
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
            
            .medical-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            .medical-table th, .medical-table td {
                padding: 10px 8px;
                font-size: 14px;
            }
            
            .notes-cell {
                max-width: 200px;
                white-space: normal;
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
                    <h1>Medical History</h1>
                    <p>Welcome, <?php echo htmlspecialchars($patient_name); ?>!</p>
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
                        <li><a href="medical_history.php" class="active">Medical History</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <h1 class="page-title">Medical History</h1>
        
        <div class="history-section">
            <h2 class="section-title">Treatment Records</h2>
            
            <table class="medical-table" aria-label="Patient medical history records">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Doctor Seen</th>
                        <th scope="col">Diagnosis</th>
                        <th scope="col">Prescribed Medications</th>
                        <th scope="col" class="notes-cell">Doctor's Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($history)): ?>
                        <tr>
                            <td colspan="5" class="empty-row">
                                No medical history records found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($history as $row): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($row['diagnosis_date']); ?><br>
                                    <span class="record-status status-<?php echo htmlspecialchars($row['status']); ?>">
                                        <?php echo ucfirst(htmlspecialchars($row['status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['doctor_name']); ?><br>
                                    <span class="doctor-specialty">
                                        <?php echo htmlspecialchars($row['specialization']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($row['medication_name']); ?>
                                    <?php echo $row['dosage'] ? ' - ' . htmlspecialchars($row['dosage']) : ''; ?><br>
                                    <?php echo htmlspecialchars($row['frequency']); ?>
                                </td>
                                <td class="notes-cell">
                                    <?php echo nl2br(htmlspecialchars($row['notes'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="info-message">
                <p><strong>Note:</strong> This is your complete medical history. Contact the clinic if you notice any discrepancies.</p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

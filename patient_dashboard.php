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

try {
  
    $stmt = $pdo->prepare("
        SELECT p.full_name, p.patient_id
        FROM patient p
        WHERE p.user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $patient = $stmt->fetch();

   
    if (!$patient) {
        header("Location: login.php?error=no_patient_profile");
        exit();
    }

    $patient_name = $patient['full_name'];
    $patient_id   = $patient['patient_id'];


    $nextStmt = $pdo->prepare("
        SELECT a.preferred_date, a.preferred_time, d.full_name AS doctor_name, a.status
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.doctor_id
        WHERE a.patient_id = ?
          AND a.status IN ('pending', 'confirmed')
          AND a.preferred_date >= CURDATE()
        ORDER BY a.preferred_date ASC
        LIMIT 1
    ");
    $nextStmt->execute([$patient_id]);
    $nextAppointment = $nextStmt->fetch();


    
    $statsStmt = $pdo->prepare("
        SELECT
            COUNT(*) AS total,
            SUM(a.status = 'pending') AS pending,
            SUM(a.status = 'completed') AS completed,
            SUM(a.status = 'confirmed') AS upcoming
        FROM appointment a
        WHERE a.patient_id = ?
    ");
    $statsStmt->execute([$patient_id]);
    $stats = $statsStmt->fetch();

    if (!$stats) {
        $stats = [
            'total'     => 0,
            'pending'   => 0,
            'completed' => 0,
            'upcoming'  => 0,
        ];
    }

} catch (PDOException $e) {

   
    header("Location: login.php?error=db_error");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - Patient Dashboard</title>
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .dashboard-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .dashboard-section h2 {
            background-color: #f0f8ff;
            padding: 15px;
            margin: -30px -30px 25px -30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 22px;
            color: #4d93c2ff;
        }
        
        h1 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 32px;
        }
        
        h2 {
            color: #4d93c2ff;
            margin: 25px 0 20px;
            font-size: 24px;
        }
        
        p {
            margin-bottom: 20px;
            color: #666;
            font-size: 16px;
        }
        
        .appointment-info {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 6px;
            border-left: 4px solid #4d93c2ff;
            margin-bottom: 20px;
        }
        
        .appointment-info p {
            margin-bottom: 12px;
            font-size: 16px;
        }
        
        .appointment-info strong {
            color: #4d93c2ff;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-card {
            background-color: #f0f8ff;
            padding: 25px;
            border-radius: 6px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #4d93c2ff;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 16px;
            color: #666;
        }
        
        .no-appointment {
            text-align: center;
            padding: 40px 25px;
            color: #666;
        }
        
        .no-appointment p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
            transform: translateY(-2px);
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 25px;
        }
        
        .action-btn {
            background-color: #f0f8ff;
            border: 2px solid #4d93c2ff;
            color: #4d93c2ff;
            padding: 15px;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background-color: #4d93c2ff;
            color: white;
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
            main {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .quick-actions {
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
                margin-top: 20px;
                gap: 15px;
            }
            
            .welcome-message {
                text-align: center;
            }
            
            .dashboard-section {
                padding: 25px;
            }
            
            .dashboard-section h2 {
                margin: -25px -25px 20px -25px;
                padding: 12px;
            }
            
            .stat-number {
                font-size: 28px;
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
                    <h1>Patient Dashboard</h1>
                    <p>Welcome, <?php echo htmlspecialchars($patient_name); ?>!</p>
                </div>
                
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="patient_dashboard.php" class="active">Dashboard</a></li>
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
       
        <div class="dashboard-section">
            <h2>Next Appointment</h2>

            <?php if ($nextAppointment): ?>
                <div class="appointment-info">
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($nextAppointment['preferred_date']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($nextAppointment['preferred_time']); ?></p>
                    <p><strong>Doctor:</strong> <?php echo htmlspecialchars($nextAppointment['doctor_name']); ?></p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="status-badge status-<?php echo htmlspecialchars($nextAppointment['status']); ?>">
                            <?php echo ucfirst(htmlspecialchars($nextAppointment['status'])); ?>
                        </span>
                    </p>
                </div>
            <?php else: ?>
                <div class="no-appointment">
                    <p>No upcoming appointments scheduled</p>
                    <p style="font-size: 14px; margin-bottom: 25px;">
                        Book your next appointment to get started with your healthcare journey.
                    </p>
                    <a href="book_appointment.php" class="btn-primary">Book New Appointment</a>
                </div>
            <?php endif; ?>
        </div>
        
        
        <div class="dashboard-section">
            <h2>Quick Stats</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo (int)$stats['total']; ?></div>
                    <div class="stat-label">Total Appointments</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo (int)$stats['pending']; ?></div>
                    <div class="stat-label">Pending Appointments</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo (int)$stats['completed']; ?></div>
                    <div class="stat-label">Completed Visits</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo (int)$stats['upcoming']; ?></div>
                    <div class="stat-label">Upcoming Visits</div>
                </div>
            </div>
            
            <div style="margin-top: 30px;">
                <h3 style="color: #4d93c2ff; margin-bottom: 15px; font-size: 18px;">Quick Actions</h3>
                <div class="quick-actions">
                    <a href="book_appointment.php" class="action-btn">Book Appointment</a>
                    <a href="medical_history.php" class="action-btn">View Medical History</a>
                    <a href="patient_profile.php" class="action-btn">Update Profile</a>
                    <a href="my_appointment.php" class="action-btn">My Appointments</a>
                </div>
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

<?php
session_start();
require_once 'db_connection.php';
$database = new Database();
$pdo = $database->getConnection();

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Get doctor information
$stmt = $pdo->prepare("SELECT * FROM doctor WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle view type and date range
$view_type = $_GET['view'] ?? 'week'; // Default to week view
$current_date = $_GET['date'] ?? date('Y-m-d');

// Calculate date ranges based on view type
switch ($view_type) {
    case 'day':
        $start_date = $current_date;
        $end_date = $current_date;
        $display_text = date('l, F j, Y', strtotime($current_date));
        break;
    case 'month':
        $start_date = date('Y-m-01', strtotime($current_date));
        $end_date = date('Y-m-t', strtotime($current_date));
        $display_text = date('F Y', strtotime($current_date));
        break;
    case 'week':
    default:
        $start_date = date('Y-m-d', strtotime('monday this week', strtotime($current_date)));
        $end_date = date('Y-m-d', strtotime('sunday this week', strtotime($current_date)));
        $display_text = date('M j', strtotime($start_date)) . ' - ' . date('M j, Y', strtotime($end_date));
        break;
}

// Handle availability form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['available_date'])) {
    $available_date = $_POST['available_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $max_appointment = $_POST['max_appointment'] ?? 10; // Default to 10 if not set
    $repeat_weekly = isset($_POST['repeat_weekly']) ? 1 : 0;
    
    if ($repeat_weekly) {
        // Add to doctor_availability table for weekly repetition
        $day_of_week = strtolower(date('l', strtotime($available_date)));
        
        $stmt = $pdo->prepare("
            INSERT INTO doctor_availability (doctor_id, day_of_week, start_time, end_time, max_appointment) 
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE start_time = VALUES(start_time), end_time = VALUES(end_time), max_appointment = VALUES(max_appointment)
        ");
        $stmt->execute([$doctor_id, $day_of_week, $start_time, $end_time, $max_appointment]);
    } else {
        // Add to doctor_schedule table for specific date
        $stmt = $pdo->prepare("
            INSERT INTO doctor_schedule (doctor_id, date, start_time, end_time, max_appointment, is_available) 
            VALUES (?, ?, ?, ?, ?, 1)
        ");
        $stmt->execute([$doctor_id, $available_date, $start_time, $end_time, $max_appointment]);
    }
    
    header('Location: doctor_calendar.php?success=1&view=' . $view_type . '&date=' . $current_date);
    exit();
}

// Get appointments for the current view range
$stmt = $pdo->prepare("
    SELECT a.*, p.full_name, p.date_of_birth, p.gender
    FROM appointment a
    JOIN patient p ON a.patient_id = p.patient_id
    WHERE a.doctor_id = ? AND a.preferred_date BETWEEN ? AND ?
    ORDER BY a.preferred_date ASC, a.preferred_time ASC
");
$stmt->execute([$doctor_id, $start_date, $end_date]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get doctor's availability for the week
$stmt = $pdo->prepare("SELECT * FROM doctor_availability WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$weekly_availability = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get specific date schedules
$stmt = $pdo->prepare("
    SELECT * FROM doctor_schedule 
    WHERE doctor_id = ? AND date BETWEEN ? AND ? AND is_available = 1
");
$stmt->execute([$doctor_id, $start_date, $end_date]);
$specific_schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - My Schedule & Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .week-display {
            background-color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-weight: 600;
            color: #4d93c2ff;
        }
        
        .calendar-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .view-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-view {
            background-color: white;
            color: #4d93c2ff;
            border: 1px solid #4d93c2ff;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        
        .btn-view:hover, .btn-view.active {
            background-color: #4d93c2ff;
            color: white;
            text-decoration: none;
        }
        
        .navigation-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .btn-nav {
            background-color: white;
            color: #4d93c2ff;
            border: 1px solid #4d93c2ff;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .btn-nav:hover {
            background-color: #4d93c2ff;
            color: white;
            text-decoration: none;
        }
        
        .calendar-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        
        .calendar-view {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
            min-height: 400px;
        }
        
        .calendar-view h2 {
            color: #4d93c2ff;
            margin-bottom: 16px;
            font-size: 20.8px;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-top: 20px;
        }
        
        .calendar-day {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px;
            min-height: 100px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }
        
        .calendar-day.today {
            background-color: #e6f2fa;
            border: 2px solid #4d93c2ff;
            box-shadow: 0 2px 8px rgba(77, 147, 194, 0.2);
        }
        
        .calendar-day-header {
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            color: #4d93c2ff;
            padding: 4px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        
        .calendar-day-header.today {
            background-color: #4d93c2ff;
            color: white;
            border-radius: 4px;
        }
        
        .appointment-slot {
            background-color: #4d93c2ff;
            color: white;
            padding: 4px 6px;
            border-radius: 3px;
            margin-bottom: 4px;
            font-size: 11px;
            line-height: 1.3;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: all 0.3s ease;
        }
        
        .appointment-slot:hover {
            background-color: #1d5a8a;
            transform: translateY(-1px);
        }
        
        .available-slot {
            background-color: #28a745;
            color: white;
            padding: 4px 6px;
            border-radius: 3px;
            margin-bottom: 4px;
            font-size: 11px;
            line-height: 1.3;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: all 0.3s ease;
        }
        
        .available-slot:hover {
            background-color: #1e7e34;
            transform: translateY(-1px);
        }
        
        /* Month View Specific Styles */
        .month-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-top: 10px;
        }
        
        .month-header {
            grid-column: 1 / -1;
            text-align: center;
            font-weight: bold;
            padding: 12px;
            background: linear-gradient(135deg, #4d93c2ff, #1d5a8a);
            color: white;
            border-radius: 6px;
            margin-bottom: 8px;
            font-size: 18px;
        }
        
        .day-header {
            text-align: center;
            font-weight: bold;
            padding: 10px 8px;
            background: #e6f2fa;
            color: #4d93c2ff;
            border-radius: 4px;
            font-size: 13px;
        }
        
        .month-day {
            min-height: 80px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 6px;
            font-size: 12px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .month-day.today {
            background: #e6f2fa;
            border: 2px solid #4d93c2ff;
            box-shadow: 0 2px 6px rgba(77, 147, 194, 0.3);
        }
        
        .month-day:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .day-number {
            font-weight: bold;
            margin-bottom: 4px;
            color: #333;
            font-size: 13px;
        }
        
        .month-appointment {
            background-color: #4d93c2ff;
            color: white;
            padding: 2px 4px;
            border-radius: 2px;
            margin-bottom: 2px;
            font-size: 10px;
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Day View Specific Styles */
        .day-view-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin-top: 20px;
        }
        
        .day-view-slot {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .day-view-slot:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .time-slot-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .time-range {
            font-weight: bold;
            color: #4d93c2ff;
            font-size: 16px;
        }
        
        .slot-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .slot-type.appointment {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .slot-type.available {
            background-color: #28a745;
            color: white;
        }
        
        .slot-type.free {
            background-color: #6c757d;
            color: white;
        }
        
        .patient-info {
            font-size: 14px;
            color: #333;
        }
        
        .patient-name {
            font-weight: 600;
            color: #4d93c2ff;
            margin-bottom: 4px;
        }
        
        .appointment-reason {
            color: #666;
            font-size: 13px;
        }
        
        .availability-form {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            height: fit-content;
        }
        
        .availability-form h2 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
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
        
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 2px rgba(77, 147, 194, 0.2);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox-group input {
            width: auto;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
            transform: translateY(-1px);
        }
        
        .appointments-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
        }
        
        .appointments-section h2 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
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
            transform: translateX(2px);
            transition: all 0.3s ease;
        }
        
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status.confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status.available {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .action-links a {
            color: #4d93c2ff;
            text-decoration: none;
            margin-right: 10px;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .action-links a:hover {
            color: #1d5a8a;
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
        
        /* Success Message Styles */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
            font-weight: 500;
        }
        
        /* Empty State Styles */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 16px;
        }
        
        .empty-state h3 {
            color: #666;
            margin-bottom: 8px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .calendar-container {
                grid-template-columns: 1fr;
            }
            
            .calendar-grid {
                grid-template-columns: repeat(1, 1fr);
            }
            
            .month-grid {
                grid-template-columns: repeat(1, 1fr);
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
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .calendar-controls {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .view-buttons, .navigation-controls {
                width: 100%;
                justify-content: center;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .btn-view, .btn-nav {
                padding: 10px 14px;
                font-size: 13px;
            }
        }
        
        @media (max-width: 480px) {
            .calendar-view {
                padding: 20px;
            }
            
            .month-day {
                min-height: 60px;
                padding: 4px;
            }
            
            .month-appointment {
                font-size: 9px;
                padding: 1px 2px;
            }
            
            .day-view-slot {
                padding: 12px;
            }
            
            .time-range {
                font-size: 14px;
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
                        <li><a href="doctor_calendar.php" class="active">My Calendar</a></li>
                        <li><a href="patient_list.php">Patient List</a></li>
                        <li><a href="doctor_profile.php">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>My Appointment Calendar</h1>
            <div class="week-display">
                <?php echo ucfirst($view_type); ?>: <strong id="currentWeek"><?php echo $display_text; ?></strong>
            </div>
        </div>
        
        <div class="calendar-controls">
            <div class="view-buttons">
                <a href="?view=day&date=<?php echo $current_date; ?>" class="btn-view <?php echo $view_type == 'day' ? 'active' : ''; ?>">Day</a>
                <a href="?view=week&date=<?php echo $current_date; ?>" class="btn-view <?php echo $view_type == 'week' ? 'active' : ''; ?>">Week</a>
                <a href="?view=month&date=<?php echo $current_date; ?>" class="btn-view <?php echo $view_type == 'month' ? 'active' : ''; ?>">Month</a>
            </div>
            <div class="navigation-controls">
                <?php if ($view_type == 'day'): ?>
                    <a href="?view=day&date=<?php echo date('Y-m-d', strtotime($current_date . ' -1 day')); ?>" class="btn-nav">← Previous Day</a>
                    <a href="?view=day&date=<?php echo date('Y-m-d'); ?>" class="btn-nav">Today</a>
                    <a href="?view=day&date=<?php echo date('Y-m-d', strtotime($current_date . ' +1 day')); ?>" class="btn-nav">Next Day →</a>
                <?php elseif ($view_type == 'week'): ?>
                    <a href="?view=week&date=<?php echo date('Y-m-d', strtotime($current_date . ' -1 week')); ?>" class="btn-nav">← Previous Week</a>
                    <a href="?view=week&date=<?php echo date('Y-m-d'); ?>" class="btn-nav">This Week</a>
                    <a href="?view=week&date=<?php echo date('Y-m-d', strtotime($current_date . ' +1 week')); ?>" class="btn-nav">Next Week →</a>
                <?php elseif ($view_type == 'month'): ?>
                    <a href="?view=month&date=<?php echo date('Y-m-d', strtotime($current_date . ' -1 month')); ?>" class="btn-nav">← Previous Month</a>
                    <a href="?view=month&date=<?php echo date('Y-m-d'); ?>" class="btn-nav">This Month</a>
                    <a href="?view=month&date=<?php echo date('Y-m-d', strtotime($current_date . ' +1 month')); ?>" class="btn-nav">Next Month →</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="calendar-container">
            <div class="calendar-view">
                <h2>
                    <?php 
                    if ($view_type == 'day') {
                        echo 'Daily Schedule';
                    } elseif ($view_type == 'week') {
                        echo 'Weekly Schedule';
                    } else {
                        echo 'Monthly Overview';
                    }
                    ?>
                </h2>
                <p>Available slots are shown in <span style="color:#28a745;">GREEN</span>, and booked appointments in <span style="color:#4d93c2ff;">BLUE</span>.</p>
                
                <div class="calendar-grid">
                    <?php
                    if ($view_type == 'day') {
                        // Single day view
                        $current_date_display = date('D, j M', strtotime($current_date));
                        $is_today = $current_date == date('Y-m-d');
                        
                        echo "<div class='calendar-day" . ($is_today ? ' today' : '') . "'>";
                        echo "<div class='calendar-day-header" . ($is_today ? ' today' : '') . "'>$current_date_display</div>";
                        
                        // Display appointments for this day
                        $day_appointments = array_filter($appointments, function($apt) use ($current_date) {
                            return $apt['preferred_date'] == $current_date;
                        });
                        
                        foreach ($day_appointments as $apt) {
                            $time = date('g:i A', strtotime($apt['preferred_time']));
                            echo "<div class='appointment-slot'>$time - " . htmlspecialchars($apt['full_name']) . "</div>";
                        }
                        
                        // Display available slots
                        $day_of_week = strtolower(date('l', strtotime($current_date)));
                        $available_today = array_filter($weekly_availability, function($avail) use ($day_of_week) {
                            return $avail['day_of_week'] == $day_of_week && $avail['is_available'] == 1;
                        });
                        
                        foreach ($available_today as $slot) {
                            $start = date('g:i A', strtotime($slot['start_time']));
                            $end = date('g:i A', strtotime($slot['end_time']));
                            echo "<div class='available-slot'>$start - $end - Available</div>";
                        }
                        
                        if (empty($day_appointments)) {
                            echo "<div style='color:#666; font-size:12px; text-align:center; margin-top:20px;'>No appointments</div>";
                        }
                        
                        echo "</div>";
                        
                    } elseif ($view_type == 'week') {
                        // Week view
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        foreach ($days as $index => $day) {
                            $day_date = date('Y-m-d', strtotime($start_date . " +$index days"));
                            $day_name = date('D, j M', strtotime($day_date));
                            $is_today = $day_date == date('Y-m-d');
                            
                            echo "<div class='calendar-day" . ($is_today ? ' today' : '') . "'>";
                            echo "<div class='calendar-day-header" . ($is_today ? ' today' : '') . "'>$day_name</div>";
                            
                            // Display appointments for this day
                            $day_appointments = array_filter($appointments, function($apt) use ($day_date) {
                                return $apt['preferred_date'] == $day_date;
                            });
                            
                            foreach ($day_appointments as $apt) {
                                $time = date('g:i A', strtotime($apt['preferred_time']));
                                echo "<div class='appointment-slot'>$time - " . htmlspecialchars($apt['full_name']) . "</div>";
                            }
                            
                            // Display available slots
                            $day_of_week = strtolower($day);
                            $available_today = array_filter($weekly_availability, function($avail) use ($day_of_week) {
                                return $avail['day_of_week'] == $day_of_week && $avail['is_available'] == 1;
                            });
                            
                            foreach ($available_today as $slot) {
                                $start = date('g:i A', strtotime($slot['start_time']));
                                $end = date('g:i A', strtotime($slot['end_time']));
                                echo "<div class='available-slot'>$start - $end - Available</div>";
                            }
                            
                            if (empty($day_appointments)) {
                                echo "<div style='color:#666; font-size:12px; text-align:center; margin-top:20px;'>No appointments</div>";
                            }
                            
                            echo "</div>";
                        }
                    } else {
                    // Month view - traditional calendar grid but styled like week view
                    $first_day = date('Y-m-01', strtotime($current_date));
                    $last_day = date('Y-m-t', strtotime($current_date));
                    $days_in_month = date('t', strtotime($current_date));
                    $current_year_month = date('Y-m', strtotime($current_date));
                    
                    // Get first day of month (0=Sunday, 1=Monday, etc.)
                    $first_day_of_week = date('w', strtotime($first_day));
                    
                    echo "<div class='calendar-grid'>";
                    
                    // Day headers - keep the same styling as week view
                    $day_headers = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    foreach ($day_headers as $header) {
                        echo "<div class='calendar-day-header'>$header</div>";
                    }
                    
                    // Empty cells for days before the first day of month
                    for ($i = 0; $i < $first_day_of_week; $i++) {
                        echo "<div class='calendar-day' style='background-color: #f5f5f5; opacity: 0.6;'>";
                        echo "<div style='color:#666; font-size:12px; text-align:center; margin-top:20px;'></div>";
                        echo "</div>";
                    }
                    
                    // Days of the month
                    for ($day = 1; $day <= $days_in_month; $day++) {
                        $current_day_date = $current_year_month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                        $is_today = $current_day_date == date('Y-m-d');
                        $day_appointments = array_filter($appointments, function($apt) use ($current_day_date) {
                            return $apt['preferred_date'] == $current_day_date;
                        });
                        
                        echo "<div class='calendar-day" . ($is_today ? ' today' : '') . "'>";
                        echo "<div class='calendar-day-header" . ($is_today ? ' today' : '') . "'>" . date('D, j M', strtotime($current_day_date)) . "</div>";
                        
                        // Display appointments for this day
                        foreach ($day_appointments as $apt) {
                            $time = date('g:i A', strtotime($apt['preferred_time']));
                            echo "<div class='appointment-slot'>$time - " . htmlspecialchars($apt['full_name']) . "</div>";
                        }
                        
                        // Display available slots
                        $day_of_week = strtolower(date('l', strtotime($current_day_date)));
                        $available_today = array_filter($weekly_availability, function($avail) use ($day_of_week) {
                            return $avail['day_of_week'] == $day_of_week && $avail['is_available'] == 1;
                        });
                        
                        foreach ($available_today as $slot) {
                            $start = date('g:i A', strtotime($slot['start_time']));
                            $end = date('g:i A', strtotime($slot['end_time']));
                            echo "<div class='available-slot'>$start - $end - Available</div>";
                        }
                        
                        if (empty($day_appointments)) {
                            echo "<div style='color:#666; font-size:12px; text-align:center; margin-top:20px;'>No appointments</div>";
                        }
                        
                        echo "</div>";
                    }
                    
                    echo "</div>";
                }
                    ?>
                </div>
            </div>
            
            <div class="availability-form">
            <h2>Set Your Availability</h2>
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Availability updated successfully!
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <input type="hidden" name="view" value="<?php echo $view_type; ?>">
                <input type="hidden" name="date" value="<?php echo $current_date; ?>">
                
                <div class="form-group">
                    <label for="available-date">Date:</label>
                    <input type="date" id="available-date" name="available_date" required>
                </div>
                
                <div class="form-group">
                    <label for="start-time">Start Time:</label>
                    <input type="time" id="start-time" name="start_time" value="09:00" required>
                </div>
                
                <div class="form-group">
                    <label for="end-time">End Time:</label>
                    <input type="time" id="end-time" name="end_time" value="17:00" required>
                </div>
                
                <div class="form-group">
                    <label for="max-appointments">Maximum Appointments (per day):</label>
                    <select id="max-appointments" name="max_appointment" class="form-control">
                        <option value="5">5 appointments</option>
                        <option value="10" selected>10 appointments</option>
                        <option value="15">15 appointments</option>
                        <option value="20">20 appointments</option>
                        <option value="25">25 appointments</option>
                        <option value="30">30 appointments</option>
                        <option value="40">40 appointments</option>
                        <option value="50">50 appointments</option>
                        <option value="0">No limit</option>
                    </select>
                    <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
                        Maximum number of appointments you can accept for this day
                    </small>
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="repeat-weekly" name="repeat_weekly">
                    <label for="repeat-weekly">Repeat this time slot weekly</label>
                </div>
                
                <button type="submit" class="btn-primary">Add to My Available Schedule</button>
            </form>
        </div>

        <section class="appointments-section">
            <h2>Appointment List (<?php echo $view_type == 'day' ? 'Today' : ($view_type == 'week' ? 'This Week' : 'This Month'); ?>)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($appointments) > 0): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo date('D, j M - g:i A', strtotime($appointment['preferred_date'] . ' ' . $appointment['preferred_time'])); ?></td>
                                <td><?php echo htmlspecialchars($appointment['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                                <td><span class="status confirmed"><?php echo ucfirst($appointment['status']); ?></span></td>
                                <td class="action-links">
                                    <a href="patient_details.php?patient_id=<?php echo $appointment['patient_id']; ?>">View</a> | 
                                    <a href="#">Reschedule</a> | 
                                    <a href="#">Cancel</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px;">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h3>No Appointments</h3>
                                    <p>No appointments scheduled for <?php echo $view_type == 'day' ? 'today' : ($view_type == 'week' ? 'this week' : 'this month'); ?>.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Set current week display
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today for availability form
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('available-date').setAttribute('min', today);
            
            // Set default date to today
            document.getElementById('available-date').value = today;
        });
    </script>
</body>
</html>
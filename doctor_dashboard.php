<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Doctor Portal</title>
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
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .dashboard-header h1 {
            color: #4d93c2ff;
            font-size: 28.8px;
        }
        
        .date-display {
            background-color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-weight: 600;
            color: #4d93c2ff;
        }
        
        .welcome-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
            margin-bottom: 32px;
        }
        
        .welcome-container h2 {
            color: #4d93c2ff;
            margin-bottom: 16px;
            font-size: 20.8px;
        }
        
        .welcome-container p {
            color: #666;
            margin-bottom: 0;
        }
        
        .appointments-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
        }
        
        .appointments-list {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
        }
        
        .appointments-list h2 {
            color: #4d93c2ff;
            margin-bottom: 24px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .appointment-card {
            background-color: #f9f9f9;
            border-left: 4px solid #4d93c2ff;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .appointment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .appointment-card h3 {
            color: #4d93c2ff;
            margin-bottom: 12px;
            font-size: 18px;
        }
        
        .appointment-card p {
            margin-bottom: 8px;
            color: #666;
        }
        
        .appointment-card strong {
            color: #333;
        }
        
        .appointment-card .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 8px;
        }
        
        .status.confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .btn-view-details {
            display: inline-block;
            background-color: #4d93c2ff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 12px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .btn-view-details:hover {
            background-color: #1d5a8a;
        }
        
        .doctor-actions {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            height: fit-content;
        }
        
        .doctor-actions h2 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .action-card {
            background-color: #f0f8ff;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 16px;
            transition: background-color 0.3s;
        }
        
        .action-card:hover {
            background-color: #e1f0ff;
        }
        
        .action-card h3 {
            color: #4d93c2ff;
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .action-card p {
            color: #666;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .btn-action {
            display: inline-block;
            background-color: #4d93c2ff;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .btn-action:hover {
            background-color: #1d5a8a;
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
            .appointments-container {
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
            
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
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
                    <p>Welcome, Dr. [Name]!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="doctor_dashboard.php" class="active">Dashboard</a></li>
                        <li><a href="doctor_calendar.php">My Calendar</a></li>
                        <li><a href="patient_list.php">Patient List</a></li>
                        <li><a href="doctor_profile.php">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="dashboard-header">
            <h1>Doctor Dashboard</h1>
            <div class="date-display">
                Today's Date: <strong id="currentDate">[Dynamic Date]</strong>
            </div>
        </div>
        
        <div class="welcome-container">
            <h2>Welcome to Your Dashboard</h2>
            <p>Here you can view today's confirmed appointments, access patient records, and manage your schedule. All appointments are listed in chronological order for your convenience.</p>
        </div>
        
        <div class="appointments-container">
            <div class="appointments-list">
                <h2>Today's Confirmed Appointments</h2>
                
                <!-- Appointment 1 - Morning -->
                <div class="appointment-card">
                    <h3>Sarah Johnson</h3>
                    <p><strong>Appointment ID:</strong> #A-001</p>
                    <p><strong>Time:</strong> 9:00 AM - 10:00 AM</p>
                    <p><strong>Reason for Visit:</strong> Routine check-up</p>
                    <span class="status confirmed">Confirmed</span>
                    <a href="patient_details.php?patient_id=1" class="btn-view-details">View Patient Details & Medical History</a>
                </div>
                
                <!-- Appointment 2 - Late Morning -->
                <div class="appointment-card">
                    <h3>Michael Chen</h3>
                    <p><strong>Appointment ID:</strong> #A-002</p>
                    <p><strong>Time:</strong> 10:30 AM - 11:30 AM</p>
                    <p><strong>Reason for Visit:</strong> Follow-up consultation</p>
                    <span class="status confirmed">Confirmed</span>
                    <a href="patient_details.php?patient_id=2" class="btn-view-details">View Patient Details & Medical History</a>
                </div>
                
                <!-- Appointment 3 - Afternoon -->
                <div class="appointment-card">
                    <h3>Emma Williams</h3>
                    <p><strong>Appointment ID:</strong> #A-003</p>
                    <p><strong>Time:</strong> 2:00 PM - 3:00 PM</p>
                    <p><strong>Reason for Visit:</strong> New symptoms evaluation</p>
                    <span class="status confirmed">Confirmed</span>
                    <a href="patient_details.php?patient_id=3" class="btn-view-details">View Patient Details & Medical History</a>
                </div>
                
                <!-- Appointment 4 - Late Afternoon -->
                <div class="appointment-card">
                    <h3>Robert Garcia</h3>
                    <p><strong>Appointment ID:</strong> #A-004</p>
                    <p><strong>Time:</strong> 3:30 PM - 4:30 PM</p>
                    <p><strong>Reason for Visit:</strong> Annual physical</p>
                    <span class="status confirmed">Confirmed</span>
                    <a href="patient_details.php?patient_id=4" class="btn-view-details">View Patient Details & Medical History</a>
                </div>
            </div>
            
            <div class="doctor-actions">
                <h2>Quick Actions</h2>
                
                <div class="action-card">
                    <h3>View Full Calendar</h3>
                    <p>Check your complete schedule and upcoming appointments.</p>
                    <a href="doctor_calendar.php" class="btn-action">Open Calendar</a>
                </div>
                
                <div class="action-card">
                    <h3>Patient Directory</h3>
                    <p>Access complete patient records and medical histories.</p>
                    <a href="patient_list.php" class="btn-action">View Patients</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Set current date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = today.toLocaleDateString('en-US', options);
        });
    </script>
</body>
</html>
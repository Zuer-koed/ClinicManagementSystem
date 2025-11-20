<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Staff Portal</title>
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
        
        .date-display {
            background-color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-weight: 600;
            color: #4d93c2ff;
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
        
        .alert-emergency {
            background-color: #ffebee;
            border-left: 4px solid #ff6b6b;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 16px;
        }
        
        .alert-emergency h4 {
            color: #d32f2f;
            margin-bottom: 8px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            border: 1px solid #e9ecef;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .stat-card h4 {
            color: #4d93c2ff;
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 12px;
        }
        
        .btn-stat {
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
        
        .btn-stat:hover {
            background-color: #1d5a8a;
        }
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            font-size: 14px;
        }
        
        .schedule-table th, .schedule-table td {
            padding: 10px 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        
        .schedule-table th {
            background-color: #f0f8ff;
            color: #4d93c2ff;
            font-weight: 600;
        }
        
        .schedule-table td {
            background-color: white;
        }
        
        .appointment-booked {
            background-color: #4d93c2ff;
            color: white;
            border-radius: 3px;
            padding: 4px;
            font-size: 12px;
        }
        
        .appointment-emergency {
            background-color: #ff6b6b;
            color: white;
            border-radius: 3px;
            padding: 4px;
            font-size: 12px;
        }
        
        .appointment-available {
            background-color: #28a745;
            color: white;
            border-radius: 3px;
            padding: 4px;
            font-size: 12px;
        }
        
        .appointment-lunch {
            background-color: #ffc107;
            color: #333;
            border-radius: 3px;
            padding: 4px;
            font-size: 12px;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }
        
        .btn-action {
            display: block;
            background-color: #4d93c2ff;
            color: white;
            text-decoration: none;
            padding: 16px;
            border-radius: 6px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-action:hover {
            background-color: #1d5a8a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .activity-log {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 16px;
            margin-top: 16px;
        }
        
        .activity-item {
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-time {
            font-weight: 600;
            color: #4d93c2ff;
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
            
            .schedule-table {
                display: block;
                overflow-x: auto;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
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
                    <p>Welcome, Staff Member!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="staff_dashboard.php" class="active">Dashboard</a></li>
                        <li><a href="staff_manage_appointment.php">Manage Appointments</a></li>
                        <li><a href="patient_list.php">Patient List</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>Today's Operations Overview</h1>
            <div class="date-display">
                Today's Date: <strong id="currentDate">[Dynamic Date]</strong>
            </div>
        </div>

        <!-- Emergency Alerts Section -->
        <section class="section-card">
            <h2>High Priority Alerts</h2>
            <div class="alert-emergency">
                <h4>🚨 Emergency Case</h4>
                <p><strong>Patient:</strong> James Wilson</p>
                <p><strong>Time Arrived:</strong> 10:30 AM</p>
                <p><strong>Assigned Doctor:</strong> Dr. Smith</p>
                <p><strong>Status:</strong> In treatment</p>
                <a href="staff_manage_appointment.php" class="btn-stat">Manage Emergency Cases</a>
            </div>
        </section>

        <!-- Appointment Statistics -->
        <section class="section-card">
            <h2>Appointment Summary</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h4>Pending Requests</h4>
                    <p>5</p>
                    <a href="staff_manage_appointment.php?filter=pending" class="btn-stat">Review Pending</a>
                </div>
                <div class="stat-card">
                    <h4>Confirmed Today</h4>
                    <p>12</p>
                    <a href="staff_manage_appointment.php?filter=confirmed" class="btn-stat">View All</a>
                </div>
                <div class="stat-card">
                    <h4>Walk-in Patients</h4>
                    <p>3</p>
                    <a href="staff_manage_appointment.php?filter=walk_in" class="btn-stat">Manage Walk-ins</a>
                </div>
                <div class="stat-card">
                    <h4>Completed Today</h4>
                    <p>8</p>
                    <a href="staff_manage_appointment.php?filter=completed" class="btn-stat">View Completed</a>
                </div>
            </div>
        </section>

        <!-- Master Schedule for All Doctors -->
        <section class="section-card">
            <h2>Today's Master Schedule</h2>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>9:00-10:00</th>
                        <th>10:00-11:00</th>
                        <th>11:00-12:00</th>
                        <th>12:00-13:00</th>
                        <th>13:00-14:00</th>
                        <th>14:00-15:00</th>
                        <th>15:00-16:00</th>
                        <th>16:00-17:00</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Dr. Smith</strong></td>
                        <td><span class="appointment-booked">Sarah Johnson</span></td>
                        <td><span class="appointment-booked">Michael Chen</span></td>
                        <td><span class="appointment-available">Available</span></td>
                        <td><span class="appointment-lunch">Lunch</span></td>
                        <td><span class="appointment-booked">Emma Williams</span></td>
                        <td><span class="appointment-emergency">James Wilson</span></td>
                        <td><span class="appointment-available">Available</span></td>
                        <td><span class="appointment-booked">Robert Garcia</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dr. Johnson</strong></td>
                        <td><span class="appointment-available">Available</span></td>
                        <td><span class="appointment-booked">Lisa Thompson</span></td>
                        <td><span class="appointment-available">Available</span></td>
                        <td><span class="appointment-lunch">Lunch</span></td>
                        <td><span class="appointment-booked">David Brown</span></td>
                        <td><span class="appointment-booked">Maria Garcia</span></td>
                        <td><span class="appointment-booked">Walk-in Slot</span></td>
                        <td><span class="appointment-available">Available</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dr. Williams</strong></td>
                        <td><span class="appointment-booked">Jennifer Lee</span></td>
                        <td><span class="appointment-available">Available</span></td>
                        <td><span class="appointment-booked">Thomas Clark</span></td>
                        <td><span class="appointment-lunch">Lunch</span></td>
                        <td><span class="appointment-booked">Walk-in Slot</span></td>
                        <td><span class="appointment-available">Available</span></td>
                        <td><span class="appointment-booked">Susan Adams</span></td>
                        <td><span class="appointment-available">Available</span></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Quick Actions -->
        <section class="section-card">
            <h2>Quick Actions</h2>
            <div class="quick-actions">
                <a href="staff_manage_appointment.php?action=new_walkin" class="btn-action">Register New Walk-in</a>
                <a href="staff_manage_appointment.php?action=new_emergency" class="btn-action">Register Emergency Case</a>
                <a href="staff_patient_list.php" class="btn-action">Search Patient</a>
                <a href="staff_manage_appointment.php?filter=pending" class="btn-action">Process Pending Requests</a>
            </div>
        </section>

        <!-- Today's Activity Log -->
        <section class="section-card">
            <h2>Recent Activity</h2>
            <div class="activity-log">
                <div class="activity-item">
                    <span class="activity-time">10:30 AM:</span> Emergency case registered - James Wilson
                </div>
                <div class="activity-item">
                    <span class="activity-time">10:15 AM:</span> Walk-in patient registered - Maria Garcia
                </div>
                <div class="activity-item">
                    <span class="activity-time">09:45 AM:</span> Appointment confirmed - David Brown with Dr. Johnson
                </div>
                <div class="activity-item">
                    <span class="activity-time">09:30 AM:</span> Patient checked in - Sarah Johnson
                </div>
                <div class="activity-item">
                    <span class="activity-time">09:00 AM:</span> Clinic opened for the day
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
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
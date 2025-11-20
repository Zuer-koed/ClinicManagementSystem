<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - My Schedule & Appointments</title>
<<<<<<< HEAD
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
        
        .calendar-controls {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-bottom: 24px;
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
        }
        
        .btn-view:hover, .btn-view.active {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .week-display {
            background-color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-weight: 600;
            color: #4d93c2ff;
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
        }
        
        .calendar-day-header {
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            color: #4d93c2ff;
        }
        
        .appointment-slot {
            background-color: #4d93c2ff;
            color: white;
            padding: 4px;
            border-radius: 3px;
            margin-bottom: 4px;
            font-size: 12px;
        }
        
        .available-slot {
            background-color: #28a745;
            color: white;
            padding: 4px;
            border-radius: 3px;
            margin-bottom: 4px;
            font-size: 12px;
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
        }
        
        .action-links a:hover {
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
            .calendar-container {
                grid-template-columns: 1fr;
            }
            
            .calendar-grid {
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
                    <p>Welcome, Dr. [Name]!</p>
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
=======
</head>
<body>

    <header>
        <div>
            <h1>NexusCare</h1>
            <p>Doctor Portal</p>
        </div>
        <nav>
            <ul>
                <li><a href="doctor_dashboard.php">Dashboard</a></li>
                <li><a href="doctor_calendar.php">My Calendar</a></li>
                <li><a href="patient_list.php">Patient List</a></li>
            </ul>
        </nav>
        <div>
            <p>Welcome, Dr. [Name]</p>
            <a href="logout.php">Logout</a>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
        </div>
    </header>

    <main>
<<<<<<< HEAD
        <div class="page-header">
            <h1>My Appointment Calendar</h1>
            <div class="week-display">
                Week of: <strong id="currentWeek">Sep 15 - Sep 21, 2025</strong>
            </div>
        </div>
        
        <div class="calendar-controls">
            <div class="view-buttons">
                <button class="btn-view active">Day</button>
                <button class="btn-view">Week</button>
                <button class="btn-view">Month</button>
            </div>
        </div>

        <div class="calendar-container">
            <div class="calendar-view">
                <h2>Weekly Schedule</h2>
                <p>Available slots are shown in <span style="color:#28a745;">GREEN</span>, and booked appointments in <span style="color:#4d93c2ff;">BLUE</span>.</p>
                
                <div class="calendar-grid">
                    <div class="calendar-day">
                        <div class="calendar-day-header">Mon, 15 Sep</div>
                        <div class="appointment-slot">10:15 AM - Michael Chen</div>
                        <div class="available-slot">2:00 PM - Available</div>
                        <div class="available-slot">4:30 PM - Available</div>
                    </div>
                    <div class="calendar-day">
                        <div class="calendar-day-header">Tue, 16 Sep</div>
                        <div class="appointment-slot">9:00 AM - Sarah Johnson</div>
                        <div class="appointment-slot">2:00 PM - Emma Williams</div>
                        <div class="available-slot">4:00 PM - Available</div>
                    </div>
                    <div class="calendar-day">
                        <div class="calendar-day-header">Wed, 17 Sep</div>
                        <div class="appointment-slot">11:00 AM - Robert Garcia</div>
                        <div class="available-slot">1:30 PM - Available</div>
                        <div class="available-slot">3:45 PM - Available</div>
                    </div>
                    <div class="calendar-day">
                        <div class="calendar-day-header">Thu, 18 Sep</div>
                        <div class="available-slot">10:00 AM - Available</div>
                        <div class="available-slot">1:15 PM - Available</div>
                        <div class="appointment-slot">3:30 PM - Lisa Brown</div>
                    </div>
                    <div class="calendar-day">
                        <div class="calendar-day-header">Fri, 19 Sep</div>
                        <div class="appointment-slot">9:30 AM - David Wilson</div>
                        <div class="available-slot">11:45 AM - Available</div>
                        <div class="available-slot">2:30 PM - Available</div>
                    </div>
                    <div class="calendar-day">
                        <div class="calendar-day-header">Sat, 20 Sep</div>
                        <div class="available-slot">10:00 AM - Available</div>
                        <div class="available-slot">12:00 PM - Available</div>
                        <div style="color:#666; font-size:12px; text-align:center; margin-top:10px;">No afternoon appointments</div>
                    </div>
                    <div class="calendar-day">
                        <div class="calendar-day-header">Sun, 21 Sep</div>
                        <div style="color:#666; font-size:12px; text-align:center; margin-top:20px;">No appointments scheduled</div>
                    </div>
                </div>
            </div>
            
            <div class="availability-form">
                <h2>Set Your Availability</h2>
                <form action="" method="post">
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
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="repeat-weekly" name="repeat_weekly">
                        <label for="repeat-weekly">Repeat this time slot weekly</label>
                    </div>
                    <button type="submit" class="btn-primary">Add to My Available Schedule</button>
                </form>
            </div>
        </div>

        <section class="appointments-section">
            <h2>Appointment List (This Week)</h2>
=======
        <h2>My Appointment Calendar</h2>

        <div>
            <button>Day</button>
            <button>Week</button>
            <button>Month</button>
            <span>Week of: Sep 15 - Sep 21, 2025</span>
        </div>

        <div>
            <h3>Interactive Calendar View</h3>
            <p>This area will show a visual calendar grid. Available slots will be in GREEN, and booked appointments will be in BLUE.</p>
        </div>

        <section>
            <h3>Set Your Availability</h3>
            <form action="" method="post">
                <div>
                    <label for="available-date">Date:</label>
                    <input type="date" id="available-date" name="available_date" required>
                </div>
                <div>
                    <label for="start-time">Start Time:</label>
                    <input type="time" id="start-time" name="start_time" value="09:00" required>
                </div>
                <div>
                    <label for="end-time">End Time:</label>
                    <input type="time" id="end-time" name="end_time" value="17:00" required>
                </div>
                <div>
                    <input type="checkbox" id="repeat-weekly" name="repeat_weekly">
                    <label for="repeat-weekly">Repeat this time slot weekly</label>
                </div>
                <button type="submit">Add to My Available Schedule</button>
            </form>
        </section>

        <section>
            <h3>Appointment List (This Week)</h3>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
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
                    <tr>
                        <td>Mon, 15 Sep - 10:15 AM</td>
                        <td>Michael Chen</td>
                        <td>Follow-up</td>
<<<<<<< HEAD
                        <td><span class="status confirmed">Confirmed</span></td>
                        <td class="action-links">
                            <a href="patient_details.php?patient_id=2">View</a> | 
                            <a href="#">Reschedule</a> | 
                            <a href="#">Cancel</a>
                        </td>
=======
                        <td>Confirmed</td>
                        <td><a href="patient_details.php?patient_id=2">View</a> | <a href="#">Reschedule</a> | <a href="#">Cancel</a></td>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    </tr>
                    <tr>
                        <td>Tue, 16 Sep - 2:00 PM</td>
                        <td>Emma Williams</td>
                        <td>New Symptoms</td>
<<<<<<< HEAD
                        <td><span class="status confirmed">Confirmed</span></td>
                        <td class="action-links">
                            <a href="patient_details.php?patient_id=3">View</a> | 
                            <a href="#">Reschedule</a> | 
                            <a href="#">Cancel</a>
                        </td>
=======
                        <td>Confirmed</td>
                        <td><a href="patient_details.php?patient_id=3">View</a> | <a href="#">Reschedule</a> | <a href="#">Cancel</a></td>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    </tr>
                    <tr>
                        <td>Wed, 17 Sep - 11:00 AM</td>
                        <td>Available Slot</td>
                        <td>-</td>
<<<<<<< HEAD
                        <td><span class="status available">Available</span></td>
                        <td class="action-links">
                            <a href="#">Block Time</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Thu, 18 Sep - 3:30 PM</td>
                        <td>Lisa Brown</td>
                        <td>Annual Checkup</td>
                        <td><span class="status confirmed">Confirmed</span></td>
                        <td class="action-links">
                            <a href="patient_details.php?patient_id=5">View</a> | 
                            <a href="#">Reschedule</a> | 
                            <a href="#">Cancel</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Fri, 19 Sep - 9:30 AM</td>
                        <td>David Wilson</td>
                        <td>Vaccination</td>
                        <td><span class="status confirmed">Confirmed</span></td>
                        <td class="action-links">
                            <a href="patient_details.php?patient_id=6">View</a> | 
                            <a href="#">Reschedule</a> | 
                            <a href="#">Cancel</a>
                        </td>
=======
                        <td>Available</td>
                        <td><a href="#">Block Time</a></td>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    </tr>
                </tbody>
            </table>
        </section>
<<<<<<< HEAD
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Set current week display
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today for availability form
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('available-date').setAttribute('min', today);
            
            // View buttons functionality
            const viewButtons = document.querySelectorAll('.btn-view');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    viewButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
=======

    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
</body>
</html>
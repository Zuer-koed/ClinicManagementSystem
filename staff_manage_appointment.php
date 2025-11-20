<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Manage Appointments</title>
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
                    <p>Welcome, Staff Member!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="staff_dashboard.php">Dashboard</a></li>
                        <li><a href="staff_manage_appointment.php" class="active">Manage Appointments</a></li>
                        <li><a href="patient_list.php">Patient List</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>Appointment Management Center</h1>
        </div>

        <!-- Quick Action Buttons -->
        <section class="section-card">
            <h2>Quick Actions</h2>
            <div class="quick-actions">
                <button onclick="showWalkInForm()" class="btn-primary">New Walk-in Patient</button>
                <button onclick="showEmergencyForm()" class="btn-primary">New Emergency Case</button>
                <a href="#pending-requests" class="btn-link">View Pending Requests (5)</a>
                <a href="#queue-management" class="btn-link">Manage Queues</a>
=======
</head>
<body>

    <!-- Top Navigation Bar - Staff Portal -->
    <header>
        <div>
            <h1>NexusCare</h1>
            <p>Staff Portal</p>
        </div>
        <nav>
            <ul>
                <li><a href="staff_dashboard.php">Dashboard</a></li>
                <li><a href="staff_manage_appointments.php">Manage Appointments</a></li>
                <li><a href="patient_list.php">Patient List</a></li>
            </ul>
        </nav>
        <div>
            <p>Welcome, Staff Member</p>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <h2>Appointment Management Center</h2>

        <!-- Quick Action Buttons -->
        <section>
            <h3>Quick Actions</h3>
            <div>
                <button onclick="showWalkInForm()">New Walk-in Patient</button>
                <button onclick="showEmergencyForm()">New Emergency Case</button>
                <a href="#pending-requests">View Pending Requests (5)</a>
                <a href="#queue-management">Manage Queues</a>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
            </div>
        </section>

        <!-- Pending Appointment Requests Section -->
<<<<<<< HEAD
        <section id="pending-requests" class="section-card">
            <h2>Pending Appointment Requests</h2>
            
            <!-- Pending Request 1 -->
            <div class="request-card">
                <h4>Request #R-001</h4>
                <p><strong>Patient:</strong> New Patient - John Davis</p>
                <p><strong>Preferred Date/Time:</strong> 2025-09-16, 2:00-3:00 PM</p>
                <p><strong>Reason:</strong> General consultation</p>
                <p><strong>Contact:</strong> john.d@email.com | 555-0110</p>
                
                <form action="" method="post">
                    <input type="hidden" name="request_id" value="1">
                    <div class="form-group">
                        <label for="doctor1">Assign Doctor:</label>
                        <select id="doctor1" name="doctor_id" required>
                            <option value="">Select Doctor</option>
                            <option value="1">Dr. Smith</option>
                            <option value="2">Dr. Johnson</option>
                            <option value="3">Dr. Williams</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointment_time1">Appointment Time:</label>
                        <input type="datetime-local" id="appointment_time1" name="appointment_time" required>
                    </div>
                    <div class="quick-actions">
                        <button type="submit" name="action" value="confirm" class="btn-primary">Confirm Appointment</button>
                        <button type="submit" name="action" value="reject" class="btn-danger">Reject Request</button>
                    </div>
                </form>
            </div>

            <!-- Pending Request 2 -->
            <div class="request-card">
                <h4>Request #R-002</h4>
                <p><strong>Patient:</strong> Sarah Johnson (Existing)</p>
                <p><strong>Preferred Date/Time:</strong> 2025-09-17, 10:00-11:00 AM</p>
                <p><strong>Reason:</strong> Follow-up check</p>
                
                <form action="" method="post">
                    <input type="hidden" name="request_id" value="2">
                    <div class="form-group">
                        <label for="doctor2">Assign Doctor:</label>
                        <select id="doctor2" name="doctor_id" required>
                            <option value="">Select Doctor</option>
                            <option value="1">Dr. Smith</option>
                            <option value="2">Dr. Johnson</option>
                            <option value="3">Dr. Williams</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointment_time2">Appointment Time:</label>
                        <input type="datetime-local" id="appointment_time2" name="appointment_time" required>
                    </div>
                    <div class="quick-actions">
                        <button type="submit" name="action" value="confirm" class="btn-primary">Confirm Appointment</button>
                        <button type="submit" name="action" value="reject" class="btn-danger">Reject Request</button>
                    </div>
                </form>
=======
        <section id="pending-requests">
            <h3>Pending Appointment Requests</h3>
            <div>
                <!-- Pending Request 1 -->
                <div>
                    <h4>Request #R-001</h4>
                    <p><strong>Patient:</strong> New Patient - John Davis</p>
                    <p><strong>Preferred Date/Time:</strong> 2025-09-16, 2:00-3:00 PM</p>
                    <p><strong>Reason:</strong> General consultation</p>
                    <p><strong>Contact:</strong> john.d@email.com | 555-0110</p>
                    
                    <form action="" method="post">
                        <input type="hidden" name="request_id" value="1">
                        <div>
                            <label for="doctor1">Assign Doctor:</label>
                            <select id="doctor1" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. Smith</option>
                                <option value="2">Dr. Johnson</option>
                                <option value="3">Dr. Williams</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment_time1">Appointment Time:</label>
                            <input type="datetime-local" id="appointment_time1" name="appointment_time" required>
                        </div>
                        <button type="submit" name="action" value="confirm">Confirm Appointment</button>
                        <button type="submit" name="action" value="reject">Reject Request</button>
                    </form>
                </div>

                <!-- Pending Request 2 -->
                <div>
                    <h4>Request #R-002</h4>
                    <p><strong>Patient:</strong> Sarah Johnson (Existing)</p>
                    <p><strong>Preferred Date/Time:</strong> 2025-09-17, 10:00-11:00 AM</p>
                    <p><strong>Reason:</strong> Follow-up check</p>
                    
                    <form action="" method="post">
                        <input type="hidden" name="request_id" value="2">
                        <div>
                            <label for="doctor2">Assign Doctor:</label>
                            <select id="doctor2" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. Smith</option>
                                <option value="2">Dr. Johnson</option>
                                <option value="3">Dr. Williams</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment_time2">Appointment Time:</label>
                            <input type="datetime-local" id="appointment_time2" name="appointment_time" required>
                        </div>
                        <button type="submit" name="action" value="confirm">Confirm Appointment</button>
                        <button type="submit" name="action" value="reject">Reject Request</button>
                    </form>
                </div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
            </div>
        </section>

        <!-- Walk-in Registration Form (Initially Hidden) -->
<<<<<<< HEAD
        <section id="walkin-form" class="section-card" style="display: none;">
            <h2>Register Walk-in Patient</h2>
            <form action="" method="post">
                <div class="radio-group">
=======
        <section id="walkin-form" style="display: none;">
            <h3>Register Walk-in Patient</h3>
            <form action="" method="post">
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label><input type="radio" name="patient_type" value="existing" checked> Existing Patient</label>
                    <label><input type="radio" name="patient_type" value="new"> New Patient</label>
                </div>
                
                <div id="existing-patient">
<<<<<<< HEAD
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
=======
                    <label for="search_patient">Search Patient:</label>
                    <input type="text" id="search_patient" name="search_patient" placeholder="Enter patient name or ID">
                </div>
                
                <div id="new-patient">
                    <div>
                        <label for="walkin_name">Full Name:</label>
                        <input type="text" id="walkin_name" name="walkin_name">
                    </div>
                    <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                        <label for="walkin_phone">Phone Number:</label>
                        <input type="tel" id="walkin_phone" name="walkin_phone">
                    </div>
                </div>
                
<<<<<<< HEAD
                <div class="form-group">
=======
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label for="walkin_doctor">Assign to Doctor:</label>
                    <select id="walkin_doctor" name="walkin_doctor" required>
                        <option value="">Select Doctor</option>
                        <option value="1">Dr. Smith</option>
                        <option value="2">Dr. Johnson</option>
                        <option value="3">Dr. Williams</option>
                    </select>
                </div>
                
<<<<<<< HEAD
                <div class="form-group">
=======
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label for="walkin_reason">Reason for Visit:</label>
                    <input type="text" id="walkin_reason" name="walkin_reason" required>
                </div>
                
<<<<<<< HEAD
                <div class="quick-actions">
                    <button type="submit" name="action" value="walkin" class="btn-primary">Register Walk-in</button>
                    <button type="button" onclick="hideWalkInForm()" class="btn-secondary">Cancel</button>
                </div>
=======
                <button type="submit" name="action" value="walkin">Register Walk-in</button>
                <button type="button" onclick="hideWalkInForm()">Cancel</button>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
            </form>
        </section>

        <!-- Emergency Registration Form (Initially Hidden) -->
<<<<<<< HEAD
        <section id="emergency-form" class="section-card" style="display: none;">
            <h2>Register Emergency Case</h2>
            <form action="" method="post">
                <div class="form-group">
=======
        <section id="emergency-form" style="display: none;">
            <h3>Register Emergency Case</h3>
            <form action="" method="post">
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label for="emergency_name">Patient Name:</label>
                    <input type="text" id="emergency_name" name="emergency_name" required>
                </div>
                
<<<<<<< HEAD
                <div class="form-group">
=======
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label for="emergency_doctor">Assign to Doctor:</label>
                    <select id="emergency_doctor" name="emergency_doctor" required>
                        <option value="">Select Doctor</option>
                        <option value="1">Dr. Smith</option>
                        <option value="2">Dr. Johnson</option>
                        <option value="3">Dr. Williams</option>
                    </select>
                </div>
                
<<<<<<< HEAD
                <div class="form-group">
=======
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label for="emergency_reason">Emergency Details:</label>
                    <textarea id="emergency_reason" name="emergency_reason" required placeholder="Describe the emergency situation"></textarea>
                </div>
                
<<<<<<< HEAD
                <div class="form-group">
=======
                <div>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    <label for="emergency_priority">Priority Level:</label>
                    <select id="emergency_priority" name="emergency_priority">
                        <option value="high">High Priority</option>
                        <option value="critical">Critical (Immediate)</option>
                    </select>
                </div>
                
<<<<<<< HEAD
                <div class="quick-actions">
                    <button type="submit" name="action" value="emergency" class="btn-primary">Register Emergency</button>
                    <button type="button" onclick="hideEmergencyForm()" class="btn-secondary">Cancel</button>
                </div>
=======
                <button type="submit" name="action" value="emergency">Register Emergency</button>
                <button type="button" onclick="hideEmergencyForm()">Cancel</button>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
            </form>
        </section>

        <!-- Queue Management Section -->
<<<<<<< HEAD
        <section id="queue-management" class="section-card">
            <h2>Current Queues</h2>
            
            <!-- Dr. Smith's Queue -->
            <div class="queue-section">
                <h3>Dr. Smith's Queue</h3>
                <div class="queue-card">
                    <div class="queue-item queue-item-emergency">
                        <div>
                            <strong>James Wilson</strong> (EMERGENCY) - Chest pain
                        </div>
                        <div class="queue-actions">
                            <button class="btn-primary">Move Up</button>
                            <button class="btn-secondary">Move Down</button>
                            <button class="btn-danger">Remove</button>
                        </div>
                    </div>
                    <div class="queue-item">
                        <div>
                            <strong>Sarah Johnson</strong> (Confirmed) - Routine check-up
                        </div>
                        <div class="queue-actions">
                            <button class="btn-primary">Move Up</button>
                            <button class="btn-secondary">Move Down</button>
                            <button class="btn-danger">Remove</button>
                        </div>
                    </div>
                    <div class="queue-item queue-item-walkin">
                        <div>
                            <strong>Walk-in: Maria Garcia</strong> - Fever and cough
                        </div>
                        <div class="queue-actions">
                            <button class="btn-primary">Move Up</button>
                            <button class="btn-secondary">Move Down</button>
                            <button class="btn-danger">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dr. Johnson's Queue -->
            <div class="queue-section">
                <h3>Dr. Johnson's Queue</h3>
                <div class="queue-card">
                    <div class="queue-item">
                        <div>
                            <strong>David Brown</strong> (Confirmed) - Allergy consultation
                        </div>
                        <div class="queue-actions">
                            <button class="btn-primary">Move Up</button>
                            <button class="btn-secondary">Move Down</button>
                            <button class="btn-danger">Remove</button>
                        </div>
                    </div>
                    <div class="queue-item queue-item-walkin">
                        <div>
                            <strong>Walk-in: Thomas Lee</strong> - Minor injury
                        </div>
                        <div class="queue-actions">
                            <button class="btn-primary">Move Up</button>
                            <button class="btn-secondary">Move Down</button>
                            <button class="btn-danger">Remove</button>
                        </div>
                    </div>
                </div>
=======
        <section id="queue-management">
            <h3>Current Queues</h3>
            
            <!-- Dr. Smith's Queue -->
            <div>
                <h4>Dr. Smith's Queue</h4>
                <ol>
                    <li>
                        <strong>James Wilson</strong> (EMERGENCY) - Chest pain
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                    <li>
                        <strong>Sarah Johnson</strong> (Confirmed) - Routine check-up
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                    <li>
                        <strong>Walk-in: Maria Garcia</strong> - Fever and cough
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                </ol>
            </div>

            <!-- Dr. Johnson's Queue -->
            <div>
                <h4>Dr. Johnson's Queue</h4>
                <ol>
                    <li>
                        <strong>David Brown</strong> (Confirmed) - Allergy consultation
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                    <li>
                        <strong>Walk-in: Thomas Lee</strong> - Minor injury
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                </ol>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
            </div>
        </section>

        <!-- Today's Appointments Overview -->
<<<<<<< HEAD
        <section class="section-card">
            <h2>Today's Appointments Summary</h2>
=======
        <section>
            <h3>Today's Appointments Summary</h3>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
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
                    <tr>
                        <td>09:00 AM</td>
                        <td>Sarah Johnson</td>
                        <td>Dr. Smith</td>
<<<<<<< HEAD
                        <td><span class="status-badge status-confirmed">Confirmed</span></td>
                        <td><span class="status-badge status-waiting">Checked In</span></td>
                        <td class="table-actions">
                            <a href="#">Edit</a> | <a href="#">Cancel</a>
                        </td>
=======
                        <td>Confirmed</td>
                        <td>Checked In</td>
                        <td><a href="#">Edit</a> | <a href="#">Cancel</a></td>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    </tr>
                    <tr>
                        <td>10:30 AM</td>
                        <td>James Wilson</td>
                        <td>Dr. Smith</td>
<<<<<<< HEAD
                        <td><span class="status-badge status-emergency">Emergency</span></td>
                        <td><span class="status-badge status-waiting">In Treatment</span></td>
                        <td class="table-actions">
                            <a href="#">Edit</a> | <a href="#">Complete</a>
                        </td>
=======
                        <td>Emergency</td>
                        <td>In Treatment</td>
                        <td><a href="#">Edit</a> | <a href="#">Complete</a></td>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    </tr>
                    <tr>
                        <td>11:00 AM</td>
                        <td>Walk-in: Maria Garcia</td>
                        <td>Dr. Smith</td>
<<<<<<< HEAD
                        <td><span class="status-badge status-walkin">Walk-in</span></td>
                        <td><span class="status-badge status-waiting">Waiting</span></td>
                        <td class="table-actions">
                            <a href="#">Edit</a> | <a href="#">Cancel</a>
                        </td>
=======
                        <td>Walk-in</td>
                        <td>Waiting</td>
                        <td><a href="#">Edit</a> | <a href="#">Cancel</a></td>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
<<<<<<< HEAD
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
=======
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
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
<<<<<<< HEAD

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
=======
    </script>

>>>>>>> f60d6414eca54246b00d92abab43a29d245b32b8
</body>
</html>
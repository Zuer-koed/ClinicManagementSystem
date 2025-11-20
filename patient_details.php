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
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 2px rgba(77, 147, 194, 0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        
        .checkbox-group input {
            width: auto;
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

        <!-- Patient Profile Section -->
        <section class="section-container">
            <h2>Patient Profile</h2>
            <div class="patient-info">
                <div>
                    <div class="info-item"><strong>Patient ID:</strong> P-001</div>
                    <div class="info-item"><strong>Full Name:</strong> Sarah Johnson</div>
                    <div class="info-item"><strong>Date of Birth:</strong> 1985-03-15 (Age: 40)</div>
                    <div class="info-item"><strong>Gender:</strong> Female</div>
                    <div class="info-item"><strong>Contact Email:</strong> sarah.j@email.com</div>
                </div>
                <div>
                    <div class="info-item"><strong>Phone Number:</strong> 555-0101</div>
                    <div class="info-item"><strong>Address:</strong> 123 Main Street, City, State 12345</div>
                    <div class="info-item"><strong>Emergency Contact:</strong> John Johnson (Spouse) - 555-0106</div>
                    <div class="info-item"><strong>Blood Type:</strong> O+</div>
                    <div class="info-item"><strong>Known Allergies:</strong> Penicillin, Pollen</div>
                </div>
            </div>
        </section>

        <!-- Medical History Section -->
        <section class="section-container">
            <h2>Medical History</h2>
            <div>
                <h3>Past Appointments</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reason for Visit</th>
                            <th>Diagnosis</th>
                            <th>Prescription</th>
                            <th>Doctor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-09-10</td>
                            <td>Routine check-up</td>
                            <td>Healthy, normal vitals</td>
                            <td>None</td>
                            <td>Dr. [Your Name]</td>
                        </tr>
                        <tr>
                            <td>2025-06-15</td>
                            <td>Seasonal allergies</td>
                            <td>Allergic rhinitis</td>
                            <td>Antihistamines</td>
                            <td>Dr. [Your Name]</td>
                        </tr>
                        <tr>
                            <td>2025-03-20</td>
                            <td>Flu symptoms</td>
                            <td>Influenza</td>
                            <td>Rest, fluids, antipyretics</td>
                            <td>Dr. [Your Name]</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Update Records Form -->
        <section class="section-container">
            <h2>Update Medical Records</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="appointment-date">Appointment Date:</label>
                    <input type="date" id="appointment-date" name="appointment_date" required>
                </div>
                <div class="form-group">
                    <label for="reason">Reason for Visit:</label>
                    <input type="text" id="reason" name="reason" required>
                </div>
                <div class="form-group">
                    <label for="diagnosis">Diagnosis:</label>
                    <textarea id="diagnosis" name="diagnosis" rows="3" placeholder="Enter diagnosis details"></textarea>
                </div>
                <div class="form-group">
                    <label for="prescription">Prescription:</label>
                    <textarea id="prescription" name="prescription" rows="3" placeholder="List prescribed medications and dosage"></textarea>
                </div>
                <div class="form-group">
                    <label for="notes">Doctor's Notes:</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Additional observations and recommendations"></textarea>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="follow-up" name="follow_up">
                    <label for="follow-up">Follow-up Required:</label>
                    <label for="follow-up-date">Follow-up Date:</label>
                    <input type="date" id="follow-up-date" name="follow_up_date">
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-primary">Update Patient Records</button>
                    <button type="reset" class="btn-secondary">Clear Form</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
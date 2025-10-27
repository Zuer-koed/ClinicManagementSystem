<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - My Profile</title>
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
        
        .profile-section {
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
        
        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        .profile-table th, .profile-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .profile-table th {
            background-color: #f8f9fa;
            color: #4d93c2ff;
            font-weight: 600;
            width: 30%;
        }
        
        .profile-table tr:hover {
            background-color: #f9f9f9;
        }
        
      
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #4d93c2ff;
            border: 2px solid #4d93c2ff;
        }
        
        .btn-outline:hover {
            background-color: #4d93c2ff;
            color: white;
        }
        
        .important-info {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .important-info h3 {
            color: #856404;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .important-info p {
            color: #856404;
            margin: 0;
            font-size: 14px;
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
        
      
        .mobile-profile-view {
            display: none;
        }
        
        .profile-card {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #4d93c2ff;
        }
        
        .profile-card .label {
            font-weight: 600;
            color: #4d93c2ff;
            display: block;
            margin-bottom: 5px;
        }
        
        .profile-card .value {
            color: #333;
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
            
            .profile-table {
                display: none; 
            }
            
            .mobile-profile-view {
                display: block;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-profile-view {
                display: none; /* Hide card view on desktop */
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
                    <h1>My Profile</h1>
                    <p>Welcome, Hajimi!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="patient_dashboard.php">Dashboard</a></li>
                        <li><a href="my_appointment.php">My Appointments</a></li>
                        <li><a href="book_appointment.php">Book Appointment</a></li>
                        <li><a href="patient_profile.php" class="active">My Profile</a></li>
                        <li><a href="medical_history.php">Medical History</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <h1 class="page-title">Profile Information</h1>
        
        <div class="profile-section">
            <h2 class="section-title">Personal Details</h2>
            
            
            <table class="profile-table" aria-label="Patient profile information">
                <tr>
                    <th scope="row">Patient ID</th>
                    <td>P-2024-001</td>
                </tr>
                <tr>
                    <th scope="row">Full Name</th>
                    <td>Hajimi</td>
                </tr>
                <tr>
                    <th scope="row">Date of Birth</th>
                    <td>March 15, 1985</td>
                </tr>
                <tr>
                    <th scope="row">Email Address</th>
                    <td>hajimi@gmail.com</td>
                </tr>
                <tr>
                    <th scope="row">Phone Number</th>
                    <td>(+60) 10785 6788</td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>123, Taman Mambo, 11900 Bayan Lepas, Pulau Pinang</td>
                </tr>
                <tr>
                    <th scope="row">Emergency Contact</th>
                    <td>Jacky (+60) 10085 66543</td>
                </tr>
                <tr>
                    <th scope="row">Blood Type</th>
                    <td>AB+</td>
                </tr>
                <tr>
                    <th scope="row">Primary Care Physician</th>
                    <td>Dr. Sarah Chen</td>
                </tr>
            </table>
            
            
            <div class="mobile-profile-view">
                <div class="profile-card">
                    <span class="label">Patient ID</span>
                    <span class="value">P-2024-001</span>
                </div>
                <div class="profile-card">
                    <span class="label">Full Name</span>
                    <span class="value">Hajimi</span>
                </div>
                <div class="profile-card">
                    <span class="label">Date of Birth</span>
                    <span class="value">March 15, 1985</span>
                </div>
                <div class="profile-card">
                    <span class="label">Email Address</span>
                    <span class="value">hajimi@gmail.com</span>
                </div>
                <div class="profile-card">
                    <span class="label">Phone Number</span>
                    <span class="value">(+60) 10785 6788</span>
                </div>
                <div class="profile-card">
                    <span class="label">Address</span>
                    <span class="value">123, Taman Mambo, 11900 Bayan Lepas, Pulau Pinang</span>
                </div>
                <div class="profile-card">
                    <span class="label">Emergency Contact</span>
                    <span class="value">Jacky (+60) 10085 66543</span>
                </div>
                <div class="profile-card">
                    <span class="label">Blood Type</span>
                    <span class="value">AB+</span>
                </div>
                <div class="profile-card">
                    <span class="label">Primary Care Physician</span>
                    <span class="value">Dr. Sarah Chen</span>
                </div>
            </div>
            
           
            <div class="important-info">
                <h3>📋 Profile Update Required</h3>
                <p>Please ensure your contact information is up to date. This helps us reach you for appointment reminders and important health updates.</p>
            </div>
            
            
            <div class="action-buttons">
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                <a href="change_password.php" class="btn btn-outline">Change Password</a>
                <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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
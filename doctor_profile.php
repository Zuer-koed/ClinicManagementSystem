<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - My Profile</title>
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
        
        .profile-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 32px;
            margin-bottom: 32px;
        }
        
        .profile-sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            height: fit-content;
        }
        
        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        
        .section-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
        }
        
        .section-card h2 {
            color: #4d93c2ff;
            margin-bottom: 20px;
            font-size: 20.8px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-photo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4d93c2ff;
            margin-bottom: 12px;
        }
        
        .btn-change-photo {
            background-color: #4d93c2ff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .btn-change-photo:hover {
            background-color: #1d5a8a;
        }
        
        .personal-info {
            margin-top: 16px;
        }
        
        .info-item {
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-item strong {
            color: #333;
            display: inline-block;
            width: 140px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
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
            min-height: 100px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .checkbox-group input {
            width: auto;
        }
        
        .action-buttons {
            display: flex;
            gap: 16px;
            margin-top: 24px;
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
        
        .btn-outline {
            background-color: white;
            color: #4d93c2ff;
            border: 1px solid #4d93c2ff;
        }
        
        .btn-outline:hover {
            background-color: #4d93c2ff;
            color: white;
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
            .profile-container {
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
            
            .action-buttons {
                flex-direction: column;
            }
            
            .info-grid {
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
                        <li><a href="patient_list.php">Patient List</a></li>
                        <li><a href="doctor_profile.php" class="active">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>My Profile</h1>
        </div>
        
        <div class="profile-container">
            <!-- Sidebar with Personal Info -->
            <div class="profile-sidebar">
                <div class="profile-photo">
                    <img src="default_doctor_avatar.jpg" alt="Doctor Profile Photo">
                    <button class="btn-change-photo">Change Photo</button>
                </div>
                <div class="personal-info">
                    <div class="info-item">
                        <strong>Full Name:</strong> Dr. Sarah Smith
                    </div>
                    <div class="info-item">
                        <strong>Email:</strong> dr.sarah.smith@nexuscare.com
                    </div>
                    <div class="info-item">
                        <strong>Phone:</strong> +6012-345-6789
                    </div>
                    <div class="info-item">
                        <strong>License No:</strong> MED123456
                    </div>
                    <div class="info-item">
                        <strong>Specialization:</strong> Cardiology
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="profile-main">
                <!-- Professional Information -->
                <section class="section-card">
                    <h2>Professional Information</h2>
                    <div class="info-grid">
                        <div>
                            <h3>Education</h3>
                            <p>MBBS - University of Malaya (2010)</p>
                            <p>MD Cardiology - National University of Malaysia (2015)</p>
                        </div>
                        <div>
                            <h3>Qualifications</h3>
                            <p>Board Certified Cardiologist</p>
                            <p>Advanced Cardiac Life Support (ACLS)</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bio">Professional Bio:</label>
                        <textarea id="bio" name="bio" readonly>Dr. Sarah Smith is a dedicated cardiologist with over 10 years of experience in treating heart conditions. She specializes in interventional cardiology and has performed numerous successful procedures.</textarea>
                    </div>
                </section>

                <!-- Work Schedule -->
                <section class="section-card">
                    <h2>Work Schedule</h2>
                    <div class="info-grid">
                        <div>
                            <h3>Regular Hours</h3>
                            <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                            <p>Saturday: 9:00 AM - 1:00 PM</p>
                            <p>Sunday: Closed</p>
                        </div>
                        <div>
                            <h3>Appointment Settings</h3>
                            <p>Consultation Duration: 30 minutes</p>
                            <p>Max Daily Appointments: 15 patients</p>
                        </div>
                    </div>
                </section>

                <!-- Account Settings -->
                <section class="section-card">
                    <h2>Account Settings</h2>
                    
                    <form action="" method="post">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label for="current-password">Current Password:</label>
                            <input type="password" id="current-password" name="current_password">
                        </div>
                        <div class="form-group">
                            <label for="new-password">New Password:</label>
                            <input type="password" id="new-password" name="new_password">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm New Password:</label>
                            <input type="password" id="confirm-password" name="confirm_password">
                        </div>
                        <button type="submit" class="btn-primary">Update Password</button>
                    </form>
                    
                    <form action="" method="post" style="margin-top: 24px;">
                        <h3>Notification Preferences</h3>
                        <div class="checkbox-group">
                            <input type="checkbox" id="email-notifications" name="email_notifications" checked>
                            <label for="email-notifications">Email Notifications</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="sms-notifications" name="sms_notifications" checked>
                            <label for="sms-notifications">SMS Notifications</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="appointment-reminders" name="appointment_reminders" checked>
                            <label for="appointment-reminders">Appointment Reminders</label>
                        </div>
                        <button type="submit" class="btn-primary">Save Preferences</button>
                    </form>
                </section>

                <!-- Emergency Contact -->
                <section class="section-card">
                    <h2>Emergency Contact</h2>
                    <div class="info-grid">
                        <div>
                            <p><strong>Contact Person:</strong> John Smith</p>
                            <p><strong>Relationship:</strong> Spouse</p>
                        </div>
                        <div>
                            <p><strong>Phone Number:</strong> +6019-876-5432</p>
                            <p><strong>Email:</strong> john.smith@email.com</p>
                        </div>
                    </div>
                </section>

                <!-- Action Buttons -->
                <section class="section-card">
                    <div class="action-buttons">
                        <button class="btn-primary">Edit Profile</button>
                        <button class="btn-outline">Update Schedule</button>
                        <button class="btn-secondary">Download Profile Data</button>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
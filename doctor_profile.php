<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - My Profile</title>
</head>
<body>

    <!-- Top Navigation Bar -->
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
                <li><a href="doctor_profile.php">My Profile</a></li>
            </ul>
        </nav>
        <div>
            <p>Welcome, Dr. [Name]</p>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <h1>My Profile</h1>
        
        <!-- Profile Information Section -->
        <section>
            <h2>Personal Information</h2>
            <div>
                <div>
                    <p><strong>Profile Photo:</strong></p>
                    <img src="default_doctor_avatar.jpg" alt="Doctor Profile Photo" width="150" height="150">
                    <button>Change Photo</button>
                </div>
                <div>
                    <p><strong>Full Name:</strong> Dr. Sarah Smith</p>
                    <p><strong>Email:</strong> dr.sarah.smith@nexuscare.com</p>
                    <p><strong>Phone Number:</strong> +6012-345-6789</p>
                    <p><strong>License Number:</strong> MED123456</p>
                    <p><strong>Specialization:</strong> Cardiology</p>
                </div>
            </div>
        </section>

        <!-- Professional Information Section -->
        <section>
            <h2>Professional Information</h2>
            <div>
                <p><strong>Education:</strong></p>
                <p>MBBS - University of Malaya (2010)</p>
                <p>MD Cardiology - National University of Malaysia (2015)</p>
                
                <p><strong>Qualifications:</strong></p>
                <p>Board Certified Cardiologist</p>
                <p>Advanced Cardiac Life Support (ACLS)</p>
                
                <p><strong>Bio:</strong></p>
                <p>Dr. Sarah Smith is a dedicated cardiologist with over 10 years of experience in treating heart conditions. She specializes in interventional cardiology and has performed numerous successful procedures.</p>
            </div>
        </section>

        <!-- Work Schedule Section -->
        <section>
            <h2>Work Schedule</h2>
            <div>
                <p><strong>Regular Working Hours:</strong></p>
                <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                <p>Saturday: 9:00 AM - 1:00 PM</p>
                <p>Sunday: Closed</p>
                
                <p><strong>Consultation Duration:</strong> 30 minutes per patient</p>
                <p><strong>Maximum Daily Appointments:</strong> 15 patients</p>
            </div>
        </section>

        <!-- Account Settings Section -->
        <section>
            <h2>Account Settings</h2>
            <form action="" method="post">
                <div>
                    <h3>Change Password</h3>
                    <div>
                        <label for="current-password">Current Password:</label>
                        <input type="password" id="current-password" name="current_password">
                    </div>
                    <div>
                        <label for="new-password">New Password:</label>
                        <input type="password" id="new-password" name="new_password">
                    </div>
                    <div>
                        <label for="confirm-password">Confirm New Password:</label>
                        <input type="password" id="confirm-password" name="confirm_password">
                    </div>
                    <button type="submit">Update Password</button>
                </div>
            </form>
            
            <form action="" method="post">
                <div>
                    <h3>Notification Preferences</h3>
                    <div>
                        <input type="checkbox" id="email-notifications" name="email_notifications" checked>
                        <label for="email-notifications">Email Notifications</label>
                    </div>
                    <div>
                        <input type="checkbox" id="sms-notifications" name="sms_notifications" checked>
                        <label for="sms-notifications">SMS Notifications</label>
                    </div>
                    <div>
                        <input type="checkbox" id="appointment-reminders" name="appointment_reminders" checked>
                        <label for="appointment-reminders">Appointment Reminders</label>
                    </div>
                    <button type="submit">Save Preferences</button>
                </div>
            </form>
        </section>

        <!-- Emergency Contact Section -->
        <section>
            <h2>Emergency Contact</h2>
            <div>
                <p><strong>Emergency Contact Person:</strong> John Smith</p>
                <p><strong>Relationship:</strong> Spouse</p>
                <p><strong>Phone Number:</strong> +6019-876-5432</p>
                <p><strong>Email:</strong> john.smith@email.com</p>
            </div>
        </section>

        <!-- Action Buttons -->
        <section>
            <div>
                <button>Edit Profile</button>
                <button>Update Schedule</button>
                <button>Download Profile Data</button>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
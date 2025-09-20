<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Doctor Portal</title>
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
            </ul>
        </nav>
        <div>
            <p>Welcome, Dr. [Name]</p>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <h2>Today's Appointments</h2>
        <p>Today's Date: <strong>[Dynamic Date]</strong></p>
        
        <!-- Appointment List -->
        <div id="appointments-list">
            <!-- Example Appointment 1 -->
            <div>
                <h3>Sarah Johnson</h3>
                <p><strong>Appointment ID:</strong> #A-001</p>
                <p><strong>Reason for Visit:</strong> Routine check-up</p>
                <p><strong>Status:</strong> Confirmed</p>
                <a href="patient_details.php?patient_id=1">View Patient Details & Medical History</a>
            </div>

            <!-- Example Appointment 2 -->
            <div>
                <h3>Michael Chen</h3>
                <p><strong>Appointment ID:</strong> #A-002</p>
                <p><strong>Reason for Visit:</strong> Follow-up consultation</p>
                <p><strong>Status:</strong> Confirmed</p>
                <a href="patient_details.php?patient_id=2">View Patient Details & Medical History</a>
            </div>

            <!-- Example Appointment 3 -->
            <div>
                <h3>Emma Williams</h3>
                <p><strong>Appointment ID:</strong> #A-003</p>
                <p><strong>Reason for Visit:</strong> New symptoms evaluation</p>
                <p><strong>Status:</strong> Confirmed</p>
                <a href="patient_details.php?patient_id=3">View Patient Details & Medical History</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
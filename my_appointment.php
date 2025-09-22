<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - My Appointment</title>
</head>
<body>
    
    <nav>
        <ul>
            <li><a href="patient_dashboard.php">Dashboard</a></li>
            <li><a href="my_appointments.php">My Appointments</a></li>
            <li><a href="book_appointment.php">Book Appointment</a></li>
            <li><a href="my_profile.php">My Profile</a></li>
            <li><a href="medical_history.php">Medical History</a></li>
            <li ><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <header>
     <h1>My Appointment</h1>
        <h1>Welcome,  [Patient Name]!</h1>
    </header>

  <main>
        
        <div>
            <a href="book_appointment.php"><button>Request New Appointment</button></a>
        </div>

        
        <h2>Your Appointments</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2023-09-20</td>
                    <td>10:30 AM</td>
                    <td>Dr. Alen</td>
                    <td>Follow-up consultation</td>
                    <td>Confirmed</td>
                    <td>
                        <button onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel</button>
                    </td>
                </tr>
                <tr>
                    <td>2023-10-05</td>
                    <td>2:15 PM</td>
                    <td>Dr. Hanami</td>
                    <td>Annual physical exam</td>
                    <td>Pending</td>
                    <td>
                        <button onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel</button>
                    </td>
                </tr>
                <tr>
                    <td>2023-09-05</td>
                    <td>9:00 AM</td>
                    <td>Dr. Jacky</td>
                    <td>Allergy symptoms</td>
                    <td>Completed</td>
                    <td>
                        <button disabled>Cancel</button>
                    </td>
                </tr>
              
            </tbody>
        </table>
    </main>

     <footer>
    <p>&copy; 2024 City Clinic. All rights reserved.</p>
  </footer>
</body>
</html>

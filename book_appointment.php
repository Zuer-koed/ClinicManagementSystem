<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Book Appointment</title>
</head>
<body>
    
    <nav>
        <ul>
            <li><a href="patient_dashboard.php">Dashboard</a></li>
            <li><a href="my_appointments.php">My Appointments</a></li>
            <li><a href="book_appointment.php">Book Appointment</a></li>
            <li><a href="my_profile.php">My Profile</a></li>
            <li><a href="medical_history.php">Medical History</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <header>
         <h1>Book Appointment</h1>
        <h1>Welcome,  [Patient Name]!</h1>
    </header>

    

    <main>
        <p>Please select your preferred date and time for an appointment. Our staff will review your request and confirm your appointment.</p>
        
        <form action="book_appointment.php" method="post">
            <div>
                <label for="date">Preferred Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <br>
            <div>
                <label for="time">Preferred Time Slot:</label>
                <select id="time" name="time" required>
                    <option value="">Select a time slot</option>
                    <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                    <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                    <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                    <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                    <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                    <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                    <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                </select>
            </div>
            <br>
            <div>
                <label for="reason">Reason for Visit:</label>
                <textarea id="reason" name="reason" rows="4" required placeholder="Please describe the reason for your visit"></textarea>
            </div>
        
            <br>
            <div>
                <button type="submit">Request Appointment</button>
                <button type="reset">Clear Form</button>
            </div>
        </form>
        <br>
        <div>
            <h2>* Appointment Instructions *</h2>
            <ul>
                <li>Appointments are subject to availability</li>
                <li>Our staff will contact you to confirm your appointment</li>
                <li>Please allow 24-48 hours for confirmation</li>
                <li>For urgent medical issues, please contact our office directly</li>
            </ul>
        </div>
    </main>

    <footer>
    <p>&copy; 2024 City Clinic. All rights reserved.</p>
  </footer>
</body>
</html>

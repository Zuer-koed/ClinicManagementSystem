<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Patient Details</title>
</head>
<body>

    <!-- Top Navigation Bar - Same for all doctor pages -->
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
        <h2>Patient Details</h2>
        <a href="patient_list.php">← Back to Patient List</a>

        <!-- Patient Profile Section -->
        <section>
            <h3>Patient Profile</h3>
            <div>
                <p><strong>Patient ID:</strong> P-001</p>
                <p><strong>Full Name:</strong> Sarah Johnson</p>
                <p><strong>Date of Birth:</strong> 1985-03-15 (Age: 40)</p>
                <p><strong>Gender:</strong> Female</p>
                <p><strong>Contact Email:</strong> sarah.j@email.com</p>
                <p><strong>Phone Number:</strong> 555-0101</p>
                <p><strong>Address:</strong> 123 Main Street, City, State 12345</p>
                <p><strong>Emergency Contact:</strong> John Johnson (Spouse) - 555-0106</p>
                <p><strong>Blood Type:</strong> O+</p>
                <p><strong>Known Allergies:</strong> Penicillin, Pollen</p>
            </div>
        </section>

        <!-- Medical History Section -->
        <section>
            <h3>Medical History</h3>
            <div>
                <h4>Past Appointments</h4>
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
        <section>
            <h3>Update Medical Records</h3>
            <form action="" method="post">
                <div>
                    <label for="appointment-date">Appointment Date:</label>
                    <input type="date" id="appointment-date" name="appointment_date" required>
                </div>
                <div>
                    <label for="reason">Reason for Visit:</label>
                    <input type="text" id="reason" name="reason" required>
                </div>
                <div>
                    <label for="diagnosis">Diagnosis:</label>
                    <textarea id="diagnosis" name="diagnosis" rows="3" placeholder="Enter diagnosis details"></textarea>
                </div>
                <div>
                    <label for="prescription">Prescription:</label>
                    <textarea id="prescription" name="prescription" rows="3" placeholder="List prescribed medications and dosage"></textarea>
                </div>
                <div>
                    <label for="notes">Doctor's Notes:</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Additional observations and recommendations"></textarea>
                </div>
                <div>
                    <label for="follow-up">Follow-up Required:</label>
                    <input type="checkbox" id="follow-up" name="follow_up">
                    <label for="follow-up-date">Follow-up Date:</label>
                    <input type="date" id="follow-up-date" name="follow_up_date">
                </div>
                <button type="submit">Update Patient Records</button>
                <button type="reset">Clear Form</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
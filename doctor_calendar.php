<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - My Schedule & Appointments</title>
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
        </div>
    </header>

    <main>
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
                        <td>Confirmed</td>
                        <td><a href="patient_details.php?patient_id=2">View</a> | <a href="#">Reschedule</a> | <a href="#">Cancel</a></td>
                    </tr>
                    <tr>
                        <td>Tue, 16 Sep - 2:00 PM</td>
                        <td>Emma Williams</td>
                        <td>New Symptoms</td>
                        <td>Confirmed</td>
                        <td><a href="patient_details.php?patient_id=3">View</a> | <a href="#">Reschedule</a> | <a href="#">Cancel</a></td>
                    </tr>
                    <tr>
                        <td>Wed, 17 Sep - 11:00 AM</td>
                        <td>Available Slot</td>
                        <td>-</td>
                        <td>Available</td>
                        <td><a href="#">Block Time</a></td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
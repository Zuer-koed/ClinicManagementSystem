<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Staff Portal</title>
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
        <h2>Today's Operations Overview</h2>
        <p>Today's Date: <strong>[Dynamic Date]</strong></p>

        <!-- Emergency Alerts Section -->
        <section>
            <h3>High Priority Alerts</h3>
            <div>
                <p><strong>Emergency Cases Today:</strong> 1 case requiring immediate attention</p>
                <div>
                    <h4>🚨 Emergency Patient</h4>
                    <p><strong>Patient:</strong> James Wilson</p>
                    <p><strong>Time Arrived:</strong> 10:30 AM</p>
                    <p><strong>Assigned Doctor:</strong> Dr. Smith</p>
                    <p><strong>Status:</strong> In treatment</p>
                    <a href="staff_manage_appointments.php">Manage Emergency Cases</a>
                </div>
            </div>
        </section>

        <!-- Appointment Statistics -->
        <section>
            <h3>Appointment Summary</h3>
            <div>
                <div>
                    <h4>Pending Requests</h4>
                    <p>5 appointments</p>
                    <a href="staff_manage_appointments.php?filter=pending">Review Pending</a>
                </div>
                <div>
                    <h4>Confirmed Today</h4>
                    <p>12 appointments</p>
                    <a href="staff_manage_appointments.php?filter=confirmed">View All</a>
                </div>
                <div>
                    <h4>Walk-in Patients</h4>
                    <p>3 patients</p>
                    <a href="staff_manage_appointments.php?filter=walk_in">Manage Walk-ins</a>
                </div>
                <div>
                    <h4>Completed Today</h4>
                    <p>8 appointments</p>
                    <a href="staff_manage_appointments.php?filter=completed">View Completed</a>
                </div>
            </div>
        </section>

        <!-- Master Schedule for All Doctors -->
        <section>
            <h3>Today's Master Schedule</h3>
            <table>
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>9:00-10:00</th>
                        <th>10:00-11:00</th>
                        <th>11:00-12:00</th>
                        <th>12:00-13:00</th>
                        <th>13:00-14:00</th>
                        <th>14:00-15:00</th>
                        <th>15:00-16:00</th>
                        <th>16:00-17:00</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dr. Smith</td>
                        <td>Sarah Johnson</td>
                        <td>Michael Chen</td>
                        <td>Available</td>
                        <td>Lunch</td>
                        <td>Emma Williams</td>
                        <td>James Wilson (EMERGENCY)</td>
                        <td>Available</td>
                        <td>Robert Garcia</td>
                    </tr>
                    <tr>
                        <td>Dr. Johnson</td>
                        <td>Available</td>
                        <td>Lisa Thompson</td>
                        <td>Available</td>
                        <td>Lunch</td>
                        <td>David Brown</td>
                        <td>Maria Garcia</td>
                        <td>Walk-in Slot</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>Dr. Williams</td>
                        <td>Jennifer Lee</td>
                        <td>Available</td>
                        <td>Thomas Clark</td>
                        <td>Lunch</td>
                        <td>Walk-in Slot</td>
                        <td>Available</td>
                        <td>Susan Adams</td>
                        <td>Available</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Quick Actions -->
        <section>
            <h3>Quick Actions</h3>
            <div>
                <a href="staff_manage_appointments.php?action=new_walkin">Register New Walk-in</a>
                <a href="staff_manage_appointments.php?action=new_emergency">Register Emergency Case</a>
                <a href="staff_patient_list.php">Search Patient</a>
                <a href="staff_manage_appointments.php?filter=pending">Process Pending Requests</a>
            </div>
        </section>

        <!-- Today's Activity Log -->
        <section>
            <h3>Recent Activity</h3>
            <div>
                <p><strong>10:30 AM:</strong> Emergency case registered - James Wilson</p>
                <p><strong>10:15 AM:</strong> Walk-in patient registered - Maria Garcia</p>
                <p><strong>09:45 AM:</strong> Appointment confirmed - David Brown with Dr. Johnson</p>
                <p><strong>09:30 AM:</strong> Patient checked in - Sarah Johnson</p>
                <p><strong>09:00 AM:</strong> Clinic opened for the day</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Manage Appointments</title>
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
        <h2>Appointment Management Center</h2>

        <!-- Quick Action Buttons -->
        <section>
            <h3>Quick Actions</h3>
            <div>
                <button onclick="showWalkInForm()">New Walk-in Patient</button>
                <button onclick="showEmergencyForm()">New Emergency Case</button>
                <a href="#pending-requests">View Pending Requests (5)</a>
                <a href="#queue-management">Manage Queues</a>
            </div>
        </section>

        <!-- Pending Appointment Requests Section -->
        <section id="pending-requests">
            <h3>Pending Appointment Requests</h3>
            <div>
                <!-- Pending Request 1 -->
                <div>
                    <h4>Request #R-001</h4>
                    <p><strong>Patient:</strong> New Patient - John Davis</p>
                    <p><strong>Preferred Date/Time:</strong> 2025-09-16, 2:00-3:00 PM</p>
                    <p><strong>Reason:</strong> General consultation</p>
                    <p><strong>Contact:</strong> john.d@email.com | 555-0110</p>
                    
                    <form action="" method="post">
                        <input type="hidden" name="request_id" value="1">
                        <div>
                            <label for="doctor1">Assign Doctor:</label>
                            <select id="doctor1" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. Smith</option>
                                <option value="2">Dr. Johnson</option>
                                <option value="3">Dr. Williams</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment_time1">Appointment Time:</label>
                            <input type="datetime-local" id="appointment_time1" name="appointment_time" required>
                        </div>
                        <button type="submit" name="action" value="confirm">Confirm Appointment</button>
                        <button type="submit" name="action" value="reject">Reject Request</button>
                    </form>
                </div>

                <!-- Pending Request 2 -->
                <div>
                    <h4>Request #R-002</h4>
                    <p><strong>Patient:</strong> Sarah Johnson (Existing)</p>
                    <p><strong>Preferred Date/Time:</strong> 2025-09-17, 10:00-11:00 AM</p>
                    <p><strong>Reason:</strong> Follow-up check</p>
                    
                    <form action="" method="post">
                        <input type="hidden" name="request_id" value="2">
                        <div>
                            <label for="doctor2">Assign Doctor:</label>
                            <select id="doctor2" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. Smith</option>
                                <option value="2">Dr. Johnson</option>
                                <option value="3">Dr. Williams</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment_time2">Appointment Time:</label>
                            <input type="datetime-local" id="appointment_time2" name="appointment_time" required>
                        </div>
                        <button type="submit" name="action" value="confirm">Confirm Appointment</button>
                        <button type="submit" name="action" value="reject">Reject Request</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Walk-in Registration Form (Initially Hidden) -->
        <section id="walkin-form" style="display: none;">
            <h3>Register Walk-in Patient</h3>
            <form action="" method="post">
                <div>
                    <label><input type="radio" name="patient_type" value="existing" checked> Existing Patient</label>
                    <label><input type="radio" name="patient_type" value="new"> New Patient</label>
                </div>
                
                <div id="existing-patient">
                    <label for="search_patient">Search Patient:</label>
                    <input type="text" id="search_patient" name="search_patient" placeholder="Enter patient name or ID">
                </div>
                
                <div id="new-patient">
                    <div>
                        <label for="walkin_name">Full Name:</label>
                        <input type="text" id="walkin_name" name="walkin_name">
                    </div>
                    <div>
                        <label for="walkin_phone">Phone Number:</label>
                        <input type="tel" id="walkin_phone" name="walkin_phone">
                    </div>
                </div>
                
                <div>
                    <label for="walkin_doctor">Assign to Doctor:</label>
                    <select id="walkin_doctor" name="walkin_doctor" required>
                        <option value="">Select Doctor</option>
                        <option value="1">Dr. Smith</option>
                        <option value="2">Dr. Johnson</option>
                        <option value="3">Dr. Williams</option>
                    </select>
                </div>
                
                <div>
                    <label for="walkin_reason">Reason for Visit:</label>
                    <input type="text" id="walkin_reason" name="walkin_reason" required>
                </div>
                
                <button type="submit" name="action" value="walkin">Register Walk-in</button>
                <button type="button" onclick="hideWalkInForm()">Cancel</button>
            </form>
        </section>

        <!-- Emergency Registration Form (Initially Hidden) -->
        <section id="emergency-form" style="display: none;">
            <h3>Register Emergency Case</h3>
            <form action="" method="post">
                <div>
                    <label for="emergency_name">Patient Name:</label>
                    <input type="text" id="emergency_name" name="emergency_name" required>
                </div>
                
                <div>
                    <label for="emergency_doctor">Assign to Doctor:</label>
                    <select id="emergency_doctor" name="emergency_doctor" required>
                        <option value="">Select Doctor</option>
                        <option value="1">Dr. Smith</option>
                        <option value="2">Dr. Johnson</option>
                        <option value="3">Dr. Williams</option>
                    </select>
                </div>
                
                <div>
                    <label for="emergency_reason">Emergency Details:</label>
                    <textarea id="emergency_reason" name="emergency_reason" required placeholder="Describe the emergency situation"></textarea>
                </div>
                
                <div>
                    <label for="emergency_priority">Priority Level:</label>
                    <select id="emergency_priority" name="emergency_priority">
                        <option value="high">High Priority</option>
                        <option value="critical">Critical (Immediate)</option>
                    </select>
                </div>
                
                <button type="submit" name="action" value="emergency">Register Emergency</button>
                <button type="button" onclick="hideEmergencyForm()">Cancel</button>
            </form>
        </section>

        <!-- Queue Management Section -->
        <section id="queue-management">
            <h3>Current Queues</h3>
            
            <!-- Dr. Smith's Queue -->
            <div>
                <h4>Dr. Smith's Queue</h4>
                <ol>
                    <li>
                        <strong>James Wilson</strong> (EMERGENCY) - Chest pain
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                    <li>
                        <strong>Sarah Johnson</strong> (Confirmed) - Routine check-up
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                    <li>
                        <strong>Walk-in: Maria Garcia</strong> - Fever and cough
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                </ol>
            </div>

            <!-- Dr. Johnson's Queue -->
            <div>
                <h4>Dr. Johnson's Queue</h4>
                <ol>
                    <li>
                        <strong>David Brown</strong> (Confirmed) - Allergy consultation
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                    <li>
                        <strong>Walk-in: Thomas Lee</strong> - Minor injury
                        <button>Move Up</button>
                        <button>Move Down</button>
                        <button>Remove</button>
                    </li>
                </ol>
            </div>
        </section>

        <!-- Today's Appointments Overview -->
        <section>
            <h3>Today's Appointments Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>09:00 AM</td>
                        <td>Sarah Johnson</td>
                        <td>Dr. Smith</td>
                        <td>Confirmed</td>
                        <td>Checked In</td>
                        <td><a href="#">Edit</a> | <a href="#">Cancel</a></td>
                    </tr>
                    <tr>
                        <td>10:30 AM</td>
                        <td>James Wilson</td>
                        <td>Dr. Smith</td>
                        <td>Emergency</td>
                        <td>In Treatment</td>
                        <td><a href="#">Edit</a> | <a href="#">Complete</a></td>
                    </tr>
                    <tr>
                        <td>11:00 AM</td>
                        <td>Walk-in: Maria Garcia</td>
                        <td>Dr. Smith</td>
                        <td>Walk-in</td>
                        <td>Waiting</td>
                        <td><a href="#">Edit</a> | <a href="#">Cancel</a></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

    <script>
        function showWalkInForm() {
            document.getElementById('walkin-form').style.display = 'block';
            document.getElementById('emergency-form').style.display = 'none';
        }
        
        function showEmergencyForm() {
            document.getElementById('emergency-form').style.display = 'block';
            document.getElementById('walkin-form').style.display = 'none';
        }
        
        function hideWalkInForm() {
            document.getElementById('walkin-form').style.display = 'none';
        }
        
        function hideEmergencyForm() {
            document.getElementById('emergency-form').style.display = 'none';
        }
    </script>

</body>
</html>
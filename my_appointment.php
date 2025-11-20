<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - My Appointments </title>
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
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            color: #4d93c2ff;
            font-size: 32px;
        }
        
        .btn-primary {
            background-color: #4d93c2ff;
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary:hover {
            background-color: #1d5a8a;
        }
        
        .appointments-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f0f8ff;
            color: #4d93c2ff;
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .status-confirmed {
            color: #28a745;
            font-weight: 600;
        }
        
        .status-pending {
            color: #ffc107;
            font-weight: 600;
        }
        
        .status-completed {
            color: #6c757d;
            font-weight: 600;
        }
        
        .btn-cancel {
            background-color: #ff6b6b;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background-color: #e55a5a;
        }
        
        .btn-cancel:disabled {
            background-color: #ccc;
            cursor: not-allowed;
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
            
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            table {
                display: block;
                overflow-x: auto;
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
                    <h1>My Appointments</h1>
                    <p>Welcome, [Patient Name]!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="patient_dashboard.php">Dashboard</a></li>
                        <li><a href="my_appointment.php" class="active">My Appointments</a></li>
                        <li><a href="book_appointment.php">Book Appointment</a></li>
                        <li><a href="patient_profile.php">My Profile</a></li>
                        <li><a href="medical_history.php">Medical History</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1 class="page-title">Your Appointments</h1>
            <a href="book_appointment.php" class="btn-primary">Request New Appointment</a>
        </div>
        
        <div class="appointments-section">
            <h2 class="section-title">Appointment History</h2>
            
            <table>
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
                        <td class="status-confirmed">Confirmed</td>
                        <td>
                            <button class="btn-cancel">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2023-10-05</td>
                        <td>2:15 PM</td>
                        <td>Dr. Hanami</td>
                        <td>Annual physical exam</td>
                        <td class="status-pending">Pending</td>
                        <td>
                            <button class="btn-cancel">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2023-09-05</td>
                        <td>9:00 AM</td>
                        <td>Dr. Jacky</td>
                        <td>Allergy symptoms</td>
                        <td class="status-completed">Completed</td>
                        <td>
                            <button class="btn-cancel" disabled>Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <script>
       
        document.querySelectorAll('.btn-cancel').forEach(btn => {
            btn.onclick = function() {
                if (!this.disabled) {
                    return confirm('Are you sure you want to cancel this appointment?');
                }
                return false;
            };
        });
    </script>
</body>
</html>
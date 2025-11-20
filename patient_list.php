<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Patient List</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .page-header h1 {
            color: #4d93c2ff;
            font-size: 28.8px;
        }
        
        .search-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 24px;
        }
        
        .search-form {
            display: flex;
            gap: 12px;
            align-items: end;
        }
        
        .form-group {
            flex: 1;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 2px rgba(77, 147, 194, 0.2);
        }
        
        button {
            padding: 10px 20px;
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
        
        .patients-table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 32px;
            margin-bottom: 24px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background-color: #f0f8ff;
            color: #4d93c2ff;
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .btn-view {
            display: inline-block;
            background-color: #4d93c2ff;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .btn-view:hover {
            background-color: #1d5a8a;
        }
        
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 16px 24px;
        }
        
        .pagination-info {
            color: #666;
        }
        
        .pagination-controls {
            display: flex;
            gap: 8px;
        }
        
        .pagination-btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background-color: white;
            color: #333;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .pagination-btn:hover {
            background-color: #4d93c2ff;
            color: white;
            border-color: #4d93c2ff;
        }
        
        .pagination-btn.active {
            background-color: #4d93c2ff;
            color: white;
            border-color: #4d93c2ff;
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
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .pagination {
                flex-direction: column;
                gap: 16px;
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
                        <li><a href="patient_list.php" class="active">Patient List</a></li>
                        <li><a href="doctor_profile.php">My Profile</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1>Patient List</h1>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form action="" method="get" class="search-form">
                <div class="form-group">
                    <label for="search">Search Patients</label>
                    <input type="text" id="search" name="search" placeholder="Enter patient name or ID">
                </div>
                <button type="submit" class="btn-primary">Search</button>
                <button type="reset" class="btn-secondary">Clear</button>
            </form>
        </div>

        <!-- Patient List Table -->
        <div class="patients-table">
            <table>
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Last Visit</th>
                        <th>Contact Info</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>P-001</td>
                        <td>Sarah Johnson</td>
                        <td>1985-03-15</td>
                        <td>2025-09-10</td>
                        <td>sarah.j@email.com<br>555-0101</td>
                        <td><a href="patient_details.php?patient_id=1" class="btn-view">View Details</a></td>
                    </tr>
                    <tr>
                        <td>P-002</td>
                        <td>Michael Chen</td>
                        <td>1978-11-22</td>
                        <td>2025-09-08</td>
                        <td>michael.c@email.com<br>555-0102</td>
                        <td><a href="patient_details.php?patient_id=2" class="btn-view">View Details</a></td>
                    </tr>
                    <tr>
                        <td>P-003</td>
                        <td>Emma Williams</td>
                        <td>1992-07-30</td>
                        <td>2025-09-05</td>
                        <td>emma.w@email.com<br>555-0103</td>
                        <td><a href="patient_details.php?patient_id=3" class="btn-view">View Details</a></td>
                    </tr>
                    <tr>
                        <td>P-004</td>
                        <td>Robert Garcia</td>
                        <td>1980-12-10</td>
                        <td>2025-08-28</td>
                        <td>robert.g@email.com<br>555-0104</td>
                        <td><a href="patient_details.php?patient_id=4" class="btn-view">View Details</a></td>
                    </tr>
                    <tr>
                        <td>P-005</td>
                        <td>Lisa Thompson</td>
                        <td>1975-05-18</td>
                        <td>2025-08-25</td>
                        <td>lisa.t@email.com<br>555-0105</td>
                        <td><a href="patient_details.php?patient_id=5" class="btn-view">View Details</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <div class="pagination-info">
                <p>Showing 1-5 of 12 patients</p>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn">Previous</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">Next</button>
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
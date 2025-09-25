<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Patient List</title>
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
        <h2>Patient List</h2>
        
        <!-- Search Bar -->
        <div>
            <form action="" method="get">
                <label for="search">Search Patients:</label>
                <input type="text" id="search" name="search" placeholder="Enter patient name or ID">
                <button type="submit">Search</button>
                <button type="reset">Clear</button>
            </form>
        </div>

        <!-- Patient List Table -->
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
                    <td><a href="patient_details.php?patient_id=1">View Details</a></td>
                </tr>
                <tr>
                    <td>P-002</td>
                    <td>Michael Chen</td>
                    <td>1978-11-22</td>
                    <td>2025-09-08</td>
                    <td>michael.c@email.com<br>555-0102</td>
                    <td><a href="patient_details.php?patient_id=2">View Details</a></td>
                </tr>
                <tr>
                    <td>P-003</td>
                    <td>Emma Williams</td>
                    <td>1992-07-30</td>
                    <td>2025-09-05</td>
                    <td>emma.w@email.com<br>555-0103</td>
                    <td><a href="patient_details.php?patient_id=3">View Details</a></td>
                </tr>
                <tr>
                    <td>P-004</td>
                    <td>Robert Garcia</td>
                    <td>1980-12-10</td>
                    <td>2025-08-28</td>
                    <td>robert.g@email.com<br>555-0104</td>
                    <td><a href="patient_details.php?patient_id=4">View Details</a></td>
                </tr>
                <tr>
                    <td>P-005</td>
                    <td>Lisa Thompson</td>
                    <td>1975-05-18</td>
                    <td>2025-08-25</td>
                    <td>lisa.t@email.com<br>555-0105</td>
                    <td><a href="patient_details.php?patient_id=5">View Details</a></td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination (for when we have many patients) -->
        <div>
            <p>Showing 1-5 of 12 patients</p>
            <button>Previous</button>
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>Next</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
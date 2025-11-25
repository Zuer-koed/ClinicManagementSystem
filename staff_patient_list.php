<?php
session_start();
require_once 'db_connection.php';
$database = new Database();
$pdo = $database->getConnection();

// Check if user is logged in and is a staff member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit();
}

$staff_id = $_SESSION['user_id'];

// Get staff information
$stmt = $pdo->prepare("SELECT * FROM staff WHERE staff_id = ?");
$stmt->execute([$staff_id]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle search and pagination
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Build query for patients
$query = "
    SELECT p.*, u.email, MAX(a.preferred_date) as last_visit
    FROM patient p 
    JOIN user u ON p.user_id = u.user_id 
    LEFT JOIN appointment a ON p.patient_id = a.patient_id 
    WHERE 1=1
";

$params = [];
$countParams = [];

if (!empty($search)) {
    $query .= " AND (p.full_name LIKE ? OR p.patient_id = ? OR u.email LIKE ? OR p.phone_number LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    
    // Handle patient ID search (remove 'P-' prefix if present)
    $patientIdSearch = str_replace('P-', '', $search);
    $params[] = $patientIdSearch;
    
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $countParams[] = $searchTerm;
    $countParams[] = $patientIdSearch;
    $countParams[] = $searchTerm;
    $countParams[] = $searchTerm;
}

$query .= " GROUP BY p.patient_id ORDER BY p.full_name LIMIT $limit OFFSET $offset";

// Get patients
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total count for pagination
$countQuery = "
    SELECT COUNT(DISTINCT p.patient_id) as total
    FROM patient p 
    JOIN user u ON p.user_id = u.user_id 
    LEFT JOIN appointment a ON p.patient_id = a.patient_id 
    WHERE 1=1
";

if (!empty($search)) {
    $countQuery .= " AND (p.full_name LIKE ? OR p.patient_id = ? OR u.email LIKE ? OR p.phone_number LIKE ?)";
}

$stmt = $pdo->prepare($countQuery);
$stmt->execute($countParams);
$totalResult = $stmt->fetch(PDO::FETCH_ASSOC);
$totalPatients = $totalResult ? $totalResult['total'] : 0;
$totalPages = $totalPatients > 0 ? ceil($totalPatients / $limit) : 1;

// Ensure page is within valid range
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;
?>

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
            text-decoration: none;
            display: inline-block;
            text-align: center;
            line-height: normal;
            padding: 10px 20px;
            border-radius: 4px;
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
            text-decoration: none;
            display: inline-block;
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
                    <h1>Staff Portal</h1>
                    <p>Welcome, <?php echo htmlspecialchars($staff['full_name'] ?? 'Staff Member'); ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="staff_dashboard.php">Dashboard</a></li>
                        <li><a href="staff_manage_appointment.php">Manage Appointments</a></li>
                        <li><a href="staff_patient_list.php" class="active">Patient List</a></li>
                        <li><a href="staff_profile.php">My Profile</a></li>
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
                    <input type="text" id="search" name="search" placeholder="Enter patient name, ID, email, or phone" value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <button type="submit" class="btn-primary">Search</button>
                <a href="staff_patient_list.php" class="btn-secondary">Clear</a>
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
                        <th>Gender</th>
                        <th>Last Visit</th>
                        <th>Contact Info</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($patients) > 0): ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>P-<?php echo str_pad($patient['patient_id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                                <td><?php echo $patient['date_of_birth'] ?? 'Not provided'; ?></td>
                                <td><?php echo ucfirst($patient['gender'] ?? 'Not specified'); ?></td>
                                <td><?php echo $patient['last_visit'] ?? 'No visits yet'; ?></td>
                                <td>
                                    <?php echo htmlspecialchars($patient['email']); ?>
                                    <?php if (!empty($patient['phone_number'])): ?>
                                        <br><?php echo htmlspecialchars($patient['phone_number']); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="staff_patient_details.php?patient_id=<?php echo $patient['patient_id']; ?>" class="btn-view">View Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">
                                <?php echo empty($search) ? 'No patients found.' : 'No patients found matching your search.'; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <div class="pagination-info">
                <p>
                    <?php 
                    $start = (($page - 1) * $limit) + 1;
                    $end = min($page * $limit, $totalPatients);
                    echo "Showing $start-$end of $totalPatients patients"; 
                    ?>
                </p>
            </div>
            <div class="pagination-controls">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">Previous</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn <?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">Next</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 NexusCare. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
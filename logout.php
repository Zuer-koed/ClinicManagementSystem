<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Logout</title>
</head>
<body>

    <!-- Simple Header -->
    <header>
        <div>
            <h1>NexusCare</h1>
            <p>Doctor Portal</p>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div>
            <h2>Logout</h2>
            <p>Are you sure you want to logout?</p>
            
            <div>
                <form action="process_logout.php" method="post">
                    <button type="submit">Yes, Logout</button>
                </form>
                
                <a href="doctor_dashboard.php">
                    <button>Cancel</button>
                </a>
            </div>
            
            <div>
                <p>You will be redirected to the login page.</p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
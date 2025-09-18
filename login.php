<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Login</title>
</head>
<body>

    <header>
        <h1>NexusCare Login</h1>
        <p>Access your dedicated portal.</p>
        <a href="index.php">← Back to Home</a>
    </header>

    <main>
        <section id="login-form">
            <h2>Login to Your Portal</h2>
            <form action="" method="post">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div>
                    <label for="role">Login as:</label>
                    <select id="role" name="role" required>
                        <option value="">-- Select Role --</option>
                        <option value="patient">Patient</option>
                        <option value="doctor">Doctor</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register as a patient here.</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 NexusCare. All rights reserved.</p>
    </footer>

</body>
</html>
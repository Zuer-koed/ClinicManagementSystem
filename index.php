<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCare - Home</title>
</head>
<body>

    <header>
        <img src="Picture/NexusCareLogo_withoutbg.png" alt="NexusCare Logo" width="150">
        <h1>Welcome to NexusCare</h1>
    </header>

    <main>
        <section id="about">
            <h2>About Us</h2>
            <p>At NexusCare, we are dedicated to providing compassionate and comprehensive healthcare for you and your family. Our team of experienced doctors and nurses utilizes a modern, patient-centered approach to ensure you receive the highest quality of care in a comfortable environment.</p>
            <p>We believe in leveraging technology to make healthcare more accessible and efficient.</p>
            <p>Your health is our journey together.</p>
        </section>

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
                    <label for="role">I am a:</label>
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
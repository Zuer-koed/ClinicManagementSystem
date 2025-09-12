<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Clinic - Home</title>
    <!-- We will add CSS and Bootstrap links here later -->
</head>
<body>

    <header>
        <h1>Welcome to City Clinic</h1>
        <p>Your health is our priority.</p>
    </header>

    <main>
        <section id="about">
            <h2>About Us</h2>
            <p>We provide comprehensive and compassionate healthcare for the entire family. Our team of experienced doctors and staff is dedicated to your well-being.</p>
        </section>

        <section id="login-form">
            <h2>Login to Your Portal</h2>
            <!-- The form submits to itself for now (action="") -->
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
        <p>&copy; 2024 City Clinic. All rights reserved.</p>
    </footer>

</body>
</html>
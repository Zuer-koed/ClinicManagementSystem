<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NexusCare - Patient Registration</title>
</head>
<body>
  <header>
    <h1>Welcome to NexusCare</h1>
    <p>Create your patient account to access healthcare services online.</p>
    <a href="index.php">← Back to Home</a>
  </header>

  <main>
    <section id="register-form">
      <h2>Patient Registration</h2>

      <form action="" method="post">
        <div>
          <label for="name">Full Name:</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div>
          <label for="phone">Phone Number:</label>
          <input type="tel" id="phone" name="phone">
        </div>

        <div>
          <label for="dob">Date of Birth:</label>
          <input type="date" id="dob" name="dob" required>
        </div>

        <div>
          <label for="address">Address:</label>
          <textarea id="address" name="address" rows="3"></textarea>
        </div>

        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div>
          <label for="confirm_password">Confirm Password:</label>
          <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit">Register</button>
      </form>
      
      <p>Already have an account? <a href="index.php">Login here</a></p>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 NexusCare. All rights reserved.</p>
  </footer>
</body>
</html>
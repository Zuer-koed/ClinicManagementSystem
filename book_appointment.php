<?php
session_start();

// Database connection
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Fetch patient details from database
try {
    $stmt = $pdo->prepare("
        SELECT p.full_name 
        FROM patient p 
        WHERE p.user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $patient = $stmt->fetch();
    
    if (!$patient) {
        // Patient record not found, redirect to login
        header("Location: logout.php");
        exit();
    }
    
    $patient_name = $patient['full_name'];
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $patient_name = "Patient"; // Fallback name
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            margin-bottom: 10px;
            font-weight: 700; 
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
        
        .btn-primary-custom {
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
        
        .btn-primary-custom:hover {
            background-color: #1d5a8a;
            color: white;
        }
        
        .appointment-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 32px;
        }
        
        .section-title {
            background-color: #f0f8ff;
            padding: 15px;
            margin: -30px -30px 25px -30px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 22px;
            color: #4d93c2ff;
            grid-column: 1 / -1;
        }
        
        .form-container {
            padding: 0;
        }
        
        .instructions {
            background-color: white;
            border-radius: 8px;
            padding: 0;
            height: fit-content;
        }
        
        h1 {
            color: #4d93c2ff;
            margin-bottom: 16px;
            font-size: 28.8px;
        }
        
        h2 {
            color: #4d93c2ff;
            margin: 24px 0 16px;
            font-size: 20.8px;
        }
        
        p {
            margin-bottom: 24px;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 0.2rem rgba(77, 147, 194, 0.25);
        }
        
        .button-group {
            display: flex;
            gap: 16px;
        }
        
        .quick-contact {
            background: linear-gradient(135deg, #4d93c2ff 0%, #1d5a8a 100%);
            color: white;
            border-radius: 10px;
            padding: 25px;
        }
        
        .quick-contact h5 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
            font-size: 20.8px;
        }
        
        .contact-method {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 16.8px;
        }
        
        .contact-method strong {
            margin-right: 8px;
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
            
            .appointment-section {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .logo {
                height: 150px;
                width: 150px;
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
                    <h1>Book Appointment</h1>
                    <p>Welcome, <?php echo htmlspecialchars($patient_name); ?>!</p>
                </div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
            
            <nav>
                <div class="nav-container">
                    <ul>
                        <li><a href="patient_dashboard.php">Dashboard</a></li>
                        <li><a href="my_appointment.php">My Appointments</a></li>
                        <li><a href="book_appointment.php" class="active">Book Appointment</a></li>
                        <li><a href="patient_profile.php">My Profile</a></li>
                        <li><a href="medical_history.php">Medical History</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="page-header">
            <h1 class="page-title">Book New Appointment</h1>
            <a href="my_appointment.php" class="btn-primary-custom">View My Appointments</a>
        </div>
        
        <div class="appointment-section">
            <h2 class="section-title">Appointment Request Form</h2>
            
            <div class="form-container">
                <div class="alert alert-success d-none" id="successMessage" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    Your appointment request has been submitted successfully! Our staff will contact you within 24-48 hours to confirm.
                </div>
        
                <p>Please select your preferred date and time for an appointment. Our staff will review your request and confirm your appointment.</p>
        
                <form id="appointmentForm" action="book_appointment.php" method="post">
                    <div class="mb-3">
                        <label for="date" class="form-label">Preferred Date:</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="time" class="form-label">Preferred Time Slot:</label>
                        <select id="time" name="time" class="form-select" required>
                            <option value="">Select a time slot</option>
                            <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                            <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                            <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                            <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                            <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                            <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                            <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Visit:</label>
                        <textarea id="reason" name="reason" rows="6" class="form-control" required placeholder="Please describe the reason for your visit"></textarea>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Request Appointment</button>
                        <button type="reset" class="btn btn-secondary">Clear Form</button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#helpModal">
                            Need Help?
                        </button>
                    </div>
                </form>
        
                <div class="d-none text-center my-3" id="loadingIndicator">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Submitting your request...</p>
                </div>
            </div>
            
            <div class="instructions">
                <h2>Quick Contact</h2>
                <div class="quick-contact">
                    <div class="contact-method">
                        <strong>Emergency:</strong> (+60)19-456 7567
                    </div>
                    <div class="contact-method">
                        <strong>Email:</strong> nexuscare@gmail.com
                    </div>
                    <div class="contact-method">
                        <strong>Business Hours:</strong> Mon-Fri 8:00 AM - 6:00 PM
                    </div>
                    <div class="contact-method">
                        <strong>Address:</strong> 302E-1, Jalan Dato Ismail Hashim, Sungai Ara, 11900 Bayan Lepas, Pulau Pinang
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="helpModalLabel">Appointment Instructions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Booking Process:</h6>
                    <ol>
                        <li>Select your preferred date and time slot</li>
                        <li>Describe your reason for visit in detail</li>
                        <li>Submit your request</li>
                        <li>Wait for confirmation (24-48 hours)</li>
                    </ol>
                    
                    <h6 class="mt-4">Important Guidelines:</h6>
                    <ul>
                        <li>Appointments subject to doctor's availability</li>
                        <li>Arrive 15 minutes early for paperwork</li>
                        <li>Bring insurance card and photo ID</li>
                        <li>24-hour notice required for cancellations</li>
                        <li>Late arrivals may be rescheduled</li>
                        <li>Payment due at time of service</li>
                        <li>Telehealth options available</li>
                    </ul>
                    
                    <div class="alert alert-warning mt-4">
                        <strong>Emergency?</strong> Call us immediately at <strong>(+60)19-456 7567</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it!</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
            dateInput.value = today;
            
            // Enhanced date validation to exclude weekends
            dateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const dayOfWeek = selectedDate.getDay();
                
                // 0 = Sunday, 6 = Saturday
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    alert('Please select a weekday (Monday-Friday). We are closed on weekends.');
                    this.value = today;
                }
            });
            
            document.getElementById('appointmentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Basic form validation
                const date = document.getElementById('date').value;
                const time = document.getElementById('time').value;
                const reason = document.getElementById('reason').value.trim();
                
                if (!date || !time || !reason) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                if (reason.length < 10) {
                    alert('Please provide a more detailed reason for your visit (at least 10 characters).');
                    return;
                }
                
                document.getElementById('loadingIndicator').classList.remove('d-none');
                
                // Simulate form submission
                setTimeout(function() {
                    document.getElementById('loadingIndicator').classList.add('d-none');
                    document.getElementById('successMessage').classList.remove('d-none');
                    
                    // Reset form but keep today's date
                    e.target.reset();
                    dateInput.value = today;
                    
                    // Scroll to top to show success message
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    // Hide success message after 5 seconds
                    setTimeout(function() {
                        document.getElementById('successMessage').classList.add('d-none');
                    }, 5000);
                }, 1500);
            });
        });
    </script>
</body>
</html>
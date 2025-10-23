<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Care - Book Appointment</title>
    
    <!-- Bootstrap CSS -->
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
            margin-bottom: 10px; /* Increased from 5px to 10px */
            font-weight: 700; /* Added bold weight */
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
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 2px rgba(77, 147, 194, 0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .button-group {
            display: flex;
            gap: 16px;
        }
        
        button {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .btn-info:hover {
            background-color: #138496;
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
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
        
        /* Quick Contact Section */
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
        
        /* Success Message */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 24px;
            display: none;
        }
        
        /* Loading animation */
        .loading {
            display: none;
            text-align: center;
            padding: 16px;
        }
        
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #4d93c2ff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
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
        
        /* Bootstrap enhanced styles */
        .bootstrap-enhanced .form-control:focus {
            border-color: #4d93c2ff;
            box-shadow: 0 0 0 0.2rem rgba(77, 147, 194, 0.25);
        }
        
        .bootstrap-enhanced .btn {
            font-weight: 600;
        }
    </style>
<header>
    <div class="header-container">
        <img src="Logo.png" alt="Nexus Care Clinic Logo" class="logo">
        <div class="welcome-section">
            <div class="welcome-message">
                <h1>Book Appointment</h1>
                <p>Welcome, [Patient Name]!</p>
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
            <a href="my_appointment.php" class="btn-primary">View My Appointments</a>
        </div>
        
        <div class="appointment-section">
            <h2 class="section-title">Appointment Request Form</h2>
            
            <div class="form-container">
                <!-- Bootstrap Alert for Success Message -->
                <div class="alert alert-success d-none" id="successMessage" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    Your appointment request has been submitted successfully! Our staff will contact you within 24-48 hours to confirm.
                </div>
        
                <p>Please select your preferred date and time for an appointment. Our staff will review your request and confirm your appointment.</p>
        
                <form id="appointmentForm" action="book_appointment.php" method="post">
                    <div class="form-group">
                        <label for="date" class="form-label">Preferred Date:</label>
                        <input type="date" id="date" name="date" class="form-control" required min="">
                    </div>
                    
                    <div class="form-group">
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
                    
                    <div class="form-group">
                        <label for="reason" class="form-label">Reason for Visit:</label>
                        <textarea id="reason" name="reason" rows="6" class="form-control" required placeholder="Please describe the reason for your visit"></textarea>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Request Appointment</button>
                        <button type="reset" class="btn btn-secondary">Clear Form</button>
                        
                        <!-- Bootstrap Modal Trigger Button -->
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#helpModal">
                            Need Help?
                        </button>
                    </div>
                </form>
        
                <!-- Bootstrap Loading Spinner -->
                <div class="d-none text-center my-3" id="loadingIndicator">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Submitting your request...</p>
                </div>
            </div>
            
            <!-- Quick Contact Sidebar -->
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

    <!-- Bootstrap Help Modal with Appointment Instructions -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent past dates
            const dateInput = document.getElementById('date');
            dateInput.min = new Date().toISOString().split('T')[0];
            
            // Handle form submission with Bootstrap enhancements
            document.getElementById('appointmentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading indicator
                document.getElementById('loadingIndicator').classList.remove('d-none');
                
                // Simulate server processing
                setTimeout(function() {
                    // Hide loading indicator
                    document.getElementById('loadingIndicator').classList.add('d-none');
                    
                    // Show success message
                    document.getElementById('successMessage').classList.remove('d-none');
                    
                    // Reset form
                    e.target.reset();
                    
                    // Scroll to top
                    window.scrollTo(0, 0);
                    
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

    <main>
       <div class="form-container">
            <!-- Bootstrap Alert for Success Message -->
            <div class="alert alert-success d-none" id="successMessage" role="alert">
                <h4 class="alert-heading">Success!</h4>
                Your appointment request has been submitted successfully! Our staff will contact you within 24-48 hours to confirm.
            </div>
    
            <p>Please select your preferred date and time for an appointment. Our staff will review your request and confirm your appointment.</p>
    
            <form id="appointmentForm" action="book_appointment.php" method="post">
                <div class="form-group">
                    <label for="date" class="form-label">Preferred Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required min="">
                </div>
                
                <div class="form-group">
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
                
                <div class="form-group">
                    <label for="reason" class="form-label">Reason for Visit:</label>
                    <textarea id="reason" name="reason" rows="6" class="form-control" required placeholder="Please describe the reason for your visit"></textarea>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Request Appointment</button>
                    <button type="reset" class="btn btn-secondary">Clear Form</button>
                    
                    <!-- Bootstrap Modal Trigger Button -->
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#helpModal">
                        Need Help?
                    </button>
                </div>
            </form>
    
            <!-- Bootstrap Loading Spinner -->
            <div class="d-none text-center my-3" id="loadingIndicator">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Submitting your request...</p>
            </div>
        </div>
        
        <!-- Quick Contact Sidebar - NOW WIDER -->
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
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Nexus Care. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Help Modal with Appointment Instructions -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent past dates
            const dateInput = document.getElementById('date');
            dateInput.min = new Date().toISOString().split('T')[0];
            
            // Handle form submission with Bootstrap enhancements
            document.getElementById('appointmentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading indicator
                document.getElementById('loadingIndicator').classList.remove('d-none');
                
                // Simulate server processing
                setTimeout(function() {
                    // Hide loading indicator
                    document.getElementById('loadingIndicator').classList.add('d-none');
                    
                    // Show success message
                    document.getElementById('successMessage').classList.remove('d-none');
                    
                    // Reset form
                    e.target.reset();
                    
                    // Scroll to top
                    window.scrollTo(0, 0);
                    
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
<?php
session_start();
include 'connection.php'; // Ensure this file contains a valid database connection

$error_message = "";
$success_message = "";

// Initialize $email_value to avoid "undefined variable" error
$email_value = isset($_POST['email']) ? trim($_POST['email']) : "";

// ** REGISTRATION PROCESS ** (Removed bcrypt)
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $dob = $_POST['dob'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate input
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        echo "<script>alert('❌ Invalid name format!');</script>";
    } elseif (!preg_match("/^[0-9]{10}$/", $contact)) {
        echo "<script>alert('❌ Invalid contact number!');</script>";
    } elseif ($password !== $confirmPassword) {
        echo "<script>alert('❌ Passwords do not match!');</script>";
    } else {
        // Store password in plain text (⚠️ NOT SECURE)
        $query = "INSERT INTO regis (Name, Contact, DOB, Email, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $name, $contact, $dob, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Registration successful!');</script>";
        } else {
            echo "<script>alert('❌ Registration failed. Email might already be registered.');</script>";
        }
        $stmt->close();
    }
}

// ** LOGIN PROCESS ** (Removed bcrypt)
if (isset($_POST['login'])) {
    $email_value = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT id, Password FROM regis WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email_value);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['Password']) {  // Plain text comparison
        $_SESSION['user_id'] = $user['id'];
        echo "<script>alert('✅ Login successful!'); window.location='day1.php';</script>";
    } else {
        echo "<script>alert('❌ Invalid email or password.');</script>";
    }
    $stmt->close();
}

// ** PASSWORD RESET PROCESS ** (Removed bcrypt)
if (isset($_POST['reset_password'])) {
    $email = trim($_POST['reset_username']);
    $new_password = $_POST['new_password'];

    $query = "UPDATE regis SET Password = ? WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $new_password, $email);  // Storing as plain text

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "<script>alert('✅ Password has been reset successfully!');</script>";
    } else {
        echo "<script>alert('❌ Email not found or no changes made!');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<html>
<head>
    <title>Contact Us</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

           a {
            text-decoration: none;
            color: white;
             }
              /* Content Sections */
        #ex1 {
            background-color: #e1f2ef;
            width: 1243px;
            padding: 20px;
            margin: auto;
        }
   .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #618780;
            padding: 15px;
            width: 1243px;
   
        }

        .navbar img {
            width: 150px;
            height: auto;
        }

        .nav-links {
            display: flex;
            gap: 10px;
           }

        /* Basic styling */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
        }


        body {
            background-color: white;
            width: 1243px;
            margin: auto;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1rem;
            color: #555;
        }

        .content {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .contact-details, .contact-form {
            flex: 1;
            background-color: #e1f2ef;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 10px;
        }

        .contact-details h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;


        }

        .detail {
            margin-bottom: 20px;

   
        }

        .detail strong {
            font-size: 1.1rem;
            display: block;
            margin-bottom: 5px;
        }

        .social a {
            display: inline-block;
            margin: 10px;
            font-size: 2rem;
            color: #555;
            transition: 0.3s;
            text-decoration: none;
        }

        .social a:hover {
            color: #ff4c4c;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .contact-form textarea {
            height: 150px;
            resize: none;
        }

        .button {
            border: none;
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            background-color: #618780;
            cursor: pointer;
            border-radius: 20px;
        }

        .button:hover {
            background-color: #4b5e5b;
        }

        .message {
            display: none;
            color: green;
            font-size: 1.2rem;
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
        }
.faq {
        max-width: 800px;
        margin: auto;
    }

    .faq-item {
        background: #fff;
        border-radius: 5px;
        margin: 10px 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .faq-question {
        width: 100%;
        background: #618780;
        color: white;
        border: none;
        padding: 15px;
        text-align: left;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px;
    }

    .faq-answer {
        display: none;
        padding: 15px;
        background: #f9f9f9;
        border-top: 1px solid #ccc;
    }

    .icon {
        font-weight: bold;
    }
/* Footer */
        .footer {
            background-color: #618780;
            text-align: center;
            padding: 20px;
            width: 1243px;
        }

        .footer .footer-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .footer .contact-info {
            margin-top: 10px;
            font-size: 16px;
        }

        .footer img {
            width: 150px;
        }

        @media screen and (max-width: 1243px) {
            body, .navbar, #ex1, .content, .footer {
                min-width: 1243px; /* Ensures the page never shrinks */
            }
        }
.btn {
            padding: 10px 15px;
            font-size: 18px;
            background: #618780;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 20px;
        }
        .btn:hover {
            background: #4b5e5b;
        }

   
</style>

<script>
   document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".faq-question").forEach(button => {
        button.addEventListener("click", () => {
            const answer = button.nextElementSibling;
            const icon = button.querySelector(".icon");

            if (answer.style.display === "block") {
                answer.style.display = "none";
                icon.textContent = "+";
            } else {
                answer.style.display = "block";
                icon.textContent = "-";
            }
        });
    });
});
</script>

    </style>
</head>
<body>
 <div class="navbar">
        <img src="./image/Black and Grey Square Social Logo.png" alt="Challenge Rise Logo">
        <div class="nav-links">
            <button class="button"><a href="home.php">Home</a></button>
            <button class="button"><a href="aboutus.php">About Us</a></button>
            <button class="button"><a href="workshop.php">Workshop</a></button>
             <button class="button"><a href="contactus.php">Contact Us</a></button>
            <button class="button"><a href="rg1.php">Registration</a></button>
            <button class="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
           
            <button class="button"><a href="admin.php">Admin</a></button>
        </div>
    </div>

    <div id="ex1">
        <div class="content">
</div>
    </div>


<div class="container">
    <h1>Contact Us</h1>
    <p>Have questions or just want to say hello? We’re here for you! Drop us a message, and we’ll get back to you.</p>

    <div class="content">
        <div class="contact-details">
            <h2>Our Contact Details</h2>
                       
            <div class="detail">
                <strong>Address:</strong>
                <p>Dummy Area, Dummy Street</p>
            </div>

            <div class="detail">
                <strong>Phone No.:</strong>
                <p>111-222-333</p>
            </div>

            <div class="detail">
                <strong>Email:</strong>
                <p>challengeRise@gmail.com</p>

            </div>

            <div class="social">
                <h3>Follow Us:</h3>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="contact-form">
            <form id="contactForm" method="POST">
<h2>Feedback</h2>
                <input type="text" id="name" placeholder="Your Name" required>
                <input type="email" id="email" placeholder="Your Mail" required>
                <textarea id="message" placeholder="Your Message" required></textarea>
                <button class="button" type="submit">SUBMIT</button>
                <div class="message" id="successMessage">✅ Message Submitted Successfully!</div>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <h1 style="font-size:50px;">FAQ'S</h1>
    <div class="faq">
        <div class="faq-item">
            <button class="faq-question">What is Challenge Rise? <span class="icon">+</span></button>
            <div class="faq-answer">Challenge Rise is a dynamic platform designed to help individuals develop better habits and achieve their goals.</div>
        </div>
        <div class="faq-item">
            <button class="faq-question">How can I register for a workshop? <span class="icon">+</span></button>
            <div class="faq-answer">You can register for a workshop by visiting our Registration page and filling out the required details.</div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Is Challenge Rise free to join? <span class="icon">+</span></button>
            <div class="faq-answer">Some features of Challenge Rise are free, but certain premium workshops and programs require a fee.</div>
        </div>
        <div class="faq-item">
            <button class="faq-question">How can I contact customer support? <span class="icon">+</span></button>
            <div class="faq-answer">You can contact us via email at challengeRise@gmail.com or call us at 111-222-333.</div>
        </div>
    </div>
</div>
<!-- Footer -->
    <div class="footer">
        <img src="./image/Black and Grey Square Social Logo11.png" alt="Challenge Rise Logo">
        <div class="footer-links">
            <button class="button"><a href="home.php">Home</a></button>
            <button class="button"><a href="aboutus.php">About Us</a></button>
            <button class="button"><a href="workshop.php">Workshop</a></button>
            <button class="button"><a href="contactus.php">Contact Us</a></button>
        </div>
        <div class="contact-info">
            <p><font color=white><span style='font-size:25px;'>&#128379;</span> 111-222-333 | <span style='font-size:25px;'>&#128386;</span>
 challengeRise@gmail.com</font></p>
            <center><hr style="height:2px; border-width:0; color:white; background-color:white; width:80%;"></center>
            <button class="button"><a href="tc.php">Terms & Conditions</a></button><font color=white>|</font>
            <button class="button"><a href="pp.php">Privacy Policy</a></button>
            <p><font color=white>© 2025 Challenge Rise. All Rights Reserved.</font></p>    
        </div>
    </div>
<!-- Modal for Login -->
    <!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
    <!-- Email input -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" 
            value="<?php echo htmlspecialchars($email_value); ?>" required>
    </div>

    <!-- Password input -->
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" style="color:black;">
        <center>Forgot Password?</center>
    </a>

    <!-- Login button -->
    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>

            </div>
        </div>
    </div>
</div>

   <!-- Bootstrap Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (for modal functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Forgot Password Modal -->

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="reset_username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" name="reset_password" class="btn btn-primary w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
<script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        let name = document.getElementById('name').value;
        let contact = document.getElementById('contact').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirmPassword').value;
        let errorMessage = '';

        if (/\d/.test(name)) {
            errorMessage = '❌ Name cannot contain numbers!';
        }
        if (!/^[0-9]+$/.test(contact)) {
            errorMessage = '❌ Contact number must contain only numbers!';
        }
        if (password !== confirmPassword) {
            errorMessage = '❌ Passwords do not match!';
        }

        if (errorMessage) {
            event.preventDefault();
            alert(errorMessage);
        } else {
            alert('✅ Registration Successful! Redirecting to homepage...');
        }
    });

    <?php if (!empty($error_message)) : ?>
        alert("<?php echo $error_message; ?>");
    <?php endif; ?>
</script>

</body>
</html>
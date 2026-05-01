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
<title>Terms & Conditions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
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
.hero {
            text-align: center;
            background: linear-gradient(to bottom, #e1f2ef, white);
            padding: 50px 20px;
            color: #095859;
           font-family: "Times New Roman", serif;
   }
.container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color:#6B6B6B;

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
</head>
<body>

    <div class="navbar">
        <img src="./image/Black and Grey Square Social Logo.png" alt="Challenge Rise Logo">
        <div class="nav-links">
            <button class="button"><a href="home.php">Home</a></button>
            <button class="button"><a href="aboutus.php">About Us</a></button>
            <button class="button"><a href="workshop.php">Workshop</a></button>
            <button class="button"><a href="rg1.php">Registration</a></button>
            <button class="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="button"><a href="contactus.php">Contact Us</a></button>
        </div>
    </div>

    <div id="ex1">
        <div class="content">
</div>
    </div>

 <div class="hero">
<h1>Terms Of Service</h1>
            </div>

<div class="container">
        <h2>OVERVIEW</h2>
&nbsp;

        <p>This website is created and managed by a student passionate about sharing valuable content. Throughout the site, the terms “we”, “us” and “our” refer to Challenge Rise.  Challenge Rise offers this website, including all information, tools and services available from this site to you, the user, conditioned upon your acceptance of all terms, conditions, policies and notices stated here.<br>By visiting our site and/ or purchasing something from us, you engage in our “Service” and agree to be bound by the following terms and conditions (“Terms of Service”, “Terms”), including those additional terms and conditions and policies referenced herein and/or available by hyperlink. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/ or contributors of content.
</p>
     &nbsp;

        <h3>SECTION 1- ACCURACY, COMPLETENESS AND TIMELINESS OF INFORMATION</h3>
 &nbsp;
<p>We are not responsible if information made available on this site is not accurate, complete or current. The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions without consulting primary, more accurate, more complete or more timely sources of information.</P>
       
&nbsp;
 <h3>SECTION 2 - THIRD-PARTY LINKS</h3>
 &nbsp;
   <p>Third-party links on this site may direct you to third-party websites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any liability or responsibility for any third-party materials or websites, or for any other materials, products, or services of third-parties.</p>


&nbsp;
 <h3>SECTION 3- USER COMMENTS, FEEDBACK AND OTHER SUBMISSIONS</h3>
 &nbsp;
   <p>If, at our request, you send certain specific submissions (for example contest entries) or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, whether online, by email, or otherwise (collectively, 'comments'), you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use in any medium any comments that you forward to us.</p>

&nbsp;
<h3>SECTION 4- PERSONAL INFORMATION</h3>
&nbsp;
<p>Your submission of personal information through the store is governed by our Privacy Policy. To view our Privacy Policy.</p>

&nbsp;
<h3>SECTION 5 - ERRORS, INACCURACIES AND OMISSIONS</h3>
&nbsp;
 <p>Occasionally there may be information on our site or in the Service that contains typographical errors, inaccuracies or omissions .We reserve the right to correct any errors, inaccuracies or omissions, and to change or update information .</p>

&nbsp;
<h3>SECTION 6 - DISCLAIMER OF WARRANTIES; LIMITATION OF LIABILITY</h3>
&nbsp;
<p>We do not guarantee, represent or warrant that your use of our service will be uninterrupted, timely, secure or error-free.We do not warrant that the results that may be obtained from the use of the service will be accurate or reliable.</p>

&nbsp;
<h3>SECTION 7 - TERMINATION</h3>
&nbsp;
<p>These Terms of Service are effective unless and until terminated by either you or us. You may terminate these Terms of Service at any time by notifying us that you no longer wish to use our Services, or when you cease using our site.</p>

&nbsp;
<h3>SECTION 8 - COMMUNICATION</h3>
&nbsp;
<p>By sharing your contact details, you consent to receive important updates about your purchases and workshops, along with occasional promotional messages about workshops, and offerings from Challenge Rise.</p>


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
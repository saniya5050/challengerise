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

<!DOCTYPE html>
<html lang="en">
<title>Registration</title>
   
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
        }

        body {
            background-color: white;
            width: 100%;
            height: 100vh;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #618780;
            padding: 15px;
        }

        .navbar img {
            width: 150px;
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

        .container {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-weight: bold;
        }

        .input-group input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #618780;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .payment-method {
            display: none;
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



    <div class="container mt-5">
    <h2 class="text-center">User Registration</h2>

    <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
<?php elseif (!empty($success_message)): ?>
    <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
<?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
    </form>
</div>

<script>
    // Check if there is an error message from the backend
    <?php if (!empty($error_message)) : ?>
        alert("<?php echo $error_message; ?>");  // Show the error message in an alert
    <?php endif; ?>

    // JavaScript to validate the login form
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        let email = document.getElementById('loginEmail').value;
        let password = document.getElementById('loginPassword').value;
        let errorMessage = '';

        // Basic validations for email and password
        if (!email || !password) {
            errorMessage = '❌ Both email and password are required!';
        }

        // If there is an error message, prevent form submission and display the message
        if (errorMessage) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
</script>
  <!--footer-->
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
    <button type="submit" name="login" class="button">Login</button>
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

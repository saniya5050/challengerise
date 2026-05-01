<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "progress2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['pass']);

    $sql = "SELECT * FROM admin WHERE email='$email' AND pass='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['email'] = $email;
        header("Location: aprogress.php"); // Redirect on success
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>

        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 320px;
            margin: 100px auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #618780;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
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
            padding: 20px;
            margin: auto;
        }

        .content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: auto;
        }

        .content img {
            width: 250px;
            height: auto;
        }

        .content p {
            font-size: 16px;
            width: 600px;
        }

        /* Footer */
        .footer {
            background-color: #618780;
            text-align: center;
            padding: 20px;
            margin: auto;
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
                width: 100%; /* Ensures the page is responsive */
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
	input[type="email"],
input[type="password"] {
    width: 94%;
    
}
    </style>
</head>
<body>
   
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="pass" placeholder="Enter your password" required>
            <input type="submit" value="Login">
        </form>
        <?php
        if (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
    </div>
    
</body>
</html>


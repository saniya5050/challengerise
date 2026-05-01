<?php
ob_start(); // Prevents "headers already sent" error
session_start(); // Ensure session starts at the beginning
include('connection.php'); // Database connection

$error_message = "";
$email_value = "";

// ** Handle Login Form Submission **
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email_value = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare the query to fetch user by email
    $query = "SELECT id, email, password FROM regis WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    // Check if prepare() succeeded
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind the email parameter to the query
    $stmt->bind_param("s", $email_value);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result of the query
    $result = $stmt->get_result();

    // Check if a user is found with the provided email
    if ($result->num_rows > 0) {
        // Fetch the user's details
        $regis = $result->fetch_assoc();
        
        // Verify the password (Ensure the password is stored as hashed in the database)
        if ($password === $regis['password']) { // ⚠️ Plain-text password check (change to password_verify if hashed)
            $_SESSION['user_id'] = $regis['id'];  // Set session variables
            $_SESSION['email'] = $regis['email'];

            // Redirect to dashboard.html upon successful login
            header("Location: dashboard.html");
            exit();
        } else {
            $error_message = "❌ Incorrect email or password.";  // If password is incorrect
        }
    } else {
        $error_message = "❌ No user found with this email.";  // If no user found
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

ob_end_flush(); // Flush the output buffer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: white; }
        .alert { margin-top: 10px; }
    </style>
</head>
<body>



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
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email_value); ?>" required>
            </div>

            <!-- Password input -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <!-- Display error message if any -->
            <?php if (!empty($error_message)) { echo '<div class="alert alert-danger text-center">' . $error_message . '</div>'; } ?>

            <!-- Login button -->
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

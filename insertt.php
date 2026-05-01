<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $dob = trim($_POST['dob']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "<script>alert('❌ Passwords do not match!');</script>";
        exit;
    }

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $query = "INSERT INTO regis (Name, Contact, DOB, Email, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $name, $contact, $dob, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registration Successful!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('❌ Registration Failed: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
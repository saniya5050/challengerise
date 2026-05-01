<?php
$servername = "localhost";  // Change if using a remote DB
$username = "root";         // Your database username
$password = "";             // Your database password
$database = "project12"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} 
?>

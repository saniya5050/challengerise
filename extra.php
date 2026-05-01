<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

// Connect to the database
$conn = new mysqli("localhost", "root", "", "progress1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === Update Days 1–7 using all entries from Day 8 onwards ===
$source_query = $conn->query("SELECT id, elapsed_time, recorded_at FROM activity_logs WHERE id >= 8 ORDER BY id ASC");

$updates = 0;
$debug_output = '';

while ($row = $source_query->fetch_assoc()) {
    $src_id = $row['id'];
    
    // Day 8 → Day 1, Day 9 → Day 2, ..., Day 14 → Day 7, Day 15 → Day 1 again, etc.
    $target_id = (($src_id - 1) % 7) + 1;

    $elapsed_time = $conn->real_escape_string($row['elapsed_time']);
    $recorded_at = $conn->real_escape_string($row['recorded_at']);

    $query = "UPDATE activity_logs 
              SET elapsed_time = '$elapsed_time', recorded_at = '$recorded_at' 
              WHERE id = $target_id";

    if ($conn->query($query) === TRUE) {
        $updates++;
        $debug_output .= "✅ Day $target_id updated using Day $src_id (Elapsed: $elapsed_time | At: $recorded_at)<br>";
    } else {
        $debug_output .= "❌ Error updating Day $target_id from Day $src_id: " . $conn->error . "<br>";
    }
}

$message = ($updates > 0) ? "$updates day(s) updated from future data." : "No updates applied.";
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Logger - Auto Mapping</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 30px;
            margin: 0;
        }

        h2.info {
            color: green;
            margin-bottom: 20px;
        }

        fieldset {
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        legend {
            font-weight: bold;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #618780;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button {
            display: block;
            margin: 30px auto 0;
            background-color: #618780;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        button:hover {
            background-color: #4b5e5b;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        .debug {
            margin: 20px auto;
            max-width: 800px;
            color: #444;
            font-size: 14px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
         /* Navbar Styles - Kept Same */
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

        /* Main Container */
        .container {
            width: 80%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #618780;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Login Form (if used) */
        .login-container {
            width: 320px;
            margin: 100px auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
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

        /* Footer Section */
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

        /* Responsive */
        @media screen and (max-width: 1243px) {
            body, .navbar, #ex1, .content, .footer {
                width: 100%;
            }
        }

        /* Content Section */
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

        /* Button Styles */
        .btn, button {
            padding: 10px 15px;
            font-size: 18px;
            background: #618780;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            margin-top: 10px;
        }

        .btn:hover, button:hover {
            background: #4b5e5b;
        }

        button a {
            color:white;
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
            <button class="button"><a href="admin.php">Admin</a></button>
            <button class="button"><a href="rg1.php">Registration</a></button>
            <button class="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="button"><a href="admin.php">Admin</a></button>
        </div>
    </div>
<h2 class="info"><?= htmlspecialchars($message) ?></h2>

<div class="debug"><?= $debug_output ?></div>

<fieldset>
    <legend>User Table (Days 1–7)</legend>
    <table>
        <tr>
            <th>DAY</th>
            <th>TIME TAKEN</th>
            <th>RECORDED AT</th>
        </tr>

        <?php
        // Reload connection to fetch the updated table
        $conn = new mysqli("localhost", "root", "", "progress1");
        if ($conn->connect_error) {
            echo "<tr><td colspan='3'>Database error: " . $conn->connect_error . "</td></tr>";
        } else {
            $result = $conn->query("SELECT id, elapsed_time, recorded_at FROM activity_logs WHERE id BETWEEN 1 AND 7 ORDER BY id ASC");

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>Day {$row['id']}</td>
                            <td>{$row['elapsed_time']}</td>
                            <td>{$row['recorded_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data available for Days 1–7.</td></tr>";
            }
            $conn->close();
        }
        ?>
    </table>
</fieldset>

<button><a href="home.php">Next</a></button>
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

</body>
</html>

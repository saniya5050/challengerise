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

$sql = "SELECT * FROM activity_logs ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Data</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Base Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
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
            color: white;
        }
    </style>
</head>
<body>
  
    <center><div class="container" >
        <h2>Progress Data</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Button 1 Status</th>
                <th>Button 2 Status</th>
                <th>Elapsed Time</th>
                <th>Recorded At</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['button1_status']}</td>
                            <td>{$row['button2_status']}</td>
                            <td>{$row['elapsed_time']}</td>
                            <td>{$row['recorded_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found.</td></tr>";
            }
            ?>
        </table>

        <div>
            <button type="button"><a href="home.php">Next</a></button>
        </div>
    </div></center>
</body>
    </html>
<?php
$conn->close();
?>

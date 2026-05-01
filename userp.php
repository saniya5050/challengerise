<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

// Connect to the database
$conn = new mysqli("localhost", "root", "", "progress2");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === Update Days 1–7 using all entries from Day 8 onwards ===
$source_query = $conn->query("SELECT id, elapsed_time, recorded_at FROM activity_logs WHERE id >= 8 ORDER BY id ASC");

while ($row = $source_query->fetch_assoc()) {
    $src_id = $row['id'];

    // Map 8→1, 9→2, ... 14→7, 15→1 again, etc.
    $target_id = (($src_id - 1) % 7) + 1;

    $elapsed_time = $conn->real_escape_string($row['elapsed_time']);
    $recorded_at = $conn->real_escape_string($row['recorded_at']);

    $query = "REPLACE INTO activity_logs (id, elapsed_time, recorded_at)
              VALUES ($target_id, '$elapsed_time', '$recorded_at')";

    $conn->query($query);
}

// === Update Days 15 and beyond based on Days 1–7 ===
$max_day = 14;
$current_day = date('j'); // Get current day number (1–31)

if ($current_day > $max_day) {
    // For Day 15 and beyond, map Day 15 to Day 1, Day 16 to Day 2, etc.
    $source_query = $conn->query("SELECT id, elapsed_time, recorded_at FROM activity_logs WHERE id >= 15 ORDER BY id ASC");

    while ($row = $source_query->fetch_assoc()) {
        $src_id = $row['id'];

        // Map 15→1, 16→2, ... 21→7, 22→1, etc.
        $target_id = (($src_id - 1) % 7) + 1;

        $elapsed_time = $conn->real_escape_string($row['elapsed_time']);
        $recorded_at = $conn->real_escape_string($row['recorded_at']);

        $query = "REPLACE INTO activity_logs (id, elapsed_time, recorded_at)
                  VALUES ($target_id, '$elapsed_time', '$recorded_at')";

        $conn->query($query);
    }
}

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
                width: 100%;
            }
        }

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

<fieldset>
    <legend>User Table (Days 1–14)</legend>
    <table>
        <tr>
            <th>DAY</th>
            <th>TIME TAKEN</th>
            <th>RECORDED AT</th>
        </tr>

        <?php
        // Connect to the database and fetch data for Days 1-14
        $conn = new mysqli("localhost", "root", "", "progress2");
        if ($conn->connect_error) {
            echo "<tr><td colspan='3'>Database error: " . $conn->connect_error . "</td></tr>";
        } else {
            $result = $conn->query("SELECT id, elapsed_time, recorded_at FROM activity_logs WHERE id BETWEEN 1 AND 14 ORDER BY id ASC");

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>Day {$row['id']}</td>
                            <td>{$row['elapsed_time']}</td>
                            <td>{$row['recorded_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data available for Days 1–14.</td></tr>";
            }
            $conn->close();
        }
        ?>
    </table>
</fieldset>

<button><a href="c.php">Next</a></button>

</body>
</html>
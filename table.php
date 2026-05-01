<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db23";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'updateButton') {
            $button = $_POST['button'];
            $_SESSION[$button . '_status'] = "yes";
            echo json_encode(["status" => "success", "message" => "$button clicked", "button" => $button]);
            exit();
        }
        
        if ($_POST['action'] === 'stopTracking') {
            $button1_status = $_SESSION['button1_status'] ?? "no";
            $button2_status = $_SESSION['button2_status'] ?? "no";
            $elapsed_time = $_POST["elapsed_time"] ?? "0 sec";

            $sql_insert = "INSERT INTO activity_logs (button1_status, button2_status, elapsed_time, recorded_at) VALUES (?, ?, ?, NOW())";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $button1_status, $button2_status, $elapsed_time);
            $stmt_insert->execute();
            $stmt_insert->close();

            $_SESSION['button1_status'] = "no";
            $_SESSION['button2_status'] = "no";
            
            echo json_encode(["status" => "success", "message" => "Data saved successfully."]);
            exit();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Button Click & Timer</title>
<script>
    let countdownValue = 0; // Start from 0 seconds
    let countdownInterval;
    let formSubmitted = false;

    function startCountdown() {
        // Initial display
        document.getElementById("countdown_timer").innerText = "Elapsed Time: " + countdownValue + " sec";

        countdownInterval = setInterval(() => {
            countdownValue++; // Increase seconds
            document.getElementById("countdown_timer").innerText = "Elapsed Time: " + countdownValue + " sec";

            if (countdownValue >= 3600) { // Stop at 60 minutes (3600 seconds)
                clearInterval(countdownInterval);
            }
        }, 1000); // 1-second interval
    }

    function stopTracking() {
        if (!formSubmitted) {
            let elapsedSeconds = countdownValue; // Track total seconds
            let formData = new FormData();
            formData.append("action", "stopTracking");
            formData.append("elapsed_time", elapsedSeconds + " sec");

            fetch("", { method: "POST", body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById("tracking_timer").innerText = "Total Time: " + elapsedSeconds + " sec";
                        formSubmitted = true;
                    }
                });
        }
    }

    function updateButtonStatus(buttonName) {
        let formData = new FormData();
        formData.append("action", "updateButton");
        formData.append("button", buttonName);

        fetch("", { method: "POST", body: formData })
            .then(response => response.json())
            .then(data => {
                document.getElementById(buttonName + "_status").innerText = "Status: Yes";
            });
    }

    // Start countdown when page loads
    window.onload = function() {
        startCountdown();
    };
</script>

</head>
<body>
    <h2>AJAX Button Click & Timer Tracker</h2>
    <button type="button" onclick="updateButtonStatus('button1')">Button 1</button>
    <span id="button1_status">Status: no</span>
    
    <button type="button" onclick="updateButtonStatus('button2')">Button 2</button>
    <span id="button2_status">Status: no</span>

    <button type="button" onclick="stopTracking()">Stop & Save Time</button>
    
    <h2>10s Countdown Timer</h2>
    <p id="countdown_timer">10s Timer: 10 sec</p>
    
    <h2>Tracking Timer</h2>
    <p id="tracking_timer">Click Stop to Save Time</p>
</body>
</html>

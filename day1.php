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

<html>
<head>
    <title>Day 1: Yoga & Meditation Challenge</title>
    <!-- Bootstrap CSS -->
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
        .content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 1243px;
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
        @media (min-width: 992px) {
            .container, .container-lg, .container-md, .container-sm {
                max-width: 1295px;
            }
        }
        .container {
            background: #e1f2ef;
            padding: 40px 10%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: black;
            text-shadow: 3px 3px 7px #4b5e5b;
        }
        .prayer {
            font-size: 18px;
            background: white;
            padding: 15px;
            border: 3px solid brown;
            color: black;
        }
        button {
            padding: 15px 25px;
            background: #4b5e5b;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            margin: 10px;
        }
        button:disabled {
            background: #bbb;
            cursor: not-allowed;
        }
        .list {
            list-style: none;
            padding: 0;
            display: none;
        }
        .list li {
            background: #618780;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            font-size: 18px;
            display: none;
        }
        #asanaImage, #asanaTimer, #meditationTimerDisplay, #meditationImage {
            display: none;
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
        }
        #asanaImage, #meditationImage {
            max-width: 80%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
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
.exercise-img {
            width: 250px;
            height: auto;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

#asanaImages, #meditationImages {
            display: none;
            margin-top: 20px;
            justify-content: center;
            gap: 20px;
        }
       
     
        .button:hover { background-color: #4b5e5b; }
        .container { background: #e1f2ef; padding: 40px; text-align: center; }
        .list { list-style-type: none; padding: 0; }
        .list li {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin: 10px 0;
        }
       .list img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
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
            <button class="button" onclick="showLoginAlert()">Login</button>
	<button class="button"><a href="home.php">Logout</a></button>
            
        </div>
    </div>
      <div class="container">
        <h1>Day-1</h1>
<h1><center>Yoga & Meditation Challenge</center></h1>
        <br>
        <h2 class="prayer">
            <font size="5"><center>"PRAYER"</center></font>
            <br>
            <center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center>
        </h2>
        <br>
<div id="countdown" style="font-size: 30px; font-weight: bold; color: black;">60:00</div>

<script>
    let timeElapsed = 0; // Start from 0
let targetTime = 3600; // 1 hour

function updateCountdown() {
    let minutes = Math.floor(timeElapsed / 60);
    let seconds = timeElapsed % 60;
    document.getElementById("countdown").textContent =
        `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

    if (timeElapsed >= targetTime) {  
        document.body.innerHTML = "<h1>Time's Up</h1>";
    } else {
        timeElapsed++;
        setTimeout(updateCountdown, 1000);
    }
}

// Start the timer
updateCountdown();
;
</script>
    <button type="button" id="startYoga" onclick="updateButtonStatus('button1')">Start Yoga</button>
    <span id="button1_status"></span>

       
        <div id="asanaImages" class="image-container">
            <img src="./image/Suryanamaskar.jpg" class="exercise-img" alt="Surya Namaskar">
            <img src="./image/tree.jpg" class="exercise-img" alt="Tree Pose">
        </div>
        <button type="button" id="startMeditation" onclick="updateButtonStatus('button2')">Start Meditation</button>
    <span id="button2_status"></span>
       
        <div id="meditationImages" class="image-container">
            <img src="./image/breath.jpg" class="exercise-img" alt="Deep Breathing">
            <img src="./image/sav.jpg" class="exercise-img" alt="Body Scan">

        </div>
        <button type="button" id="n" onclick="stopTracking()"><a href="day2.php">Next</a></button>
       
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
 
    </div>
    <script>
        document.getElementById("startYoga").addEventListener("click", () => {
            document.getElementById("asanaImages").style.display = "flex";
        });

        document.getElementById("startMeditation").addEventListener("click", () => {
            document.getElementById("meditationImages").style.display = "flex";
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js"></script>
   
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
            <p><font color="white"><span style="font-size:25px;">&#128379;</span> 111-222-333 | <span style="font-size:25px;">&#128386;</span>
            challengeRise@gmail.com</font></p>
            <center><hr style="height:2px; border-width:0; color:white; background-color:white; width:80%;"></center>
            <button class="button"><a href="tc.php">Terms & Conditions</a></button><font color="white">|</font>
            <button class="button"><a href="pp.php">Privacy Policy</a></button>
            <p><font color="white">© 2025 Challenge Rise. All Rights Reserved.</font></p>    
        </div>
    </div>
   
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
                    formSubmitted = true;

                    // **Show alert only, no on-screen display**
                    alert("Tracking Stopped!\nTotal Time Recorded: " + elapsedSeconds + " sec");
                }
            })
            .catch(error => console.error("Error:", error));
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
<script>
  function showLoginAlert() {
    alert("You are already logged in!");
  }
</script>
</body>
</html>

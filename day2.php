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
    <title>Day-2: Pumping Breath Exercise 🌬️</title>
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
   transition: background 1s ease-in-out;
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
width: 100%;
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
        .breath-container {
            margin: 50px auto;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            transition: transform 4s ease-in-out;
        }
        .instructions {
            margin-top: 20px;
            font-size: 20px;
        }
        .start-btn {
            padding: 10px 20px;
            font-size: 16px;
            background: #4b5e5b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .wake {
            font-size: 25px;
            font-family: "Times New Roman", serif;
            color: black;
   text-align: left;

        }
        h2 {
            color: white;
        }
        .timer {
            font-size: 24px;
            font-weight: bold;
            color: black;
            margin-top: 20px;
        }
       
        @media (max-width: 600px) {
            .breath-container {
                width: 150px;
                height: 150px;
                font-size: 16px;
            }
            .instructions, .timer {
                font-size: 18px;
            }
            .start-btn {
                font-size: 14px;
                padding: 8px 16px;


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
.gif-container {
            margin-top: 20px;
            display: none;
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
        <center><h1>Day-2</h1>
        <h1>Wake up 30 min Early</h1>
        <br><h2 class="prayer"><font size="5">"PRAYER"</font><br><br>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</h2><br><br>
       
<table>
<tr>
<td>
        <p class="wake">
WHY WE SHOULD WAKE UP<br>30MIN EARLY?&nbsp;<br><br>
        1. Calm & Peaceful Start<br>
        2. Extra Time for Morning Routine <br>
        3. Better Smooth Transition to Early Rising<br>
        4. Mental Clarity<br>
        5. Enhances Discipline & Willpower Avoids Rushing<br>
        6. Aligns with Natural Body Rhythm<br>
        </p>
    </div>
</td>
<td>
<video width="480" controls>
  <source src="./video/VID-20250317-WA0000.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
</td>
</tr></table>
    <h1><br>Pumping Breath Exercise 🌬️</h1>
    <div class="breath-container" id="breathCircle">Inhale</div>
    <p class="instructions" id="instructions">Follow the animation to breathe.</p>
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
<button type="button" onclick="updateButtonStatus('button1'); startBreathing();" class="start-btn">Start</button>
    <span id="button1_status"></span>
   <br>
    <button type="button" onclick="updateButtonStatus('button2'); showGif();" class="start-btn">Breathing Exercise</button>
    <span id="button2_status"></span>
    <div class="gif-container" id="gif-container">
        <img src="./image/4e08b5aa-6daa-4b56-935e-bb3e4727c9da.gif" alt="Breathing Exercise GIF" width="450" height="400">
    </div>
    <script>
        function showGif() {
            document.getElementById('gif-container').style.display = 'block';
        }
    </script>
    <div id="nextStep" class="hidden"><br>
        <button class="button" id="n" onclick="stopTracking()" class="start-btn"><a href="day3.php">Next</a></button>
            <p id="countdown_timer"></p>
    
    <h2></h2>
    <p id="tracking_timer"></p>
    </div>
    <script>
       function startBreathing() {
    let breathCircle = document.getElementById("breathCircle");
    let instructions = document.getElementById("instructions");

    function breathe() {
        if (breathCircle.style.transform === "scale(1.5)") {
            breathCircle.style.transform = "scale(1)";
            instructions.innerText = "Inhale deeply...";
            document.body.style.background = "#d0f0c0";
        } else {
            breathCircle.style.transform = "scale(1.5)";
            instructions.innerText = "Exhale slowly...";
            document.body.style.background = "#c0e0f0";
        }
    }

    setInterval(breathe, 4000);
    breathe();
}

           
           
    </script></div></center>
   
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
            <p><font color="white"><span style='font-size:25px;'>&#128379;</span> 111-222-333 | <span style='font-size:25px;'>&#128386;</span> challengeRise@gmail.com</font></p>
            <center><hr style="height:2px; border-width:0; color:white; background-color:white; width:80%;"></center>
            <button class="button"><a href="tc.php">Terms & Conditions</a></button><font color="white">|</font>
            <button class="button"><a href="pp.php">Privacy Policy</a></button>
            <p><font color="white">© 2025 Challenge Rise. All Rights Reserved.</font></p>
        </div>
    </div>

<!--table time entry-->
   
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
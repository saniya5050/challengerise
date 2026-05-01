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
    <title>Day-5: 30-Minute Workout</title>
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

        body{
            background-color:white;
            color: white;
            height: 100%;
            margin: 0;
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
            padding: 20px;
            margin: auto;
        }

.container {
width: 100%;
background: white;
padding: 40px 10%;
box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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

        @media screen and (max-width: 1243px) {
            body, .navbar, #ex1, .content, .footer {
                min-width: 1243px; /* Ensures the page never shrinks */
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

.exercise, .start-btn {
            display: inline-block;
            width: 200px;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
            cursor: pointer;
            position: relative;
            color: black;
            font-weight: bold;
        }

        .exercise:hover::after {
            content: attr(data-info);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: black;
            color: white;
            padding: 5px;
            border-radius: 5px;
            white-space: nowrap;
        }

        .hidden { display: none; }
        .progress-container {
            width: 80%;
            background: black;
            margin: 20px auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 20px;
            background: green;
            width: 0%;
            transition: width 0.5s;
        }

        .score { font-size: 20px; font-weight: bold; margin-top: 10px; }
        .badge { font-size: 24px; color: white; margin-top: 10px; }
        .rest-time {
            font-size: 18px;
            font-weight: bold;
            color: yellow;
            margin-top: 20px;
        }
.Benfits{
font-size:25px;
font-family:serif;
}
.black-text {
    color: black;
}
 .exercise {
            color: black;
        }
</style>
</head>
<body>

    <center><div class="navbar">
        <img src="./image/Black and Grey Square Social Logo.png" alt="Challenge Rise Logo">
        <div class="nav-links">
            <button class="button"><a href="home.php">Home</a></button>
            <button class="button"><a href="aboutus.php">About Us</a></button>
            <button class="button"><a href="workshop.php">Workshop</a></button>
	<button class="button"><a href="contactus.php">Contact Us</a></button>
            <button class="button"><a href="rg1.php">Registration</a></button>
            <button class="button" onclick="showLoginAlert()">Login</a></button>
	<button class="button"><a href="home.php">Logout</a></button>
            
        </div>
    </div>

    <div id="ex1">
        <div class="container">
<div id="prayerScreen">
<h1><center>Day-5</h1>

        <h1><center>🙏 Prayer Before Workout 🙏</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>

<table border="0">
<tr>
<td><img src="./image/practice.jpg" width="60%"></td>
<td><h2> <font color="black">Benfits of Workout-</font></h2></td>
<td><pre class="Benfits"><font color="black">
1.Improves Physical Health
2.Boosts Mental Health  
3.Enhances Flexibility & Mobility  
4.Aids in Weight Management    
5.Increases Energy Levels  
6.Strengthens Immunity  
7.Improves Sleep Quality  
8.Enhances Brain Function</font> </pre></td>
</tr>
</table>
   <button class="start-btn" onclick="startWorkout()">Start Workout</button>

       
    </div>

    <!-- Exercise Section (Hidden Initially) -->
    <div id="workoutSection" class="hidden">
        <h1>Day-5</h1>
<div id="countdown" style="font-size: 30px; font-weight: bold; color: black;"></div>

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
        <h1>30-Minute Workout</h1>
        <div id="exerciseContainer">
          <div class="exercise" data-info="Shoulder improves your shoulder flexibility" onclick="startExercise(' Shoulder Roll ', './image/Shoulder.gif')">
        Shoulder Roll
    </div>
            <div class="exercise" data-info="Jumping jacks is a full-body exercise" onclick="startExercise('Jumping Jacks', './image/jumping.gif')">Jumping Jacks</div>
        </div>
       
        <div id="exerciseView" class="hidden">
            <h2 id="exerciseTitle"></h2>
            <img id="exerciseGif" src="" alt="Exercise Gif" width="300">
         
            <button onclick="markAsDone()"type="button"  onclick="updateButtonStatus('button1')">&nbsp;Mark as Done&nbsp;</button>
            <!--<button type="button" id="startYoga" onclick="updateButtonStatus('button1')" >Start Yoga</button>-->
    <span id="button1_status"></span>

        </div>
       
        <div id="restView" class="hidden">
            <h2><font color="black">Rest Time</font></h2>
            <p><font color="black">Take a break! Next exercise starts in <span id="restTimer">05</span> seconds.</font></p>
        </div>

        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>
        <div class="progress" id="progress"><font color="black">Progress: 0/2 Completed</font></div>
        <div class="score" id="score"><font color="black">Score: 0</font></div>
        <div class="badge" id="badge"></div>

        <div id="nextStep" class="hidden">
            <!--<center><button class="button"><a href="day6.php">Next</a></button></center>-->
            <center><button type="button" class="button" onclick="stopTracking()"><a href="day6.php">Next</a></button></center>
        
    <p id="countdown_timer"></p>
    
    
    <p id="tracking_timer"></p>
        </div>
    </div>

    <script>
        let totalExercises = 2;
        let completedExercises = 0;
        let score = 0;
        let countdown;

        function startWorkout() {
            document.getElementById('prayerScreen').classList.add('hidden');
            document.getElementById('workoutSection').classList.remove('hidden');
        }

        function startExercise(name, gif) {
            document.getElementById('exerciseContainer').classList.add('hidden');
            document.getElementById('exerciseView').classList.remove('hidden');
            document.getElementById('exerciseTitle').innerText = name;
            document.getElementById('exerciseGif').src = gif;
            let timeLeft = 0;
         

   
                }
           
       

        function markAsDone() {
            clearInterval(countdown);
            completedExercises++;
            score += 10;
            document.getElementById('progress').innerText = `Progress: ${completedExercises}/${totalExercises} Completed`;
    document.getElementById('progress').classList.add('black-text');
            document.getElementById('score').innerText = `Score: ${score}`;
    document.getElementById('score').classList.add('black-text');
            document.getElementById('progressBar').style.width = `${(completedExercises / totalExercises) * 100}%`;

            document.getElementById('exerciseView').classList.add('hidden');

            if (completedExercises < totalExercises) {
                startRest();
            } else {
              document.getElementById('badge').innerText = "🏆 Fitness Champ!";
     document.getElementById('badge').classList.add('black-text');


                alert("Workout Complete! Great Job! You've earned a badge!");
                document.getElementById('exerciseContainer').classList.remove('hidden');
                document.getElementById('nextStep').classList.remove('hidden'); // Show next button
            }
        }

        function startRest() {
            document.getElementById('restView').classList.remove('hidden');
            let restTime = 05;
            document.getElementById('restTimer').innerText = restTime;

            let restCountdown = setInterval(() => {
                restTime--;
                document.getElementById('restTimer').innerText = restTime;
                if (restTime <= 0) {
                    clearInterval(restCountdown);
                    document.getElementById('restView').classList.add('hidden');
                    document.getElementById('exerciseContainer').classList.remove('hidden');
                }
            }, 1000);
        }

        function moveForward() {
            alert("Moving to the next step!");
        }
    </script></center>
</div>
    </div>

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

    <script>
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                event.preventDefault();
            }
        });
    </script>   
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
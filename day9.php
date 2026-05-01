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
    <title>Day-9: Healthy Ritual</title>
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
	.task
	{
            margin: 15px 0;
            padding: 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 18px;
            display: none;
        }
	#congrats
{
            font-size: 22px;
            margin-top: 20px;
            color: #ffcc00;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        @keyframes confetti {
            0% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(100vh); opacity: 0; }
        }
h3{
    color:black;
}
#p1{
color:black;
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

    <div id="ex1">
        <div class="container">
<h1><center>Day-9</h1>
        <h1><center>Relaxing Ritual 🌙</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<center><h2><strong>HEALTHY RITUALS</strong></h2>
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

<p >Our rituals are more important than our morning rituals because if we don't sleep properly , we won't be able to wake up and set the tone for our day</p><p>Our bedtime routine sets the tone for our sleep.</p><br>
        <p>Follow these calming steps for a peaceful sleep.</p>
        <img src="./image/family.jpg" height="40%"><br>Spend quality time with your<br> family for at least 30 minutes<br><br>
<fieldset style=" background:url('images.jpg'); background-size:cover;" >
<h3>Ask these question to yourself and reflect :</h3>
<p id="p1">1.When was the last time you took out time to spend with your family?<br><textarea row="100" cols="60"></textarea><br><br>2.When was the last time you told your family that you love and care about them?<br><textarea row="100" cols="60"></textarea></p>
</fieldset>
  <button class="button" id="startRitual"onclick="updateButtonStatus('button1')">Start Ritual</button>
    <span id="button1_status"></span>
        
        <div id="taskContainer"></div>
        <p id="congrats">🎉 Congratulations! You completed your ritual! 🎉</p>
         <p align="left"><center>Click a selfie with your family in the victory hours pose and upload it</center><br>
<form>
  <input type="file" id="myfile" name="filename" accept="image/*" onchange="previewImage(event)">
  <br>
  <img id="preview" src="" alt="Image Preview" style="max-width: 200px; display: none;">
</form>
 
     <button class="button" id="n" onclick="stopTracking()"><a href="day10.php">Next</a></button>
     <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
 
        <!-- Background Music -->
        <audio id="bgMusic" loop>
            <source src="relaxing-music.mp3" type="audio/mpeg">
        </audio>

        <!-- Completion Sound -->
        <audio id="completionSound">
            <source src="celebration.mp3" type="audio/mpeg">
        </audio>
    </div>

    <script>
        const tasks = [
            { text: "Drink a cup of warm herbal tea!(10 min)", action: showCheck },
{ text: "Take  deep breaths and relax!(15 min)", action: showBreathingCircle },
            { text: "Stretch or do light yoga for 15 min!", action: startTimer },
           
            { text: "Write 3 things you're grateful for!(2 min)", action: showTextArea },
           
{text: "Dim the lights and avoid screens for(18 min) !", action: dimLights }
        ];

        let currentTaskIndex = 0;
        const taskContainer = document.getElementById("taskContainer");
        const startButton = document.getElementById("startRitual");
        const congratsMessage = document.getElementById("congrats");
        const bgMusic = document.getElementById("bgMusic");
        const completionSound = document.getElementById("completionSound");

        startButton.addEventListener("click", () => {
            startButton.style.display = "none";
            bgMusic.play();
            showNextTask();
        });

        function showNextTask() {
            if (currentTaskIndex >= tasks.length) {
                showCompletionEffects();
                return;
            }

            const task = tasks[currentTaskIndex];
            const taskDiv = document.createElement("div");
            taskDiv.classList.add("task");
            taskDiv.innerHTML = `<span>${task.text}</span>`;
           
            taskContainer.appendChild(taskDiv);
            taskDiv.style.display = "block";
            task.action(taskDiv);
        }

        function dimLights(taskDiv) {
            document.body.style.background = "black";
            setTimeout(() => completeTask(taskDiv), 5000);
        }

        function startTimer(taskDiv) {
            let timeLeft = 10;
            const timerText = document.createElement("p");
            timerText.innerText = `Time Left: ${timeLeft}s`;
            taskDiv.appendChild(timerText);

            const countdown = setInterval(() => {
                timeLeft--;
                timerText.innerText = `Time Left: ${timeLeft}s`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    timerText.innerText = "Done! ✅";
                    completeTask(taskDiv);
                }
            }, 1000);
        }

        function showCheck(taskDiv) {
            setTimeout(() => completeTask(taskDiv), 2000);
        }

        function showTextArea(taskDiv) {
            const input = document.createElement("textarea");
            const submitButton = document.createElement("button");
            submitButton.innerText = "Submit";
	    submitButton.classList.add('button');
           
            taskDiv.appendChild(input);
            taskDiv.appendChild(submitButton);

            input.style.display = "block";
            submitButton.style.display = "block";
           
            submitButton.addEventListener("click", () => {
                if (input.value.trim() !== "") {
                    completeTask(taskDiv);
                } else {
                    alert("Please enter at least one thing you're grateful for!");
                }
            });
        }

        function showBreathingCircle(taskDiv) {
            const breathingCircle = document.createElement("div");
            breathingCircle.style.width = "100px";
            breathingCircle.style.height = "100px";
            breathingCircle.style.background = "#ffcc00";
            breathingCircle.style.borderRadius = "50%";
            breathingCircle.style.margin = "10px auto";
            breathingCircle.style.animation = "breathe 5s infinite ease-in-out";
           
            const style = document.createElement("style");
            style.innerHTML = `
                @keyframes breathe {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.5); }
                    100% { transform: scale(1); }
                }
            `;
            document.head.appendChild(style);
           
            taskDiv.appendChild(breathingCircle);
            setTimeout(() => completeTask(taskDiv), 10000);
        }

        function completeTask(taskDiv) {
            currentTaskIndex++;
            showNextTask();
        }

        function showCompletionEffects() {
            congratsMessage.style.opacity = 1;
            bgMusic.pause();
            completionSound.play();
            triggerConfetti();
        }

        function triggerConfetti() {
            for (let i = 0; i < 50; i++) {
                let confetti = document.createElement("div");
                confetti.style.position = "fixed";
                confetti.style.width = "10px";
                confetti.style.height = "10px";
                confetti.style.backgroundColor = getRandomColor();
                confetti.style.left = `${Math.random() * window.innerWidth}px`;
                confetti.style.top = `-${Math.random() * 50}px`;
                confetti.style.animation = "confetti 2s linear infinite";
               
                document.body.appendChild(confetti);
                setTimeout(() => confetti.remove(), 2000);
            }
        }

        function getRandomColor() {
            const colors = ["#ffcc00", "#ff6600", "#ff0066", "#66ff66", "#0099ff"];
            return colors[Math.floor(Math.random() * colors.length)];
        }
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById("preview");
        preview.src = e.target.result;
        preview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
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

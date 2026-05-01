
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
    <title>Day-14: Random Act of Kindness</title>
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
	.progress-bar-container {
            width: 100%;
            background-color: #ddd;
            border-radius: 10px;
            height: 30px;
            margin-top: 20px;
            position: relative;
        }

        .progress-bar {
            background-color: #00bcd4;
            height: 100%;
            width: 0;
            border-radius: 10px;
        }

        .reflection {
            margin-top: 30px;
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.2em;
        }
	textarea, input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
	</style>
<script>
        let progress = 0;
        let currentTask = 0;
        const tasks = [
            "Give a compliment to someone.",
            "Help someone with a task.",
            "Share a positive post on social media.",
            "Donate to a charity of your choice.",
            "Spend time with someone who needs company.",
            "Send a thank-you message to someone you appreciate.",
            "Do something kind for a stranger."
        ];

        function startGame() {
            document.getElementById("startButton").style.display = 'none';
            document.getElementById("taskContainer").style.display = 'block';
            startNextTask();
        }

        function startNextTask() {
            if (currentTask < tasks.length) {
                document.getElementById("taskTitle").textContent = `Challenge ${currentTask + 1}`;
                document.getElementById("taskDescription").textContent = tasks[currentTask];
                document.getElementById("completeTaskButton").style.display = 'inline-block';
            } else {
                endGame();
            }
        }

        function completeTask() {
            progress += 14.28;
            document.getElementById("progressBar").style.width = progress + '%';
            document.getElementById("completeTaskButton").style.display = 'none';
            document.getElementById("reflectionContainer").style.display = 'block';
        }

        function submitReflection() {
            const reflectionInput = document.getElementById("reflectionInput").value;
            if (reflectionInput.trim() === "") {
                alert("Please share your reflection before submitting.");
                return;
            }

            alert("Thank you for sharing your reflection! Let's move to the next task.");
            currentTask++;
            document.getElementById("reflectionContainer").style.display = 'none';
            startNextTask();
        }

        function endGame() {
            document.getElementById("taskContainer").style.display = 'none';
            document.getElementById("reflectionContainer").style.display = 'none';
            document.getElementById("title").textContent = 'You’ve Completed the Morning Kindness Challenge!';
            document.getElementById("description").textContent = 'Start your day with love, and let it ripple through the world.';
        }
    </script>
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
<h1><center>Day-14</h1>
        <h1><center>Spread Kindness Today</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<center><div id="countdown" style="font-size: 30px; font-weight: bold; color:black"></div>
<script>
let timeElapsed = 0; // Start from 0
let targetTime = 3600; // 1 hour
let timerStarted = false;
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
   
</script>
<div class="progress-bar-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        <br><button class="button" id="startButton" onclick="startGame()">Start Morning Challenge</button>

        <div id="taskContainer" style="display: none;">
            <h2 id="taskTitle">Challenge 1</h2>
            <p id="taskDescription"></p>
            <button class="button" id="completeTaskButton" onclick="completeTask()">Complete Task</button>
        </div>

        <div id="reflectionContainer" style="display: none;">
            <div class="reflection">
                <p>How did this act of kindness make your morning feel?</p>
                <input type="text" id="reflectionInput" placeholder="Your reflection...">
                <br><br>
                <button class="button" onclick="submitReflection()">Submit Reflection</button>
            </div>
        </div>

        <br><br><h2>Write a morning letter to your future self</h2>
        <textarea rows="5" placeholder="Dear future me, this morning I..."></textarea>
        <br><br>
       
        <button class="button" id="n" onclick="stopTracking()"><a href="userp.php">Next</a></button>
       
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
</main>
    </div></center>
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
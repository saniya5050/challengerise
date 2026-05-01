
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
    <title>Day-13: Try a New Hobbies</title>
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
	h2, h3 {
            margin: 20px 0;
        }
	ul {
            list-style: disc;
            padding-left: 40px;
            text-align: left;
            margin: 30px 0;
        }

        li {
            padding: 10px 0;
            font-size: 18px;
        }

        .hobby-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hobby-buttons button, #startBtn, #submitBtn {
            margin: 10px;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 220px;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .hobby-buttons button:disabled {
            background-color: #e0e0e0;
            cursor: not-allowed;
        }

        .hobby-buttons button:hover:enabled {
            background-color: #2980b9;
            color: white;
            transform: scale(1.05);
        }

        #startBtn {
            background-color: #3498db;
            color: white;
        }

        #submitBtn {
            background-color: #2ecc71;
            color: white;
            display: none;
            font-weight: bold;
        }

        #timer {
            font-size: 22px;
            font-weight: bold;
            color: red;
            margin-top: 20px;
            display: none;
        }

        .hobby-section {
            display: none;
            margin-top: 30px;
            text-align: left;
        }

        canvas {
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 20px auto;
            display: block;
        }

        #writingArea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin: 10px 0;
            min-height: 150px;
        }

        #codeEditor {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin: 10px 0;
            min-height: 150px;
            font-family: monospace;
        }

        #codeOutput {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            min-height: 50px;
            border: 1px solid #ccc;
            color: #333;
        }

        .image-preview-container {
            margin-top: 20px;
        }

        #imagePreview {
            max-width: 100%;
            border-radius: 8px;
            display: block;
            margin-top: 10px;
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
<h1><center>Day-13</h1>
        <h1><center>Try a New Hobbies</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<center><div id="countdown" style="font-size: 30px; font-weight: bold; color:black"></div>
        <h2>Ways to Enjoy Your Hobby</h2>
        <ul>
            <li>Set aside a specific time</li>
            <li>Create a comfortable environment</li>
            <li>Join a hobby-related community</li>
            <li>Try out new methods and techniques</li>
            <li>Set achievable challenges and goals</li>
            <li>Share your progress with others</li>
            <li>Invest in quality tools and materials</li>
            <li>Keep a journal to track your journey</li>
            <li>Mix hobbies to create new experiences</li>
            <li>Take breaks to stay refreshed</li>
        </ul>
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
        <script>
function startTimer() {
                if (!timerStarted) {
                    timerStarted = true;
                    updateCountdown();
                    document.querySelectorAll(".hobby-buttons button").forEach(btn => btn.disabled = false);
                    document.getElementById("startBtn").style.display = "none"; // Hide the Start button
                    document.getElementById("submitBtn").style.display = "block"; // Show Submit button
                }
            }
        </script>

      <button id="startBtn" onclick="startTimer()">Start</button>

<div class="hobby-buttons" style="display:none;">
  <button onclick="startHobby('painting', this)">Painting</button>
  <button onclick="startHobby('writing', this)">Writing</button>
  <button onclick="startHobby('coding', this)">Coding</button>
</div>

<div id="painting" class="hobby-section">
  <canvas id="paintCanvas" width="400" height="300"></canvas>
  <input type="color" id="colorPicker" value="#000000">
  <button onclick="clearCanvas()">Clear</button>
</div>

<div id="writing" class="hobby-section">
  <textarea id="writingArea" placeholder="Start writing your thoughts..." oninput="markCompleted('writing')"></textarea>
</div>

<div id="coding" class="hobby-section" style="display:none;">
  <textarea id="codeEditor" placeholder="Write JavaScript code here..." rows="6" cols="50"></textarea><br>
  <button onclick="runCode()">Run Code</button>
  <div id="codeOutput" style="margin-top: 10px; font-weight: bold;"></div>
</div>

<button id="submitBtn" onclick="showPopup()" style="display:none;" disabled>Submit</button>
<br>

<button class="button" id="n" onclick="stopTracking()"><a href="day14.php">Next</a></button>
       
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
</main>

<script>
   
 let selectedHobbies = 0;
  const completed = new Set();

 function startTimer() {
    if (!timerStarted) {
        timerStarted = true;
        updateCountdown();
        document.querySelectorAll(".hobby-buttons button").forEach(btn => btn.disabled = false);
        document.querySelector(".hobby-buttons").style.display = "flex"; // 👈 SHOW HOBBY BUTTONS
        document.getElementById("startBtn").style.display = "none"; // Hide Start button
    }
}
  function startHobby(id, btn) {
    if (selectedHobbies < 2) {
      btn.disabled = true;
      selectedHobbies++;
      document.getElementById(id).style.display = 'block';

      if (selectedHobbies === 2) {
        document.querySelectorAll('.hobby-buttons button').forEach(b => b.disabled = true);
      }
    } else {
      alert("Only 2 hobbies allowed.");
    }
  }

 

   function runCode() {
    const code = document.getElementById('codeEditor').value;
    const output = document.getElementById('codeOutput');

    try {
      const result = eval(code); // Only for JavaScript
      output.innerText = result !== undefined ? result : 'Code executed with no output.';
    } catch (e) {
      output.innerText = 'Error: ' + e.message;
    }

    markCompleted('coding');
  }

  function clearCanvas() {
    const canvas = document.getElementById("paintCanvas");
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    markCompleted('painting');
  }

  function showPopup() {
    alert("🎉 Congratulations! You've explored your hobbies! 🎉");
  }

  // Drawing logic
  window.addEventListener("load", () => {
    const canvas = document.getElementById("paintCanvas");
    const ctx = canvas.getContext("2d");
    const colorPicker = document.getElementById("colorPicker");
    let drawing = false;

    canvas.addEventListener("mousedown", () => {
      drawing = true;
      ctx.beginPath();
    });

    canvas.addEventListener("mouseup", () => {
      drawing = false;
      markCompleted("painting");
    });

    canvas.addEventListener("mousemove", (e) => {
      if (!drawing) return;
      const rect = canvas.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      ctx.strokeStyle = colorPicker.value;
      ctx.lineWidth = 2;
      ctx.lineTo(x, y);
      ctx.stroke();
    });
  });
function markCompleted(name) {
  if (!completed.has(name)) {
    completed.add(name);
  }
  if (completed.size >= 2) {
    const submitBtn = document.getElementById("submitBtn");
    submitBtn.style.display = "inline-block"; // show it
    submitBtn.disabled = false; // enable it
  }
}
</script></center>
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
</div>
</div>
<!-- Footer -->
    <div class="footer">
        <img src="./image/Black and Grey Square Social Logo11.png" alt="Challenge Rise Logo">
        <div class="footer-links">
            <button class="button"><a href="home.html">Home</a></button>
            <button class="button"><a href="aboutus.html">About Us</a></button>
            <button class="button"><a href="workshop.html">Workshop</a></button>
            <button class="button"><a href="contactus.html">Contact Us</a></button>
        </div>
        <div class="contact-info">
            <p><font color=white><span style='font-size:25px;'>&#128379;</span> 111-222-333 | <span style='font-size:25px;'>&#128386;</span>
 challengeRise@gmail.com</font></p>
            <center><hr style="height:2px; border-width:0; color:white; background-color:white; width:80%;"></center>
            <button class="button"><a href="tc.html">Terms & Conditions</a></button><font color=white>|</font>
            <button class="button"><a href="pp.html">Privacy Policy</a></button>
            <p><font color=white>© 2025 Challenge Rise. All Rights Reserved.</font></p>    
        </div>
    </div>
</body>
</html>
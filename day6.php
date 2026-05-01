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
    <title>Day-6📵 Limit Social Media - Fun Challenges 🚀</title>
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
@keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes floatIn {
            0% { transform: translateX(-100vw); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        .floating-content {
            opacity: 0;
            transform: translateX(-100vw);
            animation: floatIn 1s ease-out forwards;
        }
        .floating-content:nth-child(1) { animation-delay: 0.5s; }
        .floating-content:nth-child(2) { animation-delay: 0.5s; }
        .floating-content:nth-child(3) { animation-delay: 0.5s; }
        .floating-content:nth-child(4) { animation-delay: 0.5s; }
        canvas {
            border: 2px solid black;
            background: white;
        }
        .tools {
            margin: 10px 0;
        }
        .color-picker, .brush-size {
            margin-right: 10px;
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
            <button class="button" onclick="showLoginAlert()">Login</a></button>
	<button class="button"><a href="home.php">Logout</a></button>
            
        </div>
    </div>

    <div id="ex1">
        <div class="container">
<h1><center>Day-6</h1>
        <h1><center>📵 Limit Social Media - Fun Challenges 🚀</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2><center><div id="countdown" style="font-size: 30px; font-weight: bold; color: black;">60:00</div>
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

<div>
            <h2>📱 Why Limit Social Media?</h2>
            <ul style="font-size: 18pt; text-align: left; display: inline-block;">
                <li>Boost productivity and focus</li>
                <li>Improve mental well-being and reduce stress</li>
                <li>Enhance real-life interactions and relationships</li>
                <li>Develop healthier habits and better sleep patterns</li>
            </ul>
        </div>
        <div class="section floating-content">
            <h2>💃 Dance Challenge - Follow the Moves in 30 Min!</h2>
            <img src="./image/girll.gif" alt="Dancing GIF">
   <img src="./image/sheep.gif" alt="Dance Challenge" height="300">

            <br><br><p>Dance along with the GIF and have fun! 
                <button type="button" class="button" onclick="updateButtonStatus('button1')" onclick="showAlert() saveDrawing()">&nbsp;Done&nbsp;</button></p>
    <span id="button1_status"></span>
    
     
<script>
    function showAlert() {
        alert("Congrates, your dance challenge is completed.");
    }
</script>
        </div>

        <div class="section floating-content">
            <h2>🎨 Drawing Challenge - Create Art in 30 Min!</h2>
            <p>Use the canvas below to draw something amazing!</p>
            <div class="tools">
                <input type="color" id="colorPicker" class="color-picker">
                <input type="range" id="brushSize" class="brush-size" min="1" max="10" value="3">
            </div>
            <canvas id="drawingCanvas" width="400" height="300"></canvas>
            <button onclick="clearCanvas()">🧹 Clear&nbsp;</button>
	<button type="button" id="startMeditation" onclick="handleSaveClick()">💾 Save&nbsp;</button>
    <span id="button2_status"></span>
<script>        
function handleSaveClick() {
    updateButtonStatus('button2');  // Update status in session and UI
    saveDrawing();                  // Download drawing
}
</script>          
           
        </div>
<br>
 <button type="button" id="n" onclick="stopTracking()" class="button"><a href="day7.php">Next</a></button>
         <p id="countdown_timer"></p>
    
    <p id="tracking_timer"></p>
 
    </div>

    <script>
        let mediaRecorder;
        let audioChunks = [];

        function startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();
                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };
            });
        }

        function stopRecording() {
            mediaRecorder.stop();
            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                const audioUrl = URL.createObjectURL(audioBlob);
                document.getElementById('audioPlayback').src = audioUrl;
            };
        }

        let canvas = document.getElementById("drawingCanvas");
        let ctx = canvas.getContext("2d");
        let drawing = false;
        let colorPicker = document.getElementById("colorPicker");
        let brushSize = document.getElementById("brushSize");

        canvas.addEventListener("mousedown", () => drawing = true);
        canvas.addEventListener("mouseup", () => drawing = false);
        canvas.addEventListener("mousemove", draw);

        function draw(event) {
            if (!drawing) return;
            ctx.lineWidth = brushSize.value;
            ctx.lineCap = "round";
            ctx.strokeStyle = colorPicker.value;
            ctx.lineTo(event.offsetX, event.offsetY);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(event.offsetX, event.offsetY);
        }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function saveDrawing() {
            let link = document.createElement('a');
            link.download = 'drawing.png';
            link.href = canvas.toDataURL();
            link.click();
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
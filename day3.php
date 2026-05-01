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
    <title>Day-3: Hydration Challenge </title>
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
    max-width: 1243px;
    margin: auto;
   
}

/* Navbar */
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

/* Container */
.container{
width: 100%;
background: white;
padding: 40px 10%;
box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Applied to both */
}
.prayer {
font-size: 18px;
background: white;
padding: 15px;
border: 3px solid brown;
color: black;
}

/* Benefits List */
.benefits {
    padding: 0;
    list-style: none;
}

.benefits li {
    background: #7fb3d5;
    color: white;
    padding: 10px;
    margin: 5px;
    border-radius: 8px;
    font-size: 14px;
    display: none;
    animation: fadeIn 0.5s ease-in-out forwards;
}

/* Fade-in Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Wheel */
.wheel {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: conic-gradient(#ff5733, #ffbd33, #33ff57, #33a8ff, #a833ff, #ff33a8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    color: white;
    margin: 20px auto;
    cursor: pointer;
    transition: transform 2s ease-in-out;
}

/* Progress Bar */
.progress {
    width: 100%;
    background: #ddd;
    border-radius: 5px;
    margin-top: 20px;
}

.progress-bar {
    height: 20px;
    width: 0%;
    background: #4CAF50;
    border-radius: 5px;
    transition: width 1s;
}

/* Reward */
.reward {
    display: none;
    font-size: 18px;
    color: #4CAF50;
    margin-top: 20px;
}

/* Footer */
.footer {
    background-color: #618780;
    text-align: center;
    padding: 20px;
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

/* Responsive Design */
@media screen and (max-width: 1243px) {
    body, .navbar, #ex1, .container, .footer {
        min-width: 100%; /* Ensures proper responsiveness */
    }
}
h1 {
color: black;
text-shadow: 3px 3px 7px #4b5e5b;
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
.glasses {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .glass {
            width: 50px;
            height: 100px;
            background: #b3e5fc;
            border: 2px solid #0077b6;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .glass.drunk {
            background: #0077b6;
            color: white;
            transform: scale(1.1);
        }
        .progress-container {
            margin-top: 20px;
            height: 20px;
            width: 100%;
            background: #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            width: 0%;
            background: #0077b6;
            transition: width 0.3s;
        }
.progress-bar1 {
            height: 100%;
            width: 0%;
            background: #0077b6;
            transition: width 0.3s;
        }
        .message {
            margin-top: 15px;
            font-size: 18px;
            color: green;
            font-weight: bold;
            display: none;
        }
        .submit-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background: #618780;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: not-allowed;
            opacity: 0.5;
        }
        .submit-btn.enabled {
            cursor: pointer;
            opacity: 1;
            transition: background 0.3s;
        }
        .submit-btn.enabled:hover {
            background: #4b5e5b;
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
        <div class="content">
    <div class="container">
<center><h1><center>Day-3</h1>
        <h1><center>Drinking 8 glass of water Challenge</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2><br>
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
        <h2>💧 Why Drink Water?</h2>
        <ul class="benefits">
            <li>Keeps You Hydrated</li>
            <li>Boosts Energy Levels</li>
            <li>Aids Digestion</li>
            <li>Flushes Out Toxins</li>
            <li>Promotes Healthy Skin</li>
            <li>Regulates Body Temperature</li>
            <li>Supports Weight Loss</li>
            <li>Enhances Brain Function</li>
            <li>Strengthens the Immune System</li>
            <li>Lubricates Joints</li>
        </ul>
        <h1>🔹 Reverse Hydration Challenge 💦</h1>
        <p>Tap the wheel to get your funny drinking challenge! 😂<br>Do this task 5 times.</p>
        <div class="wheel" onclick="spinWheel()">🎡 Spin Me!</div>
        <p id="challengeText">Your challenge will appear here...</p>
       
<button type="button" onclick="updateButtonStatus('button1')" class="start-btn" onclick="startBreathing()" id="completeBtn" onclick="completeChallenge()" disabled>&nbsp;I Did It! ✅</button>
    <span id="button1_status"></span>

        <div class="progress">
            <div class="progress-bar" id="progressBar"></div>
        </div>
        <p class="reward" id="rewardText">🎉 Congrats! You've completed the challenge! 🎊</p>
    </div>
<center><h1>💧 8 Glasses Water Challenge 💧</h1>
    <div class="container">
        <p>Click each glass when you drink water!</p>
        <div class="glasses">
            <div class="glass" onclick="drinkWater(0)">1</div>
            <div class="glass" onclick="drinkWater(1)">2</div>
            <div class="glass" onclick="drinkWater(2)">3</div>
            <div class="glass" onclick="drinkWater(3)">4</div>
            <div class="glass" onclick="drinkWater(4)">5</div>
            <div class="glass" onclick="drinkWater(5)">6</div>
            <div class="glass" onclick="drinkWater(6)">7</div>
            <div class="glass" onclick="drinkWater(7)">8</div>
        </div>
        <div class="progress-container">
            <div class="progress-bar1" id="progressBar1"></div>
        </div>
        <p class="message" id="message">🎉 Great job! You've completed the challenge!
            <br>
            <button type="button" onclick="updateButtonStatus('button2')" class="start-btn" onclick="showGif()" class="submit-btn" id="submitBtn" disabled onclick="submitChallenge()">Submit</button></p>
            <span id="button2_status"></span>
        

    <script>
        let glasses = document.querySelectorAll(".glass");
        let progressBar = document.getElementById("progressBar1");
        let message = document.getElementById("message");
        let submitBtn = document.getElementById("submitBtn");
        let count = 0;

        function drinkWater(index) {
            if (!glasses[index].classList.contains("drunk")) {
                glasses[index].classList.add("drunk");
                count++;
            } else {
                glasses[index].classList.remove("drunk");
                count--;
            }
           
            let progress = (count / 8) * 100;
            progressBar.style.width = progress + "%";

            if (count === 8) {
                message.style.display = "block";
                submitBtn.disabled = false;
                submitBtn.classList.add("enabled");
            } else {
                message.style.display = "none";
                submitBtn.disabled = true;
                submitBtn.classList.remove("enabled");
            }
        }

        function submitChallenge() {
            alert("✅ Challenge Submitted Successfully!");
        }
    </script></center>
            <br><center><button class="button" id="n" onclick="stopTracking()" class="start-btn" class="btn"><a href="day4.php"><font color="black">&nbsp;Next&nbsp;</font></a></button></center>
               <center><p id="countdown_timer"></p></center>
    
    <center></center>
    <center><p id="tracking_timer"></p></center>
</div>
    </div></center>
     <p id="countdown_timer"></p>
    
    

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
        function showBenefits() {
            let items = document.querySelectorAll(".benefits li");
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.display = "block";
                }, index * 500);
            });
        }

        // Automatically show benefits on page load
        window.onload = showBenefits;

        const challenges = [
            "Drink with a tiny cup ☕",
            "Use a crazy straw 🥤",
            "Pretend to be in a water commercial 🎥",
            "Drink while standing on one leg 🦶",
            "Sip while humming your favorite song 🎶",
            "Take a sip after every joke you hear 😂"
        ];

    let spinCount = 0; // Counter for spins

function spinWheel() {
    let wheel = document.querySelector(".wheel");
    let randomIndex = Math.floor(Math.random() * challenges.length);
    let rotation = Math.random() * 360 + 720; // At least 2 full spins
    wheel.style.transition = "transform 2s ease-out"; // Smooth animation
    wheel.style.transform = `rotate(${rotation}deg)`;

    let completeBtn = document.getElementById("completeBtn");
    completeBtn.disabled = true; // Keep button disabled initially

    setTimeout(() => {
        document.getElementById("challengeText").textContent = challenges[randomIndex];
        spinCount++; // Increase spin count

        // Enable button only after 5 spins
        if (spinCount >= 5) {
            completeBtn.disabled = false;
        }
    }, 2000);
}

function completeChallenge() {
    let progressBar = document.getElementById("progressBar");
    progressBar.style.width = "100%";
    setTimeout(() => {
        document.getElementById("rewardText").style.display = "block";
    }, 1000);
}


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
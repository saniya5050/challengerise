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
    <title>Day-4🎯 Plan Your Day Perfectly 🚀</title>
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

header {
            background: #618780;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .container1 {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            gap: 20px;
            flex-wrap: wrap;
        }
        .box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 45%;
            min-width: 300px;
        }
        h2 { color: black; }
        ul { list-style: none; padding: 0; }
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .remove-btn {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 10px;
        }
        .remove-btn:hover { background: #c82333; }
        .memory-game {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .card {
            background: #618780;
            color: white;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
            border-radius: 5px;
            user-select: none;
        }
        .card.flipped {
            background: #28a745;
        }
        .card.matched {
            background: #ccc;
            pointer-events: none;
        }
        .timer-container1 {
            text-align: center;
            margin: 20px 0;
        }
        .timer {
            font-size: 32px;
            color: #ff5733;
            font-weight: bold;
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
<h1><center>Day-4</h1>
        <h1><center>🎯 Plan Your Day Perfectly 🚀</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2><br><header>
    <h1>Plan Your Day</h1>
</header>

<div class="timer-container1">
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
</div>

<div class="container1">
    <!-- Task Planner -->
    <div class="box">
        <h2>Task Planner</h2>
        <input type="text" id="taskInput" placeholder="Enter Task">
        <button type="button" onclick="addTask()" class="button" onclick="updateButtonStatus('button1')">Add Task</button>
    <span id="button1_status"></span>
    <ul id="taskList"></ul>
    </div>

    <!-- Perfect Plan for the Day -->
    <div class="box">
        <h2>Perfect Plan for the Day</h2>

        <button onclick="generatePerfectPlan()" class="button">Generate Plan</button>
        <ul id="planList"></ul>
    </div>

    <!-- Memory Card Game -->
    <div class="box">
        <h2>Memory Card Game</h2><br>Play minimum 2 times.
        <div class="memory-game" id="memoryGame"></div><br>
        
         <button type="button" onclick="updateButtonStatus('button2')" onclick="resetGame()" class="button">Restart Game</button>
    <span id="button2_status"></span>
    </div>
</div>

<script>
   
    // Task planner functionality
    function addTask() {
        const taskInput = document.getElementById('taskInput');
        const taskList = document.getElementById('taskList');
       
        if (taskInput.value.trim() !== "") {
            const li = document.createElement('li');
            li.textContent = taskInput.value;

            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'Remove';
            removeBtn.className = 'remove-btn';
            removeBtn.onclick = () => taskList.removeChild(li);
           
            li.appendChild(removeBtn);
            taskList.appendChild(li);
            taskInput.value = "";
        } else {
            alert('Please enter a task.');
        }
    }

    // Perfect Plan functionality
    const perfectPlans = [
       { activity: "Morning yoga and meditation", time: "7:00 AM - 8:00 AM" },
        { activity: "Healthy breakfast and reading", time: "8:00 AM - 9:00 AM" },
        { activity: "Work on important tasks", time: "9:00 AM - 12:00 PM" },
        { activity: "Take a walk during lunch break", time: "12:00 PM - 1:00 PM" },
        { activity: "Afternoon productivity boost", time: "1:00 PM - 4:00 PM" },
        { activity: "Evening relaxation with family", time: "5:00 PM - 7:00 PM" },
        { activity: "Watch a movie or read a book", time: "8:00 PM - 10:00 PM" }
    ];

    function generatePerfectPlan() {
        const planList = document.getElementById('planList');
        planList.innerHTML = "";
       
        perfectPlans.forEach(plan => {
            const li = document.createElement('li');
            li.textContent = `${plan.time} - ${plan.activity}`;
            planList.appendChild(li);
        });
    }

    // Memory Card Game
    const symbols = ['🍎', '🍌', '🍓', '🍒', '🍎', '🍌', '🍓', '🍒'];
    let flippedCards = [];

    function createMemoryGame() {
        const memoryGame = document.getElementById('memoryGame');
        memoryGame.innerHTML = '';
        const shuffledSymbols = symbols.sort(() => 0.5 - Math.random());
       
        shuffledSymbols.forEach(symbol => {
            const card = document.createElement('div');
            card.className = 'card';
            card.dataset.symbol = symbol;
            card.onclick = () => flipCard(card);
            memoryGame.appendChild(card);
        });
    }

    function flipCard(card) {
        if (flippedCards.length < 2 && !card.classList.contains('flipped')) {
            card.textContent = card.dataset.symbol;
            card.classList.add('flipped');
            flippedCards.push(card);
        }

        if (flippedCards.length === 2) {
            setTimeout(checkMatch, 800);
        }
    }

    function checkMatch() {
        if (flippedCards[0].dataset.symbol === flippedCards[1].dataset.symbol) {
            flippedCards.forEach(card => card.classList.add('matched'));
        } else {
            flippedCards.forEach(card => {
                card.textContent = '';
                card.classList.remove('flipped');
            });
        }
        flippedCards = [];
    }

    function resetGame() {
        createMemoryGame();
    }

    createMemoryGame();
</script>
<center><video width="600" controls>
  <source src="./video/Record_2025-03-31-20-04-25.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video></center><br>
<center><button class="button" type="button" id="n" onclick="stopTracking()"><a href="day5.php">Next</a></button></center>
 
    <center><p id="countdown_timer"></p></center>
    
    
    <p id="tracking_timer"></p>
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
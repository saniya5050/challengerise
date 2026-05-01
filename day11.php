
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
    <title>Day-11: Focus Mode</title>
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
	 .task {
            font-size: 20px;
            margin: 20px 0;
            background: #444;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
	    color: white;
        }
        .task-list {
            text-align: left;
            margin-top: 20px;
            background: #555;
            padding: 15px;
            border-radius: 5px;
		color: white;
        }
        .task-list ul {
            list-style-type: none;
            padding: 0;
        }
        .task-list li {
            margin: 10px 0;
            padding: 15px;
            background: #666;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .task-list li:hover {
            background: #777;
        }
        .task-list li.completed {
            background: #4caf50;
            text-decoration: line-through;
        }
        .task-list img {
            width: 80px;
            height: 80px;
            margin-right: 15px;
            border-radius: 10px;
            object-fit: cover;
        }
        #focusGame {
            margin-top: 20px;
        }
        .card {
            width: 100px;
            height: 100px;
            display: inline-block;
            margin: 10px;
            background-color: #666;
            color: transparent;
            text-align: center;
            line-height: 100px;
            font-size: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        .flipped {
            background-color: #4caf50;
            color: white;
        }
        .matched {
            background-color: #4caf50;
        }
        #nextButton, #questionSection, #submitButton, #focusGame {
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

    <div id="ex1">
        <div class="container">
<h1><center>Day-11</h1>
        <h1><center>🎯 Focus Mode</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<center><div id="countdown" style="font-size: 30px; font-weight: bold; color: black;">60:00</div>

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
        <h3><strong>WHY DOES THE MIND BECOME SO DISTURBED?</strong></h3>
        <img src="./image/focus.jpg" height="40%">
        <h2>
            1. Our brain is consuming lots and lots of information.<br>
            2. Our mind is not able to be in the present moment.<br>
            3. Our decision-making becomes heavily influenced by the information we consume.
        </h2>
        <div class="task">Today's Challenge: Stay focused and complete the tasks!</div>
       
        <div class="task-list">
            <h2>🎉 Fun Challenges:</h2>
            <ul id="taskList">
                <li onclick="startTaskTimer(this)">
                    <img src="./image/victory.jpg" alt="Victory Pose">
                    Act out a victory pose <span class="task-timer"></span>
                </li>
                <li onclick="startTaskTimer(this)">
                    <img src="./image/drawing.jpg" alt="Drawing">
                    Draw something happy <span class="task-timer"></span>
                </li>
                <li onclick="startTaskTimer(this)">
                    <img src="./image/read.jpg" alt="Reading">
                    Read a quote aloud <span class="task-timer"></span>
                </li>
                <li onclick="startTaskTimer(this">
                    <img src="./image/pose.jpg" alt="Power Pose">
                    Hold a power pose <span class="task-timer"></span>
                </li>
                <li onclick="startTaskTimer(this)">
                    <img src="./image/writing.jpg" alt="Writing">
                    Write a note to yourself <span class="task-timer"></span>
                </li>
            </ul>
        </div>

        <br><button class="button"  id="Button" onclick="showQuestion(); updateButtonStatus('button2')">Continue</button>
    <span id="button2_status"></span>
       
        <div id="questionSection">
            <h3>🧐 Question: How do you maintain focus in daily life?</h3>
            <textarea rows="4" cols="50" id="userAnswer" placeholder="Write your thoughts here..."></textarea>
        </div>
       
        <br><button class="button" id="submitButton" onclick="showGame()">Submit</button>
        <div id="focusGame" style="display:none;">
            <h2>🧠 Focus Game: Match the Cards!</h2>
            <p>Click the cards to reveal the words and match them:</p>
            <div id="gameBoard"></div>
           
            <button class="button" onclick="startGame(); updateButtonStatus('button1')">Start Game</button>
    <span id="button1_status"></span>


        </div>
       
        <br><button class="button" id="nextButton" onclick="stopTracking()"><a href="day12.php">Next</button>
    
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
    </div>

    <script>
        let activeTask = null;

        function startTaskTimer(task, seconds) {
            if (activeTask) {
                alert("Please complete the current task before starting a new one.");
                return;
            }
            activeTask = task;
            let span = task.querySelector(".task-timer");
            let countdown = seconds;
            let interval = setInterval(() => {
                if (countdown > 0) {
                    countdown--;
                    span.textContent = countdown + "s";
                } else {
                    clearInterval(interval);
                    task.classList.add("completed");
                    span.textContent = "✔ Done!";
                    checkAllTasksCompleted();
                    activeTask = null;
                }
            }, 1000);
        }

        function checkAllTasksCompleted() {
            const tasks = document.querySelectorAll(".task-list li");
            const allCompleted = [...tasks].every(task => task.classList.contains("completed"));
            if (allCompleted) {
                document.getElementById("Button").style.display = "block"; // Show continue button
            }
        }

        function showQuestion() {
            document.getElementById("questionSection").style.display = "block";
            document.getElementById("submitButton").style.display = "block";
            document.getElementById("Button").style.display = "none"; // Hide continue button after tasks
        }

        function showGame() {
            document.getElementById("focusGame").style.display = "block";
            document.getElementById("submitButton").style.display = "none"; // Hide submit button after question
        }

        let cardValues = ['Focus', 'Concentration', 'Memory', 'Strength', 'Focus', 'Concentration', 'Memory', 'Strength'];
        let flippedCards = [];
        let matchedCards = [];

        function startGame() {
            shuffledCards = shuffleArray([...cardValues]);
            renderGameBoard(shuffledCards);
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function renderGameBoard(cards) {
            let gameBoard = document.getElementById('gameBoard');
            gameBoard.innerHTML = ''; // Clear previous cards
            cards.forEach((cardValue, index) => {
                let cardElement = document.createElement('div');
                cardElement.classList.add('card');
                cardElement.setAttribute('data-index', index);
                cardElement.addEventListener('click', flipCard);
                gameBoard.appendChild(cardElement);
            });
        }

        function flipCard(event) {
            let cardElement = event.target;
            if (cardElement.classList.contains('flipped') || flippedCards.length === 2) {
                return; // Ignore if card is already flipped or if two cards are already flipped
            }
           
            let cardIndex = cardElement.getAttribute('data-index');
            cardElement.textContent = cardValues[cardIndex];
            cardElement.classList.add('flipped');
            flippedCards.push(cardElement);

            if (flippedCards.length === 2) {
                checkMatch();
            }
        }

        function checkMatch() {
            let [firstCard, secondCard] = flippedCards;
            let firstValue = firstCard.textContent;
            let secondValue = secondCard.textContent;

            if (firstValue === secondValue) {
                firstCard.classList.add('matched');
                secondCard.classList.add('matched');
                matchedCards.push(firstCard, secondCard);
                flippedCards = [];
                if (matchedCards.length === cardValues.length) {
                    alert('✅ Congratulations! You matched all the cards!');
                    document.getElementById("nextButton").style.display = "block"; // Show next button after game completion
                }
            } else {
                setTimeout(() => {
                    firstCard.classList.remove('flipped');
                    secondCard.classList.remove('flipped');
                    firstCard.textContent = '';
                    secondCard.textContent = '';
                    flippedCards = [];
                }, 1000);
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
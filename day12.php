
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
    <title>Day-12: Mindset and Therapy Games</title>
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
main {
            padding: 20px;
        }
        .activity-section {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
h2 {
            color: #333;
}
        .output-area {
            margin-top: 10px;
            text-align: center;
            font-size: 16px;
        }
        .puzzle-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px 0;
        }
        .option-button {
            margin: 5px;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 2px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .option-button:hover {
            background-color: #e0e0e0;
        }
        .option-button.selected {
            background-color: #4CAF50;
            color: white;
            border-color: #45a049;
        }
	.interactive-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .interactive-button:hover {
            background-color: #45a049;
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
<h1><center>Day-12</h1>
        <h1><center>Mindset Exploration and Therapy Games</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<main>
<center><div id="countdown" style="font-size: 30px; font-weight: bold; color:black;">60:00</div>

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

</script>


<!-- Mindset Exploration Section -->
<section>
    <h2>What is Mindset?</h2>
    <p>Mindset refers to the set of attitudes, beliefs, and perspectives that shape how we interpret and respond to the world around us. It influences our thoughts, emotions, and actions, guiding our approach to challenges and opportunities.</p>
</section>

<section class="activity-section">
    <h2>Activity</h2>
    <p>Spend an hour reflecting on your own mindset. Follow these steps:</p>
    <ul>
        <li>Write down your current beliefs about challenges and opportunities.</li>
        <li>Identify areas where you might have a fixed mindset and explore how you can shift towards a growth mindset.</li>
        <li>Create a plan to nurture positive and resilient mindsets in your daily life.</li>
        <li>Share your reflections with a friend or mentor for feedback.</li>
    </ul>
</section>

<!-- Mindset Challenge Section -->
<section class="activity-section">
    <h2>Mindset Challenge Game</h2>
    <p>Click the button below to start the challenge! You will receive a scenario where you need to choose between a fixed or growth mindset response.</p>

    <button class="button" onclick="startChallenge(); updateButtonStatus('button1')">Start Challenge</button>

    <span id="button1_status"></span>

    <div id="challenge-output" class="output-area"></div>
</section>

<!-- Enhanced Puzzle Game Section -->
<section class="activity-section">
    <h2>Mindset Puzzle Game</h2>
    <p>Solve these mindset-related puzzles to exercise your brain and reinforce positive thinking patterns:</p>

    <div id="puzzle-container">
        <div id="puzzle-question"></div>
        <div id="puzzle-options" class="puzzle-options"></div>
        <div id="puzzle-controls">

    <button class="button" onclick="checkPuzzleAnswer(); updateButtonStatus('button1')">Next Puzzle</button>
    
    <span id="button1_status"></span>
<button class="button" id="submit-button" onclick="submitPuzzle()" style="display:none;">Submit</button>

</div>

    </div>

    <div id="puzzle-output" class="output-area"></div>
    <div id="puzzle-score" class="output-area">Score: 0</div>
 <br><button class="button" id="n" onclick="stopTracking()"><a href="day13.php">Next</a></button>
       
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
</section>
</center>

</main>

<!-- JavaScript Code -->
<script>
// Mindset Challenge Logic
function startChallenge() {
    const challengeOutput = document.getElementById('challenge-output');
    const scenarios = [
        { scenario: "You failed an important exam.", response1: "I guess I'm just not good at this.", response2: "I can learn from my mistakes and try again!" },
        { scenario: "You didn't get the job you wanted.", response1: "I will never get hired.", response2: "This is an opportunity to improve my skills." },
        { scenario: "You received critical feedback on your project.", response1: "I can't handle criticism.", response2: "This feedback will help me grow." },
        { scenario: "You were asked to solve a problem that seems very challenging.", response1: "This is too hard for me. I’ll never figure it out.", response2: "This is a great opportunity to challenge myself and grow." }
    ];

    const randomScenario = scenarios[Math.floor(Math.random() * scenarios.length)];

    challengeOutput.innerHTML = `<strong>Scenario:</strong> ${randomScenario.scenario}<br><br>` +
                                `<strong>Your Responses:</strong><br>` +
                                `<button class="interactive-button" onclick="evaluateResponse('${randomScenario.response1}')">${randomScenario.response1}</button>` +
                                `<button class="interactive-button" onclick="evaluateResponse('${randomScenario.response2}')">${randomScenario.response2}</button>`;
}

function evaluateResponse(response) {
    const challengeOutput = document.getElementById('challenge-output');

    if (response.includes("learn") || response.includes("improve") || response.includes("grow")) {
        challengeOutput.innerHTML += "<br><strong>Your Response is Positive!</strong> This reflects a Growth Mindset!";
    } else {
        challengeOutput.innerHTML += "<br><strong>Your Response is Negative!</strong> This reflects a Fixed Mindset.";
    }
}

// Enhanced Puzzle Game Logic
let currentPuzzleIndex = 0;
let puzzleScore = 0;
const puzzles = [
  { question: "Rearrange the letters in 'GROWTH' to form another meaningful word related to mindset.", options: ["WORTH", "THROW", "GHOST", "ROUGH"], answer: "WORTH", hint:"This word relates to your self-value and importance." },
    { question:"Unscramble 'LERISECINE' to find a key mindset trait.", options:["RESILIENCE", "RELICENSE", "SINCERELE", "CLEANSIER"], answer:"RESILIENCE", hint:"The ability to bounce back from difficulties." },
    { question:"What word is hidden in this phrase:'Positively Optimistic Wonderful Experiences Result'?", options:["POWER", "PROWESS", "PROVE", "PORES"], answer:"POWER", hint:"Look at the first letter of each word." },
    { question:"Rearrange 'CHALLENGED' to find a word that means 'to have succeeded'.", options:["ACHIEVED", "CHANNELED", "LAUNCHED", "DECLARED"], answer:"ACHIEVED", hint:"When you've accomplished your goals." },
    { question:"What mindset-related word can be formed from the letters of 'IMPOVERISHED' by removing certain letters?", options:["IMPROVED", "PROVED", "EMPOWERED", "DISCOVERED"], answer:"IMPROVED", hint:"To have made something better." }
];

function initPuzzleGame() {
    currentPuzzleIndex = 0;
    puzzleScore = 0;
    displayPuzzle(currentPuzzleIndex);
}

function displayPuzzle(index) {
   const puzzleQuestion = document.getElementById('puzzle-question');
   const puzzleOptions = document.getElementById('puzzle-options');
   const puzzleOutput = document.getElementById('puzzle-output');

   if (index < puzzles.length) {
       const currentPuzzle = puzzles[index];

       puzzleQuestion.innerHTML = `<p><strong>Puzzle ${index + 1}/${puzzles.length}:</strong> ${currentPuzzle.question}</p>`;
       puzzleOptions.innerHTML = '';
       currentPuzzle.options.forEach(option => {
           const button = document.createElement('button');
           button.className = 'option-button';
           button.textContent = option;
           button.onclick = function() { selectOption(this); };
           puzzleOptions.appendChild(button);
       });

       puzzleOutput.textContent = '';
   } else {
       // All puzzles completed
       puzzleQuestion.innerHTML = `<p><strong>All puzzles completed!</strong></p>`;
       puzzleOptions.innerHTML = '';
       puzzleOutput.textContent = `Final Score:${puzzleScore} out of ${puzzles.length}`;
   }
}

function selectOption(button) {
   // Remove any previously selected options
   const options = document.querySelectorAll('.option-button');
   options.forEach(opt => { opt.classList.remove('selected'); });

   // Mark the clicked option as selected
   button.classList.add('selected');
}

function checkPuzzleAnswer() {
    const selectedOption = document.querySelector('.option-button.selected');
    const puzzleOutput = document.getElementById('puzzle-output');

    if (!selectedOption) {
        puzzleOutput.textContent = "Please select an answer first!";
        return;
    }

    const userAnswer = selectedOption.textContent;
    const correctAnswer = puzzles[currentPuzzleIndex].answer;

    if (userAnswer === correctAnswer) {
        puzzleScore++;
        puzzleOutput.innerHTML = `<span style='color:red;'>Correct! Great job!</span>`;
    } else {
        puzzleOutput.innerHTML = `<span style='color:red;'>Incorrect. Hint: ${puzzles[currentPuzzleIndex].hint}</span>`;
    }

    // Delay before moving to the next puzzle
   setTimeout(() => {
    currentPuzzleIndex++;
    if (currentPuzzleIndex < puzzles.length) {
        displayPuzzle(currentPuzzleIndex);
    } else {
        // Hide Next button and show Submit button
        document.querySelector('#puzzle-controls button').style.display = 'none';
        document.getElementById('submit-button').style.display = 'inline-block';
        puzzleOutput.innerHTML += `<br><strong>Click Submit to see your final score!</strong>`;
    }
    document.getElementById('puzzle-score').textContent = `Score: ${puzzleScore}`;
}, 1000);
 // 1 second delay before next puzzle
}
function submitPuzzle() {
    const puzzleOutput = document.getElementById('puzzle-output');
    puzzleOutput.innerHTML = `<strong>Your Final Score is ${puzzleScore} out of ${puzzles.length}.</strong><br>Well done! Keep nurturing that growth mindset!`;
    document.getElementById('submit-button').style.display = 'none';
}


// Initialize the puzzle game when the page loads
window.addEventListener('load', initPuzzleGame);
</script>
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
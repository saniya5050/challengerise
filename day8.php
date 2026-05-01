
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
    <title>Day-8: Healthy Food Fun</title>
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

header {
            background-color: #2f855a;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }
h2 {
            color: #2f855a;
        }
.step {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .choices li {
            background-color: #3498db;
            color: white;
            padding: 15px;
            margin: 5px 0;
            list-style: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
            text-align: center;
        }
        .choices li:hover {
            background-color: #2980b9;
        }
       
        #result {
            display: none;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
.correct {
    background-color: #4caf50;
    color: white;
}

.wrong {
    background-color: #f44336;
    color: white;
}

.button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
 .correct {
            background-color: #2ecc71 !important;
        }
        .wrong {
            background-color: #e74c3c !important;
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
<h1><center>Day-8</h1>
        <h1><center>Healthy Living Hub 🍎</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<center><div id="countdown" style="font-size: 30px; font-weight: bold; color: black;"></div><center>

<!-- Food Information Section -->
    <section>
        <center><h2>The Power of Healthy Eating</h2>
        <p>Eating healthy fuels our bodies, sharpens our minds, and keeps us energized for life’s adventures!</p>
        <b>HOW DO YOU FEEL WHEN YOU EAT A HEAVY MEAL?</b><br><br>
        We feel dull and heavy. When we eat, our battery starts getting discharged.
        Junk food rapidly discharges our battery, even while sleeping. Our body is unable to charge up properly as it's busy digesting the heavy food.
        Insufficient sleep leads to feelings of laziness and procrastination.<br><br>
        <b>FOODS THAT DESTROY OUR SLEEP QUALITY</b><br><br>
        <img src="./image/foodchart.jpg" alt="Food Chart" width="60%" height="40%">
    </section>

    <!-- Virtual Cooking Class -->
   <section>
  <br><h2>Virtual Cooking Class: Classic Spaghetti Aglio e Olio</h2>

  <h3>Ingredients:</h3>
  <ul>
    <li>200g Spaghetti</li>
    <li>4 Garlic Cloves (sliced thinly)</li>
    <li>1/4 Cup Olive Oil</li>
    <li>1/2 Tsp Red Pepper Flakes</li>
    <li>Salt (to taste)</li>
    <li>Fresh Parsley (chopped)</li>
    <li>Grated Parmesan (optional)</li>
  </ul>

  <h3>Instructions:</h3>
  <div id="step1" class="step" onclick="showNextStep(1)">
    <p><strong>Step 1:</strong> Boil a pot of salted water and cook the spaghetti according to the package instructions.</p>
  </div>
  <div id="step2" class="step" onclick="showNextStep(2)" style="display:none;">
    <p><strong>Step 2:</strong> Heat olive oil in a pan over medium heat. Add the garlic slices and cook until golden brown.</p>
  </div>
  <div id="step3" class="step" onclick="showNextStep(3)" style="display:none;">
    <p><strong>Step 3:</strong> Add red pepper flakes to the pan and cook for another 30 seconds.</p>
  </div>
  <div id="step4" class="step" onclick="showNextStep(4)" style="display:none;">
    <p><strong>Step 4:</strong> Drain the pasta and add it directly to the pan. Toss to coat.</p>
  </div>
  <div id="step5" class="step" onclick="showNextStep(5)" style="display:none;">
    <p><strong>Step 5:</strong> Add salt to taste and chopped parsley. Serve hot, and top with Parmesan cheese if desired.</p>
  </div>

  <!-- Finish Button always shown -->
  <button id="finishBtn" class="button" onclick="finish()">Finish Recipe</button>

</section>

    <!-- Food and Nutrition Quiz -->
   <section id="quiz-container">
  <br><h2>Food and Nutrition Quiz Game</h2>
  <div id="quiz-content">
    <h2 id="question-text"></h2>
    <ul id="choices" class="choices"></ul>

   
</div>

<div id="result" style="display: none;">
    <h2>Quiz Completed!</h2>
    <p>You scored <span id="score"></span> out of <span id="total"></span>.</p>
    <button class="button" onclick="restartQuiz()">Restart Quiz</button>
</div>

<p> After completing the quiz click on submit button</p>
   <button class="button"  onclick="updateButtonStatus('button1')">Submit</button>
    <span id="button1_status"></span>

<br>
<br>
</main><br>

<button class="button" id="n" onclick="stopTracking()"><a href="day9.php">Next</a></button>
       
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
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
     function showNextStep(step) {
    // Hide current step
    document.getElementById('step' + step).style.display = 'none';

    if (step < 5) {
      // Show next step
      document.getElementById('step' + (step + 1)).style.display = 'block';
    } else {
      // Restart from Step 1
      for (let i = 2; i <= 5; i++) {
        document.getElementById('step' + i).style.display = 'none';
      }
      document.getElementById('step1').style.display = 'block';
    }
  }
function finish()
{
alert("yeah..you learnt new receipe");
}

  const questions = [
    { question: "Which vitamin is found in citrus fruits?", choices: ["A", "C", "D", "E"], answer: "C" },
    { question: "What is a healthy fat?", choices: ["Butter", "Olive oil", "Lard", "Sugar"], answer: "Olive oil" },
    { question: "Which mineral is essential for bone health?", choices: ["Calcium", "Iron", "Potassium", "Zinc"], answer: "Calcium" },
    { question: "What is a common source of Omega-3?", choices: ["Salmon", "Banana", "Tomato", "Cheese"], answer: "Salmon" },
    { question: "Which food contains natural sugar?", choices: ["Honey", "Bread", "Salt", "Oil"], answer: "Honey" }
  ];

  let currentQuestionIndex = 0;
  let score = 0;

  function loadQuestion() {
    const q = questions[currentQuestionIndex];
    document.getElementById("question-text").textContent = q.question;
    const choices = document.getElementById("choices");
    choices.innerHTML = "";

    q.choices.forEach(choice => {
      const li = document.createElement("li");
      li.textContent = choice;
      li.onclick = () => selectAnswer(li, choice);
      choices.appendChild(li);
    });
  }

  function selectAnswer(selectedLi, choice) {
    const correct = questions[currentQuestionIndex].answer;
    const choices = document.querySelectorAll(".choices li");

    choices.forEach(li => li.style.pointerEvents = "none");

    if (choice === correct) {
      selectedLi.classList.add("correct");
      score++;
    } else {
      selectedLi.classList.add("wrong");
    }

    setTimeout(() => {
      currentQuestionIndex++;
      if (currentQuestionIndex < questions.length) {
        loadQuestion();
      } else {
        showResult();
      }
    }, 800);
  }

  function showResult() {
    document.getElementById("quiz-content").style.display = "none";
    document.getElementById("result").style.display = "block";
    document.getElementById("score").textContent = score;
    document.getElementById("total").textContent = questions.length;
  }

  function restartQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    document.getElementById("quiz-content").style.display = "block";
    document.getElementById("result").style.display = "none";
    loadQuestion();
  }

  // Start quiz on page load
  loadQuestion();
</script>

    </div></center>

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
</script>s
</body>
</html>
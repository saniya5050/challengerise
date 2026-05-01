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
    <title>Day-7: Reading Challenge</title>
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
.reading-option {
            display: inline-block;
            width: 250px;
            padding: 20px;
            margin: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .reading-option:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0,0,0,0.5);
        }
        .hidden { display: none; }
        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .book-card {
            width: 200px;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
        }
        .book-card:hover {
            transform: scale(1.1);
        }
        .book-card img {
            width: 100%;
            border-radius: 5px;
        }
.task-completed
{
text-align:center;
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
<h1><center>Day-7</h1>
        <h1><center>📚 Reading Challenge 📚</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2><center><p>Choose an activity and complete different levels to become a Reading Master!</p>
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
    <div id="readingContainer">
        <div class="reading-option" data-activity="Read a Book">📖 Level 1: Read a Book</div>
        <div class="reading-option" data-activity="Read an Article">📰 Level 2: Read an Article</div>
       
<br><br>
Tell us about your favourite book and tell us the story behind it
<br>
<textarea row="80" cols="60"></textarea>
<br><br>
What's your aim, where did you get this knowledge of life ?
<br>
<textarea row="80" cols="60"></textarea>
<br><br>
 
 <button type="button" id="n" onclick="stopTracking()" class="button"><a href="day8.php">Next</a></button>
        
   <center> <p id="countdown_timer"></p></center>
    
  
    <p id="tracking_timer"></p>
 
   
   
   
    </div>
   
    <div id="bookSection" class="hidden">
        <h2>📖 Choose any one  Book to Read</h2>
        <div class="book-container">
            <div class="book-card" onclick="openBook('./image/5am.pdf')">
                <img src="./image/robin.jpg" alt="The 5 AM Club">
                <p>The 5 AM Club - Robin Sharma</p>
            </div>
            <div class="book-card" onclick="openBook('./image/RichDad.pdf')">
                <img src="./image/rich.jpg" alt="Rich Dad Poor Dad">
                <p>Rich Dad Poor Dad - Robert Kiyosaki</p>
            </div>
            <div class="book-card" onclick="openBook('./image/atomic.pdf')">
                <img src="./image/atomic.jpg" alt="Atomic Habits">
                <p>Atomic Habits - James Clear</p>
            </div>
        </div>
<br><br>
      <button class="button" id="bookBackButton" onclick="goBackFromBook()" type="button" id="startYoga" onclick="updateButtonStatus('button1')" disabled>&nbsp;Back&nbsp;</button>
    
    <span id="button1_status"></span>
    </div>

    <div id="articleSection" class="hidden">
        <h2>📰 Choose any one  Article to Read</h2>
        <div class="book-container">
            <div class="book-card" onclick="openArticle('https://medium.com/personal-growth-lab/the-unexpected-power-of-a-morning-routine-mindmasters-79b10f7c800')">
                <img src="./image/article1.jpg" alt="Morning Routine">
                <p>Power of Morning Routine</p>
            </div>
            <div class="book-card" onclick="openArticle('https://www.healthline.com/nutrition/mindful-eating-guide')">
                <img src="./image/article2.jpg" alt="Mindful Eating">
                <p>Mindful Eating Habits</p>
            </div>
            <div class="book-card" onclick="openArticle('https://www.simplilearn.com/best-productivity-hacks-to-get-more-done-article')">
                <img src="./image/article3.jpg" alt="Productivity Hacks">
                <p>Top 10 Productivity Hacks</p>
            </div>
        </div>
<br><br>
<button id="articleBackButton" onclick="goBackFromArticle()" disabled>&nbsp;Back&nbsp;</button>
</div>


  <script>
    let bookSelected = false;
    let articleSelected = false;

    function openBook(bookUrl) {
        bookSelected = true;
        window.open(bookUrl, '_blank');
        document.getElementById("bookBackButton").disabled = false; // Enable Book Section Back Button
    }

    function openArticle(articleUrl) {
        articleSelected = true;
        window.open(articleUrl, '_blank');
        document.getElementById("articleBackButton").disabled = false; // Enable Article Section Back Button
    }

    document.querySelector("[data-activity='Read a Book']").addEventListener("click", function() {
        document.getElementById("readingContainer").classList.add("hidden");
        document.getElementById("bookSection").classList.remove("hidden");
    });

    document.querySelector("[data-activity='Read an Article']").addEventListener("click", function() {
        if (bookSelected) {  // Allow article selection only after a book is selected
            document.getElementById("readingContainer").classList.add("hidden");
            document.getElementById("articleSection").classList.remove("hidden");
        } else {
            alert("Please read a book first before selecting an article.");
        }
    });

    function goBackFromBook() {
        if (bookSelected) {
            document.getElementById("bookSection").classList.add("hidden");
            document.getElementById("readingContainer").classList.remove("hidden");
        }
    }

    function goBackFromArticle() {
        if (articleSelected) {
            document.getElementById("articleSection").classList.add("hidden");
            document.getElementById("readingContainer").classList.remove("hidden");
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
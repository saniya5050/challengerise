
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "progress1";

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
    <title>Day-10: 5 elements or Panchmahabhutas🙏</title>
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
	.element-section
{
            margin: 20px 0;
        }
        .element-section strong
{
            display: block;
            margin-bottom: 10px;
            font-size: 20px;
        }
        textarea
{
            width: 100%;
            max-width: 600px;
            height: 30px;
            margin-top: 5px;
        }
        img {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
        }
	@media (max-width: 768px)
{
	.element-section strong
{
                font-size: 18px;
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
<h1><center>Day-10</h1>
        <h1><center>5 elements or Panchmahabhutas🙏</h1>
        <br><h2 class="prayer"><font size="5"><center>"PRAYER"</font><br><br><center>Thank you God for bringing us together in this beautiful purpose. Please give us your blessings so that we all can complete this challenge gracefully. I know I can and I will. I believe in myself. Thank you God.</center></h2>
<center><p class="highlight">HOW TO CREATE YOUR OWN HEALTHY NIGHT RITUALS?</p>
    <p>As per our Indian philosophy and scriptures, our body is made up of 5 elements: water, earth, fire, air, and space (Panchmahabhutas). Connecting with these elements daily can bring balance to our lives.</p>

    <div id="countdown" style="font-size: 30px; font-weight: bold; color: black;"></div>

    <!-- Water -->
    <div class="element-section">
      <strong>WATER ELEMENT 💧</strong>
      <p>Take a shower 30 minutes before sleep</p>
      <p>Hot foot bath for 20 minutes</p>
      <img src="./image/bath.jpg" alt="Water Element Practice" class="element-img">
      
    </div>

    <!-- Air -->
    <div class="element-section">
      <strong>AIR ELEMENT 🌬️</strong>
      <p>Pranayam or breathing exercise for 20 minutes</p>
      <p>Wear loose, light cotton clothes</p>
      <img src="./image/unnamed.jpg" alt="Air Element Practice" class="element-img">
      
    </div>

    <!-- Fire -->
    <div class="element-section">
      <strong>FIRE ELEMENT 🔥</strong>
      <p>Tratak kriya for 20 minutes</p>
      <p>Light a diya or candle</p>
      <img src="./image/trataka_kriya.jpg" alt="Fire Element Practice" class="element-img">
    </div>
<button class="button" onclick="revealFinalTasks(); updateButtonStatus('button1') ">Continue</button>

    <span id="button1_status"></span>

  <!-- Surprise Message -->
<div id="surprise-message" style="display: none; background-color: #ffe4e1; padding: 20px; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.2); margin: 30px 0;">
  <h2 style="color: #b22222;">🎊 You're on Fire! 🔥</h2>
  <p style="font-size: 18px; color: #4b1e0c;">You’ve completed 3 powerful elements. Let’s keep this momentum going! 🌟</p>
</div>

<!-- Hidden Final Tasks -->
<div id="final-tasks" style="display: none;">
  <!-- Earth -->
  <div class="element-section">
    <strong>EARTH ELEMENT 🌍</strong>
    <p>Walk barefoot on soil/grass</p>
    <p>Hug a tree</p>
    <img src="./image/grass.jpg" alt="Earth Element Practice" class="element-img">
  </div>

  <!-- Space -->
  <div class="element-section">
    <strong>SPACE ELEMENT 🌌</strong>
    <p>Clean and organize your bedroom</p>
    <p>Have an early dinner</p>
    <img src="./image/room.jpg" alt="Space Element Practice" class="element-img">
  </div>

 
    <p>"You will not find happiness when you achieve your dreams. You will achieve your dreams when you find happiness."</p>


     <button class="button"  onclick="updateButtonStatus('button2')">Done</button>
    <span id="button2_status"></span>
<br><br>
 
       <button class="button" id="n" onclick="stopTracking()"><a href="day11.php">Next</a></button>
       
    <p id="countdown_timer"></p>
   
    <h2></h2>
    <p id="tracking_timer"></p>
 
  </div>

  <script>
    let timeElapsed = 0;
    let targetTime = 3600;

    function updateCountdown() {
      let minutes = Math.floor(timeElapsed / 60);
      let seconds = timeElapsed % 60;
      document.getElementById("countdown").textContent =
        `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

      if (timeElapsed >= targetTime) {
        document.body.innerHTML = "<h1 style='font-size: 40px; color: darkred;'>Time's Up</h1>";
      } else {
        timeElapsed++;
        setTimeout(updateCountdown, 1000);
      }
    }

    updateCountdown();
function submit()
{
alert("Congratulations..!you have done the all task..!");
}
function revealFinalTasks() {
  document.getElementById("surprise-message").style.display = "block";

  setTimeout(() => {
    document.getElementById("final-tasks").style.display = "block";
    window.scrollTo({
      top: document.getElementById("final-tasks").offsetTop,
      behavior: "smooth"
    });
  }, 1000); // show final tasks after 1 seconds
}

  </script>

</script>

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
</div>
</div><!-- Footer -->
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracker</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let startTime = new Date().getTime();
        let timerInterval;

        function startTimer(duration) {
            let display = document.getElementById("timer");
            let endTime = new Date().getTime() + duration * 1000;

            timerInterval = setInterval(() => {
                let now = new Date().getTime();
                let remaining = Math.max(0, Math.floor((endTime - now) / 1000));
                let minutes = Math.floor(remaining / 60);
                let seconds = remaining % 60;
                display.textContent = minutes + "m " + seconds + "s";

                if (remaining === 0) {
                    clearInterval(timerInterval);
                }
            }, 1000);
        }

        function sendData(buttonName) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("button_name=" + buttonName);
        }

        function submitCompletion() {
            let elapsedTime = Math.floor((new Date().getTime() - startTime) / 1000);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("time_taken=" + elapsedTime");
            clearInterval(timerInterval);
            setTimeout(() => location.reload(), 500);
        }

        function loadChart() {
            let ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Button 1", "Button 2", "Completion Time"],
                    datasets: [{
                        label: "Clicks & Time",
                        data: [<?= $button1_count ?>, <?= $button2_count ?>, <?= $latest_time_taken ?>],
                        backgroundColor: ["red", "blue", "green"]
                    }]
                }
            });
        }

        window.onload = function () {
            startTimer(3600);
            loadChart();
        };
    </script>
</head>
<body>
    <h1>Progress Tracker</h1>
    <p>Time Left: <span id="timer">60m 0s</span></p>
    <button onclick="sendData('Button1')">Button 1</button>
    <button onclick="sendData('Button2')">Button 2</button>
    <button onclick="submitCompletion()">Submit Completion</button>
   
    <canvas id="progressChart" width="400" height="200"></canvas>
</body>
</html>

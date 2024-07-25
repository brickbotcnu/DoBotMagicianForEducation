<?php
// Conectarea la baza de date
$conn = new mysqli("localhost", "pavel", "DoBot2024!", "putereabratului");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obține adresa IP a utilizatorului
$ip_address = $_SERVER['REMOTE_ADDR'];

// Verifică dacă utilizatorul este primul în coadă
$check_query = "SELECT * FROM Waiting ORDER BY id ASC LIMIT 1";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['ip_address'] == $ip_address) {
        echo "You have access to the main interface";
        header("location:DoBotControlPanel.php");
    } else {
        echo '<script>"alert(Please wait your turn)"</script>';
    }
} else {
    echo "Queue is empty";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
<title>Waiting Room</title>
        <style>
     body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #252525;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h2 {
            color: #66ccff;
            border-bottom: 2px solid #66ccff;
            padding-bottom: 10px;
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #66ccff;
            text-align: left;
        }
        </style>
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function checkQueue() {
            fetch('queue.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('queue_status').innerText = data;
                });
        }

        setInterval(checkQueue, 5000); // Verifică la fiecare 5 secunde
    </script>
<body onload="checkQueue()">
    <h1>Camera de asteptare</h1>
</body>
</html>


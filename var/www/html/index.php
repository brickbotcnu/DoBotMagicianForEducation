<?php
$mysqli = new mysqli("localhost","pavel","DoBot2024!","putereabratului");

if($mysqli->connect_errno){
echo " Eroare la conectarea in baza de date: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->query("SET NAMES 'utf8'");
session_start();
if (isset($_POST["username"])){
//print_r($_POST);
           $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
           $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
           $query = "SELECT * FROM Inregistrari WHERE username = '$username'";
           $result = mysqli_query($mysqli, $query);
           if(mysqli_num_rows($result) > 0)
           {
                while($row = mysqli_fetch_array($result))
                {
                     if(password_verify($password, $row["password"]))
                     {
                          //return true;
                          $_SESSION['uid']=$row['uid'];
                          $_SESSION['username'] = $username;
                          $_SESSION['fullname'] = $row['fullname'];
                          header("location:DoBotControlPanel.php");
                     }
                     else
                     {
                          //return false;
                          echo '<script>alert("Combinatie user/parola gresita!1")</script>';
                     }
                }           }
           else
           {
                echo '<script>alert("User inexistent!")</script>';
           }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Autentificare</title>
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

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #666666;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #1e1e1e;
            color: #fff;
        }

        input[type="button"] {
            background-color: #252525;
            color: #66ccff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"] {
            background-color: #4da6ff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #66ccff;
        }
        input[type="button"]:hover {
            background-color: #66ccff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Bine ai revenit!</h2>
    <form action="index.php" method="post">
        <label for="username">Nume Utilizator:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Logare">
    </form>
    <input type="button" value="N-ai cont? | Înregistrează-te" onclick="location.href='inregistrari.html'">
</div>
</body>
</html>


<?php
$servername = "localhost";
$username = "pavel";
$password = "DoBot2024!";
$dbname = "putereabratului";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}

function user_existent($mysqli,$user){
        $sql_user="SELECT username FROM Inregistrari WHERE username='".$user."'";
        $res=mysqli_query($mysqli, $sql_user);
        if (mysqli_num_rows($res)>=1){
                return true;
        }else{
                return false;
        }
}
// Preia datele din formular
$user = mysqli_real_escape_string($conn,$_POST['username']);
$pass = mysqli_real_escape_string($conn,$_POST['password']);

if (preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/', $user)){

  if (!user_existent($conn, $user)){

        // Criptare parolă (opțional)
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Inserare date în baza de date
        $sql = "INSERT INTO Inregistrari (username, password) VALUES ('$user', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Înregistrarea a fost realizată cu succes!")</script>';
            header("location:index.php");
        } else {
            echo "Eroare: " . $sql . "<br>" . $conn->error;
        }
   } else{
        echo '<script>alert("Userul deja exista in baza de date")</script>';
  }
   }else{
        echo '<script>alert("Username trebuie sa contina doar caractere sau cifre, fara spatii sau caractere speciale")</script> ';
}
// Închidere conexiune
$conn->close();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare</title> <style>
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
            text-align: center; /* Centrare elemente inline */
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
            text-align: left; /* Aliniere la stânga */
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
        input[type="button"]:hover {
            background-color: #66ccff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Bine ai venit!</h2>
    <form action="inregistrari.php" method="post">
        <label for="username">Nume Utilizator:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password" required>
        <label for="password">Confirmare Parolă:</label>
        <input type="password" id="password1" name="password1" required><br>
        <input type="submit" value="Înregistrează-te">
    </form>
        <input type="button" value="Ai deja cont? | Loghează-te" onclick="location.href='index.php'">
</div>
</body>
</html>

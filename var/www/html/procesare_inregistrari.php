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
	    echo "Înregistrarea a fost realizată cu succes!";
	} else {
	    echo "Eroare: " . $sql . "<br>" . $conn->error;
	}
   } else{
	echo "Userul deja exista in baza de date";
  }
}else{
	echo "Username trebuie sa contina doar caractere sau cifre, fara spatii sau caractere speciale ";
}
// Închidere conexiune
$conn->close();
?>



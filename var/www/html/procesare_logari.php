<?php
// Configurarea bazei de date
$svname = 'localhost'; // Numele serverului MySQL
$dbname = 'putereabratului'; // Numele bazei de date
$dbusername ='pavel'; // Numele utilizatorului MySQL
$dbpassword = 'DoBotMagician2024!'; // Parola utilizatorului MySQL

$dsn = "mysql:host=$svname;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Conectarea la baza de date a eșuat: ' . $e->getMessage());
}
<?php
// Configurarea bazei de date
$svname = 'localhost'; // Numele serverului MySQL
$dbname = 'database_name'; // Numele bazei de date
$dbusername = 'database_username'; // Numele utilizatorului MySQL
$dbpassword = 'database_password'; // Parola utilizatorului MySQL

$dsn = "mysql:host=$svname;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Conectarea la baza de date a eșuat: ' . $e->getMessage());
}

// Preluarea datelor de logare din formular
$loginUsername = $_POST['username'];
$loginPassword = $_POST['password'];

// Pregătirea și executarea interogării SQL
$sql = 'SELECT password FROM users WHERE username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $loginUsername);
$stmt->execute();

// Verificarea rezultatelor
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verificarea parolei
    if (password_verify($loginPassword, $user['password'])) {
        // Autentificare reușită, redirecționează utilizatorul
        header('Location: http://192.168.0.203/DoBotControlPanel.php');
        exit(); // Asigură-te că scriptul se oprește după redirecționare
    } else {
        echo 'Parolă incorectă!';
    }
} else {
    echo 'Username incorect!';
}
?>

// Preluarea datelor de logare din formular
$loginUsername = $_POST['username'];
$loginPassword = $_POST['password'];

// Pregătirea și executarea interogării SQL
$sql = 'SELECT password FROM users WHERE username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $loginUsername);
$stmt->execute();

// Verificarea rezultatelor
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verificarea parolei
    if (password_verify($loginPassword, $user['password'])) {
        echo 'Autentificare reușită!';
    } else {
        echo 'Parolă incorectă!';
    }
} else {
    echo 'Username incorect!';
}
?>

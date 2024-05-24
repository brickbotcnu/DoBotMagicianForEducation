<?php

if(isset($_POST['reset'])) {
    // Redirect to Python script 1
    exec("python3 homing.py");
//    exit();
} elseif(isset($_POST['trimite'])) {
    if (isset($_POST['x'])&isset($_POST['y')&&isset($_POST['z')&&isset($_POST['r'])&&isset($_POST['s'])){
    $x=$_POST['x'];
    $y=$_POST['y'];
    $z=$_POST['z'];
    $r=$_POST['r'];
    $s=$_POST['s'];
    exec("python3 DoBot.py -x $x -y $y -z $z -r $r -s $s");
    }
    exit();
} else {
    // Handle unexpected cases
    echo "Error: Invalid button clicked!";
}

print_r($_POST);
?>


<?php
session_start();

// Shembull përdoruesi statik (në praktikë përdor databazë)
$perdoruesi = "eko_user";
$fjalekalimi = "eko123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $perdoruesi && $password === $fjalekalimi) {
        $_SESSION["username"] = $username;
        header("Location: homepage.php");
        exit();
    } else {
        echo "Të dhënat janë të pasakta!";
    }
}
?>

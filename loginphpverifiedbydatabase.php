<?php
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=ekologji", "root", "");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM perdoruesit WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["username"] = $username;
        header("Location: homepage.php");
        exit();
    } else {
        echo "Përdoruesi ose fjalëkalimi është gabim!";
    }
}
?>

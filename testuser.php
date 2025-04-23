<?php
// run this once to insert a test user
$pdo = new PDO("mysql:host=localhost;dbname=ekologji", "root", "");
$username = "eko_user";
$password = password_hash("eko123", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO perdoruesit (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Përdoruesi u shtua me sukses!";
?>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Homepage - Programi Ekologjik</title>
</head>
<body>
  <h1>Mirë se erdhe, <?php echo $_SESSION["username"]; ?>!</h1>
  <p>Kjo është faqja kryesore e programit ekologjik.</p>
</body>
</html>

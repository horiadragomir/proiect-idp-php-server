<?php

// Initialize the session
if(!isset($_SESSION)) {
    session_start(); 
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin_adm"]) || $_SESSION["loggedin_adm"] !== true){
    header("location: login.php");
    exit;
}

?>

<?php include "templates/header.php"; ?>

<div><a href="logout.php">Iesire</a></div>

<body>
    <h2>Gestionarea calatoriilor</h2>
</body>

<ul>
  <li>
    <a href="view.php"><strong>Cauta calatorii</strong></a>
  </li>
</ul>

<ul>
  <li>
    <a href="add.php"><strong>Adauga o calatorie</strong></a>
  </li>
</ul>

<ul>
  <li>
    <a href="cancel.php"><strong>Anuleaza o calatorie</strong></a>
  </li>
</ul>

<?php include "templates/footer.php"; ?>

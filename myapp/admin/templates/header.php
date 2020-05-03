<?php
  if(!isset($_SESSION)) {
    session_start(); 
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Mersul Trenurilor - Admin</title>

    <link rel="stylesheet" href="../../css/style.css">
  </head>

  <body>
    <h1>Mersul Trenurilor - Admin</h1>
  </body>

<?php
  if(isset($_SESSION["loggedin_adm"]) && $_SESSION["loggedin_adm"] == true) {
    echo "Administrator: " . $_SESSION["lastname_adm"] . " " . $_SESSION["firstname_adm"];
  }
?>

</html>

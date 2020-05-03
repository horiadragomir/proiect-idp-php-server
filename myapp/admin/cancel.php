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

<?php

if (isset($_POST["cancel"])) {
	$url = 'http://admin-server:20001/trips/' . $_POST["id"];
	
	$options = array(
		'http' => array(
		    'header'  => "Content-type: application/json\r\n",
		    'method'  => 'DELETE'
		)
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	echo '> ' . nl2br(json_decode($result)->status);
}
?>

<?php require "templates/header.php"; ?>

	<h2>Anuleaza o calatorie</h2>

	<form method="post">
		<p>
		ID Tren: <input type="text" name="id" required>
		</p>

		<p>
    	<input type="submit" name="cancel" value="Anuleaza">
		</p>
    </form>

    <a href="home.php">Inapoi</a>

<?php require "templates/footer.php"; ?>

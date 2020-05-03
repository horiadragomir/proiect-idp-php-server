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

if (isset($_POST["add"])) {
	$url = 'http://admin-server:20001/trips';
	$data = array('id' => $_POST["id"],
					'src' => $_POST["src"],
					'dst' => $_POST["dst"],
					'hour' => $_POST["hour"],
					'day' => $_POST["day"],
					'trip_time' => $_POST["trip_time"],
					'total_seats' => $_POST["total_seats"]);
	
	$options = array(
		'http' => array(
		    'header'  => "Content-type: application/json\r\n",
		    'method'  => 'POST',
		    'content' => json_encode($data)
		)
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);

	echo '> ' . nl2br(json_decode($result)->status);
}
?>

<?php require "templates/header.php"; ?>

	<h2>Adauga o calatorie</h2>

	<form method="post">
		<p>
		ID Tren: <input type="text" name="id" required>
		</p>

		<p>
		Statie Plecare: <input type="text" name="src" required>
		</p>

		<p>
		Statie Sosire: <input type="text" name="dst" required>
		</p>

		<p>
		Ora Plecarii (0 - 23): <input type="number" name="hour" min="0" max="23" required>
		</p>

		<p>
		Ziua Plecarii (1 - 365): <input type="number" name="day" min="1" max="365" required>
		</p>

		<p>
		Durata Calatoriei (Ore): <input type="number" name="trip_time" min="1" required>
		</p>

		<p>
		Numar Total de Locuri: <input type="number" name="total_seats" min="1" required>
		</p>

		<p>
    	<input type="submit" name="add" value="Adauga">
		</p>
    </form>

    <a href="home.php">Inapoi</a>

<?php require "templates/footer.php"; ?>

<?php

if (isset($_POST["buy"])) {
	$url = 'http://client-server:20000/buy?';
	
	$data = array('booking_id' => $_POST["id"],
								'credit_card_info' => $_POST["card"]);

	$response = file_get_contents($url . http_build_query($data));

	$result = json_decode($response)->status;

	echo '> ' . nl2br($result);
}
?>

<?php require "templates/header.php"; ?>

	<h2>Achita biletele rezervate</h2>

	<form method="post">
		<p>
		ID Rezervare: <input type="text" name="id" required>
		</p>

		<p>
		Card Bancar: <input type="text" name="card" required>
		</p>

		<p>
    	<input type="submit" name="buy" value="Achita">
		</p>
    </form>

    <a href="home.php">Inapoi</a>

<?php require "templates/footer.php"; ?>

<?php

if (isset($_POST["search"])) {
	$url = 'http://client-server:20000/route?';
	$data = array('src' => $_POST["src"],
					'dst' => $_POST["dst"],
					'max_trains' => $_POST["max_trains"],
					'departure_day' => $_POST["departure_day"]);

	$response = file_get_contents($url . http_build_query($data));

	$result = json_decode($response)->status;

	$trains = count($result);
	$ora = " ora.";
	$ore = " ore.";

	for ($i = 0; $i < $trains; ++$i) {
		$ora_this = $ore;
		if ($result[$i][5] == "1") {
			$ora_this = $ora;
		}

		$message = "> " . ($i + 1) . ": Trenul " . $result[$i][0] .
					", de la " . $result[$i][1] . " la " . $result[$i][2] .
					", pleaca la ora " . $result[$i][3] .
					", ziua " . $result[$i][4] .
					", iar calatoria va dura " . $result[$i][5] . $ora_this;

		echo $message;
		echo "<br>";
	}

	if ($trains == 0) {
		echo "> " . "Nu exista nicio ruta intre " . $_POST["src"] . " si " . $_POST["dst"] . " cu aceste optiuni.";
		echo "<br>";	
	}

}
?>

<?php require "templates/header.php"; ?>

	<h2>Gaseste ruta optima intre doua orase</h2>

	<form method="post">
		<p>
		Statie Plecare: <input type="text" name="src" required>
		</p>

		<p>
		Statie Sosire: <input type="text" name="dst" required>
		</p>

		<p>
		Numar Maxim de Trenuri: <input type="number" name="max_trains" min="0" max="23" required>
		</p>

		<p>
		Ziua Plecarii (1 - 365): <input type="number" name="departure_day" min="1" max="365" required>
		</p>

		<p>
    	<input type="submit" name="search" value="Cauta">
		</p>
	</form>

	<a href="home.php">Inapoi</a>

<?php require "templates/footer.php"; ?>

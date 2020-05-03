<?php

if (isset($_POST["search"])) {
	$src = $_POST["src"];
	$dst = $_POST["dst"];
	$departure_day = $_POST["departure_day"];

	if ($src == "") {
		$src = "%";	
	}

	if ($dst == "") {
		$dst = "%";	
	}

	if ($departure_day == "") {
		$departure_day = "%";
	}

	$url = 'http://client-server:20000/view?';
	$data = array("src" => $src,
					"dst" => $dst,
					"departure_day" => $departure_day);

	$response = file_get_contents($url . http_build_query($data));

	$result = json_decode($response)->status;

	if (count($result) == 0) {
		echo "> Nu s-a gasit niciun tren pentru optiunile alese";
		echo "<br>";	
	} else {?>
		<h2>Lista trenuri</h2>

		<table>
			<thead>
				<tr style="text-align:center">
					<th>ID</th>
					<th>Plecare</th>
					<th>Sosire</th>
					<th>Ora</th>
					<th>Zi</th>
					<th>Durata (Ore)</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($result as $row) : ?>
					<tr style="text-align:center">
						<td><?php echo $row[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
						<td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
						<td><?php echo $row[4]; ?></td>
						<td><?php echo $row[5]; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
<?php
	}
}
?>

<?php require "templates/header.php"; ?>

    <h2>Cauta trenuri</h2>

		<form method="post">
			<p>
				Statie Plecare: <input type="text" name="src">
			</p>

			<p>
				Statie Sosire: <input type="text" name="dst">
			</p>

			<p>
				Ziua Plecarii (1 - 365): <input type="number" name="departure_day" min="1" max="365">
			</p>

			<p>
		  		<input type="submit" name="search" value="Cauta">
			</p>
    </form>

    <a href="home.php">Inapoi</a>

<?php require "templates/footer.php"; ?>

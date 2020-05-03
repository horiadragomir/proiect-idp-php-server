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

if (isset($_POST["search"])) {
	$src = $_POST["src"];
	$dst = $_POST["dst"];
	$departure_day = $_POST["departure_day"];
	$status = $_POST["status"];

	if ($src == "") {
		$src = "%";	
	}

	if ($dst == "") {
		$dst = "%";	
	}

	if ($departure_day == "") {
		$departure_day = "%";
	}

	$url = 'http://admin-server:20001/view?';
	$data = array("src" => $src,
					"dst" => $dst,
					"departure_day" => $departure_day,
					"status" => $status);

	$response = file_get_contents($url . http_build_query($data));

	$result = json_decode($response)->status;

	if (count($result) == 0) {
		echo "> Nu s-a gasit nicio calatorie pentru optiunile alese";
		echo "<br>";	
	} else {?>
		<h2>Lista calatorii</h2>

		<table>
			<thead>
				<tr style="text-align:center">
					<th>ID</th>
					<th>Plecare</th>
					<th>Sosire</th>
					<th>Ora</th>
					<th>Zi</th>
					<th>Durata (Ore)</th>
					<th>Total Locuri</th>
					<th>Locuri Rezervate</th>
					<th>Locuri Achitate</th>
					<th>Status</th>
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
						<td><?php echo $row[6]; ?></td>
						<td><?php echo $row[7]; ?></td>
						<td><?php echo $row[8]; ?></td>
						<td><?php if ($row[9] == "0") echo "activ"; else echo "anulat";?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
<?php
	}
}
?>

<?php require "templates/header.php"; ?>

    <h2>Cauta calatorii</h2>

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
        Status:
        <select name="status">
		      <option value="%">Toate</option>
		      <option value="Activ">Activ</option>
		      <option value="Anulat">Anulat</option>
        </select>
        </p>

			<p>
		  		<input type="submit" name="search" value="Cauta">
			</p>
    </form>

    <a href="home.php">Inapoi</a>

<?php require "templates/footer.php"; ?>

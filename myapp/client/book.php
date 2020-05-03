<?php
	if (isset($_POST["book"])) {
		$url = "http://client-server:20000/book?";

		foreach ($_POST["trip_ids"] as $id) {
			$url = $url . "trip_ids=" . urlencode($id) . "&";
		}

		$response = file_get_contents(substr($url, 0, -1));

		$result = json_decode($response)->status;
		
		echo "> " . nl2br($result);	
	}
?>

<?php require "templates/header.php"; ?>

<head>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>

<body>

	<h2>Fa o rezervare</h2>  

	<form method="post" id="dynamic_field">
		<p>
			ID Tren: <input type="text" name="trip_ids[]" required>
			<button type="button" name="add" id="add" class="btn add">Adauga un tren</button>
		</p>

		<p>
    		<input type="submit" name="book" id="book" value="Rezerva">
		</p>
    </form>

	<a href="home.php">Inapoi</a>

</body>

<script type="text/javascript">

	$(document).ready(function() {

		var i = 1;  


		$('#add').click(function() {

			i++;

			$('#book').remove();

			$('#dynamic_field').append('<p id="row'+i+'">\
											ID Tren: <input type="text" name="trip_ids[]" required>\
											<button type="button" name="remove" class="btn remove" id="'+i+'">X</button>\
										</p>');  

			$('#dynamic_field').append('<p>\
											<input type="submit" name="book" id="book" value="Rezerva">\
										</p>');

		});


		$(document).on('click', '.remove', function() {  

			var button_id = $(this).attr("id");   

			$('#row'+button_id+'').remove();  

		});

	});

</script>

<?php require "templates/footer.php"; ?>

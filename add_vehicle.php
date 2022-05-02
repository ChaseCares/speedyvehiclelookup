<?php
require './includes/db_connect.php';
require './includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta-tags -->
	<meta charset="UTF-8">
	<meta name="description" content="Speedy vehicle Look Up is a service for looking vehicle information">
	<meta name="keywords" content="vehicle info">
	<meta name="author" content="Chase Curtis">
	<title>Group project</title>
	<!-- Importing the CSS from an external stylesheet -->
	<link rel="stylesheet" href="./css/stylesheet.css" type="text/css">
	<!-- Linking to an external image for the favicon -->
	<link href="./img/logo.png" rel="icon" type="image/x-icon">
	<!-- Linking to external CSS for social media links -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<!-- Dummy script, there's a bug in Firefox with loading stylesheets -->
	<!-- https://bugzilla.mozilla.org/show_bug.cgi?id=1404468 -->
	<script>
		0
	</script>
	<!-- Navigation -->
	<nav>
		<ul>
			<!-- Navigation links. Active class represents the current page -->
			<li><a href="index.php">Home</a></li>
			<li><a class="active" href="add_vehicle.php">Add Vehicle</a></li>
			<li><a href="./includes/search.php?vehicle_condition=&newVIN=&color=&make=&year=&model=&action=Matching+All+Fields">All Vehicles</a></li>
			<li><a href="about.html">About Speedy Vehicle Look Up</a></li>
		</ul>
	</nav>

	<!-- Main container div creating an area minus the navigation bar -->
	<div class="container">
		<!-- Content div formatting the text within a page -->
		<div class="contentsWrapper">
			<!-- todo use css to remove this br -->
			<h1>Add a new record to the database!</h1><br>

			<form id="vehicleForm" action="./includes/create.php" method="get" onsubmit="return submitForm()">
				<label for="vehicle_condition">Vehicle condition</label>
				<select name="vehicle_condition" id="vehicle_condition" value="New">
					<option value="new">New</option>
					<option value="used">Used</option>
				</select>

				<label for="VIN">VIN</label>
				<p id="newVINError" class="hiddenError error"> VIN must be 17 characters long </p>
				<input type="text" id="newVIN" name="newVIN" placeholder="JH4DA1740JS012011" maxlength="17" required>

				<label for="color">Color</label><br>
				<p id="colorError" class="hiddenError error"> The maximum character length is 255 </p>
				<input list="color" type="text" name="color" id="color" placeholder="Orange" maxlength=" 254" />
				<datalist id="color">
					<?php optionFiler($conn, "Vehicle", "color"); ?>
				</datalist><br>

				<label>Make:</label><br>
				<p id="makeError" class="hiddenError error"> The maximum character length is 255 </p>
				<input list="make" name="make" type="text" id="make" placeholder="Ford" maxlength="254" />
				<datalist id="make">
					<?php optionFiler($conn, "Brand", "make"); ?>
				</datalist><br>

				<label for="year">Year</label><br>
				<p id="yearError" class="hiddenError error"> Year must be after 1900 or before 2025</p>
				<input list="year" name="year" type="text" id="year" placeholder="2022" maxlength="4" />
				<datalist id="year">
					<?php optionFiler($conn, "Vehicle", "year"); ?>
				</datalist><br>

				<label for="model">Model</label><br>
				<p id="modelError" class="hiddenError error"> The maximum character length is 255 </p>
				<input list="model" name="model" type="text" id="model" placeholder="F-150" maxlength="254" />
				<datalist id="model">
					<?php optionFiler($conn, "Type", "model"); ?>
				</datalist><br><br>
				<input type="submit" value="Submit">
			</form>
		</div>

	</div>
	<script src="./js/inputValidation.js"></script>
</body>

</html>

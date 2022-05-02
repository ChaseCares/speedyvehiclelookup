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
			<li><a class="active" href="index.php">Home</a></li>
			<li><a href="add_vehicle.php">Add Vehicle</a></li>
			<li><a href="./includes/search.php?vehicle_condition=&newVIN=&color=&make=&year=&model=&action=Matching+All+Fields">All Vehicles</a></li>
			<li><a href="about.html">About Speedy Vehicle Look Up</a></li>
		</ul>
	</nav>

	<!-- Main container div creating an area minus the navigation bar -->
	<div class="container">
		<!-- Content div formatting the text within a page -->
		<div class="contentsWrapper">
			<!-- todo use css to remove this br -->
			<h1>Welcome to Speedy Vehicle Look Up!</h1><br>
			<?php
			if (isset($_GET['error'])) {
				if ($_GET['error'] == 'record_deleted') {
					echo "<h3>Record deleted</h3><br>";
				} elseif ($_GET['error'] == 'no_record') {
					echo "<h3>No vehicle found with that VIN</h3><br>";
				}
			} else {
				echo "<h3>Search for a Vehicle</h3><br>";
			}
			?>

			<!-- Convert all value to placeholder -->
			<form id="vehicleForm" action="./includes/search.php" method="get" onsubmit="return submitForm()">
				<label for="vehicle_condition">Vehicle Condition</label>
				<select name="vehicle_condition" id="vehicle_condition" value="New">
					<option value=''></option>
					<option value="new">New</option>
					<option value="used">Used</option>
				</select>

				<label for="VIN">VIN</label>
				<p id="newVINError" class="hiddenError error"> VIN must be 17 characters long </p>
				<input type="text" id="newVIN" name="newVIN" placeholder="JH4DA1740JS012011" maxlength="17">

				<label for="color">Color</label>
				<p id="colorError" class="hiddenError error"> The maximum character length is 255 </p>
				<select name="color" id="color" value="New" maxlength="254">
					<option value=''></option>
					<?php dropDownFiler($conn, "Vehicle", "color"); ?>
				</select>

				<label>Make:</label><br>
				<p id="makeError" class="hiddenError error"> The maximum character length is 255 </p>
				<select name="make" id="make">
					<option value=''></option>
					<?php dropDownFiler($conn, "Brand", "make"); ?>
				</select>

				<label for="year">Year</label>
				<p id="yearError" class="hiddenError error"> Year must be after 1900 or before 2025</p>
				<select name="year" id="year">
					<option value=''></option>
					<?php dropDownFiler($conn, "Vehicle", "year"); ?>
				</select>

				<label for="model">Model</label><br>
				<p id="modelError" class="hiddenError error"> The maximum character length is 255 </p>
				<select name="model" id="model">
					<option value=''></option>
					<?php dropDownFiler($conn, "Type", "model"); ?>
				</select><br><br>
				Search:
				<input type="submit" name="action" value="VIN Only" />
				<input type="submit" name="action" value="Matching All Fields" />
				<input type="submit" name="action" value="Matching Any Fields" />
			</form>
		</div>
	</div>
	<script src="./js/inputValidation.js"></script>
</body>

</html>

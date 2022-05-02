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
    <script>0</script>

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
            <h1>Vehicle Info</h1><br>

            <?php
            if ($_GET["error"] == "duplicate") {
                echo "<h3 class=error>This vehicle already exists!</h3><br>";
                writeToConsole("Error: duplicate");
            } elseif ($_GET["error"] == "update_success") {
                echo "<h3 class=success>Vehicle record has been updated</h3><br>";
                writeToConsole("Update success");
            } elseif ($_GET["error"] == "create_success") {
                echo "<h3 class=success>New vehicle record has been added</h3><br>";
                writeToConsole("Create success");
            } elseif ($_GET['error'] == 'vehicle_exists') {
                echo "<h3>Vehicle found matching VIN</h3><br>";
            }
            ?>

            <form id="vehicleForm" action="./includes/update.php" method="get" onsubmit="return submitForm()">
                <label for="vehicle_condition">Vehicle Condition:</label>
                <select name="vehicle_condition" id="vehicle_condition">
                    <?php $vehicle_condition = $_GET["vehicle_condition"];
                        if($vehicle_condition == 'used'){
                            echo '<option value="new">New</option>
                                    <option value="used" selected >Used</option>';
                        }else{
                            echo '<option value="new" selected>New</option>
                                    <option value="used">Used</option>';
                        }
                    ?>
                </select>

                <!-- todo replace year with drop-down selector -->
                <input type="hidden" id="oldVIN" name="oldVIN" value="<?php echo strtoupper($_GET["VIN"]); ?>">
                <label for="newVIN">VIN</label>
                <p id="newVINError" class="hiddenError error"> VIN must be 17 characters long </p>
                <input type="text" id="newVIN" name="newVIN" value="<?php echo strtoupper($_GET["VIN"]); ?>" maxlength="17" required>

                <label for="color">Color</label>
                <p id="colorError" class="hiddenError error"> The maximum character length is 255 </p>
                <input type="text" id="color" name="color" value="<?php echo ucfirst($_GET["color"]); ?>" maxlength="254">

                <label for="year">Year</label>
                <p id="yearError" class="hiddenError error"> Year must be after 1900 or before 2025</p>
                <input type="text" id="year" name="year" value="<?php echo ucfirst($_GET["year"]); ?>" maxlength="4">

                <label for="make">Make</label><br>
                <p id="makeError" class="hiddenError error"> The maximum character length is 255 </p>
                <input type="text" id="make" name="make" value="<?php echo ucfirst($_GET["make"]); ?>" maxlength="254"><br>

                <label for="model">Model</label><br>
                <p id="modelError" class="hiddenError error"> The maximum character length is 255 </p>
                <input type="text" id="model" name="model" value="<?php echo ucfirst($_GET["model"]); ?>" maxlength="254"><br><br>

                <input type="submit" name="action" value="Update" />
                <input type="submit" name="action" value="Delete" />

            </form>
        </div>
    </div>
    <script src="./js/inputValidation.js"></script>
</body>

</html>

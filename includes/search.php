<?php
require './db_connect.php';
require './functions.php';
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
    <link rel="stylesheet" href="../css/stylesheet.css" type="text/css">
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
            <li><a class="active" href="../index.php">Home</a></li>
            <li><a href="../add_vehicle.php">Add Vehicle</a></li>
            <li><a href="../includes/search.php?vehicle_condition=&newVIN=&color=&make=&year=&model=&action=Matching+All+Fields">All Vehicles</a></li>
            <li><a href="../about.html">About Speedy Vehicle Look Up</a></li>
        </ul>
    </nav>

    <!-- Main container div creating an area minus the navigation bar -->
    <div class="container">
        <!-- Content div formatting the text within a page -->
        <div class="contentsWrapper">
            <h1>Search Results</h1><br>
            <h3>Click on the VIN nuumber to edit or delete</h3><br>

            <?php
            //  Setting the values
            $vehicle_condition = strtolower($_GET["vehicle_condition"]);
            $VIN = strtolower($_GET["newVIN"]);
            $color = strtolower($_GET["color"]);
            $year = $_GET["year"];
            $make = strtolower($_GET["make"]);
            $model = strtolower($_GET["model"]);

            if ($_GET['action'] == 'VIN Only') {
                // Check if the vehicle already exists
                try {
                    //  Creating a prepared statement to execute the query
                    $query = $conn->prepare("SELECT * FROM Vehicle WHERE VIN=:VIN");

                    //  Binding placeholder values
                    $query->bindParam(":VIN", $VIN);
                    //  Executing the query
                    $query->execute();

                    $result = $query->fetchAll();
                } catch (PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                    writeToConsole($error);
                }


                $conn = null;
                if (count($result) == 0) {
                    // Redirect the user if VIN does not exist
                    header("Location: ../index.php?error=no_record");
                    exit();
                } elseif (count($result) == 1) {
                    $vehicle_condition =
                        $result[0]['vehicle_condition'];
                    $color = $result[0]['color'];
                    $year = $result[0]['year'];
                    $make = $result[0]['make'];
                    $model = $result[0]['model'];

                    $conn = null;
                    // Redirect the user if VIN already exists
                    header("Location: ../results.php?vehicle_condition=$vehicle_condition&VIN=$VIN&color=$color&year=$year&make=$make&model=$model&error=vehicle_exists");
                    exit();
                }
            } elseif ($_GET['action'] == 'Matching All Fields') {
                // Check if the vehicle already exists
                try {
                    //  Creating a prepared statement to execute the query
                    $query = $conn->prepare("SELECT * FROM Vehicle WHERE
                    vehicle_condition LIKE :vehicle_condition AND
                    VIN LIKE :VIN AND
                    color LIKE :color AND
                    year LIKE :year AND
                    make LIKE :make AND
                    model LIKE :model");

                    if ($vehicle_condition == '') $vehicle_condition = '%';
                    if ($VIN == '') $VIN = '%';
                    if ($color == '') $color = '%';
                    if ($year == '') $year = '%';
                    if ($make == '') $make = '%';
                    if ($model == '') $model = '%';

                    //  Binding placeholder values
                    $query->bindParam(":vehicle_condition", $vehicle_condition);
                    $query->bindParam(":VIN", $VIN);
                    $query->bindParam(":color", $color);
                    $query->bindParam(":year", $year);
                    $query->bindParam(":make", $make);
                    $query->bindParam(":model", $model);

                    //  Executing the query
                    $query->execute();

                    $result = $query->fetchAll();
                } catch (PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                    writeToConsole($error);
                }

                tableBuilder($result);
            } elseif ($_GET['action'] == 'Matching Any Fields') {
                // Check if the vehicle already exists
                try {
                    //  Creating a prepared statement to execute the query
                    $query = $conn->prepare("SELECT * FROM Vehicle WHERE
                    vehicle_condition=:vehicle_condition OR
                    VIN=:VIN OR
                    color=:color OR
                    year=:year OR
                    make=:make OR
                    model=:model");

                    //  Binding placeholder values
                    $query->bindParam(":vehicle_condition", $vehicle_condition);
                    $query->bindParam(":VIN", $VIN);
                    $query->bindParam(":color", $color);
                    $query->bindParam(":year", $year);
                    $query->bindParam(":make", $make);
                    $query->bindParam(":model", $model);

                    //  Executing the query
                    $query->execute();

                    $result = $query->fetchAll();
                } catch (PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                    writeToConsole($error);
                }

                tableBuilder($result);
            } else {
                writeToConsole("Invalid action");
                // Redirect the user
                header("Location: ../index.php?error=invalid_action");
            }
            ?>

        </div>
    </div>
</body>

</html>

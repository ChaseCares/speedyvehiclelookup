<?php
require './db_connect.php';
require './functions.php';

//  Setting the values
$vehicle_condition = strtolower($_GET["vehicle_condition"]);
$oldVIN = strtolower($_GET["oldVIN"]);
$newVIN = strtolower($_GET["newVIN"]);
$color = strtolower($_GET["color"]);
$year = $_GET["year"];
$make = strtolower($_GET["make"]);
$model = strtolower($_GET["model"]);

if ($_GET['action'] == 'Update') {
    try {
        //  Creating a prepared statement to execute the query
        $query = $conn->prepare("INSERT IGNORE INTO Brand (make) VALUES (:make)");
        $query->bindParam(":make", $make);
        $query->execute();

        $query = $conn->prepare("INSERT IGNORE INTO Type (model) VALUES (:model)");
        $query->bindParam(":model", $model);
        $query->execute();

        //  Creating a prepared statement to execute the query
        $query = $conn->prepare("UPDATE Vehicle SET vehicle_condition=:vehicle_condition, VIN=:newVIN, color=:color, year=:year, make=:make, model=:model WHERE VIN=:oldVIN");

        //  Binding placeholder values
        $query->bindParam(":vehicle_condition", $vehicle_condition);
        $query->bindParam(":oldVIN", $oldVIN);
        $query->bindParam(":newVIN", $newVIN);
        $query->bindParam(":color", $color);
        $query->bindParam(":year", $year);
        $query->bindParam(":make", $make);
        $query->bindParam(":model", $model);

        //  Executing the query
        $query->execute();

        // echo "New record created successfully";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        writeToConsole($error);
    }

    $conn = null;
    writeToConsole("Update succes");
    // Redirect the user
    header("Location: ../results.php?vehicle_condition=$vehicle_condition&VIN=$newVIN&color=$color&year=$year&make=$make&model=$model&error=update_success");
} else if ($_GET['action'] == 'Delete') {
    try {
        //  Creating a prepared statement to execute the query
        $query = $conn->prepare("DELETE FROM Vehicle WHERE VIN=:oldVIN");

        //  Binding placeholder values
        $query->bindParam(":oldVIN", $oldVIN);

        //  Executing the query
        $query->execute();

        // echo "New record deleted successfully";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        writeToConsole($error);
    }

    $conn = null;
    writeToConsole("Record deleted");
    // Redirect the user
    header("Location: ../index.php?error=record_deleted");
} else {
    writeToConsole("Invalid action");
    // Redirect the user
    header("Location: ../index.php?error=invalid_action");
}
?>

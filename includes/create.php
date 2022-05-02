<?php
require 'db_connect.php';
require './functions.php';

//  Setting the values
$vehicle_condition = strtolower($_GET["vehicle_condition"]);
$VIN = strtolower($_GET["newVIN"]);
$color = strtolower($_GET["color"]);
$year = $_GET["year"];
$make = strtolower($_GET["make"]);
$model = strtolower($_GET["model"]);

// Check if the vehicle already exists
try {
    //  Creating a prepared statement to execute the query
    $query = $conn->prepare("SELECT VIN FROM Vehicle WHERE VIN=:VIN");

    //  Binding placeholder values
    $query->bindParam(":VIN", $VIN);
    //  Executing the query
    $query->execute();

    $result = $query->fetchAll();


} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    writeToConsole($error);
}

if (count($result) > 0) {
    $conn = null;
    // Redirect the user if VIN already exists
    header("Location: ../results.php?vehicle_condition=$vehicle_condition&VIN=$VIN&color=$color&year=$year&make=$make&model=$model&error=duplicate");
    exit();
}

// If vehicle does not exist add it
try {
    //  Creating a prepared statement to execute the query
    $query = $conn->prepare("INSERT IGNORE INTO Brand (make) VALUES (:make)");
    $query->bindParam(":make", $make);
    $query->execute();

    $query = $conn->prepare("INSERT IGNORE INTO Type (model) VALUES (:model)");
    $query->bindParam(":model", $model);
    $query->execute();

    //  Creating a prepared statement to execute the query
    $query = $conn->prepare("INSERT INTO Vehicle (vehicle_condition, VIN, color, year, make, model) VALUES (:vehicle_condition, :VIN, :color, :year, :make, :model)");

    //  Binding placeholder values
    $query->bindParam(":vehicle_condition", $vehicle_condition);
    $query->bindParam(":VIN", $VIN);
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
writeToConsole("Create success");

// Redirect the user
header("Location: ../results.php?vehicle_condition=$vehicle_condition&VIN=$VIN&color=$color&year=$year&make=$make&model=$model&error=create_success");
?>

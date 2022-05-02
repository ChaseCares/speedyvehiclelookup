<?php
function tableReturn($conn, $table, $column){
	// Creating a prepared statement to execute the query
	$query = $conn->prepare("SELECT DISTINCT $column FROM $table ORDER BY $column ASC");
	// Executing the query
	$query->execute();
	$array = $query->fetchAll(PDO::FETCH_COLUMN);
	return $array;
}
function dropDownFiler($conn, $table, $column){
    $array = tableReturn($conn, $table, $column);
    foreach ($array as $x => $val) {
        if ($column == "VIN"){
                echo "<option value='$val'>" . strtoupper($val) . "</option>";
        } else {
                echo "<option value='$val'>" . ucfirst($val) . "</option>";
        }
    }
}
function optionFiler($conn, $table, $column){
    $array = tableReturn($conn, $table, $column);
    foreach ($array as $x => $val) {
        echo "<option value='". ucfirst($val) . "'></option>\n";
    }
}
function writeToConsole($data){
    $console = $data;
    if (is_array($console))
        $console = implode(',', $console);

    echo "<script>console.log('Console: " . $console . "' );</script>";
}
function tableBuilder($array){
    echo "<table style='width:100%'>
                    <tr>
                        <th>Vehicle Condition</th>
                        <th>VIN</th>
                        <th>Color</th>
                        <th>Year</th>
                        <th>Make</th>
                        <th>Model</th>
                    </tr>";
    $i = 0;
    foreach ($array as $vehicle) {
        $_VIN = strtoupper($array[$i]['VIN']);
        echo "
                    <tr>
                        <td>" . ucfirst($array[$i]['vehicle_condition']) . "</td>
                        <td><a href= '/includes/search.php?newVIN=" . $_VIN . "&action=VIN Only'>" . $_VIN . "</a></td>
                        <td>" . ucfirst($array[$i]['color']) . "</td>
                        <td>" . ucfirst($array[$i]['year']) . "</td>
                        <td>" . ucfirst($array[$i]['make']) . "</td>
                        <td>" . ucfirst($array[$i]['model']) . "</td>
                    </tr>";
        $i = ++$i;
    }
    echo "</table>";
}
?>

<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empName = $conn->real_escape_string($_POST['uempname']);

    // Get values from the form
    $ucl = isset($_POST['ucl']) ? floatval($_POST['ucl']) : 0;
    $usl = isset($_POST['usl']) ? floatval($_POST['usl']) : 0;
    $uco = isset($_POST['uco']) ? floatval($_POST['uco']) : 0;
    $lastupdate = date('Y-m-d H:i:s');

    // Fetch current values of CL, SL, and CO
    $selectSql = "SELECT icl, isl, ico, cl, sl, co, lastupdate FROM leavebalance WHERE empname = ?";
    $stmt = $conn->prepare($selectSql);
    $stmt->bind_param("s", $empName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned a result
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Calculate updated values
        $icl = isset($row['icl']) ? floatval($row['icl']) + $ucl : 0;
        $isl = isset($row['isl']) ? floatval($row['isl']) + $usl : 0;
        $ico = isset($row['ico']) ? floatval($row['ico']) + $uco : 0;
        $cl = isset($row['cl']) ? floatval($row['cl']) + $ucl : 0;
        $sl = isset($row['sl']) ? floatval($row['sl']) + $usl : 0;
        $co = isset($row['co']) ? floatval($row['co']) + $uco : 0;

        // Prepare the SQL statement for updating leavebalance table
        $updateSql = "UPDATE leavebalance 
                      SET icl = ?, isl = ?, ico = ?, cl = ?, sl = ?, co = ?, lastupdate = ?
                      WHERE empname = ?";

        // Prepare and bind the parameters
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ddddddss", $icl, $isl, $ico, $cl, $sl, $co, $lastupdate, $empName);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Data updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: No data found for employee: $empName";
    }

    // Close the connection
    $conn->close();
}
?>

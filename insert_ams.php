<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tableData = $_POST['table_data'];
    
    $con = new mysqli("localhost", "root", "", "ems");
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    foreach ($tableData as $data) {
        $adate = trim($data['adate']);
        $empname = trim($data['empname']);
        $intime = trim($data['intime']);
        $intime_inputtype = trim($data['intime_inputtype']);
        $outtime = trim($data['outtime']);
        $outtime_inputtype = trim($data['outtime_inputtype']);
        $total_hrs = trim($data['total_hrs']);
        $actual_working_hrs = trim($data['actual_working_hrs']);
        
        $sql = "INSERT INTO ams (adate, empname, intime, intime_inputtype, outtime, outtime_inputtype, total_hrs, actual_working_hrs)
                VALUES ('$adate', '$empname', '$intime', '$intime_inputtype', '$outtime', '$outtime_inputtype', '$total_hrs', '$actual_working_hrs')";
        
        if ($con->query($sql) === TRUE) {
            echo "Data inserted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
    
    $con->close();
} else {
    echo "Invalid request!";
}
?>

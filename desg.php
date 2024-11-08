<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$desg= $_POST['desg'];
$shifts= $_POST['shifts'];
$toshifttime1= $_POST['toshifttime1'];
$toshifttime2= $_POST['toshifttime2'];
$toshifttime3= $_POST['toshifttime3'];
$fromshifttime1= $_POST['fromshifttime1'];
$fromshifttime2= $_POST['fromshifttime2'];
$fromshifttime3= $_POST['fromshifttime3'];

$sql = "INSERT INTO dept (desg, shifts, toshifttime1,toshifttime2,toshifttime3, fromshifttime1,fromshifttime2,fromshifttime3) 
        VALUES ('$desg', '$shifts','$toshifttime1', '$toshifttime2', '$toshifttime3','$fromshifttime1', '$fromshifttime2', '$fromshifttime3')";

if ($conn->query($sql) === TRUE) {
    echo "Done !";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>

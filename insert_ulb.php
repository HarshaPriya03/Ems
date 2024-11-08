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
    $empname = $_POST['uempname'];
    $empemail = $_POST['uempemail'];
    $cl = $_POST['ccl'];
    $sl = $_POST['csl'];
    $co = $_POST['cco'];
    $ucl = $_POST['ucl'];
    $usl = $_POST['usl'];
    $uco = $_POST['uco'];
    $by_user = $_POST['by_user'];
    $utime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO updatelb (empname, empemail, ccl, csl, cco, ucl, usl, uco, by_user, utime) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $empname, $empemail, $cl, $sl, $co, $ucl, $usl, $uco, $by_user, $utime);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

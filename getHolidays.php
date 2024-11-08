<?php
header('Content-Type: application/json');
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$fetchHolidaysQuery = "SELECT `date` FROM holiday";
$holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
$holidayDates = [];

while ($row = mysqli_fetch_assoc($holidaysResult)) {
    $holidayDates[] = $row['date'];
}
echo json_encode($holidayDates);

mysqli_close($con);
?>

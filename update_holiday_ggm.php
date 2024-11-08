<?php
require_once("dbConfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $value = $_POST["value"];

    // Perform the update query
    $formattedDate = date('Y-m-d', strtotime($date));
    $sql = "UPDATE holiday_ggm SET value = '$value' WHERE date = '$formattedDate'";
    $result = $db->query($sql);

    if ($result) {
        // Return the updated value (you can customize this based on your needs)
        echo $value;
    } else {
        // Handle the update failure
        echo "Update failed";
    }
}

$db->close();
?>

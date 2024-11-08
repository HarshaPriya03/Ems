<?php
require_once("dbConfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];

    // Perform the delete query
    $formattedDate = date('Y-m-d', strtotime($date));
    $sql = "DELETE FROM holiday WHERE date = '$formattedDate'";
    $result = $db->query($sql);

    if ($result) {
        // Return success message or any response you prefer
        echo "Delete successful";
    } else {
        // Handle the delete failure
        echo "Delete failed";
    }
}

$db->close();
?>

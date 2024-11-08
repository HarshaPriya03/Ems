<?php
include_once 'dbConfig.php';

if (isset($_POST['userId']) && isset($_POST['work_location'])) {
    $userId = $_POST['userId'];
    $workLocation = $_POST['work_location'];
    
    $sql = "SELECT ServiceTagId, ServiceTagId1 FROM emp WHERE UserId = ? AND work_location = ?";
    $stmt = $db->prepare($sql);
    
    // Bind both parameters (i for integer, s for string)
    $stmt->bind_param("is", $userId, $workLocation);
    
    $stmt->execute();
    
    // Bind the result variables
    $stmt->bind_result($serviceTagId, $serviceTagId1);
    
    // Fetch the results
    if ($stmt->fetch()) {
        // Output the results
        echo $serviceTagId . " " . $serviceTagId1;
    } else {
        echo "No records found.";
    }
    
    // Close the statement
    $stmt->close();
}
?>

<?php
// Assuming you have a database connection established already
@include 'inc/config.php';

// Query to check if there are any updates based on ID increment
$query = "SELECT MAX(id) AS max_id FROM loggedin";
$result = mysqli_query($con, $query);

if ($result) {
    // Fetch the maximum ID from the result
    $row = mysqli_fetch_assoc($result);
    $maxId = $row['max_id'];

    // Get the latest ID stored in the client-side
    $latestId = $_GET['latestId'];

    // Check if there are updates by comparing the latest ID
    $hasUpdates = ($maxId > $latestId);

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode(['hasUpdates' => $hasUpdates, 'maxId' => $maxId]);
} else {
    // Handle the case where the query fails
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Failed to execute query']);
}
ob_clean();

// Set the content type header to indicate that the response is JSON
header('Content-Type: application/json');

// Output the JSON response
?>

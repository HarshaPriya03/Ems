<?php
// Replace these variables with your own database details
$host = 'localhost';
$username = 'Anika12';
$password = 'Anika12';
$database = 'ems';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data from your table
$sql = "SELECT * FROM mail_log";
$result = $conn->query($sql);

// Build the HTML to display the data
$output = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= '<div>';
        $output .= 'Email: ' . $row['email'] . '<br>';
        $output .= 'purpose: ' . $row['purpose'] . '<br>';
        // Add more fields as needed
        $output .= '</div>';
    }
} else {
    $output = 'No data found';
}

// Close the database connection
$conn->close();

// Return the generated HTML
echo $output;
?>

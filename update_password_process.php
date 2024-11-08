<?php
// Include your database connection file here
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Perform additional validation if needed

    // Check if passwords match
    if ($password !== $cpassword) {
        $response = array('success' => false, 'message' => 'Passwords do not match');
    } else {
        // Hash the password (use password_hash() in a real-world scenario)
        $hashedPassword = md5($password); // This is just an example, use a secure hashing algorithm

        // Update password in the database
        // Implement your database update query here
        // Example: mysqli_query($conn, "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'");
        mysqli_query($conn, "UPDATE user_form SET password = '$hashedPassword' WHERE email = '$email'");
        $response = array('success' => true, 'message' => 'Password updated successfully');
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method');
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

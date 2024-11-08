<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];



    if ($password !== $cpassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
        exit;
    }

    $checkEmailQuery = "SELECT * FROM user_form WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'User already exists']);
        exit;
    }

    $insertQuery = "INSERT INTO user_form (email, name, password,user_type,empstatus) VALUES ('$email', '$name', '$password','$user_type','0')";
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error creating account']);
    }

    $conn->close();
}
?>

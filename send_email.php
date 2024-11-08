<?php

// Database connection details
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    $subject = 'Reset Password Request';
    $email = $_POST['email'];
    $queryParams = http_build_query(['email' => $email]);
    $url = "https://hrms.anikasterilis.com/reset-email.php?" . $queryParams;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $msg = curl_exec($ch);
    curl_close($ch);
    
     $from_email = 'hrms@anikasterilis.in';
    $from_name = 'ASPL HRMS';
    $headers = "From: $from_name <$from_email>\r\n" .
               "Reply-To: $from_email\r\n" .
               "Content-type: text/html\r\n" . 
               'X-Mailer: PHP/' . phpversion();

    if (mail($email, $subject, $msg, $headers)) {
        $email = $_POST['email'];
        $purpose = $_POST['purpose'];
        $query = "INSERT INTO mail_log (email, purpose) VALUES ('$email', '$purpose')";
        if ($conn->query($query) === TRUE) {
            echo "ok";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "error";
    }

    $conn->close();
}

?>

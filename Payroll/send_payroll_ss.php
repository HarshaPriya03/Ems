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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $subject = 'Payrun Completed – Statements Available';
    $queryParams = http_build_query(['email' => $email]);
    $url = "https://hrms.anikasterilis.com/Payroll/payroll_mail.html?" . $queryParams;

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $msg = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
        curl_close($ch);
        $conn->close();
        exit();
    }
    curl_close($ch);

    // Email details
    $from_email = 'hrms@anikasterilis.in';
    $from_name = 'ASPL HRMS';
    $headers = "From: $from_name <$from_email>\r\n" .
               "Reply-To: $from_email\r\n" .
               "Content-type: text/html\r\n" . 
               'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (mail($email, $subject, $msg, $headers)) {
        $purpose = 'Payroll Notification';

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO mail_log (email, purpose) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $email, $purpose);
            if ($stmt->execute()) {
                echo "ok";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "error";
    }

    $conn->close();
}
?>

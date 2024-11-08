<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $purpose = $_POST['purpose'];
    $to = $_POST['email'];
    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function emailExists($email)
    {
        global $conn;

        $email = mysqli_real_escape_string($conn, $email);

        $query = "SELECT COUNT(*) as count FROM emp WHERE empemail = '$email'";
        $result = $conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        } else {
            return false;
        }
    }
    function emailExists1($email)
    {
        global $conn;

        $email = mysqli_real_escape_string($conn, $email);

        $query = "SELECT COUNT(*) as count FROM onb WHERE empemail = '$email'";
        $result = $conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        } else {
            return false;
        }
    }
 

    if (emailExists($email)) {
        echo "exists";
        exit();
    }
    if (emailExists1($email)) {
        echo "exist";
        exit();
    }


    $uniqueLink = generateRandomString();
    $queryParams = http_build_query(['email' => $email, 'token' => $uniqueLink]);
    $url = "https://hrms.anikasterilis.com/add-email.php?" . $queryParams;
    
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $msg = curl_exec($ch);
    curl_close($ch);


    
    $subject = 'Welcome to the ASPL - Onboarding Process Initiated';

    $from_email = 'hrms@anikasterilis.in';
    $from_name = 'ASPL HRMS';
    $headers = "From: $from_name <$from_email>\r\n" .
        "Reply-To: $from_email\r\n" .
        "Content-type: text/html\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $msg, $headers)) {
        $query = "INSERT INTO mail_log (email, purpose) VALUES ('$email', '$purpose')";
        if ($conn->query($query) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error occur";
    }
    $conn->close();
}

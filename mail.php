<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Move the function declaration outside of the POST block
function generateRandomString($length = 10)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueLink = generateRandomString();
    $msg = "Click the following link to <u>Create Emp login acc</u>: <a href='https://hrms.anikasterilis.com/createpage.php?email={$$empemail}&token={$uniqueLink}'>Click here</a>";
   
    $subject = 'Successful Onboarding - Next Steps: Employee Login Creation';
    $from_email = 'hrms@anikasterilis.in';
    $from_name = 'ASPL HRMS';
    $headers = "From: $from_name <$from_email>\r\n" .
               "Reply-To: $from_email\r\n" .
               "Content-type: text/html\r\n" . 
               'X-Mailer: PHP/' . phpversion();

}
$conn->close();
?>

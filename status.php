<?php
$currentTimestamp = date("Y-m-d");
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    $uniqueLink = generateRandomString();

    $ID = isset($_GET['id']) ? $_GET['id'] : null;

    $empstatus = $_POST['empstatus'];
    $reason = $_POST['reason'];

    if ($empstatus == 1) {
        $subject = 'Update on employment status - Terminate';
        $message = "Click the following link to <u>Terminate</u>: <a href='http://hrms.anikasterilis.com/email-form.php?email={$_POST['email']}&token={$uniqueLink}'>Click here</a>";
    } elseif ($empstatus == 2) {
        $subject = 'Update on employment status - Resignation';
        $message = "Click the following link to <u>Complete your resignation</u>: <a href='http://hrms.anikasterilis.com/email-form.php?email={$_POST['email']}&token={$uniqueLink}'>Click here</a>";
    } elseif ($empstatus == 0) {
        $subject = 'Update on employment status - Complete';
        $message = "Click the following link to <u>Complete</u>: <a href='http://hrms.anikasterilis.com/email-form.php?email={$_POST['email']}&token={$uniqueLink}'>Click here</a>";
    }

       $from_email = 'hrms@anikasterilis.in';
    $from_name = 'ASPL HRMS';
    $headers = "From: $from_name <$from_email>\r\n" .
               "Reply-To: $from_email\r\n" .
               "Content-type: text/html\r\n" . // Set content type to HTML
               'X-Mailer: PHP/' . phpversion();

    if (mail($_POST['email'], $subject, $message, $headers)) {
        $empQuery = "UPDATE `emp` SET empstatus='$empstatus', reason='$reason', exit_dt = '$currentTimestamp' WHERE id='$ID' ";
        if ($conn->query($empQuery) === TRUE) {
            $userFormQuery = "UPDATE `user_form` SET empstatus='$empstatus' WHERE email='{$_POST['email']}'";
            if ($conn->query($userFormQuery) === TRUE) {
                // Insert into mail_log after successful email and database updates
                $emailLogQuery = "INSERT INTO mail_log (email, purpose) VALUES ('{$_POST['email']}', 'for an update on employment status.')";
                if ($conn->query($emailLogQuery) === TRUE) {
                    echo "Email sent and records updated successfully.";
                } else {
                    echo "Error updating mail_log table: " . $conn->error;
                }
            } else {
                echo "Error updating user_form table: " . $conn->error;
            }
        } else {
            echo "Error updating emp table: " . $conn->error;
        }
    } else {
        echo "Error sending email.";
    }

    $conn->close();
}
?>

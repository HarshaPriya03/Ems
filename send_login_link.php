<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $to = $_POST['email'];
    $subject = 'Subject of the Email';

    // Create the HTML content
    $html = "Click the following link to <u>To LOGIN</u>: <a href='https://hrms.anikasterilis.com/loginpage.php?email={$_POST['email']}'>Click here</a>";


    $from_email = 'hrms@anikasterilis.in';
    $from_name = 'ASPL HRMS';
    $headers = "From: $from_name <$from_email>\r\n" .
               "Reply-To: $from_email\r\n" .
               "Content-type: text/html\r\n" . // Set content type to HTML
               'X-Mailer: PHP/' . phpversion();
               
    // Send the email
    if (mail($to, $subject, $html, $headers)) {
        echo "alert success";
    } else {
        echo "Error occur";
    }
}
?>

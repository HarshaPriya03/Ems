<?php
// Set session cookie parameters to share across subdomains
$domain = '.anikasterilis.com'; // Notice the dot at the beginning
session_set_cookie_params(0, '/', $domain, true, true);

session_start();
include 'inc/config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('location:index.php');
    exit();
}

$email = $_SESSION['email'];
$app = $_POST['app'];  // Get the app value from the form submission

// Check if the app is VMS
if ($app === 'VMS') {
    // Create a new connection to the voucherms database
    $voucherms_con = new mysqli('localhost', 'root', '', 'voucherms');
    
    // Check connection
    if ($voucherms_con->connect_error) {
        die("Connection failed: " . $voucherms_con->connect_error);
    }
    
    $stmt = $voucherms_con->prepare("SELECT department FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($department);
        $stmt->fetch();
        
        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        
        // Store the token and email in the session
        $_SESSION['auth_token'] = $token;
        $_SESSION['email'] = $email;
        
        // Determine the redirect URL
        $redirect_url = 'https://voucher.anikasterilis.com/';
        if ($department == 'admin') {
            $redirect_url .= 'admin.php';
        } elseif ($department == 'Issuer') {
            $redirect_url .= 'index.php';
        } elseif ($department == 'Approver') {
            $redirect_url .= 'Approver/index.php';
        } else {
            $redirect_url .= 'home.php';
        }
        
        // Append token and email to the URL
        $redirect_url .= '?token=' . urlencode($token) . '&email=' . urlencode($email);
        
        // Redirect to the appropriate page
        header("Location: $redirect_url");
        exit();
    } else {
        echo "<script> 
                alert('No records found!');
                window.open('home.php','_self');
              </script>";
        exit();
    }
    
    $stmt->close();
    $voucherms_con->close();
} else {
    echo "<script> 
            alert('Invalid app selected!');
            window.open('home.php','_self');
          </script>";
    exit();
}
?>
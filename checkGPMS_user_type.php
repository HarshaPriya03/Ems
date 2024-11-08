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
if ($app === 'GPMS') {
    // Create a new connection to the voucherms database
    $gatepass_con = new mysqli('localhost', 'root', '', 'simpleave');
    
    // Check connection
    if ($gatepass_con->connect_error) {
        die("Connection failed: " . $gatepass_con->connect_error);
    }
    
    $stmt = $gatepass_con->prepare("SELECT department FROM users WHERE email = ?");
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
        $redirect_url = 'https://gatepass.anikasterilis.com/';
        if ($department == 'Approver') {
            $redirect_url .= 'admin/access_page.php';
        } elseif ($department == 'Issuer') {
            $redirect_url .= 'issuer/new.php';
        } elseif ($department == 'Verifier') {
            $redirect_url .= 'gaurd/new.php';
        } else {
            $redirect_url .= 'employee-dashboard.php';
        }
        
        // Append token and email to the URL
        $redirect_url .= '?token=' . urlencode($token) . '&email=' . urlencode($email);
        
        // Redirect to the appropriate page
        header("Location: $redirect_url");
        exit();
    } else {
        echo "<script> 
                alert('No records found!');
                window.open('employee-dashboard.php','_self');
              </script>";
        exit();
    }
    
    $stmt->close();
    $gatepass_con->close();
} else {
    echo "<script> 
            alert('Invalid app selected!');
            window.open('employee-dashboard.php','_self');
          </script>";
    exit();
}
?>
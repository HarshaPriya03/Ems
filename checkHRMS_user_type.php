<?php
// Set session cookie parameters to share across subdomains
$domain = '.anikasterilis.com'; // Notice the dot at the beginning
session_set_cookie_params(0, '/', $domain, true, true);

session_start();
include 'inc/config.php'; // This should include the connection to the `apps` database

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('location:index.php');
    exit();
}

$email = $_SESSION['email'];
$app = $_POST['app'];  // Get the app value from the form submission

// Check if the app is HRMS
if ($app === 'HRMS') {
    // Create a new connection to the ems database
    $ems_con = new mysqli('localhost', 'root', '', 'ems');
    // Check connection
    if ($ems_con->connect_error) {
        die("Connection failed: " . $ems_con->connect_error);
    }

    // Fetch user details from the ems database
    $select = "SELECT uf.*, m.status as manager_status 
               FROM user_form uf
               LEFT JOIN manager m ON uf.email = m.email 
               WHERE uf.email = ?";
    $stmt = $ems_con->prepare($select);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $email;

        // Fetch module information from the ems database
        $module_sql = "SELECT module_name FROM modules INNER JOIN user_modules ON modules.id = user_modules.module_id WHERE user_modules.email = ?";
        $module_stmt = $ems_con->prepare($module_sql);
        $module_stmt->bind_param("s", $email);
        $module_stmt->execute();
        $module_result = $module_stmt->get_result();

        // Log the user's login details in the apps database
        $insertQuery = "INSERT INTO loggedin (empemail, loggedtime, device, browser, longitude, latitude) VALUES (?, NOW(), 'desktopapp', ?, 'N/A', 'N/A')";
        $log_stmt = $con->prepare($insertQuery);
        $log_stmt->bind_param("ss", $email, $_SERVER['HTTP_USER_AGENT']);
        $log_stmt->execute();

        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $_SESSION['auth_token'] = $token;

        // Determine the redirect URL based on user type
        $HRMSurl = 'https://hrms.anikasterilis.com/';
        $redirect_url = 'https://hrms.anikasterilis.com/';
        if ($row['user_type'] == 'acc') {
            $redirect_url .= 'Payroll/acc/acc_payroll.php';
        } elseif ($row['user_type1'] == 'admin' || $row['manager_status'] == 1 || $row['user_type'] == 'user') {
            $redirect_url .= 'employee-dashboard.php';
        } else {
            $redirect_url .= 'employee-dashboard.php';
        }

        // Mobile device detection
        echo '<script>
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                 window.location.href = " '. $HRMSurl .'mobileV/emp-dashboard-mob.php?token=' . urlencode($token) . '&email=' . urlencode($email) . '";
            } else {
                window.location.href = "' . $redirect_url . '?token=' . urlencode($token) . '&email=' . urlencode($email) . '";
            }
        </script>';

        // Set session variables
        $_SESSION['user_name'] = $row['email'];
        $_SESSION['admin_name'] = $row['name'];

        exit();
    } else {
        echo '<script>alert("No records found!");</script>';
        echo '<script>window.location.href = "home.php";</script>';
        exit();
    }
    
    // Close statements and connection
    $stmt->close();
    $module_stmt->close();
    $ems_con->close();
    $log_stmt->close();
} else {
    echo '<script>alert("Invalid app selected!");</script>';
    echo '<script>window.location.href = "home.php";</script>';
    exit();
}
?>

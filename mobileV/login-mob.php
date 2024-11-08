<?php

@include '../inc/config.php';

session_start();

// Initialize login attempts if not already set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = md5($_POST['password']);
    $latitude = 'N/A';
    $longitude = 'N/A';

    // Increment login attempts
    $_SESSION['login_attempts']++;

    // Check if location is provided or if login attempts are 3 or more
    if ($_SESSION['login_attempts'] < 3 && (empty($_POST['latitude']) || empty($_POST['longitude']))) {
        echo '<script>alert("Please enable location access to proceed.");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
        exit;
    }

    if ($_SESSION['login_attempts'] >= 3) {
        // Use N/A for latitude and longitude if attempts are 3 or more
        $latitude = 'N/A';
        $longitude = 'N/A';
    } else {
        // Use provided latitude and longitude
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
    }

    $select = "SELECT uf.*, m.status as manager_status 
               FROM user_form uf
               LEFT JOIN manager m ON uf.email = m.email 
               WHERE uf.email = '$email' AND uf.password = '$pass'";
    $result = mysqli_query($con, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            $insertQuery = "INSERT INTO loggedin (empemail,browser, loggedtime, device, latitude, longitude) VALUES ('$email', '" . $_SERVER['HTTP_USER_AGENT'] . "', NOW(), 'mobileapp', '$latitude', '$longitude')";
            mysqli_query($con, $insertQuery);
            header('location:index.php');
            exit;
        } elseif ($row['manager_status'] == 1) {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
           $insertQuery = "INSERT INTO loggedin (empemail,browser, loggedtime, device, latitude, longitude) VALUES ('$email', '" . $_SERVER['HTTP_USER_AGENT'] . "', NOW(), 'mobileapp', '$latitude', '$longitude')";
            mysqli_query($con, $insertQuery);
            header('location:index_mgr.php');
            exit;
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $insertQuery = "INSERT INTO loggedin (empemail,browser, loggedtime, device, latitude, longitude) VALUES ('$email', '" . $_SERVER['HTTP_USER_AGENT'] . "', NOW(), 'mobileapp', '$latitude', '$longitude')";
            mysqli_query($con, $insertQuery);
            header('location:emp-dashboard-mob.php');
            exit;
        } else {
            header('location:emp-dashboard-mob.php');
            exit;
        }
    } else {
        echo '<script>alert("Incorrect Email or Password!");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
    }

    $select_email = "SELECT * FROM user_form WHERE email = '$email'";
    $result_email = mysqli_query($con, $select_email);

    if (mysqli_num_rows($result_email) === 0) {
        echo '<script>alert("Email does not exist!");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./empmobcss/globalop.css" />
  <link rel="stylesheet" href="./empmobcss/login-mob.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div class="loginmob" style="height: 100svh;">
    <div class="frame-div">
      <img class="logo-1-icon3" alt="" style="filter:contrast(200%);" src="./public/logo-1@2x3.png" />

      <h1 class="anika-hrm3">
        <span>Anika</span>
        <span class="span3"> </span>
        <span class="hrm3">HRM</span>
      </h1>
      <div class="frame-child5"></div>
      <img class="pngfind-1-icon3" alt="" src="./public/pngfind-1@2x.png" />

      <img class="image-1-icon1" alt="" src="./public/image-1@2x.png" />

      <div class="login-to-your">Login to your account</div>
      <div class="email-id1">Email ID:</div>
      <div class="password1">Password:</div>
      <form action="" method="POST">
        <?php
        if (isset($error)) {
          foreach ($error as $error) {
            echo '<span style="color:white;">' . $error . '</span>';
          };
        };
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
          $prefilledEmail = $_GET['email'];
          echo "<input class='frame-child6' style='font-size: 30px;' id='email' value='$prefilledEmail' name='email' type='email' readonly required />";
        } else {
          echo "<input class='frame-child6' style='font-size: 30px;' id='email' name='email' type='email' required />";
        }
        ?>
        <input class="frame-child5" style="font-size: 30px;margin-left:100px;margin-top:200px;" type="hidden" id="longitude" name="longitude">

        <input class="frame-child5" style="font-size: 30px;margin-left:100px;margin-top:100px;" type="hidden" id="latitude" name="latitude">

        <input style='color: white;' class='frame-child7' name="password" type="password" required>
        <button type="submit" name="submit" class="frame-child8"><span style="color:white; font-size:15px; margin-left:10px">Login</span></button>
      </form>
      <img class="tablerlogout-icon1" alt="" src="./public/tablerlogout.svg" />
    </div>
  </div>
  <script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    function getLocation() {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    }

    function showPosition(position) {
      document.querySelector('#latitude').value = position.coords.latitude;
      document.querySelector('#longitude').value = position.coords.longitude;
    }

    function showError(error) {
      console.log("showError() called");
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("You have denied the request for Geolocation. Please enable location access to proceed.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }

    getLocation();
  });
</script>
</body>

</html>
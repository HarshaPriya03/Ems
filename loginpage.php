<?php
@include 'inc/config.php';
session_start();

// Initialize login attempts if not set
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
        $_SESSION['email'] = $email;

        $module_sql = "SELECT module_name FROM modules INNER JOIN user_modules ON modules.id = user_modules.module_id WHERE user_modules.email = '$email'";
        $module_result = mysqli_query($con, $module_sql);

        $insertQuery = "INSERT INTO loggedin (empemail, loggedtime, device, browser, longitude, latitude) VALUES ('$email', NOW(), 'desktopapp', '" . $_SERVER['HTTP_USER_AGENT'] . "', '$longitude', '$latitude')";
        mysqli_query($con, $insertQuery);

        if ($row['user_type'] == 'acc') {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:Payroll/acc/acc_payroll.php');
            exit;
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['email'];
            header('location:employee-dashboard.php');
            exit;
        } elseif ($row['user_type'] == 'admin') {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:index.php');
            exit;
        } elseif ($row['manager_status'] == 1) {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:dash_mgr.php');
            exit;
        } elseif ($module_row = mysqli_fetch_assoc($module_result)) {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            $module_name = $module_row['module_name'];
            header("Location: $module_name");
            exit();
        } else {
            header('location:employee-dashboard.php');
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

  <link rel="stylesheet" href="./global.css" />
  <link rel="stylesheet" href="./loginpage.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location.href = "./mobileV/login-mob.php";
    }
  </script>
</head>

<body>
  <section class="loginpage">
    <div class="loginpage-child"></div>
    <div class="loginpage-item"></div>
    <div class="logo-1-group">
      <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

      <h3 class="login-to-your">Login to your account</h3>

      <label class="email-id1">Email ID</label>
      <label class="password1">Password</label>
      <form action="" class="loginForm" method="POST">

        <?php
        if (isset($error)) {
          foreach ($error as $error) {
            echo '<span style="color:white;">' . $error . '</span>';
          };
        };

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
          $prefilledEmail = $_GET['email'];
          echo "<input class='frame-child4' style='font-size: 30px;' id='email' value='$prefilledEmail' name='email' type='text' readonly required />";
        } else {
          echo "<input class='frame-child4' style='font-size: 30px;' id='email' name='email' type='text' required />";
        }
        ?>
        <input class="frame-child5" style="font-size: 30px;margin-left:100px;margin-top:200px;" type="hidden" id="longitude" name="longitude">

        <input class="frame-child5" style="font-size: 30px;margin-left:100px;margin-top:100px;" type="hidden" id="latitude" name="latitude">

        <input class="frame-child5" style="font-size: 30px;" name="password" type="password" required />

        <button  type="submit" name="submit" id="submitBtn" class="frame-child6" style="color:white; font-size:30px;"><span style="margin-left:30px;">Login</span></button>
        <!-- <button type="submit" name="submit" class="frame-child6" style="color:white; font-size:30px;"><span style="margin-left:30px;">Login</span></button> -->
        <img style="cursor:pointer;" class="tablerlogout-icon1" alt="" src="./public/tablerlogout1.svg" />
      </form>
    </div>
    <div class="rectangle-group">
      <div class="rectangle-div"></div>
      <div class="ellipse-div"></div>
      <div class="frame-child7"></div>
      <h1 class="anika-hrm1" id="anikaHRM">
        <span>Anika </span>
        <span class="hrm1">HRM</span>
      </h1>
      <img class="image-1-icon1" alt="" src="./public/image-1@2x.png" />

      <img class="pngfind-1-icon1" alt="" src="./public/pngfind-11@2x.png" />
    </div>
  </section>
  <!-- <script type="text/javascript">
    function getLocation() {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    }

    function showPosition(position) {
      document.querySelector('#latitude').value = position.coords.latitude;
      document.querySelector('#longitude').value = position.coords.longitude;

    }
    getLocation();
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
      return false;
    }
  </script> -->

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
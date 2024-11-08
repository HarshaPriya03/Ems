<?php
session_start();
@include 'inc/config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}
// Insert data into user_pages table for logging user activity
$page = basename($_SERVER['PHP_SELF']);
$empemail = $_SESSION['email'];
$sql_insert_page = "INSERT INTO user_pages (email, loggedtime, page, longitude, latitude) VALUES (?, NOW(), ?, ?, ?)";
$stmt_page = mysqli_prepare($con, $sql_insert_page);
$latitude = ''; // Set latitude
$longitude = ''; // Set longitude
mysqli_stmt_bind_param($stmt_page, "ssdd", $empemail, $page, $longitude, $latitude);
mysqli_stmt_execute($stmt_page);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$module_name = basename($_SERVER['PHP_SELF']);

// Sanitize module name to prevent directory traversal attacks
$module_name = mysqli_real_escape_string($con, $module_name);

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the module is linked to the user
$sql = "SELECT COUNT(*) AS count FROM user_modules INNER JOIN modules ON user_modules.module_id = modules.id INNER JOIN user_form ON user_modules.email = user_form.email WHERE user_form.email = '$email' AND modules.module_name = '$module_name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    // If the module is not linked to the user, redirect to the login page
    header("Location: loginpage.php");
    exit();
}

// Fetch all users
$sql_users = "SELECT * FROM user_form";
$result_users = mysqli_query($con, $sql_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Fetch all modules
$sql_modules = "SELECT * FROM modules";
$result_modules = mysqli_query($con, $sql_modules);
$modules = mysqli_fetch_all($result_modules, MYSQLI_ASSOC);

// Fetch user-module associations
$user_module_associations = array();
$sql_user_modules = "SELECT * FROM user_modules";
$result_user_modules = mysqli_query($con, $sql_user_modules);
while ($row = mysqli_fetch_assoc($result_user_modules)) {
    $user_module_associations[$row['email']][] = $row['module_id'];
}

// Fetch user types
$user_types = array();
$sql_user_types = "SELECT email, user_type FROM user_form WHERE user_type = 'user'";
$result_user_types = mysqli_query($con, $sql_user_types);
while ($row = mysqli_fetch_assoc($result_user_types)) {
    $user_types[$row['email']] = $row['user_type'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Modules Management</title>
    <link rel="stylesheet" href="css/dash.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #cacaca;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 12% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 60%;
      height: 60%;
    }

    .close {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 data" id="attendanceTable">
  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr>
      <th scope="col" class="px-6 py-3">
        empname
      </th>
      <th scope="col" class="px-6 py-3">
        page
      </th>
      <th scope="col" class="px-6 py-3">
        accessed time
      </th>
      <th scope="col" class="px-6 py-3">
        location
      </th>
    </tr>
  </thead>
  <?php
  $sql = "SELECT l.*, e.empname , e.pic
FROM user_pages l 
LEFT JOIN emp e ON l.email = e.empemail ORDER BY loggedtime DESC";

  $que = mysqli_query($con, $sql);
  $cnt = 1;
  while ($result = mysqli_fetch_assoc($que)) {
  ?>
    <tbody>
      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
          <img class="w-10 h-10 rounded-full" src="pics/<?php echo $result['pic']; ?>" alt="emppic">
          <div class="ps-3">
            <div class="text-base font-semibold"><?php echo $result['empname']; ?></div>
            <div class="font-normal text-gray-500"><?php echo $result['email']; ?></div>
          </div>
        </td>
        <td class="px-6 py-4">
          <span href="#" class="font-medium text-blue-600 dark:text-blue-500 "> <?php echo $result['page']; ?></a>
        </td>
        <td class="px-6 py-4">
          <div class="flex items-center">
            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
            <?php echo date('Y-m-d H:i:s', strtotime('+12 hours 30 minutes', strtotime($result['loggedtime']))); ?>
          </div>
        </td>
      
        <td class="px-6 py-4">
          <button style="margin-left:20px;" class="open-map-btn" data-src="https://www.google.com/maps?q=<?php echo $result['latitude']; ?>,<?php echo $result['longitude']; ?>&hl=es;z=10&output=embed"><img src="./public/Location.png" width="30px"/> </button>
        </td>


      </tr>
    </tbody>
  <?php
    $cnt++;
  }
  ?>
</table>
<div id="mapModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <iframe height=100% id="mapIframe" class="map-iframe" frameborder="0"></iframe>
  </div>
</div>
</div>
<script>
    // JavaScript to handle modal functionality
    document.addEventListener('DOMContentLoaded', function() {
      var modal = document.getElementById('mapModal');
      var btns = document.querySelectorAll('.open-map-btn');
      var iframe = document.getElementById('mapIframe');

      // When the button is clicked, open the modal and set iframe source
      btns.forEach(function(btn) {
        btn.onclick = function() {
          modal.style.display = "block";
          iframe.src = this.dataset.src;
        }
      });

      // When the user clicks on <span> (x), close the modal
      var span = document.getElementsByClassName("close")[0];
      span.onclick = function() {
        modal.style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    });
  </script>
</body>
</html>
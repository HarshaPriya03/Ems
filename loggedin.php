<?php
session_start();
@include 'inc/config.php';
$currentDate = date("Y-m-d");
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}


// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module name from the URL (assuming the module pages have a parameter in the URL)
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

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/onboarding.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <!-- <script>
function checkForUpdates() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    try {
                        var response = JSON.parse(xhr.responseText.replace(/(['"])?([a-zA-Z0-9_]+)(['"])?:/g, '"$2":'));

                        console.log(response);

                        if (response && response.hasUpdates) {
                            console.log('Reloading page...');
                            location.reload();
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response. Raw response:', xhr.responseText);
                        console.error('Error details:', error);
                    }
                } else {
                    console.error('Error in AJAX request. Status:', xhr.status);
                }
            }
        };

        xhr.open("GET", "getloggedin.php", true);
        xhr.send();
    }

    setInterval(checkForUpdates, 1000); 
</script> -->
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
  <div class="onboarding17">
    <div class="bg15"></div>
    <img class="onboarding-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="onboarding-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon15" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm15" href="./index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm15">HRM</span>
    </a>
    <a class="onboarding18" href="./index.php" id="onboarding">HR Management</a>
    <a class="onboarding18" style="margin-left: 300px;" href="./index.php" id="onboarding">/Users</a>
    <button class="onboarding-inner"></button>
    <div class="logout15">Logout</div>
    <a class="attendance15" id="attendance" href="./attendence.php">Attendance</a>
    <div class="payroll15">Payroll</div>
    <div class="reports15">Reports</div>
    <img class="uitcalender-icon15" alt="" src="./public/uitcalender.svg" />

    <img class="arcticonsgoogle-pay15" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon15" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />
    <img class="onboarding-child2" style="margin-top: -200px;" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard15" href="./index.php" id="dashboard" style="color: white;">Dashboard</a>
    <a class="fluentpeople-32-regular15" id="fluentpeople32Regular">
      <img class="vector-icon78" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list15" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard15" href="./index.php" id="akarIconsdashboard">
      <img class="vector-icon79" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon15" alt="" src="./public/tablerlogout.svg" />

    <a class="uitcalender15" id="uitcalender">
      <img class="vector-icon80" alt="" src="./public/vector4.svg" />
    </a>
    <a class="leaves15" id="leaves">Leaves</a>
    <a class="fluentperson-clock-20-regular15" id="fluentpersonClock20Regular">
      <img class="vector-icon81" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding19" style="color: black;" href="./onboarding.php">Onboarding</a>
    <a class="fluent-mdl2leave-user15">
      <img class="vector-icon82" alt="" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" src="./public/vector8.svg" />
    </a>
    <div class="container" style="margin-top:100px; margin-left: 600px;">
      <div class="row">
        <div class="col-md-8">
          <div class="input-group mb-3" style="width:400px">
            <input type="text" class="form-control input-text" id="filterInput" onkeyup="filterTable()" placeholder="Search for employee name...">
            <div class="input-group-append" style="background:white;">
              <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="rectangle-parent24" style="margin-top:40px; overflow-y:auto;">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 data" id="attendanceTable">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                empname
              </th>
              <th scope="col" class="px-6 py-3">
                device
              </th>
              <th scope="col" class="px-6 py-3">
                loggedin time
              </th>
              <th scope="col" class="px-6 py-3">
                browser
              </th>
              <th scope="col" class="px-6 py-3">
                location
              </th>
            </tr>
          </thead>
          <?php
          $sql = "SELECT l.*, e.empname , e.pic
    FROM loggedin l 
    LEFT JOIN emp e ON l.empemail = e.empemail ORDER BY loggedtime DESC";

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
                    <div class="font-normal text-gray-500"><?php echo $result['empemail']; ?></div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <?php
                  $device = $result['device'];
                  if ($device == "mobileapp") {
                    echo "Mobile";
                  } elseif ($device == "desktopapp") {
                    echo "Desktop";
                  } else {
                    echo $device;
                  }
                  ?>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                    <?php echo date('Y-m-d H:i:s', strtotime('+12 hours 30 minutes', strtotime($result['loggedtime']))); ?>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span href="#" class="font-medium text-blue-600 dark:text-blue-500 "> <?php echo $result['browser']; ?></a>
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




  <script>
    function filterTable() {
      var input = document.getElementById('filterInput');
      var filter = input.value.toUpperCase();

      var table = document.getElementById('attendanceTable');

      var rows = table.getElementsByTagName('tr');

      for (var i = 1; i < rows.length; i++) { // Start loop from index 1 to skip header row
        var cells = rows[i].getElementsByTagName('td');
        var shouldShow = false;

        for (var j = 0; j < cells.length; j++) {
          var cell = cells[j];
          var txtValue = cell.textContent || cell.innerText;

          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            shouldShow = true;
            break;
          }
        }

        if (shouldShow) {
          rows[i].style.display = '';
        } else {
          rows[i].style.display = 'none';
        }
      }
    }
  </script>

  <script>
    var anikaHRM = document.getElementById("anikaHRM");
    if (anikaHRM) {
      anikaHRM.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var onboarding = document.getElementById("onboarding");
    if (onboarding) {
      onboarding.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var attendance = document.getElementById("attendance");
    if (attendance) {
      attendance.addEventListener("click", function(e) {
        window.location.href = "./attendence.html";
      });
    }

    var dashboard = document.getElementById("dashboard");
    if (dashboard) {
      dashboard.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
    if (fluentpeople32Regular) {
      fluentpeople32Regular.addEventListener("click", function(e) {
        window.location.href = "./employee-management.php";
      });
    }

    var employeeList = document.getElementById("employeeList");
    if (employeeList) {
      employeeList.addEventListener("click", function(e) {
        window.location.href = "./employee-management.php";
      });
    }

    var akarIconsdashboard = document.getElementById("akarIconsdashboard");
    if (akarIconsdashboard) {
      akarIconsdashboard.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var uitcalender = document.getElementById("uitcalender");
    if (uitcalender) {
      uitcalender.addEventListener("click", function(e) {
        window.location.href = "./attendence.php";
      });
    }

    var leaves = document.getElementById("leaves");
    if (leaves) {
      leaves.addEventListener("click", function(e) {
        window.location.href = "./leave-management.php";
      });
    }

    var fluentpersonClock20Regular = document.getElementById(
      "fluentpersonClock20Regular"
    );
    if (fluentpersonClock20Regular) {
      fluentpersonClock20Regular.addEventListener("click", function(e) {
        window.location.href = "./leave-management.html";
      });
    }

    var akarIconsedit9 = document.getElementById("akarIconsedit9");
    if (akarIconsedit9) {
      akarIconsedit9.addEventListener("click", function(e) {
        window.location.href = "./employee-approval.html";
      });
    }
  </script>
</body>

</html>
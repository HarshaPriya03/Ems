<?php
session_start();
@include 'inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT user_type,user_type1 FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];

    if ($user_type1 !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
  } else {
    die("Error: Unable to fetch user details.");
  }
} else {
  die("Error: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
    }

    th,
    td {
      padding: 1em;
      border-bottom: 2px solid rgb(193, 193, 193);
    }

    .even {
      border-bottom: 2px solid #e8e8e8ba;
    }

    .odd {
      background-color: #e9e9e9 !important;
    }

    .dropbtn {
      background-color: #45C380;
      color: #ffffff;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px #45C380;
    }


    .dropdown-content {
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 98;
      max-height: 0;
      min-width: 160px;
      transition: max-height 0.15s ease-out;
      overflow: hidden;
    }

    .dropdown-content a {
      color: black;
      background-color: #f9f9f9;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #e2e2e2;
    }

    .dropdown:hover .dropdown-content {
      max-height: 500px;
      min-width: 160px;
      transition: max-height 0.25s ease-in;
    }

    .dropdown:hover .dropbtn {
      /* background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0; */
      transition: max-height 0.25s ease-in;
    }

    .container {
      padding-bottom: 20px;
      margin-right: 0px;
    }

    .input-text:focus {
      box-shadow: 0px 0px 0px;
      border-color: #fd7e14;
      outline: 0px;
    }

    .form-control {
      border: 1px solid #fd7e14;
    }
  </style>
  <script>
    function checkForUpdates() {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            try {
              var response = JSON.parse(xhr.responseText.replace(/(['"])?([a-zA-Z0-9_]+)(['"])?:/g, '"$2":'));

              console.log(response);

              if (response && response.hasUpdates) {
                console.log('Reloading page...');
                // Reload the page if updates are found
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

      xhr.open("GET", "getattendence.php", true);
      xhr.send();
    }

    setInterval(checkForUpdates, 1000);
  </script>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent22" style="margin-left:60px;">
      <div class="frame-child187"></div>
      <div class="dropdown">

      </div>
      <a href="attendence.php" class="frame-child188" style="margin-left: -150px; background-color:#e8e8e8"> </a>
      <a class="frame-child189" style="margin-left: -150px;" id="rectangleLink1"> </a>
      <a href="punchout.php" class="frame-child190" style="margin-left: -150px;" id="rectangleLink2"> </a>

      <a class="frame-child191" style="margin-left: -150px; background-color:#ffe2c6;width:190px;" id="rectangleLink3"> </a>
      <a class="my-attendence4" id="myAttendence" style="margin-left: -152px; margin-top:-4px; color:#ff5400;width:250px;">Break In/Out Log</a>
      <a class="attendence5" href="attendence.php" style="margin-left: -150px; margin-top:-4px; color:black;">Attendance</a>
      <a class="records5" id="records" style="margin-left: -150px; margin-top:-4px;">Check IN</a>
      <a class="punch-inout4" id="punchINOUT" style="margin-left: -128px; margin-top:-4px;">Check OUT</a>

      <a class="frame-child191" id="rectangleLink3" style="margin-left: 80px;"> </a>
      <a href="attendancelog.php" class="my-attendence4" id="myAttendence" style="margin-left: 87px; margin-top:-4px;">Attendance log</a>
    </div>
    <div class="container" style="margin-top:170px; margin-left:630px;">
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
    <div class="rectangle-parent23" style="overflow-y:auto; margin-top:40px;">
      <table class="data" id="attendanceTable" style="margin-left: auto; margin-right:auto;">
        <tr class='header-row'>
          <th></th>
          <th class='static-cell'>Date</th>
          <th class='static-cell' style="border-left: 2px solid rgb(182, 182, 182);"></th>
          <th class='static-cell'>Employee Name</th>
          <th class='static-cell' colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">BreakOut Time <span style="margin-left:80px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
          <th class='static-cell' colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">BreakIn Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
          <th class='static-cell' style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Duration</th>
        </tr>

        <?php
        $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
       FROM emp
       INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
       WHERE emp.empstatus = 0
       ORDER BY CamsBiometricAttendance.AttendanceTime DESC";

        $que = mysqli_query($con, $sql);
        $cnt = 1;
        $userBreakIn = array();
        $userEntriesCount = array();
        $prevDay = null;

        while ($result = mysqli_fetch_assoc($que)) {
          $userId = $result['UserID'];
          $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
          $formattedDate = date('D j M', strtotime($result['AttendanceTime']));
          $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

          if ($result['AttendanceType'] == 'BreakIn') {
            $userBreakIn[$userId] = array(
              'AttendanceTime' => $result['AttendanceTime'],
              'InputType' => $result['InputType'],
              'Department' => $result['dept']
            );
          } elseif ($result['AttendanceType'] == 'BreakOut') {
            $currentDay = date('j', strtotime($result['AttendanceTime']));
            $borderBottom = ($prevDay !== null && $currentDay !== $prevDay) ? 'border-top: 4px solid #FB8B0B;' : '';

            $breakOutAttendanceTime = strtotime($result['AttendanceTime']);
            $breakInAttendanceTime = strtotime($userBreakIn[$userId]['AttendanceTime']);
            $difference = $breakInAttendanceTime - $breakOutAttendanceTime;

            $hours = floor($difference / 3600);
            $minutes = floor(($difference % 3600) / 60);
            $seconds = $difference % 60;
            $timeDiffStyle = ($hours > 2 || ($hours == 2 && ($minutes > 0 || $seconds > 0))) ? 'color: red;' : 'color: green;';
    
            $timeDiff = "";
            if ($hours > 0) {
                $timeDiff .= "$hours hrs ";
            }
            if ($minutes > 0) {
                $timeDiff .= "$minutes mins ";
            }
            if ($seconds > 0) {
                $timeDiff .= "$seconds secs";
            }
    
            ?>
            <tr class="<?php echo $rowColorClass; ?>" style="<?php echo $borderBottom; ?>">
              <td></td>
              <td style="white-space:nowrap;"><?php echo $formattedDate; ?></td>
              <td style="border-left: 2px solid rgb(182, 182, 182);">
                <img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);">
              </td>
              <td><?php echo $result['empname']; ?></td>
              <td style="border-left: 2px solid rgb(182, 182, 182);">
                <?php echo $result['AttendanceTime']; ?>
              </td>
              <td><?php echo $result['InputType']; ?></td>
              <td style="border-left: 2px solid rgb(182, 182, 182);">
                <?php
                if (isset($userBreakIn[$userId])) {
                  echo $userBreakIn[$userId]['AttendanceTime'];
                } else {
                  echo '<span style="color: red !important;">Yet to Break In!</span>';
                }
                ?>
              </td>
              <td>
                <?php
                if (isset($userBreakIn[$userId])) {
                  echo $userBreakIn[$userId]['InputType'];
                } else {
                  echo '<span style="color: red !important;">Yet to Break In!</span>';
                }
                ?>
              </td>
              <td style="border-left: 2px solid rgb(182, 182, 182);<?php echo $timeDiffStyle; ?>">
                <?php echo $timeDiff; ?>
              </td>
            </tr>
        <?php
            $prevDay = $currentDay;
          }
          $cnt++;
        }
        ?>

      </table>



    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm14" href="./index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.php" id="attendenceManagement">Attendance Management</a>
    <button class="attendence-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
    <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll14">Payroll</a>
    <div class="reports14">Reports</div>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

    <!--<img class="attendence-child1" alt="" src="./public/ellipse-1@2x.png" />-->

    <!--<img-->
    <!--  class="material-symbolsperson-icon14"-->
    <!--  alt=""-->
    <!--  src="./public/materialsymbolsperson.svg"-->
    <!--/>-->

    <img class="attendence-child2" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="./index.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
      <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" href="./index.php" id="akarIconsdashboard">
      <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
      <img class="vector-icon75" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" id="onboarding">Onboarding</a>
    <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
      <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14">Attendance</a>
    <a class="uitcalender14">
      <img class="vector-icon77" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>
  <script>
    function filterTable() {
      var input = document.getElementById('filterInput');
      var filter = input.value.toUpperCase();

      var table = document.getElementById('attendanceTable');

      var rows = table.getElementsByTagName('tr');

      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var shouldShow = false;

        if (i === 0) {
          shouldShow = true;
        } else {
          for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            var isHeaderCell = cell.classList.contains('static-cell');

            if (!isHeaderCell) {
              var txtValue = cell.textContent || cell.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                shouldShow = true;
                break;
              }
            }
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
    var rectangleLink1 = document.getElementById("rectangleLink1");
    if (rectangleLink1) {
      rectangleLink1.addEventListener("click", function(e) {
        window.location.href = "./punch-i-n.php";
      });
    }

    var rectangleLink2 = document.getElementById("rectangleLink2");
    if (rectangleLink2) {
      rectangleLink2.addEventListener("click", function(e) {
        window.location.href = "./punch-i-n.php";
      });
    }

    var rectangleLink3 = document.getElementById("rectangleLink3");
    if (rectangleLink3) {
      rectangleLink3.addEventListener("click", function(e) {
        window.location.href = "./my-attendence.php";
      });
    }

    var records = document.getElementById("records");
    if (records) {
      records.addEventListener("click", function(e) {
        window.location.href = "./punch-i-n.php";
      });
    }

    var punchINOUT = document.getElementById("punchINOUT");
    if (punchINOUT) {
      punchINOUT.addEventListener("click", function(e) {
        window.location.href = "./punchout.php";
      });
    }

    var myAttendence = document.getElementById("myAttendence");
    if (myAttendence) {
      myAttendence.addEventListener("click", function(e) {
        window.location.href = "./my-attendence.php";
      });
    }

    var anikaHRM = document.getElementById("anikaHRM");
    if (anikaHRM) {
      anikaHRM.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var attendenceManagement = document.getElementById("attendenceManagement");
    if (attendenceManagement) {
      attendenceManagement.addEventListener("click", function(e) {
        window.location.href = "./index.php";
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
        window.location.href = "./leave-management.php";
      });
    }

    var onboarding = document.getElementById("onboarding");
    if (onboarding) {
      onboarding.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
    if (fluentMdl2leaveUser) {
      fluentMdl2leaveUser.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }
  </script>
</body>

</html>
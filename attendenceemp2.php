<?php
@include 'inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
if (isset($_GET['redirect'])) {
  // Assuming you have retrieved the department value from the 'emp' table
  $result = mysqli_query($con, "SELECT desg FROM emp WHERE empemail = '{$_SESSION['user_name']}'");
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (!empty($rows)) {
      $department = $rows[0]['desg']; // Access the first row and the 'dept' column
      if ($department === 'SECURITY GAURDS') {
          header("Location: sheet_emp_g.php");
          exit();
      } else {
          header("Location: sheet_emp.php");
          exit();
      }
  } else {
      // Handle the case when no rows are returned
      echo "No department found.";
  }
}


$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
  ?>
<!DOCTYPE html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
       <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
         table {
        z-index: 100;
  border-collapse: collapse;
  background-color: white;
}

th, td {
  padding: 1em;
  border-bottom: 2px solid rgb(193, 193, 193); 
}
.even {
  border-bottom: 2px solid #e8e8e8ba; 
    }

    .odd {
        background-color: #e9e9e9 !important; 
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
      transition: max-height 0.25s ease-in;
    }

    .mgr-view{
          margin-top:-600px;
          margin-left:-20px;
          color:white;
          font-size:20px;
        }
       
        .attendence-inner {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .attendence-inner svg {
            flex-shrink: 0;
        }

        .attendence-inner span {
            margin-left: 5px;
        }
        .attendence-inner span{
          white-space: nowrap;
        }
    </style>
    <script>
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
    <div class="attendence4" style="margin-left:auto;margin-right:auto;">
      <div class="bg14"></div>
      <div class="rectangle-parent22" style="margin-left:200px;">
        <div class="frame-child187"></div>
            <a class="frame-child188"> </a>

            <div class="dropdown">
        <button class="attendence5" style="margin-left: -300px; border: none; background: none; margin-top: -14px;" for="btnControl"><img src="./public/9710841.png" width="50px" alt="">
          <div class="dropdown-content" style="margin-left: -40px; border-radius: 20px;">
<a href="remote_work_emp.php" >Remote Work</a>
          </div>
        </button>
      </div>

        <a class="attendence5">Attendance</a>
    <a class="frame-child191" id="rectangleLink3" style="margin-left: -450px;"> </a>
        <a href="attendanceemp.php" class="my-attendence4" id="myAttendence" style="margin-left: -450px;">Attendance log</a>

<a class="frame-child191" id="rectangleLink3" href="?redirect=true" target="_blank" style="margin-left: -200px;"></a>
<a href="?redirect=true" class="my-attendence4" id="myAttendence" target="_blank" style="margin-left: -205px; margin-top:2px; font-size:18px; width:200px">Monthly Attendance</a>
      </div>
      <div class="rectangle-parent23" style="overflow-y:auto;">
      <?php
      function getColorForCheckOut($checkOutInfo)
      {
        $outTimeColor = 'color: red !important;';
        $outTimeColor1 = 'color: green !important;';

        if ($checkOutInfo['Department'] == 'HOUSE KEEPING' || $checkOutInfo['Department'] == 'KITCHEN') {
          // Check if the time is beyond 5:30 PM
          if (strtotime($checkOutInfo['AttendanceTime']) >= strtotime('5:30 PM', strtotime($checkOutInfo['AttendanceTime']))) {
            $outTimeColor = 'color: green !important;';
          } else {
            $outTimeColor1 = 'color: red !important;';
          }
        } else {
          // For other departments, check if the time is beyond 6:00 PM
          if (strtotime($checkOutInfo['AttendanceTime']) >= strtotime('6:00 PM', strtotime($checkOutInfo['AttendanceTime']))) {
            $outTimeColor = 'color: green !important;';
          } else {
            $outTimeColor1 = 'color: red !important;';
          }
        }

        // Return both colors as an array
        return array($outTimeColor, $outTimeColor1);
      }
      ?>
      <table class="data" style="margin-left: auto; margin-right:auto;">
    <tr>
        <th>Date</th>
        <th style="border-left: 2px solid rgb(182, 182, 182);"></th>
        <th>Employee Name</th>
        <th colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
        <th colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
    </tr>

    <?php
 $user_name = $_SESSION['user_name'];
 $sql = "SELECT serviceTagId FROM emp WHERE empemail = '$user_name'";
 $result = $con->query($sql);
 
 if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     $serviceTagId = $row['serviceTagId'];
 
     // Determine the table name based on serviceTagId
     if ($serviceTagId == 'ZXQI19009096') {
         $tableName = 'CamsBiometricAttendance';
     } elseif ($serviceTagId == 'ZYSA07001899') {
         $tableName = 'CamsBiometricAttendance_GGM';
     } else {
         die("No attendance table associated with this serviceTagId.");
     }
 
     // Retrieve attendance records from the determined table
     $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, $tableName.*
             FROM emp
             INNER JOIN $tableName ON emp.UserID = $tableName.UserID
             WHERE emp.empemail = '$user_name'
             ORDER BY $tableName.AttendanceTime DESC";

    $que = mysqli_query($con, $sql);
    $cnt = 1;

    $userCheckOut = array();
    $prevDay = null;

    while ($result = mysqli_fetch_assoc($que)) {
        $userId = $result['UserID'];
        $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
        $formattedDate = date('D j M', strtotime($result['AttendanceTime']));
        $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

        if ($result['AttendanceType'] == 'CheckOut') {
            $userCheckOut[$userId] = array(
                'AttendanceTime' => $result['AttendanceTime'],
                'InputType' => $result['InputType'],
                'Department' => $result['dept']
            );
        } elseif ($result['AttendanceType'] == 'CheckIn') {
            $currentDay = date('j', strtotime($result['AttendanceTime']));
            $borderBottom = ($prevDay !== null && $currentDay !== $prevDay) ? 'border-top: 4px solid #FB8B0B;' : '';

            $inTimeColor = (strtotime($result['AttendanceTime']) > strtotime('9:40 AM', strtotime($result['AttendanceTime']))) ? 'color: red !important;' : 'color: green !important;';

            $outTimeColors = isset($userCheckOut[$userId]) ? getColorForCheckOut($userCheckOut[$userId]) : array('color: red !important;', 'color: red !important;');
            $outTimeColor = $outTimeColors[0];

            ?>
            <tr class="<?php echo $rowColorClass; ?>" style="<?php echo $borderBottom; ?>">
                <td style="white-space:nowrap;"><?php echo $formattedDate; ?></td>
                <td style="border-left: 2px solid rgb(182, 182, 182);"><img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td>
                <td><?php echo $result['empname']; ?></td>

                <td style="border-left: 2px solid rgb(182, 182, 182); <?php echo $inTimeColor; ?>">
                    <?php echo $result['AttendanceTime']; ?>
                </td>
                <td>
                    <?php echo $result['InputType']; ?>
                </td>
                <td style="border-left: 2px solid rgb(182, 182, 182); <?php echo $outTimeColor; ?>">
                    <?php
                    if (isset($userCheckOut[$userId])) {
                        echo $userCheckOut[$userId]['AttendanceTime'];
                    } else {
                        echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($userCheckOut[$userId])) {
                        echo $userCheckOut[$userId]['InputType'];
                    } else {
                        echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                </td>
            </tr>
            <?php
} else {
  echo "";
}
 $currentDay = date('j', strtotime($result['AttendanceTime']));
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

      <a class="anikahrm14" href="./employee-dashboard.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm14">HRM</span>
      </a>
      <a
        class="attendence-management4"
        href="./employee-dashboard.php"
        id="attendenceManagement"
        >Attendance Management</a
      >
      <?php

$select = "SELECT uf.*, m.status as manager_status 
FROM user_form uf
LEFT JOIN manager m ON uf.email = m.email 
WHERE uf.email = ?";

$stmt = mysqli_prepare($con, $select);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$_SESSION['user_name'] = $row['email'];
$_SESSION['admin_name'] = $row['name'];

$manager_status = $row['manager_status'];
} else {
// Handle case where user is not found
echo "User not found";
exit;
}

    $email1 = $row['email'];

    $sql = "SELECT * FROM user_form WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      $user_type = $row['user_type'];
      $user_type1 = $row['user_type1'];

      $is_enabled = ($user_type == 'user' && $user_type1 == 'admin');
    } else {
      $is_enabled = false;
    }
    ?>
    <?php
    if ($is_enabled) {
    ?>
      <a style="height:25px;width:110px;text-decoration:none;" href="index.php"  class="attendence-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>HR View</span>
        </a>
        <?php
    }?>
      <?php if ($manager_status == 1): ?>
        <a style="margin-top:-545px;height:20px;text-decoration:none;width:155px;" href="dash_mgr.php"  class="attendence-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>Manager View</span>
        </a>
        <?php endif; ?>
      <button class="attendence-inner"><a  href="logout.php" style="margin-left:25px; color:white; text-decoration:none; font-size:25px">Logout</a></button>
      <!--<div class="logout14">Logout</div>-->
      <a style="margin-top: -35px; text-decoration:none; color:black;" href="card.php" class="payroll14">Directory</a>
      <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

      <img style="margin-top: -35px;"
        class="arcticonsgoogle-pay14"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <!--<img class="attendence-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon14"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img style="margin-top: -50px;" class="attendence-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard14" style="margin-top: 60px;" href="./employee-dashboard.php" id="dashboard">Dashboard</a>
      <a style="margin-top: 60px;"
        class="akar-iconsdashboard14"
        href="./employee-dashboard.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon74" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

      <a class="leaves14" id="leaves" href="apply-leave-emp.php">Leaves</a>
      <a
        class="fluentperson-clock-20-regular14"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon75" alt="" src="./public/vector1.svg" />
      </a>
      <a style="margin-top: -50px;" class="attendance14">Attendance</a>
      <a style="margin-top: -50px;" class="uitcalender14">
        <img class="vector-icon77" alt="" src="./public/vector11.svg" />
      </a>
      <div class="oouinext-ltr3"></div>
    </div>

    <script>
      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var rectangleLink2 = document.getElementById("rectangleLink2");
      if (rectangleLink2) {
        rectangleLink2.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function (e) {
          window.location.href = "./attendanceemp.php";
        });
      }
      
      var records = document.getElementById("records");
      if (records) {
        records.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var punchINOUT = document.getElementById("punchINOUT");
      if (punchINOUT) {
        punchINOUT.addEventListener("click", function (e) {
          window.location.href = "./punchout.php";
        });
      }
      
      var myAttendence = document.getElementById("myAttendence");
      if (myAttendence) {
        myAttendence.addEventListener("click", function (e) {
          window.location.href = "./attendanceemp.php";
        });
      }
      
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var attendenceManagement = document.getElementById("attendenceManagement");
      if (attendenceManagement) {
        attendenceManagement.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var leaves = document.getElementById("leaves");
      if (leaves) {
        leaves.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      </script>
  </body>
</html>
<?php
} else {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
?>
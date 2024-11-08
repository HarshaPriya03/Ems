<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Login Again, if your still facing issues Contact HR!',
            }).then(function() {
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
  exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/attendenceemp-mob.css" />
    <link rel="stylesheet" href="./empmobcss/empjob-details-mob.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
     table {
       border: 0;
       width: 100%;
       margin: 0;
       padding: 0;
       border-collapse: collapse;
       border-spacing: 0;
       box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
     }
     table thead {
       background: #F0F0F0;
       height: 60px !important;
     }
     table thead tr th:first-child {
       padding-left: 45px;
     }
     table thead tr th {
       text-transform: uppercase;
       line-height: 60px !important;
       text-align: left;
       font-size: 11px;
       padding-top: 0px !important;
       padding-bottom: 0px !important;
     }
     table tbody {
       background: #fff;
     }
     table tbody tr {
       border-top: 1px solid #e5e5e5;
       height: 60px;
     }
     table tbody tr td:first-child {
       padding-left: 45px;
     }
     table tbody tr td {
       height: 60px;
       line-height: 60px !important;
       text-align: left;
       padding: 0 10px;
       font-size: 14px;
     }
     table tbody tr td i {
       margin-right: 8px;
     }
     
     @media screen and (max-width: 850px) {
       table {
         border: 1px solid transparent;
         box-shadow: none;
       }
       table thead {
         display: none;
       }
       table tbody tr {
         border-bottom: 20px solid #F6F5FB;
       }
       table tbody tr td:first-child {
         padding-left: 10px;
       }
       table tbody tr td:before {
         content: attr(data-label);
         float: left;
         font-size: 10px;
         text-transform: uppercase;
         font-weight: bold;
       }
       table tbody tr td {
         display: block;
         text-align: right;
         font-size: 14px;
         padding: 0px 10px !important;
         box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
       }
     }
     .logo-1-icon10 {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 55px;
  height: 55px;
  object-fit: cover;
}
.dropdown-content1 {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 80px;
      margin-left:-25px;
      margin-top:25px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-content1 a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content1 a:hover {
      background-color: #f1f1f1;
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

        xhr.open("GET", "../getattendence.php", true);
        xhr.send();
    }

    setInterval(checkForUpdates, 1000); 
</script>
  </head>
  <body>
    <div class="attendenceemp-mob" style="height: 100svh;">
      <div class="logo-1-group">
        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="attendance-management" style="width: 300px;">Attendance Management</a>
      </div>
        <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
      <div class="attendenceemp-mob-child"></div>
      <div class="attendenceemp-mob-item"></div>
      <div class="rectangle-parent">
        <a class="frame-item"> </a>
        <a class="frame-inner" href="./attendancelogemp-mob.php"> </a>

        <div class="dropdown">
  <a class="attendance" id="salary" href="javascript:void(0)">Attendance</a>
  <div class="dropdown-content1" id="dropdown-content1">
    <a href="./remote_work_emp.php">Remote Attendance</a>
  </div>
</div>

        <a class="punch-inout" href="./attendancelogemp-mob.php" style="width: 100px; margin-left: -5px;">Attendance Log</a>
        <a class="rectangle-a" href="monthly-attendance-emp.php" style="width: 100px;"> </a>
        <a class="my-attendance" href="monthly-attendance-emp.php" style="width: 100px; margin-left: -1px;">Monthly Attendance</a>
    
      </div>
      <div class="rectangle-parent23" style="margin-top: 20px;">
      <table class="data">
      <thead>
    <tr>
      <th >Date</th>
        <th style="border-left: 2px solid rgb(182, 182, 182);"></th>
        <th>Employee Name</th>
             <th colspan="2" style="white-space:nowrap;">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
        <th colspan="2" style="white-space:nowrap;">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
    </tr>
  </thead>
    <?php
function getColorForCheckOut($checkOutInfo) {
    $outTimeColor = 'color: red !important;';
    $outTimeColor1 = 'color: green !important;';

    if ($checkOutInfo['Department'] == 'Cleaning') {
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
                <td data-label="Date" style="white-space:nowrap;"><?php echo $formattedDate; ?></td>
                <!-- <td style="border-left: 2px solid rgb(182, 182, 182);"><img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td> -->
                <td data-label="Employee Name"> <?php
                $empname = $result['empname'];
                echo strlen($empname) > 22 ? substr($empname, 0, 22) . '...' : $empname;
            ?></td>

                <td data-label="In Time" style=" <?php echo $inTimeColor; ?>">
                    <?php echo $result['AttendanceTime']; ?>
                </td>
                <td data-label="In Input-Type">
                    <?php echo $result['InputType']; ?>
                </td>
                <td data-label="Out Time" style=" <?php echo $outTimeColor; ?>">
                    <?php
                    if (isset($userCheckOut[$userId])) {
                        echo $userCheckOut[$userId]['AttendanceTime'];
                    } else {
                        echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                </td>
                <td data-label="out Input-Type">
                    <?php
                    if (isset($userCheckOut[$userId])) {
                        echo $userCheckOut[$userId]['InputType'];
                    } else {
                        echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                </td>
            </tr>
  </tbody>
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
      <div class="arcticonsgoogle-pay-parent">
        <img
          class="arcticonsgoogle-pay1"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="ellipse-div"></div>
        <a class="akar-iconsdashboard1" id="akarIconsdashboard">
          <img class="vector-icon3" alt="" src="./public/vector1dash.svg" />
        </a>
        <a
          class="fluentperson-clock-20-regular1"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon4"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender1">
          <img
            class="vector-icon5"
            alt=""
            src="./public/vector3@2xattenblack.png"
          />
        </a>
      </div>
    </div>
    <script>
  document.getElementById('salary').addEventListener('click', function(event) {
    event.preventDefault();
    var dropdownContent = document.getElementById('dropdown-content1');
    if (dropdownContent.style.display === 'block') {
      dropdownContent.style.display = 'none';
    } else {
      dropdownContent.style.display = 'block';
    }
  });

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('#salary')) {
      var dropdowns = document.getElementsByClassName('dropdown-content1');
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.style.display === 'block') {
          openDropdown.style.display = 'none';
        }
      }
    }
  }
</script>
    <script>
      var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
      if (arcticonsgooglePay) {
        arcticonsgooglePay.addEventListener("click", function (e) {
          window.location.href = "./directoryemp-mob.php";
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./emp-dashboard-mob.php";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./apply-leaveemp-mob.php";
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
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
  exit();
}
?>
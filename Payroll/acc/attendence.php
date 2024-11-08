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

$query = "SELECT user_type FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type'])) {
    $user_type = $row['user_type'];

    if ($user_type !== 'admin') {
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

  <link rel="stylesheet" href="../../css/global.css" />
  <link rel="stylesheet" href="../../css/attendence.css" />
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

    .remove {
      display: none;
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

    #rowCountSelectTh,
    .checkboxTd {
      display: none;
    }
  </style>
  <script>
    function toggleElements() {

      var button = document.getElementById('viewButton');
      var rowCountSelectTh = document.getElementById("rowCountSelectTh");
      var checkboxTds = document.querySelectorAll(".checkboxTd");

      if (rowCountSelectTh.style.display === "none") {
        rowCountSelectTh.style.display = "table-cell";
        checkboxTds.forEach(function(td) {
          td.style.display = "table-cell";
        });
        document.getElementById('submitid').classList.remove('remove');
        button.textContent = "Hide";
      } else {
        rowCountSelectTh.style.display = "none";
        checkboxTds.forEach(function(td) {
          td.style.display = "none";
        });
        document.getElementById('submitid').classList.add('remove');
        button.textContent = "View";
      }
    }
    document.addEventListener("DOMContentLoaded", function() {
      toggleElements();
    });

    function toggleCheckboxes() {
      var rowCountSelect = document.getElementById("rowCountSelect");
      var checkboxes = document.querySelectorAll("#attendanceTable tbody input[type='checkbox']");
      var rowCount = parseInt(rowCountSelect.value);
      var checkedCount = 0;

      checkboxes.forEach(function(checkbox, index) {
        if (index < rowCount) {
          checkbox.checked = true;
          checkedCount++;
        } else {
          checkbox.checked = false;
        }
      });
    }
  </script>

</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <!--<div class="rectangle-parent22" style="margin-left:60px;">-->
    <!--  <div class="frame-child187"></div>-->
    <!--  <div class="dropdown">-->
    <!--    <button class="attendence5" style="margin-left: -300px; border: none; background: none; margin-top: -14px;" for="btnControl"><img src="../public/9710841.png" width="50px" alt="">-->
    <!--      <div class="dropdown-content" style="margin-left: -40px; border-radius: 20px;">-->
    <!--        <a href="markabsent.php" style="border-bottom: 1px solid rgb(185, 185, 185); font-size:15px;">Mark Absent</a>-->
    <!--        <a href="phistory.php" style="border-bottom: 1px solid rgb(185, 185, 185); font-size:15px;">Permission History</a>-->
    <!--        <a href="sheet.php" style="border-bottom: 1px solid rgb(185, 185, 185); font-size:15px;">Overall Attendance</a>-->
    <!--        <a style="font-size:15px;" href="sheet_gaurd.php">Overall Attendance(SG)</a>-->
    <!--      </div>-->


    <!--    </button>-->
    <!--  </div>-->
    <!--  <a class="frame-child188" style="margin-left: -150px;"> </a>-->
    <!--  <a class="frame-child188" style="margin-left:400px; width:240px; height:40px; margin-top:77px; border-radius:10px;"> </a>-->
    <!--  <a href="attendence_gaurd.php" target="_blank" class="attendence5" style="margin-left:375px; width:250px; margin-top:71px; font-size:16px;">Security Gaurd's Attendance</a>-->
    <!--  <a class="frame-child189" style="margin-left: -150px;" id="rectangleLink1"> </a>-->
    <!--  <a href="punchout.php" class="frame-child190" style="margin-left: -150px;" id="rectangleLink2"> </a>-->

    <!--  <a class="frame-child191" style="margin-left: -150px;" id="rectangleLink3"> </a>-->
    <!--  <a class="attendence5" style="margin-left: -150px; margin-top:-4px;">Attendance</a>-->
    <!--  <a class="records5" id="records" style="margin-left: -150px; margin-top:-4px;">Check IN</a>-->
    <!--  <a class="punch-inout4" id="punchINOUT" style="margin-left: -128px; margin-top:-4px;">Check OUT</a>-->
    <!--  <a class="my-attendence4" id="myAttendence" style="margin-left: -150px; margin-top:-4px; width:200px;">Break In/Out Log</a>-->
    <!--  <a class="frame-child191" id="rectangleLink3" style="margin-left: 80px;"> </a>-->
    <!--  <a href="attendancelog.php" class="my-attendence4" id="myAttendence" style="margin-left: 87px; margin-top:-4px;">Attendance log</a>-->
    <!--</div>-->
    <div class="container" style="margin-top:100px; margin-left:630px;">
      <div class="row">
        <div class="col-md-8">
          <div class="input-group mb-3" style="width:400px">
            <input type="text" class="form-control input-text" id="filterInput" onkeyup="filterTable()" placeholder="Search for employee name...">
            <div class="input-group-append" style="background:white;">
              <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
            </div>
            <button class="remove" id="submitid" onclick="submitAttendanceData()" style="border:none; background-color:#ffe3c6; color:#ff5400; font-size:18px; border-radius:10px; width:80px; height:40px; position:absolute; left:-150px;">Submit</button>
            <button id="viewButton" onclick="toggleElements()" style="border:none; background-color:#ffe3c6; color:#ff5400; font-size:18px; border-radius:10px; width:80px; height:40px; position:absolute; left:-240px;">View</button>
          </div>

        </div>
      </div>
    </div>
    <div class="rectangle-parent23" style="overflow-y:auto; margin-top:-20px; margin-left:-40px; width:78%;">
      <table class="data" id="attendanceTable">
        <tr class='header-row'>
          <th id="rowCountSelectTh">
            <select id="rowCountSelect" onchange="toggleCheckboxes()">
              <option>Select</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
            </select>
          </th>

          <th class='static-cell'>Date</th>
          <th class='static-cell' style="border-left: 2px solid rgb(182, 182, 182);"></th>
          <th class='static-cell'>Employee Name</th>
          <th class='static-cell' colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
          <th class='static-cell' colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
          <th style="border-left: 2px solid rgb(182, 182, 182);">Total Hrs</th>
          <th style="border-left: 2px solid rgb(182, 182, 182);">Actual Working Hrs</th>
        </tr>

        <?php
        $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
FROM emp
INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
WHERE emp.empstatus = 0
AND emp.desg != 'SECURITY GAURDS'
ORDER BY CamsBiometricAttendance.AttendanceTime DESC";

        $que = mysqli_query($con, $sql);
        $cnt = 1;
        $userCheckOut = array();
        $userEntriesCount = array();
        $prevDay = null;
        $showDiscrepancyDiv = false;

        while ($result = mysqli_fetch_assoc($que)) {
          $userId = $result['UserID'];
          $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
          $formattedDate = date('D j M', strtotime($result['AttendanceTime']));
          $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

          $showWarningSVG = false;

          if ($dayOfMonth == date('j')) {
            if ($result['AttendanceType'] == 'CheckIn' && !isset($userEntriesCount[$userId][$dayOfMonth])) {
              $userEntriesCount[$userId][$dayOfMonth] = 1;
            } elseif ($result['AttendanceType'] == 'CheckIn') {
              $userEntriesCount[$userId][$dayOfMonth]++;
              $showWarningSVG = true;
            }
          }

          if ($result['AttendanceType'] == 'CheckOut') {
            $userCheckOut[$userId] = array(
              'AttendanceTime' => $result['AttendanceTime'],
              'InputType' => $result['InputType'],
              'Department' => $result['dept']
            );
          } elseif ($result['AttendanceType'] == 'CheckIn') {
            $currentDay = date('j', strtotime($result['AttendanceTime']));
            $borderBottom = ($prevDay !== null && $currentDay !== $prevDay) ? 'border-top: 4px solid #FB8B0B;' : '';

            $inTimeColor = (strtotime($result['AttendanceTime']) > strtotime('9:40 AM', strtotime($result['AttendanceTime']))) ? 'color: red !important;' : 'color: green !important';

            $outTimeColors = isset($userCheckOut[$userId]) ? getColorForCheckOut($userCheckOut[$userId]) : array('color: red !important;', 'color: red !important');
            $outTimeColor = $outTimeColors[0];

            if ($result['AttendanceType'] == 'CheckIn' && $showWarningSVG) {
              $showDiscrepancyDiv = true;
            }

        ?>
            <tr class="<?php echo $rowColorClass; ?>" style="<?php echo $borderBottom; ?>">
              <td class="checkboxTd">
                <input type="checkbox" name="rowCheckbox[]" />
              </td>
              <td style="white-space:nowrap;"><?php echo $formattedDate; ?></td>
              <td style="border-left: 2px solid rgb(182, 182, 182);"><img class="hovpic" src="../../pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td>
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

              <td style="border-left: 2px solid rgb(182, 182, 182); width:130px;white-space:nowrap;">
                <?php
                $empname = $result['empname'];

                $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

                $result_dept = $con->query($sql); // Renamed $result to $result_dept to avoid variable conflict

                if ($result_dept->num_rows > 0) {
                  while ($row = $result_dept->fetch_assoc()) {
                    // Convert fromshifttime1 and toshifttime1 to DateTime objects
                    $fromShiftTime = new DateTime($row['fromshifttime1']);
                    $toShiftTime = new DateTime($row['toshifttime1']);

                    // Calculate the difference between the times
                    $interval = $fromShiftTime->diff($toShiftTime);

                    // Format the difference
                    $duration = $interval->format('%s'); // Store duration in seconds
                  }
                } else {
                  echo "No designation found for this employee";
                }
                ?>

                <?php
                if (isset($userCheckOut[$userId])) {
                  $inTime = strtotime($result['AttendanceTime']);
                  $outTime = strtotime($userCheckOut[$userId]['AttendanceTime']);

                  // Calculate the difference in seconds
                  $secondsDiff = $outTime - $inTime;

                  // Calculate hours and minutes
                  $hours = floor($secondsDiff / 3600);
                  $minutes = floor(($secondsDiff % 3600) / 60);
                  $durationMinutes = $interval->h * 60 + $interval->i;
                  $totalMinutes = $hours * 60 + $minutes;
                  $difference = $durationMinutes - $totalMinutes;

                  if (($hours * 60 + $minutes) < $durationMinutes) {
                    echo '<span style="color: red;">' . $hours . ' hrs ' . $minutes . ' mins</span>';
                    $differenceHours = floor($difference / 60);
                    $differenceMinutes = $difference % 60;
                    echo '<br><span style="color: red;">[-' . $differenceHours . ' hrs ' . $differenceMinutes . ' mins]</span>';
                  } elseif (($hours * 60 + $minutes) > 720) {
                    echo '<span title="12 Hrs exceeded"><img src="../public/warn.png" width=40px>' . $hours . ' hrs ' . $minutes . ' mins</span>';
                  } else {
                    echo '<span style="color: green;">' . $hours . ' hrs ' . $minutes . ' mins</span>';
                  }
                } else {
                  $timeInput = strtotime($result['AttendanceTime']);
                  $origin = new DateTime(date('Y-m-d H:i:s', $timeInput));
                  $target = new DateTime(); // Current time
                  $target->modify('+5 hours 30 minutes');
                  $interval = $origin->diff($target);
                  if ($interval->h > 10) {
                    echo '<span title="12 Hrs exceeded"><img src="../public/warn.png" width=40px></span>';
                  }
                  echo $interval->format('%h hrs %i mins') . PHP_EOL;
                }
                ?>
              </td>



              <td style="border-left: 2px solid rgb(182, 182, 182);">
                <?php
                $empname = $result['empname'];

                $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    // Convert fromshifttime1 and toshifttime1 to DateTime objects
                    $fromShiftTime = new DateTime($row['fromshifttime1']);
                    $toShiftTime = new DateTime($row['toshifttime1']);

                    // Calculate the difference between the times
                    $interval = $fromShiftTime->diff($toShiftTime);

                    // Format the difference
                    $duration = $interval->format('%h hrs %i mins');

                    echo '<span style="color:green;">' . $duration . '</span>';
                  }
                } else {
                  echo "No designation found for this employee";
                }
                ?>
              </td>



            </tr>
        <?php
            $prevDay = $currentDay;
          }
          $cnt++;
        }
        ?>
      </table>
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



    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />

    <a class="anikahrm14" href="../../index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <a href="../../logout.php" style="margin-top:-5px;" class="logout14">Logout</a>
    <a class="payroll14" href="./acc_payroll.php" style="text-decoration:none; color:black; z-index:9999; margin-top:-200px">Payroll</a>
    <div class="reports14" style="margin-top:-70px;">Reports</div>
    <img class="uitcalender-icon14" alt="" src="../public/uitcalender.svg" />

    <img style=" z-index:9999; margin-top:-200px" class="arcticonsgoogle-pay14" alt="" src="../public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" style="margin-top:-70px;" alt="" src="../public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

  

    <img class="attendence-child2" alt="" style="margin-top: 0px;" src="../public/rectangle-4@2x.png" />

    <!--<a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>-->
    <!--<a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">-->
    <!--    <img class="vector-icon73" alt="" src="../public/vector7.svg" />-->
    <!--</a>-->
    <!--<a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>-->
    <!--<a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">-->
    <!--    <img class="vector-icon74" alt="" src="../public/vector3.svg" />-->
    <!--</a>-->
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="../public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999; margin-top:55px;" href="./leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" style=" margin-top:55px;" id="fluentpersonClock20Regular">
        <img class="vector-icon75" style="z-index: 99999;" alt="" src="../public/vector1.svg" />
    </a>
    <!--<a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>-->
    <!--<a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">-->
    <!--    <img class="vector-icon76" alt="" src="../public/vector.svg" />-->
    <!--</a>-->
    <a class="attendance14" href="./attendence.php" style="color:white; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
        <img class="vector-icon77" style=" z-index: 99999;" alt="" src="../public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
    </div>


  <script>
    function submitAttendanceData() {
      var tableData = [];
      var atLeastOneChecked = false;
      $('#attendanceTable tr').each(function(row, tr) {
        if (row > 0) { // Skip the header row
          var isChecked = $(tr).find('td:first-child input[type="checkbox"]').prop('checked');
          if (isChecked) {
            atLeastOneChecked = true; // At least one checkbox is checked
            tableData.push({
              "adate": $(tr).find('td:eq(1)').text(),
              "empname": $(tr).find('td:eq(3)').text(),
              "intime": $(tr).find('td:eq(4)').text(),
              "intime_inputtype": $(tr).find('td:eq(5)').text(),
              "outtime": $(tr).find('td:eq(6)').text(),
              "outtime_inputtype": $(tr).find('td:eq(7)').text(),
              "total_hrs": $(tr).find('td:eq(8)').text(),
              "actual_working_hrs": $(tr).find('td:eq(9)').text()
            });
          }
        }
      });

      if (!atLeastOneChecked) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please check at least one row before submitting.',
        });
        return;
      }

      if (!submitAttendanceData.processing) {
        submitAttendanceData.processing = true;

        $.ajax({
          url: 'insert_ams.php',
          method: 'POST',
          data: {
            table_data: tableData
          },
          success: function(response) {
            var successMessage = "Data inserted successfully";
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              html: successMessage,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "attendence.php";
              }
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          },
          complete: function() {
            submitAttendanceData.processing = false;
          }
        });
      }
    }
  </script>

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
<?php
require_once("../inc/config.php");
require_once("dbConfig.php");
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
if (isset($_GET['redirect'])) {
  // Assuming you have retrieved the department value from the 'emp' table
  $result = mysqli_query($con, "SELECT desg FROM emp WHERE empemail = '{$_SESSION['user_name']}'");
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (!empty($rows)) {
    $department = $rows[0]['desg']; // Access the first row and the 'dept' column
    if ($department === 'SECURITY GAURDS') {
      header("Location: ../print-details3.php");
      exit();
    } else {
      header("Location:  ../print-details1.php");
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

  $firstDayOfMonth = date("Y-m-01");
  $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

  // Fetching Employees 
  $fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'") or die(mysqli_error($db));
  $totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

  $EmployeesNamesArray = array();
  $EmployeesIDsArray = array();
  $counter = 0;
  while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
    $EmployeesNamesArray[] = $Employees['empname'];
    $EmployeesIDsArray[] = $Employees['UserID'];
  }
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/attendenceemp-mob.css" />
    <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
      .udbtn:hover {
        background-color: #FB8A0B !important;
        color: white;
      }
    
@keyframes color {
  from {
    background-position: 0% 50%;
  }
  to {
    background-position: 100% 50%;
  }
}
h2 {
  /* font-size: 8vw; */
  font-weight: 400;
  color: transparent;
  background: rgb(255, 0, 0);
  background: linear-gradient(
    90deg,
    rgba(255, 0, 0, 1) 0%,
    rgba(238, 100, 10, 1) 7%,
    rgba(210, 169, 39, 1) 14%,
    rgba(234, 252, 62, 1) 21%,
    rgba(134, 248, 10, 1) 28%,
    rgba(99, 245, 56, 1) 35%,
    rgba(87, 241, 215, 1) 42%,
    rgba(75, 216, 237, 1) 49%,
    rgba(66, 158, 239, 1) 56%,
    rgba(57, 74, 241, 1) 63%,
    rgba(126, 45, 244, 1) 70%,
    rgba(162, 84, 247, 1) 77%,
    rgba(229, 117, 249, 1) 84%,
    rgba(251, 103, 64, 1) 91%,
    rgba(253, 127, 190, 1) 97%,
    rgba(255, 0, 191, 1) 100%
  );
  background-clip: text;
  -webkit-background-clip: text;
  background-size: 500%;
  animation: color 5s linear infinite;
}

    </style>
  </head>

  <body>
    <div class="attendenceemp-mob" style="height: 100svh;">
      <div class="logo-1-group">
        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="attendance-management" style="width: 300px;">Attendance Management</a>
      </div>
      <div class="attendenceemp-mob-child"></div>
      <div class="attendenceemp-mob-item"></div>
      <div class="rectangle-parent">
        <a class="frame-item" href="attendenceemp-mob.php" style="background-color: #E8E8E8;"> </a>
        <a class="frame-inner" href="./attendancelogemp-mob.php"> </a>
        <a class="rectangle-a" style="width: 100px; background-color: #ffe2c6;"> </a>
        <a class="attendance" href="attendenceemp-mob.php" style="color: BLACK;">Attendance</a>
        <a class="punch-inout" href="./attendancelogemp-mob.php" style="width: 100px; margin-left: -5px;">Attendance Log</a>
        <a class="my-attendance" style="width: 100px; margin-left: -1px; color: #ff5400;">Monthly Attendance</a>
      </div>
      <div class="rectangle-parent9" style="margin-top: 15px;">
        <div class="frame-child23"></div>
        <a class="employee-management1" style="margin-left: 17px;">Monthly Attendance</a>
        <div class="box" style=" overflow-y:hidden !important;">
        <h2 class="uploaded-docs" style="margin-left: 0px; font-size: 13px;">
        Gain Access to Previous
      </h2>
      <h2 class="uploaded-docs" style="margin-left: 145px; font-size: 13px;">
          Month's Attendance:
      </h2>
      <h2 class="uploaded-docs" style="margin-left: 0px;top:90px; font-size: 13px;">
      Simply Click On <a href="month-wise-attendance-emp.php"> <button class="btn btn-outline-success btn-sm" style="position: absolute; z-index: 100; margin-left:10px; top:-5px;">Access</button></a>
      </h2>
    </div>
        <?php $employeeName = $EmployeesNamesArray[0]; ?>
        <h3 class="documentspdf" style="margin-left:-80px; white-space: nowrap;">
          Attendance_<?php echo (strlen($employeeName) > 15) ? substr($employeeName, 0, 15) . '...' : $employeeName; ?>.pdf
        </h3>

        <h3 class="document-view" style="margin-top:10px;width:300px;">Attendance Sheet(<?php echo $currentDate = date('M Y'); ?>)</h3>
        <img class="frame-child24" style="margin-top:-40px;" alt="" src="./public/line-12@2x.png" />

        <a href="?redirect=true" target="_blank"><button class="btn btn-outline-primary" style="position: absolute; z-index: 100; margin-top: 255px; margin-left: 114px;">Download</button></a>
        <img class="frame-icon" alt="" src="./public/frame-174@2x.png" />
        <!-- Confirm Div -->
        <form method="post">

          <?php
          $currentDate = date('Y-m-d');
          $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));
          $fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'") or die(mysqli_error($db));
          $totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);
          $counter = 0;

          while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
            $status_query = "SELECT status FROM CA WHERE empname = '" . $Employees['empname'] . "'
  AND MONTH(submissionTime) = MONTH(CURRENT_DATE())
  AND YEAR(submissionTime) = YEAR(CURRENT_DATE())";
            $status_result = mysqli_query($con, $status_query);

            if ($status_result) {
              if (mysqli_num_rows($status_result) > 0) {
                $row = mysqli_fetch_assoc($status_result);
                $status = $row['status'];

                if ($status == 1 && $currentDate === $lastDayOfMonth) {
                  echo '<div>
                  <h3 class="uploaded-docs" style="color: rgb(0, 119, 255); margin-top: 350px; width: 300px; font-size: 13px; margin-left: 2px;">
                      Current Month Attendance Confirmed Successfully 
                      <svg style=" margin-left: 120px;margin-top: 30px !important;" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#28C855" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                      </svg>
                  </h3>  <div class="frame-child26" style="margin-top: 205px; height: 190px;"></div>
              </div>';
                 
                  } elseif ($currentDate === $lastDayOfMonth) {
                    echo " <div>
                    <h3 class='uploaded-docs' style=' color: rgb(0, 119, 255); margin-top: 310px; width: 300px; font-size: 13px; margin-left: 2px;'>Please download your current month's attendance report from above and review it. If there are no discrepancies, confirm your attendance by using the '<b>Confirm</b>' button below. In case you observe any inconsistencies, kindly contact the HR promptly for resolution.</h3>
                    <a href='javascript:void(0);'onclick='confirmAttendance()' class='btn udbtn' style='outline:1px solid #F46114;position: absolute; z-index: 100; margin-top: 485px; margin-left: 121px;'>Confirm</a>
                    <div class='frame-child26' style='margin-top: 205px; height: 190px;'></div>
                </div>";
                }
              } elseif ($currentDate === $lastDayOfMonth) {
                // No record found, display the button
                echo " <div>
            <h3 class='uploaded-docs' style=' color: rgb(0, 119, 255); margin-top: 310px; width: 300px; font-size: 13px; margin-left: 2px;'>Please download your current month's attendance report from above and review it. If there are no discrepancies, confirm your attendance by using the '<b>Confirm</b>' button below. In case you observe any inconsistencies, kindly contact the HR promptly for resolution.</h3>
            <a href='javascript:void(0);'onclick='confirmAttendance()' class='btn udbtn' style='outline:1px solid #F46114;position: absolute; z-index: 100; margin-top: 485px; margin-left: 121px;'>Confirm</a>
            <div class='frame-child26' style='margin-top: 205px; height: 190px;'></div>
        </div>";
              }

              mysqli_free_result($status_result);
            } else {
              die("Error: " . mysqli_error($con));
            }

            $counter++;
          }
          mysqli_free_result($fetchingEmployees);
          ?>
                 <!-- <div>
             <h3 class='uploaded-docs' style=' color: rgb(0, 119, 255);; margin-top: 310px; width: 300px; font-size: 13px; margin-left: 2px;'>Please download your current month's attendance report from above and review it. If there are no discrepancies, confirm your attendance by using the '<b>Confirm</b>' button below. In case you observe any inconsistencies, kindly contact the HR promptly for resolution.</h3>
             <a href='javascript:void(0);'onclick='confirmAttendance()' class="btn udbtn" style='outline:1px solid #F46114;position: absolute; z-index: 100; margin-top: 485px; margin-left: 121px;'>Confirm</a>
             <div class='frame-child26' style='margin-top: 205px; height: 190px;'></div>
          </div> -->
        </form>

        <div class="frame-child26"></div>
      </div>
      <div class="arcticonsgoogle-pay-parent">
        <img class="arcticonsgoogle-pay1" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

        <div class="ellipse-div"></div>
        <a class="akar-iconsdashboard1" id="akarIconsdashboard">
          <img class="vector-icon3" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="fluentperson-clock-20-regular1" id="fluentpersonClock20Regular">
          <img class="vector-icon4" alt="" src="./public/vector1@2xleaves.png" />
        </a>
        <a class="uitcalender1">
          <img class="vector-icon5" alt="" src="./public/vector3@2xattenblack.png" />
        </a>
      </div>
    </div>
    <script>
    function confirmAttendance() {
        // Get the values to be sent to the server
        var empEmail = '<?php echo $_SESSION['user_name']; ?>';
        var empName = '<?php echo $EmployeesNamesArray[0]; ?>'; // Assuming there is only one employee for simplicity
        var submissionTime = new Date().toISOString().slice(0, 19).replace("T", " "); // Format date as string
        var confirm = "self";

        // Show a confirmation SweetAlert
        Swal.fire({
            title: 'Confirm Attendance',
            text: 'Confirming the attendance indicates that you dont have any discrepancies in your attendance,and this information will be used for further salary processing and other related process(s).This action is irreversible, so please ensure that your attendance details are accurate before confirming.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to the server to update the 'CA' table
                $.ajax({
                    type: "POST",
                    url: "../update_ca_table.php",
                    data: {
                        empEmail: empEmail,
                        empName: empName,
                        submissionTime: submissionTime,
                        confirm: confirm,
                    },
                    success: function(response) {
                        // Log the response to the console for debugging
                        console.log(response);

                        // Handle the response from the server using SweetAlert2
                        if (response === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Attendance confirmed successfully!',
                            }).then(function() {
                                // Redirect to sheet_emp.php after the user clicks "OK"
                                window.location = 'monthly-attendance-emp.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to confirm attendance.',
                                text: response, // Display the error message from the server
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Log any AJAX errors to the console for debugging
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }
</script>

    <script>
      var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
      if (arcticonsgooglePay) {
        arcticonsgooglePay.addEventListener("click", function(e) {
          window.location.href = "./directoryemp-mob.php";
        });
      }

      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function(e) {
          window.location.href = "./emp-dashboard-mob.php";
        });
      }

      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function(e) {
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
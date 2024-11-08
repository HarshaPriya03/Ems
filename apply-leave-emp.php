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
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

$sqlEmployeeName = "SELECT empname,desg,empph,work_location FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultEmployeeName = mysqli_query($con, $sqlEmployeeName);
$employeeNameRow = mysqli_fetch_assoc($resultEmployeeName);
$employeeName = $employeeNameRow['empname'];
$employeeDesg = $employeeNameRow['desg'];
$employeePhone = $employeeNameRow['empph'];
$work_location = $employeeNameRow['work_location'];
     $currentDate = date('Y-m-d');

if ($statusRow['empstatus'] == 0) {
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./apply-leave.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
      select,
      input,
      textarea {
        font-size: 23px;
      }
    </style>
  </head>

  <body>
    <div class="applyleave">
      <div class="bg7"></div>
      <div class="rectangle-parent9">
        <div class="frame-child101"></div>
        <a class="frame-child104" style="margin-left: -300px;"> </a>
        <a class="frame-child105" href="./myleaves-emp.php" style="margin-left: -300px;" id="rectangleLink3"> </a>
        <a class="frame-child105" href="./lbhistory.php" style="margin-left: -60px;" id="rectangleLink3"> </a>
        <a class="apply-leave1" style="margin-left: -300px;">Apply Leave</a>
        <a class="my-leaves1" href="./myleaves-emp.php" style="margin-left: -310px;" id="myLeaves">My Leaves</a>
        <a class="my-leaves1" href="./lbhistory.php" style="margin-left: -85px; width:200px;" id="myLeaves">Leaves History</a>
      </div>
      <img class="applyleave-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="applyleave-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon7" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm7" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm7">HRM</span>
      </a>
      <a class="leave-management1" href="./index.php" id="leaveManagement">Leave Management</a>
      <button class="applyleave-inner"><a href="logout.php" style="margin-left:25px; color:white; text-decoration:none; font-size:25px">Logout</a></button>
      <!--<div class="logout7">Logout</div>-->
      <a class="attendance7" id="attendance" style="margin-top: -50px;" href="attendenceemp2.php">Attendance</a>
      <a class="payroll7" style="margin-top: -50px; text-decoration:none; color:black;" href="card.php">Directory</a>
      <img class="uitcalender-icon7" alt="" src="./public/uitcalender.svg" />

      <img style="margin-top: -50px;" class="arcticonsgoogle-pay7" alt="" src="./public/arcticonsgooglepay.svg" />

      <!--<img class="applyleave-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon7"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img class="applyleave-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard7" style="margin-top: 50px;" href="employee-dashboard.php" id="dashboard">Dashboard</a>
      <a style="margin-top: 50px;" class="akar-iconsdashboard7" href="./index.php" id="akarIconsdashboard">
        <img class="vector-icon39" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon7" alt="" src="./public/tablerlogout.svg" />

      <a style="margin-top: -50px;" class="uitcalender7" id="uitcalender">
        <img class="vector-icon40" alt="" src="./public/vector4.svg" />
      </a>
      <a class="leaves7">Leaves</a>
      <a class="fluentperson-clock-20-regular7">
        <img class="vector-icon41" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector1.svg" />
      </a>
      <div class="rectangle-parent10">
        <div class="frame-child106"></div>
        <label class="employee-name2">Leave Type</label>
        <label class="from-date">From Date</label>
        <label class="reason1">Reason</label>
        <label class="to-date">To Date</label>
        <h3 class="apply-leave2">Apply Leave</h3>
        <img class="frame-child107" alt="" src="./public/line-121@2x.png" />

        <form id="updateForm">
    <input class="frame-child109" type="date" name="from" min="<?php echo $currentDate; ?>"/>
    <input class="frame-child111" type="date" name="to" />
    <textarea class="rectangle-textarea" name="reason"></textarea>
    <input class="frame-child110" type="hidden" value="<?php echo $employeeName ?>" name="empname" />
    <input type="hidden" value="<?php echo $employeePhone ?>" name="empph" />
    <input type="hidden" value="<?php echo $employeeDesg ?>" name="desg">
    <input type="hidden" value="<?php echo $work_location ?>" name="work_location">
    <input type="hidden" value="<?php echo $_SESSION['user_name'] ?>" name="empemail">
    <input type="hidden" value="0" name="status">

    <?php

    function checkCompOffEligibility($con) {
        $sql = "SELECT co FROM leavebalance WHERE co != 0 AND empemail = '{$_SESSION['user_name']}'";
        $result = $con->query($sql);

        return ($result->num_rows > 0);
    }

    $sql = "SELECT leavetype FROM leavetype ";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<select class='frame-child108' name='leavetype' id='leavetype'>";
        echo "<option value=''>--select--</option>";

        while ($row = $result->fetch_assoc()) {
            $leavetype = $row["leavetype"];
            if ($leavetype !== "HALF DAY" && $leavetype !== "OFFICIAL LEAVE" && $leavetype !== "WORK FROM HOME") {
                if ($leavetype === "COMP. OFF") {
                    $coEligible = checkCompOffEligibility($con);
                    if ($coEligible) {
                        echo "<option value='" . $leavetype . "'>" . $leavetype . "</option>";
                    }
                } else {
                    echo "<option value='" . $leavetype . "'>" . $leavetype . "</option>";
                }
            }
        }
        echo "</select>";
    } else {
        echo "0 results";
    }

    ?>
    <button class="frame-child112"></button>
    <a class="apply">Apply</a>
</form>
      </div>
    </div>
    <script>
  $(document).ready(function() {
    // Define holidayDates globally to make it accessible in different functions
    var holidayDates = [];
    var selectedDuration; // Declare selectedDuration here

    // Fetch holiday dates from the database
    var fetchHolidaysXHR = new XMLHttpRequest();
    fetchHolidaysXHR.onreadystatechange = function() {
        if (fetchHolidaysXHR.readyState === 4 && fetchHolidaysXHR.status === 200) {
            holidayDates = JSON.parse(fetchHolidaysXHR.responseText);
        }
    };

    fetchHolidaysXHR.open("GET", "getHolidays.php", true);
    fetchHolidaysXHR.send();

    $("#updateForm").submit(function(e) {
        e.preventDefault();

        var selectedLeaveType = document.getElementById('leavetype').value;
        var empEmail = '<?php echo $_SESSION['user_name']; ?>'; // Define empEmail here

        if (selectedLeaveType === "COMP. OFF") {
            var fromDate = new Date(document.getElementsByName('from')[0].value);
            var toDate = new Date(document.getElementsByName('to')[0].value);

            // Make an AJAX request to fetch the 'co' value from leavebalance table
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var coValue = parseInt(xhr.responseText);

                    // Make another AJAX request to fetch the total leave balance
                    var totalLeaveBalanceXHR = new XMLHttpRequest();
                    totalLeaveBalanceXHR.onreadystatechange = function() {
                        if (totalLeaveBalanceXHR.readyState === 4 && totalLeaveBalanceXHR.status === 200) {
                            var totalLeaveBalance = parseInt(totalLeaveBalanceXHR.responseText);

                            // Check if the total leave balance is zero
                            if (totalLeaveBalance <= 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning!',
                                    text: 'You have exhausted all of your allocated leave balance and your leave balance is "' + totalLeaveBalance + '". Please select a different leave type other than COMP. OFF for your leave application.',
                                    confirmButtonText: 'OK'
                                });
                            } else if (selectedDuration > coValue) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning!',
                                    text: 'Selected duration exceeds available COMP. OFF balance.',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // If duration is within limit, submit the form
                                submitForm();
                            }
                        }
                    };

                    totalLeaveBalanceXHR.open("GET", "getTotalLeaveBalance.php?empemail=" + empEmail, true);
                    totalLeaveBalanceXHR.send();
                }
            };

            xhr.open("GET", "getCompOffBalance.php?empemail=" + empEmail, true);
            xhr.send();

        } else {
            // If leave type is not "COMP. OFF", submit the form
            submitForm();
        }
    });

    function submitForm() {
        var formData = new FormData($("#updateForm")[0]);
        formData.append("from", $("input[name='from']").val());
        formData.append("to", $("input[name='to']").val());

        var fromDate = new Date($("input[name='from']").val());
        var toDate = new Date($("input[name='to']").val());

        // Calculate selectedDuration considering whole days excluding Sundays and holidays
        selectedDuration = calculateSelectedDuration(fromDate, toDate, holidayDates); // Assign selectedDuration here

        formData.append("days", selectedDuration);

        $.ajax({
            type: "POST",
            url: "insert_leave.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Applied!',
                    text: response,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'apply-leave-emp.php';
                    }
                });

                // Clear form fields
                $("#updateForm")[0].reset();
            }
        });
    }

    function calculateSelectedDuration(fromDate, toDate, holidayDates) {
        var daysDiff = 0;

        // Calculate the interval between dates
        var oneDay = 24 * 60 * 60 * 1000;
        var dateRange = [];
        for (var d = new Date(fromDate); d <= toDate; d.setDate(d.getDate() + 1)) {
            dateRange.push(new Date(d));
        }

        // Iterate over each date in the range
        dateRange.forEach(function(date) {
            // Exclude Sundays (where Sunday is 0) and holidays
            if (date.getDay() !== 0 && !isHoliday(date, holidayDates)) {
                daysDiff++;
            }
        });

        return daysDiff;
    }

    function isHoliday(date, holidayDates) {
        // Check if the date is in the array of dynamically fetched holiday dates
        return holidayDates.includes(date.toISOString().split('T')[0]);
    }
});
</script>




    <script>
      var rectangleLink = document.getElementById("rectangleLink");
      if (rectangleLink) {
        rectangleLink.addEventListener("click", function(e) {
          window.location.href = "./leave-management.php";
        });
      }

      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function(e) {
          window.location.href = "./assign-leave.php";
        });
      }

      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function(e) {
          window.location.href = "./my-leaves.php";
        });
      }

      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function(e) {
          window.location.href = "./leave-management.php";
        });
      }

      var assignLeave = document.getElementById("assignLeave");
      if (assignLeave) {
        assignLeave.addEventListener("click", function(e) {
          window.location.href = "./assign-leave.php";
        });
      }

      var myLeaves = document.getElementById("myLeaves");
      if (myLeaves) {
        myLeaves.addEventListener("click", function(e) {
          window.location.href = "./my-leaves.php";
        });
      }

      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function(e) {
          window.location.href = "./index.php";
        });
      }

      var leaveManagement = document.getElementById("leaveManagement");
      if (leaveManagement) {
        leaveManagement.addEventListener("click", function(e) {
          window.location.href = "./index.php";
        });
      }

      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function(e) {
          window.location.href = "./onboarding.php";
        });
      }

      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function(e) {
          window.location.href = "./attendence.php";
        });
      }

      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function(e) {
          window.location.href = "./onboarding.php";
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
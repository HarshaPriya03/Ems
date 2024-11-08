<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Session Terminated',
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

$sqlEmployeeName = "SELECT empname,desg,empph FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultEmployeeName = mysqli_query($con, $sqlEmployeeName);
$employeeNameRow = mysqli_fetch_assoc($resultEmployeeName);
$employeeName = $employeeNameRow['empname'];
$employeeDesg = $employeeNameRow['desg'];
$employeePhone = $employeeNameRow['empph'];

if ($statusRow['empstatus'] == 0) {
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/apply-leaveemp-mob.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
      .logo-1-icon10 {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 55px;
        height: 55px;
        object-fit: cover;
      }
    </style>
  </head>

  <body>
    <div class="applyleaveemp-mob" style="height: 100svh;">
      <div class="rectangle-parent2">
        <div class="frame-child6" style="height: 500px;"></div>
        <a class="apply-leave1">Apply Leave</a>
        <h3 class="apply-a-leave">Apply a Leave</h3>
        <img class="line-icon" alt="" src="./public/line-12@2x.png" />

        <label style="margin-top: -90px;" class="leave-type">Leave Type</label>
        <label style="margin-top: -90px;" class="from-date">From Date</label>
        <label style="margin-top: -90px;" class="to-date">To Date</label>
        <label style="margin-top: -90px;" class="reason">Reason</label>
        <form id="updateForm">
          <input class="frame-child110" type="hidden" value="<?php echo $employeeName ?>" name="empname" />
          <input type="hidden" value="<?php echo $employeePhone ?>" name="empph" />
          <input type="hidden" value="<?php echo $employeeDesg ?>" name="desg">
          <input type="hidden" value="<?php echo $_SESSION['user_name'] ?>" name="empemail">
          <input type="hidden" value="0" name="status">
          <?php
          $currentDate = date('Y-m-d');

          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "ems";

          $conn = new mysqli($servername, $username, $password, $dbname);

          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          function checkCompOffEligibility($conn)
          {
            $sql = "SELECT co FROM leavebalance WHERE co != 0 AND empemail = '{$_SESSION['user_name']}'";
            $result = $conn->query($sql);

            return ($result->num_rows > 0);
          }

          $sql = "SELECT leavetype FROM leavetype ";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            echo "<select style='margin-top: -90px;' class='frame-child7' name='leavetype' id='leavetype'>";
            echo "<option value=''>--select--</option>";

            while ($row = $result->fetch_assoc()) {
              $leavetype = $row["leavetype"];
              if ($leavetype !== "HALF DAY" && $leavetype !== "OFFICIAL LEAVE") {
                if ($leavetype === "COMP. OFF") {
                  $coEligible = checkCompOffEligibility($conn);
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

          $conn->close();
          ?>


         <input style="margin-top: -90px;" class="frame-child8" type="date" name="from" min="<?php echo $currentDate; ?>" />

          <input style="margin-top: -90px;" class="frame-child9" type="date" name="to" />

          <textarea style="margin-top: -90px;" class="rectangle-textarea" name="reason"> </textarea>
          <button class="rectangle-button" style="margin-top: -90px; color: white; font-size: 16px;">Apply</button>
        </form>
      </div>
      <div class="logo-1-parent1">
        <img class="logo-1-icon3" alt="" src="./public/logo-1@2x.png" />

        <a class="leaves-list1">Leaves List</a>
      </div>
      <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
      <div class="applyleaveemp-mob-child"></div>
      <div class="applyleaveemp-mob-item"></div>
      <div class="uitcalender-group">
        <a class="uitcalender3" id="uitcalender">
          <img class="vector-icon11" alt="" src="./public/vector2@2xatten.png" />
        </a>
        <img class="arcticonsgoogle-pay3" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

        <div class="frame-child10"></div>
        <a class="akar-iconsdashboard3" id="akarIconsdashboard">
          <img class="vector-icon12" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="fluentperson-clock-20-regular3">
          <img class="vector-icon13" alt="" src="./public/vector6@2xleaveblack.png" />
        </a>
      </div>
      <div class="rectangle-parent3" style="margin-left:-48px">
        <a class="frame-child11"> </a>
        <a class="frame-child12" id="rectangleLink1"> </a>
        <a class="apply-leave2">Apply Leave</a>
        <a class="my-leaves1" id="myLeaves">My Leaves</a>
        <a class="frame-child12" href="lbhistory-mob.php" id="rectangleLink1" style="margin-left:100px;"> </a>
        <a class="my-leaves1" href="lbhistory-mob.php" id="myLeaves" style="margin-left:93px; width:100px">Leave History</a>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        // Define holidayDates globally to make it accessible in different functions
        var holidayDates = [];

        // Fetch holiday dates from the database
        var fetchHolidaysXHR = new XMLHttpRequest();
        fetchHolidaysXHR.onreadystatechange = function() {
          if (fetchHolidaysXHR.readyState === 4 && fetchHolidaysXHR.status === 200) {
            holidayDates = JSON.parse(fetchHolidaysXHR.responseText);
          }
        };

        fetchHolidaysXHR.open("GET", "../getHolidays.php", true);
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

                    totalLeaveBalanceXHR.open("GET", "../getTotalLeaveBalance.php?empemail=" + empEmail, true);
                    totalLeaveBalanceXHR.send();
                }
            };

            xhr.open("GET", "../getCompOffBalance.php?empemail=" + empEmail, true);
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
          var selectedDuration = calculateSelectedDuration(fromDate, toDate, holidayDates);

          formData.append("days", selectedDuration);

          $.ajax({
            type: "POST",
            url: "../insert_leave.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Applied!',
                text: response,
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'apply-leaveemp-mob.php';
                }
              });
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
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function(e) {
          window.location.href = "./attendenceemp-mob.php";
        });
      }

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

      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function(e) {
          window.location.href = "./my-leaveemp-mob.php";
        });
      }

      var myLeaves = document.getElementById("myLeaves");
      if (myLeaves) {
        myLeaves.addEventListener("click", function(e) {
          window.location.href = "./my-leaveemp-mob.php";
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
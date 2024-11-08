<?php
@include 'inc/config.php';

session_start();

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

$sqlEmployeeName = "SELECT empname, desg, empph, empemail,work_location FROM emp";
$resultEmployeeName = mysqli_query($con, $sqlEmployeeName);

if ($resultEmployeeName) {
    $employeeNameRow = mysqli_fetch_assoc($resultEmployeeName);
    $employeeName = $employeeNameRow['empname'];
    $employeeDesg = $employeeNameRow['desg'];
    $employeePhone = $employeeNameRow['empph'];
    $employeeMail = $employeeNameRow['empemail'];
    $work_location = $employeeNameRow['work_location'];
} else {
    die("Error: Unable to fetch employee details.");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/apply-leave.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <style>
          select,input,textarea{
            font-size:20px;
        }
    </style>
  </head>
  <body>
    <div class="applyleave">
      <div class="bg7"></div>
      <div class="rectangle-parent9" style="margin-left: 120px;">
        <div class="frame-child101"></div>
        <a class="frame-child102" href="./leave-management.php"> </a>
        <a class="frame-child103" id="rectangleLink1"> </a>        <a href="./leave-type.php"  class="frame-child103" style="margin-left: -470px;background-color: #E8E8E8;" id="rectangleLink1"> </a>
        <a class="frame-child104" id="rectangleLink2"> </a>
        <a class="frame-child105" id="rectangleLink3"> </a>
        <a class="leaves-list2" href="./leave-management.php">Leaves List</a>
        <a class="assign-leave1" id="assignLeave">Approvers</a>        <a href="./leave-type.php" class="assign-leave1" style="margin-left: -485px; width: 200px; color: black;" id="assignLeave">New Leave Type</a>
        <a class="apply-leave1" id="applyLeave">Apply Leave</a>
        <a class="my-leaves1" id="myLeaves">My Leaves</a>
      </div>
     
      <img class="applyleave-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="applyleave-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon7" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm7" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm7">HRM</span>
      </a>
      <a class="leave-management1" href="./index.php" id="leaveManagement"
        >Leave Management</a
      >
      <button class="applyleave-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
      <a class="onboarding9" id="onboarding">Onboarding</a>
      <a class="attendance7" id="attendance">Attendance</a>
      <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll7">Payroll</a>
      <div class="reports7">Reports</div>
      <a class="fluent-mdl2leave-user7" id="fluentMdl2leaveUser">
        <img class="vector-icon37" alt="" src="./public/vector.svg" />
      </a>
      <img class="uitcalender-icon7" alt="" src="./public/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay7"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon7"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="applyleave-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon7"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img class="applyleave-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard7" href="./index.php" id="dashboard">Dashboard</a>
      <a class="fluentpeople-32-regular7" id="fluentpeople32Regular">
        <img class="vector-icon38" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list7" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard7"
        href="./index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon39" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon7" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender7" id="uitcalender">
        <img class="vector-icon40" alt="" src="./public/vector4.svg" />
      </a>
      <a class="leaves7" href="leave-management.php">Leaves</a>
      <a class="fluentperson-clock-20-regular7">
        <img class="vector-icon41" alt="" src="./public/vector10.svg" />
      </a>
      <div class="rectangle-parent10">
        <div class="frame-child106"></div>
        <label class="employee-name2">Employee Name*</label>
        <label class="from-date">From Date</label>
        <label class="reason1">Reason</label>
        <label class="leave-type1">Leave Type</label>
        <label class="to-date">To Date</label>
        <h3 class="apply-leave2">Apply Leave</h3>
        <img class="frame-child107" alt="" src="./public/line-121@2x.png" />
        <form id="updateForm">
        <select class="frame-child108" name="empname" id="detail">
            <option value="">--select--</option>
            <?php

                $sql = "SELECT empname, empemail, empph, desg,work_location FROM emp WHERE empstatus=0";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row["empname"] . "' data-work_location='" . $row["work_location"] . "' data-empemail='" . $row["empemail"] . "' data-empph='" . $row["empph"] . "' data-desg='" . $row["desg"] . "'>" . $row["empname"] . "</option>";
                    }
                } else {
                    echo "0 results";
                }

            ?>
        </select>
      <input class="frame-child109" type="datetime-local"  name="from" id="fromDatetime" style="display:none;" readonly/>
        <input class="frame-child111" type="datetime-local" name="to" id="toDatetime" style="display:none;" readonly/>
        <input class="frame-child109" type="date" name="from1" />
        <input class="frame-child111" type="date"  name="to2" />
        <textarea class="rectangle-textarea" name="reason"></textarea>
        <input type="hidden" value="0" name="status">
        <input type="hidden" value="1" name="status2">
        <input  type="hidden" value="<?php echo $employeePhone?>" name="empph"/>
        <input type="hidden" value="<?php echo $employeeDesg ?>" name="desg">
        <input type="hidden" value="<?php echo $employeeMail ?>" name="empemail">
        <input type="hidden" value="<?php echo $work_location ?>" name="work_location">
        <select class="frame-child110" name="leavetype" style="width:25%;">
          <option value="">--select--</option>
          <?php

                $sql = "SELECT leavetype FROM leavetype ";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["leavetype"] . "'>" . $row["leavetype"] . "</option>";
                    }
                } else {
                    echo "0 results";
                }

            ?>
        </select>
        <select class="frame-child110" name="leavetype2" style="margin-left:400px;width:9%;display:none;" id="halfDaySelect">
          <option value="">--select--</option>
          <option value="FN">FN (Forenoon)</option>
          <option value="AN">AN (Afternoon)</option>
        </select>
    

        <button class="frame-child112"></button>
        <a class="apply">Apply</a>
        </form>
      </div>
    </div>
        <script>
    $(document).ready(function () {
        // Initialize Select2 on your dropdown
        $('#detail').select2({
            width: '200px', // Adjust the width as needed
            placeholder: '--sss--',
            minimumResultsForSearch: -1, // Disable search box
        });
    });
</script>
       <script>
  document.querySelector('select[name="leavetype2"]').addEventListener('change', function () {
    var selectedValue = this.value;

    var dateFromInput = document.querySelector('input[type="date"][name="from1"]');
    var dateToInput = document.querySelector('input[type="date"][name="to2"]');

    var datetimeFromInput = document.getElementById('fromDatetime');
    var datetimeToInput = document.getElementById('toDatetime');

    if (selectedValue === "") {
      dateFromInput.style.display = 'block';
      dateToInput.style.display = 'block';
      datetimeFromInput.style.display = 'none';
      datetimeToInput.style.display = 'none';
    } else {
      dateFromInput.style.display = 'none';
      dateToInput.style.display = 'none';
      datetimeFromInput.style.display = 'block';
      datetimeToInput.style.display = 'block';
    }
  });
</script>
    <script>
  document.getElementById('halfDaySelect').addEventListener('change', function () {
    var selectedValue = this.value;

    var fromDatetimeInput = document.getElementById('fromDatetime');
    var toDatetimeInput = document.getElementById('toDatetime');

    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2); 
    var day = ('0' + currentDate.getDate()).slice(-2);

    if (selectedValue === "FN") {
      fromDatetimeInput.value = `${year}-${month}-${day}T09:30`;
      toDatetimeInput.value = `${year}-${month}-${day}T13:00`;
    } else if (selectedValue === "AN") {
      fromDatetimeInput.value = `${year}-${month}-${day}T14:00`;
      toDatetimeInput.value = `${year}-${month}-${day}T18:00`;
    } else {
      fromDatetimeInput.value = '';
      toDatetimeInput.value = '';
    }
  });
</script>

     <script>
    $(document).ready(function(){
      
        $("#updateForm").submit(function(e){
            e.preventDefault();
            var selectedOption = $("select[name='empname'] option:selected");
        var empname = selectedOption.val();
        var leavetype = $("select[name='leavetype']").val();
        var leavetype2 = $("select[name='leavetype2']").val();
        var from = $("input[name='from']").val();
        var to = $("input[name='to']").val();
        var from1 = $("input[name='from1']").val();
        var to2 = $("input[name='to2']").val();
        var desg = selectedOption.data('desg');
        var status = $("input[name='status']").val();
        var status2 = $("input[name='status2']").val();
        var reason = $("textarea[name='reason']").val();
        var empph = selectedOption.data('empph');
        var empemail = selectedOption.data('empemail');
        var work_location = selectedOption.data('work_location');
            $.ajax({
                type: "POST",
                url: "insert_leave.php", 
                data: { work_location:work_location ,empname: empname, leavetype: leavetype,leavetype2: leavetype2, from: from, to: to,from1: from1, to2: to2, desg: desg, status: status,status2: status2, reason: reason, empph: empph, empemail: empemail },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Applied!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'leave-management.php';
                        }
                    });

                    $("select[name='empname']").val();
                    $("select[name='leavetype']").val();
$("input[name='from']").val();
$("input[name='to']").val();
$("input[name='desg']").val();
$("input[name='status']").val();
$("textarea[name='reason']").val();
$("input[name='empph']").val();
$("input[name='empemail']").val();
                }
            });
        });
    });
</script>
<script>
  document.querySelector('.frame-child110[name="leavetype"]').addEventListener('change', function () {
    var selectedValue = this.value;

    var halfDaySelect = document.getElementById('halfDaySelect');

    if (selectedValue === "HALF DAY") {
      halfDaySelect.style.display = 'block';
    } else {
      halfDaySelect.style.display = 'none';
    }
  });
</script>
    <script>
      var rectangleLink = document.getElementById("rectangleLink");
      if (rectangleLink) {
        rectangleLink.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function (e) {
          window.location.href = "./approver.php";
        });
      }
      
      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function (e) {
          window.location.href = "./my-leaves.php";
        });
      }
      
      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var assignLeave = document.getElementById("assignLeave");
      if (assignLeave) {
        assignLeave.addEventListener("click", function (e) {
          window.location.href = "./approver.php";
        });
      }
      
      var myLeaves = document.getElementById("myLeaves");
      if (myLeaves) {
        myLeaves.addEventListener("click", function (e) {
          window.location.href = "./my-leaves.php";
        });
      }
      
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var leaveManagement = document.getElementById("leaveManagement");
      if (leaveManagement) {
        leaveManagement.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./index.php";
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
          window.location.href = "./index.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      </script>
  </body>
</html>

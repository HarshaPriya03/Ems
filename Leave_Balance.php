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

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];
    $work_location = $row['work_location'];

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


$sql = "SELECT DISTINCT MONTH(AttendanceTime) AS month_num, YEAR(AttendanceTime) AS year 
        FROM CamsBiometricAttendance 
        WHERE AttendanceTime IS NOT NULL AND AttendanceTime <> ''
              AND (MONTH(AttendanceTime) != 1 OR YEAR(AttendanceTime) != 2024)
        ORDER BY year ASC, month_num ASC";

$result = mysqli_query($con, $sql);
$months = array();

while ($row = mysqli_fetch_assoc($result)) {
  $month_num = $row['month_num'];
  $year = $row['year'];
  $month_name = date('F', mktime(0, 0, 0, $month_num, 1, $year));
  $months[$year][$month_num] = $month_name;
}

if ($work_location == 'All') {
  $sql = "SELECT DISTINCT E.empname, lb.*
FROM CamsBiometricAttendance AS CBA
INNER JOIN emp AS E ON CBA.UserID = E.UserID
INNER JOIN leavebalance AS lb ON E.empname = lb.empname
WHERE E.empstatus = 0
ORDER BY lb.lastupdate DESC";
} else {
  $sql = "SELECT DISTINCT E.empname, E.work_location, lb.*
        FROM CamsBiometricAttendance AS CBA
        INNER JOIN emp AS E ON CBA.UserID = E.UserID
        INNER JOIN leavebalance AS lb ON E.empname = lb.empname
        WHERE E.empstatus = 0
        AND  E.work_location = '$work_location'
        ORDER BY lb.lastupdate DESC";
}

$result = mysqli_query($con, $sql);
$employees = array();
$cnt = 1;
while ($row = mysqli_fetch_assoc($result)) {
  $employees[] = $row['empname'];
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/map.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
      text-align: center;
    }

    th,
    td {
      padding: 1em;
      background: white;
      color: rgb(52, 52, 52);
      border-bottom: 2px solid rgb(193, 193, 193);
    }

    input,
    select {
      font-size: 20px;
    }

    .container {
      padding-bottom: 20px;
      margin-right: -60px;
    }

    .input-text:focus {
      box-shadow: 0px 0px 0px;
      border-color: #fd7e14;
      outline: 0px;
    }

    .form-control {
      border: 1px solid #fd7e14;
    }

    .udbtn:hover {
      color: black !important;
      background-color: white !important;
      outline: 1px solid #F46114;
    }

    .dialog {
      padding: 20px;
      border: 0;
      background: transparent;
    }

    .dialog::backdrop {
      background-color: rgba(0, 0, 0, .3);
      backdrop-filter: blur(4px);
    }

    .dialog__wrapper {
      padding: 20px;
      background: #fff;
      width: 740px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
    }

    .dialog__close {
      border: 0;
      padding: 0;
      width: 24px;
      aspect-ratio: 1;
      display: grid;
      place-items: center;
      background: #000;
      color: #fff;
      border-radius: 50%;
      font-size: 12px;
      line-height: 20px;
      position: absolute;
      top: 5px;
      right: 5px;
      cursor: pointer;
      --webkit-appearance: none;
      appearance: none;
    }

    tr td:nth-child(3),
    tr td:nth-child(4) {
      background: #A1EEBD;
    }

    tr td:nth-child(12) {
      background: #FFDD95;
    }

    tr td:nth-child(15) {
      background: #A1EEBD;
    }
    .cards{
      position:absolute;
      top:500px;
      left:427px;
      display:flex;
      flex-direction:row;
      gap:50px;
      width:1170px;
      justify-content:center;
    }
    .card{
      background-color:#fff;
      border-radius:20px;
      padding:30px;
      width:550px;
      display:flex;
      flex-direction:column;
      justify-content:center; 
      border:1px solid #45C380;
       box-shadow: 2px 2px 2px 2px #dcdcdc;
       gap:10px;
    }
    .images{
      border-radius:50%;
      margin:auto;
      background-color:#792a86;
      color:white;
      width:50px;
      height:50px;
      font-size:50px;
      font-weight:bolder;
      vertical-align:middle;
      padding-bottom:10px;
      padding-left:10px;
      box-shadow: 1px 1px 1px 1px #888888;
      cursor:pointer;
    }
    .images h2{
        
        margin-top:-5px;
    
    }
    .images-1{
      border-radius:50%;
      margin:auto;
     background-color:#792a86;
      color:white;
      width:50px;
      height:50px;
      font-size:50px;
      font-weight:bolder;
      vertical-align:middle;
      padding-bottom:10px;
      padding-left:13px;
      cursor:pointer;
      box-shadow: 1px 1px 1px 1px #888888;
    }
    .images-1 h2{
        margin-top:-5px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div class="biometricmap">
    <div class="bg"></div>
    <img class="biometricmap-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="biometricmap-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm">
      <span>Anika</span>
      <span class="hrm">HRM</span>
    </a>
    <h5 class="hr-management">Leave Management/Leave Balance</h5>
    <button class="biometricmap-inner" autofocus="{true}"></button>
    <div class="logout">Logout</div>
    <a class="employee-list" href="./employee-management.php">Employee List</a>
    <a class="leaves" style="color: white; z-index: 99999;" href="./leave-management.php">Leaves</a>
    <a class="onboarding" href="./onboarding.php">Onboarding</a>
    <a class="attendance" href="./attendence.php">Attendance</a>
    <a href="./Payroll/payroll.php" style="text-decoration:none; color:black; z-index:99;" class="payroll">Payroll</a>
    <div class="reports">Reports</div>
    <a class="fluentpeople-32-regular" style="margin-top:130px;">
      <img class="vector-icon" alt="" src="./public/vector.svg" />
    </a>
    <a class="fluent-mdl2leave-user" style="margin-top:-65px; z-index: 99999; -webkit-filter: grayscale(1) invert(1);
	  filter: grayscale(1) invert(1);">
      <img class="vector-icon1" alt="" src="./public/vector1.svg" />
    </a>
    <a class="fluentperson-clock-20-regular" style="margin-top:-65px;">
      <img class="vector-icon2" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector2.svg" />
    </a>
    <a class="uitcalender" style="margin-top:-260px; z-index:9999;">
      <img class="vector-icon3" alt="" src="./public/vector3.svg" />
    </a>
    <img class="arcticonsgoogle-pay" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


    <a href="leave-management.php"><img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" style="margin-top: 132px;" /></a>

    <a href="./index.php" style="color: black;" class="dashboard">Dashboard</a>
    <a class="akar-iconsdashboard" style="margin-top:263px;">
      <img class="vector-icon4" alt="" src="./public/vector4.svg" />
    </a>
    <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

    <div class="frame-div"></div>
    <div class="rectangle-div"></div>

    <h3 class="userid-mapping" style="width:300px;">Leave Balance</h3>
    <img class="line-icon" alt="" src="./public/line-12@2x.png" />
    <label class="employee-name">Employee Name*</label>
    <form id="updateForm">
      <select onchange="updateFields()" name="employee" class="rectangle-input employeeSelect" id="employeeSelect">
        <option value="">--select--</option>
        <?php
        if ($work_location == 'All') {
          $sql = "SELECT empname, empemail, emp_no FROM emp WHERE empstatus=0 ORDER BY emp_no ASC";
        } else {
          $sql = "SELECT empname, empemail, emp_no, work_location FROM emp WHERE empstatus=0 AND work_location = '$work_location' ORDER BY emp_no ASC";
        }

        $result = mysqli_query($con, $sql);

        if ($result) {
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<option value='" . $row["empname"] . "|" . $row["empemail"] . "'>" . $row["empname"] . "</option>";
            }
          } else {
            echo "0 results";
          }
        } else {
          echo "Error: " . mysqli_error($con);
        }
        ?>
      </select>
      <input type='hidden' name='empname' id='employeeNameField' value=''>
      <input type='hidden' name='empemail' id='employeeEmailField' value=''>
      <label class="user-id">Casual Leave</label>
      <input class="biometricmap-child1" type="text" name="cl" style="width: 120px;" />
      <label class="user-id" style="margin-left: 150px;">Sick Leave</label>
      <input class="biometricmap-child1" type="text" name="sl" style="width: 120px; margin-left: 150px;" />
      <label class="user-id" style="margin-left: 300px;">Comp. Off</label>
      <input class="biometricmap-child1" type="text" name="co" style="width: 120px; margin-left: 300px;" />
      <button class="rectangle-button" id="rectangleButton1" style="color:white; font-size:25px;">ADD</button>
    </form>

    <div class="cards"  >
      <div class="cards-1 card" >
      <img src="./work_pics/final.png" alt="" style="width:250px;height:200px;margin:auto;">
      <h2 style="color:black;margin:auto">Access Leave Management</h2>
      <!-- <div class="images" onclick="leave_manage()"><h2><</h2></div> -->
       <img src="./work_pics/images.png" alt=""  onclick="leave_manage()" style="width:50px;height:70px;margin:auto;cursor:pointer">
      </div>
      <div class="cards-2 card"  >
           <img src="./work_pics/final_1.png" alt="" style="width:280px;height:200px;margin:auto;">
           <h2 style="color:black;margin:auto;">Access Leave Balance</h2>
           <!-- <div class="images-1" onclick="leave_balance()"><h2>></h2></div> -->
           <img src="./work_pics/images-1.png" alt="" onclick="leave_balance()" style="width:50px;height:50px;margin:auto;cursor:pointer">

      </div>
    </div>

  </div>
  <script>
    function populateDialog(values) {
      var valueArray = values.split(',');

      var coValue = valueArray[0];
      var clValue = valueArray[1];
      var slValue = valueArray[2];
      var empnameValue = valueArray[3];
      var empemailValue = valueArray[4];

      document.getElementById('currentCompOff').innerText = coValue;
      document.getElementById('currentCL').innerText = clValue;
      document.getElementById('currentSL').innerText = slValue;
      document.getElementById('empemailInputCO1').value = coValue;
      document.getElementById('empemailInputCL1').value = clValue;
      document.getElementById('empemailInputSL1').value = slValue;
      document.getElementById('empnameInput').value = empnameValue;
      document.getElementById('empemailInput').value = empemailValue;
    }
  </script>
  <script>
    function submitForm() {
      var formData = $('#frm').serialize();
      $.ajax({
        type: 'POST',
        url: 'insert_ulb.php',
        data: formData,
        success: function(response) {
          if (response === 'success') {
            $.ajax({
              type: 'POST',
              url: 'update_ulb.php',
              data: formData,
              success: function(updateResponse) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: updateResponse
                }).then(function() {
                  window.location = 'Leave_Balance.php';
                });
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'An error occurred while updating. Please try again later.'
                });
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while inserting. Please try again later.'
            });
          }
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while processing your request. Please try again later.'
          });
        }
      });
    }

    $('#frm').submit(function(event) {
      event.preventDefault();
      submitForm();
    });
  </script>

  <script>
    const modalLinks = document.querySelectorAll('a[href^="#modal"]');

    modalLinks.forEach(function(modalLink, index) {
      // Get modal ID to match the modal
      const modalId = modalLink.getAttribute('href');

      // Click on link
      modalLink.addEventListener('click', function(event) {

        // Get modal element
        const modal = document.querySelector(modalId);
        // If modal with an ID exists
        if (modal) {
          // Get close button
          const closeBtn = modal.querySelector('.dialog__close');
          event.preventDefault();
          modal.showModal(); // Open modal

          // Close modal on click
          closeBtn.addEventListener('click', function(event) {
            modal.close();
          });
          const closeBtn1 = modal.querySelector('.dialog__close1');
          event.preventDefault();
          modal.showModal(); // Open modal

          // Close modal on click
          closeBtn1.addEventListener('click', function(event) {
            modal.close();
          });

          // Close modal when clicking outside modal
          document.addEventListener('click', function(event) {

            const dialogEl = event.target.tagName;
            const dialogElId = event.target.getAttribute('id');
            if (dialogEl == 'DIALOG') {
              // Close modal
              modal.close();
            }
          }, false);

          // If modal ID not exists
        } else {
          console.log('Modal doesn\'t exist');
        }
      });
    });
  </script>
  <script>
    function updateFields() {
      var selectedEmployee = document.getElementsByClassName("employeeSelect")[0];
      var nameField = document.getElementById("employeeNameField");
      var emailField = document.getElementById("employeeEmailField");

      var selectedValue = selectedEmployee.options[selectedEmployee.selectedIndex].value;
      var values = selectedValue.split("|");

      nameField.value = values[0];
      emailField.value = values[1];
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

        if (i === 0 || rows[i].classList.contains('static-cell')) { // Exclude header row and static cells
          shouldShow = true;
        } else {
          for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            var txtValue = cell.textContent || cell.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              shouldShow = true;
              break;
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
    var rectangleButton1 = document.getElementById("rectangleButton1");
    if (rectangleButton1) {
      rectangleButton1.addEventListener("click", function(e) {});
    }

    var map = document.getElementById("map");
    if (map) {
      map.addEventListener("click", function(e) {});
    }
  </script>
  <script>
    $(document).ready(function() {

      $("#updateForm").submit(function(e) {
        e.preventDefault();
        var empname = $("input[name='empname']").val();
        var empemail = $("input[name='empemail']").val();
        var sl = $("input[name='sl']").val();
        var cl = $("input[name='cl']").val();
        var co = $("input[name='co']").val();

        $.ajax({
          type: "POST",
          url: "insert_lb.php",
          data: {
            empname: empname,
            empemail: empemail,
            sl: sl,
            cl: cl,
            co: co
          },
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Added!',
              text: response,
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'Leave_Balance.php';
              }
            });
          }
        });
      });
    });
  </script>
  <script>
    function leave_manage(){
      window.location.href = 'leave-management.php';
    }

    function leave_balance(){
      window.location.href = 'leave.php';
    }
  </script>
</body>

</html>
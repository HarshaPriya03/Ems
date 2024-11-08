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
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">-->
  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
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

    table tr {
      border-bottom: 1px solid #ddd;
    }

    table tr:hover td,
    table tr:focus td {
      background-color: #eee;
    }

    table tr:hover td ul,
    table tr:focus td ul {
      display: block;
    }

    table tr.bold:hover td {
      background-color: #fff;
    }

    table tr td {
      padding: 15px;
      position: relative;
    }

    table tr td ul {
      position: absolute;
      display: none;
      width: 120px;
      top: 5px;
      right: 10px;
      margin: 0;
      padding: 5px;
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      border-radius: 3px;
      z-index: 100;
    }

    table tr td ul li a {
      padding: 7px;
      display: block;
      text-decoration: none;
      border-radius: 3px;
      color: #555;
    }

    table tr td ul li a:hover {
      color: white;
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
    <div class="container" style="margin-top:100px; margin-left:630px;">
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
     <a class="frame-child188" style="margin-left:400px; width:270px; height:40px; margin-top:77px; border-radius:10px;"> </a>
      <a href="attendancelog_gaurd.php" class="attendence5" style="margin-left:375px; width:250px; margin-top:71px; font-size:16px;">Security Gaurd's Attendance Log</a>
      
    <div class="rectangle-parent23" style="overflow-y:auto; margin-top:-20px;">
      <table class="data" id="attendanceTable" style="margin-left: auto; margin-right:auto;">
        <tr class='header-row'>
          <th class='static-cell'>Date</th>
          <th class='static-cell' style="border-left: 2px solid rgb(182, 182, 182);"></th>
          <th class='static-cell'>Employee Name</th>
          <th class='static-cell' colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type </span></th>
          <th>
          </th>
          <th class='static-cell' colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
          <th>Update</th>
        </tr>

        <?php
             $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
FROM emp
INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
AND emp.ServiceTagId = CamsBiometricAttendance.ServiceTagId
WHERE emp.empstatus = 0
AND emp.desg = 'SECURITY GAURDS'
AND emp.ServiceTagId = 'ZXQI19009096'
ORDER BY CamsBiometricAttendance.AttendanceTime DESC;
";
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
              'Department' => $result['dept'],
            );
          } elseif ($result['AttendanceType'] == 'CheckIn' || $result['AttendanceType'] == 'BreakIn') {
            $currentDay = date('j', strtotime($result['AttendanceTime']));
            $ID = $result['ID'];
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
              <td>
              <?php echo $result['AttendanceType']; ?>
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
             
              <td>
                <button data-modal-target="crud-modal" onclick="openModal('<?php echo $result['ID']; ?>','<?php echo $result['empname']; ?>', '<?php echo $result['AttendanceType']; ?>', '<?php echo $result['AttendanceTime']; ?>', '<?php echo $result['InputType']; ?>')" data-modal-toggle="crud-modal" class="updateBtn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                  Update
                </button>
              </td>

            </tr>
        <?php

            $prevDay = $currentDay;
          }
          $cnt++;
        }
        ?>
      </table>
      <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-3 md:p-3 border-b rounded-t dark:border-gray-600">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Update Attendance Discrepancies
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="updateForm">
              <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee Name</label>
                  <input type="text" name="empname" id="empname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly>
                </div>

                <div class="col-span-2">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> AttendanceTime</label>
                  <input type="text" name="AttendanceTime" id="AttendanceTime" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" readonly>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">AttendanceType</label>
                  <!-- <input type="text" name="AttendanceType" id="AttendanceType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"> -->
                  <select name="AttendanceType" id="AttendanceType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="CheckIn">CheckIn</option>
                    <option value="CheckOut">CheckOut</option>
                    <option value="BreakIn">BreakIn</option>
                    <option value="BreakOut">BreakOut</option>
                  </select>

                </div>
                <div class="col-span-2 sm:col-span-1">
                  <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">InputType</label>
                  <input type="text" name="InputType" id="InputType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                </div>
              </div>
              <input type="hidden" name="ID" id="ID">
              <div class="flex items-center">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Confirm Update</button>
                <a data-modal-toggle="crud-modal" type="button" class="text-decoration-none py-2.5 px-5 ms-3  text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                  Cancel
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>



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
   function openModal(ID, empname, AttendanceType, AttendanceTime, InputType) {
    // Get the modal
    var modal = document.getElementById("updateModal");

    // Populate form fields with row data
    document.getElementById("ID").value = ID;
    document.getElementById("empname").value = empname;
    document.getElementById("AttendanceTime").value = AttendanceTime;
    document.getElementById("InputType").value = InputType;

    // Get the select element
    var attendanceTypeSelect = document.getElementById("AttendanceType");

    // Loop through options and set selected based on InputType
    for (var i = 0; i < attendanceTypeSelect.options.length; i++) {
        if (attendanceTypeSelect.options[i].value === AttendanceType) {
            attendanceTypeSelect.options[i].selected = true;
            break;
        }
    }

    // Display the modal
    modal.style.display = "block";
}

  </script>
  <script>
    $(document).ready(function() {
      // Function to handle form submission
      function submitForm(formData) {
        $.ajax({
          type: 'POST',
          url: 'update_sg_attendance.php',
          data: formData,
          success: function(updateResponse) {
            // Display success message using SweetAlert
            Swal.fire({
              icon: 'success',
              title: 'Success',
               text: 'Record updated successfully'
            }).then(function() {
              // Redirect to the desired page after success
              window.location = 'attendence_gaurd.php';
            });
          },
          error: function(xhr, status, error) {
            // Display error message using SweetAlert
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while updating. Please try again later.'
            });
          }
        });
      }

      // Submit form when it's submitted
      $('#updateForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data
        submitForm(formData); // Call submitForm function with serialized data
      });
    });
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
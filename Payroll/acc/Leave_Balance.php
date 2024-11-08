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

  <link rel="stylesheet" href="../../css/map.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
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
  </style>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div class="biometricmap">
    <div class="bg"></div>
    <img class="biometricmap-child" alt="" src="../public/rectangle-1@2x.png" />

    <!--<div class="biometric-mapping"> </div>-->
    <img class="biometricmap-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon" alt="" src="../public/logo-1@2x.png" />

    <a class="anikahrm">
      <span>Anika</span>
      <span class="hrm">HRM</span>
    </a>
    <h5 class="hr-management">Leave Management/Leave Balance</h5>
    <button class="biometricmap-inner" autofocus="{true}"></button>
    <a href="../../logout.php" class="logout">Logout</a>
    <!--<a class="employee-list" href="./employee-management.php">Employee List</a>-->
    <a class="leaves" style="color: white; z-index: 99999; margin-top:65px; " href="./leave-management.php">Leaves</a>
    <!--<a class="onboarding" href="./onboarding.php">Onboarding</a>-->
    <a class="attendance" href="./attendence.php" style="z-index:9999;">Attendance</a>
    <a href="./acc_payroll.php" style="text-decoration:none; color:black; z-index:99; margin-top:-200px" class="payroll">Payroll</a>
    <div class="reports" style="margin-top:-70px;">Reports</div>
    <!--<a class="fluentpeople-32-regular" style="margin-top:130px;">-->
    <!--  <img class="vector-icon" alt="" src="../public/vector.svg" />-->
    <!--</a>-->
    <a class="fluent-mdl2leave-user" style="margin-top:px; z-index: 99999; -webkit-filter: grayscale(1) invert(1);
	  filter: grayscale(1) invert(1);">
      <img class="vector-icon1" alt="" src="../public/vector1.svg" />
    </a>
    <!--<a class="fluentperson-clock-20-regular" style="margin-top:-65px;">-->
    <!--  <img class="vector-icon2" style="-webkit-filter: grayscale(1) invert(1);-->
    <!--    filter: grayscale(1) invert(1);" alt="" src="../public/vector2.svg" />-->
    <!--</a>-->
    <!--<a class="uitcalender" style="margin-top:-260px; z-index:9999;">-->
    <!--  <img class="vector-icon3" alt="" src="../public/vector3.svg" />-->
    <!--</a>-->
    <img class="arcticonsgoogle-pay" alt="" style=" margin-top:-200px" src="../public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon" style="margin-top:-70px;" alt="" src="../public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


    <a href="./leave-management.php"><img class="rectangle-icon" alt="" src="../public/rectangle-4@2x.png" style="margin-top: 197px;" /></a>

    <!--<a href="./index.php" style="color: black;" class="dashboard">Dashboard</a>-->
    <a class="akar-iconsdashboard" style="margin-top:263px;">
      <img class="vector-icon4" alt="" src="../public/vector4.svg" />
    </a>
    <img class="tablerlogout-icon" alt="" src="../public/tablerlogout.svg" />

    <div class="frame-div"></div>
    <div class="rectangle-div"></div>
    <div class="container" style="margin-top:500px; ">
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
    <div style="position: absolute; margin-top: -40px; width:2260px; overflow-y:auto; height:470px;scale:0.9;">
      <table class="data" id="attendanceTable" style="margin-left:auto; margin-right:auto;font-size:15px !important;">
        <tr class='header-row'>
          <th colspan="9" style="font-size:12px;">*Total Leave Balance Allocated (for the fiscal year April 2023 - March 2024)</th>
          <td colspan="3">
            <a class="btn udbtn" style="background-color: #FB8A0B; color: white;" href="print-detailslb.php" target="_blank">Download</a>
            <!--<a class="btn udbtn" style="background-color: #FB8A0B; color: white; margin-left:50px;" href="lb_assign.php" target="_blank">Assign Leave Balance</a>-->
          </td>
        </tr>
        <tr class='header-row'>
          <th class='static-cell'></th>
          <th class='static-cell'>Employee Name</th>
          <th class='static-cell' style="border-right:1px solid black;"> Total Leave Bal.*</th>
          <th class='static-cell'>Intial CL</th>
          <th class='static-cell' style="border-right:1px solid black;">Current CL</th>
          <th class='static-cell'>Intial SL</th>
          <th class='static-cell' style="border-right:1px solid black;">Current SL</th>
          <th class='static-cell'>Intial Comp. Off</th>
          <th class='static-cell' style="border-right:1px solid black;">Current Comp. Off</th>
          <th class='static-cell' style="border-right:1px solid black;">Current Leave Bal.</th>
          <th class='static-cell'>Last Updation</th>
          <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT lb.*, emp.pic 
        FROM leavebalance lb 
        JOIN emp ON lb.empname = emp.empname 
        WHERE emp.empstatus = 0 
        ORDER BY lb.lastupdate DESC";


        $que = mysqli_query($con, $sql);
        $cnt = 1;
        while ($result = mysqli_fetch_assoc($que)) {
        ?>
          <tr>
            <td><img class="hovpic" src="../../pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td>
            <td><?php echo $result['empname']; ?></td>
            <td style="border-right:1px solid black;"><?php echo $result['icl'] + $result['isl'] + $result['ico']; ?></td>
            <td><?php echo $result['icl']; ?></td>
            <td style="border-right:1px solid black;"><?php echo $result['cl']; ?></td>
            <td><?php echo $result['isl']; ?></td>
            <td style="border-right:1px solid black;"><?php echo $result['sl']; ?></td>
            <td><?php echo $result['ico']; ?></td>
            <td style="border-right:1px solid black;"><?php echo $result['co']; ?></td>
            <td style="border-right:1px solid black;"><?php echo $result['cl'] + $result['sl'] + $result['co']; ?></td>
            <td><?php echo date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes')); ?></td>
            <td>
              <a class="btn udbtn" style="background-color: #FB8A0B; color: white;" href="#modal-option-1" onclick="populateDialog('<?php echo $result['ico'] . ',' . $result['icl'] . ',' . $result['isl'] . ',' . $result['empname'] . ',' . $result['empemail']; ?>')">Update</a>
            </td>
          </tr>
        <?php $cnt++;
        } ?>
      </table>
    </div>

    <dialog class="dialog" id="modal-option-1" style="overflow:hidden;">
      <div class="dialog__wrapper">
        <button class="dialog__close">✕</button>
        <div class="send-email-parent">
          <form id="frm">
               <h5 class="modal-title" id="exampleModalLabel" style="font-size:25px;">Update Leave Balance</h5>
           <div style="display:flex; gap:30px; padding:20px; justify-content:center;">
                <div style="font-size:20px; font-weight: lighter; background-color:#FB8A0B; color:white; width:150px; height:40px; display:flex; justify-content:center; align-items:center; border-radius:10px;">Allocated CL: <span id="currentCL"></span></div>
             <div style="font-size:20px; font-weight: lighter; background-color:#FB8A0B; color:white; width:150px; height:40px; display:flex; justify-content:center; align-items:center; border-radius:10px;">Allocated SL: <span id="currentSL"></span></div>
             <div style="font-size:20px; font-weight: lighter; background-color:#FB8A0B; color:white; width:200px; height:40px; display:flex; justify-content:center; align-items:center; border-radius:10px;">Allocated Comp.Off: <span id="currentCompOff"></span></div>
           </div>
           <div class="container">
                 <label class="form-label" style="font-size:20px; font-weight: lighter;">Enter the adjustment CL value: </label>
            <input type="text" class="form-control" style="margin-bottom:10px; width:550px;" name='ucl'>
           
            <label style="font-size:20px; font-weight: lighter;">Enter the adjustment SL value:</label>
             <input class="form-control" type="text" style="margin-bottom:10px; width:550px;" name='usl'>
            
            <label style="font-size:20px; font-weight: lighter;">Enter the adjustment Comp.Off value:</label>
            <input class="form-control" type="text" style="margin-bottom:10px; width:550px;" name='uco' id="empemailInputCO">
           </div>
              <br/>
            <input type="hidden" name='ccl' id="empemailInputCL1" value="">
            <input type="hidden" name='csl' id="empemailInputSL1" value="">
            <input type="hidden" name='cco' id="empemailInputCO1" value="">
            <input type="hidden" name='uempname' id="empnameInput" value="">
            <input type="hidden" name='uempemail' id="empemailInput" value="">
            <input type="hidden" name="by_user" value="<?php echo $_SESSION['user_name']; ?>">
            <button type="button" onclick="submitForm();" class="frame-item dialog__close1 btn udbtn" style=" font-size: 20px; position:absolute; right:50px; background-color: #FB8A0B; color: white;">Submit</button><br/>
          </form>
        </div>
      </div>
    </dialog>

    <h3 class="userid-mapping" style="width:300px;">Leave Balance</h3>
    <img class="line-icon" alt="" src="./public/line-12@2x.png" />
    <label class="employee-name">Employee Name*</label>
    <form id="updateForm">
      <select onchange="updateFields()" name="employee" class="rectangle-input employeeSelect" id="employeeSelect">
        <option value="">--select--</option>
        <?php
        $servername = "localhost";
        $username = "Anika12";
        $password = "Anika12";
        $dbname = "ems";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT empname, empemail,emp_no FROM emp WHERE empstatus=0 ORDER BY emp_no asc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

            echo "<option value='" . $row["empname"] . "|" . $row["empemail"] . "'>" . $row["empname"] . "</option>";
          }
        } else {
          echo "0 results";
        }

        $conn->close();
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
</body>

</html>
<?php

$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <style>
    .rectangle-div {
      position: absolute;
      /* top: 136px; */
      border-radius: 20px;
      background-color: #ffffff;
      width: 400px;
      height: 200px;
      border: 1px solid rgb(185, 185, 185);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
    }

    label {
      font-weight: normal;
    }

    .backclr {
      background-color: #dfebff;
    }

    .remove {
      display: none;
    }

    .hide-calendar .ui-datepicker-calendar {
      display: none;
      width: 120px !important;
    }
  </style>
</head>

<body>
<?php
    $sql = "SELECT SUM(damt) AS total_damt, MAX(created) AS last_created FROM payroll_misc";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $sum = $row['total_damt'];
    $last_created = $row['last_created'];


    $current_month = date('m');
    $current_year = date('Y');
    $sql1 = "SELECT SUM(damt) AS total_cmisc FROM payroll_misc WHERE MONTH(created) = $current_month AND YEAR(created) = $current_year";
    $result = mysqli_query($con, $sql1);
    $row = mysqli_fetch_assoc($result);
    $total_cmisc = $row['total_cmisc'];

    $sql = "SELECT COUNT(*) AS total_rows FROM payroll_misc";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $total_rows = $row['total_rows'];
  
    ?>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-left: 40px; margin-top:-60px;">
      <div class="rectangle-div"></div>
      <p style="position: absolute; margin-left: 30px; top: 10px; font-size: 20px;">Total Misc. Deductions</p>
      <p style="position: absolute; margin-left: 30px; top: 60px; font-size: 30px; font-weight: 700;">₹ <?php echo $sum; ?></p>
      <p style="position: absolute; margin-left: 30px; top: 130px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created))); ?></p>
      <img src="../public/totalamt.png" style="position: absolute; left: 260px; top: 70px;" width="130px" alt="">
      <div class="rectangle-div" style="margin-left: 420px;"></div>
      <p style="position: absolute; margin-left: 450px; top: 10px; font-size: 20px;">Employees with Misc. Deductions</p>
      <p style="position: absolute; margin-left: 480px; top: 60px; font-size: 30px; font-weight: 700;"><?php echo $total_rows ?></p>
      <p style="position: absolute; margin-left: 450px; top: 130px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created))); ?></p>
      <img src="../public/remamt.png" style="position: absolute; left: 680px; top: 60px;" width="150px" alt="">
      <div class="rectangle-div" style="margin-left: 840px;"></div>
      <p style="position: absolute; margin-left: 870px; top: 10px; font-size: 20px;">Deduction's this month</p>
      <p style="position: absolute; margin-left: 870px; top: 60px; font-size: 30px; font-weight: 700;">₹ <?php echo $total_cmisc ?></p>
      <p style="position: absolute; margin-left: 870px; top: 130px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created))); ?></p>
      <img src="../public/dedamt.png" style="position: absolute; left: 1105px; top: 75px;" width="120px" alt="">
      <button style="position: absolute; top: 210px; left: 1040px;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        + Create New Deduction
      </button>
      <div style="margin-top: 260px;">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="width: 1240px;">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                Deduction ID
              </th>
              <th scope="col" class="px-6 py-3">
                Emp Name
              </th>
              <th scope="col" class="px-6 py-3">
                Deduction Type
              </th>
              <th scope="col" class="px-6 py-3">
                Deduction amount
              </th>
              <th scope="col" class="px-6 py-3">
                Deduction Paymonth
              </th>
              <th scope="col" class="px-6 py-3">
                Reason
              </th>
              <th scope="col" class="px-6 py-3">
                Created on
              </th>
            </tr>
          </thead>
          <?php
          $cnt = 1;
          $sql = "SELECT * FROM payroll_misc  ORDER BY ID ASC";
          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4"><?php echo $cnt++; ?></td>
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['dtype']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['damt']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['paymonth']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['reason']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['created']; ?></td>

                </tr>
              </tbody>
            <?php
            }
          } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td colspan="8" class="px-6 py-4 text-center">No data</td>
            </tr>
          <?php
          }
          ?>
        </table>
        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                  Create a New Deduction
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <form id="employeeForm">
                <div class="p-4 md:p-5 space-y-4" style="margin-left: 65px;">
                  <!-- <p style="font-size: 13px; font-weight: 500; position: absolute; right: 30px;">DEDUCTION ID: ASPLDEDUCTION202401230001</p> <br> -->
                  <label for="">Employee Name:</label>
                  <select name="empname" id="" style="width: 300px; border-radius: 5px; ">
                    <option value="" disabled selected>--Select--</option>
                    <?php
                    $servername = "localhost";
                    $username = "Anika12";
                    $password = "Anika12";
                    $dbname = "ems";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT empname FROM emp where empstatus=0 ORDER BY emp_no ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["empname"] . "'>" . $row["empname"] . "</option>";
                      }
                    } else {
                      echo "0 results";
                    }

                    $conn->close();
                    ?>
                  </select>
                  <label for="">Deduction Type:</label>
                  <select name="dtype" id="" style="width: 300px; border-radius: 5px; margin-left: 5px;">
                    <option value="">--Select--</option>
                    <option value="Training Fees">Training Fees</option>
                    <option value="Fine">Fine</option>
                    <option value="Other">Other</option>
                  </select>
                  <div style="display: flex;">
                    <label for="">Deduction Amount:</label>
                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-left: 18px;">₹</div>
                    <input type="text" name="damt" style="font-size: 18px; width: 200px; height: 40px; border: 1px solid rgb(185,185,185);">
                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                  </div>
                  <label for="">Payout Month:</label>
                  <input id="datepicker" name="paymonth" class="datepicker-without-calendar" type="text" style="width: 300px; border-radius: 5px; margin-left: 20px;">
                  <div style="margin-top: 20px;">
                    <label for="">Reason:</label><br>
                    <textarea name="reason" cols="47" rows="3" style="border-radius: 5px;"></textarea>
                  </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="../../index.html" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
      <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <a href="../../logout.php" style="margin-top:-5px;" class="logout14">Logout</a>
    <a class="payroll14" href="./acc_payroll.php" style="color: white; z-index:9999; margin-top:-200px">Payroll</a>
    <div class="reports14" style="margin-top:-70px;">Reports</div>
    <img class="uitcalender-icon14" alt="" src="../public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999; margin-top:-200px" class="arcticonsgoogle-pay14" alt="" src="../public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" style="margin-top:-70px;" alt="" src="../public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

     

    <img class="attendence-child2" alt="" style="margin-top: -130px;" src="../public/rectangle-4@2x.png" />

    <!--<a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>-->
    <!--<a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">-->
    <!--    <img class="vector-icon73" alt="" src="../public/vector7.svg" />-->
    <!--</a>-->
    <!--<a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>-->
    <!--<a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">-->
    <!--    <img class="vector-icon74" alt="" src="../public/vector3.svg" />-->
    <!--</a>-->
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="../public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999; margin-top:70px;" href="./leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" style=" margin-top:70px;" id="fluentpersonClock20Regular">
        <img class="vector-icon75" style="z-index: 99999;" alt="" src="../public/vector1.svg" />
    </a>
    <!--<a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>-->
    <!--<a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">-->
    <!--    <img class="vector-icon76" alt="" src="../public/vector.svg" />-->
    <!--</a>-->
    <a class="attendance14" href="./attendence.php" style="color: black; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
        <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="../public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
    </div>
</body>
<script>
  $(document).ready(function() {
    $('#employeeForm').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'insert_misc.php',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
          console.log('Success:', response);
          Swal.fire({
            icon: 'success',
            title: 'Created!',
            text: response,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'misc.php';
              $('#employeeForm')[0].reset();
            }
          });
        },
        error: function(xhr, status, error) {
          console.log('Error:', xhr.responseText);
        }
      });
    });
  });
</script>
<script>
  $('.datepicker-without-calendar').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    beforeShow: function(input) {
      $(input).datepicker("widget").addClass('hide-calendar');
    },
    onClose: function(dateText, inst) {
      $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
      $(this).datepicker('widget').removeClass('hide-calendar');
    }
  });

  $('.datepicker').datepicker();
</script>

</html>
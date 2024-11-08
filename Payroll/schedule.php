<?php

@include 'inc/config.php';

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

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
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
      background-color: var(--color-white);
      width: 60%;
      height: 400px;
    }

    .hide-calendar .ui-datepicker-calendar {
      display: none;
      width: 120px !important;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -50px; margin-left: -25px;">
     <div class="rectangle-div">
        <p style="position: absolute; left: 20px; top: 20px; font-size: 30px; font-weight: 500;">Pay Schedule</p>
        <p style="position: absolute; left: 20px; top: 65px; font-size: 18px; color: #484848;">Configure and view your payment schedules</p>

        <div style="position: absolute; left: 20px; top: 120px; color: #484848;">
            <label for="">Pay employee's on:</label>
            <p style="margin-top: 10px;">Day
            <select style="border-radius: 7px;" name="sdate" id="day">
            <?php
            for ($i = 1; $i <= 28; $i++) {
              echo "<option value=\"$i\">$i</option>";
            }
            ?>
          </select>
            of every month</p>
        </div>
        <p style="position: absolute; left: 20px; top: 210px; font-size: 16px; color: #484848;">Note: When payday falls on a non-working day or a holiday, employees will get paid on the previous working day.</p>
        <div style="position: absolute; left: 20px; top: 250px; color: #484848;">
            <label for="">Start your first payroll from:</label><br>
            <input name="smonth" class="datepicker-without-calendar" id="datepicker" type="text" style="margin-top: 10px; width: 250px; border-radius: 7px;">
        </div>
        <button id="saveBtn" type="submit" style="position: absolute; right: 40px; top: 340px; width: 200px;"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
     </div>


      <div class="relative overflow-x-auto" style="position: absolute; right: 0; width: 39%; height:780px;">
        <caption>Upcoming Payrolls</caption>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                Pay Period
            </th>
            <th scope="col" class="px-6 py-3">
                Pay Date
            </th>
        </tr>
    </thead>
    <?php
$sql = "SELECT * FROM payroll_schedule ORDER BY ID ASC";
$que = mysqli_query($con, $sql);

if (mysqli_num_rows($que) > 0) {
    while ($result = mysqli_fetch_assoc($que)) {
        $dateParts = explode(' ', date('F Y', strtotime('+1 month', strtotime($result['smonth']))));
        $month = $dateParts[0];
        $year = $dateParts[1];

        $currentMonth = date('F');
        $currentYear = date('Y');

        $sql_next = "SELECT * FROM payroll_schedule  WHERE (smonth = '" . $result['smonth'] . "' AND  approval = 0 )";
        $result_next = $con->query($sql_next);
        if ($result_next && mysqli_num_rows($result_next) > 0) {
            ?>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $result['smonth'];?>
                        <?php
                        echo '&nbsp;<span style="color: white; background-color: #00BD9C; padding: 3px; border-radius: 1px; font-size: 10px;">NEXT PAYRUN</span>';
                        ?>                        
                    </th>
                    <?php
                    $formattedDate = sprintf("%02d", $result['sdate']) . '/' . $month . '/' . $year;
                    ?>
                    <td class="px-6 py-4"><?php echo $formattedDate; ?></td>
                </tr>
            </tbody>
            <?php
        } else {
            ?>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $result['smonth'];?>
                    </th>
                    <?php
                    $formattedDate = sprintf("%02d", $result['sdate']) . '/' . $month . '/' . $year;
                    ?>
                    <td class="px-6 py-4"><?php echo $formattedDate; ?></td>
                </tr>
            </tbody>
            <?php
        }
    }
} else {
    ?>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td colspan="8" class="px-6 py-4 text-center">No Schedules</td>
    </tr>
<?php
}
?>


</table>


      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <div class="logout14">Logout</div>
    <a class="payroll14" href="payroll.php" style="color: white; z-index:9999;">Payroll</a>
    <div class="reports14">Reports</div>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
      <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">
      <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999;" href="../leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
      <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>
    <a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">
      <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" href="../attendence.php" style="color: black; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
      <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>
</body>
<script>
  $(document).ready(function() {
    $('#saveBtn').click(function(e) {
      e.preventDefault();

      var startMonth = $('#datepicker').val();

      $.ajax({
        type: 'POST',
        url: 'insert_schedule.php',
        data: {
          startMonth: startMonth,
          selectedDay: $('#day').val()
        },
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Payroll schedule has been saved successfully!',
          }).then(function() {
            window.location.href = 'schedule.php';
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to save payroll schedule. Please try again later.',
          });
          console.error(error);
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
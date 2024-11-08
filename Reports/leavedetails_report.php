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

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .rectangle-parent23 {
      position: absolute;
      width: 98%;
      top: calc(50% - 360px);
      /*right: 1.21%;*/
      left: 20px;
      height: 850px;
      font-size: var(--font-size-xl);
    }

    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #cacaca;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>

    <div class="rectangle-parent23">
      <div style="display: flex; position: absolute; top: -20px; right: 60px;">
        <a id="printReportLink"  href="print_leaves_report.php"  target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div>
      <div style="margin-top: 30px;overflow-x:auto;height:800px;">
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                S.No.
              </th>
              <th scope="col" class="px-6 py-3">
                Employee Name <br>
                <input id="empnameFilter" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" type="text" placeholder="Search for employee">
              </th>
              <th scope="col" class="px-6 py-3">
                Designation
              </th>
              <th scope="col" class="px-6 py-3">
                Leave Type<br>
                <select name="leavetypeFilter" id="leavetypeFilter" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);">
                  <option value=""></option>
                  <?php
                  $sql = "SELECT * from leavetype ";
                  $result = $con->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row["leavetype"] . "'>" . $row["leavetype"] . "</option>";
                    }
                  } else {
                    echo "0 results";
                  }

                  ?>
                </select>
              </th>
              <th scope="col" class="px-6 py-3">
                Applied On
              </th>
              <th scope="col" class="px-6 py-3">
                Leave From
                <div style="display: flex;">
                  <input id="fromFilter" type="date" style="height: 35px; width: 100px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);">
                </div>
              </th>
              <th scope="col" class="px-6 py-3">
                Leave To
                <div style="display: flex;">
                  <input id="toFilter" type="date" style="height: 35px; width: 100px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);">
                </div>
              </th>
              <th scope="col" class="px-6 py-3">
                Leave Status
              </th>
              <th scope="col" class="px-6 py-3">
                Leave Bal. Costed
              </th>
            </tr>
          </thead>
          <?php
          $sql = "SELECT * FROM leaves ORDER BY applied DESC";
          $que = mysqli_query($con, $sql);
          $cnt = 1;
          while ($result = mysqli_fetch_assoc($que)) {
          ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4"><?php echo $cnt++ ?></td>
              <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
              <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
              <td class="px-6 py-4"><?php echo $result['leavetype']; ?></td>
              <td class="px-6 py-4"><?php
                                    $status2 = isset($result['status2']) ? $result['status2'] : '';
                                    ?>
                <?php echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($result['applied']))); ?><BR>
                <span style='font-size:16px; border-top:0.1px solid black; white-space:nowrap;'>
                  <?php echo ($status2 == '1') ? 'Thru HR' : 'self'; ?>
                </span>
              </td>
              <td class="px-6 py-4"><?php echo date('d-m-Y', strtotime($result['from'])); ?> </td>
              <td class="px-6 py-4"><?php echo date('d-m-Y', strtotime($result['to'])); ?> </td>
              <td class="px-6 py-4">
                <?php
                $status = $result['status'];
                $status1 = $result['status1'];
                ?>
                <?php
                if ($status == '2' && $status1 == '0') {
                  echo 'Rejected';
                } elseif ($status == '2' && $status1 == '1') {
                  echo 'Approver Rejected';
                } elseif (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
                  echo 'Approved';
                } elseif ($status == '0' && $status1 == '0') {
                  echo ' HR-Action Pending';
                } elseif ($status == '4' && $status1 == '0') {
                  echo 'Pending at Manager';
                } elseif ($status == '3' && $status1 == '0') {
                  echo 'Pending at Approver';
                }
                ?>
              </td>
              <td class="px-6 py-4">
                <?php
                if (
                  (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
                  strtotime($result['from']) >= strtotime('2024-02-01')
                ) {
                  $fromDate = new DateTime($result['from']);
                  $toDate = new DateTime($result['to']);
                  if ($result['leavetype'] === "HALF DAY") {
                    echo '0.5';
                  } else {
                    $toDate->modify('+1 day');

                    $interval = new DateInterval('P1D');
                    $dateRange = new DatePeriod($fromDate, $interval, $toDate);

                    $fetchHolidaysQuery = "SELECT `date` FROM holiday";
                    $holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
                    $holidayDates = [];

                    while ($row = mysqli_fetch_assoc($holidaysResult)) {
                      $holidayDates[] = $row['date'];
                    }
                    $excludedDays = 0;
                    foreach ($dateRange as $date) {
                      if ($date->format('w') != 0 && !in_array($date->format('Y-m-d'), $holidayDates)) {
                        $excludedDays++;
                      }
                    }
                    $totalDays = $excludedDays;
                    echo $totalDays;
                  }
                } else
                  echo "";
                ?>
              </td>
            </tr>
          <?php
          }
          ?>
        </table>

      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Leave Management</a>
  </div>


 <script>
  // Filter table based on selected options and pass filter values to anchor tag
  function filterTable() {
    var empname = $('#empnameFilter').val().toLowerCase();
    var leavetype = $('#leavetypeFilter').val();
    var from = $('#fromFilter').val();
    var to = $('#toFilter').val();

    // Show Swal loading animation
    Swal.fire({
  title: 'Loading...',
  allowOutsideClick: false,
  allowEscapeKey: false,
  didOpen: () => {
    Swal.showLoading();
  }
});

    // Initialize an empty array to store non-empty filter parameters
    var filterParams = [];

    // Add empname filter parameter if not empty
    if (empname.trim() !== '') {
      filterParams.push('empname=' + empname);
    }

    // Add leavetype filter parameter if not empty
    if (leavetype.trim() !== '') {
      filterParams.push('leavetype=' + leavetype);
    }

    // Add from filter parameter if not empty
    if (from.trim() !== '') {
      filterParams.push('from=' + from);
    }

    // Add to filter parameter if not empty
    if (to.trim() !== '') {
      filterParams.push('to=' + to);
    }

    // Join the filter parameters into a single string
    var filterQueryString = filterParams.join('&');

    // Build the URL with filter parameters
    var url = 'print_leaves_report.php?' + filterQueryString;

    // Update the href attribute of the anchor tag
    $('#printReportLink').attr('href', url);

    $.ajax({
      url: 'filter_data1.php',
      method: 'POST',
      data: {
        empname: empname,
        leavetype: leavetype,
        from: from,
        to: to
      },
      success: function(response) {
        $('#attendanceTable tbody').html(response); // Update the tbody of the attendanceTable

        // Hide Swal loading animation after receiving the response
        Swal.close();
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);

        // Hide Swal loading animation in case of an error
        Swal.close();
      }
    });
  }

  $(document).ready(function() {
    // Call filterTable function when any filter option changes
    $('#empnameFilter, #leavetypeFilter, #fromFilter, #toFilter').on('input', filterTable);
  });
</script>


</body>

</html>
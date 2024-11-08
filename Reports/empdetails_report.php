<?php
session_start();
@include '../inc/config.php';

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

@include 'inc/head.php';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="css/select.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
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

    select {
      width: 250px;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>

    <div class="rectangle-parent23">
      <div style="display: flex; position: absolute; top: -20px; right: 60px;">
      <a href="javascript:void(0);" onclick="exportPDF();" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div>
      <div style="margin-top: 30px;overflow-x:auto;height:750px;">
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" style="position:sticky;top:0;">
            <tr>
              <th scope="col" class="px-6 py-3">S.No.</th>
              <th scope="col" class="px-6 py-3">Employee ID</th>
              <th scope="col" class="px-6 py-3">Employee Name
                <br><input id="empnameFilter" name="empname" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" type="text" placeholder="Search for employee">
              </th>
              <th scope="col" class="px-6 py-3">Designation <br>
                <select name="desg" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" id="desgFilter" data-placeholder="Select Designation" class="form-control select2-multi" multiple="multiple">
                </select>
              </th>
              <th scope="col" class="px-6 py-3">Department<br>
                <select name="dept" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" id="deptFilter" data-placeholder="Select Department" class="form-control select2-multi" multiple="multiple">
                  <option value=""></option>
                </select>
              </th>
              <th scope="col" class="px-6 py-3">Employement Type<br>
                <select name="empty" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" id="emptyFilter" data-placeholder="Select Employement Type" class="form-control select2-multi" multiple="multiple">
                  <option value=""></option>
                </select>
              </th>
              <th scope="col" class="px-6 py-3">Employee Status<br>
                <select name="empstatus" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" id="empstatusFilter" data-placeholder="Select Employee Status" class="form-control select2-multi" multiple="multiple">
                  <option value=""></option>
                </select>
              </th>
              <th scope="col" class="px-6 py-3">Employee Work Location<br>
                <select name="emp-work_location" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);"  id="empstatusCity" data-placeholder="Select Employee Work Location" class="form-control select2-multi" multiple="multiple" >
                  <option value=""></option>
                </select>
              </th>
              <th scope="col" class="px-6 py-3">Document View</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php
             if ($work_location == 'All') {
              $sql = "SELECT * FROM emp ORDER BY emp_no ASC";
          } else {
              $sql = "SELECT * FROM emp WHERE work_location = '$work_location' ORDER BY emp_no ASC";
          }
            $que = mysqli_query($con, $sql);
            $cnt = 1;

            while ($result = mysqli_fetch_assoc($que)) {
            ?>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4"><?php echo $cnt; ?></td>
                <td class="px-6 py-4"><?php echo $result['emp_no']; ?></td>
                <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
                <td class="px-6 py-4"><?php echo $result['dept']; ?></td>
                <td class="px-6 py-4"><?php echo $result['empty']; ?></td>
                <td class="px-6 py-4">
                  <?php
                  if ($result['empstatus'] == '0') {
                    echo 'Active';
                  } elseif ($result['empstatus'] == '1') {
                    echo 'Terminated';
                  } elseif ($result['empstatus'] == '2') {
                    echo 'Resigned';
                  }
                  ?>
                </td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"><a href="../pdfs/<?php echo $result['pdf']; ?>" target="_blank" class="btn btn--light btn--sm btn--icon" aria-label="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff6e24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                  </a></td>
              </tr>
            <?php
              $cnt++;
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Employee Management</a>
  </div>
  <!-- <script  src="js/multiselect-dropdown.js"></script> -->
  <script>
    $('.select2-multi').select2();
  </script>
 <script>
    // Function to show loading spinner
    function showLoadingSpinner() {
        Swal.fire({
            title: 'Loading...',
            html: '<div class="spinner-border" role="status"><span class="visually-hidden">Bringing up—just hold on!</span></div>',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false
        });
    }

    // Function to hide loading spinner
    function hideLoadingSpinner() {
        Swal.close();
    }

    // Fetch data from server and populate table
    function populateTable() {
        // Show loading spinner before AJAX request
        showLoadingSpinner();

        $.ajax({
            url: 'fetch_data.php', // Provide the URL to fetch data from server
            method: 'GET',
            success: function(response) {
                $('#tableBody').html(response);
                // Hide loading spinner after data is loaded
                hideLoadingSpinner();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Hide loading spinner if there's an error
                hideLoadingSpinner();
            }
        });
    }

    // Filter table based on selected options
    function filterTable() {
        // Show loading spinner before AJAX request
        showLoadingSpinner();

        var desg = $('#desgFilter').val() || [];
        var dept = $('#deptFilter').val() || [];
        var empstatus = $('#empstatusFilter').val() || [];
        var empname = $('#empnameFilter').val().toLowerCase();
        var work_location = $('#empstatusCity').val() || [];
        var empty = $('#emptyFilter').val() || [];

        $.ajax({
            url: 'filter_data.php',
            method: 'POST',
            data: {
                desg: desg,
                dept: dept,
                empstatus: empstatus,
                empname: empname,
                empty: empty,
                work_location: work_location
            },
            success: function(response) {
                $('#tableBody').html(response);
                // Hide loading spinner after data is loaded
                hideLoadingSpinner();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Hide loading spinner if there's an error
                hideLoadingSpinner();
            }
        });
    }

    // Populate the filter options
    function populateFilters() {
        // Show loading spinner before AJAX request
        showLoadingSpinner();

        $.ajax({
            url: 'populate_filters.php', // Provide the URL to fetch filter options from server
            method: 'GET',
            dataType: 'json', // Specify that the response will be JSON
            success: function(response) {
                $('#desgFilter').html(response.desg);
                $('#deptFilter').html(response.dept);
                $('#empstatusFilter').html(response.empstatus);
                $('#empstatusCity').html(response.work_location);
                $('#emptyFilter').html(response.empty);
                // Hide loading spinner after data is loaded
                hideLoadingSpinner();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Hide loading spinner if there's an error
                hideLoadingSpinner();
            }
        });
    }
    // Export as PDF with filtered data
    function exportPDF() {
        // Show loading spinner before exporting PDF
        showLoadingSpinner();

        var desg = $('#desgFilter').val();
    var dept = $('#deptFilter').val();
    var empstatus = $('#empstatusFilter').val();
    var empname = $('#empnameFilter').val();
    var work_location = $('#empstatusCity').val();
    var empty = $('#emptyFilter').val();

    // Initialize the URL with the base URL
    var url = 'print_empdetails_report.php';

    // Debug messages
    console.log('desg:', desg);
    console.log('dept:', dept);
    console.log('empstatus:', empstatus);
    console.log('empname:', empname);

    // Check if any filter value is not empty, then append it to the URL
    var params = [];
    if (empty && empty.length > 0) {
        params.push('empty=' + encodeURIComponent(empty));
    }
    if (work_location && work_location.length > 0) {
        params.push('work_location=' + encodeURIComponent(work_location));
    }
    if (desg && desg.length > 0) {
        params.push('desg=' + encodeURIComponent(desg));
    }
    if (dept && dept.length > 0) {
        params.push('dept=' + encodeURIComponent(dept));
    }
    if (empstatus && empstatus.length > 0) {
        params.push('empstatus=' + encodeURIComponent(empstatus));
    }
    if (empname) {
        params.push('empname=' + encodeURIComponent(empname));
    }

    // Append the parameters to the URL
    if (params.length > 0) {
        url += '?' + params.join('&');
    }

    // Debug message for the final URL
    console.log('Final URL:', url);

    // Open the URL in a new tab
    window.open(url, '_blank');

        // Hide loading spinner after export is completed
        setTimeout(function() {
            hideLoadingSpinner();
        }, 1000); // Adjust the timeout as needed depending on the PDF generation time
    }

    // Call functions when the document is ready
    $(document).ready(function() {
        populateTable();
        populateFilters();

        // Call filterTable function when any filter option changes
        $('#desgFilter, #deptFilter, #empstatusFilter ,#empstatusCity,#emptyFilter').change(filterTable);
        $('#empnameFilter').keyup(filterTable);
    });
</script>
</body>

</html>
<?php
session_start();
@include '../inc/config.php';
$currentDate = date("Y-m-d");
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}


// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module name from the URL (assuming the module pages have a parameter in the URL)
$module_name = basename($_SERVER['PHP_SELF']);

// Sanitize module name to prevent directory traversal attacks
$module_name = mysqli_real_escape_string($con, $module_name);

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the module is linked to the user
$sql = "SELECT COUNT(*) AS count FROM user_modules INNER JOIN modules ON user_modules.module_id = modules.id INNER JOIN user_form ON user_modules.email = user_form.email WHERE user_form.email = '$email' AND modules.module_name = '$module_name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    // If the module is not linked to the user, redirect to the login page
    header("Location: ../loginpage.php");
    exit();
}

// Fetch all users
$sql_users = "SELECT * FROM user_form";
$result_users = mysqli_query($con, $sql_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Fetch all modules
$sql_modules = "SELECT * FROM modules";
$result_modules = mysqli_query($con, $sql_modules);
$modules = mysqli_fetch_all($result_modules, MYSQLI_ASSOC);

// Fetch user-module associations
$user_module_associations = array();
$sql_user_modules = "SELECT * FROM user_modules";
$result_user_modules = mysqli_query($con, $sql_user_modules);
while ($row = mysqli_fetch_assoc($result_user_modules)) {
    $user_module_associations[$row['email']][] = $row['module_id'];
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
        <a id="exportPDFLink" href="print_salary_report.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div>
      <div style="margin-top: 30px;overflow-x:auto;height:800px;">
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th></th>
              <th scope="col" class="px-6 py-3">
                S.No.
              </th>
              <th scope="col" class="px-3 py-3">
                Employee Name <br>
                <input id="empnameFilter" name="empname" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" type="text" placeholder="Search for employee" oninput="filterTable()">
              </th>
              <th scope="col" class="px-8 py-3">
                Date of Joining
              </th>
              <th scope="col" class="px-3 py-3">
                Designation
              </th>
              <th scope="col" class="px-6 py-3">Service Length</th>
              <th scope="col" class="px-6 py-3">
                Basic Pay
              </th>
              <th scope="col" class="px-6 py-3">
                HRA
              </th>
              <th scope="col" class="px-6 py-3">
                OA
              </th>
              <th scope="col" class="px-6 py-3">
                EPF (Employee Share 12%)
              </th>
              <th scope="col" class="px-6 py-3">
                EPF (Pension 8.33%)
              </th>
              <th scope="col" class="px-6 py-3">
                EPF (Employer Share 3.67%)
              </th>
              <th scope="col" class="px-6 py-3">
                ESIC (Employee Share 0.75%)
              </th>
              <th scope="col" class="px-6 py-3">
                ESIC (Employer Share 3.25%)
              </th>
              <th scope="col" class="px-6 py-3">
                Net Payable <br>
                <select id="ascdescFilter">
                  <option value=""></option>
                  <option value="ASC">ASC</option>
                  <option value="DESC">DESC</option>
                </select>
              </th>
              <th scope="col" class="px-6 py-3">
                Gross Salary
              </th>
            </tr>
          </thead>
          <?php
          $sql = "SELECT p.*, COALESCE(e.empname, p.empname) AS empname,e.empdoj,e.exit_dt
 FROM payroll_msalarystruc p
 LEFT JOIN emp e ON p.empname = e.empname
 ORDER BY p.emp_no ASC
 ";



          $que = mysqli_query($con, $sql);
          $cnt = 1;
          while ($result = mysqli_fetch_assoc($que)) {
          ?>
            <?php
            $startDate = new DateTime($result['empdoj']);
            $exitDate = new DateTime($result['exit_dt']);

            $interval = $startDate->diff($exitDate);

            $years = $interval->y;
            $months = $interval->m;
            $days = $interval->d;

            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4"><input type="checkbox" name="selectedRow[]" onchange="updateExportPDFLink(this)"></td>
              <td class="px-6 py-4"><?php echo $cnt++; ?></td>
              <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
              <td class="px-6 py-4"><?php echo !empty($result['empdoj']) ? $result['empdoj'] : 'N/A'; ?></td>
              <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
              <td class="px-6 py-4">
                <?php
              if ($years > 0) {
                echo "$years year";
              }

              if ($months > 0) {
                echo ($years > 0 ? ', ' : '') . "$months months";
              }

              if ($days > 0) {
                echo ($years > 0 || $months > 0 ? ', ' : '') . "$days days";
              }
                ?>
              </td>
              <td class="px-6 py-4"><?php echo $result['bp']; ?></td>
              <td class="px-6 py-4"><?php echo $result['hra']; ?></td>
              <td class="px-6 py-4"><?php echo $result['oa']; ?></td>
              <td class="px-6 py-4"><?php echo $result['epf1']; ?></td>
              <td class="px-6 py-4"><?php echo $result['epf2']; ?></td>
              <td class="px-6 py-4"><?php echo $result['epf3']; ?></td>
              <td class="px-6 py-4"><?php echo $result['esi1']; ?></td>
              <td class="px-6 py-4"><?php echo $result['esi2']; ?></td>
              <td class="px-6 py-4"><?php echo $result['netpay']; ?></td>
              <td class="px-6 py-4"><?php echo $result['ctc']; ?></td>
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
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Salary Table</a>
  </div>
  <script>
    function filterTable() {
      var empnameFilter = document.getElementById("empnameFilter").value.toUpperCase();

      var table = document.getElementById("attendanceTable");
      var rows = table.getElementsByTagName("tr");

      // Loop through all table rows
      for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var empnameCell = cells[2]; // Assuming empname is the second column (index 1)

        if (empnameCell) {
          var empnameText = empnameCell.textContent || empnameCell.innerText;
          if (empnameText.toUpperCase().indexOf(empnameFilter) > -1) {
            row.style.display = "";
          } else {
            row.style.display = "none";
          }
        }
      }
      var exportPDFLink = document.getElementById("exportPDFLink");
      exportPDFLink.href = "print_salary_report.php?empnameFilter=" + encodeURIComponent(empnameFilter);
    }
  </script>
  <script>
    // Function to handle table sorting based on ASC/DESC selection
    function sortTable() {
      var table = document.getElementById("attendanceTable");
      var ascDescFilter = document.getElementById("ascdescFilter").value;
      var rows, switching, i, x, y, shouldSwitch;

      switching = true;

      while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
          shouldSwitch = false;

          x = parseFloat(rows[i].getElementsByTagName("TD")[14].innerHTML);
          y = parseFloat(rows[i + 1].getElementsByTagName("TD")[14].innerHTML);

          if (ascDescFilter === 'ASC') {
            if (x > y) {
              shouldSwitch = true;
              break;
            }
          } else if (ascDescFilter === 'DESC') {
            if (x < y) {
              shouldSwitch = true;
              break;
            }
          }
        }

        if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
        }
      }
    }

    // Call the sortTable function when the ascDescFilter value changes
    document.getElementById("ascdescFilter").addEventListener("change", sortTable);
  </script>


  <script>
    function updateExportPDFLink(checkbox) {
      console.log("Checkbox checked:", checkbox.checked); // Debug statement

      var selectedEmpnames = [];

      // Get all checkboxes with the name "selectedRow[]"
      var checkboxes = document.getElementsByName("selectedRow[]");

      // Loop through all checkboxes
      for (var i = 0; i < checkboxes.length; i++) {
        // Check if the checkbox is checked
        if (checkboxes[i].checked) {
          // Get the corresponding empname
          var empnameCell = checkboxes[i].closest("tr").getElementsByTagName("td")[2]; // Assuming empname is the second column (index 1)
          var empnameText = empnameCell.textContent || empnameCell.innerText;
          selectedEmpnames.push(empnameText.trim());
        }
      }

      // Update the href attribute of the exportPDFLink with the selected empnames
      var exportPDFLink = document.getElementById("exportPDFLink");
      exportPDFLink.href = "print_salary_report.php?empnameFilter=" + encodeURIComponent(selectedEmpnames.join(','));

      console.log("Export PDF Link updated:", exportPDFLink.href); // Debug statement
    }
  </script>



</body>

</html>
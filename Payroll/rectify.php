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
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .rectangle-div {
      position: absolute;
      border-radius: 10px;
      background-color: #ffffff;
      width: 250px;
      height: 40px;
      border: 1px solid rgb(185, 185, 185);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
    }

    .hidden111 {
      display: none;
    }

    ol {
      display: flex;
      justify-content: center;
      margin-left: 200px;
      ;
    }

    @keyframes blink {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    .blink {
      animation: blink 0.9s infinite;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -130px;">


      <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
        <form id="payrollForm">
          <div id="payrollTableContainer">
            <table id="payrollTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col" class="px-6 py-3">
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Emp Name
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Reported Issues
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Edit
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Status
                  </th>
                </tr>
              </thead>
              <?php

              $sql = "SELECT payroll_ss.*, emp.pic 
FROM payroll_ss 
LEFT JOIN emp ON payroll_ss.empname = emp.empname
WHERE payroll_ss.status1 = 2 ";


              $que = mysqli_query($con, $sql);

              if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
                  $status = $result['status'];
                  $status1 = $result['status1'];
              ?>
                  <tbody style="text-align: center;">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <td class="px-6 py-4">
                        <img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;" alt="pic">
                      </td>
                      <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                      <td class="px-6 py-4"><?php echo $result['report']; ?></td>
                      <td class="px-6 py-4">
                        <button type="button" id="<?php echo $result['empname']; ?>" data-modal-target="default-modal" data-modal-toggle="default-modal" class="edit_data6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <img src="public/edit.svg" style="height:30px;" >
                        </button>
                      </td>
                      <td class="px-6 py-4">
                        Status
                      </td>
                    </tr>
                  </tbody>
                <?php
                }
              } else {
                ?><br>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td colspan="5" class="px-6 py-4 text-center">No data</td>
                </tr>
              <?php
              }
              ?>
            </table>
          </div>
        </form>
      </div>
    </div>

    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-8/10 md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width: 120%;">
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-2" id="info_update6">
            <?php @include("view_ss_edit.php"); ?>
          </div>
          <!-- Modal footer -->
        </div>
      </div>
    </div>


    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <div class="logout14">Logout</div>
    <a class="payroll14" href="payroll.html" style="color: white; z-index:9999;">Payroll</a>
    <div class="reports14">Reports</div>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="./index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
      <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" href="employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" style="z-index: 99999;" href="./index.php" id="akarIconsdashboard">
      <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999;" href="leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
      <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" style="z-index: 99999;" id="onboarding" href="onboarding.php">Onboarding</a>
    <a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">
      <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" href="attendence.php" style="color: black; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
      <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>



  <script type="text/javascript">
    $(document).ready(function() {
      // View more button click event
      $(document).on('click', '.edit_data6', function() {
        var edit_id5 = $(this).attr('id');
        $.ajax({
          url: "view_ss_edit.php",
          type: "post",
          data: {
            edit_id5: edit_id5
          },
          success: function(data) {
            $("#info_update6").html(data);
            $("body").addClass("modal-open");
          }
        });
      });
    });
  </script>
  <script>
    var modal = document.getElementById('default-modal');
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
      fetchData();
    }

    function showLoading() {
      Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });
    }

    function hideLoading() {
      Swal.close();
    }

    function fetchData() {
      showLoading(); // Show loading animation
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          hideLoading(); // Hide loading animation
          var data = JSON.parse(xhr.responseText);
          if (data) {
            console.log("Data fetched successfully:", data);
            document.getElementById("empName").innerText = data.empname;
            document.getElementById("empHRA").value = data.hra;
            document.getElementById("fgs").value = data.fgs;
            document.getElementById("fbp").value = data.fbp;
            document.getElementById("fhra").value = data.fhra;
            document.getElementById("foa").value = data.foa;
            document.getElementById("monthdays").value = data.monthdays;
            document.getElementById("present").value = data.present;
            document.getElementById("leaves").value = data.leaves;
            document.getElementById("sundays").value = data.sundays;
            document.getElementById("flop").value = data.flop;
            document.getElementById("paydays").value = data.paydays;
            document.getElementById("oa").value = data.oa;
            document.getElementById("bp").value = data.bp;
            document.getElementById("gross").value = data.gross;
            document.getElementById("epf1").value = data.epf1;
            document.getElementById("esi1").value = data.esi1;
            document.getElementById("tds").value = data.tds;
            document.getElementById("emi").value = data.emi;
            document.getElementById("lopamt").value = data.lopamt;
            document.getElementById("misc").value = data.misc;
            document.getElementById("totaldeduct").value = data.totaldeduct;
            document.getElementById("bonus").value = data.bonus;
            document.getElementById("payout").value = data.payout;
            modal.setAttribute("data-id", data.id);
          } else {
            console.log("No data fetched");
            showNoDataAvailable(); // Show "No Data Available" message
          }
        }
      };
      xhr.open("GET", "fetch_new_data.php", true);
      xhr.send();
    }

    function showNoDataAvailable() {
      Swal.fire({
        icon: 'error',
        title: 'No Data Available',
        text: 'There is no data further available to confirm !',
        showConfirmButton: false,
        timer: 2000
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          modal.style.display = "none";
          location.reload(); // Reload the page
        }
      });
    }

    // Prevent the modal from closing automatically on Confirm
    document.getElementById("confirmBtn").onclick = function() {
      // Get the id from the modal content
      var id = modal.getAttribute("data-id");

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var data = JSON.parse(xhr.responseText);
          if (data) {
            console.log("Confirm button clicked for ID: " + id);
            console.log("Response:", xhr.responseText);
            showLoading(); // Show loading animation
            setTimeout(function() {
              hideLoading(); // Hide loading animation after a delay
              showSuccessMessage(); // Show "Success" message
            }, 1000); // Adjust the delay as needed
          } else {
            modal.style.display = "none";
          }
        }
      };
      xhr.open("POST", "fetch_new_data.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("id=" + id + "&confirm=1");
    }

    function showSuccessMessage() {
      Swal.fire({
        icon: 'success',
        title: 'Confirmed!',
        text: 'Data has been confirmed successfully.',
        showConfirmButton: false,
        timer: 1000
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          // Load the next data
          fetchData();
        }
      });
    }

    span.onclick = function() {
      modal.style.display = "none";
    }
  </script>




  <script>
    function submitFormData() {
      var formData = new FormData();
      // Iterate through each table row
      $("#payrollTable tbody tr").each(function() {
        // Get the input elements within the current row
        var inputs = $(this).find('input[name^="confirm"]:checked');
        // Check if at least one checkbox is checked in the row
        if (inputs.length > 0) {
          // Get the data attributes from the row
          var empName = $(this).find('td:eq(1)').text().trim();
          var grossSalary = $(this).find('td:eq(2)').text().trim();
          var loanDeductables = $(this).find('td:eq(3)').text().trim();
          var lop = $(this).find('td:eq(4)').text().trim();
          var epf = $(this).find('td:eq(5)').text().trim();
          var esi = $(this).find('td:eq(6)').text().trim();
          var netSalary = $(this).find('td:eq(7)').text().trim();
          // Append the data to the formData object
          formData.append('confirm[]', empName);
          formData.append('gross_salary[' + empName + ']', grossSalary);
          formData.append('loan_deductables[' + empName + ']', loanDeductables);
          formData.append('lop[' + empName + ']', lop);
          formData.append('epf[' + empName + ']', epf);
          formData.append('esi[' + empName + ']', esi);
          formData.append('net_salary[' + empName + ']', netSalary);
        }
      });

      // Check if at least one checkbox is checked
      if ($('input[name="confirm[]"]:checked').length > 0) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to confirm payroll statements?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, confirm',
          cancelButtonText: 'No, cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'POST',
              url: 'insert_statement.php',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                console.log('Success:', response);
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: response,
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = 'salarystatement.php';
                    $('#payrollForm')[0].reset();
                  }
                });
              },
              error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'An error occurred while processing your request.',
                  confirmButtonText: 'OK'
                });
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'The submission of payroll statements was cancelled',
              icon: 'info',
              confirmButtonText: 'OK'
            });
          }
        });
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Please select at least one employee to confirm payroll statements.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    }
  </script>

</body>

</html>
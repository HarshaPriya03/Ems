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
  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11" /> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
    .udbtn:hover {
      color: black !important;
      background-color: white !important;
      outline: 1px solid #F46114;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -60px;">
      <div style="background-color: white; width: 60%; height: 380px; border-radius: 20px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5); margin-left: auto; margin-right: auto;">
        <p style="margin-left: 20px; padding-top: 20px;">Add Bank Details</p>
        <hr style="width: 95%;" /><br>
        <form id="updateForm">
          <label for="" style="margin-left: 20px; font-weight: lighter;">Select Bank Account:</label>
          <select name="bank_name" id="bank_name" style="margin-left: 20px; width: 400px; height: 40px; font-size: 20px; border-radius: 5px;">
            <option value="">--select--</option>
            <option value="SBI">State Bank Of India (SBI)</option>
            <option value="PNB">Punjab National Bank (PNB)</option>
            <option value="IB">Indian Bank (IB)</option>
            <option value="BOI">Bank Of India (BOI)</option>
            <option value="UCO">UCO Bank</option>
            <option value="UBI">Union Bank Of India</option>
            <option value="CBI">Central Bank Of India</option>
            <option value="BOB">Bank Of Baroda</option>
            <option value="BOM">Bank Of Maharashtra</option>
            <option value="CB">Canara Bank</option>
            <option value="IOB">Indian Overseas Bank</option>
            <option value="ICICI">ICICI Bank</option>
            <option value="HDFC">HDFC Bank</option>
            <option value="AB">Axis Bank</option>
            <option value="KMB">Kotak Mahindra Bank</option>
            <option value="FB">Federal Bank</option>
            <option value="FB">Karur Vysya Bank</option>
          </select> <br> <br>
          <label for="" style="margin-left: 20px; font-weight: lighter;">Enter IFSC Code:</label>
          <input name="ifsc" id="ifsc" type="text" style="margin-left: 62px; font-size: 20px; width: 395px; height: 40px; border-radius: 5px;"><br> <br>
          <input name="default_bank" id="default_bank" type="checkbox" style="margin-left: 20px;">
          <label for="" style=" font-weight: lighter;">Set as default salary account</label> <br><br><br>
          <button type="submit" class="udbtn" style="background-color: #FB8A0B; color: white; border: none; border-radius: 5px; width: 100px; height: 35px; font-size: 18px; margin-left: 20px;">Submit</button>
        </form>
      </div>

      <br>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Bank Name
            </th>
            <th scope="col" class="px-6 py-3">
              IFSC Code
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <?php
        $sql = "SELECT * FROM payroll_bank  ORDER BY ID ASC";
        $que = mysqli_query($con, $sql);
        $cnt = 1;
        while ($result = mysqli_fetch_assoc($que)) {
        ?>
          <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <div style="display: flex; align-items: center;">
                  <?php echo $result['bank_name']; ?>
                  <?php if ($result['default_bank'] == 'Yes') { ?>
                    <img src="https://cdn4.iconfinder.com/data/icons/flat-common-10/32/bank-ok-512.png" width="23" style="margin-top: -4px;margin-left: 5px;">
                    <span style="font-size: 13px; color: #50C878;margin-left: 2px;"> Default Salary A/C</span>
                  <?php } ?>
                </div>
              </td>
              <td class="px-6 py-4">
                <?php echo $result['ifsc']; ?>
              </td>
              <td class="px-6 py-4">
                <div style="display: flex; gap: 20px;">
                  <a href=""><img src="./public/edit.png" width="35px" alt=""></a>
                  <a href=""><img src="./public/delete1.png" width="35px" alt=""></a>
                </div>
              </td>
            </tr>
          <?php $cnt++;
        } ?>
          </tbody>
      </table>
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
    <a href="./payroll.html" class="payroll14" style="color: white; z-index:9999;">Payroll</a>
    <a class="reports14">Reports</a>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="./index.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
      <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" href="employee-management.php" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" href="./index.php" id="akarIconsdashboard">
      <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" href="leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
      <img class="vector-icon75" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" id="onboarding" href="onboarding.php">Onboarding</a>
    <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
      <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" href="attendence.php" style="color: black;">Attendance</a>
    <a class="uitcalender14">
      <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>
  <script>
    $(document).ready(function() {
      $("#updateForm").submit(function(e) {
        e.preventDefault();

        var bank_name = $("#bank_name").val();
        var ifsc = $("#ifsc").val();
        var default_bank = $("#default_bank").is(":checked") ? "Yes" : "No";

        $.ajax({
          type: "POST",
          url: "insert_bank.php",
          data: {
            bank_name: bank_name,
            ifsc: ifsc,
            default_bank: default_bank
          },
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'added!',
              text: response,
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'addbankpayroll.php';
              }
            });
          }
        });
      });
    });
  </script>

</body>

</html>
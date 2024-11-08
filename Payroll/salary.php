
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        .udbtn:hover {
            color: black !important;
            background-color: white !important;
            outline: 1px solid #F46114;
        }

        .hidden-btn {
            display: none;
        }

        tr:hover .hidden-btn {
            display: block;
            transition: 300ms ease all;
        }

        tr:hover .hideon1 {
            display: none;
            transition: 300ms ease all;
        }
    </style>
</head>

<body>
    <div class="attendence4">
        <div class="bg14"></div>
        <div class="rectangle-parent23" style="margin-top: -60px;">
            
            <?php
            $sql4 = "SELECT COUNT(*) AS count FROM payroll_msalarystruc";
            $result4 = $con->query($sql4);
            $row4 = $result4->fetch_assoc();
            $count4 = $row4['count'];
            ?>
            <div class="flex items-center text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" style=" background-color: rgb(250, 253, 255); font-size: 18px; width: 350px; margin-bottom: 20px; padding: 8px;">Total Employees Listed in Payroll =    <p class="bg-blue-100 text-blue-800 text-lg font-semibold inline-flex items-center ml-2 p-1.5 rounded dark:bg-blue-200 dark:text-blue-800"><?php echo $count4; ?></p> </div>
        
<div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
  <h2 id="accordion-color-heading-1">
    <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-1" aria-expanded="true" aria-controls="accordion-color-body-1">
      <span>Employee Fixed Salary Compensation Breakdown Table</span>
      <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
      </svg>
    </button>
  </h2>
  <div id="accordion-color-body-1" class="hidden bg-gray-50" aria-labelledby="accordion-color-heading-1">
    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
      <p class="mb-2 text-gray-500 dark:text-gray-400">
            <svg class="flex-shrink-0 inline w-7 h-7 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
          This table provides a comprehensive overview of the components comprising an employee's fixed salary. It encompasses base pay, allowances, and deductions, providing transparency and clarity regarding the fundamental components of an individual's compensation package</p>
</div>
  </div>
</div>
<div style="overflow-x:hidden;height:72%;">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead style="position:sticky;top:0;"  class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr style="border-top: 1px solid rgb(224, 224, 224);">
                        <th colspan="2" style="text-align: center;" scope="col" class="px-6 py-3">
                            Employee Details
                        </th>
                        <th colspan="3" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.5);" scope="col" class="px-6 py-3">
                            Earnings
                        </th>
                        <th style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.5);" scope="col" class="px-6 py-3">
                            Earnings
                        </th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 161, 161, 0.5);" class="px-6 py-3">
                            Deductions
                        </th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.5);" class="px-6 py-3">
                            NET Payable
                        </th>
                    </tr>
                    <tr style="border-top: 1px solid rgb(224, 224, 224);">
                        <th scope="col" colspan="2" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);" class="px-6 py-3">Employee Name</th>
                        <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Basic Pay</th>
                        <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">HRA</th>
                        <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Other Allowances</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Pension, Bonus, ...</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">EPF, ESI, ...</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.2);" class="px-6 py-3">Total Payable</th>
                    </tr>
                </thead>
                <?php
          $sql = "SELECT p.*, emp.*,
          COALESCE(emp.pic, 'default_pic.jpg') AS pic, 
          pa.*
   FROM payroll_msalarystruc AS p
   LEFT JOIN emp ON p.empname = emp.empname
   LEFT JOIN payroll_msalarystruc AS pa ON p.empname = pa.empname
   ORDER BY p.emp_no ASC";
   
  $que = mysqli_query($con, $sql);
  $cnt = 1;
  
  while ($result = mysqli_fetch_assoc($que)) {
    $total_eycontributions = $result['epf2'] + $result['epf3'] + $result['esi2'];
    $total_empcontributions = $result['epf1'] + $result['esi1'];
      if ($result['empname'] == "YERRAMSETTI SUSANTHA SANKAR") {
          $result['bp'] = "14000";
          $result['hra'] = "7000";
          $result['oa'] = "7000";
          $result['netpay'] = "26320";
          $total_eycontributions = "1680";
          $total_empcontributions = "1680";
      }
  
     
  ?>
      <tbody>
          <tr style="border-top: 1px solid rgb(224, 224, 224);" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="py-4">
                  <img src="../pics/<?php echo $result['pic']; ?>" style="border-radius: 50%; height: 50px; width: 50px;" alt="N/A"></td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);">
                  <?php echo $result['empname']; ?> <br>
                  <span style="font-size: 13px; text-align: left; color: rgb(179, 179, 179);"><?php echo $result['desg']; ?></span>
              </td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
                  <?php echo $result['bp']; ?>
              </td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                  <?php echo $result['hra']; ?>
              </td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                  <?php echo $result['oa']; ?>
              </td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);">
                  <span class="hideon1"><?php echo $total_eycontributions ?></span>
                  <button data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                      Earnings
                  </button>
              </td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);">
                  <span class="hideon1"><?php echo $total_empcontributions ?></span>
                  <button data-modal-target="default-modal" data-modal-toggle="default-modal" id="<?php echo $result['empname']; ?>" class="edit_data5 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                      Deductions
                  </button>
              </td>
              <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.2);">
                  <?php echo $result['netpay']; ?>
              </td>
          </tr>
      </tbody>
  <?php $cnt++;
  } ?>
                    </tbody>
                    <?php
                    $sql = "SELECT 
                     (SELECT SUM(epf2) FROM payroll_msalarystruc) AS total_epf2, 
                     (SELECT SUM(epf3) FROM payroll_msalarystruc) AS total_epf3, 
                     (SELECT SUM(esi2) FROM payroll_msalarystruc) AS total_esi2, 
            (SELECT SUM(esi1) FROM payroll_msalarystruc) AS total_esi1, 
            (SELECT SUM(epf1) FROM payroll_msalarystruc) AS total_epf1, 
            (SELECT SUM(netpay) FROM payroll_msalarystruc) AS total_netpay, 
            (SELECT SUM(oa) FROM payroll_msalarystruc) AS total_oa, 
           (SELECT SUM(hra) FROM payroll_msalarystruc) AS total_hra, 
           (SELECT SUM(bp) FROM payroll_msalarystruc) AS total_abp";

                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $total_abp = $row['total_abp'];
                        $total_hra = $row['total_hra'];
                        $total_oa = $row['total_oa'];
                        $total_netpay = $row['total_netpay'];
                        $total_epf1 = $row['total_epf1'];
                        $total_esi1 = $row['total_esi1'];
                        $total_empcontributions = $total_epf1 + $total_esi1;
                        $total_epf2 = $row['total_epf2'];
                        $total_esi2 = $row['total_esi2'];
                        $total_epf3 = $row['total_epf3'];
                        $total_eycontributions = $total_epf2 + $total_epf3 + $total_esi2;
                    } else {
                        echo "Error executing query: " . mysqli_error($con);
                    }
                    mysqli_free_result($result);
                    ?>

                    <tfoot style="position:sticky;bottom:0;"  class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1px solid rgb(224, 224, 224); font-weight: 500;"></td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_abp ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1px solid rgb(224, 224, 224); font-weight: 500;">₹ <?php echo $total_hra ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1px solid rgb(224, 224, 224); font-weight: 500;">₹ <?php echo $total_oa ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_eycontributions ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_empcontributions ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_netpay ?>/-</td>
                    </tfoot>
            </table>
            </div>
            <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                Deductions Summary <br>
                                <!-- <span style="font-size: 16px; font-weight: normal;">jan 15, 2024</span> -->
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4" id="info_update5">
                            <?php @include("view-salaryded.php"); ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Additions Summary <br>
                                <!-- <span style="font-size: 16px; font-weight: normal;">jan 15, 2024</span> -->
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modals">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4" id="info_update6">
                            <?php @include("view-salaryadd.php"); ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <!-- <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button> -->
                            <button data-modal-hide="default-modals" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
            </div>
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
    <div class="logout14" style="font-size:25px; font-weight:normal; margin-top:-8px;">Logout</div>
    <a href="./payroll.php" class="payroll14" style="color: white; z-index:9999; font-size:25px; font-weight:350; margin-top:-5px;">Payroll</a>
    <a class="reports14" style="font-size:25px; font-weight:350; margin-top:-5px;">Reports</a>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

    

    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" style="font-size:25px; font-weight:350; margin-top:-5px;" href="../index.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
        <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" style="font-size:25px; font-weight:350; margin-top:-5px;" href="../employee-management.php" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" href="../index.php" id="akarIconsdashboard">
        <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="font-size:25px; font-weight:350; margin-top:-5px;" href="../leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
        <img class="vector-icon75" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" style="font-size:25px; font-weight:350; margin-top:-5px;" id="onboarding" href="../onboarding.php">Onboarding</a>
    <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
        <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" style="font-size:25px; font-weight:350; margin-top:-5px; color: black;" href="../attendence.php">Attendance</a>
    <a class="uitcalender14">
        <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.edit_data5', function() {
                var edit_id5 = $(this).attr('id');
                $.ajax({
                    url: "view-salaryded.php",
                    type: "post",
                    data: {
                        edit_id5: edit_id5
                    },
                    success: function(data) {
                        $("#info_update5").html(data);
                        $("body").addClass("modal-open");
                    }
                });
            });

            $(document).on('click', '[data-modal-hide="default-modal"]', function() {
                $("#default-modal").removeClass("show");
                $("body").removeClass("modal-open");
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.edit_data6', function() {
                var edit_id5 = $(this).attr('id');
                $.ajax({
                    url: "view-salaryadd.php",
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

            $(document).on('click', '[data-modal-hide="default-modals"]', function() {
                $("#default-modals").removeClass("show");
                $("body").removeClass("modal-open");
            });

        });
    </script>
</body>

</html>
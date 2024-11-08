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
  <script>
    function toggleCheckboxes() {
      var masterCheckbox = document.getElementById("masterCheckbox");
      var checkboxes = document.querySelectorAll("#payrollTable tbody input[type='checkbox']");
      checkboxes.forEach(function(checkbox) {
        checkbox.checked = masterCheckbox.checked;
      });
    }
  </script>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top:-60px;">
      <div style="display: flex; position: absolute; top: 0px; right: 60px;">
        <a href="print-details_ss.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF[1]</span>
          </div>
        </a>
        <a href="print-details_ssa.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF[2]</span>
          </div>
        </a>

        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="relative inline-flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <img class=" me-2" src="./public/pdf.png" width="25px">
          Bank Statement
          <!--<span class="bg-yellow-200 text-xs font-medium text-orange-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-orange-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0 blink">NEW</span>-->
        </button>
           <a href="exportCSV_bank.php" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
          <div style="display: flex; gap: 10px;"><img src="./public/csv.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as CSV</span>
          </div>
        </a>
      </div>
      <?php
            $currentMonthYear = date('F Y');
            ?>
      <!-- Main modal -->
      <div id="crud-modal" data-modal-placement="top-right" style="margin-top:200px; right:40px;" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-10/12 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5  rounded-t">
              <h3 class="text-lg text-gray-900 dark:text-white" style="text-align:center;">
              Please enter the <b>Transaction Ref. Number</b> to access <b><?php echo $currentMonthYear ?></b> salary statement.
              </h3>
             
            </div>
            <!-- Modal body -->
            <?php
            $currentMonthYear = date('F Y');
            ?>
            <form id="transId" class="p-4 md:p-5">
              <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction Reference Number</label>
                  <input type="text" name="transid" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type here" required="">
                </div>
                <input type="hidden" value="<?php echo $currentMonthYear ?>" name="salarymonth">
              </div>
           
              <button  type="submit" data-drawer-target="drawer-contact" data-drawer-show="drawer-contact" aria-controls="drawer-contact" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-5.5 h-5.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 18 23">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-4m5-13v4a1 1 0 0 1-1 1H5m0 6h9m0 0-2-2m2 2-2 2" />
        </svg>
        Save & Access
        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
        </svg>
      </button>
            </form>
          </div>
        </div>
      </div>


      <button id="openModalBtn" data-modal-target="default-modal" data-modal-toggle="default-modal" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Confirm
      </button>
      <br> <br />
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
                  View
                </th>
                <th scope="col" class="px-6 py-3">
                  Pay Slip
                </th>
              </tr>
            </thead>
            <?php

            $sql = "SELECT payroll_ss.*, emp.pic 
FROM payroll_ss 
LEFT JOIN emp ON payroll_ss.empname = emp.empname
WHERE payroll_ss.status = 1 ORDER BY confirm1 DESC";


            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
              while ($result = mysqli_fetch_assoc($que)) {
            ?>
                <tbody style="text-align: center;">
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                      <img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;" alt="pic">
                    </td>
                    <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                    <td class="px-6 py-4">
                      <button data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-s px-2 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        View more
                      </button>
                    </td>
                    <td class="px-6 py-4">
                      <a href="print-details_pslip.php?empname=<?php echo urlencode($result['empname']); ?>" target="_blank" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                        <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                          <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                      </a>
                    </td>
                  </tr>

                </tbody>
              <?php
              }
            } else {
              ?><br>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="4" class="px-6 py-4 text-center">No data</td>
              </tr>
            <?php
            }
            ?>
          </table>
        </div>
      </form>
    </div>
    <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-8/10 md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width: 113%;">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Salary Details <br>
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
          <div class="p-4 md:p-5 space-y-2" id="info_update6">
            <?php @include("view_ss.php"); ?>
          </div>
          <!-- Modal footer -->
        </div>
      </div>
    </div>


    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-10/12 md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width: 113%;">
          <div class="p-4 md:p-5 space-y-4">
            <p style="display:flex; justify-content:center; color: #666666;" id="empName"></p>
            <hr />
            <p style="display:flex; margin-left:20px; margin-top:0px;">Fixed Salary Components:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary:</label>
                <div style="display: flex; margin-left: 16px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="fgs" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="fhra" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="foa" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="fbp" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Days Calculation:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="monthdays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Present Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="present" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Leaves:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="leaves" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Week Off's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="sundays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="flop" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pay Day's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="paydays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Salary as per number of days:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="gross" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="empHRA" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                <div style="display: flex; margin-left:20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="oa" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="bp" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Deductions:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="epf1" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESIC:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="esi1" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">TDS:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="tds" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Loan EMI:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="emi" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="lopamt" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>

              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Misc. Deductions:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="misc" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="totaldeduct" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Additional Compensation:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Bonus:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="bonus" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <hr />
            <div style="display: flex; justify-content:center;">
              <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Net Payout:</label>
              <div style="display: flex; margin-left:10px;">
                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                <input name="ags" id="payout" type="text" style="font-size: 18px; width: 110px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button id="confirmBtn" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
            <button data-modal-hide="default-modal" type="button" class="close py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
          </div>
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
    <a class="payroll14" href="./payroll.php" style="color: white; z-index:9999;">Payroll</a>
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
  <script>
    $(document).ready(function() {
      $("#transId").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
          type: "POST",
          url: "update_ss1.php",
          data: formData,
          dataType: "json",
          success: function(response) {
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
              }).then(function() {
                window.open('print-details_bank.php', '_blank');
                window.location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message,
              });
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while processing your request. Please try again later.',
            });
          }
        });
      });
    });
  </script>


  <script>
    // Function to fetch data from the server and update the table
    function updateTable() {
      $.ajax({
        url: 'check-status.php',
        type: 'GET',
        success: function(response) {
          // If there's a need to reload the table
          if (response === 'reload') {
            // Reload only the table content
            $("#payrollTableContainer").load(location.href + " #payrollTable");
          }
        },
        error: function(xhr, status, error) {
          console.error("Error:", error);
        }
      });
    }

    setInterval(updateTable, 1000); // Adjust the interval as per your requirement
  </script>



  <script type="text/javascript">
    $(document).ready(function() {
      // View more button click event
      $(document).on('click', '.edit_data6', function() {
        var edit_id5 = $(this).attr('id');
        $.ajax({
          url: "view_ss.php",
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
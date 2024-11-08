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

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      width: 80%;
      max-width: 600px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
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
    <div class="rectangle-parent23">
      <div id="marketing-banner" style="position:absolute; top:-82px; margin-left:-425px; width: 40%;" tabindex="-1" class="flex justify-between w-[calc(100%-40rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
          <a href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
            <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
            </svg>

          </a>
          <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">Here, User needs to confirm the salary adjustments for each employee. This includes reviewing the finalized salary structure, obtaining necessary approvals, and confirming the salary adjustments with HR before processing the statements.
          </p>
        </div>
      </div>
      <div style="position: absolute; right: 0; top: -90px; background-color: white; width: 460px; height: 134px; border-radius: 7px;  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); display: flex;">
        <div style="display: flex; align-items: center; border-right: 1px solid #dadada; padding-left: 10px;">
          <img src="../public/analytics.png" width="100px" alt="">
        </div>
        <?php
       $sql4 = "SELECT COUNT(*) AS count FROM payroll_ss WHERE status1 = 1";
       $result4 = $con->query($sql4);
       $row4 = $result4->fetch_assoc();
       $count4 = $row4['count'];

       $sql5 = "SELECT COUNT(*) AS count1 FROM payroll_ss WHERE status1 = 2";
$result4 = $con->query($sql5);
$row4 = $result4->fetch_assoc();
$count5 = $row4['count1'];

$sql6 = "SELECT COUNT(*) AS count2 FROM payroll_ss WHERE status1 = 0";
$result4 = $con->query($sql6);
$row4 = $result4->fetch_assoc();
$count6 = $row4['count2'];

         ?>
        <div id="count">
          <div style="display: flex; gap: 10px; margin-left: 20px; margin-top: 10px;">
            <div style="background-color: #d3d3d3; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 5px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
              <img src="../public/confirmed.png" width="25px" alt="">
            </div>
            <p style="color: #666666; font-size: 18px; margin-top: 3px;">Pending Confirmation</p>
            <p style="color: #666666; font-size: 20px; margin-top: 2px;">- <?php echo $count6; ?> </p>
          </div>
          <div style="display: flex; gap: 10px; margin-left: 20px; margin-top: 10px;">
            <div style="background-color: #d3d3d3; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 5px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
              <img src="../public/reported.png" width="25px" alt="">
            </div>
            <p style="color: #666666; font-size: 18px; margin-top: 3px;">Confirmed employees</p>
            <p style="color: #666666; font-size: 20px; margin-top: 2px; margin-left: 2px;">- <?php echo $count4; ?></p>
          </div>
          <div style="display: flex; gap: 10px; margin-left: 20px; margin-top: 10px;">
            <div style="background-color: #d3d3d3; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 5px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
              <img src="../public/rectified.png" width="25px" alt="">
            </div>
            <p style="color: #666666; font-size: 18px; margin-top: 3px;">Reported employees</p>
            <p style="color: #666666; font-size: 20px; margin-top: 2px; margin-left: 10px;">- <?php echo $count5; ?></p>
          </div>
        </div>
      </div>
      <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" style="margin-top:-200px;" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Approve Payroll
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                You are about to approve this payroll for March, 2024. Once you approve it, you can make payments for all your employees on the paydate 06/04/2024.
              </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
              <button data-modal-hide="static-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Confirm & Approve
              </button>
              <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
            </div>
          </div>
        </div>
      </div>
  

      <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
        <form id="payrollForm">
          <div id="payrollTableContainer">
            <table id="payrollTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 ">
                    <td>
                            <button onClick="refreshPage()" style="border:1px solid #3964bb" type="button" class="relative inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-blue-600 bg-gray-100 rounded-lg hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

<svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
</svg>

Reload
</button>
                        
                    </td>
                  <td colspan="8">
                              
                    <div class="inline-flex self-center items-center" style="padding:10px; gap: 10px;">
            

                      <button type="button" id="openModalBtn" data-modal-target="default-modal" data-modal-toggle="default-modal" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Confirm
                      </button>
                      <!--<span class="bg-yellow-200 text-xs font-medium text-orange-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-orange-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0 blink">NEW</span>-->
                      <a id="approveButton">
                      <?php
$query = "SELECT COUNT(*) AS count FROM payroll_ss WHERE status1 = 1";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    // If count matches the total number of rows, enable the button
    $query_total_rows = "SELECT COUNT(*) AS total_rows FROM payroll_ss";
    $result_total_rows = mysqli_query($con, $query_total_rows);

    if ($result_total_rows) {
        $row_total_rows = mysqli_fetch_assoc($result_total_rows);
        $total_rows = $row_total_rows['total_rows'];

        if ($count == $total_rows) {
       echo '
   
<button onclick="confirmSubmission()"  type="button" class="relative inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

<svg class="w-6 h-6 me-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd"/>
</svg>

  Approve Data Submission
  <div class="absolute inline-flex items-center justify-center w-7 h-5 text-xs font-bold text-white bg-red-500  -top-2 -end-2 blink " style="margin-top:0px;">NEW</div>
</button>

   ';
    } else {
        // If count is not 0, disable the button
        echo '';
    }
} else {
    // Handle error if the query fails
    $disabled = 'disabled';
}
} else {
  // Handle error if the query to get count fails
  $disabled = 'disabled';
}
?>
                
                      </a>
                    </div>
                  </td>
                </tr>
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
                    Status
                  </th>
                </tr>
              </thead>
              <?php

              $sql = "SELECT payroll_ss.*, emp.pic 
FROM payroll_ss 
LEFT JOIN emp ON payroll_ss.empname = emp.empname
WHERE payroll_ss.status1 = 1 ORDER BY confirm1 DESC";


              $que = mysqli_query($con, $sql);

              if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
                  $status = $result['status'];
                  $status1 = $result['status1'];
              ?>
                  <tbody style="text-align: center;">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <td class="px-6 py-4">
                        <img src="../../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;" alt="pic">
                      </td>
                      <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                      <td class="px-6 py-4 text-center">
                        <button style="margin-left:180px;" data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-s px-2 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                          View more
                        </button>
                      </td>
                      <td class="px-6 py-4">
                        <?php
                        if ($status == 1 &&  $status1 = 0) {
                          echo "<span>HR Confirmed </span>";
                        } elseif ($status == 1 &&  $status1 = 1) {
                          echo "<span>Accountant Confirmed</span>";
                        } else {
                        }
                        ?>
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
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="../public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="monthdays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Present Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="../public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="present" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Leaves:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="../public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="leaves" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Week Off's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="../public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="sundays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="../public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="flop" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pay Day's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="../public/calendar3d.png" width="25px" /></div>
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
            <button style="position: absolute; right: 20px;" id="confirmBtn" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" style="position: absolute; right: 120px;" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Report</button>

            <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(90%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width: 130%;">
          <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
          <div class="p-4 md:p-5 text-center">
            <form id="employeeSS">
            <h1 style="font-size: 25px; font-weight: 700; text-align: center;">Confirm EMP Report</h1>
            <h1 style="font-size: 16px; font-weight: 400; text-align: center; color:#444444">
             This modal prompts for salary correction report to HR. Streamlining communication for accurate compensation adjustments.</h1>
              <input type="hidden" name="empname"  value="">
            <p style="font-size: 18px; margin-top: 25px; position:absolute; left:40px;"><span style="color: rgb(145, 145, 145);">
            Name:</span> <span id="empnameInSecondModal" style="margin-left: 10px; font-size:17px; margin-bottom: 10px;"></span></p>
            <label for="message" style="text-align: start; margin-left: 20px; color: rgb(145, 145, 145); font-size: 18px; font-weight: normal; margin-top: 60px;" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason:</label>
            <textarea name="report" style=" margin-left: 20px; width: 92%;" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your reasons here..."></textarea><br>
            <button  id="saveReportBtn" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
              Yes, Report
            </button>
            <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
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
    <script>
        function refreshPage(){
    window.location.reload();
} 
    </script>
<script>
  function confirmSubmission() {
    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to approve the data submission?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, approve',
      cancelButtonText: 'No, cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: 'Confirmed!',
          text: 'Data submission approved successfully.',
          showConfirmButton: false,
          timer: 2000 // Redirect after 3 seconds
        }).then(() => {
          window.location.href = 'acc_summary.php';
        });
      }
    });
  }
</script>
  <script>
  document.querySelector('[data-modal-target="popup-modal"]').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior
    
    // Get the empname from the first modal
    var empname = document.querySelector('#empName').innerText.trim(); // Assuming the empname is displayed in an element with id 'empName'
    
    // Set the empname in the second modal span element
    document.querySelector('#empnameInSecondModal').innerText = empname;
    
    // Set the empname in the input field
    document.querySelector('input[name="empname"]').value = empname;

    // Show the second modal
    document.querySelector('#popup-modal').classList.remove('hidden');
  });
</script>

<script>
document.getElementById('saveReportBtn').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent default form submission
  
  // Get the form data
  var formData = new FormData(document.getElementById('employeeSS'));
  
  // Send an AJAX request
  fetch('save_report.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    // Handle the response
    if (data.success) {
      document.getElementById('message').value = '';
      confirmData(); // Call the function to handle the confirmation
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error saving report: ' + data.message,
        confirmButtonText: 'OK'
      });
    }
  })
  .catch(error => {
    // Handle any errors that occur during the request
    console.error('Error saving report:', error);
    // Show an error message using SweetAlert
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'An unexpected error occurred',
      confirmButtonText: 'OK'
    });
  });
});

function confirmData() {
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
  xhr.open("POST", "fetch_new_data2.php", true);
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

</script>

  <script>
    $(document).ready(function() {
      $('#steps').click(function(e) {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'update_steps.php',
          data: new FormData($('#employeeForm')[0]),
          processData: false,
          contentType: false,
          success: function(response) {
            console.log('Success:', response);
            Swal.fire({
              icon: 'success',
              title: 'Confirmed!',
              text: response,
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'summary.php';
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
                window.open('exportCSV_bank.php', '_blank');
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
  // Function to fetch data from the server and update the table and count
  function updateTable() {
    $.ajax({
      url: 'check-status.php',
      type: 'GET',
      success: function(response) {
        // If there's a need to reload the table
        if (response === 'reload') {
          // Reload the table content
          $("#payrollTableContainer").load(location.href + " #payrollTable");
          // Reload the content of the "count" div
          $("#count").load(location.href + " #count");
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
          url: "../view_ss.php",
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
      xhr.open("GET", "../fetch_new_data1.php", true);
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
      xhr.open("POST", "fetch_new_data1.php", true);
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
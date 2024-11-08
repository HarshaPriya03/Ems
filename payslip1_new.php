<?php

@include 'inc/config.php';

session_start();

if(!isset($_SESSION['user_name']) && !isset($_SESSION['name'])){
   header('location:main.php');
}

$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./global.css" />
    <link rel="stylesheet" href="./salary.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  </head>
  <body>
    <div class="salary1">
      <div class="bg1"></div>
      <img class="salary-child" alt="" src="./public1/rectangle-1@2x.png" />

      <img class="salary-item" alt="" src="./public1/rectangle-2@2x.png" />

      <a class="anikahrm1">
        <span>Anika</span>
        <span class="hrm1">HRM</span>
      </a>
      <a class="employee-management1" id="employeeManagement"
        >Employee Management</a
      >
      <button class="salary-inner"></button>
      <a href="logout.php" > <div class="logout1">Logout</div></a>
      <a class="leaves1">Leaves</a>
      <a class="attendance1">Attendance</a>
      <div class="payroll1">Payroll</div>
      <a class="fluentperson-clock-20-regular1">
        <img class="vector-icon4" alt="" src="./public1/vector.svg" />
      </a>
      <img class="uitcalender-icon1" alt="" src="./public1/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay1"
        alt=""
        src="./public1/arcticonsgooglepay.svg"
      />
      <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $cnt = 1;
         $row=mysqli_fetch_array($que);
         ?>
      <!--<img class="salary-child1" alt="" src="pics/<?php  echo $row['pic'];?>" />-->
<!-- 
      <img
        class="material-symbolsperson-icon1"
        alt=""
        src="./public1/materialsymbolsperson.svg"
      /> -->

      <img class="salary-child2" alt="" src="./public1/rectangle-4@2x.png" />

      <img class="tablerlogout-icon1" alt="" src="./public1/tablerlogout.svg" />

      <a class="uitcalender1">
        <img class="vector-icon5" alt="" src="./public1/vector1.svg" />
      </a>
      <a class="dashboard1" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard1" id="akarIconsdashboard">
        <img class="vector-icon6" alt="" src="./public1/vector2.svg" />
      </a>
      <div class="rectangle-container">
        <div class="frame-child4"></div>
        <img class="frame-child5" alt="" src="./public1/line-39.svg" />

        <a href="./personal-details.html" class="frame-child6" id="rectangleLink"> </a>
        <a href="./personal-details.html" class="personal-details1" id="personalDetails">Personal Details</a>
        <a href="./job.php" class="frame-child7" id="rectangleLink1"> </a>
        <a href="./directory.php" class="frame-child8" id="rectangleLink2"> </a>
        <a class="frame-child9"> </a>
        <a href="./job.php" class="job1" id="job">Job</a>
        <a href="./directory.php" class="document1" id="document">Document</a>
        <a class="salary2">Salary</a>
       <a href="./employee-dashboard.html"> <img
          class="bxhome-icon1"
          alt=""
          src="./public1/bxhome.svg"
          id="bxhomeIcon"
        /></a>
      </div>
      <div class="frame-div">
    
      <?php
$user_name = $_SESSION['user_name'];

$sql = "SELECT emp.empname
        FROM emp
        INNER JOIN user_form ON emp.empemail = user_form.email
        WHERE user_form.email = '$user_name'";

$result = mysqli_query($con, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $empname = $row['empname'];
    } else {
        $empname = "Unknown"; 
    }
} else {
    $empname = "Unknown"; 
}

?>


      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                Employee Name 
              </th>
              <th scope="col" class="px-6 py-3">
                SALARY TYPE
              </th>
              <th scope="col" class="px-6 py-3">
              Pay Period
              </th>
              <th scope="col" class="px-6 py-3">
                PAID DAYS
              </th>
              <!-- <th scope="col" class="px-6 py-3">
                Net Pay
              </th> -->
              <th scope="col" class="px-6 py-3">
                Net Paycheck
              </th>
              <th scope="col" class="px-6 py-3">
                PAYSLIP
              </th>
              <th scope="col" class="px-6 py-3">
                PAYMENT MODE
              </th>
              <th scope="col" class="px-6 py-3">
                PAYMENT STATUS
              </th>
            </tr>
          </thead>
          <?php
       $sql_vsp = "SELECT empname FROM payroll_ss_vsp WHERE empname = '$empname' AND salarymonth = '$smonth'";
       $result_vsp = mysqli_query($con, $sql_vsp);
       
       if (mysqli_num_rows($result_vsp) > 0) {
           $table = 'payroll_ss_vsp';
       } else {
           // Check if empname exists in payroll_ss_ggm
           $sql_ggm = "SELECT empname FROM payroll_ss_ggm WHERE empname = '$empname' AND salarymonth = '$smonth'";
           $result_ggm = mysqli_query($con, $sql_ggm);
       
           if (mysqli_num_rows($result_ggm) > 0) {
               $table = 'payroll_ss_ggm';
           } else {
               // Check if empname exists in payroll_ss_sp
               $sql_sp = "SELECT empname FROM payroll_ss_sp WHERE empname = '$empname' AND salarymonth = '$smonth'";
               $result_sp = mysqli_query($con, $sql_sp);
       
               if (mysqli_num_rows($result_sp) > 0) {
                   $table = 'payroll_ss_sp';
               } else {
                   // empname does not exist in any of the tables
                   echo json_encode(['error' => 'No data found']);
                   exit;
               }
           }
       }
       
       // Prepare the final query based on the determined table
       $sql = "
           SELECT 
               $table.*, 
               payroll_msalarystruc.salarytype, 
               payroll_msalarystruc.netpay
           FROM 
               $table
           LEFT JOIN 
               payroll_msalarystruc ON $table.empname = payroll_msalarystruc.empname
           WHERE 
               $table.salarymonth = '$smonth' 
               AND $table.empname = '$empname'
           ORDER BY 
               $table.ID ASC";
       
       

 $comparisonDate = DateTime::createFromFormat('F Y', 'April 2024');

          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
            //   $salaryMonthDate = DateTime::createFromFormat('F Y', $result['salarymonth']);
            //   if ($result['empname'] == "YERRAMSETTI SUSANTHA SANKAR" && $salaryMonthDate > $comparisonDate) {
            //     $result['netpay'] = "26320";
            //     $result['payout'] = "26320";
            // }
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['salarytype']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['salarymonth']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['paydays']; ?></td>
                  <!-- <td class="px-6 py-4">₹<?php echo $result['netpay']; ?></td> -->
                  <td class="px-6 py-4">₹<?php echo $result['payout']; ?></td>
                  <td class="px-6 py-4">
                    <button class="view-btn" data-empname="<?php echo $result['empname']; ?>" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example">
                      <a class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                        <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                          <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                      </a>
                    </button>
                  </td>
                  <td class="px-6 py-4">Bank Transfer</td>
                  <td class="px-6 py-4 text-green-400">
                    Paid
                  </td>

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

        <div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto overflow-x-hidden transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label" style="width: 500px;">
      <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-blue-400 dark:text-blue-400">empname</h5><br>
      <p class="emp-id inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Emp. ID : </p>
      <p class="payout  inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="position: absolute; right: 70px; font-size: 32px;"></p>
      <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="position: absolute; right: 70px; top: 20px;">NET PAY</p>
      <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
        <span class="sr-only">Close menu</span>
      </button>

      <div style="width: 115%;margin-left:-20px; background-color: rgb(234, 255, 233); height: 40px;  display: flex; align-items: center; justify-content: center;">
        <svg class="w-6 h-6 text-green-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd" />
        </svg>
        <?php
      $sql = "SELECT paid FROM payroll_schedule WHERE smonth = '$smonth' ";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $paid = $row['paid'];
      $paidDate = date('d', strtotime($paid)); 
$paidMonthYear = date('F Y', strtotime($paid)); 

      ?>
        <?php
$date = strtotime($paid); 
$formatted_date = date("d-m-Y", $date); 
?>

        <p class="text-green-400" style="font-size: 16px;">Paid on <span class="text-green-400" style="font-weight: 500;"><?php echo $formatted_date ?></span> through <span class="text-green-400" style="font-weight: 500;">Manual Bank Transfer</span></p>
      </div>
      <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 20px; font-size: 20px;">Payable Days</p>
      <p class="paydays inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 20px; font-size: 20px; position: absolute; right: 60px;"></p>
      <div>
        <hr style="margin-top: 10px;">
        <p class="inline-flex items-center mb-4 text-base font-normal text-green-400 dark:text-green-400" style="margin-top: 10px;">(+) Earnings</p>
        <p class="inline-flex items-center mb-4 text-base font-normal text-green-400 dark:text-green-400" style="margin-top: 10px; position: absolute; right: 60px;">Amount</p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Basic</p>
        <p class="bp inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p> <br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">House Rent Allowance</p>
        <p class="hra inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Other Allowance</p>
        <p class="oa inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Bonus</p>
        <p class="bonus inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;">₹bonus</p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-red-500 dark:text-red-400" style="margin-top: 10px;">(-) Deductions</p>
        <p class="inline-flex items-center mb-4 text-base font-normal text-red-500 dark:text-red-400" style="margin-top: 10px; position: absolute; right: 60px;">Amount</p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Provident Fund</p>
        <p class="epf1  inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p> <br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Employee State Insurance</p>
        <p class="esi1 inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Loan EMI</p>
        <p class="emi inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">TDS</p>
        <p class="tds inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Miscellaneous</p>
        <p class="misc inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">LOP</p>
        <p class="lop inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; font-size: 22px; font-weight:500;">Netpay</p>
        <p class="payout1  inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; font-size: 22px; font-weight:500; position: absolute; right: 60px;"></p>
        <hr>
      </div>
      <div style="position: absolute; bottom: 0; width: 92%;" class="flex items-center p-4 md:p-5 ">
      <a id="downloadBtn"  target="_blank" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    Download Payslip
</a>
        <!-- <button style="position: absolute; right: 20px;" data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Send Payslip</button> -->
      </div>
    </div>
      </div>
      <img class="logo-1-icon1" alt="" src="./public1/logo-1@2x.png" />
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.view-btn');
        const drawer = document.getElementById('drawer-right-example');
        const downloadBtn = document.getElementById('downloadBtn');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const empname = this.dataset.empname;

                // AJAX request to fetch details from database based on empname
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        populateDrawer(data);
                    }
                };
                xhr.open('GET', './Payroll/fetch_ss_details_new.php?smonth=<?php echo $smonth; ?>&empname=' + empname, true);
                xhr.send();
            });
        });

        function populateDrawer(data) {
            const empnameElement = drawer.querySelector('#drawer-right-label');
            const empIDElement = drawer.querySelector('.emp-id');
            const payoutElement = drawer.querySelector('.payout');
            const paydaysElement = drawer.querySelector('.paydays');
            const payout1Element = drawer.querySelector('.payout1');
            const epfElement = drawer.querySelector('.epf1');
            const esiElement = drawer.querySelector('.esi1');
            const bpElement = drawer.querySelector('.bp');
            const hraElement = drawer.querySelector('.hra');
            const oaElement = drawer.querySelector('.oa');
            const bonusElement = drawer.querySelector('.bonus');
            const miscElement = drawer.querySelector('.misc');
            const emiElement = drawer.querySelector('.emi');
            const tdsElement = drawer.querySelector('.tds');
            const lopElement = drawer.querySelector('.lop');

            // Populate drawer elements with fetched data
            empnameElement.textContent = data.empname;
            empIDElement.textContent = 'Emp. ID: ' + data.emp_no;
            payoutElement.textContent = '₹' + data.payout;
            paydaysElement.textContent = data.paydays;
            payout1Element.textContent = '₹' + data.payout;
            epfElement.textContent = '₹' + data.epf1;
            esiElement.textContent = '₹' + data.esi1;
            bpElement.textContent = '₹' + data.bp;
            hraElement.textContent = '₹' + data.hra;
            oaElement.textContent = '₹' + data.oa;
            bonusElement.textContent = '₹' + data.bonus;
            miscElement.textContent = '₹' + data.misc;
            emiElement.textContent = '₹' + data.emi;
            tdsElement.textContent = '₹' + data.tds;
            lopElement.textContent = '₹' + data.lopamt;

            // Show the drawer
            drawer.classList.remove('hidden');
        }

        // Event listener for setting the href attribute of the download button
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const empname = this.dataset.empname;
                // Set the href attribute of the download button dynamically
                downloadBtn.href = './Payroll/print-details_pslip_new.php?smonth=<?php echo $smonth; ?>&empname=' + empname;

            });
        });
    });
</script>
  </body>
</html>

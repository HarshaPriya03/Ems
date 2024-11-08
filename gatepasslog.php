<!DOCTYPE html>
<?php
@include 'inc/config.php';
session_start();
$hrmsHost = "localhost";
$hrmsUser = "root";
$hrmsPassword = "";
$hrmsDatabase = "ems";

$leaveManagementHost = "localhost";
$leaveManagementUser = "root";
$leaveManagementPassword = "";
$leaveManagementDatabase = "simpleave";
$hrmsCon = mysqli_connect($hrmsHost, $hrmsUser, $hrmsPassword, $hrmsDatabase);

if (!$hrmsCon) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    echo "";
    exit();
}

$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($hrmsCon, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
    $sqlHRMS = "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
    $resultHRMS = mysqli_query($hrmsCon, $sqlHRMS);
    
    $rowHRMS = mysqli_fetch_assoc($resultHRMS);

    if ($resultHRMS) {
        $leaveManagementCon = mysqli_connect($leaveManagementHost, $leaveManagementUser, $leaveManagementPassword, $leaveManagementDatabase);

        if (!$leaveManagementCon) {
            die("Connection failed: " . mysqli_connect_error());
        }
?>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://kit.fontawesome.com/26eea4c998.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./gatepasslog.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    
    <style>
       .white-line
      {
        background-color: #fff;
        position:absolute;
        height:3vw;
        top:80px;
        width:82%;
        left:360px;
        display:flex;
        flex-direction:row;
        gap:15vw;
        justify-content:center;
        /* z-index:1000; */
      }

      .issuer button
      {
        padding:0.4vw !important;
        padding-bottom:0.4vw !important;
        font-size:1vw;
        background-color: gray!important;
        color:#fff !important;
        border:none;
        border-radius:2vw;
        margin-top:0.5vw;
        width:10vw;
        cursor:pointer;
      }
      .issuer-1 button{
        padding:0.4vw !important;
        padding-bottom:0.4vw !important;
        font-size:1vw;
        background-color: gray;
        color:#fff ;
        border:none;
        border-radius:2vw;
        margin-top:0.5vw;
        width:10vw;
        cursor:pointer;
      }
      
      .active{
        background-color: #FFE2C6 !important;
        color:#FF5400 !important;
      }

      .custom-button {
    position: absolute;
    /* bottom:30px; */
    left:1250px;
    /* top:10px; */
    /* top:2px; */
    font-weight: 400;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    text-align: center;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    cursor: pointer;
    margin-top:-2.5vw;
    cursor:pointer;
}

/* Make sure the modal is centered and covers the full screen */
#step2 {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.5);
}

/* Modal content styling */
#step2 .bg-white {
    width: 48%;
    max-width: 500px;
    margin: auto;
    border-radius: 10px;
    padding: 20px;
}

/* Close button */


/* Background for the modal overlay */
/* #step2 {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(128, 128, 128, 0.5); /* Gray overlay with opacity */


/* Modal container */
#step2 .relative {
    background-color: white;
    border-radius: 0.75rem;
    max-width: 400px;
    width: 100%;
    padding: 1.5rem;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

/* Close button */
#closeModal {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    color: #718096; /* Gray color */
    transition: color 0.2s ease;
}
#closeModal:hover {
    color: #1a202c; /* Darker gray on hover */
}

/* Header text and status */
.text-center h2 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-align:center;
}
.text-center p {
    font-size: 0.875rem;
    color: #16A34A; /* Green color for status text */
    text-align:center;
}

/* QR code container */
#qrcode {
    padding: 1rem;
    /* background-color: white; */
    border-radius: 0.5rem;
    /* box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1); */
    margin-left:4vw !important;
}

/* Time containers */
.grid {
    display:flex;
    flex-direction:row;
    gap: 1rem;
    margin-bottom:1vw;
}
.grid-cols-2 > div {
    padding: 0.75rem;
    border-radius: 0.5rem;
    /* text-align: center; */
    /* margin-left:2vw; */
    width:500px;
   
  
}
.bg-blue-50 {
    background-color: #EBF8FF;
}
.bg-purple-50 {
    background-color: #FAF5FF;
}
.text-blue-600 {
    color: #3182CE; /* Blue text */
}
.text-purple-600 {
    color: #805AD5; /* Purple text */
}

/* Details section */
.space-y-4 > div {
    margin-top: 0.5rem;
}
.border-t {
    border-top: 1px solid #E2E8F0;
    padding-top: 1rem;
}
.text-gray-500 {
    color: #718096;
    font-size: 0.875rem;
}
.font-mono {
    font-family: monospace;
}
.font-medium {
    font-weight: 500;
}
.font-semibold {
    font-weight: 600;
}

   
    </style>
  </head>
  <body>
    <section class="gatepasslog">
      <section class="bg"></section>
      <section class="gatepasslog-child"></section>
      <h2 class="gatepass-log">/Gatepass Log</h2>
      <img class="gatepasslog-item" alt="" src="./public/rectangle-2@2x.png" />

      <a class="anikahrm">
        <span>Anika</span>
        <span class="hrm">HRM</span>
      </a>
      <a class="employee-management" id="employeeManagement"
        >Employee Management</a
      >
      <button class="gatepasslog-inner"><a  href="logout.php" style="margin-left:25px; color:white; text-decoration:none; font-size:25px">Logout</a></button>
      <a class="leaves" href="apply-leave-emp.php">Leaves</a>
      <a class="attendance" href="attendenceemp2.php">Attendance</a>
      <a class="payroll" href="card.php" style="text-decoration:none;">Directory</a>
      <a class="fluentperson-clock-20-regular">
        <img class="vector-icon" alt="" src="./public/vector1.svg" />
      </a>
      <img class="uitcalender-icon" alt="" src="./public/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <!--<img class="ellipse-icon" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

<a href="employee-dashboard.php">
      <img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" /></a>

      <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender">
        <img class="vector-icon1" alt="" src="./public/vector4.svg" />
      </a>
      <a class="dashboard" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard" id="akarIconsdashboard">
        <img class="vector-icon2" alt="" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" src="./public/vector3.svg" />
      </a>
      <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />
      <div class="white-line">
        <div class="issuer">
           <button>Issue Gatepass</button>
        </div>
        <div class="issuer-1" >
          <button class="active">GatePass Log</button>
       </div>
    </div>

      <section class="frame-parent" style="width: 1400px;margin-left:-80px; margin-top:50px;">
      <div style="display: flex; gap: 10px; ">
          <div style="display: flex; gap: 10px;">
            <svg style="margin-left: 40px;" xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='none' stroke='#4a90e2' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M16 17l5-5-5-5M19.8 12H9M10 3H4v18h6'/></svg>
          <p style="margin-top: 9px;">: One way pass</p>
          </div>
          <div style="display: flex; gap: 10px; margin-left: 35px;">
            <img src="./public/tick.png" alt="" width="50px" height="50px">
          <p style="margin-top: 9px;">: Employee marked in</p>
          </div>
          <div style="display: flex; gap: 10px; margin-left: 35px;">
            <img style="margin-top: -7px;" src="./public/cross.png" alt="" width="60px" height="60px">
          <p style="margin-top: 9px;">: Employee yet to mark in</p>
          </div>
          <div style="display: flex; gap: 10px; margin-left: 35px;">
          <svg  xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='none' stroke='#e24a4a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z'/><path d='M14 3v5h5M9.9 17.1L14 13M9.9 12.9L14 17'/></svg>
          <p style="margin-top: 9px;">: Gatepass Rejected</p>
          </div>
        </div>
       <div class="rectangle-parent" style="margin-top:40px;">

         
          <?php
        $sqlLeaveManagement = "SELECT * FROM leaves WHERE mobile = '{$rowHRMS['empph']}' ORDER BY id DESC";
        $resultLeaveManagement = mysqli_query($leaveManagementCon, $sqlLeaveManagement);

        if ($resultLeaveManagement) {
          ?>
      
            <?php
            while ($rowLeaveManagement = mysqli_fetch_assoc($resultLeaveManagement)) {
              ?>
                         <?php
$timestamp = strtotime($rowLeaveManagement['leavedate']);
$formattedDate = date('D', $timestamp);
$formattedDate1 = date('d', $timestamp);
$formattedDate2 = date('M', $timestamp);
$formattedDate3 = date('H\H  i\M', $timestamp);
$hours = date('H', $timestamp);
$minutes = date('i', $timestamp);
$formattedDateWithLabels = "$hours Hrs $minutes mins";

$timestamp1 = strtotime($rowLeaveManagement['marktime']);
$hours1 = date('H', $timestamp1);
$minutes1 = date('i', $timestamp1);
$formattedDateWithLabels1 = "$hours1 Hrs $minutes1 mins";

?>
<div>
 <table>   <tr>
        <td>
            
              <div class="frame-child" style="width: 1350px;"></div>
            <p style="filter: contrast(200); margin-left: 190px; margin-top: -90px;">Gatepass ID:</p>
            <p style="filter: contrast(200);margin-left: 960px; margin-top: -54px; width:20px;">  <?php echo $rowLeaveManagement['email']?></p>
            <p style="filter: contrast(200);margin-left: 1085px; margin-top: -15px; width:20px;">  <?php
if (!empty($rowLeaveManagement['email1'])) {
    echo $rowLeaveManagement['email1'];
} else {
    echo "[Action Pending]";
}
?></p>
            <p style="filter: contrast(200); margin-left: 1015px; margin-top: -15px;">   <?php 
                                     if ($rowLeaveManagement['status'] == 0) {
                                        echo "<span style='color: #fcf00e;'>Pending </span>";
                                     }
                                     elseif ($rowLeaveManagement['status'] == 1){
                                        echo "<span style='color: #00ff77;'>Approved</span>";
                                     }
									 elseif ($rowLeaveManagement['status'] == 2){
                                        echo "<span style='color: #f35c17;'>Rejected</span>";
                                     }
                         
                                  ?></p>
            <p style="filter: contrast(200);margin-left: 450px; font-size: 25px; margin-top: -55px;"><?php 
                                    if( $rowLeaveManagement['status'] == 2){
                                        echo "<span class='badge badge-danger'>[GP Rejected]</span>";
									 }
									 elseif($rowLeaveManagement['mark'] == 0 & $rowLeaveManagement['way'] == '2 WAY') {
                                        echo "<span class='badge badge-danger'>[to be marked]</span>";
                                     }
									 elseif( $rowLeaveManagement['mark'] == 0 & $rowLeaveManagement['way'] == '1 WAY'){
                                        echo "<span style='font-size:15px !important;' class='badge badge-default'>N/A</span>";
									 }
									
						
                                     else{
                                      echo $formattedDateWithLabels1; 
                                     }
                              
                                  ?></p>
            <p style="filter: contrast(200);margin-left: 410px; font-size: 25px; margin-top: -55px;">IN:</p>
            <p style="filter: contrast(200);margin-left: 387px; font-size: 25px; margin-top: -100px;">OUT:</p>
            <p style="filter: contrast(200);margin-left: 450px; font-size: 25px; margin-top: -55px;"><?php 
								 if( $rowLeaveManagement['status'] == 2){
									echo "<span class='badge badge-danger'>[GP Rejected]</span>";
								 }
								 else {
								echo $formattedDateWithLabels; 
								 }
								 ?></p>
            <div class="frame-item" style="margin-top: -75px; margin-left: 8px;"></div>
            <p style=" color: white; font-weight: 400; filter: contrast(200);margin-left: 20px; font-size: 30px; margin-top: -40px;width:100px"><?php echo $formattedDate1; ?> <?php echo $formattedDate2; ?></p>
            <p style=" color: white; font-weight: 400; filter: contrast(200);margin-left: 30px; font-size: 30px; margin-top: -135px;width:100px"><?php echo $rowLeaveManagement['way']?></p>
            <h3 style="color: white; filter: contrast(200); margin-left: 30px; font-size: 34px; margin-top: -35px;width:100px"><?php echo $formattedDate; ?></h3>
            <button class="custom-button">Update</button>
            <div class="frame-inner" style="margin-left: 380px; margin-top: -90px;"></div>
            <div class="line-div" style="margin-left: 820px; margin-top: -78px;"></div>
            <div class="line-div" style="margin-left: 630px; margin-top: -80px;"></div>
            <div class="line-div" style="margin-left: 1200px; margin-top: -80px;"></div>
            
         

<!-- Modal -->
<div id="step2" class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden hidden fixed inset-0 z-50 bg-gray-800 bg-opacity-50">
    <div class="p-6 relative bg-white rounded-lg">
        <!-- Close button -->
        <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="p-6">
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold">Digital Gatepass</h2>
                <p class="text-sm text-green-600">Active and Ready to Use</p>
            </div>

            <div class="flex justify-center mb-6">
                <div id="qrcode" class="bg-white p-4 rounded-lg">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuIy6HNc3zXzJ9-y-rNEfnaSdhcgeXytmnQg&s">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-50 p-3 rounded-lg" style="height:2.5vw;">
                    <p class="text-sm text-blue-600" style="margin:0">Exit Time</p>
                    <p class="font-semibold" id="displayExitTime" style="margin:0">--:--</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg" style="height:2.5vw;">
                    <p class="text-sm text-purple-600" style="margin:0">Return Time</p>
                    <p class="font-semibold" id="displayReturnTime" style="margin:0">--:--</p>
                </div>
            </div>

            <div class="space-y-4 border-t pt-4">
                <div>
                    <p class="text-sm text-gray-500">Gatepass ID</p>
                    <p class="font-mono font-medium" id="gatepassId">GP-2024-XXXX</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Duration</p>
                    <p class="font-medium" id="displayDuration">-- minutes</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Purpose</p>
                    <p class="font-medium" id="displayPurpose">--</p>
                </div>
            </div>
        </div>
    </div>
</div>

    
                   
            <p style="filter: contrast(200);margin-left: 853px; margin-top: -86px;">Issued By:</p>
            <p style="filter: contrast(200);margin-left: 853px; margin-top: -15px;">Approved/Rejected By:</p>
            <p style="filter: contrast(200);margin-left: 853px; margin-top: -15px;">Approval Status:</p>
            <p style="filter: contrast(200);margin-left: 160px; margin-top: -55px;"><?php echo date('Ymd',strtotime($rowLeaveManagement['leavedate']));?>-000<?php echo $rowLeaveManagement['id'];?></p>
            <p style="filter: contrast(200);margin-left: 640px; font-size: 25px; margin-top: -45px;"><?php if ($rowLeaveManagement['status'] == 2 ){
									echo "<span class='badge badge-danger'> [GP Rejected]</span>";
								 }
								 elseif ($rowLeaveManagement['way'] == '1 WAY'){
									echo "<span style='font-size:15px !important;' class='badge badge-default'>N/A</span>";
								 }
                                 elseif($rowLeaveManagement['mark'] == 0 & $rowLeaveManagement['way'] == '2 WAY') {
                                    echo "<span class='badge badge-danger'>[to be marked]</span>";
                                 }
								 elseif($rowLeaveManagement['status'] == 0) {
									echo "<span class='badge badge-warning'>Pending <br>for Approval </span>";
								 }
								 
								 else{
                  $date1 = new DateTime(date('Y-m-d H:i:s', strtotime('+12 hours +30 minutes', strtotime($rowLeaveManagement['marktime']))));
                  $date2 = new DateTime($rowLeaveManagement['leavedate']);
                  $interval = $date1->diff($date2);
                  echo $interval->format('%Hhrs %imins');
                  
								 } ?></p>
            <p style="filter: contrast(200);margin-left: 640px; font-size: 25px; margin-top: -99px;">OUT Duration</p>
            <?php 
                                     if((($rowLeaveManagement['status'] == 0 || $rowLeaveManagement['status'] == 2) & $rowLeaveManagement['way'] == '1 WAY')){
                                        echo "<svg style='margin-top: 20px;' xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='none' stroke='#4a90e2' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M16 17l5-5-5-5M19.8 12H9M10 3H4v18h6'/></svg>
                                        ";
                                     }
                                     elseif ($rowLeaveManagement['status'] == 2){
                                      echo "
                                      <svg style='margin-top: 20px;' xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='none' stroke='#e24a4a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z'/><path d='M14 3v5h5M9.9 17.1L14 13M9.9 12.9L14 17'/></svg>

                                  ";
                                   }
                                     elseif ($rowLeaveManagement['status'] == 2 & $rowLeaveManagement['way'] == '2 WAY' & $rowLeaveManagement['mark'] == '0'){
                                        echo "
                                        <img src='./public/cross.png'  width='65px' style='margin-top: 20px;'>
                                    ";
                                     }
                                   
                                     else{
                                        echo "
                                        <img src='./public/tick.png' width='55px' style='margin-top: 20px;'>
                                    ";
                                     }
                         
                                  ?>
           
            </td>
          
            <?php
          }
          ?>
   
        <?php
      } else {
        echo "Error in Leave Management System query: " . mysqli_error($leaveManagementCon);
      }
      ?>     </tr> 
    </table>
    </div>
          </div>
        
      
      </section>
    </section>
    <?php
    mysqli_close($leaveManagementCon);
  } else {
      echo "Error in HRMS query: " . mysqli_error($hrmsCon);
  }

  mysqli_close($hrmsCon);
} else {
    echo "";
    exit();
}
?>
    <script>
      var employeeManagement = document.getElementById("employeeManagement");
      if (employeeManagement) {
        employeeManagement.addEventListener("click", function (e) {
          // Please sync "Homepage" to the project
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          // Please sync "Homepage" to the project
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          // Please sync "Homepage" to the project
        });
      }
      </script>
      <script>
        // Select elements
const updateButton = document.querySelector('.custom-button');
const modal = document.querySelector('#step2');
const closeModalButton = document.querySelector('#closeModal');

// Show modal when 'Update' button is clicked
updateButton.addEventListener('click', () => {
    modal.style.display = 'flex';  // Show the modal
});

// Close modal when 'Close' button is clicked
closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none';  // Hide the modal
});

// Optional: Close modal when clicking outside the modal content
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';  // Hide the modal when clicking outside
    }
});

      </script>
  </body>
</html>
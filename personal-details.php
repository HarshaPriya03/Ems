<?php
@include 'inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./global.css" />
    <link rel="stylesheet" href="./personal-details.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <style>
        input{
           font-size:20px; 
        }
    </style>
  </head>
  <body>
    <div class="personaldetails">
      <div class="bg3"></div>
      <img
        class="personaldetails-child"
        alt=""
        src="./public1/rectangle-1@2x.png"
      />

      <img
        class="personaldetails-item"
        alt=""
        src="./public1/rectangle-2@2x.png"
      />
      <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $cnt = 1;
         $row=mysqli_fetch_array($que)
         ?>

      <a class="anikahrm3">
        <span>Anika</span>
        <span class="hrm3">HRM</span>
      </a>
      <a class="employee-management3" id="employeeManagement"
        >Employee Management</a
      >
      <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php" class="employee-management3" id="employeeManagement"></a>
      <button class="personaldetails-inner"></button>
      <a href="logout.php" > <div class="logout3">Logout</div></a>
      <a class="leaves3" href="apply-leave-emp.php">Leaves</a>
      <a class="attendance3" href="attendenceemp2.php">Attendance</a>
      <a href="card.php" style="text-decoration: none; color: #222222;" class="payroll3">Directory</a>
      <!--<div class="payroll3">Payroll</div>-->
      <a class="fluentperson-clock-20-regular3">
        <img class="vector-icon10" alt="" src="./public1/vector.svg" />
      </a>
      <img class="uitcalender-icon3" alt="" src="./public1/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay3"
        alt=""
        src="./public1/arcticonsgooglepay.svg"
      />

      <!--<img-->
      <!--  class="personaldetails-child1"-->
      <!--  alt=""-->
      <!--  src="pics/<?php  echo $row['pic'];?>"-->
      <!--/>-->

      <!-- <img
        class="material-symbolsperson-icon3"
        alt=""
        src="./public1/materialsymbolsperson.svg"
      /> -->

      <img
        class="personaldetails-child2"
        alt=""
        src="./public1/rectangle-4@2x.png"
      />

      <img class="tablerlogout-icon3" alt="" src="./public1/tablerlogout.svg" />

      <a class="uitcalender3">
        <img class="vector-icon11" alt="" src="./public1/vector1.svg" />
      </a>
      <a class="dashboard3" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard3" id="akarIconsdashboard">
        <img class="vector-icon12" alt="" src="./public1/vector2.svg" />
      </a>
      <div class="rectangle-parent3">
        <div class="frame-child33"></div>
        <img class="frame-child34" alt="" src="./public1/line-39.svg" />

        <a class="frame-child35"> </a>
        <a class="personal-details3">Personal Details</a>
        <a href="./job.php" class="frame-child36" id="rectangleLink1"> </a>
        <a href="./directory.php" class="frame-child37" id="rectangleLink2"> </a>
        <a href="./salary.php" class="frame-child38" id="rectangleLink3"> </a>
        <a href="./job.php" class="job4" id="job">Job</a>
        <a href="./directory.php" class="document3" id="document">Document</a>
        <a href="./salary.php" class="salary4" id="salary">Salary</a>
       <a href="./employee-dashboard.php"> <img
          class="bxhome-icon3"
          alt=""
          src="./public1/bxhome.svg"
          id="bxhomeIcon"
        /></a>
      </div>
      <div class="rectangle-parent4">
        <div class="frame-child39"></div>
        <h3 class="personal-details4">Personal Details</h3>
        <img class="frame-child40" alt="" src="./public1/line-121@2x.png" />

        <label class="employee-name">Employee Name*</label>
        <label class="phone-number">Phone Number</label>
        <label class="marital-status">Marital Status</label>
        <label class="pan">PAN</label>
        <label class="account-number">Account Number</label>
        <label class="date-of-birth">Date of Birth</label>
        <label class="email-id">Email ID</label>
        <label class="gender">Gender</label>
        <label class="aadhaar">Aadhaar</label>
        <label class="ifsc-code">IFSC Code</label>
        <input
          class="frame-child41"
          value=" <?php echo $row['empname']; ?>"
          type="text"
          defaultvalue="Mohan Reddy"
          disabled
        />

        <input
          class="frame-child42"
          value="<?php echo $row['empph']; ?>"
          type="tel"
          defaultvalue="9885852424"
          disabled
        />

        <input
          class="frame-child43"
          value="<?php echo $row['empms']; ?>"
          type="text"
          defaultvalue="Single"
          disabled
        />

        <input
          class="frame-child44"
          value="<?php echo $row['pan']; ?>"
          type="text"
          defaultvalue="FUYRT2347T"
          disabled
        />

        <input
          class="frame-child45"
          value="<?php echo $row['ban']; ?>"
          type="text"
          defaultvalue="39728467242"
          disabled
        />

        <input
          class="frame-child46"
          value="<?php  $orgDate = $row['empdob']; $newDate = date("d-m-Y", strtotime($orgDate));   echo $newDate;  ?>"
          type="text"
          defaultvalue="17/06/2002"
          disabled
        />

        <input
          class="frame-child47"
          value="<?php echo $row['empemail']; ?>"
          type="email"
          defaultvalue="naradamohan1@gmail.com"
          disabled
        />

        <input
          class="frame-child48"
          value="<?php echo $row['empgen']; ?>"
          type="text"
          defaultvalue="Male"
          disabled
        />

        <input
          class="frame-child49"
          value="<?php echo $row['adn']; ?>"
          type="text"
          defaultvalue="384627362536"
          disabled
        />

        <input
          class="frame-child50"
          value="<?php echo $row['ifsc']; ?>"
          type="text"
          defaultvalue="ICIC28287U"
          disabled
        />

        <label class="bank-name">Bank Name</label>
        <input
          class="frame-child51"
          value="<?php echo $row['bn']; ?> "
          type="text"
          defaultvalue="ICICI "
          disabled
        />
      </div>
      <img class="logo-1-icon3" alt="" src="./public1/logo-1@2x.png" />
    </div>
<!-- 
    <script>
      var employeeManagement = document.getElementById("employeeManagement");
      if (employeeManagement) {
        employeeManagement.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function (e) {
          window.location.href = "./job.php";
        });
      }
      
      var rectangleLink2 = document.getElementById("rectangleLink2");
      if (rectangleLink2) {
        rectangleLink2.addEventListener("click", function (e) {
          window.location.href = "./directory.php";
        });
      }
      
      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function (e) {
          window.location.href = "./salary.php";
        });
      }
      
      var job = document.getElementById("job");
      if (job) {
        job.addEventListener("click", function (e) {
          window.location.href = "./job.php";
        });
      }
      
      var document = document.getElementById("document");
      if (document) {
        document.addEventListener("click", function (e) {
          window.location.href = "./directory.php";
        });
      }
      
      var salary = document.getElementById("salary");
      if (salary) {
        salary.addEventListener("click", function (e) {
          window.location.href = "./salary.php";
        });
      }
      
      var bxhomeIcon = document.getElementById("bxhomeIcon");
      if (bxhomeIcon) {
        bxhomeIcon.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      </script> -->
  </body>
</html>
<?php
} else {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
?>
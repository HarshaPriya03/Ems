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
    <link rel="stylesheet" href="./job.css" />
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
    <div class="job2">
      <div class="bg2"></div>
      <img class="job-child" alt="" src="./public1/rectangle-1@2x.png" />

      <img class="job-item" alt="" src="./public1/rectangle-2@2x.png" />

      <a class="anikahrm2">
        <span>Anika</span>
        <span class="hrm2">HRM</span>
      </a>
      <a class="employee-management2" id="employeeManagement"
        >Employee Management</a
      >
      <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php" class="employee-management2" id="employeeManagement"></a>
      <button class="job-inner"></button>
      <a href="logout.php" > <div class="logout2">Logout</div></a>
      <a class="leaves2" href="apply-leave-emp.php">Leaves</a>
      <a class="attendance2" href="attendenceemp2.php">Attendance</a>
     <a href="card.php" style="text-decoration: none; color: #222222;" class="payroll2">Directory</a>
      <a class="fluentperson-clock-20-regular2">
        <img class="vector-icon7" alt="" src="./public1/vector.svg" />
      </a>
      <img class="uitcalender-icon2" alt="" src="./public1/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay2"
        alt=""
        src="./public1/arcticonsgooglepay.svg"
      />
      <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $row=mysqli_fetch_array($que);
         $empName1= $row['empname'];

         ?>
      <!--<img class="job-child1" alt="" src="pics/<?php  echo $row['pic'];?>" />-->

      <!-- <img
        class="material-symbolsperson-icon2"
        alt=""
        src="./public1/materialsymbolsperson.svg"
      /> -->
<?php
$employeeDesg = $row['desg']; 
$query = "SELECT empname FROM manager WHERE desg LIKE ?";

if ($stmt = $con->prepare($query)) {
    $searchDesg = "%".$employeeDesg."%";
    $stmt->bind_param("s", $searchDesg);

    $stmt->execute();

    $stmt->bind_result($managerName);

    if ($stmt->fetch()) {
        echo "Manager Name: " . $managerName;
    } else {
        echo "No manager found for the designation: " . $employeeDesg;
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $con->error;
}

?>



      <img class="job-child2" alt="" src="./public1/rectangle-4@2x.png" />

      <img class="tablerlogout-icon2" alt="" src="./public1/tablerlogout.svg" />

      <a class="uitcalender2">
        <img class="vector-icon8" alt="" src="./public1/vector1.svg" />
      </a>
      <a class="dashboard2" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard2" id="akarIconsdashboard">
        <img class="vector-icon9" alt="" src="./public1/vector2.svg" />
      </a>
    
      <div class="rectangle-parent1">
        <div class="frame-child18"></div>
        <img class="frame-child19" alt="" src="./public1/line-39.svg" />

        <a href="./personal-details.php" class="frame-child20" id="rectangleLink"> </a>
        <a href="./personal-details.php" class="personal-details2" id="personalDetails">Personal Details</a>
        <a class="frame-child21"> </a>
        <a href="./directory.php" class="frame-child22" id="rectangleLink2"> </a>
        <a href="./salary.php" class="frame-child23" id="rectangleLink3"> </a>
        <a href="./job.php" class="job3">Job</a>
        <a href="./directory.php" class="document2" id="document">Document</a>
        <a href="./salary.php" class="salary3" id="salary">Salary</a>
        <a href="./employee-dashboard.php"><img
          class="bxhome-icon2"
          alt=""
          src="./public1/bxhome.svg"
          id="bxhomeIcon"
        /></a>
      </div>
      <div class="rectangle-parent2">
        <div class="frame-child24"></div>
        <h3 class="employment-details">Employment Details</h3>
        <img class="frame-child25" alt="" src="./public1/line-12@2x.png" />

        <label class="employee-id">Employee ID</label>
        <label class="reporting-manager">General Manager</label>
        <label class="designation">Designation</label>
        <label class="employment-type">Employment Type</label>
        <label class="date-of-joining">Date of Joining</label>
        <label class="employment-status">Reporting Manager</label>
        <label class="department">Department</label>
        <label class="salary-fixed">Work Location</label>
        <input
          class="rectangle-input"
          value="<?php echo $row['emp_no']; ?>"
          type="text"
          defaultvalue="1902"
          disabled
        />

        <input
          class="frame-child26"
          value="<?php echo $row['rm']; ?>"
          type="text"
          defaultvalue="Prabhdeep Singh Maan"
          disabled
        />

        <input
          class="frame-child27"
          value="<?php echo $row['desg']; ?>"
          type="text"
          defaultvalue="Web Developer"
          disabled
        />

        <input
          class="frame-child28"
          value="<?php echo $row['empty']; ?>"
          type="text"
          defaultvalue="Permanent"
          disabled
        />

        <input
          class="frame-child29"
          value="<?php echo $row['empdoj']; ?>"
          type="text"
          defaultvalue="24/11/2002"
          disabled
        />

        <input
          class="frame-child30"
          value="<?php echo $managerName; ?>"
          type="text"
          defaultvalue="Active"
          disabled
        />

        <input class="frame-child31" value="<?php echo $row['dept']; ?>" type="text" defaultvalue="IT" 
          disabled/>

        <input
          class="frame-child32"
          value="<?php echo $row['work_location']; ?>"
          type="text"
          defaultvalue="3 LPA"
          disabled
        />
      </div>
      <img class="logo-1-icon2" alt="" src="./public1/logo-1@2x.png" />
    </div>
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
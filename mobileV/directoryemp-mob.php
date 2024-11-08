<?php
@include '../inc/config.php';
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
                 text: 'Login Again, if your still facing issues Contact HR!',
            }).then(function() {
              window.location.href = 'login-mob.php';
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

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/directoryemp-mob.css" />
    <link rel="stylesheet" href="./empmobcss/empjob-details-mob.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <style>
        .logo-1-icon10 {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 55px;
  height: 55px;
  object-fit: cover;
}
    </style>
  </head>
  <body>
    <div class="directoryemp-mob" style="height: 100svh;">
      <div class="logo-1-parent">
        <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

        <a class="directory">Directory</a>
      </div>
      <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
      <div class="directoryemp-mob-child"></div>
      <div class="ellipse-parent">
        <div class="frame-child"></div>
        <a class="akar-iconsdashboard" id="akarIconsdashboard">
          <img class="vector-icon" alt="" src="./public/vector1dash.svg" />
        </a>
        <a
          class="fluentperson-clock-20-regular"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon1"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender" id="uitcalender">
          <img class="vector-icon2" alt="" src="./public/vector2@2xatten.png" />
        </a>
        <img
          class="arcticonsgoogle-pay"
          alt=""
          src="./public/arcticonsgooglepay@2x.png"
        />
      </div>
   
      <div class="rectangle-parent23" style="overflow-x:hidden; margin-top: -150px; height: 110svh; scale: 0.7;">
      <?php
$sql = "SELECT * FROM emp ORDER BY emp_no ASC";
$que = mysqli_query($con,$sql);
$cnt = 1;
while ($result = mysqli_fetch_assoc($que)) {
?>
        <div class="rectangle-parent">
   
          <div class="box-container" style="display: flex; flex-wrap: wrap;">
              <div class="box-item">
                  <div class="flip-box">
                      <div class="flip-box-front text-center"
                          style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
                          <div class="inner color-white">
                              <h3 class="flip-box-header"><?php echo $result['empname'];?></h3>
                              <img src="../pics/<?php  echo $result['pic'];?>" width="200px" height="200px"
                                  style="border-radius: 100px;" alt=""> <br>
                              <img src="https://s25.postimg.cc/65hsttv9b/cta-arrow.png" alt="" class="flip-box-img">
                          </div>
                      </div>
                      <div class="flip-box-back text-center"
                          style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
                          <div class="inner color-white">
                              <h3 class="flip-box-header"><?php echo $result['empph'];?></h3>
                              <p><?php echo $result['empemail'];?></p>
                              <p><?php echo $result['desg'];?></p>
                              <p><?php echo $result['dept'];?></p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <?php } ?>
      </div>

    
 
      </div>
    <script>
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./emp-dashboard-mob.php";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./apply-leaveemp-mob.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendenceemp-mob.php";
        });
      }
      </script>
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
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
  exit();
}
?>
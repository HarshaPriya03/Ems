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

    <!-- <link rel="stylesheet" href="./global.css" /> -->
    <link rel="stylesheet" href="./card.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap"
    />
    <style>
               html {
            font-family: sans-serif;
            box-sizing: border-box;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        .text-center {
            text-align: center;
        }

        .color-white {
            color: #fff;
        }

        .box-container {
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding: 35px 15px;
            width: 100%;
        }

        @media screen and (min-width:1380px) {
            .box-container {
                flex-direction: row
            }
        }

        .box-item {
            position: relative;
            -webkit-backface-visibility: hidden;
            width: 355px;
            margin-bottom: 35px;
            max-width: 100%;
        }

        .flip-box {
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
            -webkit-transform-style: preserve-3d;
            perspective: 1000px;
            -webkit-perspective: 1000px;
        }

        .flip-box-front,
        .flip-box-back {
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            min-height: 475px;
            -ms-transition: transform 0.7s cubic-bezier(.4, .2, .2, 1);
            transition: transform 0.7s cubic-bezier(.4, .2, .2, 1);
            -webkit-transition: transform 0.7s cubic-bezier(.4, .2, .2, 1);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .flip-box-front {
            -ms-transform: rotateY(0deg);
            -webkit-transform: rotateY(0deg);
            transform: rotateY(0deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box:hover .flip-box-front {
            -ms-transform: rotateY(-180deg);
            -webkit-transform: rotateY(-180deg);
            transform: rotateY(-180deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box-back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;

            -ms-transform: rotateY(180deg);
            -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box:hover .flip-box-back {
            -ms-transform: rotateY(0deg);
            -webkit-transform: rotateY(0deg);
            transform: rotateY(0deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box .inner {
            position: absolute;
            left: 0;
            width: 100%;
            padding: 60px;
            outline: 1px solid transparent;
            -webkit-perspective: inherit;
            perspective: inherit;
            z-index: 2;

            transform: translateY(-50%) translateZ(60px) scale(.94);
            -webkit-transform: translateY(-50%) translateZ(60px) scale(.94);
            -ms-transform: translateY(-50%) translateZ(60px) scale(.94);
            top: 50%;
        }

        .flip-box-header {
            font-size: 34px;
        }

        .flip-box p {
            font-size: 20px;
            line-height: 1.5em;
        }

        .flip-box-img {
            margin-top: 25px;
        }

        .flip-box-button {
            background-color: transparent;
            border: 2px solid #fff;
            border-radius: 2px;
            color: #fff;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            margin-top: 25px;
            padding: 15px 20px;
            text-transform: uppercase;
        }
    </style>
  </head>
  <body>
    <div class="directory">
      <div class="bg"></div>
      <img class="directory-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="directory-item" alt="" src="./public/rectangle-2@2x.png" />

      <a href="./employee-dashboard.php" class="anikahrm">
        <span>Anika</span>
        <span class="hrm">HRM</span>
      </a>
      <a href="./employee-dashboard.php" class="employee-management" id="employeeManagement"
        >Employee Management</a
      >
      <a href="logout.php" > <button class="directory-inner"> <span style="color:white; font-size:25px; margin-top:20px; margin-left:25px;">Logout</span></button>
   <div class="logout4" >Logout</div></a>
      <a class="leaves" href="apply-leave-emp.php">Leaves</a>
      <a class="attendance" href="attendenceemp2.php">Attendance</a>
      <a class="fluentperson-clock-20-regular">
        <img class="vector-icon" alt="" src="./public/vector1.svg" />
      </a>
      <img class="uitcalender-icon" alt="" src="./public/uitcalender.svg" />

       <!--<img class="ellipse-icon" alt="" src="./public/ellipse-1@2x.png" /> -->
      <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $cnt = 1;
         $row=mysqli_fetch_array($que);
         $dept = $row['dept'];
         ?>
      <!--<img-->
      <!--  class="ellipse-icon"-->
      <!--  alt=""-->
      <!--  src="pics/<?php  echo $row['pic'];?>"-->
      <!--/>-->
      

      <img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" />

      <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender">
        <img class="vector-icon1" alt="" src="./public/vector4.svg" />
      </a>
      <a class="next">Next</a>
      <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

      <div class="directory1">Directory</div>
      <img
        class="arcticonsgoogle-pay"
        alt="" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);"
        src="./public/arcticonsgooglepay.svg"
      />

      <a href="./employee-dashboard.php" class="dashboard" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard" href="./employee-dashboard.php" id="akarIconsdashboard">
        <img class="vector-icon2"  alt="" src="./public/vector3.svg" />
      </a>
      <div class="rectangle-parent" style="width: 1200px; height: 860px; margin-left: -90px; margin-top: -80px;">
        <div class="box-container" style="display: flex; flex-wrap: wrap;">
        <?php
$sql = "SELECT * FROM emp
WHERE dept= '$dept' 
AND empstatus = 0
 ORDER BY emp_no ASC ";
$que = mysqli_query($con,$sql);
$cnt = 1;
while ($result = mysqli_fetch_assoc($que)) {
?>
 <div class="box-item">
                <div class="flip-box">
                    <div class="flip-box-front text-center"
                        style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
                        <div class="inner color-white">
                            <h3 class="flip-box-header" style="width:300px; margin-left:-25px;"><?php echo $result['empname'];?></h3>
                            <!-- <p>A short sentence describing this callout is.</p> -->
                            <img src="pics/<?php  echo $result['pic'];?>" width="200px" height="200px"
                                style="border-radius: 100px; margin-top: -10px;" alt="">
                                <p style="margin-bottom: 25px;"><?php echo $result['desg'];?></p>
                            <img style="margin-top: -16px;" src="https://s25.postimg.cc/65hsttv9b/cta-arrow.png" alt="" class="flip-box-img">
                        </div>
                    </div>
                    <div class="flip-box-back text-center"
                        style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
                        <div class="inner color-white">
                                              <h3 name="MOBILE" class="flip-box-header">
  <a style="color:inherit; text-decoration:none;" href="tel:<?php echo $result['empph'];?>" title="Click to call">
    <?php echo $result['empph'];?>
  </a>
</h3>

                            <p name="email">
  <a style="color:inherit; text-decoration:none; width:180px; word-wrap: break-word;" href="mailto:<?php echo $result['empemail'];?>" title="Click to email">
    <?php echo $result['empemail'];?>
  </a>
</p>
                            <p><?php echo $result['dept'];?></p>
                            <!-- <button class="flip-box-button">More</button> -->
                        </div>
                    </div>
                </div>
            </div>
<!-- <div class="box-item">
    <div class="flip-box">
        <div class="flip-box-front text-center"
            style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
            <div class="inner color-white">
                <h3 class="flip-box-header"> <?php echo $result['empname'];?></h3>
                <img src="pics/<?php  echo $result['pic'];?>" width="200px" height="200px"
                    style="border-radius: 100px;" alt=""> <br>
                <img src="https://s25.postimg.cc/65hsttv9b/cta-arrow.png" alt="" class="flip-box-img">
            </div>
        </div>
        <div class="flip-box-back text-center"
            style="background-image: url('https://s25.postimg.cc/frbd9towf/cta-2.png');">
            <div class="inner color-white">
                <h3 class="flip-box-header"><?php echo $result['empph'];?></h3>
                <p><?php echo $result['empemail'];?></p>
                <button class="flip-box-button">More</button>
            </div>
        </div>
    </div>
</div> -->

<?php } ?>

        </div>
      </div>
    </div>

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
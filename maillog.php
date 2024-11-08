<?php

@include 'inc/config.php';

session_start();

if(!isset($_SESSION['user_name']) && !isset($_SESSION['name'])){
   header('location:loginpage.php');
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <!-- <link rel="stylesheet" href="./global.css" /> -->
    <link rel="stylesheet" href="./css/maillog.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap" />
</head>

<body>
    <div class="maillog">
        <div class="bg"></div>
        <img class="maillog-child" alt="" src="./public/rectangle-1@2x.png" />

        <div class="mail-log">/Mail Log</div>
        <img class="maillog-item" alt="" src="./public/rectangle-2@2x.png" />

        <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm" id="anikaHRM">
            <span>Anika</span>
            <span class="hrm">HRM</span>
        </a>
        <a class="hr-management" id="hRManagement">HR Management</a>
        <button class="maillog-inner"></button>
        <div class="logout">Logout</div>
        <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll">Payroll</a>
        <div class="reports">Reports</div>
        <img class="uitcalender-icon" alt="" src="./public/uitcalender.svg" />

        <img class="arcticonsgoogle-pay" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon" alt=""
            src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

        <!--<img class="material-symbolsperson-icon" alt="" src="./public/materialsymbolsperson.svg" />-->

        <img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" href="./index.php" />

        <a class="dashboard" id="dashboard" href="./index.php">Dashboard</a>
        <a class="fluentpeople-32-regular" style="margin-top: 130px;" id="fluentpeople32Regular">
            <img class="vector-icon" alt="" src="./public/vector.svg" />
        </a>
        <a class="employee-list" id="employeeList" href="./employee-management.php">Employee List</a>
        <a class="akar-iconsdashboard" style="margin-top: 130px;" id="akarIconsdashboard">
            <img class="vector-icon1"  alt="" src="./public/vector1.svg" />
        </a>
        <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves" id="leaves" href="./leave-management.php">Leaves</a>
        <a class="fluentperson-clock-20-regular" style="margin-top: -65px;" id="fluentpersonClock20Regular">
            <img class="vector-icon2" style="-webkit-filter: grayscale(1) invert(1);
            filter: grayscale(1) invert(1);" alt="" src="./public/vector2.svg" />
        </a>
        <a class="onboarding" id="onboarding" href="./onboarding.php">Onboarding</a>
        <a class="fluent-mdl2leave-user" style="margin-top: -197px;" id="fluentMdl2leaveUser">
            <img class="vector-icon3"  style="-webkit-filter: grayscale(1) invert(1);
            filter: grayscale(1) invert(1);" alt="" src="./public/vector3.svg" />
        </a>
        <a class="attendance" href="./attendence.php">Attendance</a>
        <a class="uitcalender">
            <img class="vector-icon4" alt="" src="./public/vector4.svg" />
        </a>
        <div class="rectangle-parent" style="overflow-x: hidden; width: 1500px;">
          <table>
          <?php
           $sql = "SELECT * FROM mail_log ORDER BY id DESC";
           $que = mysqli_query($con,$sql);
           $cnt = 1;
           while ($result = mysqli_fetch_assoc($que)) {
           ?>
            <tr>
   <?php
$timestamp = strtotime($result['log_date']);
$timestamp += 12 * 3600 + 30 * 60; 
$formattedDate = date('D', $timestamp);
$formattedDate1 = date('d', $timestamp);
$formattedDate2 = date('M', $timestamp);
$formattedDate3 = date('H\H i\M', $timestamp); // Use 'H' for 24-hour format
?>



                <td>
                    <div style="margin-bottom: 80px;">
                <div class="frame-child"></div>
                <div class="frame-child1"></div>
                <h3 style="margin-top: -90px; color:white; margin-left: 33px; font-size: 30px;"><?php echo $formattedDate; ?></h3>
                <p style="margin-top: -20px; color:white;  margin-left: 23px; font-size: 25px;"><?php echo $formattedDate1; ?> <?php echo $formattedDate2; ?></p>
                <p style="color: rgb(66, 66, 66); font-size: 30px; font-weight: 500; margin-top: -86px; margin-left: 150px;"><?php echo $formattedDate3; ?>ins</p>
                <p style="color: #ff5400; font-size: 23px; margin-top: -40px; margin-left: 330px;"><?php echo $result['purpose'];?></p>
                <p style="font-size: 23px; margin-top: -85px; margin-left: 330px; "><span style="color: #2da867;">Mail Sent to:</span> <span style="color: #4a4a4a;"><?php echo $result['email'];?></span> </p>
            </div> 
            </td>
            </tr>
            <?php $cnt++;}?>
          </table>
        </div>
        <!--<img class="ellipse-icon" alt="" src="./public/ellipse-1@2x.png" />-->

    </div>
</body>

</html>
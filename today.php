<?php
session_start();
@include 'inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
    exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
    header('location:loginpage.php');
    exit();
}

$query = "SELECT user_type FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    if ($row && isset($row['user_type'])) {
        $user_type = $row['user_type'];
        
        if ($user_type !== 'admin') {
            header('location:loginpage.php');
            exit();
        }
    } else {
        die("Error: Unable to fetch user details.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./global.css" />
  <link rel="stylesheet" href="./index.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
  <style>
    body {
      margin: 0;
      line-height: normal;
    }

    :root {
      /* fonts */
      --font-inter: Inter;
      --font-rubik: Rubik;

      /* font sizes */
      --font-size-smi: 13px;
      --font-size-xl: 20px;
      --font-size-6xl: 25px;
      --font-size-19xl: 38px;

      /* Colors */
      --color-white: #fff;
      --color-black: #000;
      --color-khaki: #fffcac;
      --color-lightblue: #cdedff;
      --color-whitesmoke: #ebecf0;
      --color-lavender: #e5e1ff;
      --color-red: #ff0000;
      --color-lightgoldenrodyellow: #d9ffcc;
      --color-darkorange: #fb840e;
      --color-bisque-100: #ffe1c4;

      /* Border radiuses */
      --br-8xs: 5px;
      --br-mini: 15px;
      --br-3xs: 10px;
      --br-31xl: 50px;
      --br-11xs: 2px;
      --br-52xl: 71px;
    }

    .bg,
    .index-child {
      position: absolute;
      right: 0;
    }

    .bg {
      width: 100%;
      top: 0;
      left: 0;
      background-color: #f6f5fb;
      height: 994px;
    }

    .index-child {
      width: 92.33%;
      top: -2px;
      left: 7.67%;
      background: linear-gradient(90deg, #fc900b, #f35c17);
      height: 81px;
    }

    .index-item,
    .logo-1-icon {
      position: absolute;
      object-fit: cover;
    }

    .index-item {
      top: -2px;
      left: -3px;
      border-radius: var(--br-11xs) var(--br-52xl) var(--br-52xl) var(--br-11xs);
      width: 366px;
      height: 1000px;
    }

    .logo-1-icon {
      top: 4px;
      left: 102px;
      width: 163px;
      height: 151px;
    }

    .hrm {
      color: #45c380;
    }

    .anikahrm,
    .hr-management {
      position: absolute;
      font-size: var(--font-size-19xl);
    }

    .anikahrm {
      text-decoration: none;
      top: 155px;
      left: 90px;
      color: inherit;
    }

    .hr-management {
      margin: 0;
      top: 16px;
      left: 385px;
      font-weight: 400;
      font-family: inherit;
      color: var(--color-white);
    }

    .index-inner {
      cursor: pointer;
      border: 0;
      padding: 0;
      background-color: transparent;
      position: absolute;
      top: 834px;
      left: 32px;
      border-radius: var(--br-31xl);
      background: linear-gradient(90deg, #f9840d, #f35d16);
      width: 200px;
      height: 55px;
    }

    .logout {
      margin: 0;
      position: absolute;
      top: 849px;
      left: 113px;
      font-size: 23px;
      font-weight: 400;
      font-family: inherit;
      color: var(--color-white);
    }

    .employee-list {
      position: absolute;
      top: 359px;
      left: 99px;
      font-weight: 300;
    }

    .employee-list,
    .leaves,
    .onboarding {
      text-decoration: none;
      color: inherit;
    }

    .leaves {
      position: absolute;
      top: 425px;
      left: 99px;
      font-weight: 300;
    }

    .onboarding {
      top: 491px;
    }

    .attendance,
    .onboarding,
    .payroll,
    .reports {
      position: absolute;
      left: 102px;
      font-weight: 300;
    }

    .attendance {
      text-decoration: none;
      top: 557px;
      color: inherit;
    }

    .payroll,
    .reports {
      margin: 0;
      top: 623px;
      font-size: inherit;
      font-family: inherit;
    }

    .reports {
      top: 689px;
    }

    .vector-icon {
      position: absolute;
      height: 68.67%;
      width: 87.33%;
      top: 15.67%;
      right: 6.33%;
      bottom: 15.67%;
      left: 6.33%;
      max-width: 100%;
      overflow: hidden;
      max-height: 100%;
      object-fit: cover;
    }

    .fluentpeople-32-regular {
      text-decoration: none;
      position: absolute;
      top: 361px;
      left: 40px;
      width: 30px;
      height: 30px;
      overflow: hidden;
    }

    .vector-icon1 {
      position: absolute;
      height: 96%;
      width: 100%;
      top: 0;
      right: 0;
      bottom: 4%;
      left: 0;
      max-width: 100%;
      overflow: hidden;
      max-height: 100%;
      object-fit: cover;
    }

    .fluent-mdl2leave-user {
      text-decoration: none;
      position: absolute;
      top: 492px;
      left: 40px;
      width: 30px;
      height: 30px;
      overflow: hidden;
    }

    .vector-icon2 {
      position: absolute;
      height: 85%;
      width: 85%;
      top: 10%;
      right: 5%;
      bottom: 5%;
      left: 10%;
      max-width: 100%;
      overflow: hidden;
      max-height: 100%;
      object-fit: cover;
    }

    .fluentperson-clock-20-regular {
      text-decoration: none;
      top: 425px;
      left: 40px;
      width: 30px;
      height: 30px;
    }

    .fluentperson-clock-20-regular,
    .uitcalender,
    .vector-icon3 {
      position: absolute;
      overflow: hidden;
    }

    .vector-icon3 {
      height: 83.33%;
      width: 83.33%;
      top: 8.33%;
      right: 8.33%;
      bottom: 8.33%;
      left: 8.33%;
      max-width: 100%;
      max-height: 100%;
      object-fit: cover;
    }

    .uitcalender {
      text-decoration: none;
      top: 558px;
      left: 40px;
      width: 30px;
      height: 30px;
    }

    .arcticonsgoogle-pay,
    .streamlineinterface-content-c-icon {
      position: absolute;
      top: 624px;
      left: 43px;
      width: 30px;
      height: 30px;
      overflow: hidden;
      object-fit: cover;
    }

    .streamlineinterface-content-c-icon {
      top: 690px;
    }

    .ellipse-icon {
      position: absolute;
      top: 2px;
      right: 30px;
      border-radius: 50%;
      width: 72px;
      height: 72px;
      object-fit: cover;
    }

    .material-symbolsperson-icon {
      position: absolute;
      top: 17px;
      right: 45px;
      width: 42px;
      height: 42px;
      overflow: hidden;
    }

    .rectangle-icon {
      position: absolute;
      top: 275px;
      left: -32px;
      border-radius: var(--br-31xl);
      width: 368px;
      height: 69px;
      object-fit: cover;
    }

    .dashboard {
      text-decoration: none;
      position: absolute;
      top: 293px;
      left: 99px;
      font-weight: 300;
      color: var(--color-white);
    }

    .vector-icon4 {
      position: absolute;
      height: 75%;
      width: 83.33%;
      top: 12.67%;
      right: 8.33%;
      bottom: 12.33%;
      left: 8.33%;
      max-width: 100%;
      overflow: hidden;
      max-height: 100%;
      object-fit: cover;
    }

    .akar-iconsdashboard {
      text-decoration: none;
      top: 294px;
      left: 43px;
      width: 30px;
      height: 30px;
    }

    .akar-iconsdashboard,
    .frame-div,
    .tablerlogout-icon {
      position: absolute;
      overflow: hidden;
    }

    .tablerlogout-icon {
      top: 847px;
      left: 71px;
      width: 30px;
      height: 30px;
      object-fit: cover;
    }

    .frame-div {
      top: 36px;
      left: 177px;
      width: 100px;
      height: 100px;
    }


    /* .frame-child {
      top: 0;
      left: calc(50% - 99px);
      border-radius: var(--br-31xl);
      background-color: #ffe2c6;
      width: 198px;
      height: 55px;
    } */

    .quick-access {
      top: 16px;
      left: calc(50% - 53px);
      color: inherit;
      display: inline-block;
      width: 126px;
      height: 26px;
    }

    .vector-icon5 {
      position: absolute;
      height: 50.91%;
      width: 7.58%;
      top: 27.27%;
      right: 81.82%;
      bottom: 21.82%;
      left: 10.61%;
      max-width: 100%;
      overflow: hidden;
      max-height: 100%;
      object-fit: cover;
    }

    .rectangle-parent {
      position: absolute;
      top: 11px;
      right: 112px;
      width: 198px;
      height: 55px;
      font-size: var(--font-size-xl);
      color: #ff5400;
    }

    .frame-item {
      position: absolute;
      top: 0;
      left: 0;
      border-radius: var(--br-3xs);
      background-color: var(--color-whitesmoke);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
      width: 285px;
      height: 526px;
    }

    .check-inout {
      margin: 0;
      position: absolute;
      top: 15px;
      left: 22px;
      font-size: inherit;
      font-weight: 400;
      font-family: inherit;
    }

    .frame-inner {
      position: absolute;
      top: 52.3px;
      left: 12.3px;
      border-top: 1.5px solid var(--color-white);
      box-sizing: border-box;
      width: 258.5px;
      height: 1.5px;
    }

    .frame-child1 {
      position: absolute;
      top: 13px;
      left: 14px;
      border-radius: var(--br-8xs);
      background-color: var(--color-lightgoldenrodyellow);
      width: 50px;
      height: 20px;
    }

    .in {
      position: absolute;
      top: 15px;
      left: 32px;
    }

    .div,
    .fingerprint,
    .narada-mohan-nanda {
      position: absolute;
      top: 44px;
      left: 14px;
    }

    .div,
    .fingerprint {
      top: 67px;
    }

    .fingerprint {
      top: 90px;
    }

    .frame-child2 {
      position: absolute;
      top: 88px;
      right: 16px;
      border-radius: 50%;
      width: 47px;
      height: 47px;
      object-fit: cover;
    }

    .material-symbolsperson-icon1 {
      position: absolute;
      top: 98px;
      right: 25px;
      width: 28px;
      height: 28px;
      overflow: hidden;
    }

    .ellipse-div {
      /* position: absolute; */
      top: 72px;
      left: 148px;
      border-radius: 50%;
      background-color: #42ff00;
      box-shadow: 0 4px 4px rgba(66, 255, 0, 0.25);
      width: 7px;
      height: 7px;
    }

    .frame-child4,
    .rectangle-container {
      position: absolute;
      top: 0;
      left: 1px;
      width: 257px;
      height: 145px;
    }

    .frame-child4 {
      top: 13px;
      left: 14px;
      border-radius: var(--br-8xs);
      background-color: var(--color-bisque-100);
      width: 50px;
      height: 20px;
    }

    .frame-child6,
    .out {
      top: 15px;
      left: 25px;
    }

    .frame-child6 {
      top: 72px;
      left: 148px;
      border-radius: 50%;
      background-color: var(--color-darkorange);
      box-shadow: 0 4px 4px rgba(251, 132, 14, 0.25);
      width: 7px;
      height: 7px;
    }

    .frame-child14,
    .rectangle-parent1,
    .rectangle-parent2 {
      top: 152px;
      left: 0;
      width: 257px;
      height: 145px;
    }

    .frame-child14,
    .rectangle-parent2 {
      top: 608px;
    }

    .frame-child14 {
      top: 72px;
      left: 148px;
      border-radius: 50%;
      background-color: var(--color-red);
      box-shadow: 0 4px 4px rgba(255, 0, 0, 0.25);
      width: 7px;
      height: 7px;
    }

    .frame-group,
    .rectangle-parent3,
    .rectangle-parent4 {
      position: absolute;
      top: 304px;
      left: 0;
      width: 257px;
      height: 145px;
    }

    .frame-group,
    .rectangle-parent4 {
      top: 456px;
      left: 1px;
    }

    .frame-group {
      top: 61px;
      left: 14px;
      width: 258px;
      height: 449px;
      overflow-y: auto;
      font-size: var(--font-size-smi);
    }

    .rectangle-group {
      position: absolute;
      top: 0;
      left: 0;
      width: 285px;
      height: 526px;
      overflow: hidden;
    }

    .frame-child20 {
      position: absolute;
      top: 0;
      left: 0;
      border-radius: var(--br-mini);
      background-color: var(--color-white);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
      width: 257px;
      height: 125px;
    }

    .frame-child21 {
      position: absolute;
      top: 13px;
      left: 14px;
      border-radius: var(--br-8xs);
      background-color: var(--color-lavender);
      width: 148px;
      height: 24px;
    }

    .web-developer {
      position: absolute;
      top: 17px;
      left: calc(50% - 87.5px);
    }

    .frame-child22 {
      position: absolute;
      top: 68px;
      right: 16px;
      border-radius: 50%;
      width: 47px;
      height: 47px;
      object-fit: cover;
    }

    .material-symbolsperson-icon6 {
      position: absolute;
      top: 78px;
      right: 25px;
      width: 28px;
      height: 28px;
      overflow: hidden;
    }

    .rectangle-parent6 {
      position: absolute;
      top: 0;
      left: 0;
      width: 257px;
      height: 125px;
    }

    .rectangle-parent7,
    .rectangle-parent8,
    .rectangle-parent9 {
      position: absolute;
      top: 134px;
      left: 0;
      width: 257px;
      height: 125px;
    }

    .rectangle-parent8,
    .rectangle-parent9 {
      top: 268px;
    }

    .rectangle-parent9 {
      top: 402px;
    }

    .frame-container,
    .rectangle-parent10,
    .rectangle-parent11 {
      position: absolute;
      top: 536px;
      left: 0;
      width: 257px;
      height: 125px;
    }

    .frame-container,
    .rectangle-parent11 {
      top: 670px;
    }

    .frame-container {
      top: 59px;
      left: 13px;
      height: 446px;
      overflow-y: auto;
      font-size: var(--font-size-smi);
    }

    .rectangle-parent5 {
      position: absolute;
      top: 0;
      left: 302px;
      width: 285px;
      height: 526px;
      overflow: hidden;
    }

    .frame-parent1 {
      position: absolute;
      top: 61px;
      left: 13px;
      width: 257px;
      height: 446px;
      overflow-y: auto;
      font-size: var(--font-size-smi);
    }

    .rectangle-parent12 {
      position: absolute;
      top: 0;
      left: 604px;
      width: 285px;
      height: 526px;
      overflow: hidden;
    }

    .frame-child61 {
      position: absolute;
      top: 13px;
      left: 14px;
      border-radius: var(--br-8xs);
      background-color: var(--color-lightblue);
      width: 148px;
      height: 24px;
    }

    .change-password {
      position: absolute;
      top: 17px;
      left: 32px;
    }

    .rectangle-parent20 {
      position: absolute;
      top: 0;
      left: 3px;
      width: 257px;
      height: 125px;
    }

    .frame-child70,
    .rectangle-parent21,
    .rectangle-parent22 {
      position: absolute;
      top: 266px;
      left: 2px;
      width: 257px;
      height: 125px;
    }

    .frame-child70,
    .rectangle-parent22 {
      top: 532px;
      left: 1px;
    }

    .frame-child70 {
      top: 13px;
      left: 14px;
      border-radius: var(--br-8xs);
      background-color: var(--color-khaki);
      width: 148px;
      height: 24px;
    }

    .leave-request {
      position: absolute;
      top: 17px;
      left: 46px;
    }

    .rectangle-parent23 {
      position: absolute;
      top: 133px;
      left: 2px;
      width: 257px;
      height: 125px;
    }

    .frame-parent2,
    .rectangle-parent24,
    .rectangle-parent25 {
      position: absolute;
      top: 399px;
      left: 1px;
      width: 257px;
      height: 125px;
    }

    .frame-parent2,
    .rectangle-parent25 {
      top: 665px;
      left: 0;
    }

    .frame-parent2 {
      top: 61px;
      left: 13px;
      width: 260px;
      height: 443px;
      overflow-y: auto;
      font-size: var(--font-size-smi);
    }

    .rectangle-parent19 {
      position: absolute;
      top: 0;
      left: 906px;
      width: 285px;
      height: 526px;
      overflow: hidden;
    }

    .frame-parent,
    .index {
      text-align: left;
      color: var(--color-black);
    }

    .frame-parent {
      position: absolute;
      height: calc(100% - 468px);
      top: 96px;
      bottom: 372px;
      left: calc(50% - 411.5px);
      width: 1191px;
      font-size: var(--font-size-xl);
      font-family: var(--font-inter);
    }

    .index {
      position: relative;
      background-color: var(--color-white);
      width: 100%;
      height: 994px;
      overflow: hidden;
      font-size: var(--font-size-6xl);
      font-family: var(--font-rubik);
    }

    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #bebebe;
    }

    .asdf {
      z-index: 9999;
      margin-top: -125px;
      margin-left: 30px;
      border-radius: var(--br-8xs);
      background-color: var(--color-lightgoldenrodyellow);
      width: 70px;
      height: 20px;
    }

    .qwer {
      z-index: 9999;
      margin-top: -125px;
      margin-left: 28px;
      border-radius: var(--br-8xs);
      background-color: #ffe1c4;
      width: 85px;
      height: 20px;
    }
     .hovpic{
      position: relative !important;
      z-index:10000 !important;
    }
    .hovpic:hover{
      transform: scale(3) translate(-15px, -10px) !important;
    }
    .hovpic1{
      position: relative !important;
      z-index:10000 !important;
    }
    .hovpic1:hover{
         z-index:10000 !important;
      transform: scale(3) translate(15px, 10px) !important;
    }
    .image-2024-01-17-154424414-rem-icon {
  position: absolute;
  top: 0;
  left: 0;
  width: 295px;
  height: 272px;
  object-fit: cover;
}
.b,
.frame-child {
  position: absolute;
}
.frame-child {
  top: 0;
  left: 0;
  border-radius: 50%;
  background-color: var(--color-white);
  width: 156px;
  height: 156px;
}
.b {
  text-align: center !important;
  top: 40px;
  left: 35px;
  display: inline-block;
  width: 82px;
  height: 72px;
  font-size:72px;
}
.ellipse-parent {
  position: absolute;
  top: 58px;
  left: 70px;
  width: 156px;
  height: 156px;
}
.image-2024-01-17-154424414-rem-parent {
  position: absolute;
  top: -125px;
  left: 80px;
  width: 295px;
  height: 272px;
}
.image-2024-01-17-154712686-rem-icon {
  position: absolute;
  top: 0;
  left: 0;
  width: 272px;
  height: 272px;
  object-fit: cover;
}
.ellipse-group {
  position: absolute;
  top: 58px;
  left: 57px;
  width: 156px;
  height: 156px;
}
.image-2024-01-17-154712686-rem-parent {
  position: absolute;
  top: -125px;
  left: 80px;
  width: 295px;
  height: 272px;
}
.image-2024-01-17-154939738-rem-icon {
  position: absolute;
  top: 0;
  left: 0;
  width: 306.8px;
  height: 272px;
  object-fit: cover;
}
.b2 { 
   text-align: center !important;
  position: absolute;
  top: 40px;
  left: 30px;
  display: inline-block;
  width: 82px;
  height: 72px;
  font-size:72px;
}
.ellipse-container {
  position: absolute;
  top: 45px;
  left: 75px;
  width: 156px;
  height: 156px;
}
.image-2024-01-17-154939738-rem-parent {
  position: absolute;
  top: -122px;
  left: 80px;
  width: 295px;
  height: 272px;
}
tr {
    border-bottom: 2px solid black !important;
}

td {
    padding: 2px;
}

  </style>
</head>

<body>
  <div class="index">
    <section class="bg"></section>
    <section class="index-child"></section>
    <img class="index-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm">
      <span>Anika</span>
      <span class="hrm">HRM</span>
    </a>
    <h5 class="hr-management">HR Management</h5>
    <button class="index-inner" autofocus="{true}"></button>
    <h2 class="logout">Logout</h2>
    <a class="employee-list">Employee List</a>
    <a class="leaves">Leaves</a>
    <a class="onboarding">Onboarding</a>
    <a class="attendance">Attendance</a>
    <h2 class="payroll">Payroll</h2>
    <h2 class="reports">Reports</h2>
    <a class="fluentpeople-32-regular">
      <img class="vector-icon" alt="" src="./public/vector@2x.png" />
    </a>
    <a class="fluent-mdl2leave-user">
      <img class="vector-icon1" alt="" src="./public/vector@2x.png" />
    </a>
    <a class="fluentperson-clock-20-regular">
      <img class="vector-icon2" alt="" src="./public/vector@2x.png" />
    </a>
    <a class="uitcalender">
      <img class="vector-icon3" alt="" src="./public/vector@2x.png" />
    </a>
    <img class="arcticonsgoogle-pay" alt="" src="./public/arcticonsgooglepay@2x.png" />

    <img class="streamlineinterface-content-c-icon" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart@2x.png" />

    <img class="ellipse-icon" alt="" src="./public/ellipse-1@2x.png" />

    <img class="material-symbolsperson-icon" alt="" src="./public/materialsymbolsperson.svg" />

    <img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard">Dashboard</a>
    <a class="akar-iconsdashboard">
      <img class="vector-icon4" alt="" src="./public/vector@2x.png" />
    </a>
    <img class="tablerlogout-icon" alt="" src="./public/tablerlogout@2x.png" />

    <div class="frame-div"></div>
        <?php
  @include 'inc/config.php';
   $sql1 = "SELECT COUNT(*) as count
  FROM emp e
  JOIN CamsBiometricAttendance c ON e.UserID = c.UserID
  WHERE DATE(AttendanceTime) = CURDATE() + INTERVAL 24 HOUR
    AND AttendanceType = 'CheckIn'
    AND NOT EXISTS (
        SELECT 1
        FROM CamsBiometricAttendance co
        WHERE co.UserID = c.UserID
          AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
          AND co.AttendanceType = 'CheckOut'
    )";
  $result1 = 

  $result1 = $con->query($sql1);
  $row1 = $result1->fetch_assoc();
  $count1 = $row1['count'];
  $sql2 = "SELECT COUNT(*) as count FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE l.status = 1 AND l.status1 = 1 AND CURDATE() + INTERVAL 24 HOUR BETWEEN DATE(l.from) AND DATE(l.to)";

  $result2 = $con->query($sql2);
  $row2 = $result2->fetch_assoc();
  $count2 = $row2['count'];

  $sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE TIMESTAMP(DATE(AttendanceTime)) = CURDATE() + INTERVAL 24 HOUR";

  $result3 = $con->query($sql3);
  $row3 = $result3->fetch_assoc();
  $count3 = $row3['count'];

  $sql4 = "SELECT COUNT(*) as count FROM emp";

  $result4 = $con->query($sql4);
  $row4 = $result4->fetch_assoc();
  $count4 = $row4['count'];
  $con->close();
  ?>
    <section class="frame-parent">
      <div id="main">
        <div class="frame-item" >
         <h3 class="check-inout">Employee's on Duty<span style="font-size:14px;margin-left:20px;">
         <div class="image-2024-01-17-154939738-rem-parent" style="scale:0.3;;z-index:10000;">
        <img
          class="image-2024-01-17-154939738-rem-icon"
          alt=""
          src="./public/image-20240117-154939738removebgpreview-1@2x.png"
        />

        <div class="ellipse-container">
          <div class="frame-child"></div>
          <b class="b2"><?php echo $count1;?></b>
        </div>
      </div>
        </span></h3>
          <div class="frame-inner"></div>
          <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px;">
            <?php
            @include 'inc/config.php';
            if ($con->connect_error) {
              die("Connection failed: " . $con->connect_error);
            }
         $sql = "SELECT e.empname, e.pic, c.AttendanceTime, c.InputType, c.AttendanceType
        FROM emp e
        JOIN CamsBiometricAttendance c ON e.UserID = c.UserID
        WHERE TIMESTAMP(DATE(AttendanceTime)) = CURDATE() + INTERVAL 24 HOUR ORDER BY AttendanceTime DESC";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<table style="margin-top: -60px;">
              <tr>
                <td style="display: block; margin-bottom: 15px;padding:4px;">
                  <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 145px;"></div>';

                if ($row['AttendanceType'] == 'CheckIn') {
                  echo '<div class="asdf"></div>';
                } elseif ($row['AttendanceType'] == 'CheckOut') {
                  echo '<div class="qwer"></div>';
                }
                echo '<p style="font-size: 16px; margin-left: 33px; margin-top: -20px;">' . $row['AttendanceType'] . '</p>
              <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
              <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['AttendanceTime'] . '</p>
              <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['InputType'] . '</p>
              <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -40px; margin-left: 200px; border-radius: 60%;height: 50px;" alt="">
                </td>
              </tr>
            </table>';
              }
            }else {
              echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No CheckIn/CheckOut today</div>';
            }
            $con->close();
            ?>
       
          </div>
        </div>
      </div>
      <div id="main1">

        <div class="frame-item" style="margin-left: 300px; z-index: 100;">
          <h3 class="check-inout" style=" z-index: 100;">Employee's on leave<span style="font-size:14px;margin-left:20px;">
         <div class="image-2024-01-17-154424414-rem-parent" style="scale:0.3;z-index:10000;">
        <img
          class="image-2024-01-17-154424414-rem-icon"
          alt=""
          src="./public/image-20240117-154424414removebgpreview-1@2x.png"
        />
        <div class="ellipse-parent">
          <div class="frame-child"></div>
          <b class="b"><?php echo $count2;?></b>
        </div>
      </div>
        </span></h3>
          <div class="frame-inner"></div>
          <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
                 <?php
            include 'inc/config.php';

            function formatDateTime($dateTime)
            {
              $formattedDate = date('Y-m-d', strtotime($dateTime));
              return (substr($dateTime, 11) === '00:00:00') ? $formattedDate : $dateTime;
            }

            $sql = "SELECT e.empname, e.empph, l.leavetype, l.from, l.to, l.status, l.status1, e.pic
        FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE l.status = 1 AND l.status1 = 1 AND CURDATE() + INTERVAL 24 HOUR  BETWEEN DATE(l.from) AND DATE(l.to)";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $fromDateTime = date('Y-m-d H:i:s', strtotime($row['from']));
                $toDateTime = date('Y-m-d H:i:s', strtotime($row['to']));

                echo '<table style="margin-top: -60px;">
                <tr>
                    <td style="display: block; margin-bottom: 24px;">
                        <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>
                        <div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lavender);width: 148px; height: 24px;"></div>
                        <p style="font-size: 16px; margin-left: 45px; margin-top: -20px;font-size:14px;">' . $row['leavetype'] . '</p>
                        <p style="font-size: 12px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
                        <p style="font-size: 12px; margin-left: 30px; margin-top: -8px; width: 130px;">' . $row['empph'] . '</p>
                        <p class="leave-request-datetime" style="font-size: 12px; margin-left: 30px; margin-top: -8px; width: 170px;">' .
                  formatDateTime($fromDateTime) . ' to ' . formatDateTime($toDateTime) . '</p>
                        <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-left: 200px; border-radius: 100px; margin-top: -40px;height:50px;" alt="">
                    </td>
                </tr>
            </table>';
              }
            } else {
              echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No employee on Leave today</div>';
            }

            $result->close();
            $con->close();
            ?>

          </div>
        </div>
      </div>
      <div id="main2">

        <div class="frame-item" style="margin-left: 600px; z-index: 100;">

        <h3 class="check-inout" style=" z-index: 100;">Absentees<span style="font-size:14px;margin-left:20px;">
        <div class="image-2024-01-17-154712686-rem-parent" style="scale:0.3;z-index:10000;">
        <img
          class="image-2024-01-17-154712686-rem-icon"
          alt=""
          src="./public/image-20240117-154712686removebgpreview-1@2x.png"
        />

        <div class="ellipse-group">
          <div class="frame-child"></div>
          <b class="b"><?php echo $count3;?></b>
        </div>
      </div>
        </span> </h3>
          <div class="frame-inner"></div>
          <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
            <?php
            @include 'inc/config.php';
            $sql = "SELECT a.empname, e.empph, e.pic, e.desg 
        FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE DATE(a.AttendanceTime) = CURDATE() + INTERVAL 24 HOUR ";


            $result = $con->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<table style="margin-top: -60px;">
              <tr>
                <td style="display: block;margin-bottom: 15px;padding:4px;">
                  <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 120px;"></div>
                  <div style="z-index: 9999; margin-top: -110px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lavender);width: 148px; height: 24px;"></div>
                  <p style="font-size: 16px; margin-left: 30px; margin-top: -22px;font-size:14px;">' . $row['desg'] . '</p>
                  <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
                  <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empph'] . '</p>
                  <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -35px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">
                  </td>
                </td>
              </tr>
            </table>';
              }
            } else {
              echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No absentees today</div>';
            }

            $con->close();
            ?>
          </div>
        </div>
      </div>
      <div id="main3">

        <div class="frame-item" style="margin-left: 900px; z-index: 100;">

          <h3 class="check-inout" style=" z-index: 100;">Employee Request's</h3>
          <div class="frame-inner" style=" z-index: 100;"></div>
          <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
          <?php
include 'inc/config.php';
$sql = "SELECT leaves.empname, leaves.applied, leaves.status, leaves.status1, emp.pic
        FROM leaves
        INNER JOIN emp ON leaves.empname = emp.empname
        WHERE ((leaves.status = 0 AND leaves.status1 = 0) OR (leaves.status = 3 AND leaves.status1 = 0)) 
        ORDER BY leaves.applied DESC";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $status = $row['status'];
      $status1 = $row['status1'];
    echo '<table style="margin-top: -60px;">';
                echo '<tr>';
                echo '<td style="display: block;margin-bottom: 5px;padding:4px;">';
                echo '<div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>';
                echo '<div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lightblue);width: 148px; height: 24px;"></div>';
                echo '<p style="font-size: 14px; margin-left: 43px; margin-top: -22px;">Leave Request</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -5px;">' . $row['empname'] . '</p>';
                $formattedDate = date('H:i:s d-m-Y', strtotime($row['applied']));
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -5px; width: 130px;">[Pending from-</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -10px; width: 130px;">' . $formattedDate . ']</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -7px;">' .
                  (($status == '0' && $status1 == '0') ? 'HR-Action Pending' : (($status == '3' && $status1 == '0') ? 'Pending at Approver' : '')) . '</p>';
                echo '<img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -60px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
    }
    mysqli_free_result($result);
} else {
  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No requests today</div>';
}
mysqli_close($con);
?>

          </div>
        </div>
      </div>
      <div class="chart" style="display: flex; gap: 20px; margin-left: 400px; width: 335px; margin-top: 520px;">
        <div class="frame-item" style="height: 340px; margin-top: 540px; margin-left: 300px; width: 885px;"></div>
        <canvas id="myChart1" style="width: 500px; height: 400px; margin-top: 90px; z-index: 999999;"></canvas>
        <canvas id="myChart" style="margin-top: 20px; z-index: 999999;"></canvas>
        <div style="z-index: 999999999; background-color: white; height: 40px; width: 270px; margin-left: -800px; margin-top: 30px; border-radius: 10px; display: flex; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
          <img src="./public/groupicon.png" width="62px" height="60px" style="margin-top: -12px;" alt="">
          <p style="font-size: 14px;  margin-top: 10px;margin-left:-10px;">Total Active Employee's => <sub style="font-size: 20px; font-weight: 600;">43</sub> </p>
        </div>
      </div>
      <div id="main4">
        <div class="frame-item" style="  margin-top: 540px; height: 340px;">
          <h3 class="check-inout" >Birthday's</h3>
          <div class="frame-inner" ></div>
          <div style="position:absolute;overflow-y: auto; height: 270px; width: 285px; margin-top: 60px; background-color: white; width: 270px; margin-left: 7px; border-radius: 10px;">
<?php
include('inc/config.php');

$query = "SELECT pic, empname, empdob FROM emp ORDER BY MONTH(empdob), DAY(empdob)";
$result = mysqli_query($con, $query);

if ($result) {
    $todayData = '';
    $otherData = '';

    while ($row = mysqli_fetch_assoc($result)) {
        $limitedEmpName = substr($row['empname'], 0, 13);
        $formattedEmpDob = date('M, d', strtotime($row['empdob']));
        $isCurrentDate = date('M, d') == $formattedEmpDob;
        $trBackgroundColor = $isCurrentDate ? 'color:white;background: url(https://i.pinimg.com/originals/9a/1c/94/9a1c94e764a96733ff449a592bb64cfb.jpg);background-size: cover;outline:2px solid #ad8047;border-radius:25px;' : '';
        $trPicColor = $isCurrentDate ? 'outline:1px solid  #FFCC33;border-radius:30px;' : '';

        $rowData = '<table>
                        <tr >
                            <td></td>
                            <td> <img class="hovpic1" src="pics/' . $row['pic'] . '" width="30px" style="border-radius: 50px;' . $trPicColor . '" alt=""> </td>
                            <td style="font-size: 14px;' . $trBackgroundColor . '">' . $limitedEmpName . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="font-size: 14px; text-align: right;' . $trBackgroundColor . '">' . $formattedEmpDob . '</td>
                        </tr>
                    </table>';

        if ($isCurrentDate) {
            $todayData .= $rowData;
        } else {
            $otherData .= $rowData; 
        }
    }

    echo $todayData . $otherData; 
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>



          </div>
        </div>
      </div>
    </section>
  </div>
  <?php
     @include 'inc/config.php';
    $sql1 = "SELECT COUNT(*) as count
  FROM emp e
  JOIN CamsBiometricAttendance c ON e.UserID = c.UserID
  WHERE DATE(AttendanceTime) = CURDATE() + INTERVAL 24 HOUR
    AND AttendanceType = 'CheckIn'
    AND NOT EXISTS (
        SELECT 1
        FROM CamsBiometricAttendance co
        WHERE co.UserID = c.UserID
          AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
          AND co.AttendanceType = 'CheckOut'
    )";

$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$count1 = $row1['count'];
$sql2 = "SELECT COUNT(*) as count FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE l.status = 1 AND l.status1 = 1 AND CURDATE() + INTERVAL 24 HOUR  BETWEEN DATE(l.from) AND DATE(l.to)";

$result2 = $con->query($sql2);
$row2 = $result2->fetch_assoc();
$count2 = $row2['count'];

$sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE TIMESTAMP(DATE(AttendanceTime)) = CURDATE() + INTERVAL 24 HOUR ";

$result3 = $con->query($sql3);
$row3 = $result3->fetch_assoc();
$count3 = $row3['count'];

$sql4 ="SELECT COUNT(*) as count FROM emp";

$result4 = $con->query($sql4);
$row4 = $result4->fetch_assoc();
$count4 = $row4['count'];
$con->close();
?>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels@0.1.4/dist/chartjs-plugin-piechart-outlabels.min.js"></script>
<script>
  var maxCount = <?php echo ceil($count4); ?>;
  maxCount = Math.ceil(maxCount); 
</script>
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var count = Math.ceil(<?php echo $count4; ?>);
  var chart = new Chart(ctx, {
    type: 'polarArea',
          labels: ["Absentees", "Employee's on leave","Employee's on Duty" ],
    data: {
      datasets: [{
        label: 'EMS',
        data: [<?php echo $count3; ?>, <?php echo $count2; ?>, <?php echo $count1; ?>],
        backgroundColor: [
          'rgba(255, 99, 132, 0.4)',
          'rgba(54, 162, 235, 0.4)',
          'rgba(154, 255, 132, 0.4)',
        ],
        borderColor: [
             'rgba(255, 80, 132, 1)',
             'rgba(54, 70, 235, 1)',
          'rgba(154, 255, 13, 9)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        r: {
          beginAtZero: true,
          max: maxCount,
          ticks: {
            stepSize: 1,
          },
        }
      }
    }
  });
</script>
<script>
  var ctx = document.getElementById('myChart1').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Employee's on Duty", "Employee's on leave", "Absentees"],
      datasets: [{
        data: [<?php echo $count1; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>],
        backgroundColor: [
          'rgba(154, 255, 132, 0.4)',
          'rgba(54, 162, 235, 0.4)',
          'rgba(255, 99, 132, 0.4)',
        ],
        borderColor: [
        'rgba(154, 255, 13, 9)',
              'rgba(54, 70, 235, 1)',
              'rgba(255, 80, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          max: maxCount,
          ticks: {
            stepSize: 1,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
      },
    }
  });
</script>
<script>
  var ctx = document.getElementById('myChart2').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Employee's on Duty", "Employee's on leave","Absentees"],
      datasets: [{
        data: [<?php echo $count1; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>],
        backgroundColor: [
          'rgba(154, 255, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 99, 132, 0.2)',
        ],
        borderColor: [
          'rgba(154, 255, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 99, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      tooltips: {
        enabled: false
      },
      animation: {
        animateRotate: true,
        animateScale: true
      }
    }
  });
</script>

</html>
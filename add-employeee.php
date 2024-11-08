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

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];
    $work_location = $row['work_location'];

    if ($user_type1 !== 'admin' && $user_type !== 'user') {
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

  <link rel="stylesheet" href="./css/global1.css" />
  <link rel="stylesheet" href="./css/frame-22.css" />
  <link rel="stylesheet" href="./css/frame-18.css" />
  <link rel="stylesheet" href="./css/frame-19.css" />
  <link rel="stylesheet" href="./css/frame-20.css" />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  <style>
    .section {
      display: none;
    }

    .active {
      display: block;
    }

    #pdfPreview {
      overflow-x: hidden;
      margin-left: 1200px;
      margin-top: 280px;

      width: 400px;
      height: 400px;
      z-index: 100;
    }

    .avatar-upload {
      position: relative;
      max-width: 205px;
      margin: 50px auto;
    }

    .avatar-upload .avatar-edit {
      position: absolute;
      right: 12px;
      z-index: 1;
      top: 10px;
    }

    .avatar-upload .avatar-edit input {
      display: none;
    }

    .avatar-upload .avatar-edit input+label {
      display: inline-block;
      width: 34px;
      height: 34px;
      margin-bottom: 0;
      border-radius: 100%;
      background: #FFFFFF;
      border: 1px solid transparent;
      box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
      cursor: pointer;
      font-weight: normal;
      transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
      background: #f1f1f1;
      border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
      content: "\f040";
      font-family: 'FontAwesome';
      color: #757575;
      position: absolute;
      top: 10px;
      left: 0;
      right: 0;
      text-align: center;
      margin: auto;
    }

    .avatar-upload .avatar-preview {
      width: 192px;
      height: 192px;
      position: relative;
      border-radius: 100%;
      border: 6px solid #F8F8F8;
      box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload .avatar-preview>div {
      width: 100%;
      height: 100%;
      border-radius: 100%;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    .container-full {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      position: absolute !important;
      top: 300px;
      left: 600px;
      width: 50%;
      align-items: center;
    }

    .container {

      flex: 0 0 22%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card h3 {
      font-size: 22px;
      font-weight: 600;
    }

    .drop_box {
      margin: 10px 0;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      border: 3px dotted #a3a3a3;
      border-radius: 5px;
    }

    .drop_box h4 {
      font-size: 10px;
      font-weight: 400;
      color: #2e2e2e;
    }

    .drop_box p {
      margin-top: 10px;
      margin-bottom: 10px;
      font-size: 10px;
      color: #a3a3a3;
    }

    .btn {
      text-decoration: none;
      background-color: #005af0;
      color: #ffffff;
      padding: 5px 5px;
      border: none;
      outline: none;
      transition: 0.3s;
    }

    .btn:hover {
      text-decoration: none;
      background-color: #ffffff;
      color: #005af0;
      padding: 5px 5px;
      border: none;
      outline: 1px solid #010101;
    }

    .font {
      font-size: 10px;
    }
    .hidden-file-input {
            display: none;
        }
        .file-name {
            margin-top: 10px;
            font-size: 10px;
        }

     
.checkbox.style-e {
  display: inline-block;
  position: relative;
  padding-left: 50px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.checkbox.style-e input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
.checkbox.style-e input:checked ~ .checkbox__checkmark {
  background-color: #F56C12;
}
.checkbox.style-e input:checked ~ .checkbox__checkmark:after {
  left: 21px;
}
.checkbox.style-e:hover input ~ .checkbox__checkmark {
  background-color: #eee;
}
.checkbox.style-e:hover input:checked ~ .checkbox__checkmark {
  background-color: #F56C12;
}
.checkbox.style-e .checkbox__checkmark {
  position: absolute;
  top: 1px;
  left: 0;
  height: 22px;
  width: 40px;
  background-color: #eee;
  transition: background-color 0.25s ease;
  border-radius: 11px;
}
.checkbox.style-e .checkbox__checkmark:after {
  content: "";
  position: absolute;
  left: 3px;
  top: 3px;
  width: 16px;
  height: 16px;
  display: block;
  background-color: #fff;
  border-radius: 50%;
  transition: left 0.25s ease;
}
.checkbox.style-e .checkbox__body {
  color: #333;
  line-height: 1.4;
  font-size: 16px;
  transition: color 0.25s ease;
}

.personal-details-container {
    background-color: #FFF5E6;
    border: 2px solid #FFA500;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 0px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-height:100%;
  }

  .personal-details-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .personal-details-icon {
    width: 30px;
    height: 30px;
    margin-right: 15px;
    fill: #FFA500;
  }

  .personal-details-title {
    font-size: 24px;
    font-weight: bold;
    color: #FFA500;
    margin: 0;
  }

  .personal-details-info {
    font-size: 16px;
    color: #666;
  }
  </style>
  <script>
    $(document).ready(function(e) {
      function generateEmployeeID() {
        var prefix = 'ASPL';

        var lastEmployeeID = getLastEmployeeIDFromDB();

        var lastNumber = parseInt(lastEmployeeID.substring(8));

        if (!isNaN(lastNumber)) {
          var newNumber = lastNumber + 1;
        } else {
          var newNumber = 1;
        }

        var today = new Date();
        var date = today.getFullYear() + ('0' + (today.getMonth() + 1)).slice(-2) + ('0' + today.getDate()).slice(-2);

        var newEmployeeID = prefix + date + ('0000' + newNumber).slice(-4);

        return newEmployeeID;
      }

      function getLastEmployeeIDFromDB() {
        var lastEmployeeID = '';
        $.ajax({
          type: 'GET',
          url: 'get_last_employee_id.php',
          async: false,
          success: function(response) {
            lastEmployeeID = response;
          }
        });

        return lastEmployeeID;
      }

      $('#empid').val(generateEmployeeID());

      function generateUniqueId() {
        var timestamp = new Date().getTime();
        return 'EMP' + timestamp;
      }


      $("#frm").on('submit', function(e) {
        e.preventDefault();
        var spOwnerCheckbox = $('#sp_owner_checkbox');
        var spOwnerValue = spOwnerCheckbox.is(':checked') ? 'Yes' : 'No';
        spOwnerCheckbox.val(spOwnerValue);


        Swal.fire({
          title: 'Loading...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          type: 'POST',
          url: 'upload.php',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.submitBtn').attr("disabled", "disabled");
            $('#frm').css("opacity", ".5");
          },
          success: function(msg) {
            // Hide loading spinner
            Swal.close();

            console.log(msg);
            $('.statusMsg').html('');
            if (msg == 'ok') {
              $('#frm')[0].reset();
              swal({
                type: "success",
                title: "Employee Added Successfully"
              }, function() {
                window.location = "employee-management.php";
              });
            } else {
              $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
            }
            $('#frm').css("opacity", "");
            $(".submitBtn").removeAttr("disabled");
          }
        });
      });

      function generateUniqueId() {
        var timestamp = new Date().getTime();
        return 'EMP' + timestamp;
      }
    });
  </script>
  <style>
    .section {
      display: none;
    }

    .active {
      display: block;
    }

    #pdfPreview {
      overflow-x: hidden;
      margin-left: 1200px;
      margin-top: 280px;

      width: 400px;
      height: 400px;
      z-index: 100;
    }

    a:hover {
      text-decoration: none;
      color: inherit;
    }

    .employee-management:hover {
      color: white;
    }

    .employee-list2:hover {
      color: white;
    }

    #service_provider, #sp_owner, #salary-fixed , #employment-type {
            display: none;
        }

        .elegant-modal .modal-content {
    background: linear-gradient(135deg, #FEF3E2 0%, #FFD18E 100%);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    top:200px;
  }
  
  .elegant-modal .modal-header {
    border-bottom: none;
    padding: 25px 25px 0;
  }
  
  .elegant-modal .modal-title {
    color: #3a4f63;
    font-weight: 600;
    font-size: 1.5rem;
  }
  
  .elegant-modal .modal-body {
    padding: 25px;
    color: #4a5568;
    font-size: 1.1rem;
  }
  
  .elegant-modal .modal-footer {
    border-top: none;
    padding: 0 25px 25px;
  }
  
  .elegant-modal .btn {
    padding: 10px 20px;
    border-radius: 30px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
  }
  
  .elegant-modal .btn-secondary {
    background-color: #cbd5e0;
    border: none;
    color: #4a5568;
  }
  
  .elegant-modal .btn-primary {
    background-color: #FFAD60;
    border: none;
  }
  
  .elegant-modal .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }
  
  .elegant-modal .close {
    color: #4a5568;
    opacity: 0.7;
    transition: all 0.3s ease;
  }
  
  .elegant-modal .close:hover {
    opacity: 1;
  }
  input{
    border-radius: 10px !important;
  }
  </style>
</head>

<body style="margin-left:-30px;">
  <div class="bg-parent">
    <div class="bg"></div>
    <img class="rectangle-icon" alt="" src="./public/rectangle-32@2x.png" />

    <img class="frame-child47" alt="" src="./public/rectangle-33@2x.png" />

    <img class="logo-2-icon" alt="" src="./public/logo-11@2x.png" />

    <a class="anikahrm1" href="./index.php">
      <span>Anika</span>
      <span class="hrm1">HRM</span>
    </a>
    <a class="employee-management" href="./index.php" id="employeeManagement">Employee Management</a>
    <a href="logout.php"> <button class="frame-child48"></button>
      <div class="logout1" style="margin-top:-5px;">Logout</div>
    </a>
    <a class="leaves1" style="z-index: 10;" href="./leave-management.php">Leaves</a>
    <a class="onboarding2" style="z-index: 10;" href="./onboarding.php">Onboarding</a>
    <a class="attendance1" style="z-index: 10;" href="./attendence.php">Attendance</a>
    <a href="./Payroll/payroll.php" style="text-decoration:none; color:black; z-index:9999;" class="payroll1">Payroll</a>
    <div class="reports1">Reports</div>
    <!--<img class="frame-child49" alt="" src="./public/ellipse-2@2x.png" />-->

    <!--<img class="material-symbolsperson-icon4" alt="" src="./public/materialsymbolsperson.svg" />-->

    <img class="frame-child50" alt="" style="margin-left:27px;" src="./public/rectangle-35@2x.png" />
    <img src="./public/vector3.svg" width="30px" style="position:absolute; margin-top: 300px; margin-left:70px;" />
    <img src="./public/vector2.svg" width="30px" style="position:absolute; margin-top: 370px; margin-left:70px;" />
    <img src="./public/vector1.svg" width="30px" style="position:absolute; margin-top: 430px; margin-left:70px;" />
    <img src="./public/vector.svg" width="30px" style="position:absolute; margin-top: 500px; margin-left:70px;" />
    <img src="./public/vector4.svg" width="30px" style="position:absolute; margin-top: 560px; margin-left:70px;" />
    <img src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" width="30px" style="position:absolute; margin-top: 690px; margin-left:70px;" />
    <img src="./public/arcticonsgooglepay.svg" width="30px" style="position:absolute; margin-top: 630px; margin-left:70px;" />
    <img src="./public/tablerlogout.svg" width="30px" style="position:absolute; margin-top: 848px; margin-left:100px;" />
    <a class="dashboard1" href="./index.php" style="z-index: 10;" id="dashboard">Dashboard</a>
    <a class="employee-list2" style="z-index: 10;" href="employee-management.php">Employee List</a>
    <div class="section active" id="section1">
      <div class="frame-wrapper">
        <div class="rectangle-parent1" style="z-index: 1;">
          <div class="frame-child25" style="margin-left:-15px; width:1512px;"></div>
          <div class="rectangle-parent2">
            <div class="frame-child52"></div>
            <div class="frame-child53"></div>
            <div class="frame-child54"></div>
            <img class="frame-child55" alt="" src="./public/ellipse-4@2x.png" />

            <a class="a12">1</a>
            <img class="frame-child56" alt="" src="./public/ellipse-6@2x.png" />

            <img class="frame-child57" alt="" src="./public/ellipse-71@2x.png" />

            <img class="frame-child58" alt="" src="./public/ellipse-6@2x.png" />

            <a class="a13">2</a>
            <a class="a14">3</a>
            <a class="a15">4</a>
          </div>

          <form id='frm'>
            <div class="frame-child59" style="height:100vh;max-height:90%;margin-top:-20px;">
              <div class="avatar-upload" style="margin-top: 480px; margin-left: 70px;">
                <div class="avatar-edit">
                  <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="file1" />
                  <label for="imageUpload" style="margin-top:7px"></label>
                </div>
                <div class="avatar-preview">
                  <div id="imagePreview" style="background-image: url(./public/screenshot-20231027-141446-1@2x.png);">
                  </div>
                </div>
              </div>
            </div>
            <label class="employee-name">Employee Name <span style="color: red;"> *</span></label>
            <label class="phone-number">Phone Number <span style="color: red;"> *</span></label>
            <label class="marital-status">Marital Status <span style="color: red;"> *</span></label>
            <label class="date-of-birth" style="width:10%;">Date of Birth <span style="color: red;"> *</span></label>
            <label class="email-id">Email ID <span style="color: red;"> *</span></label>
            <label class="gender">Gender <span style="color: red;"> *</span></label>
            <!-- <h3 class="personal-details">Personal Details</h3> -->

            <h3 class="personal-details" style="width:70%;height:100%;top:90px; ">          
<div class=" personal-details-container">
  <div class="personal-details-header">
    <svg class="personal-details-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
    </svg>
    <h2 class="personal-details-title">Personal Details</h2>
  </div>
  <p class="personal-details-info">
    In this step, you'll be filling out the employee's personal information. This includes basic details such as name, date of birth, contact information, and other relevant personal data. Please ensure all information is accurate and up-to-date.
  </p>
</div>
</h3>
            <!-- <img class="frame-child60" alt="" src="./public/line-121@2x.png" /> -->

            <input name="name" id='name' class="frame-child61" type="text" oninput="convertToUpperCase(this)" />

            <input name="mobile" id='mobile' class="frame-child62" type="tel" maxlength="10" />

            <select name="ms" class="frame-child63">
              <option value="">--select--</option>
              <option value="Married">Married</option>
              <option value="Single">Single</option>
            </select>
            <!-- <input name="emptype" value="Permanent" type="hidden" /> -->
            <input name="dob" class="frame-child64" type="date" max="2005-12-31" />

            <input name="email" id='email' class="frame-child65" type="text" />

            <select name="gen" class="frame-child66">
              <option value="">--select--</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">

            <span onclick="showSection(2)" class="frame-child67"></span>
            <a onclick="showSection(2)" class="next2" style="color:white; cursor:pointer;">Next</a>

        </div>
      </div>
    </div>
    <div class="section" id="section2">
      <div class="rectangle-top">
        <div class="frame-child25" style="margin-top: 80px;"></div>
        <div class="rectangle-container" style="margin-top: 75px; margin-left: 50px;">
          <div class="frame-child26" style="height:120vh; max-height:100%;"></div>
          <label class="employee-id">  Employee ID<span style="color: red;"> *</span></label>
          <label class="reporting-manager">Reporting Manager<span style="color: red;"> *</span></label>
          <label class="designation">Designation<span style="color: red;"> *</span></label>
          <label class="employment-type">Employment Type<span style="color: red;"> *</span></label>
          <label id="employment-type" class="employment-type" style="margin-top:115px;width: 450px;">Name of the Service Provider </label>
          <label class="date-of-joining">Date of Joining<span style="color: red;"> *</span></label>
          <label class="employment-status">Department<span style="color: red;"> *</span></label>
          <label class="department" style="width: 250px;">Work Location<span style="color: red;"> *</span></label>
          <label class="salary-fixed" style="width:370px;"> Gross Salary(per month)<span style="color: red;"> *</span></label>
          <label id="salary-fixed" class="salary-fixed" style="margin-top:115px;width: 450px;">Is Owner of Service</label>
          <!-- <label class="salary-deductions">Deduction (ESI)</label>
          <label class="salary-base-pay">Deduction (EPF)</label> -->
          <!-- <h3 class="employment-details">Employment Details</h3> -->

          <h3 class="employment-details" style="width: 1150px; height: 100%; margin-top: -20px; margin-left: 0px;">          
<div class=" personal-details-container">
  <div class="personal-details-header">
    <svg class="personal-details-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
    </svg>
    <h2 class="personal-details-title">Employement Details</h2>
  </div>
  <p class="personal-details-info">
  In this step, you'll be filling out the employee's employment details. This includes important information such as job title, department, joining date, salary, and other work-related specifics. Please ensure all information is accurate and up-to-date as it will be used for official records and payroll purposes.
</p>
</div>
</h3>
          <!-- <img class="frame-child27" alt="" src="./public/line-121@2x.png" /> -->

          <input name="empid" id="empid" class="frame-child28" type="text" />

          <!-- <select name="rm" class="frame-child29">
            <option value="">--select--</option>
            <option value="Prabhdeep Singh Maan">Prabhdeep Singh Maan</option>
          </select> -->


          <div class="custom-select-input">
  <input list="rmOptions" id="rmInput" name="rm" class="frame-child29" style="padding-left:10px!important;">
  <datalist id="rmOptions">
    <option value="Prabhdeep Singh Maan">
  </datalist>
</div>

          <!-- <input name="desg" class="frame-child30" type="text" oninput="convertToUpperCase(this)"/> -->
          <select name="desg" class="frame-child30" onchange="convertToUpperCase(this)">
            <?php

            $sql = "SELECT desg FROM dept";
            $result = $con->query($sql);

            echo '<option>--select--</option>';
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['desg'] . '">' . $row['desg'] . '</option>';
              }
            } else {
              echo '<option value="">No data available</option>';
            }
            ?>
          </select>

          <select name="work_location" class="frame-child35">
            <?php

            $sql = "SELECT city FROM workLocation";
            $result = $con->query($sql);

            echo '<option>--select--</option>';
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['city'] . '">' . $row['city'] . '</option>';
              }
            } else {
              echo '<option value="">No data available</option>';
            }
            ?>
          </select>



          <input name="doj" class="frame-child33" type="date" id="dojInput" />

          <!--<input name="dept" class="frame-child34" type="text" oninput="convertToUpperCase(this)" />-->
          
          <select  class="frame-child34" id="asdf"  name="dept"  />
          
           <?php

$sql1 = "SELECT DISTINCT dept FROM emp WHERE dept IS NOT NULL AND dept <> ''";
$result = $con->query($sql1);

echo'<option>--select--</option>';
if ($result->num_rows > 0) {
    while($row1 = $result->fetch_assoc()) {
        echo '<option style="font-size:20px;" value="' . $row1['dept'] . '">' . $row1['dept'] . '</option>';
    }
} else {
    echo '<option value="">No data available</option>';
}
?>
</select>
    

          <input name="salary" class="frame-child36" type="text" />
          

          <!-- <input name="emptype" class="frame-child31" type="text" /> -->

          <?php
          $query = "SELECT DISTINCT service_provider FROM emp WHERE service_provider IS NOT NULL";
          $result = $con->query($query);
          
          $options = [];
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $options[] = $row['service_provider'];
              }
          }
          ?>
          <input class="frame-child31" type="text" name="emptype" id="empnameInput" list="empdatalist" onchange="getEmployeeDetails(this.value)" oninput="checkInput(this)" autocomplete="off" />
<datalist id="empdatalist">
    <option value="Full-Time">Full-Time</option>
    <option value="Part-Time">Part-Time</option>
    <option value="Consultant">Consultant</option>
    <option value="Service Provider">Service Provider</option>
    <option value="Intern">Intern</option>

    <?php foreach ($options as $option): ?>
            <option value="<?php echo htmlspecialchars($option); ?>"><?php echo htmlspecialchars($option); ?></option>
        <?php endforeach; ?>
</datalist>


          <input id="service_provider" name="service_provider" class="frame-child31" type="text" style="margin-top:115px;"/>

          
    <div id="sp_owner" class="checkboxes__item frame-child36" style="margin-top:125px;border:none !important;">
      <label class="checkbox style-e">
        <input name="sp_owner" id="sp_owner_checkbox" type="checkbox"/>
        <div class="checkbox__checkmark"></div>
        <div class="checkbox__body">Yes</div>
      </label>
    </div>
          <span class="frame-child38" onclick="showSection(3)"></span>
          <a class="next1" onclick="showSection(3)" style="color:white; cursor:pointer;">Next</a>
          <span class="frame-child39" onclick="showSection(1)"></span>
          <a class="prev2" onclick="showSection(1)" style="color:white; cursor:pointer;">Prev</a>

        </div>
        <div class="frame-div" style="margin-top: 80px;">
          <div class="frame-child40"></div>
          <div class="frame-child41"></div>
          <div class="frame-child42"></div>
          <img class="frame-child43" alt="" src="./public/ellipse-4@2x.png" />

          <a class="a8">1</a>
          <img class="frame-child44" alt="" src="./public/ellipse-5@2x.png" />

          <img class="frame-child45" alt="" src="./public/ellipse-71@2x.png" />

          <img class="frame-child46" alt="" src="./public/ellipse-6@2x.png" />

          <a class="a9">2</a>
          <a class="a10">3</a>
          <a class="a11">4</a>
        </div>
      </div>
    </div>
    <div class="section" id="section3">
      <div class="rectangle-root">
        <div class="frame-child9" style="margin-top: 80px;"></div>
        <a class="typcnplus1"> </a>

        <div class="frame-child10" style="margin-top: 80px;"></div>
        <div class="frame-child11" style="margin-top: 80px;"></div>
        <div class="frame-child12" style="margin-top: 80px;"></div>
        <img class="frame-child13" style="margin-top: 80px;" alt="" src="./public/ellipse-4@2x.png" />

        <a class="a4" style="margin-top: 80px;">1</a>
        <img class="frame-child14" style="margin-top: 80px;" alt="" src="./public/ellipse-5@2x.png" />

        <img class="frame-child15" style="margin-top: 80px;" alt="" src="./public/ellipse-7@2x.png" />

        <img class="frame-child16" style="margin-top: 80px;" alt="" src="./public/ellipse-6@2x.png" />

        <a class="a5" style="margin-top: 80px;">2</a>
        <a class="a6" style="margin-top: 80px;">3</a>
        <a class="a7" style="margin-top: 80px;">4</a>

        <div class="frame-child17" style="margin-top: 60px; margin-left: 80px;"></div>

        <label class="pan" style="margin-top: 80px; margin-left: 80px;">PAN <span style="color: red;"> *</span></label>
        <label class="bank-account-number" style="margin-top: 80px; margin-left: 80px;width:30%;">Bank Account Number <span style="color: red;"> *</span></label>
        <label class="bank-name" style="margin-top: 80px; margin-left: 80px;">Bank Name <span style="color: red;"> *</span></label>
        <label class="aadhaar-number" style="margin-top: 80px; margin-left: 80px;width:30%;">Aadhaar Number <span style="color: red;"> *</span></label>
        <label class="ifsc-code" style="margin-top: 80px; margin-left: 80px;">IFSC Code <span style="color: red;"> *</span></label>
        <!-- <h3 class="identity-details" style="margin-top: 80px; margin-left: 80px;">Identity Details</h3> -->

        <div class="identity-details" style="width: 1150px; height: 100%; margin-top: 40px; margin-left: 80px;">          
  <div class="personal-details-container">
    <div class="personal-details-header">
      <svg class="personal-details-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
    </svg>
      <h2 class="personal-details-title">Identity Details</h2>
    </div>
    <p class="personal-details-info">
    In this step, you'll be filling out the employee's identity details. This includes important information such as PAN, Aadhaar, and bank details. Ensure all information is accurate and up-to-date as it will be used for official records and payroll purposes.
    </p>
  </div>
</div>


        <!-- <img class="line-icon" style="margin-top: 80px; margin-left: 80px;" alt="" src="./public/line-12@2x.png" /> -->

        <input name="pan" class="frame-child18" style="margin-top: 80px; margin-left: 80px;" type="text" maxlength="15" placeholder="ABCD-1234-E" oninput="formatPAN(this)" />

        <input name="ban" class="frame-child19" style="margin-top: 80px; margin-left: 80px;" type="text" />
        <select name="bn" class="frame-child20" style="margin-top: 80px; margin-left: 80px;">
  <option value="">--Select a Bank--</option>
  <option value="State Bank Of India">State Bank Of India</option>
  <option value="Punjab National Bank">Punjab National Bank</option>
  <option value="Indian Bank">Indian Bank</option>
  <option value="Bank Of India">Bank Of India</option>
  <option value="UCO Bank">UCO Bank</option>
  <option value="Union Bank Of India">Union Bank Of India</option>
  <option value="Central Bank Of India">Central Bank Of India</option>
  <option value="Bank Of Baroda">Bank Of Baroda</option>
  <option value="Bank Of Maharashtra">Bank Of Maharashtra</option>
  <option value="Canara Bank">Canara Bank</option>
  <option value="Indian Overseas Bank">Indian Overseas Bank</option>
  <option value="ICICI Bank">ICICI Bank</option>
  <option value="HDFC Bank">HDFC Bank</option>
  <option value="Axis Bank">Axis Bank</option>
  <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
  <option value="Federal Bank">Federal Bank</option>
  <option value="Karur Vysya Bank">Karur Vysya Bank</option>

        </select>
        <input name="adn" class="frame-child21" style="margin-top: 80px; margin-left: 80px;" type="text" oninput="formatAdn(this)" maxlength="14" />

        <input name="ifsc" class="frame-child22" style="margin-top: 80px; margin-left: 80px;" type="text" oninput="convertToUpperCase(this)" />

        <span class="frame-child23" style="margin-top: 80px; margin-left: 80px;" onclick="showSection(4)"></span>
        <span class="frame-child24" style="margin-top: 80px; margin-left: 80px;" onclick="showSection(2)"></span>
        <a class="next" style="margin-top: 80px; margin-left: 80px; color:white; cursor:pointer;" onclick="showSection(4)">Next</a>
        <a class="prev1" style="margin-top: 80px; margin-left: 80px; color:white; cursor:pointer;" onclick="showSection(2)">Prev</a>

      </div>
    </div>
    <div class="section" id="section4">

      <div class="rectangle-parent">
        <div class="frame-child" style="margin-top:80px;"></div>
        <a class="typcnplus"> </a>
        <img class="mdifolder-upload-icon" alt="" style="margin-top:80px;" src="./public/mdifolderupload.svg" />

        <div class="frame-item" style="margin-top:80px; margin-left: 80px;">
        </div>
        <h3 class="documents-upload" style="margin-top:80px; margin-left: 80px;">Documents Upload</h3>
        <p class="note-upload" style="margin-top:50px; margin-left: 80px;width:40%;"><b>Note</b>: If all required documents are not available at the time of enrollment, HR can add them later. In this step, file uploads are not mandatory.
        </p>
   
        <div class="container-full">
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Aadhaar Card</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID1" name="adr_file">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID1').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName1"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>PAN</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID2" name="pan_file">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID2').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName2"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Bank details (Passbook Frontpage)</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID3" name="ban_file">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID3').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName3"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Educational Certificates (10th, 12th, UG/PG Certificate as applicable)</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID4" name="edu_file">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID4').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName4"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Police Verification Certificate</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID5" name="pvc">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID5').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName5"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Updated Resume</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID6" name="resume">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID6').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName6"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Experience Certificate (if applicable)</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID7" name="exp_file">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID7').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName7"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="drop_box">
                    <header>
                        <h4>Passport (if available)</h4>
                    </header>
                    <p>Files Supported: PDF, PNG, JPG, JPEG</p>
                    <input type="file" hidden accept=".jpeg, .jpg, .png .pdf" id="fileID8" name="passport">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" onclick="document.getElementById('fileID8').click();">
                            <h6 class="font">Choose File</h6>
                        </button>
                    </div>
                    <div class="file-name" id="fileName8"></div>
                </div>
            </div>
        </div>
    </div>

        <input type="hidden" name="empstatus" value="0">
        <input type="hidden" name="purpose" id="purpose" value="for confirmation of employement details and creation of emp login." />
        <!-- <input class="browse-file" style="margin-top:80px;  display: none;" id="pdfFile" type="file" name="file"
          value="cv" accept=".pdf"> -->
        <span class="rectangle-button " style="margin-top:80px; margin-left: 80px;" data-toggle="modal" data-target="#demoModal"></span>

        <span class="frame-child2 " onclick="showSection(3)" style="margin-top:80px; margin-left: 80px;"></span>
        <a class="save submitBtn" style="margin-top:80px; margin-left: 80px; color: white; cursor:pointer;" data-toggle="modal" data-target="#demoModal">Add</a>
        <!-- <div class="modal" id="demoModal" style="  margin-top: 300px;">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" style="color: #636363;">Employee Details </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body" style="color: #636363;">
                Are you sure saving the details..
              </div>

              <div class="modal-footer">

                <span type="button" class="btn btn-danger" data-dismiss="modal">Close</span>
                <button type="submit" class="btn btn-success submitBtn">Save</button>
              </div>

            </div>
          </div>
        </div> -->


        <div class="modal elegant-modal" id="demoModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm Submission</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>You're about to submit the employee information to our HRMS.</p>
        <p>We've ensured data integrity, but a final review is always wise.</p>
        <p>Are you ready to proceed with this submission?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Review Again</button>
        <button type="submit" class="btn btn-primary submitBtn" id="submitBtn">Confirm & Submit</button>
      </div>
    </div>
  </div>
</div>
        </form>

        <button class="frame-child2" onclick="showSection(3)" style="margin-top:80px; margin-left: 80px;"></button>


        <a class="prev" style="margin-top:80px; margin-left: 80px; color:white; cursor:pointer;" onclick="showSection(3)">Prev</a>
        <div class="material-symbolsinfo-outline" style="margin-top:80px; margin-left: 80px;"></div>
        <div class="rectangle-group" style="margin-top:80px;">
          <div class="frame-child3"></div>
          <div class="frame-child4"></div>
          <div class="frame-child5"></div>
          <img class="ellipse-icon" alt="" src="./public/ellipse-4@2x.png" />

          <a class="a">1</a>
          <img class="frame-child6" alt="" src="./public/ellipse-5@2x.png" />

          <img class="frame-child7" alt="" src="./public/ellipse-7@2x.png" />

          <img class="frame-child8" alt="" src="./public/ellipse-5@2x.png" />

          <a class="a1">2</a>
          <a class="a2">3</a>
          <a class="a3">4</a>
        </div>
      </div>
    </div>
  </div>

  <script>
document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('rmInput');
  const datalist = document.getElementById('rmOptions');

  input.addEventListener('input', function() {
    const value = this.value;
    let optionFound = false;

    for (let i = 0; i < datalist.options.length; i++) {
      if (value === datalist.options[i].value) {
        optionFound = true;
        break;
      }
    }

    if (!optionFound && value !== '') {
      console.log('Custom value entered:', value);
    }
  });
});
</script>

  <script>
function getEmployeeDetails(value) {
    console.log("Selected employee type:", value);
    if (value === "Service Provider") {
        document.getElementById("service_provider").style.display = "block";
        document.getElementById("sp_owner").style.display = "block";
        document.getElementById("salary-fixed").style.display = "block";
        document.getElementById("employment-type").style.display = "block";
    } else {
        document.getElementById("service_provider").style.display = "none";
        document.getElementById("sp_owner").style.display = "none";
        document.getElementById("salary-fixed").style.display = "none";
        document.getElementById("employment-type").style.display = "none";
    }
}

function checkInput(input) {
    // Function to handle input events
    console.log("Current input:", input.value);
}
</script>

</script>

  <script>
        function handleFileSelect(event, fileNameId) {
            const fileName = event.target.files[0] ? event.target.files[0].name : "No file selected";
            document.getElementById(fileNameId).textContent = `Selected file: ${fileName}`;
        }

        document.getElementById('fileID1').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName1');
        });
        document.getElementById('fileID2').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName2');
        });
        document.getElementById('fileID3').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName3');
        });
        document.getElementById('fileID4').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName4');
        });
        document.getElementById('fileID5').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName5');
        });
        document.getElementById('fileID6').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName6');
        });
        document.getElementById('fileID7').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName7');
        });
        document.getElementById('fileID8').addEventListener('change', function(event) {
            handleFileSelect(event, 'fileName8');
        });
    </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
  <script>
    function formatAdn(input) {
      // Remove non-numeric characters from the input value
      var numericValue = input.value.replace(/\D/g, '');

      // Ensure the value is not longer than 12 digits
      numericValue = numericValue.substring(0, 12);

      // Format the value as "1234-5678-9101"
      var formattedValue = numericValue.replace(/(\d{4})(\d{4})(\d{4})/, '$1-$2-$3');

      // Update the input value
      input.value = formattedValue;
    }
  </script>
  <script>
    function convertToUpperCase(inputElement) {
      inputElement.value = inputElement.value.toUpperCase();
    }
  </script>
  <script>
    function formatPAN(input) {
      // Remove any non-alphanumeric characters
      let formattedValue = input.value.replace(/[^a-zA-Z0-9]/g, '');

      // Apply the PAN format (AAAAA-1111-A)
      if (formattedValue.length > 5) {
        formattedValue = formattedValue.substring(0, 5) + '-' +
          formattedValue.substring(5, 9) + '-' +
          formattedValue.substring(9, 10);
      }

      // Update the input value
      input.value = formattedValue.toUpperCase();
    }
  </script>
  <script>
    // Get the current date
    const currentDate = new Date();

    // Calculate the last day of the next month
    const nextMonth = new Date(currentDate);
    nextMonth.setMonth(currentDate.getMonth() + 2);
    nextMonth.setDate(0); // Set to the last day of the current month

    // Format the date as "YYYY-MM-DD" for the max attribute
    const maxDate = nextMonth.toISOString().split('T')[0];

    // Set the max attribute of the input element
    document.getElementById('dojInput').setAttribute('max', maxDate);
  </script>
  <script>
    $('#demoModal').modal('show');
  </script>
  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
          $('#imagePreview').hide();
          $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function() {
      readURL(this);
    });


    var employeeManagement = document.getElementById("employeeManagement");
    if (employeeManagement) {
      employeeManagement.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var dashboard = document.getElementById("dashboard");
    if (dashboard) {
      dashboard.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }
  </script>
</body>
<script>
  let currentSection = 1;

  function showSection(section) {
    document.getElementById('section' + currentSection).classList.remove('active');
    document.getElementById('section' + section).classList.add('active');
    currentSection = section;
  }
  document.getElementById('pdfFile').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const pdfPreview = document.getElementById('pdfPreview');

    // Clear previous preview
    pdfPreview.innerHTML = '';

    if (file) {
      const fileReader = new FileReader();

      fileReader.onload = function() {
        const typedarray = new Uint8Array(this.result);
        displayPDF(typedarray);
      };

      fileReader.readAsArrayBuffer(file);
    }
  });

  function displayPDF(pdfData) {
    const loadingTask = pdfjsLib.getDocument({
      data: pdfData
    });

    loadingTask.promise.then(function(pdf) {
      const scale = 1;
      const canvas = document.createElement('canvas');
      const pdfPreview = document.getElementById('pdfPreview');

      for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
        pdf.getPage(pageNum).then(function(page) {
          const viewport = page.getViewport({
            scale
          });
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          const renderContext = {
            canvasContext: canvas.getContext('2d'),
            viewport: viewport
          };

          page.render(renderContext).promise.then(function() {
            pdfPreview.appendChild(canvas);
          });
        });
      }
    }).catch(function(error) {
      console.error('Error occurred while rendering the PDF:', error);
    });
  }
</script>
<script>
  $(document).ready(function() {
    $('#frm').submit(function(event) {
      event.preventDefault();
      var recipientEmail = $('#email').val();
      var purpose = $('#purpose').val();
      $.ajax({
        type: 'POST',
        url: 'mail.php',
        data: {
          recipientEmail: recipientEmail,
          purpose: purpose
        },
        success: function(response) {
          $('#response').html(response);
        }
      });
    });
  });
</script>


</html>
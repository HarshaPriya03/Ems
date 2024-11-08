<!DOCTYPE html>
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

<?php
include('inc/config.php');
$ID = $_GET['id'];
$query = mysqli_query($con, "select * from `emp` where id='$ID'");
$row = mysqli_fetch_array($query);
?>

<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global4.css" />
  <link rel="stylesheet" href="./css/employee-approval.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <style>
    .addin {
      border: 1px solid #FA840D;
      border-radius: 7px
    }

    .remove {
      display: none;
    }

    .instyle {
      border: 2px solid rgb(177, 177, 177);
      border-radius: 20px;
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

    .dropbtn {
      background-color: rgb(248, 172, 109);
      color: #ffffff;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgb(255, 133, 34);
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 98;
      max-height: 0;
      min-width: 160px;
      transition: max-height 0.15s ease-out;
      overflow: hidden;
    }

    .dropdown-content a {
      color: black;
      background-color: #f9f9f9;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #e2e2e2;
    }

    .dropdown:hover .dropdown-content {
      max-height: 500px;
      min-width: 160px;
      transition: max-height 0.25s ease-in;
    }

    .dropdown:hover .dropbtn {
      /* background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0; */
      transition: max-height 0.25s ease-in;
    }

    .led-green {
      /* margin: 0 auto; */
      width: 20px;
      height: 20px;
      background-color: #ABFF00;
      border-radius: 50%;
      box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #304701 0 -1px 9px, #89FF00 0 2px 12px;
    }

    .led-red {
      /* margin: 0 auto; */
      width: 20px;
      height: 20px;
      background-color: #F00;
      border-radius: 50%;
      box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 12px;
    }

    .led-yellow {
      /* margin: 0 auto; */
      width: 20px;
      height: 20px;
      background-color: #FF0;
      border-radius: 50%;
      box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #808002 0 -1px 9px, #FF0 0 2px 12px;
    }

    .dialog {
      padding: 20px;
      border: 0;
      background: transparent;
    }

    .dialog::backdrop {
      background-color: rgba(0, 0, 0, .3);
      backdrop-filter: blur(4px);
    }

    .dialog__wrapper {
      padding: 20px;
      background: #fff;
      width: 1000px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
    }

    .dialog__close {
      border: 0;
      padding: 0;
      width: 24px;
      aspect-ratio: 1;
      display: grid;
      place-items: center;
      background: #000;
      color: #fff;
      border-radius: 50%;
      font-size: 12px;
      line-height: 20px;
      position: absolute;
      top: 5px;
      right: 5px;
      cursor: pointer;
      --webkit-appearance: none;
      appearance: none;
    }

    .send-email {
      position: absolute;
      top: 101px;
      left: 388px;
      display: inline-block;
      width: 236px;
      height: 39px;
    }

    .email-id1,
    .frame-child {
      position: absolute;
      left: 126px;
    }

    .email-id1 {
      cursor: pointer;
      top: 190px;
      font-size: 20px;
      font-weight: 300;
      color: #313131;
      display: inline-block;
      width: 165px;
      height: 22px;
    }

    .frame-child {
      border: 1px solid #7f7f7f;
      background-color: var(--color-white);
      top: 221px;
      border-radius: 10px;
      box-sizing: border-box;
      width: 727px;
      height: 50px;
    }

    .frame-item {
      cursor: pointer;
      border: 0;
      padding: 0;
      background-color: #2f82ff;
      position: absolute;
      top: 337px;
      left: 683px;
      border-radius: 50px;
      box-shadow: 5px 7px 4px rgba(47, 130, 255, 0.41);
      width: 170px;
      height: 43px;
    }

    .send-mail {
      text-decoration: none;
      position: absolute;
      top: 344px;
      left: 711px;
      font-size: 25px;
      line-height: 117.5%;
      color: var(--color-white);
      display: inline-block;
      width: 130px;
      height: 27px;
    }

    .send-email-parent {
      position: relative;
      border-radius: 20px;
      background-color: var(--color-white);
      width: 100%;
      height: 479px;
      overflow: hidden;
      text-align: left;
      font-size: 40px;
      color: #000;
      font-family: var(--font-rubik);
    }

    .frame-child1 {
      border: 1px solid #7f7f7f;
      background-color: var(--color-white);
      margin-left: 125px;
      margin-top: 320px;
      border-radius: 10px;
      box-sizing: border-box;
      width: 727px;
      height: 100px;
    }

    input {
      background-color: transparent;
    }

    .view-file1 {
      text-decoration: none;
      position: absolute;
      top: 807px;
      left: 1265px;
      font-weight: 300;
      display: inline-block;
      width: 143px;
      height: 24px;
    }

    .employeeapproval-child71 {
      cursor: pointer;
      border: 0;
      padding: 0;
      position: absolute;
      top: 800px;
      left: 1233px;
      width: 162px;
      height: 44px;
    }
  </style>
  <script>
    $(document).ready(function() {
      $("#frm").submit(function(event) {
        event.preventDefault();
        showLoadingSpinner();
        sendMail();
      });

      function showLoadingSpinner() {
        $("#loading-bar-spinner").show();
      }

      function hideLoadingSpinner() {
        $("#loading-bar-spinner").hide();
      }

      function sendMail() {
        Swal.fire({
          title: 'Updating Status....',
          allowOutsideClick: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          },
        });

        $.ajax({
          url: 'status.php?id=<?php echo $ID; ?>',
          type: "POST",
          data: $("#frm").serialize(),
          success: function(response) {
            hideLoadingSpinner();

            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Status updated successfully!',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'employee-overview.php?id=<?php echo $ID; ?>';
              }
            });
          },
          error: function() {
            hideLoadingSpinner();

            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error occurred',
              confirmButtonText: 'OK'
            });
          }
        });
      }
    });
  </script>
</head>

<body>
  <div class="employeeapproval">
    <section class="bg1"></section>

    <section class="employeeapproval-item"></section>
    <img class="employeeapproval-inner" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm1" href="./index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm1">HRM</span>
    </a>
    <a class="onboarding1" href="./index.php" id="onboarding">
      Employee Management
      <span style="opacity:0.8; font-size:25px;">
        /Employee Overview/<span id="nameDisplay">
          <?php
          $empname = $row['empname'];
          echo strlen($empname) > 15 ? substr($empname, 0, 15) . '...' : $empname;
          ?>
        </span>
      </span>
    </a>
    <a class="onboarding1 remove" href="./index.php" style="margin-left: 950px; margin-top: 12px; opacity: 0.8; font-size: 26px;" id="onboarding123">/Edit Info</a>


    <?php
    include('inc/config.php');
    $ID = $_GET['id'];
    $query = mysqli_query($con, "select * from `emp` where id='$ID'");
    $row = mysqli_fetch_array($query);

    if ($row) {
      $empstatus = $row['empstatus'];


      if ($empstatus == '0') {
        echo '<a class="onboarding1" href="#modal-option-1" style="margin-left:1105px;  font-size: 20px; margin-top: 9px; " id="onboarding">
        <div style="display: flex; gap: 5px;">
            <span>Status: </span>
            <div style="display: flex; gap: 5px; background-color: rgb(248, 172, 109); width: 100px; align-items: center; justify-content: center; height: 50px; margin-top: -13px; border-radius: 25px;">
                <div style="margin-top: 3px;" class="led-green"></div> <span>Active</span>
            </div>
        </div>
    </a>';
      } elseif ($empstatus == '1') {
        echo '<a class="onboarding1" href="#modal-option-1" style="margin-left:1065px;  font-size: 20px; margin-top: 9px; " id="onboarding">
        <div style="display: flex; gap: 5px;">
            <span>Status: </span>
            <div style="display: flex; gap: 1px; background-color: rgb(248, 172, 109); width: 140px; align-items: center; justify-content: center; height: 50px; margin-top: -13px; border-radius: 25px;">
                <div style="margin-top: 3px;" class="led-red"></div> <span>Terminated</span>
            </div>
        </div>
    </a>';
      } elseif ($empstatus == '2') {
        echo '<a class="onboarding1" href="#modal-option-1" style="margin-left:1085px;  font-size: 20px; margin-top: 9px; " id="onboarding">
      <div style="display: flex; gap: 5px;">
          <span>Status: </span>
          <div style="display: flex; gap: 2px; background-color: rgb(248, 172, 109); width: 120px; align-items: center; justify-content: center; height: 50px; margin-top: -13px; border-radius: 25px;">
              <div style="margin-top: 3px;" class="led-yellow"></div> <span style="font-size:18px;">Resigned</span>
          </div>
      </div>
  </a>';
      }
    } else {
      echo "Error: " . mysqli_error($connection);
    }
    ?>

    <dialog class="dialog" id="modal-option-1">
      <div class="dialog__wrapper">
        <button class="dialog__close">✕</button>
        <div class="send-email-parent">
          <div class="send-email" style="width: 500px; margin-left: -90px;margin-top: -80px;">Employee Status</div>
          <label class="email-id1" style="margin-top: -80px;">Status</label>
          <form id="frm">
            <select name="empstatus" style="margin-top: -80px;" class="frame-child" id="">
              <option value="0" <?php echo ($row['empstatus'] == '0') ? 'selected' : ''; ?>>Active</option>
              <option value="1" <?php echo ($row['empstatus'] == '1') ? 'selected' : ''; ?>>Terminated</option>
              <option value="2" <?php echo ($row['empstatus'] == '2') ? 'selected' : ''; ?>>Resigned</option>
            </select>

            <input type="hidden" name="email" value="<?php echo $row['empemail']; ?>">
            <label class="email-id1" style="margin-top: 20px;">Reason</label>
            <textarea style="margin-top: 240px;" name="reason" class="frame-child1" id="" cols="30" rows="10"></textarea>

            <button type="submit" onclick="submitBtn();" class="frame-item dialog__close1" style="color: white; font-size: 20px; margin-top: 50px;">Submit</button>
          </form>
        </div>
      </div>
    </dialog>

    <?php
    include('inc/config.php');
    $ID = $_GET['id'];
    $query = mysqli_query($con, "select empstatus from `emp` where id='$ID'");
    $result = mysqli_fetch_array($query);

    if ($result) {
      $empstatus = $result['empstatus'];

      if ($empstatus == 0) {
    ?>
        <div class="dropdown" style="z-index: 100; margin-left: 105pc; margin-top: 12px;">
          <button style="border-radius: 50px; font-size: 21px;" class="dropbtn" for="btnControl">Requests</button>
          <div class="dropdown-content">
            <a id="changePasswordLink" href="#" style="font-size: 18px; border-radius:10px; white-space: nowrap;">Change Password</a>
          </div>
        </div>
    <?php
      } else {
      }
    } else {
      echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
    ?>
    <button class="employeeapproval-child1"></button>
    <div class="logout1">Logout</div>
    <a class="attendance1" href="./attendence.php" id="attendance">Attendance</a>
    <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll1">Payroll</a>
    <div class="reports1">Reports</div>
    <img class="uitcalender-icon1" alt="" src="./public/uitcalender.svg" />

    <img class="arcticonsgoogle-pay1" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon1" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


    <img style="margin-top: -135px;" class="employeeapproval-child3" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard1" href="./index.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular1" id="fluentpeople32Regular">
      <img class="vector-icon7" alt="" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" src="./public/vector7.svg" />
    </a>
    <a class="employee-list1" href="./employee-management.php" style="color: white;" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard1" href="./index.php" id="akarIconsdashboard">
      <img class="vector-icon8" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon1" alt="" src="./public/tablerlogout.svg" />

    <a class="uitcalender1" id="uitcalender">
      <img class="vector-icon9" alt="" src="./public/vector4.svg" />
    </a>
    <a class="leaves1" href="./leave-management.php" id="leaves">Leaves</a>
    <a class="fluentperson-clock-20-regular1" id="fluentpersonClock20Regular">
      <img class="vector-icon10" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding2" href="./onboarding.php" style="color: black;" id="onboarding1">Onboarding</a>
    <a class="fluent-mdl2leave-user1" id="fluentMdl2leaveUser">
      <img class="vector-icon11" alt="" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" src="./public/vector8.svg" />
    </a>
    <div>
      <img style="margin-top:-20px;" class="employeeapproval-child" alt="" src="./public/rectangle-22@2x.png" />

      <form id="employeeForm">

        <input style="margin-top:-45px;  font-size:20px;" name="ms" value="<?php echo $row['empms']; ?>" class="single" value="Single" type="text" defaultvalue="Single" readonly="readonly" id="tgb" />

        <input style="margin-top:-45px;  font-size:20px; width:310px;" class="naradamohan1gmailcom1" type="text" name="email" value="<?php echo $row['empemail']; ?>" readonly="readonly" id="rfv" />

        <input type="hidden" name="purpose" id="rfvv" value="for changing the login password." />

        <input style="margin-top:-45px;  font-size:20px;" class="input" name="mobile" value="<?php echo $row['empph']; ?>" type="text" readonly="readonly" id="edc" />

        <input style="margin-top:-45px;  font-size:20px;" id="wsx" class="input1" name="empdob" value="<?php echo date('Y-m-d', strtotime($row['empdob'])); ?>" type="date" readonly="readonly" />
        <!--<input style="margin-top:-20px; display:none;" class="input1" name="empdob" value="<?php echo $row['empdob']; ?>" type="date" readonly="readonly" />-->
        <p style="margin-top:-40px;" class="date-of-birth">Date of Birth:</p>
        <p style="margin-top:-40px;" class="phone-number">Phone Number:</p>
        <p style="margin-top:-40px;" class="email-id">Email id:</p>
        <p style="margin-top:-40px;" class="marital-status">Marital Status:</p>
        <p style="margin-top:-40px;" class="gender">Gender:</p>
        <!--Clothing Sizes-->
        <!--<p class="gender">Clothing Size:</p>-->
        <!--<img src="./public/shirt.png" width="30px" style="position:absolute; margin-left:850px; margin-top:307px;"/>-->
        <!--<input class="input1" type="text" style="margin-left:60px; border-radius:5px; margin-top:180px; width:30px; font-size:18px;" value="42" id="qazlp" readonly/>-->
        <!--<img src="./public/trouser.png" width="40px" style="position:absolute; margin-left:950px; margin-top:304px;"/>-->
        <!--<input class="input1" type="text" style="margin-left:160px; border-radius:5px; margin-top:180px; width:30px; font-size:18px;" value="42" id="wsxmko" readonly/>-->
        <input style="margin-top:-45px;  font-size:20px;" class="male" value="<?php echo $row['empgen']; ?>" name="gen" type="text" defaultvalue="Male" readonly="readonly" id="yhn" />

        <?php
        if ($row['empstatus'] == '1' || $row['empstatus'] == '2') {
        ?>
          <p style="margin-top:65px;" class="marital-status">Status:</p>
          <p style="margin-top:65px;" class="gender">Reason:</p>
          <input style="margin-top:65px; margin-left: -60px;" class="single" value="
        <?php
          if ($row['empstatus'] == '1') {
            echo 'Terminated';
          } elseif ($row['empstatus'] == '2') {
            echo 'Resigned';
          }
        ?>" <input type="text" defaultvalue="Single" readonly="readonly" id="tgb" />
          <input style="margin-top:65px;" class="male" value="<?php echo $row['reason']; ?>" type="text" defaultvalue="Male" readonly="readonly" id="yhn" />
          <p style="margin-top:35px; margin-left: -470px;" class="salary">Date of Exit: <?php echo date('Y-m-d', strtotime($row['exit_dt'])); ?></p>
        <?php
        }
        ?>




        <input style="margin-top:-68px;  font-size:20px; font-weight: 300; width: 250px;margin-left:-20px" id="empid" class="web-developer1" value="<?php echo $row['emp_no']; ?>" type="text" name="empid" defaultvalue="1902" readonly />

        <input style="margin-top:-65px;  font-size:20px; text-align: center; width: 250px;margin-left:-40px" id="qaz" class="mohan-reddy1" name="desg" type="text" value="<?php echo $row['desg']; ?>" defaultvalue="Mohan Reddy" readonly="readonly" />

        <input style="margin-top:-25px;  font-size:20px; font-weight: 300;  width: 35%; margin-left:-20px" id="designation" class="web-developer1" name="name" value="<?php echo htmlspecialchars($row['empname'] ?? ''); ?>" type="text" defaultvalue="Web Developer" readonly />

        <div class="avatar-upload" style="margin-top: 60px; margin-left: 456px;">
          <div class="avatar-edit remove" id="avatarEdit">
            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
            <label for="imageUpload"></label>
          </div>
          <div class="avatar-preview">

            <div id="imagePreview" style="background-image: url(pics/<?php echo rawurlencode($row['pic']); ?>);">
            </div>
          </div>
        </div>

        <h3 style="margin-top:-20px;" class="personal-info">Personal info</h3>
        <img style="margin-top:-20px;" class="employeeapproval-child4" alt="" src="./public/rectangle-53@2x.png" />

        <input style="margin-top:-50px; margin-left: -10px;  font-size:20px;" class="input2" id="asdf" name="dept" value="<?php echo $row['dept']; ?>" type="text" defaultvalue="IT" readonly />

        <img class="employeeapproval-child5" alt="" style="margin-left: 12px; margin-top: -34px;" src="./public/rectangle-54@2x.png" />

        <input style="margin-top:-25px; font-size:20px;" class="union-bank-of" name="bn" value="<?php echo $row['bn']; ?>" type="text" defaultvalue="Union Bank of India" readonly="readonly" id="qwertyuiop" />

        <input style="margin-top:-25px; font-size:20px;" class="ubin39723" name="ifsc" value="<?php echo $row['ifsc']; ?>" type="text" defaultvalue="UBIN39723" readonly="readonly" id="ol." />

        <input style="margin-top:-25px; font-size:20px;" class="input3" name="ban" value="<?php echo $row['ban']; ?>" type="text" defaultvalue="3947284762543254" readonly="readonly" id="ik," />

        <input style="margin-top:-25px; font-size:20px;" class="input4" name="adn" value="<?php echo $row['adn']; ?>" type="text" defaultvalue="39472947294" readonly="readonly" id="ujm" />

        <input style="margin-top:-25px; font-size:20px;" class="kdiry3947h" name="pan" value="<?php echo $row['pan']; ?>" type="text" defaultvalue="KDIRY3947H" readonly="readonly" id="yhnq" />

        <img style="margin-top:-20px;" class="employeeapproval-child6" alt="" src="./public/rectangle-54@2x.png" />

        <h3 style="margin-top:-20px;" class="document-view">Document Upload</h3>
        <p style="margin-top:-45px;" class="employee-id">Department:</p>
        <p style="margin-top:-20px;" class="pan">PAN:</p>
        <p style="margin-top:-45px;" class="date-of-joining">Date of Joining:</p>
        <input style="margin-top:-50px;  font-size:20px;" class="input5" id="sdfg" name="doj" value="<?php echo $row['empdoj']; ?>" type="text" defaultvalue="24/11/2022" readonly />

        <p style="margin-top:-20px;" class="aadhaar">Aadhaar:</p>
        <p style="margin-top:-45px;" class="reporting-manager">Reporting Manager:</p>
        <input style="margin-top:-50px;  font-size:20px;" class="prabhdeep-singh-maan" id="dfgh" name="rm" value="<?php echo $row['rm']; ?>" type="text" defaultvalue="Prabhdeep Singh Maan" readonly />

        <p style="margin-top:-20px;" class="account-number">Account Number:</p>
        <p style="margin-top:-45px;" class="employment-status">Employment Type:</p>
        <input style="margin-top:-50px;  font-size:20px; margin-left: -22px;" class="active" id="fghj" name="emptype" value="<?php echo $row['empty']; ?>" type="text" defaultvalue="Active" readonly />

        <p style="margin-top:-20px;" class="ifsc-code">IFSC Code:</p>
        <p style="margin-top:-45px;" class="department">Tentative Gross Salary:</p>
        <input style="margin-top:-50px;margin-left: 85px;  font-size:20px;width:5%;" class="it" id="ghjk" name="salary" value="<?php echo $row['salary']; ?>" type="text" defaultvalue="25000" readonly />

        <p style="margin-top:-20px;" class="bank-name">Bank Name:</p>
        <p style="margin-top:-45px;width:500px !important;" class="employment-type">Work Location:</p>
        <input style="margin-top:-50px; margin-left: -40px;  font-size:20px;" class="permanent" id="hjkl" name="work_location" value="<?php echo $row['work_location']; ?>" type="text" defaultvalue="23000" readonly />

        <p style="margin-top:-45px;" class="salary">Length of service:</p>
        <input style="width:15%;margin-top:-50px; margin-left: 55px;  font-size:20px;background:transparent;" class="input6" id="qwer" name="sald1" value="      <?php
                                                                                                                                                                  $startDate = new DateTime($row['empdoj']);
                                                                                                                                                                  $exitDate = new DateTime($row['exit_dt']);

                                                                                                                                                                  $interval = $startDate->diff($exitDate);

                                                                                                                                                                  $years = $interval->y;
                                                                                                                                                                  $months = $interval->m;
                                                                                                                                                                  $days = $interval->d;

                                                                                                                                                                  if ($years > 0) {
                                                                                                                                                                    echo "$years year";
                                                                                                                                                                  }

                                                                                                                                                                  if ($months > 0) {
                                                                                                                                                                    echo ($years > 0 ? ', ' : '') . "$months months";
                                                                                                                                                                  }

                                                                                                                                                                  if ($days > 0 || ($years == 0 && $months == 0)) {
                                                                                                                                                                    echo ($years > 0 || $months > 0 ? ', ' : '') . "$days days";
                                                                                                                                                                  }
                                                                                                                                                                  ?>" type="text" defaultvalue="1200" readonly />
<?php
if ($row['sp_owner'] == "Yes") {
    echo '
        <p style="margin-top:-8px;" class="salary">Service Provider:</p>
        <input style="width:15%;margin-top:-12px; margin-left: 75px;  font-size:20px;background:transparent;" class="input6" name="service_provider" value="' . htmlspecialchars($row["service_provider"]) . '" type="text" defaultvalue="1200" readonly />
    ';
} else {
    echo '';
}
?>

        
        <!-- <p style="margin-top:-8px;" class="salary">ESI:</p>
        <input style="margin-top:-13px; margin-left: -25px;  font-size:20px;" class="input6" id="wert" name="sald" value="<?php echo $row['sald']; ?>" type="text" defaultvalue="100" readonly /> -->

        <!-- <p style="margin-top:35px; margin-left: 0px;" class="salary">Length of service:</p>
        <b style="margin-top:30px; margin-left: 95px;font-weight:bold;font-size:20px; background-color:transparent;" class="input6" id="wert" name="sald" value="1yr" type="text" readonly >
                <?php
                $startDate = new DateTime($row['empdoj']);
                $exitDate = new DateTime($row['exit_dt']);

                $interval = $startDate->diff($exitDate);

                $years = $interval->y;
                $months = $interval->m;
                $days = $interval->d;

                if ($years > 0) {
                  echo "$years year";
                }

                if ($months > 0) {
                  echo ($years > 0 ? ', ' : '') . "$months months";
                }

                if ($days > 0 || ($years == 0 && $months == 0)) {
                  echo ($years > 0 || $months > 0 ? ', ' : '') . "$days days";
                }
                ?>
</b> -->
        <h3 style="margin-top:-40px;" class="employment-info">Employment Info</h3>
        <h3 style="margin-top:-20px;" class="identity-info">Identity Info</h3>
        <!-- <a style="margin-top:-25px; width:350px; margin-left:-50px; word-wrap: break-word;" class="documentspdf innerstyle" id="fileName"><?php echo $row['pdf']; ?></a> -->
        <!-- <div style="margin-top:-20px;" class="rectangle-div"></div> -->
        <!-- <img style="margin-top:-20px;" class="mdifolder-upload-icon innerstyle" id="docimg" alt="" src="./public/mdifolderupload.svg" /> -->

        <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
          View Documents
        </button>
        <span style="margin-top:10px;" id="upbtn" class="employeeapproval-child71"></span>
        <a id="uptxt" class="view-file1">

          <div style="position: absolute; left: -50px; margin-top: -150px; width: 180px; height: 200px;">
            <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
              View Uploaded Documents
            </button>
          </div>
        </a>

        <div id="static-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width:140%;">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                  Uploaded Document(s)
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
                <?php
                $adrFile = $row['adr_file'];
                $panFile = $row['pan_file'];
                $banFile = $row['ban_file'];
                $eduFile = $row['edu_file'];
                $pvcFile = $row['pvc'];
                $resumeFile = $row['resume'];
                $expFile = $row['exp_file'];
                $passportFile = $row['passport'];

                $pdfFile = $row['pdf'];

                $hrefAdr = !empty($adrFile) ? "Emp_docs/Aadhaar/{$adrFile}" : "pdfs/{$pdfFile}";
                $hrefPan = !empty($panFile) ? "Emp_docs/Pan/{$panFile}" : "pdfs/{$pdfFile}";
                $hrefBan = !empty($banFile) ? "Emp_docs/Bank/{$banFile}" : "pdfs/{$pdfFile}";
                $hrefEdu = !empty($eduFile) ? "Emp_docs/Education/{$eduFile}" : "pdfs/{$pdfFile}";
                $hrefPvc = !empty($pvcFile) ? "Emp_docs/Pvc/{$pvcFile}" : "pdfs/{$pdfFile}";
                $hrefResume = !empty($resumeFile) ? "Emp_docs/Resume/{$resumeFile}" : "pdfs/{$pdfFile}";
                $hrefExp = !empty($expFile) ? "Emp_docs/Experience/{$expFile}" : "pdfs/{$pdfFile}";
                $hrefPassport = !empty($passportFile) ? "Emp_docs/Passport/{$passportFile}" : "pdfs/{$pdfFile}";
                ?>
                <div class="relative overflow-x-auto">
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                      <tr>
                        <th scope="col" class="px-6 py-3">
                          Document Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                          Upload Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                          View
                        </th>
                        <th scope="col" class="px-6 py-3">
                          Download
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">Aadhaar</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefAdr; ?>"> <svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefAdr; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">PAN</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefPan; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefPan; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">Bank details</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefBan; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefBan; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">Educational Certificates</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefEdu; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefEdu; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">PVC</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefPvc; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefPvc; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">Resume</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefResume; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefResume; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">Experience Certificate</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefExp; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefExp; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">Passport</td>
                        <td>
                          <?php
                          echo !empty($row['docs_uploaded']) ? $row['docs_uploaded'] : 'N/A';
                          ?>
                        </td>

                        <td class="px-6 py-4">
                          <a target="_blank" href="<?php echo $hrefPassport; ?>"><svg fill="#ff7b24" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 442.04 442.04" xml:space="preserve" stroke="#ff7b24" stroke-width="10.60896">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <g>
                                  <g>
                                    <path d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z"></path>
                                  </g>
                                  <g>
                                    <path d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z"></path>
                                  </g>
                                </g>
                              </g>
                            </svg></a>
                        </td>
                        <td class="px-6 py-4">
                          <a download href="<?php echo $hrefPassport; ?>">
                            <svg style="margin-left: 17px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ff7b24">
                              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                              <g id="SVGRepo_iconCarrier">
                                <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#ff7b24" stroke-width="1.9919999999999998" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </svg></a>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>

        <input type="file" id="fileInput" class="remove" onchange="displayFileName()">
        <img style="margin-top:-40px; margin-left: 500px;" class="group-icon akar-iconsedit" onclick="editFunction();" alt="" src="./public/group.svg" />

        <input type="file" style="display: none;" id="infile">
    </div>
    <button type="submit" style="margin-top: 130px; margin-left: 150px; font-size:23px; color:white;" class="employeeapproval-child7 remove" id="updatebtn">Update</button>
    <!--<a style="margin-top: 130px; margin-left: 155px; cursor: pointer;" class="view-file remove" id="updatetxt">Update</a>-->
    <span type="submit" onclick="location.reload();" style="margin-top: 130px; background: rgb(255, 92, 92); margin-left: -20px;" class="employeeapproval-child7 remove" id="cancelbtn"></span>
    <a onclick="location.reload();" style="margin-top: 130px; margin-left: -15px; cursor: pointer;" class="view-file remove" id="canceltxt">Cancel</a>

    </form>
    <div style="position: absolute; left: 800px; margin-top: 240px; border: 1px dashed black; width: 180px; height: 200px; display: flex; align-items: center; justify-content: center;">
      <button data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        View Account Details
      </button>
      <div style="z-index: 999" id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
        <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">Account Details</h5>
        <img src="./public/group.svg" onclick="reqeditfunc();" width="25px" style="position: absolute; left: 50%; top: 15px;" alt="">
        <button onclick="window.location.reload()" type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">Close menu</span>
        </button>
        <form id="sacForm">
          <div class="mb-6">
            <label for="datepicker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary Bank Name:</label>
            <select id="namert" name="sbn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
              <option value="">--select--</option>
              <option value="State Bank Of India" <?php if ($row['sbn'] === 'State Bank Of India') echo 'selected'; ?>>State Bank Of India (SBI)</option>
              <option value="Punjab National Bank" <?php if ($row['sbn'] === 'Punjab National Bank') echo 'selected'; ?>>Punjab National Bank (PNB)</option>
              <option value="Indian Bank" <?php if ($row['sbn'] === 'Indian Bank') echo 'selected'; ?>>Indian Bank (IB)</option>
              <option value="Bank Of India" <?php if ($row['sbn'] === 'Bank Of India') echo 'selected'; ?>>Bank Of India (BOI)</option>
              <option value="UCO Bank" <?php if ($row['sbn'] === 'UCO Bank') echo 'selected'; ?>>UCO Bank</option>
              <option value="Union Bank Of India" <?php if ($row['sbn'] === 'Union Bank Of India') echo 'selected'; ?>>Union Bank Of India</option>
              <option value="Central Bank Of India" <?php if ($row['sbn'] === 'Central Bank Of India') echo 'selected'; ?>>Central Bank Of India</option>
              <option value="Bank Of Baroda" <?php if ($row['sbn'] === 'Bank Of Baroda') echo 'selected'; ?>>Bank Of Baroda</option>
              <option value="Bank Of Maharashtra" <?php if ($row['sbn'] === 'Bank Of Maharashtra') echo 'selected'; ?>>Bank Of Maharashtra</option>
              <option value="Canara Bank" <?php if ($row['sbn'] === 'Canara Bank') echo 'selected'; ?>>Canara Bank</option>
              <option value="Indian Overseas Bank" <?php if ($row['sbn'] === 'Indian Overseas Bank') echo 'selected'; ?>>Indian Overseas Bank</option>
              <option value="ICICI Bank" <?php if ($row['sbn'] === 'ICICI Bank') echo 'selected'; ?>>ICICI Bank</option>
              <option value="HDFC Bank" <?php if ($row['sbn'] === 'HDFC Bank') echo 'selected'; ?>>HDFC Bank</option>
              <option value="Axis Bank" <?php if ($row['sbn'] === 'Axis Bank') echo 'selected'; ?>>Axis Bank</option>
              <option value="Kotak Mahindra Bank" <?php if ($row['sbn'] === 'Kotak Mahindra Bank') echo 'selected'; ?>>Kotak Mahindra Bank</option>
              <option value="Federal Bank" <?php if ($row['sbn'] === 'Federal Bank') echo 'selected'; ?>>Federal Bank</option>
            </select>


          </div>
          <div class="mb-6">
            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary Bank IFSC Code :</label>
            <input type="text" name="sifsc" id="ifscvb" value="<?php echo $row['sifsc']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly />
          </div>
          <div class="mb-6">
            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary Bank Account Number :</label>
            <input type="text" name="sban" id="bankl" value="<?php echo $row['sban']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly />
          </div>
          <div class="mb-6">
            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UAN :</label>
            <input type="text" name="uan" id="uanm" value="<?php echo $row['uan']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly />
          </div>
          <div class="mb-6">
            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">EPF Account Number :</label>
            <input type="text" name="epfn" id="epfgh" value="<?php echo $row['epfn']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly />
          </div>
          <div class="mb-6">
            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ESIC Account Number :</label>
            <input type="text" name="esin" id="esicv" value="<?php echo $row['esin']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly />
          </div>
          <button id="submitBtn123" type="submit" class="remove text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">Save</button>
        </form>
      </div>
    </div>
  </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>


<script>
  $(document).ready(function() {
    $('#employeeForm').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'update.php?id=<?php echo $ID; ?>',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
          if (response === 'ok') {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Details Edited successfully!',
            }).then(function() {
              window.location.href = "employee-overview.php?id=<?php echo $ID; ?>";
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Form submission failed!',
            });
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#submitBtn123').click(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'update_sac.php?id=<?php echo $ID; ?>',
        data: new FormData($('#sacForm')[0]),
        processData: false,
        contentType: false,
        success: function(response) {
          if (response === 'ok') {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Details Edited successfully!',
            }).then(function() {
              window.location.href = "employee-overview.php?id=<?php echo $ID; ?>";
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Form submission failed!',
            });
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>

<script>
  function reqeditfunc() {
    document.getElementById('namert').removeAttribute('disabled');
    document.getElementById('namert').classList.add('addin');
    document.getElementById('ifscvb').removeAttribute('readonly');
    document.getElementById('ifscvb').classList.add('addin');
    document.getElementById('bankl').removeAttribute('readonly');
    document.getElementById('bankl').classList.add('addin');
    document.getElementById('uanm').removeAttribute('readonly');
    document.getElementById('uanm').classList.add('addin');
    document.getElementById('epfgh').removeAttribute('readonly');
    document.getElementById('epfgh').classList.add('addin');
    document.getElementById('esicv').removeAttribute('readonly');
    document.getElementById('esicv').classList.add('addin');
    document.getElementById('submitBtn123').classList.remove('remove');
  }
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
</script>
<script>
  $(document).ready(function() {
    $('#changePasswordLink').click(function() {
      // Get the email from the form
      var email = $('#rfv').val();
      var purpose = $('#rfvv').val();
      var changePasswordLink = 'https://yourwebsite.com/change-password?email=' + email;

      Swal.fire({
        title: 'Sending Password Change Link',
        text: 'Please wait...',
        onBeforeOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajax({
        type: 'POST',
        url: 'send_email.php',
        data: {
          email: email,
          purpose: purpose,
          changePasswordLink: changePasswordLink,
        },
        beforeSend: function() {
          // Show loading spinner before sending the request
          Swal.showLoading();
        },
        success: function(response) {
          if (response === 'ok') {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Link for Change Password sent successfully to Emp. mail!',
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Email sending failed!',
            });
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while sending the email!',
          });
        },
        complete: function() {
          // Hide loading spinner when the request is complete
          Swal.hideLoading();
        },
      });
    });
  });
</script>


<script>
  function submitBtn() {
    document.getElementById('sbtbtn').style.opacity = "0.5";
  } // Get all links that start with #modal
  const modalLinks = document.querySelectorAll('a[href^="#modal"]');

  modalLinks.forEach(function(modalLink, index) {
    // Get modal ID to match the modal
    const modalId = modalLink.getAttribute('href');

    // Click on link
    modalLink.addEventListener('click', function(event) {

      // Get modal element
      const modal = document.querySelector(modalId);
      // If modal with an ID exists
      if (modal) {
        // Get close button
        const closeBtn = modal.querySelector('.dialog__close');
        event.preventDefault();
        modal.showModal(); // Open modal

        // Close modal on click
        closeBtn.addEventListener('click', function(event) {
          modal.close();
        });
        const closeBtn1 = modal.querySelector('.dialog__close1');
        event.preventDefault();
        modal.showModal(); // Open modal

        // Close modal on click
        closeBtn1.addEventListener('click', function(event) {
          modal.close();
        });

        // Close modal when clicking outside modal
        document.addEventListener('click', function(event) {

          const dialogEl = event.target.tagName;
          const dialogElId = event.target.getAttribute('id');
          if (dialogEl == 'DIALOG') {
            // Close modal
            modal.close();
          }
        }, false);

        // If modal ID not exists
      } else {
        console.log('Modal doesn\'t exist');
      }
    });
  });
  var anikaHRM = document.getElementById("anikaHRM");
  if (anikaHRM) {
    anikaHRM.addEventListener("click", function(e) {
      window.location.href = "./index.php";
    });
  }

  var onboarding = document.getElementById("onboarding");
  if (onboarding) {
    onboarding.addEventListener("click", function(e) {
      window.location.href = "./index.php";
    });
  }

  var attendance = document.getElementById("attendance");
  if (attendance) {
    attendance.addEventListener("click", function(e) {
      window.location.href = "./attendence.html";
    });
  }

  var dashboard = document.getElementById("dashboard");
  if (dashboard) {
    dashboard.addEventListener("click", function(e) {
      window.location.href = "./index.php";
    });
  }

  var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
  if (fluentpeople32Regular) {
    fluentpeople32Regular.addEventListener("click", function(e) {
      window.location.href = "./employee-management.html";
    });
  }

  var employeeList = document.getElementById("employeeList");
  if (employeeList) {
    employeeList.addEventListener("click", function(e) {
      window.location.href = "./employee-management.html";
    });
  }

  var akarIconsdashboard = document.getElementById("akarIconsdashboard");
  if (akarIconsdashboard) {
    akarIconsdashboard.addEventListener("click", function(e) {
      window.location.href = "./index.php";
    });
  }

  var uitcalender = document.getElementById("uitcalender");
  if (uitcalender) {
    uitcalender.addEventListener("click", function(e) {
      window.location.href = "./attendence.html";
    });
  }

  var leaves = document.getElementById("leaves");
  if (leaves) {
    leaves.addEventListener("click", function(e) {
      window.location.href = "./leave-management.html";
    });
  }

  var fluentpersonClock20Regular = document.getElementById(
    "fluentpersonClock20Regular"
  );
  if (fluentpersonClock20Regular) {
    fluentpersonClock20Regular.addEventListener("click", function(e) {
      window.location.href = "./leave-management.html";
    });
  }

  var onboarding1 = document.getElementById("onboarding1");
  if (onboarding1) {
    onboarding1.addEventListener("click", function(e) {
      window.location.href = "./onboarding.html";
    });
  }

  var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
  if (fluentMdl2leaveUser) {
    fluentMdl2leaveUser.addEventListener("click", function(e) {
      window.location.href = "./onboarding.html";
    });
  }

  var akarIconsedit = document.getElementById("akarIconsedit");
  if (akarIconsedit) {
    akarIconsedit.addEventListener("click", function(e) {
      window.location.href = "./employee-approval.html";
    });
  }

  function editFunction() {
    document.getElementById('onboarding123').classList.remove('remove');
    document.getElementById('updatebtn').classList.remove('remove');
    // document.getElementById('updatetxt').classList.remove('remove');
    document.getElementById('cancelbtn').classList.remove('remove');
    document.getElementById('canceltxt').classList.remove('remove');
    // document.getElementById('avatarEdit').classList.remove('remove');
    document.getElementById('asdf').classList.add('addin');
    document.getElementById('sdfg').classList.add('addin');
    document.getElementById('dfgh').classList.add('addin');
    document.getElementById('fghj').classList.add('addin');
    document.getElementById('ghjk').classList.add('addin');
    document.getElementById('hjkl').classList.add('addin');
    // document.getElementById('qwer').classList.add('addin');
    // document.getElementById('wert').classList.add('addin');
    document.getElementById('designation').classList.add('addin');
    document.getElementById('empid').classList.add('addin');
    document.getElementById('asdf').removeAttribute('readonly');
    document.getElementById('sdfg').removeAttribute('readonly');
    document.getElementById('dfgh').removeAttribute('readonly');
    document.getElementById('fghj').removeAttribute('readonly');
    document.getElementById('ghjk').removeAttribute('readonly');
    document.getElementById('hjkl').removeAttribute('readonly');
    // document.getElementById('qwer').removeAttribute('readonly');
    // document.getElementById('wert').removeAttribute('readonly');
    document.getElementById('uptxt').classList.remove('remove');
    document.getElementById('upbtn').classList.remove('remove');
    document.getElementById('designation').removeAttribute('readonly');
    document.getElementById('empid').removeAttribute('readonly');
    document.getElementById('qaz').classList.add('addin');
    document.getElementById('qaz').removeAttribute('readonly');
    document.getElementById('wsx').classList.add('addin');
    document.getElementById('wsx').removeAttribute('readonly');
    document.getElementById('edc').classList.add('addin');
    document.getElementById('edc').removeAttribute('readonly');
    document.getElementById('rfv').classList.add('addin');
    document.getElementById('rfv').removeAttribute('readonly');
    document.getElementById('tgb').classList.add('addin');
    document.getElementById('tgb').removeAttribute('readonly');
    document.getElementById('yhn').classList.add('addin');
    document.getElementById('yhn').removeAttribute('readonly');
    document.getElementById('yhnq').classList.add('addin');
    document.getElementById('yhnq').removeAttribute('readonly');
    document.getElementById('ujm').classList.add('addin');
    document.getElementById('ujm').removeAttribute('readonly');
    document.getElementById('ik,').classList.add('addin');
    document.getElementById('ik,').removeAttribute('readonly');
    document.getElementById('ol.').classList.add('addin');
    document.getElementById('ol.').removeAttribute('readonly');
    document.getElementById('qwertyuiop').classList.add('addin');
    document.getElementById('qwertyuiop').removeAttribute('readonly');
    document.getElementById('qazlp').classList.add('addin');
    document.getElementById('qazlp').removeAttribute('readonly');
    document.getElementById('wsxmko').classList.add('addin');
    document.getElementById('wsxmko').removeAttribute('readonly');
  }

  function displayFileName() {
    var fileInput = document.getElementById('fileInput');
    var fileNameDisplay = document.getElementById('fileName');

    if (fileInput.files.length > 0) {
      fileNameDisplay.innerHTML = fileInput.files[0].name;
    } else {
      fileNameDisplay.textContent = 'No file selected';
    }
  }
</script>

</html>
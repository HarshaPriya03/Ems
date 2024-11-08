<?php
require_once("dbConfig.php");

function generateDates($year)
{
  $dates = array();
  $startDate = new DateTime("$year-01-01");
  $endDate = new DateTime("$year-12-31");

  while ($startDate <= $endDate) {
    $dates[] = $startDate->format('d-m-Y');
    $startDate->add(new DateInterval('P1D'));
  }

  return $dates;
}

$currentYear = date('Y');
$dates = generateDates($currentYear);
$valuesFromDatabase = array();
$sql = "SELECT date, value FROM holiday";
$result = $db->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $valuesFromDatabase[$row['date']] = $row['value'];
  }
}
$db->close();
?>
<?php
// Set session cookie parameters to share across subdomains
$domain = '.anikasterilis.com'; // Notice the dot at the beginning
session_set_cookie_params(0, '/', $domain, true, true);

session_start();

@include 'inc/config.php';

// Check for token and email in URL
if (isset($_GET['token']) && isset($_GET['email'])) {
  // Verify the token (you should implement a more secure verification method)
  // For now, we'll just check if it's not empty
  if (!empty($_GET['token']) && !empty($_GET['email'])) {
    // Token is present, set up the session
    $_SESSION['email'] = $_GET['email'];
    // You might want to store the token in the session if needed for further verification
    // $_SESSION['auth_token'] = $_GET['token'];
  } else {
    // Invalid token or email, redirect to login
    header('Location: https://apps.anikasterilis.com/index.php');
    exit();
  }
}

if (!isset($_SESSION['email'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Session Expired',
              text: 'Please log in again.',
            }).then(function() {
              window.location.href = 'https://apps.anikasterilis.com/index.php';
            });
          });
        </script>";
  exit();
}


$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['email']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
?>
  <?php

  if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
  }

  $select = "SELECT uf.*, m.status as manager_status 
           FROM user_form uf
           LEFT JOIN manager m ON uf.email = m.email 
           WHERE uf.email = ?";

  $stmt = mysqli_prepare($con, $select);
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_name'] = $row['email'];
    $_SESSION['admin_name'] = $row['name'];

    $manager_status = $row['manager_status'];
  } else {
    echo "User not found";
    exit;
  }
  ?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="emp-profile_global.css" />
    <link rel="stylesheet" href="emp-profile_index.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Aclonica:wght@400&display=swap" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Sansation:wght@400&display=swap" />
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  </head>

  <body>
    <div class="addemployee">
      <div class="bg"></div>
      <img class="addemployee-child" alt="" src="./emp_public/rectangle-1@2x.png" />

      <img class="addemployee-item" alt="" src="./emp_public/rectangle-21@2x.png" />

      <div class="frame-parent24">
        <div class="logo-1-wrapper">
          <img class="logo-1-icon2" alt="" src="./emp_public/logo-12@2x.png" />
        </div>
        <div class="anikahrm-wrapper">
          <a class="anikahrm1">
            <span>Anika</span>
            <span class="hrm1">HRM</span>
          </a>
        </div>
      </div>
      <a class="employee-management">Employee Dashboard </a>
      <div class="fluentperson-clock-20-regular-parent">
        <a class="fluentperson-clock-20-regular2" href="apply-leave-emp.php">
          <img class="vector-icon6" alt="" src="./emp_public/vector2.svg" />
        </a>
        <div class="leaves-wrapper">
          <a class="onboarding1" href="apply-leave-emp.php">Leaves</a>
        </div>
      </div>
      <a href="card.php" style="text-decoration: none;">
        <div class="arcticonsgoogle-pay-parent">
          <img
            class="arcticonsgoogle-pay2"
            alt=""
            src="./emp_public/arcticonsgooglepay2.svg" />

          <div class="ui-designer" style="font-size:25px;color:black">Directory</div>
        </div>
      </a>
      <a style="text-decoration: none;color:black" href="./module_transition_emp-policies/index.php?target=https://hrms.anikasterilis.com/emppolicy/emppolicy.php">
        <div class="streamlineinterface-content-c-parent">
          <img
            class="arcticonsgoogle-pay2"
            alt=""
            src="./emp_public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart1.svg" />

          <div class="ui-designer" style="font-size:25px;">Policies</div>
        </div>
      </a>
      <div class="addemployee-inner">
        <div class="akar-iconsdashboard-parent">
          <a class="akar-iconsdashboard1">
            <img class="vector-icon7" alt="" src="./emp_public/vector3.svg" />
          </a>
          <div class="dashboard-wrapper">
            <a class="dashboard1">Dashboard</a>
          </div>
        </div>
      </div>
    
      <div class="uitcalender-parent">
        <a class="fluent-mdl2leave-user2" href="attendenceemp2.php">
          <img class="vector-icon8" alt="" src="./emp_public/vector4.svg" />
        </a>
        <a class="onboarding1" href="attendenceemp2.php">Attendance</a>
      </div>

      <a href="logout.php">
        <div class="addemployee-inner1">
          <div class="tablerlogout-parent">
            <div class="tablerlogout">
              <img class="group-icon2" alt="" src="./emp_public/group2.svg" />
            </div>
            <div class="leaves-wrapper">
              <div class="putsala-harsha-priya" style="font-size: 1.4vw;">Logout</div>
            </div>
          </div>
        </div>
      </a>
      <?php
    $email1 = $row['email'];

    $sql = "SELECT * FROM user_form WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      $user_type = $row['user_type'];
      $user_type1 = $row['user_type1'];

      $is_enabled = ($user_type == 'user' && $user_type1 == 'admin');
    } else {
      $is_enabled = false;
    }
    ?>
      <?php
$ems_con = new mysqli('localhost', 'root', '', 'apps');
$query = "SELECT apps FROM user_form WHERE email = '$email1'";
$result = mysqli_query($ems_con, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_array($result);
    $apps = $user['apps'];

    $apps_array = explode(',', $apps);  
    $count_apps = count($apps_array);
} else {
    echo '<script>alert("User not found!");</script>';
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}
?>

<div class="streamlineinterface-content-c-parent" style="margin-top:100px;">
          <img
            class="arcticonsgoogle-pay2"
            style="width: 50px; height: 50px; <?php echo ($count_apps > 1) ? 'display:block;' : 'display:none;'; ?>"
            src="https://ik.imagekit.io/jxuol7kjt/openart-a9cf7437-b560-4f97-b445-2e88c3efdd1c%20(1).png?updatedAt=1724395654168" />

          <a id="openModalBtn"  class="ui-designer" style="
          margin-left:-35px;
          font-size:25px;
          text-decoration: none; 
              cursor: pointer; 
              background: linear-gradient(rgba(96,181,234,255),rgba(90,177,230,255),rgba(64,84,111,255)); 
              padding: 10px 10px; 
              border-radius: 5px; 
              font-size: 20px; 
              transition: background 0.3s ease, transform 0.3s ease;
              font-weight:400;
              overflow: hidden;
              <?php echo ($count_apps > 1) ? 'display:block;' : 'display:none;'; ?>
          ">
          <span style="
                     z-index: 1;
                     background: linear-gradient(to right, #f6f7f8, #ffffff, #f6f7f8);
                     -webkit-background-clip: text;
                     -webkit-text-fill-color: transparent;
                     animation: shine 3s infinite linear;">
            Apps Central
        </span>  
          </a>
        </div>


<div id="myModal-1" class="modal-1">
    <div class="modal-content-1">
        <div class="modal-header">
            <span class="close">&times;</span>
               <div class="portal-name" >
        <h2 style="text-transform: capitalize;">
          <span class="portal-name-anika">Anika One</span>
          <span class="portal-name-apps">Apps Central</span>
        </h2>
      </div>
        </div>
  
<div class="app-list">
    <div class="app-card-wrapper">
        <form action="checkGPMS_user_type.php" method="post">
            <button type="submit" style="border: none !important;">
                <div class="app-card hrms-card" id="gpms-section">
                    <img src="https://ik.imagekit.io/jxuol7kjt/gatepass_u.png?updatedAt=1723885699390" alt="Gatepass">
                    <p>Gatepass</p>
                </div>
                <input type="hidden" name="app" value="GPMS">
            </button>
        </form>
    </div>

    <div class="app-card-wrapper">
        <form action="checkVMS_user_type.php" method="post">
            <button type="submit" style="border: none !important;">
                <div class="app-card hrms-card" id="vms-section">
                    <img src="https://ik.imagekit.io/jxuol7kjt/voucher_u.png?updatedAt=1723885618307" alt="Voucher">
                    <p>Voucher</p>
                </div>
                <input type="hidden" name="app" value="VMS">
            </button>
        </form>
    </div>

    <div class="app-card-wrapper">
        <form action="checkSMS_user_type.php" method="post">
            <button type="submit" style="border: none !important;">
                <div class="app-card hrms-card" id="sms-section">
                    <img src="https://ik.imagekit.io/jxuol7kjt/visitor_u.png?updatedAt=1723885698730" alt="Visitor">
                    <p>Visitor</p>
                </div>
                <input type="hidden" name="app" value="SMS">
            </button>
        </form>
    </div>

    <div class="app-card-wrapper">
        <form action="checkSMS_user_type.php" method="post">
            <button type="submit" style="border: none !important;">
        <div class="app-card hrms-card" id="pms-section">
            <img src="https://ik.imagekit.io/jxuol7kjt/policy_u.png?updatedAt=1723885703083" alt="Policy">
            <p>Policy</p>
        </div>
        <input type="hidden" name="app" value="SMS">
            </button>
        </form>
    </div>

</div>
    </div>
</div>

      <?php
    $email1 = $row['email'];

    $sql = "SELECT * FROM user_form WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      $user_type = $row['user_type'];
      $user_type1 = $row['user_type1'];

      $is_enabled = ($user_type == 'user' && $user_type1 == 'admin');
    } else {
      $is_enabled = false;
    }
    ?>
    <?php
    if ($is_enabled) {
    ?>
      <a href="index.php" class="addemployee-inner1 mgr-view view">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
          <polygon points="12 15 17 21 7 21 12 15"></polygon>
        </svg>
        <span>HR View</span>
      </a>
      <?php
    }?>
        <?php if ($manager_status == 1): ?>
      <a href="dash_mgr.php" class="addemployee-inner1 mgr-view view2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
          <polygon points="12 15 17 21 7 21 12 15"></polygon>
        </svg>
        <span>Manager View</span>
      </a>
      <?php endif; ?>



    
      <?php
      $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
      $que = mysqli_query($con, $sql);
      $cnt = 1;
      $row = mysqli_fetch_array($que);
      ?>

      <div class="addemployee-child1"></div>
      <div class="frame-parent25">
        <div class="ellipse-container">
          <img class="frame-child7" alt="" src="pics/<?php echo $row['pic']; ?>" />
        </div>
      </div>
      <div class="frame-parent15">
        <div class="ellipse-wrapper1">
          <img class="frame-child20" alt="" src="./emp_public/ellipse-71@2x.png" />
        </div>
        <div class="ellipse-wrapper2">
          <div class="frame-child21"></div>
        </div>
      </div>


      <div class="frame-parent26">
        <div class="leaves-wrapper">
          <div class="putsala-harsha-priya"><?php echo $row['empname']; ?></div>
        </div>
        <div class="ui-designer-wrapper">
          <div class="ui-designer"><?php echo $row['desg']; ?></div>
        </div>
        <div class="visakhapatnam-started-on-jun-wrapper">
          <div class="visakhapatnam-started">
            <?php echo $row['work_location']; ?> | <?php
                                                    if (!empty($row['empdoj'])) {
                                                      $date = DateTime::createFromFormat('Y-m-d', $row['empdoj']);
                                                      if ($date !== false) {
                                                        echo "Started on " . $date->format('M d, Y');
                                                      } else {
                                                        echo "Started on: Invalid Date";
                                                      }
                                                    } else {
                                                      echo "Start date not available";
                                                    }
                                                    ?>
          </div>
        </div>
      </div>
      <div class="frame-parent27" onclick="toggleDropdown()" style="cursor:pointer;">
        <div class="rectangle-wrapper">
          <div class="frame-child9"></div>
        </div>
        <div class="frame-parent28">
          <div class="run-1-wrapper">
            <img class="run-1-icon" alt="" src="./emp_public/run-1@2x.png" />
          </div>
          <div class="actions-wrapper">
            <div class="actions">ACTIONS</div>
            <div class="dropdown-menu" id="dropdownMenu">
              <a href="apply-leave-emp.php" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                  <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" />
                </svg>
                <span>Apply Leave</span>
              </a>
              <a href="remote_work_emp.php" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                  <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9" />
                </svg>
                <span>Apply Remote Work</span>
              </a>
              <a href="Reports/print_holiday_report.php" target="_blank" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" />
                </svg>
                <span>Download Holiday Calendar</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="job-wrapper">
        <div class="putsala-harsha-priya" id="job-tab" onclick="showSection('job')">JOB</div>
      </div>


      <div class="frame-parent29">
        <div class="personal-wrapper" style="color: var(--color-gray-100);">
          <div class="putsala-harsha-priya" id="personal-tab" onclick="showSection('personal')">PERSONAL</div>
        </div>
      </div>

      <div class="payroll-wrapper">
        <div class="putsala-harsha-priya" id="payroll-tab" onclick="showSection('payroll')">PAYROLL</div>
      </div>

      <div class="addemployee-child2"></div>
      <div class="leave-balance-wrapper">
        <div class="leave-balance">LEAVE BALANCE</div>
      </div>
      <div class="addemployee-child3"></div>
      <div class="manager-wrapper">
        <div class="leave-balance">MANAGER</div>
      </div>
      <div class="frame-parent30">
        <div class="run-1-wrapper">
          <img class="frame-child10" alt="" src="https://ik.imagekit.io/d9wt8plt0/PRABHDEEP%20SINGH%20MAAN.png?updatedAt=1724070423812" />
        </div>
        <div class="frame-wrapper19">
          <div class="frame-parent31">
            <div class="psm-wrapper">
              <div class="putsala-harsha-priya" style="font-size: 1.5vh;margin-left: 4vh;white-space:nowrap;">Prabhdeep Singh Maan</div>
            </div>
            <div class="general-manager-wrapper">
              <div class="putsala-harsha-priya" style="font-size: 1.5vh;margin-left: -10vh;">General Manager</div>
            </div>
          </div>
        </div>
      </div>
      <?php
      $rm_pic = mysqli_real_escape_string($con, $row['rm']);
      $pic_query = "SELECT pic FROM emp WHERE empname = '$rm_pic' ";
      $pic_result = mysqli_query($con, $pic_query);

      if ($pic_result && mysqli_num_rows($pic_result) > 0) {
        $pic_row = mysqli_fetch_assoc($pic_result);
        $pic1 = $pic_row['pic'];
      } else {
        $pic1 = 'default.jpg';
      }
      ?>

      <div class="frame-parent32">
        <div class="run-1-wrapper">
          <img class="frame-child10" src="pics/<?php echo htmlspecialchars($pic1); ?>" alt="Employee Picture" />
        </div>
        <div class="frame-parent33">
          <div class="leaves-wrapper">
            <div class="putsala-harsha-priya" style="font-size: 1.5vh;margin-left: -3.8vh;white-space:nowrap;"><?php echo $row['rm']; ?></div>
          </div>
          <div class="general-manager-wrapper">
            <div class="putsala-harsha-priya" style="font-size: 1.5vh;margin-left: -11.5vh;">Reporting Manager</div>
          </div>
        </div>
      </div>
      <div class="wd-applet-employee-on-leave-re-wrapper">
        <img
          class="wd-applet-employee-on-leave-re-icon"
          alt=""
          src="./emp_public/wdappletemployeeonleaveremovebgpreview-1@2x.png" />
      </div>
      <?php
      $sql_lb = "SELECT * FROM leavebalance WHERE empemail = '{$_SESSION['user_name']}'";
      $que_lb = mysqli_query($con, $sql_lb);
      $icl = 0;

      if (mysqli_num_rows($que_lb) > 0) {
        $row_lb = mysqli_fetch_assoc($que_lb);
        $isl = $row_lb['isl'];
        $icl = $row_lb['icl'];
        $ico = $row_lb['ico'];
        $allocated = $icl + $isl + $ico;

        $sl = $row_lb['sl'];
        $cl = $row_lb['cl'];
        $co = $row_lb['co'];
        $current = $cl + $sl + $co;
      } else {
        echo "No leave balance found for the user.";
      }
      ?>
      <div class="frame-parent34">
        <div class="personal-wrapper">
          <div class="leave-balance">Allocated Leave Balance: <?php echo $allocated ?></div>
        </div>
        <div class="current-leave-balance-2-wrapper" style="margin-left:-17px;">
          <div class="leave-balance">Current Leave Balance: <span style="color:#45C380;"><?php echo $current ?></span></div>
        </div>
      </div>
      <div class="addemployee-child4"></div>

      <!-- PERSONAL SECTION -->
      <section id="personal">
        <div class="identification-info-wrapper">
          <div class="leave-balance">IDENTIFICATION INFO</div>
        </div>
        <div class="demographic-details-wrapper">
          <div class="leave-balance">DEMOGRAPHIC INFO</div>
        </div>
        <div class="frame-parent35">
          <div class="leaves-wrapper">
            <div class="leave-balance">FULL NAME</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['empname']; ?></div>
          </div>
        </div>
        <div class="frame-parent36">
          <div class="leaves-wrapper">
            <div class="leave-balance">PAN</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['pan']; ?></div>
          </div>
        </div>
        <div class="frame-parent37">
          <div class="leaves-wrapper">
            <div class="leave-balance">AADHAR CARD</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['adn']; ?></div>
          </div>
        </div>
        <div class="frame-parent38" style="margin-top:2vh;">
          <div class="leaves-wrapper">
            <div class="leave-balance">EMAIL</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <a class="putsalaharshapriyagmailcom"
              href="mailto:putsalaharshapriya@gmail.com"
              target="_blank" style="font-size: 2vh;"><?php echo $row['empemail']; ?></a>
          </div>
        </div>
        <?php
        $name = '';
        $sanitized_email = mysqli_real_escape_string($con, $row['empemail']);
        $sql_name = "SELECT name FROM user_form WHERE email = '$sanitized_email'";
        $result = mysqli_query($con, $sql_name);

        if ($result && mysqli_num_rows($result) > 0) {
          $row_name = mysqli_fetch_assoc($result);
          $name = $row_name['name'];
        } else {
          $name = 'User Not Found';
        }
        mysqli_free_result($result);
        ?>
        <div class="frame-parent39">
          <div class="leaves-wrapper">
            <div class="leave-balance">PREFERRED NAME</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $name ?></div>
          </div>
        </div>
        <div class="frame-parent40" style="margin-top:2vh;">
          <div class="leaves-wrapper">
            <div class="leave-balance">PHONE NUMBER</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['empph']; ?></div>
          </div>
        </div>
        <div class="frame-parent41">
          <div class="personal-wrapper">
            <div class="leave-balance">DATE OF BIRTH</div>
          </div>
          <div class="frame">
            <div class="leave-balance"><?php echo $row['empdob']; ?></div>
          </div>
        </div>
        <div class="frame-parent42">
          <div class="personal-wrapper">
            <div class="leave-balance">GENDER</div>
          </div>
          <div class="female-wrapper">
            <div class="leave-balance">
              <?php
              if ($row['empgen'] == "M") {
                echo "Male";
              } else {
                echo "Female";
              }
              ?></div>
          </div>
        </div>
        <div class="frame-parent43">
          <div class="personal-wrapper">
            <div class="leave-balance">MARTIAL STATUS</div>
          </div>
          <div class="frame">
            <div class="leave-balance"><?php echo $row['empms']; ?></div>
          </div>
        </div>

        <div class="frame-parent43" style="left:87vw;">
          <div class="personal-wrapper">
            <div class="leave-balance">YOUR DOCUMENTS</div>
          </div>
          <a href="directory.php">
            <div class="frame" style="margin-left: -2vw;">
              <div class="leave-balance">
                <img src="https://static-00.iconduck.com/assets.00/folder-color-orange-icon-2048x1613-kty59ev1.png" alt="image" style="width: 3vw;height: 5vh; margin-left:4.5vh;margin-top:-0.5vh;">
              </div>
            </div>
          </a>
        </div>
      </section>

      <!-- JOB SECTION -->
      <section id="job" style="display: none;">
        <div class="identification-info-wrapper">
          <div class="leave-balance">JOB INFO</div>
        </div>

        <div class="frame-parent35">
          <div class="leaves-wrapper">
            <div class="leave-balance">DESIGNATION</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['desg']; ?></div>
          </div>
        </div>
        <div class="frame-parent36" style="width:100%;">
          <div class="leaves-wrapper">
            <div class="leave-balance">EMPLOYMENT TYPE</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['empty']; ?></div>
          </div>
        </div>
        <div class="frame-parent37">
          <div class="leaves-wrapper">
            <div class="leave-balance">WORK LOCATION</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['work_location']; ?></div>
          </div>
        </div>
        <div class="frame-parent38">
          <div class="leaves-wrapper">
            <div class="leave-balance">GENERAL MANAGER</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <a
              class="putsalaharshapriyagmailcom"
              style="font-size: 2vh;text-decoration:none;">Prabhdeep Singh Maan</a>
          </div>
        </div>
        <div class="frame-parent39">
          <div class="leaves-wrapper">
            <div class="leave-balance">DEPARTMENT</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance" style="margin-left: 0.1vw;"><?php echo $row['dept']; ?></div>
          </div>
        </div>
        <div class="frame-parent40" style="width:100%;">
          <div class="leaves-wrapper">
            <div class="leave-balance">REPORTING MANAGER</div>
          </div>
          <div class="putsala-harsha-priya-container">
            <div class="leave-balance"><?php echo $row['rm']; ?></div>
          </div>
        </div>
        <div class="frame-parent41" style="margin-top: -10vh;">
          <div class="personal-wrapper" style="margin-left:0.23vw;">
            <div class="leave-balance">EMPLOYEE ID</div>
          </div>
          <div class="frame" style="margin-left:3.4vw;">
            <div class="leave-balance"><?php echo $row['emp_no']; ?></div>
          </div>
        </div>

        <div class="frame-parent43" style="margin-top: -10vh;">
          <div class="personal-wrapper">
            <div class="leave-balance">DATE OF JOINING</div>
          </div>
          <div class="frame">
            <div class="leave-balance" style="margin-left: -1.5vw;"><?php echo $row['empdoj']; ?></div>
          </div>
        </div>
      </section>
      <!-- PAYROLL SECTION -->
      <section id="payroll" style="display: none;">
        <div class="identification-info-wrapper">
          <div class="leave-balance">PAYROLL INFO</div>
        </div>
        <div class="cards">
          <a href="salary.php" style="text-decoration:none;color:black;">
            <div class="cards-1">
              <img src="https://hrms.anikasterilis.com/Payroll/public/salarystruc-removebg-preview.png" alt="">
              <div class="right">
                <h3>Salary Details</h3>
                <p>View your complete salary breakdown</p>
              </div>
            </div>
          </a>
          <a href="payslip.php" style="text-decoration:none;color:black;">
            <div class="cards-2">
              <img src="https://hrms.anikasterilis.com/Payroll/public/statements.png" alt="">
              <div class="right">
                <h3>Payslip</h3>
                <p>Access and download your monthly payslips</p>
              </div>
            </div>
          </a>
          <a href="emploan.php" style="text-decoration:none;color:black;">
            <div class="cards-3">
              <img src="https://hrms.anikasterilis.com/Payroll/public/loans-removebg-preview.png" alt="">
              <div class="right">
                <h3>Employee Loan</h3>
                <p>Manage and track your employee loan information</p>
              </div>
            </div>
          </a>
        </div>
      </section>
    </div>
    <script>
        var apps = '<?php echo $apps; ?>';
        
        apps = apps.replace(/[{}]/g, '').split(', ');

        apps.forEach(function(app) {
           if (app === 'VMS') {
                document.getElementById('vms-section').style.display = 'block';
            } else if (app === 'GPMS') {
                document.getElementById('gpms-section').style.display = 'block';
              } else if (app === 'PMS') {
                document.getElementById('pms-section').style.display = 'block';
              } else if (app === 'SMS') {
                document.getElementById('sms-section').style.display = 'block';
            }
        });
    </script>
    <script>// Get the modal
        var modal = document.getElementById("myModal-1");
        
        // Get the button that opens the modal
        var btn = document.getElementById("openModalBtn");
        var btn_1 = document.getElementById("openModalBtn-1");
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }
        btn_1.onclick = function() {
            modal.style.display = "block";
        }
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
        </script>
  
    <script>
      function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
      }

      // Close the dropdown when clicking outside
      window.onclick = function(event) {
        if (!event.target.closest('.frame-parent27')) {
          const dropdown = document.getElementById('dropdownMenu');
          if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
          }
        }
      };

      function showSection(sectionId) {
        const personalTab = document.getElementById('personal-tab');
        const jobTab = document.getElementById('job-tab');
        const payrollTab = document.getElementById('payroll-tab');

        personalTab.classList.remove('active');
        jobTab.classList.remove('active');
        payrollTab.classList.remove('active');

        document.getElementById('personal').style.display = 'none';
        document.getElementById('job').style.display = 'none';
        document.getElementById('payroll').style.display = 'none';

        if (sectionId === 'personal') {
          personalTab.classList.add('active');
          document.getElementById('personal').style.display = 'block';
        } else if (sectionId === 'job') {
          jobTab.classList.add('active');
          document.getElementById('job').style.display = 'block';
        } else if (sectionId === 'payroll') {
          payrollTab.classList.add('active');
          document.getElementById('payroll').style.display = 'block';
        }
      }

      document.addEventListener('DOMContentLoaded', function() {
        showSection('personal');
      });
    </script>
  </body>

  </html>
<?php
} else {
  echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Session Expired',
        text: 'For your security, your session has timed out due to inactivity.',
        confirmButtonText: 'Log In Again',
        confirmButtonColor: '#3085d6',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        customClass: {
            container: 'session-expired-alert',
            title: 'font-weight-bold',
            content: 'text-left',
            confirmButton: 'btn btn-primary btn-lg'
        },
        backdrop: `
           #FFBF78
            url('https://apps.anikasterilis.com/ASPL.png')
            center center
            no-repeat
        `
    }).then(function() {
        window.location.href = 'loginpage.php';
    });
});
</script>";
  exit();
}
?>
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
    // Handle case where user is not found
    echo "User not found";
    exit;
}
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="./global.css" />
    <link rel="stylesheet" href="./employee-dashboard.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
      .calendar-container {
        height: auto;
        width: 400px;
        background-color: white;
        border-radius: 20px;
        box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.4);
        padding: 0px 10px;
      }

      .calendar-week {
        display: flex;
        list-style: none;
        align-items: center;
        padding-inline-start: 0px;
      }

      .calendar-week-day {
        max-width: 90.1px;
        width: 100%;
        text-align: center;
        color: #525659;
      }

      .calendar-days {
        margin-top: 30px;
        list-style: none;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
        gap: 30px;
        padding-inline-start: 0px;
      }

      .calendar-day {
        text-align: center;
        color: #525659;
        padding: 10px;
      }

      .calendar-month-arrow-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .calendar-month-year-container {
        padding: 10px 10px 20px 10px;
        color: #525659;
        cursor: pointer;
      }

      .calendar-arrow-container {
        margin-top: -5px;
      }

      .calendar-left-arrow,
      .calendar-right-arrow {
        height: 30px;
        width: 30px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #525659;
      }

      .calendar-today-button {
        margin-top: -10px;
        border-radius: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        color: #525659;
        padding: 5px 10px;
      }

      .calendar-today-button {
        height: 35px;
        margin-right: 10px;
        background-color: #ec7625;
        color: white;
      }

      .calendar-months,
      .calendar-years {
        flex: 1;
        border-radius: 10px;
        height: 50px;
        border: none;
        cursor: pointer;
        outline: none;
        color: #525659;
        font-size: 15px;
      }

      .calendar-day-active {
        background-color: #ec7625;
        color: white;
        border-radius: 50%;
      }

      .calendar-day-holiday {
        color: #cc0000 !important;
      }

      .holiday-name {
        font-size: 10px;
        color: #ff0000;
        text-align: start !important;
        position: absolute;
        transform: translateX(-20%);
      }

      .holiday-style {
        background-color: #ffcccc !important;
        color: #cc0000 !important;
      }

      .holiday-name-style {
        font-size: 10px;
        color: #ff0000;
        text-align: start !important;
        position: absolute;
        transform: translateX(-20%);
      }
        .dropbtn {
      background-color: #45C380;
      color: #ffffff;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px #45C380;
    }

    .dropdown-content {
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 9;
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
    .dropbtn1 {
      background-color: #ffe2c6;
      color: #ff5400;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      /* box-shadow: 0px 8px 16px 0px #ffe2c6; */
    }

    .toggle-container {
            height: 100vh;
        }
        .toggle {
            position: relative;
            width: 40px;
            height: 80px;
            background-color: #ccc;
            border-radius: 20px;
            cursor: pointer;
        }
        .toggle-button {
            position: absolute;
            left: 5px;
            bottom: 5px;
            width: 30px;
            height: 30px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        .toggle.active {
            background-color: #4CAF50;
        }
        .toggle.active .toggle-button {
            transform: translateY(-40px);
        }

        .mgr-view{
          margin-top:-600px;
          margin-left:-20px;
          color:white;
          font-size:20px;
        }
       
        .employeedashboard-inner {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .employeedashboard-inner svg {
            flex-shrink: 0;
        }

        .employeedashboard-inner span {
            margin-left: 5px;
        }
        .employeedashboard-inner span{
          white-space: nowrap;
        }
        
        .dropdown-content1 {
          left: calc(50% + 70px);
          top: calc(60px);
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 9;
      max-height: 0;
      min-width: 160px;
      transition: max-height 0.15s ease-out;
      overflow: hidden;
    }

    .dropdown-content1 a {
      color: black;
      background-color: #f9f9f9;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content1 a:hover {
      background-color: #e2e2e2;
    }

    .dropdown:hover .dropdown-content1 {
      max-height: 500px;
      min-width: 160px;
      transition: max-height 0.25s ease-in;
    }
.modal-1 {
    display: none;
    position: fixed;
    z-index: 9999999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(10px);
    line-height: normal;
  font-family: "Raleway", sans-serif;
  font-weight:300;
}

.modal-content-1 {
    background: linear-gradient(135deg, #f6f9fc, #eaeaea);
    margin: 10% auto;
    padding: 20px;
    width: 70%;
    max-width: 900px;
        height: 280px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.4s ease-in-out;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
      background: linear-gradient(135deg, rgba(0, 111, 218, 0.9), rgba(0, 111, 218, 0.57));
    padding: 10px 20px;
    border-radius: 12px 12px 0 0;
    color: white;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.close {
    font-size: 1.5rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover {
    color: #f44336;
}

.app-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.app-card-wrapper {
    /* flex: 0 1 200px;  */
    display: flex;
    justify-content: center;
}

.app-card {
    width: 100%;
    max-width: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.app-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s ease;
}
.app-card {
    background-color: white;
    border-radius: 8px;
    padding: 10px;
    margin: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 150px;
    cursor: pointer;
}

.app-card img {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
    border-radius: 8px;
}

.app-card p {
    margin: 0;
    font-size: 1rem;
    color: #333;
}

.app-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.portal-name {
  flex: 1;
  text-align: center;
  position: relative;
  overflow: hidden;

}

.portal-name h2 {
  margin: 0;
  font-weight: 300 !important;
  font-size: 1.5vw;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  color: #FFD700;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  position: relative;
  z-index: 1;
}
.portal-name-anika {
  display: inline-block;
  border-right: 3px solid #FFD700;
  padding-right: 10px;
  margin-right: 10px;
}
#openModalBtn:hover {
    background: linear-gradient(135deg, rgba(0,111,218,0.9), rgba(0,111,218,1));
    transform: scale(1.05);
}

#openModalBtn-1:hover {
    transform: rotate(-10deg) scale(1.05);
}
@keyframes shine {
    0% {background-position: -100px;}
    100% {background-position: 200px;}
}

#openModalBtn::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.1);
    transform: rotate(45deg);
    animation: shine-effect 3s infinite;
}

@keyframes shine-effect {
    0% {transform: rotate(45deg) translate(-50%, -50%);}
    100% {transform: rotate(45deg) translate(50%, 50%);}
}


.app-card{
        display:none;
    } 

    </style>
  </head>

  <body>

  
    <section class="employeedashboard">
      <div class="bg4"></div>
      <img class="employeedashboard-child" alt="" src="./public1/rectangle-1@2x.png" />

      <img class="employeedashboard-item" alt="" src="./public1/rectangle-2@2x.png" />

      <a class="anikahrm4">
        <span>Anika</span>
        <span class="hrm4">HRM</span>
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
    if ($is_enabled) {
    ?>
    <a style="height:45px;width:170px;" href="index.php"  class="employeedashboard-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>HR  View</span>
        </a>
        <?php
    }?>
      <?php if ($manager_status == 1): ?>
        <a style="margin-top:-545px;height:40px;" href="dash_mgr.php"  class="employeedashboard-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>Manager View</span>
        </a>
    <?php endif; ?>
    
      <a href="./employee-dashboard.php" class="employee-management4" id="employeeManagement">Employee Management </a>
    <button style="border-radius: 50%;position:absolute;right:50px; top:7px;" onclick="window.location.href='./faqs/faq.php'" class="dropbtn1" for="btnControl"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ff5400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></button>
      <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php" class="employee-management4" id="employeeManagement"></a>
      <button class="employeedashboard-inner"></button>
      <a href="logout.php">
        <div class="logout4">Logout</div>
      </a>
      <a href="apply-leave-emp.php" class="leaves4">Leaves</a>
      <a href="attendenceemp2.php" class="attendance4">Attendance</a>

      <a href="card.php" style="text-decoration: none; color: #222222;" class="payroll4">Directory</a>
      <img class="arcticonsgoogle-pay4" alt="" src="./public1/arcticonsgooglepay.svg" />

      <a class="fluentperson-clock-20-regular4">
        <img class="vector-icon13" alt="" src="./public1/vector.svg" />
      </a>
      <img class="uitcalender-icon4" alt="" src="./public1/uitcalender.svg" />

      <a href="./module_transition_emp-policies/index.php?target=https://hrms.anikasterilis.com/emppolicy/emppolicy.php"  style="margin-top:60px;text-decoration: none; color: #222222;" class="btn payroll4">Policies</a>
      <img class="arcticonsgoogle-pay4" style="margin-top:60px;margin-left:-35px;width:100px;" src="./public1/policy.svg" />
      
      
      <!--  <a id="openModalBtn"  style="margin-top:201px;text-decoration: none; color: #fff;cursor:pointer;background:linear-gradient(135deg,rgba(0,111,218,0.57),rgba(0,111,218,0.9));padding:6.2px;margin-left:-10px;padding-right:15px;padding-bottom:9px;padding-top:11px;border-top-right-radius:5px;border-bottom-right-radius:5px;font-size:20px;" class="btn payroll4">Apps Central</a>-->
      <!--<img id="openModalBtn-1" class="arcticonsgoogle-pay4" style="margin-top:200px;;width:50px;height:50px;font-size:15px; background:linear-gradient(135deg,rgba(0,111,218,0.57),rgba(0,111,218,0.9));padding:10px;border-top-left-radius:5px;border-bottom-left-radius:5px;color:#fff;" -->
      <!--src="https://ik.imagekit.io/jxuol7kjt/output-onlinepngtools.png?updatedAt=1724311711831" />-->
 
   
    <!--<a id="openModalBtn" -->
    <!--   style="margin-left:-10px;margin-top:205px;text-decoration: none; color: #D0D3D5; cursor: pointer; background: linear-gradient(rgba(96,181,234,255),rgba(90,177,230,255),rgba(64,84,111,255)); padding: 7px 10px; border-radius: 5px; font-size: 20px; transition: background 0.3s ease, transform 0.3s ease;font-weight:400;" -->
    <!--   class="btn payroll4">-->
    <!--    Apps Central-->
    <!--</a>-->
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

<div>
<img id="openModalBtn-1"  class="arcticonsgoogle-pay4"
         style=" <?php echo ($count_apps > 1) ? 'display:block;' : 'display:none;'; ?> margin-top:200px;width: 50px; height: 50px;   border-top-left-radius: 5px; border-bottom-left-radius: 5px; color: #fff; transition: transform 0.3s ease;" 
         src="https://ik.imagekit.io/jxuol7kjt/openart-a9cf7437-b560-4f97-b445-2e88c3efdd1c%20(1).png?updatedAt=1724395654168" 
         alt="App Store Logo" />
    <a id="openModalBtn" 
       style="margin-left:-10px;
              margin-top:205px;
              text-decoration: none; 
              cursor: pointer; 
              background: linear-gradient(rgba(96,181,234,255),rgba(90,177,230,255),rgba(64,84,111,255)); 
              padding: 7px 10px; 
              border-radius: 5px; 
              font-size: 20px; 
              transition: background 0.3s ease, transform 0.3s ease;
              font-weight:400;
              overflow: hidden;
              <?php echo ($count_apps > 1) ? 'display:block;' : 'display:none;'; ?>" 
       class="btn payroll4">
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
            <button type="submit">
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
            <button type="submit">
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
            <button type="submit">
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
            <button type="submit">
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
  
  
  
  
  
      <?php
          $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
    $que = mysqli_query($con, $sql);
    $cnt = 1;
    $row = mysqli_fetch_array($que);
    ?>

      <img class="employeedashboard-child2" alt="" src="./public1/rectangle-4@2x.png" />

      <img class="tablerlogout-icon4" alt="" src="./public1/tablerlogout.svg" />

      <a class="uitcalender4">
        <img class="vector-icon14" alt="" src="./public1/vector1.svg" />
      </a>
      <div class="rectangle-parent5" style="margin-top:-20px;">
        <img class="frame-child52" alt="" style="width:753px" src="./public1/rectangle-22@2x.png" />



        <h3 class="mohan-reddy" style="width:300px; margin-left:-50px; margin-top:30px; word-wrap: break-word;"><?php echo $row['empname']; ?> </h3>
        <!--<p class="web-developer"><?php echo $row['desg']; ?> </p>-->
        <img style="border-radius: 50%; margin-top:25px;" class="screenshot-2023-10-27-141446-1" alt="" src="pics/<?php echo $row['pic']; ?>">

        <img class="frame-icon" alt="" src="./public1/frame-34.svg" />

        <h3 class="basic-info" style="top:20px;left:500px;"><u>Basic Info</u></h3>
        <h3 class="job-info" style="left:500px;"><u>Job Info</u></h3>
        <p class="full-name-mohan" style="margin-top:180px"><b>Employee ID:</b> <br><?php echo $row['emp_no']; ?></p>
        <p class="full-name-mohan" style="top:50px;"><b>Gender:</b> <br><?php echo $row['empgen']; ?></p>
        <!-- <p class="join-date-24112022">Joining Date: <?php echo $row['empdoj']; ?> </p> -->
        <p class="employee-id-1920" style="top:100px;"><b>Marital Status:</b> <br> <?php echo $row['empms']; ?> </p>
        <p class="department-it" style="margin-top:20px"><b>Designation:</b> <br><?php echo $row['desg']; ?></p>
        <p class="birthday-17062002"><b>Date of Birth:</b> <br> <?php $orgDate = $row['empdob'];
    $newDate = date("d-m-Y", strtotime($orgDate));
    echo $newDate;  ?></p>

 
        <img class="frame-child53" alt="" src="./public1/rectangle-23@2x.png" />
        <img class="solarsuitcase-outline-icon" alt="" src="./public1/solarsuitcaseoutline.svg" />
       
        <?php
      $currentDate = date('Y-m-d');

      $user_name = $_SESSION['user_name'];
      $sql = "SELECT serviceTagId FROM emp WHERE empemail = '$user_name'";
      $result = $con->query($sql);
      
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $serviceTagId = $row['serviceTagId'];
      
          // Determine the table name based on serviceTagId
          if ($serviceTagId == 'ZXQI19009096') {
              $tableName = 'CamsBiometricAttendance';
          } elseif ($serviceTagId == 'ZYSA07001899') {
              $tableName = 'CamsBiometricAttendance_GGM';
          } else {
              die("No attendance table associated with this serviceTagId.");
          }

      }

    $sql = "SELECT emp.*, $tableName .*
              FROM emp
              INNER JOIN $tableName  ON emp.UserID = $tableName .UserID
              WHERE empemail = '{$_SESSION['user_name']}'
              AND DATE($tableName .AttendanceTime) = '$currentDate'";

    $que = mysqli_query($con, $sql);
    $userCheckOut = array();
    $userEntriesCount = array();
    $prevDay = null;

    while ($result = mysqli_fetch_assoc($que)) {
        $userId = $result['UserID'];
        $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
        $formattedDate = date('D j M', strtotime($result['AttendanceTime']));

        if ($result['AttendanceType'] == 'CheckOut') {
            $userCheckOut[$userId] = array(
              'AttendanceTime' => $result['AttendanceTime'],
              'InputType' => $result['InputType'],
              'Department' => $result['dept']
            );
        } elseif ($result['AttendanceType'] == 'CheckIn') {
            $currentDay = date('j', strtotime($result['AttendanceTime']));
            ?>

<p class="phone-9885852424" style="margin-top:-50px; margin-left:-15px;">
<b>Check IN:</b>   <br> <?php echo isset($result['AttendanceTime']) ? date('H:i:s', strtotime($result['AttendanceTime'])) : ''; ?>
</p>

            <p class="email-naradamohan1gmailcom" style="margin-top:30px; margin-left:-15px;">
              <span class="email">
              <b>Total Hours:</b> <br>
                <?php
                    if (isset($userCheckOut[$userId])) {
                        $inTime = strtotime($result['AttendanceTime']);
                        $outTime = strtotime($userCheckOut[$userId]['AttendanceTime']);

                        // Calculate the difference in seconds
                        $secondsDiff = $outTime - $inTime;

                        // Calculate hours and minutes
                        $hours = floor($secondsDiff / 3600);
                        $minutes = floor(($secondsDiff % 3600) / 60);

                        echo $hours . ' hrs ' . $minutes . ' mins';
                    } else {
                        $timeInput = strtotime($result['AttendanceTime']);
                        $origin = new DateTime(date('Y-m-d H:i:s', $timeInput));
                        $target = new DateTime(); // Current time
                        $target->modify('+5 hours 30 minutes');
                        $interval = $origin->diff($target);

                        echo $interval->format('%h hrs %i mins') . PHP_EOL;
                    }
            ?>
              </span>
            </p>
        <?php
        }
    }
    ?>
    <?php
$sql_last_record = "SELECT emp.*, $tableName .*
                    FROM emp
                    INNER JOIN $tableName  ON emp.UserID = $tableName .UserID
                    WHERE empemail = '{$_SESSION['user_name']}'
                    AND DATE($tableName .AttendanceTime) != '$currentDate'
                    ORDER BY $tableName .AttendanceTime DESC
                    LIMIT 1";

    $que_last_record = mysqli_query($con, $sql_last_record);

    // Fetch the last record other than currentDate
    if ($result_last_record = mysqli_fetch_assoc($que_last_record)) {
        ?>
  <p class="email-naradamohan1gmailcom" style="margin-top:-35px; margin-left:-15px;">
        <span class="email"><b>Recent Check IN/OUT:</b> <br /> 
            <?php echo $result_last_record['AttendanceTime']; ?>
        </span>
    </p>
    <?php
    }
    ?>

        <p class="email-naradamohan1gmailcom" style="margin-top:100px; margin-left:-15px;">
          <span class="email"><b>Actual Work Hours:</b><br>

            <?php
            $empname = $_SESSION['user_name'];

    $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empemail = '$empname'";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert fromshifttime1 and toshifttime1 to DateTime objects
            $fromShiftTime = new DateTime($row['fromshifttime1']);
            $toShiftTime = new DateTime($row['toshifttime1']);

            // Calculate the difference between the times
            $interval = $fromShiftTime->diff($toShiftTime);

            // Format the difference
            $duration = $interval->format('%h hrs %i mins');

            echo $duration;
        }
    } else {
        echo "No designation found for this employee";
    }
    ?>
          </span>
        </p>

        <?php
        $cnt++;
    ?>
        <div class="vector-wrapper">
          <img class="vector-icon15" alt="" src="./public1/vector4.svg" />
        </div>
        <img class="frame-child54" alt="" style="margin-top:-14px; width:590px; height:420px;" src="./public1/rectangle-24@2x.png" />

        <h3 class="leave-balance" style="margin-top:-14px">Leave Balance</h3><a href="myleaves-emp.php" class="leave-balance" style="margin-left:170px;margin-top:-12px"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="25" viewBox="0 0 24 24" fill="none" stroke="#F46214" stroke-width="2.5" stroke-linecap="butt" stroke-linejoin="bevel">
            <g fill="none" fill-rule="evenodd">
              <path d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h5M15 3h6v6M10 14L20.2 3.8" />
            </g>
          </svg></a>
        <?php
    $sql = "SELECT * FROM leavebalance WHERE empemail = '{$_SESSION['user_name']}'";
    $que = mysqli_query($con, $sql);
    $cnt = 1;
    if (mysqli_num_rows($que) == 0) {
        echo '<tr><td colspan="5" style="text-align:center;">Stay tuned for upcoming updates on your leave balance! Keep an eye on this space for exciting developments.</td></tr>';
    } else {
        while ($result = mysqli_fetch_assoc($que)) {
            ?>
            <div style="position:absolute; z-index:9; margin-top:480px; display:flex; margin-left:10px;">
              <div style="background-color:#f6f5fb; width:250px; height:290px; border-radius:20px; margin-left:30px;"> <br />
                <div style="border:2px solid #dadada; width:90%;margin-left:auto; margin-right:auto; border-radius:20px">
                  <img src="./public/Casualleavee.png" width="70px" style="margin-left:85px; margin-top:10px;" />
                  <p style="font-size:16px; font-weight:400;margin-left:15px;">Leave Balance(SL + CL)*</p>
                  <p style="font-size:13px; font-weight:400;margin-left:12px; margin-top:-10px; color:#8a7561">*Leave Balance Allocated</p>

                </div>
              <p style="font-size:13px; font-weight:400;margin-left:15px; margin-top: 10px;">*Allocated Leave balance - <b><?php echo  $result['icl'] + $result['isl']; ?></b></p>
                <p style="font-size:13px; font-weight:400;margin-left:15px; margin-top: 10px;">*Remaining Leave balance - <b class="text-green-500"><?php echo  $result['cl'] + $result['sl']; ?></b></p>
                </div>
              <div style="background-color:#f6f5fb; width:250px; height:290px; border-radius:20px; margin-left:30px;"> <br />
                <div style="border:2px solid #dadada; width:90%;margin-left:auto; margin-right:auto; border-radius:20px">
                  <img src="./public/Compoff.png" width="70px" style="margin-left:85px; margin-top:10px;" />
                  <p style="font-size:16px; font-weight:400;margin-left:15px;">Comp. Off's*</p>

                  <p style="font-size:13px; font-weight:400;margin-left:12px; margin-top:-10px; color:#8a7561">*Comp.Off(s) Earned
                  </p>
                  <p style="font-size:13px; font-weight:400;margin-left:15px; margin-top:-5px; color:#8a7561"></p>
                </div>
                <p style="font-size:13px; font-weight:400;margin-left:15px; margin-top: 10px;">Earned Comp.Off(s)* - <b><?php echo $result['ico']; ?></b></p>
                <p style="font-size:13px; font-weight:400;margin-left:15px; margin-top: 10px;">Remaining Comp.Off(s)- <b class="text-green-500"><?php echo $result['co']; ?></b></p>
                <p style="font-size:12px; font-weight:400;margin-left:12px; margin-top:-5px; color:#8a7561">Updated as of <b><?php echo date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes')); ?> </b></p>
              </div>

            </div>
        <?php
        }
    }
    ?>
        <div class="calendar-container" style="margin-left:550px; width:560px; scale:0.7; margin-top:325px;">
          <div class="calendar-month-arrow-container">
            <div class="calendar-month-year-container">
              <select class="calendar-years"></select>
              <select class="calendar-months">
              </select>
            </div>
            <div class="calendar-month-year">
            </div>
            <div class="calendar-arrow-container">
              <button class="calendar-today-button"></button>
              <a href="./Reports/print_holiday_report.php" target="_blank" class="calendar-today-button">PDF</a>
              <button class="calendar-left-arrow">
                ← </button>
              <button class="calendar-right-arrow"> →</button>
            </div>
          </div>
          <ul class="calendar-week">
          </ul>
          <ul class="calendar-days">
          </ul>
        </div>
      </div>
      <?php
          $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
    $que = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($que);
    ?>
      <div class="rectangle-parent6" style="margin-left:80px;">
        <div class="frame-child64" style="margin-left:-80px;"></div>
        <div class="dropdown" style="position:absolute;z-index:99;">
        <a class="attendence5" style="margin-left: 80px; border: none; background: none; margin-top: 15px; " for="btnControl"><img src="./public/9710841.png" width="50px" alt="">
          <div class="dropdown-content" style="margin-left: -60px; border-radius: 20px;">
          <?php
$sql1 = "SELECT * FROM inet_access WHERE (empemail = '" . $_SESSION['user_name'] . "')";
$que = mysqli_query($con, $sql1);
$row = mysqli_fetch_array($que);

if (!$row) {
  echo '<a style="margin-top:-40px;cursor:pointer;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
Request office Wi-Fi/LAN access
</a>';
}
 else {
  if ($row['status'] == 0) {
      echo '<span style="position:absolute; left:10px; top:10px; display:flex; gap:10px"> 
      <span class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-1.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
      <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
    </svg>
    
    Pending approval for access to the office Wi-Fi/LAN
</span>
      </span>';
  } elseif ($row['status'] == 1) {
    echo '<span style="position:absolute; left:10px; top:10px; display:flex; gap:10px"> 
    <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
              <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>You now have access to the office Wi-Fi/LAN
      </span>
    </span>';
  } elseif ($row['status'] == 2) {
    echo '<span style="position:absolute; left:10px; top:10px; display:flex; gap:10px"> 
    <span class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-red-700 dark:text-red-400 border border-red-500 ">
    <svg class="w-4 h-4 me-1.5"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
  </svg>
  Regrettably,you cant access the office Wi-Fi/LAN
</span>
    </span>';
  } else{
    echo '<a style="margin-top:-40px;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Request office internet access
    </a>';
  }
}
?>
<?php
          $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
    $que = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($que);
    ?>
<form id="employeeForm">
<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-99 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Request Office Internet
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </a>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <label>DEVICE TYPE:</label>
                <div style="display:flex; gap:30px">
                    <div class="flex items-center mb-4">
    <input id="country-option-1" type="radio" name="dtype" value="Mobile" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
    <label for="country-option-1" class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
      Mobile
    </label>
  </div>

  <div class="flex items-center mb-4">
    <input id="country-option-2" type="radio" name="dtype" value="Laptop/PC" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
    <label for="country-option-2" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
      Laptop/PC
    </label>
  </div>
                </div>
                 <label>DEVICE OWNERSHIP:</label>
                <div style="display:flex; gap:30px">
                  <div class="flex items-center mb-4">
    <input id="country-option-3" type="radio" name="downer" value="Personal"  class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
    <label for="country-option-3" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
     Personal
    </label>
  </div>

  <div class="flex items-center mb-4">
    <input id="country-option-4" type="radio" name="downer" value="Office" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus-ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
    <label for="country-option-4" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
      Office
    </label>
  </div>
                </div>
            <label>DEVICE NAME:</label><br>
            <input name="dname" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
            <label>MODEL NAME:</label><br>
            <input name="mname" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required /> 
            <label>S/N NUMBER:</label><br>
            <input name="srno" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
            <label>PHYSICAL ADDRESS(MAC):</label><br>
            <input name="mac" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
            <label>REASON:</label><br>
            <textarea name="reason" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a reason..."></textarea>
            </div>
            <input type="hidden" name="status" value="0" >
            <input type="hidden" name="empname" value="<?php echo $row['empname']; ?>" >
            <input type="hidden" name="empemail" value="<?php echo $row['empemail']; ?>" >
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>
</form>


            
          </div>
        </button>
      </div>
        <img class="frame-child65" alt="" src="./public1/line-39.svg" />
        <a href="./gatepasslog.php" style="margin-left: -210px;" class="frame-child66" id="rectangleLink"> </a>
        <a href="./gatepasslog.php" style="margin-left: -200px;" class="personal-details5" id="personalDetails">Gatepass Log</a>
        <a href="./personal-details.php" class="frame-child66" id="rectangleLink"> </a>
        <a href="./job.php" class="frame-child67" id="rectangleLink1"> </a>
        <a href="./directory.php" class="frame-child68" id="rectangleLink2"> </a>
        <a href="./salary.php" class="frame-child69" id="rectangleLink3"> </a>
        <a href="./personal-details.php" class="personal-details5" id="personalDetails">Personal Details</a>
        <a href="./job.php" class="job5" id="job">Job</a>
        <a href="./directory.php" class="document4" id="document">Document</a>
        <div class="dropdown">
  <a class="salary5" id="salary">Payroll
  <div class="dropdown-content1">
    <a href="./salary.php">Salary Details</a>
    <a href="payslip.php">Payslip</a>
    <a href="emploan.php">Employee Loan</a>
  </div>
  </a>
</div>
      </div>
      <a class="dashboard4" href="./employee-dashboard.php" id="dashboard">Dashboard</a>
      <a href="./employee-dashboard.php" class="akar-iconsdashboard4" id="akarIconsdashboard">
        <img class="vector-icon16" alt="" src="./public1/vector2.svg" />
      </a>
      <img class="logo-1-icon4" alt="" src="./public1/logo-1@2x.png" />
    </section>
  </body>

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
  <script>
    $(document).ready(function() {
        $('#employeeForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'insert_inet.php',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'employee-dashboard.php';
                            $('#employeeForm')[0].reset();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    const weekArray = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const monthArray = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    const current = new Date();
    const todaysDate = current.getDate();
    const currentYear = current.getFullYear();
    const currentMonth = current.getMonth();
    let holidaysData = [];

    async function fetchHolidaysAndGenerateCalendar() {
        let workLocation = "<?php echo $row['work_location']; ?>";
        let fetchUrl;

        if (workLocation === 'Visakhapatnam') {
            fetchUrl = 'fetchHolidays.php';
        } else if (workLocation === 'Gurugram') {
            fetchUrl = 'fetchHolidays_ggm.php';
        } else {
            console.error('Unknown work location:', workLocation);
            return;
        }

        try {
            const response = await fetch(fetchUrl);
            holidaysData = await response.json();
            updateCalendarWithHolidays(holidaysData);
            generateCalendarDays(new Date());
        } catch (error) {
            console.error('Error fetching holidays:', error);
        }
    }

    function updateCalendarWithHolidays(holidays) {
      console.log('Received holidays:', holidays);
      const holidayDates = holidays.map(holiday => holiday.date);
      console.log('Holiday dates:', holidayDates);
      const calendarDays = document.getElementsByClassName("calendar-day");

      Array.from(calendarDays).forEach((dayElement, index) => {
        const day = index + 1;
        const currentDate = new Date(currentYear, currentMonth, day);

        const matchingHoliday = holidays.find(holiday =>
          holiday.date === currentDate.toISOString().split('T')[0]
        );

        if (matchingHoliday) {
          console.log(`Adding holiday styles to day ${day}`);

          dayElement.style.backgroundColor = "#ffcccc";
          dayElement.style.color = "#cc0000";

          const holidayName = document.createElement("div");
          holidayName.textContent = matchingHoliday.name;
          holidayName.classList.add("holiday-name");

          holidayName.style.fontSize = "10px";
          holidayName.style.color = "#ff0000";
          holidayName.style.textAlign = "start";
          holidayName.style.position = "absolute";
          holidayName.style.transform = "translateX(-20%)";

          dayElement.appendChild(holidayName);
        }
      });
    }

    function applyHolidayStyles() {
      const holidayElements = document.querySelectorAll(".calendar-day-holiday");
      holidayElements.forEach(holidayElement => {
        holidayElement.classList.add("holiday-style");
      });

      const holidayNameElements = document.querySelectorAll(".holiday-name");
      holidayNameElements.forEach(nameElement => {
        nameElement.classList.add("holiday-name-style");
      });
    }

    window.onload = function() {
      const currentDate = new Date();
      generateCalendarDays(currentDate);

      let calendarWeek = document.getElementsByClassName("calendar-week")[0];
      let calendarTodayButton = document.getElementsByClassName("calendar-today-button")[0];
      calendarTodayButton.textContent = "Today";

      calendarTodayButton.addEventListener("click", () => {
        generateCalendarDays(currentDate);
      });

      weekArray.forEach((week) => {
        let li = document.createElement("li");
        li.textContent = week;
        li.classList.add("calendar-week-day");
        calendarWeek.appendChild(li);
      });

      const calendarMonths = document.getElementsByClassName("calendar-months")[0];
      const calendarYears = document.getElementsByClassName("calendar-years")[0];
      const monthYear = document.getElementsByClassName("calendar-month-year")[0];

      const selectedMonth = parseInt(monthYear.getAttribute("data-month") || 0);
      const selectedYear = parseInt(monthYear.getAttribute("data-year") || currentYear);

      monthArray.forEach((month, index) => {
        let option = document.createElement("option");
        option.textContent = month;
        option.value = index;
        option.selected = index === selectedMonth;
        calendarMonths.appendChild(option);
      });

      const startYear = currentYear - 60;
      const endYear = currentYear + 60;
      let newYear = startYear;
      while (newYear <= endYear) {
        let option = document.createElement("option");
        option.textContent = newYear;
        option.value = newYear;
        option.selected = newYear === selectedYear;
        calendarYears.appendChild(option);
        newYear++;
      }

      const leftArrow = document.getElementsByClassName("calendar-left-arrow")[0];

      leftArrow.addEventListener("click", () => {
        const monthYear = document.getElementsByClassName("calendar-month-year")[0];
        const month = parseInt(monthYear.getAttribute("data-month") || 0);
        const year = parseInt(monthYear.getAttribute("data-year") || currentYear);

        let newMonth = month === 0 ? 11 : month - 1;
        let newYear = month === 0 ? year - 1 : year;
        let newDate = new Date(newYear, newMonth, 1);
        generateCalendarDays(newDate);
      });

      const rightArrow = document.getElementsByClassName("calendar-right-arrow")[0];

      rightArrow.addEventListener("click", () => {
        const monthYear = document.getElementsByClassName("calendar-month-year")[0];
        const month = parseInt(monthYear.getAttribute("data-month") || 0);
        const year = parseInt(monthYear.getAttribute("data-year") || currentYear);
        let newMonth = month + 1;
        newMonth = newMonth === 12 ? 0 : newMonth;
        let newYear = newMonth === 0 ? year + 1 : year;
        let newDate = new Date(newYear, newMonth, 1);
        generateCalendarDays(newDate);
      });

      calendarMonths.addEventListener("change", function() {
        let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
        generateCalendarDays(newDate);
      });

      calendarYears.addEventListener("change", function() {
        let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
        generateCalendarDays(newDate);
      });

      fetchHolidaysAndGenerateCalendar();
    };

    function generateCalendarDays(currentDate) {
      const newDate = new Date(currentDate);
      const year = newDate.getFullYear();
      const month = newDate.getMonth();
      const totalDaysInMonth = getTotalDaysInAMonth(year, month);
      const firstDayOfWeek = getFirstDayOfWeek(year, month);
      let calendarDays = document.getElementsByClassName("calendar-days")[0];

      removeAllChildren(calendarDays);

      let firstDay = 1;
      while (firstDay <= firstDayOfWeek) {
        let li = document.createElement("li");
        li.classList.add("calendar-day");
        calendarDays.appendChild(li);
        firstDay++;
      }

      let day = 1;
      while (day <= totalDaysInMonth) {
        let li = document.createElement("li");
        li.textContent = day;
        li.classList.add("calendar-day");
        if (todaysDate === day && currentMonth === month && currentYear === year) {
          li.classList.add("calendar-day-active");
        }
        calendarDays.appendChild(li);

        const matchingHoliday = holidaysData.find(holiday =>
          holiday.date === new Date(Date.UTC(year, month, day)).toISOString().split('T')[0]
        );

        if (matchingHoliday) {
          li.classList.add("calendar-day-holiday");
          const holidayName = document.createElement("div");
          holidayName.textContent = matchingHoliday.name;
          holidayName.classList.add("holiday-name");
          li.appendChild(holidayName);
        }

        day++;
      }

      const monthYear = document.getElementsByClassName("calendar-month-year")[0];
      monthYear.setAttribute("data-month", month);
      monthYear.setAttribute("data-year", year);
      const calendarMonths = document.getElementsByClassName("calendar-months")[0];
      const calendarYears = document.getElementsByClassName("calendar-years")[0];
      calendarMonths.value = month;
      calendarYears.value = year;
    }

    function getTotalDaysInAMonth(year, month) {
      return new Date(year, month + 1, 0).getDate();
    }

    function getFirstDayOfWeek(year, month) {
      return new Date(year, month, 1).getDay();
    }

    function removeAllChildren(parent) {
      while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
      }
    }
</script>

  <script>
    function addValue(date) {
      var inputField = document.querySelector('input[name="input_value_' + date + '"]');
      var inputValue = inputField.value;

      // Make an AJAX request to the server-side PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "insert_holiday.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            console.log('Input value for ' + date + ': ' + inputValue);

            // Update the input field with the added value
            inputField.value = xhr.responseText;

            // Change action buttons to update and delete
            var actionButtons = document.querySelector('td button');
            actionButtons.innerHTML = '<button onclick="updateValue(\'' + date + '\')">Update</button>' +
              '<button onclick="deleteValue(\'' + date + '\')">Delete</button>';

            // Show SweetAlert for success
            Swal.fire({
              title: 'Success!',
              text: 'Holiday  added successfully.',
              icon: 'success',
              timer: 2000, // Close after 2 seconds
              showConfirmButton: false
            }).then(() => {
              window.location.href = 'holiday.php';
            });
          } else {
            // Show SweetAlert for error
            Swal.fire({
              title: 'Error!',
              text: 'Failed to add value.',
              icon: 'error'
            });
          }
        }
      };

      // Send the input value and date to the server-side script
      xhr.send("date=" + date + "&value=" + inputValue);
    }

    function updateValue(date) {
      var inputField = document.querySelector('input[name="input_value_' + date + '"]');
      var updatedValue = inputField.value;

      // Make an AJAX request to the server-side PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "update_holiday.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            console.log('Update value for ' + date + ': ' + updatedValue);

            // Show SweetAlert for success
            Swal.fire({
              title: 'Success!',
              text: 'Holiday updated successfully.',
              icon: 'success',
              timer: 2000, // Close after 2 seconds
              showConfirmButton: false
            }).then(() => {
              window.location.href = 'holiday.php';
            });
          } else {
            // Show SweetAlert for error
            Swal.fire({
              title: 'Error!',
              text: 'Failed to update value.',
              icon: 'error'
            });
          }
        }
      };

      // Send the updated value and date to the server-side script
      xhr.send("date=" + date + "&value=" + updatedValue);
    }

    function deleteValue(date) {
      // Make an AJAX request to the server-side PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "delete_holiday.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            console.log('Delete value for ' + date);

            // Update the input field with an empty value
            var inputField = document.querySelector('input[name="input_value_' + date + '"]');
            inputField.value = '';

            // Change action buttons back to add
            var actionButtons = document.querySelector('td button');
            actionButtons.innerHTML = '<button onclick="addValue(\'' + date + '\')">Add</button>';

            // Show SweetAlert for success
            Swal.fire({
              title: 'Success!',
              text: 'Holiday deleted successfully.',
              icon: 'success',
              timer: 2000, // Close after 2 seconds
              showConfirmButton: false
            }).then(() => {
              window.location.href = 'holiday.php';
            });

          } else {
            // Show SweetAlert for error
            Swal.fire({
              title: 'Error!',
              text: 'Failed to delete value.',
              icon: 'error'
            });
          }
        }
      };

      // Send the date to the server-side script for deletion
      xhr.send("date=" + date);
    }

    function autocomplete(inp, arr) {
      var currentFocus;

      inp.addEventListener("input", function(e) {
        closeAllLists();
        if (!this.value) {
          return false;
        }

        currentFocus = -1;

        var a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        this.parentNode.appendChild(a);

        for (var i = 0; i < arr.length; i++) {
          if (arr[i].substr(0, this.value.length).toUpperCase() == this.value.toUpperCase()) {
            var b = document.createElement("DIV");
            b.innerHTML = "<strong>" + arr[i].substr(0, this.value.length) + "</strong>";
            b.innerHTML += arr[i].substr(this.value.length);
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              closeAllLists();
            });
            a.appendChild(b);
          }
        }
      });

      inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          currentFocus++;
          addActive(x);
        } else if (e.keyCode == 38) {
          currentFocus--;
          addActive(x);
        } else if (e.keyCode == 13) {
          e.preventDefault();
          if (currentFocus > -1) {
            if (x) x[currentFocus].click();
          }
        }
      });

      function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
      }

      function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
          x[i].classList.remove("autocomplete-active");
        }
      }

      function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
          if (elmnt != x[i] && elmnt != inp) {
            x[i].parentNode.removeChild(x[i]);
          }
        }
      }

      document.addEventListener("click", function(e) {
        closeAllLists(e.target);
      });
    }

    var holidays = ["Sankranti", "Bhogi", "Holiday", "YSS", "OKOK"];

    <?php foreach ($dates as $date) : ?>
      autocomplete(document.getElementById("input_<?php echo $date; ?>"), holidays);
    <?php endforeach; ?>
  </script>

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
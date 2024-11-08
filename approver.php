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

$query = "SELECT user_type,user_type1 FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];

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

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/apply-leave.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
      /* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
}
 
::-webkit-scrollbar-track {
    background-color: #ebebeb;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #cacaca; 
}
    </style>
  </head>
  <body>
    <div class="applyleave">
      <div class="bg7"></div>
    
      <div class="rectangle-parent9" style="margin-left: 120px;">
        <div class="frame-child101"></div>
        <a class="frame-child102" href="leave-management.php"> </a>
        <a class="frame-child103" id="rectangleLink2" style="background-color: bisque;"> </a>        <a href="./leave-type.php" class="frame-child103" style="margin-left: -470px;" id="rectangleLink1"> </a>
        <a class="frame-child104" id="rectangleLink1" style="background-color: #e8e8e8;"> </a>
        <a class="frame-child105" id="rectangleLink3" > </a>
        <a class="leaves-list2" href="leave-management.php" style="margin-top:-4px;">Leaves List</a>
        <a class="assign-leave1"  style="color:orangered; margin-left:10px; margin-top:-4px;">Approvers</a>        <a href="./leave-type.php" class="assign-leave1" style="margin-left: -485px; width: 200px; margin-top:-4px;" id="assignLeave">New Leave Type</a>
        <a class="apply-leave1" id="applyLeave" style="color:black; margin-top:-4px;" href="./apply-leave.php">Apply Leave</a>
        <a class="my-leaves1" id="myLeaves" style="margin-top:-4px;">My Leaves</a>
      </div>
      <img class="applyleave-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="applyleave-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon7" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm7" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm7">HRM</span>
      </a>
      <a class="leave-management1" href="./index.php" id="leaveManagement"
        >Leave Management</a
      >
      
      <button class="applyleave-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
      <a class="onboarding9" id="onboarding">Onboarding</a>
      <a class="attendance7" id="attendance">Attendance</a>
      <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll7">Payroll</a>
      <div class="reports7">Reports</div>
      <a class="fluent-mdl2leave-user7" id="fluentMdl2leaveUser">
        <img class="vector-icon37" alt="" src="./public/vector.svg" />
      </a>
      <img class="uitcalender-icon7" alt="" src="./public/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay7"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon7"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="applyleave-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon7"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img class="applyleave-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard7" href="./index.php" id="dashboard">Dashboard</a>
      <a class="fluentpeople-32-regular7" id="fluentpeople32Regular">
        <img class="vector-icon38" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list7" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard7"
        href="./index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon39" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon7" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender7" id="uitcalender">
        <img class="vector-icon40" alt="" src="./public/vector4.svg" />
      </a>
      <a class="leaves7" href="leave-management.php">Leaves</a>
      <a class="fluentperson-clock-20-regular7">
        <img class="vector-icon41" alt="" src="./public/vector10.svg" />
      </a>
      <div class="rectangle-parent10" style="margin-left: 270px;">
        <div class="frame-child106" style="width: 800px; height: 360px; border-radius: 20px;"></div>
        <label class="employee-name2" style="margin-top: -15px;">Approver Name</label>
        <label class="employee-name2" style="margin-top:80px;">Approver Email</label>
        <h3 class="apply-leave2">Add Approver</h3>
        <img class="frame-child107" style="width: 750px;" alt="" src="./public/line-121@2x.png" />
        <form id="updateForm">
        <input class="frame-child108" type="text" name="aprname" style="height: 40px; margin-top: -15px; font-size:18px" oninput="convertToUpperCase(this)"/>
        <input class="frame-child108" style="margin-top: 80px; height: 40px;font-size:18px" type="email" name="apremail" />
 
        <button class="frame-child112" style="margin-top: -380px; margin-left: -400px;"></button>
        <a class="apply" style="margin-top: -380px; margin-left: -390px;">Add</a>
</form>
<table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="margin-top: 400px; width:800px;">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          Approver Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Approver Email
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Delete
                      </th>
                  </tr>
              </thead>
          <?php
    $sql = "SELECT * FROM approver  ORDER BY id DESC";
    $que = mysqli_query($con, $sql);
    $cnt = 1;
    while ($result = mysqli_fetch_assoc($que)) {
        ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4"><?php echo $result['aprname']; ?></td>
            <td class="px-6 py-4"><?php echo $result['apremail']; ?></td>
            <td  class="px-6 py-4">
                <a href="delete_apr.php?id=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure you want to delete this Approver?');"><svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="#FB8A0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
            </td>
        </tr>
        <?php $cnt++;
    } ?>
        </table>
      </div>
     
    </div>
    <script>
    function convertToUpperCase(inputElement) {
        inputElement.value = inputElement.value.toUpperCase();
    }
</script>
<script>
    $(document).ready(function () {

        $("#updateForm").submit(function (e) {
            e.preventDefault();

            var aprname = $("input[name='aprname']").val();
            var apremail = $("input[name='apremail']").val();

            $.ajax({
                type: "POST",
                url: "add_approver.php",
                data: { aprname: aprname, apremail:apremail}, 
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: ' added!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'approver.php';
                        }
                    });

                    $("input[name='aprname']").val();
                    $("input[name='apremail']").val();
                }
            });
        });
    });
</script>
    <script>
      var rectangleLink = document.getElementById("rectangleLink");
      if (rectangleLink) {
        rectangleLink.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function (e) {
          window.location.href = "./assign-leave.php";
        });
      }
      
      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function (e) {
          window.location.href = "./my-leaves.php";
        });
      }
      
      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var applyLeave = document.getElementById("applyLeave");
      if (applyLeave) {
        assignLeave.addEventListener("click", function (e) {
          window.location.href = "./assign-leave.php";
        });
      }
      
      var myLeaves = document.getElementById("myLeaves");
      if (myLeaves) {
        myLeaves.addEventListener("click", function (e) {
          window.location.href = "./my-leaves.php";
        });
      }
      
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var leaveManagement = document.getElementById("leaveManagement");
      if (leaveManagement) {
        leaveManagement.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      </script>
  </body>
</html>
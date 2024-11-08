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
    <link rel="stylesheet" href="./css/records.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
       <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
         .content {
            display: none;
        }
        .show {
            display: block;
        }
/*        table {*/
/*        z-index: 100;*/
/*  border-collapse: collapse;*/
  /* border-radius: 200px; */
/*  background-color: white;*/
/*   overflow: hidden; */
/*}*/

/*th, td {*/
/*  padding: 1em;*/
/*  background: white;*/
/*  color: rgb(52, 52, 52);*/
/*  border-bottom: 2px solid rgb(193, 193, 193); */
/*}*/
.container {
    padding-bottom: 20px;
    margin-right: -350px;
}

.input-text:focus{
    box-shadow: 0px 0px 0px;
    border-color:#fd7e14;
    outline: 0px;
}
.form-control {
    border: 1px solid #fd7e14;
}
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
    <div class="records3">
      <div class="bg13"></div>
      <img class="records-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="records-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon13" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm13" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm13">HRM</span>
      </a>
      <a
        class="attendence-management3"
        href="./index.php"
        id="attendenceManagement"
        >Dashboard/Designation-Shifts</a
      >
      <button class="records-inner"></button>
      <div class="logout13">Logout</div>
      <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll13">Payroll</a>
      <div class="reports13">Reports</div>
      <img class="uitcalender-icon13" alt="" src="./public/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay13"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon13"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="records-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon13"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img class="records-child2" style="margin-top: -262px;" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard13" href="./index.php" style="color: white;" id="dashboard">Dashboard</a>
      <a class="fluentpeople-32-regular13" id="fluentpeople32Regular">
        <img class="vector-icon67" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list13" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard13"
        href="./index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon68"  style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon13" alt="" src="./public/tablerlogout.svg" />

      <a class="leaves13" id="leaves">Leaves</a>
      <a
        class="fluentperson-clock-20-regular13"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon69" alt="" src="./public/vector1.svg" />
      </a>
      <a class="onboarding15" id="onboarding">Onboarding</a>
      <a class="fluent-mdl2leave-user13" id="fluentMdl2leaveUser">
        <img class="vector-icon70" alt="" src="./public/vector.svg" />
      </a>
      <a class="attendance13" style="color: black;" href="./attendence.php">Attendance</a>
      <a class="uitcalender13">
        <img class="vector-icon71" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
      </a>
      <div class="oouinext-ltr1"></div>
      <div class="rectangle-parent21" style="margin-top: -70px;">
        <div class="frame-child176"></div>
        <div class="oouinext-ltr2"></div>
        <div class="employee-records">Designation-Shifts</div>
        <div class="frame-child178"></div>
        <form id="updateForm">
        <div class="employee-name7">Designation</div>
        <div class="designation4">Number of Shifts</div>
        <input class="frame-child181" style="font-size: 20px; border-radius:10px; height: 40px;" type="text" name="desg"  oninput="convertToUpperCase(this)"/>
        
       <div id="div1" class="content">
        <div class="to-date3" style="margin-left: -350px;">Shift-1 To Time</div>
        <div class="from-date3">Shift-1 From Time</div>

   
        <input class="frame-child182" style="font-size: 20px; height: 35px; width: 150px;" type="time" name="fromshifttime1" />
        <input class="frame-child184" style="font-size: 20px; height: 35px; width: 150px;margin-left: -350px;" type="time" name="toshifttime1"/>
       </div>
        
        <select style="font-size: 20px; height: 40px;" class="frame-child183" id="dropdown" name="shifts" onchange="showContent()"> 
            <option value="" >--select--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>

      <div id="div2" class="content">
        <div class="from-date3" style="margin-left: 543px;">Shift-2 From Time</div>
        <div class="to-date3" style="margin-left: 200px;">Shift-2 To Time</div>
        <input class="frame-child182" style="font-size: 20px; height: 35px; width: 150px; margin-left: 543px;" type="time"  name="fromshifttime2"/>
        <input class="frame-child184" style="font-size: 20px; height: 35px; width: 150px;margin-left: 200px;" type="time" name="toshifttime2"/>
      </div>
       <div id="div3" class="content">
        <div class="from-date3" style="margin-top: 90px;">Shift-3 From Time</div>
        <div class="to-date3" style="margin-left: -350px; margin-top: 90px;">Shift-3 To Time</div>
        <input class="frame-child182" style="font-size: 20px; height: 35px; width: 150px; margin-top: 90px;" type="time" name="fromshifttime3"/>
        <input class="frame-child184" style="font-size: 20px; height: 35px; width: 150px;margin-left: -350px;margin-top: 90px;" type="time" name="toshifttime3"/>
       </div>

        <button class="frame-child185" style="color:white; font-size:25px;">Save</button>
</form>
      <div class="container" style="margin-top:400px; ">
    <div class="row">
       <div class="col-md-8">
           <div class="input-group mb-3" style="width:400px">
  <input type="text" class="form-control input-text"id="filterInput" onkeyup="filterTable()" placeholder="Search for designation...">
  <div class="input-group-append" style="background:white;">
    <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
  </div>
</div>
       </div>        
    </div>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="margin-top:-30px; overflow-y: auto; height:430px;">
<table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable" style="margin-left:auto; margin-right:auto;">
   <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          Designation
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Number of Shifts
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Shift Timings
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Delete
                      </th>
                  </tr>
              </thead>
    <?php
    $sql = "SELECT * FROM dept  ORDER BY id DESC";
    $que = mysqli_query($con, $sql);
    $cnt = 1;
    while ($result = mysqli_fetch_assoc($que)) {
        ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
            <td class="px-6 py-4"><?php echo $result['shifts']; ?></td>
            <td class="px-6 py-4">
                <?php
                if ($result['fromshifttime1'] != '00:00:00' && $result['toshifttime1'] != '00:00:00') {
                    echo $result['fromshifttime1'] . ' to ' . $result['toshifttime1'] . '<br>';
                }
                if ($result['fromshifttime2'] != '00:00:00' && $result['toshifttime2'] != '00:00:00') {
                    echo $result['fromshifttime2'] . ' to ' . $result['toshifttime2'] . '<br>';
                }
                if ($result['fromshifttime3'] != '00:00:00' && $result['toshifttime3'] != '00:00:00') {
                    echo $result['fromshifttime3'] . ' to ' . $result['toshifttime3'];
                }
                ?>
            </td>
            <td class="px-6 py-4">
                <a href="delete_shift.php?id=<?php echo $result['ID']; ?>" onclick="return confirm('Are you sure you want to delete this Shift?');"><svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="#FB8A0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
            </td>
        </tr>
        <?php $cnt++;
    } ?>
</table>


    </div>
    <script>
function filterTable() {
    var input = document.getElementById('filterInput');
    var filter = input.value.toUpperCase();

    var table = document.getElementById('attendanceTable');

    var rows = table.getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var shouldShow = false;

        if (i === 0) {
            shouldShow = true;
        } else {
            for (var j = 0; j < cells.length; j++) {
                var cell = cells[j];

                var isHeaderCell = cell.classList.contains('static-cell');

                if (!isHeaderCell) {
                    var txtValue = cell.textContent || cell.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        shouldShow = true;
                        break;
                    }
                }
            }
        }

        if (shouldShow) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

</script>
    <script>
    function convertToUpperCase(inputElement) {
        inputElement.value = inputElement.value.toUpperCase();
    }
</script>
    <script>
    $(document).ready(function () {

        $("#updateForm").submit(function (e) {
            e.preventDefault();

            var desg = $("input[name='desg']").val();
            var shifts = $("select[name='shifts']").val();
            var fromshifttime1 = $("input[name='fromshifttime1']").val();
            var toshifttime1 = $("input[name='toshifttime1']").val();
            var fromshifttime2 = $("input[name='fromshifttime2']").val();
            var toshifttime2 = $("input[name='toshifttime2']").val();
            var fromshifttime3 = $("input[name='fromshifttime3']").val();
            var toshifttime3 = $("input[name='toshifttime3']").val();

            $.ajax({
                type: "POST",
                url: "desg.php",
                data: { desg: desg, shifts: shifts, fromshifttime1: fromshifttime1, fromshifttime2: fromshifttime2, fromshifttime3: fromshifttime3,toshifttime1:toshifttime1,toshifttime2:toshifttime2,toshifttime3:toshifttime3 }, 
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Shift added!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'designation.php';
                        }
                    });

                    $("input[name='desg']").val('');
                    $("select[name='shifts']").val();
                    $("input[name='fromshifttime1']").val();
                    $("input[name='toshifttime1']").val();
                    $("input[name='fromshifttime2']").val();
                    $("input[name='toshifttime2']").val();
                    $("input[name='fromshifttime3']").val();
                    $("input[name='toshifttime3']").val();
                }
            });
        });
    });
</script>
<script>
    function showContent() {
            var divs = document.getElementsByClassName("content");
            for (var i = 0; i < divs.length; i++) {
                divs[i].classList.remove("show");
            }
            var selectedOption = document.getElementById("dropdown").value;
            for (var i = 1; i <= selectedOption; i++) {
                var currentDiv = document.getElementById("div" + i);
                currentDiv.classList.add("show");
            }
        }
</script>
    <script>
      var rectangleLink = document.getElementById("rectangleLink");
      if (rectangleLink) {
        rectangleLink.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      
      var rectangleLink2 = document.getElementById("rectangleLink2");
      if (rectangleLink2) {
        rectangleLink2.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function (e) {
          window.location.href = "./my-attendence.php";
        });
      }
      
      var attendence = document.getElementById("attendence");
      if (attendence) {
        attendence.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      
      var punchINOUT = document.getElementById("punchINOUT");
      if (punchINOUT) {
        punchINOUT.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var myAttendence = document.getElementById("myAttendence");
      if (myAttendence) {
        myAttendence.addEventListener("click", function (e) {
          window.location.href = "./my-attendence.php";
        });
      }
      
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var attendenceManagement = document.getElementById("attendenceManagement");
      if (attendenceManagement) {
        attendenceManagement.addEventListener("click", function (e) {
          window.location.href = "./index.php";
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
      
      var leaves = document.getElementById("leaves");
      if (leaves) {
        leaves.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      </script>
  </body>
</html>
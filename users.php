<?php
session_start();
@include 'inc/config.php';
$currentDate = date("Y-m-d");
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}


// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module name from the URL (assuming the module pages have a parameter in the URL)
$module_name = basename($_SERVER['PHP_SELF']);

// Sanitize module name to prevent directory traversal attacks
$module_name = mysqli_real_escape_string($con, $module_name);

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the module is linked to the user
$sql = "SELECT COUNT(*) AS count FROM user_modules INNER JOIN modules ON user_modules.module_id = modules.id INNER JOIN user_form ON user_modules.email = user_form.email WHERE user_form.email = '$email' AND modules.module_name = '$module_name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    // If the module is not linked to the user, redirect to the login page
    header("Location: loginpage.php");
    exit();
}

// Fetch all users
$sql_users = "SELECT * FROM user_form";
$result_users = mysqli_query($con, $sql_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Fetch all modules
$sql_modules = "SELECT * FROM modules";
$result_modules = mysqli_query($con, $sql_modules);
$modules = mysqli_fetch_all($result_modules, MYSQLI_ASSOC);

// Fetch user-module associations
$user_module_associations = array();
$sql_user_modules = "SELECT * FROM user_modules";
$result_user_modules = mysqli_query($con, $sql_user_modules);
while ($row = mysqli_fetch_assoc($result_user_modules)) {
    $user_module_associations[$row['email']][] = $row['module_id'];
}

?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["purpose"])) {
        $email = $_POST["email"];
        $purpose = $_POST["purpose"];
        $insert_query = "INSERT INTO mail_log (email, purpose) VALUES ('$email', '$purpose')";
        mysqli_query($con, $insert_query);
    }
?>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/onboarding.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
/*      table {*/
/*        margin-left: 150px;*/
/*        z-index: 100;*/
/*  border-collapse: collapse;*/
/*  background-color: white;*/
/*}*/

/*th, td {*/
/*  padding: 1em;*/
/*  background: white;*/
/*  color: rgb(52, 52, 52);*/
/*  border-bottom: 2px solid rgb(193, 193, 193); */
/*}*/
.container {
    padding-bottom: 20px;
    display:flex;
    justify-content:center;
    gap:200px;
}

.input-text:focus{
    box-shadow: 0px 0px 0px;
    border-color:#fd7e14;
    outline: 0px;
}
.form-control {
    border: 1px solid #fd7e14;
}
    </style>
  </head>
  <body>
    <div class="onboarding17">
      <div class="bg15"></div>
      <img class="onboarding-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="onboarding-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon15" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm15" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm15">HRM</span>
      </a>
      <a class="onboarding18" href="./index.php" id="onboarding"
        >HR Management</a
      >
      <a class="onboarding18" style="margin-left: 300px;" href="./index.php" id="onboarding"
        >/Users</a
      >
      <button class="onboarding-inner"></button>
      <div class="logout15">Logout</div>
      <a class="attendance15" id="attendance" href="./attendence.php">Attendance</a>
      <div class="payroll15">Payroll</div>
      <div class="reports15">Reports</div>
      <img class="uitcalender-icon15" alt="" src="./public/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay15"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon15"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="onboarding-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon15"-->
      <!--  alt=""-->

      <img class="onboarding-child2" style="margin-top: -200px;" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard15" href="./index.php" id="dashboard" style="color: white;">Dashboard</a>
      <a class="fluentpeople-32-regular15" id="fluentpeople32Regular">
        <img class="vector-icon78" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list15" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard15"
        href="./index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon79" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon15" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender15" id="uitcalender">
        <img class="vector-icon80" alt="" src="./public/vector4.svg" />
      </a>
      <a class="leaves15" id="leaves">Leaves</a>
      <a
        class="fluentperson-clock-20-regular15"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon81" alt="" src="./public/vector1.svg" />
      </a>
      <a class="onboarding19" style="color: black;" href="./onboarding.php">Onboarding</a>
      <a class="fluent-mdl2leave-user15">
        <img class="vector-icon82" alt="" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" src="./public/vector8.svg" />
      </a>
            <div class="container" style="margin-top:100px">
    <div class="row">
       <div class="col-md-8">
           <div class="input-group mb-3" style="width:400px">
  <input type="text" class="form-control input-text"id="filterInput" onkeyup="filterTable()" placeholder="Search for employee name...">
  <div class="input-group-append" style="background:white;">
    <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
  </div>
</div>
       </div>        
    </div>
    <div style="position:absolute; right:100px;">
    <a href="loggedin.php">
        <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Logged in users</button>
</a>
      </div>
</div>
      <div class="rectangle-parent24" style="margin-top:40px; overflow-y:auto;">
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"  id="attendanceTable" style="margin-left:auto; margin-right:auto;">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          Emp. Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Login Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Login ID
                      </th>
                      <th scope="col" class="px-6 py-3">
                          User Type
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Send Login Link
                      </th>
                  </tr>
              </thead>
    <?php
$sql = "SELECT user_form.*, IFNULL(emp.empname, '(admin acc)') AS display_name
FROM user_form
LEFT JOIN emp ON user_form.email = emp.empemail
WHERE user_form.empstatus = '0'
ORDER BY user_form.id DESC";

    $que = mysqli_query($con, $sql);
    $cnt = 1;
    while ($result = mysqli_fetch_assoc($que)) {
    ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4"><?php echo isset($result['display_name']) ? $result['display_name'] : '(admin acc)'; ?></td>
            <td class="px-6 py-4"><?php echo $result['name']; ?></td>
            <td class="px-6 py-4"><?php echo $result['email']; ?></td>
            <td class="px-6 py-4"><?php echo $result['user_type']; ?></td>
            <input type="hidden" name="purpose" value="for login link.">
            <td class="px-6 py-4"><a href="#" class="send-login-link" data-email="<?php echo $result['email']; ?>" style="text-decoration: none; color: goldenrod;"><img width="55px;" src="public/send_icon123.png" alt=""></a></td>
          
        </tr>

    <?php
        $cnt++;
    }
    ?>
</table>

       

        
      </div>
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
            document.addEventListener("DOMContentLoaded", function () {
                const sendLoginLinks = document.querySelectorAll(".send-login-link");

                sendLoginLinks.forEach(function (link) {
                    link.addEventListener("click", function (event) {
                        event.preventDefault();
                        const email = this.getAttribute("data-email");
                        const purpose = "for login link.";

                        // Send the data to the server using AJAX
                        const xhr = new XMLHttpRequest();
                        const formData = new FormData();
                        formData.append("email", email);
                        formData.append("purpose", purpose);

                        xhr.open("POST", window.location.href, true);
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Handle the response from the server if needed
                                // ...
                            }
                        };

                        xhr.send(formData);
                    });
                });
            });
        </script>
    <script>
    $(document).ready(function () {
        $(".send-login-link").click(function (e) {
            e.preventDefault();

            var email = $(this).data("email");

            Swal.fire({
                title: 'Sending login link...',
                text: 'Hold on for a bit.',
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "POST",
                url: "send_login_link.php", 
                data: { email: email },
                success: function (response) {
                    Swal.close();

                    if (response.includes("success")) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login link sent successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while sending the login link.'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.'
                    });
                }
            });
        });
    });
</script>


    <script>
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function (e) {
          window.location.href = "./attendence.html";
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
          window.location.href = "./leave-management.html";
        });
      }
      
      var akarIconsedit9 = document.getElementById("akarIconsedit9");
      if (akarIconsedit9) {
        akarIconsedit9.addEventListener("click", function (e) {
          window.location.href = "./employee-approval.html";
        });
      }
      </script>
  </body>
</html>

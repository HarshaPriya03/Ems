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

    <link rel="stylesheet" href="./css/map.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
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
input,select{
    font-size:20px;
}
.container {
    padding-bottom: 20px;
    /*margin-right: -120px;*/
    display: flex;
    justify-content:center;
    
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  </head>
  <body>
    <div class="biometricmap">
      <div class="bg"></div>
      <img
        class="biometricmap-child"
        alt=""
        src="./public/rectangle-1@2x.png"
      />

      <div class="biometric-mapping">/Biometric Mapping</div>
      <img class="biometricmap-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm">
        <span>Anika</span>
        <span class="hrm">HRM</span>
      </a>
      <h5 class="hr-management">HR Management</h5>
      <button class="biometricmap-inner" autofocus="{true}"></button>
      <div class="logout">Logout</div>
      <a class="employee-list" href="./employee-management.php">Employee List</a>
      <a class="leaves" href="./leave-management.php">Leaves</a>
      <a class="onboarding" href="./onboarding.php">Onboarding</a>
      <a class="attendance" href="./attendence.php">Attendance</a>
      <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll">Payroll</a>
      <div class="reports">Reports</div>
      <a class="fluentpeople-32-regular" style="margin-top:130px;">
        <img class="vector-icon" alt="" src="./public/vector.svg" />
      </a>
      <a class="fluent-mdl2leave-user" style="margin-top:-65px;">
        <img class="vector-icon1" alt="" src="./public/vector1.svg" />
      </a>
      <a class="fluentperson-clock-20-regular" style="margin-top:-65px;">
        <img class="vector-icon2" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector2.svg" />
      </a>
      <a class="uitcalender" style="margin-top:-260px; z-index:9999;-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);">
        <img class="vector-icon3" alt="" src="./public/vector3.svg" />
      </a>
      <img
        class="arcticonsgoogle-pay"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="ellipse-icon" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

    <a href="./index.php">  <img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" /></a>

      <a href="./index.php" class="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard" style="margin-top:263px;" >
        <img class="vector-icon4" alt="" src="./public/vector4.svg" />
      </a>
      <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

      <div class="frame-div"></div>
      <div class="rectangle-div"></div>
      <div class="container" style="margin-top:500px;">
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
</div>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="position: absolute; margin-left:420px; margin-top: -20px; overflow-y:auto; height:410px; width:1180px;"> 

          <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"  id="attendanceTable" > 
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" style="scale:0.9;">
                      <div>
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                  <li class="me-2">
                    <a href="./Reports/map_report.php" class="inline-flex items-center justify-center  text-blue-600  border-b-2 border-blue-600 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">

                      <svg class="w-6 h-6 me-2 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                      </svg>

                      UserID Mapping Report
                    </a>
                  </li>
                  </div>
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Employee ID
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Employee Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                          CAMS User ID
                      </th>
                      <th scope="col" class="px-6 py-3">
                          CAMS instrument location
                      </th>
                  </tr>
              </thead>
        <?php
         if ($work_location == 'All') {
           $sql = "SELECT * FROM emp WHERE empstatus = 0 AND UserID != 0 
           ORDER BY UserID ASC";
      } else {
        $sql = "SELECT * FROM emp WHERE empstatus = 0 AND UserID != 0 
           AND work_location = '$work_location'
           ORDER BY UserID ASC";
           }
           

        $que = mysqli_query($con, $sql);
        $cnt = 1;
        while ($result = mysqli_fetch_assoc($que)) {
        ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="px-6 py-4"><img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td>
          <td class="px-6 py-4"><?php echo $result['emp_no']; ?></td>
          <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
          <td class="px-6 py-4">
<?php
echo $result['UserID']; 
if (isset($result['UserID1'])) {
    echo '<br>' . ($result['UserID1'] === NULL ? '' : $result['UserID1']);
}
?>



</td>

          <td class="px-6 py-4">
    <?php 
    if ($result['ServiceTagId'] === 'ZXQI19009096') {
        echo 'ZXQI19009096 - VSP';
    } elseif ($result['ServiceTagId'] === 'ZYSA07001899') {
        echo 'ZYSA07001899 - GGM';
    } else {
        echo $result['ServiceTagId'];
    }
    ?>
    <br>
    <?php 
    if ($result['ServiceTagId1'] === 'ZXQI19009096') {
        echo 'ZXQI19009096 - VSP';
    } elseif ($result['ServiceTagId1'] === 'ZYSA07001899') {
        echo 'ZYSA07001899 - GGM';
    } else {
        echo $result['ServiceTagId1'];
    }
    ?>
</td>

        </tr>
        <?php $cnt++;
        } ?>
      </table>

      </div>




   <h3 class="userid-mapping" style="width:300px;">CAMS UserID Mapping</h3>
      <img class="line-icon" alt="" src="./public/line-12@2x.png" />
      <label class="employee-name">Employee Name</label>
      <label class="employee-name" style="margin-top:110px;width:200px;">Select CAMS Location</label>
      <label class="user-id">UserID</label>
      <form id="updateForm">
        <select name="employee" class="rectangle-input" id="employeeSelect">
            <option value="">--select--</option>
            <?php
                $sql = "SELECT empname FROM emp WHERE empstatus=0";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["empname"] . "'>" . $row["empname"] . "</option>";
                    }
                } else {
                    echo "0 results";
                }

            ?>
        </select>
        <select name="ServiceTagId" style="margin-top:110px" class="rectangle-input" id="serviceTagSelect">
            <option value="">--select--</option>
            <option value="ZXQI19009096">Visakhapatnam (VSP)</option>
            <option value="ZYSA07001899">Gurugram (GGM)</option>
        </select>
        <input class="biometricmap-child1" style="border-radius:10px;" type="text" placeholder="Enter CAMS UserID" name="UserID" />
        <input class="biometricmap-child1" style="margin-top:120px" type="checkbox" name="check" id="multiLocationCheck" />
        <label class="user-id" style="margin-top:150px; margin-left:30px; width:400px;">
            Check this box if the employee works at multiple locations or for secondary mapping
        </label>
        <button class="rectangle-button" id="rectangleButton1" style="margin-left:100px;width:140px;color:white; font-size:25px;">Map</button>
    </form>

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
      var rectangleButton1 = document.getElementById("rectangleButton1");
      if (rectangleButton1) {
        rectangleButton1.addEventListener("click", function (e) {
        });
      }
      
      var map = document.getElementById("map");
      if (map) {
        map.addEventListener("click", function (e) {
        });
      }
      </script>
 <script>
        $(document).ready(function(){
            $("#updateForm").submit(function(e){
                e.preventDefault();

                var selectedEmployee = $("#employeeSelect").val();
                var userId = $("input[name='UserID']").val();
                var serviceTagId = $("#serviceTagSelect").val();
                var isMultiLocation = $("#multiLocationCheck").is(":checked");

                $.ajax({
                    type: "POST",
                    url: "update_userid.php", 
                    data: { 
                        employee: selectedEmployee, 
                        userId: userId, 
                        serviceTagId: serviceTagId,
                        isMultiLocation: isMultiLocation
                    },
                    success: function(response){
                        Swal.fire({
                            icon: 'success',
                            title: 'UserID Mapped!',
                            text: response,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'map.php';
                            }
                        });

                        $("#employeeSelect").val('');
                        $("input[name='UserID']").val('');
                    }
                });
            });
        });
    </script>
  </body>
</html>

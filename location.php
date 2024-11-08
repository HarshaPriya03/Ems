<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/map.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
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

    input,
    select {
      font-size: 20px;
    }

    .container {
      padding-bottom: 20px;
      display: flex;
      justify-content: center;

    }

    .input-text:focus {
      box-shadow: 0px 0px 0px;
      border-color: #fd7e14;
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
    <img class="biometricmap-child" alt="" src="./public/rectangle-1@2x.png" />

    <div class="biometric-mapping">/Add Work Location</div>
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
    <img class="arcticonsgoogle-pay" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

    <a href="./index.php"> <img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" /></a>

    <a href="./index.php" class="dashboard">Dashboard</a>
    <a class="akar-iconsdashboard" style="margin-top:263px;">
      <img class="vector-icon4" alt="" src="./public/vector4.svg" />
    </a>
    <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

    <div class="frame-div"></div>
    <div class="rectangle-div" style="height: 600px;"></div>

    <h3 class="userid-mapping" style="width:300px;">Add New Work Location</h3>
    <img class="line-icon" alt="" src="./public/line-12@2x.png" />

    <form id="locationForm">
      <label class="employee-name">Building Name</label>
      <input name="building" class="rectangle-input" style="border-radius:10px; margin-top: -5px; scale: 0.8; margin-left: -50px; font-size: 25px;" id="employeeSelect" type="text">
      <label class="user-id">Street Name 1</label>
      <input name="sname1" class="biometricmap-child1" style="border-radius:10px; margin-top: -5px; scale: 0.8; margin-left: -50px; font-size: 25px;" type="text" />
      <label class="employee-name" style="margin-top:90px;">Street Name 2</label>
      <input name="sname2" style="margin-top:85px;border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px;" class="rectangle-input" id="employeeSelect" type="text">
      <label class="user-id" style="margin-top: 90px; width: 200px;">Locality/Area Name</label>
      <input name="area" class="biometricmap-child1" style="border-radius:10px; margin-top:85px; scale: 0.8; margin-left: -50px; font-size: 25px;" type="text" />
      <label class="employee-name" style="margin-top:180px;">City</label>
      <select name="city" style="margin-top:175px;border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px;" class="rectangle-input" id="employeeSelect">
      <option value="">--select--</option>
            <option value="Visakhapatnam">Visakhapatnam</option>
            <option value="Gurugram">Gurugram</option> 
    </select>
      <label class="user-id" style="margin-top: 180px;">State</label>
      <input name="state" class="biometricmap-child1" style="border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px; margin-top:175px" type="text" />
      <label class="employee-name" style="margin-top:270px;">PIN</label>
      <input name="pin" style="margin-top:265px;border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px;" class="rectangle-input" id="employeeSelect" type="text">
      <label class="user-id" style="margin-top: 270px;">City Abbrevation</label>
      <select name="abbr" class="biometricmap-child1" style="border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px; margin-top:265px" >
      <option value="">--select--</option>
            <option value="VSP">Visakhapatnam - VSP</option>
            <option value="GGM">Gurugram - GGM</option> 
    </select>
      <label class="employee-name" style="margin-top:360px;">Email</label>
      <input name="email" style="margin-top:355px;border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px;" class="rectangle-input" id="employeeSelect" type="email">
      <label class="user-id" style="margin-top: 360px;">Phone Number</label>
      <input name="phone" class="biometricmap-child1" style="border-radius:10px; scale: 0.8; margin-left: -50px; font-size: 25px; margin-top:355px" type="text" />
      <button class="rectangle-button" id="rectangleButton1" style="color:white; scale: 0.7; margin-top: 293px; font-size:25px; margin-left: 60px;">ADD</button>
    </form>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="position: absolute; margin-left:420px; margin-top: 750px; overflow-y:auto; height:280px; width:1180px;">
      <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              S.No.
            </th>
            <th scope="col" class="px-6 py-3">
              Building Name
            </th>
            <th scope="col" class="px-6 py-3">
              Street Name 1
            </th>
            <th scope="col" class="px-6 py-3">
              Street Name 2
            </th>
            <th scope="col" class="px-6 py-3">
              Locality/Area Name
            </th>
            <th scope="col" class="px-6 py-3">
              City
            </th>
            <th scope="col" class="px-6 py-3">
              State
            </th>
            <th scope="col" class="px-6 py-3">
              PIN
            </th>
            <th scope="col" class="px-6 py-3">
              City Abbre.
            </th>
            <th scope="col" class="px-6 py-3">
              Email ID
            </th>
            <th scope="col" class="px-6 py-3">
              Phone Number
            </th>
          </tr>
        </thead>
        <?php
           $sql = "SELECT * FROM workLocation";

        $que = mysqli_query($con, $sql);
        $cnt = 1;
        while ($result = mysqli_fetch_assoc($que)) {
        ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4"><?php echo $cnt; ?></td>
          <td class="px-6 py-4"><?php echo $result['building']; ?></td>
          <td class="px-6 py-4"><?php echo $result['sname1']; ?></td>
          <td class="px-6 py-4"><?php echo $result['sname2']; ?></td>
          <td class="px-6 py-4"><?php echo $result['area']; ?></td>
          <td class="px-6 py-4"><?php echo $result['city']; ?></td>
          <td class="px-6 py-4"><?php echo $result['state']; ?></td>
          <td class="px-6 py-4"><?php echo $result['pin']; ?></td>
          <td class="px-6 py-4"><?php echo $result['abbr']; ?></td>
          <td class="px-6 py-4"><?php echo $result['email']; ?></td>
          <td class="px-6 py-4"><?php echo $result['phone']; ?></td>
        </tr>

        <?php $cnt++;
        } ?>
      </table>
    </div>
  </div>

  <script>
    $(document).ready(function () {
        $("#locationForm").submit(function (e) {
            e.preventDefault();
            
            var formData = $("#locationForm").serialize();

            $.ajax({
                type: "POST",
                url: "insert_location.php",
                data: formData, 
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Location added!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'location.php';
                        }
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while adding the location.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

</body>

</html>
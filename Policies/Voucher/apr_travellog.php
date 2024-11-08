<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:login.php');
}
?>

<?php
 $user_name = $_SESSION['user_name'];
 $sql = "SELECT `name` FROM user_form WHERE email = '$user_name'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $name = $row['name'];
    ?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/employee-management.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>


    <!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

        .swal2-container {
            z-index: 100000 !important;
        }

        .my-swal {
            z-index: 100000 !important;
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

        .email-id,
        .frame-child {
            position: absolute;
            left: 126px;
        }

        .email-id {
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

        #loading-bar-spinner.spinner::backdrop {
            background-color: rgba(0, 0, 0, .3);
            backdrop-filter: blur(4px);
        }

        #loading-bar-spinner.spinner {
            display: none;
            left: 50%;
            margin-left: -20px;
            top: 50%;
            margin-top: -20px;
            position: absolute;
            z-index: 19 !important;
            -webkit-animation: loading-bar-spinner 400ms linear infinite;
            animation: loading-bar-spinner 400ms linear infinite;
        }

        #loading-bar-spinner.spinner .spinner-icon {
            width: 40px;
            height: 40px;
            border: solid 4px transparent;
            border-top-color: #ff6e24 !important;
            border-left-color: #ff6e24 !important;
            border-radius: 50%;
        }

        .spinner::backdrop {
            background-color: rgba(0, 0, 0, .3);
            backdrop-filter: blur(4px);
        }

        @-webkit-keyframes loading-bar-spinner {
            0% {
                transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loading-bar-spinner {
            0% {
                transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .hovpic {
            z-index: 9999;
            transition: all 0.5s ease-in-out;
        }

        .hovpic:hover {
            transform: scale(3, 3);
        }

        .container {
            padding-bottom: 20px;
            margin-right: 0px;
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
</head>

<body>


    <div class="employeemanagement" id="submitBtn">
        <div class="bg17"></div>
        <img class="employeemanagement-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="employeemanagement-item" alt="" src="./public/rectangle-2@2x.png" />

        <img style="z-index:9999;" class="logo-1-icon17" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm17" href="./index.php" id="anikaHRM">
            <span>Anika</span>
            <span class="hrm17">HRM</span>
        </a>
        <a class="employee-management4" href="./index.php" id="employeeManagement">Employee Management
        </a>
        <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php"
            class="employee-management4" id="employeeManagement"></a>
        <button class="employeemanagement-inner"></button>
        <a href="logout.php">
            <div class="logout17">Logout</div>
        </a>
        <a class="leaves17" href="./leave-management.php" id="leaves">Leaves</a>
        <a class="onboarding21" id="onboarding">Onboarding</a>
        <a class="attendance17" href="./attendence.php" id="attendance">Attendance</a>
        <a href="./Payroll/payroll.php" class="payroll17">Payroll</a>
        <div class="reports17">Reports</div>
        <a class="fluent-mdl2leave-user17" id="fluentMdl2leaveUser">
            <img class="vector-icon88" alt="" src="./public/vector.svg" />
        </a>
        <a class="fluentperson-clock-20-regular17" id="fluentpersonClock20Regular">
            <img class="vector-icon89" alt="" src="./public/vector1.svg" />
        </a>
        <img class="uitcalender-icon17" alt="" src="./public/uitcalender.svg" />

        <img class="arcticonsgoogle-pay17" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon17" alt=""
            src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


        <img class="employeemanagement-child2" alt="" src="./public/rectangle-4@2x.png" />

        <a class="dashboard17" href="./index.php" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular17">
            <img class="vector-icon90" alt="" src="./public/vector2.svg" />
        </a>
        <a class="employee-list17">Employee List</a>
        <a class="akar-iconsdashboard17" href="./index.php" id="akarIconsdashboard">
            <img class="vector-icon91" alt="" src="./public/vector3.svg" />
        </a>
        <div class="rectangle-parent27" style="overflow:auto; width:calc(100% - 420px); height: 830px; margin-top:-60px; margin-left: -100px;">
            



<div class="relative overflow-x-auto" style="margin-top: 50px;">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Employee name
                </th>
                <th scope="col" class="px-6 py-3">
                    Boarding
                </th>
                <th scope="col" class="px-6 py-3">
                    Departure
                </th>
                <th scope="col" class="px-6 py-3">
                    Duration
                </th>
                <th scope="col" class="px-6 py-3">
                    Travel By
                </th>
                <th scope="col" class="px-6 py-3">
                    Ticket Cost
                </th>
                <th scope="col" class="px-6 py-3">
                    Policy Applicable
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    View Voucher
                </th>
                <th scope="col" class="px-6 py-3" colspan=2>
                    Action
                </th>
            </tr>
        </thead>
        <?php
$sql = "SELECT * FROM travel_voucher";
$que = mysqli_query($con, $sql);
while ($result = mysqli_fetch_assoc($que)) {
?>
<tbody>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            <?php echo $result['empname']; ?> 
        </th>
        <td class="px-6 py-4">
            <?php echo $result['boarding_date']; ?>
        </td>
        <td class="px-6 py-4">
            <?php echo $result['departure_date']; ?>
        </td>
        <td class="px-6 py-4">
            <?php echo $result['duration']; ?>
        </td>
        <td class="px-6 py-4">
            <?php echo $result['mode']; ?>
        </td>
        <td class="px-6 py-4">
            <?php echo $result['cost']; ?>
        </td>
        <td class="px-6 py-4">
            <?php echo $result['policies_policy']; ?>
        </td>
        <td class="px-6 py-4">
            <?php
            if (isset($result['status']) && $result['status'] == 1) {
                echo 'Approved';
            } else if (isset($result['status']) && $result['status'] == 2) {
                echo 'Rejected';
            } else {
                echo 'Pending for Approval';
            }
            ?>
        </td>
        <td class="px-6 py-4">
            <a href="#" class="pdf-preview" data-voucherno="<?php echo urlencode($result['voucherno']); ?>">
                <img src="./public/images-removebg-preview.png" width="25px" alt="">
            </a>
        </td>
        <td>
            <?php if ($result['status'] == 0) { ?>
                <button type="button" data-policy-title="<?php echo htmlspecialchars($result['voucherno']); ?>" class="approvebtn text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                    </svg>
                </button>
            <?php } elseif ($result['status'] == 1) { ?>
              <span>Approved</span>  
            <?php } ?>
        </td>
        <td>
            <?php if ($result['status'] == 0) { ?>
                <button type="button" data-policy-title="<?php echo htmlspecialchars($result['voucherno']); ?>" class="rejectbtn text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>
                </button>
            <?php } elseif ($result['status'] == 2) { ?>
            <span style="margin-left:-55px;">Rejected</span>    
            <?php } ?>
        </td>
    </tr>
</tbody>
<?php } ?>

    </table>
</div>

<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Voucher Preview</h5>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" src="" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>
</div>
        </div>
        <img class="tablerlogout-icon17" alt="" src="./public/tablerlogout.svg" />

        <a class="uitcalender17" id="uitcalender">
            <img class="vector-icon92" alt="" src="./public/vector4.svg" />
        </a>
       


     
    </div>
    <div id="loading-bar-spinner" class="spinner">
        <div class="spinner-icon"></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.rejectbtn').on('click', function() {
            var voucherno = $(this).data('policy-title');
            updateStatus(voucherno, 2);
        });

        $('.approvebtn').on('click', function() {
            var voucherno = $(this).data('policy-title');
            updateStatus(voucherno, 1);
        });

        function updateStatus(voucherno, status) {
            $.ajax({
                type: "POST",
                url: "update_status.php?voucherno=" + encodeURIComponent(voucherno),
                data: { status: status },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "apr_travellog.php";
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>


    <script>
$(document).ready(function() {
    $('.pdf-preview').on('click', function(e) {
        e.preventDefault();

        var voucherno = $(this).data('voucherno');
        var pdfUrl = 'print_voucher.php?voucherno=' + voucherno;

        $('#pdfIframe').attr('src', pdfUrl);
        $('#pdfModal').modal('show');
    });
});
</script>

    <script>
    $(document).ready(function() {
        $("#modalForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "insert_voucher.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response); 

                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'travellog.php';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr); 
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error processing your request.',
                        confirmButtonText: 'OK'
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

        var employeeManagement = document.getElementById("employeeManagement");
        if (employeeManagement) {
            employeeManagement.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var leaves = document.getElementById("leaves");
        if (leaves) {
            leaves.addEventListener("click", function (e) {
                window.location.href = "./leave-management.php";
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

        var fluentpersonClock20Regular = document.getElementById(
            "fluentpersonClock20Regular"
        );
        if (fluentpersonClock20Regular) {
            fluentpersonClock20Regular.addEventListener("click", function (e) {
                window.location.href = "./leave-management.php";
            });
        }

        var dashboard = document.getElementById("dashboard");
        if (dashboard) {
            dashboard.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var akarIconsdashboard = document.getElementById("akarIconsdashboard");
        if (akarIconsdashboard) {
            akarIconsdashboard.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var link = document.getElementById("link");
        if (link) {
            link.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var mohanReddy = document.getElementById("mohanReddy");
        if (mohanReddy) {
            mohanReddy.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var webDeveloper = document.getElementById("webDeveloper");
        if (webDeveloper) {
            webDeveloper.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var prabhdeepSinghMaan = document.getElementById("prabhdeepSinghMaan");
        if (prabhdeepSinghMaan) {
            prabhdeepSinghMaan.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var iT = document.getElementById("iT");
        if (iT) {
            iT.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var active = document.getElementById("active");
        if (active) {
            active.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var uitcalender = document.getElementById("uitcalender");
        if (uitcalender) {
            uitcalender.addEventListener("click", function (e) {
                window.location.href = "./attendence.php";
            });
        }

        var typcnplus = document.getElementById("typcnplus");
        if (typcnplus) {
            typcnplus.addEventListener("click", function (e) {
                window.location.href = "./add-employeee.php";
            });
        }

        var addEmployee = document.getElementById("addEmployee");
        if (addEmployee) {
            addEmployee.addEventListener("click", function (e) {
                window.location.href = "./add-employeee.php";
            });
        }

        var frameContainer1 = document.getElementById("frameContainer1");
        if (frameContainer1) {
            frameContainer1.addEventListener("click", function (e) {
                window.location.href = "./add-employeee.php";
            });
        }
    </script>
</body>

</html>
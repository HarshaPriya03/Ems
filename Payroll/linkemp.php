<?php

$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

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

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        .section {
            display: none;
        }

        .active {
            display: block;
        }

        .udbtn:hover {
            color: black !important;
            background-color: white !important;
            outline: 1px solid #F46114;
        }

        .btn-close {
            color: #aaaaaa;
            font-size: 30px;
            text-decoration: none;
            position: absolute;
            right: 5px;
            top: 0;
        }

        .btn-close:hover {
            color: #919191;
        }

        .modal:target:before {
            display: none;
        }

        .modal:before {
            content: "";
            display: block;
            background: rgba(0, 0, 0, 0.6);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10;
        }

        .modal .modal-dialog {
            background: #fefefe;
            border: #333333 solid 1px;
            border-radius: 5px;
            margin-left: -200px;
            position: fixed;
            left: 50%;
            z-index: 11;
            width: 700px;
            -webkit-transform: translate(0, 0);
            -ms-transform: translate(0, 0);
            transform: translate(0, 0);
            -webkit-transition: -webkit-transform 0.3s ease-out;
            -moz-transition: -moz-transform 0.3s ease-out;
            -o-transition: -o-transform 0.3s ease-out;
            transition: transform 0.3s ease-out;
            top: 5%;
        }

        .modal:target .modal-dialog {
            top: -100%;
            -webkit-transform: translate(0, -500%);
            -ms-transform: translate(0, -500%);
            transform: translate(0, -500%);
        }

        .modal-body {
            padding: 20px;
            width: 900px;
            height: 760px;
        }

        .modal-header,
        .modal-footer {
            padding: 10px 20px;
        }

        .modal-header h2 {
            font-size: 20px;
        }

        .modal-footer {
            border-top: #eeeeee solid 1px;
            text-align: right;
        }

        label {
            font-size: 18px;
        }

        ::placeholder {
            color: #FB8C0B !important;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="attendence4">
        <div class="bg14"></div>
        <div class="rectangle-parent23" style="margin-top: -80px;">
            <div style="background-color: white; width: 60%; height: 400px; border-radius: 20px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5); margin-left: auto; margin-right: auto;">
                <p style="margin-left: 20px; padding-top: 20px;">Add Details</p>
                <hr style="width: 95%;" /><br>
                <form id="employeeForm">
                    <label for="" style="margin-left: 20px; font-weight: lighter;">Employee Name:</label>
                    <select name="empname" style="margin-left: 0px; width: 400px; height: 40px; font-size: 20px; border-radius: 5px;">
                        <option value="">--select--</option>
                        <?php
                        $servername = "localhost";
                        $username = "Anika12";
                        $password = "Anika12";
                        $dbname = "ems";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT empname FROM payroll_msalarystruc ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["empname"] . "'>" . $row["empname"] . "</option>";
                            }
                        } else {
                            echo "0 results";
                        }

                        $conn->close();
                        ?>
                    </select> <br> <br>
                    <div style="display:flex;">
                        <label for="" style="margin-left: 20px; width:140px; font-weight: lighter;">Bank Name:</label>
                        <select name="bank_name" style="width: 250px; height: 40px; font-size: 20px; border-radius: 5px;">
                            <option value="">--select--</option>
                            <?php
                            $servername = "localhost";
                            $username = "Anika12";
                            $password = "Anika12";
                            $dbname = "ems";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT bank_name, default_bank FROM payroll_bank";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($row["default_bank"] == "Yes") ? "selected" : "";
                                    echo "<option value='" . $row["bank_name"] . "' $selected>" . $row["bank_name"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No bank_name available</option>";
                            }

                            $conn->close();
                            ?>
                        </select>
                        <label for="" style="margin-left: 20px; font-weight: lighter; width:150px;">UAN A/ C Number:</label>
                        <input type="text" placeholder="XXXXXXXXXXXX" name="uan" style=" font-size: 20px; width: 250px; margin-left:-10px; height: 40px; border-radius: 5px;">
                    </div>
                    <!--<br>-->
                    <div style="display:flex;">

                        <label for="" style="margin-left: 20px; width:140px; font-weight: lighter;">IFSC Code:</label>
                        <select name="ifsc" style=" width: 250px; height: 40px; font-size: 20px; border-radius: 5px;">
                            <option value="">--select--</option>
                            <?php
                            $servername = "localhost";
                            $username = "Anika12";
                            $password = "Anika12";
                            $dbname = "ems";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT ifsc, default_bank FROM payroll_bank";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($row["default_bank"] == "Yes") ? "selected" : "";
                                    echo "<option value='" . $row["ifsc"] . "' $selected>" . $row["ifsc"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No IFSC available</option>";
                            }

                            $conn->close();
                            ?>
                        </select>

                        <label for="" style="margin-left: 20px; font-weight: lighter; width:150px;">EPF A / C Number:</label>
                        <input type="text" name="epfn" placeholder="AA/AAA/XXXXXXX/XXX/XXXXXXX" style=" font-size: 20px; width: 250px; margin-left:-10px; height: 40px; border-radius: 5px;">
                    </div>
                    <!--<br> -->
                    <div style="display:flex;">

                        <label for="" style="margin-left: 20px; font-weight: lighter; width:150px;">Bank A/ C Number:</label>
                        <input type="text" name="ban" style=" font-size: 20px; width: 250px; margin-left:-10px; height: 40px; border-radius: 5px;">
                        <label for="" style="margin-left: 20px; font-weight: lighter; width:150px;">ESIC A/ C Number:</label>
                        <input type="text" placeholder="XXXXXXXXXX" name="esin" style=" font-size: 20px; width: 250px; margin-left:-10px; height: 40px; border-radius: 5px;">
                    </div> <br />
                    <button type="submit" class="udbtn" style="background-color: #FB8A0B; color: white; border: none; border-radius: 5px; width: 100px; height: 35px; font-size: 18px; margin-left: 720px;">save</button>
                </form>
            </div> <br>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Emp. Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Bank Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            IFSC Code
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Bank A/ C No.
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Confirmation Status
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM payroll_ban  ORDER BY ID ASC";
                $que = mysqli_query($con, $sql);
                $cnt = 1;
                while ($result = mysqli_fetch_assoc($que)) {
                ?>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                <?php echo $result['empname']; ?></td>
                            <td class="px-6 py-4">
                                <?php echo $result['bank_name']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $result['ifsc']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $result['ban']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div style="display: flex; gap: 20px;">
                                    <?php
                                    $status = $result['status'];
                                    $status1 = $result['status1'];
                                    if ($status == 1 && $status1 == 1) {
                                        echo "Confirmed by HR & Employee";
                                    } elseif ($status == 1 && $status1 == 0) {
                                        echo "Confirmed by HR, Pending emp confirmation";
                                    }
                                    ?>
                                </div>
                            </td>

                            <td class="px-6 py-4">

                                <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" id="<?php echo $result['empname']; ?>" class="edit_data5 font-medium text-blue-600 dark:text-blue-500 hover:underline">Link</a>
                            </td>
                        </tr>
                    </tbody>
                <?php $cnt++;
                } ?>
            </table>
        </div>
        <div id="editUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <form class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editUserModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="modal-body" id="info_update5">
                                <?php @include("view_linkmodal.php"); ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <div class="logout14">Logout</div>
    <a href="./payroll.html" class="payroll14" style="color: white; z-index:9999; font-size:20px; font-size:25px; margin-top:-6px; font-weight:350;">Payroll</a>
    <a class="reports14" style=" font-size:25px; margin-top:-6px; font-weight:350;">Reports</a>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="./index.php" id="dashboard" style=" font-size:25px; margin-top:-6px; font-weight:350;">Dashboard</a>
    <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
        <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" href="employee-management.php" id="employeeList" style=" font-size:25px; margin-top:-6px; font-weight:350;">Employee List</a>
    <a class="akar-iconsdashboard14" href="./index.php" id="akarIconsdashboard">
        <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" href="leave-management.php" style=" font-size:25px; margin-top:-6px; font-weight:350;">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
        <img class="vector-icon75" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" id="onboarding" href="onboarding.php" style=" font-size:25px; margin-top:-6px; font-weight:350;">Onboarding</a>
    <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
        <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" href="attendence.php" style="color: black; font-size:25px; margin-top:-6px; font-weight:350;">Attendance</a>
    <a class="uitcalender14">
        <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.edit_data5', function() {
                var edit_id5 = $(this).attr('id');
                $.ajax({
                    url: "view_linkmodal.php",
                    type: "post",
                    data: {
                        edit_id5: edit_id5
                    },
                    success: function(data) {
                        $("#info_update5").html(data);
                        $("body").addClass("modal-open");
                    }
                });
            });

            $(document).on('click', '[data-modal-hide="editUserModal"]', function() {
                $("#editUserModal").removeClass("show");
                $("body").removeClass("modal-open");
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#employeeForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'insert_ban.php',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Success:', response);
                        Swal.fire({
                            icon: 'success',
                            title: 'added!',
                            text: response,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'linkemp.php#modal-one';
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
</body>
<script>
    let currentSection = 1;

    function showSection(section) {
        document.getElementById('section' + currentSection).classList.remove('active');
        document.getElementById('section' + section).classList.add('active');
        currentSection = section;
    }
</script>

</html>
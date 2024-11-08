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

    <link rel="stylesheet" href="../css/global.css" />
    <link rel="stylesheet" href="../css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <style>
        .rectangle-div {
            position: absolute;
            /* top: 136px; */
            border-radius: 20px;
            background-color: #ebecf0;
            width: 400px;
            height: 200px;
            border: 1px solid rgb(185, 185, 185);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
        }

        label {
            font-weight: normal;
        }

        .backclr {
            background-color: #dfebff;
        }

        .remove {
            display: none;
        }

        .hide-calendar .ui-datepicker-calendar {
            display: none;
            width: 120px !important;
        }
    </style>
</head>

<body>
    <div class="attendence4">
        <div class="bg14"></div>
       
        <div class="rectangle-parent23" style="margin-top:-60px;">
           
        <!-- Linking Emp -->

        <button style="position: absolute; top: -10px; left: 1250px;" data-modal-target="default-modals" data-modal-toggle="default-modals" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            + Allocate Bonus
        </button>
        <div style="margin-top: 40px; height: 350px; overflow-y: auto;">
            <!-- Main modal -->
            <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Allocate Bonus to Employee's
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modals">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form id="bonusForm">
                            <div class="p-4 md:p-5 space-y-4" style="margin-left: 65px;">
                                <div style="height: 200px; overflow-y: auto; margin-left: -10px;">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="width: 500px;">
                                        <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Emp Name
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    <input type="checkbox" id="checkAll" onclick="toggleCheckboxes(this)">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                            <?php
                                            $sql = "SELECT * FROM emp  ORDER BY emp_no ASC";
                                            $que = mysqli_query($con, $sql);

                                            if (mysqli_num_rows($que) > 0) {
                                                while ($result = mysqli_fetch_assoc($que)) {
                                            ?>
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                        <td class="px-6 py-4"><?php echo $result['empname'] ?></td>
                                                        <td class="px-6 py-4"><input type="checkbox" class="absentCheckbox" name="absentCheckbox[]" value="<?php echo $result['empname'] ?>" ></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td colspan="2" class="px-6 py-4 text-center">No Employees</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>

                                <label>Bonus Type:</label>
                                <select name="bonus" id="bonus" style="width: 300px; border-radius: 5px; margin-left: 38px;">
                                    <option value="" data-amount="" disabled selected>--Select--</option>
                                    <?php
                                    $servername = "localhost";
                                    $username = "Anika12";
                                    $password = "Anika12";
                                    $dbname = "ems";

                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT id, bonus, amt FROM payroll_bonus";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["bonus"] . "' data-amount='" . $row["amt"] . "'>" . $row["bonus"] . "</option>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                                </select>

                                <div style="display: flex;">
                                    <label>Amount:</label>
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-left: 78px;">₹</div>
                                    <input type="text" name="amt" id="amt" style="font-size: 18px; width: 243px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                                <label>Payout Date:</label>
                                <input id="datepicker" name="paymonth" class="datepicker-without-calendar" type="text" style="width: 300px; border-radius: 5px; margin-left: 33px;">
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button  type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <!--<th scope="col" class="px-6 py-3">-->

                        <!--</th>-->
                        <th scope="col" class="px-6 py-3">
                            Emp Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Bonus Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Payout Month
                        </th>
                        <th scope="col" class="px-6 py-3">
                            created
                        </th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM payroll_bonusamt  ORDER BY ID ASC";
                $que = mysqli_query($con, $sql);

                if (mysqli_num_rows($que) > 0) {
                    while ($result = mysqli_fetch_assoc($que)) {
                ?>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <!--<td class="px-6 py-4"> <img src="../pics/" width="50px" style="border-radius: 50%;" alt="pic"></td>-->
                        <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                        <td class="px-6 py-4"> <?php echo $result['bonus']; ?></td>
                        <td class="px-6 py-4"><?php echo $result['amt']; ?></td>
                        <td class="px-6 py-4"><?php echo $result['paymonth']; ?></td>
                        <td class="px-6 py-4"><?php echo $result['created']; ?></td>
                    </tr>
                </tbody>
                <?php
                    }
                } else {
                    ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="8" class="px-6 py-4 text-center">No EMI history</td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <a href="../../logout.php" style="margin-top:-5px;" class="logout14">Logout</a>
    <a class="payroll14" href="./acc_payroll.php" style="color: white; z-index:9999; margin-top:-200px">Payroll</a>
    <div class="reports14" style="margin-top:-70px;">Reports</div>
    <img class="uitcalender-icon14" alt="" src="../public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999; margin-top:-200px" class="arcticonsgoogle-pay14" alt="" src="../public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" style="margin-top:-70px;" alt="" src="../public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


    <img class="attendence-child2" alt="" style="margin-top: -130px;" src="../public/rectangle-4@2x.png" />

    <!--<a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>-->
    <!--<a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">-->
    <!--    <img class="vector-icon73" alt="" src="../public/vector7.svg" />-->
    <!--</a>-->
    <!--<a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>-->
    <!--<a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">-->
    <!--    <img class="vector-icon74" alt="" src="../public/vector3.svg" />-->
    <!--</a>-->
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="../public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999; margin-top:70px;" href="./leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" style=" margin-top:70px;" id="fluentpersonClock20Regular">
        <img class="vector-icon75" style="z-index: 99999;" alt="" src="../public/vector1.svg" />
    </a>
    <!--<a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>-->
    <!--<a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">-->
    <!--    <img class="vector-icon76" alt="" src="../public/vector.svg" />-->
    <!--</a>-->
    <a class="attendance14" href="./attendence.php" style="color: black; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
        <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="../public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $("#bonusForm").submit(function(event) {
            event.preventDefault();

            const selectedEmployees = [];
            $('.absentCheckbox:checked').each(function() {
                selectedEmployees.push($(this).val());
            });

            const bonus = $('#bonus').val();
            const bonusAmount = $('#bonus option:selected').attr('data-amount');
            const payoutDate = $('#datepicker').val();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to allocate bonus to selected employees. Continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Allocate'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "insert_bonusamt.php",
                        data: {
                            selectedEmployees: selectedEmployees,
                            bonus: bonus,
                            bonusAmount: bonusAmount,
                            payoutDate: payoutDate
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Bonus allocated successfully!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'bonus.php';
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error);
                            Swal.close();
                        }
                    });
                }
            });
        });
    });

    function toggleCheckboxes(checkbox) {
        const checkboxes = document.querySelectorAll('.absentCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = !checkbox.checked;
        });
    }
</script>

<script>
    document.getElementById('bonus').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var amount = selectedOption.getAttribute('data-amount');
        document.getElementById('amt').value = amount;
    });
</script>
<script>
    $(document).ready(function() {
        $('#employeeForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'insert_bonus.php',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'bonus.php';
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
    $('.datepicker-without-calendar').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        beforeShow: function(input) {
            $(input).datepicker("widget").addClass('hide-calendar');
        },
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            $(this).datepicker('widget').removeClass('hide-calendar');
        }
    });

    $('.datepicker').datepicker();
</script>
<script>
    function toggleCheckboxes(checkbox) {
        const checkboxes = document.querySelectorAll('.absentCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = !checkbox.checked;
        });
    }
</script>

</html>
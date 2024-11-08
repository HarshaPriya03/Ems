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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        .content {
            display: none;
        }

        .show {
            display: block;
        }

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

        .mult-select-tag {
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: center;
            position: relative;
            --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --tw-shadow-color: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
            --border-color: rgb(218, 221, 224);
            font-family: Verdana, sans-serif;
        }

        .mult-select-tag .wrapper {
            width: 100%;
        }

        .mult-select-tag .body {
            display: flex;
            border: 1px solid var(--border-color);
            background: white;
            min-height: 2.15rem;
            width: 100%;
            min-width: 14rem;

        }

        .mult-select-tag .input-container {
            display: flex;
            flex-wrap: wrap;
            flex: 1 1 auto;
            padding: 0.1rem;
            align-items: center;
        }

        .mult-select-tag .input-body {
            display: flex;
            width: 100%;
        }

        .mult-select-tag .input {
            flex: 1;
            background: transparent;
            border-radius: 0.25rem;
            padding: 0.45rem;
            margin: 10px;
            color: #2d3748;
            outline: 0;
            border: 1px solid var(--border-color);
        }

        .mult-select-tag .btn-container {
            color: #e2eBf0;
            padding: 0.5rem;
            display: flex;
            border-left: 1px solid var(--border-color);
        }

        .mult-select-tag button {
            cursor: pointer;
            width: 100%;
            color: #718096;
            outline: 0;
            height: 100%;
            border: none;
            padding: 0;
            background: transparent;
            background-image: none;
            text-transform: none;
            margin: 0;
        }

        .mult-select-tag button:first-child {
            width: 1rem;
            height: 90%;
        }


        .mult-select-tag .drawer {
            position: absolute;
            background: white;
            max-height: 15rem;
            z-index: 40;
            top: 98%;
            width: 100%;
            overflow-y: scroll;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
        }

        .mult-select-tag ul {
            list-style-type: none;
            padding: 0.5rem;
            margin: 0;
        }

        .mult-select-tag ul li {
            padding: 0.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .mult-select-tag ul li:hover {
            background: rgb(243 244 246);
        }

        .mult-select-tag .item-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.2rem 0.4rem;
            margin: 0.2rem;
            font-weight: 500;
            border: 1px solid;
            border-radius: 9999px;
        }

        .mult-select-tag .item-label {
            max-width: 100%;
            line-height: 1;
            font-size: 0.75rem;
            font-weight: 400;
            flex: 0 1 auto;
        }

        .mult-select-tag .item-close-container {
            display: flex;
            flex: 1 1 auto;
            flex-direction: row-reverse;
        }

        .mult-select-tag .item-close-svg {
            width: 1rem;
            margin-left: 0.5rem;
            height: 1rem;
            cursor: pointer;
            border-radius: 9999px;
            display: block;
        }

        .mult-select-tag .shadow {
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        .mult-select-tag .rounded {
            border-radius: .375rem;
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
        <a class="attendence-management3" href="./index.php" id="attendenceManagement">Manager-Designations</a>
        <button class="records-inner"></button>
        <a href="logout.php"><div class="logout13">Logout</div></a>
        <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll13">Payroll</a>
        <div class="reports13">Reports</div>
        <img class="uitcalender-icon13" alt="" src="./public/uitcalender.svg" />

        <img class="arcticonsgoogle-pay13" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon13" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

        <img class="records-child2" style="margin-top: -262px;" alt="" src="./public/rectangle-4@2x.png" />

        <a class="dashboard13" href="./index.php" style="color: white;" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular13" id="fluentpeople32Regular">
            <img class="vector-icon67" alt="" src="./public/vector7.svg" />
        </a>
        <a class="employee-list13" id="employeeList">Employee List</a>
        <a class="akar-iconsdashboard13" href="./index.php" id="akarIconsdashboard">
            <img class="vector-icon68" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector3.svg" />
        </a>
        <img class="tablerlogout-icon13" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves13" id="leaves">Leaves</a>
        <a class="fluentperson-clock-20-regular13" id="fluentpersonClock20Regular">
            <img class="vector-icon69" alt="" src="./public/vector1.svg" />
        </a>
        <a class="onboarding15" id="onboarding">Onboarding</a>
        <a class="fluent-mdl2leave-user13" id="fluentMdl2leaveUser">
            <img class="vector-icon70" alt="" src="./public/vector.svg" />
        </a>
        <a class="attendance13" style="color: black;">Attendance</a>
        <a class="uitcalender13">
            <img class="vector-icon71" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
        </a>
        <div class="oouinext-ltr1"></div>
        <div class="rectangle-parent21" style="margin-top: -70px;">
            <div class="frame-child176" style="height:300px;"></div>
            <div class="oouinext-ltr2"></div>
            <div class="employee-records">Assign Designation(s) to Manager</div>
            <div class="frame-child178"></div>
            <div class="employee-name7">Manager Name</div>
            <div class="designation4">Designation</div>
            <form id="updateForm">
                <div class="frame-child183" style="margin-left:-550px;">
                    <button id="dropdownDefaultButton" style="width:90%;" class="text-gray-900 dark:text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <span class="text-white">Select Empname</span>
                        <select onchange="updateFields()" class="employeeSelect" style="width:90%;">
                            <option value=""></option>
                            <?php
                            $sql = "SELECT work_location,empname, empemail,emp_no FROM emp WHERE empstatus=0 ORDER BY emp_no asc";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["empname"] . "|" . $row["empemail"] .  "|" . $row["work_location"] . "'>" . $row["empname"] . "</option>";
                                }
                            } else {
                                echo "0 results";
                            }

                            ?>
                        </select>
                    </button>
                </div>
                <input type='hidden' name='empname' id='employeeNameField' value=''>
                <input type='hidden' name='email' id='employeeEmailField' value=''>
                <input type='hidden' name='work_location' id='employeeLocationField' value=''>

                <div class="frame-child183">
                    <button id="dropdownDefaultButton" class="text-gray-900 dark:text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        <span class="text-white">Select Designations</span>
                        <select name="desgs[]" multiple="multiple" style="height:100px;" id="desgSelect">
                            <?php
                            $sql = "SELECT desg FROM dept";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['desg'] . '">' . $row['desg'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No data available</option>';
                            }

                            ?>
                        </select>

                    </button>

                </div>

                <button class="frame-child185" style="margin-top:-100px; color:white; font-size:25px;">Save</button>

            </form>

            <div style="overflow-y:auto; height:500px; margin-top:350px; width:1120px;">
                <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Manager
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Desg(s)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            PRABHDEEP SINGH MAAN
                        </td>
                        <td class="px-6 py-4 text-xs" colspan="3">
                            WEB DEVELOPER, MAINTENANCE SUPERVISOR, MAINTENANCE HELPER, ASST MAINTENANCE, MAINTENANCE MANAGER, CNC OPERATOR, PRESS BRAKE OPERATOR, FACILITY MANAGER, FACILITY ASST, PSO, FLOOR SUPERVISOR, QC ENGINEER, DESIGN ENGINEER, STORE MANAGER, ASST STORE INCHARGE
                        </td>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM manager where status = 1 ORDER BY id ASC";
                    $que = mysqli_query($con, $sql);
                    while ($result = mysqli_fetch_assoc($que)) {
                    ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                            <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
                            <td class="px-6 py-4">
                                <?php
                                if ($result['status'] == 1) {
                                    echo "Active";
                                } elseif ($result['status'] == 0) {
                                    echo "Inactive";
                                }
                                ?>
                            </td>
                            <td name="manager" class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <form class="managerForm" data-id="<?php echo $result['id']; ?>" data-status="<?php echo $result['status']; ?>">
                                        <button type="button" class="actionBtn px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <?php
                                            if ($result['status'] == 1) {
                                                echo 'Remove as Manager';
                                            } else {
                                                echo '<span>Removed</span>';
                                            }
                                            ?>
                                        </button>
                                    </form>

                                    <button data-id="<?php echo $result['id']; ?>" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Update
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-800 border-2 border-blue-500 dark:border-blue-400">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Manage Designations
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <div class="mb-4">
                                    <label for="empname-display" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Manager Name</label>
                                    <div id="empname-display" class="bg-gray-100 border-2 border-gray-300 text-gray-900 text-sm rounded-lg p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white min-h-[60px]">
                                        <!-- Current designations will appear here -->
                                    </div>
                                    <br>

                                    <label for="desg-display" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Designations Handling</label>
                                    <div id="desg-display" class="bg-gray-100 border-2 border-gray-300 text-gray-900 text-sm rounded-lg p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white min-h-[60px]">
                                        <!-- Current designations will appear here -->
                                    </div>
                                </div>

                                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 mb-3 rounded-lg text-xs" role="alert">
                                    <p class="font-semibold">Multi-Select Tip</p>
                                    <p class="text-xs">Hold Ctrl (Windows) or Cmd (Mac) and click to select multiple items. Use Shift + Arrow keys to select a range.</p>
                                </div>
                                <div class="space-y-4 bg-blue-50 border-2 border-blue-300 rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-blue-800">Add New Designations</h4>
                                    <form id="update-form" class="space-y-4">
                                        <input type="hidden" name="id" id="manager-id">
                                        <label for="desgUpdate" class="block mb-2 text-sm font-medium text-blue-700">Select Designations to Add</label>
                                        <select name="desgs[]" multiple="multiple" class="bg-white border-2 border-blue-300 text-blue-900 text-sm rounded-lg p-2.5 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="desgUpdate" style="height:150px;">
                                            <!-- Available designations will be populated here -->
                                        </select>
                                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-150 ease-in-out">Add Selected Designations</button>
                                    </form>
                                </div>
                                <div class="space-y-4 bg-red-50 border-2 border-red-300 rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-red-800">Remove Designations</h4>
                                    <form id="delete-form" class="space-y-4">
                                        <input type="hidden" name="id" id="delete-manager-id">
                                        <label for="desgDelete" class="block mb-2 text-sm font-medium text-red-700">Select Designations to Remove</label>
                                        <select name="desgs[]" multiple="multiple" class="bg-white border-2 border-red-300 text-red-900 text-sm rounded-lg p-2.5 w-full focus:ring-2 focus:ring-red-500 focus:border-red-500" id="desgDelete" style="height:150px;">
                                            <!-- Assigned designations will be populated here -->
                                        </select>

                                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded-lg text-xs" role="alert">
                                            <p class="font-semibold">Warning</p>
                                            <p class="text-xs">Please review the assigned designations carefully before removing. This action cannot be undone.</p>
                                        </div>

                                        <button type="submit" class="w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-150 ease-in-out">Remove Selected Designations</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('update-form').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'update_desg_mgr.php', true);
                        xhr.onload = function() {
                            if (this.status === 200) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Designations updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#8CD4F5'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        };
                        xhr.onerror = function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Network error. Please check your connection.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        };
                        xhr.send(formData);
                    });

                    document.getElementById('delete-form').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'delete_desg_mgr.php', true);
                        xhr.onload = function() {
                            if (this.status === 200) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Designations deleted successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#e27393',
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        };
                        xhr.onerror = function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Network error. Please check your connection.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        };
                        xhr.send(formData);
                    });

                    function fetchDesgOptions() {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', 'fetch_desg_options_mgr.php', true);
                        xhr.onload = function() {
                            if (this.status === 200) {
                                try {
                                    const response = JSON.parse(this.responseText);
                                    const desgSelect = document.getElementById('desgUpdate');
                                    const desgDeleteSelect = document.getElementById('desgDelete');
                                    desgSelect.innerHTML = '';
                                    desgDeleteSelect.innerHTML = '';
                                    response.forEach(desg => {
                                        const option = document.createElement('option');
                                        option.value = desg;
                                        option.textContent = desg;
                                        desgSelect.appendChild(option);
                                        desgDeleteSelect.appendChild(option.cloneNode(true));
                                    });
                                } catch (e) {
                                    console.error('Error parsing options response:', e);
                                }
                            } else {
                                console.error('Options request failed:', this.status, this.statusText);
                            }
                        };
                        xhr.send();
                    }

                    document.querySelectorAll('[data-modal-toggle="authentication-modal"]').forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            document.getElementById('manager-id').value = id;
                            document.getElementById('delete-manager-id').value = id;
                            fetchDesgOptions();
                        });
                    });
                });
            </script>


            <script>
                document.querySelectorAll('[data-modal-toggle="authentication-modal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        document.getElementById('manager-id').value = id;
                        fetchDesg(id);
                        fetchDesgOptions();
                    });
                });

                function fetchDesgOptions() {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'fetch_desg_options_mgr.php', true);
                    xhr.onload = function() {
                        if (this.status == 200) {
                            try {
                                const response = JSON.parse(this.responseText);
                                const desgSelect = document.getElementById('desgUpdate');
                                desgSelect.innerHTML = '';
                                response.forEach(desg => {
                                    const option = document.createElement('option');
                                    option.value = desg;
                                    option.textContent = desg;
                                    desgSelect.appendChild(option);
                                });

                                // Add event listener for changes in the select element
                                desgSelect.addEventListener('change', updateSelectedDesignations);
                            } catch (e) {
                                console.error('Error parsing options response:', e);
                            }
                        } else {
                            console.error('Options request failed:', this.status, this.statusText);
                        }
                    };
                    xhr.send();
                }
            </script>
            <script>
                document.querySelectorAll('[data-modal-toggle="authentication-modal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        fetchDesg(id);
                    });
                });

                function fetchDesg(id) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'fetch_desg_mgr.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (this.status == 200) {
                            try {
                                const response = JSON.parse(this.responseText);
                                if (response.desg) {
                                    document.getElementById('desg-display').innerText = response.desg;
                                    document.getElementById('empname-display').innerText = response.empname;
                                } else {
                                    console.error('Desg not found in response', response);
                                }
                            } catch (e) {
                                console.error('Error parsing JSON response', this.responseText);
                            }
                        } else {
                            console.error('Request failed', this.status, this.statusText);
                        }
                    };
                    xhr.send('id=' + id);
                }
            </script>


            <script>
                $(document).ready(function() {
                    $(".actionBtn").click(function() {
                        var form = $(this).closest(".managerForm");
                        var id = form.data("id");
                        var status = form.data("status");

                        var actionText = (status == 1) ? 'no more a Manager' : 'as Manager';
                        var confirmText = (status == 1) ? 'Remove as Manager' : 'Make as Manager';

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This action will make this employee ' + actionText + '!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: confirmText,
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                toggleManagerStatus(id, status);
                            }
                        });
                    });

                    function toggleManagerStatus(id, status) {
                        $.ajax({
                            type: "POST",
                            url: "updatemanager.php",
                            data: {
                                toggleStatus: true,
                                id: id,
                                status: status
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = 'manager.php';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            </script>
            <script>
                $(document).ready(function() {
                    $("#updateForm").submit(function(e) {
                        e.preventDefault();
                        var empname = $("input[name='empname']").val();
                        var email = $("input[name='email']").val();
                        var work_location = $("input[name='work_location']").val();
                        var desgs = $("select[name='desgs[]']").val();
                        var status = 1;

                        $.ajax({
                            type: "POST",
                            url: "mgr.php",
                            data: {
                                empname: empname,
                                email: email,
                                desgs: desgs,
                                status: status,
                                work_location: work_location
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Manager added!',
                                    text: response,
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'manager.php';
                                    }
                                });
                                $("#updateForm")[0].reset();
                            }
                        });
                    });
                });
            </script>

            <script>
                function updateFields() {
                    var selectedEmployee = document.getElementsByClassName("employeeSelect")[0];
                    var nameField = document.getElementById("employeeNameField");
                    var emailField = document.getElementById("employeeEmailField");
                    var locationField = document.getElementById("employeeLocationField");

                    var selectedValue = selectedEmployee.options[selectedEmployee.selectedIndex].value;
                    var values = selectedValue.split("|");

                    nameField.value = values[0];
                    emailField.value = values[1];
                    locationField.value = values[2];
                }
            </script>
            <script>
                new MultiSelectTag('desgSelect')
                new MultiSelectTag('employeeSelect')
            </script>
            <script>

            </script>

            <script>
                var rectangleLink = document.getElementById("rectangleLink");
                if (rectangleLink) {
                    rectangleLink.addEventListener("click", function(e) {
                        window.location.href = "./attendence.php";
                    });
                }

                var rectangleLink2 = document.getElementById("rectangleLink2");
                if (rectangleLink2) {
                    rectangleLink2.addEventListener("click", function(e) {
                        window.location.href = "./punch-i-n.php";
                    });
                }

                var rectangleLink3 = document.getElementById("rectangleLink3");
                if (rectangleLink3) {
                    rectangleLink3.addEventListener("click", function(e) {
                        window.location.href = "./my-attendence.php";
                    });
                }

                var attendence = document.getElementById("attendence");
                if (attendence) {
                    attendence.addEventListener("click", function(e) {
                        window.location.href = "./attendence.php";
                    });
                }

                var punchINOUT = document.getElementById("punchINOUT");
                if (punchINOUT) {
                    punchINOUT.addEventListener("click", function(e) {
                        window.location.href = "./punch-i-n.php";
                    });
                }

                var myAttendence = document.getElementById("myAttendence");
                if (myAttendence) {
                    myAttendence.addEventListener("click", function(e) {
                        window.location.href = "./my-attendence.php";
                    });
                }

                var anikaHRM = document.getElementById("anikaHRM");
                if (anikaHRM) {
                    anikaHRM.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var attendenceManagement = document.getElementById("attendenceManagement");
                if (attendenceManagement) {
                    attendenceManagement.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var dashboard = document.getElementById("dashboard");
                if (dashboard) {
                    dashboard.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
                if (fluentpeople32Regular) {
                    fluentpeople32Regular.addEventListener("click", function(e) {
                        window.location.href = "./employee-management.php";
                    });
                }

                var employeeList = document.getElementById("employeeList");
                if (employeeList) {
                    employeeList.addEventListener("click", function(e) {
                        window.location.href = "./employee-management.php";
                    });
                }

                var akarIconsdashboard = document.getElementById("akarIconsdashboard");
                if (akarIconsdashboard) {
                    akarIconsdashboard.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var leaves = document.getElementById("leaves");
                if (leaves) {
                    leaves.addEventListener("click", function(e) {
                        window.location.href = "./leave-management.php";
                    });
                }

                var fluentpersonClock20Regular = document.getElementById(
                    "fluentpersonClock20Regular"
                );
                if (fluentpersonClock20Regular) {
                    fluentpersonClock20Regular.addEventListener("click", function(e) {
                        window.location.href = "./leave-management.php";
                    });
                }

                var onboarding = document.getElementById("onboarding");
                if (onboarding) {
                    onboarding.addEventListener("click", function(e) {
                        window.location.href = "./onboarding.php";
                    });
                }

                var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
                if (fluentMdl2leaveUser) {
                    fluentMdl2leaveUser.addEventListener("click", function(e) {
                        window.location.href = "./onboarding.php";
                    });
                }
            </script>
</body>

</html>
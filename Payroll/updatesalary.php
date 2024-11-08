<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
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

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css" integrity="sha512-oHDEc8Xed4hiW6CxD7qjbnI+B07vDdX7hEPTvn9pSZO1bcRqHp8mj9pyr+8RVC2GmtEfI2Bi9Ke9Ass0as+zpg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .udbtn:hover {
            color: black !important;
            background-color: white !important;
            outline: 1px solid #F46114;
        }

        .rectangle-div {
            position: absolute;
            /* top: 136px; */
            border-radius: 20px;
            margin-top: 10px;
            background-color: var(--color-white);
            width: 675px;
            height: 700px;
        }
    </style>
</head>

<body>
    <div class="attendence4">
        <div class="bg14"></div>
        <div class="rectangle-parent23" style="margin-top: -90px;">
            <!-- Emp details -->
            <form id="form1">
                <div>
                    <div style="display: flex; gap: 10px;">
                        <p style="margin-left: 20px; margin-top: 10px;">Employee Details:</p>

                        <div>
                            <input type="text" name="empname" id="empnameInput" list="empdatalist" onchange="getEmployeeDetails(this.value)" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;" autocomplete="off" />
                            <!-- <input type="text" name="empname" list="empdatalist" onchange="getEmployeeDetails(this.value)" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;" autocomplete="off" /> -->
                            <datalist id="empdatalist">
                                <option value="" style="font-weight: lighter;">Select Employee Name</option>
                                <?php
                                if ($work_location == 'All') {
                                    $sql = "SELECT DISTINCT empname FROM emp WHERE empstatus=0 ORDER BY emp_no ASC";
                                } elseif ($work_location == 'Visakhapatnam') {
                                    $sql = "SELECT DISTINCT empname,work_location FROM emp WHERE empstatus=0 AND work_location='Visakhapatnam' ORDER BY emp_no ASC";
                                } elseif ($work_location == 'Gurugram') {
                                    $sql = "SELECT DISTINCT empname,work_location FROM emp WHERE empstatus=0 AND work_location='Gurugram' ORDER BY emp_no ASC";
                                }
                                $result = $con->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["empname"] . "'>" . $row["empname"] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                }

                                ?>
                            </datalist>
                        </div>
                        <div>
                            <input name="emp_no" type="text" id="emp_no" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;" placeholder="Employee ID">
                        </div>
                        <div>
                            <input name="desg" type="text" id="desg" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;" placeholder="Designation">

                        </div>

                    </div>
                    <div style="display: flex; align-items: center;">
                        <button style="margin-left: 20px;margin-top:5px;" onclick="myFunction()" type="button" class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 ">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                            </svg>
                            Reset Form
                        </button>
                        <input type="hidden" id="selectedEmpName1" name="empname">
                        <div style="display: flex; gap: 10px;margin-top:10px; margin-left:50px;">

                            <select name="salarytype" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;">
                                <option style="font-weight: lighter;">Select Compensation Type</option>
                                <option value="Salary Increment/Raise">Salary Increment/Raise</option>
                                <option value="Appraisal">Appraisal</option>
                            </select>
                            <!-- Modal toggle -->
                            <button style="margin-left: 110px;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Parameters
                            </button>

                            <!-- Main modal -->
                            <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Parameters for Salary Update
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 space-y-4">
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                Employee Retention
                                                <input style="margin-left: 383px;" type="checkbox" name="checkbox[]" value="Employee Retention">
                                            </p>
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                Promotion
                                                <input style="margin-left: 455px;" type="checkbox" name="checkbox[]" value="Promotion">
                                            </p>
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                Performance Evaluation
                                                <input style="margin-left: 353px;" type="checkbox" name="checkbox[]" value="Performance Evaluation">
                                            </p>
                                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                Skills and Competencies
                                                <input style="margin-left: 350px;" type="checkbox" name="checkbox[]" value="Skills and Competencies">
                                            </p>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input name="dept" type="text" id="dept" style="font-size: 18px; width: 300px; height: 40px; margin-left: 110px; border-radius: 5px;" placeholder="Department">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="rectangle-div" style="margin-top:55px;height:82%;"></div>

                <div class="rectangle-div" style="margin-top:10px;height:5%;"></div>
                <div style="position: absolute; top: 100px; left:20px;">
                    <input name="ctcCalc" type="text" id="ctcCalc" style=" font-size: 18px; width: 150px;border-radius: 5px;" placeholder="Enter CTC">
                    <button onclick="calculateValues()" style="margin-left: 20px;" type="button" class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 ">
                        Calculate
                    </button>
                </div>
                <div>
                    <div style="position: absolute; top: 150px;">
                        <p style="text-align: center; font-size: 25px; padding-top: 20px;">Current Salary</p>
                        <hr style="width: 101%;" />

                        <!-- Salary Details -->

                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Salary Details:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 160px; margin-top: -20px;">

                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                                <div style="display: flex; margin-left: 86px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input type="text" name="bp" id="bp" oninput="calculateAABP(); calculatesumNet();" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                                <div style="display: flex; margin-left: 130px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input type="text" name="hra" id="hra" oninput="calculateAHRA(); calculatesumNet(); " style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Other Allowances:</label>
                                <div style="display: flex; margin-left: 25px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input type="text" name="oa" id="oa" oninput="calculateAOA(); calculatesumNet(); " style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>

                        </div>
                        <!-- Deductions  -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Deductions :</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 150px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                                    <div style="display: flex; margin-left: 40px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="epf1" id="epf1" oninput="calculateAEPF1(); calculatesumDeduc();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESI:</label>
                                    <div style="display: flex; margin-left: 70px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="esi1" id="esi1" oninput="calculateAESI1(); calculatesumDeduc();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">ESI deductions applicable only if gross salary is more than 21000</p> -->
                        </div>
                        <!-- Employer share EPF -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Employer Share on EPF:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 250px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pension:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="epf2" id="epf2" oninput="calculateAEPF2(); calculatesumEmployer();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF Share:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="epf3" id="epf3" oninput="calculateAEPF3(); calculatesumEmployer();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                        </div>
                        <!-- Employer share ESI -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Employer Share on ESI:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 240px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex; margin-top: 10px;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                                    <div style="display: flex; margin-left: 20px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="esi2" id="esi2" oninput="calculateAESI2(); calculatesumEmployer();" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Cross calc -->
                        <hr style="width: 103%;">
                        <div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">CTC:</label>
                                    <div style="display: flex; margin-left: 50px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="ctc" id="ctc" oninput="calculateACTC();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="tde" id="tde" oninput="calculateATDE();" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">NET Pay:</label>
                                    <div style="display: flex; margin-left: 15px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="netpay" id="netpay" oninput="calculateANETPAY();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                                    <div style="display: flex; margin-left: 18px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="tes" id="tes" oninput="calculateATES();" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);" readonly>
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                        </div>
                    </div>
                </div>
            </form>
            <!-- annual Component -->
            <div class="rectangle-div" style="margin-left: 700px;margin-top:55px;height:82%;"></div>
            <form id="form2">
                <input type="hidden" id="selectedEmpName" name="empname">
                <div>

                    <div style="position: absolute; top: 150px; margin-left: 700px;">

                        <p style="text-align: center; font-size: 25px; padding-top: 20px;"> Update Salary Form</p>
                        <hr style="width: 101%;" />
                        <!-- Salary Details -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Salary Details:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 160px; margin-top: -20px;">

                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                                <div style="display: flex; margin-left: 86px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input name="bp" type="text" id="bp1" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                                <div style="display: flex; margin-left: 130px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input name="hra" type="text" id="hra1" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Other Allowances:</label>
                                <div style="display: flex; margin-left: 25px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input name="oa" type="text" id="oa1" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>

                        </div>
                        <!-- Deductions  -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Deductions :</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 150px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                                    <div style="display: flex; margin-left: 40px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input name="epf1" type="text" id="epf11" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESI:</label>
                                    <div style="display: flex; margin-left: 70px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="esi1" id="esi11" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Employer share EPF -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Employer Share on EPF:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 250px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pension:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="epf2" id="epf21" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF Share:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="epf3" id="epf31" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Employer share ESI -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Employer Share on ESI:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 240px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex; margin-top: 10px;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                                    <div style="display: flex; margin-left: 20px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="esi2" id="esi21" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Cross calc -->
                        <hr style="width: 103%;">
                        <div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">CTC:</label>
                                    <div style="display: flex; margin-left: 50px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="ctc" id="ctc1" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="tde" id="tde1" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">NET Pay:</label>
                                    <div style="display: flex; margin-left: 15px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="netpay" id="netpay1" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                                    <div style="display: flex; margin-left: 18px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="tes" id="tes1" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185); " />
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <button id="submitBtn" type="submit" class="udbtn" style="background-color: #FB8A0B; color: white; border: none; border-radius: 5px; width: 150px; height: 50px; font-size: 22px; margin-left: 610px; margin-top: 720px;">Submit</button>
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
        <a href="./payroll.php" class="payroll14" style="color: white; z-index:9999;">Payroll</a>
        <a class="reports14">Reports</a>
        <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

        <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



        <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

        <a class="dashboard14" href="../index.php" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
            <img class="vector-icon73" alt="" src="./public/vector7.svg" />
        </a>
        <a class="employee-list14" href="../employee-management.php" id="employeeList">Employee List</a>
        <a class="akar-iconsdashboard14" href="../index.php" id="akarIconsdashboard">
            <img class="vector-icon74" alt="" src="./public/vector3.svg" />
        </a>
        <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves14" id="leaves" href="../leave-management.php">Leaves</a>
        <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
            <img class="vector-icon75" alt="" src="./public/vector1.svg" />
        </a>
        <a class="onboarding16" id="onboarding" href="../onboarding.php">Onboarding</a>
        <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
            <img class="vector-icon76" alt="" src="./public/vector.svg" />
        </a>
        <a class="attendance14" href="../attendence.php" style="color: black;">Attendance</a>
        <a class="uitcalender14">
            <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
        </a>
        <div class="oouinext-ltr3"></div>
    </div>


    <!-- <script>
    const form = document.getElementById('autoform');

    form.addEventListener('submit', e => {
        e.preventDefault();
        console.clear();
        console.log('Submit disabled. Data:');

        const data = new FormData(form);

        for (let nv of data.entries()) {
            console.log(`${nv[0]}: ${nv[1]}`);
        }
    });
</script> -->
<script>
       function calculateValues() {
    var ctc = parseFloat(document.getElementById('ctcCalc').value);
    if (isNaN(ctc) || ctc <= 0) {
        alert('Please enter a valid CTC');
        return;
    }
    var bp1 = 0.5 * ctc;
    var hra1 = 0.25 * ctc;
    var oa1 = 0.25 * ctc;
    
    var epf11 = bp1 > 15000 ? 1800 : 0.12 * bp1;
    var epf21 = bp1 > 15000 ? 1249.50 : 0.0833 * bp1;
    var epf31 = bp1 > 15000 ? 550.50 : 0.0367 * bp1;
    
    var esi11 = ctc > 21000 ? 0 : 0.0075 * ctc;
    var esi21 = ctc > 21000 ? 0 : 0.0325 * ctc;
    var netpay1 = bp1 + hra1 + oa1 - (epf11 + esi11);
    
    document.getElementById('bp1').value = bp1.toFixed(2);
    document.getElementById('hra1').value = hra1.toFixed(2);
    document.getElementById('oa1').value = oa1.toFixed(2);
    document.getElementById('epf11').value = epf11.toFixed(2);
    document.getElementById('esi11').value = esi11.toFixed(2);
    document.getElementById('epf21').value = epf21.toFixed(2);
    document.getElementById('epf31').value = epf31.toFixed(2);
    document.getElementById('esi21').value = esi21.toFixed(2);
    document.getElementById('netpay1').value = netpay1.toFixed(2);
    
    document.getElementById('ctc1').value = ctc.toFixed(2);
    document.getElementById('tde1').value = (epf11 + esi11).toFixed(2);
    document.getElementById('tes1').value = (epf21 + epf31 + esi21).toFixed(2);
    
}
    </script>
    <script>
        // function calculateValues() {
        //     var ctc = parseFloat(document.getElementById('ctcCalc').value);
        //     if (isNaN(ctc) || ctc <= 0) {
        //         alert('Please enter a valid CTC');
        //         return;
        //     }

        //     var bp1 = 0.5 * ctc;
        //     var hra1 = 0.25 * ctc;
        //     var oa1 = 0.25 * ctc;
        //     var epf11 = 0.12 * bp1;
        //     var esi11 = ctc > 21000 ? 0 : 0.02 * ctc;
        //     var epf21 = 0.0833 * bp1;
        //     var epf31 = 0.0367 * bp1;
        //     var esi11 = ctc > 21000 ? 0 * ctc : 0.0075 * ctc;
        //     var esi21 = ctc > 21000 ? 0 * ctc : 0.0325 * ctc;
        //     var netpay1 = bp1 + hra1 + oa1 - (epf11 + esi11);

        //     document.getElementById('bp1').value = bp1.toFixed(2);
        //     document.getElementById('hra1').value = hra1.toFixed(2);
        //     document.getElementById('oa1').value = oa1.toFixed(2);
        //     document.getElementById('epf11').value = epf11.toFixed(2);
        //     document.getElementById('esi11').value = esi11.toFixed(2);
        //     document.getElementById('epf21').value = epf21.toFixed(2);
        //     document.getElementById('epf31').value = epf31.toFixed(2);
        //     document.getElementById('esi21').value = esi21.toFixed(2);
        //     document.getElementById('netpay1').value = netpay1.toFixed(2);

        //     document.getElementById('ctc1').value = ctc.toFixed(2);
        //     document.getElementById('tde1').value = (epf11 + esi11).toFixed(2);
        //     document.getElementById('tes1').value = (epf21 + epf31 + esi21).toFixed(2);


        // }
    </script>
    <script>
        function getEmployeeDetails(empname) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    document.getElementById("emp_no").value = response.emp_no;
                    document.getElementById("desg").value = response.desg;
                    document.getElementById("dept").value = response.dept;
                    document.getElementById("bp").value = response.bp;
                    document.getElementById("hra").value = response.hra;
                    document.getElementById("oa").value = response.oa;
                    document.getElementById("epf1").value = response.epf1;
                    document.getElementById("esi1").value = response.esi1;

                    document.getElementById("esi2").value = response.esi2;
                    document.getElementById("epf2").value = response.epf2;
                    document.getElementById("epf3").value = response.epf3;
                    document.getElementById("netpay").value = response.netpay;
                    document.getElementById("ctc").value = response.ctc;
                    document.getElementById("tde").value = response.tde;
                    document.getElementById("tes").value = response.tes;
                    document.getElementById("selectedEmpName").value = empname;
                    document.getElementById("selectedEmpName1").value = empname;
                }
            };
            xhttp.open("GET", "get_employee_details1.php?empname=" + empname, true);
            xhttp.send();
        }
    </script>

    <script>
        function myFunction() {
            document.getElementById("form1").reset();
            document.getElementById("form2").reset();
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#submitBtn").click(function(event) {
                event.preventDefault();

                // Select the form with id "form1"
                var form = $("#form1")[0];

                // Create FormData object from the selected form
                var formData = new FormData(form);

                // Get checked checkboxes
                var checkedValues = $('input[name="checkbox[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                // Append checked checkboxes to formData
                formData.append('checkedValues', JSON.stringify(checkedValues));

                // Make AJAX request
                $.ajax({
                    type: "POST",
                    url: "insert_psalarystruc.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: response,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'updatesalary.php';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred!',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>


    <script>
        $("#submitBtn").click(function(event) {
            event.preventDefault();

            // Select the form with ID "form2"
            var form = $("#form2")[0];

            // Create form data object
            var formData = new FormData(form);

            // Make AJAX request
            $.ajax({
                type: "POST",
                url: "update_msalarystruc.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'updatesalary.php';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>




</body>

</html>
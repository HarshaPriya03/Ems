<?php

@include '../inc/config.php';

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.min.css">
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
            <form id="updateForm">
                <div>
                    <div style="display: flex; gap: 10px;">
                        <p style="margin-left: 20px; margin-top: 10px;">Employee Details:</p>

                        <div>
                            <input type="text" name="empname" id="empnameInput" list="empdatalist" onchange="getEmployeeDetails(this.value)" oninput="checkInput(this)" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;" autocomplete="off" />
                            <!-- <input type="text" name="empname" list="empdatalist" onchange="getEmployeeDetails(this.value)" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;" autocomplete="off" /> -->
                            <datalist id="empdatalist">
                                <option value="" style="font-weight: lighter;">Select Employee Name</option>
                                <?php
                                $sql = "SELECT DISTINCT empname FROM emp WHERE empstatus=0 ORDER BY emp_no ASC";
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
                        <div style="display: flex; gap: 10px;margin-top:10px; margin-left:50px;">

                            <select name="salarytype" style="font-size: 18px; width: 300px; height: 40px; margin-left: 20px; border-radius: 5px;">
                                <option style="font-weight: lighter;">Select Salary Type</option>
                                <option value="Probationary Salary">Probationary Salary</option>
                                <option value="Full-time Salary">Full-time Salary</option>
                                <option value="Contractual Salary">Contractual Salary</option>
                            </select>
                            <div>
                                <input name="dept" type="text" id="dept" style="font-size: 18px; width: 300px; height: 40px; margin-left: 350px; border-radius: 5px;" placeholder="Department">

                            </div>
                        </div>
                        <!-- <button   data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Enter Account Details
      </button> -->
                        <button style="display: none;margin-left:20px;margin-top:10px;" id="accountDetailsBtn" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Enter Account Details
                        </button>
                    </div>
                    <div style="z-index: 999" id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
                        <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">Account Details</h5>
                        <button onclick="window.location.reload()" type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close menu</span>
                        </button>
                        <div class="mb-6">
                            <label for="datepicker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary Bank Name:</label>
                            <select id="sbn" name="sbn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">--select--</option>
                                <option value="State Bank Of India">State Bank Of India (SBI)</option>
                                <option value="Punjab National Bank (PNB)">Punjab National Bank (PNB)</option>
                                <option value="Indian Bank (IB)">Indian Bank (IB)</option>
                                <option value="Bank Of India (BOI)">Bank Of India (BOI)</option>
                                <option value="UCO Bank">UCO Bank</option>
                                <option value="Union Bank Of India">Union Bank Of India</option>
                                <option value="Central Bank Of India">Central Bank Of India</option>
                                <option value="Bank Of Baroda">Bank Of Baroda</option>
                                <option value="Bank Of Maharashtra">Bank Of Maharashtra</option>
                                <option value="Canara Bank">Canara Bank</option>
                                <option value="Indian Overseas Bank">Indian Overseas Bank</option>
                                <option value="ICICI Bank">ICICI Bank</option>
                                <option value="HDFC Bank">HDFC Bank</option>
                                <option value="Axis Bank">Axis Bank</option>
                                <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                                <option value="Federal Bank">Federal Bank</option>
                                <option value="Karur Vysya Bank">Karur Vysya Bank</option>
                            </select>



                        </div>
                        <div class="mb-6">
                            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary Bank IFSC Code :</label>
                            <input type="text" name="sifsc" id="sifsc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-6">
                            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salary Bank Account Number :</label>
                            <input type="text" name="sban" id="sban" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-6">
                            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UAN :</label>
                            <input type="text" name="uan" id="uan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-6">
                            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">EPF Account Number :</label>
                            <input type="text" name="epfn" id="epfn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-6">
                            <label for="tdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ESIC Account Number :</label>
                            <input type="text" name="esin" id="esin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                    </div>

                </div>
                <div class="rectangle-div" style="margin-top:10px;height:5%;"></div>
                <div style="position: absolute; top: 100px; left:20px;">
                    <input name="ctcCalc" type="text" id="ctcCalc" style=" font-size: 18px; width: 150px;border-radius: 5px;" placeholder="Enter CTC">
                    <button onclick="calculateValues()" style="margin-left: 20px;" type="button" class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 ">
                        Calculate
                    </button>
                </div>




                <div class="rectangle-div" style="margin-top:55px;height:82%;"></div>
                <div>
                    <div style="position: absolute; top: 150px;">
                        <p style="text-align: center; font-size: 25px; padding-top: 20px;">Monthly Component</p>
                        <hr style="width: 101%;" />

                        <!-- Salary Details -->

                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Salary Details:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 160px; margin-top: -20px;">
                            <!--<div style="display: flex; margin-top: 10px;">-->
                            <!--    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>-->
                            <!--    <div style="display: flex; margin-left: 20px;">-->
                            <!--        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>-->
                            <!--        <input type="text" name="gs" id="gs" oninput="calculateAGS(); " style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">-->
                            <!--        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                                <div style="display: flex; margin-left: 86px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input type="text" name="bp" id="abp" oninput="calculateAABP(); calculatesumNet();" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                                <div style="display: flex; margin-left: 130px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input type="text" name="hra" id="hra" oninput="calculateAHRA(); calculatesumNet(); " style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Other Allowances:</label>
                                <div style="display: flex; margin-left: 25px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input type="text" name="oa" id="oa" oninput="calculateAOA(); calculatesumNet(); " style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
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
                                        <input type="text" name="epf1" id="epf1" oninput="calculateAEPF1(); calculatesumDeduc();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESI:</label>
                                    <div style="display: flex; margin-left: 70px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="esi1" id="esi1" oninput="calculateAESI1(); calculatesumDeduc();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
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
                                        <input type="text" name="epf2" id="epf2" oninput="calculateAEPF2(); calculatesumEmployer();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF Share:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="epf3" id="epf3" oninput="calculateAEPF3(); calculatesumEmployer();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
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
                                        <input type="text" name="esi2" id="esi2" oninput="calculateAESI2(); calculatesumEmployer();" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Basicpay after deductions -->
                        <!-- <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Basic pay after deductions:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 280px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex; margin-top: 10px;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                                    <div style="display: flex; margin-left: 67px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="abp" id="abp" oninput="calculateAABP(); calculatesumNet();" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <br>
                        <!-- Cross calc -->
                        <hr style="width: 103%;">
                        <div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">CTC:</label>
                                    <div style="display: flex; margin-left: 50px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="ctc" id="ctc" oninput="calculateACTC();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="tde" id="tde" oninput="calculateATDE();" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">NET Pay:</label>
                                    <div style="display: flex; margin-left: 15px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="netpay" id="netpay" oninput="calculateANETPAY();" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                                    <div style="display: flex; margin-left: 18px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="tes" id="tes" oninput="calculateATES();" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                        </div>
                    </div>
                </div>
                <!-- annual Component -->
                <div class="rectangle-div" style="margin-left: 700px;margin-top:55px;height:82%;"></div>
                <div>
                    <div style="position: absolute; top: 150px; margin-left: 700px;">
                        <p style="text-align: center; font-size: 25px; padding-top: 20px;">Annual Component</p>
                        <hr style="width: 101%;" />
                        <!-- Salary Details -->
                        <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Salary Details:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 160px; margin-top: -20px;">
                            <!--<div style="display: flex; margin-top: 10px;">-->
                            <!--    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>-->
                            <!--    <div style="display: flex; margin-left: 20px;">-->
                            <!--        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>-->
                            <!--        <input name="ags" id="ags" type="text" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">-->
                            <!--        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                                <div style="display: flex; margin-left: 86px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input name="abp" id="aabp" type="text" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                                <div style="display: flex; margin-left: 130px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input name="ahra" id="ahra" type="text" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Other Allowances:</label>
                                <div style="display: flex; margin-left: 25px;">
                                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                    <input name="aoa" id="aoa" type="text" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
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
                                        <input name="aepf1" id="aepf1" type="text" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESI:</label>
                                    <div style="display: flex; margin-left: 70px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="aesi1" id="aesi1" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
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
                                        <input type="text" name="aepf2" id="aepf2" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF Share:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="aepf3" id="aepf3" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
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
                                        <input type="text" name="aesi2" id="aesi2" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Basicpay after deductions -->
                        <!-- <div>
                            <p style="margin-left: 20px; margin-top: 10px;">Basic pay after deductions:</p>
                            <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 280px; margin-top: -20px;">
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex; margin-top: 10px;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                                    <div style="display: flex; margin-left: 67px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="aabp" id="aabp" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <br>
                        <!-- Cross calc -->
                        <hr style="width: 103%;">
                        <div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">CTC:</label>
                                    <div style="display: flex; margin-left: 50px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="actc" id="actc" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                                    <div style="display: flex; margin-left: 10px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="atde" id="atde" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">NET Pay:</label>
                                    <div style="display: flex; margin-left: 15px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="anetpay" id="anetpay" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                                    <div style="display: flex; margin-left: 18px;">
                                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                        <input type="text" name="ates" id="ates" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="udbtn" style="background-color: #FB8A0B; color: white; border: none; border-radius: 5px; width: 150px; height: 50px; font-size: 22px; margin-left: 610px; margin-top: 720px;">Submit</button>
        </div>
        </form>

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
        <a href="./payroll.html" class="payroll14" style="color: white; z-index:9999;">Payroll</a>
        <a class="reports14">Reports</a>
        <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

        <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



        <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

        <a class="dashboard14" href="./index.php" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
            <img class="vector-icon73" alt="" src="./public/vector7.svg" />
        </a>
        <a class="employee-list14" href="employee-management.php" id="employeeList">Employee List</a>
        <a class="akar-iconsdashboard14" href="./index.php" id="akarIconsdashboard">
            <img class="vector-icon74" alt="" src="./public/vector3.svg" />
        </a>
        <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves14" id="leaves" href="leave-management.php">Leaves</a>
        <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
            <img class="vector-icon75" alt="" src="./public/vector1.svg" />
        </a>
        <a class="onboarding16" id="onboarding" href="onboarding.php">Onboarding</a>
        <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
            <img class="vector-icon76" alt="" src="./public/vector.svg" />
        </a>
        <a class="attendance14" href="attendence.php" style="color: black;">Attendance</a>
        <a class="uitcalender14">
            <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
        </a>
        <div class="oouinext-ltr3"></div>
    </div>
    <script>
       function calculateValues() {
    var ctc = parseFloat(document.getElementById('ctcCalc').value);
    if (isNaN(ctc) || ctc <= 0) {
        alert('Please enter a valid CTC');
        return;
    }
    var bp = 0.5 * ctc;
    var hra = 0.25 * ctc;
    var oa = 0.25 * ctc;
    
    // Modified EPF calculations
    var epf1 = bp > 15000 ? 1800 : 0.12 * bp;
    var epf2 = bp > 15000 ? 1249.50 : 0.0833 * bp;
    var epf3 = bp > 15000 ? 550.50 : 0.0367 * bp;
    
    var esi1 = ctc > 21000 ? 0 : 0.0075 * ctc;
    var esi2 = ctc > 21000 ? 0 : 0.0325 * ctc;
    var netpay = bp + hra + oa - (epf1 + esi1);
    
    document.getElementById('abp').value = bp.toFixed(2);
    document.getElementById('hra').value = hra.toFixed(2);
    document.getElementById('oa').value = oa.toFixed(2);
    document.getElementById('epf1').value = epf1.toFixed(2);
    document.getElementById('esi1').value = esi1.toFixed(2);
    document.getElementById('epf2').value = epf2.toFixed(2);
    document.getElementById('epf3').value = epf3.toFixed(2);
    document.getElementById('esi2').value = esi2.toFixed(2);
    document.getElementById('netpay').value = netpay.toFixed(2);
    document.getElementById('ctc').value = ctc.toFixed(2);
    document.getElementById('tde').value = (epf1 + esi1).toFixed(2);
    document.getElementById('tes').value = (epf2 + epf3 + esi2).toFixed(2);
    
    // annual component
    var abp = bp * 12;
    var ahra = hra * 12;
    var aoa = oa * 12;
    var aepf1 = epf1 * 12;
    var aesi1 = esi1 * 12;
    var aepf2 = epf2 * 12;
    var aepf3 = epf3 * 12;
    var aesi2 = esi2 * 12;
    var anetpay = netpay * 12;
    var actc = ctc * 12;
    var atde = (epf1 + esi1) * 12;
    var ates = (epf2 + epf3 + esi2) * 12;
    
    document.getElementById('aabp').value = abp.toFixed(2);
    document.getElementById('ahra').value = ahra.toFixed(2);
    document.getElementById('aoa').value = aoa.toFixed(2);
    document.getElementById('aepf1').value = aepf1.toFixed(2);
    document.getElementById('aesi1').value = aesi1.toFixed(2);
    document.getElementById('aepf2').value = aepf2.toFixed(2);
    document.getElementById('aepf3').value = aepf3.toFixed(2);
    document.getElementById('aesi2').value = aesi2.toFixed(2);
    document.getElementById('anetpay').value = anetpay.toFixed(2);
    document.getElementById('actc').value = actc.toFixed(2);
    document.getElementById('atde').value = atde.toFixed(2);
    document.getElementById('ates').value = ates.toFixed(2);
}
    </script>
    <script>
        function calculateAGS() {
            var gsValue = document.getElementById("gs").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("ags").value = agsValue;
        }


        function calculateAHRA() {
            var gsValue = document.getElementById("hra").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("ahra").value = agsValue;
        }

        function calculateAOA() {
            var gsValue = document.getElementById("oa").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aoa").value = agsValue;
        }

        function calculateAEPF1() {
            var gsValue = document.getElementById("epf1").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aepf1").value = agsValue;
        }

        function calculateAESI1() {
            var gsValue = document.getElementById("esi1").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aesi1").value = agsValue;
        }

        function calculateAEPF2() {
            var gsValue = document.getElementById("epf2").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aepf2").value = agsValue;
        }

        function calculateAEPF3() {
            var gsValue = document.getElementById("epf3").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aepf3").value = agsValue;
        }

        function calculateAESI2() {
            var gsValue = document.getElementById("esi2").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aesi2").value = agsValue;
        }

        function calculateAABP() {
            var gsValue = document.getElementById("abp").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("aabp").value = agsValue;
        }

        function calculateACTC() {
            var gsValue = document.getElementById("ctc").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("actc").value = agsValue;
        }

        function calculateANETPAY() {
            var gsValue = document.getElementById("netpay").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("anetpay").value = agsValue;
        }

        function calculateATDE() {
            var gsValue = document.getElementById("tde").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("atde").value = agsValue;
        }

        function calculateATES() {
            var gsValue = document.getElementById("tes").value;
            var agsValue = parseFloat(gsValue) * 12;
            document.getElementById("ates").value = agsValue;
        }
    </script>
    <script>
        function calculateCTC() {
            var abpValue = parseFloat(document.getElementById("abp").value) || 0;
            var hraValue = parseFloat(document.getElementById("hra").value) || 0;
            var oaValue = parseFloat(document.getElementById("oa").value) || 0;
            var epf1Value = parseFloat(document.getElementById("epf1").value) || 0;
            // var esi1Value = parseFloat(document.getElementById("esi1").value) || 0;
            // var epf2Value = parseFloat(document.getElementById("epf2").value) || 0;
            // var epf3Value = parseFloat(document.getElementById("epf3").value) || 0;
            // var esi2Value = parseFloat(document.getElementById("esi2").value) || 0;

            var tsum = abpValue + hraValue + oaValue;
            document.getElementById("ctc").value = tsum;
            calculateACTC();
        }


        function calculatesumDeduc() {
            var epf1Value = parseFloat(document.getElementById("epf1").value) || 0;
            var esi1Value = parseFloat(document.getElementById("esi1").value) || 0;

            var sum = epf1Value + esi1Value;
            document.getElementById("tde").value = sum;
            calculateCTC();
            calculateATDE();
            calculatesumNet();
        }

        function calculatesumEmployer() {
            var epf2Value = parseFloat(document.getElementById("epf2").value) || 0;
            var epf3Value = parseFloat(document.getElementById("epf3").value) || 0;
            var esi2Value = parseFloat(document.getElementById("esi2").value) || 0;

            var sum = epf2Value + epf3Value + esi2Value;
            document.getElementById("tes").value = sum;
            calculateCTC();
            calculateATES();
        }


        function calculatesumNet() {
            var abpValue = parseFloat(document.getElementById("abp").value) || 0;
            var hraValue = parseFloat(document.getElementById("hra").value) || 0;
            var oaValue = parseFloat(document.getElementById("oa").value) || 0;
            var epf1Value = parseFloat(document.getElementById("epf1").value) || 0;
            var esi1Value = parseFloat(document.getElementById("esi1").value) || 0;

            var sum = abpValue + hraValue + oaValue - (epf1Value + esi1Value);
            document.getElementById("netpay").value = sum;
            calculateCTC();
            calculateANETPAY();
        }
    </script>
    <script>
        const form = document.getElementById('autoform');

        form.addEventListener('submit', e => {

            e.preventDefault();

            console.clear();
            console.log('Submit disabled. Data:');

            const data = new FormData(form);

            for (let nv of data.entries()) {
                console.log(`${ nv[0] }: ${ nv[1] }`);
            }

        });
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

                    var option = document.querySelector('#sbn option[value="' + response.sbn + '"]');
                    if (option) {
                        option.selected = true;
                    } else {
                        console.error('Option with value "' + response.sbn + '" not found in the dropdown.');
                    }

                    document.getElementById("sifsc").value = response.sifsc;
                    document.getElementById("sban").value = response.sban;
                    document.getElementById("uan").value = response.uan;
                    document.getElementById("epfn").value = response.epfn;
                    document.getElementById("esin").value = response.esin;
                }
            };
            xhttp.open("GET", "get_employee_details.php?empname=" + empname, true);
            xhttp.send();
        }

        function checkInput(input) {
            var datalist = document.getElementById("empdatalist");
            var button = document.getElementById("accountDetailsBtn");
            var options = datalist.querySelectorAll("option");
            var found = false;
            for (var i = 0; i < options.length; i++) {
                if (input.value.trim() === options[i].value) {
                    found = true;
                    break;
                }
            }
            if (input.value.trim() !== "" && !found) {
                button.style.display = "inline-flex";
            } else {
                button.style.display = "none";
            }
        }
    </script>
    <!-- <script>
        function getEmployeeDetails(empname) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    document.getElementById("emp_no").value = response.emp_no;
                    document.getElementById("desg").value = response.desg;
                }
            };
            xhttp.open("GET", "get_employee_details.php?empname=" + empname, true);
            xhttp.send();
        }
    </script> -->
    <script>
        function myFunction() {
            document.getElementById("updateForm").reset();
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#updateForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "insert_msalarystruc.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: response,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'salarystructure.php';
                            }
                        });
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "insert_ban.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: response,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'salarystructure.php';
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
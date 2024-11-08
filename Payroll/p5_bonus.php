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

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.min.css">
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

        ol {
            display: flex;
            justify-content: center;
            margin-left: 200px;
            ;
        }
    </style>
</head>

<body>
    <div class="attendence4">
        <div class="bg14"></div>
        <!-- <div class="rectangle-parent22" style="margin-left: -80px;">
            <div class="frame-child187" style="margin-left: 80px;"></div>
            <a class="frame-child188" href="updatesalary.html" style="background-color: #e8e8e8;"> </a>
            <a class="frame-child189" id="rectangleLink1" href="lop.html"> </a>
            <a class="frame-child190" id="rectangleLink2" style="background-color: #ffe2c6;" href="bonus.html"> </a>
            <a class="frame-child191" id="rectangleLink3" href="misc.php"> </a>
            <a class="frame-child191" id="rectangleLink3" href="loans.php" style="margin-left: 220px; "> </a>
            <a class="attendence5" style="margin-left: -7px; width: 140px; color: black; margin-top: -4px;" href="updatesalary.html">Update Salary</a>
            <a class="records5" id="records" style="margin-left: -10px; width: 110px; margin-top: -4px;" href="lop.html">Loss Of Pay</a>
            <a class="punch-inout4" id="punchINOUT" style="margin-left: 40px; margin-top: -4px; color: #ff6e24;" href="bonus.html">Bonus</a>
            <a class="my-attendence4" href="misc.php" id="myAttendence" style="margin-left: -1px; width: 200px; margin-top: -4px; ">Misc. Deductions</a>
            <a class="my-attendence4" href="loans.php" id="myAttendence" style="margin-left: 270px;  margin-top: -4px;">Loans</a>
        </div> -->
        <ol class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse" style="position: absolute; margin-top: 81px;">

            <li class="flex items-center text-green-400 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400" style="background-color: #dbffd6; border: 1px solid rgb(127, 255, 127);">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="10" height="10" viewBox="0,0,256,256">
                        <g transform="">
                            <g fill="#1eff1e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                <g transform="scale(8.53333,8.53333)">
                                    <path d="M26.98047,5.99023c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-15.29297,15.29297l-6.29297,-6.29297c-0.25082,-0.26124 -0.62327,-0.36647 -0.97371,-0.27511c-0.35044,0.09136 -0.62411,0.36503 -0.71547,0.71547c-0.09136,0.35044 0.01388,0.72289 0.27511,0.97371l7,7c0.39053,0.39037 1.02353,0.39037 1.41406,0l16,-16c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988z"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
                Salary Details

                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-green-400 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400" style="background-color: #dbffd6; border: 1px solid rgb(127, 255, 127);">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="10" height="10" viewBox="0,0,256,256">
                        <g transform="">
                            <g fill="#1eff1e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                <g transform="scale(8.53333,8.53333)">
                                    <path d="M26.98047,5.99023c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-15.29297,15.29297l-6.29297,-6.29297c-0.25082,-0.26124 -0.62327,-0.36647 -0.97371,-0.27511c-0.35044,0.09136 -0.62411,0.36503 -0.71547,0.71547c-0.09136,0.35044 0.01388,0.72289 0.27511,0.97371l7,7c0.39053,0.39037 1.02353,0.39037 1.41406,0l16,-16c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988z"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
                Leave Adjustments

                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-green-400 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400" style="background-color: #dbffd6; border: 1px solid rgb(127, 255, 127);">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="10" height="10" viewBox="0,0,256,256">
                        <g transform="">
                            <g fill="#1eff1e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                <g transform="scale(8.53333,8.53333)">
                                    <path d="M26.98047,5.99023c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-15.29297,15.29297l-6.29297,-6.29297c-0.25082,-0.26124 -0.62327,-0.36647 -0.97371,-0.27511c-0.35044,0.09136 -0.62411,0.36503 -0.71547,0.71547c-0.09136,0.35044 0.01388,0.72289 0.27511,0.97371l7,7c0.39053,0.39037 1.02353,0.39037 1.41406,0l16,-16c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988z"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
                Loan Repayments

                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-green-400 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400" style="background-color: #dbffd6; border: 1px solid rgb(127, 255, 127);">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="10" height="10" viewBox="0,0,256,256">
                        <g transform="">
                            <g fill="#1eff1e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                <g transform="scale(8.53333,8.53333)">
                                    <path d="M26.98047,5.99023c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-15.29297,15.29297l-6.29297,-6.29297c-0.25082,-0.26124 -0.62327,-0.36647 -0.97371,-0.27511c-0.35044,0.09136 -0.62411,0.36503 -0.71547,0.71547c-0.09136,0.35044 0.01388,0.72289 0.27511,0.97371l7,7c0.39053,0.39037 1.02353,0.39037 1.41406,0l16,-16c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988z"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
                Other Deductions

                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>

            <li class="flex items-center text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                    5
                </span>
                Bonus Allocation
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    6
                </span>
                Review Salary Structure
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    7
                </span>
                Confirm Salary
            </li>
        </ol>
        <div class="rectangle-parent23">
            <div id="marketing-banner" style="position:absolute; top:-30px; margin-left:-235px;" tabindex="-1" class="flex justify-between w-[calc(110%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
                <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
                    <a href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
                        <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
                        </svg>

                    </a>
                    <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">In this step, HR should allocate any bonuses to eligible employees based on company policies and performance criteria. This includes calculating bonus amounts, determining eligibility, and allocating bonus to employees.
                    </p>
                </div>
            </div>
            <a href="p4_misc.php" style="position:absolute; right:220px;"><button type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-2 mb-2">
                    <svg style="margin-right:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                    </svg>

                    Previous
                </button></a>
            <?php
            $sql = "SELECT smonth FROM payroll_schedule WHERE status = 4 LIMIT 1";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $smonth = $row["smonth"];
            } else {
                $smonth = "No month found with status = 0";
            }
            ?>
            <form id="employeeForm">
                <input type="hidden" name="status" value=5>
                <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
                <a style="position:absolute; right:0;">
                    <button id="steps" type="submit" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-3 mb-2">
                        <svg class="w-6 h-6 me-2 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                        </svg>
                        Confirm & Next
                        <svg style="margin-left:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>
                    </button>
                </a>
            </form>


            <div style=" height: 350px; overflow-y: auto;">
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
                                                            <td class="px-6 py-4"><input type="checkbox" class="absentCheckbox" name="absentCheckbox[]" value="<?php echo $result['empname'] ?>"></td>
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
                                        $sql = "SELECT id, bonus, amt FROM payroll_bonus";
                                        $result = $con->query($sql);

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
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 ">
                                <td colspan="9">
                                    <div class="inline-flex self-center items-center" style="padding:10px;">
                                        <button data-modal-target="default-modals" data-modal-toggle="default-modals" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            + Allocate Bonus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3">

                                </th>
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
          $sql = "SELECT emp.*, payroll_bonusamt.*
          FROM emp
          INNER JOIN payroll_bonusamt ON emp.empname = payroll_bonusamt.empname
          INNER JOIN payroll_schedule ON payroll_bonusamt.paymonth = payroll_schedule.smonth
          WHERE payroll_schedule.approval = 0
          ORDER BY payroll_bonusamt.ID ASC;";
  
                        $que = mysqli_query($con, $sql);

                        if (mysqli_num_rows($que) > 0) {
                            while ($result = mysqli_fetch_assoc($que)) {
                        ?>
                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4">
                                            <img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;">
                                        </td>
                                        <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                                        <td class="px-6 py-4"> <?php echo $result['bonus']; ?></td>
                                        <td class="px-6 py-4"><?php echo $result['amt']; ?></td>
                                        <td class="px-6 py-4"><?php echo $result['paymonth']; ?></td>
                                        <td class="px-6 py-4"><?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($result['created']))); ?></td>

                                    </tr>
                                </tbody>
                            <?php
                            }
                        } else {
                            ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td colspan="8" class="px-6 py-4 text-center">No data</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

        <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />
        <a class="anikahrm14" href="./index.html" id="anikaHRM">
            <span>Anika</span>
            <span class="hrm14">HRM</span>
        </a>
        <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
        <button class="attendence-inner"></button>
        <div class="logout14">Logout</div>
        <a class="payroll14" href="payroll.php" style="color: white; z-index:9999;">Payroll</a>
        <div class="reports14">Reports</div>
        <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

        <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


        <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

        <a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
            <img class="vector-icon73" alt="" src="./public/vector7.svg" />
        </a>
        <a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>
        <a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">
            <img class="vector-icon74" alt="" src="./public/vector3.svg" />
        </a>
        <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves14" id="leaves" style="z-index: 99999;" href="../leave-management.php">Leaves</a>
        <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
            <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
        </a>
        <a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>
        <a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">
            <img class="vector-icon76" alt="" src="./public/vector.svg" />
        </a>
        <a class="attendance14" href="../attendence.php" style="color: black; z-index: 99999;">Attendance</a>
        <a class="uitcalender14">
            <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="./public/vector11.svg" />
        </a>
        <div class="oouinext-ltr3"></div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#steps').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'update_steps.php',
                data: new FormData($('#employeeForm')[0]),
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Confirmed!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'p6_finalstatement_vsp.php';
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
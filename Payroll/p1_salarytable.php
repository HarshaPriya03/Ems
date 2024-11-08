<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../loginpage.php");
    exit();
}

// Connect to MySQL
@include '../inc/config.php';
$currentDate = date("Y-m-d");
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module ID for the payroll module
$sql_payroll_module = "SELECT id FROM modules WHERE module_name = 'payroll'";
$result_payroll_module = mysqli_query($con, $sql_payroll_module);
$payroll_module = mysqli_fetch_assoc($result_payroll_module);

// Retrieve the logged-in user's email
$email = $_SESSION['email'];

// Check if the logged-in user has access to the payroll module
$sql_check_access = "SELECT COUNT(*) AS count FROM user_modules WHERE email = '$email' AND module_id = " . $payroll_module['id'];
$result_check_access = mysqli_query($con, $sql_check_access);
$row_check_access = mysqli_fetch_assoc($result_check_access);

if ($row_check_access['count'] == 0) {
    // If the user doesn't have access to the payroll module, redirect them to the dashboard or display an error message
    header("Location: ../loginpage.php");
    exit();
}

// If the user has access to the payroll module, continue loading the payroll page
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .udbtn:hover {
            color: black !important;
            background-color: white !important;
            outline: 1px solid #F46114;
        }

        .hidden-btn {
            display: none;
        }

        tr:hover .hidden-btn {
            display: block;
            transition: 300ms ease all;
        }

        tr:hover .hideon1 {
            display: none;
            transition: 300ms ease all;
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
        <ol class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse" style="position: absolute; margin-top: 81px;">
            <li class="flex items-center text-blue-600 dark:text-blue-500">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                    1
                </span>
                Salary Details
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    2
                </span>
                Leave Adjustments
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    3
                </span>
                Loan Repayments
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    4
                </span>
                Other Deductions
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
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
        <div class="rectangle-parent23" style="margin-top: 0px;">


            <div id="marketing-banner" style="position:absolute; top:-30px; margin-left:-240px;" tabindex="-1" class="z-9 flex justify-between w-[calc(110%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
                <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
                    <span class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
                        <svg class="w-10 h-10 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
                        </svg>
                    </span>

                    <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">In this step, HR should review the fixed salary components for each employee, ensuring accuracy and completeness. This includes regular salary components such as basic pay, allowances, and any other fixed earnings.

                    </p>
                </div>
            </div>
            <?php
            $sql = "SELECT smonth FROM payroll_schedule WHERE status = 0 LIMIT 1";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $smonth = $row["smonth"];
            } else {
                $smonth = "No month found with status = 0";
            }
            ?>
            <form id="employeeForm">
                <input type="hidden" name="status" value=1>
                <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
                <a style="position:absolute; right:0;">
                    <button type="submit" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-3 mb-2">
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

            <div style="overflow-y:auto; height:750px; margin-top:50px;">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead style="position:sticky;top:0;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr style="border-top: 1px solid rgb(224, 224, 224);">
                        <th colspan="2" style="text-align: center;" scope="col" class="px-6 py-3">
                            Employee Details
                        </th>
                        <th colspan="3" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.5);" scope="col" class="px-6 py-3">
                            Earnings
                        </th>
                        <th style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.5);" scope="col" class="px-6 py-3">
                            Additions
                        </th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 161, 161, 0.5);" class="px-6 py-3">
                            Deductions
                        </th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.5);" class="px-6 py-3">
                           CTC
                        </th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.5);" class="px-6 py-3">
                            NET Payable
                        </th>
                    </tr>
                    <tr style="border-top: 1px solid rgb(224, 224, 224);">
                        <th scope="col" colspan="2" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);" class="px-6 py-3">Employee Name</th>
                        <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Basic Pay</th>
                        <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">HRA</th>
                        <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Other Allowances</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Pension, Bonus, ...</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">EPF, ESI, ...</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.2);" class="px-6 py-3">GROSS Pay</th>
                        <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.2);" class="px-6 py-3">Total Payable</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT p.*, emp.*,
                COALESCE(emp.pic, 'default_pic.jpg') AS pic, 
                pa.*
         FROM payroll_msalarystruc AS p
         LEFT JOIN emp ON p.empname = emp.empname
         LEFT JOIN payroll_msalarystruc AS pa ON p.empname = pa.empname
         ORDER BY p.emp_no ASC;
         ";

                $que = mysqli_query($con, $sql);
                $cnt = 1;
                while ($result = mysqli_fetch_assoc($que)) {
                    $total_eycontributions = $result['epf2'] + $result['epf3'] + $result['esi2'];
                    $total_empcontributions = $result['epf1'] + $result['esi1'];
                ?>
                    <tbody>
                        <tr style="border-top: 1px solid rgb(224, 224, 224);" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4">
                                <img src="../pics/<?php echo $result['pic']; ?>" style="border-radius: 50%; height: 50px; width: 50px;" alt="N/A">
                            </td>
                            <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);">
                                <?php echo $result['empname']; ?> <br>
                                <span style="font-size: 13px; text-align: left; color: rgb(179, 179, 179);"><?php echo $result['desg']; ?></span>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600; text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
                                <?php echo $result['bp']; ?>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600; text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                                <?php echo $result['hra']; ?>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600; text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                                <?php echo $result['oa']; ?>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600; text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);">

                                <span class="hideon1"><?php echo $total_eycontributions ?></span>
                                <button data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Additions
                                </button>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600; text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);">
                                <span class="hideon1"><?php echo $total_empcontributions ?></span>
                                <button data-modal-target="default-modal" data-modal-toggle="default-modal" id="<?php echo $result['empname']; ?>" class="edit_data5 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Deductions
                                </button>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600;text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.2);">
                                <?php echo $result['ctc']; ?>
                            </td>
                            <td class="px-6 py-4" style="font-weight:600; text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(203, 197, 252, 0.2);">
                                <?php echo $result['netpay']; ?>
                            </td>
                        </tr>
                    <?php $cnt++;
                } ?>
                    </tbody>
                    <?php
                    $sql = "SELECT 
                     (SELECT SUM(epf2) FROM payroll_msalarystruc) AS total_epf2, 
                     (SELECT SUM(epf3) FROM payroll_msalarystruc) AS total_epf3, 
                     (SELECT SUM(esi2) FROM payroll_msalarystruc) AS total_esi2, 
            (SELECT SUM(esi1) FROM payroll_msalarystruc) AS total_esi1, 
            (SELECT SUM(epf1) FROM payroll_msalarystruc) AS total_epf1, 
            (SELECT SUM(netpay) FROM payroll_msalarystruc) AS total_netpay, 
            (SELECT SUM(oa) FROM payroll_msalarystruc) AS total_oa, 
           (SELECT SUM(hra) FROM payroll_msalarystruc) AS total_hra, 
           (SELECT SUM(ctc) FROM payroll_msalarystruc) AS total_ctc, 
           (SELECT SUM(bp) FROM payroll_msalarystruc) AS total_abp";

                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $total_abp = $row['total_abp'];
                        $total_hra = $row['total_hra'];
                        $total_oa = $row['total_oa'];
                        $total_netpay = $row['total_netpay'];
                        $total_epf1 = $row['total_epf1'];
                        $total_esi1 = $row['total_esi1'];
                        $total_empcontributions = $total_epf1 + $total_esi1;
                        $total_epf2 = $row['total_epf2'];
                        $total_esi2 = $row['total_esi2'];
                        $total_epf3 = $row['total_epf3'];
                        $total_ctc =  $row['total_ctc'];
                        $total_eycontributions = $total_epf2 + $total_epf3 + $total_esi2;
                    } else {
                        echo "Error executing query: " . mysqli_error($con);
                    }
                    mysqli_free_result($result);
                    ?>

                    <tfoot style="position:sticky;bottom:0;"  class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1px solid rgb(224, 224, 224); font-weight: 500;"></td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_abp ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1px solid rgb(224, 224, 224); font-weight: 500;">₹ <?php echo $total_hra ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1px solid rgb(224, 224, 224); font-weight: 500;">₹ <?php echo $total_oa ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_eycontributions ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_empcontributions ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_ctc ?>/-</td>
                        <td class="px-6 py-4" style="text-align: center; font-size: 15px; border-left: 1.5px solid rgb(160, 160, 160); font-weight: 500;">₹ <?php echo $total_netpay ?>/-</td>
                    </tfoot>
            </table>
            </div>

            <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                Deductions Summary <br>
                                <!-- <span style="font-size: 16px; font-weight: normal;">jan 15, 2024</span> -->
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4" id="info_update5">
                            <?php @include("view_salaryded.php"); ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Additions Summary <br>
                                <!-- <span style="font-size: 16px; font-weight: normal;">jan 15, 2024</span> -->
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modals">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4" id="info_update6">
                            <?php @include("view_salaryadd.php"); ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <!-- <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button> -->
                            <button data-modal-hide="default-modals" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
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
    <a href="./payroll.php" class="payroll14" style="color: white; z-index:9999; font-size:25px; margin-top:-6px; font-weight:350;">Payroll</a>
    <a class="reports14" style="font-size:25px; margin-top:-6px; font-weight:350;">Reports</a>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="../index.php" id="dashboard" style=" font-size:25px; margin-top:-6px; font-weight:350;">Dashboard</a>
    <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
        <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" href="../employee-management.php" id="employeeList" style=" font-size:25px; margin-top:-6px; font-weight:350;">Employee List</a>
    <a class="akar-iconsdashboard14" href="../index.php" id="akarIconsdashboard">
        <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" href="../leave-management.php" style=" font-size:25px; margin-top:-6px; font-weight:350;">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
        <img class="vector-icon75" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" id="onboarding" href="../onboarding.php" style=" font-size:25px; margin-top:-6px; font-weight:350;">Onboarding</a>
    <a class="fluent-mdl2leave-user14" id="fluentMdl2leaveUser">
        <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" href="../attendence.php" style="color: black; font-size:25px; margin-top:-6px; font-weight:350;">Attendance</a>
    <a class="uitcalender14">
        <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#employeeForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'update_steps.php',
                    data: new FormData(this),
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
                                window.location.href = 'p2_lop.php';
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.edit_data5', function() {
                var edit_id5 = $(this).attr('id');
                $.ajax({
                    url: "view_salaryded.php",
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

            $(document).on('click', '[data-modal-hide="default-modal"]', function() {
                $("#default-modal").removeClass("show");
                $("body").removeClass("modal-open");
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.edit_data6', function() {
                var edit_id5 = $(this).attr('id');
                $.ajax({
                    url: "view_salaryadd.php",
                    type: "post",
                    data: {
                        edit_id5: edit_id5
                    },
                    success: function(data) {
                        $("#info_update6").html(data);
                        $("body").addClass("modal-open");
                    }
                });
            });

            $(document).on('click', '[data-modal-hide="default-modals"]', function() {
                $("#default-modals").removeClass("show");
                $("body").removeClass("modal-open");
            });

        });
    </script>
</body>

</html>
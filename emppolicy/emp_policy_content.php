<?php
@include 'inc/config.php';
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}


$policy_title = isset($_GET['policy_title']) ? $_GET['policy_title'] : '';
$policyno = isset($_GET['policyno']) ? $_GET['policyno'] : '';
$version = isset($_GET['version']) ? $_GET['version'] : '';
?>
<?php
$user_email = $_SESSION['user_name'];
$sql = "SELECT * FROM emp WHERE empemail = '$user_email' ";
$result = $con->query($sql);
$row = $result->fetch_assoc();

$dept = $row['dept'];
$empname = $row['empname'];
?>
<?php
$policy_title = mysqli_real_escape_string($con, $_GET['policy_title']);
$policyno = mysqli_real_escape_string($con, $_GET['policyno']);
$version = mysqli_real_escape_string($con, $_GET['version']);

$check_sql = "SELECT * FROM policy_opens WHERE policy_title = '$policy_title' AND policyno = '$policyno' AND version = '$version'";
$check_result = mysqli_query($con, $check_sql);

if (!$check_result) {
    die('Error checking record: ' . mysqli_error($con));
}

if (mysqli_num_rows($check_result) > 0) {
    $fetch_sql = "SELECT * FROM policy_opens WHERE policy_title = '$policy_title' AND policyno = '$policyno' AND version = '$version' AND empname = '$empname' ";
    $fetch_result = mysqli_query($con, $fetch_sql);

    if (!$fetch_result) {
        die('Error fetching record: ' . mysqli_error($con));
    }

    $fetch_row = mysqli_fetch_assoc($fetch_result);
    $last_opened = $fetch_row['last_opened'];

    $update_sql = "UPDATE policy_opens SET recent_opened = '$last_opened', open_count = open_count + 1 WHERE policy_title = '$policy_title' AND policyno = '$policyno' AND version = '$version' AND empname = '$empname'";
    $update_result = mysqli_query($con, $update_sql);

    if (!$update_result) {
        die('Error updating record: ' . mysqli_error($con));
    }
} else {
    $insert_sql = "INSERT INTO policy_opens (empname,policy_title, policyno, version, open_count) VALUES ('$empname', '$policy_title', '$policyno', '$version', 1)";
    $insert_result = mysqli_query($con, $insert_sql);

    if (!$insert_result) {
        die('Error inserting record: ' . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PolicyMaker</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
           .TopBar{
           background: rgb(255,156,72);
           background: linear-gradient(173deg, rgba(255,156,72,1) 0%, rgba(255,121,0,1) 95%);
           width: 100%;
           margin-top: -10px;
           height: 80px;
           display: flex;
       }
       .logoimg{
           width: 70px;
           height: 70px;
           margin-left: 20px;
           margin-top: 10px;
           -webkit-filter: invert(100%);
           filter: invert(100%);
       }
       .AnikaHRM{
           color: white;
           font-size: 32px;
           margin-top: 23px;
           font-weight: 500;
       }
       .AnikaHRM span{
           color: rgb(4, 160, 4);
       }
       .heading{
           font-size: 35px;
           color: white;
           margin-top: 20px; 
           margin-left: 550px;
       }
       .answersdiv{
        background-color: rgb(255, 255, 255);
        width: 60%;
        margin-left: auto;
        margin-right: auto;
       }
       .h2heading{
        font-weight: 400;
        font-size: 28px;
       }
       .ppara{
        text-align: justify;
       }
       .ansimg{
        display: block;
        margin-left: auto;
        margin-right: auto;
       }

        ::-webkit-scrollbar {
            width: 5px;

        }

        ::-webkit-scrollbar-track {
            background-color: #ebebeb;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #0867C6;
        }

        body {
            overflow: hidden;
        }

        .maindash {
            background-color: #F4F4FA;
            margin-top: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
            padding: 10px;
            height: 83vh;
            display: flex;
            gap: 10px;
        }

        .policieslist {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .polidiv {
            background-color: white;
            padding: 10px;
            border-radius: 7px;
            width: 260px;
            display: flex;
            gap: 60px;
            border: 1px solid rgb(224, 224, 224);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
        }

        .polidiv1 {
            background-color: white;
            padding: 10px;
            border-radius: 7px;
            width: 280px;
            display: flex;
            gap: 60px;
            border: 1px solid rgb(224, 224, 224);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
        }

        .infograph {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .chart {
            background-color: white;
            width: 39.3%;
            border: 1px solid rgb(224, 224, 224);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 400px;
        }

        .chart1 {
            margin-top: 10px;
            background-color: white;
            width: 39.3%;
            border: 1px solid rgb(224, 224, 224);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 350px;
        }

        .live {
            background-color: white;
            width: 20%;
            border: 1px solid rgb(224, 224, 224);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 400px;
        }

        .live1 {
            margin-top: 10px;
            background-color: white;
            width: 60%;
            border: 1px solid rgb(224, 224, 224);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 350px;
        }

        .topdiv {
            background-color: #F4f4fa;
            padding: 10px;
            border-bottom: 1px solid rgb(224, 224, 224);
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .enable {
            display: flex;
            float: right;
            gap: 7px;
            margin-right: 10px;
            margin-top: -30px;
        }

        .policy {
            display: flex;
            margin-left: 10px;
        }

        .summ {
            font-size: 16px;
            margin-left: 10px;
        }

        .lastdiv {
            display: flex;
            gap: 10px;
        }

        .maintab {
            height: 815px;
            overflow-y: auto;
        }

        .backbtn {
            background-color: #FBFAFB;
            position: absolute;
            right: 100px;
            padding: 10px 15px;
            border-radius: 7px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .reloadbtn {
            background-color: #FBFAFB;
            position: absolute;
            right: 40px;
            padding: 10px 15px;
            border-radius: 7px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .rejectbtn {
            position: absolute;
            right: 160px;
            background-color: rgb(255, 222, 222);
            color: rgb(255, 41, 41);
            border: 1px solid rgb(255, 41, 41);
            width: 80px;
            height: 40px;
            border-radius: 5px;
            text-align: center;
            margin-top: 5px;
        }

        .publishbtn {
            position: absolute;
            right: 250px;
            background-color: rgb(222, 255, 222);
            color: rgb(14, 145, 14);
            border: 1px solid rgb(14, 145, 14);
            width: 80px;
            height: 40px;
            border-radius: 5px;
            margin-top: 5px;
        }

        .addpolbtn {
            position: absolute;
            right: 160px;
            margin-top: 2px;
        }

        .topbardetails {
            background-color: #036CD0;
            border-radius: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 30px;
            margin-right: 10px;
        }

        .detaildiv {
            display: flex;
            margin-left: 400px;
            gap: 20px;
            border: 1px solid rgb(224, 224, 224);
            padding: 10px;
            border-radius: 5px;
        }

        .leftdiv {
            background-color: white;
            width: 20%;
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }

        .rightdiv {
            background-color: white;
            width: 79.6%;
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
            overflow-x: scroll;
        }

        .flexi {
            display: flex;
            font-size: 24px;
            margin-top: 20px;
            margin-left: 20px;
        }

        .flexi1 {
            margin-left: 20px;
        }

        .det12 {
            float: right;
            margin-right: 20px;
            margin-top: -60px;
            font-weight: 400;
            color: rgb(214, 214, 214);
        }

        .det21 {
            float: right;
            margin-right: 20px;
            margin-top: -30px;
            display: flex;
        }

        .hoirz {
            margin-top: 25px;
        }

        @media only screen and (max-width: 900px) {
            .policieslist {
                gap: 10px;
            }

            .live {
                width: 40%;
            }

            .infograph {
                flex-direction: column;
            }

            .chart {
                width: 100%;
            }

            .chart1 {
                width: 100%;
            }

            .live {
                width: 100%;
            }

            .maindash {
                height: 100%;
            }

            body {
                overflow: auto;
            }

            .lastdiv {
                flex-direction: column;
                gap: 0px;
            }

            .live1 {
                width: 100%;
            }

            .detaildiv {
                display: none;
            }

            .maindash {
                height: 100%;
            }
        }
        @media only screen and (max-width: 600px) {
       .TopBar{
           flex-direction: column;
           height: 90px;
       }
       .logoimg{
           width: 50px;
           height: 50px;
           margin-top: 30px;
       }
       .AnikaHRM{
           text-align: center;
           font-size: 22px;
           margin-top: -54px;
       }
       .heading{
           color: rgb(255, 255, 255);
           margin-left: auto;
           margin-right: auto;
           font-size: 22px;
           margin-top: -7px;
       }
       .answersdiv{
        width: 90%;
       }
       .ppara{
        text-align: justify;
       }
       .ansimg{
        width: 100%;
       }
       .h2heading{
        font-size: 25px;
       }
   }
        @media only screen and (max-width: 600px) {
            .policieslist {
                gap: 10px;
            }

            .live {
                width: 40%;
            }

            .infograph {
                flex-direction: column;
            }

            .chart {
                width: 100%;
            }

            .chart1 {
                width: 100%;
            }

            .live {
                width: 100%;
            }

            .maindash {
                height: 100%;
            }

            .enable {
                margin-right: 0px;
            }

            .policy {
                margin-left: 0px;
            }

            .summ {
                font-size: 14px;
                margin-left: 0px;
            }

            body {
                overflow: auto;
            }

            .lastdiv {
                flex-direction: column;
                gap: 0px;
            }

            .live1 {
                width: 100%;
            }

            .backbtn {
                scale: 0.8;
                right: 50px;
            }

            .reloadbtn {
                scale: 0.8;
                right: 7px;
            }

            .addpolbtn {
                scale: 0.8;
                right: 94px;
            }

            .topbardetails {
                scale: 0.8;
                margin-left: 0px;
                margin-right: 0px;
            }

            .detaildiv {
                display: none;
            }

            .maindash {
                height: 82svh;
                flex-direction: column;
            }

            .leftdiv {
                width: 100%;
            }

            .rightdiv {
                width: 100%;
            }

            .reloadbtn {
                display: none;
            }

            .backbtn {
                display: none;
            }

            .rejectbtn {
                scale: 0.9;
                right: 7px;
            }

            .publishbtn {
                scale: 0.9;
                right: 90px;
            }

            .flexi {
                font-size: 20px;
                font-weight: 500;
                margin-left: 10px;
            }

            .flexi1 {
                margin-left: 10px;
            }

            .det12 {
                float: none;
                margin-right: 0px;
                margin-top: 0px;
                margin-left: 10px;
            }

            .det21 {
                margin-top: 0px;
            }

            .hoirz {
                margin-top: 50px;
            }
        }
    </style>
</head>
<?php
$sql = "SELECT dept FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "'";
$que = mysqli_query($con, $sql);
$row = mysqli_fetch_array($que);

if ($row) {
    $dept_array = array_map('trim', explode(',', $row['dept']));
    $dept_array = array_unique(array_filter($dept_array));

    $conditions = ["FIND_IN_SET('All', REPLACE(dept, ' ', '')) > 0"];
    foreach ($dept_array as $dept) {
        $conditions[] = "FIND_IN_SET(TRIM('$dept'), REPLACE(dept, ' ', '')) > 0";
    }
    $condition_str = implode(' OR ', $conditions);

    $sql_ack_count = "SELECT COUNT(*) as record_count FROM policies_policy 
                          WHERE status = '1' 
                            AND ($condition_str)
                            AND  EXISTS (
                                SELECT 1 
                                FROM policies_ack 
                                WHERE policies_ack.policy_title = '$policy_title'
                                  AND policies_ack.version = '$version'
                                  AND policies_ack.policyno = '$policyno'
                                  AND policies_ack.empname = '" . mysqli_real_escape_string($con, $empname) . "'
                            )";

    $que_ack_count = mysqli_query($con, $sql_ack_count);
    $row_ack_count = mysqli_fetch_assoc($que_ack_count);
    $record_count = $row_ack_count['record_count'];

    $sql_total_count = "SELECT COUNT(*) as total_count FROM policies_policy 
                            WHERE status = '1' 
                              AND ($condition_str)";

    $que_total_count = mysqli_query($con, $sql_total_count);
    $row_total_count = mysqli_fetch_assoc($que_total_count);
    $total_count = $row_total_count['total_count'];
}
?>
<?php if ($record_count > 0) : ?>
    <?php
    $sql = "SELECT * FROM policies_ack WHERE policyno = '$policyno' AND version = '$version' AND policy_title = '$policy_title' AND empname = '$empname' ";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $ack_time = $row['ack_time'];
    ?>
<?php endif; ?>

<?php
$sql = "SELECT dept FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "'";
$que = mysqli_query($con, $sql);
$row = mysqli_fetch_array($que);

if ($row) {
    $dept_array = array_map('trim', explode(',', $row['dept']));
    $dept_array = array_unique(array_filter($dept_array));

    $conditions = ["FIND_IN_SET('All', REPLACE(dept, ' ', '')) > 0"];
    foreach ($dept_array as $dept) {
        $conditions[] = "FIND_IN_SET(TRIM('$dept'), REPLACE(dept, ' ', '')) > 0";
    }
    $condition_str = implode(' OR ', $conditions);

    $sql_ack_count1 = "SELECT COUNT(*) as record_count FROM policies_policy 
                          WHERE status = '1' 
                            AND ($condition_str)
                            AND NOT  EXISTS (
                                SELECT 1 
                                FROM policies_ack 
                                WHERE policies_ack.policy_title = '$policy_title'
                                  AND policies_ack.version = '$version'
                                  AND policies_ack.policyno = '$policyno'
                                  AND policies_ack.empname = '" . mysqli_real_escape_string($con, $empname) . "'
                            )";

    $que_ack_count1 = mysqli_query($con, $sql_ack_count1);
    $row_ack_count1 = mysqli_fetch_assoc($que_ack_count1);
    $record_count1 = $row_ack_count1['record_count'];

    $sql_total_count1 = "SELECT COUNT(*) as total_count FROM policies_policy 
                            WHERE status = '1' 
                              AND ($condition_str)";

    $que_total_count1 = mysqli_query($con, $sql_total_count1);
    $row_total_count1 = mysqli_fetch_assoc($que_total_count1);
    $total_count1 = $row_total_count1['total_count'];
}
?>

<body style="background-color: #FBFAFB; ">
    <!-- Nav Bar -->
 <div class="TopBar">
        <img class="logoimg" src="./public/logo-11@2x.png" alt="">
        <p class="AnikaHRM">Anika <span>HRM</span></p>
        <p class="heading">Policy Details</p>
    </div>
    <?php
    $sql = "SELECT * FROM policies_policy WHERE (policy_title = '$policy_title' AND policyno = '$policyno' AND `version` = '$version')";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $policy_content = $row['policy_content'];
    $folder_name = $row['folder_name'];
    ?>
    <!-- Top Bar -->
    <div style="background-color: #ffffff;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; display: flex; align-items: center;">
        <div style="display: flex;">
            <div class="topbardetails">
                <img src="./public/folder.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Policy Detail
                <br>
                <span style="color: #026ACB;">Version Detail</span>
                <?php
                $fetch_sql = "SELECT * FROM policy_opens WHERE policy_title = '$policy_title' AND policyno = '$policyno' AND version = '$version'";
                $fetch_result = mysqli_query($con, $fetch_sql);

                if (mysqli_num_rows($fetch_result) > 0) {
                    $fetch_row = mysqli_fetch_assoc($fetch_result);
                    $recent_opened = htmlspecialchars($fetch_row['recent_opened']);
                ?>
                    <span class="text-sm" style="color: rgb(122, 122, 122);">Last Viewed - <span style="color: orange;"><?php echo $recent_opened; ?></span></span>
                <?php
                } else {
                    echo "";
                }
                ?>


            </p>
        </div>
        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
        <div onclick="window.history.back();" class="backbtn">
            <img src="./public/arrow-back.svg" width="20px" style="scale: 1.4;" alt="">
        </div>

    </div>
    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Policy Acceptance Confirmation
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
                        Dear Employee,<br><br>

                        Please take a moment to review the policy. By clicking the '<b>Acknowledge</b>' button below, you confirm that you have thoroughly read and understood the policy details. Your acknowledgment indicates your acceptance and compliance with the terms outlined.
                    </p>
                </div>
                <!-- Modal footer -->
                <form action="" id="insertForm">
                    <input name="empname" type="hidden" value="<?php echo $empname ?>">
                    <input name="folder_name" type="hidden" value="<?php echo $folder_name ?>">
                    <input name="policy_title" type="hidden" value="<?php echo $policy_title ?>">
                    <input name="version" type="hidden" value="<?php echo $version ?>">
                    <input name="policyno" type="hidden" value="<?php echo $policyno ?>">
                    <input name="dept" type="hidden" value="<?php echo $dept ?>">

                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Acknowledge</button>
                        <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main Dashboard -->
    <div class="maindash">
        <div class="leftdiv">
            <p style="margin-left: 20px; margin-top: 20px; font-weight: 500; font-size: 20px;">Details</p>
            <button style="margin-left: 20px; background-color: #F4f4fa; width: 90%; height: 40px; font-size: 20px; font-weight: 450; border-radius: 5px; color: rgb(255, 166, 0);">
                <?php
                if ($row['status'] == 0) {
                    echo 'Pending';
                } elseif ($row['status'] == 1) {
                    echo 'Approved';
                } elseif ($row['status'] == 2) {
                    echo 'Rejected';
                }
                ?>

            </button>
            <p style="margin-top: 10px; font-weight: 500; font-size: 20px; color: #026ACB; text-align: center;">Version <?php echo $row['version']; ?></p>
            <p style="margin-top: 10px; font-weight: 500; font-size: 20px; margin-left: 20px; color: #aaaaaa;">Basic Information : </p>
            <p style="font-size: 18px; margin-top: 10px; font-weight: 500; color: #797979; margin-left: 20px;">Policy Title <br> <span style="color: black; font-size: 20px;"><?php echo $policy_title ?></span></p>
            <p style="font-size: 18px; margin-top: 10px; font-weight: 500; color: #797979; margin-left: 20px;">Policy Number <br> <span style="color: black; font-size: 20px;"><?php echo $policyno ?></span></p>
            <p style="font-size: 18px; margin-top: 10px; font-weight: 500; color: #797979; margin-left: 20px;">Created by <br> <span style="color: black; font-size: 20px;">
                    <?php echo $row['email']; ?></span></p>
            <p style="font-size: 18px; margin-top: 10px; font-weight: 500; color: #797979; margin-left: 20px; margin-bottom: 10px;">Created On <br> <span style="color: black; font-size: 20px;">
                    <?php echo $row['time']; ?>
                </span></p>
                <p style="font-size: 18px; margin-top: 10px; font-weight: 500; color: #797979; margin-left: 20px; margin-bottom: 10px;">Approval Authority <br> <span style="color: black; font-size: 20px;">
                    <?php echo $row['apr_name']; ?>
                </span></p>
            <p style="font-size: 18px; margin-top: 10px; font-weight: 500; color: #797979; margin-left: 20px; margin-bottom: 10px;">Effective From <br> <span style="color: black; font-size: 20px;">
                    <?php
                    $originalDate = $row['time'];
                    $dateTime = new DateTime($originalDate);
                    $formattedDate = $dateTime->format('F j, Y');

                    echo $formattedDate;
                    ?>

                </span></p>
        </div>
        <div class="rightdiv">
            <div>
                <p><span class="flexi">Flexible Leave Policy <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
                        </svg></span>

                    <?php
                    $policy_title = mysqli_real_escape_string($con, $policy_title);

                    $sql_pt = "SELECT  COUNT(*) as count FROM policies_policy WHERE policy_title = '$policy_title' ";
                    $result_pt = $con->query($sql_pt);

                    if ($result_pt->num_rows > 0) {
                        while ($row_pt = $result_pt->fetch_assoc()) {
                            $count = htmlspecialchars($row_pt['count']);
                    ?>
                    <?php
                            echo "<span class='flexi1'>Total Versions $count</span>";
                        }
                    } else {
                        echo "No versions found for the policy title: " . htmlspecialchars($policy_title);
                    }
                    ?>

                </p>
                <?php if ($record_count > 0) : ?>
                    <p class="det12">
                        <span style="color: rgb(32, 175, 32);">
                            Acknowledged
                        </span> |
                        <span style="color: black;">
                            <span style="color: rgb(122, 122, 122);">
                                Acknowledged on
                            </span> - <?php echo $ack_time ?>
                        </span>
                    </p>
                <?php endif; ?>

                <div class="det21">
                    <?php if ($record_count1 > 0) : ?>
                        <button style="margin-right:20px;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Acknowledge
                        </button>
                    <?php endif; ?>
                    <!-- pdf download -->
                    <?php if ($record_count > 0) : ?>
                    <a target="_blank" href="print_policy.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&policyno=<?php echo urlencode($row['policyno']); ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
                <hr class="hoirz">
                <div style="margin-left: 20px; margin-top: 20px;"><?php echo $policy_content ?></div>
            </div>
        </div>
    </div>
</body>
<script src='https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js'></script>
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script>
    $(document).ready(function() {
        $("#insertForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "insert_policyAck.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'emppolicy.php';
                        }
                    });

                }
            });
        });
    });
</script>


</html>
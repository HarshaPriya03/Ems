<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
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
    <style>
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

        .maindiv {
            display: flex;
            gap: 400px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .tecbtn {
            background-color: white;
            color: orange;
            border: 1px solid orange;
            width: 40px;
            border-radius: 15px;
        }

        .ackno {
            position: absolute;
            display: flex;
            right: 20px;
            color: #ff935e;
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


            .maindash {
                height: 100%;
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
                /* scale: 0.8;
                right: 50px; */
                display: none;
            }

            .reloadbtn {
                /* scale: 0.8;
                right: 7px; */
                display: none;
            }

            .maindash {
                height: 100vh;
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
                scale: 0.7;
                margin-left: 0px;
            }

            .maindiv {
                gap: 20px;
            }

            .ackno {
                position: static;
            }
        }
    </style>
</head>

<body style="background-color: #FBFAFB; ">
    <!-- Nav Bar -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900" style="box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <div class="max-w-screen-xxl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="./public/logo-1@2x.png" class="h-10" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"><span style="color: #026ACB;">P</span>olicy<span style="color: #026ACB;">M</span>aker</span>
            </a>
        </div>
    </nav>
    <!-- Top Bar -->
    <?php
    $user_email = $_SESSION['user_name'];
    $sql = "SELECT * FROM emp WHERE empemail = '$user_email' ";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $dept = $row['dept'];
    $empname = $row['empname'];
    $empty = $row['empty'];
    $work_location = $row['work_location'];
    ?>

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

        $sql = "SELECT COUNT(*) as record_count FROM policies_policy 
            WHERE status = '1' 
            AND ($condition_str)
            AND NOT EXISTS (
                SELECT 1 
                FROM policies_ack 
                WHERE policies_ack.policy_title = policies_policy.policy_title
                AND policies_ack.version = policies_policy.version
                AND policies_ack.policyno = policies_policy.policyno
                AND policies_ack.empname = '" . mysqli_real_escape_string($con, $empname) . "'
            )";

        $que = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($que);
        $record_count = $row['record_count'];
    }
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

        $sql = "SELECT COUNT(*) as total_count FROM policies_policy 
            WHERE status = '1' AND ($condition_str)";

        $que = mysqli_query($con, $sql);
        $result = mysqli_fetch_assoc($que);
        $total_count = $result['total_count'];
    }
    ?>

    <div style="background-color: #ffffff;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; display: flex; align-items: center;">
        <div style="display: flex;">
            <div class="topbardetails">
                <img src="./public/folder.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Policy Detail
                <br>
                <span style="color: #026ACB;">Policies</span>
            </p>
        </div>
        <div class="detaildiv" data-modal-target="default-modal" data-modal-toggle="default-modal">
            <svg style="margin-top: 4px;" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <p style="font-size: 13px; font-weight: 500; color: #797979;">
                Pending Acknowledgements<br> <span style="color: black; font-size: 15px;">
                    <span style="color: red;"><?php echo $record_count ?></span>/<?php echo $total_count ?></span></p>
            <p style="font-size: 13px; font-weight: 500; margin-top: 12px; color: #797979;"><svg class="w-5 h-5 text-blue-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m9 5 7 7-7 7" />
                </svg>
            </p>
        </div>
        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            All Pending Acknowledgements
                            <button class="tecbtn"><?php echo $record_count ?> </button>
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <?php
                    $sql = "SELECT * FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "'";
                    $que = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($que);

                    $dept_array = array_map('trim', explode(',', $row['dept']));
                    ?>


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

                        $sql = "SELECT * FROM policies_policy 
            WHERE status = '1' 
              AND ($condition_str)
              AND NOT EXISTS (
                  SELECT 1 
                  FROM policies_ack 
                  WHERE policies_ack.policy_title = policies_policy.policy_title
                    AND policies_ack.version = policies_policy.version
                    AND policies_ack.policyno = policies_policy.policyno
                    AND policies_ack.empname = '" . mysqli_real_escape_string($con, $empname) . "'
              )";


                        $que = mysqli_query($con, $sql);
                        $num_rows = mysqli_num_rows($que);


                        if ($num_rows > 0) {
                            while ($result = mysqli_fetch_assoc($que)) {
                                $policy_title = htmlspecialchars($result['policy_title']);
                                $version = htmlspecialchars($result['version']);
                                $policyno = htmlspecialchars($result['policyno']);
                    ?>
                                <div class="p-4 md:p-5 space-y-4">
                                    <div style="display: flex; gap: 10px;">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                                        </svg>
                                        <p onclick="window.location.href='./emp_policy_content.php?policy_title=<?php echo urlencode($policy_title); ?>&policyno=<?php echo urlencode($policyno); ?>&version=<?php echo urlencode($version); ?>'" style="color: #026ACB;"><?php echo htmlspecialchars($result['policy_title']); ?></p>
                                        <p class="ackno">Acknowledgement Required
                                            <svg style="margin-top: 3px;" class="w-5 h-5 text-orange-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </p>
                                    </div>
                                </div>
                    <?php
                            }
                        } else {
                            echo "<p>No data found</p>";
                        }
                    }
                    ?>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">close</button>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
        <div onclick="window.history.back();" class="backbtn">
            <img src="./public/arrow-back.svg" width="20px" style="scale: 1.4;" alt="">
        </div>
    </div>
    <!-- Main Dashboard -->
    <div class="maindash">
        <div class="maindiv">
            <div>
                <p style="display: flex; gap: 10px; font-weight: 500; font-size: 23px;">Latest Policies <svg style="margin-top: 6px;" class="w-6 h-6 text-yellow-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M7.05 4.05A7 7 0 0 1 19 9c0 2.407-1.197 3.874-2.186 5.084l-.04.048C15.77 15.362 15 16.34 15 18a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1c0-1.612-.77-2.613-1.78-3.875l-.045-.056C6.193 12.842 5 11.352 5 9a7 7 0 0 1 2.05-4.95ZM9 21a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2h-4a1 1 0 0 1-1-1Zm1.586-13.414A2 2 0 0 1 12 7a1 1 0 1 0 0-2 4 4 0 0 0-4 4 1 1 0 0 0 2 0 2 2 0 0 1 .586-1.414Z" clip-rule="evenodd" />
                    </svg>
                </p><br>
                <?php
                function time_elapsed_string($datetime, $full = false)
                {
                    $now = new DateTime();
                    $ago = new DateTime($datetime);

                    $now->modify('+3 hours');

                    $diff = $now->diff($ago);

                    $string = array(
                        'y' => 'year',
                        'm' => 'month',
                        'd' => 'day',
                        'h' => 'hour',
                        'i' => 'minute',
                        's' => 'second',
                    );
                    foreach ($string as $k => &$v) {
                        if ($diff->$k) {
                            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                        } else {
                            unset($string[$k]);
                        }
                    }

                    if ($diff->d >= 7) {
                        $weeks = floor($diff->d / 7);
                        $days = $diff->d % 7;
                        $string['w'] = $weeks . ' week' . ($weeks > 1 ? 's' : '');
                        if ($days) {
                            $string['d'] = $days . ' day' . ($days > 1 ? 's' : '');
                        } else {
                            unset($string['d']);
                        }
                    }

                    if (!$full) $string = array_slice($string, 0, 1);
                    return $string ? implode(', ', $string) . ' ago' : 'just now';
                }

                ?>
                <?php
                $sql = "SELECT * FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "'";
                $que = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($que);

                $dept_array = array_map('trim', explode(',', $row['dept']));
                ?>


                <?php
                $sql = "SELECT dept, work_location, empty FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "'";
                $que = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($que);

                if ($row) {
                    $dept_array = array_map('trim', explode(',', $row['dept']));
                    $dept_array = array_unique(array_filter($dept_array));

                    $work_location_array = array_map('trim', explode(',', $row['work_location']));
                    $work_location_array = array_unique(array_filter($work_location_array));

                    $empty_array = array_map('trim', explode(',', $row['empty']));
                    $empty_array = array_unique(array_filter($empty_array));

                    $conditions = [];

                    foreach ($dept_array as $dept) {
                        foreach ($work_location_array as $work_location) {
                            foreach ($empty_array as $empty) {
                                $dept_condition = "(FIND_IN_SET(TRIM('$dept'), REPLACE(dept, ' ', '')) > 0 OR FIND_IN_SET('All', REPLACE(dept, ' ', '')) > 0)";
                                $work_location_condition = "(FIND_IN_SET(TRIM('$work_location'), REPLACE(work_location, ' ', '')) > 0 OR FIND_IN_SET('All', REPLACE(work_location, ' ', '')) > 0)";
                                $empty_condition = "(FIND_IN_SET(TRIM('$empty'), REPLACE(empty, ' ', '')) > 0 OR FIND_IN_SET('All', REPLACE(empty, ' ', '')) > 0)";
                                $conditions[] = "($dept_condition AND $work_location_condition AND $empty_condition)";
                            }
                        }
                    }

                    $condition_str = implode(' OR ', $conditions);

                    $sql_policies = "SELECT * FROM policies_policy WHERE status = '1' AND ($condition_str)";

                    $que_policies = mysqli_query($con, $sql_policies);
                    $num_rows = mysqli_num_rows($que_policies);

                    if ($num_rows > 0) {
                        while ($result = mysqli_fetch_assoc($que_policies)) {
                            $policy_title = htmlspecialchars($result['policy_title']);
                            $version = htmlspecialchars($result['version']);
                            $policyno = htmlspecialchars($result['policyno']);
                ?>
                            <div style="display: flex; gap: 20px;">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p onclick="window.location.href='./emp_policy_content.php?policy_title=<?php echo urlencode($policy_title); ?>&policyno=<?php echo urlencode($policyno); ?>&version=<?php echo urlencode($version); ?>'" style="font-size: 20px; margin-top: -4px; color: #026ACB;">
                                    <?php echo htmlspecialchars($result['policy_title']); ?><br>
                                    <span style="font-size: 16px; color: black;">
                                        <?php echo htmlspecialchars($result['time']); ?>
                                        <?php echo time_elapsed_string($result['time']); ?>
                                    </span>
                                </p>
                            </div>
                <?php
                        }
                    } else {
                        echo "<p>No data found</p>";
                    }
                }
                ?>
            </div>
            <div>
                <p style="display: flex; gap: 10px; font-weight: 500; font-size: 23px;">Policy Types <svg style="margin-top: 6px;" class="w-6 h-6 text-yellow-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M7.05 4.05A7 7 0 0 1 19 9c0 2.407-1.197 3.874-2.186 5.084l-.04.048C15.77 15.362 15 16.34 15 18a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1c0-1.612-.77-2.613-1.78-3.875l-.045-.056C6.193 12.842 5 11.352 5 9a7 7 0 0 1 2.05-4.95ZM9 21a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2h-4a1 1 0 0 1-1-1Zm1.586-13.414A2 2 0 0 1 12 7a1 1 0 1 0 0-2 4 4 0 0 0-4 4 1 1 0 0 0 2 0 2 2 0 0 1 .586-1.414Z" clip-rule="evenodd" />
                    </svg>
                </p> <br>
                <?php
                $sql = "SELECT dept, work_location, empty FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "'";
                $que = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($que);

                if ($row) {
                    $dept_array = array_map('trim', explode(',', $row['dept']));
                    $dept_array = array_unique(array_filter($dept_array));

                    $work_location_array = array_map('trim', explode(',', $row['work_location']));
                    $work_location_array = array_unique(array_filter($work_location_array));

                    $empty_array = array_map('trim', explode(',', $row['empty']));
                    $empty_array = array_unique(array_filter($empty_array));

                    $conditions = [];

                    foreach ($dept_array as $dept) {
                        foreach ($work_location_array as $work_location) {
                            foreach ($empty_array as $empty) {
                                $dept_condition = "(FIND_IN_SET(TRIM('$dept'), REPLACE(dept, ' ', '')) > 0 OR FIND_IN_SET('All', REPLACE(dept, ' ', '')) > 0)";
                                $work_location_condition = "(FIND_IN_SET(TRIM('$work_location'), REPLACE(work_location, ' ', '')) > 0 OR FIND_IN_SET('All', REPLACE(work_location, ' ', '')) > 0)";
                                $empty_condition = "(FIND_IN_SET(TRIM('$empty'), REPLACE(empty, ' ', '')) > 0 OR FIND_IN_SET('All', REPLACE(empty, ' ', '')) > 0)";
                                $conditions[] = "($dept_condition AND $work_location_condition AND $empty_condition)";
                            }
                        }
                    }

                    $condition_str = implode(' OR ', $conditions);

                    $sql_policies = "SELECT * FROM policies_folder WHERE status = '1' AND ($condition_str)";

                    $que_policies = mysqli_query($con, $sql_policies);
                    $num_rows = mysqli_num_rows($que_policies);

                    if ($num_rows > 0) {
                        while ($result = mysqli_fetch_assoc($que_policies)) {
                            $folder_name = htmlspecialchars($result['folder_name']);
                ?>
                            <div style="display: flex; gap: 20px;">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p onclick="window.location.href='./empfolderdetail.php?folder_name=<?php echo urlencode($folder_name); ?>'" style="font-size: 20px; margin-top: -4px; color: #026ACB;">
                                    <?= htmlspecialchars($result['folder_name']) ?><br>
                                    <span style="font-size: 16px; color: black;"><?= htmlspecialchars($result['time']) ?>
                                        <?php echo time_elapsed_string($result['time']); ?>
                                    </span>
                                </p>
                            </div>
                <?php
                        }
                    } else {
                        echo "<p>No data found</p>";
                    }
                }
                ?>





            </div>
        </div>
    </div>
</body>

</html>
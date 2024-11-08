<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

$folder_name = isset($_GET['folder_name']) ? $_GET['folder_name'] : '';
?>
<?php
$user_email = $_SESSION['user_name'];
$sql = "SELECT * FROM emp WHERE empemail = '$user_email' ";
$result = $con->query($sql);
$row = $result->fetch_assoc();

$dept = $row['dept'];
$empname = $row['empname'];
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
        }

        .ullisty {
            background-color: #d3eaff;
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            border-left: 5px solid #026ACB;
            cursor: pointer;
        }

        .ullisty1 {
            text-align: center;
            margin-top: 20px;
        }


        .mobileview {
            display: none;
        }

        .mobdiv {
            background-color: #d3eaff;
            padding: 5px;
            border-radius: 3px;
            font-size: 15px;
        }

        .mobdiv1 {
            font-size: 15px;
        }

        .mobdiv1:hover {
            background-color: #d3eaff;
        }

        .rejectbtn {
            background-color: rgb(255, 222, 222);
            color: rgb(255, 41, 41);
            border: 1px solid rgb(255, 41, 41);
            width: 80px;
            height: 40px;
            border-radius: 5px;
        }

        .publishbtn {
            background-color: rgb(222, 255, 222);
            color: rgb(14, 145, 14);
            border: 1px solid rgb(14, 145, 14);
            width: 80px;
            height: 40px;
            border-radius: 5px;
        }

        .rightcontent {
            display: flex;
            float: right;
            margin-right: 20px;
            margin-top: -130px;
            gap: 20px;
            border: 1px solid rgb(190, 190, 190);
            width: 400px;
            background-color: #edf5fd;
            padding: 12px;
            border-radius: 5px;
        }

        .inpara1 {
            display: flex;
            padding-right: 20px;
            border-right: 1px solid rgb(190, 190, 190);
            gap: 7px;
        }

        .inpara2 {
            display: flex;
            gap: 7px;
        }

        .rightdivpara {
            font-size: 24px;
            font-weight: 500;
            margin-left: 20px;
            margin-top: 20px;
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
                display: none;
            }

            .reloadbtn {
                display: none;
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
                height: 90vh;
                flex-direction: column;
            }

            .leftdiv {
                display: none;
            }

            .rightdiv {
                width: 100%;
            }

            .mobileview {
                background-color: white;
                border-radius: 5px;
                padding: 5px;
                display: flex;
                gap: 30px;
                justify-content: center;
            }

            .mobdiv1:hover {
                background-color: #d3eaff;
            }

            .detaildiv {
                scale: 0.7;
                margin-left: 0px;
            }

            .rightdivpara {
                margin-top: 50px;
            }

            .rightcontent {
                scale: 0.8;
                margin-right: -30px;
                margin-top: -175px;
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
            WHERE status = '1' AND ($condition_str) AND folder_name = '$folder_name'";

    $que = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($que);
    $total_count = $result['total_count'];
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

    $sql1 = "SELECT COUNT(*) as record_count1 FROM policies_policy 
    WHERE status = '1' 
    AND ($condition_str)
    AND EXISTS (
        SELECT 1 
        FROM policies_ack 
        WHERE policies_ack.policy_title = policies_policy.policy_title
        AND policies_ack.folder_name = '" . mysqli_real_escape_string($con, $folder_name) . "'
        AND policies_ack.version = policies_policy.version
        AND policies_ack.policyno = policies_policy.policyno
        AND policies_ack.empname = '" . mysqli_real_escape_string($con, $empname) . "'
    )";


    $que1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($que1);
    $record_count1 = $row1['record_count1'];
}

?>

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
    <div style="background-color: #ffffff;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; display: flex; align-items: center;">
        <div style="display: flex;">
            <div class="topbardetails">
                <img src="./public/publish.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Policy Detail
                <br>
                <span style="color: #026ACB;">Details</span>
            </p>
        </div>
        <a href="emppolicy.php">
            <div class="detaildiv">
                <svg style="margin-top: 4px;" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p style="font-size: 13px; font-weight: 500; color: #797979;">
                    Pending Acknowledgements<br> <span style="color: black; font-size: 15px;"><span style="color: red;"><?php echo $record_count ?></span>/<?php echo $total_count ?></span></p>
                <p style="font-size: 13px; font-weight: 500; margin-top: 12px; color: #797979;"><svg class="w-5 h-5 text-blue-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m9 5 7 7-7 7" />
                    </svg>
                </p>
            </div>
        </a>


        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
        <div onclick="window.history.back();" class="backbtn">
            <img src="./public/arrow-back.svg" width="20px" style="scale: 1.4;" alt="">
        </div>
    </div>
    <!-- Main Dashboard -->
    <div class="maindash">
        <div class="mobileview">
            <div class="mobdiv"><?php echo $folder_name ?></div>
        </div>
        <div class="leftdiv">
            <div class="ullisty">
                <p style="font-size: 20px;">Folder Name: <b><?php echo $folder_name ?></b></p>
            </div>
        </div>
        <div class="rightdiv">
            <p class="rightdivpara">Policies Under <u class="text-blue-700"><?php echo $folder_name ?></u></p>
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

                $sql_policies = "SELECT * FROM policies_policy WHERE status = '1' AND ($condition_str)  AND folder_name = '$folder_name'";

                $que_policies = mysqli_query($con, $sql_policies);
                $num_rows = mysqli_num_rows($que_policies);

                if ($num_rows > 0) {
                    while ($result = mysqli_fetch_assoc($que_policies)) {
                        $policy_title = htmlspecialchars($result['policy_title']);
                        $version = htmlspecialchars($result['version']);
                        $policyno = htmlspecialchars($result['policyno']);
            ?>
                        <p style="margin-left: 20px; margin-top: 20px; display: flex; gap: 10px;"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <a onclick="window.location.href='./emp_policy_content.php?policy_title=<?php echo urlencode($policy_title); ?>&policyno=<?php echo urlencode($policyno); ?>&version=<?php echo urlencode($version); ?>'" style="font-size: 18px; color: #026ACB; font-weight: 500;">
                                <?php echo htmlspecialchars($result['policy_title']); ?></a>
                        </p>
            <?php
                    }
                } else {
                    echo "<p>No data found</p>";
                }
            }
            ?>
            
            <div class="rightcontent">
                <p class="inpara1">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg> <span>Total Policies - <?php echo $num_rows ?></span>
                </p>
                <p class="inpara2"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                    </svg>
                    <span>Acknowledged- <?php echo $record_count1 ?>/<?php echo $num_rows ?></span>
                </p>
            </div>
        </div>
        
    </div>
</body>
<script src='https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js'></script>
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script>
    CKEDITOR.replace('editor1');
    CKEDITOR.on('instanceReady', function(evt) {
        var editor = evt.editor;

        editor.on('change', function(e) {
            var contentSpace = editor.ui.space('contents');
            var ckeditorFrameCollection = contentSpace.$.getElementsByTagName('iframe');
            var ckeditorFrame = ckeditorFrameCollection[0];
            var innerDoc = ckeditorFrame.contentDocument;
            var innerDocTextAreaHeight = $(innerDoc.body).height();
            console.log(innerDocTextAreaHeight);
        });
    });
</script>

</html>
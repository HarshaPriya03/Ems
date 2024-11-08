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
    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,600;1,200;1,400;1,600&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
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
<body style="width: 100%; margin-left: -0.5px; font-family:Poppins;">
    <div class="TopBar">
        <img class="logoimg" src="./public/logo-11@2x.png" alt="">
        <p class="AnikaHRM">Anika <span>HRM</span></p>
        <p class="heading">Policy Management System</p>
    </div>
    <div class="answersdiv">
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
    </div>
   <!-- Main Dashboard -->
   <div class="maindash">
    <div class="mobileview">
        <div onclick="window.location.href='./policydetails.html'" class="mobdiv">Attendance Policy</div>
        <div onclick="window.location.href='./policyversions.html'" class="mobdiv1">Holiday Policy</div>
    </div>
    <div class="leftdiv">
        <div onclick="window.location.href='./policydetails.html'" class="ullisty">
        <p style="font-size: 15px;">Folder Name <br> <b><?php echo $folder_name ?></b></p>
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
    </div>
</body>
</html>
<?php
@include '../inc/config.php';

$policy_title = isset($_GET['policy_title']) ? $_GET['policy_title'] : '';
$version = isset($_GET['version']) ? $_GET['version'] : '';
$policyno = isset($_GET['policyno']) ? $_GET['policyno'] : '';
?>

<!DOCTYPE html>

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
            cursor: pointer;
            transition: all 300ms ease;
        }

        .ullisty1:hover {
            background-color: #d3eaff;
            border-left: 5px solid #026ACB;
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
    <div style="background-color: #ffffff;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; display: flex; align-items: center;">
        <div style="display: flex;">
            <div class="topbardetails">
                <img src="./public/publish.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Policy Detail
                <br>
                <span style="color: #026ACB;">Statistics</span>
            </p>
        </div>
        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
        <div onclick="window.history.back();" class="backbtn">
            <img src="./public/arrow-back.svg" width="20px" style="scale: 1.4;" alt="">
        </div>
    </div>
    <!-- Main Dashboard -->
    <?php
    $sql = "SELECT * FROM policies_policy WHERE policy_title = '$policy_title' AND version ='$version' AND policyno = '$policyno'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $policy_title = $row['policy_title'];
    ?>


    <div class="maindash">
        <div class="mobileview">
            <div onclick="window.location.href='./policydetails.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="mobdiv1">Details</div>
            <div class="mobdiv1" onclick="window.location.href='./policyversions.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '">Versions</div>
            <div onclick="window.location.href='./policystatistics.php'" class="mobdiv">Statistics</div>
            <div onclick="window.location.href='./policyrestrictions.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="mobdiv1">Restrictions</div>
        </div>
        <div class="leftdiv">
            <div onclick="window.location.href='./policydetails.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="ullisty1">
                <p style="font-size: 20px;">Details</p>
            </div>
            <div class="ullisty1" onclick="window.location.href='./policyversions.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '">
                <p style="font-size: 20px;">Versions</p>
            </div>
            <div class="ullisty" style="font-size:20px;">Statistics</p>
            </div>
            <div onclick="window.location.href='./policyrestrictions.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="ullisty1">
                <p style="font-size: 20px;">Restrictions</p>
            </div>
        </div>
        <div class="rightdiv">
            <div class="relative overflow-x-auto" style="border-top-left-radius: 10px; border-top-right-radius: 10px; position: sticky; top: 0;">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Employee Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Policy Opened
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Policy No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Version
                            </th>
                            <th scope="col" class="px-6 py-3">
                                No of times policy Opened
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Policy last opened on
                            </th>
                        </tr>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM policy_opens WHERE policy_title = '$policy_title' AND version = '$version' AND policyno = '$policyno'";
                    $que = mysqli_query($con, $sql);

                    if (mysqli_num_rows($que) > 0) {
                        while ($result = mysqli_fetch_assoc($que)) {
                    ?>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $result['empname']; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo $result['policy_title']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['policyno']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['version']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['open_count']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['last_opened']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-900 dark:text-white">
                                    No data available
                                </td>
                            </tr>
                        </tbody>
                    <?php
                    }
                    ?>

                </table>
            </div>
        </div>
        <div class="rightdiv">
            <div class="relative overflow-x-auto" style="border-top-left-radius: 10px; border-top-right-radius: 10px; position: sticky; top: 0;">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Employee Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Policy Acknowledged
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Policy No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Version
                            </th>
                            <th scope="col" class="px-6 py-3">
                            Acknowledged Date
                            </th>
                        </tr>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM policies_ack WHERE policy_title = '$policy_title' AND version = '$version' AND policyno = '$policyno'";
                    $que = mysqli_query($con, $sql);

                    if (mysqli_num_rows($que) > 0) {
                        while ($result = mysqli_fetch_assoc($que)) {
                    ?>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $result['empname']; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo $result['policy_title']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['policyno']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['version']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['ack_time']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-900 dark:text-white">
                                    No data available
                                </td>
                            </tr>
                        </tbody>
                    <?php
                    }
                    ?>

                </table>
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
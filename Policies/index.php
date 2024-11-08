<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:login.php');
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">

    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
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

        .maindash {
            background-color: #F4F4FA;
            margin-top: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
            padding: 10px;
            height: 84vh;
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
            width: 290px;
            display: flex;
            gap: 50px;
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

        .live2 {
            margin-top: 10px;
            background-color: white;
            width: 100%;
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

        .topbardetails {
            background-color: #036CD0;
            border-radius: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 30px;
            margin-right: 10px;
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

        .viewbtn {
            float: right;
            margin-top: -35px;
            background-color: #c2e4ff;
            color: #006ECB;
            border: 1px solid #006ecb;
            display: flex;
        }

        .tecbtn {
            background-color: white;
            color: orange;
            border: 1px solid orange;
            width: 40px;
            border-radius: 15px;
        }

        #columnchart_material {
            width: 80%;
            height: 90%;
            margin: 0 auto;
            margin-top: 30px;
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

            .topbardetails {
                scale: 0.8;
                margin-left: 0px;
                margin-right: 0px;
            }

            .reloadbtn {
                scale: 0.8;
                right: 7px;
            }

            .viewbtn {
                scale: 0.8;
                margin-right: -30px;
            }

            .tecthead {
                scale: 0.92;
                margin-left: -18px;
            }

            .tecbtn {
                display: none;
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
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
                <div class="relative mt-3 md:hidden">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search-navbar" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                </div>
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Top Bar -->
    <div style="background-color: #ffffff;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; display: flex; align-items: center;">
        <div style="display: flex;">
            <div class="topbardetails">
                <img src="./public/folder.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Policies <br>
                <span style="color: #026ACB;">Summary</span>
            </p>
        </div>
        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
    </div>
    <!-- Main Dashboard -->
    <?php
    $sql_count = "SELECT COUNT(*) AS count FROM policies_policy WHERE status = 0";
    $result_count = $con->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $count = $row_count['count'];

    $sql_count = "SELECT COUNT(*) AS count FROM policies_policy WHERE status = 1";
    $result_count = $con->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $count1 = $row_count['count'];

    $sql_count = "SELECT COUNT(*) AS count FROM policies_ack ";
    $result_count = $con->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $count2 = $row_count['count'];
    ?>
    <div class="maindash">
        <!-- policiescards -->
        <div class="policieslist">
            <div style="display: flex;">
                <div class="polidiv">
                    <p class="text-xl font-normal whitespace-nowrap dark:text-white">Published Policies</p>
                    <p style="color: #026ACB;" class="text-2xl font-semibold whitespace-nowrap dark:text-white"><?php echo  $count1;  ?></p>
                </div>
            </div>
            <div style="display: flex;">
                <div class="polidiv">
                    <p class="text-xl font-normal whitespace-nowrap dark:text-white">Pending Approvals</p>
                    <p style="color: #026ACB;" class="text-2xl font-semibold whitespace-nowrap dark:text-white"><?php echo  $count;  ?></p>
                </div>
            </div>
            <div style="display: flex;">
                <div class="polidiv1">
                    <p class="text-xl font-normal whitespace-nowrap dark:text-white">Policies Acknowledged</p>
                    <p style="color: #026ACB;" class="text-2xl font-semibold whitespace-nowrap dark:text-white"><?php echo  $count2;  ?></p>
                </div>
            </div>
        </div>
        <!-- Infographs -->
        <div class="infograph">

            <div class="chart">
                <div class="topdiv">
                    <p class="text-xl font-semibold whitespace-nowrap dark:text-white">Policies Statistics</p>
                </div>
                <div style="height:350px;">
                    <div id="columnchart_material"></div>
                </div>
            </div>
            <div class="chart">
                <div class="topdiv">
                    <p class="text-xl font-semibold whitespace-nowrap dark:text-white">Latest Published Policies </p>
                </div>
                <div class="relative overflow-x-auto" style="height: 349px; overflow-y: auto;">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" style="position: sticky; top: 0;">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Policy
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Folder
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Version
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Published on
                                </th>
                            </tr>
                        </thead>
                        <?php
                        $sql = "SELECT * FROM policies_policy WHERE status = '1'";
                        $que = mysqli_query($con, $sql);
                        while ($result = mysqli_fetch_assoc($que)) {
                            $time = $result['time'];
                            $date = new DateTime($time);
                            $formatted_time = $date->format('F');
                        ?>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" onclick="window.location.href='./policydetails.php?policy_title=<?php echo urlencode($result['policy_title']); ?>&version=<?php echo urlencode($result['version']); ?>'" class="px-6 py-4 font-medium text-blue-700 whitespace-nowrap dark:text-blue" style="cursor: pointer;">
                                        <?php echo  $result['policy_title'];  ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo  $result['folder_name'];  ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo  $result['version'];  ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo  $result['time'];  ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="live">
                <div class="topdiv">
                    <p class="text-xl font-semibold whitespace-nowrap dark:text-white">Live Statistics</p>
                </div>

                <?php
                // Function to calculate time elapsed
                if (!function_exists('time_elapsed_string')) {
                    function time_elapsed_string($datetime, $full = false)
                    {
                        $now = new DateTime();
                        $ago = new DateTime($datetime);

                        // Adjust timezone if necessary
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

                        foreach ($string as $key => &$value) {
                            if ($diff->$key) {
                                $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
                            } else {
                                unset($string[$key]);
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

                        if (!$full) {
                            $string = array_slice($string, 0, 1);
                        }

                        return $string ? implode(', ', $string) . ' ago' : 'just now';
                    }
                }

                $sql = "SELECT * FROM policies_ack";
                $que = $con->query($sql);
                $num_rows = $que->num_rows;

                if ($num_rows > 0) {
                    echo '<div style="height: 349px; overflow-y: auto;">';
                    while ($result = $que->fetch_assoc()) {
                        $policy_title = htmlspecialchars($result['policy_title']);
                        $empname = htmlspecialchars($result['empname']);

                        $sql_pic = "SELECT `pic` FROM emp WHERE empname = ?";
                        $stmt_pic = $con->prepare($sql_pic);
                        $stmt_pic->bind_param("s", $empname);
                        $stmt_pic->execute();
                        $result_pic = $stmt_pic->get_result();
                        $row_pic = $result_pic->fetch_assoc();

                        if ($row_pic) {
                            $pic = 'https://hrms.anikasterilis.com/pics/' . htmlspecialchars($row_pic['pic']);
                        } else {
                            $pic = './public/emp.png';
                        }
                        $ack_time = $result['ack_time'];
                        $date = new DateTime($ack_time);
                        $formatted_ack_time = $date->format('F');
                ?>
                        <div style="padding: 8px 13px; border-bottom: 1px solid rgb(224, 224, 224);">
                            <p style="font-size: 14px;">Acknowledged Policy</p>
                            <p style="font-size: 14px; font-weight: 500; float: right; margin-top: -20px;">
                                <?php echo time_elapsed_string($ack_time); ?>
                            </p>
                            <div style="display: flex; width: 100%; margin-top: 5px;">
                                <img src="<?php echo $pic ?>" width="45" style="border-radius: 50px;">
                                <p style="font-size: 15px;">
                                    <span style="font-weight: 500;"><?php echo $empname ?></span> Acknowledged a policy
                                </p>
                            </div>
                            <p style="margin-left: 44px; font-size: 15px; color: #026ACB; font-weight: 500;">
                                "<?php echo $policy_title ?>"
                            </p>
                        </div>
                <?php
                    }
                    echo '</div>';
                } else {
                    echo "<p>No data found</p>";
                }
                ?>

            </div>
        </div>
        <div class="lastdiv">
            <div class="chart1">
                <div class="topdiv">
                    <p class="text-xl font-semibold whitespace-nowrap dark:text-white">Policy Folders</p>
                    <!-- Modal toggle -->
                    <button style="float: right; margin-top: -34px; background-color: #006ECB;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        + Add New Folder
                    </button>
                    <!-- Main modal -->
                    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Create New Folder
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

                                    <form class="max-w-2xl" id="modalForm">
                                        <div class="mb-5">
                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Folder
                                                Name</label>
                                            <input type="text" id="email" name="folder_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Create a name for folder" required />
                                        </div>
                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departments
                                            to get access</label>

                                        <select name="dept[]" multiple="multiple" style="height:100px;" id="desgSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="All">All</option>
                                            <?php

                                            $sql = "SELECT DISTINCT dept FROM emp";
                                            $result = $con->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['dept'] . '">' . $row['dept'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No data available</option>';
                                            }

                                            ?>
                                        </select>
                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Work
                                            Location to get access</label>
                                        <select name="work_location[]" multiple="multiple" style="height:100px;" id="WLSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="All">All</option>
                                            <?php

                                            $sql = "SELECT DISTINCT work_location FROM emp";
                                            $result = $con->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['work_location'] . '">' . $row['work_location'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No data available</option>';
                                            }

                                            ?>
                                        </select>
                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employement
                                            Type to get access</label>
                                        <select id="emptySelect" name="empty[]" multiple="multiple" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="All">All</option>
                                            <?php

                                            $sql = "SELECT DISTINCT empty FROM emp";
                                            $result = $con->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['empty'] . '">' . $row['empty'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No data available</option>';
                                            }

                                            ?>
                                        </select>

                                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                        <textarea id="message" rows="4" name="desc" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>



                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                    <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 298px; overflow-y: auto;">
                    <?php
                    $sql = "SELECT * FROM policies_folder";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $folder_name = htmlspecialchars($row['folder_name']);
                            $folder_status = $row['folder_status'];

                            $sql_count = "SELECT COUNT(*) AS count FROM policies_policy WHERE folder_name = ?";
                            $stmt_count = $con->prepare($sql_count);
                            $stmt_count->bind_param('s', $folder_name);
                            $stmt_count->execute();
                            $result_count = $stmt_count->get_result();
                            $row_count = $result_count->fetch_assoc();

                            $count = $row_count['count'];
                    ?>
                            <div style="padding: 10px; margin-top: 8px; border-bottom: 1px solid rgb(224, 224, 224);">
                                <div class="policy">
                                    <img src="./public/folder.png" width="40px" alt="">
                                    <p onclick="window.location.href='./folderdetail.php?folder_name=<?php echo urlencode($folder_name); ?>'" style="margin-top: 8px; font-size: 17px; color: #026ACB; font-weight: 500; cursor: pointer;">
                                        <?php echo $folder_name; ?>
                                    </p>
                                </div>
                                <p class="enable">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                                    </svg>
                                    <?php echo  $count;  ?> |
                                    <img src="./public/online.jpeg" width="15px" height="10px" style="height: 16px; margin-top: 4px;" alt="">
                                    <?php echo $folder_status == 1 ? 'Enable' : 'Disabled'; ?>
                                </p>
                                <p class="summ"> <?php echo htmlspecialchars($row['desc']); ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No results found.";
                    }
                    ?>
                </div>

            </div>
            <?php

            $sql_count = "SELECT COUNT(*) AS count FROM policies_policy WHERE status = 0";
            $result_count = $con->query($sql_count);
            $row_count = $result_count->fetch_assoc();

            $count = $row_count['count'];
            ?>
            <div class="live1">
                <div class="topdiv">
                    <p class="tecthead text-xl font-semibold whitespace-nowrap dark:text-white">Pending Approvals
                        <button class="tecbtn"> <?php echo  $count;  ?> </button>
                    </p>
                    <!-- Modal toggle -->
                    <button onclick="window.location.href='./pendingapprovals.php'" class="viewbtn block text-white bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:focus:ring-blue-800" type="button">
                        View all approval requests
                        <svg class="w-[12px] h-[12px] text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div class="relative overflow-x-auto" style="height: 298px; overflow-y: auto;">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" style="position: sticky; top: 0;">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Policy Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Policy Folder
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Version
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Submitted on
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Submitted By
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                            </tr>
                        </thead>
                        <?php
                        $sql = "SELECT * FROM policies_policy WHERE status = '0'";
                        $que = mysqli_query($con, $sql);
                        while ($result = mysqli_fetch_assoc($que)) {
                        ?>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" style="color: #026ACB;" class="px-6 py-4 font-medium text-blue-700 whitespace-nowrap dark:text-white">
                                        <a href="Approvedetails.php?policy_title=<?php echo urlencode($result['policy_title']); ?>&policyno=<?php echo urlencode($result['policyno']); ?>" style="color: inherit; text-decoration: none;">
                                            <?php echo htmlspecialchars($result['policy_title']); ?>
                                        </a>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo $result['folder_name']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['version']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['time']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $result['email']; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick="window.location.href='Approvedetails.php?policy_title=<?php echo urlencode($result['policy_title']); ?>&policyno=<?php echo urlencode($result['policyno']); ?>'" style="background-color: #d9f8e0; border: 1px solid #67ff74; display: flex;" class="block text-green-500 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                                            Action
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Acknowledged', 'Published'],
                ['<?php echo $formatted_ack_time; ?>', <?php echo $count2; ?>, <?php echo $count1; ?>],
            ]);

            var maxValue = Math.max(<?php echo $count1; ?>, <?php echo $count2; ?>);

            var options = {
                chart: {},
                series: {
                    0: {
                        color: '#006ECB'
                    },
                    1: {
                        color: '#ff8a96'
                    },
                },
                trendlines: {
                    0: {
                        lineWidth: '0'
                    },
                    1: {
                        lineWidth: '1'
                    }
                },
                vAxis: {
                    textStyle: {
                        color: 'black',
                        fontSize: 20,
                    },
                    titleTextStyle: {
                        color: 'black',
                        fontSize: 20,
                    },
                    viewWindowMode: 'explicit',
                    viewWindow: {
                        min: 0,
                        max: Math.ceil(maxValue / 10) * 5
                    },
                    ticks: [0, 10, 20, 30, 40, 50],
                },
                legend: {
                    position: 'bottom',
                },
                titleTextStyle: {
                    fontSize: 20,
                },
                chartArea: {
                    width: '100%',
                    height: '90%',
                },
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            window.addEventListener('resize', function() {
                chart.draw(data, google.charts.Bar.convertOptions(options));
            });

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>



    <script>
        new MultiSelectTag('desgSelect')
        new MultiSelectTag('WLSelect')
        new MultiSelectTag('emptySelect')
    </script>

    <script>
        $(document).ready(function() {
            $("#modalForm").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "insert_policyFolder.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: response,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php';
                            }
                        });

                    }
                });
            });
        });
    </script>

</body>

</html>
<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}
if (isset($_GET['folder_name'])) {
    $folder_name = htmlspecialchars($_GET['folder_name']);
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
                <img src="./public/folder.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Folder Detail
                <br>
                <span style="color: #026ACB;">Policies</span>
            </p>
        </div>
        <?php
        $sql = "SELECT COUNT(*) AS count FROM policies_policy WHERE folder_name = ? AND status = 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $folder_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $count = $row['count'];
        ?>

        <?php
        $sql = "SELECT * FROM policies_folder WHERE folder_name = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $folder_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        ?>
        <div class="detaildiv">
            <p style="font-size: 13px; font-weight: 500; color: #797979;">Policy Type <br> <span style="color: black; font-size: 15px;"><?php echo  $folder_name;  ?></span></p>
            <p style="font-size: 13px; font-weight: 500; color: #797979;">Policies <br> <span style="color: black; font-size: 15px;"><?php echo  $count;  ?></span></p>
            <p style="font-size: 13px; font-weight: 500; color: #797979;">Departments <br> <span style="color: black; font-size: 15px;"><?php echo isset($row['dept']) && !empty($row['dept']) ? $row['dept'] : '-'; ?>
                </span></p>
            <p style="font-size: 13px; font-weight: 500; color: #797979;">Work Locations <br> <span style="color: black; font-size: 15px;">
                    <?php echo isset($row['work_location']) && !empty($row['work_location']) ? $row['work_location'] : '-'; ?></span></p>
            <p style="font-size: 13px; font-weight: 500; color: #797979;">Employment Type <br> <span style="color: black; font-size: 15px;">
                    <?php echo isset($row['empty']) && !empty($row['empty']) ? $row['empty'] : '-'; ?>
                </span></p>
            <p style="font-size: 13px; font-weight: 500; color: #797979;">Status <br> <span style="color: black; font-size: 15px; color: #026ACB;">
                    <?php echo isset($row['status']) && $row['status'] == 1 ? 'ACTIVE' : '-'; ?>
                </span></p>
        </div>
        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
        <div onclick="window.location.href = './index.html';" class="backbtn">
            <img src="./public/arrow-back.svg" width="20px" style="scale: 1.4;" alt="">
        </div>

        <button data-modal-target="default-modal" data-modal-toggle="default-modal" data-tooltip-target="tooltip-default" type="button" class="addpolbtn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><img src="./public/plus.svg" width="20px" style="-webkit-filter: grayscale(1) invert(1);
    filter: grayscale(1) invert(1);" alt=""></button>

        <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            Add New Policy
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Create New Policy
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
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Policy
                                    Title</label>
                                <input type="text" list="titledatalist" autocomplete="off" name="policy_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Create a name for policy" required />
                                <datalist id="titledatalist">
                                    <?php
                                    $sql = "SELECT policy_title FROM policies_policy WHERE folder_name = '$folder_name' ";
                                    $result = $con->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["policy_title"] . "'>" . $row["policy_title"] . "</option>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                                </datalist>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Policy
                                    Category</label>
                                <input type="text" list="titledatalist1" autocomplete="off" name="policy_category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Create a name for policy category" required />
                                <datalist id="titledatalist1">
                                    <?php
                                    $sql = "SELECT policy_category FROM policies_policy WHERE folder_name = '$folder_name' ";
                                    $result = $con->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["policy_category"] . "'>" . $row["policy_category"] . "</option>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                                </datalist>

                            </div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Policy
                                Number</label>
                            <input type="text" name="policyno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" policy no" required />

                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Version</label>
                            <select id="countries" name="version" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Choose an option</option>
                                <option value="V1">1</option>
                                <option value="V2">2</option>
                                <option value="V3">3</option>
                                <option value="V4">4</option>
                            </select>

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
                            <select name="empty[]" multiple="multiple" style="height:100px;" id="emptySelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            <textarea id="message" rows="4" name="desc" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your description here..."></textarea> <br>
                            <textarea name="policy_content" id="policy_content"></textarea>

                    </div>
                    <input type="hidden" name="folder_name" value="<?php echo $folder_name; ?>">
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Send for Approval</button>
                        <!-- <button type="button" style="margin-left: 10px;" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save as Draft</button> -->
                        <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Dashboard -->
    <div class="maindash">
        <div class="relative overflow-x-auto maintab">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead style="position: sticky; top: 0px;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th>

                        </th>
                        <th scope="col" class="px-6 py-3">
                          Policy  Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                          Policy  No.
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                           dept
                        </th>
                        <th scope="col" class="px-6 py-3">
                             Version
                        </th>
                        <th scope="col" class="px-6 py-3">
                        Work Location
                        </th>
                        <th scope="col" class="px-6 py-3">
                    Employement Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created By
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created On
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM policies_policy WHERE folder_name = '$folder_name' AND status = 1 ORDER BY id ASC";
                $cnt = 1;
                $que = mysqli_query($con, $sql);

                if (mysqli_num_rows($que) > 0) {
                    while ($result = mysqli_fetch_assoc($que)) {
                ?>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    <?php echo $cnt++; ?>
                                </td>
                                <th scope="row" style="color: #026ACB;" class="px-6 py-4 font-medium text-blue-700 whitespace-nowrap dark:text-white">
                                    <a href="policy_content.php?policy_title=<?php echo urlencode($result['policy_title']); ?>&policyno=<?php echo urlencode($result['policyno']); ?>" style="color: inherit; text-decoration: none;">
                                        <?php echo htmlspecialchars($result['policy_title']); ?>
                                    </a>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo $result['policyno']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['desc']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['dept']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['version']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['work_location']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['empty']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['email']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $result['time']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                    if (isset($result['status']) && $result['status'] == 1) {
                                        echo 'ACTIVE';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    <?php
                    }
                } else {
                    ?>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4" colspan="9" style="text-align: center;">
                                No Policy Available
                            </td>
                        </tr>
                    </tbody>
                <?php
                }
                ?>

            </table>
        </div>

    </div>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
    <script>
        new MultiSelectTag('desgSelect')
        new MultiSelectTag('WLSelect')
        new MultiSelectTag('emptySelect')
    </script>
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('policy_content');

        // Function to update textarea before form submission
        function updateTextarea() {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        }

        $(document).ready(function() {
            $("#modalForm").submit(function(e) {
                e.preventDefault();

                // Update CKEditor textarea
                updateTextarea();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "insert_policy.php",
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
                                window.location.href = "index.php";
                            }
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'There was an error submitting the form.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

</html>
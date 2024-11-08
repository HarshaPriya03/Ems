<?php
@include '../inc/config.php';

$policy_title = isset($_GET['policy_title']) ? $_GET['policy_title'] : '';
$policyno = isset($_GET['policyno']) ? $_GET['policyno'] : '';
$version = isset($_GET['version']) ? $_GET['version'] : '';
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
        .detaildiv{
            display: flex;
            margin-left: 400px;
            gap: 20px;
            border: 1px solid rgb(224, 224, 224);
            padding: 10px;
            border-radius: 5px;
        }
        .leftdiv{
            background-color: white;
            width: 20%;
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }
        .rightdiv{
            background-color: white;
            width: 79.6%;
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }
        .ullisty{
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
        .ullisty1{
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
            transition: all 300ms ease;
        }
        .ullisty1:hover{
            background-color: #d3eaff;
            border-left: 5px solid #026ACB;
        }
        .mobileview{
            display: none;
        }
        .mobdiv{
            background-color: #d3eaff;
            padding: 5px; 
            border-radius: 3px;
            font-size: 15px;
        }
        .mobdiv1{
            font-size: 15px;
        }
        .mobdiv1:hover{
            background-color: #d3eaff;
        }
        .rejectbtn{
            background-color: rgb(255, 222, 222);
            color: rgb(255, 41, 41);
            border: 1px solid rgb(255, 41, 41);
            width: 80px;
            height: 40px;
            border-radius: 5px;
        }
        .publishbtn{
            background-color: rgb(222, 255, 222);
            color: rgb(14, 145, 14);
            border: 1px solid rgb(14, 145, 14);
            width: 80px;
            height: 40px;
            border-radius: 5px;
        }
        .righthead{
            font-size: 24px;
            margin-top: 15px;
            margin-left: 20px;
            border-left: 3px solid #026ACB;
            padding-left: 20px;
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
            .detaildiv{
                display: none;
            }
            .maindash{
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
            .detaildiv{
                display: none;
            }
            .maindash{
                height: 90vh;
                flex-direction: column;
            }
            .leftdiv{
                display: none;
            }
            .rightdiv{
                width: 100%;
            }
            .mobileview{
                background-color: white;
                border-radius: 5px;
                padding: 5px;
                display: flex;
                gap: 30px;
                justify-content: center;
            }
            .mobdiv1:hover{
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
    <div
        style="background-color: #ffffff;box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; display: flex; align-items: center;">
        <div style="display: flex;">
            <div class="topbardetails">
                <img src="./public/publish.png" width="60px" alt="">
            </div>
            <p style="margin-top: 10px;" class="text-xl font-semibold whitespace-nowrap dark:text-white">Policy Detail
                <br>
                <span style="color: #026ACB;">Restrictions</span></p>
        </div>
        <div onclick="window.location.reload();" class="reloadbtn">
            <img src="./public/reload-arrow-svgrepo-com.svg" width="20px" alt="">
        </div>
        <div onclick="window.location.href = './index.php';" class="backbtn">
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
            <div  onclick="window.location.href='./policydetails.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="mobdiv1">Details</div>
            <div onclick="window.location.href='./policyversions.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="mobdiv1">Versions</div>
            <div onclick="window.location.href='./policystatistics.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '"class="mobdiv1">Statistics</div>
            <div  class="mobdiv">Restrictions</div>
        </div>
        <div class="leftdiv">
            <div  onclick="window.location.href='./policydetails.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="ullisty1"><p style="font-size: 20px;">Details</p></div>
            <div onclick="window.location.href='./policyversions.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '" class="ullisty1"><p style="font-size: 20px;">Versions</p></div>
            <div onclick="window.location.href='./policystatistics.php?policy_title=<?php echo urlencode($row['policy_title']); ?>&version=<?php echo urlencode($row['version']); ?>&policyno=<?php echo urlencode($row['policyno']); ?> '"class="ullisty1"><p style="font-size: 20px;">Statistics</p></div>
            <div  class="ullisty"><p style="font-size: 20px;">Restrictions</p></div>
        </div>
        <div class="rightdiv">
            <div class="righthead">Restrictions</div>
            <button onclick="editFunction();" style="float: right; margin-top: -40px; margin-right: 10px; display: flex; gap: 4px;" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-5 h-5 text-white-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                  </svg>                      
            Edit</button>
            <div class="p-4 md:p-5 space-y-4">
                <form class="max-w-2xl" id="updateForm">
<?php
                $sql = "SELECT * FROM policies_policy WHERE version = ? AND policy_title = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ss', $version, $policy_title);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>
                    <label for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departments
                        to get access</label>
                    <select name="dept[]" multiple="multiple" style="height:100px;" id="desgSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="<?php echo $row['dept']; ?>" selected><?php echo $row['dept']; ?></option>
                    <option value="All">All</option>
                    <?php

                        $sql = "SELECT desg FROM dept";
                        $result = $con->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['desg'] . '">' . $row['desg'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No data available</option>';
                        }

                        ?>
                    </select>

                    <?php
                $sql = "SELECT * FROM policies_policy WHERE version = ? AND policy_title = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ss', $version, $policy_title);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>
                    <label for="countrie"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Work
                        Location to get access</label>
                    <select name="work_location[]" multiple="multiple" style="height:100px;" id="WLSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="<?php echo $row['work_location']; ?>" selected><?php echo $row['work_location']; ?></option>
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

                    <?php
                $sql = "SELECT * FROM policies_policy WHERE version = ? AND policy_title = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ss', $version, $policy_title);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>
                    <label for="countri"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employement
                        Type to get access</label>
                        <select name="empty[]" multiple="multiple" style="height:100px;" id="emptySelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="<?php echo $row['empty']; ?>" selected><?php echo $row['empty']; ?></option>             
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
                    
                    <br>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">                     
                    Save</button>
                </form>
            </div>
        </div>

    </div>
</body>
<script src='https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js'></script>
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script>
    $(document).ready(function() {
        $("#updateForm").submit(function(e) {
            e.preventDefault();

            var version = "<?php echo $version; ?>"; 
            var policy_title = "<?php echo $policy_title; ?>"; 

            var formData = new FormData(this);
            formData.append('version', version);
            formData.append('policy_title', policy_title);

            $.ajax({
                type: "POST",
                url: "update_policy.php",
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
                            window.location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error updating the record.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

<script>
                new MultiSelectTag('desgSelect') 
                new MultiSelectTag('WLSelect') 
                new MultiSelectTag('emptySelect') 
            </script>


<script>
function editFunction(){
    document.getElementById('countries').removeAttribute('disabled');
    document.getElementById('countrie').removeAttribute('disabled');
    document.getElementById('countri').removeAttribute('disabled');
}
</script>
</html>

<!DOCTYPE html>
<?php
@include 'inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

$sqlEmployeeName = "SELECT empname,desg,empph,work_location FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultEmployeeName = mysqli_query($con, $sqlEmployeeName);
$employeeNameRow = mysqli_fetch_assoc($resultEmployeeName);
$employeeName = $employeeNameRow['empname'];
$employeeDesg = $employeeNameRow['desg'];
$employeePhone = $employeeNameRow['empph'];
$work_location = $employeeNameRow['work_location'];

$currentDate = date('Y-m-d');

// New code to fetch and store remotework details in session
$sqlRemoteWork = "SELECT id, status,apr FROM remotework WHERE empname = ? AND (status != 2) ORDER BY `from` DESC LIMIT 1";
$stmtRemoteWork = $con->prepare($sqlRemoteWork);
$stmtRemoteWork->bind_param("s", $employeeName);
$stmtRemoteWork->execute();
$resultRemoteWork = $stmtRemoteWork->get_result();

if ($resultRemoteWork->num_rows > 0) {
    $rowRemoteWork = $resultRemoteWork->fetch_assoc();
    $_SESSION['remotework_id'] = $rowRemoteWork['id'];
    $_SESSION['remotework_status'] = $rowRemoteWork['status'];
    $_SESSION['remotework_apr'] = $rowRemoteWork['apr'];
} else {
    $_SESSION['remotework_id'] = 0;
    $_SESSION['remotework_status'] = 0;
}

$stmtRemoteWork->close();

if ($statusRow['empstatus'] == 0) {
?>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.4-rc1/css/foundation.css'>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
  table {
        z-index: 100;
  border-collapse: collapse;
  background-color: white;
}

th, td {
  padding: 1em;
  border-bottom: 2px solid rgb(193, 193, 193); 
}
.even {
  border-bottom: 2px solid #e8e8e8ba; 
    }

    .odd {
        background-color: #e9e9e9 !important; 
    }
    .quote-imgs-thumbs {
  background: #eee;
  border: 1px solid #ccc;
  border-radius: 0.25rem;
  margin: 1.5rem 0;
  padding: 0.75rem;
}
.quote-imgs-thumbs--hidden {
  display: none;
}
.img-preview-thumb {
  background: #fff;
  border: 1px solid #777;
  border-radius: 0.25rem;
  box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
  margin-right: 1rem;
  max-width: 140px;
  padding: 0.25rem;
}
.container {
            max-width: 800px;
            width: 100%;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 10px;
        }

        button {
            font-size: 16px;
            cursor: pointer;
            margin: 4px;
            padding: 8px 12px;
            border: none;
            background: #ffffff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #f3f3f3;
        }

        .editor {
            border: 1px solid #ccc;
            min-height: 200px;
            padding: 10px;
            overflow-y: auto;
            border-radius: 8px;
        }

        #charCount,
        #wordCount {
            float: right;
            margin-top: 10px;
            color: #777;
            text-align: left;
            margin-right: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .toolbar {
                flex-direction: column;
                align-items: center;
            }

            .toolbar button {
                margin: 4px 0;
            }

            .editor {
                min-height: 150px;
            }
        }

        ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #bebebe;
    }
    .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }

        .modal.show {
            display: block; 
        }

        .timer-container {
            margin-top:-20px;
    text-align: center;
    background-color: #ffffff;
    padding: 0px;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.timer {
    position: relative;
    width: 120px; 
    height: 120px; 
    margin: 0px auto;
}

.timer svg {
    position: absolute;
    top: 0;
    left: 0;
}

.timer .time {
    font-size: 1rem; 
    line-height: 120px; 
    z-index: 1;
    position: relative;
}

.start-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.start-button:hover {
    background-color: #0056b3;
}
@keyframes gentle-pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.timer-icon {
    animation: gentle-pulse 2s infinite;
}
.heading-container {
  display: flex;
  justify-content: flex-end;
  margin: 30px 0;
  padding-right: 30px;
  
}

.heading-box {
  background-color: #3B82F6;
  padding: 15px 30px;
  border-left: 8px solid #0056b3;
  border-radius:8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.heading-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

.main-heading {
  font-size: 22px;
  font-weight: 700;
  color: #ffffff;
  margin: 0;
  text-transform: uppercase;
  letter-spacing: 2px;
}
.sub-heading {
  font-size: 18px;
  color: #e0e7ff;
  margin: 5px 0 0 0;
  font-weight: 500;
}
.custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #F46114;
            border-radius: 10px;
            border: 3px solid #FFFFFF;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #F0F0F0;
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #F46114 #F0F0F0;
        }

        .process-block {
            background-color: white;
            border: 2px solid #1A56DB;
            border-radius: 10px;
            padding: 15px;
            width: 375px;
            max-width:100%;
            max-height:94%;
            font-size:15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1A56DB;
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }
        h2::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background-color: #1A56DB;
            margin: 10px auto 0;
        }
        .step {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .step-number {
            background-color: #1A56DB;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            font-weight: bold;
            font-size: 18px;
        }
        .step-text {
            color: #333;
            
            flex-grow: 1;
        }

        .mgr-view{
          margin-top:-600px;
          margin-left:-20px;
          color:white;
          font-size:20px;
        }
       
        .attendence-inner {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .attendence-inner svg {
            flex-shrink: 0;
        }

        .attendence-inner span {
            margin-left: 5px;
        }
        .attendence-inner span{
          white-space: nowrap;
        }
    </style>
  </head>
  <body>
    <div class="attendence4" style="margin-left:auto;margin-right:auto;">
      <div class="bg14"></div>
      <div class="rectangle-parent22" style="margin-left:0px;">
        <div class="frame-child187"></div>
            <a class="frame-child188" style="background-color: #E8E8E8;"> </a>
        <a class="attendence5" style="color: black;">Attendance</a>
    <a class="frame-child191" id="rectangleLink3" style="margin-left: -450px;"> </a>
    <a class="frame-child191" id="rectangleLink3" style="margin-left: 35px; background-color: #ffe2c6;"> </a>
        <a href="attendanceemp.php" class="my-attendence4" id="myAttendence" style="margin-left: -450px;">Attendance log</a>
        <a class="frame-child191" id="rectangleLink3" href="sheet_emp.php" target="_blank" style="margin-left: -200px;"> </a>
        <a href="sheet_emp.php" class="my-attendence4" id="myAttendence" target="_blank" style="margin-left: -205px; margin-top:2px; font-size:18px; width:200px">Monthly Attendance</a>
        <a href="sheet_emp.php" class="my-attendence4" id="myAttendence" style="margin-left: 32px; margin-top:2px; font-size:18px; width:200px; color: #ff5400;">Remote Attendance</a>
      </div>
<?php
  $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0)";
  $que = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($que);
  $empname = $row['empname'];
  $desg = $row['desg'];
  $UserID = $row['UserID'];
  $ServiceTagId = $row['ServiceTagId'];
  $work_location = $row['work_location'];

$sql = "SELECT * FROM remotework WHERE empname = ? AND status != 2 ";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $empname);
$stmt->execute();
$result = $stmt->get_result();

$buttonEnabled = false;
$status = 0;
$id = 0 ;
$mgrname = '';
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
    $id = $row['id'];
    $mgrname = $row['mgrname'];
    
    $from = DateTime::createFromFormat('m/d/Y', $row['from'])->setTime(0, 0, 0);
    $to = DateTime::createFromFormat('m/d/Y', $row['to'])->setTime(23, 59, 59);
    $today = (new DateTime())->setTime(0, 0, 0);
    
    if ($today >= $from && $today <= $to) {
        $buttonEnabled = true;
    } 
} 

// Use LIKE operator for partial matching
$mgrsql = "SELECT empname FROM manager WHERE desg LIKE '%$desg%'";

// Execute the query
$que = mysqli_query($con, $mgrsql);

// Check if the query was successful
if ($que) {
    // Fetch the result
    $row = mysqli_fetch_array($que);

    // Check if a row was fetched
    if ($row) {
        $mgrname = $row['empname'];
        echo "Manager Name: " . $mgrname;
    } else {
        echo "No manager found with the designation: " . $desg;
    }
} else {
    echo "Error: " . mysqli_error($con);
}

?>

      <!-- main div -->
      <div class="rectangle-parent23 " style="margin-left: 0px;">
        <div style="background-color: white; height: 600px; width: 250vh; max-width:100%;border-radius: 20px;"></div>
        <div class=" overflow-x-auto shadow-md sm:rounded-lg" style="height:380px;position:absolute;bottom: 200px;width:100%;">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
    Remote Work History 
    <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
        Overview of your remote work sessions and attendance records.
    </p>
</caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Remote Work Duration
                </th>
                <th scope="col" class="px-6 py-3">
                Project/Task
                </th>
                <th scope="col" class="px-6 py-3">
                    Approving Authority
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">View</span>
                    Details
                </th>
                <th scope="col" class="px-6 py-3">
            Productivity Score
        </th>
            </tr>
        </thead>
      
        <?php
$sql = "SELECT remotework.*, 
(SELECT SUM(score) FROM remotework_emp WHERE remotework.id = remotework_emp.link_id) AS total_score 
FROM remotework WHERE empname = '$empname' ORDER BY id desc";

$que = mysqli_query($con, $sql);
$cnt = 1;
?>

<tbody>
    <?php
    if (mysqli_num_rows($que) == 0) {
        echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No remote work history</td></tr>';
    } else {
        while ($result = mysqli_fetch_assoc($que)) {
            $apr = $result['apr'];
               $status = $result['status'];
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo htmlspecialchars($result['from']); ?> to <?php echo htmlspecialchars($result['to']); ?>
                </th>
             <td class="px-6 py-4" style="width: 350px; overflow: hidden; text-overflow: ellipsis; ">
    <?php echo htmlspecialchars($result['reason']); ?>
</td>

                <td class="px-6 py-4">
                    <?php echo htmlspecialchars($result['mgrname']); ?>
                </td>
                <td>
                <?php
if ($apr == 1) {
    echo '<sub>
        <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Approved</span>
            </div>
        </div>
    </sub>';
    echo htmlspecialchars($result['approved']);
} elseif ($apr == 0) {
    echo '<sub>
        <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Pending for Approval</span>
            </div>
        </div>
    </sub>';
} elseif ($apr == 2) {
    echo '<sub>
        <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Request Rejected</span>
            </div>
        </div>
    </sub>';
}
?>
                </td>
                <td>
    <?php
    if ($apr == 1) {
        if ($status == 0) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-yellow-100 border border-yellow-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-700">Session not started</span>
            </div>';
        } elseif ($status == 1) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-green-100 border border-green-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-medium text-green-700">Session started</span>
            </div>';
        } else {
            echo '<a id="readProductButton" data-link-id="' . htmlspecialchars($result['id']) . '" data-modal-target="readProductModal" data-modal-toggle="readProductModal" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>';
        }
    } elseif ($apr == 0) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Pending for Approval</span>
                </div>
            </div>
        </sub>';
    } elseif ($apr == 2) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Request Rejected</span>
                </div>
            </div>
        </sub>';
    }
    ?>
</td>
             <td>
    <?php
    if ($apr == 1) {
        if ($status == 0) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-yellow-100 border border-yellow-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-700">Session not started</span>
            </div>';
        } elseif ($status == 1) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-green-100 border border-green-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-medium text-green-700">Session started</span>
            </div>';
        } elseif ($status == 2) {
            if (is_null($result['total_score']) || $result['total_score'] == 0) {
                echo '<div class="inline-flex items-center px-1 py-1 bg-yellow-100 border border-yellow-400 rounded-lg">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-yellow-700">Work Verification Pending</span>
                </div>';
            } else {
                echo '<div class="inline-flex items-center px-1 py-1 bg-blue-100 border border-blue-400 rounded-lg">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5v2m6-2v2"></path>
                    </svg>
                    <span class="text-sm font-medium text-blue-700">Score: ' . htmlspecialchars($result['total_score']) . '</span>
                </div>';
            }
        }
    } elseif ($apr == 0) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Pending for Approval</span>
                </div>
            </div>
        </sub>';
    } elseif ($apr == 2) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Request Rejected</span>
                </div>
            </div>
        </sub>';
    }
    ?>
</td>
            </tr>
            <?php
            $cnt++;
        }
    }
    ?>
</tbody>

    </table>
</div>
<!-- Main modal -->
<div id="readProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5 custom-scrollbar" style="height:780px;overflow-x:auto;">
            <!-- Modal header -->
            <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                    <h3 class="font-semibold">Remote Work Sessions</h3>
                </div>
            </div>
            <!-- Modal body -->
            <div id="modalContent">
                <!-- Content -->
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('readProductModal');
    const modalContent = document.getElementById('modalContent');
    const buttons = document.querySelectorAll('[data-modal-toggle="readProductModal"]');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const linkId = this.getAttribute('data-link-id');
            fetch('get_remote_work_data.php?link_id=' + linkId)
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                    modal.classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Close modal when clicking outside
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Close modal when clicking close button
    const closeButton = modal.querySelector('[data-modal-toggle="readProductModal"]');
    closeButton.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
});
</script>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: -575px;">
        <?php if (isset($buttonEnabled) && isset($rowRemoteWork['status']) && $buttonEnabled && $rowRemoteWork['status'] == 0 && $rowRemoteWork['apr'] == 1) { ?>
    <div class="heading-container">
        <div class="heading-box">
            <h1 class="main-heading">Remote Work Hub</h1>
            <p class="sub-heading">Attendance & Reporting</p>
        </div>
    </div>
    <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-500 rounded-lg shadow-lg text-white">
        <div class="flex-1 mr-6">
            <p class="text-lg font-semibold mb-2">
                Ready to start your remote work session?
            </p>
            <p class="text-sm opacity-90">
                Click the timer to mark your attendance and begin your work hours. Remember to start at your designated time!
            </p>
        </div>
        <div class="flex items-center">
            <div class="mr-4 text-right">
                <p class="text-xs uppercase tracking-wide">Your Timer</p>
                <p style="margin-left:50px;">
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </p>
            </div>
        </div>
    </div>
<?php } elseif (isset($rowRemoteWork['status']) && $rowRemoteWork['status'] == 1 ) { ?>
    <div class="heading-container">
        <div class="heading-box">
            <h1 class="main-heading">Remote Work Hub</h1>
            <p class="sub-heading">Attendance & Reporting</p>
        </div>
    </div>
    <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-500 rounded-lg shadow-lg text-white">
        <div class="flex-1 mr-6">
            <p class="text-lg font-semibold mb-2">
                Your remote work session is in progress !!
            </p>
            <p class="text-sm opacity-90">
                When you're finished, click the 'Stop' button to end your work day. This will:
                <ul class="list-disc list-inside mt-2 text-xs">
                    <li>Open a form to confirm your attendance</li>
                    <li>Prompt you to write a work report</li>
                    <li>Allow you to upload images as proof of work</li>
                </ul>
                <span class="text-xs">Remember to complete all steps to ensure accurate tracking of your remote work.</span>
            </p>
        </div>
        <div class="flex items-center">
            <div class="mr-4 text-right">
                <p class="text-xs uppercase tracking-wide">Your Timer</p>
                <p style="margin-left:100px;">
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </p>
            </div>
        </div>
    </div>

    <div class="timer-container">
    <div class="timer">
        <svg width="120" height="120">
            <circle cx="60" cy="60" r="40" stroke="#007bff" stroke-width="10" fill="none" />
        </svg>
        <div class="time" id="time">
        <?php 
$currentDate = date('Y-m-d');

$user_name = $_SESSION['user_name'];
$sql = "SELECT serviceTagId, UserID FROM emp WHERE empemail = '$user_name'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $serviceTagId = $row['serviceTagId'];

    // Determine the table name based on serviceTagId
    if ($serviceTagId == 'ZXQI19009096') {
        $tableName = 'CamsBiometricAttendance';
    } elseif ($serviceTagId == 'ZYSA07001899') {
        $tableName = 'CamsBiometricAttendance_GGM';
    } else {
        die("No attendance table associated with this serviceTagId.");
    }
}

$sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, $tableName.*
FROM emp
INNER JOIN $tableName ON emp.UserID = $tableName.UserID
AND emp.ServiceTagId = $tableName.ServiceTagId
WHERE emp.empstatus = 0
AND emp.empemail = '{$_SESSION['user_name']}'
AND DATE($tableName.AttendanceTime) = '$currentDate'
ORDER BY $tableName.AttendanceTime DESC";

$que = mysqli_query($con, $sql);

if ($row = mysqli_fetch_assoc($que)) {
    if ($row['AttendanceType'] == 'CheckIn') {
        $currentDay = date('j', strtotime($row['AttendanceTime']));
        $datetime = $row['AttendanceTime'];
        $time = date('H:i:s', strtotime($datetime)); 
        echo $time; 
    }
}
?>
</div>
    </div>
    <button class="start-button" id="stopButton"  data-modal-target="crud-modal" data-modal-toggle="crud-modal">Stop</button>
</div>
</div>
<?php } else { ?>
    
    <div class="heading-container">
        <div class="heading-box">
            <h1 class="main-heading" style="font-size:20px !important;">Remote Work Hub</h1>
            <p class="sub-heading">Attendance & Reporting</p>
        </div>
    </div>
    <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-500 rounded-lg shadow-lg text-white">
        <div class="flex-1 mr-6">
            <p class="text-lg font-semibold mb-2">
                Remote Work Authorization Needed
            </p>
            <p class="text-sm opacity-90">
                It looks like you do not have the necessary access to start a remote work session. If you believe you should have access, please contact your manager to get the required access OR apply using this
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="py-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Apply</button> button.
            </p>
        </div>
        <div class="flex items-center">
            <div class="mr-4 text-right">
                <p class="text-xs uppercase tracking-wide">Remote Work Session Unavailable</p>
                <svg class="w-12 h-12 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>
                </svg>
            </div>
        </div>
    </div>
    </div>
<?php } ?>
<!-- Apply modal -->
<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <div class="sm:col-span-2">
              <div class="process-block">
        <h2>Remote Work Process</h2>
        
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-text">Employee Applies for Remote Work Access</div>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <div class="step-text">Manager authorizes WFH request</div>
        </div>
        
        <div class="step">
            <div class="step-number">3</div>
            <div class="step-text">Employee starts remote timer</div>
        </div>
        
        <div class="step">
            <div class="step-number">4</div>
            <div class="step-text">Employee submits work report when timer stopped <br>
            and gets attendance for the day
          </div>
        </div>
        
        <div class="step">
            <div class="step-number">5</div>
            <div class="step-text">Manager verifies work</div>
        </div>
    </div>
            </div>
            </div>
            <!-- Modal body -->
          <!-- Modal body -->
<div class="p-4 md:p-5">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Remote Work Application</h2>
    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">Please fill out this form to apply for remote work.</p>
    <form class="space-y-4" id="applyInsert">
        <div>
            <label for="date-range-picker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Remote Work Duration
            </label>
            
            <div id="date-range-picker" date-rangepicker class="flex items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mb-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-range-start" name="from" type="text" class="datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select Start Date">
                </div>
                <span class="mx-4 text-gray-500 mb-5">to</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mb-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-range-end" name="to" type="text" class="datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select End Date">
                </div>
            </div>
        </div>
        <div>
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Project/Task for Remote Work Request
            </label>
            <textarea id="description" rows="8" name="reason" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Describe your project or task for remote work"></textarea>
        </div>
        <input type="hidden" value="<?php echo $desg ?>" name="desg">
        <input type="hidden" value="<?php echo $empname ?>" name="empname">
        <input type="hidden" value="<?php echo $mgrname ?>" name="mgrname">
        <div class="flex items-center mt-6 space-x-4 rtl:space-x-reverse">
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Remote Work Application</button>
            <button data-modal-hide="authentication-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
        </div>
    </form>
</div>
        </div>
    </div>
</div> 

  <form id="remoteInsert">
  <input type="hidden" value="<?php echo $work_location?>" name="work_location">
<input type="hidden" value="<?php echo $UserID?>" name="userId">
<input type="hidden" value="<?php echo $ServiceTagId?>" name="ServiceTagId">
<input type="hidden" value="CheckIn" name="checkIn">
<input type="hidden" value="Remote Attendance" name="Type">
<input type="hidden" id="currentDateTime1" name="time" value="">

<?php if ($buttonEnabled && $rowRemoteWork['status'] == 0 && $rowRemoteWork['apr'] == 1): ?>
  
   <div class="timer-container ">
    <div class="timer">
        <svg width="120" height="120">
            <circle cx="60" cy="60" r="40" stroke="#007bff" stroke-width="10" fill="none" />
        </svg>
        <div class="time" id="time">00:00:00
</div>

    </div>
    <button class="start-button animate-pulse" id="startButton">Start</button>
</div>
    </div>
    <hr style="width: 160vh; max-width:100%; margin-left: 30px; color: rgb(26, 26, 26);">
<?php else: ?>
<?php endif; ?>
</form>

<form id="remoteInsert1">
<input type="hidden" value="<?php echo $work_location?>" name="work_location">
<input type="hidden" value="<?php echo $UserID?>" name="userId">
<input type="hidden" value="<?php echo $ServiceTagId?>" name="ServiceTagId">
<input type="hidden" value="CheckOut" name="checkIn">
<input type="hidden" value="Remote Attendance" name="Type">
<input type="hidden" id="currentDateTime" name="time" value="">
</form>
</div>
<hr style="width: 160vh; max-width:100%; margin-left: 30px; color: rgb(26, 26, 26);">
<?php
      $currentDate = date('Y-m-d');
      $user_name = $_SESSION['user_name'];
      $sql = "SELECT serviceTagId,UserID FROM emp WHERE empemail = '$user_name'";
      $result = $con->query($sql);
      
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $serviceTagId = $row['serviceTagId'];
      
          // Determine the table name based on serviceTagId
          if ($serviceTagId == 'ZXQI19009096') {
              $tableName = 'CamsBiometricAttendance';
          } elseif ($serviceTagId == 'ZYSA07001899') {
              $tableName = 'CamsBiometricAttendance_GGM';
          } else {
              die("No attendance table associated with this serviceTagId.");
          }

      }

      $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, $tableName .*
      FROM emp
      INNER JOIN $tableName  ON emp.UserID = $tableName .UserID
      AND emp.ServiceTagId = $tableName .ServiceTagId
      WHERE emp.empstatus = 0
      AND   emp.empemail = '{$_SESSION['user_name']}'
       AND DATE($tableName .AttendanceTime) = '$currentDate'
      ORDER BY $tableName .AttendanceTime DESC";

    $que = mysqli_query($con, $sql);
    $userCheckOut = array();
    $userEntriesCount = array();
    $prevDay = null;

    while ($result = mysqli_fetch_assoc($que)) {
        $userId = $result['UserID'];
        $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
        $formattedDate = date('D j M', strtotime($result['AttendanceTime']));

        if ($result['AttendanceType'] == 'CheckOut') {
            $userCheckOut[$userId] = array(
              'AttendanceTime' => $result['AttendanceTime'],
              'InputType' => $result['InputType'],
              'Department' => $result['dept']
            );
        } elseif ($result['AttendanceType'] == 'CheckIn') {
            $currentDay = date('j', strtotime($result['AttendanceTime']));
          
            ?>

<!-- Main modal -->
<div id="crud-modal" class="modal">
    <div class="modal-content">
        <p>Remote Workday Report Submission</p>
        <form class="p-4 md:p-5" id="updateForm" enctype="multipart/form-data">
                <div class="grid gap-4 mb-4 grid-cols-2">
                 
                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Time</label>
                        <input type="text" name="start" id="start" value="<?php echo isset($result['AttendanceTime']) ? $result['AttendanceTime'] : ''; ?>" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Time</label>
                        <input type="text" name="end" id="end" value="<?php echo $userCheckOut[$userId]['AttendanceTime']; ?>" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Hours Worked</label>
                        <?php
                $empname = $result['empname'];

                $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

                $result_dept = $con->query($sql); // Renamed $result to $result_dept to avoid variable conflict

                if ($result_dept->num_rows > 0) {
                  while ($row = $result_dept->fetch_assoc()) {
                    // Convert fromshifttime1 and toshifttime1 to DateTime objects
                    $fromShiftTime = new DateTime($row['fromshifttime1']);
                    $toShiftTime = new DateTime($row['toshifttime1']);

                    // Calculate the difference between the times
                    $interval = $fromShiftTime->diff($toShiftTime);

                    // Format the difference
                    $duration = $interval->format('%s'); // Store duration in seconds
                  }
                } else {
                  echo "No designation found for this employee";
                }
                ?>

<?php
$inputValue = '';

if (isset($userCheckOut[$userId])) {
    $inTime = strtotime($result['AttendanceTime']);
    $outTime = strtotime($userCheckOut[$userId]['AttendanceTime']);
    
    // Calculate the difference in seconds
    $secondsDiff = $outTime - $inTime;
    
    // Calculate hours and minutes
    $hours = floor($secondsDiff / 3600);
    $minutes = floor(($secondsDiff % 3600) / 60);
    $durationMinutes = $interval->h * 60 + $interval->i;
    $totalMinutes = $hours * 60 + $minutes;
    $difference = $durationMinutes - $totalMinutes;
    
    if (($hours * 60 + $minutes) < $durationMinutes) {
        $inputValue = $hours . ' hrs ' . $minutes . ' mins';
        $differenceHours = floor($difference / 60);
        $differenceMinutes = $difference % 60;
        $inputValue .= ' [-' . $differenceHours . ' hrs ' . $differenceMinutes . ' mins]';
    } elseif (($hours * 60 + $minutes) > 720) {
        $inputValue = $hours . ' hrs ' . $minutes . ' mins (12 Hrs exceeded)';
    } else {
        $inputValue = $hours . ' hrs ' . $minutes . ' mins';
    }
} else {
    $timeInput = strtotime($result['AttendanceTime']);
    $origin = new DateTime(date('Y-m-d H:i:s', $timeInput));
    $target = new DateTime(); // Current time
    $target->modify('+5 hours 30 minutes');
    $interval = $origin->diff($target);
    
    if ($interval->h > 10) {
        $inputValue = $interval->format('%h hrs %i mins') . ' (12 Hrs exceeded)';
    } else {
        $inputValue = $interval->format('%h hrs %i mins');
    }
}
?>
                        <input type="text" name="total" id="total" value="<?php echo htmlspecialchars($inputValue); ?>" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"  required="">
                    </div>
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Work Report</label>
                        <textarea id="description" name="report" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your work report here"></textarea>                    
                    </div>
                    <caption class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Upload your work images
                    </caption>
                    <div id="dropzone-container" class="flex items-center justify-center w-full col-span-2">
    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG (MAX. 5MB)</p>
        </div>
        <div id="preview-container" class="hidden flex flex-wrap justify-center w-full p-2"></div>
        <input id="dropzone-file" type="file" class="hidden" name="work_pics[]" multiple />
    </label>
</div>

                </div>
                <input type="hidden" value="<?php echo $id ?>" name="id">
                <input type="hidden" value="<?php echo $empname ?>" name="empname">
                <input type="hidden" value="<?php echo $mgrname ?>" name="mgrname">
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Submit
                </button>
            </form>
    </div>
    <?php
        }
    }
    ?>
</div>
        <hr style="width: 160vh; max-width:100%; margin-left: 30px; color: rgb(26, 26, 26);">
        
</div>
</div>
       
      
      <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm14" href="./employee-dashboard.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm14">HRM</span>
      </a>
      <a
        class="attendence-management4"
        href="./employee-dashboard.php"
        id="attendenceManagement"
        >Attendance Management</a
      >

      <?php

$select = "SELECT uf.*, m.status as manager_status 
FROM user_form uf
LEFT JOIN manager m ON uf.email = m.email 
WHERE uf.email = ?";

$stmt = mysqli_prepare($con, $select);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$_SESSION['user_name'] = $row['email'];
$_SESSION['admin_name'] = $row['name'];

$manager_status = $row['manager_status'];
} else {
// Handle case where user is not found
echo "User not found";
exit;
}

    $email1 = $row['email'];

    $sql = "SELECT * FROM user_form WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      $user_type = $row['user_type'];
      $user_type1 = $row['user_type1'];

      $is_enabled = ($user_type == 'user' && $user_type1 == 'admin');
    } else {
      $is_enabled = false;
    }
    ?>
    <?php
    if ($is_enabled) {
    ?>
      <a style="height:45px;width:150px;text-decoration:none;" href="index.php"  class="attendence-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>HR View</span>
        </a>
        <?php
    }?>
      <?php if ($manager_status == 1): ?>
        <a style="margin-top:-545px;height:40px;text-decoration:none;width:190px;" href="dash_mgr.php"  class="attendence-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>Manager View</span>
        </a>
        <?php endif; ?>
      <button class="attendence-inner"><a  href="logout.php" style="margin-left:50px; color:white; text-decoration:none; font-size:25px">Logout</a></button>
      <!--<div class="logout14">Logout</div>-->
      <a style="margin-top: -35px; text-decoration:none; color:black;font-size:22px;font-weight: normal !important;" href="card.php" class="payroll14">Directory</a>
      <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

      <img style="margin-top: -35px;"
        class="arcticonsgoogle-pay14"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img style="margin-top: -50px;" class="attendence-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard14" style="margin-top: 60px;font-size:22px;font-weight: normal !important;" href="./employee-dashboard.php" id="dashboard">Dashboard</a>
      <a style="margin-top: 60px;"
        class="akar-iconsdashboard14"
        href="./employee-dashboard.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon74" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

      <a class="leaves14" id="leaves" href="apply-leave-emp.php" style="font-size:22px;font-weight: normal !important;">Leaves</a>
      <a
        class="fluentperson-clock-20-regular14"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon75" alt="" src="./public/vector1.svg" />
      </a>
      <a style="margin-top: -50px;font-size:22px;font-weight: normal !important;" class="attendance14" >Attendance</a>
      <a style="margin-top: -50px;" class="uitcalender14">
        <img class="vector-icon77" alt="" src="./public/vector11.svg" />
      </a>
      <div class="oouinext-ltr3"></div>
    </div>
    <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
    <script>
function showPreviewModal(pics) {
    const previewModal = document.getElementById('previewModal');
    const previewContent = document.getElementById('previewContent');
    previewContent.innerHTML = '';

    pics.forEach(pic => {
        const imgElement = document.createElement('img');
        imgElement.src = 'work_pics/' + pic;
        imgElement.alt = pic;
        imgElement.classList.add('max-w-full', 'h-auto', 'rounded-lg', 'shadow-md');
        previewContent.appendChild(imgElement);
    });

    previewModal.classList.remove('hidden');
}

function hidePreviewModal() {
    const previewModal = document.getElementById('previewModal');
    previewModal.classList.add('hidden');
}
</script>

    <script>
        $(document).ready(function() {
            let lastAccessDate = localStorage.getItem('lastAccessDate');
            let currentDate = new Date().toLocaleDateString();

            if (lastAccessDate !== currentDate) {
                // Update the status in the database
                $.ajax({
                    type: "POST",
                    url: "update_remotework_status.php",
                    data: { 
                        id: '<?php echo $rowRemoteWork['id']; ?>',
                        status : '<?php echo $rowRemoteWork['status']; ?>'
                     },
                    success: function(response) {
                        console.log('Status Updated: ', response);
                        localStorage.setItem('lastAccessDate', currentDate);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error: ', textStatus, errorThrown);
                    }
                });
            }
        });
    </script>
<script>
function updateDateTime() {
    fetch('https://worldtimeapi.org/api/ip')
        .then(response => response.json())
        .then(data => {
            const dateTime = new Date(data.datetime);
            const formattedDateTime = dateTime.toLocaleString('sv-SE').replace('T', ' ');
            document.getElementById('currentDateTime').value = formattedDateTime;
            document.getElementById('currentDateTime1').value = formattedDateTime;
        })
        .catch(error => {
            console.error('Error fetching time:', error);
            // Fallback to local time if API call fails
            const localDateTime = new Date().toLocaleString('sv-SE').replace('T', ' ');
            document.getElementById('currentDateTime').value = localDateTime;
            document.getElementById('currentDateTime1').value = localDateTime;
        });
}
updateDateTime();
setInterval(updateDateTime, 1000);
</script>
    <script>
  // Get the button and modal elements
  const openModalBtn = document.getElementById('openModalBtn');
  const modal = document.getElementById('crud-modal');
  const closeBtn = modal.querySelector('.close');

  // Function to open the modal
  function openModal() {
    modal.style.display = 'block';
  }

  // Function to close the modal
  function closeModal() {
    modal.style.display = 'none';
  }

  // Event listeners
  openModalBtn.addEventListener('click', openModal);
  closeBtn.addEventListener('click', closeModal);

  // Close the modal if clicked outside of it
  window.addEventListener('click', function(event) {
    if (event.target == modal) {
      closeModal();
    }
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const dropzoneContainer = document.getElementById('dropzone-container');
    const dropzoneContent = document.getElementById('dropzone-content');
    const previewContainer = document.getElementById('preview-container');
    const dropzoneFile = document.getElementById('dropzone-file');
    let uploadedFiles = []; // Array to store uploaded files

    dropzoneFile.addEventListener('change', handleFiles);

    dropzoneContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzoneContainer.classList.add('bg-gray-200', 'dark:bg-gray-600');
    });

    dropzoneContainer.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropzoneContainer.classList.remove('bg-gray-200', 'dark:bg-gray-600');
    });

    dropzoneContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzoneContainer.classList.remove('bg-gray-200', 'dark:bg-gray-600');
        console.log('Files dropped');
        handleFiles(e);
    });

    function handleFiles(e) {
        let files;
        if (e.dataTransfer) {
            files = e.dataTransfer.files;
            console.log('Handling files from drag and drop:', files);
        } else if (e.target && e.target.files) {
            files = e.target.files;
            console.log('Handling files from file input:', files);
        } else {
            files = e;
        }

        if (!files || files.length === 0) {
            console.log('No files selected');
            return;
        }

        // Filter and limit to 3 files
        const newFiles = Array.from(files).filter(file => validateFile(file));
        console.log('New valid files:', newFiles);
        uploadedFiles = [...uploadedFiles, ...newFiles].slice(0, 3);
        console.log('Uploaded files:', uploadedFiles);

        updatePreviews();

        // Hide dropzone content if files are uploaded
        if (uploadedFiles.length > 0) {
            dropzoneContent.classList.add('hidden');
            previewContainer.classList.remove('hidden');
        }
    }

    function validateFile(file) {
        const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!validTypes.includes(file.type)) {
            alert('Invalid file type. Please upload PNG, JPG, or JPEG files only.');
            return false;
        }

        if (file.size > maxSize) {
            alert('File is too large. Maximum size is 5MB.');
            return false;
        }

        return true;
    }

    function updatePreviews() {
        previewContainer.innerHTML = ''; // Clear existing previews
        const previewWrapper = document.createElement('div');
        previewWrapper.className = 'flex flex-wrap justify-center gap-4';
        uploadedFiles.forEach((file, index) => createPreview(file, index, previewWrapper));
        previewContainer.appendChild(previewWrapper);
    }

    function createPreview(file, index, wrapper) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'relative flex flex-col items-center';
            preview.innerHTML = `
                <div class="w-40 h-40 flex items-center justify-center overflow-hidden rounded-lg shadow-md">
                    <img src="${e.target.result}" alt="${file.name}" class="max-w-full max-h-full object-contain">
                </div>
                <p class="text-xs mt-2 text-center w-40 truncate">${file.name}</p>
                <button class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-600 transition-colors" onclick="removeFile(${index})">×</button>
            `;
            wrapper.appendChild(preview);
        }
        reader.readAsDataURL(file);
    }

    // Add a reset button
    const resetButton = document.createElement('button');
    resetButton.textContent = 'Reset';
    resetButton.type = 'button';
    resetButton.className = 'mt-2 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600';
    resetButton.onclick = resetDropzone;
    dropzoneContainer.appendChild(resetButton);

    function resetDropzone() {
        uploadedFiles = []; // Clear the array of uploaded files
        dropzoneFile.value = ''; // Clear the file input
        previewContainer.innerHTML = ''; // Clear previews
        dropzoneContent.classList.remove('hidden');
        previewContainer.classList.add('hidden');
    }

    // Function to remove a file
    window.removeFile = function(index) {
        uploadedFiles.splice(index, 1);
        updatePreviews();
        if (uploadedFiles.length === 0) {
            dropzoneContent.classList.remove('hidden');
            previewContainer.classList.add('hidden');
        }
    }
});
</script>
<?php 
$currentDate = date('Y-m-d');

$user_name = $_SESSION['user_name'];
$sql = "SELECT serviceTagId, UserID FROM emp WHERE empemail = '$user_name'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $serviceTagId = $row['serviceTagId'];

    // Determine the table name based on serviceTagId
    if ($serviceTagId == 'ZXQI19009096') {
        $tableName = 'CamsBiometricAttendance';
    } elseif ($serviceTagId == 'ZYSA07001899') {
        $tableName = 'CamsBiometricAttendance_GGM';
    } else {
        die("No attendance table associated with this serviceTagId.");
    }
}

$sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, $tableName.*
FROM emp
INNER JOIN $tableName ON emp.UserID = $tableName.UserID
AND emp.ServiceTagId = $tableName.ServiceTagId
WHERE emp.empstatus = 0
AND emp.empemail = '{$_SESSION['user_name']}'
AND DATE($tableName.AttendanceTime) = '$currentDate'
ORDER BY $tableName.AttendanceTime DESC";

$que = mysqli_query($con, $sql);

// Initialize $time and a flag
$time = '00:00:00'; // Default value if no CheckIn entry is found
$timeDefined = false;

if ($row = mysqli_fetch_assoc($que)) {
    if ($row['AttendanceType'] == 'CheckIn') {
        $datetime = $row['AttendanceTime'];
        $time = date('H:i:s', strtotime($datetime)); 
        $timeDefined = true; // Flag indicating that time was set
    }
}

// Output the time and flag as JavaScript variables
?>

<script>
    $(document).ready(function() {
        $("#applyInsert").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "insert_remote_apply.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Applied Successfully!',
                        text: 'Remote work request has been sent to manager.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'remote_work_emp.php';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Approval Failed',
                        text: 'An error occurred while processing your request. Please try again.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        let timerInterval; // Declare the interval variable

        // Check if the form was submitted and the page was reloaded
        if (localStorage.getItem('formSubmitted') === 'true') {
            localStorage.removeItem('formSubmitted');
            openModal();
            $('.timer-container').hide(); // Hide the timer
        }

      // Stop button click handler
$('#stopButton').click(function() {
    Swal.fire({
        title: 'End Remote Work Session?',
        text: 'This will mark the end of your remote work session and post your attendance.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, end session',
        cancelButtonText: 'No, continue working',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#remoteInsert1').submit(); // Trigger form submission
        }
    });
});


    // Form submission handler
$("#remoteInsert1").submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    var workLocation = $("input[name='work_location']").val();
    var formData = new FormData(this);

    var url = workLocation === "Gurugram" ? "update_cams_ggm.php" : "update_cams.php";

    Swal.fire({
        title: 'Ending Remote Work Session',
        text: 'Please wait while we process your request...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Remote Work Session Ended',
                text: 'Your attendance has been successfully recorded.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.setItem('formSubmitted', 'true');
                    clearInterval(timerInterval); // Stop the timer
                    location.reload(); // Reload the page
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Session End Failed',
                text: 'There was an error ending your remote work session. Please try again or contact support.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
        }
    });
});
        // Function to open the modal
        function openModal() {
            $('#crud-modal').addClass('show'); // Show the modal
        }

        $('.close').click(function() {
            $('#crud-modal').removeClass('show'); // Hide the modal
        });

        // Get the initial time from the PHP output
        let initialTime = "<?php echo $time; ?>";
        let timerEnabled = <?php echo $timeDefined ? 'true' : 'false'; ?>;

        // Function to fetch current time from API
        function fetchCurrentTime() {
            return fetch('http://worldtimeapi.org/api/ip')
                .then(response => response.json())
                .then(data => {
                    return new Date(data.datetime);
                })
                .catch(error => {
                    console.error('Error fetching time:', error);
                    return new Date(); // Fallback to local time
                });
        }

        // Function to calculate time difference
        function calculateTimeDifference(currentTime) {
        if (!timerEnabled) {
            document.getElementById('time').textContent = '00:00:00';
            return;
        }

        const [hours, minutes, seconds] = initialTime.split(':').map(Number);
        const initialDateTime = new Date();
        initialDateTime.setHours(hours, minutes, seconds, 0); // Set the initial time

        const timeDifference = Math.floor((currentTime - initialDateTime) / 1000); // Difference in seconds

        const diffHours = String(Math.floor(timeDifference / 3600)).padStart(2, '0');
        const diffMinutes = String(Math.floor((timeDifference % 3600) / 60)).padStart(2, '0');
        const diffSeconds = String(timeDifference % 60).padStart(2, '0');

        document.getElementById('time').textContent = `${diffHours}:${diffMinutes}:${diffSeconds}`;
    }

    // Fetch current time from API and calculate time difference
    function fetchCurrentTime() {
        return fetch('http://worldtimeapi.org/api/ip')
            .then(response => response.json())
            .then(data => new Date(data.datetime))
            .catch(error => {
                console.error('Error fetching time:', error);
                return new Date(); // Fallback to local time
            });
    }

    setInterval(() => {
        fetchCurrentTime().then(currentTime => {
            calculateTimeDifference(currentTime);
        });
    }, 1000);
    });
</script>


<script>
    $(document).ready(function() {
        $("#updateForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "insert_remotework_emp.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $.ajax({
                        type: "POST",
                        url: "update_remotework.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(updateResponse) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Done!',
                                text: 'Both operations were successful!',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'remote_work_emp.php';
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while updating. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong while inserting. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#remoteInsert").submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Start Remote Work Session?',
                text: 'This will mark your attendance for the remote work session.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, start session',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    var empname = "<?php echo $empname; ?>";
                    var id = "<?php echo $rowRemoteWork['id']; ?>";
                    var workLocation = $("input[name='work_location']").val();
                    var formData = new FormData(this);
                    formData.append("empname", empname);

                    var url = workLocation === "Gurugram" ? "update_cams_ggm.php" : "update_cams.php";

                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Starting your remote work session',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Update the status in the remotework table
                    $.ajax({
                        type: "POST",
                        url: "update_remotework_emp.php?empname=" + empname + "&id=" + id,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Submit the form data to the selected URL
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Remote Work Session Started!',
                                        text: 'Your attendance has been recorded successfully.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#3085d6'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = 'remote_work_emp.php';
                                        }
                                    });
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Attendance Posting Failed',
                                        text: 'There was an error recording your attendance. Please try again or contact support.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#d33'
                                    });
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Session Start Failed',
                                text: 'There was an error starting your remote work session. Please try again or contact support.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        });
    });
</script>



  
<script>
      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var rectangleLink2 = document.getElementById("rectangleLink2");
      if (rectangleLink2) {
        rectangleLink2.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var rectangleLink3 = document.getElementById("rectangleLink3");
      if (rectangleLink3) {
        rectangleLink3.addEventListener("click", function (e) {
          window.location.href = "./attendanceemp.php";
        });
      }
      
      var records = document.getElementById("records");
      if (records) {
        records.addEventListener("click", function (e) {
          window.location.href = "./punch-i-n.php";
        });
      }
      
      var punchINOUT = document.getElementById("punchINOUT");
      if (punchINOUT) {
        punchINOUT.addEventListener("click", function (e) {
          window.location.href = "./punchout.php";
        });
      }
      
      var myAttendence = document.getElementById("myAttendence");
      if (myAttendence) {
        myAttendence.addEventListener("click", function (e) {
          window.location.href = "./attendanceemp.php";
        });
      }
      
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var attendenceManagement = document.getElementById("attendenceManagement");
      if (attendenceManagement) {
        attendenceManagement.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var leaves = document.getElementById("leaves");
      if (leaves) {
        leaves.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      </script>
<?php
  $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
  $que = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($que);
  $empname = $row['empname'];
  $UserID = $row['UserID'];
  $ServiceTagId = $row['ServiceTagId'];
  $work_location = $row['work_location'];

$sql = "SELECT * FROM remotework WHERE empname = ? AND status = 2 ";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $empname);
$stmt->execute();
$result = $stmt->get_result();

$buttonEnabled = false;
$status = 0;
$id = 0 ;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
    $id = $row['id'];
    $mgrname = $row['mgrname'];
    
    $from = DateTime::createFromFormat('m/d/Y', $row['from'])->setTime(0, 0, 0);
    $to = DateTime::createFromFormat('m/d/Y', $row['to'])->setTime(23, 59, 59);
    $today = (new DateTime())->setTime(0, 0, 0);
    
    if ($today >= $from && $today <= $to) {
        $buttonEnabled = true;
    } 
} 
?>
<?php
include 'inc/config.php'; // Ensure your database connection is included

// Check the 'to' date for this user in the remotework table
$sql = "SELECT `to` FROM remotework WHERE id = '$id'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $toDate = $row['to'];
} else {
    $toDate = null;
}

$currentDate = (new DateTime())->format('m/d/Y');

// Check if the `to` date is in the format `MM/DD/YYYY`
if ($toDate) {
    $toDateFormatted = date('m/d/Y', strtotime($toDate));
} else {
    $toDateFormatted = null;
}

// If toDate is not null and matches the current date, update the status
if ($toDateFormatted !== null && $toDateFormatted === $currentDate) {
    // Update the status in the database
    $updateStatusSql = "UPDATE remotework
                        SET status1 = '2'
                        WHERE id = '$id'";
    if ($con->query($updateStatusSql) === TRUE) {
        error_log("Record updated successfully for user ID: $id");
    } else {
        error_log("Error updating record: " . $con->error);
    }
}

$con->close();
?>

  </body>
</html>
<?php
} else {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
?>
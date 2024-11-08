<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
                 text: 'Login Again, if your still facing issues Contact HR!',
            }).then(function() {
              window.location.href = 'login-mob.php';
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

if ($statusRow['empstatus'] == 0) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />

        <link rel="stylesheet" href="./empmobcss/globalqw.css" />
        <link rel="stylesheet" href="./empmobcss/attendenceemp-mob.css" />
        <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
        <style>
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
  border-left: 8px solid #F46114;
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
            table {
                border: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border-collapse: collapse;
                border-spacing: 0;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
            }

            table thead {
                background: #F0F0F0;
                height: 60px !important;
            }

            table thead tr th:first-child {
                padding-left: 45px;
            }

            table thead tr th {
                text-transform: uppercase;
                line-height: 60px !important;
                text-align: left;
                font-size: 11px;
                padding-top: 0px !important;
                padding-bottom: 0px !important;
            }

            table tbody {
                background: #fff;
            }

            table tbody tr {
                border-top: 1px solid #e5e5e5;
                height: 60px;
            }

            table tbody tr td:first-child {
                padding-left: 45px;
            }

            table tbody tr td {
                height: 60px;
                line-height: 60px !important;
                text-align: left;
                padding: 0 10px;
                font-size: 14px;
            }

            table tbody tr td i {
                margin-right: 8px;
            }

            @media screen and (max-width: 850px) {
                table {
                    border: 1px solid transparent;
                    box-shadow: none;
                    margin-top: 10px;
                    z-index:9999;
                }

                table thead {
                    display: none;
                }

                table tbody tr {
                    border-bottom: 20px solid #F6F5FB;
                }

                table tbody tr td:first-child {
                    padding-left: 10px;
                }

                table tbody tr td:before {
                    content: attr(data-label);
                    float: left;
                    font-size: 10px;
                    text-transform: uppercase;
                    font-weight: bold;
                }

                table tbody tr td {
                    display: block;
                    text-align: right;
                    font-size: 14px;
                    padding: 0px 10px !important;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
                }
            }

            .approving-authority {
    max-width: 150px; 
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media screen and (max-width: 768px) { 
    .approving-authority {
        max-width: 100%;
        white-space: normal;
        word-wrap: break-word;
    }
}
        </style>
    </head>

    <body>
        <div class="attendenceemp-mob" style="height: 100svh;">
            <div class="logo-1-group">
                <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />
                <a class="attendance-management" style="width: 300px;">Attendance Management</a>
            </div>
            <div class="attendenceemp-mob-child"></div>
            <div class="attendenceemp-mob-item"></div>

            <?php
            $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
            $que = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($que);
            $empname = $row['empname'];
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
            $id = 0;
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
            ?>

            <div class="rectangle-parent">
                <a class="frame-item" href="attendenceemp-mob.php" style="background-color: #E8E8E8;"> </a>
                <a class="frame-inner" href="./attendancelogemp-mob.php"> </a>
                <a class="rectangle-a" style="width: 100px; background-color: #ffe2c6;"> </a>
                <a class="attendance" href="attendenceemp-mob.php" style="color: BLACK;">Attendance</a>
                <a class="punch-inout" href="./attendancelogemp-mob.php" style="width: 100px; margin-left: -5px;">Attendance Log</a>
                <a class="my-attendance" style="width: 100px; margin-left: -1px; color: #ff5400;">Monthly Attendance</a>
            </div>
            <div class="rectangle-parent9" style="margin-top: 15px;">
                <div class="frame-child23" style="position: relative;
        z-index: 1;">
  <?php if ($buttonEnabled && $status == 0) {?>
                <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-500 rounded-lg shadow-lg text-white ">
    <div class="flex-1 mr-6">
        <p class="text-lg font-semibold mb-2">
            Ready to start your remote work session?
        </p>
        <p class="text-sm opacity-90">
            Click the timer to mark your attendance and begin your work hours. Remember to start at your designated time!
        </p>
    </div>
</div>
<?php } ?>
<?php if ($status == 1) { ?> 
  <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-500 rounded-lg shadow-lg text-white ">
    <div class="flex-1 mr-6">
        <p class="text-lg font-semibold mb-2">
        Your remote work session is in progress !!
        </p>
        <p class="text-sm opacity-90">
    When you're finished, click the 'Stop' button to end your work day. This will:
    <ul class="list-disc list-inside mt-2 text-xs ">
        <li>Open a form to confirm your attendance</li>
        <li>Prompt you to write a work report</li>
        <li>Allow you to upload images as proof of work</li>
    </ul>
    <span class="text-xs ">Remember to complete all steps to ensure accurate tracking of your remote work.</span>
</p>
    </div>
</div>
<?php } ?>

<?php if ( $buttonEnabled == False) {?>
        <div class="heading-container">
  <div class="heading-box"  >
    <h1 class="main-heading" style="font-size:20px !important;">Remote Work Hub</h1>
    <p class="sub-heading">Attendance & Reporting</p>
  </div>
</div>
  <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-500 rounded-lg shadow-lg text-white ">
    <div class="flex-1 mr-6">
        <p class="text-lg font-semibold mb-2">
        Remote Work Authorization Needed
        </p>
        <p class="text-sm opacity-90">
        It looks like you do not have the necessary access to start a remote work session. If you believe you should have access, please contact your manager to get the required access.
        </p>
    </div>
    <div class="flex items-center">
    <div class="mr-4 text-right">
        <p class="text-xs uppercase tracking-wide">Remote Work Session Unavailable</p>
        <svg class="w-12 h-12 ml-auto " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
        </svg>
    </div>
</div>
</div>
<?php } ?>

  <form id="remoteInsert">
  <input type="hidden" value="<?php echo $work_location?>" name="work_location">
<input type="hidden" value="<?php echo $UserID?>" name="userId">
<input type="hidden" value="<?php echo $ServiceTagId?>" name="ServiceTagId">
<input type="hidden" value="CheckIn" name="checkIn">
<input type="hidden" value="Remote Attendance" name="Type">
<input type="hidden" id="currentDateTime1" name="time" value="">

<?php if ($buttonEnabled && $status == 0): ?>
  
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

<?php if ($status == 1 ): ?>
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
<?php endif; ?>
</form>
                    <table class="data" >
                        <thead>
                            <tr>
                                <th data-label="REMOTE WORK DURATION">REMOTE WORK DURATION</th>
                                <th data-label="PROJECT/TASK">PROJECT/TASK</th>
                                <th data-label="APPROVING AUTHORITY">APPROVING AUTHORITY</th>
                                <th data-label="STATUS">STATUS</th>
                                <th data-label="DETAILS">DETAILS</th>
                                <th data-label="PRODUCTIVITY SCORE">PRODUCTIVITY SCORE</th>
                            </tr>
                        </thead>
                        <?php
                        $sql = "SELECT remotework.*, 
(SELECT SUM(score) FROM remotework_emp WHERE remotework.id = remotework_emp.link_id) AS total_score 
FROM remotework WHERE empname = '$empname'";

                        $que = mysqli_query($con, $sql);
                        $cnt = 1;
                        ?>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($que) == 0) {
                                echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No remote work history</td></tr>';
                            } else {
                                while ($result = mysqli_fetch_assoc($que)) {
                            ?>
                                    <tr>
                                        <td data-label="REMOTE WORK DURATION" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <?php echo htmlspecialchars($result['from']); ?> to <?php echo htmlspecialchars($result['to']); ?>
                                        </td>
                                        <td data-label="PROJECT/TASK">
                                            <?php echo htmlspecialchars($result['reason']); ?>
                                        </td>
                                        <td data-label="APPROVING AUTHORITY" class="approving-authority">
                                            <?php echo htmlspecialchars($result['mgrname']); ?>
                                        </td>
                                        <td data-label="STATUS">
                                            <?php echo htmlspecialchars($result['approved']); ?>
                                        </td>
                                        <td data-label="DETAILS">
                                            <a id="readProductButton" data-link-id="<?php echo htmlspecialchars($result['id']); ?>" data-modal-target="readProductModal" data-modal-toggle="readProductModal" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                                        </td>
                                        <td data-label="PRODUCTIVITY SCORE">
                                            <?php
                                            if (is_null($result['total_score']) || $result['total_score'] <= 0) {
                                                echo '<span class="text-sm font-medium text-yellow-700">Pending for Verification</span>';
                                            } else {
                                                echo htmlspecialchars($result['total_score']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                        </tbody>
                <?php
                                    $cnt++;
                                }
                            }
                ?>
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
                <a class="employee-management1" style="margin-left: 12px;margin-top:-15px;">Remote Work History</a>
                <p class="employee-management1" style="font-size:10px;margin-top:20px;width:100%;margin-left:-40px;">Overview of your remote work sessions and attendance records.</p>
                <img class="frame-child24" style="margin-top:-40px;" alt="" src="./public/line-12@2x.png" />


            </div>
            <div class="arcticonsgoogle-pay-parent">
                <img class="arcticonsgoogle-pay1" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

                <div class="ellipse-div"></div>
                <a class="akar-iconsdashboard1" id="akarIconsdashboard">
                    <img class="vector-icon3" alt="" src="./public/vector1dash.svg" />
                </a>
                <a class="fluentperson-clock-20-regular1" id="fluentpersonClock20Regular">
                    <img class="vector-icon4" alt="" src="./public/vector1@2xleaves.png" />
                </a>
                <a class="uitcalender1">
                    <img class="vector-icon5" alt="" src="./public/vector3@2xattenblack.png" />
                </a>
            </div>
        </div>
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
                    url: "../update_remotework_status.php",
                    data: { id: '<?php echo $id; ?>' },
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
    fetch('http://worldtimeapi.org/api/ip')
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
             document.getElementById('currentDateTime1').value = formattedDateTime;
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

    var url = workLocation === "Gurugram" ? "../update_cams_ggm.php" : "../update_cams.php";

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
                url: "../insert_remotework_emp.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $.ajax({
                        type: "POST",
                        url: "../update_remotework.php",
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
                    var workLocation = $("input[name='work_location']").val();
                    var formData = new FormData(this);
                    formData.append("empname", empname);

                    var url = workLocation === "Gurugram" ? "../update_cams_ggm.php" : "../update_cams.php";

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
                        url: "../update_remotework_emp.php?empname=" + empname,
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
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('readProductModal');
    const modalContent = document.getElementById('modalContent');
    const buttons = document.querySelectorAll('[data-modal-toggle="readProductModal"]');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const linkId = this.getAttribute('data-link-id');
            fetch('../get_remote_work_data.php?link_id=' + linkId)
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
        <script>
            var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
            if (arcticonsgooglePay) {
                arcticonsgooglePay.addEventListener("click", function(e) {
                    window.location.href = "./directoryemp-mob.php";
                });
            }

            var akarIconsdashboard = document.getElementById("akarIconsdashboard");
            if (akarIconsdashboard) {
                akarIconsdashboard.addEventListener("click", function(e) {
                    window.location.href = "./emp-dashboard-mob.php";
                });
            }

            var fluentpersonClock20Regular = document.getElementById(
                "fluentpersonClock20Regular"
            );
            if (fluentpersonClock20Regular) {
                fluentpersonClock20Regular.addEventListener("click", function(e) {
                    window.location.href = "./apply-leaveemp-mob.php";
                });
            }
        </script>
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
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
    exit();
}
?>
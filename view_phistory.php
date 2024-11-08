<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['edit_id5'])) {
    $eid = $_POST['edit_id5'];

    $con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
    FROM emp
    INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
    WHERE empname = ?
    ";
    $query = $con->prepare($sql);
    $query->bind_param('s', $eid);
    $query->execute();
    $result = $query->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
?>
                <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class='header-row' style=" padding: 1em;
            border-bottom: 2px solid rgb(193, 193, 193);">
                            <th class='static-cell'>Date</th>

                            <th class='static-cell' style="border-left: 2px solid rgb(182, 182, 182);">Employee Name</th>
                            <th class='static-cell' colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">BreakOut Time <span style="margin-left:80px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
                            <th class='static-cell' colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">BreakIn Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
                            <th class='static-cell' style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Duration</th>
                        </tr>
                    </thead>
                    <?php
                  $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
                  FROM emp
                  INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
                  WHERE empname = ? AND (CamsBiometricAttendance.AttendanceType = 'BreakOut' OR CamsBiometricAttendance.AttendanceType = 'BreakIn')
                  ORDER BY CamsBiometricAttendance.AttendanceTime DESC";
          

                    $query = $con->prepare($sql);
                    $query->bind_param('s', $eid);
                    $query->execute();
                    $result = $query->get_result();
                    if ($result && $result->num_rows > 0) {
                    $cnt = 1;
                    $userBreakIn = array();
                    $prevDay = null;

                    while ($row = $result->fetch_assoc()) {
                        $userId = $row['UserID'];
                        $dayOfMonth = date('j', strtotime($row['AttendanceTime']));
                        $formattedDate = date('D j M', strtotime($row['AttendanceTime']));
                        $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

                        if ($row['AttendanceType'] == 'BreakIn') {
                            $userBreakIn[$userId] = array(
                                'AttendanceTime' => $row['AttendanceTime'],
                                'InputType' => $row['InputType'],
                                'Department' => $row['dept']
                            );
                        } elseif ($row['AttendanceType'] == 'BreakOut') {
                            $currentDay = date('j', strtotime($row['AttendanceTime']));
                            $borderBottom = ($prevDay !== null && $currentDay !== $prevDay) ? 'border-top: 4px solid #FB8B0B;' : '';

                            $breakOutAttendanceTime = strtotime($row['AttendanceTime']);
                            $breakInAttendanceTime = strtotime($userBreakIn[$userId]['AttendanceTime']);
                            $difference = $breakInAttendanceTime - $breakOutAttendanceTime;

                            $hours = floor($difference / 3600);
                            $minutes = floor(($difference % 3600) / 60);
                            $seconds = $difference % 60;
                            $timeDiffStyle = ($hours > 2 || ($hours == 2 && ($minutes > 0 || $seconds > 0))) ? 'color: red;' : 'color: green;';

                            $timeDiff = "";
                            if ($hours > 0) {
                                $timeDiff .= "$hours hrs ";
                            }
                            if ($minutes > 0) {
                                $timeDiff .= "$minutes mins ";
                            }
                            if ($seconds > 0) {
                                $timeDiff .= "$seconds secs";
                            }

                    ?>
                            <tr style=" padding: 1em;
            border-bottom: 2px solid rgb(193, 193, 193);" class="<?php echo $rowColorClass; ?> bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 style=" <?php echo $borderBottom; ?>">

                                <td class="px-6 py-4" style="white-space:nowrap;"><?php echo $formattedDate; ?></td>

                                <td class="px-6 py-4" style="border-left: 2px solid rgb(182, 182, 182);"><?php echo $row['empname']; ?></td>
                                <td class="px-6 py-4" style="border-left: 2px solid rgb(182, 182, 182);">
                                    <?php echo $row['AttendanceTime']; ?>
                                </td>
                                <td class="px-6 py-4"><?php echo $row['InputType']; ?></td>
                                <td class="px-6 py-4" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">
                                    <?php
                                    if (isset($userBreakIn[$userId])) {
                                        echo $userBreakIn[$userId]['AttendanceTime'];
                                    } else {
                                        echo '<span style="color: red !important;">Yet to Break In!</span>';
                                    }
                                    ?>
                                </td>
                                <td class="px-6 py-4" style="white-space:nowrap;">
                                    <?php
                                    if (isset($userBreakIn[$userId])) {
                                        echo $userBreakIn[$userId]['InputType'];
                                    } else {
                                        echo '<span style="color: red !important;">Yet to Break In!</span>';
                                    }
                                    ?>
                                </td>
                                <td style="white-space:nowrap;width:200px;border-left: 2px solid rgb(182, 182, 182);<?php echo $timeDiffStyle; ?>">
                                    <?php echo $timeDiff; ?>
                                </td>
                            </tr>
                    <?php
                            $prevDay = $currentDay;
                        }
                        $cnt++;
                    }
                } else {
                    echo "<td colspan='7' class='text-center font-semibold text-gray-900 dark:text-white'>No data found for this employee</td>";
                }
                    ?>


                </table>
<?php
            }
        } else {
            echo "No data found";
        }
    } else {
        echo "Error executing query: " . $con->error;
    }
} else {
    echo "No data received";
}
?>
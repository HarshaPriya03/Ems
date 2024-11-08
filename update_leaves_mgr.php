<?php
header('Content-Type: application/json');
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $mgrremark = $_POST['mgrremark'];
    $ID = $_POST['id'];
    $mgrtime = date('Y-m-d H:i:s');
    $updateQuery = "UPDATE leaves SET status='$status', mgrremark='$mgrremark', mgrtime='$mgrtime' WHERE id='$ID'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        // Check if status is '1' (approved) before updating leave balance
        if ($status == '1') {
            // Fetch details of the leave to get employee name, leave type, and leave duration
            $fetchLeaveDetailsQuery = "SELECT empname, leavetype, `from`, `to` FROM leaves WHERE id='$ID'";
            $leaveDetailsResult = mysqli_query($con, $fetchLeaveDetailsQuery);

            if ($leaveDetailsResult && mysqli_num_rows($leaveDetailsResult) > 0) {
                $leaveDetails = mysqli_fetch_assoc($leaveDetailsResult);
                $empName = $leaveDetails['empname'];
                $leaveType = $leaveDetails['leavetype'];
                $fromDate = $leaveDetails['from'];
                $toDate = $leaveDetails['to'];

                $fromDateObj = new DateTime($fromDate);
                $toDateObj = new DateTime($toDate);
                
                // Calculate the interval between dates
                $interval = new DateInterval('P1D'); // 1 day interval
                
                // Create a date range between $fromDateObj and $toDateObj
                $dateRange = new DatePeriod($fromDateObj, $interval, $toDateObj->modify('+1 day')); // Modify the end date to include the last day
                
                // Initialize $daysDiff
                $daysDiff = 0;
                
                // Iterate over each date in the range
                $fetchHolidaysQuery = "SELECT `date` FROM holiday";
                $holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
                $holidayDates = [];

                while ($row = mysqli_fetch_assoc($holidaysResult)) {
                    $holidayDates[] = $row['date'];
                }

                // Iterate over each date in the range
                foreach ($dateRange as $date) {
                    // Exclude Sundays and holidays
                    if ($date->format('w') != 0 && !in_array($date->format('Y-m-d'), $holidayDates)) {
                        $daysDiff++;
                    }
                }
                // Fetch leave balance for the employee
                $fetchLeaveBalanceQuery = "SELECT sl, cl, co, lastupdate FROM leavebalance WHERE empname='$empName'";
                $leaveBalanceResult = mysqli_query($con, $fetchLeaveBalanceQuery);

                if ($leaveBalanceResult && mysqli_num_rows($leaveBalanceResult) > 0) {
                    $leaveBalance = mysqli_fetch_assoc($leaveBalanceResult);
                    $currentSL = $leaveBalance['sl'];
                    $currentCL = $leaveBalance['cl'];
                    $currentCO = $leaveBalance['co'];
                    // Deduct leave balance based on the leave type and duration
                    switch ($leaveType) {
                        case 'SICK LEAVE':
                            $currentSL -= $daysDiff;
                            break;
                        case 'CASUAL LEAVE':
                            $currentCL -= $daysDiff;
                            break;
                        case 'COMP. OFF':
                            $currentCO -= $daysDiff;
                            break;
                        case 'HALF DAY':
                            $currentCL = number_format($currentCL, 1);
                            $currentCL -= 0.5;
                            break;        
                    }
                    $lastupdate = date('Y-m-d H:i:s');
                    // Update leave balance in the database
                    $updateLeaveBalanceQuery = "UPDATE leavebalance SET sl='$currentSL', cl='$currentCL', co='$currentCO', lastupdate='$lastupdate' WHERE empname='$empName'";
                    $leaveBalanceUpdateResult = mysqli_query($con, $updateLeaveBalanceQuery);

                    if ($leaveBalanceUpdateResult) {
                        $response = ['success' => true, 'message' => 'Leave Action updated successfully. Leave balance updated.'];
                        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                        exit; // Exit to avoid sending additional JSON response
                    } else {
                        $response = ['success' => false, 'message' => 'Error updating leave balance: ' . mysqli_error($con)];
                    }
                } else {
                    $response = ['success' => false, 'message' => 'No leave balance found for the specified employee.'];
                }
            } else {
                $response = ['success' => false, 'message' => 'Error fetching leave details: ' . mysqli_error($con)];
            }
        } else {
            $response = ['success' => true, 'message' => 'Leave Action updated successfully.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Error updating leave record: ' . mysqli_error($con)];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
}
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
ob_end_flush();
exit;

?>

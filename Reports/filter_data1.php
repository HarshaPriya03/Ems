<?php
// Include your database connection file
@include 'inc/config.php';

// Check if the connection to MySQL is successful
if (mysqli_connect_errno()) {
    echo json_encode(array('error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit();
}

// Initialize SQL query
$sql = "SELECT * FROM leaves WHERE 1";

// Check if empname filter is set
if (isset($_POST['empname']) && $_POST['empname'] !== '') {
    $empname = mysqli_real_escape_string($con, $_POST['empname']);
    $sql .= " AND empname LIKE '%$empname%'";
}

// Check if leavetype filter is set
if (isset($_POST['leavetype']) && $_POST['leavetype'] !== '') {
    $leavetype = mysqli_real_escape_string($con, $_POST['leavetype']);
    $sql .= " AND leavetype = '$leavetype'";
}


// Check if from date filter is set
if (isset($_POST['from']) && $_POST['from'] !== '') {
    $from = mysqli_real_escape_string($con, $_POST['from']);
    // Convert selected date format to match the format in the database
    $from = date('Y-m-d 00:00:00', strtotime($from));
    $sql .= " AND `from` >= '$from'";
}

// Check if to date filter is set
if (isset($_POST['to']) && $_POST['to'] !== '') {
    $to = mysqli_real_escape_string($con, $_POST['to']);
    // Convert selected date format to match the format in the database
    $to = date('Y-m-d 23:59:59', strtotime($to)); // Set to end of the day
    $sql .= " AND `to` <= '$to'";
}

$sql .= " ORDER BY applied ASC";
$cnt = 1;
$result = mysqli_query($con, $sql);

// Check if there are any results
if ($result) {
    // Fetch and output the filtered data
    while ($row = mysqli_fetch_assoc($result)) {
        // Start table row
        echo "<tr class=\"bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600\">";

        // Output S.No.
        echo "<td class=\"px-6 py-4\">" . $cnt++ . "</td>";

        // Output Employee Name
        echo "<td class=\"px-6 py-4\">" . $row['empname'] . "</td>";

        // Output Designation
        echo "<td class=\"px-6 py-4\">" . $row['desg'] . "</td>";

        // Output Leave Type
        echo "<td class=\"px-6 py-4\">" . $row['leavetype'] . "</td>";

        // Output Applied On
        echo "<td class=\"px-6 py-4\">";
        $status2 = isset($row['status2']) ? $row['status2'] : '';
        echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($row['applied']))) . "<br>";
        echo "<span style='font-size:16px; border-top:0.1px solid black; white-space:nowrap;'>";
        echo ($status2 == '1') ? 'Thru HR' : 'self';
        echo "</span></td>";

        // Output Leave From
        echo "<td class=\"px-6 py-4\">" . date('d-m-Y', strtotime($row['from'])) . "</td>";

        // Output Leave To
        echo "<td class=\"px-6 py-4\">" . date('d-m-Y', strtotime($row['to'])) . "</td>";

        // Output Leave Status
        echo "<td class=\"px-6 py-4\">";
        $status = $row['status'];
        $status1 = $row['status1'];
        if ($status == '2' && $status1 == '0') {
            echo 'Rejected';
        } elseif ($status == '2' && $status1 == '1') {
            echo 'Approver Rejected';
        } elseif (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
            echo 'Approved';
        } elseif ($status == '0' && $status1 == '0') {
            echo ' HR-Action Pending';
        } elseif ($status == '4' && $status1 == '0') {
            echo 'Pending at Manager';
        } elseif ($status == '3' && $status1 == '0') {
            echo 'Pending at Approver';
        }
        echo "</td>";

        // Output Leave Bal. Costed
        echo "<td class=\"px-6 py-4\">";
        if (
            (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
            strtotime($row['from']) >= strtotime('2024-02-01')
        ) {
            $fromDate = new DateTime($row['from']);
            $toDate = new DateTime($row['to']);
            if ($row['leavetype'] === "HALF DAY") {
                echo '0.5';
            } else {
                $toDate->modify('+1 day');

                $interval = new DateInterval('P1D');
                $dateRange = new DatePeriod($fromDate, $interval, $toDate);

                $fetchHolidaysQuery = "SELECT `date` FROM holiday";
                $holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
                $holidayDates = [];

                while ($holidayRow = mysqli_fetch_assoc($holidaysResult)) {
                    $holidayDates[] = $holidayRow['date'];
                }
                $excludedDays = 0;
                foreach ($dateRange as $date) {
                    if ($date->format('w') != 0 && !in_array($date->format('Y-m-d'), $holidayDates)) {
                        $excludedDays++;
                    }
                }
                $totalDays = $excludedDays;
                echo $totalDays;
            }
        } else {
            echo "";
        }
        echo "</td>";

        // End table row
        echo "</tr>";
    }
} else {
    // Handle error if query fails
    echo "Error executing query: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);

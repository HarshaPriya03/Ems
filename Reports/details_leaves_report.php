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
if (isset($_REQUEST['empname']) && $_REQUEST['empname'] !== '') {
    $empname = mysqli_real_escape_string($con, $_REQUEST['empname']);
    $sql .= " AND empname LIKE '%$empname%'";
}

// Check if leavetype filter is set
if (isset($_REQUEST['leavetype']) && $_REQUEST['leavetype'] !== '') {
    $leavetype = mysqli_real_escape_string($con, $_REQUEST['leavetype']);
    $sql .= " AND leavetype = '$leavetype'";
}

// Check if from date filter is set
if (isset($_REQUEST['from']) && $_REQUEST['from'] !== '') {
    $from = mysqli_real_escape_string($con, $_REQUEST['from']);
    // Convert selected date format to match the format in the database
    $from = date('Y-m-d 00:00:00', strtotime($from));
    $sql .= " AND `from` >= '$from'";
}

// Check if to date filter is set
if (isset($_REQUEST['to']) && $_REQUEST['to'] !== '') {
    $to = mysqli_real_escape_string($con, $_REQUEST['to']);
    // Convert selected date format to match the format in the database
    $to = date('Y-m-d 23:59:59', strtotime($to)); // Set to end of the day
    $sql .= " AND `to` <= '$to'";
}

$sql .= " ORDER BY applied ASC";
$result = mysqli_query($con, $sql);
$cnt = 1; // Initialize counter
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Pdf</title>
    <style>
        .report-no {
            position: absolute;
            right: 10;
            top: -15;
            height: 10px;
        }

        .wrapper {
            display: flex;
            justify-content: space-around !important;
        }

        .missing-wrapper {
            margin-top: -60px;
        }

        table {
            font-size: 20px !important;
            text-align: center;
        }


        tr td:nth-child(1),
        tr td:nth-child(2),
        tr td:nth-child(3),
        tr td:nth-child(8)  {
            background: #F6F6F6;
        }
        tr td:nth-child(5)  {
            background: #FFE6CA;
        }
        tr td:nth-child(9),
        tr td:nth-child(10) {
            background: #FFE6CA;
        }
        footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: -10;
    background-color: #f2f2f2;
    border-top: 1px solid #ccc; 
    padding: 0px;
    text-align: center; 
}


footer b{
    text-align:center !important;
    display: block; 
    /* font-family: monospace ; */
    font-size:15px;
}
.centered-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0.07; 
}
.centered-h1{
    position: absolute;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0.08; 
    font-size:100px;
}
    </style>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
$formattedDate = date("Y/m/d", strtotime($currentDateTime));
echo "<p style='font-family: monospace ;font-size:15px;'>Report generated on: $currentDateTime</p>";
?>

<div style='display:block;margin-left:auto;margin-right:auto;width:110px;'>
    <img alt='logo' src='https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121' width=100px height=80px>
</div><br>
<header style="text-align:center;color:black !important; ">
    <a class="header" href="" style="Font-size:30px;text-decoration:none !important;">Anika Sterilis Private Limited</a>

    <p style="text-align:center;">Anika ONE, AMTZ Campus,Pragati Maidan,VM Steel Project S.O,Visakhapatnam,Andhra Pradesh-530031</p>
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com | Website: www.anikasterilis.com</p>
</header>
<hr>

<body>
<div style="display: flex; justify-content: space-between;margin-bottom: 0;">
    <h4 style="text-align:center;border: 1px solid #ccc; flex: 1;width:29%;">
        The data presented in this report is sourced directly from the LMS Module of our HRMS
    </h4>
    <h3 style="text-align: center;">
        <u>Employee Leave's Report</u>
    </h3>
    <h4 style="text-align: right;">
        Report No: ASPL/HRMS/LMS/<?php echo  $formattedDate ?>
    </h4>
</div>

<!--    <div class="centered-image">-->
<!--    <img src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">-->
<!--</div>-->
<!--<div class="centered-h1">-->
<!--<h1>ASPL HRM</h1>-->
<!--</div>-->
<div class="table-container">
        <table border="1" style="border-color: rgb(170, 170, 170);width:100%;margin-top:-120px;" cellspacing="0">
          <thead>
          <tr style="background-color: #363062;color:white;">
              <th>
                S.No.
              </th>
              <th>
                Employee Name
              <th>
                Designation
              </th>
              <th>
                Leave Type
              </th>
              <th>
                Applied On
              </th>
              <th>
                Leave From
              </th>
              <th>
                Leave To
              </th>
              <th>
                Leave Status
              </th>
              <th>
                Leave Bal. Costed
              </th>
            </tr>
          </thead>
          <tbody> 
          <?php
          if ($result) {
             while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr style="background-color: 
    <?php 
        if ($row['leavetype'] == 'SICK LEAVE') {
            echo '#FFEC9E';
        } elseif ($row['leavetype'] == 'CASUAL LEAVE') {
            echo '#BFD8AF';
        } elseif ($row['leavetype'] == 'HALF DAY') {
            echo '#FFCF81'; 
        } else {
            echo '#F5EFE6';
        }
    ?>;">
              <td><?php echo $cnt++ ?></td>
              <td><?php echo $row['empname']; ?></td>
              <td><?php echo $row['desg']; ?></td>
              <td><?php echo $row['leavetype']; ?></td>
              <td><?php
                                    $status2 = isset($row['status2']) ? $row['status2'] : '';
                                    ?>
                <?php echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($row['applied']))); ?><BR>
                <span style='font-size:16px; border-top:0.1px solid black; white-space:nowrap;'>
                  <?php echo ($status2 == '1') ? 'Thru HR' : 'self'; ?>
                </span>
              </td>
              <td><?php echo date('d-m-Y', strtotime($row['from'])); ?> </td>
              <td><?php echo date('d-m-Y', strtotime($row['to'])); ?> </td>
              <td>
                <?php
                $status = $row['status'];
                $status1 = $row['status1'];
                ?>
                <?php
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
                ?>
              </td>
              <td>
                <?php
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
                } else
                  echo "";
                ?>
              </td>
            </tr>
           
          <?php
          }
        }
          ?>
           </tbody> 
        </table>
        </div>
        <footer>
    <b>
        This report is generated by the ASPL HRM System and is for informational purposes only. Any discrepancies or errors should be reported to the HR Department for review and correction or to the IT Department for any technical issues.
    </b><br>
    <b>
        Confidential: This report contains proprietary information and is intended for internal use only. Unauthorized distribution or disclosure is prohibited.
    </b>
</footer>
</div>
<script type="text/php">
                if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 14;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 15;
            $x = 1520;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
}
</script>
<script type="text/php">
    if (isset($pdf)) {
        // Set opacity for all pages
        $pdf->page_script('
            $font = $fontMetrics->get_font("times", "normal");
            $pdf->set_opacity(0.1); // Set opacity to 50%
            $pdf->text(570, 870, "ASPL HRM", $font, 100);
            $pdf->image("logo.jpg", 570, 870, 0, 0, "JPG", "", true, 150);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>
</body>

</html>

<?php
$empnameFilter = isset($_GET['empnameFilter']) ? $_GET['empnameFilter'] : '';
// Include your database connection file
@include '../inc/config.php';

// Check if the connection to MySQL is successful
if (mysqli_connect_errno()) {
    echo json_encode(array('error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit();
}

// Split the empnames by comma
$empnames = explode(',', $empnameFilter);

// Prepare an array to hold the SQL conditions for each empname
$sqlConditions = [];

// Loop through each empname and create the SQL condition
foreach ($empnames as $empname) {
    // Trim whitespace from the empname
    $empname = trim($empname);
    // Add the condition to the array
    $sqlConditions[] = "COALESCE(e.empname, p.empname) LIKE '%$empname%'";
}

// Join the conditions with OR to form the final WHERE clause
$whereClause = implode(' OR ', $sqlConditions);

// Construct the SQL query
$sql = "SELECT p.*, COALESCE(e.empname, p.empname) AS empname,e.empdoj,e.exit_dt
FROM payroll_msalarystruc p
LEFT JOIN emp e ON p.empname = e.empname
WHERE $whereClause ORDER BY emp_no ASC";

$result = mysqli_query($con, $sql);
$cnt = 1;
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
            /* margin-top: -120px; */
            /* padding: 1rem; */
        }

        .missing-wrapper {
            /* width: 50%; */
            margin-top: -60px;
        }

        table {
            font-size: 15px !important;
        }
        footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f2f2f2;
    border-top: 1px solid #ccc; 
    padding: 10px;
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
.center{
    text-align:center;
}
tr td:nth-child(2) {
            background: #C1EEBD;
        }
        tr td:nth-child(14) {
            background: #A1EEBD;
        }

        tr td:nth-child(15) {
            background: #B9FFBB;
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
    <h4 style="text-align:center;border: 1px solid #ccc; flex: 1;width:30%;">
        The data presented in this report is sourced directly from the Payroll Module of our HRMS
    </h4>
    <h3 style="text-align: center;">
        <u>Employees Gross Salary Report</u>
    </h3>
    <h4 style="text-align: right;">
        Report No: ASPL/HRMS/Payroll/<?php echo  $formattedDate ?>
    </h4>
</div>

<!--    <div class="centered-image">-->
<!--    <img src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">-->
<!--</div>-->
<!--<div class="centered-h1">-->
<!--<h1>ASPL HRM</h1>-->
<!--</div>-->
<table border=1 cellspacing="0" id="attendanceTable" style="margin-top:-100px;">
        <thead style="font-size:17px !important;">
            <tr style="background-color: #363062;color:white;">
                <th>
                    S.No.
                </th>
                <th>
                    Employee Name
                </th>
                <th>
                    Date of Joining
                </th>
                <th>
                    Designation
                </th>
                <th>
                    Service Length
                </th>
                <th>
                    Basic Pay
                </th>
                <th>
                    HRA
                </th>
                <th>
                    OA
                </th>
                <th>
                    EPF <br>(Employee Share 12%)
                </th>
                <th>
                    EPF <br>(Pension 8.33%)
                </th>
                <th>
                    EPF <br>(Employer Share 3.67%)
                </th>
                <th>
                    ESIC <br>(Employee Share 0.75%)
                </th>
                <th>
                    ESIC <br>(Employer Share 3.25%)
                </th>
                <th>
                    Net Payable
                </th>
                <th>
                    Gross Salary
                </th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?> <?php
                        $startDate = new DateTime($row['empdoj']);
                        $exitDate = new DateTime($row['exit_dt']);

                        $interval = $startDate->diff($exitDate);

                        $years = $interval->y;
                        $months = $interval->m;
                        $days = $interval->d;

            ?> <tr>
                <td class="center"><?php echo $cnt++; ?></td>
                <td><?php echo $row['empname']; ?></td>
                <td class="center"><?php echo !empty($row['empdoj']) ? $row['empdoj'] : 'N/A'; ?></td>
                <td><?php echo $row['desg']; ?></td>
                <td>
                    <?php
                        if ($years > 0) {
                            echo "$years year";
                          }
        
                          if ($months > 0) {
                            echo ($years > 0 ? ', ' : '') . "$months months";
                          }
        
                          if ($days > 0) {
                            echo ($years > 0 || $months > 0 ? ', ' : '') . "$days days";
                          }
                    ?>
                </td>
                <td><?php echo $row['bp']; ?></td>
                <td><?php echo $row['hra']; ?></td>
                <td><?php echo $row['oa']; ?></td>
                <td><?php echo $row['epf1']; ?></td>
                <td><?php echo $row['epf2']; ?></td>
                <td><?php echo $row['epf3']; ?></td>
                <td><?php echo $row['esi1']; ?></td>
                <td><?php echo $row['esi2']; ?></td>
                <td><?php echo $row['netpay']; ?></td>
                <td><?php echo $row['ctc']; ?></td>
                </tr>
        <?php
                    }
                }
        ?>
        </tbody>
    </table>
    <footer>
    <b>
        This report is generated by the ASPL HRM System and is for informational purposes only. Any discrepancies or errors should be reported to the HR Department for review and correction or to the IT Department for any technical issues.
    </b><br>
    <b>
        Confidential: This report contains proprietary information and is intended for internal use only. Unauthorized distribution or disclosure is prohibited.
    </b>
</footer>
<script type="text/php">
                if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT = 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 45;
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
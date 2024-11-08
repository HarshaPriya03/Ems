<?php
@include '../inc/config.php';
$empty = isset($_GET['empty']) ? $_GET['empty'] : null;
$work_location = isset($_GET['work_location']) ? $_GET['work_location'] : null;
$desg = isset($_GET['desg']) ? $_GET['desg'] : null;
$dept = isset($_GET['dept']) ? $_GET['dept'] : null;
$empstatus = isset($_GET['empstatus']) ? $_GET['empstatus'] : null;
$empname = isset($_GET['empname']) ? $_GET['empname'] : null;
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

        td {
            width: 144px;
        }

        thead th {
            padding: 7px 0 7px;

        }
        footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f2f2f2;
    border-top: 1px solid #ccc; 
    padding: 1px;
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
/* header {
  text-align: center;
  color: black !important;
  background: #F6F5F2;
  background-size: cover;
  padding: 20px 0;
} */
    </style>
</head>

<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
echo "<p style='font-family: monospace ;font-size:15px;'>Report generated on: $currentDateTime</p>";
$formattedDate = date("Y/m/d", strtotime($currentDateTime));
?>
<div style='display:block;margin-left:auto;margin-right:auto;width:110px;'>
    <img alt='logo' src='https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121' width=100px height=80px>
</div><br>
<header class="header" style="text-align:center;color:black !important; ">
    <a class="header" href="" style="Font-size:30px;text-decoration:none !important;">Anika Sterilis Private Limited</a>

    <p style="text-align:center;">Anika ONE, AMTZ Campus,Pragati Maidan,VM Steel Project S.O,Visakhapatnam,Andhra Pradesh-530031</p>
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com | Website: www.anikasterilis.com</p>
</header>
<hr>

<body>
<div>
<div style="display: flex; justify-content: space-between;margin-bottom: 0;">
    <h4 style="text-align:center;border: 1px solid #ccc; flex: 1;width:29%;">
        The data presented in this report is sourced directly from the EMS Module of our HRMS
    </h4>
    <h3 style="text-align: center;">
        <u>Employee Data Report</u>
    </h3>
    <h4 style="text-align: right;">
        Report No: ASPL/HRMS/EMS/<?php echo  $formattedDate ?>
    </h4>
</div>

<!--    <div class="centered-image">-->
<!--    <img src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">-->
<!--</div>-->
<!--<div class="centered-h1">-->
<!--<h1>ASPL HRM</h1>-->
<!--</div>-->

    <table border=1 cellspacing="0" id="attendanceTable" style="margin-left:-45px;margin-top:-100px;">
        <thead style="font-size:17px !important;">
            <tr style="background-color: #363062;color:white;">
                <th scope="col" class="px-6 py-3">S.No.</th>
                <th scope="col" class="px-6 py-3">Employee Name</th>
                <th scope="col" class="px-6 py-3">Date of Joining</th>
                <th scope="col" class="px-6 py-3">Employee ID</th>
                <th scope="col" class="px-6 py-3">Designation </th>
                <th scope="col" class="px-6 py-3">Department </th>
                 <th scope="col" class="px-6 py-3">Work Location </th>
                <th scope="col" class="px-6 py-3">Gender</th>
                <th scope="col" class="px-6 py-3">DOB</th>
                <th scope="col" class="px-6 py-3"> Mobile No.</th>
                <th scope="col" class="px-6 py-3"> Email</th>
                <th scope="col" class="px-6 py-3"> Aadhaar No.</th>
                <th scope="col" class="px-6 py-3"> PAN</th>
                <th scope="col" class="px-6 py-3"> Status</th>
                <th scope="col" class="px-6 py-3">Service Length</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            $sql = "SELECT * FROM emp";

            // Check if all four filters are empty
            if (empty($desg) && empty($dept) && $empstatus == null && empty($empname)) {
                // If all four filters are empty, run a different query to fetch all records
                $sql = "SELECT * FROM emp ORDER BY emp_no ASC";
            } {
                // Otherwise, apply the filters as usual
                $sql = "SELECT * FROM emp WHERE 1=1";
                if (!empty($empname)) {
                    $sql .= " AND empname LIKE '%$empname%'";
                }

                if (!empty($desg)) {
                    $desg_values = is_array($desg) ? $desg : explode(',', $desg);
                    $sql .= " AND desg IN ('" . implode("','", $desg_values) . "')";
                }
                if (!empty($dept)) {
                    $dept_values = is_array($dept) ? $dept : explode(',', $dept);
                    $sql .= " AND dept IN ('" . implode("','", $dept_values) . "')";
                }
                
 if (!empty($work_location)) {
                    $work_location_values = is_array($work_location) ? $work_location : explode(',', $work_location);
                    $sql .= " AND work_location IN ('" . implode("','", $work_location_values) . "')";
                }
                if (!empty($empty)) {
                    $empty_values = is_array($empty) ? $empty : explode(',', $empty);
                    $sql .= " AND empty IN ('" . implode("','", $empty_values) . "')";
                }
                
                if ($empstatus !== null) {
                    $empstatus_values = is_array($empstatus) ? $empstatus : explode(',', $empstatus);
                    $sql .= " AND empstatus IN ('" . implode("','", $empstatus_values) . "')";
                }
            }
            $sql .= " ORDER BY emp_no ASC";
            $que = mysqli_query($con, $sql);
            $cnt = 1;

            while ($result = mysqli_fetch_assoc($que)) {
            ?>
                <?php
                $startDate = new DateTime($result['empdoj']);
                $exitDate = new DateTime($result['exit_dt']);

                $interval = $startDate->diff($exitDate);

                $years = $interval->y;
                $months = $interval->m;
                $days = $interval->d;
                ?>
                <tr style="text-align:center;
            <?php
                if ($result['empstatus'] == '0') {
                    echo 'background-color: #CDFADB;';
                } elseif ($result['empstatus'] == '1') {
                    echo 'background-color: #FF8080;';
                } elseif ($result['empstatus'] == '2') {
                    echo 'background-color: #F2C18D;';
                } ?>">
                    <td style="width:30px;"><?php echo $cnt; ?></td>
                    <td style="width:260px;"><?php echo $result['empname']; ?></td>
                    <td style="width:100px;"><?php echo $result['empdoj']; ?></td>
                    <td><?php echo $result['emp_no']; ?></td>
                    <td style="width:230px;"><?php echo $result['desg']; ?> <br>
                   <b> <?php echo $result['empty']; ?></b>
                </td>
                    <td style="width:200px;"><?php echo $result['dept']; ?></td>
                       <td style="width:100px;"><?php echo $result['work_location']; ?></td>
                    <td style="width:55px;"><?php echo $result['empgen']; ?></td>
                    <td style="width:95px;"><?php echo $result['empdob']; ?></td>
                    <td style="width:100px;"><?php echo $result['empph']; ?></td>
                    <td><?php echo $result['empemail']; ?></td>
                    <td><?php echo $result['adn']; ?></td>
                    <td><?php echo $result['pan']; ?></td>
                    <td>
                        <?php
                        if ($result['empstatus'] == '0') {
                            echo 'Active';
                        } elseif ($result['empstatus'] == '1') {
                            echo '<span>Terminated<br>' . $exitDate->format('Y-m-d') . '</span>';
                        } elseif ($result['empstatus'] == '2') {
                            echo '<span>Resigned<br>' . $exitDate->format('Y-m-d') . '</span>';
                        }
                        ?>
                    </td>

                    <td style="width:200px;">
                        <?php if ($years > 0) {
                            echo "$years year";
                        }

                        if ($months > 0) {
                            echo ($years > 0 ? ', ' : '') . "$months months";
                        }

                        if ($days > 0 || ($years == 0 && $months == 0)) {
                            echo ($years > 0 || $months > 0 ? ', ' : '') . "$days days";
                        } ?>

                    </td>
                </tr>
            <?php
                $cnt++;
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
</div>
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
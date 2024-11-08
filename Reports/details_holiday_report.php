<?php
@include '../inc/config.php';
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
            text-align: center;
        }
        td{
            padding:5px;
        }
        footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -30;
            background-color: #f2f2f2;
            border-top: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        footer b {
            text-align: center !important;
            display: block;
            font-size: 10px;
        }

        .centered-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.07;

        }

        .centered-h1 {
            position: absolute;
            top: 65%;
            left: 49%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            font-size: 30px;
        }
        .green-background {
    background-color: #C1F2B0;
}

    </style>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
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
            <u>List of Holiday's</u>
        </h3>
    </div>

    <div class="centered-image">
        <img width=300px src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">
    </div>
    <div class="centered-h1">
        <h1>ASPL HRM</h1>
    </div>

    <table border="1" cellspacing="0" id="attendanceTable" style="margin-left:130px;margin-top:-75px;">
    <thead>
        <tr style="background-color: #363062;color:white;">
            <th>S.No.</th>
            <th>Name of Occasion/Festival</th>
            <th>Date</th>
            <th>Month</th>
            <th>Day</th>
            <th>Work Location</th>
        </tr>
    </thead>
    <tbody id="tableBody">
    <?php
$sql = "SELECT date, value FROM holiday 
        UNION 
        SELECT date, value FROM holiday_ggm 
        ORDER BY date ASC";
$que = mysqli_query($con, $sql);
$cnt = 1;
$currentDate = date('Y-m-d');

while ($result = mysqli_fetch_assoc($que)) {
    $date = date('d-m-Y', strtotime($result['date']));
    $month = date('M', strtotime($result['date']));
    $day = date('l', strtotime($result['date']));

    // Check if the date is in the past
    $rowClass = (strtotime($result['date']) < strtotime($currentDate)) ? 'class="green-background"' : '';

    // Determine the location
    $visakhapatnam_check = mysqli_query($con, "SELECT 1 FROM holiday WHERE date = '" . $result['date'] . "' AND value = '" . $result['value'] . "'");
    $gurugram_check = mysqli_query($con, "SELECT 1 FROM holiday_ggm WHERE date = '" . $result['date'] . "' AND value = '" . $result['value'] . "'");
    if (mysqli_num_rows($visakhapatnam_check) > 0 && mysqli_num_rows($gurugram_check) > 0) {
        $location = 'Both';
    } elseif (mysqli_num_rows($visakhapatnam_check) > 0) {
        $location = 'Visakhapatnam';
    } elseif (mysqli_num_rows($gurugram_check) > 0) {
        $location = 'Gurugram';
    } else {
        $location = 'Unknown';
    }

    // Output table row
    echo "<tr $rowClass>";
    echo "<td>$cnt</td>";
    echo "<td>{$result['value']}</td>";
    echo "<td>$date</td>";
    echo "<td>$month</td>";
    echo "<td>$day</td>";
    echo "<td>$location</td>";
    echo "</tr>";

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
    <script type="text/php">
                if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT = 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 45;
            $x = 500;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
}
</script>
</body>

</html>
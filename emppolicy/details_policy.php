<?php
@include 'inc/config.php';

$policy_title = isset($_GET['policy_title']) ? $_GET['policy_title'] : '';
$policyno = isset($_GET['policyno']) ? $_GET['policyno'] : '';
$version = isset($_GET['version']) ? $_GET['version'] : '';
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

        .red-background {
            background-color: #F7A4A4;
        }

        th,
        td {
            border: 1px solid #000;
            text-align: left;
        }

        .half-width {
            width: 50%;
        }

        .captioncss{
            text-align: left;
            font-size:20px;
            font-weight: bold;
        }
        @page { margin: 0px; }
body { margin: 30px; }

footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #f2f2f2;
            border-top: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        footer b {
            text-align: center !important;
            display: block;
            font-size: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

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
    <?php
    $sql = "SELECT * FROM policies_policy WHERE (policy_title = ? AND policyno = ?) OR (policy_title = '$policy_title' AND version = ?) ";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sss', $policy_title, $policyno, $version);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $policy_content = $row['policy_content'];

    ?>
    <br>
   

    <div style="font-family:monospace;">
    <caption class="captioncss">Policy Details:</caption>
    <table width="100%" border="1" style="border-collapse: collapse;">

        <tr>
            <td style="background:#F5F7F8;width:20%;padding:5px;">Policy Title</td>
            <td style="padding:5px;font-weight:bold;"><?php echo $policy_title ?></td>
            <td style="background:#F5F7F8;width:20%;padding:5px;">Policy No.</td>
            <td style="padding:5px;font-weight:bold;"><?php echo $row['policyno']; ?></td>
        </tr>
        <tr>
            <td style="background:#F5F7F8;width:20%;padding:5px;">Policy Category</td>
            <td style="padding:5px;font-weight:bold;"><?php echo $row['policyno']; ?></td>
            <td style="background:#F5F7F8;width:20%;padding:5px;">Version</td>
            <td style="padding:5px;font-weight:bold;"><?php echo $row['version']; ?></td>
        </tr>
        
        <tr>
            <td style="background:#F5F7F8;width:20%;padding:5px;">Effective From</td>
            <td style="padding:5px;font-weight:bold;"> <?php
                    $originalDate = $row['time'];
                    $dateTime = new DateTime($originalDate);
                    $formattedDate = $dateTime->format('F j, Y');

                    echo $formattedDate;
                    ?>
            </td>
            <td style="background:#F5F7F8;width:20%;padding:5px;">Approval Authority</td>
            <td style="padding:5px;font-weight:bold;"><?php echo $row['apr_name']; ?></td>
        </tr>

    </table>
    </div>
<br><br>
<div style="outline:1px solid black;padding:10px;">
    <div style="text-align:justify;"><?php echo $policy_content ?></div>
    </div>
    <footer>
        <b>
        Confidential: This policy contains proprietary information and is intended for internal use only. Unauthorized distribution or disclosure is prohibited.
        </b><br>
        <b>
        This policy has been generated by the ASPL HRM System. It is for informational purposes only and should be adhered to by respective employees. Any discrepancies or errors should be reported to the HR Department for review and correction. For any technical issues, please contact the IT Department.
        </b>
    </footer>
    
    <script type="text/php">
        if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 10;
            $x = 510;
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
            $pdf->text(200, 480, "ASPL HRM", $font, 40);
            $pdf->image("logo.jpg", 200, 300, 200, 180, "JPG", "", true, 5);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>
</body>

</html>
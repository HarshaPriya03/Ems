<?php
@include 'inc/config.php';

$voucherno = isset($_GET['voucherno']) ? $_GET['voucherno'] : '';
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

        td {
            padding-top: 10px;
            padding-bottom: 20px;
            padding-left: 30px;
            padding-right: 40px;
        }

        .half-width {
            width: 50%;
        }

        .captioncss {
            text-align: left;
            font-size: 20px;
            font-weight: bold;
        }

        @page {
            margin: 0px;
        }

        body {
            margin: 30px;
        }

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

        .eemage{
    z-index: -100;
    position: absolute;
    margin-top:-10px;
    left: 30%;
    filter: contrast(5%) !important;
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
    $sql = "SELECT * FROM travel_voucher WHERE voucherno = ? ";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $voucherno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();


    ?>
    <br>


    <div style="font-family:monospace;">
    <h3 style="text-align: center;"><u>Travel Voucher Details</u></h3>
        <table width="100%" border="1" style="border-collapse: collapse;">

            <tr>
                <td style="background:#F5F7F8;width:20%;padding:5px;">Employee Name</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['empname']; ?></td>
                <td style="background:#F5F7F8;width:20%;padding:5px;">Transaction Number</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['transno']; ?></td>
            </tr>
            <tr>
                <td style="background:#F5F7F8;width:20%;padding:5px;">From city</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['from_city']; ?></td>
                <td style="background:#F5F7F8;width:20%;padding:5px;">To city</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['to_city']; ?></td>
            </tr>

            <tr>
                <td style="background:#F5F7F8;width:20%;padding:5px;">BOARDING</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['boarding_date']; ?> </td>
                <td style="background:#F5F7F8;width:20%;padding:5px;">DEPARTURE</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['departure_date']; ?></td>
            </tr>
            
            <tr>
                <td style="background:#F5F7F8;width:20%;padding:5px;">Duration</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['duration']; ?>   </td>
                <td style="background:#F5F7F8;width:20%;padding:5px;">Mode</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['mode']; ?></td>
            </tr>
            
            <tr>
                <td style="background:#F5F7F8;width:20%;padding:5px;">Ticket Cost</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['cost']; ?>   </td>
                <td style="background:#F5F7F8;width:20%;padding:5px;">Policy Applicable</td>
                <td style="padding:5px;font-weight:bold;"><?php echo $row['policies_policy']; ?></td>
            </tr>
            <tr>
              <td style="background:#F5F7F8;width:20%;padding:5px;" ><b>Approved By</b> &nbsp;</td>
            <td style="padding:5px;margin-bottom:20px !important;" colspan="3">
           <?php if ($row['status'] == 1) { ?>
                                    <div class="emage"><img class="eemage" src='https://ik.imagekit.io/akkldfjrf/markk.jpg?updatedAt=1694413905121' height=50px alt=""><p>Digitally Approved By <b><?php echo $row['apr_name'] ?></b><br>Date: <?php echo date('Y-m-d H:i:s',strtotime('+12 hours +30 minutes',strtotime($row['apr_time']))); ?> IST</p></div>
                                 </td>
           <?php } elseif ( $row['status'] == 2)  { 
            echo "{Voucher Rejected}";
            ?>
            <?php } elseif ( $row['status'] == 0)  { 
            echo "{Pending for Approval}";
            ?>
                                 <?php }
                                 
                                 else  echo "";?> 
            </tr>

            <tr>
                <td style="background:#F5F7F8;width:20%;padding:5px;"><b>Ticket</b> &nbsp;</td>
                <td style="padding:5px;font-weight:bold;" colspan="3">
                    <img src="https://policymaker.anikasterilis.com/Voucher/ticket/<?php echo $row['ticket'] ?>" style="width:20px;height:20px;">
                </td>
            </tr>
        </table>


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
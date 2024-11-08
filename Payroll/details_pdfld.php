<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}


@include '../inc/config.php';

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM payroll_loan WHERE empname = ?";


    $query = $con->prepare($sql);
    $empname = $_GET['empname'];
    $query->bind_param('s', $empname);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $disbursed = $row['disbursed'];
            $disbursedText = ($disbursed == "1") ? "Loan Disbursed" : "Pending Loan Disbursal";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Details Pdf</title>
  <style>
.vl {
  border-left: 2px solid rgb(170, 170, 170);
  height: 535px;
  position: absolute;
  left: 20%;
  margin-left: -3px;
  top: 32.6%;
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
</style>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
echo "<p style='font-family: monospace ;font-size:15px;'>Loan Report generated on: $currentDateTime</p>";
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
  <h3 style="text-align: center;"><u>Loan Summary</u></h3>
  <div class="centered-image">
        <img width=300px src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">
    </div>
    <div class="centered-h1">
        <h1>ASPL HRM</h1>
    </div>

<div>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Name</span> <span style="margin-left: 120px;"><?php echo $row['empname']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan Number</span> <span style="margin-left: 60px;"><?php echo $row['loanno']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan Amount</span> <span style="margin-left: 60px;">Rs. <?php echo $row['loamt']; ?>/-</span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Tenure</span> <span style="margin-left: 110px;"><?php echo $row['loterm']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Mode of Transfer</span><span style="margin-left: 40px;"><?php echo $row['mop']; ?></span>
                </p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Transfer Date</span> <span style="margin-left: 60px;"><?php echo $row['pdate']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Transaction No</span><span style="margin-left: 50px;"><?php echo $row['tno']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Tenure Start Date</span><span id="datepicker" style="margin-left: 33px;"><?php echo $row['stmonth']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Disbursal Status</span><span style="margin-left: 45px;"><?php echo $disbursedText; ?></span>
                    <hr>
                    <div class="vl"></div>
                    <?php if ($row['disbursed'] == "1") : ?>

                       
                <h1 style="font-size: 25px; font-weight: 700;">Transaction History</h1>
                <table border="1" style="border-color: rgb(170, 170, 170);width:100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Transaction
                                </th>
                                <th>
                                    Description
                                </th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">

                            <tr>
                                <td><?php echo $row['pdate']; ?></td>
                                <td>Loan disbursed</td>
                                <td><?php echo $row['notes']; ?></td>
                            </tr>
                            <?php
                            $sql_emi = "SELECT * FROM payroll_emi WHERE empname = ?";
                            $query_emi = $con->prepare($sql_emi);
                            $query_emi->bind_param('s', $row['empname']); 
                            $query_emi->execute();
                            $result_emi = $query_emi->get_result();

                            if ($result_emi->num_rows > 0) {
                                while ($row_emi = $result_emi->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $row_emi['created']; ?></td>
                                        <td>EMI deducted</td>
                                        <td>EMI:Rs.<?php echo $row_emi['emi']; ?>/- Month:<?php echo $row_emi['emimonth']; ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
            <?php endif; ?>
            </div>
            </footer>
<script type="text/php">
                if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 15;
            $x = 500;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
}
</script>
</body>

</html>
<?php
        }
    } else {
        echo "No data found";
    }
?>
<?php
@include 'inc/config.php';
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
if (isset($_GET['empname'])) {
    $empname = $_GET['empname'];

    $sql_vsp = "SELECT empname FROM payroll_ss_vsp WHERE empname = '$empname' AND salarymonth = '$smonth'";
    $result_vsp = mysqli_query($con, $sql_vsp);
    
    if (mysqli_num_rows($result_vsp) > 0) {
        $query = "
            SELECT 
                emp.empname,
                emp.empdoj,
                payroll_ban.*,
                payroll_ss_vsp.emp_no,
                payroll_ss_vsp.desg,
                payroll_ss_vsp.dept,
                payroll_ss_vsp.salarymonth,
                payroll_ss_vsp.*  -- Select all columns from payroll_ss_vsp
            FROM 
                emp
            LEFT JOIN 
                payroll_ban ON emp.empname = payroll_ban.empname
            LEFT JOIN 
                payroll_ss_vsp ON emp.empname = payroll_ss_vsp.empname AND payroll_ss_vsp.salarymonth = '$smonth'
            WHERE 
                emp.empname = '$empname'
            LIMIT 1";  // Limit to 1 row as empname should be unique
    } else {
        // Check if empname exists in payroll_ss_ggm
        $sql_ggm = "SELECT empname FROM payroll_ss_ggm WHERE empname = '$empname' AND salarymonth = '$smonth'";
        $result_ggm = mysqli_query($con, $sql_ggm);
    
        if (mysqli_num_rows($result_ggm) > 0) {
            $query = "
                SELECT 
                    emp.empname,
                    emp.empdoj,
                    payroll_ban.*,
                    payroll_ss_ggm.emp_no,
                    payroll_ss_ggm.desg,
                    payroll_ss_ggm.dept,
                    payroll_ss_ggm.salarymonth,
                    payroll_ss_ggm.*  -- Select all columns from payroll_ss_ggm
                FROM 
                    emp
                LEFT JOIN 
                    payroll_ban ON emp.empname = payroll_ban.empname
                LEFT JOIN 
                    payroll_ss_ggm ON emp.empname = payroll_ss_ggm.empname AND payroll_ss_ggm.salarymonth = '$smonth'
                WHERE 
                    emp.empname = '$empname'
                LIMIT 1";  // Limit to 1 row as empname should be unique
        } else {
            // Check if empname exists in payroll_ss_sp
            $sql_sp = "SELECT empname FROM payroll_ss_sp WHERE empname = '$empname' AND salarymonth = '$smonth'";
            $result_sp = mysqli_query($con, $sql_sp);
    
            if (mysqli_num_rows($result_sp) > 0) {
                $query = "
                    SELECT 
                        emp.empname,
                        emp.empdoj,
                        payroll_ban.*,
                        payroll_ss_sp.emp_no,
                        payroll_ss_sp.desg,
                        payroll_ss_sp.dept,
                        payroll_ss_sp.salarymonth,
                        payroll_ss_sp.*  -- Select all columns from payroll_ss_sp
                    FROM 
                        emp
                    LEFT JOIN 
                        payroll_ban ON emp.empname = payroll_ban.empname
                    LEFT JOIN 
                        payroll_ss_sp ON emp.empname = payroll_ss_sp.empname AND payroll_ss_sp.salarymonth = '$smonth'
                    WHERE 
                        emp.empname = '$empname'
                    LIMIT 1";  // Limit to 1 row as empname should be unique
            } else {
                // empname does not exist in any of the tables
                echo json_encode(['error' => 'No data found']);
                exit;
            }
        }
    }
    $result = mysqli_query($con, $query);

    // Check if any rows were returned
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the data from the result set
        $row = mysqli_fetch_assoc($result);
        $empname = $row['empname'];
        $empno = $row['emp_no'];
        $desg = $row['desg'];
        $doj = $row['empdoj'];
        $bp = $row['fbp'];
        $hra = $row['fhra'];
        $oa = $row['foa'];
        $epf1 = $row['epf1'];
        $esi1 = $row['esi1'];
        $emi = $row['emi'];
         $tds = $row['tds'];
        $bonus = $row['bonus'];
        $misc = $row['misc'];
        $lop = $row['lopamt'];
        $payout = $row['payout'];
        $gross = $row['fgs'];
        $totaldeduct = $row['totaldeduct'];
        $present = $row['present'];
        $sundays = $row['sundays'];
        $holidays = $row['holidays'];
        $flop = $row['flop'];
        $paydays = $row['paydays'];
        $leaves = $row['leaves'];
        $monthdays = $row['monthdays'];
    } else {
        $empname = "Employee Not Found";
    }
} else {
    $empname = "Employee Not Specified";
}


$payout_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $payout);
$gross_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $gross);
$bp_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $bp);
$hra_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $hra);
$oa_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $oa);
$epf1_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $epf1);
$esi1_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $esi1);
$emi_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $emi);
$tds_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tds);
$misc_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $misc);
$lop_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $lop);
$bonus_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $bonus);
$deductions_formatted = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $totaldeduct);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap');

        .rupee {
            font-family: 'Noto Sans', sans-serif;
        }

        @page {
            margin: 0in;
            position: fixed;
            inset: -1in;
        }
    </style>
</head>
<?php
function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}
$amount = $payout;
$inWords = getIndianCurrency($amount);

?>

<body style="margin:0;">
    <div style="background-color: #f9f9f9; height:100svh;">
        <img src='https://ik.imagekit.io/xrwtssnxo/logo.jpg?updatedAt=1709032970434' style="position: absolute; left: 14%; top: 25%; opacity: 0.1;">
        <div>
            <img alt='logo' src='https://ik.imagekit.io/xrwtssnxo/ASPL2.jpg?updatedAt=1712297943086' style="position: absolute; right: 30px; top: 30px; width: 90px;">
            <p style="position: absolute; font-size: 22px; font-weight: 600; left: 30px; top:20; color: rgb(61, 61, 61);">ANIKA STERILIS PRIVATE LIMITED</p>
            <p style="position: absolute; font-size: 14px; font-weight: 500; left: 30px; top: 70px; color: rgb(104, 104, 104);">AMTZ Campus, VM Steel Project S.O, Visakhapatnam, Andhra Pradesh - 530031</p>
            <hr style="width: 91%; border: 1px solid #d8d8d8; position: absolute; top: 110px; left: 30px;">
            <p style="position: absolute; left: 30px; font-size: 18px; font-weight: 600; top: 120px; color: rgb(61, 61, 61);">Payslip for the month of <?php echo $smonth; ?></p>
            <p style="position: absolute; left: 30px; font-size: 20px; font-weight: 600; top: 163px; color: rgb(61, 61, 61);"><?php echo $empname; ?><br></p>
            <p style="position: absolute; left: 30px; font-size: 14px; top: 200px; color: #666666;">
                Designation <span style="position:relative;left:30px;">: <?php echo $desg; ?></span> <br>Employee ID <span style="position:absolute;left:100px;">:&nbsp;<?php echo ($empno == null || $empno == 0) ? 'N/A' : $empno; ?> </span><br>D-O-J <span style="position:absolute;left:100px;white-space:nowrap;">: <?php echo $doj; ?></span></p>
            <p style="position: absolute; right: 30px; font-size: 18px; top: 125px; color: rgb(61, 61, 61);">Employee Net Pay</p>
            <p style="position: absolute; right: 30px; font-size: 35px;top: 120px; color: rgb(61, 61, 61);"><span class="rupee">₹</span> <b><?php echo $payout; ?></b></p>
            <p style="position: absolute; right: 70px; font-size: 14px; top: 200px; color: #666666;">
                Present Days<span style="position:relative;left:0px;"> : <?php echo $present; ?></span> | Leaves : <?php echo $leaves; ?> <br>Week Off's <span style="position:absolute;left:77px;">: <?php echo $sundays; ?> </span><span style="position:absolute;left:95px;white-space:nowrap;">| Holidays : <?php echo $holidays; ?> </span> <br> Paid Days <span style="position:absolute;left:77px;">: <?php echo $paydays; ?> </span><?php if ($flop != 0) : ?><span style="position:absolute;left:113px;width:120%;"> | Loss of Pay : <?php echo $flop; ?></span><?php endif; ?></p>
            <hr style="width: 91%; border: 1.5px dashed #d8d8d8; position: absolute; top: 265px; left: 30px;">
            <p style="position: absolute; left: 30px; top: 280px; color: #666666;">UAN Number</p>
            <p style="position: absolute; left: 190px; top: 280px; color: #000000;">: <?php echo ($row['uan'] == null || $row['uan'] == 0) ? 'N/A' : $row['uan']; ?></p>
            <p style="position: absolute; right: 220px; top: 280px; color: #666666;">ESI Number</p>
            <p style="position: absolute; left: 628px; top: 280px; color: #000000;">: <?php echo ($row['esin'] == null || $row['esin'] == 0) ? 'N/A' : $row['esin']; ?></p>
            <p style="position: absolute; left: 30px; top: 330px; color: #666666;">Bank A/C Number</p>
            <p style="position: absolute; left: 190px; top: 330px; color: #000000;">: <?php echo $row['sban']; ?></p>
            <p style="position: absolute; right: 228px; top: 330px; color: #666666;">IFSC Code</p>
            <p style="position: absolute; left: 628px; top: 330px; color: #000000;">: <?php echo $row['sifsc']; ?></p>
            <hr style="width: 91%; border: 1px solid #d8d8d8; position: absolute; top: 390px; left: 30px;">
            <p style="position: absolute; left: 50px; font-weight: 600; font-size: 15px; top: 410px; color: rgb(109, 33, 33);">EARNINGS</p>
            <p style="position: absolute; left: 230px; font-weight: 600; font-size: 15px; top: 410px; color: rgb(109, 33, 33);">AMOUNT</p>
            <p style="position: absolute; right: 220px; font-weight: 600; font-size: 15px; top: 410px; color: rgb(109, 33, 33);">DEDUCTIONS</p>
            <p style="position: absolute; right: 80px; font-weight: 600; font-size: 15px; top: 410px; color: rgb(109, 33, 33);">AMOUNT</p>
            <hr style="width: 44%; border: 1px solid #d8d8d8; position: absolute; top: 460px; left: 30px;">
            <hr style="width: 47%; border: 1px solid #d8d8d8; position: absolute; top: 460px; right: 30px;">
            <p style="position: absolute; left: 50px; font-size: 17px; top: 470px;">Basic Pay</p>
            <p style="position: absolute; left: 230px; font-size: 17px; top: 460px;"><span class="rupee">₹</span> <?php echo $bp_formatted; ?></p>
            <?php if ($hra_formatted != 0) : ?>
                <p style="position: absolute; left: 50px; font-size: 17px; top: 520px;">House Rent Allowance</p>
                <p style="position: absolute; left: 230px; font-size: 17px; top: 510px;"><span class="rupee">₹</span> <?php echo $hra_formatted; ?></p>
            <?php endif; ?>
            <?php if ($oa_formatted != 0) : ?>
                <p style="position: absolute; left: 50px; font-size: 17px; top: 570px;">Other Allowance</p>
                <p style="position: absolute; left: 230px; font-size: 17px; top: 560px;"><span class="rupee">₹</span> <?php echo $oa_formatted; ?></p>
            <?php endif; ?>
            <?php if ($bonus_formatted != 0) : ?>
                <p style="position: absolute; left: 50px; font-size: 17px; top: 620px;">Bonus</p>
                <p style="position: absolute; left: 230px; font-size: 17px; top: 610px;"><span class="rupee">₹</span> <?php echo $bonus_formatted; ?></p>
            <?php endif; ?>
            <p style="position: absolute; right: 220px; font-size: 17px; top: 470px;">Provident Fund</p>
            <p style="position: absolute; right: 80px; font-size: 17px; top: 460px;"><span class="rupee">₹</span> <?php echo $epf1_formatted; ?></p>
            <p style="position: absolute; right: 140px; font-size: 17px; top: 520px;">Employee's State Insurance</p>
            <p style="position: absolute; right: 80px; font-size: 17px; top: 510px;"><span class="rupee">₹</span> <?php echo $esi1_formatted; ?></p>

            <p style="position: absolute; right: 230px; font-size: 17px; top: 570px;">Miscellaneous</p>
            <p style="position: absolute; right: 80px; font-size: 17px; top: 560px;"><span class="rupee">₹</span> <?php echo $misc_formatted; ?></p>

            <p style="position: absolute; right: 252px; font-size: 17px; top: 615px;">Loan EMI </p>
            <p style="position: absolute; right: 80px; font-size: 17px; top: 605px;"><span class="rupee">₹</span> <?php echo $emi_formatted; ?></p>

        <p style="position: absolute; right: 288px; font-size: 17px; top: 645px;">TDS </p>
            <p style="position: absolute; right: 80px; font-size: 17px; top: 635px;"><span class="rupee">₹</span> <?php echo $tds_formatted; ?></p>
            
            <?php if ($lop_formatted != 0) : ?>
                <p style="position: absolute; right: 294px; font-size: 17px; top: 650px;">LOP</p>
                <p style="position: absolute; right: 80px; font-size: 17px; top: 640px;"><span class="rupee">₹</span> <?php echo $lop_formatted; ?></p>
            <?php endif; ?>
            <hr style="width: 44%; border: 1px solid #d8d8d8; position: absolute; top: 680px; left: 30px;">
            <hr style="width: 47%; border: 1px solid #d8d8d8; position: absolute; top: 680px; right: 30px;">
            <p style="position: absolute; left: 50px; font-size: 17px; top: 690px; font-weight: 600; color: rgb(109, 33, 33);">GROSS EARNINGS</p>
            <p style="position: absolute; left: 230px; font-size: 17px; top: 680px;color: rgb(109, 33, 33);"><span class="rupee">₹</span> <b><?php echo $gross_formatted; ?></b></p>
            <p style="position: absolute; right: 220px; font-size: 17px; top: 690px; font-weight: 600; color: rgb(109, 33, 33);">DEDUCTIONS</p>
            <p style="position: absolute; right: 80px; font-size: 17px; top: 680px;  color: rgb(109, 33, 33);"><span class="rupee">₹</span> <b><?php echo $deductions_formatted; ?></b></p>
            <div style="background:#f1f1f1;height: 90px;margin: 0 auto;outline:1px solid #d8d8d8;">
                <p style="text-align: center; font-size: 20px; margin-top: 800px; ">Total Net Payable <span class="rupee">₹</span><b><?php echo $payout_formatted; ?></b> <span style="font-size: 14px;text-transform: capitalize;">( <?php echo $inWords; ?> only )</span> </p>
                <p style="text-align: center; font-size: 17px; color:#777777;">**Total Net Payable = (Gross Earnings - Deductions)</p>
            </div>
            <p style="text-align: center; font-size: 13px; margin-top: 90px; padding-bottom:65px; color: #666666;">
                -- This document has been automatically generated by ASPL Payroll; therefore, a signature is not required. --
            </p>
        </div>
    </div>



</body>

</html>
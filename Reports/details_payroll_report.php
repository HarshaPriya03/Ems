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
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com</p>
</header>
<hr>

<body>
    <h3 style="text-align: center;"><u>EMI Report</u></h3>

    <table border="1" cellspacing="0" id="attendanceTable">
        <thead>
            <tr>
            <th >
                                 S.No.
                             </th>
                             <th >
                                 Employee Name   </th>
                             <th >
                                 EMI Month  </th>
                             <th >
                              EMI
                          </th>
                             <th >
                                Loan Number
                             </th><th >
                                 Deduction Date
                             </th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
         $sql = "SELECT * FROM payroll_emi  
         ORDER BY STR_TO_DATE(emimonth, '%M %Y') DESC";
            $que = mysqli_query($con, $sql);
            $cnt = 1;
            while ($result = mysqli_fetch_assoc($que)) {
            ?>
                <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $result['empname']; ?></td>
                <td><?php echo $result['emimonth']; ?></td>
                <td><?php echo $result['emi']; ?></td>
                <td><?php echo $result['loanno']; ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($result['created']))); ?></td>
                </tr>
            <?php
                $cnt++;
            }
            ?>
        </tbody>
    </table>

</body>

</html>
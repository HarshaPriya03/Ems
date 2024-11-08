<?php
@include 'inc/config.php';
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ICICI-NEFT-<?php echo $smonth ?> </title>
  <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  border-color:black;
  white-space:nowrap;
  text-align:center;
}
th, td {
  padding: 18px;
}
</style>
</head>

<body>
<table border="1" cellspacing="0" align="center" >
      <thead style="font-style:italics;font-family: Arial, Helvetica, sans-serif;">
        <tr>
          <th >
            S No.
          </th>
          <th >
            Tran Reference <br>number
          </th>
          <th >
            Amount
          </th>
          <th style="white-space:nowrap;">
            Sender A/C type<br>(Debit A/C type)
          </th>
          <th >
            Sender A/C No<br>(Debit A/C number)
          </th>
          <th style="white-space:nowrap;">
            Sender Name<br>(Debit A/C type)
          </th>
          <th >
            SMS/EMAIL
          </th>
          <th >
           EMAIL Details
          </th>
          <th>
          OoR7002 (Debit A/C name)
          </th>
          <th >
            Beneficiary IFSC
          </th>
          <th >
            Beneficiary A/C type
          </th>
          <th >
            Beneficiary A/C number
          </th>
          <th >
            Beneficiary A/C name
          </th>
          <th >
            Sender to Receiver<br>(Transaction Narration)
          </th>
        </tr>
      </thead>
      <?php
 $salaryMonth = $smonth; 
 $cnt = 1;
 $sql = "SELECT payroll_ss.*, emp.*, payroll_ban.*
         FROM payroll_ss
         LEFT JOIN emp ON payroll_ss.empname = emp.empname
         LEFT JOIN payroll_ban ON payroll_ss.empname = payroll_ban.empname
         WHERE payroll_ss.salarymonth = '$salaryMonth' ORDER BY emp.emp_no ASC";

            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
            ?>
      <tbody>
        <tr>
          <td>
          <?php echo $cnt++; ?>
          </td>
          <td >
          <?php echo $result['transid']; ?>
          </td>
          <td style="text-align:right;">
          <?php echo str_replace(',', '', number_format($result['payout'], 0)); ?>
          </td>
          <td >
            11
          </td>
          <td >
            436205000047
          </td>
          <td>
            ANIKA STERILIS PRIVATE LIMITED
          </td>
          <td >
            EML
          </td>
          <td >
            info@anikasterilis.com
          </td>
          <td >
            ANIKA STERILIS PRIVATE LIMITED
          </td>
          <td style="text-align:left;">
          <?php echo $result['sifsc']; ?>
          <td >
            10
          </td>
          <td style="text-align:left;">
          <?php echo $result['sban']; ?>
          </td>
          <td style="text-align:left;">
          <?php echo $result['empname']; ?>
          </td>
          <td style="text-transform: uppercase;">
            SALARY FOR THE MONTH OF <?php echo $salaryMonth ?>
          </td>
        </tr>
      </tbody>
      <?php
                }
            } else {
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td colspan="8" class="px-6 py-4 text-center">No data</td>
                </tr>
            <?php
            }
            ?>
    </table>
</body>

</html>
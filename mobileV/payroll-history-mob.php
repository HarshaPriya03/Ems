<?php
@include '../inc/config.php';

$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./empmobcss/globalqw.css" />
  <link rel="stylesheet" href="./empmobcss/attendenceemp-mob.css" />
  <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <div class="attendenceemp-mob" style="height: 100svh;">
    <div class="logo-1-group">
      <img class="logo-1-icon1" style=" z-index:99; margin-top: -15px;" alt="" src="./public/logo-1@2x.png" />

      <a class="attendance-management" style="width: 300px; margin-top: -17px; color: white; z-index: 99;">Payroll Management</a>
    </div>
    <!-- <div class="attendenceemp-mob-child"></div> -->
    <div class="attendenceemp-mob-item" style="margin-top: -75px; height: 50px;"></div>
    <?php 
    $dateParts = explode(' ', $smonth);
    $month = $dateParts[0];
    $year = $dateParts[1];

    $numDays = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($month)), $year);
  ?>
    <div class="rectangle-parent9" style="margin-top: -50px; height: 600px;">
      <div style="background-color: #fcfbff; border: 1px solid #dadada; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); border-radius: 10px;">
        <p style="color: #7E7E7E; margin-left: 20px; padding-top: 10px;">Period:  <?php echo $smonth ?></span> | <?php echo $numDays ?>  Pay Days</p>
        <div style="display: flex;">
          <div style="display: flex;">
            <div style=" margin-left: 10px; display: flex; align-items: center; justify-content: center; background-color: #dfffef; border-radius: 50%; width: 50px; height: 50px;">
              <img src="./public/Vector-1231.svg" width="20px" alt="">
            </div>
            <?php
          $sql = "SELECT SUM(payout + epf1 + epf2 + esi1 + esi2 + misc + pension) AS total_payroll FROM payroll_ss WHERE salarymonth = '$smonth'";
          $result = $con->query($sql);
          $row = $result->fetch_assoc();
          $total_payroll = $row['total_payroll'];
          if (($total_payroll - floor($total_payroll)) > 0.5) {
            $total_payroll = ceil($total_payroll);
          } elseif (($total_payroll - floor($total_payroll)) < 0.5) {
            $total_payroll = floor($total_payroll);
          }
          ?>

            <div>
              <p style="font-size: 22px;">₹<?php echo $total_payroll; ?> </p>
              <p style="font-size: 12px; color: #7E7E7E; margin-top: -20px;">PAYROLL COST</p>
            </div>
          </div>
          <?php
          $sql = "SELECT SUM(payout) AS total_payout FROM payroll_ss WHERE salarymonth = '$smonth'";
          $result = $con->query($sql);
          $row = $result->fetch_assoc();
          $sum = $row['total_payout'];
          ?>
          <div style="display: flex;">
            <div style=" margin-left: 10px; display: flex; align-items: center; justify-content: center; background-color: #e4dfff; border-radius: 50%; width: 50px; height: 50px;">
              <img src="./public/Group-2.svg" width="20px" alt="">
            </div>
            <div>
              <p style="font-size: 22px;">₹<?php echo $sum; ?></p>
              <p style="font-size: 12px; color: #7E7E7E; margin-top: -20px;">EMPLOYEE'S NET PAY</p>
            </div>
          </div>
        </div>
      </div>
      <?php
      $sql = "SELECT paid FROM payroll_schedule WHERE smonth = '$smonth' ";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $paid = $row['paid'];
      $paidDate = date('d', strtotime($paid)); 
$paidMonthYear = date('F Y', strtotime($paid)); 

      ?>
      <div style="background-color: rgb(255, 255, 255); margin-top: 10px; margin-left: auto; margin-right: auto; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 200px; height: 166px; border-radius: 10px; border: 1px solid #e7e7e7;">
        <p style=" color: #7e7e7e; text-align: center; font-size: 18px; margin-top: 10px;">
        <?php
                                if ($row['paid'] == NULL) {
                                    echo "PAY  DATE";
                                } else {
                                    echo "PAID DATE";
                                }
                                ?>
      </p>
        <p style="font-size: 30px; font-weight: lighter; text-align: center; margin-top: -10px;">
        <?php
                                if ($row['paid'] == NULL) {
                                 echo "To be";
                                } else {
                                  echo $paidDate ;
                                }
                                ?>
      </p>
        <p style="font-size: 20px; font-weight: lighter; text-align: center; margin-top: -25px;">
        <?php
                                if ($row['paid'] == NULL) {
                                 echo "Paid on 7th";
                                } else {
                                  echo $paidMonthYear ;
                                }
                                ?>
      </p>
        <hr>
        <?php
        $sql4 = "SELECT paid_emp FROM payroll_schedule WHERE smonth = '$smonth' ";

        $result4 = $con->query($sql4);
        $row4 = $result4->fetch_assoc();
        $count4 = $row4['paid_emp'];
        ?>
        <p style=" color: #7e7e7e; text-align: center; font-size: 18px; margin-top: -10px;">
        <?php
                                if ($row['paid'] == NULL) {
                                 echo "";
                                } else {
                                  echo $count4 .'EMPLOYEES' ;
                                }
                                ?>
      </p>
      </div>
      <div>
      <a href="../Payroll/print-details_main.php?smonth=<?php echo $smonth; ?>" target="_blank" style="text-decoration:none;">
        <div style="display: flex; gap: 10px; align-items:center; background-color: #fcfbff; border: 1px solid #dadada; height: 50px; border-radius: 10px; margin-top: 10px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <img style=" background-color: #ffffff; border-radius: 5px; width: 45px; height: 35px !important; left: 10px; top: 6px;" src="../Payroll/public/pdf.svg" alt="">
          <p style="margin-top: 15px;">Salary Statement</p>
        </div>
        </a>
        <a href="../Payroll/print-details_bank.php?smonth=<?php echo $smonth; ?>" target="_blank" style="text-decoration:none;">
        <div style="display: flex; gap: 10px; align-items:center; background-color: #fcfbff; border: 1px solid #dadada; height: 50px; border-radius: 10px; margin-top: 10px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
     
           <img style=" background-color: #ffffff; border-radius: 5px; width: 45px; height: 35px !important; left: 10px; top: 6px;" src="../Payroll/public/pdf.svg" alt="">
     
          <p style="margin-top: 15px;">Bank Statement</p>
        </div>
        </a>
        <a href="../Payroll/exportCSV_main.php?smonth=<?php echo $smonth; ?>"  style="text-decoration:none;">
        <div style="display: flex; gap: 10px; align-items:center; background-color: #fcfbff; border: 1px solid #dadada; height: 50px; border-radius: 10px; margin-top: 10px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <img style=" background-color: #ffffff; border-radius: 5px; width: 45px; height: 35px !important; left: 10px; top: 6px;" src="../Payroll/public/xls.svg" alt="">
          <p style="margin-top: 15px;">Salary Statement</p>
        </div>
        </a>
        <a href="../Payroll/exportCSV_bank.php?smonth=<?php echo $smonth; ?>" style="text-decoration:none;">
        <div style="display: flex; gap: 10px; align-items:center; background-color: #fcfbff; border: 1px solid #dadada; height: 50px; border-radius: 10px; margin-top: 10px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <img style=" background-color: #ffffff; border-radius: 5px; width: 45px; height: 35px !important; left: 10px; top: 6px;" src="../Payroll/public/xls.svg" alt="">
          <p style="margin-top: 15px;">Bank Statement</p>
        </div>
        </a>
        <a href="../Payroll/print-details_ss.php?smonth=<?php echo $smonth; ?>" target="_blank" style="text-decoration:none;">
        <div style="display: flex; gap: 10px; align-items:center; background-color: #fcfbff; border: 1px solid #dadada; height: 50px; border-radius: 10px; margin-top: 10px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <img style=" background-color: #ffffff; border-radius: 5px; width: 45px; height: 35px !important; left: 10px; top: 6px;" src="../Payroll/public/pdf.svg" alt="">
          <p style="margin-top: 15px;">Statement [1]</p>
        </div>
        </a>
        <a href="../Payroll/print-details_ssa.php?smonth=<?php echo $smonth; ?>" target="_blank" style="text-decoration:none;">
        <div style="display: flex; gap: 10px; align-items:center; background-color: #fcfbff; border: 1px solid #dadada; height: 50px; border-radius: 10px; margin-top: 10px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <img style=" background-color: #ffffff; border-radius: 5px; width: 45px; height: 35px !important; left: 10px; top: 6px;" src="../Payroll/public/pdf.svg" alt="">
          <p style="margin-top: 15px;">Statement [2]</p>
        </div>
        </a>
      </div>
    </div>
  </div>


</body>

</html>
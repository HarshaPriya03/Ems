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

        td {
            padding: 10px;
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
    <h3 style="text-align: center;"><u>Attendance Report</u></h3>

    <table border="1" cellspacing="0" id="attendanceTable">
          <tr >
            <th>S.No.</th>
            <th>Date <br>
              <div style="display: flex;"><input style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198); width: 100px;" type="date"> <input style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198); width: 100px;" type="date"></div>
            </th>
            <th>Employee Name <br> <input style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" type="text" placeholder="Search for employee"></th>
            <th colspan="2" >In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
            <th colspan="2" >Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
            <th>Total Hrs</th>
            <th>Actual Working Hrs</th>
          </tr>
          <?php
          $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
FROM emp
INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
WHERE emp.empstatus = 0
AND emp.desg != 'SECURITY GAURDS'
ORDER BY CamsBiometricAttendance.AttendanceTime DESC";

          $que = mysqli_query($con, $sql);
          $cnt = 1;
          $userCheckOut = array();
          $userEntriesCount = array();
          $prevDay = null;
          $showDiscrepancyDiv = false;

          while ($result = mysqli_fetch_assoc($que)) {
            $userId = $result['UserID'];
            $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
            $formattedDate = date('D j M', strtotime($result['AttendanceTime']));
            $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

            $showWarningSVG = false;

            if ($dayOfMonth == date('j')) {
              if ($result['AttendanceType'] == 'CheckIn' && !isset($userEntriesCount[$userId][$dayOfMonth])) {
                $userEntriesCount[$userId][$dayOfMonth] = 1;
              } elseif ($result['AttendanceType'] == 'CheckIn') {
                $userEntriesCount[$userId][$dayOfMonth]++;
                $showWarningSVG = true;
              }
            }

            if ($result['AttendanceType'] == 'CheckOut') {
              $userCheckOut[$userId] = array(
                'AttendanceTime' => $result['AttendanceTime'],
                'InputType' => $result['InputType'],
                'Department' => $result['dept']
              );
            } elseif ($result['AttendanceType'] == 'CheckIn') {
              $currentDay = date('j', strtotime($result['AttendanceTime']));


          ?>
              <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $formattedDate; ?></td>
                <td><?php echo $result['empname']; ?></td>
                <td> <?php echo $result['AttendanceTime']; ?></td>
                <td> <?php echo $result['InputType']; ?></td>
                <td>
                  <?php
                  if (isset($userCheckOut[$userId])) {
                    echo $userCheckOut[$userId]['AttendanceTime'];
                  } else {
                    echo '<span style="color: red !important;">Yet to Check Out!</span>';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if (isset($userCheckOut[$userId])) {
                    echo $userCheckOut[$userId]['InputType'];
                  } else {
                    echo '<span style="color: red !important;">Yet to Check Out!</span>';
                  }
                  ?>
                </td>
                
                <td>
                  <?php
                  $empname = $result['empname'];

                  $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

                  $result = $con->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      // Convert fromshifttime1 and toshifttime1 to DateTime objects
                      $fromShiftTime = new DateTime($row['fromshifttime1']);
                      $toShiftTime = new DateTime($row['toshifttime1']);

                      // Calculate the difference between the times
                      $interval = $fromShiftTime->diff($toShiftTime);

                      // Format the difference
                      $duration = $interval->format('%h hrs %i mins');

                      echo $duration;
                    }
                  } else {
                    echo "No designation found for this employee";
                  }
                  ?>
                </td>
              </tr>
          <?php
              $prevDay = $currentDay;
            }
            $cnt++;
          }
          ?>
        </table>


</body>

</html>
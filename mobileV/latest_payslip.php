<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
                 text: 'Login Again, if your still facing issues Contact HR!',
            }).then(function() {
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
    exit();
}
$sqlStatusCheck = "SELECT empstatus,work_location FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);


$work_location = $statusRow['work_location'];

if ($statusRow['empstatus'] == 0) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />

        <link rel="stylesheet" href="./empmobcss/empjob-details-mob.css" />
        <link rel="stylesheet" href="./empmobcss/globalqw.css" />
        <link rel="stylesheet" href="./empmobcss/my-leaveemp-mob.css" />
        <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob1.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
        <style>
            table {
                border: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border-collapse: collapse;
                border-spacing: 0;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
            }

            table thead {
                background: #F0F0F0;
                height: 60px !important;
            }

            table thead tr th:first-child {
                padding-left: 45px;
            }

            table thead tr th {
                text-transform: uppercase;
                line-height: 60px !important;
                text-align: left;
                font-size: 11px;
                padding-top: 0px !important;
                padding-bottom: 0px !important;
            }

            table tbody {
                background: #fff;
            }

            table tbody tr {
                border-top: 1px solid #e5e5e5;
                height: 60px;
            }

            table tbody tr td:first-child {
                padding-left: 45px;
            }

            table tbody tr td {
                height: 60px;
                line-height: 60px !important;
                text-align: left;
                padding: 0 10px;
                font-size: 14px;
            }

            table tbody tr td i {
                margin-right: 8px;
            }

            @media screen and (max-width: 850px) {
                table {
                    border: 1px solid transparent;
                    box-shadow: none;
                }

                table thead {
                    display: none;
                }

                table tbody tr {
                    border-bottom: 20px solid #F6F5FB;
                }

                table tbody tr td:first-child {
                    padding-left: 10px;
                }

                table tbody tr td:before {
                    content: attr(data-label);
                    float: left;
                    font-size: 10px;
                    text-transform: uppercase;
                    font-weight: bold;
                }

                table tbody tr td {
                    display: block;
                    text-align: right;
                    font-size: 14px;
                    padding: 0px 10px !important;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
                }
            }
        </style>
    </head>

    <body>
        <div class="myleaveemp-mob" style="height: 100svh;">
            <?php
            $sql = "SELECT * FROM leavebalance WHERE empemail = '{$_SESSION['user_name']}'";
            $que = mysqli_query($con, $sql);
            $cnt = 1;
            if (mysqli_num_rows($que) == 0) {
                echo '<tr><td colspan="5" style="text-align:center;">Stay tuned for upcoming updates on your leave balance! Keep an eye on this space for exciting developments.</td></tr>';
            } else {
                while ($result = mysqli_fetch_assoc($que)) {
            ?>
                    <div class="frame-parent" style="height: 230px; margin-top: -20px;">

                        <div class="rectangle-container">
                            <div class="rectangle-div" style="background:#FFE2C6;width:200%;"></div>
                            <svg style="margin-left:90px;" class="vector-icon6 w-10 h-10 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>

                            <p class="total-earned1" style="width:180%;color:black;">
                                <svg class="inline w-6 h-6 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Click on any row to access the payslip for the respective pay period.
                            </p>

                            <div class="sick-leave flex items-center mb-3" style="white-space:nowrap;margin-top:-20px;">

                                <h2 class="text-m font-semibold dark:text-white" style="color:#FF5400;margin-left:60px;">Payroll Information</h2>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>


            <div class="rectangle-parent23" style="margin-top: 240px; height: 240px;">
                <table class="data">
                    <thead>
                        <tr>
                            <th data-label="Payment Date">Payment Date</th>
                            <th data-label="Pay Period">Pay Period</th>
                            <th data-label="Pay Period Details">Pay Period Details</th>
                            <th data-label="Status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_name = $_SESSION['user_name'];

                        $sql1 = "SELECT emp.empname
        FROM emp
        INNER JOIN user_form ON emp.empemail = user_form.email
        WHERE user_form.email = '$user_name'";

                        $result1 = mysqli_query($con, $sql1);

                        if ($result1) {
                            if (mysqli_num_rows($result1) > 0) {
                                $row1 = mysqli_fetch_assoc($result1);
                                $empname = $row1['empname'];
                            } else {
                                $empname = "Unknown";
                            }
                        } else {
                            $empname = "Unknown";
                        }

                        ?>
                        <?php
                        $sql = "SELECT * FROM payroll_schedule WHERE approval != 0 ORDER BY ID DESC";
                        $que = mysqli_query($con, $sql);

                        if ($work_location == 'Visakhapatnam') {
                            $checkEmpnameSql = "SELECT salarymonth FROM payroll_ss_vsp WHERE empname = '$empname'";
                        } elseif ($work_location == 'Gurugram') {
                            $checkEmpnameSql = "SELECT salarymonth FROM payroll_ss_ggm WHERE empname = '$empname'";
                        }

                        $checkEmpnameResult = mysqli_query($con, $checkEmpnameSql);
                        $empnameExists = mysqli_num_rows($checkEmpnameResult) > 0;

                        if ($empnameExists) {
                            $salaryMonths = [];
                            while ($row = mysqli_fetch_assoc($checkEmpnameResult)) {
                                $salaryMonths[] = $row['salarymonth'];
                            }

                            if (mysqli_num_rows($que) > 0) {
                                while ($result = mysqli_fetch_assoc($que)) {
                                    $monthYear = $result['smonth'];

                                    if (in_array($monthYear, $salaryMonths)) {
                                        $startOfMonth = date('d/m/Y', strtotime('first day of ' . $monthYear));
                                        $endOfMonth = date('d/m/Y', strtotime('last day of ' . $monthYear));
                        ?>
                                        <tr onclick="openPayrollHistory('<?php echo $monthYear; ?>')">
                                            <td data-label="Payment Date:">
                                                <?php echo $result['paid']; ?>
                                            </td>
                                            <td data-label="Pay Period:">
                                                <?php echo $monthYear; ?>
                                            </td>
                                            <td data-label="Pay Period Details:">
                                                <?php echo $startOfMonth . ' to ' . $endOfMonth; ?>
                                            </td>
                                            <td data-label="Status:">
                                                <p class="text-green-400">PAID</p>
                                            </td>
                                        </tr>
                    </tbody>
            <?php
                                    }
                                }
                            } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="8" class="px-6 py-4 text-center">No data</td>
            </tr>
        <?php
                            }
                        } else {
        ?>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td colspan="8" class="px-6 py-4 text-center">No data found</td>
        </tr>
    <?php
                        }
    ?>
                </table>
            </div>
            <div class="logo-1-container">
                <img class="logo-1-icon2" alt="" src="./public/logo-1@2x.png" />

                <a class="leaves-list" style="width:120%;">Payroll Management</a>
            </div>
            <div class="myleaveemp-mob-item"></div>
            <div class="rectangle-parent1" style="margin-left:-48px">
                <a class="frame-child3" id="rectangleLink" style="width:50%;"> </a>
                <a class="frame-child4" style="background:#E8E8E8;"> </a>
                <a class="apply-leave" id="applyLeave" style="width:100%;">Personal Details</a>
                <a class="my-leaves" style="text-align:center;margin-left:-10px;color:black;">Job</a>
                <a class="frame-child3" href="lbhistory-mob.php" id="rectangleLink1" style="margin-left:200px;background:#FFE2C6;"> </a>
                <a class="apply-leave" href="lbhistory-mob.php" id="myLeaves" style="margin-left:200px; width:50px;text-align:center;color:#FF5400">Salary</a>
            </div>
            <div class="empsalarydetails-mob-inner"></div>
      <div class="fluentperson-clock-20-regular-container">
        <a
          class="fluentperson-clock-20-regular6"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon21"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender6" id="uitcalender">
          <img
            class="vector-icon22"
            alt=""
            src="./public/vector2@2xatten.png"
          />
        </a>
        <img
          class="arcticonsgoogle-pay6"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="frame-child27"></div>
        <a class="akar-iconsdashboard6" href="emp-dashboard-mob.php">
          <img
            class="vector-icon23"
            alt=""
            src="./public/vector.svg"
          />
        </a>
      </div>
        </div>

        <script>
            function openPayrollHistory(monthYear) {
                const thresholdMonthYear = new Date('2024-05-01');
                const currentMonthYear = new Date(monthYear + '-01');

                if (currentMonthYear >= thresholdMonthYear) {
                    window.location.href = "latest_payslip1_new.php?smonth=" + monthYear;
                } else {
                    window.location.href = "payslip1.php?smonth=" + monthYear;
                }
            }
        </script>

        <script>
            // JavaScript to dynamically set the reason content in the modal
            document.addEventListener('DOMContentLoaded', function() {
                const viewReasonButtons = document.querySelectorAll('.view-reason-button');
                const reasonContent = document.getElementById('reason-content');

                viewReasonButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        const reason = this.getAttribute('data-reason');
                        reasonContent.textContent = reason;
                    });
                });
            });
        </script>
        <script>
            var rectangleLink = document.getElementById("rectangleLink");
            if (rectangleLink) {
                rectangleLink.addEventListener("click", function(e) {
                    window.location.href = "./apply-leaveemp-mob.php";
                });
            }

            var applyLeave = document.getElementById("applyLeave");
            if (applyLeave) {
                applyLeave.addEventListener("click", function(e) {
                    window.location.href = "./apply-leaveemp-mob.php";
                });
            }

            var uitcalender = document.getElementById("uitcalender");
            if (uitcalender) {
                uitcalender.addEventListener("click", function(e) {
                    window.location.href = "./attendenceemp-mob.php";
                });
            }

            var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
            if (arcticonsgooglePay) {
                arcticonsgooglePay.addEventListener("click", function(e) {
                    window.location.href = "./directoryemp-mob.php";
                });
            }

            var akarIconsdashboard = document.getElementById("akarIconsdashboard");
            if (akarIconsdashboard) {
                akarIconsdashboard.addEventListener("click", function(e) {
                    window.location.href = "./emp-dashboard-mob.php";
                });
            }
        </script>
    </body>

    </html>
<?php
} else {
    echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Session Expired',
        text: 'For your security, your session has timed out due to inactivity.',
        confirmButtonText: 'Log In Again',
        confirmButtonColor: '#3085d6',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        customClass: {
            container: 'session-expired-alert',
            title: 'font-weight-bold',
            content: 'text-left',
            confirmButton: 'btn btn-primary btn-lg'
        },
        backdrop: `
           #FFBF78
            url('https://apps.anikasterilis.com/ASPL.png')
            center center
            no-repeat
        `
    }).then(function() {
        window.location.href = 'login-mob.php';
    });
});
</script>";
    exit();
}
?>
<?php
@include '../inc/config.php';

$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,600;1,200;1,400;1,600&display=swap" rel="stylesheet">
    <style>
        .TopBar {
            background: rgb(255, 156, 72);
            background: linear-gradient(173deg, rgba(255, 156, 72, 1) 0%, rgba(255, 121, 0, 1) 95%);
            width: 100%;
            margin-top: -10px;
            height: 80px;
            display: flex;
        }

        .logoimg {
            width: 70px;
            height: 70px;
            margin-left: 20px;
            margin-top: 10px;
            -webkit-filter: invert(100%);
            filter: invert(100%);
        }

        .AnikaHRM {
            color: white;
            font-size: 32px;
            margin-top: 23px;
            font-weight: 500;
        }

        .AnikaHRM span {
            color: rgb(4, 160, 4);
        }

        .heading {
            font-size: 35px;
            color: white;
            margin-top: 20px;
            margin-left: 550px;
        }

        .answersdiv {
            background-color: rgb(255, 255, 255);
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .h2heading {
            font-weight: 400;
            font-size: 28px;
        }

        .ppara {
            text-align: justify;
        }

        .ansimg {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        @media only screen and (max-width: 600px) {
            .TopBar {
                flex-direction: column;
                height: 90px;
            }

            .logoimg {
                width: 50px;
                height: 50px;
                margin-top: 30px;
            }

            .AnikaHRM {
                text-align: center;
                font-size: 22px;
                margin-top: -54px;
            }

            .heading {
                color: rgb(255, 255, 255);
                margin-left: auto;
                margin-right: auto;
                font-size: 22px;
                margin-top: -30px;
            }

            .answersdiv {
                width: 90%;
            }

            .ppara {
                text-align: justify;
            }

            .ansimg {
                width: 100%;
            }

            .h2heading {
                font-size: 25px;
            }
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 20px;
            text-align: left;
            border: 1px solid #ccc;
        }

        thead {
            background-color: #f4f4f4;
        }

        @media screen and (max-width: 600px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 15px;
            }

            .padding {
                padding-left: 85%;
            }

             td {
                display: flex;
                justify-content: space-between;
                /* white-space:nowrap; */
                align-items: center;
                padding-left: 50%;
                position: relative;
                text-align: right;
                border: none;
                border-bottom: 1px solid #eee;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left:10px;
                width: calc(50% - 20px);
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
            }
        }

        @media screen and (max-width: 767px) {
            tbody{
                background-color: #f9f8f7;
                width:98%;
            }
    .responsive thead {
      visibility: hidden;
      height: 0;
      position: absolute;
    }
  
    .responsive tr {
      display: block;
      margin-bottom: 1.825em;
    }
  
    .responsive td {
      border: 1px solid;
      border-bottom: none;
      display: block;
      font-size: 0.8em;
      text-align: right;
    }
  
    .responsive td::before {
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }
  
    .responsive td:last-child {
      border-bottom: 1px solid;
    }
  }
    </style>
</head>
<?php
$sql = "SELECT smonth FROM payroll_schedule WHERE status = 7 LIMIT 1";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $smonth = $row["smonth"];
} else {
    $smonth = "No month found with status = 0";
}
?>
<?php
$sql = "SELECT smonth FROM payroll_schedule WHERE approval = 0 LIMIT 1";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $smonth = $row["smonth"];
    $nextMonth = date('F Y', strtotime('+1 month', strtotime($row['smonth'])));

    $dateParts = explode(' ', $smonth);
    $month = $dateParts[0];
    $year = $dateParts[1];

    $numDays = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($month)), $year);
} else {
    $smonth = "No month found with status = 0";
}
?>

<body style="width: 100%; margin-left: -0.5px; font-family:Poppins;">
    <div class="TopBar">
        <img class="logoimg" src="./public/logo-11@2x.png" alt="">
        <p class="AnikaHRM">Anika <span>HRM</span></p>
        <p class="heading">Payroll Management</p>
    </div> <br>
    <div class="table-container">
        <table class="table responsive"  >
            <thead>
                <tr>
                    <th> Payment Date</th>
                    <th> Payroll Month</th>
                    <th> Details</th>
                    <th>Total Number of Employees Paid</th>
                    <th colspan = 2></th>
                </tr>
            </thead>
            <?php

            $sql = "SELECT * FROM payroll_schedule where status = 7 ORDER BY approval";

            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
                    $monthYear = $result['smonth'];

                    $startOfMonth = date('d/m/Y', strtotime('first day of ' . $monthYear));

                    $endOfMonth = date('d/m/Y', strtotime('last day of ' . $monthYear));
            ?>
                    <tbody style="text-align: center;">
                        <tr style="cursor: pointer;" onclick="openPayrollHistory('<?php echo $monthYear; ?>')">
                            <td data-label="Payment Date">
                            <?php
                                if ($result['paid'] == NULL) {
                                    echo "Awaiting HR Update";
                                } else {
                                    echo $result['paid'];
                                }
                                ?>
                        </td>
                            <td data-label="Payroll Month"><?php echo $monthYear; ?></td>
                            <td data-label="Details">FOR THE PAY PERIOD  <?php echo $startOfMonth . ' to ' . $endOfMonth; ?></td>
                            <td class="padding" data-label="Total Number of Employees Paid">
                            <?php
                                if ($result['paid_emp'] == NULL) {
                                    echo "Awaiting HR Update";
                                } else {
                                    echo $result['paid_emp'];
                                }
                                ?>
                        </td>
                            <td class="padding" data-label="Status">
                                <?php
                                if ($result['approval'] == 1) {
                                    echo "Paid";
                                } else {
                                    echo "Awaiting HR Update";
                                }
                                ?>
                            </td>
                            <td class="padding" data-label="Access Statements">
                                <svg class="w-6 h-6 text-blue-800 dark:text-blue" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
                                </svg>

                            </td>
                        </tr>
                    </tbody>

                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center">No data</td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <script>
        function openPayrollHistory(monthYear) {
            window.location.href = "payroll-history-mob.php?smonth=" + monthYear;
        }
    </script>
</body>

</html>
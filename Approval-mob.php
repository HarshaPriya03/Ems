<?php
@include 'inc/config.php';
$apremail = isset($_GET['email']) ? $_GET['email'] : '';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global6.css" />
    <link rel="stylesheet" href="./css/email-form.css" />
    <link rel="stylesheet" href="./css/email-form2.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

     <style>
       table {
        z-index: 100;
  border-collapse: collapse;
  background-color: white;
  margin-left: auto;
  margin-right: auto;
}

th, td {
  padding: 1em;
  background: white;
  color: rgb(52, 52, 52);
  border-bottom: 2px solid rgb(193, 193, 193); 
}
        .confirm{
          width: 80px;
          height: 30px;
          margin-top: 5px;
          color: red; background: transparent; border: 1px solid red;
          border-radius: 10px;
        }
        .confirm:hover{
            background-color: red;
            color: white;
        }
        .remove{
            display: none;
        }
        caption{
          color: #383838;
          font-size: 30px;
          margin-bottom: 10px;
        }

        
        @media screen and (max-width: 600px) {
    table {
      border: 0;
      width: 380px;
      margin-left: auto;
      margin-right: auto;
    }
  
    table caption {
      font-size: 1.3em;
    }
    
    table thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    
    table tr {
      border-bottom: 3px solid #2b2b2b;
      display: block;
      margin-bottom: 1em;
    }
    
    table td {
      border-bottom: 1px solid #2b2b2b;
      display: block;
      font-size: .8em;
      text-align: right;
    }
    .employee-management1{
        display: none;
    }
    
    table td::before {
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    table td:last-child {
        border-bottom: 0;
      }
      
    table td:first-child {
        border-bottom: 0;
      }
    table td:nth-child(2) {
        border-bottom: 0;
        float: left;
        margin-top: -110px;
      }
      table td:nth-child(3) {
        border-bottom: 0;
        float: left;
        margin-top: -75px;
      }
  }

.marquee {
  height: 50px;
  font-size: 25px;
font-weight: 500;
  overflow: hidden;
  position: relative;
  color: #F56B12;
  border: 2px solid #000000;
  z-index:1000;
}

.marquee p {
  position: absolute;
  z-index:1000;
  width: 100%;
  height: 100%;
  margin: 0;
  line-height: 50px;
  text-align: center;
  -moz-transform: translateX(100%);
  -webkit-transform: translateX(100%);
  transform: translateX(100%);
  -moz-animation: scroll-right 1s linear infinite;
  -webkit-animation: scroll-right 1s linear infinite;
  animation: scroll-right 9s linear infinite;
}
@keyframes scroll-right {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }
@media (max-width: 767px) {
.marquee p {
    font-size: 20px !important;
    line-height: 20px !important;
}
}
    </style>
</head>

<body>
    <div class="emailform" >
        <div class="bg1"></div>
        <img class="emailform-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="logo-1-icon1"  alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm1">
            <span>Anika</span>
            <span class="hrm1">HRM</span>
        </a>
        <a class="employee-management1" id="employeeManagement">Leave Management</a>
        <img class="uitcalender-icon1" alt="" src="./public/uitcalemnder.svg" />
        <div class="section active" id="section1">
            <div class="bxhome1" id="bxhome"></div>
            <div class="rectangle-group" style="overflow-y: auto;">
            <table class="data">
    <caption>Leave Requests</caption>
    <thead>
        <tr>
            <th></th>
            <th scope="col">Employee Name</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Leave Type</th>
            <th scope="col">Leave From</th>
            <th scope="col">Leave To</th>
            <th scope="col">Reason</th>
            <th scope="col">HR Remarks</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <?php
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $sql = "SELECT * FROM leaves WHERE status = '3' AND apremail = '$email' ORDER BY ID ASC";
    $que = mysqli_query($con, $sql);

    if (mysqli_num_rows($que) == 0) {
        ?>
        <tr>
            <td colspan="9" ><div class="marquee">
									<p>« <b class="text-dark">No Requests</b> at this moment ! »</p>
								</div></td>
        </tr>
        <?php
    } else {
        $cnt = 1;
        while ($result = mysqli_fetch_assoc($que)) {
            $employeeSql = "SELECT pic FROM emp WHERE empname = '{$result['empname']}'";
            $employeeQuery = mysqli_query($con, $employeeSql);
            $employeeData = mysqli_fetch_assoc($employeeQuery);
            ?>
            <tr>
                <td>
                    <img class="hovpic" src="pics/<?php echo $employeeData['pic']; ?>" width="60px" height="60px" style="border-radius: 48px; border: 1px solid rgb(161, 161, 161);" alt="">
                </td>
                <td class="wert"><?php echo $result['empname']; ?></td>
                <td><?php echo $result['empph']; ?></td>
                <td data-label="Leave Type:"><?php echo $result['leavetype']; ?></td>
                <?php
$leavetype2 = $result['leavetype2'];

if ($leavetype2 === 'FN' || $leavetype2 === 'AN') {
    echo '<td data-label="From Date:">' . date('d-m-Y H:i', strtotime($result['from'])) . '</td>';
    echo '<td data-label="To Date:">' . date('d-m-Y H:i', strtotime($result['to'])) . '</td>';
} else {
    echo '<td data-label="From Date:">' . date('d-m-Y', strtotime($result['from'])) . '</td>';
    echo '<td data-label="To Date:">' . date('d-m-Y', strtotime($result['to'])) . '</td>';
}
?>
                <td data-label="Reason:" style="text-align:justify;"><?php echo $result['reason']; ?></td>
                <td data-label="HR Remarks:"><?php echo $result['hrremark']; ?></td>
                <td data-label="Action">
                    <div style="display: flex; gap: 30px; justify-content: center;">
                    <form name="approve" method="POST" data-apremail="<?php echo $apremail; ?>">
    <input type="hidden" name="appid" value="<?php echo $result['ID']; ?>">
    <button name="approve" style="background: transparent; border: none;">
        <img src="./public/image-20231221-122832907removebgpreview-1@3x.png" width="45px" height="50px" style="margin-top: 6px;" alt="">
    </button>
</form>


                        <form name="reject" method="POST" data-apremail="<?php echo $apremail; ?>">
                            <input type="hidden" name="appid" value="<?php echo $result['ID']; ?>">
                            <button style="background: transparent; border: none;" onclick="edif(); return false;">
                                <img src="./public/360-f-135715088-upk1bf6yqvcrbkhjsq9k7ml0xkwbmjzxremovebgpreview-1@3x.png" width="70px" alt="">
                            </button>
                            <input id="intec" type="text" name="aprremark" class="remove " style="font-size: 17px; border: 1px solid grey; width: 200px; height: 40px; border-radius: 10px;">

                            <button type="submit" name="reject" id="intecbtn" class="confirm remove">Confirm</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php
        }
    }
    ?>
</table>

            </div>
        </div>
       
    </div>
    </div>
</body>
<script>
    function edif() {
        document.getElementById("intec").classList.remove("remove");
        document.getElementById("intecbtn").classList.remove("remove");
    }
</script>
<script>
$(document).ready(function () {
    $('form[name="approve"]').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var appid = form.find('input[name="appid"]').val();
        var apremail = getQueryParam('email');

        $.ajax({
            type: 'POST',
            url: 'approver_accept.php',
            data: {
                appid: appid,
                apremail: apremail,
                approve: true
            },
            success: function (response) {
                if (response === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Successfully approved!',
                    }).then(function () {
                        window.location.href = "Approval-mob.php?email=" + encodeURIComponent(apremail);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submission failed!',
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    function getQueryParam(param) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }
});
</script>
<script>
    $(document).ready(function () {
        $('form[name="reject"]').submit(function (e) {
            e.preventDefault();

            var form = $(this);
            var appid = form.find('input[name="appid"]').val();
            var aprremark = form.find('input[name="aprremark"]').val();
            var apremail = getQueryParam('email');

            $.ajax({
                type: 'POST',
                url: 'approver_reject.php',
                data: {
                    appid: appid,
                    aprremark: aprremark,
                    apremail: apremail,
                    reject: true
                },
                success: function (response) {
                    if (response === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Successfully rejected!',
                        }).then(function () {
                            window.location.href = "Approval-mob.php?email=" + encodeURIComponent(apremail);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Form submission failed!',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        function getQueryParam(param) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
    });
</script>


</html>
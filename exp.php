<?php
session_start();
@include 'inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
    exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
    header('location:loginpage.php');
    exit();
}

$query = "SELECT user_type FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row && isset($row['user_type'])) {
        $user_type = $row['user_type'];

        if ($user_type !== 'admin') {
            header('location:loginpage.php');
            exit();
        }
    } else {
        die("Error: Unable to fetch user details.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/records.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
    <!-- Add the Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add the Select2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .content {
            display: none;
        }

        .show {
            display: block;
        }

        table {
            z-index: 100;
            border-collapse: collapse;
            /* border-radius: 200px; */
            background-color: white;
            /*   overflow: hidden; */
        }

        th,
        td {
            padding: 1em;
            background: white;
            color: rgb(52, 52, 52);
            border-bottom: 2px solid rgb(193, 193, 193);
        }
        .selectMultiple {
  width: 240px;
  position: relative;
}
.selectMultiple select {
  display: none;
}
.selectMultiple > div {
  position: relative;
  z-index: 2;
  padding: 8px 12px 2px 12px;
  border-radius: 8px;
  background: #fff;
  font-size: 14px;
  min-height: 44px;
  box-shadow: 0 4px 16px 0 rgba(22, 42, 90, 0.12);
  transition: box-shadow 0.3s ease;
}
.selectMultiple > div:hover {
  box-shadow: 0 4px 24px -1px rgba(22, 42, 90, 0.16);
}
.selectMultiple > div .arrow {
  right: 1px;
  top: 0;
  bottom: 0;
  cursor: pointer;
  width: 28px;
  position: absolute;
}
.selectMultiple > div .arrow:before, .selectMultiple > div .arrow:after {
  content: "";
  position: absolute;
  display: block;
  width: 2px;
  height: 8px;
  border-bottom: 8px solid #99A3BA;
  top: 43%;
  transition: all 0.3s ease;
}
.selectMultiple > div .arrow:before {
  right: 12px;
  transform: rotate(-130deg);
}
.selectMultiple > div .arrow:after {
  left: 9px;
  transform: rotate(130deg);
}
.selectMultiple > div span {
  color: #99A3BA;
  display: block;
  position: absolute;
  left: 12px;
  cursor: pointer;
  top: 8px;
  line-height: 28px;
  transition: all 0.3s ease;
}
.selectMultiple > div span.hide {
  opacity: 0;
  visibility: hidden;
  transform: translate(-4px, 0);
}
.selectMultiple > div a {
  position: relative;
  padding: 0 24px 6px 8px;
  line-height: 28px;
  color: #1E2330;
  display: inline-block;
  vertical-align: top;
  margin: 0 6px 0 0;
}
.selectMultiple > div a em {
  font-style: normal;
  display: block;
  white-space: nowrap;
}
.selectMultiple > div a:before {
  content: "";
  left: 0;
  top: 0;
  bottom: 6px;
  width: 100%;
  position: absolute;
  display: block;
  background: rgba(228, 236, 250, 0.7);
  z-index: -1;
  border-radius: 4px;
}
.selectMultiple > div a i {
  cursor: pointer;
  position: absolute;
  top: 0;
  right: 0;
  width: 24px;
  height: 28px;
  display: block;
}
.selectMultiple > div a i:before, .selectMultiple > div a i:after {
  content: "";
  display: block;
  width: 2px;
  height: 10px;
  position: absolute;
  left: 50%;
  top: 50%;
  background: #ff6d18;
  border-radius: 1px;
}
.selectMultiple > div a i:before {
  transform: translate(-50%, -50%) rotate(45deg);
}
.selectMultiple > div a i:after {
  transform: translate(-50%, -50%) rotate(-45deg);
}
.selectMultiple > div a.notShown {
  opacity: 0;
  transition: opacity 0.3s ease;
}
.selectMultiple > div a.notShown:before {
  width: 28px;
  transition: width 0.45s cubic-bezier(0.87, -0.41, 0.19, 1.44) 0.2s;
}
.selectMultiple > div a.notShown i {
  opacity: 0;
  transition: all 0.3s ease 0.3s;
}
.selectMultiple > div a.notShown em {
  opacity: 0;
  transform: translate(-6px, 0);
  transition: all 0.4s ease 0.3s;
}
.selectMultiple > div a.notShown.shown {
  opacity: 1;
}
.selectMultiple > div a.notShown.shown:before {
  width: 100%;
}
.selectMultiple > div a.notShown.shown i {
  opacity: 1;
}
.selectMultiple > div a.notShown.shown em {
  opacity: 1;
  transform: translate(0, 0);
}
.selectMultiple > div a.remove:before {
  width: 28px;
  transition: width 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44) 0s;
}
.selectMultiple > div a.remove i {
  opacity: 0;
  transition: all 0.3s ease 0s;
}
.selectMultiple > div a.remove em {
  opacity: 0;
  transform: translate(-12px, 0);
  transition: all 0.4s ease 0s;
}
.selectMultiple > div a.remove.disappear {
  opacity: 0;
  transition: opacity 0.5s ease 0s;
}
.selectMultiple > ul {
  margin: 0;
  padding: 0;
  list-style: none;
  font-size: 16px;
  z-index: 1;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  visibility: hidden;
  opacity: 0;
  border-radius: 8px;
  transform: translate(0, 20px) scale(0.8);
  transform-origin: 0 0;
  filter: drop-shadow(0 12px 20px rgba(22, 42, 90, 0.08));
  transition: all 0.4s ease, transform 0.4s cubic-bezier(0.87, -0.41, 0.19, 1.44), filter 0.3s ease 0.2s;
}
.selectMultiple > ul li {
  color: #1E2330;
  background: #fff;
  padding: 12px 16px;
  cursor: pointer;
  overflow: hidden;
  position: relative;
  transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease 0.3s, opacity 0.5s ease 0.3s, border-radius 0.3s ease 0.3s;
}
.selectMultiple > ul li:first-child {
  border-radius: 8px 8px 0 0;
}
.selectMultiple > ul li:first-child:last-child {
  border-radius: 8px;
}
.selectMultiple > ul li:last-child {
  border-radius: 0 0 8px 8px;
}
.selectMultiple > ul li:last-child:first-child {
  border-radius: 8px;
}
.selectMultiple > ul li:hover {
  background: #ff6d18;
  color: #fff;
}
.selectMultiple > ul li:after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  width: 6px;
  height: 6px;
  background: rgba(0, 0, 0, 0.4);
  opacity: 0;
  border-radius: 100%;
  transform: scale(1, 1) translate(-50%, -50%);
  transform-origin: 50% 50%;
}
.selectMultiple > ul li.beforeRemove {
  border-radius: 0 0 8px 8px;
}
.selectMultiple > ul li.beforeRemove:first-child {
  border-radius: 8px;
}
.selectMultiple > ul li.afterRemove {
  border-radius: 8px 8px 0 0;
}
.selectMultiple > ul li.afterRemove:last-child {
  border-radius: 8px;
}
.selectMultiple > ul li.remove {
  transform: scale(0);
  opacity: 0;
}
.selectMultiple > ul li.remove:after {
  -webkit-animation: ripple 0.4s ease-out;
          animation: ripple 0.4s ease-out;
}
.selectMultiple > ul li.notShown {
  display: none;
  transform: scale(0);
  opacity: 0;
  transition: transform 0.35s ease, opacity 0.4s ease;
}
.selectMultiple > ul li.notShown.show {
  transform: scale(1);
  opacity: 1;
}
.selectMultiple.open > div {
  box-shadow: 0 4px 20px -1px rgba(22, 42, 90, 0.12);
}
.selectMultiple.open > div .arrow:before {
  transform: rotate(-50deg);
}
.selectMultiple.open > div .arrow:after {
  transform: rotate(50deg);
}
.selectMultiple.open > ul {
  transform: translate(0, 12px) scale(1);
  opacity: 1;
  visibility: visible;
  filter: drop-shadow(0 16px 24px rgba(22, 42, 90, 0.16));
}

@-webkit-keyframes ripple {
  0% {
    transform: scale(0, 0);
    opacity: 1;
  }
  25% {
    transform: scale(30, 30);
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: scale(50, 50);
  }
}

@keyframes ripple {
  0% {
    transform: scale(0, 0);
    opacity: 1;
  }
  25% {
    transform: scale(30, 30);
    opacity: 1;
  }
  100% {
    opacity: 0;
    transform: scale(50, 50);
  }
}
html {
  box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
}

* {
  box-sizing: inherit;
}
*:before, *:after {
  box-sizing: inherit;
}
option{
  z-index: 99999999999999999;
}
::-webkit-scrollbar {
    width: 8px;
}
 
::-webkit-scrollbar-track {
    background-color: #ebebeb;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: #bebebe; 
}
.actionBtn{
    background-color:transparent; border:1px solid blue; border-radius:5px; color:blue; padding:.7em;
}
.actionBtn:hover{
    transition: all 600ms ease;
    background-color:blue;
    color:white;
}
.actionBtn2{
    background-color:transparent; border:1px solid red; border-radius:5px; color:red; padding:.7em;
}
.actionBtn2:hover{
    transition: all 600ms ease;
    background-color:red;
    color:white;
}

    </style>
</head>

<body>
    <div class="records3">
        <div class="bg13"></div>
        <img class="records-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="records-item" alt="" src="./public/rectangle-2@2x.png" />

        <img class="logo-1-icon13" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm13" href="./index.php" id="anikaHRM">
            <span>Anika</span>
            <span class="hrm13">HRM</span>
        </a>
        <a class="attendence-management3" href="./index.php" id="attendenceManagement">Dashboard/Designation-Shifts</a>
        <button class="records-inner"></button>
        <div class="logout13">Logout</div>
        <div class="payroll13">Payroll</div>
        <div class="reports13">Reports</div>
        <img class="uitcalender-icon13" alt="" src="./public/uitcalender.svg" />

        <img class="arcticonsgoogle-pay13" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon13" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

        <img class="records-child1" alt="" src="./public/ellipse-1@2x.png" />

        <img class="material-symbolsperson-icon13" alt="" src="./public/materialsymbolsperson.svg" />

        <img class="records-child2" style="margin-top: -262px;" alt="" src="./public/rectangle-4@2x.png" />

        <a class="dashboard13" href="./index.php" style="color: white;" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular13" id="fluentpeople32Regular">
            <img class="vector-icon67" alt="" src="./public/vector7.svg" />
        </a>
        <a class="employee-list13" id="employeeList">Employee List</a>
        <a class="akar-iconsdashboard13" href="./index.php" id="akarIconsdashboard">
            <img class="vector-icon68" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector3.svg" />
        </a>
        <img class="tablerlogout-icon13" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves13" id="leaves">Leaves</a>
        <a class="fluentperson-clock-20-regular13" id="fluentpersonClock20Regular">
            <img class="vector-icon69" alt="" src="./public/vector1.svg" />
        </a>
        <a class="onboarding15" id="onboarding">Onboarding</a>
        <a class="fluent-mdl2leave-user13" id="fluentMdl2leaveUser">
            <img class="vector-icon70" alt="" src="./public/vector.svg" />
        </a>
        <a class="attendance13" style="color: black;">Attendance</a>
        <a class="uitcalender13">
            <img class="vector-icon71" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector11.svg" />
        </a>
        <div class="oouinext-ltr1"></div>
        <div class="rectangle-parent21" style="margin-top: -70px;">
            <div class="frame-child176"></div>
            <div class="oouinext-ltr2"></div>
            <div class="employee-records">Manager</div>
            <div class="frame-child178"></div>
            <div class="employee-name7">Manager</div>
            <div class="designation4">Department</div>
            <form id="updateForm">
                <select class="frame-child181" id="employeeSelect" onchange="updateFields()" style="font-size:22px;">
                    <option value="">--select--</option>
                    <?php
                    $servername = "localhost";
                    $username = "Anika12";
                    $password = "Anika12";
                    $dbname = "ems";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT empname, empemail FROM emp WHERE empstatus=0";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["empname"] . "|" . $row["empemail"] . "'>" . $row["empname"] . "</option>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </select>

                <input style='margin-top:100px;' class='frame-child181' type='text' name='empname' id='employeeNameField' value=''>
                <input style='margin-top:100px; font-size:22px;' class='frame-child181' type='email' name='email' id='employeeEmailField' value=''>

                
                <div style=" margin-top: 120px; margin-left: 595px; position: absolute; width:300px; height:200px; overflow-y:auto;">
                  <select multiple data-placeholder="Add Departments">
                    <?php
                    $servername = "localhost";
                    $username = "Anika12";
                    $password = "Anika12";
                    $dbname = "ems";
      
                    $conn = new mysqli($servername, $username, $password, $dbname);
      
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
      
                    $sql = "SELECT desg FROM dept";
                    $result = $conn->query($sql);
      
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.$row['desg'].'">' . $row['desg'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No data available</option>';
                    }
      
                    $conn->close();
                    ?>
                </select>
                  <!-- <select name="desgs[]" id="desgSelect" multiple="multiple" style="height:55px; margin-left: 595px; margin-top: 115px; position: absolute; width: 400px; border-radius: 10px;" >
                    <?php
                    $servername = "localhost";
                    $username = "Anika12";
                    $password = "Anika12";
                    $dbname = "ems";
      
                    $conn = new mysqli($servername, $username, $password, $dbname);
      
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
      
                    $sql = "SELECT desg FROM dept";
                    $result = $conn->query($sql);
      
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="'.$row['desg'].'">' . $row['desg'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No data available</option>';
                    }
      
                    $conn->close();
                    ?>
                </select> -->
                </div>

                <button class="frame-child185"></button>
                <a class="search" style="margin-left: 10px;">Save</a>
            </form>
            <div style="display:flex; justify-content:center;overflow-y:auto;">
                <table class="data" style="margin-top: 400px;">
                    <tr>
                        <th>Manager</th>
                        <th>Depts</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM manager ORDER BY id DESC";
                    $que = mysqli_query($con, $sql);
                    while ($result = mysqli_fetch_assoc($que)) {
                    ?>
                        <tr>
                            <td><?php echo $result['empname']; ?></td>
                            <td><?php echo $result['desg']; ?></td>
                            <td>
                                <?php
                                if ($result['status'] == 1) {
                                    echo "Active";
                                } elseif ($result['status'] == 0) {
                                    echo "Inactive";
                                }
                                ?>
                            </td>
                            <td name="manager">
                                <form class="managerForm" data-id="<?php echo $result['id']; ?>" data-status="<?php echo $result['status']; ?>">
                                    <button type="button" class="actionBtn" style="">
                                        <?php echo ($result['status'] == 1) ? 'Remove as Manager' : 'Make as Manager'; ?>
                                    </button>
                                    <button type="button" class="actionBtn2" style="">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>


            </div>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
          
            <script>
               $(document).ready(function() {

var select = $('select[multiple]');
var options = select.find('option');

var div = $('<div />').addClass('selectMultiple');
var active = $('<div />');
var list = $('<ul />');
var placeholder = select.data('placeholder');

var span = $('<span />').text(placeholder).appendTo(active);

options.each(function() {
    var text = $(this).text();
    if($(this).is(':selected')) {
        active.append($('<a />').html('<em>' + text + '</em><i></i>'));
        span.addClass('hide');
    } else {
        list.append($('<li />').html(text));
    }
});

active.append($('<div />').addClass('arrow'));
div.append(active).append(list);

select.wrap(div);

$(document).on('click', '.selectMultiple ul li', function(e) {
    var select = $(this).parent().parent();
    var li = $(this);
    if(!select.hasClass('clicked')) {
        select.addClass('clicked');
        li.prev().addClass('beforeRemove');
        li.next().addClass('afterRemove');
        li.addClass('remove');
        var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
        a.slideDown(400, function() {
            setTimeout(function() {
                a.addClass('shown');
                select.children('div').children('span').addClass('hide');
                select.find('option:contains(' + li.text() + ')').prop('selected', true);
            }, 500);
        });
        setTimeout(function() {
            if(li.prev().is(':last-child')) {
                li.prev().removeClass('beforeRemove');
            }
            if(li.next().is(':first-child')) {
                li.next().removeClass('afterRemove');
            }
            setTimeout(function() {
                li.prev().removeClass('beforeRemove');
                li.next().removeClass('afterRemove');
            }, 200);

            li.slideUp(400, function() {
                li.remove();
                select.removeClass('clicked');
            });
        }, 600);
    }
});

$(document).on('click', '.selectMultiple > div a', function(e) {
    var select = $(this).parent().parent();
    var self = $(this);
    self.removeClass().addClass('remove');
    select.addClass('open');
    setTimeout(function() {
        self.addClass('disappear');
        setTimeout(function() {
            self.animate({
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }, 300, function() {
                var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
                li.slideDown(400, function() {
                    li.addClass('show');
                    setTimeout(function() {
                        select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
                        if(!select.find('option:selected').length) {
                            select.children('div').children('span').removeClass('hide');
                        }
                        li.removeClass();
                    }, 400);
                });
                self.remove();
            })
        }, 300);
    }, 400);
});

$(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
    $(this).parent().parent().toggleClass('open');
});

});
            </script>
            <script>
                $(document).ready(function() {
                    $(".actionBtn").click(function() {
                        var form = $(this).closest(".managerForm");
                        var id = form.data("id");
                        var status = form.data("status");

                        var actionText = (status == 1) ? 'no more a Manager' : 'as Manager';
                        var confirmText = (status == 1) ? 'Remove as Manager' : 'Make as Manager';

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This action will make this employee ' + actionText + '!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: confirmText,
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                toggleManagerStatus(id, status);
                            }
                        });
                    });

                    function toggleManagerStatus(id, status) {
                        $.ajax({
                            type: "POST",
                            url: "updatemanager.php",
                            data: {
                                toggleStatus: true,
                                id: id,
                                status: status
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = 'manager.php';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            </script>
            <script>
                $(document).ready(function() {
                    $("#updateForm").submit(function(e) {
                        e.preventDefault();
                        var empname = $("input[name='empname']").val();
                        var email = $("input[name='email']").val();
                        var desgs = $("select[name='desgs[]']").val();
                        var status = 1;

                        $.ajax({
                            type: "POST",
                            url: "mgr.php",
                            data: {
                                empname: empname,
                                email: email,
                                desgs: desgs,
                                status: status
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Manager added!',
                                    text: response,
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'manager.php';
                                    }
                                });
                                $("#updateForm")[0].reset();
                            }
                        });
                    });
                });
            </script>

            <script>
                function updateFields() {
                    var selectedEmployee = document.getElementById("employeeSelect");
                    var nameField = document.getElementById("employeeNameField");
                    var emailField = document.getElementById("employeeEmailField");

                    var selectedValue = selectedEmployee.options[selectedEmployee.selectedIndex].value;
                    var values = selectedValue.split("|");

                    nameField.value = values[0];
                    emailField.value = values[1];
                }
            </script>
            <script>
    $(document).ready(function() {
        $('#desgSelect').select2();
    });

</script>



            <script>
                var rectangleLink = document.getElementById("rectangleLink");
                if (rectangleLink) {
                    rectangleLink.addEventListener("click", function(e) {
                        window.location.href = "./attendence.php";
                    });
                }

                var rectangleLink2 = document.getElementById("rectangleLink2");
                if (rectangleLink2) {
                    rectangleLink2.addEventListener("click", function(e) {
                        window.location.href = "./punch-i-n.php";
                    });
                }

                var rectangleLink3 = document.getElementById("rectangleLink3");
                if (rectangleLink3) {
                    rectangleLink3.addEventListener("click", function(e) {
                        window.location.href = "./my-attendence.php";
                    });
                }

                var attendence = document.getElementById("attendence");
                if (attendence) {
                    attendence.addEventListener("click", function(e) {
                        window.location.href = "./attendence.php";
                    });
                }

                var punchINOUT = document.getElementById("punchINOUT");
                if (punchINOUT) {
                    punchINOUT.addEventListener("click", function(e) {
                        window.location.href = "./punch-i-n.php";
                    });
                }

                var myAttendence = document.getElementById("myAttendence");
                if (myAttendence) {
                    myAttendence.addEventListener("click", function(e) {
                        window.location.href = "./my-attendence.php";
                    });
                }

                var anikaHRM = document.getElementById("anikaHRM");
                if (anikaHRM) {
                    anikaHRM.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var attendenceManagement = document.getElementById("attendenceManagement");
                if (attendenceManagement) {
                    attendenceManagement.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var dashboard = document.getElementById("dashboard");
                if (dashboard) {
                    dashboard.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
                if (fluentpeople32Regular) {
                    fluentpeople32Regular.addEventListener("click", function(e) {
                        window.location.href = "./employee-management.php";
                    });
                }

                var employeeList = document.getElementById("employeeList");
                if (employeeList) {
                    employeeList.addEventListener("click", function(e) {
                        window.location.href = "./employee-management.php";
                    });
                }

                var akarIconsdashboard = document.getElementById("akarIconsdashboard");
                if (akarIconsdashboard) {
                    akarIconsdashboard.addEventListener("click", function(e) {
                        window.location.href = "./index.php";
                    });
                }

                var leaves = document.getElementById("leaves");
                if (leaves) {
                    leaves.addEventListener("click", function(e) {
                        window.location.href = "./leave-management.php";
                    });
                }

                var fluentpersonClock20Regular = document.getElementById(
                    "fluentpersonClock20Regular"
                );
                if (fluentpersonClock20Regular) {
                    fluentpersonClock20Regular.addEventListener("click", function(e) {
                        window.location.href = "./leave-management.php";
                    });
                }

                var onboarding = document.getElementById("onboarding");
                if (onboarding) {
                    onboarding.addEventListener("click", function(e) {
                        window.location.href = "./onboarding.php";
                    });
                }

                var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
                if (fluentMdl2leaveUser) {
                    fluentMdl2leaveUser.addEventListener("click", function(e) {
                        window.location.href = "./onboarding.php";
                    });
                }
            </script>
</body>

</html>
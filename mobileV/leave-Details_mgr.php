<?php
session_start();
@include '../inc/config.php';

if (empty($_SESSION['user_name']) && empty($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if (empty($user_name)) {
  header('location:loginpage.php');
  exit();
}


$query = "SELECT uf.*, m.status as manager_status 
              FROM user_form uf
              LEFT JOIN manager m ON uf.email = m.email 
              WHERE uf.email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type'])) {
    $user_type = $row['user_type'];

    if ($user_type !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
    if ($user_type === 'user' && empty($row['manager_status'])) {
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
<?php
$ID = $_GET['id'];
$query = mysqli_query($con, "SELECT l.*, e.pic FROM leaves l JOIN emp e ON l.empname = e.empname WHERE l.id='$ID'");
$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./empmobcss/globalop.css" />
    <link rel="stylesheet" href="./empmobcss/globalzxc.css" />
    <link rel="stylesheet" href="./empmobcss/mgr-emp-list-mob.css" />
    <link rel="stylesheet" href="./empmobcss/attendence-mob.css" />
    <link rel="stylesheet" href="./empmobcss/leave-details-mob.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .addin{
  border: 1px solid #FA840D;
  border-radius: 7px
}
      .remove{
        display: none;
      }
    </style>
  </head>
  <body>
    <div class="attendencemob"style="height: 100svh;">
        <div class="rectangle-group" style="height: 500px; overflow: hidden; margin-top: -50px;">
            <div class="rectangle-div"></div>
           <a class="leave-details">Leave Details</a>
            <img class="line-icon" alt="" src="./line-12@2x.png" />
        
            <img class="frame-child2" alt="" style="margin-top: 1px;" src="./line-14@2x.png" />
            <img class="frame-child2" alt="" style="margin-left: 319px; margin-top: 1px;" src="./line-14@2x.png" />
            <img class="frame-child2" alt="" style="margin-left: 115px; margin-top: 1px; height: 100px;" src="./line-14@2x.png" />
            <img class="frame-child2" alt="" style="margin-left: 157px; margin-top: 99px; height:66px;" src="./line-14@2x.png" />
            <img class="frame-child2" alt="" style="margin-left: 157px; margin-top: 275px; height:30px;" src="./line-14@2x.png" />
            
            <img class="frame-child4" alt="" src="./line-12@2x.png" />
        
            <img class="frame-child5" alt="" src="./line-12@2x.png" />
        
            <img class="frame-child6" alt="" src="./line-12@2x.png" />
        
            <img class="frame-child8a" style="margin-top: -55px;" alt="" src="./line-12@2x.png" />
            <img class="frame-child8a" alt="" src="./line-12@2x.png" />
        
            <img class="frame-child9" alt="" src="./line-12@2x.png" />
        
            <img class="frame-child10" alt="" style="height: 1px;" src="./line-12@2x.png" />
        
            <img class="frame-child11" alt="" src="./line-19@2x.png" />
        
            <img class="frame-child12" alt="" src="./line-19@2x.png" />
        
            <img class="frame-child13" alt="" src="./line-17@2x.png" />
        
            <img class="frame-child14" alt="" src="./line-22@2x.png" />
        
            <img class="frame-child15" alt="" src="./line-26@2x.png" />
        
            <img class="ellipse-icon" alt="" src="../pics/<?php echo $row['pic']; ?>" />
        
            <!--<img-->
            <!--  class="material-symbolsperson-icon1"-->
            <!--  alt=""-->
            <!--  src="../pics/<?php echo $row['pic']; ?>"-->
            <!--/>-->
        
            <div class="employee-name">Employee Name:</div>
            <div class="email-id">Email Id:</div>
            <div class="phone-number">Phone Number:</div>
            <div class="leave-from">Leave From:</div>
            <div class="leave-applied">Leave Applied:</div>
            <div class="leave-reason">Leave Reason:</div>
      
            <div class="leave-to">Leave To:</div>
            <div class="status">Status:</div>
            <p class="mohan-reddy" style="font-size:11px; margin-top:2px; width:140px;"><?php
                                            $empname = $row['empname'];
                                                echo strlen($empname) > 15 ? substr($empname, 0, 15) . '...' : $empname;
                                                ?></p>
        
            <p
              class="naradamohan1gmailcom"><?php
                                            $empname = $row['empemail'];
                                                echo strlen($empname) > 21 ? substr($empname, 0, 21) . '...' : $empname;
                                                ?></p>

            <p class="input"><?php echo $row['empph']; ?></p>
            <?php
        $leavetype2 =  $row['leavetype2'];

       if ($leavetype2 === 'FN' || $leavetype2 === 'AN') {
    echo '<p class="input1" style="font-size:9px; margin-top:3px;">' . date('Y-m-d H:i', strtotime($row['from'])) . '</p>';
    echo '<p class="input3" style="font-size:9px; margin-top:3px;">' . date('Y-m-d H:i', strtotime($row['to'])) . '</p>';
}
 else {
          echo '<p class="input1">' . date('Y-m-d', strtotime($row['from'])) . '</p>';
          echo '<p class="input3">' . date('Y-m-d', strtotime($row['to'])) . '</p>';
        }
        ?>

            <p class="input2" id="ghjk"><?php echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($row['applied']))); ?></p>
        
            <textarea name="" class="fever" id="qwer" cols="30" rows="10" readonly><?php echo $row['reason']; ?></textarea>
            <?php
        if (!is_null($row['hrremark'])) {
        ?>
                <div class="hr-remarks">HR Remarks:</div>
          <textarea cols="30" rows="10"  class="fever2"  readonly id="qwer"><?php echo $row['hrremark']; ?></textarea>

        <?php
        }
        ?>
              <?php
      $status = $row['status'];
      $status1 = $row['status1'];
      ?>
   <p class="approved" style="scale:0.8; margin-top:-5px;">
   <?php
    if ($status == '2' && $status1 == '0') {
      echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
      Rejected
      </span>';
    } elseif ($status == '2' && $status1 == '1') {
      echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
      Approver Rejected
      </span>';
    } elseif (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
      echo '<span class=\'bg-green-100 text-green-800 text-xs font-medium inline-flex items-center me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#417505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
    Approved
      </span>';
    } elseif ($status == '0' && $status1 == '0') {
      echo '<span style="scale:0.8;margin-left:-20px; white-space:nowrap;" class=\'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-red-400 border border-red-400\'>
      <svg xmlns=\'http://www.w3.org/2000/svg\' width=\'22\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#fb0b0b\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'>
          <path d=\'M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z\'></path>
          <line x1=\'12\' y1=\'9\' x2=\'12\' y2=\'13\'></line>
          <line x1=\'12\' y1=\'17\' x2=\'12.01\' y2=\'17\'></line>
      </svg>
      HR-Action Pending
      </span>';
    }elseif ($status == '4' && $status1 == '0') {
      echo '<span style="scale:0.8;margin-left:-30px; white-space:nowrap;" class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Manager
      </span>';
  }elseif ($status == '3' && $status1 == '0') {
      echo '<span  style="scale:0.8;margin-left:-30px; white-space:nowrap;" class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Approver
      </span>';
  }
    ?></p>

<?php
      if ($row['status1'] == 1 || $row['status'] == 2 || ($row['status1'] == 0 &&  $row['status'] == 1)) {
      ?>
         <div class="approver">Approver:</div>
         <?php
        if (!empty($row['aprname'])) {
        ?>
          <p class="prabhdeep-singh"><?php
                                            $empname = $row['aprname'];
                                                echo strlen($empname) > 10 ? substr($empname, 0, 10) . '...' : $empname;
                                                ?></p>
        <?php
        } else {
        ?>
          <p class="prabhdeep-singh"><?php
                                            $empname = $row['mgrname'];
                                                echo strlen($empname) > 10 ? substr($empname, 0, 10) . '...' : $empname;
                                                ?></p>
        <?php
        }
        ?>
            <div class="approver-action-on">Action Perfomed at:</div>
            <?php
        if (!is_null($row['aprtime'])) {
        ?>
          <p class="input4" style="font-size:10px; margin-top:-6px;">
            <?php echo date('d-m-Y H:i:s', strtotime('+5 hours +30 minutes', strtotime($row['aprtime']))); ?>
          </p>
        <?php
        } else if (!is_null($row['mgrtime'])) {
        ?>
          <p class="input4" style="font-size:10px; margin-top:-6px;">
            <?php echo date('d-m-Y H:i:s', strtotime('+5 hours +30 minutes', strtotime($row['mgrtime']))); ?>
          </p>
        <?php
        } else {
        ?>
          <p class="input4" style="font-size:10px; margin-top:-6px;" >Action Pending</p>
        <?php
        }
        ?>
          <?php
        if ($row['status'] == "2" && ($row['aprremark'] != "" || $row['mgrremark'] != "")) {
        ?>
            <div class="rejection-reason">Rejection Reason:</div>
            <p class="fever4" style="margin-top:15px;"> <?php echo $row['aprremark']; ?> <?php echo $row['mgrremark']; ?></p>
            <?php
        }
        ?>
            <?php
      } else {
      }
      ?>
            <?php if (($status1 == '0' && $status == '4')) : ?>
        <button class="rectangle-button" id="modalOpen" style="color: white; text-align: center;">Set Action</button>
         <?php endif; ?>
            <div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="theModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Set Action</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <label style="font-size: 17px;" for="approve">Perform Action</label><br>
                      <form id="updateForm" data-id="<?php echo $ID; ?>">
                      <select name="status" id="approve" onchange="approveFunc();" style="border-radius: 5px; font-size: 17px; width: 300px; height: 40px;">
                  <option selected disabled value="">--Choose--</option>
                  <option value="1" id="qwsx">Approve</option>
                  <option value="2">Reject</option>
                </select><br id="qwsa" class="remove">
                      <label id="mnb" class="remove" style="font-size: 17px;" for="approve">Remarks</label><br>
                      <textarea class="remove" name="mgrremark" id="mnbv" style="border-radius: 5px;" cols="39" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-warning" id="modalClose">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
           
          </div>
      <div class="logo-1-parent10">
        <img class="logo-1-icon12" alt="" src="./public/logo-1@2x.png" />

        <a class="attendance-management1" style="width: 300px;" id="attendanceManagement"
          >Leave Management</a
        >
      </div>
      <div class="frame-container" style="z-index: 999999;" >
        <a href="employee-management_mgr.php"><img class="frame-child7" alt="" src="./public/frame-156.svg" /></a>

        <a class="uitcalender2" href="attendence_mgr.php">
          <img class="vector-icon6" alt="" src="./public/vectoratten.svg" />
        </a>
        <div class="frame-child8"></div>
        <a class="akar-iconsdashboard2" href="dash_mgr.php">
          <img class="vector-icon7" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="fluentperson-clock-20-regular2" href="leave-management_mgr.php">
          <img
            class="vector-icon8"
            alt=""
            src="./public/vector3leaveblack.svg"
          />
        </a>
      </div>
      <div class="attendencemob-child"></div>
     
    

  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js'></script><script>
  $(document).ready(function() {
    $("#modalOpen").click(function() {
      $("#theModal").modal("show");
    });

    $("#updateForm").submit(function(event) {
      event.preventDefault();

      var formData = $(this).serialize();

      var id = $(this).data('id');
      formData += '&id=' + id;

      Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        type: "POST",
        url: "../update_leaves_mgr.php",
        data: formData,
        dataType: "json",
        success: function(response) {
          Swal.close();

          if (response.success) {
            console.log(response); 
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
            }).then(function() {
              $("#theModal").modal("hide");
              window.location.href = 'leave-management_mgr.php';
            });
          } else {
            Swal.fire({
              
              icon: 'error',
              title: 'Error',
              text: 'Error updating leave record: ' + response.message,
            });
          }
        },
        error: function(xhr, status, error) {
          
          Swal.close();

          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error updating leave record. Please try again. Status: ' + status + ', Error: ' + error,
          });
          console.error('AJAX request failed. Response:', xhr.responseText);
        }
      });
    });

    $("#modalClose").click(function() {
      $("#theModal").modal("hide");
    });
  });

</script>
  <script>
   
    $(document).ready(function () {

$("#modalOpen").click(function () {
  $("#theModal").modal("show");
});

$("#modalClose").click(function () {
  $("#theModal").modal("hide");
});

});
function approveFunc() {
    var dropdown1 = document.getElementById('approve');

    if (dropdown1.value === '2') {
      document.getElementById('mnb').classList.remove('remove');
      document.getElementById('mnbv').classList.remove('remove');
      document.getElementById('qwsx').classList.add('remove');
  }
}
  </script>
      </html>


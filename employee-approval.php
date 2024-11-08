<!DOCTYPE html>
<?php

@include 'inc/config.php';

	$ID=$_GET['id'];
	$query=mysqli_query($con,"select * from `onb` where id='$ID'");
	$row=mysqli_fetch_array($query);
?>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global4.css" />
    <link rel="stylesheet" href="./css/employee-approval.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script>
	$(document).ready(function(e){
		$("#frm").on('submit', function(e){
			e.preventDefault();
			
			// Show loading animation
			Swal.fire({
				title: 'Processing...',
				text: 'Please wait',
				icon: 'info',
				allowOutsideClick: false,
				showConfirmButton: false,
				onBeforeOpen: () => {
					Swal.showLoading();
				}
			});

			$.ajax({
				type: 'POST',
				url: 'upload1.php',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					$('.submitBtn').attr("disabled","disabled");
					$('#frm').css("opacity",".5");
				},
				success: function(msg){
					Swal.close(); // Close loading animation

					$('.statusMsg').php('');
					if(msg == 'ok'){
						$('#frm')[0].reset();
						Swal.fire({
							icon: 'success',
							title: 'Employee Added Successfully',
						}).then(function() {
							window.location = 'employee-management.php';
						});
					}else{
						$('.statusMsg').php('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
					}
					$('#frm').css("opacity","");
					$(".submitBtn").removeAttr("disabled");
				}
			});
		});

		//file type validation
		$("#pdfFile").change(function() {
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["application/pdf","image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
				alert('Please select a valid pdf file .');
				$("#pdfFile").val('');
				return false;
			}
		});
	});
</script>
<script>
  $(document).ready(function(e){
    $("#frm").on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: 'update1.php?id=<?php echo $ID; ?>',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
          $('.submitBtn').attr("disabled","disabled");
          $('#frm').css("opacity",".5");
        },
        success: function(msg){
          console.log(msg);
          $('.statusMsg').html(''); // Corrected line
          if(msg == 'ok'){
            $('#frm')[0].reset();
            Swal.fire({
  type: "success",
  title: "Employee Added Successfully",
}).then(function() {
  window.location = "employee-management.php";
});
          } else {
            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
          }
          $('#frm').css("opacity","");
          $(".submitBtn").removeAttr("disabled");
        }
      });
    });
  });
</script>


      <script>
  $(document).ready(function (e) {
    // Generate a unique employee ID when the page loads
    function generateEmployeeID() {
        var prefix = 'ASPL';

        // You need to implement the getLastEmployeeIDFromDB function using AJAX to call a server-side PHP script
        var lastEmployeeID = getLastEmployeeIDFromDB();

        // Extract the number part
        var lastNumber = parseInt(lastEmployeeID.substring(8));

        // Check if lastNumber is a valid number
        if (!isNaN(lastNumber)) {
            // Increment the last number by 1
            var newNumber = lastNumber + 1;
        } else {
            // If lastNumber is not a valid number, set it to 1
            var newNumber = 1;
        }

        // Get the current date
        var today = new Date();
        var date = today.getFullYear() + ('0' + (today.getMonth() + 1)).slice(-2) + ('0' + today.getDate()).slice(-2);

        // Format the new employee ID with prefix, date, and incremented number
        var newEmployeeID = prefix + date + ('0000' + newNumber).slice(-4);

        return newEmployeeID;
    }

    // Function to get the last stored employee ID from the server using AJAX
    function getLastEmployeeIDFromDB() {
        var lastEmployeeID = '';

        // Implement AJAX call here to get the last employee ID from the server
        $.ajax({
            type: 'GET',  // Change the method based on your server-side implementation
            url: 'get_last_employee_id.php',  // Replace with the actual server-side script
            async: false,  // Make the call synchronous to wait for the response
            success: function (response) {
                lastEmployeeID = response;
            }
        });

        return lastEmployeeID;
    }

    // Set default value for Employee ID when the form page is loaded
    $('#empid').val(generateEmployeeID());

    function generateUniqueId() {
        // Logic to generate a unique ID, for example, a timestamp
        var timestamp = new Date().getTime();
        return 'EMP' + timestamp;
    }
});

  </script>
    <style>
     
      .addin{
  border: 1px solid #FA840D;
  border-radius: 7px
}
      .remove{
        display: none;
      }
      .instyle{
        border: 2px solid rgb(177, 177, 177);
        border-radius: 20px;
      }
      .avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 50px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
    </style>
  </head>
  <body>
    <div class="employeeapproval">
      <section class="bg1"></section>
  
      <section class="employeeapproval-item"></section>
      <img
        class="employeeapproval-inner"
        alt=""
        src="./public/rectangle-2@2x.png"
      />

      <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm1" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm1">HRM</span>
      </a>
      <a class="onboarding1" href="./index.php" id="onboarding">Onboarding</a>
      <a class="onboarding1 remove" href="./index.php" style="margin-left: 215px; margin-top: 2px;" id="onboarding123">/Edit Info</a>
      <button class="employeeapproval-child1"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
      <a class="attendance1" href="./attendence.php" id="attendance">Attendance</a>
      <div class="payroll1">Payroll</div>
      <div class="reports1">Reports</div>
      <img class="uitcalender-icon1" alt="" src="./public/uitcalender.svg" />
     
      <img
        class="arcticonsgoogle-pay1"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />
 
      <img
        class="streamlineinterface-content-c-icon1"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img-->
      <!--  class="employeeapproval-child2"-->
      <!--  alt=""-->
      <!--  src="./public/ellipse-1@2x.png"-->
      <!--/>-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon1"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img
        class="employeeapproval-child3"
        alt=""
        src="./public/rectangle-4@2x.png"
      />

      <a class="dashboard1" href="./index.php" id="dashboard">Dashboard</a>
      <a class="fluentpeople-32-regular1" id="fluentpeople32Regular">
        <img class="vector-icon7" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list1" href="./employee-management.php" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard1"
        href="./index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon8" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon1" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender1" id="uitcalender">
        <img class="vector-icon9" alt="" src="./public/vector4.svg" />
      </a>
      <a class="leaves1" href="./leave-management.php" id="leaves">Leaves</a>
      <a class="fluentperson-clock-20-regular1" id="fluentpersonClock20Regular">
        <img class="vector-icon10" alt="" src="./public/vector1.svg" />
      </a>
      <a class="onboarding2" href="./onboarding.php" id="onboarding1">Onboarding</a>
      <a class="fluent-mdl2leave-user1" id="fluentMdl2leaveUser">
        <img class="vector-icon11" alt="" src="./public/vector8.svg" />
      </a>
        <div>
          <img style="margin-top:-20px;"
          class="employeeapproval-child"
          alt=""
          src="./public/rectangle-22@2x.png"
        />
    
        <form id='frm'>
          <input type="hidden" id="purpose" name="purpose" value="for confirmation of employement details and creation of emp login.">

        <input style="margin-top:-20px;" class="single" name="ms" value="<?php echo $row['empms']; ?>" type="text" readonly="readonly"
        />
    
        <input style="margin-top:-20px; width:310px;"
          class="naradamohan1gmailcom1"
          name="email"
          id='email'
          value="<?php echo $row['empemail']; ?>"
          type="text"
          defaultvalue="naradamohan1@gmail.com"
          readonly="readonly"
        />
    
        <input style="margin-top:-20px;"
          class="input"
          name="mobile"
          value="<?php echo $row['empph']; ?>"
          type="text"
          defaultvalue="9885852424"
          readonly="readonly"
        />
    
        <input style="margin-top:-20px;"
          class="input1"
          value="<?php  $orgDate = $row['empdob']; $newDate = date("d-m-Y", strtotime($orgDate));   echo $newDate;  ?>"
          type="text"
          defaultvalue="17/06/2002"
          readonly="readonly"
        />
        <input style="margin-top:-20px; display:none;"
          class="input1"
          name="dob"
          value="<?php echo $row['empdob']; ?>"
          type="date"
          readonly="readonly"
        />
    
        <p style="margin-top:-20px;" class="date-of-birth">Date of Birth:</p>
        <p style="margin-top:-20px;" class="phone-number">Phone Number:</p>
        <p style="margin-top:-20px;" class="email-id">Email id:</p>
        <p style="margin-top:-20px;" class="marital-status">Marital Status:</p>
        <p style="margin-top:-20px;" class="gender">Gender:</p>
        <input style="margin-top:-20px;" class="male" name="gen" value="<?php echo $row['empgen']; ?>" type="text" defaultvalue="Male"  readonly="readonly"
       />

        <input style="margin-top:-63px; font-weight: 300; width: 235px;font-size:20px;" placeholder="enter emp id" class="web-developer1" id="empid" name="empid" type="text" defaultvalue="1902"/>
        <input style="margin-top:-60px; text-align: center; width: 180px; font-size:20px;"
          class="mohan-reddy1"
          name="name"
          value="<?php echo htmlspecialchars($row['empname'] ?? ''); ?>"
          type="hidden"
          readonly="readonly"
        />
        <p style="margin-top:-75px; text-align: center; width: 250px; font-size:20px;margin-left:-30px;"
          class="mohan-reddy1">
             <?php echo htmlspecialchars($row['empname'] ?? ''); ?>
            
        </p>
        <select style="margin-top:-20px;font-size:20px;"
        id="designation"
          class="web-developer1"
          name="desg"
        >
        <?php

$sql1 = "SELECT desg FROM dept";
$result = $con->query($sql1);

echo'<option>--select--</option>';
if ($result->num_rows > 0) {
    while($row1 = $result->fetch_assoc()) {
        echo '<option style="font-size:20px;" value="' . $row1['desg'] . '">' . $row1['desg'] . '</option>';
    }
} else {
    echo '<option value="">No data available</option>';
}
?>
      </select>
    
        <input type="text" style="display:none;" value="<?php  echo $row['pic'];?>" name="file1">
        <div class="avatar-upload" style="margin-top: 130px; margin-left: 456px;">
          <div class="avatar-edit remove" id="avatarEdit">
              <input type='file' name="file1" value="pics/<?php  echo $row['pic'];?>" id="imageUpload" />
              <label for="imageUpload"></label>
          </div>
          <div class="avatar-preview">
          <div id="imagePreview" style="background-image: url(pics/<?php echo rawurlencode($row['pic']); ?>);">


              </div>
          </div>
      </div>
      <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
      <input type="hidden" name="status" value="1">


        <h3 style="margin-top:-20px;" class="personal-info">Personal info</h3>
          <img style="margin-top:-20px;"
            class="employeeapproval-child4"
            alt=""
            src="./public/rectangle-53@2x.png"
          />
          <select style="margin-top:-45px; margin-left: -10px;" class="input2" id="asdf"  name="dept"  disabled="disabled"/>
          
           <?php

$sql1 = "SELECT DISTINCT dept FROM emp WHERE dept IS NOT NULL AND dept <> ''";
$result = $con->query($sql1);

echo'<option>--select--</option>';
if ($result->num_rows > 0) {
    while($row1 = $result->fetch_assoc()) {
        echo '<option style="font-size:20px;" value="' . $row1['dept'] . '">' . $row1['dept'] . '</option>';
    }
} else {
    echo '<option value="">No data available</option>';
}
?>
</select>
    
          <img 
            class="employeeapproval-child5"
            alt="" style="margin-left: 12px; margin-top: -34px;"
            src="./public/rectangle-54@2x.png"
          />
    
          <input style="margin-top:-20px;"
            class="union-bank-of"
            value="<?php echo $row['bn']; ?>"
            name="bn"
            type="text"
            defaultvalue="Union Bank of India"
            readonly="readonly"
          />
    
          <input style="margin-top:-20px;"
            class="ubin39723"
            name="ifsc"
            value="<?php echo $row['ifsc']; ?>"
            type="text"
            defaultvalue="UBIN39723"
            readonly="readonly"
          />
    
          <input style="margin-top:-20px;"
            class="input3"
            name="ban"
            value="<?php echo $row['ban']; ?>"
            type="text"
            defaultvalue="3947284762543254"
            readonly="readonly"
          />
    
          <input style="margin-top:-20px;"
            class="input4"
            name="adn"
            value="<?php echo $row['adn']; ?>"
            type="text"
            defaultvalue="39472947294"
            readonly="readonly"
          />
    
          <input style="margin-top:-20px;"
            class="kdiry3947h"
            name="pan"
            value="<?php echo $row['pan']; ?>"
            type="text"
            defaultvalue="KDIRY3947H"
            readonly="readonly"
          />
    
          <img style="margin-top:-20px;"
            class="employeeapproval-child6"
            alt="" 
            src="./public/rectangle-54@2x.png"
          />
    
          <h3 style="margin-top:-20px;" class="document-view">Document Upload</h3>
          <p style="margin-top:-45px;" class="employee-id">Department:</p>
          <p style="margin-top:-20px;" class="pan">PAN:</p>
          <p style="margin-top:-45px;" class="date-of-joining">Date of Joining:</p>
          <input style="margin-top:-45px;"
            class="input5"
            id="sdfg"
            name="doj"
            type="date"
            defaultvalue="24/11/2022"
            disabled="disabled"
          />
          <p style="margin-top:-20px;" class="aadhaar">Aadhaar:</p>
          <p style="margin-top:-45px;" class="reporting-manager">Reporting Manager:</p>
          <!-- <input style="margin-top:-45px;"
            class="prabhdeep-singh-maan"
            id="dfgh"
            name="rm"
            type="text"
            defaultvalue="Prabhdeep Singh Maan"
            disabled="disabled"
          /> -->
          <input list="rmOptions" id="dfgh" name="rm" style="margin-top:-45px;font-size:15px;height:25px;" class="prabhdeep-singh-maan" >
  <datalist id="rmOptions">
    <option value="Prabhdeep Singh Maan">
  </datalist>
    
          <p style="margin-top:-20px;" class="account-number">Account Number:</p>
          <p style="margin-top:-45px;" class="employment-status">Employment Type:</p>
          <input style="margin-top:-45px; margin-left: -22px;" class="active" id="fghj" name="emptype" type="text" defaultvalue="Active" disabled="disabled"/>

          <p style="margin-top:-20px;" class="ifsc-code">IFSC Code:</p>
          <p style="margin-top:-45px;" class="department">Gross Salary(per month):</p>
          <input style="margin-top:-50px;margin-left: 105px;  font-size:20px;width:5%;" class="it" id="ghjk" name="salary" type="text" defaultvalue="25000" disabled="disabled"/>
    
          <p style="margin-top:-20px;" class="bank-name">Bank Name:</p>
          <p style="margin-top:-45px;" class="employment-type">Work Location:</p>
          <select style="margin-top:-50px; margin-left: -40px;  font-size:20px;"
            class="permanent"
            id="hjkl"
            name="work_location"
            type="text">
            <?php

    $sql2 = "SELECT city FROM workLocation";
    $result = $con->query($sql2);

    echo'<option>--select--</option>';
    if ($result->num_rows > 0) {
        while($row2 = $result->fetch_assoc()) {
            echo '<option value="' . $row2['city'] . '">' . $row2['city'] . '</option>';
        }
    } else {
        echo '<option value="">No data available</option>';
    }
  ?>
          </select>
    
          <!-- <p style="margin-top:-45px;" class="salary">EPF:</p>
          <input style="margin-top:-45px; margin-left: -25px;" class="input6" id="qwer" name="sald1" type="text" defaultvalue="1200" disabled="disabled"/>
          <p style="margin-top:-8px;" class="salary">ESI:</p>
          <input style="margin-top:-8px; margin-left: -25px;" class="input6" id="wert" name="sald" type="text" defaultvalue="100" disabled="disabled"/>
     -->
          <h3 style="margin-top:-40px;" class="employment-info">Employment Info</h3>
          <h3 style="margin-top:-20px;" class="identity-info">Identity Info</h3>
          <a style="margin-top:-20px;" class="documentspdf innerstyle" id="fileName" >No files Selected</a>
          <div style="margin-top:-20px;" class="rectangle-div"></div>
          <img style="margin-top:-20px;"
            class="mdifolder-upload-icon innerstyle"
            id="docimg"
            alt=""
            src="./public/mdifolderupload.svg"
          />
    
          <span style="margin-top:10px;" id="upbtn" onclick="document.getElementById('fileInput').click();"  class="employeeapproval-child7 remove"></span>
          <a style="margin-top:10px; margin-left: 11px; cursor: pointer;" onclick="document.getElementById('fileInput').click();"  id="uptxt" class="view-file remove ">Upload</a>
          <input type="file" id="fileInput" class="remove" name="file" accept=".pdf" onchange="displayFileName()">
          <!-- <span class="akar-iconsedit" id="akarIconsedit"> -->
            <img style="margin-top:-40px; margin-left: 500px;" class="group-icon akar-iconsedit"  onclick="editFunction();" alt="" src="./public/group.svg" />
            <!-- <img style="margin-top:10px; margin-left: -620px; " class="group-icon akar-iconsedit remove"  onclick="document.getElementById('infile').click();"  id="editImage" alt="" src="./public/group.svg" /> -->
            <input type="file" style="display: none;" id="infile">
          <!-- </span> --> 
        </div>
      <button type="submit" style="margin-top: 130px; margin-left: 150px; color:white; font-size:25px;" class="employeeapproval-child7 submitBtn remove" id="updatebtn">Update</button>
      <span type="submit" onclick="location.reload();" style="margin-top: 130px; background: rgb(255, 92, 92); margin-left: -20px;" class="employeeapproval-child7 remove" id="cancelbtn"></span>
      <a onclick="location.reload();" style="margin-top: 130px; margin-left: -10px; cursor: pointer;" class="view-file remove" id="canceltxt">Cancel</a>
    </div>
   
  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
<script>
  // Get the current date
  const currentDate = new Date();

  // Calculate the last day of the next month
  const nextMonth = new Date(currentDate);
  nextMonth.setMonth(currentDate.getMonth() + 2);
  nextMonth.setDate(0); // Set to the last day of the current month

  // Format the date as "YYYY-MM-DD" for the max attribute
  const maxDate = nextMonth.toISOString().split('T')[0];

  // Set the max attribute of the input element
  document.getElementById('sdfg').setAttribute('max', maxDate);
</script>
<script>
 function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
        $('#imagePreview').hide();
        $('#imagePreview').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
}
}
$("#imageUpload").change(function() {
readURL(this);
});

</script>
<script>
        $(document).ready(function(){
            $('#frm').submit(function(event){
                event.preventDefault();
                var recipientEmail = $('#email').val();
                var purpose = $('#purpose').val();

                $.ajax({
                    type: 'POST',
                    url: 'mail.php',
                    data: { recipientEmail: recipientEmail,purpose: purpose },
                    success: function(response){
                        $('#response').php(response);
                    }
                });
            });
        });
    </script>
  
      <script>
        var anikaHRM = document.getElementById("anikaHRM");
        if (anikaHRM) {
          anikaHRM.addEventListener("click", function (e) {
            window.location.href = "./index.php";
          });
        }
        
        var onboarding = document.getElementById("onboarding");
        if (onboarding) {
          onboarding.addEventListener("click", function (e) {
            window.location.href = "./index.php";
          });
        }
        
        var attendance = document.getElementById("attendance");
        if (attendance) {
          attendance.addEventListener("click", function (e) {
            window.location.href = "./attendence.php";
          });
        }
        
        var dashboard = document.getElementById("dashboard");
        if (dashboard) {
          dashboard.addEventListener("click", function (e) {
            window.location.href = "./index.php";
          });
        }
        
        var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
        if (fluentpeople32Regular) {
          fluentpeople32Regular.addEventListener("click", function (e) {
            window.location.href = "./employee-management.php";
          });
        }
        
        var employeeList = document.getElementById("employeeList");
        if (employeeList) {
          employeeList.addEventListener("click", function (e) {
            window.location.href = "./employee-management.php";
          });
        }
        
        var akarIconsdashboard = document.getElementById("akarIconsdashboard");
        if (akarIconsdashboard) {
          akarIconsdashboard.addEventListener("click", function (e) {
            window.location.href = "./index.php";
          });
        }
        
        var uitcalender = document.getElementById("uitcalender");
        if (uitcalender) {
          uitcalender.addEventListener("click", function (e) {
            window.location.href = "./attendence.php";
          });
        }
        
        var leaves = document.getElementById("leaves");
        if (leaves) {
          leaves.addEventListener("click", function (e) {
            window.location.href = "./leave-management.php";
          });
        }
        
        var fluentpersonClock20Regular = document.getElementById(
          "fluentpersonClock20Regular"
        );
        if (fluentpersonClock20Regular) {
          fluentpersonClock20Regular.addEventListener("click", function (e) {
            window.location.href = "./leave-management.php";
          });
        }
        
        var onboarding1 = document.getElementById("onboarding1");
        if (onboarding1) {
          onboarding1.addEventListener("click", function (e) {
            window.location.href = "./onboarding.php";
          });
        }
        
        var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
        if (fluentMdl2leaveUser) {
          fluentMdl2leaveUser.addEventListener("click", function (e) {
            window.location.href = "./onboarding.php";
          });
        }
        
        var akarIconsedit = document.getElementById("akarIconsedit");
        if (akarIconsedit) {
          akarIconsedit.addEventListener("click", function (e) {
            window.location.href = "./employee-approval.php";
          });
        }
        function editFunction(){
          document.getElementById('onboarding123').classList.remove('remove');
          document.getElementById('updatebtn').classList.remove('remove');
          document.getElementById('cancelbtn').classList.remove('remove');
          document.getElementById('canceltxt').classList.remove('remove');
          // document.getElementById('avatarEdit').classList.remove('remove');
          document.getElementById('asdf').classList.add('addin');
          document.getElementById('sdfg').classList.add('addin');
          document.getElementById('dfgh').classList.add('addin');
          document.getElementById('fghj').classList.add('addin');
          document.getElementById('ghjk').classList.add('addin');
          document.getElementById('hjkl').classList.add('addin');
          // document.getElementById('qwer').classList.add('addin');
          // document.getElementById('wert').classList.add('addin');
          document.getElementById('designation').classList.add('addin');
          document.getElementById('empid').classList.add('addin');
          document.getElementById('asdf').removeAttribute('disabled');
          document.getElementById('sdfg').removeAttribute('disabled');
          document.getElementById('dfgh').removeAttribute('disabled');
          document.getElementById('fghj').removeAttribute('disabled');
          document.getElementById('ghjk').removeAttribute('disabled');
          document.getElementById('hjkl').removeAttribute('disabled');
          // document.getElementById('qwer').removeAttribute('disabled');
          // document.getElementById('wert').removeAttribute('disabled');
          document.getElementById('uptxt').classList.remove('remove');
          document.getElementById('upbtn').classList.remove('remove');
          document.getElementById('designation').removeAttribute('disabled');
          document.getElementById('empid').removeAttribute('disabled');
        }
        function displayFileName() {
      var fileInput = document.getElementById('fileInput');
      var fileNameDisplay = document.getElementById('fileName');

      if (fileInput.files.length > 0) {
        fileNameDisplay.innerHTML =  fileInput.files[0].name;
      } else {
        fileNameDisplay.textContent = 'No file selected';
      }
    }
        </script>
</html>

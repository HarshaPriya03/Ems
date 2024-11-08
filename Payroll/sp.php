<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../loginpage.php");
    exit();
}

// Connect to MySQL
@include '../inc/config.php';
$currentDate = date("Y-m-d");
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module ID for the payroll module
$sql_payroll_module = "SELECT id FROM modules WHERE module_name = 'payroll'";
$result_payroll_module = mysqli_query($con, $sql_payroll_module);
$payroll_module = mysqli_fetch_assoc($result_payroll_module);

// Retrieve the logged-in user's email
$email = $_SESSION['email'];

// Check if the logged-in user has access to the payroll module
$sql_check_access = "SELECT COUNT(*) AS count FROM user_modules WHERE email = '$email' AND module_id = " . $payroll_module['id'];
$result_check_access = mysqli_query($con, $sql_check_access);
$row_check_access = mysqli_fetch_assoc($result_check_access);

if ($row_check_access['count'] == 0) {
    // If the user doesn't have access to the payroll module, redirect them to the dashboard or display an error message
    header("Location: ../loginpage.php");
    exit();
}

$query = "SELECT DISTINCT service_provider FROM emp WHERE service_provider IS NOT NULL AND service_provider != ''";
$result = mysqli_query($con, $query) or die(mysqli_error($con));
$serviceProviders = array();
while ($row = mysqli_fetch_assoc($result)) {
    $serviceProviders[] = $row['service_provider'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .rectangle-div {
            position: absolute;
            border-radius: 10px;
            background-color: #ffffff;
            width: 250px;
            height: 40px;
            border: 1px solid rgb(185, 185, 185);
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
        }

        .hovpic {
            transition: all 0.5s ease-in-out;
            z-index: 1000 !important;
        }


        .hovpic:hover {
            transform: scale(5, 5);
        }
    </style>

</head>

<body>
    <div class="attendence4">
        <div class="bg14"></div>
        <div class="rectangle-parent23" style="height: 60vh;overflow-y: auto;display:block; margin-top:-40px;">


            <table id="serviceTableBody" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800" style="position:sticky; top:0;">
                <td colspan="10">
                    <div class="px-1 py-2 flex items-center">
                        <select style="border-radius:5px;" id="service_provider">
                            <option value="">Select Service Provider</option>
                            <?php foreach ($serviceProviders as $provider) : ?>
                                <option value="<?php echo htmlspecialchars($provider, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($provider, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="col" class="px-6 py-3">Employee Name</th>
                <th scope="col" class="px-6 py-3">CTC</th>
                <th scope="col" class="px-6 py-3">Service Provider</th>
                <th scope="col" class="px-6 py-3">Service Fee %</th>
                <th scope="col" class="px-6 py-3">Service Fee</th>
            </tr>
        </thead>
        <?php

$sql = "SELECT * from payroll_sp ";

$result = mysqli_query($con, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tbody style="text-align: center;">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">
                <?php echo $row['empname']; ?>
            </td>
            <td class="px-6 py-4">
                <?php echo $row['ctc']; ?>
            </td>
            <td class="px-6 py-4">
                <?php echo $row['service_provider']; ?>
            </td>
            <td class="px-6 py-4">
            <?php echo $row['sfper']; ?>
            </td>
            <td class="px-6 py-4">
            <?php echo $row['sfee']; ?>
            </td>
        </tr>
        </tbody>
        <?php
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
    </table>

        </div>
        <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

        <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />
        <a class="anikahrm14" href="./index.html" id="anikaHRM">
            <span>Anika</span>
            <span class="hrm14">HRM</span>
        </a>
        <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
        <button class="attendence-inner"></button>
        <div class="logout14">Logout</div>
        <a class="payroll14" href="./payroll.php" style="color: white; z-index:9999;">Payroll</a>
        <div class="reports14">Reports</div>
        <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

        <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



        <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

        <a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
            <img class="vector-icon73" alt="" src="./public/vector7.svg" />
        </a>
        <a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>
        <a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">
            <img class="vector-icon74" alt="" src="./public/vector3.svg" />
        </a>
        <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="./public/tablerlogout.svg" />

        <a class="leaves14" id="leaves" style="z-index: 99999;" href="../leave-management.php">Leaves</a>
        <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
            <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
        </a>
        <a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>
        <a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">
            <img class="vector-icon76" alt="" src="./public/vector.svg" />
        </a>
        <a class="attendance14" href="../attendence.php" style="color: black; z-index: 99999;">Attendance</a>
        <a class="uitcalender14">
            <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="./public/vector11.svg" />
        </a>
        <div class="oouinext-ltr3"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('#service_provider').change(function() {
                var serviceProvider = $(this).val();
                
                $.ajax({
                    type: 'POST',
                    url: 'fetch_SPemployees.php',
                    data: { service_provider: serviceProvider },
                    success: function(data) {
                        $('#serviceTableBody').html(data);
                    }
                });
            });
        });
    </script> -->
<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    var service_provider = document.getElementById('service_provider');
    if (service_provider) {
      service_provider.addEventListener('change', function(event) {
        var serviceProvider = event.target.value;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById('serviceTableBody').innerHTML = this.responseText;
          }
        };
        
        xhttp.open('POST', 'fetch_SPemployees.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('service_provider=' + encodeURIComponent(serviceProvider));
      });
    }
  });
</script> -->
<script>
function calculateFee(input) {
    var row = input.closest('tr');
    console.log('Row:', row); // Debugging: Log the row element

    var ctc = row.querySelector('td:nth-child(3)').textContent.trim();
    console.log('CTC:', ctc); // Debugging: Log the CTC value

    var sfper = input.value;
    console.log('Service Fee Percentage:', sfper); // Debugging: Log the service fee percentage

    if (ctc !== "") {
        var sfee = (sfper / 100) * parseFloat(ctc);
        console.log('Calculated Service Fee:', sfee); // Debugging: Log the calculated service fee

        // Assign sfper to the 4th td element's input field
        row.querySelector('td:nth-child(4) input').value = sfper;

        // Assign sfee to the 5th td element's input field
        row.querySelector('td:nth-child(5) input').value = sfee.toFixed(2);
    } else {
        console.log('CTC is empty.'); // Debugging: Log if CTC is empty
    }
}
</script>

<script>
      document.addEventListener('DOMContentLoaded', function() {
        var service_provider = document.getElementById('service_provider');
        if (service_provider) {
          service_provider.addEventListener('change', function(event) {
            var serviceProvider = event.target.value;
            
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById('serviceTableBody').innerHTML = this.responseText;
              }
            };
            
            xhttp.open('POST', 'fetch_SPemployees.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('service_provider=' + encodeURIComponent(serviceProvider));
          });
        }
      });

function submitFormData() {
    var formData = new FormData();

    $("#serviceTableBody tbody tr").each(function() {
        var empname = $(this).find('td:eq(1)').text().trim();
        var ctc = $(this).find('td:eq(2)').text().trim();
        var sfper = $(this).find('td:eq(3) input').val().trim(); // Get input value
        var sfee = $(this).find('td:eq(4) input').val().trim(); // Get input value
        var service_provider = $('input[name="service_provider"]').val().trim();

        // Append data to formData object
        formData.append('empname[]', empname);
        formData.append('ctc[]', ctc);
        formData.append('sfper[]', sfper);
        formData.append('sfee[]', sfee);
        formData.append('service_provider[]', service_provider);
    });

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to submit the form data?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, submit',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'insert_sp.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while processing your request.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'Cancelled',
                text: 'Form submission cancelled',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>


</body>
<script>
    function myFuncdet() {
        document.getElementById("emibtn").classList.add("backclr");
        document.getElementById("onebtn").classList.remove("backclr");
        document.getElementById("scheper").classList.remove("remove");
    }

    function myFuncdet1() {
        document.getElementById("emibtn").classList.remove("backclr");
        document.getElementById("onebtn").classList.add("backclr");
        document.getElementById("scheper").classList.add("remove");
    }
</script>




</html>
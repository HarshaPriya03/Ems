<?php
session_start();
@include 'inc/config.php';
$currentDate = date("Y-m-d");
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}


// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module name from the URL (assuming the module pages have a parameter in the URL)
$module_name = basename($_SERVER['PHP_SELF']);

// Sanitize module name to prevent directory traversal attacks
$module_name = mysqli_real_escape_string($con, $module_name);

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the module is linked to the user
$sql = "SELECT COUNT(*) AS count FROM user_modules INNER JOIN modules ON user_modules.module_id = modules.id INNER JOIN user_form ON user_modules.email = user_form.email WHERE user_form.email = '$email' AND modules.module_name = '$module_name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    // If the module is not linked to the user, redirect to the login page
    header("Location: loginpage.php");
    exit();
}

// Fetch all users
$sql_users = "SELECT * FROM user_form";
$result_users = mysqli_query($con, $sql_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Fetch all modules
$sql_modules = "SELECT * FROM modules";
$result_modules = mysqli_query($con, $sql_modules);
$modules = mysqli_fetch_all($result_modules, MYSQLI_ASSOC);

// Fetch user-module associations
$user_module_associations = array();
$sql_user_modules = "SELECT * FROM user_modules";
$result_user_modules = mysqli_query($con, $sql_user_modules);
while ($row = mysqli_fetch_assoc($result_user_modules)) {
    $user_module_associations[$row['email']][] = $row['module_id'];
}

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>

<body>
    <div class="emailform">
        <div class="bg1"></div>
        <img class="emailform-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm1">
            <span>Anika</span>
            <span class="hrm1">HRM</span>
        </a>
        <a class="employee-management1" id="employeeManagement">Employee Management</a>
        <img class="uitcalender-icon1" alt="" src="./public/uitcalemnder.svg" />
        <div class="rectangle-parent" style="display:flex; flex-direction:column; flex:1;gap:20px;">
            

<div class="relative overflow-x-auto" >
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" colspan="10" style="border:1px solid rgb(200,200,200); text-align:center;" class="text-xl px-6 py-3">
              WIFI/LAN  Access Requests
                </th>
            </tr>
            <tr>
                <th scope="col" class="px-6 py-3">
                    S.No.
                </th>
                <th scope="col" class="px-6 py-3">
                    Employee Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Device Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Device Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Device Ownership
                </th>
                <th scope="col" class="px-6 py-3">
                    Modal Name
                </th>
                <th scope="col" class="px-6 py-3">
                    S/N Number
                </th>
                <th scope="col" class="px-6 py-3">
                MAC Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Reason
                </th>
                <th scope="col" class="text-center">
                    Action
                </th>
            </tr>
        </thead>
        <?php
                $cnt = 1;
                $sql = "SELECT * FROM inet_access WHERE status = 0 ORDER BY ID ASC";
                $que = mysqli_query($con, $sql);

                if (mysqli_num_rows($que) > 0) {
                    while ($result = mysqli_fetch_assoc($que)) {
                ?>
        <tbody>
            <tr id="row_<?php echo $result['id']; ?>"  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="px-6 py-4"><?php echo $cnt++; ?></td>
            <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
            <td class="px-6 py-4"><?php echo $result['dtype']; ?></td>
            <td class="px-6 py-4"><?php echo $result['dname']; ?></td>
            <td class="px-6 py-4"><?php echo $result['downer']; ?></td>
            <td class="px-6 py-4"><?php echo $result['mname']; ?></td>
            <td class="px-6 py-4"><?php echo $result['srno']; ?></td>
            <td class="px-6 py-4"><?php echo $result['mac']; ?></td>
            <td class="px-6 py-4"><?php echo $result['reason']; ?></td>
            <td class="text-center">
            <button class="px-4 py-1 approve-btn text-white bg-blue-100 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  text-center inline-flex items-center me-2 dark:bg-blue-100 dark:hover:bg-blue-300 dark:focus:ring-blue-300" data-id="<?php echo $result['id']; ?>" aria-label="Approve">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#50e390" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </button>
            <button class="px-4 py-1 reject-btn text-white bg-blue-100 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  text-center inline-flex items-center me-2 dark:bg-blue-100 dark:hover:bg-blue-300 dark:focus:ring-blue-300" data-id="<?php echo $result['id']; ?>" aria-label="Reject">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </td>
            </tr>
        </tbody>
        <?php
                    }
                } else {
                    ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="10" class="px-6 py-4 text-center">No requests</td>
                    </tr>
                <?php
                }
                ?>
    </table>
</div>

<div class="relative overflow-x-auto" >
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
             <tr style="border:1px solid rgb(200,200,200); text-align:center;">
                <th scope="col" colspan="11" class="px-6 py-3 text-xl">
                WIFI/LAN Access Approval Status
                </th>
            </tr>
            <tr>
                <th scope="col" class="px-6 py-3">
                    S.No.
                </th>
                <th scope="col" class="px-6 py-3">
                    Employee Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Device Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Device Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Device Ownership
                </th>
                <th scope="col" class="px-6 py-3">
                    Modal Name
                </th>
                <th scope="col" class="px-6 py-3">
                    S/N Number
                </th>
                <th scope="col" class="px-6 py-3">
                MAC Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Reason
                </th>
                <th scope="col" class="text-center">
                    Status
                </th>
                <th scope="col" >
                    Action Performed by
                </th>
            </tr>
        </thead>
        <?php
                $cnt = 1;
                $sql = "SELECT * FROM inet_access WHERE status != 0 ORDER BY ID ASC";
                $que = mysqli_query($con, $sql);

                if (mysqli_num_rows($que) > 0) {
                    while ($result = mysqli_fetch_assoc($que)) {
                ?>
        <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="px-6 py-4"><?php echo $cnt++; ?></td>
            <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
            <td class="px-6 py-4"><?php echo $result['dtype']; ?></td>
            <td class="px-6 py-4"><b><?php echo $result['dname']; ?></b></td>
            <td class="px-6 py-4"><?php echo $result['downer']; ?></td>
            <td class="px-6 py-4"><?php echo $result['mname']; ?></td>
            <td class="px-6 py-4"><?php echo $result['srno']; ?></td>
            <td class="px-6 py-4"><b><?php echo $result['mac']; ?></b></td>
            <td class="px-6 py-4"><?php echo $result['reason']; ?></td>
            <td class="px-6 py-4 text-center">
    <?php
    if ($result['status'] == 1) {
        echo '
        <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
        <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
      </svg>
      
Approved
</span>
        ';
    } elseif ($result['status'] == 2) {
        echo '
        <span class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-red-700 dark:text-red-400 border border-red-500 ">
        <svg class="w-4 h-4 me-1.5"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
      </svg>
      
Rejected
</span>
        ';
    } else {
    }
    ?>
</td>

            <td>
            <?php echo $result["action"]; ?>
            </td>
            </tr>
        </tbody>
        <?php
                    }
                } else {
                    ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="11" class="px-6 py-4 text-center">No Data</td>
                    </tr>
                <?php
                }
                ?>
    </table>
</div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('.approve-btn').click(function() {
            var rowId = $(this).data('id');
            updateStatus(rowId, 1); 
        });

        $('.reject-btn').click(function() {
            var rowId = $(this).data('id');
            updateStatus(rowId, 2); 
        });

        function updateStatus(rowId, status) {
            // Get the email value from the session
            var email = "<?php echo $_SESSION['email']; ?>";

            $.ajax({
                url: 'update_inet.php',
                method: 'POST',
                data: { id: rowId, status: status, email: email }, 
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Status updated successfully.',
                    }).then(function() {
                        window.location.href = 'inet.php';
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while updating the status.',
                    });
                    console.error('Error:', error);
                }
            });
        }
    });
</script>


</body>
</html>
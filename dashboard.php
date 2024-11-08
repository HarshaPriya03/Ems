<?php
session_start();
@include 'inc/config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}
// Insert data into user_pages table for logging user activity
$page = basename($_SERVER['PHP_SELF']);
$empemail = $_SESSION['email'];
$sql_insert_page = "INSERT INTO user_pages (email, loggedtime, page, longitude, latitude) VALUES (?, NOW(), ?, ?, ?)";
$stmt_page = mysqli_prepare($con, $sql_insert_page);
$latitude = ''; // Set latitude
$longitude = ''; // Set longitude
mysqli_stmt_bind_param($stmt_page, "ssdd", $empemail, $page, $longitude, $latitude);
mysqli_stmt_execute($stmt_page);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

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

// Fetch user types
$user_types = array();
$sql_user_types = "SELECT email, user_type FROM user_form WHERE user_type = 'user'";
$result_user_types = mysqli_query($con, $sql_user_types);
while ($row = mysqli_fetch_assoc($result_user_types)) {
    $user_types[$row['email']] = $row['user_type'];
}

// Set default checked value for module named 'employee-dashboard.php' for users with user_type = 'user'
$default_module_id = ''; // Initialize default module id
foreach ($modules as $module) {
    if ($module['module_name'] === 'employee-dashboard.php') {
        $default_module_id = $module['id'];
        break;
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Modules Management</title>
    <link rel="stylesheet" href="css/dash.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
    // Function to dynamically set colspan based on the number of columns
    function setColspan() {
        // Get the number of columns in the table
        var numColumns = document.getElementsByTagName('tr')[0].getElementsByTagName('td').length;

        // Set the colspan for the first row
        document.getElementsByTagName('tr')[0].getElementsByTagName('td')[0].setAttribute('colspan', numColumns);
        document.getElementsByTagName('tr')[1].getElementsByTagName('td')[0].setAttribute('colspan', numColumns);
    }

    // Call the function when the page loads
    window.onload = function() {
        setColspan();
    };

    // Reload the page function
    function reloadPage() {
        location.reload();
    }
</script>
<script>
    // Function to dynamically set colspan for the button row
    function setButtonColspan() {
        // Get the number of columns in the table
        var numColumns = document.getElementsByTagName('tr')[0].getElementsByTagName('td').length;

        // Set the colspan for the button row
        document.getElementById('button-row').getElementsByTagName('td')[0].setAttribute('colspan', numColumns);
    }

    // Call the function when the page loads
    window.onload = function() {
        setButtonColspan();
    };

    // Reload the page function
    function reloadPage() {
        location.reload();
    }
</script>
</head>

<body>
    <form action="update_modules.php" method="post">
        <input type="hidden" id="longitude" name="longitude">

        <input type="hidden"  id="latitude" name="latitude">
        <div class="table-wrapper">

            <table border="1" class="fl-table">
                <tr>
                    <td colspan=9>
                        <h4 class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl lg:text-3xl dark:text-white">
                            User & Modules Management for HRMS</h4>

                    </td>
                    <td>
                        <a href="user_access.php" target="_blank" type="button" class="text-gray-900 bg-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-m px-3 py-2 text-center inline-flex items-center dark:focus:ring-gray-500 me-2 mb-2">
                            User Accessed Pages
                        </a>
                    </td>
                </tr>

                <tr>
                    <td colspan=9>
                        <button type="submit" class="px-3 py-2 text-lg font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-6 h-6 me-2 -ms-1 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6" />
                            </svg>
                            Save Changes
                        </button>
                    </td>
                    <td>
                        <button onclick="reloadPage()" type="button" class="text-gray-900 bg-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-m px-3 py-2 text-center inline-flex items-center dark:focus:ring-gray-500 me-2 mb-2">

                            <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                            </svg>
                            Refresh Table
                        </button>
                    </td>
                </tr>

                <tr>
                    <th>User Login ID's</th>
                    <?php foreach ($modules as $module) : ?>
                        <th>
                            <?php echo $module['module']; ?>
                            <br>
                            <input type="checkbox" class="checkAllModule" data-module="<?php echo $module['module_name']; ?>">
                        </th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $user['email']; ?></td>
                        <?php foreach ($modules as $module) : ?>
                            <td>
                                <?php
                                $isChecked = isset($user_module_associations[$user['email']]) && in_array($module['id'], $user_module_associations[$user['email']]);

                                $wrapperClass = $isChecked ? 'checkbox-wrapper-40' : 'checkbox-wrapper-400';
                                ?>
                                <div class="<?php echo $wrapperClass; ?>">
                                    <label>
                                        <input type="checkbox" name="user_module[<?php echo $user['email']; ?>][]" value="<?php echo $module['id']; ?>" <?php if ($isChecked) echo 'checked'; ?>>
                                        <span class="checkbox"></span>
                                    </label>
                                </div>
                            </td>
                        <?php endforeach; ?>
                    </tr>

                <?php endforeach; ?>
            </table>
            <br>

        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Would you like to update user access?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $(this).serialize();
                        $.ajax({
                            type: "POST",
                            url: "update_modules.php",
                            data: formData,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: response,
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'dashboard.php';
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Request failed:', error);
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function reloadPage() {
            location.reload();
        }

        function toggleModuleColumn(moduleCheckbox) {
            var isChecked = moduleCheckbox.checked;
            var moduleName = moduleCheckbox.dataset.module;
            var columnIndex = Array.from(moduleCheckbox.parentNode.parentNode.children).indexOf(moduleCheckbox.parentNode);
            var checkboxes = document.querySelectorAll('table tr td:nth-child(' + (columnIndex + 1) + ') input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        }

        var checkAllCheckboxes = document.querySelectorAll('.checkAllModule');
        checkAllCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                toggleModuleColumn(this);
            });
        });
    </script>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            function getLocation() {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            }

            function showPosition(position) {
                document.querySelector('#latitude').value = position.coords.latitude;
                document.querySelector('#longitude').value = position.coords.longitude;
            }

            function showError(error) {
                console.log("showError() called");
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert("You have denied the request for Geolocation. Please enable location access to proceed.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        alert("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("An unknown error occurred.");
                        break;
                }
            }

            getLocation();
        });
    </script>
</body>

</html>
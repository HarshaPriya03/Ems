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

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];
    $work_location = $row['work_location'];

    if ($user_type1 !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
  } else {
    die("Error: Unable to fetch user details.");
  }
} else {
  die("Error: " . mysqli_error($con));
}

$sql_desg = "SELECT DISTINCT desg FROM emp";
$sql_dept = "SELECT DISTINCT dept FROM emp";
$sql_empstatus = "SELECT DISTINCT empstatus FROM emp";
$sql_empty = "SELECT DISTINCT `empty` FROM emp";
$sql_empcity = "SELECT DISTINCT work_location FROM emp";


$result_desg = mysqli_query($con, $sql_desg);
$result_dept = mysqli_query($con, $sql_dept);
$result_empstatus = mysqli_query($con, $sql_empstatus);
$result_empty = mysqli_query($con, $sql_empty);
$result_empcity= mysqli_query($con, $sql_empcity);

$output_desg = '';
$output_dept = '';
$output_empstatus = '';
$output_empty = '';
$output_empcity = '';

// Populate filter options for 'desg'
while ($row = mysqli_fetch_assoc($result_desg)) {
    $output_desg .= '<option value="' . $row['desg'] . '">' . $row['desg'] . '</option>';
}

// Populate filter options for 'dept'
while ($row = mysqli_fetch_assoc($result_dept)) {
    $output_dept .= '<option value="' . $row['dept'] . '">' . $row['dept'] . '</option>';
}

// Populate filter options for 'empstatus'

while ($row = mysqli_fetch_assoc($result_empstatus)) {
    $status = '';
    if ($row['empstatus'] == '0') {
        $status = 'Active';
    } elseif ($row['empstatus'] == '1') {
        $status = 'Terminated';
    } elseif ($row['empstatus'] == '2') {
        $status = 'Resigned';
    }
    $output_empstatus .= '<option value="' . $row['empstatus'] . '">' . $status . '</option>';
}

// Populate filter options for 'empty'
while ($row = mysqli_fetch_assoc($result_empty)) {
    $output_empty .= '<option value="' . $row['empty'] . '">' . $row['empty'] . '</option>';
}


// Populate filter options for 'city'
while ($row = mysqli_fetch_assoc($result_empcity)) {
    $output_empcity .= '<option value="' . $row['work_location'] . '">' . $row['work_location'] . '</option>';
}

echo json_encode(array(
    'desg' => $output_desg,
    'dept' => $output_dept,
    'empstatus' => $output_empstatus,
    'empty' => $output_empty,
    'work_location' => $output_empcity
));

// Close the database connection
mysqli_close($con);
?>

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

if ($work_location == 'All') {
    $sql = "SELECT * FROM emp ORDER BY emp_no ASC";
} else {
    $sql = "SELECT * FROM emp WHERE work_location = '$work_location' ORDER BY emp_no ASC";
}
$result = mysqli_query($con, $sql);
$cnt = 1;
$output = '';

while ($row = mysqli_fetch_assoc($result)) {
    $output .= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
    $output .= '<td class="px-6 py-4">' . $cnt++ . '</td>';
    $output .= '<td class="px-6 py-4">' . $row['emp_no'] . '</td>';
    $output .= '<td class="px-6 py-4">' . $row['empname'] . '</td>';
    $output .= '<td class="px-6 py-4">' . $row['desg'] . '</td>';
    $output .= '<td class="px-6 py-4">' . $row['dept'] . '</td>';
    $output .= '<td class="px-6 py-4">' . $row['empty'] . '</td>';
   
    $output .= '<td class="px-6 py-4">';
    if ($row['empstatus'] == '0') {
        $output .= 'Active';
    } elseif ($row['empstatus'] == '1') {
        $output .= 'Terminated';
    } elseif ($row['empstatus'] == '2') {
        $output .= 'Resigned';
    }
    $output .= '</td>';
    $output .= '<td class="px-6 py-4">' . $row['work_location'] . '</td>';
    $output .= '<td class="px-6 py-4"><a href="../pdfs/' . $row['pdf'] . '" target="_blank" class="btn btn--light btn--sm btn--icon" aria-label="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff6e24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </a></td>';
    $output .= '</tr>';
}

echo $output;

// Close the database connection
mysqli_close($con);
?>

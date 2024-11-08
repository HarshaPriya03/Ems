<?php
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// $sql = "SELECT COUNT(*) AS count FROM payroll_ss WHERE status = 0";
$sql = "
    SELECT SUM(count) AS count FROM (
        SELECT COUNT(*) AS count FROM payroll_ss_vsp WHERE status = 0
        UNION ALL
        SELECT COUNT(*) AS count FROM payroll_ss_sp WHERE status = 0
        UNION ALL
        SELECT COUNT(*) AS count FROM payroll_ss_ggm WHERE status = 0
    ) AS combined_counts
";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($con);
    exit();
}

$row = mysqli_fetch_assoc($result);
$count = $row['count'];

session_start();
$prevCount = isset($_SESSION['prev_count']) ? $_SESSION['prev_count'] : 0;

if ($count < $prevCount) {
    echo 'reload';
} else {
    echo 'no_reload';
}

$_SESSION['prev_count'] = $count;

mysqli_close($con);
?>

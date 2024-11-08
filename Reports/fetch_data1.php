<?php
// Assuming you have a database connection established
include '../inc/config.php';

$sql = "SELECT * FROM emp ORDER BY emp_no ASC";
$result = mysqli_query($con, $sql);
$cnt = 1;
$table_rows = '';

if (mysqli_num_rows($result) > 0) {
    $cnt = 1; // Initialize counter for S.NO.
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $table_rows .= "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'>";
        $table_rows .= "<td class='px-6 py-4'>" . $cnt++ . "</td>";
        $table_rows .= "<td>" . $row['empname'] . "</td>"; // Adjust column name based on your database structure
        // Output other columns as needed
        // Example: $table_rows .= "<td>" . $row['column_name'] . "</td>";
        $table_rows .= "</tr>";
    }
} else {
    $table_rows = "<tr><td colspan='10'>No data found</td></tr>";
}

echo $table_rows;

// Close the database connection
mysqli_close($con);
?>

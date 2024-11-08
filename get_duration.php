<?php
include 'inc/config.php'; 

if (isset($_GET['empname'])) {
    $empname = mysqli_real_escape_string($con, $_GET['empname']);

    $sql = "SELECT dept.fromshifttime1, dept.toshifttime1
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Convert fromshifttime1 and toshifttime1 to DateTime objects
        $fromShiftTime = new DateTime($row['fromshifttime1']);
        $toShiftTime = new DateTime($row['toshifttime1']);

        // Calculate the difference between the times
        $interval = $fromShiftTime->diff($toShiftTime);

        // Format the difference
        $duration = $interval->format('%h hrs %i mins');

        echo "Daily Work Hours: " .$duration; 
    } else {
        echo "No designation found";
    }
} else {
    echo "Employee name not provided";
}
?>
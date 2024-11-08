<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['edit_id5'])) {
    $eid = $_POST['edit_id5'];
    @include 'inc/config.php';
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM payroll_msalarystruc 
    WHERE payroll_msalarystruc.empname = ?";


    $query = $con->prepare($sql);
    $query->bind_param('s', $eid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $total_empcontributions = $row['epf1'] + $row['esi1'] + $row['tds'];
?>

            <h3 class="text-l font-semibold text-gray-900 dark:text-white">
                Deductions Breakdown
            </h3>
            <div>
            <p style="font-size: 16px; font-weight: normal;">TDS<span style="margin-left: 180px;">-</span> <span style="margin-left: 79px;">₹<?php echo $row['tds']; ?>/-</span></p>
                <p style="font-size: 16px; font-weight: normal;">EPF*<span style="margin-left: 173px;">-</span> <span style="margin-left: 79px;">₹<?php echo $row['epf1']; ?>/-</span></p>
                <p style="font-size: 16px; font-weight: normal;">ESIC <span style="margin-left: 170px;">-</span> <span style="margin-left: 80px;">₹<?php echo $row['esi1']; ?>/-</span></p> <hr style="width:70px; margin-left:290px; margin-top:10px;" />
              
                <p style="font-size: 16px; font-weight: normal;margin-top:10px;">Total Deductions <span style="margin-left: 80px;">-</span> <span style="margin-left: 80px;">₹<?php echo $total_empcontributions ?>/-</span></p> <br/>
                <span style="font-size:15px; color:rgb(170,170,170);">*=(Employee Contribution 12% of Basic Pay)</span>
            </div>

<?php
        }
    } else {
        echo "No data found";
    }
} else {
    echo "No data received";
}
?>
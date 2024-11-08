<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['edit_id5'])) {
    $eid = $_POST['edit_id5'];

    $con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
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
      if ($row['empname'] == "YERRAMSETTI SUSANTHA SANKAR") {
        $row['epf2'] = "1166";
        $row['epf3'] = "514";
        $total_eycontribution = "1680" ;
    }
    $total_eycontributions = $row['epf2'] + $row['epf3'] + $row['esi2'];
?>


            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Additions Breakdown
            </h3>

            
            <div>
                <p style="font-size: 16px; font-weight: normal;">EPF <sup>1</sup>*<span style="margin-left: 179px;">-</span> <span style="margin-left: 80px;">₹<?php echo $row['epf2']; ?>/-</span></p>
                <p style="font-size: 16px; font-weight: normal;">EPF <sup>2*</sup><span style="margin-left: 179px;">-</span> <span style="margin-left: 80px;">₹<?php echo $row['epf3']; ?>/-</span></p>
                <p style="font-size: 16px; font-weight: normal;">ESIC <span style="margin-left: 186px;">-</span> <span style="margin-left: 80px;">₹<?php echo $row['esi2']; ?>/-</span></p><hr style="width:70px; margin-left:300px; margin-top:10px;" />
                <p style="font-size: 16px; font-weight: normal;margin-top:10px;">Total Additions <span style="margin-left: 110px;">-</span> <span style="margin-left: 80px;">₹<?php echo $total_eycontributions ?>/-</span></p>
                <span style="font-size:15px; color:rgb(170,170,170);">   <sup>1</sup>*=(Employee Contribution for Pension from 12% of Basic Pay)</span><br>
                <span style="font-size:15px; color:rgb(170,170,170);"> <sup>2</sup>*=(Employee Contribution for Employer Share from 12% of Basic Pay)</span>
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
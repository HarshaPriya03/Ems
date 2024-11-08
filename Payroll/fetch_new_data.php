<?php
// Database connection
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

if (!$con) {
    echo json_encode(['error' => 'Database connection error: ' . mysqli_connect_error()]);
    exit;
}

// Check if the ID is received through POST
if (isset($_POST['id'])) {
    // Sanitize the received ID
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $created = date('Y-m-d H:i:s');

    // Initialize update query variable
    $sql_update = "";

    // Check if the ID exists in payroll_ss_vsp with status = 0
    $sql_vsp = "SELECT id FROM payroll_ss_vsp WHERE id = '$id' AND status = 0";
    $result_vsp = mysqli_query($con, $sql_vsp);

    if (mysqli_num_rows($result_vsp) > 0) {
        // Update the record in payroll_ss_vsp
        $sql_update = "UPDATE payroll_ss_vsp SET status = 1, status1 = 1, confirm1 = '$created' WHERE id = '$id'";
    } else {
        // Check if the ID exists in payroll_ss_ggm with status = 0
        $sql_ggm = "SELECT id FROM payroll_ss_ggm WHERE id = '$id' AND status = 0";
        $result_ggm = mysqli_query($con, $sql_ggm);

        if (mysqli_num_rows($result_ggm) > 0) {
            // Update the record in payroll_ss_ggm
            $sql_update = "UPDATE payroll_ss_ggm SET status = 1, status1 = 1, confirm1 = '$created' WHERE id = '$id'";
        } else {
            // Check if the ID exists in payroll_ss_sp with status = 0
            $sql_sp = "SELECT id FROM payroll_ss_sp WHERE id = '$id' AND status = 0";
            $result_sp = mysqli_query($con, $sql_sp);

            if (mysqli_num_rows($result_sp) > 0) {
                // Update the record in payroll_ss_sp
                $sql_update = "UPDATE payroll_ss_sp SET status = 1, status1 = 1, confirm1 = '$created' WHERE id = '$id'";
            } else {
                // The record does not exist in any of the tables with status = 0
                echo json_encode(['error' => 'No data found for id ' . $id . ' with status = 0']);
                exit;
            }
        }
    }

    // Execute the update query and output debugging information
    if ($sql_update) {
        if (mysqli_query($con, $sql_update)) {
            // Status updated successfully
            // Fetch the next available data
            $query = "
                SELECT id, empname, fgs, fhra, foa, fbp, monthdays, present, leaves, sundays, flop, paydays, gross, hra, oa, bp, epf1, esi1, tds, emi, lopamt, misc, totaldeduct, bonus, payout 
                FROM payroll_ss_sp WHERE status = 0 OR status = 1
                UNION ALL
                SELECT id, empname, fgs, fhra, foa, fbp, monthdays, present, leaves, sundays, flop, paydays, gross, hra, oa, bp, epf1, esi1, tds, emi, lopamt, misc, totaldeduct, bonus, payout 
                FROM payroll_ss_ggm WHERE status = 0 OR status = 1
                UNION ALL
                SELECT id, empname, fgs, fhra, foa, fbp, monthdays, present, leaves, sundays, flop, paydays, gross, hra, oa, bp, epf1, esi1, tds, emi, lopamt, misc, totaldeduct, bonus, payout 
                FROM payroll_ss_vsp WHERE status = 0 OR status = 1
                LIMIT 1
            ";
            $result = mysqli_query($con, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $nextData = mysqli_fetch_assoc($result);
                echo json_encode($nextData); // Output next available data as JSON
            } else {
                echo json_encode(false); // No more data available
            }
        } else {
            echo json_encode(['error' => 'Failed to update status: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['error' => 'No valid update query was generated']);
    }
} else {
    // ID not received, fetch data with status = 0 for initial modal opening
    $query = "
        SELECT id, empname, fgs, fhra, foa, fbp, monthdays, present, leaves, sundays, flop, paydays, gross, hra, oa, bp, epf1, esi1, tds, emi, lopamt, misc, totaldeduct, bonus, payout 
        FROM payroll_ss_sp WHERE status = 0 
        UNION ALL
        SELECT id, empname, fgs, fhra, foa, fbp, monthdays, present, leaves, sundays, flop, paydays, gross, hra, oa, bp, epf1, esi1, tds, emi, lopamt, misc, totaldeduct, bonus, payout 
        FROM payroll_ss_ggm WHERE status = 0 
        UNION ALL
        SELECT id, empname, fgs, fhra, foa, fbp, monthdays, present, leaves, sundays, flop, paydays, gross, hra, oa, bp, epf1, esi1, tds, emi, lopamt, misc, totaldeduct, bonus, payout 
        FROM payroll_ss_vsp WHERE status = 0 
        LIMIT 1
    ";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $initialData = mysqli_fetch_assoc($result);
        echo json_encode($initialData); // Output initial data as JSON
    } else {
        echo json_encode(false); // No initial data with status = 0 found
    }
}

mysqli_close($con);
?>

<?php
require_once("dbConfig.php");

if ($_FILES["pdfFile"]["error"] == UPLOAD_ERR_OK && $_FILES["pdfFile"]["type"] == "application/pdf") {
    // Get the current timestamp
    $currentTimestamp = time();

    // Derive month and year from the timestamp
    $currentMonthYear = date("m-Y", $currentTimestamp);

    // Determine the next serial number for the current month and year
    $serialNumber = 1;

    $query = "SELECT MAX(serial_number) AS max_serial FROM pdf_table WHERE month_year = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $currentMonthYear);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['max_serial'] !== null) {
        $serialNumber = $row['max_serial'] + 1;
    }

    // Generate the filename
    $filename = "Attendance_sheet_" . $currentMonthYear . "_" . str_pad($serialNumber, 2, '0', STR_PAD_LEFT) . ".pdf";

    // Save the uploaded file on the server
    move_uploaded_file($_FILES["pdfFile"]["tmp_name"], "attendencepdf/" . $filename);

    // Get desg value, if not provided set it to NULL
    $desg = isset($_POST["desg"]) ? $_POST["desg"] : NULL;

    // Store the file path and desg value in the database
    $insertQuery = "INSERT INTO pdf_table (pdf_content, month_year, serial_number, upload_timestamp, desg) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = mysqli_prepare($db, $insertQuery);
    mysqli_stmt_bind_param($stmt, "ssis", $filename, $currentMonthYear, $serialNumber, $desg);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "PDF uploaded successfully!";
    } else {
        echo "Error uploading PDF. Please try again.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid PDF file. Please upload a valid PDF file.";
}
?>

<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$salmonth = $_POST['salmonth'];
$tdate = $_POST['tdate'];
$notes = $_POST['notes'];
$created = date('Y-m-d H:i:s');

// File upload handling
$targetDir = "docs/";
$fileName = basename($_FILES["esidoc"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

$response = array(); // Initialize an array to store response data

// Check if file is selected
if (!empty($fileName)) {
    // Allow certain file formats
    $allowTypes = array('pdf', 'doc', 'docx');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["esidoc"]["tmp_name"], $targetFilePath)) {
            // Insert file name into database
            $sql = "INSERT INTO payroll_esi (salmonth, tdate, notes, esidoc, created) VALUES ('$salmonth', '$tdate', '$notes', '$fileName', '$created')";
            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Epf created successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Sorry, only PDF, DOC, and DOCX files are allowed.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Please select a file to upload.";
}

// Output JSON response
echo json_encode($response);

$conn->close();
?>

<?php
    $rawdata = file_get_contents("php://input");
    $stgid= $_GET["stgid"];

    $raw = json_decode($rawdata);

    $ret = "done";
    $data = json_decode($rawdata, true);

    if( isset( $data["RealTime"] ))
    {
        $ret = handle_attendance_log($stgid, $rawdata);
    }
    else
        $ret = "Else";

    $response = new StdClass();
    $response->status="done";

    header("Content-Type: application/text;charset=utf-8");
    http_response_code(200);
    echo json_encode($response);


function handle_attendance_log($stgid, $rawdata)
{
    $ret = "done";

    $request = new StdClass();
	$request->RealTime = new StdClass();
	$request->RealTime->AuthToken="";
	$request->RealTime->Time="";
	$request->RealTime->OperationID="";
	$request->RealTime->PunchLog = new StdClass();
	$request->RealTime->PunchLog->UserId="";
	$request->RealTime->PunchLog->LogTime="";
	$request->RealTime->PunchLog->Temperature="";
	$request->RealTime->PunchLog->FaceMask="";
	$request->RealTime->PunchLog->InputType="";
	$request->RealTime->PunchLog->Type= "";

    
    $request = json_decode($rawdata);

    $content = 'ServiceTagId:' . $stgid . ",\t";
    $content .= 'UserId:' . $request->RealTime->PunchLog->UserId . ",\t";
    $content .= 'AttendanceTime:' . $request->RealTime->PunchLog->LogTime . ",\t";
    // $content .= 'AttendanceType:' . $request->RealTime->PunchLog->Type . ",\t";
    $content .= 'InputType:' . $request->RealTime->PunchLog->InputType . ",\t";
    $content .= 'Operation: RealTime->PunchLog' . ",\t";
    $content .= 'AuthToken:' . $request->RealTime->AuthToken . "\n";

    $file = fopen("cams-attendance-record.txt", "a");
    fwrite($file, $content);

    $ServiceTagId = $stgid;
    $UserId = $request->RealTime->PunchLog->UserId;
    $AttendanceTime = $request->RealTime->PunchLog->LogTime;
    $InputType = $request->RealTime->PunchLog->InputType;

	$servername = "localhost";
	$username = "Anika12";
	$password = "Anika12";
	$dbname = "ems";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        fwrite($file, "Connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    // Determine the AttendanceType based on the number of punches for the day
    $date = date('Y-m-d', strtotime($AttendanceTime));
    $check_punches_sql = "SELECT COUNT(*) as punch_count FROM CamsBiometricAttendance_GGM WHERE UserId = '$UserId' AND DATE(AttendanceTime) = '$date'";
    $result = $conn->query($check_punches_sql);
    $row = $result->fetch_assoc();
    $punch_count = $row['punch_count'];

    if ($punch_count % 2 == 0) {
        $AttendanceType = 'CheckIn';
    } else {
        $AttendanceType = 'CheckOut';
    }

    $sql = "INSERT INTO CamsBiometricAttendance_GGM (ServiceTagId, UserId, AttendanceTime, AttendanceType, InputType)
            VALUES ('$ServiceTagId', '$UserId', '$AttendanceTime', '$AttendanceType', '$InputType')";

    fwrite($file, $sql);
    if ($conn->query($sql) === TRUE) {
        fwrite($file, " -- inserted in db");
    } else {
        fwrite($file, " -- DB Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
    fclose($file);

    return $ret;
}
?>

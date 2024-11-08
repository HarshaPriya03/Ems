<?php
header('Content-Type: application/json');
include('smtp/PHPMailerAutoload.php');
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $apremail = $_POST['apremail'];
    $aprname = $_POST['aprname'];
    $mgrname = $_POST['mgrname'];
    $remark = $_POST['remark'];
    $ID = $_POST['id'];

    $updateQuery = "UPDATE leaves SET status='$status', apremail='$apremail', aprname='$aprname',mgrname='$mgrname', hrremark='$remark' WHERE id='$ID'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        $response = ['success' => true, 'message' => 'Leave Action updated successfully.'];

        if ($status == '3') {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "hrms.ems.acc.creation@gmail.com";
                $mail->Password = "brbnnshtcvfnuupu";
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->setFrom("hrms.ems.acc.creation@gmail.com", "ASPL HRMS");
                $mail->addAddress($apremail, $aprname);
                $mail->Subject = 'Leave Approval Request-ASPL HRMS System';
                $mail->isHTML(true);

                ob_start();
                include('leave_aprmail.php');
                $mail->Body = ob_get_contents();
                ob_end_clean();

                $mail->send();

                $purpose = "for leave request approval";
                $query = "INSERT INTO mail_log (email, purpose) VALUES ('$apremail', '$purpose')";

                if (mysqli_query($con, $query)) {
                    $response['message'] .= ' Email sent to Approver for leave approval.';
                } else {
                    $response['success'] = false;
                    $response['message'] .= ' Error inserting record into mail_log table: ' . mysqli_error($con);
                }
            } catch (Exception $e) {
                $response['success'] = false;
                $response['message'] .= ' Error sending email: ' . $e->getMessage();
            }
        }

        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating leave record. Please try again. Status: ' . $status, 'error' => mysqli_error($con)]);
    }

    ob_end_flush();
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>

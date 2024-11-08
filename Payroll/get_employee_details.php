<?php
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
if(isset($_GET['empname']) && !empty($_GET['empname'])) {
    $empname = $_GET['empname'];

      $stmt = $con->prepare("SELECT emp_no, desg,dept,sbn,sifsc,sban,uan,epfn,esin FROM emp WHERE empname = ?");
    $stmt->bind_param("s", $empname);
    $stmt->execute();
    $stmt->bind_result($emp_no, $desg,$dept, $sbn, $sifsc, $sban, $uan, $epfn, $esin);

    $stmt->fetch();

    $stmt->close();

    $result = array(
        'emp_no' => $emp_no,
        'desg' => $desg,
        'dept' => $dept,
        'sbn' => $sbn,
        'sifsc' => $sifsc,
        'sban' => $sban,
        'uan' => $uan,
        'epfn' => $epfn,
        'esin' => $esin
    );

    echo json_encode($result);
} else {
    echo json_encode(array('error' => 'empname is missing'));
}
mysqli_close($con);
?>

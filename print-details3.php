

<?php
require_once("dbConfig.php");
session_start();
$firstDayOfMonth = date("1-m-Y");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

// Fetching Employees 
$fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'") or die(mysqli_error($db));
$totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

$EmployeesNamesArray = array();
$EmployeesIDsArray = array();
$counter = 0;
while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
    $EmployeesNamesArray[] = $Employees['empname'];
    $EmployeesIDsArray[] = $Employees['UserID'];
}

// Fetching holidays
$fetchingHolidays = mysqli_query($db, "SELECT value, date FROM holiday") or die(mysqli_error($db));
$holidayDates = array();
while ($holiday = mysqli_fetch_assoc($fetchingHolidays)) {
    $holidayDates[$holiday['date']] = $holiday['value'];
}

?>
<?php
use Dompdf\Dompdf;
use Dompdf\Options;

require 'dompdf/autoload.inc.php';

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('tempDir', '/tmp');
$options->set('chroot', __DIR__);
$dompdf = new Dompdf($options);

ob_start();
require('details_pdf3.php');

$html =
ob_get_clean();


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A3', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$employeeName = $EmployeesNamesArray[0];
// Output the generated PDF to Browser
$dompdf->stream("Attendance_$employeeName.pdf", ['Attachment' => false]);


<?php
require_once("dbConfig.php");

$firstDayOfMonth = date("1-m-Y");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

// Fetching Employees 
$fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE desg != 'SECURITY GAURDS' ORDER BY emp_no ASC") or die(mysqli_error($db));

$totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

$EmployeesNamesArray = array();
$EmployeesIDsArray = array();
$counter = 0;
$cnt = 1;
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
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

ob_start();
require('details_pdf.php');

$html =
ob_get_clean();


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A2', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('Attendance_Sheet.pdf',['Attachment'=>false]);

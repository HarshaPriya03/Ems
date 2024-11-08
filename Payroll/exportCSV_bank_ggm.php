<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../loginpage.php");
    exit();
}

// Connect to MySQL
@include 'inc/config.php';
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module ID for the payroll module
$sql_payroll_module = "SELECT id FROM modules WHERE module_name = 'payroll'";
$result_payroll_module = mysqli_query($con, $sql_payroll_module);
$payroll_module = mysqli_fetch_assoc($result_payroll_module);

// Retrieve the logged-in user's email
$email = $_SESSION['email'];

// Check if the logged-in user has access to the payroll module
$sql_check_access = "SELECT COUNT(*) AS count FROM user_modules WHERE email = '$email' AND module_id = " . $payroll_module['id'];
$result_check_access = mysqli_query($con, $sql_check_access);
$row_check_access = mysqli_fetch_assoc($result_check_access);

if ($row_check_access['count'] == 0) {
    // If the user doesn't have access to the payroll module, redirect them to the dashboard or display an error message
    header("Location: ../loginpage.php");
    exit();
}

// If the user has access to the payroll module, continue loading the payroll page
?>
<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection
// @include 'inc/config.php';

$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
$currentMonth = $smonth; 

// Query to fetch data
$query = mysqli_query($con, "SELECT payroll_ss_ggm.*, emp.*, payroll_ban.*
FROM payroll_ss_ggm
LEFT JOIN emp ON payroll_ss_ggm.empname = emp.empname
LEFT JOIN payroll_ban ON payroll_ss_ggm.empname = payroll_ban.empname
WHERE payroll_ss_ggm.salarymonth = '$currentMonth' ORDER BY emp.emp_no ASC");
    $cnt = 1;

if (mysqli_num_rows($query) > 0) {
    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getStyle('A1:N1')->getFont()->setName('Times New Roman')->setSize(11); // Set font size for column headers
    $sheet->getStyle('A1:N1')->getFont()->setBold(true); // Set headers in bold
    $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set headers text-align:center
    $sheet->getStyle('A1:N1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Set headers vertical align center
    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(7);
    $sheet->getColumnDimension('B')->setWidth(10);
    $sheet->getColumnDimension('C')->setWidth(11);
    $sheet->getColumnDimension('D')->setWidth(12);
    $sheet->getColumnDimension('E')->setWidth(21);
    $sheet->getColumnDimension('F')->setWidth(36);
    $sheet->getColumnDimension('G')->setWidth(12);
    $sheet->getColumnDimension('H')->setWidth(25);
    $sheet->getColumnDimension('I')->setWidth(36);
    $sheet->getColumnDimension('J')->setWidth(18.5);
    $sheet->getColumnDimension('K')->setWidth(20.57);
    $sheet->getColumnDimension('L')->setWidth(25);
    $sheet->getColumnDimension('M')->setWidth(45);
    $sheet->getColumnDimension('N')->setWidth(40);

    // Set row heights
    $headerRowHeight = 60;
    $valueRowHeight = 30;
    $sheet->getRowDimension('1')->setRowHeight($headerRowHeight);
    $sheet->getStyle('1:' . $sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    // Set font family for whole sheet
    $sheet->getStyle('A1:N' . $sheet->getHighestRow())->getFont()->setName('Times New Roman');

    // Set font size for column headers
    $sheet->getStyle('A1:N1')->getFont()->setSize(11);

    // Set headers text-align:center, font-weight:bold
    $headers = [
        'A1' => 'Sr No.',
        'B1' => 'TRAN.ID',
        'C1' => 'AMOUNT',
        'D1' => 'SENDER ACCOUNT TYPE',
        'E1' => 'SENDER ACCOUNT NO',
        'F1' => 'SENDER NAME',
        'G1' => 'SMS EML',
        'H1' => 'DETAIL',
        'I1' => 'OoR7002 (SENDER NAME)',
        'J1' => 'BENEFICIARY IFSC',
        'K1' => 'BENEFICIARY ACCOUNT TYPE',
        'L1' => 'BENEFICIARY ACCOUNT NO',
        'M1' => 'BENEFICIARY ACCOUNT NAME',
        'N1' => 'SENDER TO RECEIVER INFORMATION',
    ];

    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
        $sheet->getStyle($cell)->getAlignment()->setWrapText(true); // Wrap text
        $sheet->getStyle($cell)->getFont()->setBold(true); // Set bold font
        $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set center alignment
    }

    // Fetch data and populate the spreadsheet
    $row = 2; // Start from row 2
    while ($data = mysqli_fetch_assoc($query)) {
        $sheet->setCellValue('A' . $row, $cnt . '');
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('B' . $row, $data['transid']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C' . $row, $data['payout']);
        $sheet->getStyle('C' . $row)->getFont()->setBold(true);
        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->setCellValue('D' . $row, '11');
        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueExplicit('E' . $row, '436205000047', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('F' . $row, 'ANIKA STERILIS PRIVATE LIMITED');
        $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('G' . $row, 'EML');
        $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('H' . $row, 'info@anikasterilis.com');
        $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('I' . $row, 'ANIKA STERILIS PRIVATE LIMITED');
        $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('J' . $row, $data['sifsc']);
        $sheet->setCellValue('K' . $row, '10');
        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValueExplicit('L' . $row, $data['sban'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('L' . $row)->getFont()->setBold(true);

        $sheet->setCellValue('M' . $row, $data['empname']);
        $sheet->setCellValue('N' . $row, strtoupper('SALARY FOR THE MONTH OF ' . $currentMonth));
     

        // Set row height for data rows
        $sheet->getRowDimension($row)->setRowHeight($valueRowHeight);
        $sheet->getStyle('A' . $row . ':N' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $row++;
        $cnt++;
    }
  // Apply borders to the entire sheet
  $highestRowWithData = $sheet->getHighestRow();
  $highestColumnWithData = $sheet->getHighestColumn();
  $rangeWithData = 'A1:' . $highestColumnWithData . $highestRowWithData;

  $styleArray = [
      'borders' => [
          'allBorders' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
              'color' => ['argb' => 'FF000000'],
          ],
      ],
  ];

  $sheet->getStyle($rangeWithData)->applyFromArray($styleArray);
    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ICICI-NEFT-GGM-' . $smonth  . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Create a writer and output the spreadsheet
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>

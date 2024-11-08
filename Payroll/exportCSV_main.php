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
$query = mysqli_query($con, "
    SELECT 
        payroll_ss.emp_no, 
        payroll_ss.desg, 
        payroll_ss.dept, 
        payroll_ss.*, 
        emp.empname, 
        payroll_ban.*,
        (payroll_ss.emi + payroll_ss.misc) AS MISC
    FROM 
        payroll_ss
    LEFT JOIN 
        emp ON payroll_ss.empname = emp.empname
    LEFT JOIN 
        payroll_ban ON payroll_ss.empname = payroll_ban.empname
    WHERE 
        payroll_ss.salarymonth = '$currentMonth'
    ORDER BY 
        payroll_ss.emp_no ASC
");


$cnt = 1;

if (mysqli_num_rows($query) > 0) {
    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
// Set text value
$sheet->setCellValue('A1', 'ANIKA STERILIS PRIVATE LIMITED | SALARY SHEET');

// Merge cells
$sheet->mergeCells('A1:AN1');

// Center text horizontally and vertically
$sheet->getStyle('A1:AN1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:AN1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

// Set font size to 20 and make text bold
$sheet->getStyle('A1')->getFont()->setSize(20);
$sheet->getStyle('A1')->getFont()->setBold(true);


// 2ND ROW
$sheet->setCellValue('A2', 'SALARY FOR THE MONTH OF '. $smonth);

// Merge cells
$sheet->mergeCells('A2:AN2');

// Center text horizontally and vertically
$sheet->getStyle('A2:AN2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:AN2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
// Apply vertical center alignment to the entire 4th row
$sheet->getStyle('4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

// Set row height to 30
$sheet->getRowDimension(2)->setRowHeight(30);

// Add fill color (yellow) to the merged cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF00'],
    ],
];

// Apply bold font to the merged cells
$sheet->getStyle('A2:AN2')->applyFromArray($styleArray);
$sheet->getStyle('A2:AN2')->getFont()->setBold(true);
// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F4B084'], // Peach color
    ],
];

$sheet->getStyle('K4:P4')->applyFromArray($styleArray);
// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'BDD7EE'], // Light blue color
    ],
];

$sheet->getStyle('Q4:T4')->applyFromArray($styleArray);
// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00B0F0'], // Light blue color
    ],
];

$sheet->getStyle('U4:AA4')->applyFromArray($styleArray);

// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFD961'], // Orange color
    ],
];

$sheet->getStyle('AB4')->applyFromArray($styleArray);

// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFC000'], // Orange color
    ],
];

$sheet->getStyle('AC4:AE4')->applyFromArray($styleArray);

// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'], // Green color
    ],
];

$sheet->getStyle('AF4:AN4')->applyFromArray($styleArray);

    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(7);
    $sheet->getColumnDimension('B')->setWidth(10);
    $sheet->getColumnDimension('C')->setWidth(45);
    $sheet->getColumnDimension('D')->setWidth(40);
    $sheet->getColumnDimension('E')->setWidth(21);
    $sheet->getColumnDimension('F')->setWidth(36);
    $sheet->getColumnDimension('G')->setWidth(12);
    $sheet->getColumnDimension('H')->setWidth(12);
    $sheet->getColumnDimension('I')->setWidth(16);
    $sheet->getColumnDimension('J')->setWidth(18.5);
    $sheet->getColumnDimension('K')->setWidth(16.57);
    $sheet->getColumnDimension('L')->setWidth(14);
    $sheet->getColumnDimension('M')->setWidth(14);
    $sheet->getColumnDimension('N')->setWidth(12);
    $sheet->getColumnDimension('O')->setWidth(12);
    $sheet->getColumnDimension('P')->setWidth(14);
    $sheet->getColumnDimension('Q')->setWidth(14);
    $sheet->getColumnDimension('R')->setWidth(17);
    $sheet->getColumnDimension('S')->setWidth(15);
    $sheet->getColumnDimension('T')->setWidth(15);
    $sheet->getColumnDimension('U')->setWidth(15);
    $sheet->getColumnDimension('V')->setWidth(16);
    $sheet->getColumnDimension('W')->setWidth(16);
    $sheet->getColumnDimension('X')->setWidth(16);
    $sheet->getColumnDimension('Y')->setWidth(16);
    $sheet->getColumnDimension('Z')->setWidth(15);
    $sheet->getColumnDimension('AA')->setWidth(17);
    $sheet->getColumnDimension('AB')->setWidth(16);
    $sheet->getColumnDimension('AC')->setWidth(20);
    $sheet->getColumnDimension('AD')->setWidth(20);
    $sheet->getColumnDimension('AE')->setWidth(17);
    $sheet->getColumnDimension('AF')->setWidth(20);
    $sheet->getColumnDimension('AG')->setWidth(20);
    $sheet->getColumnDimension('AH')->setWidth(20);
    $sheet->getColumnDimension('AI')->setWidth(45);
    $sheet->getColumnDimension('AJ')->setWidth(15);
    $sheet->getColumnDimension('AK')->setWidth(23);
    $sheet->getColumnDimension('AL')->setWidth(45);
    $sheet->getColumnDimension('AM')->setWidth(25);
    $sheet->getColumnDimension('AN')->setWidth(25);

    // Set row heights
    $headerRowHeight = 60;
    $valueRowHeight = 30;
    $sheet->getRowDimension('1')->setRowHeight($headerRowHeight);

// Merge and center cells for EMPLOYEE DETAILS
// Merge cells
$sheet->mergeCells('A3:F3');

// Set text value
$sheet->setCellValue('A3', 'EMPLOYEE DETAILS');

// Center text horizontally and vertically
$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A3:F3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

// Set bold and increase font size
$sheet->getStyle('A3:F3')->getFont()->setBold(true);
$sheet->getStyle('A3:F3')->getFont()->setSize(10);

// Add fill color (orange) to the merged cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFC000'], // Orange color
    ],
];

$sheet->getStyle('A3:F3')->applyFromArray($styleArray);

$sheet->getRowDimension(3)->setRowHeight(40);

// Merge and center cells for FIXED SALARY COMPONENTS
$sheet->mergeCells('G3:J3');
$sheet->setCellValue('G3', 'FIXED SALARY COMPONENTS');
$sheet->getStyle('G3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('G3:J3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('G3:J3')->getFont()->setBold(true);
$sheet->getStyle('G3:J3')->getFont()->setSize(10);
$sheet->getStyle('G3:J3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'], // Blue color
    ],
]);

// Merge and center cells for DAYS CALCULATION
$sheet->mergeCells('K3:P3');
$sheet->setCellValue('K3', 'DAYS CALCULATION');
$sheet->getStyle('K3:O3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K3:O3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('K3:O3')->getFont()->setBold(true);
$sheet->getStyle('K3:O3')->getFont()->setSize(10);
$sheet->getStyle('K3:O3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F4B084'], // Black color
    ],
]);

// Merge and center cells for SALARY AS PER NO OF DAYS
$sheet->mergeCells('Q3:T3');
$sheet->setCellValue('Q3', 'SALARY AS PER NO OF DAYS');
$sheet->getStyle('Q3:T3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('Q3:T3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('Q3:T3')->getFont()->setBold(true);
$sheet->getStyle('Q3:T3')->getFont()->setSize(10);
$sheet->getStyle('Q3:T3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'BDD7EE'], // Pink color
    ],
]);

// Merge and center cells for DEDUCTION
$sheet->mergeCells('U3:AA3');
$sheet->setCellValue('U3', 'DEDUCTION');
$sheet->getStyle('U3:AA3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('U3:AA3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('U3:AA3')->getFont()->setBold(true);
$sheet->getStyle('U3:AA3')->getFont()->setSize(10);
$sheet->getStyle('U3:AA3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '00B0F0'], // Green color
    ],
]);

$sheet->mergeCells('AB3:AB4');
$sheet->setCellValue('AB3', 'BONUS');
$sheet->getStyle('AB3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('AB3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('AB3')->getFont()->setBold(true);
$sheet->getStyle('AB3')->getFont()->setSize(10);
$sheet->getStyle('AB3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFD961'], // Peach color
    ],
]);

$sheet->mergeCells('AC3:AE3');
$sheet->setCellValue('AC3', 'BANK TRANSFER DETAILS');
$sheet->getStyle('AC3:AE3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('AC3:AE3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('AC3:AE3')->getFont()->setBold(true);
$sheet->getStyle('AC3:AE3')->getFont()->setSize(10);
$sheet->getStyle('AC3:AE3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFC000'], // Peach color
    ],
]);

// Merge and center cells for OTHER DETAILS
$sheet->mergeCells('AF3:AN3');
$sheet->setCellValue('AF3', 'OTHER DETAILS');
$sheet->getStyle('AF3:AN3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('AF3:AN3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('AF3:AN3')->getFont()->setBold(true);
$sheet->getStyle('AF3:AN3')->getFont()->setSize(10);
$sheet->getStyle('AF3:AN3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'], // Navy blue color
    ],
]);

$highlightedCells = ['B4', 'C4', 'D4', 'E4', 'F4']; // Specify the cells to highlight

// Apply fill color to the specified cells
foreach ($highlightedCells as $cell) {
    $sheet->getStyle($cell)->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFC000'], // Orange color
        ],
    ]);
}
// Fill color for the specified cells
$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '92D050'], // Green color
    ],
];

$sheet->getStyle('G4:J4')->applyFromArray($styleArray);
$sheet->getStyle('A4:AN4')->getFont()->setSize(10);
$sheet->getRowDimension(4)->setRowHeight(50);

// Merge the existing headers with the new headers
$headers = [
    'A4' => 'Sr No.',
    'B4' => 'TRAN ID',
    'C4' => 'EMPLOYEE NAME',
    'D4' => 'EMPLOYEE ID',
    'E4' => 'DEPARTMENT',
    'F4' => 'DESIGNATION',
    'G4' => 'BASIC SALARY',
    'H4' => 'HRA',
    'I4' => 'OTHER ALLOWANCE',
    'J4' => 'GROSS SALARY',
    'K4' => 'TOTAL NO. OF DAYS',
    'L4' => 'PRESENT DAYS',
    'M4' => 'WEEK OFF DAYS',
    'N4' => 'LEAVES',
    'O4' => 'LOP', 
    'P4' => 'PAY DAYS',
    'Q4' => 'BASIC SALARY',
    'R4' => 'HRA',
    'S4' => 'OTHER ALLOWANCE',
    'T4' => 'GROSS SALARY',
    'U4' => 'EPF',
    'V4' => 'ESIC',
    'W4' => 'TDS',
    'X4' => 'ADVANCE SALARY',
    'Y4' => 'LABOUR AND WELFARE FUND',
    'Z4' => 'LOAN & MISC',
    'AA4' => 'TOTAL DEDUCTION',
    'AB4' => 'BONUS',
    'AC4' => 'SALARY PAYOUT',
    'AD4' => 'BENEFICIARY IFSC',
    'AE4' => 'BENEFICIARY ACCOUNT TYPE',
    'AF4' => 'BENEFICIARY ACCOUNT NO',
    'AG4' => 'SENDER ACCOUNT TYPE',
    'AH4' => 'SENDER ACCOUNT NO',
    'AI4' => 'SENDER NAME',
    'AJ4' => 'SMS EML',
    'AK4' => 'DETAIL',
    'AL4' => 'OoR7002 (SENDER NAME)',
    'AM4' => 'SENDER TO RECEIVER INFORMATION',
    'AN4' => 'REMARKS'
];



    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
        $sheet->getStyle($cell)->getAlignment()->setWrapText(true); // Wrap text
        $sheet->getStyle($cell)->getFont()->setBold(true); // Set bold font
        $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set center alignment
    }

    // Fetch data and populate the spreadsheet
    $row = 5; // Start from row 2
    while ($data = mysqli_fetch_assoc($query)) {
        $sheet->setCellValue('A' . $row, $cnt . '');
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('B' . $row, $data['transid']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('C' . $row, $data['empname']);
        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('D' . $row, $data['emp_no']);
        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('E' . $row, $data['dept']);
        $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('F' . $row, $data['desg']);
        $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('G' . $row, $data['fbp']);
        $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('H' . $row, $data['fhra']);
        $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('I' . $row, $data['foa']);
        $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('J' . $row, $data['fgs']);
        $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('K' . $row, $data['monthdays']);
        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('L' . $row, $data['present']);
        $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('M' . $row, $data['sundays']);
        $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('N' . $row, $data['leaves']);
        $sheet->getStyle('N' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('O' . $row, $data['flop']);
        $sheet->getStyle('O' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('P' . $row, $data['paydays']);
        $sheet->getStyle('P' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('Q' . $row, $data['bp']);
        $sheet->getStyle('Q' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('R' . $row, $data['hra']);
        $sheet->getStyle('R' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('S' . $row, $data['oa']);
        $sheet->getStyle('S' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('T' . $row, $data['gross']);
        $sheet->getStyle('T' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('U' . $row, $data['epf1']);
        $sheet->getStyle('U' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('V' . $row, $data['esi1']);
        $sheet->getStyle('V' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('W' . $row, $data['tds']);
        $sheet->getStyle('W' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('X' . $row, '0');
        $sheet->getStyle('X' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('Y' . $row, '0');
        $sheet->getStyle('Y' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('Z' . $row, $data['MISC']);
        $sheet->getStyle('Z' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('AA' . $row, $data['totaldeduct']);
        $sheet->getStyle('AA' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      
        $sheet->setCellValue('AB' . $row, $data['bonus']);
        $sheet->getStyle('AB' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AC' . $row, $data['payout']);
        $sheet->getStyle('AC' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AD' . $row, $data['sifsc']);
        $sheet->getStyle('AD' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AE' . $row, '10');
        $sheet->getStyle('AE' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValueExplicit('AF' . $row, $data['sban'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('AF' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AG' . $row, '11');
        $sheet->getStyle('AG' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValueExplicit('AH' . $row,'436205000047', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('AH' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AI' . $row,'ANIKA STERILIS PRIVATE LIMITED');
        $sheet->getStyle('AI' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AJ' . $row,'EML');
        $sheet->getStyle('AJ' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AK' . $row,'info@anikasterilis.com');
        $sheet->getStyle('AK' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AL' . $row,'ANIKA STERILIS PRIVATE LIMITED');
        $sheet->getStyle('AL' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AM' . $row,'');
        $sheet->getStyle('AM' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('AN' . $row,'');
        $sheet->getStyle('AN' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
     
        $sheet->getRowDimension($row)->setRowHeight($valueRowHeight);
        $sheet->getStyle('A' . $row . ':AN' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // Increment row count
        $row++;
        $cnt++;
    }

    // Apply borders to the entire sheet
    $highestRowWithData = $sheet->getHighestRow();
    $highestColumnWithData = $sheet->getHighestColumn();
    $rangeWithData = 'A2:' . $highestColumnWithData . $highestRowWithData;

    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];

    $sheet->getStyle($rangeWithData)->applyFromArray($styleArray);
// Set font for the entire sheet
$sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setName('Times New Roman');

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Salary Statement-' . $smonth . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Create a writer and output the spreadsheet
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

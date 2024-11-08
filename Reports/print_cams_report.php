
<?php
use Dompdf\Dompdf;
use Dompdf\Options;

require '../dompdf/autoload.inc.php';

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

ob_start();
require('details_cams_report.php');

$html =
ob_get_clean();


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('Report.pdf',['Attachment'=>false]);

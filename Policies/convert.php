<?php
use Dompdf\Dompdf;
use Dompdf\Options;

require '../dompdf/autoload.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['html'])) {
    $htmlContent = $_POST['html'];

    // Initialize DOMPDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);

    // (Optional) Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="converted-file.pdf"');
    echo $dompdf->output();
}
?>

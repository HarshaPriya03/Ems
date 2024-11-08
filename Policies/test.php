<?php
// Include PHPWord and DOMPDF
require 'PHPWord/bootstrap.php';

use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;

require '../dompdf/autoload.inc.php';

function convertDocxToHtml($filePath) {
    $phpWord = IOFactory::load($filePath);
    $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
    ob_start();
    $htmlWriter->save('php://output');
    $htmlContent = ob_get_clean();
    return $htmlContent;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['attachment'])) {
    $filePath = $_FILES['attachment']['tmp_name'];

    // Convert .docx to HTML
    $htmlContent = convertDocxToHtml($filePath);

    // Initialize DOMPDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);

    // (Optional) Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF (to the browser or save to file)
    $dompdf->stream("converted-file.pdf", array("Attachment" => false)); // Set to true to download the PDF
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Convert DOCX to PDF</title>
</head>
<body>
    <h2>Upload and Convert DOCX to PDF</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="attachment">Choose a DOCX file:</label>
            <input type="file" id="attachment" name="attachment" accept=".doc, .docx" required>
        </div>
        <div>
            <button type="submit">Upload and Convert</button>
        </div>
    </form>
</body>
</html>
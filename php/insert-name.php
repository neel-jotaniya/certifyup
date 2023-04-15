<?php
require_once('fpdf/fpdf.php');
require_once('FPDI-2.3.7/src/autoload.php');

use setasign\Fpdi\Fpdi;
$name = $_POST['name'];
function insertTextInPdf($pdfUrl, $text, $newPdfUrl) {
    // initiate FPDI
    $pdf = new Fpdi();

    // set the source file
    $pdf->setSourceFile($pdfUrl);

    // set the page format, orientation and size
    $pageId = $pdf->importPage(1);
    $size = $pdf->getTemplateSize($pageId);
    $pdf->AddPage($size['orientation'], $size);

    // use the imported page
    $pdf->useTemplate($pageId);

    // set font and text color
    $pdf->SetFont('Arial', '', 25);
    $pdf->SetTextColor(0, 0, 0);

    // calculate the width of the text
    $textWidth = $pdf->GetStringWidth($text);

    // calculate the x-coordinate position for centered text
    $x = ($size['width'] - $textWidth) / 2;

    // add the text
    $pdf->SetXY($x, 85);
    $pdf->Write(0, $text);

    // save the PDF with a new name
    $pdf->Output($newPdfUrl, 'F');
}
$newPdfUrl = 'pdfs/Minimal Abstract Blue and White Certificate of Appreciation.pdf-edited';

insertTextInPdf('Minimal Abstract Blue and White Certificate of Appreciation.pdf', $name, 'Minimal Abstract Blue and White Certificate of Appreciation-edited.pdf');


// call the refreshPDF function to update the PDF viewer
echo '<script>refreshPDF("' . $newPdfUrl . '")</script>';
header("Location: ../create-template.html");
exit;
?>

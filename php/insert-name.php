<?php
require_once('fpdf/fpdf.php');
require_once('FPDI-2.3.7/src/autoload.php');
use setasign\Fpdi\Fpdi;



$name = $_POST['name'];
$c = $_POST['c'];
$c = intval($c);
$data = $_POST['data'];
$sign1 = $_POST['sign1'];
$sign2 = $_POST['sign2'];

echo $c;
if ($c==6){
    $c = 1;
}
elseif ($c ==7){
    $c = 2;
}
elseif ($c == 8){
    $c = 3;
}
elseif ($c == 9){
    $c == 4;

}
elseif ($c == 10){
    $c = 5;
}


$mysqli = new mysqli('localhost', 'root', '', 'user-info');

if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}
$sql = "SELECT `name-y`, `name-color`, `data-y`, `sign-1-y`, `sign-2-y`,`sign-1-x`, `sign-2-x` FROM `certificates-info` WHERE `c` = $c";



$result = $mysqli->query($sql);

if (!$result) {
    echo 'Error executing query: ' . $mysqli->error;
    exit();
}

$row = $result->fetch_assoc();
print_r($row);
$name_y = $row['name-y'];
echo $name_y;
$name_color = $row['name-color'];
$data_y = $row['data-y'];

$sign1_y = $row['sign-1-y'];
$sign1_x = $row['sign-1-x'];

$sign2_y = $row['sign-2-y'];
$sign2_x = $row['sign-2-x'];

$result->free();
$mysqli->close();


switch ($c) {
    case 1:
      $pdfUrl = 'Blue Modern Elegant Achievement Certificate.pdf';
      break;
    case 2:
      $pdfUrl = 'Blue Yellow Minimalist Internship Certificate.pdf';
      break;
    case 3:
      $pdfUrl = 'Minimal Abstract Blue and White Certificate of Appreciation.pdf';
      break;
    case 4:
      $pdfUrl = 'Orange Blue Course Badge Certificate.pdf';
      break;
    case 5:
      $pdfUrl = 'Blue and Yellow Minimalist Employee of the Month Certificate.pdf';
      break;
   
  }
  
$newPdfUrl = substr($pdfUrl, 0, strrpos($pdfUrl, ".")) . "-edited.pdf";
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

// calculate the width of the text1
$text1Width = $pdf->GetStringWidth($name);
// calculate the x-coordinate position for text1
$x1 = ($size['width'] - $text1Width) / 2;
// add text1
$pdf->SetXY($x1, $name_y);
$pdf->Write(0, $name);

// calculate the width of the text2
$text2Width = $pdf->GetStringWidth($data);
// calculate the x-coordinate position for text2
$x2 = ($size['width'] - $text2Width) / 2;
// add text2
$pdf->SetXY($x2, $data_y);
$pdf->Write(0, $data);
if ($c != 2 || $c != 4){
// calculate the width of the text3
$text3Width = $pdf->GetStringWidth($sign1);
// calculate the x-coordinate position for text3
$x3 = $sign1_x;
// add text3
$pdf->SetXY($x3, $sign1_y);
$pdf->Write(0, $sign1);

// calculate the width of the text4
$text4Width = $pdf->GetStringWidth($sign2);
// calculate the x-coordinate position for text4
$x4 = $sign2_x;
// add text4
$pdf->SetXY($x4, $sign2_y);
$pdf->Write(0, $sign2);
}
// save the PDF with a new name
if (file_exists($newPdfUrl)) {
    // delete existing file
    unlink($newPdfUrl);
}

$pdf->Output($newPdfUrl, 'F');


// call the refreshPDF function to update the PDF viewer
$c += 5;
echo '<script>refreshPDF("' . $newPdfUrl . '")</script>';
header("Location: ../create-template.html?c=$c");
exit;
?>
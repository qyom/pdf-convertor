<?php header('Access-Control-Allow-Origin: *');

require_once('WkHtmlToPdf.php');

$pdf = new WkHtmlToPdf;

$pdf->setPageOptions(array(
    'orientation' => 'landscape',
//    'page-size' => 'A4',
    'page-height' => '390mm',
    'page-width' => '255mm',
));

$pdfData = '';
if(isset($_POST['pdfData'])){
    $pdfData = $_POST['pdfData'];
};

$saveToFile = false;
if(isset($_POST['saveToFile'])){
    $saveToFile = $_POST['saveToFile'];
};

// Add a HTML file, a HTML string or a page from URL
//  $pdf->addPage('http://google.com');

$html =
    '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'.
    '<head>'.
    '<title>linesheet layout</title>'.
    '<link href="linesheet.css" media="all" rel="stylesheet" type="text/css" />'.
    '</head><body>'.
    $pdfData.
    '</body></html>';

file_put_contents("tmp/tmp.html", $html);

//  $pdf->addPage($html);
$pdf->addPage('/home/zizicoco/www/utils/pdf/tmp/tmp.html');

// Save the PDF
// $pdf->saveAs('tmp/tmp.pdf');

// Send to client for inline display
if($saveToFile){
    if(!$pdf->send("linesheet.pdf")){
        throw new Exception('Could not save PDF: '.$pdf->getError());
    }

}
else{
    if(!$pdf->send()){
        throw new Exception('Could not display PDF: '.$pdf->getError());
    }
}

<?php // header('Access-Control-Allow-Origin: *');

require_once('WkHtmlToPdf.php');

$pdfData = '';
if(isset($_POST['pdfData'])){
    $pdfData = $_POST['pdfData'];
};

$saveToFile = false;
if(isset($_POST['saveToFile'])){
    $saveToFile = true;
};

$orientation = 'landscape';
if(isset($_POST['portrait'])){
    $orientation = 'portrait';
};

$pdf = new WkHtmlToPdf;

$pdf->setPageOptions(array(
    'orientation' => $orientation,
//    'page-size' => 'A4',
    'page-height' => '400mm',
    'page-width' => '270mm',
));

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
        print "Something went wrong on downloading the file, please try again.<br/>";
        print "If problem persists please contact our customer support.";
        // throw new Exception('Could not save PDF: '.$pdf->getError());
        // trigger_error("Incorrect input vector, array of values expected", E_USER_WARNING);
    }

}
else{
    if(!$pdf->send()){

        print "Something went wrong on displaying the preview, please try again.<br/>";
        print "If problem persists please contact our customer support.";
        // throw new Exception('Could not display PDF: '.$pdf->getError());
        // trigger_error("Incorrect input vector, array of values expected", E_USER_WARNING);
    }
}

function errorReporter() {
    echo "Error message goes here";
}

set_error_handler('errorReporter');
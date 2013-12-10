<?php // header('Access-Control-Allow-Origin: *');

require_once('WkHtmlToPdf.php');

$arrPageFormats =array(
    "Legal"=>array("width"=>215.9, "height"=>355.6),
    "Letter"=>array("width"=>215.9, "height"=>279.4),
    "Executive"=>array("width"=>184, "height"=>267),
    "A3"=>array("width"=>297, "height"=>420),
    "A4"=>array("width"=>210, "height"=>297),
    "A5"=>array("width"=>148, "height"=>210),
    "A6"=>array("width"=>105, "height"=>148),
    "B4 JIS"=>array("width"=>257, "height"=>364),
    "B5 JIS"=>array("width"=>182, "height"=>257)
);

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

$pageFormat = $arrPageFormats["Letter"];
if(isset($_POST['pageFormat'])){
    $pageFormat = $arrPageFormats[$_POST['pageFormat']];
};

$pdf = new WkHtmlToPdf;

$pdf->setPageOptions(array(
    'orientation' => $orientation,
//    'page-size' => 'A4',
    'page-height' => $pageFormat["height"],
    'page-width' => $pageFormat["width"],
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
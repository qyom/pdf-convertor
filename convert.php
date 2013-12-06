<?php header('Access-Control-Allow-Origin: *');

require_once('WkHtmlToPdf.php');

$pdf = new WkHtmlToPdf;

$pdf->setPageOptions(array(
    'orientation' => 'landscape',
//    'page-size' => 'A4',
//    'page-height' => '362mm',
//    'page-width' => '170mm',
));

$pdfData = '';
if(isset($_POST['pdfData'])){
    $pdfData = $_POST['pdfData'];
};

// Add a HTML file, a HTML string or a page from URL
// $pdf->addPage('linesheet/ls.htTTml');

// $pdf->addPage('<html>....</html>');
//$pdf->addPage('http://google.com');
// Add a cover (same sources as above are possible)
// $pdf->addCover('mycover.html');
// Add a Table of contents
// $pdf->addToc();
// Save the PDF

$html =
    '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'.
    '<head>'.
    '<title>linesheet layout</title>'.
    '<link href="linesheet.css" media="all" rel="stylesheet" type="text/css" />'.
    '</head><body>'.
    $pdfData.
    '</body></html>';

file_put_contents("linesheet/ls.html", $html);

//$pdf->addPage($html);
//$pdf->addPage(file_get_contents("linesheet/ls.html"));
// $pdf->addPage('ls.html');
$pdf->addPage('http://localhost/wkhtmltopdf/linesheet/ls.html');

//$pdf->saveAs('linesheet/ls.pdf');

if(!$pdf->saveAs('linesheet/ls.pdf'))
    throw new Exception('Could not create PDF: '.$pdf->getError());
// ... or send to client for inline display
//  $pdf->send();
// ... or send to client as file download
// $pdf->send('ls.pdf');


//$pdf=new WKPDF();
//$pdf->set_url('http://google.com');
//$pdf->render();
//$pdf->output(WKPDF::$PDF_EMBEDDED,'converted.pdf');


//$html = file_get_contents("http://www.google.com");
//$pdf = new WKPDF();
////$pdf = new WKPDF(array(
////    // Use `wkhtmltopdf-i386` or `wkhtmltopdf-amd64`
//////    'bin' => 'path/to/vendor/bin/wkhtmltopdf-i386'
////    'bin' => 'c:/xampp/htdocs/wkhtmltopdf/bin'
////));
//$pdf->set_html($html);
//$pdf->render();
//$pdf->output(WKPDF::$PDF_EMBEDDED,'sample.pdf');
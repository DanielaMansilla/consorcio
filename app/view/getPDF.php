<?php
require_once '../lib/dompdf/autoload.inc.php'; 


use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
require_once ('comprobantePago.php'); 
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4','landscape');
$dompdf->render();
$dompdf->stream('comprobante-'.time());

    
?>
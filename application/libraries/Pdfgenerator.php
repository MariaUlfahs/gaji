<?php
require_once("./dompdf/autoload.inc.php");
use Dompdf\Dompdf;
class Pdfgenerator {
 	public function generate($html,$filename) {
		define('DOMPDF_ENABLE_AUTOLOAD', false);
		$dompdf = new DOMPDF();
		$dompdf->set_option( 'isRemoteEnabled',true);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream($filename.'.pdf',array("Attachment"=>0));
	}
}
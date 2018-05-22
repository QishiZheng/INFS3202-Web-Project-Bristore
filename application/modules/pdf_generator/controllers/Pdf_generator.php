<?php
class Pdf_generator extends MX_Controller {
	function __construct() {
		parent::__construct();
	}


	function index() {
        // Require composer autoload
        require_once '/Applications/XAMPP/xamppfiles/htdocs/bristore/vendor/autoload.php';
        // Create an instance of the class:
        $mpdf = new \Mpdf\Mpdf();

        // Write some HTML code:
        $mpdf->WriteHTML('Hello World');

        // Output a PDF file directly to the browser
        $mpdf->Output();
    }

}
<?php
class Pdf_generator extends MX_Controller {
	function __construct() {
		parent::__construct();
	}


	function index() {

    }

    function generate_invoice($order_id, $content) {
        $data['order_id'] = $order_id;

        $data['html'] = '<h1>Order Invoice</h1><table width="100%" align="left">'.$content.'</table>';

        //echo $data['html'];die();
        $this->load->library('Pdf');
        $this->load->view('invoice_pdf', $data);
    }

}
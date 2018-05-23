<?php
class Email_helper extends MX_Controller {
	function __construct() {
		parent::__construct();
	}

    //TODO: implenment fully working email service
    //Send email
    function send_email($receiver, $subject, $message){
        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->set_mailtype('html');
        $this->email->from('customer_service@bristore.com', 'Bristore');
        $this->email->to($receiver);

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
        echo "sent!";
    }
}
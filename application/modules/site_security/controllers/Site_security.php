<?php
class site_security extends MX_Controller {
	function __construct() {
		parent::__construct();
	}
//	//link to templates/Templates.php in order to load tempalte
//	function account_manage(){
//	    //TODO: need to check after complete the logic
////	    $this->_make_sure_is_admin();
//
//
//        //set the template name
//        $data['view_file'] = "account_manage";
//        //load template
//        $this->load->module('templates');
//
//        //send info back to super template [admin]
//        $this->templates->admin($data);
//    }

    function _make_sure_is_admin() {
	    $is_admin = TRUE;

	    if ($is_admin != TRUE) {
	        redirect(base_url().'site_security/not_allowed');
        }
    }

    function not_allowed() {

	    echo "You are not allowed to be here";
    }
}
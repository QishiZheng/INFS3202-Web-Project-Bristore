<?php
class site_security extends MX_controller {
	function __construct() {
		parent::__construct();
	}

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
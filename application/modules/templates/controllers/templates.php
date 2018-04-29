<?php
	class Templates extends MX_Controller
    {
        function __construct() {
            parent::__construct();
        }

        function test() {
            $data = "";
            $this->admin($data);
        }

        function public_bootstrap($data) {
            //if view_module is not set, then set it as the first segment of url
            if(!isset($data['view_module'])) {
                $data['view_module'] = $this->uri->segment(1);
            }
            $this->load->view('public_bootstrap', $data);
        }

        //jQuery mobile
        function public_jqm($data) {
            if(!isset($data['view_module'])) {
                //if view_module is not set, then set it as the first segment of url
                $data['view_module'] = $this->uri->segment(1);
            }
            $this->load->view('public_jqm', $data);
        }

        //load the admin page
        function admin($data) {
            //if view_module is not set, then set it as the first segment of url
            if(!isset($data['view_module'])) {
                $data['view_module'] = $this->uri->segment(1);
            }

            $this->load->view('admin', $data);
        }
        //load account manage template from site_security/views/account_manage.php
        function account_manage(){

            if(!isset($data['view_module'])) {
                $data['view_module'] = $this->uri->segment(1);
            }

            $this->load->view('account_manage', $data);
        }
    }
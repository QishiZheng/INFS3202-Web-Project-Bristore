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
            $this->load->view('public_bootstrap', $data);
        }

        //jQuery mobile
        function public_jqm($data) {
            $this->load->view('public_jqm', $data);
        }

        function admin($data) {
            $this->load->view('admin', $data);
        }
    }
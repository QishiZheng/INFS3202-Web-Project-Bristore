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

        //load shop template page and transfer data to this view page
        function shop($data) {
            //if view_module is not set, then set it as the first segment of url
            if(!isset($data['view_module'])) {
                $data['view_module'] = $this->uri->segment(1);
            }
            $this->load->view('shop', $data);
        }

        //jQuery mobile
        function public_jqm($data) {
            if(!isset($data['view_module'])) {
                //if view_module is not set, then set it as the first segment of url
                $data['view_module'] = $this->uri->segment(1);
            }
            $this->load->view('public_jqm', $data);
        }

        //load admin template page and transfer data to this view page
        function admin($data) {
            //if view_module is not set, then set it as the first segment of url
            if(!isset($data['view_module'])) {
                $data['view_module'] = $this->uri->segment(1);
            }

            $this->load->view('admin', $data);
        }

        function store($data) {
            //if view_module is not set, then set it as the first segment of url
            if(!isset($data['view_module'])) {
                $data['view_module'] = $this->uri->segment(1);
            }
            $this->load->view('store', $data);
        }

    }
<?php
class Home extends CI_Controller {

    public function goHome() {
        $this->load->view('homePage');
    }
}
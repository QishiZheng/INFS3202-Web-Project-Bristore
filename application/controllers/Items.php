<?php
class Items extends CI_Controller {

    public function index() {
        $data['title'] = 'All Items';

        $data['items'] = $this->Item_model->get_items();

        $this->load->view('templates/header');
        $this->load->view('items/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($id = NULL) {
        $data['item'] = $this->Item_model->get_items($id);

        if(empty($data['item'])) {
            show_404();
        }
        $data['title'] = $data['item']['title'];

        $this->load->view('templates/header');
        $this->load->view('items/view', $data);
        $this->load->view('templates/footer');
    }
}
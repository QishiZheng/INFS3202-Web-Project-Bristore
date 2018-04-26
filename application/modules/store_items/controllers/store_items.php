<?php
class Store_items extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}

    function create() {
	    //check if the user is admin
        $this ->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        $update_id = $this->uri->segment(3);
        $submit = $this->input->post('submit', TRUE);

        if($submit=="Submit") {
            //validate the form
            //$this->load->library('form_validation');
            $this->form_validation->set_rules('item_title', 'Item Title', 'required|max_length[240]|callback_item_check');
            $this->form_validation->set_rules('item_price', 'Item Price', 'required|numeric|callback_check_positive');
            $this->form_validation->set_rules('item_stock', 'Item Stock', 'required|numeric|callback_check_positive');
            $this->form_validation->set_rules('item_category', 'Item Category', 'required|max_length[240]');
            $this->form_validation->set_rules('item_description', 'Item Description', 'required');

            //update or insert a new item if all user inputs are correct
            if($this->form_validation->run() == TRUE) {
                //fetch the user input
                $data=$this->fetch_data_from_post();
                $data['item_url'] = url_title($data['item_title']);

                if(is_numeric($update_id)) {
                    //update the details of the item with $update_id
                    $this->_update($update_id, $data);
                    $flash_msg = "This item details were successfully updated!";
                    $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
                    $this->session->set_flashdata('item', $value);
                    redirect('store_items/create/'.$update_id);
                } else {
                    //insert a new item
                    echo $data['item_title'];
                    $this->_insert($data);
                    $update_id = $this->get_max();//the id of newly added item
                    $flash_msg = "This item was successfully added!";
                    $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
                    $this->session->set_flashdata('item', $value);
                    redirect('store_items/create/'.$update_id);
                }
            }
        } elseif($submit == "Cancel") {
            redirect('store_items/manage');
        }

        if((is_numeric($update_id)) && ($submit != "Submit")) {
            $data = $this->fetch_data_from_db($update_id);
        } else {
            $data = $this->fetch_data_from_post();
        }

        //change the header depending on whether updating or inserting
        if(!is_numeric($update_id)) {
            $data['headline'] = "Add New Item";
        } else {
            $data['headline'] = "Update Item Details";
        }

        //set $data and load views
        $data['update_id'] = $update_id;
        $data['flash'] = $this->session->flashdata('item');
       // $data['view_module'] = "store_items";
        $data['view_file'] = "create";
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    function upload_img($update_id) {
        //check if the user is admin
        $this ->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //set $data and load views
        $data['headline'] = "Upload Images of Item ".$update_id;
        $data['update_id'] = $update_id;
        $data['flash'] = $this->session->flashdata('item');
        // $data['view_module'] = "store_items";
        $data['view_file'] = "upload_img";
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    //do actual uploading
    function do_upload($update_id)
    {
        //check if the user is admin
        $this ->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        $submit = $this->input->post('submit', TRUE);
        if ($submit == "Cancel") {
            redirect('store_items/create/'.$update_id);
        }

        $config['upload_path']          = './item_pics/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;
        $config['max_width']            = 6000 ;
        $config['max_height']           = 4000;

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('userfile'))
        {

            //set $data and load views
            $data['error'] = array('error' => $this->upload->display_errors());
            $data['headline'] = "Upload Error ".$update_id;
            $data['update_id'] = $update_id;
            $data['flash'] = $this->session->flashdata('item');
            // $data['view_module'] = "store_items";
            $data['view_file'] = "upload_img";
            $this->load->module('templates');
            $this->templates->admin($data);
        }
        else
        {

            //set $data and load views
            $data = array('upload_data' => $this->upload->data());
            $data['headline'] = "Images uploaded successfully for Item ".$update_id;
            $data['update_id'] = $update_id;
            $data['flash'] = $this->session->flashdata('item');
            $data['view_file'] = "upload_success";
            $this->load->module('templates');
            $this->templates->admin($data);
        }
    }


    //show the item management page
	function manage() {
	    //load security module and check if is admin
	    $this ->load->module('site_security');
	    $this->site_security->_make_sure_is_admin();

	    $data['query'] = $this->get('item_title');

	    //$data['view_module'] = "store_items";
	    $data['view_file'] = "manage";
	    $this->load->module('templates');
	    $this->templates->admin($data);
    }

    function fetch_data_from_post() {
	    $data['item_title'] = $this->input->post('item_title', TRUE);
        $data['item_price'] = $this->input->post('item_price', TRUE);
        $data['item_stock'] = $this->input->post('item_stock', TRUE);
        $data['item_category'] = $this->input->post('item_category', TRUE);
        $data['item_description'] = $this->input->post('item_description', TRUE);
        return $data;
    }

    function fetch_data_from_db($update_id) {
	    $query = $this->get_where($update_id);
	    foreach($query->result() as $row) {
	        $data['item_title'] = $row->item_title;
            $data['item_url'] = $row->item_url;
            $data['item_price'] = $row->item_price;
            $data['item_stock'] = $row->item_stock;
            $data['item_category'] = $row->item_category;
            $data['item_description'] = $row->item_description;
            $data['item_pic'] = $row->item_pic;
            $data['item_created_at'] = $row->item_created_at;
        }

        if(!isset($data)) {
	        $data = "";
        }

        return $data;
    }

	function get($order_by) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_insert($data);
	}

	function _update($id, $data) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_update($id, $data);
	}

	function _delete($id) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_delete($id);
	}

	function count_where($col, $value) {
		$this->load->model('mdl_store_items');
		$count = $this->mdl_store_items->count_where($col, $value);
		return $count;
	}

	function get_max() {
		$this->load->model('mdl_store_items');
		$max_id = $this->mdl_store_items->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_custom_query($mysql_query);
		return $query;
	}


	//check if the item with the title is in the db
	function item_check($item_title) {
	    $item_url = url_title($item_title);
        $my_query = "SELECT * FROM items WHERE item_title = '$item_title' AND item_url = '$item_url'";
        $update_id = $this->uri->segment(3);

        //add update_id to query if $update_id is numeric
        if(is_numeric($update_id)){
            $my_query.=" AND id!=$update_id";
        }

        //get the number of rows in db that has same item_title and item_url
        $query = $this->_custom_query($my_query);
        $num_rows =$query->num_rows();
        //give error if there is exists a row with the query condition in the db
	    if($num_rows>0) {
            $this->form_validation->set_message('item_check', 'The Item Title is already in the database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //check if the number is greater than 0
    function check_positive($num)
    {
        // Don't run bother checking if we have a form error on check_positive
        if  (form_error('item_stock')) {
            return true;
        }

        $num = intval($num);
        if ($num < 0) {
            $this->form_validation->set_message('check_positive', "The stock/price must be more than 0.");
            return false;
        }
        return true;
    }

}
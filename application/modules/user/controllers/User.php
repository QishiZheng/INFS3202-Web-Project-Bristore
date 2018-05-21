<?php
class User extends MX_Controller {
	function __construct() {
		parent::__construct();

        $this->load->module(array('store_items', 'auth', 'templates'));
        $this->load->library(array('ion_auth'));
	}

	//show the user profile page
    function index(){
        $this->auth->login_check();
        $data['view_file'] = "profile";
        $this->templates->shop($data);
    }


    //show the user my_orders page
    function my_orders() {
        $this->auth->login_check();
        $data['view_file'] = "my_orders";
        $this->templates->shop($data);
    }

	function get($order_by) {
		$this->load->model('user_model');
		$query = $this->user_model->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('user_model');
		$query = $this->user_model->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) {
		$this->load->model('user_model');
		$query = $this->user_model->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) {
		$this->load->model('user_model');
		$query = $this->user_model->get_where_custom($col, $value);
		return $query;
	}

	function _inset($data) {
		$this->load->model('user_model');
		$query = $this->user_model->_inset($data);
	}

	function _update($id, $data) {
		$this->load->model('user_model');
		$query = $this->user_model->_update($id, $data);
	}

	function _delete($id) {
		$this->load->model('user_model');
		$query = $this->user_model->_delete($id);
	}

	function count_where($col, $value) {
		$this->load->model('user_model');
		$count = $this->user_model->count_where($col, $value);
		return $count;
	}

	function get_max() {
		$this->load->model('user_model');
		$max_id = $this->user_model->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$this->load->model('user_model');
		$query = $this->user_model->_custom_query($mysql_query);
		return $query;
	}


	//get details of this user
    private function fetch_user_data_from_db($id) {
        //execute the query that retrieves the data of user with given id
        $query = $this->get_where($id);
        foreach($query->result() as $row) {
            $user['id'] = $row->id;
            $user['username'] = $row->username;
            $user['email'] = $row->email;
            $user['first_name'] = $row->first_name;
            $user['last_name'] = $row->last_name;
            $user['phone'] = $row->phone;
            $user['address'] = $row->address;
        }

        if(!isset($user)) {
            $user = "";
        }

        return $user;
    }
}
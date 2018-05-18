<?php
class User extends MX_Controller {
	function __construct() {
		parent::__construct();
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
    private function fetch_data_from_db($id) {
        //check the update_id
        if(!is_numeric($id)) {
            redirect('site_security/not_allowed');
        }
        //execute the query that retrieves the data of item with given id
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
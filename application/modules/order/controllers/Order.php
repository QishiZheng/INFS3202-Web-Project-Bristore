<?php
class Order extends MX_Controller {
	function __construct() {
		parent::__construct();
        $this->load->module('cart');
        $this->load->module('auth');
        $this->load->library('ion_auth');
	}


    function index(){
        $this->auth->admin_check();
        $data['view_file'] = "order";
        $this->load->module('templates');;
        $this->templates->admin($data);
    }
	//create a new order for current logged in user
	public function create_order(){

    }

    //show the order management page
    function manage() {
        //load security module and check if is admin
        $this->load->library('session');
        //security check
        $this->auth->login_check();
        $this->auth->admin_check();

        $data['query'] = $this->get('id');
        $data['view_file'] = "manage";
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    //insert data to order table
    function _insert_order($data) {
        $this->load->model('order_model');
        $query = $this->order_model->_insert($data);
    }
    //insert data to order_items table
    function _insert_order_items($data) {
        $this->load->model('order_items_model');
        $query = $this->order_items_model->_insert($data);
    }

    //get all rows in orders table ordered by $ordered_by
	function get_orders($order_by) {
		$this->load->model('order_model');
		$query = $this->order_model->get($order_by);
		return $query;
	}

    //get all rows in order_items ordered by $ordered_by
    function get_order_items($order_by) {
        $this->load->model('order_items_model');
        $query = $this->order_items_model->get($order_by);
        return $query;
    }

    //get orders with given limits
	function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('order_model');
		$query = $this->order_model->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	//get order with given order_id
	function get_order_where($id) {
		$this->load->model('order_model');
		$query = $this->order_model->get_where($id);
		return $query;
	}

    //get order items with given order_id
    function get_order_items_where($id) {
        $this->load->model('order_items_model');
        $query = $this->order_items_model->get_where($id);
        return $query;
    }

    //get order with given condition
	function get_order_where_custom($col, $value) {
		$this->load->model('order_model');
		$query = $this->order_model->get_where_custom($col, $value);
		return $query;
	}

    //get order_items with given condition
    function get_order_items_where_custom($col, $value) {
        $this->load->model('order_items_model');
        $query = $this->order_items_model->get_where_custom($col, $value);
        return $query;
    }

    //update the order with given order_id and input data
	function _update_order($id, $data) {
		$this->load->model('order_model');
		$query = $this->order_model->_update($id, $data);
	}

    //update the order_item with given order_id and item_id
    function _update_order_items($order_id, $item_id, $data) {
        $this->load->model('order_items_model');
        $query = $this->order_items_model->_update($order_id, $item_id, $data);
    }

    //delete the order with given id
	function _delete_order($id) {
		$this->load->model('order_model');
		$query = $this->order_model->_delete($id);
	}


    /**
     * Delete the order_item with given id
     * May remove this method since order_id foreign key constraint
     * was set to onDelete cascade
     * */
    function _delete_order_items($order_id) {
        $this->load->model('order_model');
        $query = $this->order_model->_delete($order_id);
    }

    //count the number of rows with given condition in order table
	function count_order_where($col, $value) {
		$this->load->model('order_model');
		$count = $this->order_model->count_where($col, $value);
		return $count;
	}

    //count the number of rows with given condition in order_items table
    function count_order_items_where($col, $value) {
        $this->load->model('order_model');
        $count = $this->order_model->count_where($col, $value);
        return $count;
    }

//	function get_max() {
//		$this->load->model('order_model');
//		$max_id = $this->order_model->get_max();
//		return $max_id;
//	}

	function _custom_query($mysql_query) {
		$this->load->model('order_model');
		$query = $this->order_model->_custom_query($mysql_query);
		return $query;
	}
}
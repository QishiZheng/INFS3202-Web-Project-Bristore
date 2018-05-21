<?php
class Order extends MX_Controller {
	function __construct() {
		parent::__construct();
        $this->load->module('cart');
        $this->load->module('auth');
        $this->load->module('store_items');
        $this->load->library('ion_auth');
	}


    function index(){
        $this->auth->admin_check();
        $data['view_file'] = "order";
        $this->load->module('templates');;
        $this->templates->admin($data);
    }

	//place a order for current logged in user
	public function place_order(){
        //check if the user is logged in
	    $this->auth->login_check();
	    //check if all items in cart are in stock
	    $this->all_stock_check();

	    //get user_id
        $user_id = $this->ion_auth->get_user_id();
        $user = $this->ion_auth->user($user_id)->row();
        $s_address = $user->address;
        $b_address = $user->address;

        //create a new order
        $order_data = array(
            'shipping_address'  => $s_address,
            'billing_address'    => $b_address,
            'user_id'  => $user_id,
        );
        $this->_insert_order($order_data);
        //get this order's id
        $order_id = $this->get_latest_order_id($user_id);
        //echo $order_id;

        //get all items that are in the cart of current user
        //populate order_item table
        $query = $this->cart_model->get_where($user_id);
        foreach($query->result() as $row) {
            $item_id = $row->item_id;
            $qty = $row->qty;
            $item_data = $this->store_items->fetch_data_from_db($item_id);
            $order_items_data = array(
                'order_id'  => $order_id,
                'item_id'    => $item_id,
                'qty'  => $qty,
                'price' => $item_data['item_price'],
            );
            $this->_insert_order_items($order_items_data);

            //reduce the stock of each item that were ordered
            $update_item_data['item_stock'] = $item_data['item_stock'] - $qty;
            $this->store_items->_update($item_id, $update_item_data);
        }
        //clear this user's shopping cart
        $this->cart->clear_cart();
        //TODO: redirect user to order success page or order details page
        //TODO: pdf file generation for receipt of this order
        //TODO: send user an email that contains receipt and pdf receipt
    }


    //check all if all items in cart is in stock
    function all_stock_check() {
        //get user_id
        $user_id = $this->ion_auth->get_user_id();
        $query = $this->cart_model->get_where($user_id);
        //get all items' stock, if any item has not enough stock, redirect user to checkout page
        foreach($query->result() as $row) {
            $item_id = $row->item_id;
            $qty = $row->qty;
            $item_data = $this->store_items->fetch_data_from_db($item_id);
            if(!$this->stock_check_with_qty($item_id, $qty)) {
                //set flash data
                $flash_msg = $item_data['item_title']." only has ".$item_data['item_stock']." in stock! Please remove this item or reduce the quantity!";
                $value = '<div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
                $this->session->set_flashdata('item', $value);
                // redirect them to the home page because they must be an administrator to view this
                redirect('cart/check_out', 'refresh');
            }
        }
    }

    //check if the item stock >= qty want to order
    function stock_check_with_qty($item_id, $qty) {
	    $item_data = $this->store_items->fetch_data_from_db($item_id);
	    if($item_data['item_stock'] >= $qty) {
	        return true;
        }
        return false;
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

	//get the latest order id of the user with given user_id
	function get_latest_order_id($user_id) {
        $get_order_query = "SELECT * FROM orders WHERE user_id = '$user_id' AND id >= ALL (SELECT id FROM orders)";
        $order = $this->_custom_query($get_order_query);
        foreach ($order->result() as $row)
        {
            $order_id = $row->id;
        }
        return $order_id;
    }
}
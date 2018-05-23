<?php
class Order extends MX_Controller {
	function __construct() {
		parent::__construct();
        $this->load->module(array('store_items', 'auth', 'templates', 'cart', 'email_helper', 'pdf_generator'));
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
	    //check if the cart is empty
	    $this->cart_item_number_check();
	    //check if the user's address is empty
	    $this->address_check();

	    //get user_id
        $user_id = $this->ion_auth->get_user_id();

        $user = $this->ion_auth->user($user_id)->row();
        $s_address = $user->address;
        $b_address = $user->address;
        $receiver = $user->email;

        //create a new order
        $order_data = array(
            'shipping_address'  => $s_address,
            'billing_address'    => $b_address,
            'user_id'  => $user_id,
        );
        $this->_insert_order($order_data);
        //get this order's id
        $order_id = $this->get_latest_order_id($user_id);
        //get all items that are in the cart of current user
        $query = $this->cart_model->get_where($user_id);
        //populate order_item table
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
        //redirect user to order success page or order details page
        $this->order_success($order_id);

       //create invoice table content
        $invoice_content = $this->make_invoice($order_id);
        //pdf file generation for receipt of this order
        $this->pdf_generator->generate_invoice($order_id, $invoice_content);

        //send user an email that contains receipt and pdf receipt
        $subject = "Order Confirmation - Bristore(please do not respond)";
        $message = "<table>".$invoice_content."</table>";
        //TODO: Make it dynamic
        $pdf_invoice = "/var/www/html/invoice_pdf/".$order_id."_invoice.pdf";
        //attach pdf invoice if exist
        if(file_exists($pdf_invoice)) {
            $this->email_helper->send_email($receiver, $subject, $message, $pdf_invoice);
        } else {
            $this->email_helper->send_email($receiver, $subject, $message);
        }

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

    //check if the user's cart is empty
    function cart_item_number_check() {
        //get user_id
        $user_id = $this->ion_auth->get_user_id();
        //get number of items in this user's cart
        $num_of_items = $this->cart_model->count_where('user_id', $user_id);
        if($num_of_items == 0) {
            //set flash data
            $flash_msg = "You shopping cart is empty!";
            $value = '<div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
            $this->session->set_flashdata('item', $value);
            // redirect them to the home page because they must be an administrator to view this
            redirect('cart/check_out', 'refresh');
        }
    }

    //check if the user's address is empty
    function address_check() {
        //get user_id
        $user_id = $this->ion_auth->get_user_id();
        //get number of items in this user's cart
        $address = $this->ion_auth->user($user_id)->row()->address;
        if($address==null || $address="") {
            //set flash data
            $flash_msg = "You Do No Have A Address! Please Update Your Address In Your Profile!";
            $value = '<div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
            $this->session->set_flashdata('item', $value);
            // redirect them to the home page because they must be an administrator to view this
            redirect('cart/check_out', 'refresh');
        }
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


    //take the user to order_success page and show the user order invoice
     function order_success($order_id) {
	    $data['order_id'] = $order_id;
        $data['view_file'] = "order_success";

        $this->load->module('templates');
        $this->templates->shop($data);
    }


    //populate invoice table
    function show_invoice($order_id) {
	    //make invoice table content
        $output = $this->make_invoice($order_id);
        echo json_encode($output);
    }

    //create a invoice table for this order
    private function make_invoice($order_id){
        $this->load->model('order_items_model');

        $order_data = $this->get_order_where($order_id)->row();
        $address =  $order_data->shipping_address;
        $time = $order_data->time;

        $user_id = $order_data->user_id;

        $user = $this->ion_auth->user($user_id)->row();
        $full_name = $user->first_name." ".$user->last_name;
        $phone_num = $user->phone;
        $user_email = $user->email;

        $total=0;

        //populate user details
        $output=' <tr class="top">
                        <td>
                            <table>
                                <tr>
                                    <td class="title">
                                        <h1>Bristore</h1>
                                    </td>
                                    <td align="right">
                                        Invoice #: '.$order_id.'<br>
                                        Created: '.$time.'<br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="information" align="right">
                        <td>
                            <table>
                                <tr>
                                    <td>Address: '.$address.'</td>
                                    <td>
                                        Name: '.$full_name.'<br>
                                        Phone: '.$phone_num.'<br>
                                        Email: '.$user_email.'
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="heading">
                        <td>
                        <table style="width: 80%" align="left">
                            <tr>
                                <td>Item</td>
                                <td>Price</td>
                                <td>Qty</td>
                                <td>Subtotal</td>
                            </tr>
                        </table>
                        </td>
                    </tr>';

        $output.='<tr class="item"><td><table style="width: 80%" align="left">';
        //populate order items details
        $query = $this->order_items_model->get_where($order_id);
        //get all items that are in this order
        foreach($query->result() as $row) {
            $item_id = $row->item_id;
            $qty = $row->qty;
            $price = $row->price;
            $item_details = $this->store_items->fetch_data_from_db($item_id);
            $item_name = $item_details['item_title'];
            $subtotal = $price * $qty;
            $total += $subtotal;

            $output .='
                            <tr>
                                <td>'.$item_name.'</td>
                                <td>'.$price.'</td>
                                <td>'.$qty.'</td>
                                <td> $'.$subtotal.'</td>
                            </tr>
                    
            ';
        }
        //add total amount
        $output .= '</table></td></tr>           
                    <tr class="total">
                        <td>
                            <table align="left"><tr><td><h2>Total: $'.$total.'</h2></td></tr></table>
                        </td>
                    </tr>';
        return $output;
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
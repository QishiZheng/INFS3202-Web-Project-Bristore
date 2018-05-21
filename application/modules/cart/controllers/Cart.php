<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MX_Controller {

    function __construct(){
        parent::__construct();
        //$this->load->library('cart');

        $this->load->module(array('store_items', 'auth', 'templates'));
        $this->load->library(array('ion_auth'));
        $this->load->model('cart_model');
    }

    function index(){
        $data['view_file'] = "check_out";
        $this->templates->shop($data);
    }

    //add item to cart
    function add_to_cart(){
        //check if the user is logged in
        if (!$this->ion_auth->logged_in())
        {
            echo json_encode("You are not logged in! Please login before adding anything to cart.");
            die();
        }
        //$this->auth->login_check();

        //$this->load->model('cart_model');
        $user_id = $this->ion_auth->get_user_id();
        $item_id = $this->input->post('item_id');

        //fetch item data from items table in db
        $item = $this->store_items->fetch_data_from_db($item_id);

        //response to client
        $rsp = $item['item_title']." is out of stock!";
        //number of this item in this user's cart
        $num = $this->cart_model->count_cart_item($user_id, $item_id);

        //add this item to cart only if stock is greater than 0
        if($item['item_stock'] > 0 ) {
            $rsp = $item['item_title']." was added to cart successfully!";
            //add a row of data to cart in db if there is no such item in cart
            if($num == 0) {
                $data = array(
                    'user_id' => $user_id,
                    'item_id' => $item_id,
//            'price' => $item['item_price'],
                    'qty' => $this->input->post('item_qty'),
                );
                $this->cart_model->_insert($data);
                //        echo $this->show_cart();
            } else {
                //otherwise only update the quantity of this item
                $qty = $this->cart_model->get_item_qty($user_id, $item_id);

                $new_qty = $this->input->post('item_qty') + $qty;
                $data = array(
                    'user_id' => $user_id,
                    'item_id' => $item_id,
//            'price' => $item['item_price'],
                    'qty' => $new_qty,
                );
                $this->cart_model->_update_item($data);
            }
        }
        echo json_encode($rsp);
    }


    //pass the cart content to the cart modal in view
    function show_cart(){
        $result = '';
        $total = 0;

        $user_id = $this->ion_auth->get_user_id();
        $query = $this->cart_model->get_where($user_id);

        //get all items that are in the cart of current user
        foreach($query->result() as $row) {
            $item_id = $row->item_id;
            $qty = $row->qty;
            $item_details = $this->store_items->fetch_data_from_db($item_id);
            $subtotal = $item_details['item_price'] * $qty;
            $total += $subtotal;

            $result .='
                <tr>
                    <td>'.$item_id.'</td>
                    <td>'.$item_details['item_title'].'</td>
                    <td>'.'$'.$item_details['item_price'].'</td>
                    <td><input type="number" id="'.$item_id.'_qty" onchange="update_qty('.$item_id.')" value='.$qty.' style="width: 50px;"></td>
                    <td id="'.$item_id.'_subtotal">'.'$'.$subtotal.'</td>
                    <td><button type="button" id="'.$item_id.'" class="btn btn-danger btn-sm remove_cart_item_btn">Delete</button></td>
                </tr>
            ';
        }
        $result .= '
            <tr>
                <th colspan="3">Total</th>
                <th colspan="2" id="total_amount">'.'$ '.$total.'</th>
            </tr>';
        echo json_encode($result);
    }


    //delete this item in cart send back updated subtotal and total back to client
    function delete_cart_item(){
        $this->auth->login_check();
        $user_id = $this->ion_auth->get_user_id();
        $item_id = $this->input->post('item_id');

        //show the uer error message if the item_id is not numeric
        if(!(is_numeric($item_id))){
            //set flash data
            $flash_msg = "Something is wrong about the item id";
            $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
            $this->session->set_flashdata('item', $value);

            header('Location: '.$_SERVER['REQUEST_URI']);
            die();
        }

        $this->cart_model->_delete($user_id, $item_id);

        //recalculate total, send back to client
        $total = $this->get_total();
        echo json_encode($total);
    }

    //update the item qty and send back updated subtotal and total back to client using ajax
    function update_cart_item_qty(){
        $this->auth->login_check();
        $user_id = $this->ion_auth->get_user_id();
        $item_id = $this->input->post('item_id');
        $qty = $this->input->post('qty');

        $data = array(
            'user_id' => $user_id,
            'item_id' => $item_id,
            'qty' => $qty
        );
        $this->cart_model->_update_item($data);

        $this->recalculate_amount($user_id, $item_id);
    }

    //go to check out page
    function check_out(){
        $this->auth->login_check();
        $user_id = $this->ion_auth->get_user_id();
        $data['user'] = $this->ion_auth->user($user_id)->row();

        $data['view_file'] = "check_out";
        $this->templates->shop($data);
    }

    //fetch the data of shopping cart with given userid
    function get_total() {
        $this->auth->login_check();
        $user_id = $this->ion_auth->get_user_id();
        $total=0;
        //execute the query that retrieves the data of item with given id
        $query = $this->cart_model->get_where($user_id);
        foreach($query->result() as $row) {
            $item_id = $row->item_id;
            $total += $this->cart_model->get_item_subtotal($user_id, $item_id);
        }

        return $total;
    }

//    //fetch the data of shopping cart with given userid
//    function fetch_cart_item_from_db($user_id) {
//        //execute the query that retrieves the data of item with given id
//        $query = $this->cart_model->get_where($user_id);
//        foreach($query->result() as $row) {
//            $data['user_id'] = $row->user_id;
//            $data['item_id'] = $row->item_id;
//            $data['qty'] = $row->qty;
//        }
//
//        if(!isset($data)) {
//            $data = "";
//        }
//
//        return $data;
//    }

    //clear this user's cart
    function clear_cart() {
        $user_id = $this->ion_auth->get_user_id();
        $query = $this->cart_model->_clear_cart($user_id);
    }


    function count_where($col, $value) {
        $this->load->model('cart_model');
        $count = $this->cart_model->count_where($col, $value);
        return $count;
    }

    //recalculate subtotal and total, send back to client
    private function recalculate_amount($user_id, $item_id){
        $subtotal = $this->cart_model->get_item_subtotal($user_id, $item_id);
        $total = $this->get_total();

        $cart_data = array(
            'subtotal' => $subtotal,
            'total' => $total,
        );

        echo json_encode($cart_data);
    }
}


<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MX_Controller {

    function __construct(){
        parent::__construct();
        //$this->load->library('cart');

        $this->load->module('store_items');
        $this->load->module('auth');
        $this->load->library(array('ion_auth'));
        $this->load->model('cart_model');
    }

    function index(){
        $data['view_file'] = "cart";
        $this->load->module('templates');;
        $this->templates->shop($data);
    }

    //add item to cart
    function add_to_cart(){
        //check if the user is logged in
        if (!$this->ion_auth->logged_in())
        {
            echo json_encode("You are not logged in! Please login before adding anything to cart.");
        }

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
            if($num < 1) {
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
                $this->cart_model->_update_item($user_id, $item_id, $data);
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
                    <td>'.'$'.$subtotal.'</td>
                    <td><button type="button" id="'.$item_id.'" class="btn btn-danger btn-sm remove_cart_item_btn">Delete</button></td>
                </tr>
            ';
        }
        $result .= '
            <tr>
                <th colspan="3">Total</th>
                <th colspan="2">'.'$'.$total.'</th>
            </tr>';
        echo json_encode($result);
    }

//    function load_cart(){
//        echo $this->show_cart();
//    }


    //delete this item in cart
    function delete_cart_item(){
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
        echo 1;
    }




    //fetch the data of shopping cart with given userid
    function fetch_cart_item_from_db($user_id) {
        //check the update_id
        if(!is_numeric($user_id)) {
            redirect('site_security/not_allowed');
        }
        //execute the query that retrieves the data of item with given id
        $query = $this->cart_model->get_where($user_id);
        foreach($query->result() as $row) {
            $data['user_id'] = $row->user_id;
            $data['item_id'] = $row->item_id;
            $data['qty'] = $row->qty;
        }

        if(!isset($data)) {
            $data = "";
        }

        return $data;
    }
}


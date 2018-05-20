<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "add_to_cart";
        return $table;
    }

    function get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    //get all items in the cart of the user with given user_id
    function get_where($user_id) {
        $table = $this->get_table();
        $this->db->where('user_id', $user_id);
        $query = $this->db->get($table);
        return $query;
    }


    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
    }

    function _update_item($data) {
        $table = $this->get_table();
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('item_id', $data['item_id']);
        $this->db->update($table, $data);
    }


    //remove this item from the cart of user with given user_id
    function _delete($user_id, $item_id) {
        $table = $this->get_table();
        $this->db->where('user_id', $user_id);
        $this->db->where('item_id', $item_id);
        $this->db->delete($table);
    }


    // clear this user's cart
    function _clear_cart($user_id) {
        $table = $this->get_table();
        $this->db->where('user_id', $user_id);
        $this->db->delete($table);
    }

    function count_where($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }


    //count the number of item with given item_id in the cart of the user with given user_id
    function count_cart_item($user_id, $item_id) {
        $table = $this->get_table();
        $this->db->where('user_id', $user_id);
        $this->db->where('item_id', $item_id);
        $query = $this->db->get($table);
        $num = $query->num_rows();
        return $num;
    }

    //get the qty of the item with given item_id in the cart of the user with given user_id
    function get_item_qty($user_id, $item_id) {
        $table = $this->get_table();
        $this->db->where('user_id', $user_id);
        $this->db->where('item_id', $item_id);
        $query = $this->db->get($table);
        $qty = 0;
        foreach ($query->result() as $row) {
            $qty = $row->qty;
        }
        return $qty;
    }

    //get the subtotal of the item with given item_id in the cart of the user with given user_id
    function get_item_subtotal($user_id, $item_id) {
        $qty = $this->get_item_qty($user_id, $item_id);
        $item_data = $this->store_items->fetch_data_from_db($item_id);
        $price = $item_data['item_price'];
        $subtotal = $qty*$price;
        return $subtotal;
    }


    function count_all() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max() {
        $table = $this->get_table();
        $this->db->select_max('user_id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }
}
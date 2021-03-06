<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_items_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_table() {
		$table = "order_items";
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

	function get_where($order_id) {
		$table = $this->get_table();
		$this->db->where('order_id', $order_id);
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

	function _update($order_id, $item_id, $data) {
		$table = $this->get_table();
		$this->db->where('order_id', $order_id);
        $this->db->where('item_id', $item_id);
		$this->db->update($table, $data);
	}

	function _delete($order_id) {
		$table = $this->get_table();
		$this->db->where('order_id', $order_id);
		$this->db->delete($table);
	}

	function count_where($col, $value) {
		$table = $this->get_table();
		$this->db->where($col, $value);
		$query = $this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function count_all() {
		$table = $this->get_table();
		$query = $this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function get_max() {
		$table = $this->get_table();
		$this->db->select_max('order_id');
		$query = $this->db->get($table);
		$row = $query->row();
		$order_id = $row->order_id;
		return $order_id;
	}

	function _custom_query($mysql_query) {
		$query = $this->db->query($mysql_query);
		return $query;
	}
}
<?php
class Templatecontroller extends MX_Controller {
	function __construct() {
		parent::__construct();
	}

	function get($order_by) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->get_where_custom($col, $value);
		return $query;
	}

	function _inset($data) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->_inset($data);
	}

	function _update($id, $data) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->_update($id, $data);
	}

	function _delete($id) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->_delete($id);
	}

	function count_where($col, $value) {
		$this->load->model('mdl_templatecontroller');
		$count = $this->mdl_templatecontroller->count_where($col, $value);
		return $count;
	}

	function get_max() {
		$this->load->model('mdl_templatecontroller');
		$max_id = $this->mdl_templatecontroller->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$this->load->model('mdl_templatecontroller');
		$query = $this->mdl_templatecontroller->_custom_query($mysql_query);
		return $query;
	}
}
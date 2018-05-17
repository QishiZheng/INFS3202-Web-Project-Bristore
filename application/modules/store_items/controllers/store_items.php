<?php
class Store_items extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
//		$this->form_validation->CI =& $this;
	}

    //takes the user to home page
    function index() {
        $data['view_file'] = "home_page.php";
        $this->load->module('templates');
        $this->templates->shop($data);
    }

	//create a new item or update the item if it already exists
    function create() {
	    //check if the user is admin
        $this->load->library('session');

        //security check
        $this->login_check();
        $this->admin_check();

        //get the id of this item
        $update_id = $this->uri->segment(3);
        //check if submit is TRUE
        $submit = $this->input->post('submit', TRUE);

        if($submit=="Submit") {
            //validate the form
            //$this->load->library('form_validation');
            $this->form_validation->set_rules('item_title', 'Item Title', 'required|max_length[240]|callback_item_check');
            $this->form_validation->set_rules('item_price', 'Item Price', 'required|numeric|callback_check_positive');
            $this->form_validation->set_rules('item_stock', 'Item Stock', 'required|numeric|callback_check_positive');
            $this->form_validation->set_rules('item_category', 'Item Category', 'required|max_length[240]');
            $this->form_validation->set_rules('item_description', 'Item Description', 'required');

            //update or insert a new item if all user inputs are correct
            if($this->form_validation->run($this) == TRUE) {
                //fetch the user input
                $data=$this->fetch_data_from_post();
                $data['item_url'] = url_title($data['item_title']);

                if(is_numeric($update_id)) {
                    //update the details of the item with $update_id
                    $this->_update($update_id, $data);
                    //set flash data
                    $flash_msg = "This item details were successfully updated!";
                    $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
                    $this->session->set_flashdata('item', $value);

                    redirect('store_items/create/'.$update_id);
                } else {
                    //insert a new item
                    //echo $data['item_title'];
                    $this->_insert($data);
                    $update_id = $this->get_max();//the id of newly added item
                    //set flash data
                    $flash_msg = "This item was successfully added!";
                    $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
                    $this->session->set_flashdata('item', $value);

                    redirect('store_items/create/'.$update_id);
                }
            }
        } elseif($submit == "Cancel") {     //redirect to manage page if submit is Cancel
            redirect('store_items/manage');
        }

        if((is_numeric($update_id)) && ($submit != "Submit")) {
            $data = $this->fetch_data_from_db($update_id);
        } else {
            $data = $this->fetch_data_from_post();
        }

        //change the header depending on whether updating or inserting
        if(!is_numeric($update_id)) {
            $data['headline'] = "Add New Item";
        } else {
            $data['headline'] = "Update Item Details";
        }


        //set $data and load views
        $data['update_id'] = $update_id;
        //$data['flash'] = $this->session->flashdata('item');
        // $data['view_module'] = "store_items";
        $data['view_file'] = "create";
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    //upload img of item with given id
    function upload_img($update_id) {
        //check if the user is admin
        $this->load->library('session');
        //security check
        $this->login_check();
        $this->admin_check();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //set $data and load views
        $data['headline'] = "Upload Images";
        $data['update_id'] = $update_id;
        //$data['flash'] = $this->session->flashdata('item');
        // $data['view_module'] = "store_items";
        $data['view_file'] = "upload_img";
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    //Do actual image uploading
    function do_upload($update_id)
    {
        //check if the user is admin
        $this->load->library('session');
        //security check
        $this->login_check();
        $this->admin_check();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //check submit status
        $submit = $this->input->post('submit', TRUE);
        if ($submit == "Cancel") {
            redirect('store_items/create/'.$update_id);
        }

        $config['upload_path'] = './item_pics/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 6000 ;
        $config['max_height'] = 4000;
        $config['file_name'] = "item".$update_id."_img";

        $this->load->library('upload', $config);

        //upload failed
        if (! $this->upload->do_upload('userfile'))
        {
            //set $data and load views
            $data['error'] = array('error' => $this->upload->display_errors());
            $data['headline'] = "Upload Error";
            $data['update_id'] = $update_id;
            //$data['flash'] = $this->session->flashdata('item');
            // $data['view_module'] = "store_items";
            $data['view_file'] = "upload_img";
            $this->load->module('templates');
            $this->templates->admin($data);
        }
        else {  //upload was successful
            //get upload data
            $data = array('upload_data' => $this->upload->data());

            //generate thumbnail for this image
            $img_data = $data['upload_data'];
            $img_name = $img_data['file_name'];
            $this->generate_thumbnail($img_name);

            //update the item_pic in db
            $update_data['item_pic'] = $img_name;
            $this->_update($update_id, $update_data);

            //set $data and load views
            $data['headline'] = "Images uploaded successfully for Item ".$update_id;
            $data['update_id'] = $update_id;
            //$data['flash'] = $this->session->flashdata('item');
            $data['view_file'] = "upload_success";
            $this->load->module('templates');
            $this->templates->admin($data);
        }
    }


    //generate a thumbnail for given image in the same source folder
    function generate_thumbnail($img_name) {

	    $config['image_library'] = 'gd2';
        $config['source_image'] = './item_pics/'.$img_name;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        $config['height'] = 200;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }


    function delete_img($update_id) {
        //check if the user is admin
        $this->load->library('session');
        //security check
        $this->login_check();
        $this->admin_check();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //get the data of item from db
        $data = $this->fetch_data_from_db($update_id);
        $item_pic_path = "./item_pics/".$data["item_pic"];
        //get the name of the thumbnail of this item image
        list($file_name, $file_extension) = explode(".", $data["item_pic"]);
        $item_thumb_path = "./item_pics/".$file_name."_thumb.".$file_extension;

        //delete the image and its thumbnail
        if(file_exists($item_pic_path)) {
            unlink($item_pic_path);
        }
        if(file_exists($item_thumb_path)) {
            unlink($item_thumb_path);
        }
        //update the db
        unset($data);
        $data["item_pic"] = "";
        $this->_update($update_id, $data);

        //set flash data
        $flash_msg = "This image was successfully deleted!";
        $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
        $this->session->set_flashdata('item', $value);

        //redirect to edit item page
        redirect('store_items/create/'.$update_id);
    }


    //Delete item confirmation
    function conf_del($update_id) {
        //load security module and check if is admin
        $this->load->library('session');
        //security check
        $this->login_check();
        $this->admin_check();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //set $data and load views
        $data = $this->fetch_data_from_db($update_id);
        $data['headline'] = "Delete Item?";
        $data['update_id'] = $update_id;
        //$data['flash'] = $this->session->flashdata('item');
        // $data['view_module'] = "store_items";
        $data['view_file'] = "conf_del";
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    //Perform Delete the item with given id if yes is clicked,
    //otherwise redirect user to update page
    function delete_item($update_id) {
        //load security module and check if is admin
        $this->load->library('session');
        //security check
        $this->login_check();
        $this->admin_check();

        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //check what the user clicked(yse or no)
        $submit = $this->input->post('submit', TRUE);
        if($submit == "No") {
            redirect('store_items/create/'.$update_id);
        } elseif($submit== "Yes") {
            $this->_do_delete_item($update_id);

            //set flash data
            $flash_msg = "This item was successfully deleted!";
            $value = '<div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
            $this->session->set_flashdata('item', $value);

            redirect('store_items/manage');
        }
    }

    //do the actual deleting item task, and delete images related to this item
    function _do_delete_item($update_id) {
        $data = $this->fetch_data_from_db($update_id);
        //delete item_pic and thumbnail if it exists
        if(isset($data['item_pic']) && $data['item_pic'] != "") {
            $item_pic_path = "./item_pics/".$data["item_pic"];
            //get the name of the thumbnail of this item image
            list($file_name, $file_extension) = explode(".", $data["item_pic"]);
            $item_thumb_path = "./item_pics/".$file_name."_thumb.".$file_extension;
            //delete the image and its thumbnail
            if(file_exists($item_pic_path)) {
                unlink($item_pic_path);
            }
            if(file_exists($item_thumb_path)) {
                unlink($item_thumb_path);
            }
        }

        //delete the item record in db
        $this->_delete($update_id);
    }

    //delete an item using AJAX on manage page
    function ajax_do_delete_item() {
        //security check
        $this->login_check();
        $this->admin_check();

        if(isset($_POST['id'])) {
            //get the id from AJAX POST
            $deleteid = $_POST['id'];

            //load security module and check if is admin
            $this->load->library('session');
            $this ->load->module('site_security');
            $this->site_security->_make_sure_is_admin();

            //check the deleteid
            if(!is_numeric($deleteid)) {
                redirect('site_security/not_allowed');
            }

            //delete the item with deleteid
            $this->_do_delete_item($deleteid);
            echo 1;
        }

	}

	//view the item with the given id on its own product page
    function view_item($update_id) {
        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }

        //fetch the details of the item with given id from db
        $data = $this->fetch_data_from_db($update_id);

        $data['update_id'] = $update_id;
        //$data['flash'] = $this->session->flashdata('item');
        $data['view_file'] = "view_item";
        $this->load->module('templates');;
        $this->templates->shop($data);

    }


    //show the item management page
	function manage() {
	    //load security module and check if is admin
        $this->load->library('session');
        //security check
        $this->login_check();
        $this->admin_check();

	    $data['query'] = $this->get('id');
	    $data['view_file'] = "manage";
	    $this->load->module('templates');
	    $this->templates->admin($data);
    }

    function fetch_data_from_post() {
	    $data['item_title'] = $this->input->post('item_title', TRUE);
        $data['item_price'] = $this->input->post('item_price', TRUE);
        $data['item_stock'] = $this->input->post('item_stock', TRUE);
        $data['item_category'] = $this->input->post('item_category', TRUE);
        $data['item_description'] = $this->input->post('item_description', TRUE);
        return $data;
    }

    function fetch_data_from_db($update_id) {
        //check the update_id
        if(!is_numeric($update_id)) {
            redirect('site_security/not_allowed');
        }
        //execute the query that retrieves the data of item with given id
	    $query = $this->get_where($update_id);
	    foreach($query->result() as $row) {
	        $data['item_title'] = $row->item_title;
            $data['item_url'] = $row->item_url;
            $data['item_price'] = $row->item_price;
            $data['item_stock'] = $row->item_stock;
            $data['item_category'] = $row->item_category;
            $data['item_description'] = $row->item_description;
            $data['item_pic'] = $row->item_pic;
            $data['item_created_at'] = $row->item_created_at;
        }

        if(!isset($data)) {
	        $data = "";
        }

        return $data;
    }

//    //view the product
//    function view($update_id) {
//
//    }

	function get($order_by) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_insert($data);
	}

	function _update($id, $data) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_update($id, $data);
	}

	function _delete($id) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_delete($id);
	}

	function count_where($col, $value) {
		$this->load->model('mdl_store_items');
		$count = $this->mdl_store_items->count_where($col, $value);
		return $count;
	}

	function get_max() {
		$this->load->model('mdl_store_items');
		$max_id = $this->mdl_store_items->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$this->load->model('mdl_store_items');
		$query = $this->mdl_store_items->_custom_query($mysql_query);
		return $query;
	}


	//check if the item with the title is in the db
	function item_check($item_title) {
	    $item_url = url_title($item_title);
        $my_query = "SELECT * FROM items WHERE item_title = '$item_title' AND item_url = '$item_url'";
        $update_id = $this->uri->segment(3);

        //add update_id to query if $update_id is numeric
        if(is_numeric($update_id)){
            $my_query.=" AND id!=$update_id";
        }

        //get the number of rows in db that has same item_title and item_url
        $query = $this->_custom_query($my_query);
        $num_rows =$query->num_rows();
        //give error if there is exists a row with the query condition in the db
	    if($num_rows>0) {
            $this->form_validation->set_message('item_check', 'The Item Title is already in the database!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //check if the number is greater than 0
    function check_positive($num)
    {
        // Don't run bother checking if we have a form error on check_positive
        if  (form_error('item_stock')) {
            return true;
        }

        $num = intval($num);
        if ($num < 0) {
            $this->form_validation->set_message('check_positive', "The stock/price must be more than 0.");
            return false;
        }
        return true;
    }



//    //for AJAX test
//    function test(){
////	    echo "test";
//    echo json_encode(array("qty"=>$_POST['qty']));
//	}



	//check if the user is logged in,redirect to login page if no admin
	private function login_check() {
        $this ->load->module('auth');
        if (!$this->ion_auth->logged_in())
        {
            $flash_msg = "You have to log in to view this page";
            $value = '<div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
            $this->session->set_flashdata('item', $value);
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
    }


    //check if the user is admin, redirect to home page if no admin
	private function admin_check() {
        $this ->load->module('auth');
        if (!$this->ion_auth->is_admin())
        {
            //set flash data
            $flash_msg = "You shall not pass to Manage page! Only Admin is allowed to be here.";
            $value = '<div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>'.$flash_msg.'</strong></div>';
            $this->session->set_flashdata('item', $value);
            // redirect them to the home page because they must be an administrator to view this
            redirect('store_items/index', 'refresh');
        }
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: VinceZ
 * Date: 5/4/18
 * Time: 12:25
 */

class Auth extends CI_Controller {

    public function login() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[32]');

        if($this->form_validation->run() == TRUE) {

            $email = $_POST['email'];
            $password = md5($_POST['password']);

            //check user details in database
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where(array('email' =>$email,
                                    'password' => $password));
            $query = $this->db->get();

            $user = $query->row();
            //if user exists
            if($user->email) {
                //temp message
                $this->session->set_flashdata("success", "You are logged in!");

                //set session available
                $_SESSION['user_logged'] = TRUE;
                $_SESSION['email'] = $user->email;
                $_SESSION['name'] = $user->firstName;

                //redirect to profile page
                redirect("user/profile", refresh);

            } else {
                $this->session->set_flashdata('error', "Invalid email address or password!");
                redirect("auth/login", refresh);
            }
        }


        $this->load->view('login');
    }

    public function signup() {

        if(isset($_POST['signup'])) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('firstName', 'First Name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[32]');
            $this->form_validation->set_rules('confirmPwd', 'Password Confirmation', 'trim|required|matches[password]');

            ////add user to DB if form validation true
            if($this->form_validation->run() == TRUE) {
                echo '<h1>form is valid</h1>';

                //add user to DB
                $data = array(
                    'email' => $_POST['email'],
                    'firstName' => $_POST['firstName'],
                    'lastName' => $_POST['lastName'],
                    'password' => md5($_POST['password']),

                );

                $this->db->insert('users', $data);

                $this->session->set_flashdata("success","Your account has been created! you can login now!");
                redirect("auth/signup", "refresh");
            }
        }

        //load signup view page
        $this->load->view('signUp');
    }
}
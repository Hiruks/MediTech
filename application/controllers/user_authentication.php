<?php 
session_start();
class User_Authentication extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->library('session');
    }
    public function index() {
        $this->load->view('contactus');
        
}

// Show registration page
public function user_registration_show() {
$this->load->view('registration_form');
}

// Validate and store registration data in database
public function new_user_registration() {

    
}

// Check for user login process
public function user_login_process() {

    
}

// Logout from user page
public function logout() {

}
}

?> 
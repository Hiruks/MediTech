<?php

class Login extends CI_Controller {

	public function __construct() {
				parent::__construct();
        	$this->load->helper('form');
        	$this->load->library('form_validation');
        	$this->load->model('user_model');
        	$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('auth/login');
	}

	public function register()
	{
		$this->load->view('auth/register');
	}

    public function profile(){
        $success = $this->session->flashdata('success');
		$error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        $sessionData = $this->session->userdata('userinfo');
        // print_r($sessionData);
        if($this->checkSessionExist()){

            $result = $this->user_model->getUserDataByID($sessionData['id']);
            if($result){
                $data['myprofile'] = $result;
                $this->load->view('profile',$data);
            }
            
        }
        
    }

    public function editProfile(){
        $success = $this->session->flashdata('success');
		$error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        $sessionData = $this->session->userdata('userinfo');
        if($this->checkSessionExist()){

            $result = $this->user_model->getUserDataByID($sessionData['id']);
            if($result){
                $data['myprofile'] = $result;
                $this->load->view('edit-profile',$data);
            }
            
        }
    }

    public function editProfileSubmit(){
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('contact', 'Contact', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Form details cannot be empty');
            redirect("/login/editProfile/");
        }else{
            //print_r($_POST);
            $sessionData = $this->session->userdata('userinfo');
            $data = array(
                'id'=>$sessionData['id'],
                'name'=>$_POST['name'],
                'email'=> $_POST['email'],
                'contact' => $_POST['contact']
             );
             $result = $this->user_model->updateProfile($data);
             if($result == 1){
                $this->session->set_flashdata('success','Profile data updated successfully.');
                redirect("/login/profile/");
             }elseif($result == 0){
                $this->session->set_flashdata('success','Profile data upto date.');
                redirect("/login/profile/");
             }else{
                $this->session->set_flashdata('error','Error occured please try again');
                redirect("/login/editProfile/");
             }

        }
    }
    
	public function loginSubmit(){
		//print_r($_POST);
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->load->view('auth/login');
        }else{
            $data = array(
                'email'=> $_POST['email'],
                'password'=> $_POST['password'],
             );
             $result = $this->user_model->loginCheck($data);
             if($result){
                // set session 
                $resutlUserData = $this->user_model->getUserData($data);
                //print_r($resutlUserData);
                $session_user = array(
                    'id'=> $resutlUserData[0]->userid,
                    'login'=> true,
                    'name' => $resutlUserData[0]->name
                );
                if($resutlUserData[0]->userType == 'Admin'){
                    $actions = array(
                        'dashboard'=>['myprofile'=>true,
                                        'teamprofile'=>true,
                                        'product'=>true,
                                        'reports'=>true
                            ],
                        'user-management'=>['view'=>true,
                                   'edit'=>true,
                                    'delete'=>true
                        ],
                        'blacklist'=>['view'=>true,
                                    
                        ],
                        'orders'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                                    ],
                        'reports'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                                    ],

                    );
                }elseif($resutlUserData[0]->userType == 'Sales'){
                    $actions = array(
                        'dashboard'=>['myprofile'=>true,
                                        'teamprofile'=>true,
                                        'product'=>true,
                                        'reports'=>true
                            ],
                        'user-management'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                        ],
                        'blacklist'=>['view'=>true,
                                    
                        ],
                        'orders'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                                    ],
                        'reports'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                                    ],

                    );
                }
			    elseif($resutlUserData[0]->userType == 'DataEntry'){
                    $actions = array(
                        'dashboard'=>['myprofile'=>true,
                                        'teamprofile'=>true,
                                        'product'=>true,
                                        'reports'=>true
                            ],
                        'user-management'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                        ],
                        'blacklist'=>['view'=>true,
                                    
                        ],
                        'orders'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                                    ],
                        'reports'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                                    ],

                    );
                }
                
                // update session object with new session data
                $this->session->set_userdata('userinfo', $session_user);
                $this->session->set_userdata('routing', $actions);
                $this->session->set_flashdata('success', 'Login Successful');
                redirect('login/dashboard');
            }else{

                $this->session->set_flashdata('error','Invalid email/password. Please try again.');
                redirect('login/userlogin');

             }
            }
        }
	

	public function dashboard(){
        $success = $this->session->flashdata('success');
		$error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
		if(isset($data['error']) || isset($data['success'])){
            $this->load->view('dashboard',$data);
        }else{
            if($this->checkSessionExist()){
                $this->load->view('dashboard',$data);
            }else{
                $this->load->view('auth/login',$data);
            }
        }
	}

	public function userlogin(){
        $success = $this->session->flashdata('success');
		$error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if(isset($data['error']) || isset($data['success'])){
            $this->load->view('auth/login',$data);
        }else{
            if($this->checkSessionExist()){
                $this->load->view('dashboard',$data);
            }else{
                $this->load->view('auth/login',$data);
            }
        }

	}

    private function checkSessionExist(){
        if(!$this->session->has_userdata('userinfo')){
            $this->session->set_flashdata('error','Please login first to access the page');
            redirect('login/userlogin');
        }else{
            return true;
        }
    }

    public function logout(){
        $this->session->unset_userdata('userinfo');
        $this->session->set_flashdata('success','Logout successful.');
            redirect('login/userlogin');
        
    }

}

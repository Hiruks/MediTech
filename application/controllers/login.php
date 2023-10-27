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
                        'profile'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                        ],
                        'teamprofile'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>true
                        ],
                        'product'=>['view'=>true,
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
                                        'reports'=>false
                            ],
                        'profile'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>false
                                    ],
                        'teamprofile'=>['view'=>true,
                                    'edit'=>false,
                                    'delete'=>false
                                    ],
                        'product'=>['view'=>true,
                                    'edit'=>true,
                                    'delete'=>false
                                    ],
                        'reports'=>['view'=>false,
                                    'edit'=>false,
                                    'delete'=>false
                                    ],
                    );
                }
			    elseif($resutlUserData[0]->userType == 'DataEntry'){
				$actions = array(
					'dashboard'=>['myprofile'=>true,
									'teamprofile'=>true,
									'product'=>true,
									'reports'=>false
						],
					'profile'=>['view'=>true,
								'edit'=>true,
								'delete'=>false
								],
					'teamprofile'=>['view'=>true,
								'edit'=>false,
								'delete'=>false
								],
					'product'=>['view'=>true,
								'edit'=>true,
								'delete'=>false
								],
					'reports'=>['view'=>false,
								'edit'=>false,
								'delete'=>false
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

?>
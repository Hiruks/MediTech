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

	public function loginSubmit(){
		print_r($_POST);
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
                print_r($resutlUserData);
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
                redirect('login/dashboard');
            }else{

                //$this->session->set_flashdata('error','Email or password incorrect. Please check');
                redirect('login/userlogin');

             }
            }
        }
	

	public function dashboard(){
		$this->load->view('dashboard');
	}

	public function userlogin(){
		$this->load->view('auth/login');
	}

}

?>
<?php

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->model('data_model');
        //$this->load->controller('mail');
        $this->load->library('session');
        $this->load->helper('url');

        date_default_timezone_set("Asia/colombo");

        $this->load->library('upload');
        $this->load->library('phpmailer_lib');
        $this->load->library('email');
    }

    

    function sendReminder($name, $amount, $date, $email)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.office365.com',
            'smtp_port' => 587,
            'smtp_user' => 'sales@meditech.work',
            'smtp_pass' => 'meditech@123', // Use the App Password generated in your Google Account
            'smtp_crypto' => 'tls', // Use 'ssl' or 'tls'
            'mailtype' => 'html',
            'charset' => 'utf-8',
    'newline' => "\r\n",
        );
        $this->email->initialize($config);
       
        $this->email->from('sales@meditech.work', 'MediTech');
        $this->email->to($email);
        $this->email->subject('Overdue payment notification | MediTech');

        $mailContent = "
        <h1>Overdue Order Notice</h1>
        <h3>Hi $name,</h3>
        <p>A credit order placed on $date from Meditech has been overdued recently. The amount overdue is $amount. Please make the necessary payment timely to avoid being blacklisted from our services.</p>
        <p>Thank you for your attention.</p>
        <p>MediTech</p>";

        $this->email->message($mailContent);

        if ($this->email->send()) {
            echo 'Email sent.';
        } else {
            echo 'Email could not be sent.';
            echo $this->email->print_debugger();
        }
    }
    
   

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function profile()
    {
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
        if ($this->checkSessionExist()) {

            $result = $this->user_model->getUserDataByID($sessionData['id']);
            if ($result) {
                $data['myprofile'] = $result;
                $this->load->view('profile', $data);
            }
        }
    }

    public function editProfile()
    {
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
        if ($this->checkSessionExist()) {

            $result = $this->user_model->getUserDataByID($sessionData['id']);
            if ($result) {
                $data['myprofile'] = $result;
                $this->load->view('edit-profile', $data);
            }
        }
    }

    public function editProfileSubmit()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('contact', 'Contact', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form details cannot be empty');
            redirect("/login/editProfile/");
        } else {
            //print_r($_POST);
            $sessionData = $this->session->userdata('userinfo');
            $data = array(
                'id' => $sessionData['id'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'contact' => $_POST['contact']
            );
            $result = $this->user_model->updateProfile($data);
            if ($result == 1) {
                $this->session->set_flashdata('success', 'Profile data updated successfully.');
                redirect("/login/profile/");
            } elseif ($result == 0) {
                $this->session->set_flashdata('success', 'Profile data upto date.');
                redirect("/login/profile/");
            } else {
                $this->session->set_flashdata('error', 'Error occured please try again');
                redirect("/login/editProfile/");
            }
        }
    }

    public function loginSubmit()
    {
        //print_r($_POST);
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $data = array(
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            );
            $result = $this->user_model->loginCheck($data);
            if ($result) {
                // set session 
                $resutlUserData = $this->user_model->getUserData($data);
                //print_r($resutlUserData);
                $session_user = array(
                    'id' => $resutlUserData[0]->userid,
                    'login' => true,
                    'name' => $resutlUserData[0]->name
                );

                if ($resutlUserData[0]->userType == 'Admin') {
                    $actions = array(
                        'dashboard' => [
                            'myprofile' => true,
                            'teamprofile' => true,
                            'product' => true,
                            'reports' => true
                        ],
                        'customers' => [
                            'edit' => true,
                            'delete' => true
                        ],
                        'user-management' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        'products' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        'blacklist' => [
                            'view' => true,

                        ],
                        'orders' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        'reports' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],

                    );
                } elseif ($resutlUserData[0]->userType == 'Sales') {
                    $actions = array(
                        'dashboard' => [
                            'myprofile' => true,
                            'teamprofile' => true,
                            'product' => true,
                            'reports' => true
                        ],
                        'customers' => [
                            'edit' => true,
                            'delete' => false
                        ],
                        /*
                        'user-management' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        */
                        'blacklist' => [
                            'view' => true,

                        ],
                        'orders' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        /*
                        'reports' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],*/

                    );
                } elseif ($resutlUserData[0]->userType == 'DataEntry') {
                    $actions = array(
                        'dashboard' => [
                            'myprofile' => true,
                            'teamprofile' => true,
                            'product' => true,
                            'reports' => true
                        ],
                        'customers' => [
                            'edit' => false,
                            'delete' => false
                        ],
                        'user-management' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        /*
                        'blacklist' => [
                            'view' => true,

                        ],
                        */
                        'orders' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        'products' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ]
                        /*
                        'reports' => [
                            'view' => true,
                            'edit' => true,
                            'delete' => true
                        ],
                        */

                    );
                }

                // update session object with new session data
                $this->session->set_userdata('userinfo', $session_user);
                $this->session->set_userdata('routing', $actions);
                $this->session->set_flashdata('success', "Successfully Logged in.");

                $termsNo = $this->data_model->getCreditTermsNo(); //int
                $terms = $this->data_model->fetchCreditTerms();

                foreach ($terms as $term) {
                    $month = $this->data_model->findOverdueMonth($term->id);
                    $overdueOrder = $this->data_model->updateOverdueOrderPerTerm($term->id, $month);
                    
                    foreach ($overdueOrder as $ovOrder){
                        //$custName = $this->user_model->getCustomerNameByID($ovOrder->custID);
                        $cust = $this->user_model->getCustomerDataByID($ovOrder->custID);
                        $overdueAmount = $ovOrder->value;
                        $this->sendReminder($cust[0]->name, $overdueAmount, $ovOrder->created_date, $cust[0]->email);
                    }
                }



                foreach ($terms as $term) {
                    $month = $this->data_model->findBlacklistMonth($term->id);
                    $bresult = $this->data_model->findBlacklistableUsers($term->id, $month);
                    if ($bresult != false) {
                        foreach ($bresult as $customer) {
                            $result = $this->data_model->blacklistCustomers($customer->custID);
                        }
                    }
                }


               


                $currentMonth = date('n');
                //$currentMonth = 11;

                redirect('login/dashboard/' . $currentMonth);
            } else {

                $this->session->set_flashdata('error', 'Invalid email/password. Please try again.');
                redirect('login/userlogin');
            }
        }
    }

    public function refreshdash()
    {
        $currentMonth = $_GET['value'];
        redirect('login/dashboard/' . $currentMonth);
       
    }

    public function dashboard($currentMonth)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if (isset($data['error']) || isset($data['success'])) {
            //$currentMonth = date('n');
            // $currentMonth = 11;

            $result = $this->data_model->getMonthlySales($currentMonth);
            $result2 = $this->data_model->getMonthlyCust($currentMonth);

            $data['orders'] = $result;
            $data['customers'] = $result2;
            $data['overdue'] = $this->data_model->fetchOverdueOrders($currentMonth);
            $data['month'] = $currentMonth;
            //print_r($currentMonth);

            $this->load->view('dashboard/dashboard', $data);
        } else {
            if ($this->checkSessionExist()) {

                //$currentMonth = date('n');
                //$currentMonth = 11; //remove this later

                $result = $this->data_model->getMonthlySales($currentMonth);
                $result2 = $this->data_model->getMonthlyCust($currentMonth);

                $data['orders'] = $result;
                $data['customers'] = $result2;
                $data['overdue'] = $this->data_model->fetchOverdueOrders($currentMonth);
                $data['month'] = $currentMonth;
                //$this->send();

                //print_r($result2);
                $this->load->view('dashboard/dashboard', $data);
            } else {
                $this->load->view('auth/login', $data);
            }
        }
    }

    public function userlogin()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        //error
        if (isset($data['error']) || isset($data['success'])) {
            $this->load->view('auth/login', $data);
        } else {
            if ($this->checkSessionExist()) {
                $this->load->view('dashboard', $data);
            } else {
                $this->load->view('auth/login', $data);
            }
        }
    }

    //this is the stuff u need to change 👇
    public function userMng()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchUserDB();

            if ($result) {
                $data['user'] = $result;
                $this->load->view('user-management/user-management', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function adduser()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if (isset($data['error']) || isset($data['success'])) {
            $result = $this->user_model->fetchUserDB();

            if ($result) {
                $data['user'] = $result;

                $this->load->view('user-management/user-management', $data);
            }
        } else {

            if ($this->checkSessionExist()) {

                $result = $this->user_model->fetchUserDB();
                $userType = $this->user_model->getUserTypes();


                if ($result) {
                    $data['user'] = $result;
                    $data['dropdown'] = $userType;

                    $this->load->view('user-management/add-user-management', $data);
                }
            } else {
                $this->load->view('auth/login', $data);
            }
        }
    }

    public function addUserSubmit()
    {
        //loading stuff here
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('contact', 'Contact', 'required');
        $this->form_validation->set_rules('branch', 'Branch', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form details cannot be empty');
            redirect("/login/adduser/");
        } else {
            //print_r($_POST);

            $data = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'contactNo' => $_POST['contact'],
                'branchID' => $_POST['branch'],
                'password' => $_POST['password'],
                'userType' => $_POST['type']
            );

            $result = $this->user_model->addUser($data);

            if ($result == 1) {
                $data['success'] = $this->session->set_flashdata('success', 'User added successfully.');
                redirect('login/userMng');
            } elseif ($result == 0) {
                $data['success'] = $this->session->set_flashdata('success', 'User added successfully.');
                redirect('login/userMng');
            } else {
                $data['error'] = $this->session->set_flashdata('error', 'Error occured please try again');
                redirect("login/addUser");
            }
        }
    }

    public function editUser($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchUserDB();
            $customerFP = $this->user_model->getUserDataByID($id);
            $userType = $this->user_model->getUserTypes();
            //print_r($userType);

            if ($result && $customerFP && $userType) {

                $data['dropdown'] = $userType;
                $data['user'] = $result;
                $data['table'] = $customerFP;

                $this->load->view('user-management/edit-user-management', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function editUserSubmit($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchUserDB();
            $customerFP = $this->user_model->getUserDataByID($id);

            if ($result && $customerFP) {

                //$data['customer'] = $result;


                $data = array(
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'contactNo' => $_POST['contact'],
                    'branchID' => $_POST['branch'],
                    'password' => $_POST['password'],
                    'userType' => $_POST['type'],
                    'userid' => $id
                );

                $result = $this->user_model->editUserData($id, $data);

                if ($result == 1) {
                    $data['success'] = $this->session->set_flashdata('success', 'User edited successfully');

                    redirect('login/userMng');
                } elseif ($result == 0) {
                    $data['success'] = $this->session->set_flashdata('error', 'No edits were made.');
                    redirect('login/userMng');
                } else {
                    $this->session->set_flashdata('error', 'Error occured please try again');
                    redirect("/login/userMng");
                }
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }



    public function delUser($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {
            $result = $this->user_model->delUser($id);
            if ($result) {
                $data['success'] = $this->session->set_flashdata('success', 'User deleted successfully.');
                redirect('login/userMng');
            } else {
                $data['success'] = $this->session->set_flashdata('error', 'Error, the record was not deleted.');
                redirect("/login/userMng");
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }
    // bruhhhhhhhhhh

    //fetchCustomerDB();
    public function customerMng()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchCustomerDB();

            if ($result) {
                $data['customer'] = $result;
                $this->load->view('customer-management/customer-management', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function addcustomer()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if (isset($data['error']) || isset($data['success'])) {
            $result = $this->user_model->fetchCustomerDB();

            if ($result) {
                $data['customer'] = $result;
                $this->load->view('customer-management/customer-management', $data);
            }
        } else {

            if ($this->checkSessionExist()) {

                $result = $this->user_model->fetchCustomerDB();

                if ($result) {
                    $data['customer'] = $result;
                    $this->load->view('customer-management/add-customer-management', $data);
                }
            } else {
                $this->load->view('auth/login', $data);
            }
        }
    }

    public function addCustomerSubmit()
    {
        //loading stuff here
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('contact', 'Contact', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form details cannot be empty');
            redirect("/login/addcustomer/");
        } else {
            //print_r($_POST);

            $data = array(
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'contactNo' => $_POST['contact']
            );

            $result = $this->user_model->addCustomer($data);

            if ($result == 1) {
                $data['success'] = $this->session->set_flashdata('success', 'Customer added successfully.');
                redirect('login/addCustomer');
            } elseif ($result == 0) {
                $data['success'] = $this->session->set_flashdata('success', 'Customer added successfully.');
                redirect('login/addCustomer');
            } else {
                $data['error'] = $this->session->set_flashdata('error', 'Error occured please try again');
                redirect("login/addCustomer");
            }
        }
    }

    public function editCustomer($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchCustomerDB();
            $customerFP = $this->user_model->getCustomerDataByID($id);

            if ($result && $customerFP) {

                $data['customer'] = $result;
                $data['table'] = $customerFP;

                $this->load->view('customer-management/edit-customer-management', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function editCustomerSubmit($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchCustomerDB();
            $customerFP = $this->user_model->getCustomerDataByID($id);

            if ($result && $customerFP) {

                //$data['customer'] = $result;

                $data = array(
                    'custID' => $id,
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'contactNo' => $_POST['contact']
                );

                $result = $this->user_model->editCustomerData($id, $data);

                if ($result == 1) {
                    $data['success'] = $this->session->set_flashdata('success', 'Customer edited successfully');
                    redirect('login/customerMng');
                } elseif ($result == 0) {
                    $data['success'] = $this->session->set_flashdata('error', 'No edits were made.');
                    redirect('login/customerMng');
                } else {
                    $this->session->set_flashdata('error', 'Error occured please try again');
                    redirect("/login/customerMng");
                }
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function delCustomer($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {
            $result = $this->user_model->delCustomer($id);
            if ($result) {
                $data['success'] = $this->session->set_flashdata('success', 'Record deleted successfully.');
                redirect('login/customerMng');
            } else {
                $data['success'] = $this->session->set_flashdata('error', 'Error, the record was not deleted.');
                redirect("/login/customerMng");
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    //this is the stuff u need to change 👆

    public function products()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchProducts();
            if ($result == null) {
                $data['product'] = null;
                $this->load->view('products/add-product', $data);
            }
            if ($result) {
                $data['product'] = $result;
                $this->load->view('products/products', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function addProduct()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if (isset($data['error']) || isset($data['success'])) {
            $result = $this->user_model->fetchProducts();

            if ($result) {
                $data['product'] = $result;
                $this->load->view('products/products', $data);
            }
        } else {

            if ($this->checkSessionExist()) {

                $result = $this->user_model->fetchProducts();

                if ($result) {
                    $data['product'] = $result;
                    $this->load->view('products/add-product', $data);
                }
            } else {
                $this->load->view('auth/login', $data);
            }
        }
    }

    public function addProductSubmit()
    {
        //loading stuff here
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form details cannot be empty');
            redirect("login/addProduct/");
        } else {
            //print_r($_POST
            // print_r($_POST);
            $file_extension = pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

            // Generate a unique file name
            $new_name = time() . '_' . mt_rand(100000, 999999) . '.' . $file_extension;

            $config = array(
                'upload_path' => 'uploads/images/',
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => TRUE,
                'max_size' => "2048000",
                // 'max_height' => "768",
                // 'max_width' => "1024",
                'file_name' => $new_name
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload()) {
                $data = array('upload_data' => $this->upload->data());

                $data = array(
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'img' => $new_name,
                    'price' => $_POST['price']
                );

                $result = $this->user_model->addProduct($data);

                if ($result == 1) {
                    $data['success'] = $this->session->set_flashdata('success', 'Product added successfully.');
                    redirect('login/products');
                } elseif ($result == 0) {
                    $data['error'] = $this->session->set_flashdata('success', 'No products were added.');
                    redirect('login/products');
                } else {
                    $data['error'] = $this->session->set_flashdata('error', 'Error occured please try again');
                    redirect('login/products');
                }
            } else {
                /*$error = array('error' => $this->upload->display_errors());
                print_r($error); */
                $error = $this->upload->display_errors();
                $data['error'] = $this->session->set_flashdata('error', $error);
                redirect('login/products');
                //$this->load->view('custom_view', $error);
            }
        }
    }

    public function editProduct($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];

        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchProducts();
            $productsFP = $this->user_model->getProductByID($id);

            if ($result && $productsFP) {

                $data['product'] = $result;
                $data['info'] = $productsFP;

                $this->load->view('products/edit-products', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function editProductSubmit($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchProducts();
            $productFP = $this->user_model->getProductByID($id);

            $file_extension = pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

            // Generate a unique file name
            $new_name = time() . '_' . mt_rand(100000, 999999) . '.' . $file_extension;

            $config = array(
                'upload_path' => 'uploads/images/',
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => TRUE,
                'max_size' => "2048000",
                // 'max_height' => "768",
                // 'max_width' => "1024",
                'file_name' => $new_name
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload()) {
                $data = array('upload_data' => $this->upload->data());

                $data = array(
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'img' => $new_name,
                    'price' => $_POST['price'],
                );

                $result = $this->user_model->editProductData($id, $data);

                if ($result == 1) {
                    $data['success'] = $this->session->set_flashdata('success', 'Product edited successfully.');
                    redirect('login/products');
                } elseif ($result == 0) {
                    $data['error'] = $this->session->set_flashdata('error', 'No edits were made.');
                    redirect('login/products');
                } else {
                    $data['error'] = $this->session->set_flashdata('error', 'Error occured please try again');
                    redirect('login/products');
                }
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                /*$error = print_r($this->upload->display_errors());
                $data['error'] = $this->session->set_flashdata('error', $error);
                redirect('login/products');*/
                //$this->load->view('custom_view', $error);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function delProduct($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }

        if ($this->checkSessionExist()) {
            $result = $this->user_model->delProduct($id);
            if ($result) {
                $data['success'] = $this->session->set_flashdata('success', 'Product deleted successfully.');
                redirect('login/products');
            } else {
                $data['success'] = $this->session->set_flashdata('error', 'Error, the record was not deleted.');
                redirect("/login/products");
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function blacklist()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            $result = $this->user_model->fetchBlacklistedCustomers();
            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                $data['customer'] = $result;
                //$data['overdueCust'] = $overdue;
                $this->load->view('blacklist/blacklist', $data);
            } else {
                $data['error'] = "No records were found";
                $this->load->view('blacklist/empty-blacklist', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function searchBlacklistSubmit()
    {
        $searchTerm = $_POST['value'];
        $result = $this->user_model->searchBlacklistByName($searchTerm);
        //$overdue = $this->userlogin->fetchOverdueCustomers();
        if ($result) {
            $data['customer'] = $result;
            //$data['overdueCust'] = $overdue;
            $this->load->view('blacklist/blacklist', $data);
        } else {
            $data['error'] = $this->session->set_flashdata('error', 'No results found');
            redirect('login/blacklist');
        }
    }

    public function orderMng()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchOrdersWCustomers();
            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                //print_r($result);
                $data['orders'] = $result;
                //$data['orderName'] = $result2;

                //$data['overdueCust'] = $overdue;
                $this->load->view('order-management/order-management', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }


    public function searchOrderSubmit()
    {
        $searchTerm = $_POST['value'];
        $result = $this->user_model->searchOrderByName($searchTerm);
        //$overdue = $this->userlogin->fetchOverdueCustomers();
        if ($result) {
            $data['orders'] = $result;
            //$data['overdueCust'] = $overdue;
            $this->load->view('order-management/order-management', $data);
        } else {
            $data['error'] = $this->session->set_flashdata('error', 'No results found');
            redirect('login/orderMng');
        }
    }

    public function selectCustomer()
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            $result = $this->user_model->fetchWhitelistedCustomerDB();
            $result2 = $this->user_model->fetchOrdersWCustomers();

            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                $data['customer'] = $result;
                $data['orders'] = $result2;

                //$data['overdueCust'] = $overdue;
                $this->load->view('order-management/select-customer', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }


    public function searchCustomerSubmit()
    {
        $searchTerm = $_POST['value'];
        $result = $this->user_model->searchCustomerByName($searchTerm);
        $result2 = $this->user_model->fetchOrdersWCustomers();

        //$overdue = $this->userlogin->fetchOverdueCustomers();
        if ($result) {
            $data['customer'] = $result;
            $data['orders'] = $result2;

            //$data['overdueCust'] = $overdue;
            $this->load->view('order-management/select-customer', $data);
        } else {
            $data['error'] = $this->session->set_flashdata('error', 'No results found');
            redirect('login/selectCustomer');
        }
    }
    public function processOrder($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            $result = $this->user_model->getCustomerDataByID($id);
            $creditterms = $this->user_model->fetchCreditTermsDB();
            $products = $this->user_model->fetchProducts();
            //print_r($products);
            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                $data['customer'] = $result;
                $data['terms'] = $creditterms;
                $data['products'] = $products;
                $data['orderID'] = $id;
                //$data['overdueCust'] = $overdue;
                $this->load->view('order-management/create-order', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function processOrderSubmit($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            $result = $this->user_model->getCustomerDataByID($id);
            $creditterms = $this->user_model->fetchCreditTermsDB();
            $products = $this->user_model->fetchProducts();
            print_r($products);
            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                $data['customer'] = $result;
                $data['terms'] = $creditterms;
                $data['products'] = $products;
                $data['orderID'] = $id;
                //$data['overdueCust'] = $overdue;
                $this->load->view('order-management/create-order', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function addProductToOrder($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            if ($id) {
                $result = $this->user_model->getCustomerDataByID($id);
                $creditterms = $this->user_model->fetchCreditTermsDB();
                $products = $this->user_model->fetchProducts();
                print_r($products);
                //$overdue = $this->userlogin->fetchOverdueCustomers();
                if ($result) {
                    $data['customer'] = $result;
                    $data['terms'] = $creditterms;
                    $data['products'] = $products;
                    $data['orderID'] = $id;

                    //$data['overdueCust'] = $overdue;
                    $this->load->view('order-management/create-order', $data);
                }
            } else {
                $data['error'] = $this->session->set_flashdata('error', 'No results found');
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function ajaxRequestHandler()
    {
        $out = $_GET['value'];
        $products = $this->user_model->getProductByID($out);
        $data['products'] = $products;

        // Set the response type to JSON
        header('Content-Type: application/json');

        // Encode the data as JSON and echo it
        echo json_encode($data);

        // Exit to stop further processing
        exit;
    }

    public function addOrderSubmit($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {

            $this->form_validation->set_rules('total_order_value', 'Total_order_value', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');


            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Form details cannot be empty');
                redirect("/login/processOrder/" . $id);
            } else {
                //print_r($_POST);



                $data = array(
                    'custID' => $id,
                    'creditTermsID' => $_POST['type'],
                    'value' => $_POST['total_order_value'],
                    'productID' => $_POST['product_ids'],
                    'quantity' => $_POST['product_quantities']
                );

                if (!($data['productID'] && $data['quantity'])) {
                    $this->session->set_flashdata('error', 'Form details cannot be empty');
                    redirect("/login/processOrder/" . $id);
                }

                $result = $this->user_model->addOrder($data);

                if ($result == 1) {
                    $data['success'] = $this->session->set_flashdata('success', 'Order added successfully.');
                    redirect('login/orderMng');
                } elseif ($result == 0) {
                    $data['success'] = $this->session->set_flashdata('success', 'User added successfully.');
                    redirect('login/orderMng');
                } else {
                    $data['error'] = $this->session->set_flashdata('error', 'Error occured please try again');
                    redirect("login/selectCustomer");
                }
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }




    public function orderUpdate($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            $result = $this->user_model->fetchOrdersWCustomerID($id);
            $result2 = $this->user_model->getOrderProducts($id);
            $result3 = $this->user_model->fetchOrdersWCreditTerms($id);
            //$creditterms = $this->user_model->fetchCreditTermsDB();
            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                $data['orders'] = $result;
                $data['products'] = $result2;
                $data['credit'] = $result3;

                //$data['terms'] = $creditterms;
                //$data['overdueCust'] = $overdue;
                $this->load->view('order-management/order-view', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function orderUpdateForm($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {
            $result = $this->user_model->fetchOrdersWCustomerID($id);
            $result2 = $this->user_model->getOrderProducts($id);
            $result3 = $this->user_model->fetchOrdersWCreditTerms($id);
            //$creditterms = $this->user_model->fetchCreditTermsDB();
            //$overdue = $this->userlogin->fetchOverdueCustomers();
            if ($result) {
                $data['orders'] = $result;
                $data['products'] = $result2;
                $data['credit'] = $result3;

                //$data['terms'] = $creditterms;
                //$data['overdueCust'] = $overdue;
                $this->load->view('order-management/order-view-confirm', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    public function orderUpdateSubmit()
    {
        //loading stuff here
        $this->form_validation->set_rules('recipt', 'Recipt', 'required');
        $id = $_POST['id'];
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form details cannot be empty');
            redirect("login/orderUpdateForm/$id");
        } else {
            //print_r($_POST
            // print_r($_POST);
            $file_extension = pathinfo($_FILES["userfile"]["name"], PATHINFO_EXTENSION);

            // Generate a unique file name
            $new_name = time() . '_' . mt_rand(100000, 999999) . '.' . $file_extension;

            $config = array(
                'upload_path' => 'uploads/recipts/',
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => TRUE,
                'max_size' => "2048000",
                // 'max_height' => "768",
                // 'max_width' => "1024",
                'file_name' => $new_name
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload()) {
                $data = array('upload_data' => $this->upload->data());

                $data = array(
                    'orderID' => $_POST['id'],
                    'reciptNo' => $_POST['recipt'],
                    'img' => $new_name
                );

                $result = $this->user_model->addConfirmationRecord($data);
                $result2 = $this->user_model->updatePayment($id);
                $result3 = $this->data_model->getOrderCustomerID($id); //customer_id

                $terms = $this->data_model->fetchCreditTerms();
                $isWhitelistable = 2; //null

                foreach ($terms as $term) {
                    $custOrders = $this->data_model->orderByCustomers($result3, $term->id);
                    $month = $this->data_model->findBlacklistMonth($term->id);
                    foreach ($custOrders as $order) {
                        if ($order->isOverdue == 1) {
                            if ($this->data_model->isBlacklisted($order->id, $month)) {
                                $isWhitelistable = 0;
                            } else {
                                if ($isWhitelistable == 0) {
                                    break;
                                } else {
                                    $isWhitelistable = 1;
                                }
                            }
                        } else {
                            if ($isWhitelistable == 0) {
                                break;
                            } else {
                                $isWhitelistable = 1;
                            }
                        }
                    }
                }

                if ($isWhitelistable == 1) {
                    $result4 = $this->data_model->whitelistCustomer($result3);
                }


                if ($result && $result2 == 1) {
                    $data['success'] = $this->session->set_flashdata('success', 'Payment Confirmation Success');
                    redirect('login/orderUpdate/' . $id);
                } elseif ($result && $result2 == 0) {
                    $data['error'] = $this->session->set_flashdata('error', 'Confirmation Not Added');
                    redirect('login/orderUpdate/' . $id);
                } else {
                    $data['error'] = $this->session->set_flashdata('error', 'Error occured please try again');
                    redirect('login/orderMng');
                }
            } else {
                /*$error = array('error' => $this->upload->display_errors());
                print_r($error); */
                $error = $this->upload->display_errors();

                $data['error'] = $this->session->set_flashdata('error', $error);
                redirect("login/orderUpdateForm/$id");
                //$this->load->view('custom_view', $error);
            }
        }
    }

    public function orderPaymentDetails($id)
    {
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $data = [];
        if (!empty($success)) {
            $data['success'] = $success;
        }
        if (!empty($error)) {
            $data['error'] = $error;
        }
        if ($this->checkSessionExist()) {

            $result = $this->user_model->fetchPaymentRecord($id);

            if ($result) {
                $data['records'] = $result;

                $this->load->view('order-management/payment-details.php', $data);
            }
        } else {
            $this->load->view('auth/login', $data);
        }
    }

    private function checkSessionExist()
    {
        if (!$this->session->has_userdata('userinfo')) {
            $this->session->set_flashdata('error', 'Please login first to access the page');
            redirect('login/userlogin');
        } else {
            return true;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('userinfo');
        $this->session->set_flashdata('success', 'Logout successful.');

        redirect('login/userlogin');
    }

    public function getCharts()
    {
        $result = $this->product_model->getMarks();
        $data['students'] = $result;
        $this->load->view('/chart/charts_view', $data);
    }
}

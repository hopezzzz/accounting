<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('loginModel');
        $this->load->Model('Client');
        $this->load->helper('globalfunction_helper');
    }

    public function index() {
        $this->load->model('loginModel');
    }

    public function login()
    {
        $loginSessionData = $this->session->userdata('clientData');
        if( !empty($loginSessionData) )
        {
            redirect('dashboard');
        }
        if ($_POST) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run())
            {
                $email      = $this->input->post('email');
                $password   = md5($this->input->post('password'));
                $result     = $this->loginModel->login($email, $password);
                if (count($result) == 1)
                {
                    $isEmailVerified = $result->isEmailVerified;
                    if( $result->isDeleted == 0 )
                    {
                        if ($isEmailVerified == 2)
                        {
                            if ($result->userType != 3)
                            {
                                $companyData = array();
                            }
                            else
                            {
                                $companyData = $this->Client->fetchClientDetailByRef($result->clientRef);
                                if ($result->clientRef)
                                {
                                    if (!$companyData->companyRef)
                                    {
                                        $verifySession = array(
                                            'clientRef'   => $result->clientRef,
                                            'clientEmail' => $result->clientEmail
                                        );
                                        $this->session->set_userdata('verifyClient', $verifySession);
                                        $res['success']         = false;
                                        $res['url']             = site_url('register');
                                        $res['delayTime']       = '2000';
                                        $res['error_message']   = 'Please add company details!!';
                                        echo json_encode($res);
                                        die();
                                    }
                                    else
                                    {
                                        $res['success']         = true;
                                        $res['url']             = site_url('dashboard');
                                        $res['delayTime']       = '2000';
                                        $res['success_message'] = 'Login successful';
                                    }
                                }
                            }
                            $arrayVal = array(
                                'clientId' => $result->id,
                                'clientRef' => $result->clientRef,
                                'LoginTime' => time(),
                                'userType' => $result->userType,
                                'clientEmail' => $result->clientEmail,
                                'companyData' => $companyData
                            );
                            $this->session->set_userdata('clientData', $arrayVal);
                            $res['success']         = true;
                            $res['url']             = site_url('dashboard');
                            $res['delayTime']       = '2000';
                            $res['success_message'] = 'Login successful';
                        }
                        else
                        {
                            $res['success']       = false;
                            $res['error_message'] = 'Please verify your account.';
                        }
                    }
                    else
                    {
                        $res['success']       = false;
                        $res['error_message'] = 'Your account is deleted. Please contact to Administator.';
                    }
                } else {
                    $res['success'] = false;
                    $res['error_message'] = 'Either Username and password is incorrect.';
                }
            }
            else
            {
                $errors             = $this->form_validation->error_array();
                $res['success']     = false;
                $res['formErrors']  = true;
                $res['errors']      = $errors;
            }
            echo json_encode($res);
            die();
        }
        $this->load->view('users/login');
    }

    public function registration() {
        if ($_POST) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() == TRUE) {
                $email = $this->input->post('email');
                $response = $this->loginModel->checkemail($email);
                if ($response) {
                    $res['success'] = false;
                    $res['error_message'] = 'Email already exist. Please try again.';
                    echo json_encode($res);
                    die();
                }

                $password = randomPassword();
                $randomString = generateRef();

                $emailTemplate = getEmailTemplate(1);
                $verification_link = site_url() . 'verify-account/' . $randomString;
                //$receiver_name 		= ucfirst($this->input->post('firstName')).' '.ucfirst($this->input->post('lastName'));
                $variables = array(
                    'verification_link' => $verification_link,
                    'to' => $this->input->post('email'),
                    'receiver_name' => 'User',
                    'password' => $password,
                );

                $mailSend = sendEmail($variables, $emailTemplate);

                if ($mailSend == 1) {
                    $data = array(
                        'clientEmail' => $email,
                        'clientPassword' => md5($password),
                        'clientRef' => $randomString,
                        'userType' => '3',
                        'createdDate' => date('Y-m-d'),
                        'status' => 1,
                    );
                    $clientProfileData = array(
                        'email' => $email,
                        'clientProfileRef ' => $randomString,
                        'createdDate' => date('Y-m-d'),
                        'status' => 0,
                    );

                    $this->loginModel->insertData('acct_clientProfile', $clientProfileData);
                    $result = $this->loginModel->registerEmail($data);
                    $emailSession = array(
                        'email' => $email,
                        'clientRef' => $randomString
                    );
                    $this->session->set_userdata('emailsession', $emailSession);
                }

                if ($result != false) {
                    $res['success'] = 'true';
                    $res['success_message'] = 'Verify email sent to ' . $email;
                }
                echo json_encode($res);
                die();
            }
        }

        $this->load->view('users/login');
        $this->load->view('layout/footer');
    }

    public function verifyAccount($clientRef) {
        if ($clientRef) {
            $getData = $this->loginModel->checkClientRef($clientRef);
            //print_r($getData); die;
            if ($getData) {
                $data = array(
                    'table' => 'acct_companies',
                    'col' => 'clientRef',
                    'val' => $clientRef,
                );

                $companyData = $this->loginModel->getSingleRowData($data);
                // print_r($companyData); die;
                if (!$companyData) {
                    $verifySession = array(
                        'clientRef' => $getData->clientRef,
                        'clientEmail' => $getData->clientEmail
                    );
                    $this->session->set_userdata('verifyClient', $verifySession);
                    redirect(site_url() . register);
                } else {
                   // echo $getData->clientEmail . ' has been verified.';
                    redirect(site_url() . dashboard);
                }
                //echo $getData->clientEmail . ' has been verified.';
            } else {
                echo "Something went wrong.";
            }
        }
    }

    public function register() {
        $this->load->view('users/registration');
    }

    public function registerCompany()
    {
        if ($_POST)
        {
            $this->form_validation->set_rules('companyName', 'Company Name', 'required');
            $this->form_validation->set_rules('contactName', 'Contact Name', 'required');
            $this->form_validation->set_rules('contactPhone', 'Contact Phone', 'required');

            if ($this->form_validation->run() == TRUE)
            {
                $emailSession = $this->session->userdata('emailsession');
                $verifyClient = $this->session->userdata('verifyClient');
                if ($verifyClient)
                {
                    $clientRef = $verifyClient['clientRef'];
                }
                else
                {
                    $clientRef = $emailSession['clientRef'];
                }
                $vatNo       = $this->input->post('vatNo');
                $vatApplied  = $this->input->post('vatApplied');
                $companyName = $this->input->post('companyName');
                $companyType = $this->input->post('companyType');
                $contactName = $this->input->post('contactName');
                $contactPhone = $this->input->post('contactPhone');
                if ($vatApplied == 'on') {
                    $vatApplied = 2;
                } else {
                    $vatApplied = 1;
                }
                $companyRef = generateRef();
                $companyData = array(
                    'companyName' => $companyName,
                    'companyType' => $companyType,
                    'companyRef' => $companyRef,
                    'contactPersonName' => $contactName,
                    'contactPersonPhone' => $contactPhone,
                    'vatNo' => $vatNo,
                    'vatApplied' => $vatApplied,
                    'clientRef ' => $clientRef,
                    'createdDate' => date('Y-m-d'),
                    'modifiedDate' => date('Y-m-d'),
                    'status' => 1,
                    'addedBy' => 0,
                );
                //echo '<pre>'; print_r($companyData); die;
                $result = $this->loginModel->insertData('acct_companies', $companyData);
                $getClientInfo = array(
                    'table' => 'acct_login',
                    'col' => 'clientRef',
                    'val' => $clientRef,
                );

                $clientInfo = $this->loginModel->getSingleRowData($getClientInfo);

                if ($result != false)
                {
                    $this->session->unset_userdata('verifyClient');
                    $res['success'] = 'true';
                    $res['success_message'] = 'Information Saved';

                    $userRef = $this->session->userdata('clientData');
                    $arrayVal = array(
                        'clientId' => $clientInfo->id,
                        'clientRef' => $clientInfo->clientRef,
                        'LoginTime' => time(),
                        'userType' => $clientInfo->userType,
                        'clientEmail' => $clientInfo->clientEmail,
                        'emailVerified' => $clientInfo->isEmailVerified,
                        'companyData' => $this->Client->fetchClientDetailByRef($clientRef)
                    );
                    $this->session->set_userdata('clientData', $arrayVal);

                }
                else
                {
                    $res['success'] = 'false';
                    $res['error_message'] = 'Error';
                }

            }
            else
            {
                $errors             = $this->form_validation->error_array();
                $res['success']     = false;
                $res['formErrors']  = true;
                $res['errors']      = $errors;
            }
            echo json_encode($res);
            die();
        }
    }

    public function register2() {

        $userRef = $this->session->userdata('clientData');
        $data1 = array(
            'table' => 'acct_login',
            'col' => 'clientRef',
            'val' => $userRef['clientId'],
        );
        $data['clientData'] = $this->loginModel->getSingleRowData($data1);

        $this->load->view('users/register2', $data);
    }

    public function resendVerificationEmail() {
        if ($_POST['email']) {

            $randomString = randomPassword();

            $data = array(
                'table' => 'acct_login',
                'col' => 'clientEmail',
                'val' => $_POST['email'],
            );

            $result = $this->loginModel->getSingleRowData($data);
            if ($result != false) {
                $password = randomPassword();
                $emailTemplate = getEmailTemplate(1);
                $verification_link = site_url() . 'verify-account/' . $result->clientRef;
                //$receiver_name 		= ucfirst($this->input->post('firstName')).' '.ucfirst($this->input->post('lastName'));
                $variables = array(
                    'verification_link' => $verification_link,
                    'to' => $this->input->post('email'),
                    'receiver_name' => 'User',
                    'password' => $password,
                );

                sendEmail($variables, $emailTemplate);
                //print_r($checkEmail); die;
                if ($result) {
                    $password = md5($password);

                    $this->loginModel->updatePassword($result->clientRef, $password);
                }

                if ($result != false) {
                    $res['success'] = true;
                    $res['success_message'] = 'Verify email sent to ' . $_POST['email'];
                } else {
                    $res['success'] = false;
                    $res['error_message'] = 'Please enter correct Username and password.';
                }
                echo json_encode($res);
                die();
            }
        }

        $this->load->view('users/login');
        $this->load->view('layout/footer');
    }

    public function checkemail() {
        if ($_POST) {
            $email = $this->input->post('email');
            $response = $this->loginModel->checkemail($email);
            if ($response) {
                $result["success"] = true;
                $result["success_msg"] = 'Email already exist. Please try again.';
            } else {
                $result["success"] = false;
                $result["error_msg"] = 'Email is invalid.';
            }

            echo json_encode($result);
            die();
        }
    }

    public function forgotPassword() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $oldemail = $this->input->post('email');

            $response = $this->loginModel->checkemail($oldemail);
            if (!$response) {
                $result["success"] = false;
                $result["error_message"] = "Email doesn't exist. Please try again.";
                echo json_encode($result);
                die();
            }

            $newPassword = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 10);
            $response = $this->loginModel->changeForgetPassword($oldemail, $newPassword);
            if ($response) {

                $emailTemplate = getEmailTemplate(2);
                $variables = array(
                    'to' => $oldemail,
                    'email' => $oldemail,
                    'loginUrl' => site_url(),
                    'site_title' => 'Accounting',
                    'receiver_name' => 'User',
                    'newPassword' => $newPassword,
                );

                $sendMail = sendEmail($variables, $emailTemplate);
                //echo 'ff'.$sendMail; die;
                if ($sendMail) {
                    $result["success"] = true;
                    $result['url'] = site_url();
                    $result['delayTime'] = '4000';
                    $result["success_message"] = 'Your new password is sent on your email!';
                } else {
                    $result["success"] = false;
                    $result["error_message"] = 'Error.';
                }

                echo json_encode($result);
                die();
            }
        }
        $this->load->view('users/forgotPassword');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard';
        $data['parentUrl'] = 'Dashboard';
        $data['childUrl'] = 'Add Dashboard';
        $this->load->view('layout/header', $data);
        $this->load->view('home');
        $this->load->view('layout/footer');
    }

    public function profile() {
        $clientData = $this->session->userdata('clientData');
        $data = array(
            'table' => 'acct_companies',
            'col' => 'clientRef',
            'val' => $clientData['clientRef'],
        );
        $data['companyData'] = $this->loginModel->getSingleRowData($data);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vatNo = $this->input->post('vatNo');
            $vatApplied = $this->input->post('vatApplied');
            $companyName = $this->input->post('companyName');
            $companyType = $this->input->post('companyType');
            $contactName = $this->input->post('contactName');
            $contactPhone = $this->input->post('contactPhone');
            if ($vatApplied == 'on') {
                $vatApplied = 1;
            } else {
                $vatApplied = 2;
            }
            $companyData = array(
                'companyName' => $companyName,
                'companyType' => $companyType,
                'contactPersonName' => $contactName,
                'contactPersonPhone' => $contactPhone,
                'vatNo' => $vatNo,
                'vatApplied' => $vatApplied,
                'clientRef ' => $clientRef,
                'createdDate' => date('Y-m-d'),
                'modifiedDate' => date('Y-m-d'),
                'status' => 0,
            );


            $response = $this->loginModel->changeForgetPassword($oldemail, $newPassword);
            if ($response) {

                $emailTemplate = getEmailTemplate(2);
                $variables = array(
                    'to' => $oldemail,
                    'email' => $oldemail,
                    'loginUrl' => site_url(),
                    'site_title' => 'Accounting',
                    'receiver_name' => 'User',
                    'newPassword' => $newPassword,
                );

                $sendMail = sendEmail($variables, $emailTemplate);
                //echo 'ff'.$sendMail; die;
                if ($sendMail) {
                    $result["success"] = true;
                    $result["success_msg"] = 'Your new password is sent on your email!';
                } else {
                    $result["success"] = false;
                    $result["error_msg"] = 'Error.';
                }

                echo json_encode($result);
                die();
            }
        }
        $data['title'] = 'Profile';
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('users/profile');
        $this->load->view('layout/footer');
    }


    public function changePassword() {
        $clientData = $this->session->userdata('clientData');
        $clientRef = $clientData['clientRef'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldPassword = md5($this->input->post('oldPassword'));
            $password = md5($this->input->post('confirmPassword'));

            $oldPasswordVerify = $this->loginModel->checkOldPassword($clientRef, $oldPassword);
            //echo $oldPasswordVerify; die;
            if ($oldPasswordVerify) {
                $response = $this->loginModel->updatePassword($clientRef, $password);
                if ($response) {
                    $result["success"] = true;
                    $result['url'] = site_url('dashboard');
                    $result['delayTime'] = '4000';
                    $result["success_message"] = 'Your new password has been changed!';
                } else {
                    $result["success"] = false;
                    $result["error_message"] = 'Error.';
                }
            } else {
                $result['success'] = false;
                $result['error_message'] = 'Old Password is incorrect. Please fill correct one';
            }
            echo json_encode($result);
            die();
        }
        $data['title'] = 'Change Password';
        $data['parentUrl'] = 'Change Password';
        $data['childUrl'] = 'Change Password';

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('users/changePassword');
        $this->load->view('layout/footer');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url());
    }

}

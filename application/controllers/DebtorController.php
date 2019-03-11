<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DebtorController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('DebtorModel');
        $this->perPage    = 10;
        $this->loginSessionData = $this->session->userdata('clientData');
        $this->companyData      = $this->loginSessionData['companyData'];
    }

    public function addDebtor()
    {
        $data['title']      = 'Add debtor';
        $data['parentUrl']  = 'Debtor';
        $data['childUrl']   = 'Add Debtor';

        $debtorData = $this->DebtorModel->getTableCloumns();
        $debtorData->billingAddress  = unserialize($debtorData->billingAddress);
        $debtorData->shippingAddress = unserialize($debtorData->shippingAddress);
        $data['result']              = $debtorData;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('debtors/addDebtor');
        $this->load->view('layout/footer');
    }

    public function addDebtorAjax()
    {
        if ($this->input->is_ajax_request())
        {

          $companyname    = $this->input->post('companyname');
          $companyname    = ($companyname) ? $companyname : '';
          $isCompanyExist = false;
          if ($companyname != '')
              $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname,'type' => '2'));
          if ($isCompanyExist)
          {
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = array('companyname' => 'Oops, company already exist.');
              echo json_encode($response); die;
          }
          else
          {
              if( $companyname != '')
              {
                  $borrowerCompanyRef                    = generateRef();
                  $borrowercompanydata['companyname']    = $companyname;
                  $borrowercompanydata['companyRef']     = $this->companyData->companyRef;
                  $borrowercompanydata['createdDate ']   = date('Y-m-d');
                  $borrowercompanydata['modifiedDate']   = date('Y-m-d');
                  $borrowercompanydata['status']         = 1;
                  $borrowercompanydata['type']           = 2;
                  $borrowercompanydata['addedBy']        = $this->loginSessionData['clientRef'];
                  $borrowercompanydata['borrowerCompanyRef']   = $borrowerCompanyRef;
                  $this->common->insert('company', $borrowercompanydata);
                  $_POST['debtorCompanyRef'] = $borrowerCompanyRef;
              }
              unset($_POST['companyname']);
          }

            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[10]|max_length[17]');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|min_length[10]|max_length[17]');
            $this->form_validation->set_rules('fax', 'Fax', 'trim|min_length[6]|max_length[15]');
            $this->form_validation->set_rules('website', 'Website', 'trim|valid_url');
            if (!$this->form_validation->run())
            {
                $errors                 = $this->form_validation->error_array();
                $response['success']    = false;
                $response['formErrors'] = true;
                $response['errors']     = $errors;
            }
            else
            {
              /* Checking valid email */
                if ($_POST['debtorRef'] != '')
                    $isEmailExist = $this->common->checkexist('debtors', array('debtorRef !=' => $_POST['debtorRef'], 'email' => $this->input->post('email') , 'debtorCompanyRef' => $this->input->post('debtorCompanyRef')));
                else
                    $isEmailExist = $this->common->checkexist('debtors', array('email' => $this->input->post('email') , 'debtorCompanyRef' => $this->input->post('debtorCompanyRef')));

                if ($isEmailExist)
                {
                    $response['success']    = false;
                    $response['formErrors'] = true;
                    $response['errors']     = array('email' => 'Oops, Email already taken.');
                    echo json_encode($response); die;
                }
                /* Checking valid email */
                else
                {
                    $billingAddress     = array(
                        'billingStreet'     => $this->input->post('billingStreet'),
                        'billingCity'       => $this->input->post('billingCity'),
                        'billingState'      => $this->input->post('billingState'),
                        'billingPostalCode' => $this->input->post('billingPostalCode'),
                        'billingCountry'    => $this->input->post('billingCountry'),
                    );
                    $sameAsBilling = isset($_POST['sameAsBilling']) ? $_POST['sameAsBilling'] : '';
                    if ($sameAsBilling != '')
                    {
                        $shippingAddress    = array(
                            'shippingStreet'     => $this->input->post('billingStreet'),
                            'shippingCity'       => $this->input->post('billingCity'),
                            'shippingState'      => $this->input->post('billingState'),
                            'shippingPostalCode' => $this->input->post('billingPostalCode'),
                            'shippingCountry'    => $this->input->post('billingCountry'),
                        );
                    }
                    else
                    {
                        $shippingAddress = array(
                            'shippingStreet'     => $this->input->post('shippingStreet'),
                            'shippingCity'       => $this->input->post('shippingCity'),
                            'shippingState'      => $this->input->post('shippingState'),
                            'shippingPostalCode' => $this->input->post('shippingPostalCode'),
                            'shippingCountry'    => $this->input->post('shippingCountry'),
                        );
                    }
                    unset($_POST['billingStreet']);
                    unset($_POST['billingCity']);
                    unset($_POST['billingState']);
                    unset($_POST['billingPostalCode']);
                    unset($_POST['billingCountry']);
                    unset($_POST['shippingStreet']);
                    unset($_POST['shippingCity']);
                    unset($_POST['shippingState']);
                    unset($_POST['shippingCountry']);
                    unset($_POST['shippingPostalCode']);
                    unset($_POST['sameAsBilling']);
                    $_POST['billingAddress']  = serialize($billingAddress);
                    $_POST['shippingAddress'] = serialize($shippingAddress);
                    if ($_POST['debtorRef'])
                    {
                        $_POST['modifiedDate']  = date('Y-m-d');
                        $this->common->update(array('debtorRef'=>$_POST['debtorRef']),  $_POST,'debtors');
                        $response['success_message'] = 'Debtor updated successfully!';
                    }
                    else
                    {
                        $_POST['companyRef']    = $this->companyData->companyRef;
                        $_POST['createdDate ']  = date('Y-m-d');
                        $_POST['modifiedDate']  = date('Y-m-d');
                        $_POST['status']        = 1;
                        $_POST['addedBy']       = $this->loginSessionData['clientRef'];
                        $_POST['debtorRef']     = generateRef();
                        $this->common->insert('acct_debtors', $_POST);
                        $response['success_message'] = 'Debtor added successfully!';
                    }
                    $response['success']    = true;
                    $response['url']        = site_url('debtors');
                    $response['delayTime']  = '2000';
                }
            }
            echo json_encode($response);
            die;
        }
    }

    public function debtors()
    {
        $output['title']     = 'Debtor Listing';
        $output['parentUrl'] = 'Debtor';
        $output['childUrl']  = 'List Debtor';
        $start      = 0;
        $searchKey  = '';

        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data                       = $this->DebtorModel->fetchDebtors($start, $this->perPage,$searchKey);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('debtors'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;

        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('debtors/debtorlistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('debtors/debtorlist');
            $this->load->view('layout/footer');
        }
    }

    public function updatedebtor($debtorRef = NULL)
    {
        $data['title']      = 'Update debtor';
        $data['parentUrl']  = 'Debtor';
        $data['childUrl']   = 'Add Debtor';

        $debtorData                  = $this->DebtorModel->getDataByRef($debtorRef);
        if(empty($debtorData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('purchase');
        }
        $debtorData->billingAddress  = unserialize($debtorData->billingAddress);
        $debtorData->shippingAddress = unserialize($debtorData->shippingAddress);
        $data['result']              = $debtorData;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('debtors/addDebtor');
        $this->load->view('layout/footer');
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BorrowersController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('BorrowersModel','borrowers');
        $this->perPage = 10;
        $this->loginSessionData = $this->session->userdata('clientData');
        $this->companyData      = $this->loginSessionData['companyData'];
    }

    public function addBorrower()
    {
        $url = current_url();
        $url = explode('/',$url);
        if(end($url) == 'add-lender')
        {
          $data['title']     = 'Add Lender';
          $data['parentUrl'] = 'Loan Management';
          $data['childUrl']  = 'List Lenders';
        }
        else
        {
          $data['title']      = 'Add Borrower';
          $data['parentUrl']  = 'Borrowing Management';
          $data['childUrl']   = 'List Borrower';
        }

        $borrowerData = $this->borrowers->getTableCloumns();
        //echo "<pre>";print_r($borrowerData);die;
        $borrowerData->billingAddress  = unserialize($borrowerData->billingAddress);
        $borrowerData->shippingAddress = unserialize($borrowerData->shippingAddress);
        $data['borrowerData']          = $borrowerData;
        //echo "<pre>";print_r($data['borrowerData']);die;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('borrowers/addBorrower');
        $this->load->view('layout/footer');
    }

    public function addBorrowerAjax()
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $borrowerCompanyRef    = $this->input->post('borrowerCompanyRef');
            if( $borrowerCompanyRef != 'addnew' )
            {
                $this->form_validation->set_rules('borrowerCompanyRef', 'Company', 'required|trim');
                $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
            }
            if( $borrowerCompanyRef == 'addnew' )
                $this->form_validation->set_rules('companyname', 'Company', 'required|trim');
            if (!$this->form_validation->run())
            {
                $errors                 = $this->form_validation->error_array();
                $response['success']    = false;
                $response['formErrors'] = true;
                $response['errors']     = $errors;
            }
            else
            {
              /** Checking valid email **/
              //print_r($_POST); die;
              $email = $_POST['email'];
              $borCompany = $_POST['borrowerCompanyRef'];
              if ($_POST['borrowerRef'] != '')
              {
                  $isEmailExist = $this->common->checkexist('borrowers', array('borrowerRef !=' => $_POST['borrowerRef'], 'email' => $email ,'borrowerCompanyRef' => $borCompany ));
              }
              else{
                  $isEmailExist = $this->common->checkexist('borrowers', array('email' => $email,'borrowerCompanyRef' => $borCompany ));

              }
              if ($isEmailExist)
              {
                  $response['success']    = false;
                  $response['formErrors'] = true;
                  $response['errors']     = array('email' => 'Oops, Email already taken.');
              }

              else
              {

                $companyname    = $this->input->post('companyname');
                $companyname    = ($companyname) ? $companyname : '';
                $isCompanyExist = false;
                if ($companyname != '')
                    $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname));
                if ($isCompanyExist)
                {
                    $response['success']    = false;
                    $response['formErrors'] = true;
                    $response['errors']     = array('companyname' => 'Oops, company already exist.');
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
                        $borrowercompanydata['type']           = 1;
                        $borrowercompanydata['addedBy']        = $this->loginSessionData['clientRef'];
                        $borrowercompanydata['borrowerCompanyRef']   = $borrowerCompanyRef;
                        $this->common->insert('company', $borrowercompanydata);
                        $_POST['borrowerCompanyRef'] = $borrowerCompanyRef;
                    }
                    unset($_POST['companyname']);
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

                    if ($_POST['borrowerRef'])
                    {
                        $_POST['modifiedDate'] = date('Y-m-d');
                        $this->common->update(array('borrowerRef'=>$_POST['borrowerRef']),  $_POST,'borrowers');
                        $response['success_message'] = 'Record updated successfully!';
                    }
                    else
                    {
                        $_POST['companyRef']    = $this->companyData->companyRef;
                        $_POST['createdDate ']  = date('Y-m-d');
                        $_POST['modifiedDate']  = date('Y-m-d');
                        $_POST['status']        = 1;
                        $_POST['addedBy']       = $this->loginSessionData['clientRef'];
                        $_POST['borrowerRef']   = generateRef();
                        $this->common->insert('borrowers', $_POST);

                        $response['success_message'] = 'Record added successfully!';
                    }
                    $response['success']    = true;

                    $url = $_SERVER['HTTP_REFERER'];;
                    $url = explode('/',$url);
                    if(end($url) == 'add-lander')
                    {
                      $response['url']        = site_url('landers');
                    }
                    else
                    {
                        $response['url']        = site_url('borrowers');
                    }

                    $response['delayTime']  = '2000';
                }
            }
          }
            echo json_encode($response);
            die;
        }
    }

    public function index()
    {
        $url = current_url();
        $url = explode('/',$url);
        if(end($url) == 'lenders')
        {
          $output['title']     = 'Lenders Listing';
          $output['parentUrl'] = 'Loan Management';
          $output['childUrl']  = 'List Lenders';
        }
        else
        {
          $output['title']     = 'Borrower Listing';
          $output['parentUrl'] = 'Borrowing Management';
          $output['childUrl']  = 'List Borrower';
        }
        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data                       = $this->borrowers->fetchBorrowers($start, $this->perPage,$searchKey);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('borrowers'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;

        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('borrowers/borrowerlistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('borrowers/borrowerlist');
            $this->load->view('layout/footer');
        }
    }

    public function updateBorrower($borrowerRef = NULL)
    {
          $url = current_url();
          $url = explode('/',$url);
          if(array_search('update-lender',$url))
          {
            $output['title']     = 'Lenders Listing';
            $output['parentUrl'] = 'Loan Management';
            $output['childUrl']  = 'List Lenders';
          }
          else
          {
            $output['title']     = 'Borrower Listing';
            $output['parentUrl'] = 'Borrowing Management';
            $output['childUrl']  = 'List Borrower';
          }

        $borrowerData                   = $this->borrowers->getDataByRef($borrowerRef);
        if(empty($borrowerData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('purchase');
        }
        $borrowerData->billingAddress   = unserialize($borrowerData->billingAddress);
        $borrowerData->shippingAddress  = unserialize($borrowerData->shippingAddress);
        $output['borrowerData']           = $borrowerData;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('borrowers/addBorrower');
        $this->load->view('layout/footer');
    }

}

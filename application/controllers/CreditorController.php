<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CreditorController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('CreditorModel');
        $this->perPage = 10;
        $this->loginSessionData = $this->session->userdata('clientData');
        $this->companyData      = $this->loginSessionData['companyData'];
    }

    public function addCreditor()
    {
        $data['title']      = 'Add Creditor';
        $data['parentUrl']  = 'Creditor';
        $data['childUrl']   = 'Add Creditor';
        $creditorData = $this->CreditorModel->getTableCloumns();
        $creditorData->billingAddress  = unserialize($creditorData->billingAddress);
        $creditorData->shippingAddress = unserialize($creditorData->shippingAddress);
        $data['result']                = $creditorData;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('creditors/addCreditor');
        $this->load->view('layout/footer');
    }

    public function addCreditorAjax()
    {
        if ($this->input->is_ajax_request())
        {
          $companyname    = $this->input->post('companyname');
          $companyname    = ($companyname) ? $companyname : '';
          $isCompanyExist = false;
          if ($companyname != '')
              $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname,'type' => '3'));
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
                  $creditorCompanyRef                    = generateRef();
                  $creditorCompanydata['companyname']    = $companyname;
                  $creditorCompanydata['companyRef']     = $this->companyData->companyRef;
                  $creditorCompanydata['createdDate ']   = date('Y-m-d');
                  $creditorCompanydata['modifiedDate']   = date('Y-m-d');
                  $creditorCompanydata['status']         = 1;
                  $creditorCompanydata['type']           = 3;
                  $creditorCompanydata['addedBy']        = $this->loginSessionData['clientRef'];
                  $creditorCompanydata['borrowerCompanyRef']   = $creditorCompanyRef;
                  $this->common->insert('company', $creditorCompanydata);
                  $_POST['creditorCompanyRef'] = $creditorCompanyRef;
              }
              unset($_POST['companyname']);
          }

            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');
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
                if ($_POST['creditorRef'] != '')
                    $isEmailExist = $this->common->checkexist('creditors', array('creditorRef !=' => $_POST['creditorRef'], 'email' => $this->input->post('email'), 'creditorCompanyRef' => $this->input->post('creditorCompanyRef')));
                else
                    $isEmailExist = $this->common->checkexist('creditors', array('email' => $this->input->post('email'),'creditorCompanyRef' => $this->input->post('creditorCompanyRef')));

                if ($isEmailExist)
                {
                    $response['success']    = false;
                    $response['formErrors'] = true;
                    $response['errors']     = array('email' => 'Oops, Email already taken.');
                }
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

                    if ($_POST['creditorRef'])
                    {
                        $_POST['modifiedDate'] = date('Y-m-d');
                        $this->common->update(array('creditorRef'=>$_POST['creditorRef']),  $_POST,'creditors');
                        $response['success_message'] = 'Creditor updated successfully!';
                    }
                    else
                    {
                        $_POST['companyRef']    = $this->companyData->companyRef;
                        $_POST['createdDate ']  = date('Y-m-d');
                        $_POST['modifiedDate']  = date('Y-m-d');
                        $_POST['status']        = 1;
                        $_POST['addedBy']       = $this->loginSessionData['clientRef'];
                        $_POST['creditorRef']   = generateRef();
                        $this->common->insert('creditors', $_POST);
                        $response['success_message'] = 'Creditor added successfully!';
                    }
                    $response['success']    = true;
                    $response['url']        = site_url('creditors');
                    $response['delayTime']  = '2000';
                }
            }
            echo json_encode($response);
            die;
        }
    }

    public function creditors()
    {
        $output['title']     = 'Creditor Listing';
        $output['parentUrl'] = 'Creditor';
        $output['childUrl']  = 'List Creditor';
        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data                       = $this->CreditorModel->fetchCreditors($start, $this->perPage,$searchKey);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('creditors'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;

        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('creditors/creditorlistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('creditors/creditorlist');
            $this->load->view('layout/footer');
        }
    }

    public function updatecreditor($creditorRef = NULL)
    {
        $data['title']      = 'Update creditor';
        $data['parentUrl']  = 'Creditor';
        $data['childUrl']   = 'List Creditor';

        $creditorData                   = $this->CreditorModel->getDataByRef($creditorRef);
        if(empty($creditorData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('purchase');
        }
        $creditorData->billingAddress   = unserialize($creditorData->billingAddress);
        $creditorData->shippingAddress  = unserialize($creditorData->shippingAddress);
        $data['result']                 = $creditorData;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('creditors/addCreditor');
        $this->load->view('layout/footer');
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Bank');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function bank()
    {
        $output['title']      = 'Bank List';
        $output['parentUrl']  = 'Bank Manegement';
        $output['childUrl']   = 'Bank';

        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Bank->fetchBankList($start, $this->perPage,$searchKey);
        //echo '<pre>';print_r($data); die;
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('bank'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('bank/banklistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('bank/index');
            $this->load->view('layout/footer');
        }
    }

    public function addBank()
    {
        $data['title']      = 'Add Bank';
        $data['parentUrl']  = 'Bank Manegement';
        $data['childUrl']   = 'Add Bank';

        $purchaseDetail          = $this->Bank->getTableCloumns();
        $data['productServices'] = $this->common->getData('products',array('companyRef' =>  $this->companyData->companyRef),'productName,productRef');
        $data['productVat']      = $this->common->getData('vats', array('companyRef' =>  $this->companyData->companyRef),'vatRef,vatPercentage');
        $data['result']          = $purchaseDetail;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');

        $this->load->view('bank/addBank');
        $this->load->view('layout/footer');
    }

    public function ajaxaddbank()
    {
      //print_r($_POST); die;
      if ($this->input->is_ajax_request())
      {
          $this->form_validation->set_rules('name', 'Bank Name', 'required|trim');
          $this->form_validation->set_rules('code', 'Bank Code', 'required|trim');
          $this->form_validation->set_rules('accountNumber', 'Account Number', 'required|trim');
          if (!$this->form_validation->run())
          {
              $errors                 = $this->form_validation->error_array();
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = $errors;
          }
          else
          {
              if ($_POST['bankRef'] != '')
                  $isAccountExits = $this->common->checkexist('acct_banks', array('name ='=>$this->input->post('name') ,'bankRef !=' => $_POST['bankRef'], 'accountNumber' => $this->input->post('accountNumber')));
              else
                  $isAccountExits = $this->common->checkexist('acct_banks', array('name ='=>$this->input->post('name') ,'accountNumber' => $this->input->post('accountNumber')));

              if ($isAccountExits)
              {
                  $response['success']    = false;
                  $response['formErrors'] = true;
                  $response['errors']     = array('accountNumber' => 'Oops, Account Number already taken.');
              }
              else
              {

                  if ($_POST['bankRef'])
                  {
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $this->common->update(array('bankRef'=>$_POST['bankRef']),  $_POST,'acct_banks');
                      $response['success_message'] = 'Bank updated successfully!';

                  }
                  else
                  {
                      $_POST['companyRef']    = $this->companyData->companyRef;
                      $_POST['createdDate']  = date('Y-m-d');
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $_POST['status']        = 1;
                      $_POST['addedBy']       = $this->loginSessionData['clientRef'];
                      $_POST['bankRef']      = generateRef();
                      $this->Bank->addBank($_POST);
                      $response['success_message'] = 'Bank added successfully!';
                      $response['resetform'] = true;
                  }
                  $response['success']    = true;
                  $response['url']        = site_url('bank');
                  $response['delayTime']  = '2000';
              }
          }
          echo json_encode($response);
          die;
      }
    }


    public function updateBank($bankRef = NULL)
    {
        $output['title']      = 'Update Bank';
        $output['parentUrl']  = 'Bank Manegement';
        $output['childUrl']   = 'Bank';

        $bankData                  = $this->Bank->getDataByRef($bankRef);
        if(empty($bankData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('bank');
        }
        $output['result']     = $bankData;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('bank/addBank');
        $this->load->view('layout/footer');
    }


    public function addNewBank()
    {
      $bankName       = $_POST['name'];
      $accountNumber  = $_POST['accountNumber'];
      $bankRef     = generateRef();
      if ($accountNumber != '' && $bankName != '')
          $isAccountExits = $this->common->checkexist('acct_banks', array('companyRef' => $this->companyData->companyRef ,'accountNumber' => $accountNumber ,'name =' => $bankName ));

      if ($isAccountExits)
      {
          $response['success']    = false;
          $response['formErrors'] = true;
          $response['error_message'] = 'Please enter Correcting Entries!';
          $response['errors']     = array('accountNumber' => 'Oops, Account Number already taken.');
          echo json_encode($response); die;
      }


      $response    = $this->Bank->addNewBank($bankName,$bankRef,$accountNumber);
      echo json_encode($response); die;
    }



}

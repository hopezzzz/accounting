<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BorrowingController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Borrowings');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function loans()
    {
        $output['title']      = 'Loans / Advances List';
        $output['parentUrl']  = 'Loan Management';
        $output['childUrl']   = 'loans';

        $start      = 0;
        $searchKey  = '';
        $type       = 1;
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;

        }
        $data = $this->Borrowings->fetchBorrowingsList($start, $this->perPage,$searchKey,$type);
        //echo '<pre>';print_r($data); die;
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('loans'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('loans/ajaxloanlisting', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('loans/index');
            $this->load->view('layout/footer');
        }
    }

    public function addLoans()
    {
        $data['title']      = 'Add Loans';
        $data['parentUrl']  = 'Loan Management';
        $data['childUrl']   = 'Add Loans';
        $BorrowingsDetail   = $this->Borrowings->getTableCloumns();
        $data['result']     = $BorrowingsDetail;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');

        $this->load->view('loans/addLoan');
        $this->load->view('layout/footer');
        $this->load->view('loans/borrowJs');
    }

    public function ajaxaddloan()
    {
      $_POST = array_map("trim", $_POST);
      if ($this->input->is_ajax_request())
      {
          $url = $_SERVER['HTTP_REFERER'];
          $url = explode('/',$url);
          if(end($url) == 'add-loans')
          {
              $this->form_validation->set_rules('loanToRef', 'Lander Name', 'required|trim');
          }
          else
          {
              $this->form_validation->set_rules('loanToRef', 'Borrower Name', 'required|trim');
          }

          $this->form_validation->set_message('loanToRef', 'You must select a business');
          $this->form_validation->set_rules('amount', 'Amount', 'required|trim');
          $this->form_validation->set_rules('date', 'Date', 'required|trim');
          $this->form_validation->set_rules('loanType', 'Loan Type', 'required|trim');
          if (!$this->form_validation->run())
          {
              $errors                 = $this->form_validation->error_array();
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = $errors;
              echo json_encode($response);
              die;
          }
          else
          {
                  // add borrower
                  $borrowType = $this->input->post('borrowType');
                  unset($_POST['borrowType']);
                  $loanToRef = $this->input->post('loanToRef');

                  if( $this->input->post('borrowerCompanyRef') == 'addnew')
                  {
                    $borrowerCompanyRef = generateRef();
                  }
                  else
                  {
                    $borrowerCompanyRef = $this->input->post('borrowerCompanyRef');
                  }
                  if ($loanToRef == 'new')
                  {
                    $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
                    $this->form_validation->set_rules('borrowerCompanyRef', 'Company Name', 'required|trim');
                      if (!$this->form_validation->run())
                      {
                          $errors                 = $this->form_validation->error_array();
                          $response['success']    = false;
                          $response['formErrors'] = true;
                          $response['errors']     = $errors;
                          echo json_encode($response);
                          die;
                      }
                      else
                      {
                          $email = $this->input->post('email');
                          $field ="borrowerRef";
                          $isAccountExits = $this->common->checkexist('acct_borrowers', array('email' => $this->input->post('email'), 'borrowerCompanyRef' => $this->input->post('borrowerCompanyRef')));
                          if ($isAccountExits)
                          {
                              $response['success']    = false;
                              $response['formErrors'] = true;
                              $response['errors']     = array('email' => 'Oops, Email Id already taken.');
                              echo json_encode($response);
                              die;
                          }

                          $companyname    = $this->input->post('companyname');
                          $companyname    = ($companyname) ? $companyname : '';
                          $isCompanyExist = false;
                          if ($companyname != '')
                          {
                              $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname));

                              if ($isCompanyExist)
                              {
                                  $response['success']    = false;
                                  $response['formErrors'] = true;
                                  $response['errors']     = array('companyname' => 'Oops, company already exist.');
                                  echo json_encode($response);
                                  die;
                              }
                              else
                              {
                                  $borrogetShareHolderlistwerCompanyRef       = generateRef();
                                  $borrowercompanydata['companyname']         = $companyname;
                                  $borrowercompanydata['companyRef']          = $this->companyData->companyRef;
                                  $borrowercompanydata['createdDate ']        = date('Y-m-d');
                                  $borrowercompanydata['modifiedDate']        = date('Y-m-d');
                                  $borrowercompanydata['status']              = 1;
                                  $borrowercompanydata['type']                = 1;
                                  $borrowercompanydata['addedBy']             = $this->loginSessionData['clientRef'];
                                  $borrowercompanydata['borrowerCompanyRef']  = $borrowerCompanyRef;
                                  $this->common->insert('company', $borrowercompanydata);
                                  $_POST['borrowerCompanyRef']                = $borrowerCompanyRef;
                              }
                            }

                            $loanData      = array(
                                'email'              => $email,
                                'companyRef'         => $this->companyData->companyRef,
                                'createdDate'        => date('Y-m-d'),
                                'modifiedDate'       => date('Y-m-d'),
                                'status'             => 1,
                                'borrowerCompanyRef' => $this->input->post('borrowerCompanyRef'),
                                'addedBy'            => $this->loginSessionData['clientRef'],
                                $field               => generateRef(),
                            );
                            $borrowerId = $this->common->insert('acct_borrowers', $loanData);
                            if ($borrowerId)
                            {
                                $borrowerRef = $this->common->getSomeFields($field, array('borrowerID' => $borrowerId), 'acct_borrowers');
                                $_POST['loanToRef']    = $borrowerRef->$field;
                            }

                      } #end else
                  }

                  /* Unset variables */
                  unset($_POST['borrowName']);
                  unset($_POST['email']);
                  unset($_POST['borrowerCompanyRef']);
                  unset($_POST['companyname']);
                  if ($_POST['loanRef'])
                  {
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $_POST['date'] = date('Y-m-d',strtotime($_POST['date']));
                      $this->common->update(array('loanRef'=>$_POST['loanRef']),  $_POST,'acct_loans');

                      if($borrowType =='loans')
                        $response['success_message'] = 'Loans / Advances updated successfully!';
                      else
                        $response['success_message'] = 'Borrowing updated successfully!';
                  }
                  else
                  {
                      $_POST['companyRef']    = $this->companyData->companyRef;
                      $_POST['createdDate']   = date('Y-m-d',strtotime($_POST['date']));
                      $_POST['date'] = date('Y-m-d',strtotime($_POST['date']));
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $_POST['status']        = 1;
                      $_POST['addedBy']       = $this->loginSessionData['clientRef'];
                      $_POST['loanRef']       = generateRef();
                      $this->common->insert('loans',$_POST);
                      $response['resetform'] = true;
                      if($borrowType =='loans')
                        $response['success_message'] = 'Loans / Advances added successfully!';
                      else
                        $response['success_message'] = 'Borrowing added successfully!';
                  }
                    $response['success']    = true;
                    $referencePageUrl       = $this->session->userdata('referencePageUrl');
                    $reference              = $this->session->userdata('reference');
                    $referenceType          = $this->session->userdata('referenceType');

                    if( $reference != '' && $referenceType == 'borrower' && $referencePageUrl != '')
                        $response['url']        = $referencePageUrl;
                    else
                        $response['url']        = site_url($borrowType);
                    $response['delayTime']  = '2000';
          }
          echo json_encode($response);
          die;
      }
    }


    public function borrowings()
    {
        $output['title']      = 'Borrowings List';
        $output['parentUrl']  = 'Borrowing Management';
        $output['childUrl']   = 'borrowings';

        $start      = 0;
        $searchKey  = '';
        $type       = 2;
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Borrowings->fetchBorrowingsList($start, $this->perPage,$searchKey,$type);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('loans'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('borrowing/ajaxborrowlisting', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('borrowing/index');
            $this->load->view('layout/footer');
        }
    }

    public function addBorrowing()
    {
        $data['title']      = 'Add Borrowing';
        $data['parentUrl']  = 'Borrowing Management';
        $data['childUrl']   = 'Add Borrowing';
        $BorrowingsDetail   = $this->Borrowings->getTableCloumns();
        $data['result']     = $BorrowingsDetail;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');

        $this->load->view('borrowing/addBorrowing');
        $this->load->view('layout/footer');
        $this->load->view('loans/borrowJs');
    }


    public function updateLoan($loanRef = NULL)
    {
        $output['title']      = 'Update Loan';
        $output['parentUrl']  = 'Loan Management';
        $output['childUrl']   = 'Loans';

        $loanData             = $this->Borrowings->getDataByRef($loanRef);
        if(empty($loanData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('loans');
        }
        $output['result']     = $loanData;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('loans/addLoan');
        $this->load->view('layout/footer');
        $this->load->view('loans/borrowJs');
    }



    public function updateBorrowing($loanRef = NULL)
    {
        $output['title']      = 'Update Borrowing';
        $output['parentUrl']  = 'Borrowing Management';
        $output['childUrl']   = 'borrowings';

        $loanData             = $this->Borrowings->getDataByRef($loanRef);
        if(empty($loanData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('loans');
        }
        $output['result']     = $loanData;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('borrowing/addBorrowing');
        $this->load->view('layout/footer');
        $this->load->view('borrowing/borrowingJs');
    }

    public function borrowerList()
    {
        $detailLower = $_POST['detailLower'];
        $detailUpper = $_POST['detailUpper'];
        $response    = $this->Borrowings->getBorrowerNamelist($detailLower,$detailUpper);
        $checkexist  = 0;
        if (!empty($response))
        {
            echo '<a data-ref="addNewBorrower" href="javascript:void(0)" id="addNewBorrower" class="list-group-item"> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New </a>';
            foreach ($response as $value)
            {
                if(empty($value['firstName']) && empty($value['lastName'])){
                  echo "<a data-ref='" . $value['borrowerRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .ucfirst($value['companyname']). " <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
                }
                else{
                echo "<a data-ref='" . $value['borrowerRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .  $value['title'] .' '. $value['firstName'] .' '. $value['lastName']. " <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
              }
            }
            $checkexist++;
        }
        else
        {
            echo '<a data-ref="addNewBorrower" href="javascript:void(0)" id="addNewBorrower" class="list-group-item"> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New </a>';
            //echo "<li class='list-group-item''> No record found </li>";
        }
    }



}

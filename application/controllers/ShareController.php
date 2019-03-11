<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShareController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('ShareHolder');
        $this->load->model('shareCapital');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function share()
    {
        $output['title']      = 'Share Holder List';
        $output['parentUrl']  = 'Share Holder';
        $output['childUrl']   = 'Share';

        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->ShareHolder->fetchShareHolderList($start, $this->perPage,$searchKey);
        //echo '<pre>';print_r($data); die;
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('share'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('sharaholder/ajaxsharelisting', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('sharaholder/index');
            $this->load->view('layout/footer');
        }
    }

    public function addShare()
    {
        $data['title']      = 'Add Share Holder';
        $data['parentUrl']  = 'Share Holder';
        $data['childUrl']   = 'Add Share';

        $ShareHolderDetail        = $this->ShareHolder->getTableCloumns();
        $data['result']            = $ShareHolderDetail;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');

        $this->load->view('sharaholder/addShare');
        $this->load->view('layout/footer');
    }

    public function addshareAjax()
    {

      if ($this->input->is_ajax_request())
      {
        $_POST = array_map("trim", $_POST);
        $companyname    = $this->input->post('companyname');
        $companyname    = ($companyname) ? $companyname : '';
        $isCompanyExist = false;
        if ($_POST['shareRef'] != '')
            $isEmailExist = $this->common->checkexist('shareHolder', array('shareRef !=' => $_POST['shareRef'], 'email' => $this->input->post('email'), 'shareholCompanyRef' => $this->input->post('shareholCompanyRef')));
        else
            $isEmailExist = $this->common->checkexist('shareHolder', array('email' => $this->input->post('email'),'shareholCompanyRef' => $this->input->post('shareholCompanyRef')));

        if ($companyname != '')
            $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname,'type =' => '4'));

        if ($isCompanyExist)
        {
            $response['success']    = false;
            $response['formErrors'] = true;
            $response['errors']     = array('companyname' => 'Oops, company already exist.');
            echo json_encode($response); die;
        }
        else if ($isEmailExist)
        {
            $response['success']    = false;
            $response['formErrors'] = true;
            $response['errors']     = array('email' => 'Oops, Email already taken.');
            echo json_encode($response); die;
        }

        else
        {
            if( $companyname != '')
            {
                $shareholCompanyRef                       = generateRef();
                $shareHolderCompanydata['companyname']    = $companyname;
                $shareHolderCompanydata['companyRef']     = $this->companyData->companyRef;
                $shareHolderCompanydata['createdDate ']   = date('Y-m-d');
                $shareHolderCompanydata['modifiedDate']   = date('Y-m-d');
                $shareHolderCompanydata['status']         = 1;
                $shareHolderCompanydata['type']           = 4;
                $shareHolderCompanydata['addedBy']        = $this->loginSessionData['clientRef'];
                $shareHolderCompanydata['borrowerCompanyRef']   = $shareholCompanyRef;
                $this->common->insert('company', $shareHolderCompanydata);
                $_POST['shareholCompanyRef'] = $shareholCompanyRef;
            }
            unset($_POST['companyname']);
        }

          $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
          $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');
          $this->form_validation->set_rules('email', 'Email', 'required|trim');
          $this->form_validation->set_rules('noOfShare', 'Number of share', 'required|trim');
          if (!$this->form_validation->run())
          {
              $errors                 = $this->form_validation->error_array();
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = $errors;
          }
          else
          {
                  if ($_POST['shareRef'])
                  {
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $_POST['dob'] = date('Y-m-d',strtotime($_POST['dob']));
                      $this->common->update(array('shareRef'=>$_POST['shareRef']),  $_POST,'shareHolder');
                      $response['success_message'] = 'Share Holder updated successfully!';
                  }
                  else
                  {
                      $_POST['dob']                   = date('Y-m-d',strtotime($_POST['dob']));
                      $_POST['companyRef']            = $this->companyData->companyRef;
                      $_POST['createdDate']           = date('Y-m-d');
                      $_POST['modifiedDate']          = date('Y-m-d');
                      $_POST['status']                = 1;
                      $_POST['addedBy']               = $this->loginSessionData['clientRef'];
                      $_POST['shareRef']              = generateRef();
                      $this->common->insert('shareHolder',$_POST);
                      $response['success_message']    = 'Share Holder added successfully!';
                      $response['resetform']          = true;
                  }
                  $response['submitDisabled']        = true;
                  $response['success']               = true;
                  $response['url']                   = site_url('share');
                  $response['delayTime']             = '2000';


          }
          echo json_encode($response);
          die;
      }
    }


    public function updateShares($shareRef = NULL)
    {
        $output['title']      = 'Update Share Holder';
        $output['parentUrl']  = 'Share Holder';
        $output['childUrl']   = 'Share';

        $loanData             = $this->ShareHolder->getDataByRef($shareRef);
        if(empty($loanData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('share');
        }
        $output['result']     = $loanData;
        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('sharaholder/addShare');
        $this->load->view('layout/footer');
    }


    /******************** function for share capital **********************/

    public function shareCapital()
    {
            $output['title']      = 'Share Capital List';
            $output['parentUrl']  = 'Share Capital';
            $output['childUrl']   = 'share-capital';

            $start      = 0;
            $searchKey  = '';
            if ($this->input->is_ajax_request())
            {
                $searchKey  = $this->input->post('searchKey');
                $page       = $this->input->post('page');
                $start      = ( $page - 1 ) * $this->perPage;
            }
            $data = $this->shareCapital->fetchShareCapitaList($start, $this->perPage,$searchKey);
            //echo '<pre>';print_r($data); die;
            $output['records']          = $data['result'];
            $output['paginationLinks']  = getPagination(site_url('share-capital'), $this->perPage, $data['total_rows'], '', 1);
            $output['start']			= $start;
            if ($this->input->is_ajax_request())
            {
                $response['html'] = $this->load->view('shareCapital/ajaxsharelisting', $output, TRUE);
                echo json_encode($response);
                exit;
            }
            else
            {
                $this->load->view('layout/header', $output);
                $this->load->view('layout/sidebar');
                $this->load->view('shareCapital/index');
                $this->load->view('layout/footer');
            }
    }

    public function addCapitalShare()
    {
          $data['title']      = 'Add Share Capital';
          $data['parentUrl']  = 'Share Capital';
          $data['childUrl']   = 'add-share-capital';

          $ShareHolderDetail        = $this->shareCapital->getTableCloumns();
          $data['result']            = $ShareHolderDetail;

          $this->load->view('layout/header', $data);
          $this->load->view('layout/sidebar');

          $this->load->view('shareCapital/addShareCapital');
          $this->load->view('shareCapital/shareCapitalJs');
          $this->load->view('layout/footer');
    }

    public function addshareCapitalAjax()
    {

          if ($this->input->is_ajax_request())
          {
              $this->form_validation->set_rules('paymentMethod', 'Payment Method', 'required|trim');
              if ($this->form_validation->run())
              {

                  $paymentMethod              = $this->input->post('paymentMethod');
                  $shareCapitalItemsRefers    = $this->input->post('shareCapitalItemsRefers');
                  $transactionItemRef         = $this->input->post('transactionItemRef');
                  $shareCapitalRefers         = $this->input->post('shareCapitalRef');
                  $itemData                   = $this->input->post('quantity');
                  $shareHolderRef             =$this->input->post('shareHolderRef');
                  if ($shareHolderRef == 'new')
                  {

                    $this->form_validation->set_rules('newemail'     , 'Email Id'         , 'trim|required|valid_email');
                    $this->form_validation->set_rules('newHolderName', 'Share Holder Name', 'required');
                    $this->form_validation->set_rules('noOfShare'    , 'No Of Shares'     , 'required|trim|numeric');
                    $this->form_validation->set_rules('shareholCompanyRef'    , 'Share Holder Company'     , 'required');
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
                          $newHolderName  = $this->input->post('newHolderName');
                          $expnewHolderName  = explode(' ', $newHolderName);
                          if(count($expnewHolderName) == 1){
                              $expnewHolderName[0]  = $newHolderName;
                              $expnewHolderName[1]  = NULL;
                          }
                          $title  = $this->input->post('title');
                          $newemail       = $this->input->post('newemail');
                          $noOfShare      = $this->input->post('noOfShare');
                          $field          = 'shareRef';
                          /* Checking valid email */
                          if( trim($_POST['shareholCompanyRef']) !=''){
                            $shareholCompanyRef   = $_POST['shareholCompanyRef'];
                          }
                          else{
                            $shareholCompanyRef   = generateRef();
                          }
                          $isAccountExits = $this->common->checkexist('shareHolder', array('email' => $newemail,'shareholCompanyRef' => $shareholCompanyRef));
                          if ($isAccountExits)
                          {
                              $response['success']    = false;
                              $response['formErrors'] = true;
                              $response['errors']     = array('newemail' => 'Oops, Email ID already taken.');
                              echo json_encode($response); die;
                          }
                          /* Checking valid email */
                          $companyname    = $this->input->post('companyname');
                          $companyname    = ($companyname) ? $companyname : '';
                          $isCompanyExist = false;
                          if ($companyname != '')
                              $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname,'type =' => '4'));
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
                                  $shareHolderCompanydata['companyname']    = $companyname;
                                  $shareHolderCompanydata['companyRef']     = $this->companyData->companyRef;
                                  $shareHolderCompanydata['createdDate ']   = date('Y-m-d');
                                  $shareHolderCompanydata['modifiedDate']   = date('Y-m-d');
                                  $shareHolderCompanydata['status']         = 1;
                                  $shareHolderCompanydata['type']           = 4;
                                  $shareHolderCompanydata['addedBy']        = $this->loginSessionData['clientRef'];
                                  $shareHolderCompanydata['borrowerCompanyRef']   = $shareholCompanyRef;
                                  $this->common->insert('company', $shareHolderCompanydata);

                              }
                              unset($_POST['companyname']);
                              unset($_POST['shareholCompanyRef']);
                          }

                          $shareHolderData      = array(
                              'title'             => $title,
                              'firstName'         => $expnewHolderName[0],
                              'lastName'          => $expnewHolderName[1],
                              'shareholCompanyRef'=> $shareholCompanyRef,
                              'companyRef'        => $this->companyData->companyRef,
                              'createdDate'       => date('Y-m-d'),
                              'modifiedDate'      => date('Y-m-d'),
                              'email'             => $newemail,
                              'noOfShare'         => $noOfShare,
                              'status'            => 1,
                              'addedBy'           => $this->loginSessionData['clientRef'],
                              $field              => generateRef(),
                          );
                          $shareHolderID = $this->common->insert('shareHolder', $shareHolderData);
                          if ($shareHolderID)
                          {
                              $dataRef = $this->common->getSomeFields($field, array('id' => $shareHolderID), 'shareHolder');
                              $shareHolderRef    = $dataRef->$field;
                          }
                  }
                }
                  if ($shareCapitalRefers == '')
                  {
                      $shareCapitalRef = generateRef();
                  }
                  else
                  {
                      $shareCapitalRef = $shareCapitalRefers;
                  }


                  $transactionData = array(
                      'shareCapitalRef' => $shareCapitalRef,
                      'companyRef'      => $this->companyData->companyRef,
                      'shareCapitalRef' => $shareCapitalRef,
                      'shareHolderRef'  => $shareHolderRef,
                      'paymentMethod'   => $this->input->post('paymentMethod'),
                      'Date'            => date('Y-m-d',strtotime($this->input->post('Date'))),
                      'subTotal'        => $this->input->post('subTotal'),
                      'bankRef'        => $this->input->post('bankRef'),
                  );

                  if ($shareCapitalRefers)
                  {
                      $transactionDataUpdate = array(
                          'modifiedDate' => date('Y-m-d')
                      );
                      $transactionDataFinal = array_merge($transactionData, $transactionDataUpdate);
                      $this->common->update(array('shareCapitalRef' => $shareCapitalRef), $transactionDataFinal, 'shareCapital');
                  }
                  else
                  {
                      $transactionDataAdd = array(
                          'createdDate'   => date('Y-m-d'),
                          'modifiedDate'  => date('Y-m-d'),
                          'status'        => 1,
                          'addedBy'       => $this->loginSessionData['clientRef']
                      );
                      $transactionDataFinal = array_merge($transactionData, $transactionDataAdd);
                      //print_r($transactionDataFinal); die;
                      $this->db->insert('shareCapital', $transactionDataFinal);
                  }
                  // add transaction item
                  //$itemData = $this->input->post('product');
                  $NoOfShares = 0;
                  if (!empty($itemData))
                  {
                      $quantity       = $this->input->post('quantity');
                      $description    = $this->input->post('description');
                      $rate           = $this->input->post('rate');
                      if(!empty($shareCapitalItemsRefers))
                      {
                        $itemRefrense = explode(',',$shareCapitalItemsRefers);
                        foreach($itemRefrense as $key=>$val)
                        {
                          if($val)
                          {
                            $this->shareCapital->deleteItems($val);
                          }
                        }
                      }
                      $shareCapitalItemArrUpdate   = array();
                      $shareCapitalItemArrAdd      = array();

                      for ($i = 0; $i < count($itemData); $i++)
                      {
                          if (empty($transactionItemRef[$i]))
                          {

                              $itemRef = generateRef();
                                // Array For Sale and Purchase
                                $shareCapitalItemArrAdd[$i] = array(
                                    'itemRef'        => $itemRef,
                                    'shareCapitalRef' => $shareCapitalRef,
                                    'quantity'       => $quantity[$i],
                                    'description'    => $description[$i],
                                    'rate'           => $rate[$i],
                                    'amount'         => $quantity[$i] * $rate[$i],
                                    'status'         => 1,
                                    'createdDate'    => date('Y-m-d'),
                                    'modifiedDate'   => date('Y-m-d'),
                                    'addedBy'        => $this->loginSessionData['clientRef']
                                );
                                //print_r($shareCapitalItemArrAdd); die;
                          }
                          else
                          {

                                 $shareCapitalItemArrUpdate[$i] = array(
                                   'itemRef'        => $transactionItemRef[$i],
                                   'shareCapitalRef' => $shareCapitalRef,
                                   'quantity'       => $quantity[$i],
                                   'description'    => $description[$i],
                                   'rate'           => $rate[$i],
                                   'amount'         => $quantity[$i] * $rate[$i],
                                   'status'         => 1,
                                   'modifiedDate'   => date('Y-m-d'),
                                 );

                                 $NoOfShares +=$quantity[$i];

                        }
                      }
                      if (!empty($shareCapitalItemArrAdd))
                      {
                          $this->db->insert_batch('shareCapitalitems', $shareCapitalItemArrAdd);

                      }
                      if (!empty($shareCapitalItemArrUpdate))
                      {
                          $this->db->update_batch('shareCapitalitems', $shareCapitalItemArrUpdate, 'itemRef');
                      }

                      /** shares deductions **/
                      //$sharevalues = totalShares($NoOfShares,$this->input->post('shareHolderRef'));


                      if ($shareCapitalRefers)
                      {
                          $response['success']         = true;
                          $response['url']             = site_url('share-capital');
                          $response['delayTime']       = '2000';
                          $response['resetform']       = false;
                          $response['success_message'] = ' Share Capital updated successfully!';
                          $response['submitDisabled']  = true;
                      }
                      else
                      {
                          $response['success']         = true;
                          $response['resetform']       = true;
                          $response['submitDisabled']  = true;
                          $response['url']             = site_url('share-capital');
                          $response['delayTime']       = '2000';
                          $response['success_message'] = 'Share Capital added successfully!';
                      }
                  }
                  else
                  {
                      $errors                 = $this->form_validation->error_array();
                      $response['success']    = false;
                      $response['formErrors'] = true;
                      $response['errors']     = $errors;
                  }
                  echo json_encode($response);
                  die;
              }
          }
    }

    public function updateshareCapital($ref)
    {
          $data['title'] = 'Update Share Capital';
          $data['parentUrl'] = 'Share Capital';
          $data['childUrl'] = 'share-capital';
          $shareCapitalRef = $this->shareCapital->getDataByRef($ref);
          $data['result'] = $shareCapitalRef;
          $this->load->view('layout/header', $data);
          $this->load->view('layout/sidebar');
          $this->load->view('shareCapital/addShareCapital');
          $this->load->view('layout/footer');
          $this->load->view('shareCapital/shareCapitalJs');
    }

    public function getShareHolderlist()
    {
          $detailLower = $_POST['detailLower'];
          $detailUpper = $_POST['detailUpper'];
          $response    = $this->shareCapital->getShareHolderlist($detailLower,$detailUpper);
          $checkexist  = 0;
          if (!empty($response))
          {
              echo "<a  href='javascript:void(0)' class='list-group-item setlist list-group-item-action' data-ref='addNewHolder' id='addNewHolder'> <i class='fa fa-plus'></i> &nbsp; &nbsp; Add New Share Holder</a>";
              foreach ($response as $value)
              {
                    echo "<a data-ref='" . $value['shareRef'] . "' href='javascript:void(0)' class='list-group-item setlist list-group-item-action'>" .  $value['title'] .' '. $value['firstName'] .' '. $value['lastName']. "<span class='badge badge-default badge-pill'> ".$value['noOfShare']."</span> <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
                    $checkexist++;
              }
          }
          else
          {
              echo "<a  href='javascript:void(0)' class='list-group-item setlist list-group-item-action' data-ref='addNewHolder' id='addNewHolder'> <i class='fa fa-plus'></i> &nbsp; &nbsp; Add New Share Holder</a>";
          }
    }
}

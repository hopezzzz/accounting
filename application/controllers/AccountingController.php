<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountingController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Accounting');
        $this->perPage            = 50;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function index()
    {
        $output['title']      = 'Charts of Account';
        $output['parentUrl']  = 'Accounting Manegement';
        $output['childUrl']   = 'Accounting';

        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Accounting->fetchAccountingList($start, $this->perPage,$searchKey);
        //echo '<pre>';print_r($data); die;
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('accounting'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('Accounting/accountinglistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('Accounting/index');
            $this->load->view('layout/footer');
        }
    }

    public function addAccounting()
    {
        $data['pageType']   = 'add';
        $data['title']      = 'Add Chart of Account';
        $data['parentUrl']  = 'Accounting Manegement';
        $data['childUrl']   = 'Add Accounting';

        $chartaccountdetails          = $this->Accounting->getTableCloumns();
        $data['productServices']      = getCategoriesType();
        $data['categories']           = $this->common->getData('trialBalanceCategories', '','title,categoryRef,type');
        $data['result']               = $chartaccountdetails;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');

        $this->load->view('Accounting/addAccounting');
        $this->load->view('layout/footer');
    }

    public function ajaxaddaccounting()
    {
      if ($this->input->is_ajax_request())
      {
        if(isset($_POST['modelHide']))
        {
          $modelHide = true;
        }
        else{
          $modelHide = false;
        }
        unset($_POST['modelHide']);
          if(isset($_POST['cattype'])){
            $this->form_validation->set_rules('cattype', 'Category Type', 'required|trim');
          }
          else{
            //if catttype not set then request come from expense view
            $_POST['ParentCategoryRef'] = $_POST['ParentCategory'];
            //unset Variable
            unset($_POST['ParentCategory']);
          }
          $this->form_validation->set_rules('title', 'Category Name', 'required|trim');
          $title =$this->input->post('title');
          if($this->input->post('ParentCategoryRef') !== '')
          {
            $cattype = $this->input->post('ParentCategoryRef');
          }
          else
          {
            $cattype =$this->input->post('cattype');
          }


          $isAccountExits = $this->common->checkexist('trialBalanceCategories', array('companyRef =' => $this->companyData->companyRef, 'title' => $title , 'ParentCategoryRef' => $cattype));

          if ($isAccountExits)
          {
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = array('title' => 'Oops, Category name already taken.');
              echo json_encode($response); die;
          }
          else{
          if (!$this->form_validation->run())
          {
              $errors                 = $this->form_validation->error_array();
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = $errors;
          }
          else
          {

                  if($this->input->post('ParentCategoryRef') !== '')
                  {
                    $parentRef = $this->input->post('ParentCategoryRef');
                  }
                  else
                  {
                    $parentRef = $this->input->post('parentCat');
                  }
                  $parentid  = getCategoryId($parentRef);
                  //print_r($parentid->categoryID);die;
                  unset($_POST['parentCat']);
                  unset($_POST['cattype']);
                  $_POST['ParentCategoryRef'] = $parentRef;

                  if (isset($_POST['categoryRef']) && trim($_POST['categoryRef']) !="")
                  {
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $this->common->update(array('categoryRef'=>$_POST['categoryRef']),  $_POST,'trialBalanceCategories');
                      $response['success_message'] = 'Record updated successfully!';
                  }
                  else
                  {

                      $_POST['companyRef']        = $this->companyData->companyRef;
                      $_POST['createdDate']       = date('Y-m-d');
                      $_POST['modifiedDate']      = date('Y-m-d');
                      $_POST['status']            = 1;
                      $_POST['addedBy']           = $this->loginSessionData['clientRef'];
                      $_POST['categoryRef']       = generateRef();
                      if(!empty($parentid->categoryID)){
                        $_POST['parent']            = $parentid->categoryID;
                      }
                      else {
                        $_POST['parent']            = 0;
                      }

                      $this->common->insert('trialBalanceCategories',$_POST);
                      $response['success_message'] = 'Record added successfully!';
                  }
                  $response['success']      = true;
                  $response['resetform']    = true;
                  if($modelHide == true){
                        $response['modelhide']            = true;
                        $response['subcatRef']            = $_POST['categoryRef'];
                        $response['title']                = $_POST['title'];
                        $response['ParentCategoryRef']    = $_POST['ParentCategoryRef'];
                    }else{
                        $response['url']          = site_url('accounting');
                    }
                  $response['delayTime']  = '2000';

          }
        }
          echo json_encode($response);
          die;
      }
    }

    public function updateAccountingAjax()
    {
        if ($this->input->is_ajax_request())
        {

            $this->form_validation->set_rules('title', 'Category Name', 'required|trim');
            $title =$this->input->post('title');
            $cattype = $this->input->post('ParentCategoryRef');
            $categoryRef = $this->input->post('categoryRef');
            $isAccountExits = $this->common->checkexist('trialBalanceCategories', array('categoryRef !=' => $categoryRef,'title' => $title , 'ParentCategoryRef' => $cattype),array('companyRef' => '1'));
            if ($isAccountExits)
            {
                $response['success']    = false;
                $response['formErrors'] = true;
                $response['errors']     = array('title' => 'Oops, Category name already taken.');
                echo json_encode($response); die;
            }
            else{
            if (!$this->form_validation->run())
            {
                $errors                 = $this->form_validation->error_array();
                $response['success']    = false;
                $response['formErrors'] = true;
                $response['errors']     = $errors;
            }
            else
            {
                if($this->input->post('ParentCategoryRef') !== '')
                {
                  $parentRef = $this->input->post('ParentCategoryRef');
                }
                $parentid  = getCategoryId($parentRef);
                unset($_POST['parentCat']);
                unset($_POST['cattype']);
                $_POST['ParentCategoryRef'] = $parentRef;
                if ($_POST['categoryRef'])
                {
                    $_POST['modifiedDate']  = date('Y-m-d');
                    $this->common->update(array('categoryRef'=>$_POST['categoryRef']),  $_POST,'trialBalanceCategories');
                    $response['success_message'] = 'Record updated successfully!';
                }
                $response['success']               = true;
                $response['url']                   = site_url('accounting');
                $response['submitDisabled']        = true;
                $response['delayTime']             = '2000';
            }
          }
            echo json_encode($response);  die;
        }
    }

    public function updateAccounting($categoryRef = NULL)
    {
        $output['pageType']   = 'update';
        $output['title']      = 'Update Accounting';
        $output['parentUrl']  = 'Accounting Manegement';
        $output['childUrl']   = 'Accounting';
        $output['productServices']      = getCategoriesType();
        $bankData                  = $this->Accounting->getDataByRef($categoryRef);
        if(empty($bankData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('accounting');
        }
        $output['result']          = $bankData;

        $output['categories']      = $this->common->getData('trialBalanceCategories', array('type' => $output['result']->type, 'parent' => 0 ),'title,categoryRef,type');

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('Accounting/addAccounting');
        $this->load->view('layout/footer');
    }


    public function getCategories()
    {
        $param = strtolower($_POST['type']);
        $response    = getCategorieslistByName($this->companyData->companyRef,$param);
        $checkexist = 0;
        if (!empty($response))
        {
            echo '<option value="0"> Select Category </option>';
            foreach ($response as $value)
            {
                echo '<option data-ref="'.$value->ParentCategoryRef.'" value="'.$value->categoryRef.'">'.$value->title.'</option>';
            }
            $checkexist++;
        }
        else
        {
            echo '<option value=""> No record found </option>';
        }
    }
    public function getTransactionlist()
    {
        if($_POST['subcategoryRef'] !=''){
          $subcategoryRef = $_POST['subcategoryRef'];
          $response = $this->Accounting->getTransactionlist($subcategoryRef);
        }
        else{
          $response['success']        =  false;
          $response['error_message']  =  "Something went wrong please try again.";
        }
        echo json_encode($response); die;
    }

    public function deleteTransactions()
    {

        if ($this->input->is_ajax_request())
    		{
    			     $status  = $this->input->post('status');
    			     $categoryRef  = $this->input->post('categoryRef');

        			if( $status == '' && $categoryRef == '')
        			{
          				$response['success']  		= false;
          				$response['error_message']  = 'Something went wrong. Please try agian.';
        			}
        			else
        			{
                if( $status == 1 )  $status = 0; else $status = 1;
                    $result = $this->Accounting->deleteTransactions($_POST,$status);
            				if( $result )
            				{
              					$response['success']  		    = true;
                        $response['modelhide']        = true;
                        $response['categoryRef']      = $_POST['categoryRef'];
                        $response['status']           = $status;
              					$response['success_message']  = 'Record updated successfully.';
            				}
            				else
            				{
              					$response['success']  		  = false;
              					$response['error_message']  = 'Something went wrong. Please try agian.';
            				}
    			   }
    			   echo json_encode($response);die;
    		}

    }

}

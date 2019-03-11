<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExpenseController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Expense');
        $this->perPage = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

      public function expense()
      {
        $output['title']      = 'Expense List';
        $output['parentUrl']  = 'Expense';
        $output['childUrl']   = 'Expense';
        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Expense->fetchExpenseList($start, $this->perPage,$searchKey);
        //echo "<pre>";print_r($data);die;
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('expense'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('expense/expenselistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('expense/index');
            $this->load->view('layout/footer');
        }
    }

    public function addExpense() {
        $expenseDetail = $this->Expense->getTableCloumns();
        //$data['expenseCat'] = $this->common->getData('trialBalanceCategories',array('type' => 'expense','parent' => '0'),'title,categoryRef,categoryID');
        $data['expenseCat']  = getParentcategories($this->companyData->companyRef,'categoryID,categoryRef,ParentCategoryRef,title','expense');
        //$data['expenseCat'] = $this->Expense->getProCategories($id = 0, $ss = '');
        //echo "<pre>"; print_r($data['expenseCat']);
        //$data['expenseCat'] = $this->Expense->getProCategories();
	      //echo "<pre>";print_r($data);
        $data['productVat'] = $this->common->getData('vats', array('companyRef' =>  $this->companyData->companyRef),'vatRef,vatPercentage');
        $data['invoiceNo'] = $this->common->getData('transactions', array('transactionType' => '1','companyRef' => $this->companyData->companyRef),'transactionID');
        $data['title'] = 'Add Expense';
        $data['parentUrl'] = 'Expense';
        $data['childUrl'] = 'Add Expense';
        $data['result'] = $expenseDetail;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('expense/addExpense');
        $this->load->view('layout/footer');
        $this->load->view('expense/expenseJs');
    }

    public function getcreditorList() {
        $detailLower = $_POST['detailLower'];
        $detailUpper = $_POST['detailUpper'];
        $dataRef = "creditorRef";
        $tableName = "acct_creditors";
        $response = getPayeeNamelist($detailLower,$detailUpper,$dataRef,$tableName);

        $checkexist = 0;

        if (!empty($response)) {
          ;
            echo '<a data-ref="addNewCreditor" href="javascript:void(0)" id="addNewCreditor" class="list-group-item list-group-item-action creditorBtn"> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Creditor</a>';
            foreach ($response as $value) {
             echo "<a data-ref='" . $value['creditorRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .  $value['title'] .' '. $value['firstName'] .' '. $value['lastName']. "</a>";
            }
            $checkexist++;
        } else {
          echo '<a data-ref="addNewCreditor" href="javascript:void(0)" id="addNewCreditor" class="list-group-item list-group-item-action creditorBtn"> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Creditor</a>';
          //echo "<li class='list-group-item creditorBtn' style='padding:4px;0'> <a data-ref='addNewCreditor' id='addNewCreditor'  href='javascript:void(0)' class='btn list-group-item '></a></li>";
        }

    }


    public function updateexpense($expenseRef = NULL) {
      if(!empty($this->session->userdata('transactionRefUrl'))){
        $output['title']           = 'Update Expense';
        $output['parentUrl']       = 'reports';
        $output['childUrl']        = 'general-ledger';
      }else
      {
        $output['title'] = 'Update Expense';
        $output['parentUrl'] = 'Expense';
        $output['childUrl'] = 'Expense';
      }

        $output['expenseCat']  = getParentcategories($this->companyData->companyRef,'categoryID,categoryRef,ParentCategoryRef,title','expense');
        $output['productVat'] = $this->common->getData('vats', array('companyRef' => $this->companyData->companyRef),'vatRef,vatPercentage');
        $expenseRef = $this->Expense->getDataByRef($expenseRef);
        //print_r(unserialize($output['result'][0]->billingAddress)['billingStreet']);
        $output['result'] = $expenseRef;
        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('expense/addExpense');
        $this->load->view('layout/footer');
        $this->load->view('expense/expenseJs');
    }

  public function addCategories(){
    // categoryType == 1 For Childer Categories && categoryType == 0 For parent
    if($_POST['categoryType'] == 1){
       $catNameRef = trim($_POST['catNameRef']);
       $subcatName = trim($_POST['subcatName']);
       $categories = $this->Expense->addNewChildCategories($catNameRef,$subcatName);
       echo json_encode($categories); die;
    }else{
       $textcatname = trim($_POST['textcatname']);
       $textsubcatname = trim($_POST['textsubcatname']);
       $categories = $this->Expense->addNewParentCategories($textcatname,$textsubcatname);
       //print_r($categories);
       echo json_encode($categories); die;
    }

  }

  public function getcategorylist()
  {
      $detailLower = $_POST['detailLower'];
      $detailUpper = $_POST['detailUpper'];
      $type        = $_POST['type'];
      $response    = $this->Expense->getcategorylistByName($detailLower,$detailUpper,$type);
      $checkexist  = 0;
      if (!empty($response))
      {
          echo '<a id="addNewCategory" href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-ref="addNewCategory" class="list-group-item "> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Category</a>';
          foreach ($response as $value)
          {
              echo "<a data-ref='" . $value['categoryRef'] . "' parent-ref='" . $value['ParentCategoryRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .  $value['title'] . "</a>";
          }
          $checkexist++;
      }
      else
      {
          echo '<a id="addNewCategory" href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-ref="addNewCategory" class="list-group-item "> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Category</a>';
      }
      
  }

}

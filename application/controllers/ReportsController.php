<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportsController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('Reports');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function index()
    {
        $output['title']      = 'Reports';
        $output['parentUrl']  = 'reports';
        $output['childUrl']   = 'reports';

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('reports/index');
        $this->load->view('layout/footer');
    }

    public function trialBalance()
    {
        $output['title']      = 'Trial Balance';
        $output['parentUrl']  = 'reports';
        $output['childUrl']   = 'reports';

        $searchKey  = '';
        $fromDate   = '';
        $toDate     = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $fromDate   = $this->input->post('fromDate');
            $toDate     = $this->input->post('toDate');
        }
        $output['accounts']      = getCategoriesType();
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('reports/trialbalanceajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('reports/trialbalance');
            $this->load->view('layout/footer');
        }
    }

    public function GeneralLedger()
    {
        if(!empty($this->session->userdata('transactionRefUrl')))
        {
            $this->session->unset_userdata('transactionRefUrl');
        }
        $output['title']      = 'General Ledger';
        $output['parentUrl']  = 'reports';
        $output['childUrl']   = 'general-ledger';

        $searchKey  = '';
        $fromDate   = '';
        $toDate     = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $fromDate   = $this->input->post('fromDate');
            $toDate     = $this->input->post('toDate');
        }

        if ($this->input->is_ajax_request())
        {
            $data = $this->Reports->fetchTransactionsLists($searchKey,$fromDate,$toDate);
        }
        else
        {
            $data = array();
        }
        $output['records']        = $data;
        $parentCats               = getParentcategories($this->companyData->companyRef,'categoryID,categoryRef,ParentCategoryRef,title');
        $output['parentCats']     = $parentCats;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('reports/GeneralLedger/transactionslistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('reports/GeneralLedger/index');
            $this->load->view('layout/footer');
        }
    }

    public function banktransaction()
    {
      $url = $_SERVER['HTTP_REFERER'];
      $url = explode('/',$url);
      $this->session->set_userdata('transactionRefUrl', end($url));
    }


    public function profitLoss()
    {
        $output['title']      = 'Profit Loss';
        $output['parentUrl']  = 'reports';
        $output['childUrl']   = 'profit-loss';

        $searchKey  = '';
        $fromDate   = '';
        $toDate     = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $fromDate   = $this->input->post('fromDate');
            $toDate     = $this->input->post('toDate');
        }

        if ($this->input->is_ajax_request())
        {
            $data = $this->Reports->fetchTransactionsLists($searchKey,$fromDate,$toDate);
        }
        else
        {
            $data = array();
        }
        $output['records']        = $data;
    /*    $incomeCategories         = $this->common->getData('trialBalanceCategories', array('type'=>'income','parent'=>0,'status'=>1),'*' );
        $expenseCategories         = $this->common->getData('trialBalanceCategories', array('type'=>'expense','parent'=>0,'status'=>1),'*' );
        //echo "<pre>";print_r($incomeCategories);
        //echo "<pre>";print_r($expenseCategories);
        if( !empty($incomeCategories) )
        {
            foreach ($incomeCategories as $key => $value)
            {
                $incomeCategories[$key]->subCategories = $this->common->getData('trialBalanceCategories', array('ParentCategoryRef'=>$value->categoryRef,'status'=>'1'),'*' );
            }
        }
        if( !empty($expenseCategories) )
        {
            foreach ($expenseCategories as $key => $value)
            {
                $expenseCategories[$key]->subCategories = $this->common->getData('trialBalanceCategories', array('ParentCategoryRef'=>$value->categoryRef,'status'=>'1'),'*' );
            }
        }
        $output['incomeCategories']     = $incomeCategories;
        $output['expenseCategories']    = $expenseCategories;*/
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('reports/profitloss/listajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('reports/profitloss/index');
            $this->load->view('layout/footer');
        }
    }
}

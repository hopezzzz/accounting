<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Sales');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function sales()
    {
        $output['title']      = 'Sales List';
        $output['parentUrl']  = 'Sales';
        $output['childUrl']   = 'Sales';
        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Sales->fetchSalesList($start, $this->perPage,$searchKey);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('sales'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('sales/saleslistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('sales/index');
            $this->load->view('layout/footer');
        }
    }

    public function Addsale()
    {
        $data['title']           = 'Add Invoice';
        $data['parentUrl']       = 'Sales';
        $data['childUrl']        = 'Add Sale';

        $salesDetail             = $this->Sales->getTableCloumns();
        $data['productServices'] = $this->common->getData('products',array('companyRef' =>  $this->companyData->companyRef),'productName,productRef');
        $data['productVat']      = $this->common->getData('vats', array('companyRef' => $this->companyData->companyRef),'vatRef,vatPercentage');
        $data['result']          = $salesDetail;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('sales/saleJs');
        $this->load->view('sales/addSale');
        $this->load->view('layout/footer');
    }

    public function updatesales($salesRef = NULL)
    {
      if(!empty($this->session->userdata('transactionRefUrl'))){
        $output['title']           = 'Update Invoice';
        $output['parentUrl']       = 'reports';
        $output['childUrl']        = 'general-ledger';
      }else
      {
        $output['title']            = 'Update Invoice';
        $output['parentUrl']        = 'Sales';
        $output['childUrl']         = 'Sales';
      }


        $output['productServices']  = $this->common->getData('products',array('companyRef' =>  $this->companyData->companyRef),'productName,productRef');
        $output['productVat']       = $this->common->getData('vats', array('companyRef' => $this->companyData->companyRef),'vatRef,vatPercentage');
        $salesData                  = $this->Sales->getDataByRef($salesRef);
        if(empty($salesData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('sales');
        }
        $output['result'] = $salesData;
        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('sales/saleJs');
        $this->load->view('sales/addSale');
        $this->load->view('layout/footer');
    }

    public function getDebitorList()
    {
        $detailLower = $_POST['detailLower'];
        $detailUpper = $_POST['detailUpper'];
        $dataRef     = "debtorRef";
        $tableName   = "acct_debtors";
        $userRef     = "debtorCompanyRef";
        $response    = getPayeeNamelist($detailLower,$detailUpper,$dataRef,$tableName,$userRef);
        //print_r($response); die;
        $checkexist  = 0;
        if (!empty($response))
        {
          echo '<a data-ref="addNewDebtor" href="javascript:void(0)" id="addNewCreditor" class="list-group-item list-group-item-action"> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Debtor</a>';
          foreach ($response as $value)
          {
              if(empty($value['firstName']) && empty($value['lastName']))
              {
                echo "<a data-ref='" . $value['debtorRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" . ucfirst($value['companyname']) ." <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
              }
              else
              {
                echo "<a data-ref='" . $value['debtorRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .  $value['title'] .' '. $value['firstName'] .' '. $value['lastName']. " <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
              }
          }

        }
        else
        {
            echo '<a data-ref="addNewDebtor" href="javascript:void(0)" id="addNewCreditor" class="list-group-item list-group-item-action"> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Debtor</a>';
        }

    }

}

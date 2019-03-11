<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Purchase');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function purchase()
    {
        $output['title']      = 'Purchase List';
        $output['parentUrl']  = 'Purchase';
        $output['childUrl']   = 'purchase';

        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Purchase->fetchPurchaseList($start, $this->perPage,$searchKey);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('purchase'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('purchase/purchaselistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('purchase/index');
            $this->load->view('layout/footer');
        }
    }

    public function addPurchase()
    {
        $data['title']      = 'Add Purchase';
        $data['parentUrl']  = 'Purchase';
        $data['childUrl']   = 'Add Purchase';

        $purchaseDetail          = $this->Purchase->getTableCloumns();
        $data['productServices'] = $this->common->getData('products',array('companyRef' =>  $this->companyData->companyRef),'productName,productRef');
        $data['productVat']      = $this->common->getData('vats', array('companyRef' =>  $this->companyData->companyRef),'vatRef,vatPercentage');
        $data['result']          = $purchaseDetail;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('purchase/purchaseJs');
        $this->load->view('purchase/addPurchase');
        $this->load->view('layout/footer');
    }


    public function updatepurchase($purchaseRef = NULL)
    {
        if(!empty($this->session->userdata('transactionRefUrl'))){
          $output['title']           = 'Update Purchase';
          $output['parentUrl']       = 'reports';
          $output['childUrl']        = 'general-ledger';
        }else
        {
          $output['title']           = 'Update Purchase';
          $output['parentUrl']       = 'Purchase';
          $output['childUrl']        = 'purchase';
        }


        $output['productServices'] = $this->common->getData('products',array('companyRef' =>  $this->companyData->companyRef),'productName,productRef');
        $output['productVat']      = $this->common->getData('vats', array('companyRef' =>  $this->companyData->companyRef),'vatRef,vatPercentage');
        $purchaseData              = $this->Purchase->getDataByRef($purchaseRef);
        if(empty($purchaseData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('purchase');
        }
        $output['result']     = $purchaseData;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('purchase/purchaseJs');
        $this->load->view('purchase/addPurchase');
        $this->load->view('layout/footer');
    }


    public function getcreditorList()
    {
        $detailLower = $_POST['detailLower'];
        $detailUpper = $_POST['detailUpper'];
        $dataRef     = "creditorRef";
        $tableName   = "acct_creditors";
        $userRef     = "creditorCompanyRef";
        $response    = getPayeeNamelist($detailLower,$detailUpper,$dataRef,$tableName,$userRef);
        //print_r($response); die;
        $checkexist  = 0;
        if (!empty($response))
        {
          echo '<a data-ref="addNewCreditor" href="javascript:void(0)" id="addNewCreditor" class="list-group-item list-group-item-action "> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Creditor</a>';
          foreach ($response as $value)
          {
              if(empty($value['firstName']) && empty($value['lastName'])){
                //echo "<a data-ref='" . $value['borrowerRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .ucfirst($value['companyname']). " <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
                echo "<a data-ref='" . $value['creditorRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" . ucfirst($value['companyname']) ." <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";
              }
              else
              {

                echo "<a data-ref='" . $value['creditorRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .  $value['title'] .' '. $value['firstName'] .' '. $value['lastName']. " <span class='badge badge-default badge-pill'> ".$value['companyname']."</span></a>";

              }
          }

        }
        else
        {
            echo '<a data-ref="addNewCreditor" href="javascript:void(0)" id="addNewCreditor" class="list-group-item list-group-item-action "> <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Creditor</a>';
        }
    }
    public function getproductslist()
    {
        $detailLower = $_POST['detailLower'];
        $detailUpper = $_POST['detailUpper'];
        $tableName   = "acct_products";
        $response    = getproductsByName($detailLower,$detailUpper,$tableName);
        $checkexist  = 0;
        if (!empty($response))
        {
            echo '<a class="list-group-item " id="addnewProduct" data-html="true" data-ref="addnewProduct" href="javascript:void(0)" > <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Product</a> ';
            foreach ($response as $value)
            {
                echo "<a data-ref='" . $value['productRef'] . "' href='javascript:void(0)' class='list-group-item list-group-item-action'>" .  $value['productName'] . "</a>";
            }
            $checkexist++;
        }
        else
        {
            echo '<a class="list-group-item " id="addnewProduct" data-html="true" data-ref="addnewProduct" href="javascript:void(0)" > <i class="fa fa-plus"></i> &nbsp;&nbsp; Add New Product</a> ';
        }
    }

    public function ajaxaddnewproduct()
    {
        $productName = $_POST['productName'];
        $productRef  = generateRef();
        $response    = $this->Purchase->addnewproduct($productName,$productRef);
        echo json_encode($response); die;
    }

}

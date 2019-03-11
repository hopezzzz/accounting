<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Inventory');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function inventory()
    {
        $output['title']      = 'Inventory Management';
        $output['parentUrl']  = 'inventory';
        $output['childUrl']   = 'inventory';

        $start      = 0;
        $searchKey  = '';
        $fromDate   = '';
        $toDate     = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $fromDate   = $this->input->post('fromDate');
            $toDate     = $this->input->post('toDate');
        /*    $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;*/
        }
        $data = $this->Inventory->fetchInventoryList($start, $this->perPage,$searchKey,$fromDate,$toDate);
        //$output['records']          = $data['result'];
        $output['records']          = $data;
//        echo "<pre>";print_r($output['records']);
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('inventory/inventorylistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('inventory/index');
            $this->load->view('layout/footer');
        }
    }



}

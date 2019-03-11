<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JournalController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Journal');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function index()
    {
        $output['title']      = 'Journal List';
        $output['parentUrl']  = 'Journal';
        $output['childUrl']   = 'Journal';

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
        $data = $this->Journal->fetchJournalList($start, $this->perPage,$searchKey,$fromDate,$toDate);
        $output['records']          = $data['result'];
        /*$output['paginationLinks']  = getPagination(site_url('journal'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        //echo "<pre>";print_r($output);die;*/
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('journal/journallistajax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('journal/index');
            $this->load->view('layout/footer');
        }
    }

    public function addJournal()
    {
        $output['title']      = 'Add Journal';
        $output['parentUrl']  = 'Journal';
        $output['childUrl']   = 'Add Journal';

        $output['productServices']      = getCategoriesType();
        $output['categories']           = $this->common->getData('trialBalanceCategories', '','title,categoryRef,type');

        $journalDetail            = $this->Journal->getTableCloumns();
        $parentCats               = getParentcategories($this->companyData->companyRef,'categoryID,categoryRef,ParentCategoryRef,title');
        $output['parentCats']     = $parentCats;
        $output['journalDetail']  = $journalDetail;
        $output['expenseCat']  = getParentcategories($this->companyData->companyRef,'categoryID,categoryRef,ParentCategoryRef,title','expense');
        //echo "<pre>";print_r($output);die;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('journal/journalJs');
        $this->load->view('journal/addJournal');
        $this->load->view('layout/footer');
    }

    public function saveJournal()
    {
        if ($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('date', '', 'required|trim');
            if (!$this->form_validation->run())
			{
				$errors = $this->form_validation->error_array();
				$response['success']  	 = false;
				$response['formErrors']  = true;
				$response['errors']      = $errors;
			}
			else
			{
                $isNewRecord        = 'no';
                $journalData        = array();
                $journalData['journalRef']     = generateRef();
                $journalData['journalNumber']  = generateJournalNumber();
                $journaldate        = date('Y-m-d',strtotime($this->input->post('date')));
                $type               = $this->input->post('type');
                $subcategoryRef     = $this->input->post('subcategoryRef');
                $description        = $this->input->post('description');
                $amount             = $this->input->post('amount');
                $journalItemRef     = $this->input->post('journalItemRef');
                $itemDataAdd        = array();
                foreach ($type as $key => $value)
                {
                    $itemDataAdd[$key]['journalRef']     = $journalData['journalRef'];
                    $itemDataAdd[$key]['type']           = $value;
                    $itemDataAdd[$key]['subcategoryRef'] = $subcategoryRef[$key];
                    $itemDataAdd[$key]['description']    = $description[$key];
                    $itemDataAdd[$key]['amount']         = $amount[$key];
                    $itemDataAdd[$key]['journalItemRef'] = generateRef();
                    $itemDataAdd[$key]['modifiedDate']   = date('Y-m-d');
                    $itemDataAdd[$key]['createdDate']    = date('Y-m-d');
                    $itemDataAdd[$key]['status'] 		 = 1;
                    $itemDataAdd[$key]['addedBy'] 	     = $this->loginSessionData['clientRef'];
                }
                $journalData['date']           = $journaldate;
                $journalData['modifiedDate']   = date('Y-m-d');
                $journalData['createdDate']    = date('Y-m-d');
                $journalData['status'] 		   = 1;
                $journalData['addedBy'] 	   = $this->loginSessionData['clientRef'];
                $journalData['companyRef'] 	   = $this->companyData->companyRef;
                $lastInsertedJournalID         = $this->common->insert('journals',$journalData);
                if( $lastInsertedJournalID > 0 )
                {
                    $this->common->insert_batch('journalItems', $itemDataAdd);
                    $response['success']           = true;
                    $response['resetform']         = true;
                    $response['url']               = site_url('journal');
                    $response['delayTime']         = '2000';
                    $response['success_message']   = 'Journal created successfully.';
                }
                else
                {
                    $response['success']         = false;
                    $response['error_message']   = 'Something went wrong. Please try again.';
                }
            }
            echo json_encode($response);die;
        }
    }
}

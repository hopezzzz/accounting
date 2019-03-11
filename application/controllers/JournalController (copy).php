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
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Journal->fetchJournalList($start, $this->perPage,$searchKey);
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('journal'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        //echo "<pre>";print_r($output);die;
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

        $journalDetail            = $this->Journal->getTableCloumns();
        $parentCats               = getParentcategories($this->companyData->companyRef,'categoryID,categoryRef,ParentCategoryRef,title');
        $output['journalDetail']  = $journalDetail;
        $output['parentCats']     = $parentCats;
        //echo "<pre>";print_r($output);die;

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('journal/journalJs');
        $this->load->view('journal/addJournal');
        $this->load->view('layout/footer');
    }


    public function updatejournal($journalRef = NULL)
    {
        $output['title']           = 'Update Journal';
        $output['parentUrl']       = 'Journal';
        $output['childUrl']        = 'Journal';

        $output['productServices'] = $this->common->getData('products',array('companyRef' =>  $this->companyData->companyRef),'productName,productRef');
        $output['productVat']      = $this->common->getData('vats', array('companyRef' =>  $this->companyData->companyRef),'vatRef,vatPercentage');
        $journalData              = $this->Journal->getDataByRef($journalRef);
        if(empty($journalData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('journal');
        }
        $output['result']     = $journalData;

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
                $journalRef         = $this->input->post('journalRef');
                if( $journalRef == '')
                {
                    $journalData['journalRef']  = generateRef();
                    $isNewRecord             = 'yes';
                }
                else
                    $journalData['journalRef']  = $journalRef;

                $journaldate        = date('Y-m-d',strtotime($this->input->post('date')));
                $type               = $this->input->post('type');
                $subcategoryRef     = $this->input->post('subcategoryRef');
                $description        = $this->input->post('description');
                $amount             = $this->input->post('amount');
                $journalItemRef     = $this->input->post('journalItemRef');
                $itemDataAdd        = array();
                $itemDataUpdate     = array();
                foreach ($type as $key => $value)
                {
                    $itemData     = array();
                    $itemData['journalRef']     = $journalData['journalRef'];
                    $itemData['type']           = $value;
                    $itemData['subcategoryRef'] = $subcategoryRef[$key];
                    $itemData['description']    = $description[$key];
                    $itemData['amount']         = $amount[$key];
                    if( $journalItemRef[$key] != '' )
                    {
                        $itemDataUpdate[$key]['journalItemRef'] = $journalItemRef[$key];
                        $itemDataUpdate[$key]['modifiedDate']   = date('Y-m-d');
                        $itemDataUpdate[$key]                   = array_merge($itemDataUpdate,$itemData);
                    }
                    else
                    {
                        $itemDataAdd[$key]['journalItemRef'] = generateRef();
                        $itemDataAdd[$key]['modifiedDate']   = date('Y-m-d');
                        $itemDataAdd[$key]['createdDate']    = date('Y-m-d');
                        $itemDataAdd[$key]['status'] 		 = 1;
                        $itemDataAdd[$key]['addedBy'] 	     = $this->loginSessionData['clientRef'];
                        $itemDataAdd[$key]                   = array_merge($itemDataAdd[$key],$itemData);
                    }
                }
                $journalData['date']           = $journaldate;
                $journalData['modifiedDate']   = date('Y-m-d');
                if( $isNewRecord == 'yes' )
                {
                    $journalData['createdDate']    = date('Y-m-d');
                    $journalData['status'] 		   = 1;
                    $journalData['addedBy'] 	   = $this->loginSessionData['clientRef'];
                    $journalData['companyRef'] 	   = $this->companyData->companyRef;
                    $lastInsertedJournalID         = $this->common->insert('journals',$journalData);
                    if( $lastInsertedJournalID > 0 )
                    {
                        $this->common->insert_batch('journalItems', $itemDataAdd);
                        $response['success']           = true;
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
                else
                {
                    $this->common->update(array('journalRef'=>$journalData['journalRef']),$journalData,'journals');
                    $this->common->insert_batch('journalItems', $itemDataAdd);
                    $this->db->update_batch('journalItems', $itemDataUpdate, 'journalItemRef');
                    $response['success']           = true;
                    $response['url']               = site_url('journal');
                    $response['delayTime']         = '2000';
                    $response['success_message']   = 'Journal updated successfully.';
                }
            }
            echo json_encode($response);die;
        }
    }
}

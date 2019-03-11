<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Setting');
        $this->perPage            = 10;
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function settings()
    {
        $output['title']      = 'Settings';
        $output['parentUrl']  = 'Setting';
        $output['childUrl']   = 'setting';

        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/settinglayout');
        $this->load->view('setting/index');
        $this->load->view('layout/footer');
    }

    public function index()
    {
        $output['title']      = 'Unit of Measurement';
        $output['parentUrl']  = 'Setting';
        $output['childUrl']   = 'unit of measurement';

        $start      = 0;
        $searchKey  = '';
        if ($this->input->is_ajax_request())
        {
            $searchKey  = $this->input->post('searchKey');
            $page       = $this->input->post('page');
            $start      = ( $page - 1 ) * $this->perPage;
        }
        $data = $this->Setting->fetchMesurementList($start, $this->perPage,$searchKey);
        //echo '<pre>';print_r($data); die;
        $output['records']          = $data['result'];
        $output['paginationLinks']  = getPagination(site_url('unit-of-measurement'), $this->perPage, $data['total_rows'], '', 1);
        $output['start']			= $start;
        if ($this->input->is_ajax_request())
        {
            $response['html'] = $this->load->view('setting/measurements/unitListAjax', $output, TRUE);
            echo json_encode($response);
            exit;
        }
        else
        {
            $this->load->view('layout/header', $output);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/settinglayout');
            $this->load->view('setting/measurements/index');
            $this->load->view('layout/footer');
        }
    }

    public function addMeasurement()
    {
        $output['title']      = 'Add Unit of Measurement';
        $output['parentUrl']  = 'Setting';
        $output['childUrl']   = 'add unit of measurement';
        $measurementdetails  = $this->Setting->getMeasurementTableCloumns();
        $output['result']     = $measurementdetails;
        $this->load->view('layout/header', $output);
        $this->load->view('layout/sidebar');
          $this->load->view('layout/settinglayout');
        $this->load->view('setting/measurements/add-measurement');
        $this->load->view('layout/footer');
    }


    public function addUnitOfMeasurement()
    {
      if ($this->input->is_ajax_request())
      {
          if(isset($_POST['req'])){
            $requestFromFrontEnd = true;
            unset($_POST['req']);
          }
          else{
            $requestFromFrontEnd = false;
          }
          $this->form_validation->set_rules('typeName', 'Unit of measurement', 'required|trim');
          $typeName =$this->input->post('typeName');
          if ($_POST['typeRef'] != '')
              $isValueExits = $this->common->checkexist('measurement', array('typeRef !=' =>$this->input->post('typeRef'),'typeName ='=>$typeName));
          else
              $isValueExits = $this->common->checkexist('measurement', array('typeName ='=>$typeName));


          if ($isValueExits)
          {
              $response['success']    = false;
              $response['formErrors'] = true;
              $response['errors']     = array('typeName' => 'Oops, this name already taken.');
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

                  if (isset($_POST['typeRef']) && trim($_POST['typeRef']) !="")
                  {
                      $_POST['modifiedDate']  = date('Y-m-d');
                      $this->common->update(array('typeRef'=>$_POST['typeRef']),  $_POST,'measurement');
                      $response['success_message'] = 'Record updated successfully!';
                  }
                  else
                  {

                      $_POST['createdDate']       = date('Y-m-d');
                      $_POST['modifiedDate']      = date('Y-m-d');
                      $_POST['status']            = 1;
                      $_POST['typeRef']           = generateRef();
                      $this->common->insert('measurement',$_POST);
                      $response['success_message'] = 'Record added successfully!';
                  }
                  $response['success']      =   true;
                  if ($_POST['typeRef'] == ''){
                      $response['resetform']    =   true;
                  }
                  if($requestFromFrontEnd == true)
                  {
                    $response['typeRef'] =   $_POST['typeRef'];
                    $response['typeName'] =   $_POST['typeName'];
                  }
                  else
                  {
                      $response['url']          =   site_url('unit-of-measurement');
                  }

                  $response['delayTime']    =   '2000';
          }
        }
          echo json_encode($response);
          die;
      }
    }


    public function updateMeasurement($typeRef = NULL)
    {
        $output['title']      = 'Update Unit of measurement';
        $output['parentUrl']  = 'Setting';
        $output['childUrl']   = 'unit of measurement';
        $measurementData      = $this->Setting->getMeasurementDataByRef($typeRef);
        if(empty($measurementData))
        {
            $this->session->set_flashdata('error_message','Something went wrong. Please try again.');
            redirect('unit-of-measurement');
        }
        $output['result']          = $measurementData;
        $this->load->view('layout/header', $output);

        $this->load->view('layout/sidebar');
        $this->load->view('layout/settinglayout');
        $this->load->view('setting/measurements/add-measurement');
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

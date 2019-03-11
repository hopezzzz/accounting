<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->Model('Client');
		$this->perPage = 10;
		$this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

	public function index()
	{
		$output['title'] 	 = 'Dashboard';
		$output['parentUrl'] = 'dashboard';
		$output['childUrl']  = 'dashboard';
		$this->load->view('layout/header',$output);
		$this->load->view('home');
		$this->load->view('layout/footer');
	}

	public function signUp()
	{
		$output['title'] 	 = 'Add Client';
		$output['parentUrl'] = 'Client';
		$output['childUrl']  = 'Add Client';
		$clientData = $this->Client->getTableCloumns();
		$clientData->billingAddress  = unserialize($clientData->billingAddress);
		$clientData->shippingAddress = unserialize($clientData->shippingAddress);
		$output['clientData'] = $clientData;

		$this->load->view('layout/header',$output);
		$this->load->view('client/clientForm');
		$this->load->view('layout/footer');
	}

	public function stepOne()
	{
		if ($this->input->is_ajax_request())
		{

			$_POST = array_map("trim", $_POST);
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
			$this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[10]|max_length[17]');
			$this->form_validation->set_rules('mobile', 'Mobile', 'trim|min_length[10]|max_length[17]');
			$this->form_validation->set_rules('fax', 'Fax', 'trim|min_length[6]|max_length[15]');
			$this->form_validation->set_rules('website', 'Website', 'trim|valid_url');
			if (!$this->form_validation->run())
			{
				$errors = $this->form_validation->error_array();
				$response['success']  	 = false;
				$response['formErrors']  = true;
				$response['errors']      = $errors;
			}
			else
			{
				$clientRef      = $this->input->post('clientRef');
				$isNewRecord    = 'yes';
				if( $clientRef != '' )
				{
					$isNewRecord    = 'no';
					$isEmailExist   = $this->common->checkexist('login',array('clientRef !='=>$clientRef,'clientEmail'=>$this->input->post('email')));
				}
				else
					$isEmailExist   = $this->common->checkexist('login',array('clientEmail'=>$this->input->post('email')));
				if($isEmailExist)
				{
					$response['success']  	 = false;
					$response['formErrors']  = true;
					$response['errors']      = array('email'=>'Oops, Email already taken.');
				}
				else
				{
					$billingAddress = array(
		                'billingStreet' 	=> $this->input->post('billingStreet'),
		                'billingCity' 		=> $this->input->post('billingCity'),
		                'billingState' 		=> $this->input->post('billingState'),
		                'billingPostalCode' => $this->input->post('billingPostalCode'),
		                'billingCountry' 	=> $this->input->post('billingCountry'),
		            );
					$sameAsBilling    = isset($_POST['sameAsBilling']) ? $_POST['sameAsBilling'] : '';
					if( $sameAsBilling != '' )
					{
						$_POST['sameAsBilling'] = 1;
						$shippingAddress = array(
			                'shippingStreet' 	 => $this->input->post('billingStreet'),
			                'shippingCity' 		 => $this->input->post('billingCity'),
			                'shippingState'   	 => $this->input->post('billingState'),
			                'shippingPostalCode' => $this->input->post('billingPostalCode'),
			                'shippingCountry' 	 => $this->input->post('billingCountry'),
			            );
					}
					else
					{
						$_POST['sameAsBilling'] = 0;
						$shippingAddress = array(
			                'shippingStreet' 	 => $this->input->post('shippingStreet'),
			                'shippingCity' 		 => $this->input->post('shippingCity'),
			                'shippingState'   	 => $this->input->post('shippingState'),
			                'shippingPostalCode' => $this->input->post('shippingPostalCode'),
			                'shippingCountry' 	 => $this->input->post('shippingCountry'),
			            );
					}
					unset($_POST['clientRef']);
					unset($_POST['billingStreet']);
					unset($_POST['billingCity']);
					unset($_POST['billingState']);
					unset($_POST['billingPostalCode']);
					unset($_POST['billingCountry']);
					unset($_POST['shippingStreet']);
					unset($_POST['shippingCity']);
					unset($_POST['shippingState']);
					unset($_POST['shippingCountry']);
					unset($_POST['shippingPostalCode']);

					$_POST['billingAddress']  = serialize($billingAddress);
					$_POST['shippingAddress'] = serialize($shippingAddress);
					if( $isNewRecord == 'yes' )
					{
						$clientRef				  = generateRef();
						$loginData  = array(
									'clientRef'			=> $clientRef,
									'clientEmail'		=> $this->input->post('email'),
									'clientPassword'	=> md5('123456'),
									'userType'			=> 3,
									'isEmailVerified'	=> 2,
									'createdDate'		=> date('Y-m-d'),
									'status'			=> 1,
									'addedBy'			=> $this->loginSessionData['clientRef']
								);
						$lastInsertedId = $this->common->insert('login',$loginData);
					}
					else
					{
						$loginData  = array(
									'clientEmail'		=> $this->input->post('email')
								);
						$lastInsertedId = $this->common->update(array('clientRef'=>$clientRef),$loginData,'login');
					}
					if( $lastInsertedId > 0 )
					{
						$_POST['modifiedDate']     = date('Y-m-d');
						if( $isNewRecord == 'yes' )
						{
							$_POST['clientProfileRef'] = $clientRef;
							$_POST['createdDate']      = date('Y-m-d');
							$_POST['status'] 		   = 1;
							$_POST['addedBy'] 		   = $this->loginSessionData['clientRef'];
							$lastInsertedClientID = $this->common->insert('clientProfile',$_POST);
						}
						else
						{
							$lastInsertedClientID = $this->common->update(array('clientProfileRef'=>$clientRef),$_POST,'clientProfile');
						}
						if( $lastInsertedClientID > 0 )
						{
							$response['success']  		  = true;
							$response['success_message']  = 'Basic info has been saved successfully.';
							$response['nextStep'] 		  = '2';
							$response['ajaxPageCallBack'] = true;
							$response['formType'] 		  = 'step-1';
							$response['clientRef'] 		  = $clientRef;
						}
						else
						{
							$response['success']  		= false;
							$response['error_message']  = 'Something went wrong. Please try agian.';
						}
					}
					else
					{
						$response['success']  		= false;
						$response['error_message']  = 'Something went wrong. Please try agian.';
					}
				}
			}
			echo json_encode($response);die;
		}
	}

	public function stepTwo()
	{
		if ($this->input->is_ajax_request())
		{
			$_POST = array_map("trim", $_POST);
			$clientRef = $_POST['clientProfileRef'];
			if( $clientRef == '' )
			{
				$response['success']  		= false;
				$response['error_message']  = 'Something went wrong. Please try agian.';
			}
			else
			{
				$this->form_validation->set_rules('companyName', 'Company Name', 'required|trim');
				$this->form_validation->set_rules('companyType', 'Company Type', 'required|trim');
				//$this->form_validation->set_rules('compRegNo', 'Registration No', 'required|trim');
				//$this->form_validation->set_rules('corporationTaxRef', 'Corporation Tax Reference', 'required|trim');
				//$this->form_validation->set_rules('dateOfIncorporation', 'Date of Incorporation', 'trim|required');
				$this->form_validation->set_rules('returnDate', 'Return Date', 'trim|required');
				$this->form_validation->set_rules('yearEndDate', 'Year End Date', 'trim|required');
				$vatApplied    = isset($_POST['vatApplied']) ? $_POST['vatApplied'] : '';
				if( $vatApplied != '' )
				{
					$this->form_validation->set_rules('vatNo', 'Vat No', 'trim|required');
					$this->form_validation->set_rules('vatPercentage', 'Vat Percentage', 'trim|required');
				}
				if (!$this->form_validation->run())
				{
					$errors = $this->form_validation->error_array();
					$response['success']  	 = false;
					$response['formErrors']  = true;
					$response['errors']      = $errors;
				}
				else
				{
					if( $vatApplied != '' )
					{
						$vatPercentage  	 = $this->input->post('vatPercentage');
						$_POST['vatApplied'] = 1;
					}
					else
					{
						$vatPercentage  	  = '';
						$_POST['vatApplied']  = 2;
						$_POST['vatNo'] 	  = '';
					}
					$companyRef       = $this->input->post('companyRef');
					$isNewCompany     = 'yes';
					if( $companyRef == '')
						$companyRef   = generateRef();
					else {
						$isNewCompany     = 'no';
					}
					if( isset($_POST['dateOfIncorporation']) )
						$_POST['dateOfIncorporation'] = date('Y-m-d',strtotime($_POST['dateOfIncorporation']));
					if( isset($_POST['returnDate']) )
						$_POST['returnDate'] = date('Y-m-d',strtotime($_POST['returnDate']));
					if( isset($_POST['yearEndDate']) )
						$_POST['yearEndDate'] = date('Y-m-d',strtotime($_POST['yearEndDate']));
					$_POST['companyRef'] 	   = $companyRef;
					$_POST['clientRef'] 	   = $clientRef;
					$vatRef 	 = isset( $_POST['vatRef'] ) ? $_POST['vatRef'] : '' ;
					unset($_POST['vatRef']);
					unset($_POST['vatPercentage']);
					unset($_POST['clientProfileRef']);
					$oldImage = '';
					if( isset($_FILES) && $_FILES['companyLogo']['name'] != '' )
					{
						$fileName = '';
						if (!is_dir('./assets/uploads/logos/'))
						{
							mkdir('./assets/uploads/logos/', 0777, TRUE);
						}
						$config['upload_path']   = './assets/uploads/logos/';
						$config['allowed_types'] = 'gif|jpg|png|tiff|tif|jpeg|bmp|BMPf';
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('companyLogo'))
						{
							$data_upload 	   		= $this->upload->data();
							$fileName         		= $data_upload['file_name'];
							$_POST['companyLogo']   = $fileName;
							$oldImage				= '';
							if( $isNewCompany != 'yes' )
								$oldImage				= $this->common->getSomeFields('companyLogo',array('companyRef'=>$companyRef),'companies')->companyLogo;
						}
						if($this->upload->display_errors())
						{
							$error = $this->upload->display_errors();
							$result["success"] 	 	 = false;
							$result["error_message"] = $error;
							echo json_encode($result);die;
						}

					}
					$_POST['modifiedDate']     = date('Y-m-d');
					if( $isNewCompany == 'yes' )
					{
						$_POST['createdDate']      = date('Y-m-d');
						$_POST['status'] 		   = 1;
						$_POST['addedBy'] 		   = $this->loginSessionData['clientRef'];
						$lastInsertedCompanyId     = $this->common->insert('companies',$_POST);
					}
					else
					{
						$lastInsertedCompanyId     = $this->common->update(array('companyRef'=>$companyRef),$_POST,'companies');
					}
					if( $lastInsertedCompanyId > 0 )
					{
						if($oldImage)
							@unlink('./assets/uploads/logos/'.$oldImage);
						$isNewRecord = 'yes';
						if($vatRef != '')
							$isNewRecord = 'no';
						if( $vatApplied != '' )
						{
							if( $isNewRecord == 'yes' )
							{
								$vatData = array(
									'vatRef' 		=> generateRef(),
									'companyRef' 	=> $companyRef,
					                'vatPercentage' => $vatPercentage,
					                'vatYear' 		=> date('Y'),
					                'status' 		=> 1,
					                'createdDate' 	=> date('Y-m-d'),
					                'modifiedDate' 	=> date('Y-m-d'),
					                'addedBy' 		=> $this->loginSessionData['clientRef'],
					            );
								$lastInsertedVatId = $this->common->insert('vats',$vatData);
							}
							else
							{
								$vatData = array(
					                'vatPercentage' => $vatPercentage,
					                'modifiedDate' 	=> date('Y-m-d')
					            );
								$lastInsertedVatId = $this->common->update(array('vatRef'=>$vatRef),$vatData,'vats');
							}
						}
						$response['success']  		  = true;
						$response['success_message']  = 'Company info has been saved successfully.';
						$response['ajaxPageCallBack'] = true;
						$response['formType'] 		  = 'step-2';
						$response['companyRef'] 	  = $companyRef;
						$response['vatRef'] 	  	  = $vatRef;
						$response['url'] 		  	  = site_url('clients');
						$response['delayTime'] 		  = 2000;
					}
					else
					{
						$response['success']  		= false;
						$response['error_message']  = 'Something went wrong. Please try agian.';
					}
				}
			}
			echo json_encode($response);die;
		}
	}

	public function clients()
	{
		$output['parentUrl'] = 'Client';
		$output['childUrl']  = 'List Client';
		$start 		= 0;
		$searchKey  = '';
		if ($this->input->is_ajax_request())
		{
			$searchKey  = $this->input->post('searchKey');
			$page  		= $this->input->post('page');
			$start 		= ( $page - 1 ) *  $this->perPage;
		}
		$output['title']   			= 'Client Listing';
		$data 			   			= $this->Client->fetchClients($start,$this->perPage,$searchKey);
		$output['records'] 			= $data['result'];
		$output['paginationLinks'] 	= getPagination(site_url('clients'),$this->perPage,$data['total_rows'],'',1);
		$output['start']			= $start;
		if ($this->input->is_ajax_request())
		{
			$response['html'] = $this->load->view('client/clientlistajax',$output,TRUE);
			echo json_encode($response);exit;
		}
		else
		{
			$this->load->view('layout/header',$output);
			$this->load->view('client/clientlist');
			$this->load->view('layout/footer');
		}
	}

	public function updateClient( $clientRef = null )
	{
		$clientData = $this->Client->fetchClientDetailByRef($clientRef);
		if(empty($clientData))
		{
			$this->session->set_flashdata('error_message','Something went wrong. Please try again.');
			redirect('clients');
		}
		$clientData->billingAddress  	 = unserialize($clientData->billingAddress);
		$clientData->shippingAddress 	 = unserialize($clientData->shippingAddress);

		$clientData->returnDate 		 = changeDateFormat( $clientData->returnDate, 'd-m-Y' );
		$clientData->yearEndDate 		 = changeDateFormat( $clientData->yearEndDate, 'd-m-Y' );
		$clientData->dateOfIncorporation = changeDateFormat( $clientData->dateOfIncorporation, 'd-m-Y' );

		$output['title'] 	  = 'Update Client';
		$output['parentUrl']  = 'Client';
		$output['childUrl']   = 'Update Client';
		$output['clientData'] = $clientData;

		$this->load->view('layout/header',$output);
		$this->load->view('client/clientForm');
		$this->load->view('layout/footer');
	}

	public function deleteRecord()
	{
		if ($this->input->is_ajax_request())
		{
			$recordRef  = $this->input->post('ref');
			$recordType = $this->input->post('type');
			if( $recordRef == '' || $recordType == '' )
			{
				$response['success']  		= false;
				$response['error_message']  = 'Something went wrong. Please try agian.';
			}
			else
			{
				$result   = $this->common->delete($recordRef,$recordType);
				if( $result )
				{
					$response['success']  		  = true;
					if($recordType == 'journal')
					{
							$response['url'] = site_url('journal');
							$response['delayTime'] = 1000;
					}
					$response['success_message']  = 'Record deleted successfully.';
				}
				else
				{
					$response['success']  		= false;
					$response['error_message']  = 'Something went wrong. Please try agian.';
				}
			}
			echo json_encode($response);die;
		}
	}

	public function updateStatus()
	{
		if ($this->input->is_ajax_request())
		{
			$ref    = $this->input->post('ref');
			$type   = $this->input->post('type');
			$status = $this->input->post('status');
			if( $ref == '' || $type == '' || $status == '' )
			{
				$response['success']  		= false;
				$response['error_message']  = 'Something went wrong. Please try agian.';
			}
			else
			{
				if( $status == 1 )
					$status = 0;
				else
					$status = 1;
				$result   = $this->common->updateStatus($ref,$type,$status);
				if( $result )
				{
					$response['success']  		  = true;
					$response['success_message']  = 'Record updated successfully.';
					$response['status']  		  = $status;
				}
				else
				{
					$response['success']  		= false;
					$response['error_message']  = 'Something went wrong. Please try agian.';
				}
			}
			echo json_encode($response);die;
		}
	}

	public function makeCompanySession( $clientRef = null )
	{
		if( $clientRef != null )
		{
			$loginSessionData = $this->session->userdata('clientData');
			$companyData      = $this->Client->fetchClientDetailByRef($clientRef);
			if(empty($companyData))
			{
				$this->session->set_flashdata('error_message','Something went wrong. Please try again.');
				redirect('clients');
			}
			else
			{
				$loginSessionData['companyData'] = $companyData;
				$loginSessionData = $this->session->set_userdata('clientData',$loginSessionData);
				redirect('dashboard');
			}
		}
	}

	public function destroyCompanySession()
	{
		$loginSessionData 				 = $this->session->userdata('clientData');
		$loginSessionData['companyData'] = array();
		$loginSessionData 				 = $this->session->set_userdata('clientData',$loginSessionData);
		redirect('dashboard');
	}


	public function makeReferenceSessions()
	{
		if ($this->input->is_ajax_request())
		{
			$reference    = $this->input->post('reference');
			$type   	  = $this->input->post('type');
			if( $reference == '' || $type == '' )
			{
				$response['success']  		= false;
				$response['error_message']  = 'Something went wrong. Please try agian.';
			}
			else
			{
				$this->session->set_userdata('reference',$reference);
				$this->session->set_userdata('referenceType',$type);
				$response['success']  = true;
				if( $type == 'debtor' )
				{
					$response['redirectUrl']  = site_url('sales');
					$this->session->set_userdata('referencePageUrl',site_url('sales'));
				}
				else if( $type == 'creditor' )
				{
					$response['redirectUrl']  = site_url('transactions');
					$this->session->set_userdata('referencePageUrl',site_url('transactions'));
				}
				else if( $type == 'borrower' )
				{
					$response['redirectUrl']  = site_url('loans-advances');
					$this->session->set_userdata('referencePageUrl',site_url('loans-advances'));
				}
				else
				{
					$response['success']  	    = true;
					$response['error_message']  = 'Something went wrong. Please try agian.';
				}
			}
			echo json_encode($response);die;
		}
	}

	public function destroyReferenceSessions()
	{
		if ($this->input->is_ajax_request())
		{
			$currentUrl    = $this->input->post('currentUrl');
			if( $currentUrl == '' )
			{
				$response['success']  		= false;
				$response['error_message']  = 'Something went wrong. Please try agian.';
			}
			else
			{
				$this->session->set_userdata('reference','');
				$this->session->set_userdata('referenceType','');
				$this->session->set_userdata('referencePageUrl','');
				$response['success']  = true;
			}
			echo json_encode($response);die;
		}
	}



}

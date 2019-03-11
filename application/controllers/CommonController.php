<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common');
        $this->load->helper('globalfunction_helper');
        $this->load->model('Purchase');
        $this->perPage = 10;
        $this->loginSessionData = $this->session->userdata('clientData');
        $this->companyData = $this->loginSessionData['companyData'];
    }

    public function addtransactionajax()
    {
        if ($this->input->is_ajax_request())
        {
            //print_r($_POST); die;
            $this->form_validation->set_rules('paymentMethod', 'Payment Method', 'required|trim');
            if ($this->form_validation->run())
            {
                $paymentDate            = $this->input->post('paymentDate');
                $transactionTypes       = $this->input->post('transactionType');
                $transactionReferance   = $this->input->post('transactionRef');
                $transactionItemRef     = $this->input->post('transactionItemRef');
                $paymentMethod          = $this->input->post('paymentMethod');

                if( $paymentMethod == 1 || $paymentMethod == 2 ||  $paymentMethod == 4 || $paymentMethod == 5)
                {
                    if( $paymentDate == '' || $paymentDate == '1970-01-01' || $paymentDate == '0000-00-00' )
                        $paymentDate = date('Y-m-d');
                }
                if ($transactionTypes == 'purchase')
                {
                    $payee              = 2;
                  //  $inventoryType      = 1;
                  //  $transactionType    = 1;
                    $inventoryType      = $this->input->post('type');
                    $transactionType    = $this->input->post('type');

                    $field              = 'creditorRef';
                    $table              = 'creditors';
                    $conditionParameter = 'creditorId';
                    $itemData           = $this->input->post('productRef');
                    $bankRef            = $this->input->post('bankRef');
                    $categoryRef        = NULL;
                    $userCompany        = 'creditorCompanyRef';
                }
                else if ($transactionTypes == 'expense')
                {
                    $payee              = 2;
                    $inventoryType      = 1;
                    $transactionType    = 3;
                    $field              = 'creditorRef';
                    $table              = 'creditors';
                    $conditionParameter = 'creditorId';
                    $itemData           = $this->input->post('serviceRef');
                    $bankRef            = $this->input->post('bankRef');
                    $categoryRef        = 'Not Null';
                    $ParentCategoryRef  = $this->input->post('ParentCategoryRef');
                    $userCompany        = 'creditorCompanyRef';
                }
                else
                {
                    $payee              =  1;
                    // $inventoryType      =  2;
                    // $transactionType    =  2;

                    $inventoryType      = $this->input->post('type');
                    $transactionType    = $this->input->post('type');

                    $field              = 'debtorRef';
                    $table              = 'debtors';
                    $conditionParameter = 'debtorId';
                    $itemData           = $this->input->post('productRef');
                    $bankRef            = $this->input->post('bankRef');
                    $categoryRef        = NULL;
                    $userCompany        = 'debtorCompanyRef';
                }
                if($paymentDate)
                {
                  $paymentStatus = 'paid';
                  $paymentDate   =  date('Y-m-d', strtotime( $paymentDate));
                }
                else
                {
                  $paymentStatus = 'pending';
                  $paymentDate   = '';
                }
                // add transaction
                $payeeRef = $this->input->post('payeeRef');
                if ($payeeRef == 'new')
                {
                    $this->form_validation->set_rules('addCreditorName', 'Name', 'required');
                    $this->form_validation->set_rules("$userCompany", 'Company Name', 'required');
                    if (!$this->form_validation->run())
                    {
                        $errors                 = $this->form_validation->error_array();
                        $response['success']    = false;
                        $response['formErrors'] = true;
                        $response['errors']     = $errors;
                        echo json_encode($response);
                        die;
                    }
                    if( trim($_POST["$userCompany"]) !=''){
                      $comapanyReff   = $_POST["$userCompany"];
                    }
                    else{
                      $comapanyReff   = generateRef();
                    }
                    $addCreditorName = $this->input->post('addCreditorName');
                    $payeeData      = array(
                        'firstName'     => $addCreditorName,
                        'companyRef'    => $this->companyData->companyRef,
                        'createdDate'   => date('Y-m-d'),
                        'modifiedDate'  => date('Y-m-d'),
                        'status'        => 1,
                        'addedBy'       => $this->loginSessionData['clientRef'],
                        $field          => generateRef(),
                        $userCompany    => $comapanyReff,
                    );

                    $companyname    = $this->input->post('companyname');
                    $companyname    = ($companyname) ? $companyname : '';
                    $isCompanyExist = false;
                    if ($companyname != '')
                    {
                        $isCompanyExist = $this->common->checkexist('company', array('companyRef' => $this->companyData->companyRef, 'companyname' => $companyname, 'type' => $payee));
                        if ($isCompanyExist)
                        {
                            $response['success']    = false;
                            $response['formErrors'] = true;
                            $response['errors']     = array('companyname' => 'Oops, company already exist.');
                            echo json_encode($response);
                            die;
                        }
                        else
                        {
                            $payeecompanydata['companyname']         = $companyname;
                            $payeecompanydata['companyRef']          = $this->companyData->companyRef;
                            $payeecompanydata['createdDate ']        = date('Y-m-d');
                            $payeecompanydata['modifiedDate']        = date('Y-m-d');
                            $payeecompanydata['status']              = 1;
                            $payeecompanydata['type']                = 1;
                            $payeecompanydata['addedBy']             = $this->loginSessionData['clientRef'];
                            $payeecompanydata['borrowerCompanyRef']  = $comapanyReff;
                            $this->common->insert('company', $payeecompanydata);
                        }
                    }
                    $creditorId = $this->common->insert($table, $payeeData);
                    if ($creditorId)
                    {
                        $creditorRef = $this->common->getSomeFields($field, array($conditionParameter => $creditorId), $table);
                        $payeeRef    = $creditorRef->$field;
                    }
                }
                if ($transactionReferance == '')
                {
                    $transactionRef = generateRef();
                }
                else
                {
                    $transactionRef = $transactionReferance;
                }
                $transactionData = array(
                    'invoiceNo'       => $this->input->post('invoiceNo'),
                    'transactionRef'  => $transactionRef,
                    'companyRef'      => $this->companyData->companyRef,
                    'transactionYear' => date('Y') . '/' . date('Y', strtotime('+1 year')),
                    'transactionType' => $transactionType,
                    'payee'           => $payee,
                    'payeeRef'        => $payeeRef,
                    'paymentMethod'   => $this->input->post('paymentMethod'),
                    'deliveryDate'    => date('Y-m-d', strtotime($this->input->post('deliveryDate'))),
                    'invoiceDate'     => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
                    'discountType'    => $this->input->post('discountType'),
                    'discountAmount'  => str_replace(',','',$this->input->post('discountAmount')),
                    'commisionType'   => $this->input->post('commisionType'),
                    'commisionAmount' => str_replace(',','',$this->input->post('commisionAmount')),
                    'subTotal'        => str_replace(',','',$this->input->post('subTotal')),
                    'vatTotal'        => str_replace(',','',$this->input->post('vatTotal')),
                    'grandTotal'      => str_replace(',','',$this->input->post('grandTotal')),
                    'purchaseType'    => $this->input->post('purchaseType'),
                    'paymentStatus'   => $paymentStatus,
                    'paymentDate'     => $paymentDate,
                    'bankRef'         => $bankRef
                );

                if ($transactionReferance)
                {
                    $transactionDataAdd = array(
                        'modifiedDate' => date('Y-m-d')
                    );
                    $transactionDataFinal = array_merge($transactionData, $transactionDataAdd);
                    $this->common->update(array('transactionRef' => $transactionReferance), $transactionDataFinal, 'transactions');
                }
                else
                {
                    $transactionDataAdd = array(
                        'createdDate'   => date('Y-m-d'),
                        'modifiedDate'  => date('Y-m-d'),
                        'status'        => 1,
                        'addedBy'       => $this->loginSessionData['clientRef']
                    );
                    $transactionDataFinal = array_merge($transactionData, $transactionDataAdd);
                    //print_r($transactionDataFinal); die;
                    $this->db->insert('transactions', $transactionDataFinal);
                }
                // add transaction item
                //$itemData = $this->input->post('product');

                if (!empty($itemData))
                {
                    $quantity       = str_replace(',','',$this->input->post('quantity'));
                    $qtyTypeRef     = $this->input->post('qtyType');
                    $description    = $this->input->post('description');
                    $rate           = str_replace(',','',$this->input->post('rate'));
                    $vatAmount      = str_replace(',','',$this->input->post('vatAmount'));
                    $vatPercentage  = str_replace(',','',$this->input->post('vatPercentage'));
                    $amount         = str_replace(',','',$this->input->post('amount'));
                    $discountAmountPerItem         = str_replace(',','',$this->input->post('discountAmountPerItem'));
                    $commisionAmountPerItem        = str_replace(',','',$this->input->post('commisionAmountPerItem'));
                    $transactionItemsRefers        = $this->input->post('transactionItemsRefers');

                    if(!empty($transactionItemsRefers))
                    {
                      $itemRefrense = explode(',',$transactionItemsRefers);
                      foreach($itemRefrense as $key=>$val)
                      {
                        if($val)
                        {
                          $this->Purchase->deleteItems($val);
                        }
                      }
                    }
                    $transactionItemArrUpdate   = array();
                    $transactionItemArrAdd      = array();
                    $inventoryRefItemArrAdd     = array();
                    $inventoryRefItemArrUpdate  = array();
                    for ($i = 0; $i < count($itemData); $i++)
                    {
                        if (empty($transactionItemRef[$i]))
                        {

                            $itemRef = generateRef();
                            if($categoryRef == NULL )
                            { // Array For Sale and Purchase
                              $transactionItemArrAdd[$i] = array(
                                  'itemRef'        => $itemRef,
                                  'transactionRef' => $transactionRef,
                                  'productRef'     => $itemData[$i],
                                  'categoryRef'    => $categoryRef,
                                  'quantity'       => $quantity[$i],
                                  'qtyTypeRef'      => $qtyTypeRef[$i],
                                  'description'    => $description[$i],
                                  'rate'           => $rate[$i],
                                  'amount'         => $amount[$i],
                                  'vatAmount'      => $vatAmount[$i],
                                  'vatPercentage'  => $vatPercentage[$i],
                                  'discountAmountPerItem'  => $discountAmountPerItem[$i],
                                  'commisionAmountPerItem' => $commisionAmountPerItem[$i],
                                  'status'         => 1,
                                  'createdDate'    => date('Y-m-d'),
                                  'modifiedDate'   => date('Y-m-d'),
                                  'addedBy'        => $this->loginSessionData['clientRef']
                              );

                                $inventoryRefItemArrAdd[$i] = array(
                                    'companyRef '    => $this->companyData->companyRef,
                                    'inventoryRef'   => generateRef(),
                                    'itemRef'        => $itemRef,
                                    'transactionRef' => $transactionRef,
                                    'inventoryType'  => $inventoryType,
                                    'productRef'     => $itemData[$i],
                                    'quantity'       => $quantity[$i],
                                    'qtyTypeRef'      => $qtyTypeRef[$i],
                                    'price'          => $rate[$i],
                                    'amount'         => $amount[$i],
                                    'date'           => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
                                    'status'         => 1,
                                    'createdDate'    => date('Y-m-d'),
                                    'modifiedDate'   => date('Y-m-d'),
                                    'addedBy'       => $this->loginSessionData['clientRef']
                                );
                            }
                            else
                            { // Array For Expense
                              //$categoryRef = getParentCategoryRef($itemData);
                              //print_r($_POST['ParentCategoryRef']); die;
                              $transactionItemArrAdd[$i] = array(
                                  'itemRef'        => $itemRef,
                                  'transactionRef' => $transactionRef,
                                  'productRef'     => NULL,
                                  'categoryRef'    => $ParentCategoryRef[$i],
                                  'subcategoryRef' => $itemData[$i],
                                  'quantity'       => $quantity[$i],
                                  'qtyTypeRef'      => $qtyTypeRef[$i],
                                  'description'    => $description[$i],
                                  'rate'           => $rate[$i],
                                  'amount'         => $quantity[$i] * $rate[$i],
                                  'vatAmount'      => $vatAmount[$i],
                                  'vatPercentage'  => $vatPercentage[$i],
                                  'discountAmountPerItem'  => $discountAmountPerItem[$i],
                                  'commisionAmountPerItem' => $commisionAmountPerItem[$i],
                                  'status'         => 1,
                                  'createdDate'    => date('Y-m-d'),
                                  'modifiedDate'   => date('Y-m-d'),
                                  'addedBy'        => $this->loginSessionData['clientRef']
                              );
                            }

                        }
                        else
                        {

                            if($categoryRef == NULL )
                              { // For Update Sale Purchase
                                $transactionItemArrUpdate[$i] = array(
                                    'transactionRef' => $transactionRef,
                                    'itemRef'        => $transactionItemRef[$i],
                                    'productRef'     => $itemData[$i],
                                    'quantity'       => $quantity[$i],
                                    'qtyTypeRef'      => $qtyTypeRef[$i],
                                    'description'    => $description[$i],
                                    'rate'           => $rate[$i],
                                    'amount'         => $amount[$i],
                                    'vatAmount'      => $vatAmount[$i],
                                    'vatPercentage'  => $vatPercentage[$i],
                                    'discountAmountPerItem'  => $discountAmountPerItem[$i],
                                    'commisionAmountPerItem' => $commisionAmountPerItem[$i],
                                    'modifiedDate'   => date('Y-m-d'),
                                );
                                $inventoryRefItemArrUpdate[$i] = array(
                                      'companyRef '       => $this->companyData->companyRef,
                                      'itemRef'           => $transactionItemRef[$i],
                                      'transactionRef'    => $transactionRef,
                                      'inventoryType'     => $inventoryType,
                                      'productRef'        => $itemData[$i],
                                      'quantity'          => $quantity[$i],
                                      'qtyTypeRef'     => $qtyTypeRef[$i],
                                      'price'             => $rate[$i],
                                      'amount'            => $amount[$i],
                                      'status'            => 1,
                                      'createdDate'       => date('Y-m-d'),
                                );
                             }
                             else
                             { // For Update Expense
                               //print_r($_POST); die;
                               $categoryRef = getParentCategoryRef($itemData);

                               $transactionItemArrUpdate[$i] = array(
                                   'transactionRef' => $transactionRef,
                                   'itemRef'        => $transactionItemRef[$i],
                                   'categoryRef'    => $ParentCategoryRef[$i],
                                   'subcategoryRef' => $itemData[$i],
                                   'quantity'       => $quantity[$i],
                                   'qtyTypeRef'     => $qtyTypeRef[$i],
                                   'description'    => $description[$i],
                                   'rate'           => $rate[$i],
                                   'amount'         => $quantity[$i] * $rate[$i],
                                   'vatAmount'      => $vatAmount[$i],
                                   'vatPercentage'  => $vatPercentage[$i],
                                   'discountAmountPerItem'  => $discountAmountPerItem[$i],
                                   'commisionAmountPerItem' => $commisionAmountPerItem[$i],
                                   'modifiedDate'   => date('Y-m-d'),
                               );
                             }
                      }
                    }
                    if (!empty($transactionItemArrAdd))
                    {
                        $this->db->insert_batch('transactionItems', $transactionItemArrAdd);
                        if($categoryRef == NULL ){
                        $this->db->insert_batch('inventory', $inventoryRefItemArrAdd);

                      }
                    }
                    if (!empty($transactionItemArrUpdate))
                    {
                        $this->db->update_batch('transactionItems', $transactionItemArrUpdate, 'itemRef');

                        if($categoryRef == NULL ){
                        $this->db->update_batch('inventory', $inventoryRefItemArrUpdate, 'itemRef');
                        }
                    }
                    // add inventory
                    $inventoryRefItemArr = array();
                    if ($transactionReferance)
                    {
                        $response['success']         = true;
                        $referencePageUrl       = $this->session->userdata('referencePageUrl');
                        $reference              = $this->session->userdata('reference');


                        $referenceType          = $this->session->userdata('referenceType');

                        $transactionRefUrl      = $this->session->userdata('transactionRefUrl');
                        /** Useting session value **/
                        if(!empty($this->session->userdata('transactionRefUrl'))){
                            $this->session->unset_userdata('transactionRefUrl');
                        };

                        if( $reference != '' && $referenceType == 'creditor' && $referencePageUrl != '')
                            $response['url']        = $referencePageUrl;
                        else
                            $response['url']             = site_url($transactionTypes);

                        if( $transactionRefUrl != ''){
                            $response['url']        = site_url($transactionRefUrl);
                          }


                        $response['delayTime']       = '2000';
                        $response['success_message'] = ucfirst($transactionTypes) . ' updated successfully!';
                    }
                    else
                    {
                        $response['resetform']       = true;
                        $response['submitDisabled']  = true;
                        $response['success']         = true;
                        $response['url']             = site_url($transactionTypes);
                        $response['delayTime']       = '2000';
                        $response['success_message'] = ucfirst($transactionTypes) . ' added successfully!';
                    }
                }
                else
                {
                    $errors                 = $this->form_validation->error_array();
                    $response['success']    = false;
                    $response['formErrors'] = true;
                    $response['errors']     = $errors;
                }
                echo json_encode($response);
                die;
            }
        }
    }


    public function getPendingAmount()
    {
        if ($this->input->is_ajax_request())
        {
            $transactionRef   = $this->input->post('transactionRef');
            $type             = $this->input->post('type');
            if( $transactionRef == '' || $type == '' )
            {
                $response['success']         = false;
                $response['error_message']   = 'Something went wrong. Please try again.';
            }
            else
            {
                $result          = $this->common->getTransactionTotalAmount( $transactionRef,$type );
                $paymentReceived = $this->common->getTransactionTotalPaidAmount( $transactionRef,$type );
                if( $result['success'] )
                {
                    $response['success']           = true;
                    $response['totalAmount']       = number_format($result['totalAmount'],2);
                    $response['paymentReceived']   = number_format($paymentReceived,2);
                    $response['paymentPending']    = $result['totalAmount'] - $paymentReceived;
                    $response['paymentPending']    = number_format($response['paymentPending'],2);
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


    public function markAsPaid()
    {
        if ($this->input->is_ajax_request())
        {
            $paymentDate      = $this->input->post('paymentDate');
            $transactionRef   = $this->input->post('transactionRef');
            $type             = $this->input->post('type');
            $paymentMethod    = $this->input->post('paymentMethod');
            $receiveAmount    = $this->input->post('receiveAmount');
            $paymentBankRef   = $this->input->post('paymentBankRef');
            if( $paymentMethod == 1 )
                $paymentBankRef = '';
            if( ($transactionRef == '' && $paymentDate == '') || $paymentDate == '' )
            {
                $response['success']         = false;
                $response['formErrors']      = true;
                $response['errorInput']      = '#paymentDateSelect';
            }
            else if( $receiveAmount <= 0  )
            {
                $response['success']         = false;
                $response['formErrors']      = true;
                $response['errorInput']      = '.receivePaymentAmount';
            }
            else if( $paymentMethod == 2 && $paymentBankRef == '' )
            {
                $response['success']         = false;
                $response['formErrors']      = true;
                $response['errorInput']      = '.receivePaymentBankRef';
            }
            else if($transactionRef == '' )
            {
                $response['success']         = false;
                $response['error_message']   = 'Something went wrong. Please try again.';
            }
            else
            {
                if($type == 'transaction')
                    $paymentType = 1;
                else if($type == 'loans')
                    $paymentType = 2;
                else if($type == 'borrowing')
                    $paymentType = 3;

                $paymentData   = array(
                    'paymentRef'     => generateRef(),
                    'companyRef'     => $this->companyData->companyRef,
                    'type'           => $paymentType,
                    'transactionRef' => $transactionRef,
                    'amount'         => $receiveAmount,
                    'bankRef'        => $paymentBankRef,
                    'paymentMethod'  => $paymentMethod,
                    'createdDate'    => date('Y-m-d'),
                    'addedBy'        => $this->loginSessionData['clientRef'],
                );
                $result = $this->common->insert('payments',$paymentData);
                if( $result )
                {
                    $response['paid'] = false;
                    $transactionData  = $this->common->getTransactionTotalAmount( $transactionRef,$type );
                    if( $transactionData['success'] )
                    {
                        $paymentReceived = $this->common->getTransactionTotalPaidAmount( $transactionRef,$type );
                        if( $transactionData['totalAmount'] == $paymentReceived )
                        {
                            $data   = array('paymentStatus'=>'paid','paymentDate'=>date('Y-m-d',strtotime($paymentDate)));
                            if($type == 'loans' || $type == 'borrowing')
                            {
                                $result = $this->common->update(array('loanRef'=>$transactionRef),$data,'loans');
                            }
                            else
                            {
                                $result = $this->common->update(array('transactionRef'=>$transactionRef),$data,'transactions');
                            }
                            $response['paid'] = true;
                        }
                    }
                    $response['success']           = true;
                    $response['success_message']   = 'Payment received successfully.';
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


    public function purchaseNExpenses()
    {
        $output['title'] 	 = 'Transactions';
		$output['parentUrl'] = 'dashboard';
		$output['childUrl']  = 'dashboard';
        $this->load->view('layout/header',$output);
		$this->load->view('purchaseNExpenses');
		$this->load->view('layout/footer');
    }

    public function loansNadvances()
    {
        $output['title'] 	 = 'Loans Advances';
		$output['parentUrl'] = 'dashboard';
		$output['childUrl']  = 'dashboard';
        $this->load->view('layout/header',$output);
		$this->load->view('loansNadvances');
		$this->load->view('layout/footer');
    }

}

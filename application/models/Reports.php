<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function allProductServices()
    {
      $this->db->select('*');
      $this->db->from('acct_products');
      $this->db->group_by('productName');
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    public function fetchPurchaseList($limit, $start, $searchKey = null )
    {
        $reference      = $this->session->userdata('reference');
        $referenceType  = $this->session->userdata('referenceType');
        if( $referenceType != 'creditor')
            $reference     = '';
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('acct_transactions');
        $this->db->where('transactionType',1);
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        if( $reference != '' )
            $this->db->where('transactions.payeeRef',$reference);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
			    $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or transactions.vatTotal LIKE '%$searchKey%' or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%' or transactions.paymentMethod LIKE '%$paymentMethod%')";
            else
			    $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.vatTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /* * **************** fetching records ******************** */
        $this->db->select("transactions.*,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName");
        $this->db->from('transactions');
        $this->db->where('transactionType',1);
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        if( $reference != '' )
            $this->db->where('transactions.payeeRef',$reference);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or transactions.vatTotal LIKE '%$searchKey%' or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%' or transactions.paymentMethod LIKE '%$paymentMethod%')";
            else
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.vatTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%')";
            $this->db->where($where);
        }
        $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
        $this->db->order_by('transactionID', 'Desc');
        $this->db->limit($start,$limit);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->result();
        }
        return array(
            'total_rows' => $total_rows,
            'result' => $result
        );
    }

    public function getTableCloumns()
    {
          $this->db->select("acct_transactions.*,acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName");
          $this->db->from('acct_transactions');
          $this->db->where('transactionType',1);
          $this->db->join('acct_creditors','acct_creditors.creditorRef = acct_transactions.payeeRef ','left');
          $query        = $this->db->get();
          $fields       = $query->list_fields();

          $this->db->select("acct_transactionItems.*,acct_products.*");
          $this->db->from('acct_transactionItems');
          $this->db->join('acct_products','acct_products.productRef = acct_transactionItems.productRef ','left');
          $query1        = $this->db->get();
          $items       = $query1->list_fields();
          $purchaseDetail = new stdClass();
          foreach ($fields as $field)
          {
             $purchaseDetail->$field = '';
          }
          $purchaseDetail->items[0] = new stdClass();

          foreach ($items as $item)
          {
           $purchaseDetail->items[0]->$item = '';
          }
          return $purchaseDetail;
    }

    public function getDataByRef($param){

        /*         * **************** fetching data by ref ******************** */
        $this->db->select("acct_transactions.*,title,firstName,lastName");
        $this->db->from('acct_transactions');
        $this->db->join('acct_creditors','acct_creditors.creditorRef = acct_transactions.payeeRef ','left');
        $this->db->where('transactionType',1);
        $this->db->where('payee',2);
        $this->db->where('acct_transactions.transactionRef',$param);
        $this->db->order_by('transactionID', 'ASC ');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->row();
            $this->db->select("acct_transactionItems.*,acct_products.*");
            $this->db->from('acct_transactionItems');
            $this->db->join('acct_products','acct_products.productRef = acct_transactionItems.productRef','left');
            $this->db->where('acct_transactionItems.transactionRef',$param);
            $query1 = $this->db->get();
            $result1 = $query1->result();
            $result->items = $result1;
        }
        return  $result;

    }

    public function addnewproduct($productName,$productRef)
    {
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
        $productName              = trim($productName);
        $this->db->select('productName,productRef');
        $this->db->from('acct_products');
        $this->db->where('productName',$productName);
        $this->db->where('companyRef',$this->companyData->companyRef);
        $query   = $this->db->get();
        //echo $this->db->last_query(); die;
        $data    = $query->result();

        if( $query->num_rows() == 0 )
        {
            $this->db->set('productRef',$productRef);
            $this->db->set('productName',$productName);
            $this->db->set('companyRef',$this->companyData->companyRef);
            $this->db->set('status',1);
            $this->db->set('createdDate',date('Y-m-d'));
            $this->db->set('modifiedDate',date('Y-m-d'));
            $this->db->set('addedBy',$this->loginSessionData['clientRef']);
            $this->db->insert('acct_products');
            if($this->db->affected_rows() > 0)
            {
                $data                    = new stdClass();
                $data->productName       = $productName;
                $data->productRef        = $productRef;
                $response['success']     = true;
                $response['productData'] = $data;
            }
            else
            {
                $response['success']  = false;
                $response['errorMsg'] = "Something went wrong. Please try again";
            }
        }
        else
        {
            $response['success']  = false;
            $response['errorMsg'] = "Product Name already exits.";
        }
        return $response;
    }

    public function deleteItems($recordRef)
    {
          $this->db->where('itemRef',$recordRef);
          $this->db->delete('transactionItems');

          $this->db->where('itemRef',$recordRef);
          $this->db->delete('inventory');

    }

    public function fetchTransactionsLists($searchKey = null,$fromDate,$toDate )
    {
        $result = array();
        if( $fromDate != '' && $fromDate != '0000-00-00' && $fromDate != '1970-01-01')
            $fromDate = date('Y-m-d',strtotime($fromDate));
        else
            $fromDate = '';

        if( $toDate != '' && $toDate != '0000-00-00' && $toDate != '1970-01-01')
            $toDate = date('Y-m-d',strtotime($toDate));
        else
            $toDate = '';

        if( $searchKey == 'R9QEIC6xPgYGuNjQ') // getting vat amount for vat category
        {
            $this->db->select("acct_transactionItems.vatAmount as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName1,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'VAT' ELSE 'VAT' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' THEN 'cr' ELSE 'cr' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where_in('transactions.transactionType',array('2','4'));
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType = 4','left');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType = 2','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $salesVat           = array();
            if($query1->num_rows() > 0)
            {
                $salesVat = $query1->result();
            }

            $this->db->select("acct_transactionItems.vatAmount as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName1,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName,( CASE WHEN acct_transactions.transactionType = '1' THEN 'VAT' ELSE 'VAT' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '1' THEN 'db' ELSE 'db' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where_in('transactions.transactionType',array('1','3','5'));
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType IN (1,3)','left');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType = 5','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $purchasesVat       = array();
            if($query1->num_rows() > 0)
            {
                $purchasesVat = $query1->result();
            }
            $result = array_merge($salesVat,$purchasesVat);
        }
        else if( $searchKey == 'q5rYG6iDglQ0kaMp' ||  $searchKey == 'ONdz9pjalp75rw8G' ) // getting amount for discount paid & commision paid
        {
            if( $searchKey == 'q5rYG6iDglQ0kaMp')
                $this->db->select("transactionItems.discountAmountPerItem as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Discount Paid' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' THEN 'db' ELSE '' END) as type");
            if( $searchKey == 'ONdz9pjalp75rw8G')
                $this->db->select("transactionItems.commisionAmountPerItem  as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Commision Paid' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' THEN 'db' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',2);
            if( $searchKey == 'q5rYG6iDglQ0kaMp')
                $this->db->where('transactionItems.discountAmountPerItem > ',0);
            if( $searchKey == 'ONdz9pjalp75rw8G')
                $this->db->where('transactionItems.commisionAmountPerItem > ',0);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }

            /************* getting expense discount/commision paid *********/
            if( $searchKey == 'q5rYG6iDglQ0kaMp')
                $this->db->select("transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '3' THEN 'Discount Paid' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '3' THEN 'db' ELSE 'db' END) as type");
            if( $searchKey == 'ONdz9pjalp75rw8G')
                $this->db->select("transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '3' THEN 'Commision Paid' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '3' THEN 'db' ELSE 'db' END) as type");

            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',3);
            $this->db->where('transactionItems.subcategoryRef',$searchKey);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $query1    	                = $this->db->get();
            $expenseDiscountCommision   = array();
            if($query1->num_rows() > 0)
            {
                $expenseDiscountCommision = $query1->result();
            }
            $result = array_merge($result,$expenseDiscountCommision);
        }
        else if( $searchKey == 'si5n0VopdHLVoB6n' ||  $searchKey == 'FHsacw7pBcHps2Z9' ) // getting amount for commision & discount receive
        {
            if( $searchKey == 'FHsacw7pBcHps2Z9')
                $this->db->select("transactionItems.discountAmountPerItem as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '1' THEN 'Discount Received' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '1' THEN 'cr' ELSE '' END) as type");
            if( $searchKey == 'si5n0VopdHLVoB6n')
                $this->db->select("transactionItems.commisionAmountPerItem  as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '1' THEN 'Commision Received' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '1' THEN 'cr' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',1);
            if( $searchKey == 'FHsacw7pBcHps2Z9')
                $this->db->where('transactionItems.discountAmountPerItem > ',0);
            if( $searchKey == 'si5n0VopdHLVoB6n')
                $this->db->where('transactionItems.commisionAmountPerItem > ',0);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'U92h8H3yP2EAxY8r') // getting amount for sale of goods and services
        {
            $this->db->select("transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Sale' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' THEN 'cr' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',2);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'FUXcYlCpKlAp2yGq') // sales return
        {
            $this->db->select("transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '5' THEN 'Sale Return' ELSE 'Sale Return' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '5' THEN 'db' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',5);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'aypZV9xC68fPRlYa') // getting amount for purchase
        {
            $this->db->select("transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '1' THEN 'Purchase' ELSE '' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '1' THEN 'db' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',1);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'MsVfObrT4PI1QmGV') // getting amount for purchase return
        {
            $this->db->select("transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '4' THEN 'Purchase Return' ELSE 'Purchase Return' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '4' THEN 'cr' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',4);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'k2qhu8UX9r2yfwUE') // getting amount for cash in hand
        {
            /************* getting cash amount from sale,purchase and expense where payment method is cash *******/
            $this->db->select("sum(acct_transactionItems.amount) as amount,sum(acct_transactionItems.vatAmount) as vatAmount,sum(acct_transactionItems.discountAmountPerItem) as discountAmountPerItem,sum(acct_transactionItems.commisionAmountPerItem) as commisionAmountPerItem,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName1,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Cash in hand' ELSE 'Cash in hand' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' || acct_transactions.transactionType = '4' THEN 'cr' ELSE 'db' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.paymentMethod',1);
            $this->db->where('transactions.status',1);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType IN (2,5)','left');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType IN (1,3,4)','left');
            $this->db->group_by('transactions.transactionRef');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $salePurchaseExpenseCash   = array();
            if($query1->num_rows() > 0)
            {
                $salePurchaseExpenseCash = $query1->result();
                $result   = array_merge($result,$salePurchaseExpenseCash);
            }

            $this->db->select("acct_payments.amount as amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,payments.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Cash in hand' ELSE 'Cash in hand' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' THEN 'cr' ELSE 'cr' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.paymentMethod',3);
            $this->db->where_in('transactions.transactionType',array(2,4));
            $this->db->where('payments.paymentMethod',1);
            $this->db->where('transactions.status',1);
            $this->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType = 4','left');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType = 2','left');
            $query    	= $this->db->get();
            $salesReceivedPayment = array();
            if($query->num_rows() > 0)
            {
                $salesReceivedPayment = $query->result();
                $result = array_merge($result,$salesReceivedPayment);
            }

            $this->db->select("acct_payments.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,payments.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName1,( CASE WHEN acct_transactions.transactionType = '1' THEN 'Cash in hand' ELSE 'Cash in hand' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '5' THEN 'db' ELSE 'db' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.paymentMethod',3);
            $this->db->where_in('transactions.transactionType',array('1','3','5'));
            $this->db->where('payments.paymentMethod',1);
            $this->db->where('transactions.status',1);
            $this->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType IN (1,3)','left');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType = 5','left');
            $query    	= $this->db->get();
            $purchaseReceivedPayment = array();
            if($query->num_rows() > 0)
            {
                $purchaseReceivedPayment = $query->result();
                $result         = array_merge($result,$purchaseReceivedPayment);
            }

            /*********** getting amount from short/long term borrowings payments received **************/
            $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,( CASE WHEN acct_loans.type = '2' THEN 'cr' ELSE '' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Borrowings' ELSE 'Short Term Borrowings' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
            $this->db->from('loans');
            if($fromDate != '' && $toDate != '')
                $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("date",$fromDate);
            else if( $toDate != '' )
                $this->db->where("date",$toDate);
            else
                $this->db->where("YEAR(acct_loans.date)",date('Y'));
            $this->db->where('loans.companyRef',$this->companyData->companyRef);
            $this->db->where('payments.paymentMethod',1);
            $this->db->where('loans.status',1);
            $this->db->where('loans.type',2);
            $this->db->join('payments','payments.transactionRef = loans.loanRef','inner');
            $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
            $query    	= $this->db->get();
            $borrowingCashReceived = array();
            if($query->num_rows() > 0)
            {
                $borrowingCashReceived = $query->result();
                $result         = array_merge($result,$borrowingCashReceived);
            }

            /*********** getting amount from short/long term loans payments received **************/
            $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE '' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Loans And Advances' ELSE 'Short Term Loan And Advances' END) as subcategory,( CASE WHEN acct_loans.type = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
            $this->db->from('loans');
            if($fromDate != '' && $toDate != '')
                $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("date",$fromDate);
            else if( $toDate != '' )
                $this->db->where("date",$toDate);
            else
                $this->db->where("YEAR(acct_loans.date)",date('Y'));
            $this->db->where('loans.companyRef',$this->companyData->companyRef);
            $this->db->where('payments.paymentMethod',1);
            $this->db->where('loans.status',1);
            $this->db->where('loans.type',1);
            $this->db->join('payments','payments.transactionRef = loans.loanRef','inner');
            $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
            $query    	= $this->db->get();
            $loansCashReceived = array();
            if($query->num_rows() > 0)
            {
                $loansCashReceived = $query->result();
                $result         = array_merge($result,$loansCashReceived);
            }

            /*********** getting amount from shareCapital where payment method is cash  **************/
            $this->db->select("acct_shareCapital.shareCapitalRef,acct_shareCapital.paymentMethod,acct_shareCapitalitems.amount,shareCapital.date as invoiceDate,CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName) AS payeeName,( CASE WHEN acct_shareHolder.ID != '' THEN 'db' ELSE 'db' END) as type,( CASE WHEN acct_shareHolder.ID != '' THEN 'Cash In Hand' ELSE 'Cash In Hand' END) as subcategory,( CASE WHEN acct_shareCapital.ID != '' THEN 'Share Capital' ELSE 'Share Capital' END) as transactionType");
            $this->db->from('shareCapital');
            if($fromDate != '' && $toDate != '')
                $this->db->where("Date BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("Date",$fromDate);
            else if( $toDate != '' )
                $this->db->where("Date",$toDate);
            else
                $this->db->where("YEAR(acct_shareCapital.Date)",date('Y'));
            $this->db->where('shareCapital.companyRef',$this->companyData->companyRef);
            $this->db->where('shareCapital.paymentMethod',1);
            $this->db->where('shareCapital.status',1);
            $this->db->join('shareCapitalitems','shareCapitalitems.shareCapitalRef = shareCapital.shareCapitalRef','inner');
            $this->db->join('shareHolder','shareHolder.shareRef = shareCapital.shareHolderRef','inner');
            $query    	      = $this->db->get();
            $shareCapitalCash = array();
            if($query->num_rows() > 0)
            {
                $shareCapitalCash = $query->result();
                $result           = array_merge($result,$shareCapitalCash);
            }
        }
        else if( $searchKey == 'p96c3k41C4PSJbXL') // getting amount for trade receiveable
        {
            $this->db->select("acct_transactionItems.amount,acct_transactionItems.vatAmount,acct_transactionItems.discountAmountPerItem,acct_transactionItems.commisionAmountPerItem,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Trade Receiveable' ELSE 'Trade Receiveable' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '2' THEN 'cr' ELSE 'cr' END) as type,(SELECT SUM(acct_payments.amount) FROM acct_payments WHERE acct_payments.transactionRef = acct_transactionItems.transactionRef) as paymentRecieved,(SELECT count(acct_transactionItems.itemID) FROM acct_transactionItems WHERE acct_transactionItems.transactionRef = acct_transactions.transactionRef) as totalItems");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where_in('transactions.transactionType',array(2,5));
            $this->db->where('transactions.paymentMethod',3);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'dDoOEeqK6ROYuXLT') // getting amount for trade payable
        {
            $this->db->select("acct_transactionItems.amount,acct_transactionItems.vatAmount,acct_transactionItems.discountAmountPerItem,acct_transactionItems.commisionAmountPerItem,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '1' THEN 'Trade Payable' ELSE 'Trade Payable' END) as subcategory,( CASE WHEN acct_transactions.transactionType = '1' THEN 'db' ELSE 'db' END) as type,(SELECT SUM(acct_payments.amount) FROM acct_payments WHERE acct_payments.transactionRef = acct_transactionItems.transactionRef) as paymentRecieved,(SELECT count(acct_transactionItems.itemID) FROM acct_transactionItems WHERE acct_transactionItems.transactionRef = acct_transactions.transactionRef) as totalItems");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where_in('transactions.transactionType',array('1','3','4'));
            $this->db->where('transactions.paymentMethod',3);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }
        else if( $searchKey == 'kgroNJeY4VUrn0GE' || $searchKey == 'tuxaCbQdS7eZ3tPy' || $searchKey == '1zr97PqolBn1AaPs'  || $searchKey == 'uyYESIXjZWPFfjkq' ) // getting amount for borrowings and loans
        {
            // kgroNJeY4VUrn0GE long term borrowings
            // tuxaCbQdS7eZ3tPy short term borrowings
            // 1zr97PqolBn1AaPs long term loans and advances
            // uyYESIXjZWPFfjkq short term loans and advances
            if( $searchKey == 'kgroNJeY4VUrn0GE' )
                $this->db->select("acct_loans.loanRef,acct_loans.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE 'cr' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Borrowings' ELSE '' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
            if( $searchKey == 'tuxaCbQdS7eZ3tPy' )
                $this->db->select("acct_loans.loanRef,acct_loans.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE 'cr' END) as type,( CASE WHEN acct_loans.loanType = '1' THEN 'Short Term Borrowings' ELSE '' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
            if( $searchKey == '1zr97PqolBn1AaPs' )
                $this->db->select("acct_loans.loanRef,acct_loans.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE 'cr' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Loan and Advances' ELSE '' END) as subcategory,( CASE WHEN acct_loans.type = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
            if( $searchKey == 'uyYESIXjZWPFfjkq' )
                $this->db->select("acct_loans.loanRef,acct_loans.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE 'cr' END) as type,( CASE WHEN acct_loans.loanType = '1' THEN 'Short Term Loan and Advances' ELSE '' END) as subcategory,( CASE WHEN acct_loans.loanType = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
            $this->db->from('loans');
            if($fromDate != '' && $toDate != '')
                $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("date",$fromDate);
            else if( $toDate != '' )
                $this->db->where("date",$toDate);
            else
                $this->db->where("YEAR(acct_loans.date)",date('Y'));
            $this->db->where('loans.companyRef',$this->companyData->companyRef);
            $this->db->where('loans.status',1);
            if( $searchKey == 'kgroNJeY4VUrn0GE' || $searchKey == '1zr97PqolBn1AaPs' )
                $this->db->where('loans.loanType',2); //long term
            if( $searchKey == 'tuxaCbQdS7eZ3tPy' || $searchKey == 'uyYESIXjZWPFfjkq' )
                $this->db->where('loans.loanType',1); //short term

            if( $searchKey == 'kgroNJeY4VUrn0GE' || $searchKey == 'tuxaCbQdS7eZ3tPy' ) // borrowings
                $this->db->where('loans.type',2);
            if( $searchKey == '1zr97PqolBn1AaPs' || $searchKey == 'uyYESIXjZWPFfjkq' ) // loans
                $this->db->where('loans.type',1);

            $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = loans.bankRef','left');
            $this->db->order_by('loanID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }

            /*********** payment received/paid ******************/
            if( $searchKey == 'kgroNJeY4VUrn0GE' )
                $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'cr' ELSE 'db' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Borrowings' ELSE '' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
            if( $searchKey == 'tuxaCbQdS7eZ3tPy' )
                $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'cr' ELSE 'db' END) as type,( CASE WHEN acct_loans.loanType = '1' THEN 'Short Term Borrowings' ELSE '' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
            if( $searchKey == '1zr97PqolBn1AaPs' )
                $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'cr' ELSE 'db' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Loan and Advances' ELSE '' END) as subcategory,( CASE WHEN acct_loans.type = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
            if( $searchKey == 'uyYESIXjZWPFfjkq' )
                $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'cr' ELSE 'db' END) as type,( CASE WHEN acct_loans.loanType = '1' THEN 'Short Term Loan and Advances' ELSE '' END) as subcategory,( CASE WHEN acct_loans.loanType = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
            $this->db->from('loans');
            if($fromDate != '' && $toDate != '')
                $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("date",$fromDate);
            else if( $toDate != '' )
                $this->db->where("date",$toDate);
            else
                $this->db->where("YEAR(acct_loans.date)",date('Y'));
            $this->db->where('loans.companyRef',$this->companyData->companyRef);
            $this->db->where('loans.status',1);
            if( $searchKey == 'kgroNJeY4VUrn0GE' || $searchKey == '1zr97PqolBn1AaPs' )
                $this->db->where('loans.loanType',2); //long term
            if( $searchKey == 'tuxaCbQdS7eZ3tPy' || $searchKey == 'uyYESIXjZWPFfjkq' )
                $this->db->where('loans.loanType',1); //short term

            if( $searchKey == 'kgroNJeY4VUrn0GE' || $searchKey == 'tuxaCbQdS7eZ3tPy' ) // borrowings
                $this->db->where('loans.type',2);
            if( $searchKey == '1zr97PqolBn1AaPs' || $searchKey == 'uyYESIXjZWPFfjkq' ) // loans
                $this->db->where('loans.type',1);

            $this->db->join('payments','payments.transactionRef = loans.loanRef','inner');
            $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = loans.bankRef','left');
            $this->db->order_by('loanID', 'Desc');
            $query1    	        = $this->db->get();
            $borrowingLoanPaid  = array();
            if($query1->num_rows() > 0)
            {
                $borrowingLoanPaid = $query1->result();
                $result            = array_merge($result,$borrowingLoanPaid);
            }
        }
        else if( $searchKey == 'aW1cjzwHMGLcO9vZ')  // getting share capital amount for money received category
        {
            $this->db->select("acct_shareCapital.shareCapitalRef,acct_shareCapital.paymentMethod,acct_shareCapitalitems.amount,shareCapital.date as invoiceDate,CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName) AS payeeName,( CASE WHEN acct_shareHolder.ID != '' THEN 'cr' ELSE 'cr' END) as type,( CASE WHEN acct_shareHolder.ID != '' THEN 'Share Capital' ELSE 'Share Capital' END) as subcategory,( CASE WHEN acct_shareCapital.ID != '' THEN 'Share Capital' ELSE 'Share Capital' END) as transactionType");
            $this->db->from('shareCapital');
            if($fromDate != '' && $toDate != '')
                $this->db->where("Date BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("Date",$fromDate);
            else if( $toDate != '' )
                $this->db->where("Date",$toDate);
            else
                $this->db->where("YEAR(acct_shareCapital.Date)",date('Y'));
            $this->db->where('shareCapital.companyRef',$this->companyData->companyRef);
            $this->db->where('shareCapital.status',1);
            $this->db->join('shareCapitalitems','shareCapitalitems.shareCapitalRef = shareCapital.shareCapitalRef','inner');
            $this->db->join('shareHolder','shareHolder.shareRef = shareCapital.shareHolderRef','inner');
            $query    	       = $this->db->get();
            $shareCapitalMoney = array();
            if($query->num_rows() > 0)
            {
                $shareCapitalMoney = $query->result();
                $result            = array_merge($result,$shareCapitalMoney);
            }
        }

        else
        {
            $this->db->select("trialBalanceCategories.title as subcategory,transactionItems.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '3' THEN 'db' ELSE '' END) as type");
            $this->db->from('transactions');
            if($fromDate != '' && $toDate != '')
                $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
            else if( $fromDate != '' )
                $this->db->where("invoiceDate",$fromDate);
            else if( $toDate != '' )
                $this->db->where("invoiceDate",$toDate);
            else
                $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.status',1);
            $this->db->where('transactions.transactionType',3);
            $this->db->where('transactionItems.subcategoryRef',$searchKey);
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
            $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
            $this->db->join('trialBalanceCategories','trialBalanceCategories.categoryRef = acct_transactionItems.subcategoryRef','left');
            $this->db->order_by('transactionID', 'Desc');
            $query1    	        = $this->db->get();
            $result             = array();
            if($query1->num_rows() > 0)
            {
                $result = $query1->result();
            }
        }

        /************** getting transactions table bank amount *******/
        $this->db->select("sum(acct_transactionItems.amount) as amount,sum(acct_transactionItems.vatAmount) as vatAmount,sum(acct_transactionItems.discountAmountPerItem) as discountAmountPerItem,sum(acct_transactionItems.commisionAmountPerItem) as commisionAmountPerItem,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName1,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName,banks.name as bankName,( CASE WHEN acct_transactions.transactionType = '2' || acct_transactions.transactionType = '4' THEN 'db' ELSE 'cr' END) as type,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Sale' WHEN acct_transactions.transactionType = '3' THEN 'Expense' WHEN acct_transactions.transactionType = '4' THEN 'Purchase Return' WHEN acct_transactions.transactionType = '5' THEN 'Sale Return' ELSE 'Purchase' END) as subcategory");
        $this->db->from('transactions');
        if($fromDate != '' && $toDate != '')
            $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("invoiceDate",$fromDate);
        else if( $toDate != '' )
            $this->db->where("invoiceDate",$toDate);
        else
            $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        $this->db->where_not_in('transactions.paymentMethod',array('1','3'));
        $this->db->where('transactions.status',1);
        $this->db->where('transactions.bankRef',$searchKey);
        $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
        $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType IN (2,5)','left');
        $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType IN (1,3,4)','left');
        $this->db->join('banks','banks.bankRef = transactions.bankRef','left');
        $this->db->order_by('transactionID', 'Desc');
        $this->db->group_by('transactions.transactionRef');
        $query    	         = $this->db->get();
        $BankTransactions    = array();
        if($query->num_rows() > 0)
        {
            $BankTransactions = $query->result();
            $result = array_merge($result,$BankTransactions);
        }

        /**************  received bank payment *************/
        $this->db->select("acct_payments.amount,transactions.transactionRef,transactions.transactionType,transactions.payeeRef,transactions.paymentMethod,transactions.invoiceDate,transactions.bankRef,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName1,( CASE WHEN acct_transactions.transactionType = '2' || acct_transactions.transactionType = '4' THEN 'db' ELSE 'cr' END) as type,( CASE WHEN acct_transactions.transactionType = '2' THEN 'Sale' WHEN acct_transactions.transactionType = '3' THEN 'Expense' WHEN acct_transactions.transactionType = '4' THEN 'Purchase Return' WHEN acct_transactions.transactionType = '5' THEN 'Sale Return' ELSE 'Purchase' END) as subcategory");
        $this->db->from('transactions');
        if($fromDate != '' && $toDate != '')
            $this->db->where("invoiceDate BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("invoiceDate",$fromDate);
        else if( $toDate != '' )
            $this->db->where("invoiceDate",$toDate);
        else
            $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        $this->db->where('transactions.paymentMethod',3);
        $this->db->where('payments.paymentMethod',2);
        $this->db->where('transactions.status',1);
        $this->db->where('payments.bankRef',$searchKey);
        $this->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
        $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef AND transactions.transactionType IN (2,5)','left');
        $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef AND transactions.transactionType IN (1,3,4)','left');
        $query    	= $this->db->get();
        $bankReceivedPayment = array();
        if($query->num_rows() > 0)
        {
            $bankReceivedPayment = $query->result();
            $result = array_merge($result,$bankReceivedPayment);
        }

        /*********** getting bank amount from short/long term borrowings  **************/
        $this->db->select("acct_loans.loanRef,acct_loans.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,( CASE WHEN acct_loans.type = '2' THEN 'db' ELSE '' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Borrowings' ELSE 'Short Term Borrowings' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
        $this->db->from('loans');
        if($fromDate != '' && $toDate != '')
            $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("date",$toDate);
        else
            $this->db->where("YEAR(acct_loans.date)",date('Y'));
        $this->db->where('loans.companyRef',$this->companyData->companyRef);
        $this->db->where('loans.status',1);
        $this->db->where('loans.type',2);
        $this->db->where('loans.bankRef',$searchKey);
        $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
        $query    	= $this->db->get();
        $borrowingResult = array();
        if($query->num_rows() > 0)
        {
            $borrowingResult = $query->result();
            $result          = array_merge($result,$borrowingResult);
        }

        /*********** getting bank amount from short/long term loans  **************/
        $this->db->select("acct_loans.loanRef,acct_loans.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,( CASE WHEN acct_loans.type = '1' THEN 'cr' ELSE '' END) as type,( CASE WHEN acct_loans.loanType = '1' THEN 'Long Term Loan And Advances' ELSE 'Short Term Loan And Advances' END) as subcategory,( CASE WHEN acct_loans.type = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
        $this->db->from('loans');
        if($fromDate != '' && $toDate != '')
            $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("date",$toDate);
        else
            $this->db->where("YEAR(acct_loans.date)",date('Y'));
        $this->db->where('loans.companyRef',$this->companyData->companyRef);
        $this->db->where('loans.status',1);
        $this->db->where('loans.type',1);
        $this->db->where('loans.bankRef',$searchKey);
        $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
        $query    	= $this->db->get();
        $loanResult = array();
        if($query->num_rows() > 0)
        {
            $loanResult = $query->result();
            $result     = array_merge($result,$loanResult);
        }


        /*********** getting bank amount from short/long term borrowings payments received **************/
        $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,( CASE WHEN acct_loans.type = '2' THEN 'cr' ELSE '' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Borrowings' ELSE 'Short Term Borrowings' END) as subcategory,( CASE WHEN acct_loans.type = '2' THEN 'Borrowings' ELSE '' END) as transactionType");
        $this->db->from('loans');
        if($fromDate != '' && $toDate != '')
            $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("date",$toDate);
        else
            $this->db->where("YEAR(acct_loans.date)",date('Y'));
        $this->db->where('loans.companyRef',$this->companyData->companyRef);
        $this->db->where('payments.paymentMethod',2);
        $this->db->where('loans.status',1);
        $this->db->where('loans.type',2);
        $this->db->where('payments.bankRef',$searchKey);
        $this->db->join('payments','payments.transactionRef = loans.loanRef','inner');
        $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
        $query    	= $this->db->get();
        $borrowingBankReceived = array();
        if($query->num_rows() > 0)
        {
            $borrowingBankReceived = $query->result();
            $result         = array_merge($result,$borrowingBankReceived);
        }

        /*********** getting bank amount from short/long term loans payments received **************/
        $this->db->select("acct_loans.loanRef,acct_payments.amount,loans.date as invoiceDate,loans.bankRef,CONCAT_WS(' ',acct_borrowers.title,acct_borrowers.firstName,acct_borrowers.lastName) AS payeeName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE '' END) as type,( CASE WHEN acct_loans.loanType = '2' THEN 'Long Term Loans And Advances' ELSE 'Short Term Loan And Advances' END) as subcategory,( CASE WHEN acct_loans.type = '1' THEN 'Loan and Advances' ELSE '' END) as transactionType");
        $this->db->from('loans');
        if($fromDate != '' && $toDate != '')
            $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("date",$toDate);
        else
            $this->db->where("YEAR(acct_loans.date)",date('Y'));
        $this->db->where('loans.companyRef',$this->companyData->companyRef);
        $this->db->where('payments.paymentMethod',2);
        $this->db->where('loans.status',1);
        $this->db->where('loans.type',1);
        $this->db->where('payments.bankRef',$searchKey);
        $this->db->join('payments','payments.transactionRef = loans.loanRef','inner');
        $this->db->join('borrowers','borrowers.borrowerRef = loans.loanToRef','left');
        $query    	= $this->db->get();
        $loansBankReceived = array();
        if($query->num_rows() > 0)
        {
            $loansBankReceived = $query->result();
            $result         = array_merge($result,$loansBankReceived);
        }

        /*********** getting amount from shareCapital where payment method is bank  **************/
        $this->db->select("acct_shareCapital.shareCapitalRef,acct_shareCapital.paymentMethod,acct_shareCapitalitems.amount,shareCapital.date as invoiceDate,CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName) AS payeeName,( CASE WHEN acct_shareHolder.ID != '' THEN 'db' ELSE 'db' END) as type,( CASE WHEN acct_shareHolder.ID != '' THEN 'Share Capital' ELSE 'Share Capital' END) as subcategory,( CASE WHEN acct_shareCapital.ID != '' THEN 'Share Capital' ELSE 'Share Capital' END) as transactionType");
        $this->db->from('shareCapital');
        if($fromDate != '' && $toDate != '')
            $this->db->where("Date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("Date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("Date",$toDate);
        else
            $this->db->where("YEAR(acct_shareCapital.Date)",date('Y'));
        $this->db->where('shareCapital.companyRef',$this->companyData->companyRef);
        $this->db->where('shareCapital.paymentMethod',2);
        $this->db->where('shareCapital.status',1);
        $this->db->where('shareCapital.bankRef',$searchKey);
        $this->db->join('shareCapitalitems','shareCapitalitems.shareCapitalRef = shareCapital.shareCapitalRef','inner');
        $this->db->join('shareHolder','shareHolder.shareRef = shareCapital.shareHolderRef','inner');
        $query    	      = $this->db->get();
        $shareCapitalBank = array();
        if($query->num_rows() > 0)
        {
            $shareCapitalBank = $query->result();
            $result           = array_merge($result,$shareCapitalBank);
        }

        $this->db->select("trialBalanceCategories.title as subcategory,acct_journalItems.amount,journals.journalNumber,journals.journalRef,journalItems.type,journals.date as invoiceDate,( CASE WHEN acct_journals.journalID = '' THEN 'Journal' ELSE 'Journal' END) as transactionType");
        $this->db->from('journalItems');
        if($fromDate != '' && $toDate != '')
            $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("date",$toDate);
        else
            $this->db->where("YEAR(date)",date('Y'));
        $this->db->where('journals.companyRef',$this->companyData->companyRef);
        $this->db->where('journalItems.subcategoryRef',$searchKey);
        $this->db->join('journals','journals.journalRef = journalItems.journalRef','inner');
        $this->db->join('trialBalanceCategories','trialBalanceCategories.categoryRef = journalItems.subcategoryRef','left');
        $this->db->order_by('journalID', 'Desc');
        $query1    	        = $this->db->get();
        $journalresult      = array();
        if($query1->num_rows() > 0)
        {
            $journalresult = $query1->result();
        }

        $result = array_merge($result,$journalresult);
    //    echo "<pre>";print_r($result);
        return $result;
    }
}
?>

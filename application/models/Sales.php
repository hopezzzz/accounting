<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function allProductServices(){
      $this->db->select('*');
      $this->db->from('acct_products');
      $this->db->group_by('productName');
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }
    public function getTableCloumns()
    {
          $this->db->select("acct_transactions.*,acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName");
          $this->db->from('acct_transactions');
          $this->db->where('transactionType',2);
          $this->db->join('acct_debtors','acct_debtors.debtorRef = payeeRef ','left');
          $query        = $this->db->get();
          $fields       = $query->list_fields();

          $this->db->select("acct_transactionItems.*,acct_products.*");
          $this->db->from('acct_transactionItems');
          $this->db->join('acct_products','acct_products.productRef = acct_transactionItems.productRef','left');
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

    public function fetchSalesList($limit, $start , $searchKey = null)
    {
        $reference     = $this->session->userdata('reference');
        $referenceType = $this->session->userdata('referenceType');
        if( $referenceType != 'debtor')
            $reference     = '';
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('acct_transactions');
        $this->db->where_in('transactionType',array(2,5));
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        if( $reference != '' )
            $this->db->where('transactions.payeeRef',$reference);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate        = date('Y-m-d',strtotime($searchKey));
            $paymentMethod  = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or transactions.vatTotal LIKE '%$searchKey%' or CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%' or transactions.paymentMethod LIKE '%$paymentMethod%')";
            else
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.vatTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%')";
            $this->db->where($where);
        }
        $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef','left');
        $query1     = $this->db->get();
        $total_rows = $query1->row()->numrows;

        /* * **************** fetching records ******************** */
        $this->db->select("transactions.*,CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS payeeName");
        $this->db->from('transactions');
        $this->db->where_in('transactionType',array(2,5));
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        if( $reference != '' )
            $this->db->where('transactions.payeeRef',$reference);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate        = date('Y-m-d',strtotime($searchKey));
            $paymentMethod  = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or transactions.vatTotal LIKE '%$searchKey%' or CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%' or transactions.paymentMethod LIKE '%$paymentMethod%')";
            else
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.vatTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%')";
            $this->db->where($where);
        }
        $this->db->join('acct_debtors','acct_debtors.debtorRef = transactions.payeeRef','left');
        $this->db->order_by('transactionID', 'Desc');
        $this->db->limit($start,$limit);
        $query  = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->result();
        }
        return array(
            'total_rows' => $total_rows,
            'result'     => $result
        );
    }

    public function getDataByRef($param){

        /*         * **************** fetching data by ref ******************** */
        $this->db->select("acct_transactions.*,title,firstName,lastName");
        $this->db->from('acct_transactions');
        $this->db->join('acct_debtors','acct_debtors.debtorRef = payeeRef ','left');
        $this->db->where_in('transactionType',array(2,5));
        $this->db->where('payee',1);
        $this->db->where('acct_transactions.transactionRef',$param);
        $this->db->order_by('transactionID', 'ASC');
        $query = $this->db->get();
          #echo $this->db->last_query(); die;
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
}
?>

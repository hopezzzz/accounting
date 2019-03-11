<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }


    public function fetchMesurementList($limit, $start, $searchKey = null )
    {
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('measurement');
        if($searchKey != NULL && $searchKey != '')
		{

			    $where = "( measurement.typeName LIKE '%$searchKey%')";
			    $this->db->where($where);
		}
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /* * **************** fetching records ******************** */
        $this->db->select("*");
        $this->db->from('measurement');
        if($searchKey != NULL && $searchKey != '')
        {

            $where = "( measurement.typeName LIKE '%$searchKey%' )";
            $this->db->where($where);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($start,$limit);
        $query = $this->db->get();
        #echo $this->db->last_query();die;
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

    public function getMeasurementTableCloumns()
    {
          $this->db->select("*");
          $this->db->from('measurement');
          $this->db->order_by('id','ASC');
          $query        = $this->db->get();
          $fields       = $query->list_fields();
          $measurementdetails = new stdClass();
          foreach ($fields as $field)
          {
             $measurementdetails->$field = '';
          }

          return $measurementdetails;
    }

    public function getMeasurementDataByRef($param){

        /*         * **************** fetching data by ref ******************** */
        $this->db->select("*");
        $this->db->from('measurement');
        $this->db->where('typeRef',$param);
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->row();
        }
        return  $result;

    }

    public function getTransactionlist($subcategoryRef)
    {
      $this->db->select("transactions.*,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName, CONCAT_WS(' ',acct_debtors.title,acct_debtors.firstName,acct_debtors.lastName) AS salePayeeName, name,subcategoryRef,itemRef,amount,vatAmount, trialBalanceCategories.title as subcategory");
      $this->db->from('transactions');
      $this->db->where('transactions.companyRef',$this->companyData->companyRef);
      $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
      $this->db->join('debtors','debtors.debtorRef = transactions.payeeRef','left');
      $this->db->join('acct_banks','acct_banks.bankRef = transactions.bankRef','left');
      $this->db->where("( subcategoryRef = '".$subcategoryRef."' OR transactions.bankRef = '".$subcategoryRef."' )");
      $this->db->join('acct_transactionItems','acct_transactionItems.transactionRef = transactions.transactionRef','inner');
      $this->db->join('trialBalanceCategories','trialBalanceCategories.categoryRef = acct_transactionItems.subcategoryRef','left');
      $this->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
      $this->db->order_by('transactionID', 'Desc');
      $this->db->group_by('itemID');
      /** Getting resutls */
      $query = $this->db->get();
      $result = array();
      if ($query->num_rows() > 0)
      {
          $result['transaction'] = $query->result();
      }
      else
      {
          $result['transaction'] =  array();
      }
      $this->db->select("journals.*,journalItems.*,trialBalanceCategories.title as subcategory");
      $this->db->from('journals');
      $this->db->where('journals.companyRef',$this->companyData->companyRef);
      $this->db->join('journalItems','journalItems.journalRef = journals.journalRef','inner');
      $this->db->join('trialBalanceCategories','trialBalanceCategories.categoryRef = journalItems.subcategoryRef','left');
      $this->db->where('journalItems.subcategoryRef ',$subcategoryRef);
      $this->db->group_by('journalItems.subcategoryRef');
      $queryJ = $this->db->get();
      #echo $this->db->last_query();die;
      $resultJ = array();
      if ($queryJ->num_rows() > 0)
      {
          $result["journal"] = $queryJ->result();
      }
      else
      {
          $result["journal"] =  array();
      }
      // return array(
      //     'transaction' => $result,
      //     'resultJ' => $resultJ
      // );
      return $result;
    }
    public function deleteTransactions($param,$status)
    {
      //  print_r($param); die;

        $this->db->set('status',$status);
        $this->db->where('categoryRef',$param['categoryRef']);
        $this->db->update('trialBalanceCategories');

        if(isset($param['journal']) && !empty($param['journal']))
        {
          $this->db->where_in('journalRef',$param['journal']);
          $this->db->delete('journalItems');
          $this->db->where_in('journalRef',$param['journal']);
          $this->db->delete('journals');
        }
        if(isset($param['expense']) && !empty($param['expense']) !="")
        {
          $this->db->where_in('itemRef',$param['expense']);
          $this->db->delete('transactionItems');
        }
        $db_error = $this->db->error();
        if ($db_error['code'] == 0)
            return '1';
        else
            return '0';
    }
}
?>

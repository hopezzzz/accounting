<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Journal extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    public function getTableCloumns()
    {
        $this->db->select("*");
        $this->db->from('journals');
        $this->db->join('journalItems','journalItems.journalRef = journals.journalRef','inner');
        $query            = $this->db->get();
        $fields           = $query->list_fields();
        $journalDetail[0] = new stdClass();
        foreach ($fields as $field)
        {
            $journalDetail[0]->$field = '';
        }
        return $journalDetail;
    }


    public function allProductServices(){
      $this->db->select('*');
      $this->db->from('acct_products');
      $this->db->group_by('productName');
      $query = $this->db->get();
      $result = $query->result();
      return $result;
    }

    public function fetchJournalList($limit, $start, $searchKey = null, $fromDate = null,$toDate = null )
    {
        if( $fromDate != '' && $fromDate != '0000-00-00' && $fromDate != '1970-01-01')
            $fromDate = date('Y-m-d',strtotime($fromDate));
        else
            $fromDate = '';

        if( $toDate != '' && $toDate != '0000-00-00' && $toDate != '1970-01-01')
            $toDate = date('Y-m-d',strtotime($toDate));
        else
            $toDate = '';

        /***************** counting records **************** */
        /*$this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('journals');
        $this->db->where('journals.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where  = "( journals.date LIKE '%$addDate%' or  trialBalanceCategories.title LIKE '%$searchKey%' or journals.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('journalItems','journalItems.journalRef = journals.journalRef','inner');
        $this->db->join('trialBalanceCategories','trialBalanceCategories.categoryRef = journalItems.subcategoryRef','left');
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;*/


        /* * **************** fetching records ******************** */
        $this->db->select("journals.*,journalItems.*,trialBalanceCategories.title as subcategory");
        $this->db->from('journals');
        $this->db->where('journals.companyRef',$this->companyData->companyRef);
        if($fromDate != '' && $toDate != '')
            $this->db->where("date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("date",$toDate);
        else
            $this->db->where("YEAR(date)",date('Y'));

        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where  = "( journals.date LIKE '%$addDate%' or journals.journalNumber LIKE '%$searchKey%' or journals.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('journalItems','journalItems.journalRef = journals.journalRef','inner');
        $this->db->join('trialBalanceCategories','trialBalanceCategories.categoryRef = journalItems.subcategoryRef','left');
        $this->db->order_by('journalID', 'Desc');
        //$this->db->limit($start,$limit);
        $query = $this->db->get();

        //echo $this->db->last_query();die;
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->result();
        }
        return array(
            //'total_rows' => $total_rows,
            'result' => $result
        );
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

}
?>

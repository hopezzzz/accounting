<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bank extends CI_Model {
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

    public function fetchBankList($limit, $start, $searchKey = null )
    {
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('acct_banks');
        $this->db->where('acct_banks.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
			    $where = "( acct_banks.name LIKE '%$searchKey%' or  acct_banks.code LIKE '%$addDate%' or  acct_banks.accountNumber LIKE '%$addDate%' )";
            else
			    $where = "( acct_banks.name LIKE '%$searchKey%' or  acct_banks.code LIKE '%$addDate%' or  acct_banks.accountNumber LIKE '%$addDate%' )";
			$this->db->where($where);
		}
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /* * **************** fetching records ******************** */
        $this->db->select("*");
        $this->db->from('acct_banks');
        $this->db->where('acct_banks.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
                $where = "( acct_banks.name LIKE '%$searchKey%' or  acct_banks.code LIKE '%$addDate%' or  acct_banks.accountNumber LIKE '%$addDate%' )";
            else
                $where = "( acct_banks.name LIKE '%$searchKey%' or  acct_banks.code LIKE '%$addDate%' or  acct_banks.accountNumber LIKE '%$addDate%' )";
            $this->db->where($where);
        }
        $this->db->order_by('bankID', 'ASC');
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
          $this->db->select("*");
          $this->db->from('acct_banks');
          $this->db->order_by('bankID','ASC');
          $query        = $this->db->get();
          $fields       = $query->list_fields();
          $purchaseDetail = new stdClass();
          foreach ($fields as $field)
          {
             $purchaseDetail->$field = '';
          }

          return $purchaseDetail;
    }

    public function getDataByRef($param){

        /*         * **************** fetching data by ref ******************** */
        $this->db->select("*");
        $this->db->from('acct_banks');
        $this->db->where('acct_banks.bankRef',$param);
        $this->db->order_by('bankID', 'ASC ');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->row();
        }
        return  $result;

    }

    public function addBank($param)
    {

        $this->db->set('name',$param['name']);
        $this->db->set('code',$param['code']);
        $this->db->set('bankRef',$param['bankRef']);
        $this->db->set('accountNumber',$param['accountNumber']);
        $this->db->set('companyRef',$param['companyRef']);
        $this->db->set('createdDate',$param['createdDate']);
        $this->db->set('modifiedDate',$param['modifiedDate']);
        $this->db->set('status',$param['status']);
        $this->db->set('addedBy',$param['addedBy']);
        $this->db->insert('acct_banks');
        if($this->db->affected_rows() > 0)
        {
           $response['success']= true;
        }
        else
        {
          $response['success'] =false;
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
    public function addNewBank($bankName,$bankRef,$accountNumber)
    {
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
        $bankName              = trim($bankName);
            $this->db->set('bankRef',$bankRef);
            $this->db->set('name',$bankName);
            $this->db->set('accountNumber',$accountNumber);
            $this->db->set('companyRef',$this->companyData->companyRef);
            $this->db->set('status',1);
            $this->db->set('createdDate',date('Y-m-d'));
            $this->db->set('modifiedDate',date('Y-m-d'));
            $this->db->set('addedBy',$this->loginSessionData['clientRef']);
            $this->db->insert('banks');
            if($this->db->affected_rows() > 0)
            {
                $data                    = new stdClass();
                $data->bankName          = $bankName;
                $data->bankRef           = $bankRef;
                $response['success']     = true;
                $response['bankData']    = $data;
                $response['success']     = true;
                $response['success_message'] = 'bank added successfully!';
            }
            else
            {
                $response['success']  = false;
                $response['errorMsg'] = "Something went wrong. Please try again";
            }
        return $response;
    }

    
}
?>

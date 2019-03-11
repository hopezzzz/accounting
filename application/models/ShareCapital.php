<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ShareCapital extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }



    public function fetchShareCapitaList($limit, $start, $searchKey = null )
    {
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('shareCapital');
        $this->db->where('shareCapital.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
			    $where = "( shareCapital.Date LIKE '%$addDate%' or shareCapital.subTotal LIKE '%$searchKey%'   or CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName, acct_shareHolder.noOfShare) LIKE '%$searchKey%' or shareCapital.createdDate LIKE '%$addDate%' or shareCapital.paymentMethod LIKE '%$paymentMethod%')";
            else
			    $where = "( shareCapital.Date LIKE '%$addDate%' or shareCapital.subTotal LIKE '%$searchKey%'   or CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName, acct_shareHolder.noOfShare) LIKE '%$searchKey%' or shareCapital.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('shareHolder','shareHolder.shareRef = shareCapital.shareHolderRef','left');
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /* * **************** fetching records ******************** */
        $this->db->select("shareCapital.*,CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName) AS payeeName");
        $this->db->from('shareCapital');
        $this->db->where('shareCapital.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
                $where = "( shareCapital.Date LIKE '%$addDate%' or shareCapital.subTotal LIKE '%$searchKey%'   or CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName, acct_shareHolder.noOfShare) LIKE '%$searchKey%' or shareCapital.createdDate LIKE '%$addDate%' or shareCapital.paymentMethod LIKE '%$paymentMethod%')";
            else
                $where = "( shareCapital.Date LIKE '%$addDate%' or shareCapital.subTotal LIKE '%$searchKey%'   or CONCAT_WS(' ',acct_shareHolder.title,acct_shareHolder.firstName,acct_shareHolder.lastName, acct_shareHolder.noOfShare) LIKE '%$searchKey%' or shareCapital.createdDate LIKE '%$addDate%')";
            $this->db->where($where);
        }
        $this->db->join('shareHolder','shareHolder.shareRef = shareCapital.shareHolderRef','left');
        $this->db->order_by('ID', 'Desc');
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
          $this->db->from('acct_shareCapital');
          $query        = $this->db->get();
          $fields       = $query->list_fields();
          $this->db->select("acct_transactionItems.*");
          $this->db->from('acct_transactionItems');
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
        $this->db->select("shareCapital.*,CONCAT_WS(' ',title,firstName,lastName) as fullName, noOfShare");
        $this->db->from('shareCapital');
        $this->db->join('shareHolder','shareHolder.shareRef = shareCapital.shareHolderRef ','left');
        $this->db->where('shareCapital.shareCapitalRef',$param);
        $this->db->order_by('ID', 'ASC ');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->row();
            $this->db->select("acct_shareCapitalitems.*");
            $this->db->from('acct_shareCapitalitems');
            $this->db->where('acct_shareCapitalitems.shareCapitalRef',$param);
            $query1 = $this->db->get();
            $result1 = $query1->result();
            $result->items = $result1;
        }
        return  $result;

    }


    public function deleteItems($recordRef)
    {
          $this->db->where('itemRef',$recordRef);
          $this->db->delete('acct_shareCapitalitems');

    }

    public function getShareHolderlist($detailUpper,$detailLower)
    {

        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
        $this->db->select("title,firstName,lastName,shareRef,noOfShare,companyname");
        $this->db->from("acct_shareHolder");
        $this->db->join("acct_company","acct_company.borrowerCompanyRef = acct_shareHolder.shareholCompanyRef",'left');
        $this->db->where('acct_shareHolder.companyRef',$this->companyData->companyRef);
        $this->db->where('acct_shareHolder.status = 1');
        $this->db->group_start();

        $this->db->like('title', $detailUpper, 'after');
        $this->db->or_like('title', $detailLower, 'after');
        $this->db->or_like('title', strtolower($detailLower), 'after');
        $this->db->or_like('title', strtoupper($detailLower), 'after');
        $this->db->or_like('title', ucfirst($detailLower), 'after');

        $this->db->like("CONCAT_WS(' ',title,firstName,lastName)", $detailUpper, 'after');
        $this->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", $detailLower, 'after');
        $this->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", strtolower($detailLower), 'after');
        $this->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", strtoupper($detailLower), 'after');
        $this->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", ucfirst($detailLower), 'after');

        $this->db->like('firstName', $detailUpper, 'after');
        $this->db->or_like('firstName', $detailLower, 'after');
        $this->db->or_like('firstName', strtolower($detailLower), 'after');
        $this->db->or_like('firstName', strtoupper($detailLower), 'after');
        $this->db->or_like('firstName', ucfirst($detailLower), 'after');

        $this->db->like('lastName', $detailUpper, 'after');
        $this->db->or_like('lastName', $detailLower, 'after');
        $this->db->or_like('lastName', strtolower($detailLower), 'after');
        $this->db->or_like('lastName', strtoupper($detailLower), 'after');
        $this->db->or_like('lastName', ucfirst($detailLower), 'after');

        $this->db->like('mobile', $detailUpper, 'after');
        $this->db->or_like('mobile', $detailLower, 'after');
        $this->db->or_like('mobile', strtolower($detailLower), 'after');
        $this->db->or_like('mobile', strtoupper($detailLower), 'after');
        $this->db->or_like('mobile', ucfirst($detailLower), 'after');

        $this->db->like('email', $detailUpper, 'after');
        $this->db->or_like('email', $detailLower, 'after');
        $this->db->or_like('email', strtolower($detailLower), 'after');
        $this->db->or_like('email', strtoupper($detailLower), 'after');
        $this->db->or_like('email', ucfirst($detailLower), 'after');

        $this->db->like('country', $detailUpper, 'after');
        $this->db->or_like('country', $detailLower, 'after');
        $this->db->or_like('country', strtolower($detailLower), 'after');
        $this->db->or_like('country', strtoupper($detailLower), 'after');
        $this->db->or_like('country', ucfirst($detailLower), 'after');

        $this->db->like('niNumber', $detailUpper, 'after');
        $this->db->or_like('niNumber', $detailLower, 'after');
        $this->db->or_like('niNumber', strtolower($detailLower), 'after');
        $this->db->or_like('niNumber', strtoupper($detailLower), 'after');
        $this->db->or_like('niNumber', ucfirst($detailLower), 'after');


        $this->db->group_end();
        $this->db->where('acct_shareHolder.status = 1');
        $this->db->group_by("shareRef");
        $query = $this->db->get();
        #echo $this->db->last_query(); die;
        $result = $query->result_array();

        return $result;
    }


}
?>

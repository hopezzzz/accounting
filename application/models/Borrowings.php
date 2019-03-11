<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Borrowings extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }



    public function fetchBorrowingsList($limit, $start, $searchKey = null , $type)
    {
        $reference     = $this->session->userdata('reference');
        $referenceType = $this->session->userdata('referenceType');
        if( $referenceType != 'borrower')
            $reference     = '';
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('acct_loans');
        $this->db->where('acct_loans.companyRef',$this->companyData->companyRef);
        $this->db->join('acct_borrowers','acct_borrowers.borrowerRef = acct_loans.loanToRef ','left');
        if( $reference != '' )
            $this->db->where('acct_loans.loanToRef',$reference);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where = "(  acct_loans.loanToRef LIKE '%$searchKey%' or acct_loans.amount LIKE '%$searchKey%' or  acct_loans.loanSource LIKE '%$searchKey%' or  acct_loans.createdDate LIKE '%$addDate%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%'or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or email LIKE '%$searchKey%' )";
			$this->db->where($where);

		}
        $this->db->where('acct_loans.type',$type);
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /* * **************** fetching records ******************** */
        $this->db->select("acct_loans.*,CONCAT_WS(' ',title,firstName,lastName) as fullName , companyname ,email");
        $this->db->from('acct_loans');
        $this->db->where('acct_loans.companyRef',$this->companyData->companyRef);
        $this->db->join('acct_borrowers','acct_borrowers.borrowerRef = acct_loans.loanToRef ','left');
        $this->db->join('acct_company','acct_company.borrowerCompanyRef = acct_borrowers.borrowerCompanyRef ','left');
        if( $reference != '' )
            $this->db->where('acct_loans.loanToRef',$reference);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate = date('Y-m-d',strtotime($searchKey));
            $where = "( acct_loans.loanToRef LIKE '%$searchKey%' or  acct_loans.amount LIKE '%$searchKey%' or  acct_loans.loanSource LIKE '%$searchKey%' or  acct_loans.createdDate LIKE '%$addDate%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%'or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or email LIKE '%$searchKey%' )";
            $this->db->where($where);

        }
        $this->db->where('acct_loans.type',$type);
        $this->db->group_by('loanID');
        $this->db->order_by('loanID', 'ASC');
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

    public function getTableCloumns()
    {
          $this->db->select("acct_loans.*,CONCAT_WS(' ',title,firstName,lastName) as fullName , companyname, email");
          $this->db->from('acct_loans');
          $this->db->join('acct_borrowers','acct_borrowers.borrowerRef = acct_loans.loanToRef ','left');
          $this->db->join('acct_company','acct_company.borrowerCompanyRef = acct_borrowers.borrowerCompanyRef ','left');
          $this->db->order_by('loanID','ASC');
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
        $this->db->select("acct_loans.*,CONCAT_WS(' ',title,firstName,lastName) as fullName , email");
        $this->db->from('acct_loans');
        $this->db->join('acct_borrowers','acct_borrowers.borrowerRef = acct_loans.loanToRef ','left');
        $this->db->join('acct_company','acct_borrowers.borrowerCompanyRef = acct_company.borrowerCompanyRef ','left');
        $this->db->where('acct_loans.loanRef',$param);
        $this->db->order_by('loanID', 'ASC ');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->row();
        }

        return  $result;

    }

    public function getBorrowerNamelist($detailUpper,$detailLower)
    {

        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
        $this->db->select("title,firstName,lastName,borrowerRef,companyname,email");
        $this->db->from("acct_borrowers");
        $this->db->join("acct_company",'acct_company.borrowerCompanyRef = acct_borrowers.borrowerCompanyRef');
        $this->db->where('acct_borrowers.companyRef',$this->companyData->companyRef);
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

        $this->db->like('companyname', $detailUpper, 'after');
        $this->db->or_like('companyname', $detailLower, 'after');
        $this->db->or_like('companyname', strtolower($detailLower), 'after');
        $this->db->or_like('companyname', strtoupper($detailLower), 'after');
        $this->db->or_like('companyname', ucfirst($detailLower), 'after');

        $this->db->like('email', $detailUpper, 'after');
        $this->db->or_like('email', $detailLower, 'after');
        $this->db->or_like('email', strtolower($detailLower), 'after');
        $this->db->or_like('email', strtoupper($detailLower), 'after');
        $this->db->or_like('email', ucfirst($detailLower), 'after');
        $this->db->group_end();
        $this->db->where('acct_borrowers.status = 1 '); 
        $this->db->group_by("borrowerRef");
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $result = $query->result_array();

        return $result;
    }

}
?>

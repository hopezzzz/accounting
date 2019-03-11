<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BorrowersModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->loginSessionData = $this->session->userdata('clientData');
        $this->companyData      = $this->loginSessionData['companyData'];
    }

    public function fetchBorrowers($start = null, $limit = null, $searchKey = null )
    {
        /****************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('borrowers');
        $this->db->where('borrowers.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where   = "( company.companyname LIKE '%$searchKey%' or borrowers.email LIKE '%$searchKey%' or borrowers.phone LIKE '%$searchKey%' or borrowers.mobile LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or borrowers.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('company','company.borrowerCompanyRef = borrowers.borrowerCompanyRef','inner');
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;

        /****************** fetching records ******************** */
        $this->db->select("company.companyname,borrowerRef ,borrowers.status,borrowers.email,borrowers.phone,borrowers.mobile,borrowers.createdDate,borrowers.modifiedDate,CONCAT_WS(' ',title,firstName,lastName) as fullName");
        $this->db->from('borrowers');
        $this->db->where('borrowers.companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where   = "( company.companyname LIKE '%$searchKey%' or borrowers.email LIKE '%$searchKey%' or borrowers.phone LIKE '%$searchKey%' or borrowers.mobile LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or borrowers.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('company','company.borrowerCompanyRef = borrowers.borrowerCompanyRef','inner');
        $this->db->order_by('borrowers.borrowerID', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return array(
            'total_rows' => $total_rows,
            'result' => $result
        );
    }

    /************* Get table column ***************/
    public function getTableCloumns()
	{
        $this->db->select("borrowers.*,company.companyname");
        $this->db->from('borrowers');
        $this->db->join('company','company.borrowerCompanyRef = borrowers.borrowerCompanyRef','inner');
        $query        = $this->db->get();
        $fields       = $query->list_fields();
        $borrowerDetail = new stdClass();
        foreach ($fields as $field)
        {
           $borrowerDetail->$field = '';
        }
        return $borrowerDetail;
	}

    /************* Get data by ref **************    */
	public function getDataByRef($borrowerRef)
	{
        $this->db->select("borrowers.*,company.companyname");
        $this->db->from('borrowers');
        $this->db->where('borrowers.borrowerRef',$borrowerRef);
        $this->db->join('company','company.borrowerCompanyRef = borrowers.borrowerCompanyRef','inner');
        $query        = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
	}
}

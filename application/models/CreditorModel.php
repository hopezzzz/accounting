<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class creditorModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->loginSessionData = $this->session->userdata('clientData');
        $this->companyData      = $this->loginSessionData['companyData'];
    }

    public function fetchCreditors($start = null, $limit = null, $searchKey = null ) {
        /*         * **************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('creditors');
        $this->db->where('companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where   = "( email LIKE '%$searchKey%' or phone LIKE '%$searchKey%' or mobile LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /*         * **************** fetching records ******************** */
        $this->db->select("creditorRef ,status,email,phone,mobile,createdDate,modifiedDate,CONCAT_WS(' ',title,firstName,lastName) as fullName");
        $this->db->from('creditors');
        $this->db->where('companyRef',$this->companyData->companyRef);
        if($searchKey != NULL && $searchKey != '')
		{
      if (strpos($searchKey, ".") !== false) {
          $addDate = '';

      }
      else {
          $addDate = date('Y-m-d',strtotime($searchKey));
      }
      //$addDate = date('Y-m-d',strtotime($searchKey));
      if($addDate !=""){
			     $where   = "( email LIKE '%$searchKey%' or phone LIKE '%$searchKey%' or mobile LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or createdDate LIKE '%$addDate%')";
      }
      else {
           $where   = "( email LIKE '%$searchKey%' or phone LIKE '%$searchKey%' or mobile LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%')";
      }
			$this->db->where($where);
		}
        $this->db->order_by('creditorID', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
      //  echo $this->db->last_query();die;
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return array(
            'total_rows' => $total_rows,
            'result' => $result
        );
    }

    /*           ************ Get table column **************    */
    	public function getTableCloumns()
	{
        $this->db->select("*");
        $this->db->from('creditors');
        $query        = $this->db->get();
        $fields       = $query->list_fields();
        $creditorDetail = new stdClass();
        foreach ($fields as $field)
        {
           $creditorDetail->$field = '';
        }
        return $creditorDetail;
	}

    /*           ************ Get data by ref **************    */
    	public function getDataByRef($creditorRef)
	{
        $this->db->select("*");
        $this->db->from('creditors');
        $this->db->where('creditorRef',$creditorRef);
        $query        = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0) {
            $result = $query->row();
        }
        return $result;
	}
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ShareHolder extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }



    public function fetchShareHolderList($limit, $start, $searchKey = null )
    {
      /*         * **************** counting records **************** */
      $this->db->select("COUNT(*) AS `numrows`");
      $this->db->from('acct_shareHolder');
      $this->db->where('companyRef',$this->companyData->companyRef);
      if($searchKey != NULL && $searchKey != '')
      {
        $addDate = date('Y-m-d',strtotime($searchKey));
        $where   = "( email LIKE '%$searchKey%' or niNumber LIKE '%$searchKey%' or  utrNumber LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or createdDate LIKE '%$addDate%')";
        $this->db->where($where);
      }
      $query1 = $this->db->get();
      $total_rows = $query1->row()->numrows;


      /*         * **************** fetching records ******************** */
      $this->db->select("shareRef ,niNumber,utrNumber,status,email,mobile,createdDate,modifiedDate,CONCAT_WS(' ',title,firstName,lastName) as fullName");
      $this->db->from('acct_shareHolder');
      $this->db->where('companyRef',$this->companyData->companyRef);
      if($searchKey != NULL && $searchKey != '')
      {
        $addDate = date('Y-m-d',strtotime($searchKey));
        $where   = "( email LIKE '%$searchKey%' or niNumber LIKE '%$searchKey%' or utrNumber LIKE '%$searchKey%' or CONCAT_WS(' ',title,firstName,lastName) LIKE '%$searchKey%' or createdDate LIKE '%$addDate%')";
        $this->db->where($where);
      }
      $this->db->order_by('id', 'asc');
      $this->db->limit($start,$limit);
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

    public function getTableCloumns()
    {
          $this->db->select("*");
          $this->db->from('acct_shareHolder');
          $this->db->order_by('id','ASC');
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
        $this->db->from('acct_shareHolder');
        $this->db->where('acct_shareHolder.shareRef',$param);
        $this->db->order_by('id', 'ASC ');
        $query = $this->db->get();
        $result = array();
        if ($query->num_rows() > 0)
        {
            $result = $query->row();
        }

        return  $result;

    }


}
?>

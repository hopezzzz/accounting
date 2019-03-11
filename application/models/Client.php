<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Client extends CI_Model {
    public function __construct()
	{
        parent::__construct();
    }
    /************ getting table fields name for add client form ********/
	public function getTableCloumns()
	{
        $this->db->select("clientProfile.*,companies.*,vats.vatPercentage,vats.vatRef");
		$this->db->from('clientProfile');
		$this->db->join('companies','companies.clientRef = clientProfile.clientProfileRef','left');
		$this->db->join('vats','vats.companyRef = companies.companyRef','left');
		$query        = $this->db->get();
        $fields       = $query->list_fields();
		$clientDetail = new stdClass();
        foreach ($fields as $field)
		{
		   $clientDetail->$field = '';
		}
		return $clientDetail;
	}

	public function fetchClients( $start = null, $limit = null, $searchKey = null )
	{
        $loginSessionData = $this->session->userdata('clientData');
		/****************** counting records *****************/
		$this->db->select("COUNT(*) AS `numrows`");
		$this->db->from('clientProfile');
        $this->db->where('login.userType',3);
        $this->db->where('login.isDeleted',0);
        $this->db->where('clientProfile.isDeleted',0);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where = "( companies.companyName LIKE '%$searchKey%' or  companies.companyType LIKE '%$searchKey%' or  clientProfile.email LIKE '%$searchKey%' or clientProfile.phone LIKE '%$searchKey%' or clientProfile.mobile LIKE '%$searchKey%' or CONCAT_WS(' ',acct_clientProfile.title,acct_clientProfile.firstName,acct_clientProfile.lastName) LIKE '%$searchKey%' or clientProfile.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('companies','companies.clientRef = clientProfile.clientProfileRef','left');
        $this->db->join('login','login.clientRef = clientProfile.clientProfileRef','left');
		$query1 = $this->db->get();
		$total_rows = $query1->row()->numrows;


		/****************** fetching records *********************/
		$this->db->select("login.isEmailVerified,login.status,login.clientRef,clientProfile.email,clientProfile.phone,clientProfile.mobile,clientProfile.createdDate,clientProfile.modifiedDate,CONCAT_WS(' ',acct_clientProfile.title,acct_clientProfile.firstName,acct_clientProfile.lastName) as fullName,companies.companyID,companies.companyName,companies.companyType,companies.companyRef");
		$this->db->from('clientProfile');
        $this->db->where('login.userType',3);
        $this->db->where('login.isDeleted',0);
        $this->db->where('clientProfile.isDeleted',0);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
			$where = "( companies.companyName LIKE '%$searchKey%' or  companies.companyType LIKE '%$searchKey%' or  clientProfile.email LIKE '%$searchKey%' or clientProfile.phone LIKE '%$searchKey%' or clientProfile.mobile LIKE '%$searchKey%' or CONCAT_WS(' ',acct_clientProfile.title,acct_clientProfile.firstName,acct_clientProfile.lastName) LIKE '%$searchKey%' or clientProfile.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
		$this->db->join('companies','companies.clientRef = clientProfile.clientProfileRef','left');
		$this->db->join('login','login.clientRef = clientProfile.clientProfileRef','left');
		$this->db->order_by('clientProfile.id', 'desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		$result = array();
		if( $query->num_rows() > 0 )
		{
			$result = $query->result();
		}
		return array(
			'total_rows'     => $total_rows,
			'result'     => $result
		);

	}

    public function fetchClientDetailByRef( $clientRef = null )
	{
		$this->db->select("clientProfile.*,companies.*,vats.vatPercentage,vats.vatRef,login.clientRef");
		$this->db->from('clientProfile');
		$this->db->where('clientProfileRef',$clientRef);
		$this->db->join('companies','companies.clientRef = clientProfile.clientProfileRef','left');
		$this->db->join('login','login.clientRef = clientProfile.clientProfileRef','left');
        $this->db->join('vats','vats.companyRef = companies.companyRef','left');
		$query = $this->db->get();
		$result = array();
		if( $query->num_rows() > 0 )
		{
			$result = $query->row();
		}
		return $result;
	}

}
?>

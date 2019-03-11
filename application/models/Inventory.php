<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    // public function fetchInventoryList($limit, $start, $searchKey = null, $fromDate = null,$toDate = null )
    // {
    //   if( $fromDate != '' && $fromDate != '0000-00-00' && $fromDate != '1970-01-01')
    //       $fromDate = date('Y-m-d',strtotime($fromDate));
    //   else
    //       $fromDate = '';
    //
    //   if( $toDate != '' && $toDate != '0000-00-00' && $toDate != '1970-01-01')
    //       $toDate = date('Y-m-d',strtotime($toDate));
    //   else
    //       $toDate = '';
    //   /* * **************** fetching records ******************** */
    //
    //   $this->db->select("inventory.*,productName");
    //   $this->db->from('inventory');
    //   $this->db->where('inventory.companyRef',$this->companyData->companyRef);
    //   $this->db->where('inventory.inventoryType=1');
    //   if($fromDate != '' && $toDate != '')
    //       $this->db->where("acct_inventory.date BETWEEN '$fromDate' AND '$toDate'");
    //   else if( $fromDate != '' )
    //       $this->db->where("acct_inventory.date",$fromDate);
    //   else if( $toDate != '' )
    //       $this->db->where("acct_inventory.date",$toDate);
    //   else
    //       $this->db->where("YEAR(acct_inventory.date)",date('Y'));
    //
    //   if($searchKey != NULL && $searchKey != '')
    //   {
    //     $addDate = date('Y-m-d',strtotime($searchKey));
    //     $where  = "(acct_inventory.inventory.date LIKE '%$addDate%')";
    //     $this->db->where($where);
    //   }
    //   $this->db->join('products','products.productRef = inventory.productRef','left');
    //   $this->db->group_by('productRef');
    //   $this->db->group_by('date');
    //   $this->db->order_by('date', 'ASC');
    //   //$this->db->limit(5);
    //   $query = $this->db->get();
    //
    //   #echo $this->db->last_query();die;
    //   $result = array();
    //   if ($query->num_rows() > 0)
    //   {
    //       $result = $query->result();
    //   }
    //   return array(
    //       //'total_rows' => $total_rows,
    //       'result' => $result
    //   );
    // }
    public function fetchInventoryList($limit, $start, $searchKey = null, $fromDate = null,$toDate = null )
    {
      if( $fromDate != '' && $fromDate != '0000-00-00' && $fromDate != '1970-01-01')
            $fromDate = date('Y-m-d',strtotime($fromDate));
        else
            $fromDate = '';

        if( $toDate != '' && $toDate != '0000-00-00' && $toDate != '1970-01-01')
            $toDate = date('Y-m-d',strtotime($toDate));
        else
            $toDate = '';

      $products = array();
      $companyRef = $this->companyData->companyRef;
      $this->db->select('date');
      $this->db->from('acct_inventory');
      $this->db->where('companyRef',$companyRef);
      if($fromDate != '' && $toDate != '')
            $this->db->where("acct_inventory.date BETWEEN '$fromDate' AND '$toDate'");
        else if( $fromDate != '' )
            $this->db->where("acct_inventory.date",$fromDate);
        else if( $toDate != '' )
            $this->db->where("acct_inventory.date",$toDate);
        else
            $this->db->where("YEAR(acct_inventory.date)",date('Y'));

        if($searchKey != NULL && $searchKey != '')
        {
          $addDate = date('Y-m-d',strtotime($searchKey));
          $where  = "(acct_inventory.inventory.date LIKE '%$addDate%')";
          $this->db->where($where);
        }

      $this->db->group_by('date');
      $this->db->order_by('date','asc');
      $query    	= $this->db->get();
      $result     = array();
          if($query->num_rows() > 0)
          {
              $result	= $query->result();
              //echo "<pre>"; print_r($result);
              /************ getting expense data start **************/
              foreach( $result as $key => $value)
              {
                  $this->db->select("acct_inventory.*,productName");
                  $this->db->from('acct_inventory');
                  $this->db->join('products','products.productRef = inventory.productRef','left');
                  $this->db->where('acct_inventory.companyRef',$companyRef);
                  $this->db->where('acct_inventory.date',$value->date);
                  $this->db->order_by('date','ASC');
                  $query1    	        = $this->db->get();
                  //echo $this->db->last_query()."<br>";
                        if($query1->num_rows() > 0)
                        {
                          $products[$value->date] = $query1->result();
                        }
              }
         }
         return $products;
    }


}
?>

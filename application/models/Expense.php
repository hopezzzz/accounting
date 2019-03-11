<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $this->loginSessionData   = $this->session->userdata('clientData');
        $this->companyData        = $this->loginSessionData['companyData'];
    }

    function getProCategories($id = 0, $spacing = '') {
      $this->db->select('*');
      $this->db->from('acct_trialBalanceCategories');
      $this->db->where('parent', $id);
      $this->db->where('type', 'expense');
       $output = $this->db->get();
       //echo $this->db->last_query(); die();
       $r = $output->result();
       echo '<pre>';print_r($r);
       $children = array();
       if (count($r) > 0) {
         foreach ($r as $catRef) {
             $children[$catRef->title]['category_name'] = $catRef->title;
             $children[$catRef->title]['categoryID'] = $catRef->categoryID;
             $children[$catRef->title]['child'] = $this->getProCategories($catRef->categoryID);
            }
          }
          print_r($children);
             return $children;
            }


    public function fetchExpenseList($limit, $start, $searchKey = null )
    {
        $reference      = $this->session->userdata('reference');
        $referenceType  = $this->session->userdata('referenceType');
        if( $referenceType != 'creditor')
            $reference     = '';
        /***************** counting records **************** */
        $this->db->select("COUNT(*) AS `numrows`");
        $this->db->from('acct_transactions');
        $this->db->where('transactionType',3);
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        if( $reference != '' )
            $this->db->where('transactions.payeeRef',$reference);
        if($searchKey != NULL && $searchKey != '')
		{
			$addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
			    $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or transactions.vatTotal LIKE '%$searchKey%' or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%' or transactions.paymentMethod LIKE '%$paymentMethod%')";
            else
			    $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.vatTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%')";
			$this->db->where($where);
		}
        $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
        $query1 = $this->db->get();
        $total_rows = $query1->row()->numrows;


        /* * **************** fetching records ******************** */
        $this->db->select("transactions.*,CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) AS payeeName");
        $this->db->from('transactions');
        $this->db->where('transactionType',3);
        $this->db->where('transactions.companyRef',$this->companyData->companyRef);
        if( $reference != '' )
            $this->db->where('transactions.payeeRef',$reference);
        if($searchKey != NULL && $searchKey != '')
        {
            $addDate = date('Y-m-d',strtotime($searchKey));
            $paymentMethod = paymentMethodDecode($searchKey);
            if( $paymentMethod != '' )
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or transactions.vatTotal LIKE '%$searchKey%' or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%' or transactions.paymentMethod LIKE '%$paymentMethod%')";
            else
                $where = "( transactions.invoiceNo LIKE '%$searchKey%' or  transactions.invoiceDate LIKE '%$addDate%' or  transactions.deliveryDate LIKE '%$addDate%' or transactions.subTotal LIKE '%$searchKey%' or transactions.vatTotal LIKE '%$searchKey%' or transactions.grandTotal LIKE '%$searchKey%'  or CONCAT_WS(' ',acct_creditors.title,acct_creditors.firstName,acct_creditors.lastName) LIKE '%$searchKey%' or transactions.createdDate LIKE '%$addDate%')";
            $this->db->where($where);
        }
        $this->db->join('creditors','creditors.creditorRef = transactions.payeeRef','left');
        $this->db->order_by('transactionID', 'Desc');
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
          $this->db->from('acct_transactions');
          $this->db->where('transactionType',3);
          $query        = $this->db->get();
          $fields       = $query->list_fields();

          $this->db->select("acct_transactionItems.*,acct_products.*");
          $this->db->from('acct_transactionItems');
          $this->db->join('acct_products','acct_products.productRef = acct_transactionItems.productRef ','left');
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
        $this->db->select("acct_transactions.*,title,firstName,lastName");
        $this->db->from('acct_transactions');
        $this->db->join('acct_creditors','acct_creditors.creditorRef = acct_transactions.payeeRef ','left');
        $this->db->where('transactionType',3);
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

  public function addnewproduct($param,$productRef){
    $this->loginSessionData   = $this->session->userdata('clientData');
    $this->companyData        = $this->loginSessionData['companyData'];
    $this->db->select('productName,productRef');
    $this->db->from('acct_products');
    $this->db->where('productName',$param);
    $this->db->where('companyRef',$this->companyData->companyRef);
    $query   = $this->db->get();
    $data    = $query->result();
    if ($query->num_rows() == 0) {
        $this->db->set('productRef',$productRef);
        $this->db->set('productName',$param);
        $this->db->set('companyRef',$this->companyData->companyRef);
        $this->db->insert('acct_products');
        if($this->db->affected_rows() > 0)
        {
          $this->db->select('productName,productRef');
          $this->db->from('acct_products');
          $this->db->where('productRef',$productRef);
          $query   = $this->db->get();
          $data    = $query->result();
            if ($query->num_rows() > 0) {
                $response['success'] = true;
                $response['productData'] = $data;
            }else{
              $response['success'] = false;
            }

        }
  }else{
    $response['success'] = false;
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

    public function addNewChildCategories($categoryRef, $subcatName)
    {
      $catRef  = generateRef();
      $this->loginSessionData   = $this->session->userdata('clientData');
      $this->companyData        = $this->loginSessionData['companyData'];
      $this->db->select('categoryID,categoryRef,title');
      $this->db->from('acct_trialBalanceCategories');
      $this->db->where('categoryRef',$categoryRef);
      $query   = $this->db->get();
      $data    = $query->result();
      if( $query->num_rows() > 0 )
      {
        $this->db->select('categoryID,categoryRef,title');
        $this->db->from('acct_trialBalanceCategories');
        $this->db->where('ParentCategoryRef',$categoryRef);
        $this->db->where('title',$subcatName);
        $query1   = $this->db->get();
        $data1    = $query1->result();
          if( $query1->num_rows() > 0 )
          {
            $response['success']  = false;
            $response['category']  = 'children';
            $response['errorMsg'] = "Category Name already exits.";
          }
          else
          {
            $this->db->set('title',$subcatName);
            $this->db->set('categoryRef',$catRef);
            $this->db->set('parent',$data[0]->categoryID);
            $this->db->set('ParentCategoryRef',$data[0]->categoryRef);
            $this->db->set('companyRef',$this->companyData->companyRef);
            $this->db->set('status',1);
            $this->db->set('type','expense');
            $this->db->set('createdDate',date('Y-m-d'));
            $this->db->set('modifiedDate',date('Y-m-d'));
            $this->db->set('addedBy',$this->loginSessionData['clientRef']);
            $this->db->insert('acct_trialBalanceCategories');

            /** response to send */
            $response['success']  = true;
            $response['category']  = 'children';
            $response['subcatName'] = $subcatName;
            $response['subcatRef'] = $catRef;
            $response['parentCatName'] = $data[0]->title;
            $response['parentCatRef'] = $data[0]->categoryRef;
            $response['success_message'] = "Category Name Added successfully.";
        }

      }
      else
      {

        $response['category']  = 'children';
        $response['success']  = false;
        $response['errorMsg'] = "Category Name already exits.";
      }

      return $response;
    }

    public function addNewParentCategories($parentCatName, $childCatName)
    {
      $parentRef  = generateRef();
      $childRef  = generateRef();
      $this->loginSessionData   = $this->session->userdata('clientData');
      $this->companyData        = $this->loginSessionData['companyData'];
      $this->db->select('categoryID,categoryRef,title');
      $this->db->from('acct_trialBalanceCategories');
      $this->db->where('title',$parentCatName);
      $query   = $this->db->get();
      $data    = $query->result();
      if( $query->num_rows() > 0 )
      {
        $response['category']  = 'parent';
        $response['success']  = false;
        $response['errorMsg'] = "Category Name already exits.";
        if(trim($childCatName)!="")
        {
          // Checking Subcatname exits in this category
        $this->db->select('categoryID,categoryRef,title');
        $this->db->from('acct_trialBalanceCategories');
        $this->db->where('ParentCategoryRef',$data[0]->categoryRef);
        $this->db->where('title',$childCatName);
        $query1   = $this->db->get();
        $data1    = $query1->result();
              if( $query1->num_rows() > 0 )
              {
                $response['success']  = false;
                $response['category']  = 'parent';
                $response['parent_errorMsg'] = "Category  already exits.";
                $response['errorMsg'] = "Sub Category already exits.";
                return $response; die;
              }
              else
              {
                $this->db->set('title',$childCatName);
                $this->db->set('categoryRef',$childRef);
                $this->db->set('parent',$data[0]->categoryID);
                $this->db->set('ParentCategoryRef',$data[0]->categoryRef);
                $this->db->set('companyRef',$this->companyData->companyRef);
                $this->db->set('status',1);
                $this->db->set('type','expense');
                $this->db->set('createdDate',date('Y-m-d'));
                $this->db->set('modifiedDate',date('Y-m-d'));
                $this->db->set('addedBy',$this->loginSessionData['clientRef']);
                $this->db->insert('acct_trialBalanceCategories');
                /** response to send */
                $response['success']  = true;
                $response['category']  = 'children';
                $response['subcatName'] = $childCatName;
                $response['subcatRef'] = $childRef;
                $response['parentCatName'] = $data[0]->title;
                $response['parentCatRef'] = $data[0]->categoryRef;
                $response['success_message'] = "Category Added successfully.";
                return $response;
                exit;
              }
        }
        else
        {
            return $response;
            exit;
        }
      }
      else
      {
        $this->db->set('title',$parentCatName);
        $this->db->set('categoryRef',$parentRef);
        $this->db->set('companyRef',$this->companyData->companyRef);
        $this->db->set('status',1);
        $this->db->set('parent',0);
        $this->db->set('type','expense');
        $this->db->set('createdDate',date('Y-m-d'));
        $this->db->set('modifiedDate',date('Y-m-d'));
        $this->db->set('addedBy',$this->loginSessionData['clientRef']);
        $this->db->insert('acct_trialBalanceCategories');
        $lastId =  $this->db->insert_id();
        if($this->db->affected_rows() > 0 )
        {
          /** response to send */
          $response['success']  = true;
          $response['category']  = 'parent';
          $response['parentCatName'] = $parentCatName;
          $response['parentRef'] = $parentRef;
          $response['success_message'] = "Category Added successfully.";

          if(trim($childCatName)!="")
          {
            $this->db->set('title',$childCatName);
            $this->db->set('categoryRef',$childRef);
            $this->db->set('parent',$lastId);
            $this->db->set('ParentCategoryRef',$parentRef);
            $this->db->set('companyRef',$this->companyData->companyRef);
            $this->db->set('status',1);
            $this->db->set('type','expense');
            $this->db->set('createdDate',date('Y-m-d'));
            $this->db->set('modifiedDate',date('Y-m-d'));
            $this->db->set('addedBy',$this->loginSessionData['clientRef']);
            $this->db->insert('acct_trialBalanceCategories');
            /** response to send */
            $response['success']  = true;
            $response['subcatName'] = $childCatName;
            $response['subcatRef'] = $childRef;
          }

        }


      }

      return $response;
    }

    public function getcategorylistByName($detailUpper,$detailLower,$type=null)
    {
        $companyRef = $this->companyData->companyRef;
        $this->db->select("title,categoryRef,ParentCategoryRef,companyRef");
        $this->db->from("trialBalanceCategories");
        if($type !== "all"){
            $this->db->where('type',$type);
            $this->db->where("categoryRef != 'MsVfObrT4PI1QmGV' ");
            $this->db->where("categoryRef != 'aypZV9xC68fPRlYa' ");
        }
        $this->db->where("( companyRef = '$companyRef' OR companyRef = '' )");
        $this->db->where('parent != 0');
        $this->db->where('status', 1);
        $where = "( title LIKE '%$detailUpper%' or  title LIKE '%$detailLower%' )";
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        $result = $query->result_array();
        return $result;
    }
}
?>

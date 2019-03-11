<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Model {
    public function __construct()
	{
        parent::__construct();
        $loginSessionData = $this->session->userdata('clientData');
        $accountantRoutes = array('clients','add-client','update-client','dashboard','update-status','delete-record','client-step-1','client-step-2','logout','settings','unit-of-measurement','add-unit-of-measurement','update-unit-of-measurement','addUnitOfMeasurement');
        $route            = $this->uri->segment(1);
        if( empty($loginSessionData) && $route != 'login' && $route != 'forgotPassword' && $route != 'register' && $route != 'checkemail' && $route != 'registration' && $route != 'registerCompany' && $route != 'resendVerificationEmail' && $route != 'verify-account')
            redirect('login');
        else if( !empty($loginSessionData) && empty($loginSessionData['companyData']) && $route != 'registerCompany' && $route != 'checkemail' && $route != 'resendVerificationEmail' && $route != 'verify-account' && $route != 'register' && $route != 'go-to-company' && $route != 'changePassword' && $route != 'checkOldPassword' )
        {
            if( !in_array($route,$accountantRoutes))
                redirect('dashboard');
        }
        else if( !empty($loginSessionData) && !empty($loginSessionData['companyData']) && ( $route == 'clients' || $route == 'register' ) )
        {
            redirect('dashboard');
        }
    }

	public function getData($table = null ,$where = null ,$select = null )
	{
		if( $table == null )
			return false;
        if( $select != null )
			$this->db->select($select);
		else
			$this->db->select('*');
		if( $where != null )
			$this->db->where($where);
        $query 	= $this->db->get($table);

		$result = array();
		if($query->num_rows() > 0)
			$result = $query->result();
		return $result;
	}


    /******************
        Check column value already exist
    ******************/
	public function checkexist($table,$where, $where_or = null)
	{
        $this->db->from($table);
        if($where_or !="")
        {
            $this->db->where("( companyRef = '".$this->companyData->companyRef."' OR companyRef = '' ) ");
            $this->db->where($where);
        }
        else
        {
            $this->db->where($where);
        }
        $query  = $this->db->get();
		$output = false;
		if($query->num_rows() > 0)
			$output = true;
		return $output;
	}

	public function insert($table,$data)
	{

		$this->db->insert($table,$data);
		$insert_id = $this->db->insert_id();
		if( $insert_id > 0)
			$output = $insert_id;
		else
			$output = '';
		return $output;
	}

	public function update($where,$data,$table)
	{
		$this->db->where($where);
		$this->db->update($table,$data);
		$db_error = $this->db->error();
		if ($db_error['code'] == 0)
			return '1';
		else
			return '0';
	}

	public function insert_batch($table,$data)
	{
		$this->db->insert_batch($table,$data);
		$insert_id = $this->db->insert_id();
		if( $insert_id != 0)
			$output = array (1,$insert_id);
		else
			$output = array (0);
		return $output;
	}

    function getSomeFields( $fields = null, $condition = null,$table = null )
    {
        $this->db->select($fields);
        $this->db->where($condition);
        $query  = $this->db->get($table);
        $result = array();
        if( $query->num_rows() > 0 )
        {
            $result = $query->row();
        }
        //echo $this->db->last_query();die;
        return $result;
    }

    public function delete($recordRef = null, $recordType = null )
    {
        switch ($recordType)
        {
            case 'client':
            {
                $this->db->set('isDeleted',1);
                $this->db->where('clientRef',$recordRef);
                $this->db->update('login');

                $this->db->set('isDeleted',1);
                $this->db->where('clientProfileRef',$recordRef);
                $this->db->update('clientProfile');
                break;
            }
            case 'debtor':
            {
                $this->db->where('debtorRef',$recordRef);
                $this->db->delete('debtors');
                break;
            }
            case 'creditor':
            {
                $this->db->where('creditorRef',$recordRef);
                $this->db->delete('creditors');
                break;
            }
            case 'transaction':
            {
                $this->db->where('transactionRef',$recordRef);
                $this->db->delete('transactions');

                $this->db->where('transactionRef',$recordRef);
                $this->db->delete('transactionItems');

                $this->db->where('transactionRef',$recordRef);
                $this->db->delete('inventory');

                $this->db->where('transactionRef',$recordRef);
                $this->db->delete('payments');

                break;
            }
            case 'bank':
            {
                $this->db->where('bankRef',$recordRef);
                $this->db->delete('acct_banks');
                break;
            }
            case 'loans':
            {
                $this->db->where('loanRef',$recordRef);
                $this->db->delete('acct_loans');

                $this->db->where('transactionRef',$recordRef);
                $this->db->delete('payments');
                break;
            }
            case 'borrowing':
            {
                $this->db->where('loanRef',$recordRef);
                $this->db->delete('acct_loans');

                $this->db->where('transactionRef',$recordRef);
                $this->db->delete('payments');

                break;
            }
            case 'share':
            {
                $this->db->where('shareRef',$recordRef);
                $this->db->delete('acct_shareHolder');
                break;
            }
            case 'borrower':
            {
                $this->db->where('borrowerRef',$recordRef);
                $this->db->delete('borrowers');
                break;
            }

            case 'accounting':
            {
                $this->db->where('categoryRef',$recordRef);
                $this->db->delete('trialBalanceCategories');
                break;
            }
            case 'share-capital':
            {
                $this->db->where('sharecapitalRef',$recordRef);
                $this->db->delete('acct_shareCapital');
                $this->db->where('shareCapitalRef',$recordRef);
                $this->db->delete('shareCapitalitems');
                break;
            }

            case 'journal':
            {
                $this->db->where('journalRef',$recordRef);
                $this->db->delete('journals');

                $this->db->where('journalRef',$recordRef);
                $this->db->delete('journalItems');
                break;
            }
            case 'measurements':
            {
                $this->db->where('typeRef',$recordRef);
                $this->db->delete('acct_measurement');
                break;
            }

            default:
            {
                //return false;
                break;
            }
        }
        $db_error = $this->db->error();
        if ($db_error['code'] == 0)
            return '1';
        else
            return '0';
    }

    public function updateStatus( $ref = null,$type = null,$status = null )
    {
        switch ($type)
        {
            case 'client':
            {
                $this->db->set('status',$status);
                $this->db->where('clientRef',$ref);
                $this->db->update('login');

                $this->db->set('status',$status);
                $this->db->where('clientProfileRef',$ref);
                $this->db->update('clientProfile');

                break;
            }
            case 'debtor':
            {
                $this->db->set('status',$status);
                $this->db->where('debtorRef',$ref);
                $this->db->update('debtors');
                break;
            }
            case 'creditor':
            {
                $this->db->set('status',$status);
                $this->db->where('creditorRef',$ref);
                $this->db->update('creditors');
                break;
            }
            case 'transaction':
            {
                $this->db->set('status',$status);
                $this->db->where('transactionRef',$ref);
                $this->db->update('transactions');
                break;
            }
            case 'bank':
            {
                $this->db->set('status',$status);
                $this->db->where('bankRef',$ref);
                $this->db->update('acct_banks');
                break;
            }
            case 'loans':
            {
                $this->db->set('status',$status);
                $this->db->where('loanRef',$ref);
                $this->db->update('acct_loans');
                break;
            }
            case 'borrowing':
            {
                $this->db->set('status',$status);
                $this->db->where('loanRef',$ref);
                $this->db->update('acct_loans');
                break;
            }
            case 'share':
            {
                $this->db->set('status',$status);
                $this->db->where('shareRef',$ref);
                $this->db->update('acct_shareHolder');
                break;
            }
            case 'borrower':
            {
                $this->db->set('status',$status);
                $this->db->where('borrowerRef',$ref);
                $this->db->update('borrowers');
                break;
            }
            case 'accounting':
            {
                $this->db->set('status',$status);
                $this->db->where('categoryRef',$ref);
                $this->db->update('trialBalanceCategories');
                break;
            }
            case 'share-capital':
            {
                $this->db->set('status',$status);
                $this->db->where('sharecapitalRef',$ref);
                $this->db->update('acct_shareCapital');
                break;
            }
            case 'measurements':
            {
                $this->db->set('status',$status);
                $this->db->where('typeRef',$ref);
                $this->db->update('acct_measurement');
                break;
            }
            default:
            {
                //return false;
                break;
            }
        }
        $db_error = $this->db->error();
        if ($db_error['code'] == 0)
            return '1';
        else
            return '0';
    }


    public function getTransactionTotalAmount( $ref = null,$type = null )
    {
        if( $type == 'transaction' )
        {
            $this->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount");
            $this->db->from('transactions');
            $this->db->where('transactions.companyRef',$this->companyData->companyRef);
            $this->db->where('transactions.paymentMethod',3);
            $this->db->where('transactions.transactionRef',$ref);
            $this->db->group_by('transactions.transactionRef');
            $this->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
            $query     = $this->db->get();
        }
        if( $type == 'loans' || $type == 'borrowing' )
        {
            $this->db->select("acct_loans.amount as totalAmount");
            $this->db->from('loans');
            $this->db->where('loans.companyRef',$this->companyData->companyRef);
            $this->db->where('loans.loanRef',$ref);
            $query     = $this->db->get();
        }
        $response['totalAmount'] = 0;
        $response['success']     = true;
        if( $query->num_rows() > 0 )
        {
            $response['totalAmount'] = $query->row()->totalAmount;
        }
        else
            $response['success']     = false;
        return $response;
    }

    public function getTransactionTotalPaidAmount( $ref = null,$type = null )
    {
        if( $type == 'transaction' )
            $type = 1;
        else if( $type == 'loans' )
            $type = 2;
        else if( $type == 'borrowing' )
            $type = 3;
        $this->db->select("sum(amount) as totalAmount");
        $this->db->from('payments');
        $this->db->where('companyRef',$this->companyData->companyRef);
        $this->db->where('type',$type);
        $this->db->where('transactionRef',$ref);
        $this->db->group_by('transactionRef');
        $query       = $this->db->get();
        $totalAmount = 0;
        if( $query->num_rows() > 0 )
        {
            $totalAmount = $query->row()->totalAmount;
        }
        return $totalAmount;
    }

}
?>

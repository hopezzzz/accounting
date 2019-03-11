<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function phoneFormat($phoneNo = NULL) { //return $phoneNo;
    $phoneNo = str_replace('-', '', $phoneNo);
    $phoneNo = str_replace(' ', '', $phoneNo);
    $len = strlen($phoneNo);
    if ($len > 10) {
        $first = substr($phoneNo, 0, 1);
        $second = substr($phoneNo, 1, 2);
        $third = substr($phoneNo, 3, 2);
        $fourth = substr($phoneNo, 5, 4);
        $fifth = substr($phoneNo, 9, 4);
        $final = $first;
        if ($second)
            $final.= '-' . $second;
        if ($third)
            $final.= '-' . $third;
        if ($fourth)
            $final.= '-' . $fourth;
        if ($fifth)
            $final.= '-' . $fifth;
    }
    else {
        $first = substr($phoneNo, 0, 3);
        $second = substr($phoneNo, 3, 3);
        $third = substr($phoneNo, 6, 4);
        $final = $first;
        if ($second)
            $final.= '-' . $second;
        if ($third)
            $final.= '-' . $third;
    }
    //echo $final;
    return $final;
}

function getEmailTemplate($id = NULL) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where('id', $id);
    $query = $ci->db->get('emailTemplates');
    $result = array();
    if ($query->num_rows() > 0) {
        $result = $query->row_array();
    }
    return $result;
}

function sendEmail($variables, $templateData) {
    $ci = & get_instance();
    $ci->email_var = array(
        'logo' => '<img src="' . $ci->config->item('logo') . '" alt="Logo" >',
        'site_title' => $ci->config->item('site_title'),
        'site_url' => site_url(),
        'copyrightText' => $ci->config->item('copyrightText')
    );
    /*$ci->config_email = Array(
        'protocol' => "smtp",
        'smtp_host' => "ssl://smtp.googlemail.com",
        'smtp_port' => '465',
        'smtp_user' => 'sarvjeet1wayit@gmail.com',
        'smtp_pass' => 'Sarvjeet@786',
        'mailtype' => "html",
        'wordwrap' => TRUE,
        'crlf' => '\r\n',
        'charset' => "utf-8"
    );*/
    $ci->config_email = Array(
        'protocol'  => "ssl",
        'smtp_host' => "mail.1wayit.com",
        'smtp_port' => '25',
        'smtp_user' => 'gurdeep@1wayit.com',
        'smtp_pass' => 'Gurdeep@786',
        'mailtype'  => "html",
        'wordwrap'  => TRUE,
        'crlf'  	=> '\r\n',
        'charset'   => "utf-8"
    );
    $variables = array_merge($variables, $ci->email_var);
   // echo '<pre>'; print_r($variables); die;
    $replacements = array();
    foreach ($variables as $key => $val) {
        $replacements['({' . $key . '})'] = $val;
    }
    $template = preg_replace(array_keys($replacements), array_values($replacements), $templateData['description']);
   //echo '<pre>'; print_r($template); die;
   $ci->email->initialize($ci->config_email);
    $ci->email->set_newline("\r\n");
    $ci->email->from($ci->config->item('emailFrom'),$ci->config->item('emailFromName'));
    $ci->email->to($variables['to']);
    $ci->email->subject($templateData['subject']);
    $ci->email->message($template);
    if ($ci->config->item('replyTo'))
        $ci->email->reply_to($ci->config->item('replyTo'));
   // echo "<pre>";print_r($ci->email);die('lol');
     $ci->email->send();
     $ci->email->print_debugger(); //die;
    return true;
}

function getPagination($url, $perPage, $totalItem = 0, $type, $number) {
    $ci = & get_instance();
    /* Create Pagination links */
    //pagination settings
    $config['base_url'] = $url;
    $config['total_rows'] = $totalItem;
    $config['per_page'] = $perPage;
    $config["uri_segment"] = 3;
    $config['page_query_string'] = TRUE;
    $choice = $config["total_rows"] / $config["per_page"];
    //$config["num_links"] = floor($choice);
    $config["num_links"] = 2;
    //config for bootstrap pagination class integration
    $config['full_tag_open'] = '<ul class="pagination ajax_pagingUL" id="ajax_pagingsearc' . $number . '" rel="' . $type . '">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = false;
    $config['last_link'] = false;
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $ci->pagination->initialize($config);
    return $ci->pagination->create_links();
}

function demoCredentials($projectName = null, $username = null, $password = null, $projectUrl = null, $user_role = null) {
    $ci = & get_instance();

    $config['hostname'] = '166.62.28.127';
    $config['username'] = 'democredentials';
    $config['password'] = 'democredentials';
    $config['database'] = 'democredentials';
    $config['dbdriver'] = 'mysqli';
    $config['dbprefix'] = '';
    $config['pconnect'] = FALSE;
    $config['db_debug'] = TRUE;
    $config['cache_on'] = FALSE;
    $config['cachedir'] = '';
    $config['char_set'] = 'utf8';
    $config['dbcollat'] = 'utf8_general_ci';

    $credentialsDB = $ci->load->database($config, TRUE);

    $credentialsDB->select('*');
    $credentialsDB->where('project_name', $projectName);
    $credentialsDB->where('username', $username);
    $query = $credentialsDB->get('credentials');
    if ($query->num_rows() > 0) {
        $result = $query->row();
        $id = $result->id;

        $credentialsDB->set('password', $password);
        $credentialsDB->set('modified_date', date('Y-m-d'));
        $credentialsDB->set('project_url', $projectUrl);
        $credentialsDB->set('user_role', $user_role);
        $credentialsDB->where('id', $id);
        $credentialsDB->update('credentials');
        return true;
    } else {
        $credentialsDB->set('project_name', $projectName);
        $credentialsDB->set('username', $username);
        $credentialsDB->set('password', $password);
        $credentialsDB->set('project_url', $projectUrl);
        $credentialsDB->set('user_role', $user_role);
        $credentialsDB->set('add_date', date('Y-m-d'));
        $credentialsDB->set('modified_date', date('Y-m-d'));
        $credentialsDB->insert('credentials');
        return true;
    }
    //echo "<pre>";print_r($result);
}

function generateRef()
{
    $length         = 8;
    $randomString   = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    $randomString1  = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    $randomString   = $randomString . $randomString1;
    return $randomString;
}

function randomPassword()
{
    $alphabet       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass           = array(); //remember to declare $pass as an array
    $alphaLength    = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n      = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function getPayeeNamelist($detailUpper,$detailLower,$dataRef = NULL, $tableName = NULL, $userRef)
{
    $ci                     = & get_instance();
    $ci->loginSessionData   = $ci->session->userdata('clientData');
    $ci->companyData        = $ci->loginSessionData['companyData'];
    $ci->db->select("title,firstName,lastName,$dataRef,companyname,email");
    $ci->db->from("$tableName");
    $ci->db->join("acct_company","acct_company.borrowerCompanyRef = $tableName.$userRef",'left');
    $ci->db->where("$tableName.companyRef",$ci->companyData->companyRef);
    $ci->db->group_start();

    $ci->db->like('title', $detailUpper, 'after');
    $ci->db->or_like('title', $detailLower, 'after');
    $ci->db->or_like('title', strtolower($detailLower), 'after');
    $ci->db->or_like('title', strtoupper($detailLower), 'after');
    $ci->db->or_like('title', ucfirst($detailLower), 'after');

    $ci->db->like("CONCAT_WS(' ',title,firstName,lastName)", $detailUpper, 'after');
    $ci->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", $detailLower, 'after');
    $ci->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", strtolower($detailLower), 'after');
    $ci->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", strtoupper($detailLower), 'after');
    $ci->db->or_like("CONCAT_WS(' ',title,firstName,lastName)", ucfirst($detailLower), 'after');

    $ci->db->like('firstName', $detailUpper, 'after');
    $ci->db->or_like('firstName', $detailLower, 'after');
    $ci->db->or_like('firstName', strtolower($detailLower), 'after');
    $ci->db->or_like('firstName', strtoupper($detailLower), 'after');
    $ci->db->or_like('firstName', ucfirst($detailLower), 'after');

    $ci->db->like('lastName', $detailUpper, 'after');
    $ci->db->or_like('lastName', $detailLower, 'after');
    $ci->db->or_like('lastName', strtolower($detailLower), 'after');
    $ci->db->or_like('lastName', strtoupper($detailLower), 'after');
    $ci->db->or_like('lastName', ucfirst($detailLower), 'after');

    $ci->db->like('companyname', $detailUpper, 'after');
    $ci->db->or_like('companyname', $detailLower, 'after');
    $ci->db->or_like('companyname', strtolower($detailLower), 'after');
    $ci->db->or_like('companyname', strtoupper($detailLower), 'after');
    $ci->db->or_like('companyname', ucfirst($detailLower), 'after');

    $ci->db->like('email', $detailUpper, 'after');
    $ci->db->or_like('email', $detailLower, 'after');
    $ci->db->or_like('email', strtolower($detailLower), 'after');
    $ci->db->or_like('email', strtoupper($detailLower), 'after');
    $ci->db->or_like('email', ucfirst($detailLower), 'after');

    $ci->db->group_end();
    $ci->db->where("$tableName.status = 1 ");
    $ci->db->group_by("$dataRef");
    $query = $ci->db->get();
    //echo $ci->db->last_query(); die
    $result = $query->result_array();

    return $result;
}

function generateInvoiceNumber()
{
    $ci = & get_instance();
    $ci->db->select('invoiceNo');
    $ci->db->order_by('invoiceNo','desc');
    $query    		= $ci->db->get('transactions');
    $invoiceNumber  = '';
    if($query->num_rows() > 0)
    {
        $result		    = $query->result();
        $docnumbers		= array();
        foreach( $result as $key=>$val)
        {
          $result = 0;
          $result += substr($val->invoiceNo, 4, strlen($val->invoiceNo));
          if(is_numeric($result))
              $docnumbers[] = $result;
        }
        $maxDocNo	  	  = max($docnumbers);
        $invoiceNumber  = $maxDocNo;
        $len           	= strlen($invoiceNumber);
        $invoiceNumber  = substr($invoiceNumber,0,$len);
        $invoiceNumber  = str_pad($invoiceNumber + 1, 4, 0, STR_PAD_LEFT);
        $invoiceNumber  = 'INV-'.$invoiceNumber;
    }
    else
    {
        $invoiceNumber  = 'INV-0001';
    }
    return $invoiceNumber;
}

function paymentMethodLabel( $paymentMethod = null )
{
    $label = '';
    if( $paymentMethod == 1 )
        $label = 'Cash';
    else if( $paymentMethod == 2 )
        $label = 'Bank';
    else if( $paymentMethod == 3 )
        $label = 'Credit';
    else if( $paymentMethod == 4 )
        $label = 'Debit Card';
    else if( $paymentMethod == 5 )
        $label = 'Cheque';
    return $label;
}
function paymentMethodDecode( $paymentMethod = null )
{
    $label = '';
    if( strtolower($paymentMethod) == 'cash' )
        $label = 1;
    else if( strtolower($paymentMethod) == 'bank' )
        $label = 2;
    else if( strtolower($paymentMethod) == 'credit' )
        $label = 3;
    else if( strtolower($paymentMethod) == 'debit card' )
        $label = 4;
    else if( strtolower($paymentMethod) == 'cheque' )
        $label = 5;
    return $label;
}

function changeDateFormat( $date = null, $format = null )
{
    if( $format == '' || $format == null )
        $format = 'd-m-Y';
    if( $date != '' && $date != '0000-00-00' && $date != '1970-01-01' )
        return $date = date($format,strtotime($date));
    else
        return '';
}


function getTrialBalanceBanksData($companyRef = NULL )
{
    $ci = & get_instance();
    /*********** getting sales bank amount where payment method is bank **************/
    $ci->db->select("transactions.transactionType,banks.bankRef,banks.name as bankName,sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount,( CASE WHEN acct_transactions.transactionType = '2' THEN 'db' ELSE 'db' END) as type");
    $ci->db->from('transactions');
    $ci->db->where('transactions.companyRef',$companyRef);
    $ci->db->where_not_in('transactions.paymentMethod',array('1','3'));
    $ci->db->where('transactions.status',1);
    $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
    $ci->db->where_in('transactions.transactionType',array(2,4));
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
    $ci->db->join('banks','banks.bankRef = transactions.bankRef','inner');
    $query    	= $ci->db->get();
    $salesBank     = array();
    if($query->num_rows() > 0)
    {
        $salesBank = $query->result();
    }
    //echo "sales bank <pre>";print_r($salesBank);
    /********** getting borrowing amount *********/
    $ci->db->select("sum(acct_loans.amount) as totalAmount,banks.bankRef,banks.name as bankName,( CASE WHEN acct_loans.type = '2' THEN 'db' ELSE 'cr' END) as type");
    $ci->db->from('loans');
    $ci->db->where('loans.companyRef',$companyRef);
    $ci->db->where('loans.bankRef!=','');
    $ci->db->where('loans.status',1);
    $ci->db->where("YEAR(acct_loans.date)",date('Y'));
    $ci->db->where('loans.type',2);
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('banks','banks.bankRef = loans.bankRef','inner');
    $query1      = $ci->db->get();
    $borrowings  = array();
    if($query1->num_rows() > 0)
    {
        $borrowings = $query1->result();
    }
    $salesBank  = array_merge($salesBank,$borrowings);

    /*********** getting bank amount from payments received and transaction type is credit and in receive payment method is bank **************/
    $ci->db->select("transactions.transactionType,banks.bankRef,banks.name as bankName,sum(acct_payments.amount) as totalAmount,( CASE WHEN acct_transactions.transactionType = '2' THEN 'db' ELSE 'db' END) as type");
    $ci->db->from('transactions');
    $ci->db->where('transactions.companyRef',$companyRef);
    $ci->db->where('transactions.paymentMethod',3);
    $ci->db->where_in('transactions.transactionType',array(2,4));
    $ci->db->where('payments.paymentMethod',2);
    $ci->db->where('transactions.status',1);
    $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
    $ci->db->join('banks','banks.bankRef = payments.bankRef','inner');
    $query    	= $ci->db->get();
    $salesBank1  = array();
    if($query->num_rows() > 0)
    {
        $salesBank1 = $query->result();
        $salesBank = array_reduce($salesBank1, function ($a, $b)
        {
            isset($a[$b->bankRef]) ? $a[$b->bankRef]->totalAmount += $b->totalAmount : $a[$b->bankRef] = $b;
            return $a;
        });
        $salesBank = array_values($salesBank);
    }
    $salesBank = array_merge($salesBank,$salesBank1);

    /************** getting total amount for loans paid from bank ********/
    $ci->db->select("sum(acct_payments.amount) as totalAmount,banks.bankRef,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'db' ELSE 'db' END) as type");
    $ci->db->from('loans');
    $ci->db->where('loans.companyRef',$companyRef);
    $ci->db->where('loans.status',1);
    $ci->db->where("YEAR(acct_loans.date)",date('Y'));
    $ci->db->where('loans.type',1);
    $ci->db->where('payments.paymentMethod',2);
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
    $ci->db->join('banks','banks.bankRef = payments.bankRef','inner');
    $query    	= $ci->db->get();
    $loansPaidFromBank = array();
    if($query->num_rows() > 0)
    {
        $loansPaidFromBank   = $query->result();
        $salesBank = array_merge($salesBank,$loansPaidFromBank);
        $salesBank = array_reduce($salesBank, function ($a, $b)
        {
            isset($a[$b->bankRef]) ? $a[$b->bankRef]->totalAmount += $b->totalAmount : $a[$b->bankRef] = $b;
            return $a;
        });
        $salesBank = array_values($salesBank);
    }
    /***************** getting sahre capital amount for banks ********/
    $ci->db->select("banks.bankRef,banks.name as bankName,sum(acct_shareCapitalitems.amount) as totalAmount,( CASE WHEN acct_shareCapital.ID != '' THEN 'db' ELSE 'db' END) as type");
    $ci->db->from('shareCapital');
    $ci->db->where('shareCapital.companyRef',$companyRef);
    $ci->db->where('shareCapital.status',1);
    $ci->db->where('shareCapital.paymentMethod',2);
    $ci->db->where("YEAR(acct_shareCapital.Date)",date('Y'));
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('shareCapitalitems','shareCapitalitems.shareCapitalRef = shareCapital.shareCapitalRef','inner');
    $ci->db->join('banks','banks.bankRef = shareCapital.bankRef','inner');
    $query      	        = $ci->db->get();
    $shareCapitalInBank     = array();
    if($query->num_rows() > 0)
    {
        $shareCapitalInBank = $query->result();
        $salesBank = array_merge($salesBank,$shareCapitalInBank);
        $salesBank = array_reduce($salesBank, function ($a, $b)
        {
            isset($a[$b->bankRef]) ? $a[$b->bankRef]->totalAmount += $b->totalAmount : $a[$b->bankRef] = $b;
            return $a;
        });
        $salesBank = array_values($salesBank);
    }

    /********** getting loan given amount *********/
    $ci->db->select("sum(acct_loans.amount) as totalAmount,banks.bankRef,banks.name as bankName,( CASE WHEN acct_loans.type = '1' THEN 'cr' ELSE 'db' END) as type");
    $ci->db->from('loans');
    $ci->db->where('loans.companyRef',$companyRef);
    $ci->db->where('loans.bankRef!=','');
    $ci->db->where('loans.status',1);
    $ci->db->where("YEAR(acct_loans.date)",date('Y'));
    $ci->db->where('loans.type',1);
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('banks','banks.bankRef = loans.bankRef','inner');
    $query1    = $ci->db->get();
    $loans     = array();
    if($query1->num_rows() > 0)
    {
        $loans = $query1->result();
    }
    //echo " loans <pre>";print_r($loans);

    $ci->db->select("transactions.transactionType,banks.bankRef,banks.name as bankName,sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount,( CASE WHEN acct_transactions.transactionType = '1' THEN 'cr' ELSE 'cr' END) as type");
    $ci->db->from('transactions');
    $ci->db->where('transactions.companyRef',$companyRef);
    $ci->db->where_not_in('transactions.paymentMethod',array('1','3'));
    $ci->db->where('transactions.status',1);
    $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
    $ci->db->where_in('transactions.transactionType',array('1','3','5'));
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
    $ci->db->join('banks','banks.bankRef = transactions.bankRef','inner');
    $query    	= $ci->db->get();
    $purchaseExpenseBank     = array();
    if($query->num_rows() > 0)
    {
        $purchaseExpenseBank = $query->result();
    }
    /************** getting total amount for borrowing paid from bank ********/
    $ci->db->select("sum(acct_payments.amount) as totalAmount,banks.bankRef,banks.name as bankName,( CASE WHEN acct_loans.type = '2' THEN 'cr' ELSE 'db' END) as type");
    $ci->db->from('loans');
    $ci->db->where('loans.companyRef',$companyRef);
    $ci->db->where('loans.status',1);
    $ci->db->where("YEAR(acct_loans.date)",date('Y'));
    $ci->db->where('loans.type',2);
    $ci->db->where('payments.paymentMethod',2);
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
    $ci->db->join('banks','banks.bankRef = payments.bankRef','inner');
    $query    	= $ci->db->get();
    $borrowingPaidFromBank = array();
    if($query->num_rows() > 0)
    {
        $borrowingPaidFromBank = $query->result();
        $purchaseExpenseBank = array_merge($purchaseExpenseBank,$borrowingPaidFromBank);
        $purchaseExpenseBank = array_reduce($purchaseExpenseBank, function ($a, $b)
        {
            isset($a[$b->bankRef]) ? $a[$b->bankRef]->totalAmount += $b->totalAmount : $a[$b->bankRef] = $b;
            return $a;
        });
        $purchaseExpenseBank = array_values($purchaseExpenseBank);
    }
    $purchaseExpenseBank = array_merge($purchaseExpenseBank,$loans);

    /*********** getting bank amount from payments received and transaction type is credit and in receive payment method is bank **************/
    $ci->db->select("transactions.transactionType,banks.bankRef,banks.name as bankName,sum(acct_payments.amount) as totalAmount,( CASE WHEN acct_transactions.transactionType = '1' THEN 'cr' ELSE 'cr' END) as type");
    $ci->db->from('transactions');
    $ci->db->where('transactions.companyRef',$companyRef);
    $ci->db->where('transactions.paymentMethod',3);
    $ci->db->where_in('transactions.transactionType',array('1','3','5'));
    $ci->db->where('payments.paymentMethod',2);
    $ci->db->where('transactions.status',1);
    $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
    $ci->db->group_by('banks.bankRef');
    $ci->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
    $ci->db->join('banks','banks.bankRef = payments.bankRef','inner');
    $query    	= $ci->db->get();
    $purchaseExpenseBank1  = array();
    if($query->num_rows() > 0)
    {
        $purchaseExpenseBank1 = $query->result();
        $purchaseExpenseBank = array_merge($purchaseExpenseBank,$purchaseExpenseBank1);
        $purchaseExpenseBank = array_reduce($purchaseExpenseBank, function ($a, $b)
        {
            isset($a[$b->bankRef]) ? $a[$b->bankRef]->totalAmount += $b->totalAmount : $a[$b->bankRef] = $b;
            return $a;
        });
        $purchaseExpenseBank = array_values($purchaseExpenseBank);
    }

    $finalArray = array_merge($salesBank,$purchaseExpenseBank);
    $newArray = array();
    foreach ($finalArray as $key => $value)
    {
        $matchedkey = array_search($value->bankRef, array_column($newArray, 'bankRef'));
        if( $matchedkey === 0 || $matchedkey  > 0)
        {
            if( $newArray[$matchedkey]->type == $value->type )
                $newArray[$matchedkey]->totalAmount = $newArray[$matchedkey]->totalAmount + $value->totalAmount;
            else if( $newArray[$matchedkey]->totalAmount > $value->totalAmount )
            {
                $newArray[$matchedkey]->totalAmount = $newArray[$matchedkey]->totalAmount - $value->totalAmount;
            }
            else if( $newArray[$matchedkey]->totalAmount < $value->totalAmount )
            {
                $newArray[$matchedkey]->totalAmount = $value->totalAmount - $newArray[$matchedkey]->totalAmount;
                $newArray[$matchedkey]->type        = $value->type;
            }
            else if( $newArray[$matchedkey]->totalAmount == $value->totalAmount )
            {
                $newArray[$matchedkey]->totalAmount = $value->totalAmount - $newArray[$matchedkey]->totalAmount;
            }
        }
        else
        {
            $newArray[$key] = $value;
        }
    }
    //echo "<pre>";print_r($newArray);

    return $newArray;
}

function getTrialBalanceData($companyRef = NULL,$parentCategoryRef = null )
{
    $ci = & get_instance();
    $ci->db->select('title,categoryRef');
    $ci->db->from('acct_trialBalanceCategories');
    if( $companyRef != '' )
    {
        $ci->db->where("( companyRef = '$companyRef' OR companyRef = '' )");
    }
    else
        $ci->db->where('companyRef','');
    $ci->db->where('ParentCategoryRef',$parentCategoryRef);
    $ci->db->order_by('title','ASC');
    $query    	= $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->result();
        /************ getting expense data start **************/
        foreach( $result as $key=>$value)
        {
            if( $value->categoryRef == 'R9QEIC6xPgYGuNjQ') // getting vat amount for vat category
            {
                $ci->db->select("sum(acct_transactionItems.vatAmount ) as totalAmount ");
                $ci->db->from('transactionItems');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where_in('transactions.transactionType',array(2,4));
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactions','transactions.transactionRef = transactionItems.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $creditAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $creditAmount = 0;

                $ci->db->select("sum(acct_transactionItems.vatAmount ) as totalAmount ");
                $ci->db->from('transactionItems');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where_in('transactions.transactionType',array('1','3','5'));
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactions','transactions.transactionRef = transactionItems.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query1->num_rows() > 0)
                {
                    $debitAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $debitAmount = 0;

                if( $debitAmount > $creditAmount )
                {
                    $result[$key]->totalAmount = $debitAmount - $creditAmount;
                    $result[$key]->type        = 'db';
                }
                else if( $creditAmount > $debitAmount )
                {
                    $result[$key]->totalAmount =  $creditAmount - $debitAmount;
                    $result[$key]->type        = 'cr';
                }
                else
                {
                    $result[$key]->totalAmount = 0;
                    $result[$key]->type        = 'db';
                }
            }
            else if( $value->categoryRef == 'aW1cjzwHMGLcO9vZ') // getting share capital amount for money received category
            {
                $ci->db->select("sum(acct_shareCapitalitems.amount ) as totalAmount ");
                $ci->db->from('shareCapital');
                $ci->db->where('shareCapital.companyRef',$companyRef);
                $ci->db->where('shareCapital.status',1);
                $ci->db->where("YEAR(acct_shareCapital.Date)",date('Y'));
                $ci->db->group_by('shareCapital.companyRef');
                $ci->db->join('shareCapitalitems','shareCapitalitems.shareCapitalRef = shareCapital.shareCapitalRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                    $result[$key]->type        = 'cr';
                }
                else
                    $result[$key]->totalAmount =  0;
            }
            else if( $value->categoryRef == 'q5rYG6iDglQ0kaMp' ||  $value->categoryRef == 'ONdz9pjalp75rw8G' ) // getting amount for discount paid & commision paid
            {
                if( $value->categoryRef == 'q5rYG6iDglQ0kaMp')
                    $ci->db->select("sum(acct_transactionItems.discountAmountPerItem) as totalAmount");
                if( $value->categoryRef == 'ONdz9pjalp75rw8G')
                    $ci->db->select("sum(acct_transactionItems.commisionAmountPerItem) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',2);
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'db';
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount = 0;

                /************* getting expense discount/commision paid *********/
                $ci->db->select("sum(acct_transactionItems.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',3);
                $ci->db->where('transactionItems.subcategoryRef',$value->categoryRef);
                $ci->db->group_by('transactionItems.subcategoryRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'db';
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $result[$key]->totalAmount + $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
            }
            else if( $value->categoryRef == 'si5n0VopdHLVoB6n' ||  $value->categoryRef == 'FHsacw7pBcHps2Z9' ) // getting amount for commision & discount receive
            {
                if( $value->categoryRef == 'FHsacw7pBcHps2Z9')
                    $ci->db->select("sum(acct_transactionItems.discountAmountPerItem) as totalAmount");
                if( $value->categoryRef == 'si5n0VopdHLVoB6n')
                    $ci->db->select("sum(acct_transactionItems.commisionAmountPerItem) as totalAmount");

                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',1);
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'cr';
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount = 0;
            }
            else if( $value->categoryRef == 'U92h8H3yP2EAxY8r') // getting amount for sale of goods and services
            {
                $ci->db->select("sum(acct_transactionItems.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',2);
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'cr';
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount = 0;
            }
            else if( $value->categoryRef == 'FUXcYlCpKlAp2yGq') // getting amount for sale of goods and services return
            {
                $ci->db->select("sum(acct_transactionItems.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',5);
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'db';
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount = 0;
            }

            else if( $value->categoryRef == 'aypZV9xC68fPRlYa') // getting amount for purchase
            {
                $ci->db->select("sum(acct_transactionItems.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',1);
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'db';
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount = 0;
            }
            else if( $value->categoryRef == 'MsVfObrT4PI1QmGV') // getting amount for purchase return
            {
                $ci->db->select("sum(acct_transactionItems.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactions.transactionType',4);
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'cr';
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount = 0;
            }

            else if( $value->categoryRef == 'k2qhu8UX9r2yfwUE') // getting amount for cash in hand
            {
                $ci->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',1);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where_in('transactions.transactionType',array(2,4));
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                if($query1->num_rows() > 0)
                {
                    $debitAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $debitAmount = 0;


                /*********** getting cash amount from payments received and transaction type is credit  **************/
                $ci->db->select("transactions.transactionType,sum(acct_payments.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',3);
                $ci->db->where_in('transactions.transactionType',array(2,4));
                $ci->db->where('payments.paymentMethod',1);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $debitAmount = $debitAmount + $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                /*********** getting amount from short/long term loans payments received **************/
                $ci->db->select("sum(acct_payments.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',1);
                $ci->db->where('payments.paymentMethod',1);
                $ci->db->group_by('loans.loanType');
                $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $debitAmount = $debitAmount + $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }

                /*********** getting amount from share capital  **************/
                $ci->db->select("sum(acct_shareCapitalitems.amount ) as totalAmount ");
                $ci->db->from('shareCapital');
                $ci->db->where('shareCapital.companyRef',$companyRef);
                $ci->db->where('shareCapital.status',1);
                $ci->db->where('shareCapital.paymentMethod',1);
                $ci->db->where("YEAR(acct_shareCapital.Date)",date('Y'));
                $ci->db->group_by('shareCapital.companyRef');
                $ci->db->join('shareCapitalitems','shareCapitalitems.shareCapitalRef = shareCapital.shareCapitalRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query1->num_rows() > 0)
                {
                    $debitAmount = $debitAmount + $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }

                $ci->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',1);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where_in('transactions.transactionType',array('1','3','5'));
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query1->num_rows() > 0)
                {
                    $creditAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $creditAmount = 0;

                /*********** getting cash amount from payments received and transaction type is credit  **************/
                $ci->db->select("transactions.transactionType,sum(acct_payments.amount) as totalAmount");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',3);
                $ci->db->where_in('transactions.transactionType',array('1','3','5'));
                $ci->db->where('payments.paymentMethod',1);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->group_by('transactions.companyRef');
                $ci->db->join('payments','payments.transactionRef = transactions.transactionRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $creditAmount = $creditAmount + $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }

                /*********** getting amount from short/long term borrowings payments received **************/
                $ci->db->select("sum(acct_payments.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',2);
                $ci->db->where('payments.paymentMethod',1);
                $ci->db->group_by('loans.loanType');
                $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $creditAmount = $creditAmount + $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }

                if( $debitAmount > $creditAmount )
                {
                    $result[$key]->totalAmount = $debitAmount - $creditAmount;
                    $result[$key]->type        = 'db';
                }
                else if( $creditAmount > $debitAmount )
                {
                    $result[$key]->totalAmount =  $creditAmount - $debitAmount;
                    $result[$key]->type        = 'cr';
                }
                else
                {
                    $result[$key]->totalAmount = 0;
                    $result[$key]->type        = 'db';
                }
            }
            else if( $value->categoryRef == 'p96c3k41C4PSJbXL') // getting amount for trade receiveable
            {
                $ci->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount,(SELECT SUM(acct_payments.amount) FROM acct_payments WHERE acct_payments.transactionRef = acct_transactionItems.transactionRef) as paymentRecieved");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',3);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionType',2);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->group_by('transactions.transactionRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	= $ci->db->get();
                $result[$key]->hasTransactions = false;
                $result[$key]->type            = 'db';
                if($query1->num_rows() > 0)
                {
                    $creditData                    = $query1->result();
                    $totalTradeReceiveable = array_sum(array_map(function($creditData)
                    {
                        return $creditData->totalAmount;
                    }, $creditData));
                    $totalPaymentRecieved = array_sum(array_map(function($creditData)
                    {
                        return $creditData->paymentRecieved;
                    }, $creditData));
                    $tradeReceiveable               = $totalTradeReceiveable - $totalPaymentRecieved;
                    $result[$key]->totalAmount      = $tradeReceiveable;
                    $result[$key]->hasTransactions  = true;
                }
                else
                    $result[$key]->totalAmount = 0;

                /********** getting sales return total amount **********/
                $ci->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount,(SELECT SUM(acct_payments.amount) FROM acct_payments WHERE acct_payments.transactionRef = acct_transactionItems.transactionRef) as paymentRecieved");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',3);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionType',5);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->group_by('transactions.transactionRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query1->num_rows() > 0)
                {
                    $creditData                    = $query1->result();
                    $totalTradeReturned1 = array_sum(array_map(function($creditData)
                    {
                        return $creditData->totalAmount;
                    }, $creditData));
                    $totalSaleReturnPaymentRecieved = array_sum(array_map(function($creditData)
                    {
                        return $creditData->paymentRecieved;
                    }, $creditData));
                    $tradeSaleReturned               = $totalTradeReturned1 - $totalSaleReturnPaymentRecieved;
                    if( $result[$key]->totalAmount > $tradeSaleReturned)
                        $result[$key]->totalAmount = $result[$key]->totalAmount - $tradeSaleReturned;
                    else
                    {
                        $result[$key]->totalAmount = $tradeSaleReturned - $result[$key]->totalAmount;
                        $result[$key]->type        = 'cr';
                    }
                    $result[$key]->hasTransactions  = true;
                }
            }
            else if( $value->categoryRef == 'dDoOEeqK6ROYuXLT') // getting amount for trade payable
            {
                $ci->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount,(SELECT SUM(acct_payments.amount) FROM acct_payments WHERE acct_payments.transactionRef = acct_transactionItems.transactionRef) as paymentRecieved");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',3);
                $ci->db->where('transactions.status',1);
                $ci->db->where_in('transactions.transactionType',array('1','3'));
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->group_by('transactions.transactionRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	= $ci->db->get();
                $result[$key]->hasTransactions = false;
                $result[$key]->type            = 'cr';
                if($query1->num_rows() > 0)
                {
                    $creditData                    = $query1->result();
                    $totalTradeReceiveable = array_sum(array_map(function($creditData)
                    {
                        return $creditData->totalAmount;
                    }, $creditData));
                    $totalPaymentRecieved = array_sum(array_map(function($creditData)
                    {
                        return $creditData->paymentRecieved;
                    }, $creditData));
                    $tradeReceiveable               = $totalTradeReceiveable - $totalPaymentRecieved;
                    $result[$key]->totalAmount      = $tradeReceiveable;
                    $result[$key]->hasTransactions  = true;
                }
                else
                    $result[$key]->totalAmount = 0;

                $ci->db->select("sum(acct_transactionItems.amount + acct_transactionItems.vatAmount - acct_transactionItems.discountAmountPerItem - acct_transactionItems.commisionAmountPerItem) as totalAmount,(SELECT SUM(acct_payments.amount) FROM acct_payments WHERE acct_payments.transactionRef = acct_transactionItems.transactionRef) as paymentRecieved");
                $ci->db->from('transactions');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.paymentMethod',3);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionType',4);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->group_by('transactions.transactionRef');
                $ci->db->join('transactionItems','transactionItems.transactionRef = transactions.transactionRef','inner');
                $query1    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query1->num_rows() > 0)
                {
                    $debitData             = $query1->result();
                    $totalTradeReturened = array_sum(array_map(function($debitData)
                    {
                        return $debitData->totalAmount;
                    }, $debitData));
                    $totalReturnedPaymentRecieved = array_sum(array_map(function($debitData)
                    {
                        return $debitData->paymentRecieved;
                    }, $debitData));
                    $tradeReturn                    = $totalTradeReturened - $totalReturnedPaymentRecieved;
                    if( $result[$key]->totalAmount > $tradeReturn)
                        $result[$key]->totalAmount = $result[$key]->totalAmount - $tradeReturn;
                    else
                    {
                        $result[$key]->totalAmount = $tradeReturn - $result[$key]->totalAmount;
                        $result[$key]->type        = 'db';
                    }
                    $result[$key]->hasTransactions  = true;
                }
            }
            else if( $value->categoryRef == 'tuxaCbQdS7eZ3tPy' ) // getting amount for short term borrowings
            {
                $ci->db->select("sum(acct_loans.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',1);
                $ci->db->where('loans.bankRef!=','');
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',2);
                $ci->db->group_by('loans.loanType');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                $result[$key]->type            = 'cr';
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount =  0;

                /*********** getting amount from short term borrowings payments received **************/
                $ci->db->select("sum(acct_payments.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',1);
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',2);
                $ci->db->group_by('loans.loanType');
                $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $result[$key]->totalAmount - $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
            }
            else if( $value->categoryRef == 'kgroNJeY4VUrn0GE' ) // getting amount for long term borrowings
            {
                $ci->db->select("sum(acct_loans.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',2);
                $ci->db->where('loans.bankRef!=','');
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',2);
                $ci->db->group_by('loans.loanType');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                $result[$key]->type            = 'cr';
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount =  0;

                /*********** getting amount from long term borrowings payments received **************/
                $ci->db->select("sum(acct_payments.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',2);
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',2);
                $ci->db->group_by('loans.loanType');
                $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $result[$key]->totalAmount - $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
            }
            else if( $value->categoryRef == 'uyYESIXjZWPFfjkq' ) // getting amount for short term loans
            {
                $ci->db->select("sum(acct_loans.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',1);
                $ci->db->where('loans.bankRef!=','');
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',1);
                $ci->db->group_by('loans.loanType');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                $result[$key]->type            = 'db';
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount =  0;

                /*********** getting amount from short term borrowings payments received **************/
                $ci->db->select("sum(acct_payments.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',1);
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',1);
                $ci->db->group_by('loans.loanType');
                $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $result[$key]->totalAmount - $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
            }
            else if( $value->categoryRef == '1zr97PqolBn1AaPs' ) // getting amount for long term loans
            {
                $ci->db->select("sum(acct_loans.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',2);
                $ci->db->where('loans.bankRef!=','');
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',1);
                $ci->db->group_by('loans.loanType');
                $query1    	        = $ci->db->get();
                $result[$key]->hasTransactions = false;
                $result[$key]->type            = 'db';
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                    $result[$key]->totalAmount =  0;

                /*********** getting amount from short term borrowings payments received **************/
                $ci->db->select("sum(acct_payments.amount) as totalAmount");
                $ci->db->from('loans');
                $ci->db->where('loans.companyRef',$companyRef);
                $ci->db->where('loans.loanType',2);
                $ci->db->where('loans.status',1);
                $ci->db->where("YEAR(acct_loans.date)",date('Y'));
                $ci->db->where('loans.type',1);
                $ci->db->group_by('loans.loanType');
                $ci->db->join('payments','payments.transactionRef = loans.loanRef','inner');
                $query    	= $ci->db->get();
                $result[$key]->hasTransactions = $result[$key]->hasTransactions;
                if($query->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $result[$key]->totalAmount - $query->row()->totalAmount;
                    if($query->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
            }
            else
            {
                $ci->db->select("sum(acct_transactionItems.amount ) as totalAmount ");
                $ci->db->from('transactionItems');
                $ci->db->where('transactions.companyRef',$companyRef);
                $ci->db->where('transactions.status',1);
                $ci->db->where('transactions.transactionType',3);
                $ci->db->where('transactions.transactionYear',date('Y') . '/' . date('Y', strtotime('+1 year')));
                $ci->db->where('transactionItems.subcategoryRef',$value->categoryRef);
                $ci->db->group_by('transactionItems.subcategoryRef');
                $ci->db->join('transactions','transactions.transactionRef = transactionItems.transactionRef','inner');
                $query1    	        = $ci->db->get();
                $result[$key]->type = 'db';
                if($query1->num_rows() > 0)
                {
                    $result[$key]->totalAmount = $query1->row()->totalAmount;
                    if($query1->row()->totalAmount > 0)
                        $result[$key]->hasTransactions = true;
                }
                else
                {
                    $result[$key]->totalAmount = 0;
                    $result[$key]->hasTransactions = false;
                }
            }

            $ci->db->select("journalItems.type,sum(acct_journalItems.amount ) as totalAmount");
            $ci->db->from('journalItems');
            $ci->db->where('journals.companyRef',$ci->companyData->companyRef);
            $ci->db->where("YEAR(date)",date('Y'));
            $ci->db->where('journalItems.subcategoryRef',$value->categoryRef);
            $ci->db->group_by('journalItems.type');
            $ci->db->join('journals','journals.journalRef = journalItems.journalRef','inner');
            $query = $ci->db->get();
            if($query->num_rows() > 0)
            {
                $journalData    = $query->result();
                $journalType    = $journalData[0]->type;
                $journalAmount  = $journalData[0]->totalAmount;
                if($journalAmount > 0)
                    $result[$key]->hasTransactions = true;
                if( isset($journalData[1]) )
                {
                    $journalType1    = $journalData[1]->type;
                    $journalAmount1  = $journalData[1]->totalAmount;
                    if($journalType != $journalType1)
                    {
                        if( $journalAmount > $journalAmount1)
                        {
                            $journalAmount = $journalAmount - $journalAmount1;
                        }
                        else if( $journalAmount < $journalAmount1)
                        {
                            $journalAmount = $journalAmount1 - $journalAmount;
                            $journalType   = $journalType1;
                        }
                        else
                        {
                            $journalAmount = 0;
                        }
                    }
                }
                if( $journalAmount > 0 )
                {
                    if( $result[$key]->type == $journalType )
                    {
                        $result[$key]->totalAmount = $result[$key]->totalAmount +  $journalAmount;
                    }
                    else
                    {
                        if( $result[$key]->totalAmount > $journalAmount )
                        {
                            $result[$key]->totalAmount =  $result[$key]->totalAmount - $journalAmount;
                        }
                        else if( $result[$key]->totalAmount < $journalAmount )
                        {
                            $result[$key]->totalAmount =  $journalAmount - $result[$key]->totalAmount;
                            $result[$key]->type        =  $journalType;
                        }
                        else
                            $result[$key]->totalAmount =  0;
                    }
                }
            }
        }
        /********************* expense data end here ************/

    }
    return $result;
}


function getParentcategories($companyRef = NULL,$fields = null, $type = null )
{
    if( $fields == null )
        $fields = '*';

    $ci = & get_instance();
    $ci->db->select($fields);
    $ci->db->from('acct_trialBalanceCategories');
    if( $companyRef != '' )
    {
        $ci->db->where("( companyRef = '$companyRef' OR companyRef = '' )");
    }
    else
        $ci->db->where('companyRef','');
    if( $type != '' )
        $ci->db->where('type',$type);

    $ci->db->where('parent',0);
    $ci->db->order_by('title','ASC');
    $query    	= $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->result();
    }
    return $result;
}



function getSubcategories($id = NULL)
{
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from('acct_trialBalanceCategories');
    $ci->db->where('parent',$id);
    $ci->db->where('status = 1');
    $ci->db->order_by('parent','ASC');
    $query    	= $ci->db->get();
    //echo $ci->db->last_query(); die;
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->result();
    }
    return $result;
}

function getParentCategoryRef($ref)
{
  $ci = & get_instance();
  $ci->db->select('parent');
  $ci->db->from('acct_trialBalanceCategories');
  $ci->db->where_in('categoryRef',$ref);
  $ci->db->where('type','expense');
  $ci->db->order_by('parent','ASC');
  $query    		= $ci->db->get();
  $result		    = $query->result_array();
  $parentIds = array();
 foreach ($result as $key => $value) {
   $parentIds[] = $value['parent'];
 }
  if($query->num_rows() > 0)
  {
    $ci->db->select('title,categoryRef');
    $ci->db->from('acct_trialBalanceCategories');
    $ci->db->where_in('categoryID',$parentIds);
    $ci->db->where('type','expense');
    $query    		= $ci->db->get();
    $data         = $query->result();
  }
  //print_r($data); die;
  return $data;
}

function getBorrowersCompanies($companyRef = NULL,$fields = NULL, $type)
{
    if($fields == '')
        $fields = '*';
    $ci = & get_instance();
    $ci->db->select($fields);
    $ci->db->from('company');
    $ci->db->where('companyRef',$companyRef);
    $ci->db->where('type',$type);
    $ci->db->order_by('companyname','ASC');
    $query    	= $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->result();
    }
    return $result;
}
function getCategorieslistByName($companyRef = NULL,$param = NULL)
{

    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from('trialBalanceCategories');
    if( $companyRef != '' )
    {
        $ci->db->where("( companyRef = '$companyRef' OR companyRef = '' )");
    }
    else
    {
        $ci->db->where('companyRef','');
    }
    $ci->db->where('type',$param);
    $ci->db->where('parent = 0');
    $ci->db->order_by('categoryID','ASC');
    $query    	= $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->result();
    }
    return $result;
}
function getCategoryId($catref = NULL)
{

    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from('trialBalanceCategories');
    $ci->db->where('categoryRef',$catref);
    $ci->db->order_by('categoryID','ASC');
    $query    	= $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->row();
    }
    return $result;
}
function getCategoriesType()
{

    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from('trialBalanceCategories');
    $ci->db->where('parent = 0');
    $ci->db->where("type != 'balance sheet'");
    $ci->db->order_by('categoryID','ASC');

    $ci->db->group_by("type");
    $query    	= $ci->db->get();
    #echo $ci->db->last_query(); die;
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result1	= $query->result();
    }
    $ci->db->select('*');
    $ci->db->from('trialBalanceCategories');
    $ci->db->where('parent = 0');
    $ci->db->where('type', 'balance sheet');
    $ci->db->group_by('title');
    $ci->db->order_by('categoryID','ASC');
    $query1    	= $ci->db->get();
    //echo $ci->db->last_query();die;
    $result2     = array();
    if($query1->num_rows() > 0)
    {
        $result2	= $query1->result();
    }
    $result = array_merge($result1,$result2);
    return $result;
}
function parentCategoryName($parentRef = null)
{

    $ci = & get_instance();
    $ci->db->select('title');
    $ci->db->from('trialBalanceCategories');
    $ci->db->where('categoryID',$parentRef);
    $ci->db->order_by('categoryID','ASC');
    $ci->db->group_by('type');
    $query    	= $ci->db->get();
  #  echo $ci->db->last_query(); die;
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->result();
    }
    return $result;
}

function getProductNameByRef($ref)
{

    $ci = & get_instance();
    $ci->db->select("productName");
    $ci->db->from('products');
    $ci->db->where('productRef',$ref);
    $query = $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->row();
    }
    return $result;
}

function getCategoryNameByRef($ref)
{

    $ci = & get_instance();
    $ci->db->select("title");
    $ci->db->from('trialBalanceCategories');
    $ci->db->where('categoryRef',$ref);
    $query = $ci->db->get();
    $result     = array();
    if($query->num_rows() > 0)
    {
        $result	= $query->row();
    }
    return $result;
}

function getproductsByName($detailUpper,$detailLower, $tableName = NULL)
{
    $ci                     = & get_instance();
    $ci->loginSessionData   = $ci->session->userdata('clientData');
    $ci->companyData        = $ci->loginSessionData['companyData'];
    $ci->db->select("productRef,productName");
    $ci->db->from("$tableName");
    $ci->db->where('companyRef',$ci->companyData->companyRef);
    $ci->db->group_start();
    $ci->db->like('productName'   , $detailUpper, 'after');
    $ci->db->or_like('productName', $detailLower, 'after');
    $ci->db->or_like('productName', strtolower($detailLower), 'after');
    $ci->db->or_like('productName', strtoupper($detailLower), 'after');
    $ci->db->or_like('productName', ucfirst($detailLower), 'after');
    $ci->db->group_end();
    $ci->db->where('status = 1');
    $query = $ci->db->get();
    $result = $query->result_array();
    return $result;
}


function generateJournalNumber()
{
    $ci = & get_instance();
    $ci->db->select('journalNumber');
    $ci->db->order_by('journalNumber','desc');
    $query    		= $ci->db->get('journals');
    $journalNumber  = '';
    if($query->num_rows() > 0)
    {
        $result		    = $query->result();
        $docnumbers		= array();
        foreach( $result as $key=>$val)
        {
          $result = substr($val->journalNumber,8,strlen($val->journalNumber));
            if(is_numeric($result))
                $docnumbers[] = $result;
        }
        $maxDocNo   	= max($docnumbers);
        $journalNumber  = $maxDocNo;
        $len           	= strlen($journalNumber);
        $journalNumber  = str_pad($journalNumber + 1, 4, 0, STR_PAD_LEFT);
        $journalNumber  = 'JOURNAL-'.$journalNumber;
    }
    else
    {
        $journalNumber  = 'JOURNAL-0001';
    }
    return $journalNumber;
}

function getBanks()
{
    $ci                     = & get_instance();
    $ci->loginSessionData   = $ci->session->userdata('clientData');
    $ci->companyData        = $ci->loginSessionData['companyData'];
    $ci->db->select("bankRef,name");
    $ci->db->from("banks");
    $ci->db->where("status",1);
    $ci->db->where('companyRef',$ci->companyData->companyRef);
    $query = $ci->db->get();
    $result = $query->result();
    return $result;
}
function getQtyTypes()
{
    $ci = & get_instance();
    $ci->loginSessionData   = $ci->session->userdata('clientData');
    $ci->companyData        = $ci->loginSessionData['companyData'];
    $ci->db->select("*");
    $ci->db->from("measurement");
    $ci->db->where("status",1);
    $query = $ci->db->get();
    $result = $query->result();
    return $result;
}
function Inventory($inventoryID,$date,$productRef)
{
  $ci = & get_instance();
  $ci->loginSessionData   = $ci->session->userdata('clientData');
  $ci->companyData        = $ci->loginSessionData['companyData'];
  $ci->db->select("inventory.*,productName");
  $ci->db->from('acct_inventory');
  $ci->db->where('acct_inventory.inventoryID != ',$inventoryID);
  $ci->db->where('acct_inventory.companyRef',$ci->companyData->companyRef);
  $ci->db->where('acct_inventory.date',$date);
  $ci->db->where('acct_inventory.productRef',$productRef);
  $ci->db->join('products','products.productRef = inventory.productRef','left');
  $query = $ci->db->get();
  //echo $ci->db->last_query();die;
  $result = array();
  if ($query->num_rows() > 0)
  {
      $result = $query->result();
  }
  //echo "<pre>";print_r($result);
  return $result;

}
function getLastInventoryMaxId($date)
{
  $ci = & get_instance();
  $ci->loginSessionData   = $ci->session->userdata('clientData');
  $ci->companyData        = $ci->loginSessionData['companyData'];
  $ci->db->select("Max(inventoryID) as inventoryID");
  $ci->db->from('acct_inventory');
  $ci->db->where('acct_inventory.date',$date);
  $ci->db->where('acct_inventory.companyRef',$ci->companyData->companyRef);
  $ci->db->limit(1);
  $query = $ci->db->get();
  //echo $ci->db->last_query();die;
  $result = array();
  if ($query->num_rows() > 0)
  {
      $result = $query->row();
  }
  return $result;
}

function getOpeningStock($itemRef,$productRef,$date,$quantity = null)
{

  $ci = & get_instance();
  $ci->loginSessionData   = $ci->session->userdata('clientData');
  $ci->companyData        = $ci->loginSessionData['companyData'];
  $ci->db->select("quantity,inventoryType,productName,date");
  $ci->db->from('acct_inventory');
  $ci->db->JOIN('products','products.productRef = acct_inventory.productRef','left');
  $ci->db->where('acct_inventory.date',$date);
  $ci->db->where('acct_inventory.itemRef!=',$itemRef);
  $ci->db->where('acct_inventory.productRef',$productRef);
  $ci->db->where('acct_inventory.companyRef',$ci->companyData->companyRef);
  $query = $ci->db->get();
  //echo $ci->db->last_query();die;
  $result = array();
  if ($query->num_rows() > 0)
  {
      $result = $query->result();
  }
  foreach ($result as $key => $value) {
    if ($value->inventoryType == 1)
    {
       $quantity += $value->quantity;
    }
    if ($value->inventoryType == 2)
    {
          $quantity -= $value->quantity;
    }


  }
  return $quantity;
}
function numberFormat($number) {
  if (empty($number))
  {
    return '';
  }
  else
  {
    $number = str_replace('-', '', $number);
    return number_format($number, 2, '.', ',');
  }
}
?>

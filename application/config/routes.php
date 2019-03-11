<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] 	= 'welcome';
$route['404_override'] 			= '';
$route['translate_uri_dashes']  = FALSE;
$route['dashboard'] 			= 'welcome/index';
$route['add-client'] 			= 'welcome/signUp';
$route['client-step-1'] 		= 'welcome/stepOne';
$route['client-step-2'] 		= 'welcome/stepTwo';
$route['clients'] 				= 'welcome/clients';
$route['clients/(:num)']		= 'welcome/clients/$1';
$route['update-client/(:any)']	= 'welcome/updateClient/$1';
$route['delete-record']			= 'welcome/deleteRecord';
$route['update-status']			= 'welcome/updateStatus';
$route['go-to-company/(:any)']		= 'welcome/makeCompanySession/$1';
$route['destroy-company-session']	= 'welcome/destroyCompanySession';
$route['show-records-by-reference']	= 'welcome/makeReferenceSessions';
$route['reset-records-by-reference']= 'welcome/destroyReferenceSessions';


$route['transactions'] 			  = 'CommonController/purchaseNExpenses';
$route['loans-advances']		  = 'CommonController/loansNadvances';

$route['default_controller'] 	  = 'LoginController/login';
$route['login'] 			  	  = 'LoginController/login';
$route['register'] 				  = 'LoginController/register';
$route['checkemail'] 			  = 'LoginController/checkemail';
$route['registration']	 		  = 'LoginController/registration';
$route['verify-account/(:any)']   = 'LoginController/verifyAccount/$1';
$route['register2'] 			  = 'LoginController/register2';
$route['resendVerificationEmail'] = 'LoginController/resendVerificationEmail';


$route['registerCompany'] 	= 'LoginController/registerCompany';
$route['forgotPassword']  	= 'LoginController/forgotPassword';

$route['profile'] 			= 'LoginController/profile';
$route['checkOldPassword'] 	= 'LoginController/checkOldPassword';
$route['changePassword'] 	= 'LoginController/changePassword';

$route['logout'] 			= 'LoginController/logout';


$route['debtors'] 			= 'DebtorController/debtors';
$route['add-debtor'] 		= 'DebtorController/addDebtor';
$route['addDebtorAjax'] 	= 'DebtorController/addDebtorAjax';

$route['update-debtor/(:any)'] = 'DebtorController/updatedebtor/$1';

$route['creditors'] 		= 'CreditorController/creditors';
$route['add-creditor'] 		= 'CreditorController/addCreditor';
$route['addCreditorAjax'] 	= 'CreditorController/addCreditorAjax';
$route['update-creditor/(:any)'] 	= 'CreditorController/updatecreditor/$1';

/** Code Pardeep Dhiman 3-OCT-2017 **/
$route['purchase'] = 'PurchaseController/purchase';
$route['update-purchase/(:any)'] = 'PurchaseController/updatepurchase/$1';
$route['add-purchase'] = 'PurchaseController/addPurchase';
$route['getcreditorlist'] = 'PurchaseController/getcreditorList';
$route['addpurchaseajax'] = 'PurchaseController/addpurchaseajax';

/********** Sales Routes **********/
$route['sales'] = 'SalesController/sales';
$route['add-sale'] = 'SalesController/Addsale';
$route['getDebitorList'] = 'SalesController/getDebitorList';
$route['update-sale/(:any)'] = 'SalesController/updatesales/$1';

/* Add New productajax */
$route['ajaxaddnewproduct'] = 'PurchaseController/ajaxaddnewproduct';
$route['getproductslist'] = 'PurchaseController/getproductslist';



$route['addtransactionajax'] = 'CommonController/addtransactionajax';
$route['get-pending-amount'] = 'CommonController/getPendingAmount';
$route['mark-as-paid']       = 'CommonController/markAsPaid';


$route['expense'] = 'ExpenseController/expense';
$route['update-expense/(:any)'] = 'ExpenseController/updateexpense/$1';
$route['add-expense'] = 'ExpenseController/addExpense';
$route['addexpenseajax'] = 'ExpenseController/addexpenseajax';
$route['add-categories'] = 'ExpenseController/addCategories';
$route['getcategorylist'] = 'ExpenseController/getcategorylist';
//$route['ajaxaddnewproduct'] = 'ExpenseController/ajaxaddnewproduct';


/** Routes For Bank Management Modudle **/
$route['bank'] = 'BankController/bank';
$route['update-bank/(:any)'] = 'BankController/updateBank/$1';
$route['add-bank'] = 'BankController/addBank';
$route['ajaxaddbank'] = 'BankController/ajaxaddbank';
$route['addNewBank'] = 'BankController/addNewBank';

/** Routes for Borrowers Management **/
$route['borrowers'] 			        = 'BorrowersController/index';
$route['lenders'] 			          = 'BorrowersController/index';
$route['update-borrower/(:any)']  = 'BorrowersController/updateBorrower/$1';
$route['add-borrower'] 			      = 'BorrowersController/addBorrower';
$route['add-lender'] 			        = 'BorrowersController/addBorrower';
$route['update-lender/(:any)']    = 'BorrowersController/updateBorrower/$1';
$route['ajaxaddborrower'] 		    = 'BorrowersController/addBorrowerAjax';

/** Routes for Borrowings Management **/
$route['borrowerList'] = 'BorrowingController/borrowerList';

$route['loans'] = 'BorrowingController/loans';
$route['update-loan/(:any)'] = 'BorrowingController/updateLoan/$1';
$route['add-loans'] = 'BorrowingController/addLoans';
$route['ajaxaddloan'] = 'BorrowingController/ajaxaddloan';


$route['borrowings'] = 'BorrowingController/borrowings';
$route['update-borrowing/(:any)'] = 'BorrowingController/updateBorrowing/$1';
$route['add-borrowing'] = 'BorrowingController/addBorrowing';
$route['ajaxaddloan'] = 'BorrowingController/ajaxaddloan';


/** Routes for Share holder **/
$route['share'] = 'ShareController/share';
$route['update-share/(:any)'] = 'ShareController/updateShares/$1';
$route['add-share'] = 'ShareController/addShare';
$route['addshareAjax'] = 'ShareController/addshareAjax';


/** Routes for Share capital **/
$route['getShareHolderlist'] = 'ShareController/getShareHolderlist';
$route['share-capital'] = 'ShareController/shareCapital';
$route['update-capital/(:any)'] = 'ShareController/updateshareCapital/$1';
$route['add-share-capital'] = 'ShareController/addCapitalShare';
$route['addsharecapitalAjax'] = 'ShareController/addshareCapitalAjax';


/** Routes for journal entry **/
$route['journal'] 				           = 'JournalController/index';
$route['update-journal/(:any)']      = 'JournalController/updatepurchase/$1';
$route['add-journal'] 			         = 'JournalController/addJournal';
$route['save-journal'] 			         = 'JournalController/saveJournal';

/** Routes for accounting entry **/
$route['accounting'] 				         = 'AccountingController/index';
$route['update-accounting/(:any)']   = 'AccountingController/updateAccounting/$1';
$route['add-accounting'] 			       = 'AccountingController/addAccounting';
$route['ajaxaddaccounting'] 			   = 'AccountingController/ajaxaddaccounting';
$route['updateAccountingAjax'] 			 = 'AccountingController/updateAccountingAjax';
$route['getCategories'] 			       = 'AccountingController/getCategories';
$route['getTransactionlist'] 			   = 'AccountingController/getTransactionlist';
$route['deleteTransactions'] 			   = 'AccountingController/deleteTransactions';

/** Routes for reports **/
$route['reports'] 			             = 'ReportsController/index';
$route['trial-balance']		             = 'ReportsController/trialBalance';
$route['profit-loss']		             = 'ReportsController/profitLoss';

/** Routes for bank and cash Transactions **/
$route['general-ledger'] 			       = 'ReportsController/GeneralLedger';
$route['banktransaction'] 			     = 'ReportsController/banktransaction';

/** Settings Root **/
$route['settings'] 	                 = 'SettingController/settings';
$route['unit-of-measurement'] 	     = 'SettingController/index';
$route['add-unit-of-measurement'] 	 = 'SettingController/addMeasurement';
$route['addUnitOfMeasurement']       = 'SettingController/addUnitOfMeasurement';
$route['update-unit-of-measurement/(:any)'] = 'SettingController/updateMeasurement/$1';

/** Inventory Management routes */
$route['inventory'] = 'InventoryController/inventory';

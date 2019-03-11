<?php
    $this->loginSessionData   = $this->session->userdata('clientData');
    $this->companyData        = $this->loginSessionData['companyData'];
    $trialBalanceCategories  = array();
    $trialBalanceCategories[0] = array('name'=>'Income','type'=>'income');
    $trialBalanceCategories[1] = array('name'=>'Expense','type'=>'expense');
    $trialBalanceCategories[2] = array('name'=>'Equity and Liability','type'=>'Equity and Liability');
    $trialBalanceCategories[3] = array('name'=>'Assets','type'=>'Assets');

    $trialBalanceCategories[0]['LinkedAccouts'] = getParentcategories($this->companyData->companyRef,'title,categoryRef', 'income' );
    $trialBalanceCategories[1]['LinkedAccouts'] = getParentcategories($this->companyData->companyRef,'title,categoryRef', 'expense' );
    $trialBalanceCategories[2]['LinkedAccouts'] = array();
    $Equity              = new stdClass();
    $Equity->title       = 'Share Capital';
    $Equity->categoryRef = 'Wndasdzxsdsdea3';
    $trialBalanceCategories[2]['LinkedAccouts'][0] = $Equity;
    $Equity              = new stdClass();
    $Equity->title       = 'Non Current Liabilities';
    $Equity->categoryRef = 'Qwertffssyuiop5';
    $trialBalanceCategories[2]['LinkedAccouts'][1] = $Equity;

    $Equity              = new stdClass();
    $Equity->title       = 'Current Liabilities';
    $Equity->categoryRef = 'Asdsfgffhjkslpii4';
    $trialBalanceCategories[2]['LinkedAccouts'][2] = $Equity;

    $Assets              = new stdClass();
    $Assets->title       = 'Non Current Assests';
    $Assets->categoryRef = 'Qsdfwertyuop5rr';
    $trialBalanceCategories[3]['LinkedAccouts'][0] = $Assets;

    $Assets              = new stdClass();
    $Assets->title       = 'Non Current Investment';
    $Assets->categoryRef = 'Asdfghjklffgdii44';
    $trialBalanceCategories[3]['LinkedAccouts'][1] = $Assets;

    $Assets              = new stdClass();
    $Assets->title       = 'Current Assets';
    $Assets->categoryRef = 'Qwertysuiopf5rr';
    $trialBalanceCategories[3]['LinkedAccouts'][2] = $Assets;

?>
<style>
.table-hover, tbody, td{
    padding-bottom: 2px !important;
    padding-top: 2px !important;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?> <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!--div class="box-header" style="margin-top:10px">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                        <div class="box-tools col-md-8">
                            <div class="col-md-3 text-right">
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="fromDate" name="fromDate"  class="datepicker form-control pull-right" placeholder="From Date">
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="toDate" name="toDate" class="datepicker form-control pull-right" placeholder="To Date">
                            </div>
                            <div class="input-group col-md-3 pull-right">
                                <input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search by reference">
								<div class="input-group-btn">
									<button data-url="<?php echo site_url('trial-balance');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
                            </div>
                        </div>
                    </div>
                    <br-->
                    <div id="tableData">
                        <div class="box-body table-responsive no-padding">
                          <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="60%">Account</th>
                                        <th width="20%">Debit</th>
                                        <th width="20%">Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $grandTotalDebit = $grandTotalCredit = 0;
                                        foreach ($trialBalanceCategories as $keyyyy => $cat)
                                        {
                                            $showParent      = false;
                                            $isParentShow    = 0;
                                            foreach ($cat['LinkedAccouts'] as $key => $linkedAccount)
                                            {
                                                $showLinkedAccount      = false;
                                                $isLinkedAccountShow    = 0;
                                                $subcategories = getTrialBalanceData($this->companyData->companyRef,$linkedAccount->categoryRef );
                                                //echo "<pre>";print_r($subcategories);
                                                if( !empty($subcategories))
                                                {
                                                    foreach ($subcategories as $keyy => $subcategory)
                                                    {
                                                        if( !$subcategory->hasTransactions )
                                                            continue;
                                                        if( $subcategory->hasTransactions  )
                                                        {
                                                            $showParent = $showLinkedAccount = true;
                                                        }
                                                        if( $showParent && $isParentShow == 0 )
                                                        { ?>
                                                            <tr class="trial-balance-category-type">
                                                                <td><strong><?php echo ucfirst($cat['name']);?></strong></td>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                <?php       $isParentShow = 1 ;
                                                        }
                                                        if( $showLinkedAccount && $isLinkedAccountShow == 0 )
                                                        { ?>
                                                            <tr class="trial-balance-sub-category-type">
                                                                <td class="td-padding-left-25"><strong><?php echo ucfirst($linkedAccount->title);?></strong></td>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                <?php       $isLinkedAccountShow = 1 ;
                                                        } ?>
                                                        <tr class="trial-balance-sub-category-type">
                                                            <td class="td-padding-left-50"><?php echo ucfirst($subcategory->title);?></td>
                                                            <td>
                                                                <?php
                                                                    if( $subcategory->type == 'db' )
                                                                    {
                                                                        echo '<a class="mouserpointer generalDetailAnchor" data-ref="'.$subcategory->categoryRef.'">'.number_format($subcategory->totalAmount,2).'</a>';
                                                                        $grandTotalDebit =  $grandTotalDebit + $subcategory->totalAmount;
                                                                    } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    if( $subcategory->type == 'cr' )
                                                                    {
                                                                        echo '<a class="mouserpointer generalDetailAnchor" data-ref="'.$subcategory->categoryRef.'">'.number_format($subcategory->totalAmount,2).'</a>';
                                                                        $grandTotalCredit =  $grandTotalCredit + $subcategory->totalAmount;
                                                                    } ?>
                                                            </td>
                                                        </tr>
                                        <?php       }
                                                }
                                            }
                                        }
                                        $banks = getTrialBalanceBanksData($this->companyData->companyRef);
                                        if( !empty($banks))
                                        {
                                            foreach ($banks as $keyy => $valuee)
                                            {
                                                if( $valuee->totalAmount <= 0 )
                                                    continue;
                                                ?>
                                                <tr class="trial-balance-sub-category-type">
                                                    <td class="td-padding-left-50"><?php echo ucfirst($valuee->bankName).' ( Bank )';?></td>
                                                    <td>
                                                        <?php
                                                            if( $valuee->type == 'db' )
                                                            {
                                                                echo '<a class="mouserpointer generalDetailAnchor" data-ref="'.$valuee->bankRef.'">'.number_format($valuee->totalAmount,2).'</a>';
                                                                $grandTotalDebit =  $grandTotalDebit + $valuee->totalAmount;
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if( $valuee->type == 'cr' )
                                                            {
                                                                echo '<a class="mouserpointer generalDetailAnchor" data-ref="'.$valuee->bankRef.'">'.number_format($valuee->totalAmount,2).'</a>';
                                                                $grandTotalCredit =  $grandTotalCredit + $valuee->totalAmount;
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                    <?php   }
                                        }
                                    ?>
                                    <tr class="trial-balance-category-type">
                                        <td class="pull-right"><strong>Total</strong></td>
                                        <td><?php echo number_format($grandTotalDebit,2);?></td>
                                        <td><?php echo number_format($grandTotalCredit,2);?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        jQuery(document).on('click','.generalDetailAnchor',function()
        {
            var ref = $(this).attr('data-ref');
            if( ref == '' || ref == undefined )
            {
                $.toast({
                    heading             : 'Error',
                    text                : 'Something went wrong. Please try again.',
                    loader              : true,
                    loaderBg            : '#fff',
                    showHideTransition  : 'fade',
                    icon                : 'error',
                    hideAfter           : 2000,
                    position            : 'top-right'
                });
                localStorage.setItem('trialBalanceCategoryRef','');
            }
            else
            {
                localStorage.setItem('trialBalanceCategoryRef',ref);
                window.open(site_url+'general-ledger/', '_blank');
            }
        });
    });

</script>

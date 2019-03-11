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
                    <div class="box-header" style="margin-top:10px">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <div class="col-md-4 text-right"></div>
                            <div class="col-md-2 text-right">
                                <input type="text" class="form-control datepicker" readonly id="fromDate" name="date-from" placeholder="Date From" value="">
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" class="form-control datepicker" readonly id="toDate" name="date-to" placeholder="Date To" value="">
                            </div>
                            <div class="col-md-4 pull-right">
                                <div class="no-padding col-md-9">
                                    <select id="searchKey" name="subcategoryRef[]" class="form-control">
                                        <option value=""> Select Category </option>
                                        <?php if(!empty($parentCats)) {
                                            foreach($parentCats as $keey=>$parentCat){?>
                                                <optgroup value="<?php echo ucfirst($parentCat->categoryRef);?>" label="<?php echo ucfirst($parentCat->title);?>">
                                                    <?php $subCategories = getSubcategories($parentCat->categoryID);
                                                    if( !empty($subCategories)){
                                                        foreach ($subCategories as $keyyyy => $subCategory) {?>
                                                            <option data-parentRef="<?php echo $subCategory->ParentCategoryRef?>" value="<?php echo $subCategory->categoryRef;?>"><?php echo ucfirst($subCategory->title);?></option>
                                                <?php   }
                                                    } ?>
                                                </optgroup>
                                        <?php   } } ?>
                                        <optgroup label="Bank Accounts">
                                            <?php $banks = getBanks();
                                            foreach ($banks as  $bankValue) {?>
                                                <option value="<?php echo $bankValue->bankRef;?>"> <?php echo $bankValue->name; ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-3">
                					<div class="input-group-btn">
                						<button data-url="<?php echo site_url('general-ledger');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
                					</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="tableData">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Reference Name</th>
                                    <th>Payment Method</th>
                                    <th>Account Name</th>
                                    <th>Transactions Type</th>
                                    <th>Invoice Date</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
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
        var trialBalanceCategoryRef = localStorage.getItem('trialBalanceCategoryRef');
        if( trialBalanceCategoryRef != '' && trialBalanceCategoryRef != undefined )
        {
            $('#searchKey').val(trialBalanceCategoryRef);
            $('#tableSearchBtn').trigger('click');
        }
        jQuery(document).on('change','#searchKey',function()
        {
            var ref = $(this).val();
            localStorage.setItem('trialBalanceCategoryRef',ref);
            $('#tableSearchBtn').trigger('click');
        });
        jQuery(document).on('click','.session',function()
        {
            $.ajax({
                type    : "POST",
                url     : site_url + 'banktransaction',
                data    : { 'value' : true },
                success : function (response)
                {
                }
            });
        });

    });

</script>

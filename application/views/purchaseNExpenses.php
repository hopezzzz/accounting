<div class="content-wrapper">
    <section class="content-header">
        <h1>&nbsp;</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#Purchases" data-toggle="tab">Purchases</a></li>
                        <li><a href="#Expenses" data-toggle="tab">Expenses</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="Purchases">
                            <div class="box">
                                <div class="box-header" style="margin-top:10px">
                                    <h3 class="box-title"></h3>
                                    <div class="box-tools col-md-8">
                                        <div class="col-sm-6 text-right">
                                            <a data-url="<?php echo site_url('purchase');?>" class="resetshowRecordsByRefenence btn btn-success"> Reset</a>
                                        </div>
                                        <div class="input-group col-sm-6 pull-right">
                                            <input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
            								<div class="input-group-btn">
            									<button data-url="<?php echo site_url('purchase');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
            								</div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="tableData">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="Expenses">
                            <div class="box">
                                <div class="box-header" style="margin-top:10px">
                                    <div class="box-tools col-md-8">
                                        <div class="col-sm-6 text-right">
                                            <a data-url="<?php echo site_url('expense');?>" class="resetshowRecordsByRefenence btn btn-success"> Reset</a>
                                        </div>
                                        <div class="input-group col-md-6 pull-right">
                                            <input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
            								<div class="input-group-btn">
            									<button data-url="<?php echo site_url('expense');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
            								</div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="tableData">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span id="pageType" data-container="#Purchases"></span>
    </section>
</div>
<script>
$(document).ready(function ()
{
    $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e)
    {
       var href = $(e.target).attr("href");
       $('#pageType').attr('data-container',href);
    })
    getTransactions(site_url+'purchase','Purchases')
    getTransactions(site_url+'expense','Expenses')
});

function getTransactions(url,container)
{
    $.ajax({
        type	 : "POST",
        dataType : "json",
        data	 : {'searchKey':'','page':1},
        url		 : url,
        beforeSend  : function () {
            $(".loader_div").show();
        },
        complete: function () {
            $(".loader_div").hide();
        },
        success: function(response)
        {
            $("#"+container).find('#tableData').html(response.html);
        },
        error:function(response){
            $.toast({
                heading             : 'Error',
                text                : 'Connection Error.',
                loader              : true,
                loaderBg            : '#fff',
                showHideTransition  : 'fade',
                icon                : 'error',
                hideAfter           : 2000,
                position            : 'top-right'
            });
        }
    });
}
</script>

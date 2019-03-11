<?php $companyData = $this->companyData->companyRef; ?>
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
                        <!--h3 class="box-title"><?php echo $title; ?></h3-->
                        <div class="box-tools">

                          <div class="col-sm-8 text-right">
                            <a href="<?php echo site_url();?>add-accounting" class="btn btn-success"> Add Chart of account </a>
                          </div>
                            <div class="col-md-4 pull-right">
                            <div class="input-group input-group-sm col-md-12">
                                <input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button data-url="<?php echo site_url('accounting');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                            </div>
                        </div>
                         </div>
                    </div>
                    <br/>
                    <div id="tableData">
                        <div class="box-body table-responsive no-padding">
                          <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Parent Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php //echo "<pre>"; print_r($records); die; ?>
                                    <?php $i = 0; if (!empty($records)) {
                                        foreach ($records as $key => $value) { ?>
                                            <tr id="accounting_<?php echo $value->categoryRef;?>">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo ucfirst($value->title); ?></td>
                                                <td><?php echo ucfirst($value->type); ?></td>
                                                <td><?php $category = parentCategoryName($value->parent); echo $category[$i]->title; ?></td>

                                                  <td class="statusTd"><?php if ($value->status == 0) {
                                                        echo '<span class="label label-warning">Inactive</span>';
                                                    } else {
                                                        echo '<span class="label label-success">Active</span>';
                                                    } ?></td>

                                                  <td>
                                                    <?php if ($companyData == $value->companyRef ) { ?>

                                                      <div class="btn-group">
                                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                              <span class="caret"></span>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                              <li><a href="<?php echo site_url('update-accounting/'.$value->categoryRef);?>">Update</a></li>
          						                                        <li><a href="javascript:void(0);" data-status="<?php echo $value->status;?>" class="updateAccounting" data-name="<?php echo ucfirst($value->title);?>" data-type="accounting" data-ref="<?php echo $value->categoryRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                                          </ul>
                                                      </div>
                                                    <?php } ?>
                                                  </td>
                                            </tr>
                                        <?php }
                                    }
                                    else
                                    { ?>
                                        <tr><td align="center" colspan="13">No records found.</td></tr>
                              <?php   } ?>
                                </tbody>
                              </table>

                        </div>
                        <div class="box-footer clearfix">
                            <?php echo $paginationLinks; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="confirm-status-update-modal-chart">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <p align="center"><img src="<?php echo site_url('assets/images/info.png');?>" /></p>
                <p align="center"> Are you sure you want to make <span class="statusLabel"></span> ?</p>
                <p id="alt-text" align="center">These are the transactions under this Category select to delete items.</p>
                <br>
                <?php echo form_open('deleteTransactions', array('id' => 'delete-chart-form', 'class' => '')); ?>
                <div class="box-body table-responsive no-padding" id="itemsTable">
                  <div class="table-data-loader text-center" style="display: none;">
                  	<div class="loader" ></div>
                  </div>
                <table id="tabelData" class="table table-hover">
                  <th>#</th>
                  <th>Category Name</th>
                  <th>Type</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Created Date</th>
                  <tbody class="tableData">

                  </tbody>
                </table>
            </div>
          </div>
            <div class="modal-footer">
                <!-- <input type="hidden" class="selectedjournalitemRef" value="">
                <input type="hidden" class="selectedTransactionitemRef" value=""> -->
                <input type="hidden" class="status" name="status" value="">
                <input type="hidden" class="categoryRef" name="categoryRef" value="0">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-success updateChartAccount">Yes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
/** Variable for assign refIds **/
/** Variable for assign refIds **/
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
/******************/
jQuery(document).on('click', '.removeLayer', function () {
//    var itemRef   =   jQuery($(this)).closest('tr').find('.journalitemRef:checked').val();
    var journalcategories = '';
    var transactioncategories = '';
    jQuery(".journalitemRef:checked").each(function () {
            journalcategories += $(this).val()+',';
    });
    jQuery(".transactionRef:checked").each(function () {
            transactioncategories += $(this).val()+',';
    });
    jQuery('.selectedjournalitemRef').val(journalcategories);
    jQuery('.selectedTransactionitemRef').val(transactioncategories);

});

$(document).on('click', '.updateAccounting', function(event)
{
  jQuery('#alt-text').hide();
  jQuery('#itemsTable').hide();
  var name 	= $(this).attr('data-name');
  var ref  	= $(this).attr('data-ref');
  var type 	= $(this).attr('data-type');
  var status 	= $(this).attr('data-status');
  jQuery('.categoryRef').val(ref);
  jQuery('.status').val(status);
  $.ajax({
      type: "POST",
      url: site_url + 'getTransactionlist',
      data: {'subcategoryRef' : ref},
      dataType: 'json',
      beforeSend  : function () {
         $(".table-data-loader").show();
      },
      complete: function () {
         $(".table-data-loader").hide();
      },
      success: function (response) {
        var toAppend = '';
        if(response.transaction.length || response.journal.length !=0)
        {

            jQuery('#alt-text').show();
            jQuery('#itemsTable').show();
        }
        else
        {
          jQuery('#alt-text').hide();
          jQuery('#itemsTable').hide();
        }
            var transactionDate1 = '';
            var transactionDate = '';
            for (var i = 0; i < response.transaction.length; i++) {
        			transactionDate = new Date(response.transaction[i].createdDate);
              var totalAmount = parseFloat(response.transaction[i].amount) + parseFloat(response.transaction[i].vatAmount);
              toAppend    += '<tr id='+response.transaction[i].transactionRef+'><td><input type="checkbox" name="expense[]" class="checkbox removeLayer transactionRef" value="'+response.transaction[i].itemRef+'"></td><td><a href="<?php echo site_url('update-expense')?>/'+response.transaction[i].transactionRef+'" target="_blank">'+response.transaction[i].subcategory+'</a></td><td><span class="label label-primary">Expense</td></td><td>'+totalAmount+'</td><td></td><td>'+transactionDate.getDate()+ ' '+monthNames[transactionDate.getMonth()] +' '+transactionDate.getFullYear()+'</td></tr>';
            }
            var journalDate = '';
            for (var j = 0; j < response.journal.length; j++) {
              journalDate = new Date(response.journal[j].createdDate);
              if(response.journal[j].type == 'db')
              {
                var dbamount = response.journal[j].amount;
                var cramount = '';
              }
              else if(response.journal[j].type == 'cr')
              {
                var cramount = response.journal[j].amount;
                  var dbamount = '';
              }
              else{
                  var dbamount = '';
                  var cramount = '';
              }

              toAppend    += '<tr id='+response.journal[j].journalRef+'><td><input type="checkbox" name="journal[]" class="checkbox removeLayer journalitemRef" value="'+response.journal[j].journalRef+'"></td><td>'+response.journal[j].subcategory+'</td><td><span class="label label-primary">Journal</td></td><td>'+dbamount+'</td><td>'+cramount+'</td><td>'+journalDate.getDate()+ ' '+monthNames[journalDate.getMonth()] +' '+journalDate.getFullYear()+'</td>></tr>';
              //jQuery('.tableData').append('<tr><td>'+response.journal[i].journalRef+'</td><td><td></td></tr>')
            }
            $('.tableData').html(toAppend);

      }
  });
  $('#confirm-status-update-modal-chart').modal('show');
  if( status == 1)
    var status = 'Inactive';
  else
    var status = 'Active';
  $('#confirm-status-update-modal-chart').find('.modal-body').find('.statusLabel').html('<strong>'+name+'</strong> '+status);
});
</script>

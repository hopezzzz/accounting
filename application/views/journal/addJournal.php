<div class="content-wrapper" style="height: 670px !important">
    <section class="content-header">
        <h1><?php echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="step_panel">
            <div class="row setup-content" id="step-1">
            <?php echo form_open('save-journal', array('id' => 'add-journal-form', 'autocomplete' => 'off')); ?>
                <div class="col-md-12">
                	<div class="row">
                    <div class="col-md-6 text-left">
                        <a href="<?php echo site_url();?>journal" class="success btn btn-success"> Back</a>
                    </div>
                    <div class="col-md-6 pull-right">
                    	<div class="row">
                        <div class="col-md-8 text-right"><h4>Journal Date</h4></div>
                        <div class="col-md-4 form-group">
                            <input autocomplete="off" type="text" name="date" value="<?php echo changeDateFormat($journalDetail[0]->date,'');?>" readonly="" id="journalDate" class="datepicker form-control">
                            <input type="hidden" class="form-control" name="journalRef" value="<?php echo trim($journalDetail[0]->journalRef);?>">
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="clearfix"></div><br>
                </div>
                <div class="col-md-12">
                    <div class="box-body no-padding">
                        <table class="table table-hover" id="tableList">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0;
                                foreach ($journalDetail as $value)
                                {
                                    $i++; ?>
                                    <tr class="dealPack trSrNo<?php echo $i;?>">
                                        <td class="serialNumberr"><?php echo $i;?></td>
                                        <td class="form-group">
                                            <select name="type[<?php echo $i-1;?>]" class="form-control type">
                                                <option <?php if( $value->type =='db' ){?>selected<?php } ?> value="db">DB</option>
                                                <option <?php if( $value->type =='cr' ){?>selected<?php } ?> value="cr">CR</option>
                                            </select>
                                        </td>
                                        <td class="form-group search_Expense">
                                            <input type="text" data-type="all" class="form-control searchExpense " placeholder="Search..." value="<?php if(trim($value->subcategoryRef)  !=""){  $category = getCategoryNameByRef($value->subcategoryRef); echo $category->title; } ?>">
                                            <input type="hidden" class="form-control do-not-ignore serviceRef" name="subcategoryRef[]" value="<?php echo $value->subcategoryRef;?>">
                                            <input type="hidden" name="ParentCategoryRef[]" class="ParentCategoryRef" value="<?php echo $value->categoryRef;?>">
                                            <ul class="categoryList list-group hide"></ul>

                                        </td>
                                        <td class="form-group">
                                            <input type="text" class="form-control description" name="description[<?php echo $i-1;?>]"  placeholder="Enter Description" value="<?php echo trim($value->description);?>">
                                            <input type="hidden" class="form-control" name="journalItemRef[<?php echo $i-1;?>]" value="<?php echo trim($value->journalItemRef);?>">
                                        </td>
                                        <td class="form-group">
                                            <input type="text" class="validNumber form-control amount" name="amount[<?php echo $i-1;?>]"  placeholder="0" value="<?php trim($value->amount);?>">
                                        </td>
                                    </tr>
                        <?php   } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="javascript:void(0)" id="addLayer" class="btn btn-success"> <i class="fa fa-plus"> </i> Add New Line </a>
                </div>
                <br>
                <div class="col-md-6 pull-right text-right">
                    <input type="button" value="Save" id="saveJournalBtn" class="btn btn-success">
                </div>
            <?php echo form_close(); ?>
            </div>
        </div>
    </section>

    <table>
        <tbody>
            <tr id="nextLine" class="hide">
                <td class="serialNumberr">1</td>
                <td class="form-group">
                    <select name="type[]" class="form-control type">
                        <option value="db" selected="selected" >DB</option>
                        <option value="cr">CR</option>
                    </select>
                </td>
                <td class="form-group search_Expense">
                    <input type="text" data-type="all" class="form-control searchExpense " placeholder="Search..."  value="<?php if(trim($value->subcategoryRef)  !=""){  $category = getCategoryNameByRef($value->subcategoryRef); echo $category->title; } ?>">
                    <input type="hidden" class="form-control serviceRef subcategoryRef" name="subcategoryRef[]" value="<?php echo $value->subcategoryRef;?>">
                    <input type="hidden" name="ParentCategoryRef[]" class="ParentCategoryRef" value="<?php echo $value->categoryRef;?>">
                    <ul class="categoryList list-group hide"></ul>
                </td>
                <td class="form-group">
                    <input type="text" class="form-control description" name="description[]"  placeholder="Enter Description" value="">
                    <input type="hidden" class="form-control" name="journalItemRef[]" value="">
                </td>
                <td class="form-group">
                    <input type="text" class="validNumber form-control amount" name="amount[]"  placeholder="0" value="" >
                </td>
                <td class="addMins mouserpointer"></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="add-Category-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-lg-12 col-md-12" id="">

                  <?php echo form_open('ajaxaddaccounting', array('id' => 'addAccounting', 'autocomplete' => 'off')); ?>
                      <div class="col-md-12 form-group">
                        <label class="form-label"> Type </label>
                          <div class="form-group">
                              <select class="form-control" id="selType" name="cattype">
                                <option value="">Select Type</option>
                                <?php foreach ($productServices as $key => $value): ?>
                                  <option data-ref="<?php if($value->type !== 'balance sheet') echo strtolower($value->type); else echo strtolower($value->type); ?>" value="<?php echo $value->categoryRef;?>">
                                          <?php if($value->type !== 'balance sheet') echo ucfirst($value->type); else echo ucfirst($value->title);?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <input type="hidden" name="ParentCategoryRef" id="ParentCategoryRef" value="">
                          </div>
                      </div>
                      <div class="clearfix"></div>
                      <div id="requiredDiv" class="col-md-12 hide form-group">
                        <label class="form-label"> Select Parent Category </label>
                          <div class="form-group">
                            <select class="form-control" id="ajaxcategories" name="parentCat">
                              <?php foreach ($categories as $key => $valuse): ?>
                                  <option data-ref="<?php echo strtolower($valuse->type);?>" value="<?php echo $valuse->categoryRef;?>"><?php echo ucfirst($valuse->title); ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-12 form-group">
                        <label class="form-label"> Category Name</label>
                          <div class="form-group">
                              <input type="text" name="title" value="" class="form-control" placeholder="Category Name">
                          </div>
                      </div>
                </div>
              <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
              <input id="cattype" type="hidden" value="balance sheet" name="type">
                <input type="hidden" name="modelHide" value="redirect" id="selectedSrNo">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <input type="submit" value="Save" class="btn btn-success pull-right">
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function()
{

    jQuery('body').on('click','#selType',function(){

      var value     = $.trim($('option:selected', this).attr('data-ref'));
      var textValue = $.trim($('option:selected', this).text());

      if(value === 'expense' || value === 'income')
      {
          jQuery('#requiredDiv').removeClass('hide');
          $.ajax({
              type: "POST",
              url: site_url + 'getCategories',
              data: {'type' : textValue},
              success: function (response) {
                  if(response.length > 1){
                    $('#ajaxcategories').html(response);
                  }
              }
          });
      }
      else
      {
          jQuery('#requiredDiv').addClass('hide');
      }

    });

     jQuery('body').on('click','#selType',function(){
        var selectValue     = $.trim($('option:selected', this).val());
        var selectdataRef     = $.trim($('option:selected', this).attr('data-ref'));
        jQuery('#cattype').val(selectdataRef);
        if(selectdataRef === 'balance sheet')
        {
          jQuery('#ParentCategoryRef').val(selectValue);
        }
        else{
          jQuery('#ParentCategoryRef').val('');
        }

     })

})
</script>

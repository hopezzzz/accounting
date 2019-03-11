
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php  echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <?php //echo "<pre>"; print_r($result); echo "</pre>"; ?>
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <a href="<?php echo site_url();?>accounting" class="success btn btn-success"> Back</a>
        </div>
        <div class="clearfix"></div><br>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
          	<div class="row">
              <?php if($pageType=='add') {?>
                <?php echo form_open('ajaxaddaccounting', array('id' => 'addAccounting', 'autocomplete' => 'off')); ?>
              <?php } else { ?>
            <?php echo form_open('updateAccountingAjax', array('id' => 'addAccounting', 'autocomplete' => 'off')); ?>
          <?php } ?>
              <div class="col-md-5 form-group">
                <label class="form-label"> Type </label>
                  <div class="form-group">

                      <select class="form-control" id="selType" name="cattype">
                        <option value="">Select Type</option>
                        <?php foreach ($productServices as $key => $value): ?>
                          <option <?php if($result->type == $value->type) echo "selected"; ?> data-ref="<?php if($value->type !== 'balance sheet') echo strtolower($value->type); else echo strtolower($value->type); ?>" value="<?php echo $value->categoryRef;?>">
                                  <?php if($value->type !== 'balance sheet') echo ucfirst($value->type); else echo ucfirst($value->title);?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <input type="hidden" name="ParentCategoryRef" id="ParentCategoryRef" value="<?php echo $result->ParentCategoryRef;?>">
                  </div>
              </div>
              <div class="clearfix"></div>
              <div id="requiredDiv" class="col-md-5 <?php if($result->type == 'expense' || $result->type == 'income' ) echo ''; else echo 'hide ';?> form-group">
                <label class="form-label"> Select Parent Category </label>
                  <div class="form-group">
                    <select class="form-control" id="ajaxcategories" name="parentCat">
                      <?php foreach ($categories as $key => $valuse): ?>
                          <option <?php if($result->ParentCategoryRef == $valuse->categoryRef) echo "selected"; ?> data-ref="<?php echo strtolower($valuse->type);?>" value="<?php echo $valuse->categoryRef;?>"><?php echo ucfirst($valuse->title); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
              </div>
              <div class="clearfix"></div>

              <div class="col-md-5 form-group">
                <label class="form-label"> Category Name</label>
                  <div class="form-group">
                      <input type="text" name="title" value="<?php if($result->title) echo $result->title;?>" class="form-control" placeholder="Category Name">
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-5">
               <input type="hidden" name="type" id="cattype" value="<?php echo $result->type;?>">
              <input type="hidden" name="categoryRef" value="<?php if($result->categoryRef) echo $result->categoryRef;?>">
              <input type="submit" value="Save" class="btn btn-success pull-right saveBtns">

            </div>
            </div>
          </div>
        </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </section>


</div>
<script type="text/javascript">
jQuery(document).ready(function()
{
    var pageType = '<?php echo $pageType;?>';
    if( pageType == 'update' )
    {
        $('#selType').attr('disabled',true).attr('name','');
        $('#ajaxcategories').attr('disabled',true).attr('name','');
        //$("#addAccounting").attr("action", '<?php echo site_url('updateAccountingAjax');?>');
    }
    else
    {
        $('#selType').attr('disabled',false);
        $('#ajaxcategories').attr('disabled',false);
    }
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
     jQuery('body').on('click','#ajaxcategories',function(){
        var selectValue     = $.trim($('option:selected', this).val());
        if(selectValue !='')
        {
          jQuery('#ajaxcategories').parents('.form-group').removeClass('has-error');
          $('#cat_error').remove();
        }
     })


    jQuery('body').on('click','.saveBtns',function()
    {
        jQuery('#ajaxcategories').parents('.form-group').removeClass('has-error');
        $('#cat_error').remove();

        var selvalues = $.trim(jQuery('#ajaxcategories').val());

          if(selvalues == 0 && !jQuery("#requiredDiv").hasClass("hide"))
          {

            jQuery('#ajaxcategories').parents('.form-group').addClass('has-error');
            $('#ajaxcategories').after('<label class="has-error" id="cat_error" for="selType">Parent Category  is required.</label>');
            return false;
          }
          else
          {
            jQuery('#ajaxcategories').parents('.form-group').removeClass('has-error');

          }
    })
})
</script>

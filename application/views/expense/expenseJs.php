<script type="text/javascript">
$(document).ready(function ()
{
    $('#creditorSearchList').hide();
  $(document).on('keyup', '#creditorName', function(event)
	{
    $('#creditorSearchList').show();
    $('#creditorRef').val('');
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'getcreditorlist',
          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
          beforeSend  : function () {
    				 $(".loader_div").show();
    			},
    			complete: function () {
    				 $(".loader_div").hide();
    			},
          success: function (response) {
              if(response.length > 1){
                $('#creditorSearchList').html(response);
                  $('#popover-form').addClass('hide');
              }
          }
      });
  }else{
      $('#creditorSearchList').html('');
      $('#creditorSearchList').hide();
  }
	});


  jQuery('body').on('keyup','#creditorName', function(){
    if($(this).val().length ==0){
        jQuery('#popover-form').hide();
    }
  })
  jQuery('body').on('click','#creditorSearchList .list-group-item', function(){
    var formGroup = jQuery(this).parent().parent().attr('class');
    jQuery('.'+formGroup).find('.has-error').hide();
      var selValue = $.trim($(this).attr('data-ref'));
      var selText = $.trim($(this).contents().get(0).nodeValue);
      if(selValue !='addNewCreditor'){
          $('#creditorRef').val(selValue);
          $('#creditorName').val(selText);
          $('#creditorSearchList').hide();
      }else{
        $('#creditorRef').val('new');
      }
  })
  jQuery('body').on('click','#addNewCreditor', function(){
      var currentvalue = jQuery('#creditorName').val();
      jQuery('#addCreditorName').val(currentvalue);
      jQuery('#addNewCreditor').hide();
      jQuery('#creditorSearchList').hide();
      jQuery('#popover-form').removeClass('hide');
      jQuery('#popover-form').show();
      jQuery('#popover-form').css('border','1px solid #ddd');
  });


  var counter_new = 2;
      jQuery('body').on('click', '#addLayer', function ()
      {
          var lastAmount = jQuery('.serialNumberr:last').text();
          var block = jQuery("#nextLine").clone();
          block.removeAttr('id');
          block.removeClass('hide');
          block.addClass('dealPack');
          //block.css('display', 'block');
          //block.attr('id', 'new_spread' + counter_new);
          block.children('.serialNumber').addClass('serialNumberr');
          block.children('.serialNumber').removeClass('serialNumber');
          block.children('.serialNumberr').text(parseInt(lastAmount) + parseInt(1));
          var last = parseInt(lastAmount) + parseInt(1);
          block.addClass('trSrNo'+last);
          block.find(".productService").attr("name","subcategoryRef["+parseInt(lastAmount)+"]").addClass('subcategoryRef');
          block.find(".productServiceQty").attr("name","quantity["+parseInt(lastAmount)+"]");
          block.find(".serviceRef").attr("name","serviceRef["+parseInt(lastAmount)+"]").addClass('do-not-ignore');
          block.find(".oneServiceProductPrice").attr("name","rate["+parseInt(lastAmount)+"]");
          block.find(".qtyType").attr("name","qtyType["+parseInt(lastAmount)+"]");
          block.children('td').children('.removeLayer').remove();
          block.children('td input.addNewProductService').addClass('hidden');
          block.children('td.addMins').append('<span class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');
          //block.children('td').children('input').val('');
          block.children('td').children('input').css('border', '1px solid #c1c1c1');
          block.children('td').children('select').val('');
          block.children('td').children('select').prop('selected', false);
          block.children('td').children('select').css('border', '1px solid #c1c1c1');
          block.children('td').children('#serviceProductPrice').text('0:00');
          block.children('td').children('.serviceList').children('.serviceUl').html('');
          block.children('td').children('.serviceProductPrice').text('0:00');
          block.children('td').children('.quantity').val('1');
          block.children('td').children('.discoutType').val('0');
          block.children('td').children('.discountPrice').text('0:00');

          block.insertAfter(".dealPack:last");
          counter_new++;
          callToEnhanceValidate();
      });
      var callToEnhanceValidate=function()
      {
          $(".serviceRefValidate").each(function()
          {

              $(this).rules('remove');
              $(this).rules('add', {
                      required: true,
  					messages: {
  						required: "Expense type is required."
  					},
               });
          });


          $(".productServiceQty").each(function()
          {
              $(this).rules('remove');
              $(this).rules('add', {
                      required: true,
                      noSpace: true,
            messages: {
              required: "QTY is required."
            },
               });
          });

          $(".oneServiceProductPrice").each(function()
          {
              $(this).rules('remove');
              $(this).rules('add', {
                      required: true,
            messages: {
              required: "Rate is required."
            },
               });
          });
          $(".qtyType").each(function()
          {
              $(this).rules('remove');
              $(this).rules('add', {
                      required: true,
                      noSpace: true,
                      messages: {
                          required: "Qty Type is required."
                      },
               });
          });
      }
      /** Variable for assign refIds **/
      var itemReff = "";
      /******************/
      jQuery('body').on('click', '.removeLayer', function () {
          var itemRef   =   jQuery($(this)).closest('tr').find('.itemRef').val();
          if(itemRef !="")
          {
              itemReff     += itemRef+',';
              jQuery('.transactionItemRef').val(itemReff);
          }
          jQuery(this).parent('td').parent('tr').remove();
          var count     = 0;
          jQuery('.serialNumberr').each(function () {
              jQuery(this).text(parseInt(count) + parseInt(1));
              count++;
          });
          if (count == 1 || count == 0) {
              jQuery('td').children('.removeLayer').remove();
          }
          $('.calculation').trigger('change');
      });

      jQuery('body').on('click','#invoiceNum',function(){
          $('#invoiceNum').hide();
          $('#boxInvoiceNum').removeClass('hidden');
          $('#boxInvoiceNum').val($(this).text());
          $('#boxInvoiceNum').focus();
      })

      jQuery("#boxInvoiceNum").blur(function() {
          jQuery('#invoiceNum').show();
          console.log($(this).val());
          jQuery('#invoiceNum').text($(this).val());
          jQuery( "#boxInvoiceNum" ).addClass('hidden');
      })


      jQuery('body').on('click','#addNewCategory',function(){
          if($(this).attr('data-ref') == 'addNewCategory'){
             $('#add-Category-modal').modal('show');
             jQuery('#add-Category-modal #selectedSrNo').val(jQuery(this).closest('tr').children('.serialNumberr').text());
             jQuery('.categoryList').addClass('hide');
         }else{
             var option = $('option:selected', this).attr('data-parentref');
             jQuery(this).closest('tr').find('.ParentCategoryRef').val(option);
         }
      })

      jQuery('#add-Category-modal').on('hidden.bs.modal', function (e) {
          jQuery(this).find("input[type=text],textarea,select").val('').end();
          jQuery(this).find('.parent').addClass('hide');
          jQuery(this).find('.children').addClass('hide');
          jQuery('#addCategory').find('#children').prop('checked',false).trigger('click');
          jQuery('.form-group').removeClass('has-error');
      });

      jQuery('body').on('click','.addCat',function()
      {
          if($(this).val() == 0)
          {
              jQuery('.children').addClass('hide');
              jQuery('.parent').removeClass('hide');
          }
          else
          {
              jQuery('.parent').addClass('hide');
              jQuery('.children').removeClass('hide');
          }
      })


    jQuery('.addCat').on('change', function () {
        $('.addCat').not(this).prop('checked', false);
    });

    jQuery('body').on('click','#saveCategory', function()
    {
        $('#addCategory').find('.form-group').removeClass('has-error');
          var str        = $( "#addCategory" ).serialize();
          var srNo       = jQuery('#add-Category-modal #selectedSrNo').val();
          var parentCat  = jQuery('.parentChk:checked').val();
          if(parentCat == 0)
          {
              if($.trim(jQuery('#textcatname').val()) =="")
              {
                jQuery('#textcatname').parents('.form-group').addClass('has-error');
                jQuery('#textcatname').attr('placeholder','Please Enter Category Name');
                return false;
              }
          }
          else if(parentCat == 1)
          {
              if($.trim(jQuery('#catNameRef').val()) =="")
              {
                jQuery('#catNameRef').parents('.form-group').addClass('has-error');
                return false;
              }
              if($.trim(jQuery('#subcatName').val()) =="")
              {
                jQuery('#subcatName').parents('.form-group').addClass('has-error');
                jQuery('#subcatName').attr('placeholder','Please Enter Sub Category Name');
                return false;
              }
          }
          else{
              alert('Please Check Category First');
              return false;
          }
          $('#addCategory').find('.form-group').removeClass('has-error');
          $.ajax({
                type: "POST",
                url: site_url + 'add-categories',
                data: str,
                dataType: "json",
                async:false,
                success: function (response)
                {

                    if(response.category == 'children')
                    {
                      if( !response.success )
                      {
                          jQuery('.errMsg').show();
                          jQuery('.errMsg').html('<div class="alert alert-warning"><strong>Warning!</strong> " '+ response.errorMsg + '"</div>').fadeOut(7000);
                      }
                      else
                      {
                          jQuery('.errMsg').show();
                          jQuery('.trSrNo'+srNo).find('.searchExpense').val(response.subcatName);
                          jQuery('.trSrNo'+srNo).find('.serviceRef').val(response.subcatRef);
                          jQuery('.trSrNo'+srNo).find('.ParentCategoryRef').val(response.parentCatName);
                          jQuery('.errMsg').html('<div class="alert alert-success"><strong>Success!</strong> " '+ response.success_message + '"</div>').fadeOut(7000);
                          setTimeout(function() {  jQuery('#add-Category-modal').modal('hide'); }, 5000);
                      }

                    }

                }
            });

       });
      /** Trigger calculation Fucntion using class .calculation **/
      $('.calculation').trigger('change');





});

</script>

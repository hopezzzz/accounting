<script type="text/javascript">
    $(document).ready(function ()
    {
        var counter_new = 2;
        jQuery('body').on('click', '#addLayer', function ()
        {
            var totalRows     = $('#tableList tbody tr').length;
            var lastRowIndex  = parseInt( totalRows ) ;
            var lastRowIndex1  = parseInt( totalRows )+1 ;
            var block = jQuery("#nextLine").clone();
            block.removeAttr('id');
            block.removeClass('hide');
            block.addClass('dealPack');
            block.addClass('trSrNo'+parseInt(lastRowIndex1));
            block.find(".serialNumberr").html(parseInt(lastRowIndex)+1);
            block.find(".subcategoryRef").attr("name","subcategoryRef["+parseInt(lastRowIndex)+"]");
            block.find(".type").attr("name","type["+parseInt(lastRowIndex)+"]");
            block.find(".description").attr("name","description["+parseInt(lastRowIndex)+"]");
            block.find(".amount").attr("name","amount["+parseInt(lastRowIndex)+"]");
            block.children('td').children('.removeLayer').remove();
            block.children('td.addMins').append('<span class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');

            block.children('td').children('.amount').text('0:00');
            block.insertAfter(".dealPack:last");
            counter_new++;
        });

        /** Variable for assign refIds **/
        var itemReff = "";
        /******************/
        jQuery('body').on('click', '.removeLayer', function ()
        {
            var itemRef   =   jQuery($(this)).closest('tr').find('.itemRef').val();
            if(itemRef !="")
            {
                itemReff     += itemRef+',';
                jQuery('.transactionItemRef').val(itemReff);
            }
            jQuery(this).parent('td').parent('tr').remove();
            var count     = 0;
            jQuery('#tableList tbody tr').each(function ()
            {
                jQuery(this).find('.serialNumberr').text(parseInt(count) + parseInt(1));
                jQuery(this).find(".subcategoryRef").attr("name","subcategoryRef["+parseInt(count)+"]");
                jQuery(this).find(".type").attr("name","type["+parseInt(count)+"]");
                jQuery(this).find(".description").attr("name","description["+parseInt(count)+"]");
                jQuery(this).find(".amount").attr("name","amount["+parseInt(count)+"]");
                count++;
            });
            if (count == 1 || count == 0)
            {
                jQuery('td').children('.removeLayer').remove();
            }
        });
        jQuery('body').on('change', '#add-journal-form :input', function (event)
        {
            var inputVal = $(this).val();
            inputVal     = $.trim(inputVal);
            if(inputVal == '' || inputVal == undefined )
            {
                    $(this).parents('.form-group').addClass('has-error');
                    $(this).attr('placeholder', 'This Field is Required');
            }
            else
            {
                $(this).parents('.form-group').removeClass('has-error');
                $(this).attr('placeholder', '');
            }
        });

        jQuery('body').off('click', '#saveJournalBtn').on('click', '#saveJournalBtn', function (event)
        {
            event.preventDefault();
            isError      = false;
            var posturl  = $('#add-journal-form').attr('action');
            $('#add-journal-form *').filter(':input').not('input[name^="description"],input[name^="journalItemRef"],input[name^="journalRef"]').each(function()
            {
            	var inputVal = $(this).val();
                inputVal     = $.trim(inputVal);

            	if(inputVal == '' || inputVal == undefined )
            	{
            			isError = true;
            			$(this).parents('.form-group').addClass('has-error');
                  $(this).parents('.form-group').find('.search_Expense').addClass('has-error');
            			$(this).attr('placeholder', 'This Field is Required');
            	}
                else
                {
                    //$(this).parents('.form-group').removeClass('has-error');
                    // for remove error class from category
                    $(this).parents('.form-group').find('.search_Expense').removeClass('has-error');
                    $(this).attr('placeholder', '');
                }
            });
            if(!isError)
            {
                var crEntry = 0;
                var dbEntry = 0;
                $('#add-journal-form *').filter(':input').not(':not(select[name^="type"])').each(function()
                {
                	var inputVal = $(this).val();
                    inputVal     = $.trim(inputVal);
                    if(inputVal == 'db')
                        dbEntry = parseInt(dbEntry) + 1;
                    if(inputVal == 'cr')
                        crEntry = parseInt(crEntry) + 1;
                });
                var errorMsg = '';
                if( dbEntry == 0 && crEntry == 0 )
                    errorMsg = 'You should have at-least one debit entry & one credit entry, please check your entries.';
                else if( dbEntry == 0 )
                    errorMsg = 'You should have at-least one debit entry, please check your entries.';
                else if( crEntry == 0 )
                    errorMsg = 'You should have at-least one credit entry, please check your entries.';

                if( dbEntry > 0 && crEntry > 0 )
                {
                    var dbAmount = crAmount = 0;
                    $('#tableList tbody tr').each(function()
                    {
                        var type    = $(this).find('select[name^="type"]').val();
                        var amount  = $(this).find('input[name^="amount"]').val();
                        if( type == 'db' )
                            dbAmount = parseFloat( dbAmount ) + parseFloat( amount );
                        else
                            crAmount = parseFloat( crAmount ) + parseFloat( amount );
                    });
                    if( crAmount <=  0 && dbAmount <= 0 )
                        errorMsg = 'Blank journal entry can not be made, please enter some record.';
                    if( crAmount != dbAmount )
                        errorMsg = 'Credit and debit amount should be equal, please check your entries.';
                }
                // Reset all error messages first
                  $.toast().reset('all');
                // Reset all error messages first
                if( errorMsg != '' )
                {
                    $.toast({
                        heading             : 'Error',
                        text                : errorMsg,
                        loader              : true,
                        loaderBg            : '#fff',
                        showHideTransition  : 'fade',
                        icon                : 'error',
                        hideAfter           : delayTime,
                        position            : 'top-right'
                    });
                    return false;
                }

                var delayTime = 3000;
                $('#add-journal-form').ajaxSubmit({
            				url: posturl,
            				dataType: 'json',
            				beforeSend: function()
                    {
                        $("input[type=submit]").attr("disabled", "disabled");
                        $(".loader_div").show();
    				         },
                    complete: function () {
                        $(".loader_div").hide();
                    },
    				        success: function(response)
                    {
                        $(".loader_div").hide();
                        $("input[type=submit]").removeAttr("disabled");

                        $.toast().reset('all');
                        if(response.delayTime)
                            delayTime = response.delayTime;
                        if (response.success)
                        {
                            $.toast({
                                heading             : 'Success',
                                text                : response.success_message,
                                loader              : true,
                                loaderBg            : '#fff',
                                showHideTransition  : 'fade',
                                icon                : 'success',
                                hideAfter           : delayTime,
                                position            : 'top-right'
                            });
                        }
                        else
                        {
                            if( response.formErrors)
                            {
                                $.each(response.errors, function( index, value )
                                {
                                    $("input[name='"+index+"']").parents('.form-group').addClass('has-error');
                                    $("input[name='"+index+"']").attr('placeholder', value);

                                    $("select[name='"+index+"']").parents('.form-group').addClass('has-error');
                                    $("select[name='"+index+"']").attr('placeholder', value);
                                });
                            }
                            else
                            {
                                $.toast({
                                    heading             : 'Error',
                                    text                : response.error_message,
                                    loader              : true,
                                    loaderBg            : '#fff',
                                    showHideTransition  : 'fade',
                                    icon                : 'error',
                                    hideAfter           : delayTime,
                                    position            : 'top-right'
                                });
                            }
                        }
    					if(response.resetform)
    					    $('#add-journal-form').resetForm();
    					if(response.url)
    					{
    						if(response.delayTime)
    							setTimeout(function() { window.location.href=response.url;}, response.delayTime);
    						else
    							window.location.href=response.url;
    					}
    				},
    				error:function(response)
                    {
                        $.toast({
                            heading             : 'Error',
                            text                : 'Connection Error.',
                            loader              : true,
                            loaderBg            : '#fff',
                            showHideTransition  : 'fade',
                            icon                : 'error',
                            hideAfter           : delayTime,
                            position            : 'top-right'
                        });
                    }
    			});
            }

        });


              jQuery('body').on('click','#addNewCategory',function(){
                  if($(this).attr('data-ref') == 'addNewCategory'){
                     $('#add-Category-modal').modal('show');
                     jQuery('#add-Category-modal #selectedSrNo').val(jQuery(this).closest('tr').children('.serialNumberr').text());
                     jQuery('#addAccounting').attr('action',"<?php echo site_url('ajaxaddaccounting')?>");
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
                                  jQuery('.trSrNo'+srNo).find('.subcategoryRef').val(response.subcatRef);
                                 // jQuery('.trSrNo'+srNo).find('.ParentCategoryRef').val(response.parentCatName);
                                  jQuery('.errMsg').html('<div class="alert alert-success"><strong>Success!</strong> " '+ response.success_message + '"</div>').fadeOut(7000);
                                  setTimeout(function() {  jQuery('#add-Category-modal').modal('hide'); }, 5000);
                              }

                            }

                        }
                    });

               });
    });
</script>

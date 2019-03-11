<script type="text/javascript">
$(document).ready(function ()
{
  $(document).on('keyup', '#creditorName', function(event)
	{
    $('#creditorSearchList').show();
    $('#creditorRef').val('');
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'getcreditorlist',
          beforeSend  : function () {
             $(".loader_div").show();
          },
          complete: function () {
             $(".loader_div").hide();
          },
          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
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

  jQuery(document).on('click','#creditorSearchList .list-group-item', function(){
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



  jQuery('body').on('change','#purchaseType', function(){
        var purchaseType = $(this).val();
        $('.calculation').trigger('change');
        if(purchaseType == 1)
        {
            $( "#tableList thead tr th:nth-child(3)" ).hide();
            $( "#tableList thead tr th:nth-child(4)" ).hide();
            $( "#tableList thead tr th:nth-child(5)" ).hide();
            jQuery('.productServiceQty').closest('td').hide();
            jQuery('.qtyType').closest('td').hide();
            jQuery('.productServiceGross').attr("readonly", false).addClass('calculation');
            //jQuery('.productServiceGross').val('0.00').removeClass('calculation');
            jQuery('.oneServiceProductPrice').closest('td').hide();
        }
        else
        {
          $( "#tableList thead tr th:nth-child(3)" ).show();
          $( "#tableList thead tr th:nth-child(4)" ).show();
          $( "#tableList thead tr th:nth-child(5)" ).show();
          jQuery('.productServiceQty').closest('td').show();
          jQuery('.qtyType').closest('td').show();
          jQuery('.productServiceGross').attr("readonly", true).addClass('calculation');
          //jQuery('.productServiceGross').val('0.00');
          jQuery('.oneServiceProductPrice').closest('td').show();
        }
  });

jQuery('body').on('click','#addNewCreditor', function(){
  var currentvalue = jQuery('#creditorName').val();
  jQuery('#addCreditorName').val(currentvalue);
  $('#addNewCreditor').hide();
  $('#creditorSearchList').hide();
  $('#popover-form').removeClass('hide');
    jQuery('#popover-form').show();
  $('#popover-form').css('border','1px solid #ddd');
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
        block.find(".productService").attr("name","product["+parseInt(lastAmount)+"]").addClass('product');
        block.find(".productServiceQty").attr("name","quantity["+parseInt(lastAmount)+"]");
        block.find(".oneServiceProductPrice").attr("name","rate["+parseInt(lastAmount)+"]");
        block.find(".productRef").attr("name","productRef["+parseInt(lastAmount)+"]").addClass('do-not-ignore');
        block.find(".qtyType").attr("name","qtyType["+parseInt(lastAmount)+"]");
        block.children('td').children('.removeLayer').remove();
        block.children('td input.addNewProductService').addClass('hidden');
        block.children('td.addMins').append('<span style="padding: 1px;vertical-align: middle;font-size: 20px;" class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');
        //block.children('td').children('input').val('');
        block.children('td').children('input').css('border', '1px solid #c1c1c1');
        block.children('td').children('select').val('');
        block.children('td').children('.productRef').val('');
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
        $(".productRef").each(function()
        {
            $(this).rules('remove');
            $(this).rules('add', {
                    required: true,
					messages: {
						required: "Product / Service Name is required."
					},
             });
        });

        $(".productServiceQty").each(function()
        {
            $(this).rules('remove');
            $(this).rules('add', {
                    required: true,
					messages: {
						required: "Product quantity is required."
					},
             });
        });

        $(".oneServiceProductPrice").each(function()
        {
            $(this).rules('remove');
            $(this).rules('add', {
                    required: true,
                    noSpace: true,
					messages: {
						required: "Product rate is required."
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

      /** Trigger calculation Fucntion using class .calculation **/
      $('.calculation').trigger('change');
      $('#purchaseType').trigger('change');
});

</script>

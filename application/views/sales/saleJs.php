<script type="text/javascript">
$(document).ready(function ()
{
  $('#debtorSearchList').hide();
  $(document).on('keyup', '#debtorName', function(event)
	{
    $('#debtorSearchList').show();
    $('.payeeRef').val('');
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'getDebitorList',
          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
          beforeSend  : function () {
    				 $(".loader_div").show();
    			},
    			complete: function () {
    				 $(".loader_div").hide();
    			},
          success: function (response) {
              if(response.length > 1){
                $('#debtorSearchList').html(response);
                  $('#popover-form').addClass('hide');
              }
          }
      });
  }else{
      $('#debtorSearchList').html('');
      $('#debtorSearchList').hide();

  }
	});
  jQuery('body').on('keyup','#debtorName', function(){
    if($(this).val().length ==0){
        jQuery('#popover-form').hide();
    }
  })
  jQuery('body').on('click','#debtorSearchList .list-group-item', function(){
    var selValue = $.trim($(this).attr('data-ref'));
    var selText = $.trim($(this).contents().get(0).nodeValue);
    var formGroup = jQuery(this).parent().parent().attr('class');
    jQuery('.'+formGroup).find('.has-error').hide();
      if(selValue !='addNewDebtor'){
          $('#debtorRef').val(selValue);
          $('#debtorName').val(selText);
          $('#debtorSearchList').hide();
      }
      else{
        $('#debtorRef').val('new');
    }
  })
jQuery('body').on('click','#addNewCreditor', function(event){
  var currentvalue = jQuery('#debtorName').val();
  jQuery('#addDebtorName').val(currentvalue);
  $('#addNewCreditor').hide();
  $('#debtorSearchList').hide();
  $('#popover-form').removeClass('hide');
    event.stopPropagation();
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
        block.children('td.addMins').append('<span class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');
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

    jQuery('body').on('click','#invoiceNum',function(){
        $('#invoiceNum').hide();
        $('#boxInvoiceNum').removeClass('hidden');
        $('#boxInvoiceNum').val($(this).text());
        $('#boxInvoiceNum').focus();
    })
    jQuery("#boxInvoiceNum").blur(function() {
        jQuery('#invoiceNum').show();
        jQuery( "#boxInvoiceNum" ).addClass('hidden');
    })
    $.fn.digits = function(){
    return this.each(function(){
        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
    })
}
      $('.calculation').trigger('change');
});

</script>

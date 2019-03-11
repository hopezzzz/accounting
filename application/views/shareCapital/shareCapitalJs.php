<script type="text/javascript">
$(document).ready(function ()
{
  $('#shareHolderList').hide();
  $(document).on('keyup', '#shareHolderName', function(event)
	{
    $('#shareHolderList').show();
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'getShareHolderlist',
          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
          beforeSend  : function () {
    				 $(".loader_div").show();
    			},
    			complete: function () {
    				 $(".loader_div").hide();
    			},
          success: function (response) {
              if(response.length > 1){
                $('#shareHolderList').html(response);
                  $('#popover-form').addClass('hide');
              }
          }
      });
  }else{
      $('#shareHolderList').html('');
      $('#shareHolderList').hide();

  }
	});
  jQuery('body').on('keyup','#shareHolderName', function(){
    if($(this).val().length ==0){
        jQuery('#popover-form').hide();
    }
  })
  jQuery(document).on('click','#shareHolderList .setlist', function(){
      jQuery(this).parents().find('#shareHolderRef-error').hide();
      var selValue = $.trim($(this).attr('data-ref'));
      var selText = $.trim($(this).children().remove().end().text());
      if(selValue !='addNewHolder'){
          $('#shareHolderRef').val(selValue);
          $('#shareHolderName').val(selText);
          $('#shareHolderList').hide();
      }else{
        $('#shareHolderRef').val('new');
      }
  })
  jQuery('body').on('click','#addNewHolder', function(){
      $("#add-share-capital-form").valid();
      var currentvalue = jQuery('#shareHolderName').val();
      jQuery('#newshareholder').val(currentvalue);
      jQuery('#addNewCreditor').hide();
      jQuery('#shareHolderList').hide();
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
          block.children('.serialNumber').addClass('serialNumberr');
          block.children('.serialNumber').removeClass('serialNumber');
          block.children('.serialNumberr').text(parseInt(lastAmount) + parseInt(1));
          var last = parseInt(lastAmount) + parseInt(1);
          block.addClass('trSrNo'+last);
          block.find(".shareQty").attr("name","quantity["+parseInt(lastAmount)+"]");
          block.find(".shareRate").attr("name","rate["+parseInt(lastAmount)+"]");
          block.children('td').children('.removeLayer').remove();
          block.children('td input.addNewProductService').addClass('hidden');
          block.children('td.addMins').append('<span class="removeLayer sharecalculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');
          //block.children('td').children('input').val('');
          block.children('td').children('input').css('border', '1px solid #c1c1c1');
          block.children('td').children('select').val('');
          block.children('td').children('select').prop('selected', false);
          block.children('td').children('select').css('border', '1px solid #c1c1c1');
          block.children('td').children('#serviceProductPrice').text('0:00');
          block.children('td').children('.serviceList').children('.serviceUl').html('');
          block.children('td').children('.serviceProductPrice').text('0:00');
          block.children('td').children('.quantity').val('1');

          block.insertAfter(".dealPack:last");
          counter_new++;
          callToEnhanceValidate();
      });
      var callToEnhanceValidate=function()
      {

          $(".shareQty").each(function()
          {

              $(this).rules('remove');
              $(this).rules('add', {
                      required: true,
                      messages: {
                        required: "QTY is required."
                      },
               });
          });

          $(".shareRate").each(function()
          {
              $(this).rules('remove');
              $(this).rules('add', {
                      required: true,
                      messages: {
                        required: "Rate is required."
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
          $('.sharecalculation').trigger('change');
      });

      jQuery('body').on('blur', '.sharecalculation', function ()
        {
            jQuery('#tableList > tbody tr').each(function (index)
            {
                rate            = jQuery($(this)).find('.shareRate').val();
                rate            = rate.replace(/,/g, "");
                if( rate > 0 )
                    jQuery((this)).find('.shareRate').val(parseFloat(rate, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

            });
        });
      jQuery('body').on('change keyup keydown blur', '.sharecalculation', function ()
        {

    		$(this).attr("maxlength",10);
    		var elementId 			= $(this).attr('id');
            var commisionType       = jQuery('#commisionType').val();
            var discountType        = jQuery('#discountType').val();
    		if( discountType == 0 && elementId == 'discountType')
    			jQuery('#discountVal').val('0.00');
    		if( commisionType == 0 && elementId == 'commisionType')
    			jQuery('#commisionVal').val('0.00');

            var commision           = jQuery('#commisionVal').val();
            var discount            = jQuery('#discountVal').val();
            discount                = discount  || 0 ;
            commision               = commision || 0 ;
            commision               = parseFloat(commision, 10).toFixed(2);
            discount                = parseFloat(discount, 10).toFixed(2);
            var DivideBy            = 0;
            jQuery('#tableList > tbody tr').each(function (index)
            {
                rate            = jQuery($(this)).find('.shareRate').val();
                quantity        = jQuery($(this)).find('.shareQty').val();

                rate            = rate.replace(/,/g, "");
                quantity        = quantity.replace(/,/g, "");

                rate            = rate || 0 ;
                quantity        = quantity || 0 ;
                var grossAmountPerRow = parseFloat(rate) * parseFloat(quantity);
                if( grossAmountPerRow > 0 )
                    DivideBy = parseInt(DivideBy) + 1;
            });
    		if( DivideBy == 0 )
    		{
    			discount = commision = 0;
    		}
            if( discountType != 0 )
                var discountPerRow      = parseFloat(discount) / parseInt(DivideBy);
            else
                var discountPerRow      = 0;
            if( commisionType != 0 )
                var commisionPerRow     = parseFloat(commision) / parseInt(DivideBy);
            else
                var commisionPerRow     = 0;
            discountPerRow          = parseFloat(discountPerRow, 10).toFixed(2);
            commisionPerRow         = parseFloat(commisionPerRow, 10).toFixed(2);
            var totalVat            = 0;
            var subTotal            = 0;
            var grandTotal          = 0;
            var subTotalAfterDiscountNCommission   = 0;
    		var totalDiscount 	= 0;
    		var totalCommission = 0;
            jQuery('#tableList > tbody tr').each(function (index)
            {
                rate            = jQuery($(this)).find('.shareRate').val();
                quantity        = jQuery($(this)).find('.shareQty').val();
                vatPercentage   = jQuery($(this)).find('.productServiceVAT').val();

                rate            = rate.replace(/,/g, "");
                quantity        = quantity.replace(/,/g, "");

                rate            = rate || 0 ;
                quantity        = quantity || 0 ;
                vatPercentage   = vatPercentage || 0 ;

                rate            = parseFloat(rate, 10).toFixed(2);
                quantity        = parseFloat(quantity, 10).toFixed(2);
                vatPercentage   = parseFloat(vatPercentage, 10).toFixed(2);
                var grossAmountPerRow = parseFloat(rate) * parseFloat(quantity);
                grossAmountPerRow     = parseFloat(grossAmountPerRow, 10).toFixed(2);
                jQuery((this)).find('.productServiceGross').val(grossAmountPerRow.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
    			var newGrossAmountPerRow =  grossAmountPerRow;
    			var discountval = commisonval = 0;
    			if( grossAmountPerRow > 0 )
                {
    	            if( discountType == 2 )
    	            {
    	                discountval      =  parseFloat(newGrossAmountPerRow) *  parseFloat(discountPerRow) / 100 ;
    	                discountval      =  parseFloat(discountval,10).toFixed(2);
    	            }
    	            else if( discountType == 1 )
    	            {
    					discountval          =  parseFloat(discountPerRow,10).toFixed(2);
    	            }

    	            if( commisionType == 2 )
    	            {
    	                commisonval          =  parseFloat(newGrossAmountPerRow) * parseFloat(commisionPerRow) / 100 ;
    	                commisonval          =  parseFloat(commisonval,10).toFixed(2);
    	            }
    	            else if( commisionType == 1 )
    	            {
    					commisonval          =  parseFloat(commisionPerRow,10).toFixed(2);
    	            }
    				newGrossAmountPerRow	= parseFloat( newGrossAmountPerRow ) - parseFloat( discountval ) - parseFloat( commisonval );
    				newGrossAmountPerRow    =  parseFloat(newGrossAmountPerRow,10).toFixed(2);
    			}
                var vatPerRow = parseFloat(newGrossAmountPerRow) * parseFloat(vatPercentage) /100 ;
                vatPerRow     = parseFloat(vatPerRow,10).toFixed(2);
                totalVat      = parseFloat(totalVat) + parseFloat(vatPerRow);
                totalVat      = parseFloat(totalVat,10).toFixed(2);
                $('.vat').html(totalVat.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $('.inputVat').val(totalVat.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

                subTotal      = parseFloat(subTotal) + parseFloat(grossAmountPerRow);
                subTotal      = parseFloat(subTotal,10).toFixed(2);
                $('.totalServicePrice').html(subTotal.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
    			jQuery('.inputVaTotalServicePrice').val(subTotal.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                if( discountType == 2 && discount > 0 )
                {
                    discountval          =  parseFloat(discountval,10).toFixed(2);
                    totalDiscount        =  parseFloat(totalDiscount) + parseFloat(discountval);
                }
                else if( discountType == 1 && discount > 0 )
                {
                    totalDiscount =  parseFloat(discount) ;
                }

                if( commisionType == 2 && commision > 0 )
                {
                    totalCommission        =  parseFloat(totalCommission) + parseFloat(commisonval);
                }
                else if( commisionType == 1  && commision > 0 )
                {
                    totalCommission = parseFloat(commision) ;
                }
                totalCommission =  parseFloat(totalCommission,10).toFixed(2);
                totalDiscount   =  parseFloat(totalDiscount,10).toFixed(2);
                if( subTotal > 0 )
                {
    				if( totalDiscount > 0 )
                    	$('.totalDiscount').html('-'+totalDiscount.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
    				else
                    	$('.totalDiscount').html(totalDiscount.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
    				if( totalCommission > 0 )
                    	$('.totalCommision').html('-'+totalCommission.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
    				else
                    	$('.totalCommision').html(totalCommission.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                }
                else
                {
                    $('.totalDiscount').html('0.00');
                    $('.totalCommision').html('0.00');
                }
                subTotalAfterDiscountNCommission =  parseFloat(subTotal) - parseFloat(totalDiscount) - parseFloat(totalCommission);
                subTotalAfterDiscountNCommission =  parseFloat(subTotalAfterDiscountNCommission);
            });
            grandTotal    = parseFloat(grandTotal) + parseFloat(subTotalAfterDiscountNCommission) + parseFloat(totalVat);
            grandTotal    = parseFloat(grandTotal,10).toFixed(2);
            $('.totalVatPrice').html(grandTotal.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $('.inputTotalVatPrice').val(grandTotal.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
        });


});

</script>

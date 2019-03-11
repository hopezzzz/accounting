<script type="text/javascript">
$(document).ready(function ()
{
  $(document).on('keyup', '#creditorName', function(event)
	{
    $('#creditorSearchList').show();
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'getcreditorlist',
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

  }
	});
  jQuery('body').on('keyup','#creditorName', function(){
    if($(this).val().length ==0){
        jQuery('#popover-form').hide();
    }
  })
  jQuery('body').on('click','#creditorSearchList .list-group-item', function(){
      var selValue = $(this).attr('data-ref');
      var selText = $(this).text();
      if(selValue !='addNewCreditor'){
          $('#creditorRef').val(selValue);
          $('#creditorName').val(selText);
          $('#creditorSearchList').hide();
      }else{
        $('#creditorRef').val('new');
      }
  })
jQuery('body').on('click','#addNewCreditor', function(){
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
        $(".product").each(function()
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
					messages: {
						required: "Product rate is required."
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

    $(document).on('click', '.productService', function(event)
    {
        var val     = $( this ).val();
        if( val == 'addnewProduct')
        {
            $('.productService').not($(this)).each(function(){
                $(this).popover('hide');
            });
            $(this).popover({
                trigger: 'manual',
                placement: 'auto bottom',
                container: 'body',
                content: $('#myForm').html()
            }).popover('show');
            jQuery('.popover #selectedSrNo').val(jQuery(this).closest('tr').children('.serialNumberr').text());
            return false;
        }
    });
    $(document).on('change', '.productService', function(event)
    {
        var val     = $( this ).val();
        if( val != 'addnewProduct')
            $('.productService').popover('hide');
    });


    $('html').on('mouseup', function(e)
    {

        if(!$(e.target).closest('.popover').length)
        {

            $('.popover').each(function()
            {
                $(this).popover('hide');
                if($(this)+':hidden'){
                  $('.productService').each(function(){
                      if($(this).val() == 'addnewProduct'){
                          console.log(jQuery($(this).val()));
                          jQuery($(this)).val('')
                      }
                  })
                }
            });
        }
    });

    jQuery('body').on('change keyup keydown click', '.calculation', function () {
        $(this).attr("maxlength",10);
        var DiscountValue       = 0; // For DiscountValue
        var CommsionValue       = 0;
        var serviceProductPrice = 0;
        var quantity            = 0;
        var vat                 = 0;
        var oneDiscountPrice    = 0;
        var discountPrice       = 0;
        var commisionType       = jQuery('#commisionType').val();
        var commision           = jQuery('#commisionVal').val();
        var discountType        = jQuery('#discountType').val();
        var discount            = jQuery('#discountVal').val();
        var oneCommisionPrice   = 0;
        var CommPrice           = 0;
        var i                   = 0;
          jQuery('#tableList > tbody tr').each(function (index)
          {
              serviceProductPrice      = jQuery($(this)).find('.oneServiceProductPrice').val();
              quantity                 = jQuery($(this)).find('.productServiceQty').val();
              vat                      = jQuery($(this)).find('.productServiceVAT').val();
              var DivideBy             = jQuery('.serialNumberr:last').text();
              var FinalDiscount        = discount / DivideBy ;
              var FinalCommision       = commision / DivideBy ;
              var totalGrandPrice      = 0;
              var totalGrossPrice      = 0;
              if (serviceProductPrice != "" && quantity != "") {

                  var serPrice = serviceProductPrice * quantity;
                  var serPriceIncVat = serPrice * vat / 100;
                  var totalPrice = serPriceIncVat + serPrice;

                  serPrice = parseFloat(serPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  totalPrice = parseFloat(totalPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  jQuery($(this)).find('.price').val(serPrice.replace(',', ''));
                  jQuery($(this)).find('.productServiceTotal').val(totalPrice.replace(',', ''));
                  jQuery($(this)).find('.serviceProductPrice').html(serPrice);
                  jQuery($(this)).find('.vatAmount').val(serPriceIncVat);
              }
              var totalServicePrice = 0;
              var totalDiscountPrice = 0;
              jQuery('.price').each(function () {
                  var sprice = jQuery(this).val();
                  sprice = sprice.replace(',', '');
                  if (sprice != "") {
                      totalServicePrice = parseFloat(totalServicePrice) + parseFloat(sprice);
                  }
              });

              if (totalServicePrice != "" && totalServicePrice != 0) {
                  totalServicePrice = parseFloat(totalServicePrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  jQuery('.totalService').val(totalServicePrice.replace(',', ''));
                  jQuery('.totalServicePrice').html(totalServicePrice);
                  jQuery('.inputVaTotalServicePrice').val(totalServicePrice);
              } else {
                  jQuery('.totalService').val('0.00');
                  jQuery('.totalServicePrice').html('0.00');
                  jQuery('.inputVaTotalServicePrice').val('0.00');
              }

              if (totalServicePrice != "" && totalServicePrice != 0) {
                  totalServicePrice = parseFloat(totalServicePrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  jQuery('.totalService').val(totalServicePrice.replace(',', ''));
                  jQuery('.totalServicePrice').html(totalServicePrice);
                  jQuery('.inputVaTotalServicePrice').val(totalServicePrice);
              } else {
                  jQuery('.totalService').val('0.00');
                  jQuery('.totalServicePrice').html('0.00');
                  jQuery('.inputVaTotalServicePrice').val('0.00');
              }

              var productServiceGrandTotal = 0;
              jQuery('.productServiceTotal').each(function () {
                  var sprice = jQuery(this).val();
                  sprice = sprice.replace(',', '');
                  if (sprice != "") {
                      productServiceGrandTotal = parseFloat(productServiceGrandTotal) + parseFloat(sprice);
                  }
              });

              if (productServiceGrandTotal != "" ) {
                  productServiceGrandTotal = parseFloat(productServiceGrandTotal, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  jQuery('.totalDiscount').val(productServiceGrandTotal.replace(',', ''));
                  jQuery('.totalVatPrice').html(productServiceGrandTotal);
                  jQuery('.inputTotalVatPrice').val(productServiceGrandTotal);
              } else {
                  jQuery('.totalDiscount').val('0.00');
                  jQuery('.totalVatPrice').html('0.00');
                  jQuery('.inputTotalVatPrice').val('0.00');
              }

              /******************* Code ******************/
              totalGrossPrice  =  $('.totalServicePrice').text();
              totalGrandPrice  =  $('.totalVatPrice').text();
              totalGrossPrice  = totalGrossPrice.replace(",", "");
              totalGrossPrice  = totalGrossPrice.replace(",", "");
              totalGrandPrice  = totalGrandPrice.replace(",", "");
              totalGrandPrice  = totalGrandPrice.replace(",", "");
              var totalTax = totalGrandPrice - totalGrossPrice;
              totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
              jQuery('.vat').html(totalTax.replace(',', ''));
              var a = jQuery('.inputVat').val(totalTax);
              /******************* Code ******************/

              if(discount !="" && discount != 0 && discountType !=0)
              {

                if (discountType == 1 && discount != 0)
                {
                   var serPrice      = serviceProductPrice * quantity;
                   discountPrice     = serPrice - FinalDiscount;
                   oneDiscountPrice += parseFloat(serPrice) - parseFloat(FinalDiscount);
                   var vatValue      = vat / 100;
                   DiscountValue     = parseFloat(DiscountValue);
                   DiscountValue    += parseFloat(discountPrice) * parseFloat(vatValue);
                   DiscountValue     = parseFloat(DiscountValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                   $('.vat').html(DiscountValue.replace(',', ''));
                   $('.inputVat').val(DiscountValue.replace(',', ''));
                   var totalTax = parseFloat(oneDiscountPrice) + parseFloat(DiscountValue);
                   totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                   //oneDiscountPrice = parseFloat(oneDiscountPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                   //jQuery('.totalDiscount').html(oneDiscountPrice.replace(',', ''));
                   $('.totalDiscount').html(oneDiscountPrice);
                   jQuery('.totalVatPrice').html(totalTax);
                   jQuery('.inputTotalVatPrice').val(totalTax);
                }
                else if (discountType == 2 && discount != 0)
                {
                  var serPrice      = serviceProductPrice * quantity;
                  var dis           = serPrice * FinalDiscount / 100;
                  console.log(serPrice * FinalDiscount / 100);
                  discountPrice     = parseFloat(serPrice) - parseFloat(dis);
                  oneDiscountPrice += parseFloat(serPrice) - parseFloat(dis);
                  DiscountValue    += discountPrice * vat / 100;
                  DiscountValue     = parseFloat(DiscountValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  $('.vat').html(DiscountValue.replace(',', ''));
                  $('.inputVat').val(DiscountValue.replace(',', ''));
                  var totalTax = parseFloat(oneDiscountPrice) + parseFloat(DiscountValue);
                  totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  //oneDiscountPrice = parseFloat(oneDiscountPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                  jQuery('.totalDiscount').html(oneDiscountPrice);
                  jQuery('.totalVatPrice').html(totalTax);
                  jQuery('.inputTotalVatPrice').val(totalTax);
                }
                //$('.totalDiscount').html(oneDiscountPrice);
              }
              else{
                jQuery('.totalDiscount').html('0.00');
              }

              if(oneDiscountPrice !="" && oneDiscountPrice != 0 && commisionType != 0 && commision !=0)
              {

                  if (commisionType == 1  && commision !=0)
                  {

                     var commisionPrice       = 0;
                     commisionPrice           = oneDiscountPrice;
                     CommPrice               +=  FinalCommision;
                     var FinalCommisionPrice  =  parseFloat(commisionPrice) - parseFloat(CommPrice);
                     var vatValue             = vat / 100;
                     FinalCommisionPrice      = parseFloat(FinalCommisionPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                     $('.totalCommision').html(FinalCommisionPrice.replace(',', ''));
                     var vatAmount            = parseFloat(FinalCommisionPrice) * parseFloat(vatValue);
                     vatAmount                = parseFloat(vatAmount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                     var totalTax             = parseFloat(FinalCommisionPrice) + parseFloat(vatAmount);
                     totalTax                 = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                     jQuery('.vat').html(vatAmount);
                     jQuery('.inputVat').val(vatAmount);
                     jQuery('.totalVatPrice').html(totalTax);
                     jQuery('.inputTotalVatPrice').val(totalTax);
                  }
                  else if (commisionType == 2  && commision !=0)
                  {
                      var commisionPrice       = oneDiscountPrice; // Final value after discount amount
                      var commistionDiscount   = oneDiscountPrice * commision / 100; // total discount accourding
                      FinalCommisionPrice      = parseFloat(commisionPrice) - parseFloat(commistionDiscount);
                      var vatValue             = vat / 100;
                      var vatAmount            = parseFloat(FinalCommisionPrice) * parseFloat(vatValue);
                      vatAmount                = parseFloat(vatAmount, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                      var totalTax             = parseFloat(FinalCommisionPrice) + parseFloat(vatAmount);
                      totalTax                 = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                      jQuery('.vat').html(vatAmount);
                      jQuery('.inputVat').val(vatAmount);
                      jQuery('.totalVatPrice').html(totalTax);
                      jQuery('.inputTotalVatPrice').val(totalTax);
                      FinalCommisionPrice      = parseFloat(FinalCommisionPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                      $('.totalCommision').html(FinalCommisionPrice.replace(',', ''));
                      /*var serPrice      = oneDiscountPrice;
                      var dis           = serPrice * FinalCommision / 100;
                      discountPrice     = parseFloat(serPrice) - parseFloat(dis);
                      oneDiscountPrice += parseFloat(serPrice) - parseFloat(dis);
                      DiscountValue    += discountPrice * vat / 100;
                      DiscountValue     = parseFloat(DiscountValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                      $('.vat').html(DiscountValue.replace(',', ''));
                      $('.inputVat').val(DiscountValue.replace(',', ''));
                      var totalTax = parseFloat(oneDiscountPrice) + parseFloat(DiscountValue);
                      totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                      //oneDiscountPrice = parseFloat(oneDiscountPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                      jQuery('.totalCommision').html(oneDiscountPrice);
                      jQuery('.totalVatPrice').html(totalTax);
                      jQuery('.inputTotalVatPrice').val(totalTax);*/

                  }
                  else
                  {
                      jQuery('.totalCommision').html('0.00');
                  }

              }
              else {
                      $('.totalCommision').html('0.00');
                      if( commisionType != 0 && commision !=0)
                      {

                          if (commisionType == 1 && commision !=0)
                          {
                            var serPrice           = serviceProductPrice * quantity;
                            var commisionPrice     = serPrice - FinalCommision;
                            CommPrice             += parseFloat(serPrice) - parseFloat(FinalCommision);
                            var vatValue      = vat / 100;
                            CommsionValue     = parseFloat(CommsionValue);
                            CommsionValue    += parseFloat(commisionPrice) * parseFloat(vatValue);
                            CommsionValue     = parseFloat(CommsionValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                            $('.vat').html(CommsionValue.replace(',', ''));
                            $('.inputVat').val(CommsionValue.replace(',', ''));
                            var totalTax = parseFloat(CommPrice) + parseFloat(CommsionValue);
                            totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                            jQuery('.totalCommision').html(CommPrice);
                            jQuery('.totalVatPrice').html(totalTax);
                            jQuery('.inputTotalVatPrice').val(totalTax);
                          }
                          else if (commisionType == 2 && commision !=0)
                          {

                            var serPrice      = serviceProductPrice * quantity;
                            console.log('serPrice => ' + serPrice);
                            var dis           = serPrice * commision / 100;
                            console.log('dis => ' + dis);
                            discountPrice     = parseFloat(serPrice) - parseFloat(dis);
                            console.log('discountPrice=> ' + discountPrice );
                            oneDiscountPrice += parseFloat(serPrice) - parseFloat(dis);
                            console.log('oneDiscountPrice => ' + oneDiscountPrice);
                            DiscountValue    += discountPrice * vat / 100;
                            console.log('DiscountValue=>' + DiscountValue );
                            DiscountValue     = parseFloat(DiscountValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                            $('.vat').html(DiscountValue.replace(',', ''));
                            $('.inputVat').val(DiscountValue.replace(',', ''));
                            var totalTax = parseFloat(oneDiscountPrice) + parseFloat(DiscountValue);
                            totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                            //oneDiscountPrice = parseFloat(oneDiscountPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                            jQuery('.totalCommision').html(oneDiscountPrice);
                            jQuery('.totalVatPrice').html(totalTax);
                            jQuery('.inputTotalVatPrice').val(totalTax);

                          }
                          else{
                              jQuery('.totalCommision').html('0.00');
                          }

                      }
                      else {
                              $('.totalCommision').html('0.00');
                          }
              }

          });


    });

      jQuery('body').on('click','#newProduct', function(){
          var ProductName = jQuery('.popover .ProductName').val();
          var srNo = jQuery('.popover #selectedSrNo').val();
          if(ProductName !=""){
            $.ajax({
                type: "POST",
                url: site_url + 'ajaxaddnewproduct',
                data: {'productName' : ProductName },
                dataType: "json",
                success: function (response) {
                  if(response.errorMsg !=""){
                      jQuery('.popover .popover-content').find('#errMsg').html(response.errorMsg).fadeOut(7000);
                  }
                  var toAppend = '';
                   toAppend += '<option value="'+ response.productData[0]['productRef'] +'">'+response.productData[0]['productName']+'</option>';
                   $('.productService').append(toAppend);
                   jQuery('.trSrNo'+srNo).find('.productService').val(response.productData[0]['productRef']);
                   jQuery('.popover').hide();
                }
            });
        }else{
          jQuery('.popover .ProductName').css('border','1px solid red');
          jQuery('.popover .ProductName').attr("placeholder", "This field is required");
        }
      });
      /** Trigger calculation Fucntion using class .calculation **/
      $('.calculation').trigger('change');
});

</script>

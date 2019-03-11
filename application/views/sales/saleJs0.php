<script type="text/javascript">
$(document).ready(function ()
{
  $(document).on('keyup', '#debtorName', function(event)
	{
    $('#debtorSearchList').show();
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'getDebitorList',
          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
          success: function (response) {
              if(response.length > 1){
                $('#debtorSearchList').html(response);
                  $('#popover-form').addClass('hide');
              }
          }
      });
  }else{
      $('#debtorSearchList').html('');

  }
	});

  jQuery('body').on('click','#debtorSearchList .list-group-item', function(){
      var selValue = $(this).attr('data-ref');
      var selText = $(this).text();
      if(selValue !='addNewDebtor'){
          $('#debtorRef').val(selValue);
          $('#debtorName').val(selText);
          $('#debtorSearchList').hide();
      }
  })
jQuery('body').on('click','#addNewCreditor', function(){
  $('#addNewCreditor').hide();
  $('#debtorSearchList').hide();
  $('#popover-form').removeClass('hide');
  $('#popover-form').css('border','1px solid #ddd');
});


var counter_new = 2;
    jQuery('body').on('click', '#addLayer', function () {
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
        block.children('td').children('.removeLayer').remove();
        block.children('td input.addNewProductService').addClass('hidden');
        block.children('td.addMins').append('<span class="removeLayer"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');
      //  block.children('td').children('input').val('');
        block.children('td').children('input').css('border', '1px solid #c1c1c1');
      //  block.children('td').children('select').val('');
        block.children('td').children('select').css('border', '1px solid #c1c1c1');
        block.children('td').children('#serviceProductPrice').text('0:00');
        block.children('td').children('.serviceList').children('.serviceUl').html('');
        block.children('td').children('.serviceProductPrice').text('0:00');
        block.children('td').children('.quantity').val('1');
        block.children('td').children('.discoutType').val('0');
        block.children('td').children('.discountPrice').text('0:00');

        block.insertAfter(".dealPack:last");
        counter_new++;
    });

    jQuery('body').on('click', '.removeLayer', function () {

        jQuery(this).parent('td').parent('tr').remove();
        var count = 0;
        jQuery('.serialNumberr').each(function () {
            jQuery(this).text(parseInt(count) + parseInt(1));
            count++;
            //console.log(count);
        });
        if (count == 1 || count == 0) {
            jQuery('td').children('.removeLayer').remove();
        }

        var totalServicePrice = 0;
        jQuery('.price').each(function () {
            var sprice = jQuery(this).val();
            sprice = sprice.replace(',', '');
            if (sprice != "") {
                totalServicePrice = parseFloat(totalServicePrice) + parseFloat(sprice);
            }
        });
        $('.totalServicePrice').html(totalServicePrice + '.00');
        var productServiceGrandTotal = 0;
        jQuery('.productServiceTotal').each(function () {
            var sprice = jQuery(this).val();
            sprice = sprice.replace(',', '');
            if (sprice != "") {
                productServiceGrandTotal = parseFloat(productServiceGrandTotal) + parseFloat(sprice);
            }
        });
        $('.totalVatPrice').html(productServiceGrandTotal + '.00');
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

    jQuery('body').on('change','.productService',function() {
        $(this).hide();
        var value = $(this).val();
        if(value == 'addnewProduct'){
            var parentMain = $(this).closest('tr');
            $(parentMain).find('input').removeClass('hidden');
        }else{
            $(this).show();
            $(parentMain).children('input').addClass('hidden');
        }
      });
      jQuery('body').on('keyup', '.calculation', function () {

          var currentSelect = jQuery(this);
          var serviceProductPrice = jQuery(currentSelect).closest('tr').find('.oneServiceProductPrice').val();
          var quantity = jQuery(currentSelect).closest('tr').find('.productServiceQty').val();
          var vat = jQuery(currentSelect).closest('tr').find('.productServiceVAT').val();
          var totalVatPrice = jQuery(currentSelect).closest('tr').find('.productServiceTotal').val();

          if (serviceProductPrice != "" && quantity != "") {
              var serPrice = serviceProductPrice * quantity;
              var serPriceIncVat = serPrice * vat / 100;
              var totalPrice = serPriceIncVat + serPrice;
              serPrice = parseFloat(serPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
              totalPrice = parseFloat(totalPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
              jQuery(currentSelect).closest('tr').find('.price').val(serPrice.replace(',', ''));
              jQuery(currentSelect).closest('tr').find('.productServiceTotal').val(totalPrice.replace(',', ''));
              jQuery(currentSelect).closest('tr').find('.serviceProductPrice').html(serPrice);
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
          } else {
              jQuery('.totalService').val('0.00');
              jQuery('.totalServicePrice').html('0.00');
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
          } else {
              jQuery('.totalDiscount').val('0.00');
              jQuery('.totalVatPrice').html('0.00');
          }
          var totalGrossPrice  =  $('.totalServicePrice').text();
          var totalGrandPrice  =  $('.totalVatPrice').text();
          totalGrossPrice = totalGrossPrice.replace(",", "");
          totalGrossPrice = totalGrossPrice.replace(",", "");

          totalGrandPrice = totalGrandPrice.replace(",", "");
          totalGrandPrice = totalGrandPrice.replace(",", "");
          var totalTax = totalGrandPrice - totalGrossPrice;
          totalTax = parseFloat(totalTax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
          jQuery('.vat').html(totalTax.replace(',', ''));

        //  totalServicePrice = totalServicePrice.replace(',', '');
        //  calcPerc = parseFloat(calcPerc, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
          //jQuery('#discountPercentage').val(calcPerc.replace(',', ''));
      });

      jQuery('body').on('change keyup keydown',".discoutCal", function(){

          var DiscountValue = 0;
          var servicePrice = 0;
          var quantity = 0;
          var vat = 0;
          var discountType = jQuery('#discountType').val();
          var discount = jQuery('#discountVal').val();
          var oneDiscountPrice = 0;
          if(discount !="" && discount != 0){
              jQuery('#tableList > tbody tr').each(function () {
                servicePrice = jQuery($(this)).find('.oneServiceProductPrice').val();
                quantity = jQuery($(this)).find('.productServiceQty').val();
                vat = jQuery($(this)).find('.productServiceVAT').val();
                var DivideBy = jQuery('.serialNumberr:last').text();
                var FinalDiscount = discount / DivideBy ;
                console.log(FinalDiscount);
                if (discountType == 1) {

                   var serPrice = servicePrice * quantity;
                   var discountPrice = 0;
                   discountPrice = serPrice - FinalDiscount;
                   var vatAmount = discountPrice * vat / 100;
                   oneDiscountPrice += serPrice - FinalDiscount;

                   DiscountValue = discountPrice * vat / 100;
                   DiscountValue = parseFloat(DiscountValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                   $('.vat').html(DiscountValue.replace(',', ''));
               } else {
                   var serPrice = servicePrice * quantity;
                   var dis = serPrice * discount / 100;
                   var discountPrice = serPrice - dis;
                       oneDiscountPrice += serPrice - dis;
                       DiscountValue = discountPrice * vat / 100;
                       DiscountValue = parseFloat(DiscountValue, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
                       $('.vat').html(DiscountValue.replace(',', ''));

                    //$('.vat').html(discountPrice * vat / 100);
                 }


        });
        }
            $('.totalDiscount').html(oneDiscountPrice);


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
                  placement: 'right',
                  container: 'body',
                  content: $('#myForm').html()
              }).popover('show');
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
              });
          }
      });
});

</script>

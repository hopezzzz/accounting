$(document).ready(function ()
{
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	$(document).on('keypress keyup', '#searchKey,#fromDate,#toDate', function(event)
	{
		var dataContainer = $('#pageType').attr('data-container');
	    if(event.which == 13)
		{
			if( dataContainer != '' && dataContainer != undefined )
				var searchKey 	  = $(dataContainer).find('#tableSearchBtn').trigger('click');
			else
	        	$('#tableSearchBtn').trigger('click');
	    }
		else if(event.which == 8)
		{
			var searchKey = $(this).val();
			if( searchKey == '' )
			{
				if( dataContainer != '' && dataContainer != undefined )
					var searchKey 	  = $(dataContainer).find('#tableSearchBtn').trigger('click');
				else
					$('#tableSearchBtn').trigger('click');
			}
		}
	});

	$(document).on('click', '#sameAsBilling', function(event)
	{
		if($(this).prop("checked") == true)
		{
			$('.ShiipingInput').val('').attr('disabled',true);
		}
		else {
			$('.ShiipingInput').val('').attr('disabled',false);
		}
	});

	$(document).on('click', '#tableSearchBtn', function(event)
	{
		var dataContainer = $('#pageType').attr('data-container');
		var url		  	  = $(this).attr('data-url');
		if( dataContainer != '' && dataContainer != undefined )
			var searchKey 	  = $(dataContainer).find("#searchKey").val();
		else
			var searchKey 	  = $('#searchKey').val();

		var fromDate   = $('#fromDate').val();
		var toDate 	   = $('#toDate').val();

		searchKey 	  = $.trim(searchKey);
		fromDate 	  = $.trim(fromDate);
		toDate 	  	  = $.trim(toDate);

		if( url != '')
		{
			$.ajax({
				type	 : "POST",
				dataType : "json",
				data	 : {'searchKey':searchKey,'page':1,'fromDate':fromDate,'toDate':toDate},
				url		 : url,
				beforeSend  : function () {
					$(".loader_div").show();
				},
				complete: function () {
					$(".loader_div").hide();
				},
				success: function(response)
				{
					if( dataContainer != '' && dataContainer != undefined )
						$(dataContainer).find("#tableData").html(response.html);
					else
					$("#tableData").html(response.html);
				},
				error:function(response){
					$.toast({
						heading             : 'Error',
						text                : 'Connection Error.',
						loader              : true,
						loaderBg            : '#fff',
						showHideTransition  : 'fade',
						icon                : 'error',
						hideAfter           : 2000,
						position            : 'top-right'
					});
				}
			});
		}
	});

	$(document).on('click', '.ajax_pagingUL a', function(event)
	{
		event.preventDefault();
		var dataContainer = $('#pageType').attr('data-container');
		var searchKey 	  = $('#searchKey').val();
		searchKey 	      = $.trim(searchKey);
		if( $(this).parent('li').hasClass('active') )
			return true;
		var url  = $(this).attr("href");
		var page = $(this).attr("data-ci-pagination-page");
		$.ajax({
			type	 : "POST",
			dataType : "json",
			data	 : {'searchKey':searchKey,'page':page},
			url		 : url,
			beforeSend  : function () {
				$(".loader_div").show();
			},
			complete: function () {
				$(".loader_div").hide();
			},
			success: function(response)
			{
				if( dataContainer != '' && dataContainer != undefined )
					$(dataContainer).find("#tableData").html(response.html);
				else
					$("#tableData").html(response.html);
			},
			error:function(response){
				$.toast({
					heading             : 'Error',
					text                : 'Connection Error.',
					loader              : true,
					loaderBg            : '#fff',
					showHideTransition  : 'fade',
					icon                : 'error',
					hideAfter           : 2000,
					position            : 'top-right'
				});
			}
		});
		return false;
	});

	$(document).on('click', '.deleteRecord', function(event)
	{
		var name = $(this).attr('data-name');
		var ref  = $(this).attr('data-ref');
		var type = $(this).attr('data-type');
		localStorage.setItem('DeleteRecordLabel',name);
		localStorage.setItem('DeleteRecordRef',ref);
		localStorage.setItem('DeleteRecordType',type);
		$('#confirm-delete-modal').modal('show');
	});

	$(document).on('click', '.deleteRecordBtn', function(event)
	{
		var DeleteRecordLabel 	= localStorage.getItem('DeleteRecordLabel');
		var DeleteRecordRef 	= localStorage.getItem('DeleteRecordRef');
		var DeleteRecordType 	= localStorage.getItem('DeleteRecordType');

		if( DeleteRecordRef == '' || DeleteRecordType == '' )
		{
			$.toast({
				heading             : 'Error',
				text                : 'Something is missing. Please try again.',
				loader              : true,
				loaderBg            : '#fff',
				showHideTransition  : 'fade',
				icon                : 'error',
				hideAfter           : 2000,
				position            : 'top-right'
			});
		}
		else
		{
			$.ajax({
				url         : site_url+'delete-record',
				type        : "post",
				data        : { 'type':DeleteRecordType,'ref':DeleteRecordRef },
				dataType    : "json",
				beforeSend  : function ()
				{
					$(".loader_div").show();
				},
				complete: function ()
				{
					$(".loader_div").hide();
				},
				success: function (response)
				{
					$(".loader_div").hide();
					if (response.success)
					{
						$.toast({
							heading             : 'Success',
							text                : response.success_message,
							loader              : true,
							loaderBg            : '#fff',
							showHideTransition  : 'fade',
							icon                : 'success',
							hideAfter           : 2000,
							position            : 'top-right'
						});
						$('#'+DeleteRecordType+'_'+DeleteRecordRef).remove();
						var tableTrCount = $('#tableData').find('table tbody tr').length;
						if( tableTrCount <= 0 )
						{
							var page = $('#ajax_pagingsearc1').find('li.active').find('a').text();
							if( page == 1 )
								$('#ajax_pagingsearc1').find('li').eq(1).find('a').trigger('click');
							else if( page > 1 )
							{
								page = parseInt(page) - 1 ;
								$('#ajax_pagingsearc1').find('li').eq(page).find('a').trigger('click');
							}
						}
						$('#confirm-delete-modal').modal('hide');
						localStorage.setItem('DeleteRecordLabel','');
						localStorage.setItem('DeleteRecordRef','');
						localStorage.setItem('DeleteRecordType','');
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
							hideAfter           : 2000,
							position            : 'top-right'
						});
						$('#confirm-delete-modal').modal('hide');
					}
					if(response.ajaxPageCallBack)
					{
						ajaxPageCallBack(response);
					}
					if(response.url)
					{
						if(response.delayTime)
							setTimeout(function() { window.location.href=response.url;}, response.delayTime);
						else
							window.location.href=response.url;
					}
				},
				error:function(response){
					$.toast({
						heading             : 'Error',
						text                : 'Connection error.',
						loader              : true,
						loaderBg            : '#fff',
						showHideTransition  : 'fade',
						icon                : 'error',
						hideAfter           : 4000,
						position            : 'top-right'
					});
				}
			});
		}
	});


	$(document).on('click', '.updateStatus', function(event)
	{
		var name 	= $(this).attr('data-name');
		var ref  	= $(this).attr('data-ref');
		var type 	= $(this).attr('data-type');
		var status 	= $(this).attr('data-status');

		localStorage.setItem('RecordLabel',name);
		localStorage.setItem('RecordStatus',status);
		localStorage.setItem('RecordRef',ref);
		localStorage.setItem('RecordType',type);

		$('#confirm-status-update-modal').modal('show');
		if( status == 1)
			var status = 'Inactive';
		else
			var status = 'Active';
		$('#confirm-status-update-modal').find('.modal-body').find('.statusLabel').html('<strong>'+name+'</strong> '+status);
	});

	$(document).on('click', '.updateRecordStatusBtn', function(event)
	{
		var name 	= localStorage.getItem('RecordLabel');
		var status 	= localStorage.getItem('RecordStatus');
		var ref  	= localStorage.getItem('RecordRef');
		var type 	= localStorage.getItem('RecordType');

		if( ref == '' || type == '' || status == '' )
		{
			$.toast({
				heading             : 'Error',
				text                : 'Something is missing. Please try again.',
				loader              : true,
				loaderBg            : '#fff',
				showHideTransition  : 'fade',
				icon                : 'error',
				hideAfter           : 2000,
				position            : 'top-right'
			});
		}
		else
		{
			$.ajax({
				url         : site_url+'update-status',
				type        : "post",
				data        : { 'type':type,'ref':ref, 'status':status },
				dataType    : "json",
				beforeSend  : function ()
				{
					$(".loader_div").show();
				},
				complete: function ()
				{
					$(".loader_div").hide();
				},
				success: function (response)
				{
					$(".loader_div").hide();
					if (response.success)
					{
						$.toast({
							heading             : 'Success',
							text                : response.success_message,
							loader              : true,
							loaderBg            : '#fff',
							showHideTransition  : 'fade',
							icon                : 'success',
							hideAfter           : 2000,
							position            : 'top-right'
						});
						if( response.status == 1 )
						{
							$('#'+type+'_'+ref).find('.statusTd').html('<span class="label label-success">Active</span>');
							$('#'+type+'_'+ref).find('.updateStatus').html('Make Inactive').attr('data-status',response.status);
						}
						else
						{
							$('#'+type+'_'+ref).find('.statusTd').html('<span class="label label-warning">Inactive</span>');
							$('#'+type+'_'+ref).find('.updateStatus').html('Make Active').attr('data-status',response.status);
						}
						$('#confirm-status-update-modal').modal('hide');
						localStorage.setItem('RecordLabel','');
						localStorage.setItem('RecordStatus','');
						localStorage.setItem('RecordRef','');
						localStorage.setItem('RecordType','');
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
							hideAfter           : 2000,
							position            : 'top-right'
						});
						$('#confirm-status-update-modal').modal('hide');
					}
					if(response.ajaxPageCallBack)
					{
						ajaxPageCallBack(response);
					}
					if(response.url)
					{
						if(response.delayTime)
							setTimeout(function() { window.location.href=response.url;}, response.delayTime);
						else
							window.location.href=response.url;
					}
				},
				error:function(response){
					$.toast({
						heading             : 'Error',
						text                : 'Connection error.',
						loader              : true,
						loaderBg            : '#fff',
						showHideTransition  : 'fade',
						icon                : 'error',
						hideAfter           : 4000,
						position            : 'top-right'
					});
				}
			});
		}
	});
	$(document).on('click', '.savePaymentStatus', function(event)
	{
		$.toast().reset('all');
		var transactionRef  = $(this).attr('data-ref');
		var type 			= $(this).attr('data-type');
		var deliveryDate    = $(this).attr('data-deliverydate');

		localStorage.setItem('PaymentTransactionRef',transactionRef);
		localStorage.setItem('PaymentTransactionType',type);
		$('#confirm-payment-status-modal').find('.form-group').removeClass('has-error');
		$('#confirm-payment-status-modal').find('input').val('');
		$('#confirm-payment-status-modal').find('select').val('');
		if( deliveryDate != '' )
		{
			deliveryDate1 = deliveryDate;
			deliveryDate  = deliveryDate.split('-');
			deliveryDate = new Date(deliveryDate[2]+'-'+deliveryDate[1]+'-'+deliveryDate[0]);
			$('#paymentDateSelect').datepicker('setStartDate', deliveryDate);
			$('#paymentDateSelect').val(deliveryDate1);
		}

		$.ajax({
			url         : site_url+'get-pending-amount',
			type        : "post",
			data        : { 'transactionRef':transactionRef, 'type' : type },
			dataType    : "json",
			beforeSend  : function ()
			{
				$(".loader_div").show();
			},
			complete: function ()
			{
				$(".loader_div").hide();
			},
			success: function (response)
			{
				$(".loader_div").hide();
				if (response.success)
				{
					$('#transactionTotalPaymentPopup').val(response.totalAmount);
					$('#transactionPaymentReceivedPopup').val(response.paymentReceived);
					$('#transactionPaymentPendingPopup').val(response.paymentPending);
					localStorage.setItem('PaymentPending',response.paymentPending);
					$('#confirm-payment-status-modal').modal('show');
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
							hideAfter           : 2000,
							position            : 'top-right'
					});
				}
			},
			error:function(response){
				$.toast({
					heading             : 'Error',
					text                : 'Connection error.',
					loader              : true,
					loaderBg            : '#fff',
					showHideTransition  : 'fade',
					icon                : 'error',
					hideAfter           : 2000,
					position            : 'top-right'
				});
			}
		});
	});
	$(document).on('change', '.receivePaymentMethod', function(event)
	{
		var paymentMethod = $(this).val();
		if( paymentMethod == 1 )
			$('.receivePaymentBankRef').val('');
	});
	$(document).on('change', '.receivePaymentBankRef', function(event)
	{
		var bankRef = $(this).val();
		if( bankRef != '' )
			$('.receivePaymentMethod').val('2');
	});
	$(document).on('click', '.savePaymentBtn', function(event)
	{
		$.toast().reset('all');
		$('#confirm-payment-status-modal').find('.form-group').removeClass('has-error');
		$("#paymentDateSelect").datepicker({
	        autoclose   : true,
	        format      : 'dd-mm-yyyy',
	        startDate   : new Date()
	    });
	    var paymentDate      = $('#paymentDateSelect').val();
	    var paymentMethod    = $('.receivePaymentMethod').val();
	    var paymentBankRef   = $('.receivePaymentBankRef').val();
	    var receiveAmount    = $('.receivePaymentAmount').val();
		var transactionRef   = localStorage.getItem('PaymentTransactionRef');
		var type   		     = localStorage.getItem('PaymentTransactionType');
		var PaymentPending   = localStorage.getItem('PaymentPending');
		PaymentPending   	 = PaymentPending.replace(/,/g, "")
		var isError			 = false;
		if(paymentDate == '')
		{
			$('#paymentDateSelect').parents('.form-group').addClass('has-error');
			isError = true;
		}
		if(paymentMethod == '')
		{
			$('.receivePaymentMethod').parents('.form-group').addClass('has-error');
			isError = true;
		}
		if(paymentMethod == 2 && paymentBankRef == '')
		{
			$('.receivePaymentBankRef').parents('.form-group').addClass('has-error');
			isError = true;
		}
		if(receiveAmount == '' || receiveAmount <= 0 || !$.isNumeric(receiveAmount))
		{
			$('.receivePaymentAmount').parents('.form-group').addClass('has-error');
			isError = true;
		}
		if( parseFloat(receiveAmount) > parseFloat(PaymentPending) )
		{
			$('.receivePaymentAmount').parents('.form-group').addClass('has-error');
			$.toast({
					heading             : 'Error',
					text                :  'Amount can not be greater than pending amount.',
					loader              : true,
					loaderBg            : '#fff',
					showHideTransition  : 'fade',
					icon                : 'error',
					hideAfter           : 2000,
					position            : 'top-right'
			});
			isError = true;
		}
		if(isError)
		{
			return false;
		}
	    else if(!isError)
	    {
		  	$.ajax({
			  	url         : site_url+'mark-as-paid',
			  	type        : "post",
			  	data        : { 'paymentDate':paymentDate,'transactionRef':transactionRef, 'type' : type, 'paymentMethod': paymentMethod,'receiveAmount':receiveAmount,'paymentBankRef':paymentBankRef },
			  	dataType    : "json",
			  	beforeSend  : function ()
			  	{
				  	$(".loader_div").show();
			  	},
			  	complete: function ()
			  	{
				  	$(".loader_div").hide();
			  	},
			  	success: function (response)
			  	{
				  	$(".loader_div").hide();
				  	if (response.success)
				  	{
						$.toast({
							heading             : 'Success',
							text                : response.success_message,
							loader              : true,
							loaderBg            : '#fff',
							showHideTransition  : 'fade',
							icon                : 'success',
						  	hideAfter           : 2000,
						  	position            : 'top-right'
						});
						if (response.paid)
						{
							paymentDate = paymentDate.split('-');
							paymentDate = new Date(paymentDate[2]+'-'+paymentDate[1]+'-'+paymentDate[0]);
							$('#'+type+'_'+transactionRef).find('.paymentStatusTd').html('<span class="label label-success">Paid</span>');
							$('#'+type+'_'+transactionRef).find('.paymentDateTd').html(paymentDate.getDate()+ ' '+ monthNames[paymentDate.getMonth()] +' '+paymentDate.getFullYear());
							$('#'+type+'_'+transactionRef).find('.paymentStatusLi').remove();
							localStorage.setItem('PaymentTransactionRef','');
							localStorage.setItem('PaymentTransactionType','')
							localStorage.setItem('PaymentPending','')
						}
					  	$('#confirm-payment-status-modal').modal('hide');
				  	}
				  	else
				  	{
						if( response.formErrors )
						{
							$(response.errorInput).parents('.form-group').addClass('has-error');
						}
					  	$.toast({
								heading             : 'Error',
								text                : response.error_message,
								loader              : true,
								loaderBg            : '#fff',
								showHideTransition  : 'fade',
								icon                : 'error',
								hideAfter           : 2000,
								position            : 'top-right'
					  	});
				  	}
			  	},
			  	error:function(response){
					$.toast({
						heading             : 'Error',
						text                : 'Connection error.',
						loader              : true,
						loaderBg            : '#fff',
						showHideTransition  : 'fade',
						icon                : 'error',
						hideAfter           : 2000,
						position            : 'top-right'
					});
			  	}
		  	});
	    }

	});

	jQuery('body').on('click','#newProduct', function()
    {
        var ProductName = jQuery('.popover .ProductName').val();
        var srNo        = jQuery('.popover #selectedSrNo').val();
        if( ProductName !="" )
        {
            $.ajax({
                type    : "POST",
                url     : site_url + 'ajaxaddnewproduct',
                data    : {'productName' : ProductName },
                dataType: "json",
                success : function (response)
                {
                    if( !response.success )
                    {
                        jQuery('.popover .popover-content').find('#errMsg').html(response.errorMsg).fadeOut(7000);
                    }
                    else
                    {
                        jQuery('.trSrNo'+srNo).find('.productService').val(response.productData['productName']);
												jQuery('.trSrNo'+srNo).find('.productRef').val(response.productData['productRef']);
                        jQuery('.popover').hide();
                    }
                }
            });
        }
        else
        {
            jQuery('.popover .ProductName').css('border','1px solid red');
            jQuery('.popover .ProductName').attr("placeholder", "This field is required");
        }
    });




	jQuery('body').on('blur', '.calculation', function ()
    {
        jQuery('#tableList > tbody tr').each(function (index)
        {
            rate            = jQuery($(this)).find('.oneServiceProductPrice').val();
            quantity        = jQuery($(this)).find('.productServiceQty').val();
            rate            = rate.replace(/,/g, "");
            quantity        = quantity.replace(/,/g, "");
            if( rate > 0 )
                jQuery((this)).find('.oneServiceProductPrice').val(parseFloat(rate, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            // if( quantity > 0 )
            // jQuery((this)).find('.productServiceQty').val(parseFloat(quantity, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
        });
    });

	jQuery('body').on('change keyup keydown blur', '.calculation', function ()
    {

		$(this).attr("maxlength",10);
		var elementId 			= $(this).attr('id');
				var purchaseType = jQuery('#purchaseType').val();
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
            rate            = jQuery($(this)).find('.oneServiceProductPrice').val();
            quantity        = jQuery($(this)).find('.productServiceQty').val();

            rate            = rate.replace(/,/g, "");
            quantity        = quantity.replace(/,/g, "");

            rate            = rate || 0 ;
            quantity        = quantity || 0 ;

						grocePrice      = jQuery($(this)).find('.productServiceGross').val();

						grocePrice			= grocePrice || 0 ;

						if(purchaseType == 1)
						{
							  var grossAmountPerRow = parseFloat(grocePrice);
						}else
						{
							  var grossAmountPerRow = parseFloat(rate) * parseFloat(quantity);
						}

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
            rate            = jQuery($(this)).find('.oneServiceProductPrice').val();
            quantity        = jQuery($(this)).find('.productServiceQty').val();
            vatPercentage   = jQuery($(this)).find('.productServiceVAT').val();

						grocePrice      = jQuery($(this)).find('.productServiceGross').val();




            rate            = rate.replace(/,/g, "");
            quantity        = quantity.replace(/,/g, "");

            rate            = rate || 0 ;
            quantity        = quantity || 0 ;
            vatPercentage   = vatPercentage || 0 ;
						grocePrice			= grocePrice || 0 ;


            rate            = parseFloat(rate, 10).toFixed(2);
            quantity        = parseFloat(quantity, 10).toFixed(2);
            vatPercentage   = parseFloat(vatPercentage, 10).toFixed(2);
            grocePrice   = parseFloat(grocePrice, 10).toFixed(2);

						if(purchaseType == 1)
						{
							  var grossAmountPerRow = parseFloat(grocePrice);
						}else
						{
							  var grossAmountPerRow = parseFloat(rate) * parseFloat(quantity);
						}


            grossAmountPerRow     = parseFloat(grossAmountPerRow, 10).toFixed(2);
						if(purchaseType == 1)
						{
							jQuery((this)).find('.productServiceGross').val(grossAmountPerRow);
						}else
						{
								jQuery((this)).find('.productServiceGross').val(grossAmountPerRow.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
						}

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
            jQuery((this)).find('.vatAmount').val(vatPerRow);
            jQuery((this)).find('.discountAmountPerItem').val(discountval);
            jQuery((this)).find('.commisionAmountPerItem').val(commisonval);
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

	$(document).on('click', '.showRecordsByReference', function(event)
	{
		var reference  = $(this).attr('data-ref');
		var type       = $(this).attr('data-type');
		reference      = $.trim(reference);
		type	       = $.trim(type);
		if( type != '' && reference != '')
		{
			$.ajax({
				type	 : "POST",
				dataType : "json",
				data	 : {'reference':reference,'type':type},
				url		 : site_url+'/show-records-by-reference',
				beforeSend  : function () {
					$(".loader_div").show();
				},
				complete: function () {
					$(".loader_div").hide();
				},
				success: function(response)
				{
					if( response.success && response.redirectUrl != '' )
					{
						window.location.href = response.redirectUrl;
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
							hideAfter           : 2000,
							position            : 'top-right'
						});
					}
				},
				error:function(response){
					$.toast({
						heading             : 'Error',
						text                : 'Connection Error.',
						loader              : true,
						loaderBg            : '#fff',
						showHideTransition  : 'fade',
						icon                : 'error',
						hideAfter           : 2000,
						position            : 'top-right'
					});
				}
			});
		}
	});

	$(document).on('click', '.resetshowRecordsByRefenence', function(event)
	{
		var currentUrl  = $(this).attr('data-url');
		currentUrl	    = $.trim(currentUrl);
		if( currentUrl != '' )
		{
			$.ajax({
				type	 : "POST",
				dataType : "json",
				data	 : {'currentUrl':currentUrl},
				url		 : site_url+'/reset-records-by-reference',
				beforeSend  : function () {
					$(".loader_div").show();
				},
				complete: function () {
					$(".loader_div").hide();
				},
				success: function(response)
				{
					if( response.success )
					{
						window.location.href = currentUrl;
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
							hideAfter           : 2000,
							position            : 'top-right'
						});
					}
				},
				error:function(response){
					$.toast({
						heading             : 'Error',
						text                : 'Connection Error.',
						loader              : true,
						loaderBg            : '#fff',
						showHideTransition  : 'fade',
						icon                : 'error',
						hideAfter           : 2000,
						position            : 'top-right'
					});
				}
			});
		}
	});

	jQuery(document).on('click','.productList .list-group-item', function()
	{
	    var no = jQuery(this).closest('tr').children('.serialNumberr').text();
	    var productRef = jQuery('.trSrNo'+no).find('.productRef').attr('name');
			jQuery('.trSrNo'+no).find('.productRef').next().hide();
	    var selValue = $.trim($(this).attr('data-ref'));
	    var selText = $.trim($(this).text());
	      if(selValue !='addnewProduct'){
	          jQuery('.trSrNo'+no).find('.productRef').val(selValue);
	          jQuery('.trSrNo'+no).find('.productService').val(selText);
	          $('.productList').addClass('hide');
	      }

	  });

		$(document).on('keyup', '.productSearch', function(event)
		{
	    var no = jQuery(this).closest('tr').children('.serialNumberr').text();
			jQuery('.trSrNo'+no).find('.productRef').val('');
	    jQuery('.trSrNo'+no).find('.productList').removeClass('hide').show();
	    if($(this).val() !=""){
	      $.ajax({
	          type: "POST",
	          url: site_url + 'getproductslist',
	          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
						beforeSend  : function () {
	             $(".loader_div").show();
	          },
	          complete: function () {
	             $(".loader_div").hide();
	          },
	          success: function (response) {
	              if(response.length > 1){
	                jQuery('.trSrNo'+no).find('.productList').html(response);
	              }
	          }
	      });
	  }else{
	       jQuery('.trSrNo'+no).find('.productList').addClass('hide').hide();

	  }
		});
		$('html').on('mouseup', function(e)
    {
        if(!$(e.target).closest('.popover').length)
        {
						if($('#shareHolderList:visible')){
								$('#shareHolderList').hide();
						}
						if($('#creditorSearchList:visible')){
								$('#creditorSearchList').hide();
						}
						if($('#debtorSearchList:visible')){
								$('#debtorSearchList').hide();
						}
						if($('#borrowSearchList:visible')){
								$('#borrowSearchList').hide();
						}
						if (!$('.categoryList').hasClass("hide")) {
								$('.categoryList').addClass('hide');
						}

            $('.popover').each(function()
            {

                $(this).popover('hide');
                if($(this)+':hidden'){
                  $('#bankRef').each(function(){
                      if($(this).find('option:selected').attr('data-ref') == 'addNewBank'){
                          jQuery('#bankRef').val($("#bankRef option:first").val());
                      }
                  })
									$('.qtyType').each(function(){
											if($( this ).find('option:selected').attr('data-ref') == 'addNewQtyType'){
													jQuery($(this)).val($(".qtyType option:first").val());
											}
									})
                }
            });
        }
    });

	jQuery(document).on('click','.categoryList .list-group-item', function(){
	  var obj = jQuery(this).closest('tr');
		jQuery(obj).find('.serviceRef').next().hide();
	  var selValue = $.trim($(this).attr('data-ref'));
	  var parentRef = $.trim($(this).attr('parent-ref'));
	  var selText = $.trim($(this).text());
		if(selValue !='addNewCategory'){
			jQuery(obj).find('.serviceRef').val(selValue);
			jQuery(obj).find('.searchExpense').val(selText);
			jQuery(obj).find('.ParentCategoryRef').val(parentRef);
			$('.categoryList').addClass('hide');
		}
		else{
			jQuery(obj).find('.searchExpense').val('');
		}
	});

	  $(document).on('keyup', '.searchExpense', function(event)
	  {

	  var no = jQuery(this).closest('tr').children('.serialNumberr').text();
	  jQuery(this).closest('tr').find('.categoryList').removeClass('hide');
	  var obj = jQuery(this).closest('tr');
		jQuery(obj).find('.serviceRef').val('');
	  var type  = jQuery(this).attr('data-type');
	  if($(this).val() !=""){
		$.ajax({
			type: "POST",
			url: site_url + 'getcategorylist',
			beforeSend  : function () {
				 $(".loader_div").show();
			},
			complete: function () {
				 $(".loader_div").hide();
			},
			data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val() , 'type' : type},
			success: function (response) {
				if(response.length > 1){
				  jQuery(obj).find('.categoryList').html(response);
				}
			}
		});
	}else{
	   jQuery(obj).find('.categoryList').addClass('hide');

   };
   });


	 $(document).on('click', '#bankRef', function(event)
	 {
			 var val     = $( this ).find('option:selected').attr('data-ref');
			 if( val == 'addNewBank')
			 {

					 $('#bankRef').not($(this)).each(function(){
							 $(this).popover('hide');
					 });

					 $(this).popover({
							 trigger: 'manual',
							 placement: 'auto right',
							 container: 'body',
							 content: $('#newBank').html()
					 }).popover('show');
					 return false;
			 }
	 });

	 jQuery(document).on('click','#newBankbtn', function()
     {
			 	jQuery('.popover .remove-label').html('');
				jQuery('.form-group').removeClass('has-error');
         var bankName = $.trim(jQuery('.popover .bankName').val());
				 var accountNumber = $.trim(jQuery('.popover .accountNumber').val());
         if( bankName !="" && accountNumber != '')
         {
             $.ajax({
                 type    : "POST",
                 url     : site_url + 'addNewBank',
                 data    : {'name' : bankName , 'accountNumber' : accountNumber },
                 dataType: "json",
                 success : function (response)
                 {
									 var delayTime = 3000;
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
												 $('#bankRef').popover('hide');
												 var toAppend = '';
												 toAppend    += '<option value="'+ response.bankData.bankRef +'" selected>'+response.bankData.bankName +'</option>';
												 $('#bankRef').append(toAppend);

 				             }
 				             else
 				             {
 				                 if( response.formErrors)
 				                 {
 				                     $.each(response.errors, function( index, value )
 				                     {
 				                         $("input[name='"+index+"']").parents('.form-group').addClass('has-error');
 				                         $("input[name='"+index+"']").after('<label id="'+index+'-error" class="has-error remove-label" for="'+index+'">'+value+'</label>');
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
							 }
             });
         }
         else
         {
					 	 if(bankName == '')
						 {
								$(".popover .bankName").parents('.form-group').addClass('has-error');
             		jQuery('.popover .bankName').after("<label class='remove-label'>This field is required</label>");
						 }
						 else{
							 	jQuery('.popover .bankName').css('border','1px solid #ccc');
						 }
					 	 if(accountNumber == '')
						 {
								$(".popover .accountNumber").parents('.form-group').addClass('has-error');
								jQuery('.popover .accountNumber').after("<label class='remove-label'>This field is required</label>");
					   }else {
					   	  jQuery('.popover .accountNumber').css('border','1px solid #ccc');
					   }

         }
     });

	 jQuery('body').on('change', '#payMethod' , function(){
		 var payMethod = $('#payMethod').val();
		 if( payMethod == 1 || payMethod == 3 )
		 {
			 jQuery('#bankRef').val($("#bankRef option:first").val());
		 }
	 })

	 $(document).on('click', '#companySelect', function(event)
{
			 var company = $(this).val();
			 if( company == 'addnew' )
			 {
					 $('#companyInputDiv').removeClass('hide');
					 $('#companySelectDiv').addClass('hide');
			 }
			 else
			 {
					 $('#companySelectDiv').removeClass('hide');
					 $('#companyInputDiv').addClass('hide');
			 }
	 });
	 $(document).on('click', '#hideCompanyInput', function(event)
{
			 $('#companyInputDiv').addClass('hide');
			 $('#companySelectDiv').removeClass('hide');
			 $('#companySelect').val('');
	 });
	 $(document).on('click', '#hideCompanyInput', function(event)
{
			 $('#companyNameInput').val('');
	 });

	 $(document).on('click', '.qtyType', function(event)
	 {
	 		var thisVal = $(this).closest('td').find('.qtyType');
	 		var val     = $( this ).find('option:selected').attr('data-ref');

	 		if( val == 'addNewQtyType')
	 		{
	 				$('.qtyType').not($(this)).each(function(){
	 						$(this).popover('hide');
	 				});
	 				$(thisVal).popover({
	 						trigger: 'manual',
	 						placement: 'auto bottom',
	 						container: 'body',
	 						content: $('#myForm').html()
	 				}).popover('show');
	 				jQuery('.popover #selectedSrNo').val(jQuery(this).closest('tr').children('.serialNumberr').text());
	 				return false;
	 		}

	 });

	 $(document).on('click', '.productList #addnewProduct', function(event)
	 {

			 var thisVal = $(this).closest('td').find('.productService');
			 var val     = $( this ).attr('data-ref');
			 if( val == 'addnewProduct')
			 {
					 $('.productList').not($(this)).each(function(){
							 $(this).popover('hide');
					 });
					 $(thisVal).popover({
							 trigger: 'manual',
							 placement: 'auto bottom',
							 container: 'body',
							 content: $('#productFrom').html()
					 }).popover('show');

					 $('.productList').addClass('hide');

					 jQuery('.popover #selectedSrNo').val(jQuery(this).closest('tr').children('.serialNumberr').text());

					 return false;
			 }
	 });
	 $(document).on('click', '.productList #addnewProduct', function(event)
	 {
			 var val = $( this ).attr('data-ref');
			 if( val != 'addnewProduct')
					 $('.productList').popover('hide');
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
									 if($(this).val() == 'Add New Product'){
											 console.log(jQuery($(this).val()));
											 jQuery($(this)).val('')
									 }
							 })
						 }
				 });

			 }
	 });


	 jQuery('body').on('click','#btnQtyType', function()
	   {
			 	jQuery('.popover .form-group #typeName-error').remove();
	       var typeName = jQuery('.popover .form-group .typeName').val();
	       var srNo        = jQuery('.popover #selectedSrNo').val();

	           $.ajax({
	               type    : "POST",
	               url     : site_url + 'addUnitOfMeasurement',
	               data    : {'typeName' : typeName,'typeRef':'','req':'' },
	               dataType: "json",
	               success : function (response)
	               {

	                   var delayTime = 3000;
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
	                         var toAppend = '';
	                         toAppend    += '<option value="'+ response.typeRef +'">'+response.typeName +'</option>';
	                         $('.qtyType').append(toAppend);
	                         jQuery('.trSrNo'+srNo).find('.qtyType').val(response.typeRef);
	                         $('.qtyType').popover('hide');
	                     }
	                     else
	                     {
	                         if( response.formErrors)
	                         {
	                             $.each(response.errors, function( index, value )
	                             {
	                                 $("input[name='"+index+"']").parents('.form-group').addClass('has-error');
	                                 $("input[name='"+index+"']").after('<label id="'+index+'-error" class="has-error remove-label" for="'+index+'">'+value+'</label>');
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
	               }
	           });


	   });




		//  $(document).click(function(e){
    // 	  var targetbox = $('#popover-form');
    // 		if(!targetbox.is(e.target) && targetbox.has(e.target).length === 0){
    //     		$('#popover-form').fadeOut('fast');
    // 		}
		// 	});

});

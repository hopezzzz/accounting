<script type="text/javascript">
$('#borrowSearchList').hide();
jQuery(document).on('keyup keydown','.borrowName', function(){
    var str = $.trim(jQuery(this).val());
    $('#borrowSearchList').show();
    if($(this).val() !=""){
      $.ajax({
          type: "POST",
          url: site_url + 'borrowerList',
          data: {'detailLower' : str , 'detailUpper' : str},
          beforeSend  : function () {
    				 $(".loader_div").show();
    			},
    			complete: function () {
    				 $(".loader_div").hide();
    			},
          success: function (response) {
              if(response.length > 1){
                $('#borrowSearchList').html(response);
              }
          }
      });
  }else{
      $('#borrowSearchList').html('');
      $('#borrowSearchList').hide();

  }
})

jQuery(document).on('keyup','.borrowName', function(){
  if($(this).val().length ==0){
      jQuery('#popover-form').hide();
      $('#borrowSearchList').hide();
  }
})
jQuery(document).on('click','#borrowSearchList .list-group-item', function(){
    var selValue = $.trim($(this).attr('data-ref'));
    var selspanText = $.trim($(this).children('span').text());
    var selText = $.trim($(this).contents().get(0).nodeValue);
    if(selValue !='addNewBorrower'){
        $('.loanToRef').val(selValue);
      //  $('.borrowName').val(selText + ' ' + selspanText );
        $('.borrowName').val(selText);
        $('#borrowSearchList').hide();
    }else{
      $('.loanToRef').val('new');
    }
})
jQuery(document).on('click','#addNewBorrower', function(){
    jQuery('#addNewBorrower').hide();
    jQuery('#borrowSearchList').hide();
    jQuery('#popover-form').removeClass('hide');
    jQuery('#popover-form').show();
    jQuery('#popover-form').css('border','1px solid #ddd');
});

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
jQuery(document).on('click blur', '.calculation', function ()
  {
    if($(this).val()!=""){
    var totalCommission = $(this).val();
    totalCommission =  parseFloat(totalCommission,10).toFixed(2);
    $(this).val(totalCommission);
  }
})
</script>

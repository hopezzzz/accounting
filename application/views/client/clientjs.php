<script type="text/javascript">
$(document).ready(function ()
{
    $(document).on('click', '#sameAsBilling', function(event)
	{
		if($(this).prop("checked") == true)
		{
			$('.clientShiipingInput').val('').attr('disabled',true);
		}
		else {
			$('.clientShiipingInput').val('').attr('disabled',false);
		}
	});
	/*$('#isVatApplied').on('ifChecked', function(event){
  		alert(event.type + ' callback');
	});
	$('#isVatApplied').on('ifUnchecked', function(event){
  		alert(event.type + ' ifUnchecked');
	});*/
});

</script>

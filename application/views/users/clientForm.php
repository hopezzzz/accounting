<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard<small>Control panel</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                        <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Step 3</p>
                    </div>
                </div>
            </div>
        </div>

        <form role="form" action="" method="post">
            <div class="row setup-content" id="step-1">
                <div class="step_panel">
                    <div class="col-md-12">
                        <h3> Step 1</h3>
                        <div class="form-group col-md-4">
                            <label class="control-label">First Name</label>
                            <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name"  />
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Last Name</label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" />
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Address</label>
                            <textarea required="required" class="form-control" placeholder="Enter your address" ></textarea>
                        </div>
                    </div>
					<div class="col-md-12">
						<button class="btn btn-success nextBtn pull-right" type="button" >Next</button>
					</div>
                </div>
            </div>

            <div class="row setup-content" id="step-2">
                <div class="step_panel">
                    <div class="col-md-12">
                        <h3> Step 2</h3>
                        <div class="form-group col-md-4">
                            <label class="control-label">Company Name</label>
                            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Company Address</label>
                            <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address"  />
                        </div>
                    </div>
					<div class="col-md-12">
						<button class="btn btn-success nextBtn pull-right" type="button" >Next</button>
                    </div>
                </div>
            </div>

            <div class="row setup-content" id="step-3">
                <div class="step_panel">
                    <div class="col-md-12">
                        <h3> Step 3</h3>
                        <button class="btn btn-success pull-right" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
<script type="text/javascript">
$(document).ready(function ()
{
  	var navListItems = $('div.setup-panel div a'),
      	allWells 	 = $('.setup-content'),
          allNextBtn = $('.nextBtn');

	allWells.hide();
  	navListItems.click(function (e)
	{
      	e.preventDefault();
      	var $target = $($(this).attr('href')),
          	$item   = $(this);

      	if (!$item.hasClass('disabled'))
		{
			navListItems.removeClass('btn-success').addClass('btn-default');
			$item.addClass('btn-success');
			allWells.hide();
			$target.show();
			$target.find('input:eq(0)').focus();
      	}
  	});

  	allNextBtn.click(function()
	{
      	var curStep 		= $(this).closest(".setup-content"),
         	curStepBtn 		= curStep.attr("id"),
          	nextStepWizard 	= $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          	curInputs 		= curStep.find("input[type='text'],input[type='url']"),
          	isValid 		= true;

      		$(".form-group").removeClass("has-error");
      		for(var i = 0; i < curInputs.length; i++)
			{
          		if (!curInputs[i].validity.valid)
				{
              		isValid = false;
              		$(curInputs[i]).closest(".form-group").addClass("has-error");
          		}
      		}
      		if (isValid)
          		nextStepWizard.removeAttr('disabled').trigger('click');
  	});
  	$('div.setup-panel div a.btn-success').trigger('click');
});
</script>

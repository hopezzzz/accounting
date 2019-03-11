Client<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <section class="content">

            <div class="row setup-content" id="step-1">
                <?php echo form_open('addDebtorAjax', array('id' => 'add-debtor-form', 'class' => ''));?>
                    <div class="step_panel">
                        <div class="col-md-12">
                            <div class="form-group col-md-1">
                                <label class="control-label">Title</label>
                                <select class="form-control" name="title">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Miss.">Miss.</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">First Name</label>
                                <input type="hidden" name="firstName" id="firstName"/>
                                <input type="text" class="form-control" name="firstName" placeholder="Enter First Name"  />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Last Name</label>
                                <input type="text" class="form-control" name="lastName" placeholder="Enter Last Name" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Email</label>
                                <input maxlength="15" type="email" class="form-control" name="email"  placeholder="Enter Email" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Phone</label>
                                <input maxlength="15" type="text" class="form-control phoneNo" id="phone" name="phone"  placeholder="Enter Phone Number" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Mobile</label>
                                <input maxlength="15" type="text" class="form-control phoneNo" name="mobile" placeholder="Enter Mobile Number" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Fax</label>
                                <input maxlength="15" type="text" class="form-control" name="fax" placeholder="Enter Fax" />
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Website</label>
                                <input type="url" class="form-control" name="website" placeholder="Enter Website" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label class="control-label">Billing Address</label>
                                <textarea name="billingStreet" class="form-control" placeholder="Enter Street" ></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="billingCity" class="form-control" placeholder="Enter City/Town" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="billingState" class="form-control" placeholder="Enter State" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="billingPostalCode" class="form-control" placeholder="Enter Postal Code" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="billingCountry" class="form-control" placeholder="Enter Country" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label class="control-label">Shipping Address &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input  style="margin-top:-3px;" name="sameAsBilling" type="checkbox" id="sameAsBilling" /><p class="mouserpointer" style="float:right;margin: -4px 5px 0px 5px;">Same as billing address</p>
                                </label>
                                <textarea name="shippingStreet" class="form-control" placeholder="Enter Street" ></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="shippingCity" class="form-control" placeholder="Enter City/Town" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="shippingState" class="form-control" placeholder="Enter State" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="shippingPostalCode" class="form-control" placeholder="Enter Postal Code" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label"></label>
                                <input type="text" name="shippingCountry" class="form-control" placeholder="Enter Country" />
                            </div>
                        </div>
                        <div class="col-md-12">
                                <button class="btn btn-success nextBtn pull-right" type="submit" >Submit</button>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>            
    </section>
</div>
<script type="text/javascript">
var disabledSteps = ['step-2'];
$(document).ready(function ()
{

    $(document).on('click', 'div.setup-panel div a', function(event)
	{
        event.preventDefault();
        var stepId      = $(this).attr('href');
        stepId          = stepId.split('-');
        var isDisabled  = $.inArray( "step-"+stepId[1], disabledSteps );
        if( isDisabled == -1 )
        {
            var $target = $($(this).attr('href'));
            $('.setup-content').hide();
            $('div.setup-panel div a').removeClass('btn-success').addClass('btn-default');
    		$(this).addClass('btn-success');
            $target.show();
        }
    });
  	$('div.setup-panel div a.btn-success').trigger('click');
});
function ajaxPageCallBack( response )
{
    var itemtoRemove = "step-"+response.nextStep;
    disabledSteps.splice($.inArray(itemtoRemove, disabledSteps), 1);
    $('div.setup-panel div a[href="#step-'+response.nextStep+'"]').trigger('click');

}
</script>

<?php $this->load->view('client/clientjs');?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo ucfirst($title);?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo ucfirst($title);?></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                        <p>Basic Info</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
                        <p>Company Info</p>
                    </div>
                </div>
            </div>
        </div>

            <div class="row setup-content" id="step-1">
                <?php echo form_open('client-step-1', array('id' => 'client-form-1', 'class' => ''));?>
                    <div class="step_panel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col-md-1">
                                    <label class="control-label">Title</label>
                                    <select class="form-control" name="title">
                                        <option <?php if($clientData->title == 'Mr.'){?>selected<?php } ?> value="Mr.">Mr.</option>
                                        <option <?php if($clientData->title == 'Mrs.'){?>selected<?php } ?> value="Mrs.">Mrs.</option>
                                        <option <?php if($clientData->title == 'Miss.'){?>selected<?php } ?> value="Miss.">Miss.</option>
                                    </select>
                                    <input type="hidden" name="clientRef" id="clientRef" value="<?php echo $clientData->clientRef;?>" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">First Name</label>
                                    <input type="text" autocomplete="off" class="form-control" name="firstName" value="<?php echo ucfirst($clientData->firstName);?>" placeholder="Enter First Name"  />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" autocomplete="off" class="form-control" name="lastName" value="<?php echo ucfirst($clientData->lastName);?>" placeholder="Enter Last Name" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Email</label>
                                    <input  autocomplete="off" type="email" class="form-control" name="email" value="<?php echo $clientData->email;?>"  placeholder="Enter Email" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Phone</label>
                                    <input autocomplete="off" maxlength="15" type="text" class="form-control phoneNo" id="phone" name="phone" value="<?php echo $clientData->phone;?>"  placeholder="Enter Phone Number" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Mobile</label>
                                    <input autocomplete="off" maxlength="15" type="text" class="form-control phoneNo" name="mobile" value="<?php echo $clientData->mobile;?>" placeholder="Enter Mobile Number" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Fax</label>
                                    <input autocomplete="off" maxlength="15" type="text" class="form-control" name="fax" value="<?php echo $clientData->fax;?>" placeholder="Enter Fax" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Website</label>
                                    <input autocomplete="off" type="url" class="form-control" name="website" value="<?php echo $clientData->website;?>" placeholder="Enter Website" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Billing Address</label>
                                    <textarea name="billingStreet" class="form-control" placeholder="Street" ><?php echo $clientData->billingAddress['billingStreet'];?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="billingCity" value="<?php echo $clientData->billingAddress['billingCity'];?>" class="form-control" placeholder="City/Town" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="billingState" value="<?php echo $clientData->billingAddress['billingState'];?>" class="form-control" placeholder="State" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="billingPostalCode" value="<?php echo $clientData->billingAddress['billingPostalCode'];?>" class="form-control" placeholder="Postal Code" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="billingCountry" value="<?php echo $clientData->billingAddress['billingCountry'];?>" class="form-control" placeholder="Enter Country" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Shipping Address &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input autocomplete="off"  name="sameAsBilling" type="checkbox" id="sameAsBilling" /><p class="mouserpointer">Same as billing address</p>
                                    </label>
                                    <textarea name="shippingStreet" class="clientShiipingInput form-control" placeholder="Street" ><?php echo $clientData->shippingAddress['shippingStreet'];?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="shippingCity" value="<?php echo $clientData->shippingAddress['shippingCity'];?>" class="clientShiipingInput form-control" placeholder="City/Town" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="shippingState" value="<?php echo $clientData->shippingAddress['shippingState'];?>" class="clientShiipingInput form-control" placeholder="State" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="shippingPostalCode" value="<?php echo $clientData->shippingAddress['shippingPostalCode'];?>" class="clientShiipingInput form-control" placeholder="Postal Code" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"></label>
                                    <input autocomplete="off" type="text" name="shippingCountry" value="<?php echo $clientData->shippingAddress['shippingCountry'];?>" class="clientShiipingInput form-control" placeholder="Country" />
                                </div>
                            </div>
                        </div>

            				<div class="col-md-12">
            					<button data-id="step-1" class="btn btn-success nextBtn pull-right" type="submit" >Next</button>
            				</div>

                    </div>
                <?php echo form_close();?>
            </div>
            <div class="row setup-content" id="step-2">
                <?php echo form_open_multipart('client-step-2', array('id' => 'client-form-2', 'class' => ''));?>
                    <div class="step_panel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Company Name</label>
                                    <input type="hidden" name="clientProfileRef" value="<?php echo $clientData->clientProfileRef;?>" id="clientProfileRef"/>
                                    <input type="hidden" name="companyRef" value="<?php echo $clientData->companyRef;?>" id="companyRef"/>
                                    <input autocomplete="off" type="text" name="companyName" value="<?php echo ucfirst($clientData->companyName);?>" class="form-control" placeholder="Enter Company Name" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Company Type</label><br>
                                    <input type="radio" class="flat-red" name="companyType" value="Trading" <?php if($clientData->companyType == 'Trading') echo 'checked';?> id="trading"> <label style="cursor:pointer;margin-left:10px;margin-right:10px;" for="trading">Trading</label>
                                    <input type="radio" class="flat-red" name="companyType" value="Service/Consultancy" <?php if($clientData->companyType == 'Service/Consultancy') echo 'checked';?> id="Consultancy"> <label style="cursor:pointer;margin-left:10px;"  for="Consultancy">Service/Consultancy</label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Registration No.</label>
                                    <input autocomplete="off" type="text" name="compRegNo" value="<?php echo $clientData->compRegNo;?>" class="form-control" placeholder="Enter Registration No" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Corporation Tax Reference</label>
                                    <input autocomplete="off" type="text" name="corporationTaxRef" value="<?php echo $clientData->corporationTaxRef;?>" class="form-control" placeholder="Enter Corporation Tax Reference"  />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Date Of Incorporation</label>
                                    <input autocomplete="off" type="text" name="dateOfIncorporation" value="<?php echo $clientData->dateOfIncorporation;?>" readonly class="datepicker form-control" placeholder="Enter Date Of Incorporation"  />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Nature Of Business</label>
                                    <input autocomplete="off" type="text" name="description" value="<?php echo $clientData->description;?>" class="form-control" placeholder="Enter Nature Of Business"  />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Return Date</label>
                                    <input autocomplete="off" type="text" name="returnDate" value="<?php echo $clientData->returnDate;?>" readonly class="datepicker form-control" placeholder="Enter Return Date"  />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Year End Date</label>
                                    <input autocomplete="off" type="text" name="yearEndDate" value="<?php echo $clientData->yearEndDate;?>" readonly class="datepicker form-control" placeholder="Enter Year End Date"  />
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label mouserpointer" for="isVatApplied">VAT Applied</label>
                                    <label><input type="checkbox" name="vatApplied" <?php if($clientData->vatApplied == 1 ) echo 'checked'; ?> id="isVatApplied" class="flat-red"   /></label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">VAT Number</label>
                                    <input autocomplete="off" type="text" name="vatNo" value="<?php echo $clientData->vatNo;?>" class="form-control" placeholder="Enter vat Number"  />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">VAT Percentage</label>
                                    <input type="hidden" id="vatRef" name="vatRef" value="<?php echo $clientData->vatRef;?>" />
                                    <input autocomplete="off" type="text" maxlength="3" name="vatPercentage" value="<?php echo $clientData->vatPercentage;?>" class="form-control numeric" placeholder="Enter VAT Percentage"  />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Contact Person Name</label>
                                    <input autocomplete="off" type="text" name="contactPersonName" value="<?php echo ucfirst($clientData->contactPersonName);?>" class="form-control" placeholder="Enter Contact Person Name"  />
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Contact Person Phone</label>
                                    <input autocomplete="off" type="text" name="contactPersonPhone" value="<?php echo ucfirst($clientData->contactPersonPhone);?>" class="phoneNo form-control" placeholder="Enter Contact Person Phone"  />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Company Logo</label>
                                    <input name="companyLogo" type="file" class="" style="padding:3px" />
                                </div>
                                <?php if( $clientData->companyLogo != '' ){?>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Existing Logo</label>
                                        <img style="width:150px !important;height:150px" class="form-control" src="<?php echo site_url('assets/uploads/logos/'.$clientData->companyLogo);?>" />
                                    </div>
                            <?php } ?>
                            </div>
                        </div>
        				<div class="col-md-12">
        					<button data-id="step-2" class="btn btn-success nextBtn pull-right" type="submit" >Save</button>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
    </section>
</div>
<script type="text/javascript">
var clientRef = '<?php echo $clientData->clientRef;?>';
var sameAsBilling = '<?php echo $clientData->sameAsBilling;?>';
if(sameAsBilling == 1)
{
    setTimeout(function()
    {
        $('#sameAsBilling').trigger('click');
    }, 1000);
}
if( clientRef == '')
    var disabledSteps = ['step-2'];
else
    var disabledSteps = [];
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
    if( response.formType == 'step-1' )
    {
        $('#clientRef').val(response.clientRef);
        $('#clientProfileRef').val(response.clientRef);
        var itemtoRemove = "step-"+response.nextStep;
        disabledSteps.splice($.inArray(itemtoRemove, disabledSteps), 1);
        $('div.setup-panel div a[href="#step-'+response.nextStep+'"]').trigger('click');
    }
    else if( response.formType == 'step-2' )
    {
        $('#companyRef').val(response.companyRef);
        $('#vatRef').val(response.vatRef);
    }
}
</script>

<?php
$loginSessionData = $this->session->userdata('clientData');
$companyData      = $loginSessionData['companyData'];
?>
<style>
#companyNameInput-error{
    float: left;
    position: absolute;
    top: 58px;
    left: 16px;
}
</style>
<script type="text/javascript">
$(document).ready(function ()
{
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

});
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <section class="content">

        <div class="row setup-content" id="step-1">
            <?php echo form_open('ajaxaddborrower', array('id' => 'add-borrower-form', 'class' => '')); ?>
            <div class="step_panel">
             <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-1">
                        <label class="control-label">Title</label>
                        <select class="form-control" name="title">
                            <option <?php if($borrowerData->title == 'Mr.') echo "selected"; ?> value="Mr.">Mr.</option>
                            <option <?php if($borrowerData->title == 'Mrs.') echo "selected"; ?> value="Mrs.">Mrs.</option>
                            <option <?php if($borrowerData->title == 'Miss.') echo "selected"; ?> value="Miss.">Miss.</option>
                        </select>
                    </div><input type="hidden" class="form-control" name="borrowerRef" value="<?php  echo $borrowerData->borrowerRef; ?>" >
                    <div class="form-group col-md-3">
                        <label class="control-label">First Name</label>
                        <input type="text" class="form-control" name="firstName" value="<?php  echo $borrowerData->firstName; ?>" placeholder="Enter First Name"  />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Last Name</label>
                        <input type="text" class="form-control" name="lastName" value="<?php if($borrowerData->lastName) { echo $borrowerData->lastName; } ?>" placeholder="Enter Last Name" />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" value="<?php if($borrowerData->email) { echo $borrowerData->email; } ?>" name="email"  placeholder="Enter Email" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group col-md-4" id="companySelectDiv">
                        <label class="control-label">Company</label>
                        <?php $borrowersCompanies = getBorrowersCompanies($companyData->companyRef,'borrowerCompanyRef,companyname',1); ?>
                        <select name="borrowerCompanyRef" class="form-control" id="companySelect">
                            <?php if(!empty($borrowersCompanies)){?>
                            <option value="" > Select Company </option>
                            <?php foreach ($borrowersCompanies as $key => $value) {?>
                                <option value="<?php echo $value->borrowerCompanyRef;?>" <?php if($borrowerData->borrowerCompanyRef == $value->borrowerCompanyRef){?>selected <?php } ?> > <?php echo ucfirst($value->companyname);?></option>
                            <?php }
                        } else {?>
                            <option value="" > No company added yet.</option>
                        <?php } ?>
                            <option value="addnew" > Add New </option>
                        </select>
                    </div>
                    <div class="input-group form-group col-md-4 hide" id="companyInputDiv" style="float:left;padding-left:15px;padding-right:15px;margin-bottom:30px;">
                        <label class="control-label">Company Name</label>
                        <input type="text" class="form-control" id="companyNameInput" name="companyname" value="" placeholder="Enter Company Name" />
                        <div class="clearfix"></div>
                        <span class="input-group-btn"><button style="margin-top:25px;" class="btn btn-primary" id="hideCompanyInput" type="button"> × </button>
                        </span>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Phone</label>
                        <input maxlength="15" type="text" class="form-control phoneNo" value="<?php if($borrowerData->phone) { echo $borrowerData->phone; } ?>" id="phone" name="phone"  placeholder="Enter Phone Number" />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Mobile</label>
                        <input maxlength="15" type="text" class="form-control phoneNo" value="<?php if($borrowerData->mobile) { echo $borrowerData->mobile; } ?>" name="mobile" placeholder="Enter Mobile Number" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label class="control-label">Fax</label>
                        <input maxlength="15" type="text" class="form-control" value="<?php if($borrowerData->fax) { echo $borrowerData->fax; } ?>" name="fax" placeholder="Enter Fax" />
                    </div>
                </div>
                </div>
                <div class="clearfix"></div>
				<div class="row">
                <div class="col-md-6">
                    <div class="form-group col-md-12">
                        <label class="control-label">Billing Address</label>
                        <textarea name="billingStreet" class="form-control" placeholder="Enter Street" ><?php echo $borrowerData->billingAddress['billingStreet']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="billingCity" class="form-control" value="<?php echo $borrowerData->billingAddress['billingCity']; ?>" placeholder="Enter City/Town" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="billingState" class="form-control" value="<?php echo $borrowerData->billingAddress['billingState']; ?>" placeholder="Enter State" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="billingPostalCode" class="form-control" value="<?php echo $borrowerData->billingAddress['billingPostalCode']; ?>" placeholder="Enter Postal Code" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="billingCountry" class="form-control" value="<?php echo $borrowerData->billingAddress['billingCountry']; ?>" placeholder="Enter Country" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group col-md-12">
                        <label class="control-label">Shipping Address &nbsp;&nbsp;&nbsp;&nbsp;
                            <input  style="margin-top:-3px;" name="sameAsBilling" type="checkbox" id="sameAsBilling" /><p class="mouserpointer" style="float:right;margin: -4px 5px 0px 5px;">Same as billing address</p>
                        </label>
                        <textarea name="shippingStreet" class="ShiipingInput form-control" placeholder="Enter Street" ><?php echo $borrowerData->shippingAddress['shippingStreet']; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="shippingCity" class="ShiipingInput form-control" value="<?php echo $borrowerData->shippingAddress['shippingCity']; ?>" placeholder="Enter City/Town" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="shippingState" class="ShiipingInput form-control" value="<?php echo $borrowerData->shippingAddress['shippingState']; ?>" placeholder="Enter State" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="shippingPostalCode" class="ShiipingInput form-control" value="<?php echo $borrowerData->shippingAddress['shippingPostalCode']; ?>" placeholder="Enter Postal Code" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label"></label>
                        <input type="text" name="shippingCountry" class="ShiipingInput form-control" value="<?php echo $borrowerData->shippingAddress['shippingCountry']; ?>" placeholder="Enter Country" />
                    </div>
                </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success nextBtn pull-right" type="submit" >Submit</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </section>
</div>

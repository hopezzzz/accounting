<?php
$loginSessionData = $this->session->userdata('clientData');
$companyData      = $loginSessionData['companyData'];
?>
<div class="content-wrapper" style="height: 760px !important">
    <section class="content-header">
        <h1><?php echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <?php //echo "<pre>"; print_r($result); echo "</pre>"; ?>
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <a href="<?php echo site_url();?>share" class="success btn btn-success"> Back</a>
        </div>
        <div class="clearfix"></div><br>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
            <?php echo form_open('addshareAjax', array('id' => 'add-share-form', 'class' => '')); ?>
            <div class="step_panel">
                <div class="col-md-12">
                	 <div class="row">
                    <div class="form-group col-md-1">
                        <label class="control-label">Title</label>
                        <select class="form-control" name="title">
                            <option <?php if($result->title == 'Mr.') echo "selected"; ?> value="Mr.">Mr.</option>
                            <option <?php if($result->title == 'Mrs.') echo "selected"; ?> value="Mrs.">Mrs.</option>
                            <option <?php if($result->title == 'Miss.') echo "selected"; ?> value="Miss.">Miss.</option>
                        </select>
                    </div><input type="hidden" class="form-control" name="shareRef" value="<?php  echo $result->shareRef; ?>" >
                    <div class="form-group col-md-3">
                        <label class="control-label">First Name</label>
                        <input type="text" class="form-control" name="firstName" value="<?php  echo $result->firstName; ?>" placeholder="Enter First Name"  />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Last Name</label>
                        <input type="text" class="form-control" name="lastName" value="<?php if($result->lastName) { echo $result->lastName; } ?>" placeholder="Enter Last Name" />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" value="<?php if($result->email) { echo $result->email; } ?>" name="email"  placeholder="Enter Email" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Mobile</label>
                        <input maxlength="15" type="text" class="form-control phoneNo" value="<?php if($result->mobile) { echo $result->mobile; } ?>" name="mobile" placeholder="Enter Mobile Number" />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">D.O.B</label>
                        <input type="text" readonly class="form-control " id="datepicker" value="<?php if(trim($result->dob)!='' && $result->dob !='30-11--0001') { echo date('d-m-Y',strtotime($result->dob)); } else echo date('d-m-Y'); ?>" name="dob" placeholder="Enter DOB" />
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">NI Number</label>
                        <input type="text" class="form-control" name="niNumber" value="<?php if($result->niNumber) { echo $result->niNumber; } ?>" placeholder="Enter NI Number" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4" id="companySelectDiv">
                        <label class="control-label">Company</label>
                        <?php $shareholderComp = getBorrowersCompanies($companyData->companyRef,'borrowerCompanyRef,companyname',4); ?>
                        <select name="shareholCompanyRef" class="form-control" id="companySelect">
                            <?php if(!empty($shareholderComp)){?>
                            <option value="" > Select Company </option>
                            <?php foreach ($shareholderComp as $key => $value) {?>
                                <option value="<?php echo $value->borrowerCompanyRef;?>" <?php if($result->shareholCompanyRef == $value->borrowerCompanyRef){?>selected <?php } ?> > <?php echo ucfirst($value->companyname);?></option>
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
                        <label class="control-label">UTR Number</label>
                        <input type="text" class="form-control number" name="utrNumber" value="<?php if($result->utrNumber) { echo $result->utrNumber; } ?>" placeholder="Enter UTR No" />
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Number of Shares</label>
                        <input type="text" class="form-control number" name="noOfShare" value="<?php if($result->noOfShare) { echo $result->noOfShare; } ?>" placeholder="Enter No Of Shares" />
                    </div>
                     </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-6">
                        <label class="control-label">Address</label>
                        <textarea name="address" class="form-control" placeholder="Enter Address" ><?php echo $result->address; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Address 1</label>
                        <input type="text" name="address1" class="form-control" value="<?php echo $result->address1; ?>" placeholder="Enter Address Line 1" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Address 2</label>
                        <input type="text" name="address2" class="form-control" value="<?php echo $result->address2; ?>" placeholder="Enter Address Line 2" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Address 3</label>
                        <input type="text" name="address3" class="form-control" value="<?php echo $result->address3; ?>" placeholder="Enter Address Line 3" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Country</label>
                        <input type="text" name="country" class="form-control" value="<?php echo $result->country; ?>" placeholder="Enter Country" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Zip Code</label>
                        <input maxlength="6" type="text" name="zipCode" class="numeric form-control" value="<?php echo $result->zipCode; ?>" placeholder="Enter Zip Code" />
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

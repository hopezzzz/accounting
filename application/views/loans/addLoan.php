<?php
$loginSessionData = $this->session->userdata('clientData');
$companyData      = $loginSessionData['companyData'];
?>
<script type="text/javascript">
$(document).ready(function ()
{
    var isPaid = '<?php echo $result->paymentStatus?>';
    if( isPaid == 'paid' )
    {
        $("#ajaxaddLoans").find('input, textarea, select').prop("disabled", true).attr("disabled", true);
        $(document).find('input, textarea, select').prop("disabled", true).attr("disabled", true);
        $(document).find('.saveBtns').remove();
        $(document).find('.savePaymentStatus').remove();
        $(document).find('#addLayer').remove();
        $(document).find('.removeLayer').remove();
        $(document).find('.content-header h1').html('View Loan / Advances');
    }


});

</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php if( $result->loanRef !== '' ) echo "Update Loans / Advances"; else  echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <!-- <?php echo "<pre>"; print_r($result); echo "</pre>"; ?> -->
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <?php
              $referencePageUrl       = $this->session->userdata('referencePageUrl');
              $reference              = $this->session->userdata('reference');
              $referenceType          = $this->session->userdata('referenceType');
              if( $reference != '' && $referenceType == 'borrower' && $referencePageUrl != '')
              {?>
                  <a href="<?php echo $referencePageUrl;?>" class="success btn btn-success"> Back</a>
          <?php }  else{?>
                  <a href="<?php echo site_url();?>loans" class="success btn btn-success"> Back</a>
        <?php } ?>
        </div>
        <div class="clearfix"></div><br>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
          <div class="row">
            <?php echo form_open('ajaxaddloan', array('id' => 'ajaxaddLoans', 'autocomplete' => 'off')); ?>
              <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                      <label class="form-label"> Lender Name </label>
                      <input type="text" name="borrowName" class="form-control borrowName" value="<?php if(strlen($result->fullName) > 3) echo ($result->fullName); else echo $result->email; ?>" placeholder="Lender Name">
                      <ul class="list-group" id="borrowSearchList" style="list-style:none"></ul>
                      <input type="hidden" name="loanToRef" value="<?php if($result->loanToRef) echo $result->loanToRef;?>" class="form-control loanToRef">
                  </div>


                  <div id="popover-form" class="hide col-md-8 col-sm-12">
                      <h4 class="text-center">Add New Lender</h4>
                      <div class="form-group">
                          <input autocomplete="off" id="emaid" name="email" type="text" placeholder="Enter email" class="form-control">
                      </div>
                      <div class="form-group" id="companySelectDiv">
                          <label class="control-label">Company</label>
                          <?php $borrowersCompanies = getBorrowersCompanies($companyData->companyRef,'borrowerCompanyRef,companyname',1); ?>
                          <select name="borrowerCompanyRef" class="form-control" id="companySelect">
                              <?php if(!empty($borrowersCompanies)){?>
                              <option value="" > Select Company </option>
                              <?php foreach ($borrowersCompanies as $key => $value) {?>
                                  <option value="<?php echo $value->borrowerCompanyRef;?>"> <?php echo ucfirst($value->companyname);?></option>
                              <?php }
                          } else {?>
                              <option value="" > No company added yet.</option>
                          <?php } ?>
                              <option value="addnew" > Add New </option>
                          </select>
                      </div>
                      <div class="input-group form-group hide" id="companyInputDiv">
                          <label class="control-label">Company Name</label>
                          <input type="text" class="form-control" id="companyNameInput" name="companyname" value="" placeholder="Enter Company Name" />
                          <div class="clearfix"></div>
                          <span class="input-group-btn"><button style="margin-top:25px;" class="btn btn-primary" id="hideCompanyInput" type="button"> × </button>
                          </span>
                      </div>

                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-3 col-sm-12">
                  <div class="form-group">
                      <label class="form-label"> Amount</label>
                      <input type="text" name="amount" value="<?php if($result->amount) echo $result->amount;?>" class="form-control calculation validNumber" placeholder="Enter Amount">
                  </div>
              </div>
              <div class="col-lg-3 col-sm-12">
                  <div class="form-group">
                    <label class="form-label"> Bank Name </label>
                      <select class="form-control" name="bankRef" id="bankRef" data-html="true">
                          <option value=""> Select Bank</option>
                            <option data-ref="addNewBank" value=""> Add New Bank </option>
                          <?php $banks = getBanks();

                            foreach ($banks as  $bankValue) {?>
                              <option <?php if($bankValue->bankRef == $result->bankRef) echo "selected"; ?> value="<?php echo $bankValue->bankRef;?>"> <?php echo $bankValue->name; ?></option>
                            <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Date:</label>
                        <div class="input-groupp">
                            <input type="text" class="form-control pull-right datepicker" name="date" value="<?php if(trim($result->date) !="") echo date('d-m-Y', strtotime($result->date)); else echo date('d-m-Y'); ?> " readonly>
                       </div>
                    <!-- /.input group -->
                  </div>
              </div>
              <div class="col-md-3 col-sm-12">
                  <div class="form-group">
                    <label>Select Loan Type</label>
                    <select class="form-control" name="loanType">
                      <option value="">Select Loan Type</option>
                      <option  <?php if($result->loanType == 1 ) echo 'selected';?>  value="1">Short Term</option>
                      <option  <?php if($result->loanType == 2 ) echo 'selected';?>  value="2">Long Term</option>
                    </select>
                  </div>
              </div>
              <!-- <div class="col-md-2 col-sm-12">
                  <div class="form-group">
                    <label>Select Loan From</label>
                    <select class="form-control" name="loanSource">
                      <option value="">Select Loan From</option>
                      <option  <?php if($result->loanSource == 1 ) echo 'selected';?>  value="1">Bank</option>
                      <option  <?php if($result->loanSource == 2 ) echo 'selected';?>  value="2">Other</option>
                    </select>
                  </div>
              </div> -->
              <div class="clearfix"></div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label>Description</label>
                  <textarea name="description" class="form-control" rows="5" placeholder="Description.."><?php if($result->description) echo $result->description;?></textarea>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-6">
                <input type="hidden" name="loanRef" value="<?php if($result->loanRef) echo $result->loanRef;?>">
                <input type="hidden" name="type" value="1">
                <input type="hidden" name="borrowType" value="loans">
                <input type="submit" value="Save" class="btn btn-success pull-right saveBtns">
              </div>
          </div>
		</div>
      </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </section>

<table>
  <tbody>
    <tr id="nextLine" class="hide">
      <td class="serialNumber">1</td>
      <td>

        <div class="form-group">
        <select data-html="true"  name="product[]" class="form-control productService">
            <option value="">Select Product</option>
            <option  id="addnewProduct" value="addnewProduct"> <a href="javascript:void(0)" class="btn btn-success"> Add New Product </a></option>
          <?php foreach ($productServices as $value) { ?>
              <option value="<?php echo $value->productRef;?>"><?php echo $value->productName;?></option>
          <?php  } ?>
        </select>
      </div>
      </td>
      <td class="tdQuantity form-group">
           <input type="hidden" class="validNumber form-control validNumber itemRef" name="transactionItemRef[]" value="">
          <input type="text" class="productServiceQty validNumber calculation form-control" name="quantity[]">
      </td>
      <td>
          <div class="form-group">
          <input type="text" class="oneServiceProductPrice validNumber calculation form-control" placeholder="0" name="rate[]">
        </div>
      </td>
      <td>
          <input type="text" class="form-control" id="productServiceDescrp" name="description[]">
      </td>
      <td>
          <input type="text" class="productServiceGross price form-control" id="productServiceGross" name="amount[]" class="calculation" readonly>
      </td>
      <td>
        <input type="hidden" class="vatAmount" id="vatAmount" value=""  name="vatAmount[]">
        <input type="text" class="productServiceVAT validNumber calculation form-control" id="productServiceVAT" value="<?php if(isset($productVat[0]->vatPercentage) && trim($productVat[0]->vatPercentage) !="") echo $productVat[0]->vatPercentage;?>" name="vatPercentage[]">
      </td>
      <!--td>

      </td-->
        <input type="hidden" class="productServiceTotal form-control" id="productServiceTotal" name="productServiceTotal[]" readonly>

      <td class="addMins">
      </td>
  </tr>
</tbody>
</table>

</div>

<?php
$loginSessionData = $this->session->userdata('clientData');
$companyData      = $loginSessionData['companyData'];
?>

<div class="content-wrapper" style="height: 1000px !important">
    <section class="content-header">
        <h1><?php  echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <?php //echo "<pre>"; print_r($result); echo "</pre>"; ?>
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <a href="<?php echo site_url();?>share-capital" class="success btn btn-success"> Back</a>
        </div>
        <div class="clearfix"></div>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
          <div class="row">
              <?php echo form_open('addsharecapitalAjax', array('id' => 'add-share-capital-form', 'autocomplete' => 'off')); ?>
              <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="form-group">
                <label class="form-label"> Payment Method </label>
                      <select class="form-control" name="paymentMethod" id="payMethod">
                          <option value=""> Select Payment Method</option>
                          <option <?php if($result->paymentMethod == '1') echo "selected"; ?> value="1">  Cash</option>
                          <option <?php if($result->paymentMethod == '2') echo "selected"; ?> value="2">  Bank</option>
                          <!--option <?php if($result->paymentMethod == '3') echo "selected"; ?> value="3">  Credit</option-->
                          <option <?php if($result->paymentMethod == '4') echo "selected"; ?> value="4">  Debit Card</option>
                          <option <?php if($result->paymentMethod == '5') echo "selected"; ?> value="5">  Cheque</option>

                      </select>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 col-xs-12">
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
              <div class="col-lg-3 col-md-6 col-xs-12">
                <input type="hidden" name="shareCapitalRef" value="<?php echo $this->uri->segment('2'); ?>">
                  <div class="form-group">
                        <label class="form-label"> Share Holder Name</label>
                        <input class="form-control" id="shareHolderName" name="payeeName" value="<?php if(isset($result->fullName)) { echo $result->fullName;}?>"  placeholder="Share Holder Name">
                        <input type="hidden" id="shareHolderRef" name="shareHolderRef" value="<?php echo $result->shareHolderRef;?>">
                        <ul class="list-group" id="shareHolderList" style="list-style:none"></ul>
                  </div>
              </div>


              <div class="col-lg-3 col-md-6 col-xs-12">
                  <label class="form-label"> Date</label>
                  <input autocomplete="off" type="text" id="invoiceDate" name="Date" value="<?php if(trim($result->Date) !="") echo date('d-m-Y', strtotime($result->Date)); else echo date('d-m-Y'); ?>" readonly="" class="datepicker form-control" placeholder="Enter Date Of Incorporation" aria-required="true" aria-invalid="false">
              </div>

              <div class="col-md-12 popoverDiv">
                <div class="poppover-arrow"></div>
                <div id="popover-form" class="hide" style="height:150px">
                    <h4 class="text-center">Add New Share Holder</h4>
                      <div class="clearfix"></div>
                      <div class="col-sm-1 no-padding" style="padding-right:4px !important">
                        <label for="shareHolderName"> Title</label>
                          <select class="form-control" name="title">
                            <option value="Mr." selected>Mr.</option>
                            <option value="Mrs.">Mrs</option>
                          </select>
                      </div>
                        <div class="col-sm-3 form-group ">
                          <label for="shareHolderName"> Share Holder Name</label>
                            <input autocomplete="off" id="newHolderName" name="newHolderName" type="text" placeholder="Enter Name" class="form-control">
                      </div>
                      <div class="col-sm-3 form-group">
                        <label for="shareHolderName"> Email ID</label>
                          <input autocomplete="off"  name="newemail" type="text" placeholder="Enter Email" class="form-control">
                      </div>
                      <div class="col-sm-2  form-group">
                        <label for="shareHolderName">No. of Shares</label>
                          <input autocomplete="off"  name="noOfShare" type="text" placeholder="Enter No Of Shares" class="form-control">
                      </div>
                      <div class="form-group col-md-3" id="companySelectDiv">
                          <label class="control-label">Company</label>
                          <?php $shareholderComp = getBorrowersCompanies($companyData->companyRef,'borrowerCompanyRef,companyname',4); ?>
                          <select name="shareholCompanyRef" class="form-control" id="companySelect">
                              <?php if(!empty($shareholderComp)){?>
                              <option value="" > Select Company </option>
                              <?php foreach ($shareholderComp as $key => $value) {?>
                                  <option value="<?php echo $value->borrowerCompanyRef;?>" > <?php echo ucfirst($value->companyname);?></option>
                              <?php }
                          } else {?>
                              <option value="" > No company added yet.</option>
                          <?php } ?>
                              <option value="addnew" > Add New </option>
                          </select>
                      </div>
                      <div class="input-group form-group col-md-3 hide" id="companyInputDiv" style="float:left;padding-left:15px;padding-right:15px;margin-bottom:30px;">
                          <label class="control-label">Company Name</label>
                          <input type="text" class="form-control" id="companyNameInput" name="companyname" value="" placeholder="Enter Company Name" />
                          <div class="clearfix"></div>
                          <span class="input-group-btn"><button style="margin-top:25px;" class="btn btn-primary" id="hideCompanyInput" type="button"> × </button>
                          </span>
                      </div>
                </div>
              </div>
              <div class="clearfix"></div><br>

                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="tableList">
                      <thead>
                          <tr>
                              <th>S.No</th>
                              <th>QTY</th>
                              <th>Rate</th>
                              <th>Description</th>
                              <th>Gross Amount</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                           $iNum = 0;
                           foreach ($result->items as $value) {
                             $iNum++;

                             ?>
                          <tr class="dealPack trSrNo<?php echo $iNum;?>">
                              <td class="serialNumberr"><?php echo $iNum;?></td>

                              <td class="tdQuantity  form-group">
                                  <input type="hidden" class="validNumber form-control validNumber itemRef" name="transactionItemRef[]" value="<?php echo $value->itemRef;?>">
                                  <input type="text" class="shareQty sharecalculation validNumber form-control validNumber" name="quantity[<?php echo $iNum-1;?>]" value="<?php if(isset($value->quantity)) echo $value->quantity;?>">
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="shareRate validNumber sharecalculation form-control" name="rate[<?php echo $iNum-1;?>]"  placeholder="0" value="<?php if(trim($value->rate) !="") echo $value->rate;?>">
                                </div>
                              </td>
                              <td>
                                  <input type="text" class="form-control" id="productServiceDescrp" name="description[]" value="<?php if(isset($value->description)) echo $value->description;?>">
                              </td>
                              <td>
                                  <input type="text" class="productServiceGross price form-control" id="productServiceGross" name="amount[]" value="<?php if(trim($value->amount) !="") echo $value->amount.".00";else echo "0.00"?>"  class="sharecalculation" readonly>
                              </td>
                              <?php  if($iNum > 1){?>
                                <td class="addMins">
                                  <span class="removeLayer sharecalculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>
                                </td>
                              <?php } ?>
                          </tr>
                        <?php } ?>
                  </tbody>
                 </table>
               </div>

               <div class="col-md-6 no-padding">
                   <a href="javascript:void(0)" id="addLayer" class="btn btn-success"> <i class="fa fa-plus"> </i> Add New Line </a>
               </div>

               <div class="col-md-5 pull-right text-right">
                 <table class="table table-responsive table-hover">
                     <tbody>
                       <tr>
                         <td class="text-right"><h4>Sub Total :- </h4></td>
                         <td><h4 class="text-right totalServicePrice"> <?php if (isset($result->items[0]->amount))  {$Subprice = 0;foreach ($result->items as $value) {  $Subprice += $value->amount; } echo $Subprice.".00";} else echo "0.00";?></h4></td>
                           <input type="hidden" name ="subTotal" class="inputVaTotalServicePrice" value="<?php echo $result->subTotal;?>">
                       </tr>
                     </tbody>
                   </table>
               </div>

               <div class="clearfix"></div>
               <br>
               <div class="col-md-12 pull-right text-right">
                 <input type="hidden" name="shareCapitalItemsRefers" class="transactionItemRef">
                 <input type="submit" value="Save" class="btn btn-success saveBtns">
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


      <td class="tdQuantity form-group">
           <input type="hidden" class="validNumber form-control validNumber itemRef" name="transactionItemRef[]" value="">
          <input type="text" class="shareQty validNumber sharecalculation form-control" name="quantity[]">
      </td>
      <td>
          <div class="form-group">
          <input type="text" class="shareRate validNumber sharecalculation form-control" placeholder="0" name="rate[]">
        </div>
      </td>
      <td>
          <input type="text" class="form-control" id="productServiceDescrp" name="description[]">
      </td>
      <td>
          <input type="text" class="productServiceGross price form-control" id="productServiceGross" name="amount[]" class="sharecalculation" readonly>
      </td>
      <td class="addMins">
      </td>
  </tr>
</tbody>
</table>

</div>

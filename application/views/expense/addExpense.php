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
        $("#add-purchase-form").find('input, textarea, select').prop("disabled", true).attr("disabled", true);
        $(document).find('input, textarea, select').prop("disabled", true).attr("disabled", true);
        $(document).find('.saveBtns').remove();
        $(document).find('.savePaymentStatus').remove();
        $(document).find('#addLayer').remove();
        $(document).find('.removeLayer').remove();
    }
});
</script>
<div class="content-wrapper" style="height: 1000px !important">
    <section class="content-header">
        <h1><?php if( $result->paymentStatus == 'paid' ) echo "View Expense"; else  echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <?php //echo "<pre>"; print_r($result); echo "</pre>"; ?>
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <?php
              $referencePageUrl       = $this->session->userdata('referencePageUrl');
              $reference              = $this->session->userdata('reference');
              $referenceType          = $this->session->userdata('referenceType');
              $transactionRefUrl      = $this->session->userdata('transactionRefUrl');
              if( $reference != '' && $referenceType == 'creditor' && $referencePageUrl != '')
              {?>
                  <a href="<?php echo $referencePageUrl;?>" class="success btn btn-success"> Back</a>
          <?php }  else if($transactionRefUrl !=''){?>
                  <a href="<?php echo site_url($transactionRefUrl);?>" class="success btn btn-success"> Back</a>
          <?php } else{?>
                  <a href="<?php echo site_url();?>expense" class="success btn btn-success"> Back</a>
        <?php } ?>
        </div>
        <div class="clearfix"></div>
        <?php echo form_open('addtransactionajax', array('id' => 'add-purchase-form', 'autocomplete' => 'off')); ?>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
          	<div class="row">

            <div class="col-lg-6">
            	<div class="row">
                <div class="col-lg-5 col-md-3">
                  <label class="form-label"> Payment Method </label>
                    <div class="form-group">
                        <select class="form-control" name="paymentMethod" id="payMethod">
                            <<option value=""> Select Payment Method</option>
                            <option <?php if($result->paymentMethod == '1') echo "selected"; ?> value="1">  Cash</option>
                            <option <?php if($result->paymentMethod == '2') echo "selected"; ?> value="2">  Bank</option>
                            <option <?php if($result->paymentMethod == '3') echo "selected"; ?> value="3">  Credit</option>
                            <option <?php if($result->paymentMethod == '4') echo "selected"; ?> value="4">  Debit Card</option>
                            <option <?php if($result->paymentMethod == '5') echo "selected"; ?> value="5">  Cheque</option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-md-3">
                  <label class="form-label"> Bank Name </label>
                    <div class="form-group">
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
              </div>
              <div class="clearfix"></div>
              <br>
              <div class="col-lg-10 col-md-6">
              <div class="row">
                <input type="hidden" name="transactionType" value="expense">
                <input type="hidden" name="transactionRef" value="<?php echo $this->uri->segment('2'); ?>">
                <label class="form-label"> Payee Name</label>
                  <div class="form-group">
                      <?php if(isset($result->firstName)) { $name = $result->title.' '.$result->firstName.' '.$result->lastName; $name = trim($name); } ?>
                        <input class="form-control creditorName" name="payeeName" id="creditorName" value="<?php if(isset($result->firstName)) { echo $name;}?>"  placeholder="Payee Name">
                        <input type="hidden" class="payeeRef do-not-ignore" id="creditorRef" name="payeeRef" value="<?php if($result->payeeRef) echo $result->payeeRef;?>">
                      <ul class="list-group" id="creditorSearchList" style="list-style:none"></ul>
                  </div>
                  <div id="popover-form" class="hide">
                      <h4 class="text-center">Add New Creditor</h4>
                      <div class="form-group">
                          <input autocomplete="off" id="addCreditorName" name="addCreditorName" type="text" placeholder="Enter Name" class="form-control">
                      </div>
                      <div class="form-group" id="companySelectDiv">
                          <label class="control-label">Company</label>
                          <?php $borrowersCompanies = getBorrowersCompanies($companyData->companyRef,'borrowerCompanyRef,companyname',3); ?>
                          <select name="creditorCompanyRef" class="form-control" id="companySelect">
                              <?php if(!empty($borrowersCompanies)){?>
                              <option value="" > Select Company </option>
                              <?php foreach ($borrowersCompanies as $key => $value) {?>
                                  <option value="<?php echo $value->borrowerCompanyRef;?>"> <?php echo ucfirst($value->companyname);?></option>
                              <?php }
                          } else {?>
                              <option value="" > No companies add yet.</option>
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
              </div>
            </div>
              <div class="col-md-6 pull-right">
				<div class="row">
                  <div class="col-md-8 text-right"><h4>Invoice Date<h4></div>
                  <div class="col-md-4 text-right"><h4><input autocomplete="off" type="text" id="invoiceDate" name="invoiceDate" value="<?php if(trim($result->createdDate) !="") echo date('d-m-Y', strtotime($result->createdDate)); else echo date('d-m-Y'); ?>" readonly="" class="datepicker form-control" placeholder="Enter Date Of Incorporation" aria-required="true" aria-invalid="false"></h4></div>

                  <div class="col-md-8 text-right"><h4>Delivery Date<h4></div>
                      <div class="col-md-4 text-right"><h4><input autocomplete="off" type="text" id="deliveryDate" name="deliveryDate" value="<?php if(trim($result->deliveryDate) !="") echo date('d-m-Y', strtotime($result->deliveryDate)); else echo date('d-m-Y');?>" readonly="" class="datepicker form-control" placeholder="Enter Date Of Incorporation" aria-required="true" aria-invalid="false"></h4></div>

                  <div class="col-md-8 text-right"><h4>Invoice Number</h4></div>

                  <div class="col-md-4 text-right"><h4 id="invoiceNum"><?php  if(trim($result->invoiceNo) !=""){ echo ucfirst($result->invoiceNo);} else{ echo generateInvoiceNumber(); }?></h4>
                    <input id="boxInvoiceNum" class="form-control boxInvoiceNum hidden" type="text" name="invoiceNo" value="<?php  if(trim($result->invoiceNo) !=""){ echo ucfirst($result->invoiceNo);} else{ echo generateInvoiceNumber(); }?>">
                  </div>

              </div>
              </div>
              <div class="clearfix"></div><br>
              <div class="col-md-12">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="tableList">
                      <thead>
                          <tr>
                              <th>S.No</th>
                              <th>Expense Type</th>
                              <th>Description</th>
                              <th>QTY</th>
                              <th style="width:120px">QTY Type</th>
                              <th>Rate</th>
                              <th>Gross Amount</th>
                              <th>VAT(%)</th>
                              <!--th>Total</th-->
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
                              <td class="form-group">
                                <input type="text" class="form-control searchExpense productService product" placeholder="Search..." data-type="expense" name="subcategoryRef[<?php echo $iNum-1;?>]" value="<?php if(trim($value->subcategoryRef)  !=""){  $category = getCategoryNameByRef($value->subcategoryRef); echo $category->title; } ?>">
                                <input type="hidden" class="form-control do-not-ignore serviceRefValidate serviceRef" name="serviceRef[]" value="<?php echo $value->subcategoryRef;?>">
                                <input type="hidden" name="ParentCategoryRef[]" class="ParentCategoryRef" value="<?php echo $value->categoryRef;?>">
                                <ul class="categoryList list-group hide"></ul>
                              </td>
                              <td>
                                  <input type="text" class="form-control" id="productServiceDescrp" name="description[]" value="<?php if(isset($value->description)) echo $value->description;?>">
                              </td>
                              <td class="tdQuantity form-group">
                                  <input type="hidden" class="validNumber form-control validNumber itemRef" name="transactionItemRef[]" value="<?php echo $value->itemRef;?>">
                                  <input type="text" class="productServiceQty calculation validNumber form-control validNumber" name="quantity[<?php echo $iNum-1;?>]" value="<?php if(isset($value->quantity)) echo $value->quantity;?>">
                              </td>
                              <td class="form-group">
                                <select data-html="true" class="form-control qtyType" name="qtyType[]">
                                    <option value="">Select option</option>
                                    <option  id="addNewQtyType" data-ref="addNewQtyType" value=""> <a href="javascript:void(0)" class="btn btn-success"> Add New </a></option>
                                    <?php $measurementType = getQtyTypes();
                                    if(!empty($measurementType)){
                                    foreach ($measurementType as $qtyType) { ?>
                                      <option value="<?php echo $qtyType->typeRef;?>" <?php if($value->qtyTypeRef == $qtyType->typeRef) echo "selected"; ?>><?php echo $qtyType->typeName;?></option>
                                    <?php } } else{ ?>
                                      <option value="">No Record..</option>
                                    <?php }  ?>
                                </select>
                            </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="oneServiceProductPrice validNumber calculation form-control" name="rate[<?php echo $iNum-1;?>]"  placeholder="0" value="<?php if(trim($value->rate) !="") echo $value->rate;?>">
                                </div>
                              </td>

                              <td>
                                  <input type="text" class="productServiceGross price form-control" id="productServiceGross" name="amount[]" value="<?php if(trim($value->amount) !="") echo $value->amount.".00";else echo "0.00"?>"  class="calculation" readonly>
                              </td>
                              <td>
                                <input type="hidden" class="vatAmount" id="vatAmount" value=""  name="vatAmount[]">
                                <input type="hidden" class="discountAmountPerItem" id="discountAmountPerItem" value=""  name="discountAmountPerItem[]">
                                <input type="hidden" class="commisionAmountPerItem" id="commisionAmountPerItem" value=""  name="commisionAmountPerItem[]">
                                <input type="text" class="productServiceVAT validNumber calculation form-control" id="productServiceVAT" value="<?php if(trim($value->vatPercentage) !="") echo $value->vatPercentage; else if(isset($productVat[0]->vatPercentage)) echo  $productVat[0]->vatPercentage;?>"  name="vatPercentage[]">
                              </td>
                                <input type="hidden" class="productServiceTotal form-control" id="productServiceTotal" name="productServiceTotal[]" readonly>
                              <?php  if($iNum > 1){?>
                                <td class="addMins">
                                  <span class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>
                                </td>
                              <?php } ?>
                          </tr>
                        <?php } ?>
                  </tbody>
              </table>
        </div>
        </div>
    </div>
    </div>
              <div class="col-md-6">
                  <a href="javascript:void(0)" id="addLayer" class="btn btn-success"> <i class="fa fa-plus"> </i> Add New Line </a>
              </div>

              <div class="col-md-5 pull-right text-right">
                <table class="table table-responsive table-hover">
                    <tbody>
                      <tr>
                        <td class="text-right"><h4>Sub Total :- </h4></td>
                        <td><h4 class="text-right totalServicePrice"> <?php if (isset($result->items[0]->amount))  {$Subprice = 0;foreach ($result->items as $value) {  $Subprice += $value->amount; } echo $Subprice.".00";} else echo "0.00";?></h4></td>
                          <input type="hidden" name ="subTotal" class="inputVaTotalServicePrice">
                      </tr>
                      <tr>
                          <td class="text-right"><h4>VAT :- </h4></td>
                          <td>  <h4 class="text-right vat"><?php if(isset($result->items[0]->vatAmount))  {$Vatprice = 0;foreach ($result->items as $value) {  $Vatprice += $value->vatAmount; } echo $Vatprice.".00";} else echo "0.00"; ?> </h4></td>
                          <input name="vatTotal" type="hidden" class="inputVat">
                      </tr>
                      <tr>
                          <td class="text-right"><h4>Grand Total :- </h4></td>
                          <td> <h4 class="text-right totalVatPrice">
                              <?php if (isset($result->items[0]->amount)) {$price = 0;foreach ($result->items as $value) {  $price += $value->amount + $value->vatAmount; } echo $price.".00";}  else echo "0.00"?>
                             </h4>
                             <input name="grandTotal" type="hidden" class="inputTotalVatPrice">
                          </td>
                      </tr>

                    </tbody>
                  </table>
              </div>

              <div class="clearfix"></div>
              <br>
              <div class="col-md-12 text-right pull-right">
                <input type="hidden" name="transactionItemsRefers" class="transactionItemRef">
                <input type="hidden" name="totalVatPriceInput" class="totalVatPriceInput">
                <input type="hidden" name="paymentDate" class="paymentDate">
                <input type="submit" value="Save" class="btn btn-success">

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
          <input type="text" class="form-control searchExpense productService product" placeholder="Search..." data-type="expense" name="subcategoryRef[]" value="">
          <input type="hidden" class="form-control serviceRefValidate serviceRef" name="serviceRef[]" value="">
          <input type="hidden" name="ParentCategoryRef[]" class="ParentCategoryRef" value="">
          <ul class="categoryList list-group hide"></ul>

      </div>
      </td>
      <td>
          <input type="text" class="form-control" id="productServiceDescrp" name="description[]">
      </td>
      <td class="tdQuantity form-group">
           <input type="hidden" class="validNumber form-control validNumber itemRef" name="transactionItemRef[]" value="">
          <input type="text" class="productServiceQty validNumber calculation form-control" name="quantity[]">
      </td>
      <td class="form-group">
        <select data-html="true" class="form-control qtyType" name="qtyType[]">
            <option value="">Select option</option>
            <option  id="addNewQtyType" data-ref="addNewQtyType" value=""> <a href="javascript:void(0)" class="btn btn-success"> Add New </a></option>
            <?php $measurementType = getQtyTypes();
            if(!empty($measurementType)){
            foreach ($measurementType as $qtyType) { ?>
              <option value="<?php echo $qtyType->typeRef;?>"><?php echo $qtyType->typeName;?></option>
            <?php } } else{ ?>
              <option value="">No Record..</option>
            <?php }  ?>
        </select>
    </td>
      <td>
          <div class="form-group">
          <input type="text" class="oneServiceProductPrice validNumber calculation form-control" placeholder="0" name="rate[]">
        </div>
      </td>

      <td>
          <input type="text" class="productServiceGross price form-control" id="productServiceGross" name="amount[]" class="calculation" readonly>
      </td>
      <td>
        <input type="hidden" class="vatAmount" id="vatAmount" value=""  name="vatAmount[]">
        <input type="hidden" class="discountAmountPerItem" id="discountAmountPerItem" value=""  name="discountAmountPerItem[]">
        <input type="hidden" class="commisionAmountPerItem" id="commisionAmountPerItem" value=""  name="commisionAmountPerItem[]">
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
<div class="modal fade" id="add-Category-modal">

  <div class="modal-dialog modal-md">
      <?php echo form_open('ajaxaddaccounting', array('id' => 'addAccounting', 'autocomplete' => 'off')); ?>
      <div class="modal-content">

          <div class="modal-body">

                    <div class="col-md-12 form-group">
                      <label class="form-label"> Select Parent Category </label>
                        <div class="form-group">
                          <select data-html="true" id="catNameRef" name="ParentCategory" class="form-control">
                            <option value=""> <a href="javascript:void(0)" class="btn btn-success"> Select Category </a></option>
                            <?php foreach ($expenseCat as $expenseValue) {
                              ?>
                                <option value="<?php echo $expenseValue->categoryRef  ;?>"><?php echo $expenseValue->title;?> </option>
                            <?php
                               } ?>
                          </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 form-group">
                      <label class="form-label"> Category Name</label>
                        <div class="form-group">
                            <input type="text" name="title" value="" class="form-control" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="clearfix"></div>
          </div>
          <div class="modal-footer">
              <input id="cattype" type="hidden" value="expense" name="type">
              <input type="hidden" name="modelHide" value="redirect" id="selectedSrNo">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <input type="submit" value="Save" class="btn btn-success pull-right">
          </div>

      </div>
      </form>
  </div>
  <?php /*  <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-lg-12 col-md-12">
                    <form action="" id="addCategory" method="post">
                        <div class="radioBtns">
                            <!-- <div class="form-group col-sm-12 col-md-6 ">

          		                <input type="checkbox" id="parent" checked name="categoryType" value="0" class="addCat parentChk "> &nbsp; <label class=" mouserpointer addCatLbl" for="parent">Parent Category</label>
                            </div>-->
                            <div class="form-group col-sm-12 col-md-6 ">
                              <input type="checkbox" checked id="children" name="categoryType" value="1" class="addCat parentChk "> &nbsp; <label class="mouserpointer addCatLbl" for="children">Child Category</label>
                    	      </div>
                          </div>
                          <div class="clearfix"> </div>
                          <div class="parent hide">
                              <div class="form-group">
                                <label> Category Name </label>
                                <input type="text" id="textcatname"  name="textcatname" value="" class="form-control" placeholder="Category Name">
                              </div>
                              <div class="form-group">
                                <label> Sub-Category Name </label>
                                <input type="text" id="textsubcatname" name="textsubcatname" value="" class="form-control" placeholder="Sub Category Name">
                              </div>
                          </div>

                            <div class="children">
                                <div class="form-group">
                                    <label> Parent Categories </label>
                                    <select data-html="true" id="catNameRef" name="catNameRef" class="form-control">
                                      <option value=""> <a href="javascript:void(0)" class="btn btn-success"> Select Category </a></option>
                                      <?php foreach ($expenseCat as $expenseValue) {
                                        ?>
                                          <option value="<?php echo $expenseValue->categoryRef  ;?>"><?php echo $expenseValue->title;?> </option>
                                      <?php
                                         } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                  <label> Category Name </label>
                                  <input type="text" id="subcatName" name="subcatName" value="" class="form-control" placeholder="Sub Category Name">
                                </div>
                            </div>
                            <div class="errMsg"></div>
                </div>
              <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="srNo" value="" id="selectedSrNo">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success savePaymentBtn" id="saveCategory">Save</button>
            </div>
            </form>
        </div>
    </div>
     */ ?>
</div>

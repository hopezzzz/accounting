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
    }


});

</script>
<div class="content-wrapper" style="height: 1000px !important">
    <section class="content-header">
        <h1><?php if( $result->paymentStatus == 'paid' ) echo "View Purchase"; else  echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <?php //echo "<pre>"; print_r($result); echo "</pre>"; ?>
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <a href="<?php echo site_url();?>purchase" class="success btn btn-success"> Back</a>
        </div>
        <div class="clearfix"></div>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
            <?php echo form_open('addtransactionajax', array('id' => 'add-purchase-form', 'autocomplete' => 'off')); ?>
              <div class="col-md-4">
                <label class="form-label"> Payment Method </label>
                  <div class="form-group">
                      <select class="form-control" name="paymentMethod" id="payMethod">
                          <<option value=""> Select Payment Method</option>
                          <option <?php if($result->paymentMethod == '1') echo "selected"; ?> value="1">  Cash</option>
                          <option <?php if($result->paymentMethod == '2') echo "selected"; ?> value="2">  NetBanking</option>
                          <option <?php if($result->paymentMethod == '3') echo "selected"; ?> value="3">  Credit</option>
                          <option <?php if($result->paymentMethod == '4') echo "selected"; ?> value="4">  Debit Card</option>
                          <option <?php if($result->paymentMethod == '5') echo "selected"; ?> value="5">  Cheque</option>

                      </select>
                  </div>
              </div>
              <div class="clearfix"></div>
              <br>
              <div class="col-lg-4 col-md-6">
                <input type="hidden" id="creditorRef" name="payeeRef" value="<?php if($result->payeeRef) echo $result->payeeRef;?>">
                <input type="hidden" name="transactionType" value="purchase">
                <input type="hidden" name="transactionRef" value="<?php echo $this->uri->segment('2'); ?>">
                <label class="form-label"> Payee Name</label>
                  <div class="form-group">
                      <?php $name = $result->title.' '.$result->firstName.' '.$result->lastName; $name = trim($name); ?>
                        <input class="form-control" name="payeeName" id="creditorName" value="<?php echo $name;?>"  placeholder="Payee Name">
                      <ul class="list-group" id="creditorSearchList" style="list-style:none">

                      </ul>
                  </div>
                  <div id="popover-form" class="hide">
                      <h4 class="text-center">Add New Creditor</h4>
                      <div class="form-group">
                          <input autocomplete="off" id="addCreditorName" name="addCreditorName" type="text" placeholder="Enter Name" class="form-control">
                      </div>

                  </div>
              </div>
              <div class="col-md-6 pull-right">

                  <div class="col-md-8 text-right"><h4><b>Invoice Date<h4></b></div>
                  <div class="col-md-4 text-right"><h4><input autocomplete="off" type="text" name="invoiceDate" value="<?php if(trim($result->createdDate) !='') echo date('d-m-Y', strtotime($result->createdDate)); else echo date('d-m-Y');?>" readonly="" id="invoiceDate" class="datepicker form-control" placeholder="" aria-required="true" aria-invalid="false"></h4></div>
                  <div class="col-md-8 text-right"><h4><b>Delivery Date</b><h4></div>
                  <div class="col-md-4 text-right"><h4><input autocomplete="off" type="text" name="deliveryDate" value="<?php if(trim($result->deliveryDate) !="") echo date('d-m-Y', strtotime($result->deliveryDate)); else echo date('d-m-Y');?>" readonly="" id="deliveryDate" class="datepicker form-control" placeholder="" aria-required="true" aria-invalid="false"></h4></div>


                  <div class="col-md-8 text-right"><h4><b>Invoice Number</b><h4></div>

                  <div class="col-md-4 text-right">
                    <input id="boxInvoiceNum" class="form-control boxInvoiceNum" type="text" name="invoiceNo" value="<?php  if(trim($result->invoiceNo) !=""){ echo ucfirst($result->invoiceNo);}?>">
                  </div>

              </div>
              <div class="clearfix"></div><br>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="tableList">
                      <thead>
                          <tr>
                              <th>S.No</th>
                              <th>Product/Service</th>
                              <th>QTY</th>
                              <th>Rate</th>
                              <th>Description</th>
                              <th>Gross Amount</th>
                              <th>VAT(%)</th>
                              <!--th>Total</th-->
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                           $i = 0;
                           foreach ($result->items as $value) {
                             $i++;
                             ?>
                          <tr class="dealPack trSrNo<?php echo $i;?>">
                              <td class="serialNumberr"><?php echo $i;?></td>
                              <td class="form-group col-sm-2">


                                <select data-html="true"  name="product[<?php echo $i-1;?>]" class="form-control productService product">
                                  <option value=""> <a href="javascript:void(0)" class="btn btn-success"> Select Product </a></option>
                                  <option id="addnewProduct" value="addnewProduct"> <a href="javascript:void(0)" class="btn btn-success" selected> Add New Product </a></option>
                                  <?php foreach ($productServices as $Servicesvalue) { ?>
                                      <option <?php if($value->productRef == $Servicesvalue->productRef ) echo "selected";?> value="<?php echo $Servicesvalue->productRef;?>"><?php echo $Servicesvalue->productName;?></option>
                                  <?php  } ?>

                                </select>
                              </td>
                              <td class="tdQuantity form-group">
                                  <input type="hidden" class="validNumber form-control validNumber itemRef" name="transactionItemRef[]" value="<?php echo $value->itemRef;?>">
                                  <input type="text" class="productServiceQty calculation validNumber form-control validNumber" name="quantity[<?php echo $i-1;?>]" value="<?php if(isset($value->quantity)) echo $value->quantity;?>">
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="oneServiceProductPrice validNumber calculation form-control" name="rate[<?php echo $i-1;?>]"  placeholder="0" value="<?php if(trim($value->rate) !="") echo $value->rate;?>">
                                </div>
                              </td>
                              <td>
                                  <input type="text" class="form-control" id="productServiceDescrp" name="description[]" value="<?php if(isset($value->description)) echo $value->description;?>">
                              </td>
                              <td>
                                  <input type="text" class="productServiceGross price form-control" id="productServiceGross" name="amount[]" value="<?php if(trim($value->amount) !="") echo $value->amount.".00";else echo "0.00"?>"  class="calculation" readonly>
                              </td>
                              <td>
                                <input type="hidden" class="vatAmount" id="vatAmount" value=""  name="vatAmount[]">
                                <input type="text" class="productServiceVAT validNumber calculation form-control" id="productServiceVAT" value="<?php if(trim($value->vatPercentage) !="") echo $value->vatPercentage; else if(isset($productVat[0]->vatPercentage)) echo  $productVat[0]->vatPercentage;?>"  name="vatPercentage[]">
                              </td>
                                <input type="hidden" class="productServiceTotal form-control" id="productServiceTotal" name="productServiceTotal[]" readonly>
                              <?php  if($i > 1){?>
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
              <div class="col-md-6">
                  <a href="javascript:void(0)" id="addLayer" class="btn btn-success"> <i class="fa fa-plus"> </i> Add New Line </a>
              </div>

              <div class="col-md-5 pull-right text-right">
                <table class="table table-responsive table-hover">
                    <tbody>
                      <tr>
                        <td class="text-right"><h4><b>Sub Total </b>:- </h4></td>
                        <td><h4 class="text-right totalServicePrice"> <?php if (isset($result->items[0]->amount))  {$Subprice = 0;foreach ($result->items as $value) {  $Subprice += $value->amount; } echo $Subprice.".00";} else echo "0.00";?></h4></td>
                          <input type="hidden" name ="subTotal" class="inputVaTotalServicePrice">
                      </tr>
                      <tr>
                          <td> <div class="col-sm-3 text-right"></div>
                            <div class="col-sm-6 text-right">
                              <select id="discountType" name="discountType" class="selectpicker form-control dw1 success calculation dealDiscountType" style="border: 1px solid rgb(60, 118, 61);">
                                   <option  value="0" selected="selected">Choose Discount Type</option>
                                   <option <?php if($result->discountType == '1' ) echo "selected"; ?> value="1">Discount Price</option>
                                   <option <?php if($result->discountType == '2' ) echo "selected"; ?> value="2">Discount Percentage</option>
                               </select>
                            </div>
                            <div class="col-sm-3 text-right">
                               <div class="form-group">
                                   <input type="text" id="discountVal" class="form-control calculation validNumber" name="discountAmount" value="<?php if($result->discountAmount) echo $result->discountAmount;?>">
                               </div>
                            </div>
                          </td>
                          <td>  <h4 class="text-right totalDiscount"> <?php if (isset($result->amount))  {$price = 0;foreach ($result as $value) {  $price += $value->amount; } echo $price.".00";} else echo "0.00";?></h4></td>

                      </tr>

                      <tr>
                        <td> <div class="col-sm-3 text-right"></div>
                          <div class="col-sm-6 text-right">
                            <select id="commisionType" name="commisionType" class="selectpicker form-control dw1 success calculation dealDiscountType" style="border: 1px solid rgb(60, 118, 61);">
                                 <option value="0" selected="selected">Choose Commission Type</option>
                                 <option <?php if($result->commisionType == '1' ) echo "selected"; ?> value="1">Commission Price</option>
                                 <option <?php if($result->commisionType == '2' ) echo "selected"; ?> value="2">Commission Percentage</option>
                             </select>
                          </div>
                          <div class="col-sm-3 text-right">
                             <div class="form-group">
                                 <input type="text"  id="commisionVal" class="form-control calculation validNumber" name="commisionAmount" value="<?php if($result->commisionAmount) echo $result->commisionAmount;?>">
                             </div>
                          </div>
                        </td>
                        <td>  <h4 class="text-right totalCommision"> <?php if (isset($result->amount))  {$price = 0;foreach ($result as $value) {  $price += $value->amount; } echo $price.".00";} else echo "0.00";?></h4></td>
                      </tr>

                      <tr>
                          <td class="text-right"><h4><b>VAT </b>:- </h4></td>
                          <td>  <h4 class="text-right vat"><?php if(isset($result->items[0]->vatAmount))  {$Vatprice = 0;foreach ($result->items as $value) {  $Vatprice += $value->vatAmount; } echo $Vatprice.".00";} else echo "0.00"; ?> </h4></td>
                          <input name="vatTotal" type="hidden" class="inputVat">
                      </tr>
                      <tr>
                          <td class="text-right"><h4><b>Grand Total</b> :- </h4></td>
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
              <div class="pull-right">
                <input type="hidden" name="transactionItemsRefers" class="transactionItemRef">
                <input type="hidden" name="totalVatPriceInput" class="totalVatPriceInput">
                <input type="hidden" name="paymentDate" class="paymentDate">
                <input type="submit" value="Save" class="btn btn-success saveBtns">
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
      <td class="form-group col-sm-2">

        <select data-html="true"  name="product[]" class="form-control productService">
            <option value="">Select Product</option>
            <option  id="addnewProduct" value="addnewProduct"> <a href="javascript:void(0)" class="btn btn-success"> Add New Product </a></option>
          <?php foreach ($productServices as $value) { ?>
              <option value="<?php echo $value->productRef;?>"><?php echo $value->productName;?></option>
          <?php  } ?>
        </select>
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

<div id="myForm" class="hide">
        <div class="col-md-12">
            <label for="productName">Product / Service:</label>
            <input type="text" name="productName" id="ProductName" class="ProductName form-control" class="form-control input-md">
            <span id="errMsg" style="color:red"></span>
        </div>
        <div class="col-md-12" style="margin:10px">
            <input type="hidden" value="" id="selectedSrNo">
            <button type="button" id="newProduct" class="btn btn-primary" data-loading-text="Sending info.."><em class="icon-ok"></em> Save</button>
        </div>
</div>
<div id="result"></div>

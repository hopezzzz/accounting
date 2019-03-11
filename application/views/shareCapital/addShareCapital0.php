
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
              <div class="col-md-4">
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
              <div class="col-lg-4 col-md-6">
                <input type="hidden" id="shareHolderRef" name="shareHolderRef" value="<?php echo $result->shareHolderRef;?>">
                <input type="hidden" name="shareCapitalRef" value="<?php echo $this->uri->segment('2'); ?>">
                <div class="form-group">
                <label class="form-label"> Share Holder Name</label>
                        <input class="form-control" id="shareHolderName" name="payeeName" value="<?php if(isset($result->fullName)) { echo $result->fullName;}?>"  placeholder="Share Holder Name">
                        <ul class="list-group" id="shareHolderList" style="list-style:none"></ul>
                  </div>

                  <div id="popover-form" class="hide">
                      <h4 class="text-center">Add New Share Holder</h4>
                      <div class="form-group">
                        <label for="shareHolderName"> Share Holder Name</label>
                        <div class="clearfix"></div>
                        <div class="col-sm-3 no-padding" style="padding-right:4px !important">
                            <select class="form-control" name="title">
                              <option value="Mr." selected>Mr.</option>
                              <option value="Mrs.">Mrs</option>
                            </select>
                        </div>
                          <div class="col-sm-9 no-padding form-group ">
                              <input id="newHolderName" name="newHolderName" type="text" placeholder="Enter Name" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="shareHolderName"> Email ID</label>
                          <input  name="newemail" type="text" placeholder="Enter Email" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="shareHolderName">No. of Shares</label>
                          <input  name="noOfShare" type="text" placeholder="Enter No Of Shares" class="form-control">
                      </div>
                  </div>

              </div>

              <div class="col-md-4 col-md-6">
                  <label class="form-label"> Date</label>
                  <input type="text" id="invoiceDate" name="Date" value="<?php if(trim($result->Date) !="") echo date('d-m-Y', strtotime($result->Date)); else echo date('d-m-Y'); ?>" readonly="" class="datepicker form-control" placeholder="Enter Date Of Incorporation">
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


<div class="content-wrapper">
    <section class="content-header">
        <h1><?php if( $result->bankRef !== '' ) echo "Update Bank"; else  echo $title; ?><small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <?php //echo "<pre>"; print_r($output); echo "</pre>"; ?>
    <section class="content">
      <div class="step_panel">
        <div class="col-md-6 text-left">
          <a href="<?php echo site_url();?>bank" class="success btn btn-success"> Back</a>
        </div>
        <div class="clearfix"></div><br>
        <div class="row setup-content" id="step-1">
          <div class="col-md-12">
          	<div class="row">
            <?php echo form_open('ajaxaddbank', array('id' => 'addbankform', 'autocomplete' => 'off')); ?>
              <div class="col-md-5">
                  <div class="form-group">
                    <label class="form-label"> Bank Name </label>
                      <input type="text" name="name" value="<?php if($result->name) echo $result->name;?>" class="form-control" placeholder="Bank Name">
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-5">
                  <div class="form-group">
                    <label class="form-label"> Bank Code</label>
                      <input type="text" name="code" value="<?php if($result->code) echo $result->code;?>" class="form-control" placeholder="Bank Code">
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-5">
                  <div class="form-group">
                    <label class="form-label"> Account No.</label>
                      <input type="text" name="accountNumber" value="<?php if($result->accountNumber) echo $result->accountNumber;?>" class="form-control" placeholder="Account Number">
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-5">
              <input type="hidden" name="bankRef" value="<?php if($result->bankRef) echo $result->bankRef;?>">
              <input type="submit" value="Save" class="btn btn-success saveBtns pull-right">

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

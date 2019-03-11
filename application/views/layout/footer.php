<footer class="main-footer">
    <!--div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
    </div-->
    <strong><?php echo $this->config->item('copyrightText'); ?>.</strong>
</footer>
<div id="myForm" class="hide">
  <div class="row setup-content" id="step-1">
    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 form-group" style="margin-bottom:-8px">
          <label class="form-label"> Unit of Measurement </label>
            <div class="form-group">
              <input type="text" id="typeName" name="typeName" value="" class="form-control typeName">
            </div>
        </div>
        <div class="col-xs-12">
        <input type="hidden" id="typeRef" name="typeRef" class="typeRef" value="">
        <input type="hidden" id="selectedSrNo" value="">
          <input type="button" id="btnQtyType" value="Save" class="btn btn-success pull-right">
      </div>
      </div>
    </div>
  </div>
</div>
<div id="productFrom" class="hide">
        <div class="col-md-12" style="padding:10px">
            <label for="productName">Product / Service:</label>
            <input type="text" name="productName" id="ProductName" class="ProductName form-control" class="form-control input-md">
            <span id="errMsg" style="color:red"></span>
        </div>
        <div class="col-md-12 no-padding" style="margin:10px">
            <input type="hidden" value="" id="selectedSrNo">
            <button type="button" id="newProduct" class="btn btn-success " data-loading-text="Sending info.."><em class="icon-ok"></em> Save</button>
        </div>
</div>
<div id="result"></div>

<div id="newBank" class="hide">
        <div class="col-md-12">
          <div class="form-group">
              <label for="bankName">Bank Name:</label>
              <input type="text" name="bank" id="bank" class="bankName form-control" class="form-control input-md">
          </div>

          <div class="form-group">
              <label for="bankName">Account Number:</label>
              <input type="text" name="accountNumber" id="accountNumber" class="accountNumber validNumber form-control" class="form-control input-md">
          </div>

        </div>
        <div class="clearfix"></div>
        <div class="col-md-12" style="margin: 10px 0">
            <button type="button" id="newBankbtn" class="btn btn-primary " data-loading-text="Sending info.."><em class="icon-ok"></em> Save</button>
        </div>
</div>
<div id="bankResult"></div>

</div>
<!-- ./wrapper -->

<script src="<?php echo $this->config->item('assets_path'); ?>js/jquery.form.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>js/jquery.toast.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>js/jquery.validate.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>js/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>js/form-validate.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>js/additional-method.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>js/custom.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<!--script src="<?php echo $this->config->item('assets_path'); ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/morris.js/morris.min.js"></script-->
<!-- Sparkline -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $this->config->item('assets_path'); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $this->config->item('assets_path'); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $this->config->item('assets_path'); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->item('assets_path'); ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->item('assets_path'); ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--script src="<?php echo $this->config->item('assets_path'); ?>dist/js/pages/dashboard.js"></script-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->item('assets_path'); ?>dist/js/demo.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo $this->config->item('assets_path');?>plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo $this->config->item('assets_path');?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $this->config->item('assets_path');?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $this->config->item('assets_path');?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script type="text/javascript">
$(document).ready(function ()
{
        jQuery('.productServiceGross').addClass('validNumber');
        $(document).on("input", ".numeric", function () {
            this.value = this.value.replace(/[^\d]/g, '');
        });

    $(".phoneNo").inputmask("(999) 999-9999",{removeMaskOnSubmit: true,"clearIncomplete": true });
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    })
    $('.datepicker').datepicker({
        autoclose: true,
        format   : 'dd-mm-yyyy'
    })

    $("#invoiceDate").datepicker({
        autoclose   : true,
        format      : 'dd-mm-yyyy',
        startDate   : new Date(),
    }).on('changeDate', function (selected)
    {
        var minDate  = new Date(selected.date.valueOf());
        var date     = minDate.getDate();
        var month    = minDate.getMonth()+1;
        var year     = minDate.getFullYear();
        if(date < 10 )
            date = '0'+date;
        if(month < 10 )
            month = '0'+month;

        $('#deliveryDate').datepicker('setStartDate', minDate);
        var invoiceDate = minDate;
        invoiceDate.setDate(invoiceDate.getDate() + 1);

        var deliveryDate = $('#deliveryDate').val();
        if( deliveryDate == '' || deliveryDate == undefined )
            $('#deliveryDate').val(date+'-'+month+'-'+year);
        else
        {
            deliveryDate     = deliveryDate.split('-');
            deliveryDate     = new Date(deliveryDate[2]+'-'+deliveryDate[1]+'-'+deliveryDate[0]);
            if( deliveryDate < invoiceDate )
                $('#deliveryDate').val(date+'-'+month+'-'+year);
        }
    });

    $("#deliveryDate").datepicker({
        autoclose   : true,
        format      : 'dd-mm-yyyy',
        startDate   : new Date()
    }).on('changeDate', function (selected)
    {
        var maxDate  = new Date(selected.date.valueOf());
        var date     = maxDate.getDate();
        var month    = maxDate.getMonth()+1;
        var year     = maxDate.getFullYear();
        if(date < 10 )
            date = '0'+date;
        if(month < 10 )
            month = '0'+month;

        $('#invoiceDate').datepicker('setEndDate', maxDate);
        var deliveryDate = maxDate;
        deliveryDate.setDate(deliveryDate.getDate() + 1);

        var invoiceDate = $('#invoiceDate').val();
        if( invoiceDate == '' || invoiceDate == undefined )
            $('#invoiceDate').val(date+'-'+month+'-'+year);
        else
        {
            invoiceDate     = invoiceDate.split('-');
            invoiceDate     = new Date(invoiceDate[2]+'-'+invoiceDate[1]+'-'+invoiceDate[0]);
            if( deliveryDate < invoiceDate )
                $('#invoiceDate').val(date+'-'+month+'-'+year);
        }
    });
});
</script>
<?php if( $this->session->flashdata('error_message') ){?>
    <script type="text/javascript">
        $.toast().reset('all');
        $.toast({
            heading             : 'Error',
            text                : '<?php echo $this->session->flashdata('error_message');?>',
            loader              : true,
            loaderBg            : '#fff',
            showHideTransition  : 'fade',
            icon                : 'error',
            hideAfter           : 4000,
            position            : 'top-right'
        });
    </script>
<?php } ?>
<?php if( $this->session->flashdata('success_message') ){?>
    <script type="text/javascript">
        $.toast().reset('all');
        $.toast({
            heading             : 'Success',
            text                : '<?php echo $this->session->flashdata('success_message');?>',
            loader              : true,
            loaderBg            : '#fff',
            showHideTransition  : 'fade',
            icon                : 'success',
            hideAfter           : 4000,
            position            : 'top-right'
        });
    </script>
<?php } ?>
<input type="hidden" value="<?php echo base_url(); ?>" id="site_url">
<div class="modal fade" id="confirm-delete-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p align="center"><img src="<?php echo site_url('assets/images/cross.png');?>" /></p>
                <p align="center">That doesn't seem like a good idea. Are you sure you want to do that? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success deleteRecordBtn">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-status-update-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p align="center"><img src="<?php echo site_url('assets/images/info.png');?>" /></p>
                <p align="center"> Are you sure you want to make <span class="statusLabel"></span> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success updateRecordStatusBtn">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-payment-status-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-color: #e4dadab3;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Receive Payment</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Total Payment</label>
              	        <div class="form-group">
              		        <input type="text" disabled="disabled" id="transactionTotalPaymentPopup" class="form-control" value="">
              	        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Payment Received</label>
              	        <div class="form-group">
              		        <input type="text" disabled="disabled" id="transactionPaymentReceivedPopup" class="form-control" value="">
              	        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Balance Amount</label>
              	        <div class="form-group">
              		        <input type="text" disabled="disabled" id="transactionPaymentPendingPopup" class="form-control" value="">
              	        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Payment Method</label>
              	        <div class="form-group">
              		        <select class="form-control receivePaymentMethod" name="paymentMethod" >
                                <option value=""> -- Select -- </option>
                                <option value="1">Cash</option>
                                <option value="2">Bank</option>
                            </select>
              	        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Select bank</label>
              	        <div class="form-group">
                            <select class="form-control receivePaymentBankRef" name="bankRef" >
                                <option value=""> -- Select -- </option>
                                <?php $banks = getBanks();
                                    foreach ($banks as  $bankValue) {?>
                                        <option value="<?php echo $bankValue->bankRef;?>"> <?php echo $bankValue->name; ?></option>
                                <?php } ?>
                            </select>
              	        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Select Payment Date</label>
              	        <div class="form-group">
              		        <input type="text" name="paymentDateSelect" id="paymentDateSelect" class="form-control datepicker" value="" readonly>
                            <input type="hidden" name="transactionRef" id="paymentStatusTransactionRef"/>
              	        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Amount</label>
              	        <div class="form-group">
              		        <input class="form-control receivePaymentAmount validNumber" name="receivePaymentAmount" />
              	        </div>
                    </div>
                </div>
              <div class="clearfix"></div>
            </div>
            <div class="modal-footer" style="border-top-color: #e4dadab3;">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success savePaymentBtn">save</button>
            </div>
        </div>
    </div>
</div>



</body>
</html>
<script type="text/javascript">
var today = new Date();
$
jQuery('#datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    endDate: "today",
    maxDate: today
})
</script>

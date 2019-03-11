<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Invoice No</th>
                <th>Payee Name</th>
                <th>Payment Method</th>
                <th>Invoice Date</th>
                <th>Delivery Date</th>
                <th>Sub Total</th>
                <th>VAT Total</th>
                <th>Grand Total</th>
                <th>Paid Date</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($records)) {
                foreach ($records as $key => $value) { ?>
                    <tr id="transaction_<?php echo $value->transactionRef;?>">
                        <td><?php echo $start+$key+1; ?></td>
                        <td><a href="<?php  echo site_url('update-expense/' . $value->transactionRef); ?>"><?php echo ucfirst($value->invoiceNo); ?></a></td>
                        <td><?php echo ucfirst($value->payeeName); ?></td>
                        <td><?php echo paymentMethodLabel($value->paymentMethod); ?></td>
                        <td><?php echo date('d M Y',strtotime($value->invoiceDate)); ?></td>
                        <td><?php echo date('d M Y',strtotime($value->deliveryDate)); ?></td>
                        <<td><?php echo numberFormat($value->subTotal,2);?> </td>
                        <td><?php echo numberFormat($value->vatTotal,2); ;?> </td>
                        <td><?php echo numberFormat($value->grandTotal,2); ?> </td>
                        <td class="paymentDateTd"><?php if ($value->paymentStatus == 'paid') { echo date('d M Y',strtotime($value->paymentDate)); } ?> </td>
                        <td class="paymentStatusTd"><?php if ($value->paymentStatus == 'paid') {
                                echo '<span class="label label-success">Paid</span>';
                          } else {
                                echo '<span class="label label-warning">Pending</span>';
                          } ?></td>
                          <td class="statusTd"><?php if ($value->status == 0) {
                                echo '<span class="label label-warning">Inactive</span>';
                            } else {
                                echo '<span class="label label-success">Active</span>';
                            } ?></td>

                          <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu">
                                      <li><a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->invoiceNo);?>" data-type="transaction" data-ref="<?php echo $value->transactionRef;?>" >Delete</a></li>
                                      <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->invoiceNo);?>" data-type="transaction" data-ref="<?php echo $value->transactionRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                      <?php if( $value->paymentStatus == 'pending' && $value->paymentMethod == 3 ){?>
                                        <li class="paymentStatusLi"><a href="javascript:;" class="savePaymentStatus" data-deliverydate="<?php echo date('d-m-Y', strtotime($value->deliveryDate));?>" data-type="transaction" data-ref="<?php echo $value->transactionRef;?>">Mark As Paid</a></li>
                                      <?php } ?>
                                  </ul>
                              </div>
                          </td>
                    </tr>
                <?php }
            }
            else
            { ?>
                <tr><td align="center" colspan="11">No expense found.</td></tr>
    <?php   } ?>
        </tbody>
    </table>
</div>
<div class="box-footer clearfix">
    <?php echo $paginationLinks; ?>
</div>

<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Lender Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Company</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($records))
            {
                foreach ($records as $key => $value) { ?>
                    <tr id="loans_<?php echo $value->loanRef;?>">
                        <td><?php echo $key + 1; ?></td>
                        <td><a href="<?php  echo site_url('update-loan/' . $value->loanRef); ?>"><?php echo ucfirst($value->fullName); ?></a></td>
                        <td><?php echo $value->email; ?></td>
                        <td><?php echo date("d M Y",strtotime($value->date)); ?></td>
                        <td><?php echo ucfirst($value->companyname); ?></td>
                        <td><?php echo numberFormat($value->amount,2); ?></td>
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
                                      <li><a href="<?php  echo site_url('update-loan/' . $value->loanRef); ?>">Update</a></li>
                                      <li><a href="javascript:void(0);" class="deleteRecord" data-name="<?php echo ucfirst($value->fullName);?>" data-type="loans" data-ref="<?php echo $value->loanRef;?>" >Delete</a></li>
                                      <li><a href="javascript:void(0);" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->fullName);?>" data-type="loans" data-ref="<?php echo $value->loanRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                      <?php if( $value->paymentStatus == 'pending' ){?>
                                          <li class="paymentStatusLi"><a href="javascript:void(0);" class="savePaymentStatus" data-deliverydate="<?php echo date('d-m-Y');?>" data-type="loans" data-ref="<?php echo $value->loanRef;?>">Mark As Paid</a></li>
                                      <?php } ?>
                                  </ul>
                              </div>
                          </td>
                    </tr>
                <?php }
            }
            else
            { ?>
                <tr><td align="center" colspan="13">No Loans / Advances found.</td></tr>
      <?php   } ?>
        </tbody>
      </table>

</div>
<div class="box-footer clearfix">
    <?php echo $paginationLinks; ?>
</div>

<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Share Holder Name</th>
                <th>Payment Method</th>
                <th> Date</th>
                <th>Grand Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($records)) {
                foreach ($records as $key => $value) { ?>
                    <tr id="share-capital_<?php echo $value->shareCapitalRef;?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><a href="<?php  echo site_url('update-capital/' . $value->shareCapitalRef); ?>"><?php echo ucfirst($value->payeeName); ?></a></td>
                        <td><?php echo '<span class="label label-success">' .paymentMethodLabel($value->paymentMethod). '</span>'; ?></td>
                        <td><?php echo date('d M Y',strtotime($value->Date)); ?></td>
                        <td><?php echo $value->subTotal;?> </td>
                          <td class="statusTd"><?php if ($value->status == 0) {
                                echo '<span class="label label-warning">Inactive</span>';
                            } else {
                                echo '<span class="label label-success">Active</span>';
                            } ?>
                          </td>

                          <td>
                              <div class="btn-group">
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu">
                                      <li><a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->payeeName);?>" data-type="share-capital" data-ref="<?php echo $value->shareCapitalRef;?>" >Delete</a></li>
                                      <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->payeeName);?>" data-type="share-capital" data-ref="<?php echo $value->shareCapitalRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                  </ul>
                              </div>
                          </td>
                    </tr>
                <?php }
            }
            else
            { ?>
                <tr><td align="center" colspan="13">No Share Capital found.</td></tr>
      <?php   } ?>
        </tbody>
      </table>

</div>
<div class="box-footer clearfix">
    <?php echo $paginationLinks; ?>
</div>

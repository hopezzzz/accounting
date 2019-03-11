<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Bank Name</th>
                <th>Bank Code</th>
                <th>Bank Account No.</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($records)) {
                foreach ($records as $key => $value) { ?>
                    <tr id="bank_<?php echo $value->bankRef;?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><a href="<?php  echo site_url('update-bank/' . $value->bankRef); ?>"><?php echo ucfirst($value->name); ?></a></td>
                        <td><?php echo ucfirst($value->code); ?></td>
                        <td><?php echo ucfirst($value->accountNumber); ?></td>
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
                                      <li><a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->name);?>" data-type="bank" data-ref="<?php echo $value->bankRef;?>" >Delete</a></li>
                                      <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->name);?>" data-type="bank" data-ref="<?php echo $value->bankRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                  </ul>
                              </div>
                          </td>
                    </tr>
                <?php }
            }
            else
            { ?>
                <tr><td align="center" colspan="13">No Bank found.</td></tr>
      <?php   } ?>
        </tbody>
      </table>

</div>
<div class="box-footer clearfix">
    <?php echo $paginationLinks; ?>
</div>

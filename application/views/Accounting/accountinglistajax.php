<?php $companyData = $this->companyData->companyRef; ?>
<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>Type</th>
                <th>Parent Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <?php //echo "<pre>"; print_r($records); die; ?>
            <?php $i = 0; if (!empty($records)) {
                foreach ($records as $key => $value) { ?>
                    <tr id="accounting_<?php echo $value->categoryRef;?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo ucfirst($value->title); ?></td>
                        <td><?php echo ucfirst($value->type); ?></td>
                        <td><?php $category = parentCategoryName($value->parent); echo $category[$i]->title; ?></td>

                          <td class="statusTd"><?php if ($value->status == 0) {
                                echo '<span class="label label-warning">Inactive</span>';
                            } else {
                                echo '<span class="label label-success">Active</span>';
                            } ?></td>

                          <td>
                            <?php if ($companyData == $value->companyRef ) { ?>

                              <div class="btn-group">
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu">
                                      <li><a href="<?php echo site_url('update-accounting/'.$value->categoryRef);?>">Update</a></li>
                                      <li><a href="javascript:void(0);" data-status="<?php echo $value->status;?>" class="updateAccounting" data-name="<?php echo ucfirst($value->title);?>" data-type="accounting" data-ref="<?php echo $value->categoryRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                  </ul>
                              </div>
                            <?php } ?>
                          </td>
                    </tr>
                <?php }
            }
            else
            { ?>
                <tr><td align="center" colspan="13">No records found.</td></tr>
      <?php   } ?>
        </tbody>
      </table>

</div>
<div class="box-footer clearfix">
    <?php echo $paginationLinks; ?>
</div>

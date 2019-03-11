
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-md-8 text-right">
                    <a href="<?php echo site_url();?>add-unit-of-measurement" class="btn btn-success btn-margin"> Add Measurement</a>
                </div>
              <div class="input-group input-group-sm col-md-4 pull-right">
                <input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
                <div class="input-group-btn">
                  <button data-url="<?php echo site_url('unit-of-measurement');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div id="tableData">
              <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                      <thead>
                          <tr>
                              <th>S.No</th>
                              <th>Unit of measurement</th>
                              <th>Created Date</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if (!empty($records)) {
                              foreach ($records as $key => $value) { ?>
                                  <tr id="measurements_<?php echo $value->typeRef;?>">
                                      <td><?php echo $key + 1; ?></td>
                                      <td><a href="<?php echo site_url('update-unit-of-measurement/' . $value->typeRef); ?>"><?php echo ucfirst($value->typeName); ?></a></td>
                                      <td><?php echo  date('d M Y', strtotime($value->createdDate));?></td>
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
                                                  <!-- <li><a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->typeName);?>" data-type="measurements" data-ref="<?php echo $value->typeRef;?>" >Delete</a></li> -->
                                                  <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->typeName);?>" data-type="measurements" data-ref="<?php echo $value->typeRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                              </ul>
                                          </div>
                                      </td>
                                  </tr>
                              <?php }
                          }
                          else
                          { ?>
                              <tr><td align="center" colspan="13">No unit of measurement found.</td></tr>
                  <?php   } ?>
                      </tbody>
                  </table>
              </div>
              <div class="box-footer clearfix">
                  <?php echo $paginationLinks; ?>
              </div>
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

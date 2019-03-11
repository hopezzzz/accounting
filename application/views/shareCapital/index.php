<?php $this->load->view('client/clientjs'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?> <small></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" style="margin-top:10px">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                          <div class="col-sm-8 text-right">
                            <a href="<?php echo site_url();?>add-share-capital" class="btn btn-success btn-margin"> Add Share Capital</a>
                          </div>
                           <div class="col-md-4 pull-right">
                            <div class="input-group input-group-sm col-md-12">
                                <input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button data-url="<?php echo site_url('share-capital');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php // echo "<pre>"; print_r($records);  ?>
                    <div id="tableData">
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
                                                <td><?php echo $key + 1; ?></td>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

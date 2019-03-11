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
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                        <div class="col-sm-8 text-right">
                          <?php
                          $url = current_url();
                          $url = explode('/',$url);
                          if(end($url) == 'lenders')
                          { ?>
                              <a href="<?php echo site_url();?>add-lender" class="btn btn-success"> Add Lender </a>
                          <?php }  else { ?>
                              <a href="<?php echo site_url();?>add-borrower" class="btn btn-success"> Add Borrower </a>
                          <?php } ?>

                        </div>
                        <div class="col-md-4 pull-right">
                            <div class="input-group input-group-sm col-md-12">
              							<div class="input-group input-group-sm" >

              								<input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
              								<div class="input-group-btn">
              									<button data-url="<?php echo site_url('borrowers');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
              								</div>
              							</div>
						            </div>
                                    </div>
                    </div>
                    <div id="tableData">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Added Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($records)) {
                                        foreach ($records as $key => $value) {
                                            ?>
                                            <tr id="borrower_<?php echo $value->borrowerRef;?>">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><a class="showRecordsByReference mouserpointer" data-ref="<?php echo $value->borrowerRef;?>" data-type="borrower" ><?php echo ucfirst($value->companyname); ?></a></td>
                                                <td><?php echo ucfirst($value->fullName); ?></td>
                                                <td><?php echo $value->email; ?></td>
                                                <td><?php echo $value->phone; ?></td>
                                                <td><?php echo $value->mobile; ?></td>
                                                <td class="statusTd"><?php
                                                    if ($value->status == 0) {
                                                        echo '<span class="label label-warning">Inactive</span>';
                                                    } else {
                                                        echo '<span class="label label-success">Active</span>';
                                                    }
                                                    ?></td>
                                                <td><?php echo date('d M Y', strtotime($value->createdDate)); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                          <?php
                                                          $url = current_url();
                                                          $url = explode('/',$url);
                                                          if(end($url) == 'lenders')
                                                          { ?>
                                                            <li><a href="<?php echo site_url('update-lender/' . $value->borrowerRef); ?>">Update</a></li>
                                                          <?php }  else { ?>
                                                              <li><a href="<?php echo site_url('update-borrower/' . $value->borrowerRef); ?>">Update</a></li>
                                                          <?php } ?>


                                                            <li><a href="javascript:;" class="deleteRecord" data-name="<?php if( $value->fullName != '' )echo ucfirst($value->fullName); else echo ucfirst($value->companyname);?>" data-type="borrower" data-ref="<?php echo $value->borrowerRef;?>" >Delete</a></li>
        						                            <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php if( $value->fullName != '' )echo ucfirst($value->fullName); else echo ucfirst($value->companyname);?>" data-type="borrower" data-ref="<?php echo $value->borrowerRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td align="center" colspan="9">No record found.</td></tr>
                                    <?php } ?>
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

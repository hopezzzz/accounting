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
                            <a href="<?php echo site_url();?>add-creditor" class="btn btn-success"> Add Creditor </a>
                          </div>
                          <div class="col-md-4 pull-right">
                            <div class="input-group input-group-sm col-md-12">
  								<input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
    								<div class="input-group-btn">
    									<button data-url="<?php echo site_url('creditors');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                                        <th>Creditor</th>
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
                                            <tr id="creditor_<?php echo $value->creditorRef;?>">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><a class="showRecordsByReference mouserpointer" data-ref="<?php echo $value->creditorRef;?>" data-type="creditor" ><?php echo ucfirst($value->fullName); ?></a></td>
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
                                                            <li><a href="<?php echo site_url('update-creditor/' . $value->creditorRef); ?>">Update</a></li>
                                                            <li><a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->fullName);?>" data-type="creditor" data-ref="<?php echo $value->creditorRef;?>" >Delete</a></li>
        						                            <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->fullName);?>" data-type="creditor" data-ref="<?php echo $value->creditorRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td align="center" colspan="8">No creditor found.</td></tr>
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

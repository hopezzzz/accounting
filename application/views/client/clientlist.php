<?php $this->load->view('client/clientjs');?>
<div class="content-wrapper">
  	<section class="content-header">
		<h1>Client List <small></small></h1>
		<ol class="breadcrumb">
		  	<li><a href="<?php echo site_url('dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		  	<li class="active">Client List</li>
		</ol>
  	</section>
  	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"></h3>
						<div class="col-md-4 pull-right">
                            <div class="input-group input-group-sm col-md-12">
								<input type="text" id="searchKey" name="searchKey" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button data-url="<?php echo site_url('clients');?>" type="button" id="tableSearchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
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
										<th>Company Name</th>
										<th>Company Type</th>
										<th>Client</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Mobile</th>
										<th>Email Verified</th>
										<th>Status</th>
										<th>Added Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php  if(!empty($records)){
										foreach ($records as $key => $value) { ?>
										<tr id="client_<?php echo $value->clientRef;?>">
											<td><?php echo $key+1;?></td>
											<td><a href="<?php echo site_url('go-to-company/'.$value->clientRef);?>"><?php echo ucfirst($value->companyName);?></a></td>
											<td><?php echo ucfirst($value->companyType);?></td>
											<td><?php echo ucfirst($value->fullName);?></td>
											<td><?php echo $value->email;?></td>
											<td><?php echo $value->phone;?></td>
											<td><?php echo $value->mobile;?></td>
											<td><?php if( $value->isEmailVerified == 1 ) { echo '<span class="label label-warning">Pending</span>'; } else { echo '<span class="label label-success">Verifed</span>'; } ?></td>
											<td class="statusTd"><?php if( $value->status == 0 ) { echo '<span class="label label-warning">Inactive</span>'; } else { echo '<span class="label label-success">Active</span>'; } ?></td>
											<td><?php echo date('d M Y',strtotime($value->createdDate));?></td>
											<td>
												<div class="btn-group">
						                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						                            <span class="caret"></span>
						                          </button>
						                          <ul class="dropdown-menu">
						                            <li><a href="<?php echo site_url('update-client/'.$value->clientRef);?>">Update</a></li>
                                                    <li><a href="javascript:;" class="deleteRecord" data-name="<?php echo ucfirst($value->fullName);?>" data-type="client" data-ref="<?php echo $value->clientRef;?>" >Delete</a></li>
						                            <li><a href="javascript:;" data-status="<?php echo $value->status;?>" class="updateStatus" data-name="<?php echo ucfirst($value->fullName);?>" data-type="client" data-ref="<?php echo $value->clientRef;?>" >Make <?php if( $value->status == 0 ){?>Active<?php } else{?>Inactive<?php } ?> </a></li>
						                          </ul>
						                        </div>
											</td>
										</tr>
								<?php 	}
							}else{?>
								<tr><td align="center" colspan="11">No client found.</td></tr>
							<?php }?>
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

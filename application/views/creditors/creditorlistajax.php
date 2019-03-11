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
            <?php if (!empty($records)) {
                foreach ($records as $key => $value) {
                    ?>
                    <tr id="creditor_<?php echo $value->creditorRef;?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><a class="showRecordsByReference mouserpointer" data-ref="<?php echo $value->creditorRef;?>" data-type="creditor" ><?php echo ucfirst($value->fullName); ?></a></td>
                        <td><?php echo $value->email; ?></td>
                        <td><?php echo $value->phone; ?></td>
                        <td><?php echo $value->mobile; ?></td>
                        <td class="statusTd"><?php if ($value->status == 0) {
                echo '<span class="label label-warning">Inactive</span>';
            } else {
                echo '<span class="label label-success">Active</span>';
            } ?></td>
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
    <?php }
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

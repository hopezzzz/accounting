<div class="content-wrapper" style="min-height: 990.3px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Unit of measurement</h3>
              <div class="box-tools ">
                <button data-widget="collapse" class="btn btn-box-tool pull-right" type="button"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">

                  <li class="<?php if ($childUrl == 'add unit of measurement') echo "active"; ?>"><a href="<?php echo site_url('add-unit-of-measurement'); ?>"><i class="fa fa-plus"></i> Add New</a></li>
                  <li class="<?php if ($childUrl == 'unit of measurement') echo "active"; ?>"><a href="<?php echo site_url('unit-of-measurement'); ?>"><i class="fa fa-list"></i> Unit of Measurement List</a></li>

              </ul>
            </div>
            <!-- /.box-body -->
            <!-- /. box - remove this comment to make new box
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Labels</h3>

                <div class="box-tools">
                  <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                  <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
                  <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
                  <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
                </ul>
              </div>
              <!-- /.box-body --
            </div>
            <!-- /.box -->
          </div>

        </div>

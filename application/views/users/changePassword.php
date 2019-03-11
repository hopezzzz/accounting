<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active" ><a href="#settings" data-toggle="tab">Change Password</a></li>
            </ul>

              <div class="active tab-pane" id="settings">                
                    <?php echo form_open('changePassword', array('name' => 'changePassword', 'method' => 'post', 'class' => 'form form-signup', 'id' => "changePassword-form"));
?>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Old Password</label>

                    <div class="col-sm-8 has-feedback"><?php //print_r($companyData); // die;?>
                     <input maxlength="200" type="password" required="required" name="oldPassword" id="oldPassword" class="form-control" placeholder="Enter old password" />
                     <span class="form-control-feedback" style="right: 17px;"></span>
                    </div>
                  </div>
                   <div class="clearfix"></div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-8">
                      <input type="password" required="required" class="form-control" name="newPassword" id="newPassword" placeholder="Enter New Password" />
                    </div>
                  </div>
                   <div class="clearfix"></div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Confirm Password</label>

                    <div class="col-sm-8">
                      <input type="password" required="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Enter Confirm Password" />
                    </div>
                  </div>
                   <div class="clearfix"></div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
                                        
               <div class="clearfix"></div>
<?php echo form_close(); ?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
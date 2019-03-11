<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Accounting | Registration </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>css/custom.css"/>
        <!--<link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>css/style.css"/>-->
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>css/jquery.toast.css">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition register-page" id="registeration">
        <div class="register-box" style="width: 60%;">
            <div class="register-logo">
                <a href="javascript:void(0);" ><b>Accounting</b></a>
            </div>
            <?php
            $verifyClient = $this->session->userdata('verifyClient');
            $clientEmail = $verifyClient['clientEmail'];
            ?>
            <div class="register-box-body clearfix">
                <h3 class="login-box-msg">Get Started today</h3>
                <div class="row">
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div id="successMsg2" style="display:none;" ></div>
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('registration', array('name' => 'registration', 'method' => 'post', 'class' => 'form form-signup', 'autocomplete' => "off", 'id' => "emailVerification-form"));
                            ?>
                            <div id="successMsg2" style="display:none;" ></div>
                            <div id="successMsg" style="display:none;" ></div>
                            <div class="stepwizard-step clearfix">
                                <div class="col-md-12">
                                    <a href="javascript:;" type="button" id="step1" class="btn btn-default btn-circle <?php
                                    if (!empty($verifyClient)) {
                                        echo '';
                                    } else {
                                        echo 'btn-success';
                                    }
                                    ?>">1</a>
                                    <p>Email</p>
                                </div>
                            </div>
                            <div class="setup-content" id="step-1" style="display:<?php
                            if (!empty($verifyClient)) {
                                echo "none";
                            } else {
                                echo "block";
                            }
                            ?>">
                                <div class="stepone">
                                    <div class="step_panel">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>

                                                <input type="text" class="form-control" name="email" id="emailId" autocomplete="off" <?php
                            if (!empty($verifyClient)) {
                                echo 'value=' . $clientEmail;
                            }
                            ?>  <?php
                                                        if (!empty($verifyClient)) {
                                                            echo "disabled";
                                                        }
                                                        ?> placeholder="Email Address" />

                                                <div class="verfication" style="display:none;" ><h6><?php
                                                if (!empty($verifyClient)) {
                                                    echo 'Email verified';
                                                } else {
                                                    echo "Verification pending";
                                                }
                                                ?></h6></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="verfication" style="display:none;" >
<?php if (empty($verifyClient)) { ?>
                                                    <button class="btn btn-success pull-right" type="button" id="resentVerificationEmail">Resend verification email</button>
                            <?php } ?>
                                            </div>
                                            <div id="mailSendBtn" >
                                                <button class="btn btn-success pull-right" required="required" id="emailNextBtn" type="submit" >Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

<?php echo form_close(); ?>
                            <div class="clearfix"></div>
<?php echo form_open('registerCompany', array('name' => 'registerCompany', 'method' => 'post', 'class' => 'form form-signup', 'id' => "registerCompany-form"));
?>
                            <div class="stepwizard-step">
                                <a type="button" id="step2" class="btn btn-default btn-circle <?php
                            if (!empty($verifyClient)) {
                                echo 'btn-success';
                            } else {
                                echo '';
                            }
                            ?>" >2</a>
                                <p>Company Details</p>
                            </div>

                            <div class="setup-content" id="step-2" style="display: <?php
                            if (!empty($verifyClient)) {
                                echo "block";
                            } else {
                                echo "none";
                            }
                            ?>" >
                                <div class="step_panel">
                                    <div class="steptwo">
                                        <div class="form-group">
                                            <label class="control-label">Company Name</label>
                                            <input maxlength="200" type="text" required="required" name="companyName" class="form-control" placeholder="Enter Company Name" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Company Type</label><br>
                                            <input type="radio" class="" name="companyType" value="Trading">&nbsp;Trading&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="" name="companyType" value="Service/Consultancy">&nbsp;Service/Consultancy
                                        </div>
                                        <div class="form-group">
                                            <h4>Contact Person</h4>
                                            <label class="control-label">Name</label>
                                            <input type="text" required="required" class="form-control" name="contactName" placeholder="Enter Contact Name" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Phone</label>
                                            <input type="text" required="required" class="form-control phoneNo" name="contactPhone" placeholder="Enter Phone No" />

                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">VAT No.</label>
                                            <input type="text" name="vatNo"  id="vatText" class="form-control" placeholder="Enter VAT No" />
                                        </div>

                                        <div class="">
                                            <input type="checkbox" name="vatApplied" class="vatApplied" >&nbsp;Not yet applied
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success nextBtn pull-right" type="submit" >SUBMIT & CREATE ACCOUNT</button>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
<?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>login" class="text-center">I already have an account</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->

        <!-- jQuery 3 -->
        <script src="<?php echo $this->config->item('assets_path'); ?>bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo $this->config->item('assets_path'); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/form-validate.js"></script>

        <script src="<?php echo $this->config->item('assets_path'); ?>/js/jquery.form.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>js/custom.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>/js/jquery.form.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>/js/jquery.toast.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>js/form-validate.js"></script>
        <!-- iCheck -->
        <script src="<?php echo $this->config->item('assets_path'); ?>plugins/iCheck/icheck.min.js"></script>
        <script src="<?php echo $this->config->item('assets_path');?>plugins/input-mask/jquery.inputmask.js"></script>
        <script src="<?php echo $this->config->item('assets_path');?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="<?php echo $this->config->item('assets_path');?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <input type="hidden" value="<?php echo base_url(); ?>" id="site_url">
        <script>
            $(document).ready(function ()
            {
                $(document).on("input", ".numeric", function () {
                    this.value = this.value.replace(/[^\d]/g, '');
                });

                // $(".phoneNo").mask("(999) 999-9999");
                $(".phoneNo").inputmask("(999) 999-9999",{removeMaskOnSubmit: true,"clearIncomplete": true });

            });
        </script>
        <div class="loader_div" style="display: none;">
            <div class="loader" ></div>
        </div>
    </body>
</html>

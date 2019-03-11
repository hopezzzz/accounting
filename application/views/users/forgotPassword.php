<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Accounting | Forgot Password</title>
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

        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>css/custom.css">
        <link rel="stylesheet" href="<?php echo $this->config->item('assets_path'); ?>css/jquery.toast.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page" style="">
        <div class="login-box">
            <div class="login-logo">
                <a href="javascript:void(0)" ><b>Accounting</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Forgot Password </p>

                <?php echo validation_errors(); ?>
                <?php echo form_open('forgotPassword', array('name' => 'forgotPassword', 'method' => 'post', 'class' => 'form form-signup', 'id' => "forgotPassword-form",'autocomplete'=> 'off' ));
                ?>
                <div id="successMsg" style="display:none;" ></div>
                <div class="form-group has-feedback">
          <!--        <input type="email" class="form-control" placeholder="Email">-->
                    <input type="email" class="form-control" name="email" id="checkemailForgot" placeholder="Email Address" >

                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="row">                                  <!-- /.col -->
                    <div class="col-xs-12">
                      <div class="btns col-xs-7">
                      <a href="<?php echo base_url(); ?>" class="align-middle">Sign In</a> &nbsp; | &nbsp;
                      <a href="<?php echo base_url(); ?>register" class="text-center align-middle">Register a new</a>
                      </div>
                      <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary btn-success pull-right" id="forgotBtn" >Submit</button>
                      </div>

                        <!--<input type="submit" class="btn btn-primary btn-block btn-flat" role="button" placeholder="Login">-->
                    </div>
                    <!-- /.col -->
                </div>
                <?php echo form_close(); ?>

                <!--    <div class="social-auth-links text-center">
                      <p>- OR -</p>
                      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                        Facebook</a>
                      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                        Google+</a>
                    </div>-->
                <!-- /.social-auth-links -->


            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="<?php echo $this->config->item('assets_path'); ?>bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo $this->config->item('assets_path'); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo $this->config->item('assets_path'); ?>plugins/iCheck/icheck.min.js"></script>



        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/form-validate.js"></script>

        <script src="<?php echo $this->config->item('assets_path'); ?>js/custom.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>/js/jquery.form.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>/js/jquery.toast.js"></script>
        <script src="<?php echo $this->config->item('assets_path'); ?>js/form-validate.js"></script>
        <input type="hidden" value="<?php echo base_url(); ?>" id="site_url">


        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
        <div class="loader_div" style="display: none;">
            <div class="loader" ></div>
        </div>
    </body>
</html>

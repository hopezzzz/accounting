<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title." | ".$this->config->item('site_title');?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>css/custom.css">
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>css/jquery.toast.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	   folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>dist/css/skins/_all-skins.min.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/morris.js/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/jvectormap/jquery-jvectormap.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_path');?>plugins/iCheck/all.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- jQuery 3 -->
  <script src="<?php echo $this->config->item('assets_path');?>bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo $this->config->item('assets_path');?>js/common.js"></script>
  <script>
	var site_url='<?php echo site_url();?>';
  </script>
  <div class="loader_div" style="display: none;">
  	<div class="loader" ></div>
  </div>
</head>
<?php $loginSessionData = $this->session->userdata('clientData');
//echo "<pre>";print_r($loginSessionData);die;
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url(); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Accounting</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Accounting</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          	<li class="dropdown user user-menu">
            	<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
              		<span class="hidden-xs">
						<?php echo 'Hi '.$loginSessionData['clientEmail']; ?>
					</span>
            	</a>
	            <ul class="dropdown-menu">
					<?php if( ( $loginSessionData['userType'] == 1 || $loginSessionData['userType'] == 2 ) && !empty($loginSessionData['companyData'])  ) {?>
						<li class="user-header" style="height:auto">
		                  	<p>Signed in as <?php echo $loginSessionData['companyData']->companyName;?><small><?php echo 'Reg. No : '.$loginSessionData['companyData']->compRegNo;?></small></p>
		                </li>
		              	<li class="user-footer">
						   	<a href="<?php echo site_url('destroy-company-session'); ?>" class="btn btn-default btn-flat">Back to accountant view</a>
		              	</li>
					<?php } ?>
	              	<li class="user-footer">
	                	<div class="pull-left">
	                  		<a href="<?php echo site_url(); ?>changePassword" class="btn btn-default btn-flat">Change Password</a>
	                	</div>
	                	<div class="pull-right">
	                  		<a href="<?php echo site_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
	                	</div>
	              	</li>
	            </ul>
          	</li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
<?php $this->load->view('layout/sidebar');?>

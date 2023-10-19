<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bhooljao Admin Section.">
     
    <link rel="icon" href="<?php echo base_url();?>template/admin/assets/images/logo-small.png" type="image/x-icon">
   <!-- <link rel="shortcut icon" href="<?php echo base_url('template/admin/');?>assets/images/dashboard/favicon.png" type="image/x-icon"> -->
    
	<title>Bhooljao | <?php echo	$title;?></title>
	<meta name="keywords" content="Bhooljao Admin Section" />
	<meta name="description" content="Bhooljao Admin Section">
	<meta name="author" content="Bhooljao">
     <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/fontawesome.css">

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/flag-icon.css">

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/icofont.css">

    <!-- Prism css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/prism.css">

    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/chartist.css">
	
	<!-- Datepicker css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/date-picker.css">
	<!-- Timepicker css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/scss/bootstrap-timepicker/css/bootstrap-timepicker.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/bootstrap.css">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/admin.css">
	<script type="text/javascript">var BASEPATH="<?php echo base_url('backend/');?>";</script>
	<style>.error_msg{ color:red;}</style>
</head>

<body onload="getNotification()">

<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
    <div class="page-main-header">
        <div class="main-header-right row">
            <div class="main-header-left d-lg-none" style="background-color: #dddddd;border: solid #75299d 5px;">
                <div class="logo-wrapper" style="padding: 5px;">
                   			
                </div>
            </div>
            <!--<div class="mobile-sidebar">
                <div class="media-body text-right switch-sm">
                    <label class="switch"><a href="javascript:void(0);"><i id="sidebar-toggle" data-feather="align-left"></i></a></label>
                </div>
            </div>-->
            <div class="nav-right col">
                <ul class="nav-menus">
                    <!-- <li>
                        <form class="form-inline search-form">
                            <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search.."><span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
                            </div>
                        </form>
                    </li>
                    <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize-2"></i></a></li>
                    <li class="onhover-dropdown"><a class="txt-dark" href="#">
                        <h6>EN</h6></a>
                        <ul class="language-dropdown onhover-show-div p-20">
                            <li><a href="#" data-lng="en"><i class="flag-icon flag-icon-is"></i> English</a></li>
                            <li><a href="#" data-lng="es"><i class="flag-icon flag-icon-um"></i> Spanish</a></li>
                            <li><a href="#" data-lng="pt"><i class="flag-icon flag-icon-uy"></i> Portuguese</a></li>
                            <li><a href="#" data-lng="fr"><i class="flag-icon flag-icon-nz"></i> French</a></li>
                        </ul>
                    </li> -->
                   <!--  <li class="onhover-dropdown"><i data-feather="bell"></i><span class="badge badge-pill badge-primary pull-right notification-badge" id="noticount">0</span><span class="dot"></span>
                        <ul class="notification-dropdown onhover-show-div p-0" id="notification_div"> -->
                            <!-- <li>Notification <span class="badge badge-pill badge-primary pull-right"></span></li>
                             -->
                                    
                           
                            
                            <!-- <li class="txt-dark"><a href="#">All</a> notification</li> -->
                      <!--   </ul>
                    </li> -->
                    <li style="display:none"><a href="#"><i class="right_side_toggle" data-feather="message-square"></i><span class="dot"></span></a></li>
                    <li class="onhover-dropdown">
                        <div class="media align-items-center"><img class="align-self-center pull-right img-50 rounded-circle blur-up lazyloaded" src="<?php echo base_url('template/admin/');?>assets/images/avatar.jpg" alt="header-user">
                            <!--<div class="dotted-animation"><span class="animate-circle"></span><span class="main-circle"></span></div>-->
                        </div>
                        <ul class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">
							<li><a href="<?php echo base_url();?>Admin/updateprofile"><i data-feather="user"></i>Update Profile</a></li>
                           <!--<li><a href="#"><i data-feather="mail"></i>Inbox</a></li>
                            <li><a href="#"><i data-feather="lock"></i>Lock Screen</a></li>
                            <li><a href="#"><i data-feather="settings"></i>Settings</a></li>-->
                            <li><a href="<?php echo base_url();?>backend/login/logout"><i data-feather="log-out"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
            </div>
        </div>
    </div>
    <!-- Page Header Ends -->
	<!-- Page Body Start-->
    <div class="page-body-wrapper">
	<?php 	$this->load->view('admin/admin_right'); ?>
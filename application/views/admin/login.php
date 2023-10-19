<!DOCTYPE html>
<html lang="en">
<head>

   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BHOOLJAO Admin Section.">
	
    <link rel="icon" href="<?php echo base_url();?>template/admin/assets/images/favicon.png" type="image/x-icon">
    <!--<link rel="shortcut icon" href="<?php echo base_url('template/admin/');?>assets/images/dashboard/favicon.png" type="image/x-icon">-->
    <title>BHOOLJAO | Admin Login</title>
	<meta name="keywords" content="BHOOLJAO Admin Section" />
	<meta name="description" content="BHOOLJAO Admin Section">
	<meta name="author" content="BHOOLJAO">
	

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/fontawesome.css">

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/themify.css">

    <!-- slick icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/slick-theme.css">

    <!-- jsgrid css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/jsgrid.css">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/bootstrap.css">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('template/admin/');?>assets/css/admin.css">

</head>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper" style="background-image:url('<?php echo base_url('template/admin/');?>assets/images/login_bg1.jpg'); ">
    <div class="authentication-box">
        <div class="container">
            <div class="row">

                <div class="col-md-12  ">
                    <div class="card tab2-card">
                        <div class="card-header text-center">
                            <img class="blur-up lazyloaded img-fluid" src="<?php echo base_url('template/admin/');?>assets/images/dashboard/BHOOLJAO_logo.png" alt="" width="200px">
                            <!-- <h3>Welcome to BHOOLJAO</h3> -->
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="top-profile-tab" data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="true"><span class="icon-user mr-2"></span>Login</a>
                                </li>
                                <!--<li class="nav-item">
                                    <a class="nav-link" id="contact-top-tab" data-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><span class="icon-unlock mr-2"></span>Register</a>
                                </li>-->
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">
                                <form name="frm_login" id="frm_login" method="post">																											
									<?php if($this->session->flashdata('success')!=""){?>						
									<div class="alert alert-success">							
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>	
									<?php echo $this->session->flashdata('success');?>						
									</div>						
									<?php }?>
									<?php if($this->session->flashdata('error')!=""){?>	
									<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('error');?>						
									</div>						
									<?php }?>
									<?php if($this->session->flashdata('error_msg')!=""){?>						
									<div class="alert alert-danger">							
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>			
									<?php echo $this->session->flashdata('error_msg');?>	
									
									</div>					
									<?php }?>		
                                    <input type="hidden" name="user_type" id="user_type" value="Admin" />
                                    <div class="form-group">
										<input required="" name="username" type="text" class="form-control" placeholder="Username / Email" id="username">
										<span id="err_username" style="color:red"></span>
                                    </div>
                                        <div class="form-group">
                                            <input required="" name="admin_password"  id="admin_password" type="password" class="form-control" placeholder="Password">
											<span id="err_admin_password" style="color:red"></span>
                                        </div>
                                        <div class="form-terms">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                               <!-- <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                                <label class="custom-control-label" for="customControlAutosizing">Remember me</label>-->
                                                <a href="<?php echo base_url();?>backend/login/forgotpassword" class="btn btn-default forgot-pass">lost your password?</a>
                                            </div>
                                        </div>
                                        <div class="form-button text-center">
                                            <button class="btn btn-primary" type="submit" name="btn_login" id="btn_login" >Login</button>
                                        </div>
                                        <!--<div class="form-footer" style="margin-top: 80px;">
                                            <span>Or Login up with social platforms</span>
                                            <ul class="social">
                                                <li><a class="icon-facebook" href=""></a></li>
                                                <li><a class="icon-twitter" href=""></a></li>
                                                <li><a class="icon-instagram" href=""></a></li>
                                                <li><a class="icon-pinterest" href=""></a></li>
                                            </ul>
                                        </div>-->
                                    </form>
                                </div>
                                <!--<div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                                    <form class="form-horizontal auth-form">
                                        <div class="form-group">
                                            <input required="" name="login[username]" type="email" class="form-control" placeholder="Username" id="exampleInputEmail12">
                                        </div>
                                        <div class="form-group">
                                            <input required="" name="login[password]" type="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input required="" name="login[password]" type="password" class="form-control" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-terms">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing1">
                                                <label class="custom-control-label" for="customControlAutosizing1"><span>I agree all statements in <a href=""  class="pull-right">Terms &amp; Conditions</a></span></label>
                                            </div>
                                        </div>
                                        <div class="form-button">
                                            <button class="btn btn-primary" type="submit">Register</button>
                                        </div>
                                        <div class="form-footer">
                                            <span>Or Sign up with social platforms</span>
                                            <ul class="social">
                                                <li><a class="icon-facebook" href=""></a></li>
                                                <li><a class="icon-twitter" href=""></a></li>
                                                <li><a class="icon-instagram" href=""></a></li>
                                                <li><a class="icon-pinterest" href=""></a></li>
                                            </ul>
                                        </div>
                                    </form>
                                </div>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<a href="index.html" class="btn btn-primary back-btn"><i data-feather="arrow-left"></i>back</a>-->
        </div>
    </div>
</div>

<!-- latest jquery-->
<script src="<?php echo base_url('template/admin/');?>assets/js/jquery-3.3.1.min.js"></script>

<!-- Bootstrap js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/bootstrap.js"></script>

<!-- feather icon js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/icons/feather-icon/feather.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/icons/feather-icon/feather-icon.js"></script>

<!-- Sidebar jquery-->
<script src="<?php echo base_url('template/admin/');?>assets/js/sidebar-menu.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/slick.js"></script>

<!-- Jsgrid js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/jsgrid/jsgrid.min.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/jsgrid/griddata-invoice.js"></script>
<script src="<?php echo base_url('template/admin/');?>assets/js/jsgrid/jsgrid-invoice.js"></script>

<!-- lazyload js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/lazysizes.min.js"></script>

<!--right sidebar js-->
<script src="<?php echo base_url('template/admin/');?>assets/js/chat-menu.js"></script>

<!--script admin-->
<script src="<?php echo base_url('template/admin/');?>assets/js/admin-script.js"></script>
<script>
    $('.single-item').slick({
            arrows: false,
            dots: true
        }
    );
	
$(document).ready(function($) 
{
$('#btn_login').click(function(){
	 
	var username=$("#username").val();
	var admin_password=$("#admin_password").val();
	var flag=1;
	
	$("#err_username").html('');
	$("#err_admin_password").html('');
	
	if(username=="")
	{
		$("#err_username").html('Enter username or valid email.');
		flag=0;
	}
	if(admin_password=="")
	{
		$("#err_admin_password").html('Enter password.');
		flag=0;
	}
	if(flag==1)
		return true;
	else
		return false;
})
});		
</script>
</body>
</html>
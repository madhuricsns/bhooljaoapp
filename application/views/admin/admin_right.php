<!-- Page Sidebar Start-->
<?php $sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_admin_id=$sessiondata['admin_id']; 
$session_admin_name=$sessiondata['admin_name'];
$session_user_type=$sessiondata['user_type'];
//$session_subroles=$sessiondata['subroles'];
$session_subroles="";

//if($session_user_type=="Subadmin" && $session_subroles!="NULL")
{
	// $modulesId=$this->Admin_model->getmodulelist($session_subroles);
}
//echo $this->db->last_query();
 //echo '<pre>';print_r($modulesId);exit;
?>

        <div class="page-sidebar" style="width:270px;">
            <div class="main-header-left d-none d-lg-block">
                <div class="logo-wrapper"><a href="<?php echo base_url();?>backend/Dashboard"><img class="blur-up lazyloaded" src="<?php echo base_url('template/admin/');?>assets/images/dashboard/BHOOLJAO_logo.png" alt="BHOOLJAO logo"></a></div>
            </div>
            <div class="sidebar custom-scrollbar">
               
                <ul class="sidebar-menu">
                   
					 <li <?php if($this->router->fetch_class()=='Dashboard'){?>style="background-color: rgb(68 114 196);"<?php }?>class="  <?php if($this->router->fetch_method()=='Dashboard'){?>nav-expanded nav-active <?php }?>" <?php //if(isset($modulesId)&& count($modulesId)>0)
							//{ 
								// if ($modulesId[0]['view'] == 'Yes') 
								// { 
								// 	echo 'style="display:block;"';
							 //    } 
								// else 
								// { 
									echo 'style="display:block;"'; 
								//}
							//}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Dashboard"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/dashboard.png"?>" style="max-height: 20px;max-width: 20px;"> &nbsp;&nbsp;<span>DASHBOARD</span></a>                        
					</li>
					<!--<li class=" <?php if($this->router->fetch_method()=='manageUsers'){?>nav-expanded nav-active <?php }?>">
						<a class="sidebar-header" href="<?php //echo base_url("backend/");?>dashboard"><i data-feather="file-text"></i><span>ANALYTICS & REPORTS</span></a>                        
					</li>-->
					<li  <?php if($this->router->fetch_class()=='Booking' && $this->router->fetch_method()=='viewBookingDetails'){ ?>style="background-color: rgb(68 114 196);"<?php }?> class="<?php if($this->router->fetch_method()=='manageBooking' || $this->router->fetch_method()=='viewBookingDetails'){?> nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Booking/manageBooking"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/Orders.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>BOOKINGS </span></a>                        
					</li>
					
					<li  <?php if($this->router->fetch_class()=='Booking' && $this->router->fetch_method()=='viewBookingDemoDetails'){?>style="background-color: rgb(68 114 196);"<?php }?> class="<?php if($this->router->fetch_method()=='manageBookingDemo' || $this->router->fetch_method()=='viewBookingDemoDetails'){?> nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Booking/manageBookingDemo"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/Orders.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>DEMO BOOKINGS </span></a>                        
					</li>
					
					<li <?php if($this->router->fetch_class()=='Users/manageUsers' || $this->router->fetch_class()=='users/manageUsers'){?>style="background-color: rgb(68 114 196);"<?php }?> class=" <?php if($this->router->fetch_method()=='manageUsers' || $this->router->fetch_method()=='addUser' || $this->router->fetch_method()=='updateUser' || $this->router->fetch_method()=='viewUserDetails'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[2]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Users/manageUsers"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/value.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;<span>CUSTOMER</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Users/manageServiceProvider' || $this->router->fetch_class()=='Users/addServiceprovider' || $this->router->fetch_class()=='Users/updateServiceprovider'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageServiceProvider' || $this->router->fetch_method()=='addServiceprovider' || $this->router->fetch_method()=='viewServiceProviderDetails' || $this->router->fetch_method()=='updateServiceprovider'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Users/manageServiceProvider"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/manager.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>SERVICE GIVERS </span></a>                        
					</li>
					<li class=" <?php if($this->router->fetch_method()=='manageGroup' || $this->router->fetch_method()=='addGroup' || $this->router->fetch_method()=='viewGroup' || $this->router->fetch_method()=='updateGroup'){?>nav-expanded nav-active <?php }?>" >
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Group/manageGroup"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/Service.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>SERVICE GROUP </span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Category'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageCategory'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Category/manageCategory"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/category.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>SERVICE CATEGORY</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Service'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageService'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Service/manageService"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/Service.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>SERVICES</span></a>                        
					</li>

					<li  <?php if($this->router->fetch_class()=='Zone'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageZones'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Zone/manageZones"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/managezones.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>ZONE MANAGEMENT </span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Material'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageMaterial'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Material/manageMaterial"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/manage-material.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>MATERIAL MANAGEMENT </span></a>                        
					</li>
					

					<li  <?php if($this->router->fetch_class()=='Promocode'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='managePromocode'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Promocode/managePromocode"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/promo-code.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>PROMOCODE</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Notifications'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageNotifications'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Notifications/manageNotifications"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/notification.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>NOTIFICATION</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Banners'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageBanner'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Banners/manageBanner"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/banners.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>BANNERS</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Feedback'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageFeedback'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Feedback/manageFeedback"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/feedback.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>FEEDBACK</span></a>                        
					</li>

					<li  <?php if($this->router->fetch_class()=='FAQ'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageFAQ'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>FAQ/manageFAQ"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/faq.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>FAQ</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='HelpCenter'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageHelpCenter'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>HelpCenter/manageHelpCenter"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/support.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>HELP CENTER</span></a>                        
					</li>
					<li  <?php if($this->router->fetch_class()=='Setting'){?>style="background-color: rgb(68 114 196);"<?php }?>class=" <?php if($this->router->fetch_method()=='manageSetting'){?>nav-expanded nav-active <?php }?>" <?php if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if ($modulesId[1]['view'] == 'Yes') 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							}
							?>>
						<a class="sidebar-header" href="<?php echo base_url("backend/");?>Setting/manageSetting"><!-- <i data-feather="home"></i> -->
						<img src="<?php echo base_url()."/uploads/flaticon/settings.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;
						<span>SETTINGS</span></a>                        
					</li>
					<li><a class="sidebar-header" href="<?php echo base_url();?>backend/Login/logout"><!-- <i data-feather="home"></i> --><img src="<?php echo base_url()."/uploads/flaticon/log-out.png"?>" style="max-height: 20px;max-width: 20px;">  &nbsp;&nbsp;<span>LOGOUT</span></a>
                    </li>	
                 </ul>
            </div>
        </div>

        <!-- Page Sidebar Ends-->

        

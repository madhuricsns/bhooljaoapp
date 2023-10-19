<?php $sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_admin_id=$sessiondata['admin_id']; 
$session_admin_name=$sessiondata['admin_name'];
$session_user_type=$sessiondata['user_type'];
$session_subroles=$sessiondata['subroles'];

//if($session_user_type=="Subadmin" && $session_subroles!="NULL")
{
	$modulesId=$this->Admin_model->getmodulelist($session_subroles);
}
#echo $this->db->last_query();
 #echo '<pre>';print_r($modulesId);exit;
?><div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card tab2-card">
                            <div class="card-header">
                                <h5>ADMIN DISTANCE SETTINGS</h5>
                            </div>
                            <div class="card-body">
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
						
                                <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active show"  href="<?php echo site_url('backend/Settings/manageadminsetting')?>" role="tab" >Distance Details</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('backend/Settings/manageadmintaxsetting')?>" role="tab">IGIC</a></li>
									
                                </ul>
								<form name="frm_updateadminsettings" id="frm_updateadminsettings" class="needs-validation user-add" method="POST" enctype="multipart/form-data">
                                <div class="tab-content" id="myTabContent">
								
                                    <div class="tab-pane fade active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                       
                                            
											 <div class="form-group row">
                                                <label for="distance_for_customer" class="col-xl-3 col-md-4">
												<span>*</span>Distance (For Customer)</label>
												<input class="form-control col-xl-2 col-md-2" id="distance_for_customer" type="text" required="" name="distance_for_customer" placeholder="0" value="<?php echo $adminsettingsinfo[0]['distance_for_customer'];?>" />KM
                                            </div>
                                            
                                           
											<div class="form-group row">
                                                <label for="distance_for_driver" class="col-xl-3 col-md-4">
												<span>*</span>Distance (For Driver)</label>
												<input class="form-control col-xl-2 col-md-2" id="distance_for_driver" type="text" required="" name="distance_for_driver" placeholder="0" value="<?php echo $adminsettingsinfo[0]['distance_for_driver'];?>" />KM
                                            </div>
											
											<div class="form-group row">
                                                <label for="distance_for_hotdeal" class="col-xl-3 col-md-4">
												<span>*</span>Hot Deal Distance (For Customer)</label>
												<input class="form-control col-xl-2 col-md-2" id="distance_for_hotdeal" type="text" required="" name="distance_for_hotdeal" placeholder="0" value="<?php echo $adminsettingsinfo[0]['distance_for_hotdeal'];?>" />KM
                                            </div>
                                            
                                           
										   
											
                                    </div>
									
									
                                </div>
								<?php if(isset($modulesId)&& count($modulesId)>0)
											{ 
												if ($modulesId[6]['edit'] == 'Yes') 
												{ ?>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"  name="btn_updatedsettings" id="btn_updatedsettings">
									Update</button>
									
									   
                                </div>
											<?php } }?>
											</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
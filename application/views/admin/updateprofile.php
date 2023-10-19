<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card tab2-card">
                            <div class="card-header">
                                <h5> UPDATE PROFILE</h5>
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
                                    <li class="nav-item"><a class="nav-link active show" id="basicinfo-tab" data-toggle="tab" href="#basicinfo" role="tab" aria-controls="basicinfo" aria-selected="true" data-original-title="" title="">Profile Details</a></li>
									
                                </ul>
								<form name="frm_updateprofile" id="frm_updateprofile" class="needs-validation user-add" method="POST" enctype="multipart/form-data">
                                <div class="tab-content" id="myTabContent">
								
                                    <div class="tab-pane fade active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                       
                                            
											  <div class="form-group row">
                                                <label for="admin_name" class="col-xl-3 col-md-4"><span>*</span> Name</label>
                                                <input class="form-control col-xl-4 col-md-4" id="admin_name" type="text" required="" name="admin_name" placeholder="Enter name" value="<?php echo $adminInfo[0]['admin_name']?>">
                                            </div>
											
											<div class="form-group row">
                                                <label for="username" class="col-xl-3 col-md-4"><span>*</span>User Name</label>
                                                <input class="form-control col-xl-4 col-md-4" id="username" type="text" required="" name="username" placeholder="Enter username" value="<?php echo $adminInfo[0]['username']?>">
                                            </div>
											
												<div class="form-group row">
                                                <label for="admin_password" class="col-xl-3 col-md-4"><span></span>Password</label>
                                                <input class="form-control col-xl-4 col-md-4" id="admin_password" type="text"  name="admin_password" placeholder="Enter password" value="">
												
                                            </div>
											
											<div class="form-group row">
                                                <label for="admin_password" class="col-xl-3 col-md-4"><span></span></label>
                                                <p>If you do not want to update the password keep this field as blank</p>
                                            </div>
											
											<div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span>Mobile Number</label>
                                                <input class="form-control col-xl-4 col-md-4" id="mobile_number" type="text" required="" name="mobile_number" placeholder="Enter mobile number" value="<?php echo $adminInfo[0]['mobile_number']?>">
                                            </div>
											
											<div class="form-group row">
                                                <label for="admin_email" class="col-xl-3 col-md-4"><span>*</span>Email Address</label>
                                                <input class="form-control col-xl-4 col-md-4" id="admin_email" type="text" required="" name="admin_email" placeholder="Enter email address" value="<?php echo $adminInfo[0]['admin_email']?>">
                                            </div>
											
											
											 	<div class="form-group row">
                                                <label for="admin_email" class="col-xl-3 col-md-4"><span>*</span>Address</label>
                                              <textarea name="admin_address" id="admin_address" class="form-control col-xl-4 col-md-4" required=""><?php echo $adminInfo[0]['admin_address']?></textarea>
                                            </div>
											
                                       
                                    </div>
									
									
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"  name="btn_updateprofile" id="btn_updateprofile">
									Update</button>
									
									   <button type="reset" class="btn btn-primary"  name="btn_resetprofile" id="btn_resetprofile">
									Cancel</button>
                                </div></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
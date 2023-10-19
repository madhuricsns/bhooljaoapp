<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card tab2-card">
                            <div class="card-header">
                                <h5> Update Merchant</h5>
                            </div>
                            <div class="card-body">
							 <?php if($this->session->flashdata('success')!=""){?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('success');?>
						</div>
						<?php }?>
				
						<?php if($error!=""){?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $error;?>
						</div>
						<?php }?>
						<?php if($this->session->flashdata('error_msg')!=""){?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error_msg');?>
						</div>
						<?php }?>
						
                                <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active show" id="basicinfo-tab" data-toggle="tab" href="<?php echo base_url();?>backend/Merchant/updateMerchant/<?php echo $this->uri->segment(4);?>"  role="tab" aria-controls="basicinfo" aria-selected="true" data-original-title="" title="">General Details</a></li>
									<li class="nav-item"><a class="nav-link" href="<?php echo base_url("backend/");?>Merchant/updateadditional/<?php echo $this->uri->segment(4);?>"   id="category-tabs"      data-original-title="" title="">Additional Details</a></li>
									
									<li class="nav-item"><a class="nav-link"  href="<?php echo base_url("backend/");?>Merchant/updatebankdetails/<?php echo $this->uri->segment(4);?>" >Bank Details</a></li>
									
									
                                </ul>
								
								<form name="frm_addstore" id="frm_addstore" class="needs-validation user-add" method="POST" enctype="multipart/form-data">
									<div class="tab-content" id="myTabContent">
									
										<div class="tab-pane fade active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
										   
												
												  <div class="form-group row">
													<label for="store_owner_name" class="col-xl-3 col-md-4"><span>*</span> Category</label>
													<?php echo $getcategoryname;?>
													<div id="err_rst_category_type" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="rst_userfullname" class="col-xl-3 col-md-4">
													<span>*</span> Your Full Name</label>
													<input class="form-control col-xl-4 col-md-4" id="rst_userfullname" type="text" required="" name="rst_userfullname" placeholder="Enter Owner/Manager Name" value="<?php echo $merchantdata[0]['rst_userfullname'];?>">
													<div id="err_rst_userfullname" class="err_msg"></div>
												</div>
												<div class="form-group row">
													<label for="store_owner_email" class="col-xl-3 col-md-4"><span>*</span> Owner’s Phone</label>
													<input class="form-control col-xl-1 col-md-4" id="rst_user_countrycode" type="text" required="" name="rst_user_countrycode" placeholder="+34" value="<?php echo $merchantdata[0]['rst_user_countrycode'];?>" readonly="readonly">
													<input class="form-control col-xl-3 col-md-3" id="rst_mobilenumber" type="text" required="" name="rst_mobilenumber" placeholder="Enter Owner's Phone"   value="<?php echo $merchantdata[0]['rst_mobilenumber'];?>" onkeypress="return isNumber(event)" readonly="readonly">
												</div>
												 <div class="form-group row">
													<label for="store_owner_email" class="col-xl-3 col-md-4"><span>*</span> Are you the owner/manager of the merchant?</label>
													<select name="rst_user_type" id="rst_user_type" class="form-control  col-xl-4 col-md-4" required >
														<option value="Owner" <?php if($merchantdata[0]['rst_user_type']=="Owner"){ echo 'selected="selected"';}?>>Owner</option>
														<option value="Manager" <?php if($merchantdata[0]['rst_user_type']=="Manager"){ echo 'selected="selected"';}?>>Manager</option>
													</select>
												</div>
												<div class="form-group row">
													<label for="store_owner_number" class="col-xl-3 col-md-4">
													<span>*</span> Merchant Store Name</label>
													<input class="form-control col-xl-4 col-md-4" id="rst_name" type="text" required="" name="rst_name" placeholder="Enter Merchant Store Name" value="<?php echo $merchantdata[0]['rst_name'];?>">
													<div id="err_rst_name" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="store_owner_number" class="col-xl-3 col-md-4">
													<span>*</span> Merchant Store Photo</label>
													<input class="form-control col-xl-4 col-md-4" id="rst_image" type="file"  name="rst_image" placeholder="Enter Merchant Store Name">
													<input type="hidden" class="form-control" name="old_rst_image" id="old_rst_image"   value="<?php echo $merchantdata[0]['rst_image'];?>">
													<?php if($merchantdata[0]['rst_image']!=""){?>
													<img src="<?php echo base_url();?>uploads/restaurant/<?php echo $merchantdata[0]['rst_image'];?>" width="100" height="80" />
													<?php } ?>
													<div id="err_rst_image" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="store_owner_number" class="col-xl-3 col-md-4">
													<span>*</span>Merchant Store Phone Number</label>
													 <input class="form-control col-xl-1 col-md-4" id="rst_countrycode" type="text" required="" name="rst_countrycode" placeholder="+34" value="<?php echo $merchantdata[0]['rst_countrycode'];?>"  readonly="readonly">
													<input class="form-control col-xl-3 col-md-4" id="rst_contact_no" type="text" required="" name="rst_contact_no" placeholder="Enter Restaurant Phone Number" value="<?php echo $merchantdata[0]['rst_contact_no'];?>" onkeypress="return isNumber(event)" readonly="readonly">
													<div id="err_rst_contact_no" class="err_msg"></div>
												</div>
												<div class="form-group row">
													<label for="store_owner_number" class="col-xl-3 col-md-4">
													<span>*</span>Email address</label>
													<input class="form-control col-xl-4 col-md-4" id="rst_email" type="text" required="" name="rst_email" placeholder="Enter Restaurant Email" value="<?php echo $merchantdata[0]['rst_email'];?>" >
													<div id="err_rst_email" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="store_owner_number" class="col-xl-3 col-md-4">
													<span>*</span>Opening Status</label>
													<select name="rst_opening_status" id="rst_opening_status" class="form-control col-xl-4 col-md-4" required >
														<option value="AlreadyOpen" <?php if($merchantdata[0]['rst_opening_status']=="AlreadyOpen") { echo 'selected="selected"';}?>>Already Open</option>
														<option value="OpeningSoon" <?php if($merchantdata[0]['rst_opening_status']=="OpeningSoon") { echo 'selected="selected"';}?>>Opening Soon</option>
													</select>
													<div id="err_rst_opening_status" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="rst_commission_type" class="col-xl-3 col-md-4"><span>*</span> Commission Type</label>
													<select name="rst_commission_type" id="rst_commission_type" class="form-control col-xl-3 col-md-4" >
														<option value="Percentage" <?php if($merchantdata[0]['rst_commission_type']=="Percentage") { echo 'selected="selected"';}?>>Percentage</option>
														<option value="Fixed Amount" <?php if($merchantdata[0]['rst_commission_type']=="Fixed Amount") { echo 'selected="selected"';}?>>Fixed Amount</option>
													</select>
													<div id="err_rst_commission_type" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="rst_commission_amt" class="col-xl-3 col-md-4"><span>*</span> Commission</label>
													<input class="form-control col-xl-3 col-md-4" id="rst_commission_amt" type="text" required="" name="rst_commission_amt" onkeypress="return /[0-9.]/i.test(event.key)"  placeholder="Enter commission percentage/amount" VALUE="<?php echo $merchantdata[0]['rst_commission_amt'];?>"/>
													<div id="err_rst_commission_amt" class="err_msg"></div>
												</div>
												
												<div class="form-group row">
													<label for="store_owner_number" class="col-xl-3 col-md-4">
													<span>*</span>Address</label>
													<textarea class="form-control col-xl-4 col-md-4" name="rst_address" id="rst_address"  placeholder="Enter address"  ><?php echo $merchantdata[0]['rst_address'];?></textarea>
													  
													<div id="err_rst_address" class="err_msg"></div>
												</div>
										</div>
									
									</div>
                                <div class="pull-right">
                                   <button class="btn btn-primary" name="btn_update_merchant" id="btn_update_merchant">Save & Proceed</button>
									<a class="btn btn-primary" href="<?php echo base_url();?>backend/Merchant/manageMerchants">Cancel</a>
                                </div>
							</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
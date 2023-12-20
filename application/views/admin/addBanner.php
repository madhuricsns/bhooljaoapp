<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Add Banner</h5>
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
						<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/banners/addBanner">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    
                                        <div class="col-sm-12">
                                        	<div class="row">
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="banner_title" ><span>*</span> Banner Title</label>
                                                <input type="text" class="form-control" id="banner_title" name="banner_title" id="banner_title"  required >
										  <div id="err_banner_title" class="error_msg"></div>
                                            </div>
                                        </div>
											
											<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="banner_image" ><span>*</span> Banner Image</label>
                                                <input class="form-control " id="banner_image" type="file" required="" name="banner_image" />
                                                <div class="error_msg" id="err_banner_image"></div>
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span>
												
                                            </div>
                                        </div>
                                    </div>
                                            <!--<div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Daily Report</label>
												<select name="daily_report" id="daily_report" class="form-control  col-md-3" required>
													
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
                                            </div>-->
											
                                           <div class="row">
                                           	<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Banner Type</label>
												<select name="banner_type" id="bannertype" class="form-control" required>
													<option value="">Select Banner Type</option>
													<option value="Customer">Customer</option>
													<option value="Service Provider">Service Provider</option>
												</select>
												 <div id="err_bannertype" class="error_msg"></div>
                                            </div>
                                        </div>
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
												 <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>

									<div class="pull-right">
										<button type="submit" class="btn btn-primary" name="btn_addbanner" id="btn_addbanner">Add</button>
										<a href="<?php echo base_url();?>backend/Banners/manageBanner" class="btn btn-primary" >Cancel</a>
									</div>

                                            
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
          
	<!-- Container-fluid Ends-->
</div>
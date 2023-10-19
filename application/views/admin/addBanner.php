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
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="banner_title" class="col-xl-3 col-md-4"><span>*</span> Banner Title</label>
                                                <input type="text" class="form-control  col-md-6" id="banner_title" name="banner_title"  required value="">
												 <div id="err_banner_title" class="error_msg"></div>
                                            </div>
											
											<!--<div class="form-group row">
                                                <label for="description" class="col-xl-3 col-md-4"> Description</label>
                                               <textarea name="description" id="description" class="form-control  col-md-6"></textarea>
                                            </div>-->
                                            <div class="form-group row">
                                                <label for="banner_image" class="col-xl-3 col-md-4"><span>*</span> Banner Image</label>
                                                <input class="form-control col-xl-6 col-md-6" id="banner_image" type="file" required="" name="banner_image" />
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
												<div class="err_msg" id="err_banner_image"></div>
                                            </div>
                                            <!--<div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Daily Report</label>
												<select name="daily_report" id="daily_report" class="form-control  col-md-3" required>
													
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
                                            </div>-->
											
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Status</label>
												<select name="status" id="status" class="form-control  col-md-6" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
                                            </div>
                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_addbanner" id="btn_addbanner">Add</button>
													<a href="<?php echo base_url();?>backend/Brands/index" class="btn btn-primary" >Cancel</a>
						                        </div>

                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD HELP CENTER</h5>
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
						<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/HelpCenter/addHelpCenter">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                            <div class="form-group col-md-6">
                                                 <label for="help_image" ><span>*</span> Help Center Image</label>
                                                <input class="form-control " id="helpcenter_image" type="file" name="helpcenter_image" />
                                                <div class="error_msg" id="err_helpcenter_image"></div>
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span>
                                            </div>
											
											<div class="form-group col-md-6">
                                                <label for="helpcenter_Name" ><span>*</span>Help Center Name</label>
                                              <input type="text" class="form-control" id="helpcenter_name" name="helpcenter_name"   required value="">
                                               <div id="err_helpcenter_name" class="error_msg"></div>
                                            </div>
                                            
                                        </div>
                                            <div class="row">
                                           <div class="form-group col-md-6">
                                                <label for="helpcenter_value" ><span>*</span>Help Center Value</label>
                                              <input type="text" class="form-control" id="helpcenter_value" name="helpcenter_value"   required value="">
                                               <div id="err_helpcenter_value" class="error_msg"></div>
                                            </div>
											
                                           <!--  <div class="form-group col-md-6">
                                                <label><span>*</span> Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
												<div id="err_status" class="error_msg"></div>
                                            </div> -->

											

										</div>

										
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addHelpCenter" id="btn_addHelpCenter">Add</button>
													<a href="<?php echo base_url();?>backend/HelpCenter/manageHelpCenter" class="btn btn-primary" >Cancel</a>

                                            </div>
                                        
                                   
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD ZONE</h5>
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
						<form class="needs-validation" name="frm_addzone" id="frm_addzone" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Zone/addZone">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                  
                                        <div class="col-sm-12">
                                            <div class="row">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="zone_name" ><span>*</span>Zone Name</label>
                                                <input type="text" class="form-control" id="zone_name" name="zone_name"  required>
												 <div id="err_zone_name" class="error_msg"></div>
                                            </div>
                                        </div>
											
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="zone_pincode" ><span>*</span>Pincode</label>
                                                <input type="text" class="form-control" id="zone_pincode" name="zone_pincode"  required>
												 <div id="err_zone_pincode" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="row">
                              			 <div class="col-md-6">
                                            <div class="form-group ">
                                            	
                                                <label><span>*</span>Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
                                                <div id="err_status" class="error_msg"></div>
                                            </div>
                                          </div>
                                        </div>
                                            
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addzone" id="btn_addzone">Add</button>
													<a href="<?php echo base_url();?>backend/Zone/manageZones" class="btn btn-primary" >Cancel</a>
						                        
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
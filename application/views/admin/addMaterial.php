<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD MATERIAL</h5>
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
						<form class="needs-validation" name="frm_addmaterial" id="frm_addmaterial" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Material/addMaterial">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                   
                                        <div class="col-sm-12">
                                        	 <div class="row">
                                        	 	<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="material_name"><span>*</span>Material Name</label>
                                               <input type="text" class="form-control" id="material_name" name="material_name"  required>
												 <div id="err_material_name" class="error_msg"></div>
                                            </div>
                                        </div>
											<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span>Status</label>
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
						                            <button type="submit" class="btn btn-primary" name="btn_addmaterial" id="btn_addmaterial">Add</button>
													<a href="<?php echo base_url();?>backend/Material/manageMaterial" class="btn btn-primary" >Cancel</a>
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
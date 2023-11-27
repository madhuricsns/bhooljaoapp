<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Add Category</h5>
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
						<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Category/addCategory">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="category_name"><span>*</span> Category Name</label>
                                                <input type="text" class="form-control" id="category_name" name="category_name"  required value="">
												 <div id="err_category_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group col-md-6">
                                                <label for="description" ><span>*</span> Description</label>
                                               <textarea name="description" id="description" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="category_image"><span>*</span> Category Image</label>
                                                <input class="form-control" id="category_image" type="file" required="" name="category_image" />
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
												<div class="err_msg" id="err_category_image"></div>
                                            </div>
                                            <!--<div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Daily Report</label>
												<select name="daily_report" id="daily_report" class="form-control  col-md-3" required>
													
													<option value="Yes">Yes</option>
													<option value="No">No</option>
												</select>
                                            </div>-->
											
                                            <div class="form-group col-md-6">
                                                <label><span>*</span> Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
                                            </div>

											

										</div>

										
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addcategory" id="btn_addcategory">Add</button>
													<a href="<?php echo base_url();?>backend/Category/manageCategory" class="btn btn-primary" >Cancel</a>

                                            </div>
                                        
                                   
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
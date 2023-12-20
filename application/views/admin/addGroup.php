<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Add Group</h5>
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
						<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Group/addGroup">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">


                                    	 	<div class="form-group  col-md-6">
                                                 <label for="category_id"> Category </label>
												<select name="category_id" id="category_id" class="form-control" required>
													<option value="">Select Category </option>
													<?php
                                                    foreach($categoryLists as $category){
                                                    ?>
                                                    <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
													<?php } ?>
												</select>
												<div id="err_category_id" class="error_msg"></div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="group_name"><span>*</span> Group Name</label>
                                                <input type="text" class="form-control" id="group_name" name="group_name" required >
												 <div id="err_group_name" class="error_msg"></div>
                                            </div>
									</div>
									
									<div class="row">
                                            <div class="form-group col-md-6">
                                                <label><span>*</span> Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
												 <div id="err_status" class="error_msg"></div>
                                            </div>

										</div>	

								<!-- </div> -->

										
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addgroup" id="btn_addgroup">Add</button>
													<a href="<?php echo base_url();?>backend/Group/manageGroup" class="btn btn-primary" >Cancel</a>

                                            </div>
                                        
                                   
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
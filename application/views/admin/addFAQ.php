<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Add FAQ</h5>
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
						<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/FAQ/addFAQ">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="category_name"><span>*</span> FAQ Question</label>
                                                <input type="text" class="form-control" id="faq_question" name="faq_question"  required value="">
												 <div id="err_faq_question" class="error_msg"></div>
                                            </div>
											
											<div class="form-group col-md-6">
                                                <label for="faq_answer" ><span>*</span> FAQ Answer</label>
                                               <textarea name="faq_answer" id="faq_answer" class="form-control" required></textarea>
                                               <div id="err_faq_answer" class="error_msg"></div>
                                            </div>
                                            
                                        </div>
                                            <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="faq_type"><span>*</span>FAQ Type</label>
												<select name="faq_type" id="faq_type" class="form-control" required>
													<option>Select FAQ Type</option>
													<option value="Customer">Customer</option>
													<option value="Service Provider">Service Provider</option>
												</select>
												 <div id="err_faq_type" class="error_msg"></div>
                                            </div>
											
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

										
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addFAQ" id="btn_addFAQ">Add</button>
													<a href="<?php echo base_url();?>backend/FAQ/manageFAQ" class="btn btn-primary" >Cancel</a>

                                            </div>
                                        
                                   
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
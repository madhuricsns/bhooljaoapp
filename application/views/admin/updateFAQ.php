<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update FAQ</h5>
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
						<?php $encodedValueId=base64_encode($FAQInfo[0]['faq_id']); ?>
						<form class="needs-validation" name="frm_updatebanner" id="frm_updatebanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/FAQ/updateFAQ/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="faq_question"><span>*</span> FAQ Question</label>
                                                <input type="text" class="form-control" id="faq_question" name="faq_question"  required value="<?php echo $FAQInfo[0]['faq_question'];?>">
												 <div id="err_faq_question" class="error_msg"></div>
                                            </div>
											<div class="form-group col-md-6">
                                                <label for="description"><span>*</span> FAQ Answer</label>
                                               <textarea name="faq_answer" id="faq_answer" class="form-control "><?php echo $FAQInfo[0]['faq_answer'];?></textarea>
                                               	 <div id="err_faq_answer" class="error_msg"></div>

                                            </div>
                                           
                                           </div>

											 <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="faq_type"><span>*</span>FAQ Type</label>
												<select name="faq_type" id="faq_type" class="form-control" required>
													<option>Select FAQ Type</option>
												
													<option value="Customer" <?php if($FAQInfo[0]['faq_type']=="Customer"){ echo 'selected="selected"';}?>>Customer</option>
													<option value="Service Provider" <?php if($FAQInfo[0]['faq_type']=="Service Provider"){ echo 'selected="selected"';}?>>Service Provider</option>
												</select>
												
												 <div id="err_faq_type" class="error_msg"></div>
                                            </div>
											
                                            <div class="form-group col-md-6">
                                                <label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($FAQInfo[0]['faq_status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($FAQInfo[0]['faq_status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
												<div id="err_status" class="error_msg"></div>
                                            </div>
										</div>
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptFAQ" id="btn_uptFAQ">Update</button>
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
<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Feedback Reply</h5>
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
                        <?php $encodedValueId=base64_encode($FeedbackInfo[0]['feedback_id']); ?>
						<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Feedback/feedbackReply/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                           
											<div class="form-group col-md-6">
                                                <label for="admin_reply" ><span>*</span> Reply</label>
                                               <textarea name="admin_reply" id="admin_reply" class="form-control" required><?php if(isset($FeedbackInfo[0]['admin_reply'])) echo $FeedbackInfo[0]['admin_reply'];?></textarea>
                                               <div id="err_admin_reply" class="error_msg"></div>
                                            </div>
                                            
                                        </div>
                                           
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_replyFeedback" id="btn_replyFeedback">Reply</button>
													<a href="<?php echo base_url();?>backend/Feedback/manageFeedback" class="btn btn-primary" >Cancel</a>

                                            </div>
                                        
                                   
                                
                            </div>
                        </div>
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
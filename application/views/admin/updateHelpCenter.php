<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Help Center</h5>
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
						<?php $encodedValueId=base64_encode($HelpInfo[0]['help_id']); ?>
						<form class="needs-validation" name="frm_updatebanner" id="frm_updatebanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/HelpCenter/updateHelpCenter/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                   
                                        <div class="col-sm-12">
                                        	  
                                           <div class="row">
                                            <div class="form-group col-md-6">
                                                 <label for="help_image" ><span>*</span> Help Center Image</label>

                                                <?php 
                                                   if($HelpInfo[0]['help_image']!="")
												{
	
												$str_images='<img src="'.base_url().'uploads/helpcenter/'.$HelpInfo[0]['help_image'].'" style="width:80px;height:80px">';
												}
												else
												{
												$str_images='<img src="'.base_url().'uploads/banner_images/default.png" style="width:80px;height:80px">';
												}
												?>
												<?php echo $str_images;?>

												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
												<input class="form-control " id="helpcenter_image" type="file"  name="helpcenter_image" />
												<div class="err_msg" id="err_helpcenter_image"></div>
                                               
                                            </div>
                                        </div>
											<div class="row">
											<div class="form-group col-md-6">
                                                <label for="helpcenter_Name" ><span>*</span>Help Center Name</label>
                                              <input type="text" class="form-control" id="helpcenter_name" name="helpcenter_name"   required value="<?php echo $HelpInfo[0]['help_name'];?>">
                                               <div id="err_helpcenter_name" class="error_msg"></div>
                                            </div>
                                            
                                       
                                            
                                           <div class="form-group col-md-6">
                                                <label for="helpcenter_value" ><span>*</span>Help Center Value</label>
                                              <input type="text" class="form-control" id="helpcenter_value" name="helpcenter_value"   required value="<?php echo $HelpInfo[0]['help_value'];?>">
                                               <div id="err_helpcenter_value" class="error_msg"></div>
                                            </div>
                        </div>
                                            	<div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptHelpCenter" id="btn_uptHelpCenter">Update</button>
													<a href="<?php echo base_url();?>backend/HelpCenter/index" class="btn btn-primary" >Cancel</a>
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
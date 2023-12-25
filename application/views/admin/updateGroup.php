<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Group</h5>
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
						<?php $encodedValueId=base64_encode($groupInfo[0]['group_id']); ?>
						<form class="needs-validation" name="frm_updategroup" id="frm_updategroup" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Group/updateGroup/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                            	<div class="row">
                            	<div class="form-group col-md-6">
                                                <label ><span></span> Category</label>
												<select name="category_id" id="category_id" class="form-control  " >
                                                    <option value="">Select Category</option>
													<?php
                                                    foreach($categoryLists as $category){
                                                    ?>
													<option value="<?php echo $category['category_id']?>" <?php if($groupInfo[0]['group_category_id']==$category['category_id']){ echo 'selected="selected"';}?>><?php echo $category['category_name']?></option>
													<?php } ?>
                                                    
												</select>
												<div id="err_category_id" class="error_msg"></div>
                                    </div>
                                    
                                            <div class="form-group col-md-6">
                                                <label for="group_name"><span>*</span> Group Name</label>
                                                <input type="text" class="form-control" id="group_name" name="group_name"  required value="<?php echo $groupInfo[0]['group_name'];?>">
												<div id="err_group_name" class="error_msg"></div>
                                            </div>
                                        </div>
                                        
										<div class="row">	
											<div class="form-group  col-md-6">
                                                 <label for="sp_id"> Service Givers </label>
												<select name="sp_ids[]" id="sp_id" class="form-control select2" multiple required>
													<option value="">Select  </option>
													<?php
													$spList=$this->Group_model->getGroupSP($groupInfo[0]['group_id'],1);
													$serviceproviderArr =array();
													foreach($spList as $sp){
														$serviceproviderArr[]=$sp['service_provider_id'];
													}
													$serviceproviders=$this->Group_model->getAllServiceproviders($groupInfo[0]['group_category_id'],1);
													// echo $this->db->last_query();
														// $spArr=explode(",",$serviceproviderArr);
                                                    foreach($serviceproviders as $servicegiver){
                                                    ?>
                                                    <option value="<?php echo $servicegiver['user_id']?>" <?php echo (isset($serviceproviderArr) && in_array($servicegiver['user_id'], $serviceproviderArr) ) ? "selected" : "" ?>><?php echo $servicegiver['full_name']?></option>
													<?php } ?>
												</select>
												<div id="err_sp_id" class="error_msg"></div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($groupInfo[0]['group_status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($groupInfo[0]['group_status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
												<div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
										<!-- </div> -->
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptgroup" id="btn_addgroup">Update</button>
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
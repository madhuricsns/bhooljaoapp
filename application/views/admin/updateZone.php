<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>UPDATE ZONE</h5>
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
                        <?php $encodedValueId=base64_encode($zoneInfo[0]['zone_id']);?>
			<form class="needs-validation" name="frm_updatezone" id="frm_updatezone" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Zone/update_Zone/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <!-- <div class="row"> -->
                                        <div class="col-sm-12">
                                        	<div class="row">
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="zone_name" ><span>*</span>Zone Name</label>
                                                <input type="text" class="form-control  " id="zone_name" name="zone_name" value="<?php if(isset($zoneInfo[0]['zone_name'])) echo $zoneInfo[0]['zone_name'];?>" required>
												 <div id="err_zone_name" class="error_msg"></div>
                                            </div>
                                            </div>

                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="zone_pincode"><span>*</span>Pincode</label>
                                                <input type="text" class="form-control" id="zone_pincode" name="zone_pincode" value="<?php if(isset($zoneInfo[0]['zone_pincode'])) echo $zoneInfo[0]['zone_pincode'];?>" required>
												 <div id="err_zone_pincode" class="error_msg"></div>
                                            </div>
                                           </div>
                                          </div>

											
                                            <div class="row">
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span>Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active" <?php if(isset($zoneInfo[0]['zone_status'])) if($zoneInfo[0]['zone_status']=='Active'){ echo 'selected';} ?>>Active</option>
													<option value="Inactive" <?php if(isset($zoneInfo[0]['zone_status'])) if($zoneInfo[0]['zone_status']=='Inactive'){ echo 'selected';} ?>>Inactive</option>
												</select>
                                                <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="form-group row">
                                            	<div class="offset-xl-8 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_updatezone" id="btn_updatezone">Update</button>
													<a href="<?php echo base_url();?>backend/Zone/manageZones" class="btn btn-primary" >Cancel</a>
						                        </div>
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
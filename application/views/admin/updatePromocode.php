<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Promocode</h5>
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
						<?php $encodedValueId=base64_encode($PromocodeInfo[0]['promocode_id']); ?>
						<form class="needs-validation" name="frm_updatebanner" id="frm_updatebanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Promocode/updatePromocode/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                     <div class="col-sm-12">
                                        	<div class="row">
                                        	
											
											<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="banner_image" ><span>*</span> Promocode</label>
                                                <input type="text" class="form-control" id="promocode_code" name="promocode_code"   required value="<?php echo $PromocodeInfo[0]['promocode_code'];?>" readonly>
										 <div id="err_promocode_code" class="error_msg"></div>
												
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                           	<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Promocode Description</label>
												<textarea name="promocode_description" id="promocode_description" class="form-control" required><?php echo $PromocodeInfo[0]['promocode_description'];?></textarea>
												 <div id="err_promocode_description" class="error_msg"></div>
                                            </div>
                                        </div>
                                   
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Promocode Discount</label>
												 <input type="text" class="form-control" id="promocode_discount" name="promocode_discount"   required value="<?php echo $PromocodeInfo[0]['promocode_discount'];?>">
												 <div id="err_promocode_discount" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>
											
                                           <div class="row">
                                           	<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Promocode Type</label>
												<select name="promocode_type" id="promocode_type" class="form-control" required>
													<option value="">Select Promocode Type</option>
													<option value="Fixed Price" <?php if($PromocodeInfo[0]['promocode_type']=="Fixed Price"){ echo 'selected="selected"';}?>>Fixed Price</option>
													<option value="Percentage" <?php if($PromocodeInfo[0]['promocode_type']=="Percentage"){ echo 'selected="selected"';}?>>Percentage</option>
												</select>
												 <div id="err_promocode_type" class="error_msg"></div>
                                            </div>
                                        </div>

                                       
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($PromocodeInfo[0]['promocode_status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($PromocodeInfo[0]['promocode_status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
												 <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptpromocode" id="btn_uptpromocode">Update</button>
													<a href="<?php echo base_url();?>backend/Promocode/managePromocode" class="btn btn-primary" >Cancel</a>
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
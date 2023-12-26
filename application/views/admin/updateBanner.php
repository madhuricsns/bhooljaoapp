<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Banner</h5>
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
						<?php $encodedValueId=base64_encode($BannerInfo[0]['banner_id']); ?>
						<form class="needs-validation" name="frm_updatebanner" id="frm_updatebanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/banners/updateBanner/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                   
                                        <div class="col-sm-12">
                                        	  <div class="row">
                                        	  	<div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="banner_title" ><span>*</span> Banner</label>
                                                <input type="text" class="form-control" id="banner_title" name="banner_title"  required value="<?php echo $BannerInfo[0]['banner_title'];?>">
												 <div id="err_brand_name" class="error_msg"></div>
                                            </div>
                                        </div>
											<!--<div class="form-group row">
                                                <label for="description" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <textarea name="description" id="description" class="form-control  col-md-6"><?php //echo $BrandInfo[0]['description'];?></textarea>
                                            </div>-->
                                           
                                        	  	<div class="col-md-6">
                                            <div class="form-group">
                                            	<label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($BannerInfo[0]['banner_status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($BannerInfo[0]['banner_status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                                
                                            </div>
                                        </div>
                                    </div>
											  <div class="row">
											  	 <div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span>Banner Type</label>
												<select name="banner_type" id="banner_type" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Customer" <?php if($BannerInfo[0]['banner_type']=="Customer"){ echo 'selected="selected"';}?>>Customer</option>
													<option value="Service Provider" <?php if($BannerInfo[0]['banner_type']=="Service Provider"){ echo 'selected="selected"';}?>>Service Giver</option>
												</select>
                                            </div>
                                        </div>
                                        	  	<div class="col-md-6">
                                            <div class="form-group ">
                                            	<label for="banner_image"><span>*</span> Banner Image</label>
                                                

												<?php 
                                                   if($BannerInfo[0]['banner_image']!="")
												{
	
												$str_images='<img src="'.base_url().'uploads/banner_images/'.$BannerInfo[0]['banner_image'].'" style="width:80px;height:80px">';
												}
												else
												{
												$str_images='<img src="'.base_url().'uploads/banner_images/default.png" style="width:80px;height:80px">';
												}
												?>
												<?php echo $str_images;?>

												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
												<input class="form-control " id="banner_image" type="file" name="banner_image" />
												<div class="err_msg" id="err_banner_image"></div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                            
                                            	<div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptbanner" id="btn_uptbanner">Update</button>
													<a href="<?php echo base_url();?>backend/Banners/manageBanner" class="btn btn-primary" >Cancel</a>
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
<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Update Category</h5>
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
						<?php $encodedValueId=base64_encode($categoryInfo[0]['category_id']); ?>
						<form class="needs-validation" name="frm_updatebanner" id="frm_updatebanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Category/updateCategory/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                            	<div class="row">
                            	<div class="form-group col-md-6">
                                                <label ><span></span> Category</label>
												<select name="category" id="category" class="form-control  " >

                                                    <option value="">Select Category</option>
													<?php
                                                    foreach($categoryLists as $category){
                                                    ?>
   <option value="<?php echo $category['category_id']?>" <?php if($categoryInfo[0]['category_parent_id']==$category['category_id']){ echo 'selected="selected"';}?>><?php echo $category['category_name']?></option>
													<?php } ?>
                                                    
												</select>
												<div id="err_category" class="error_msg"></div>
                                    </div>
                                    
                                            <div class="form-group col-md-6">
                                                <label for="category_name"><span>*</span> Category Name</label>
                                                <input type="text" class="form-control" id="category_name" name="category_name"  required value="<?php echo $categoryInfo[0]['category_name'];?>">
												 <div id="err_category_name" class="error_msg"></div>
                                            </div>
                                        </div>
                                        <div class="row">

											<div class="form-group col-md-6">
                                                <label for="description"><span>*</span> Description</label>
                                               <textarea name="description" id="description" class="form-control "><?php echo $categoryInfo[0]['category_description'];?></textarea>
                                               <div id="err_description" class="error_msg"></div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="category_image" ><span>*</span> Category Image</label>
                                                <input class="form-control" id="category_image" type="file"  name="category_image" />
												<div class="err_msg" id="err_category_image"></div>
												
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
                                            </div>


											<div class="form-group col-md-2">
												<?php
                                                $str_images="";
                                                 if($categoryInfo[0]['category_image']!="")
												{
												$str_images='<img src="'.base_url().'uploads/category_images/'.$categoryInfo[0]['category_image'].'" style="width:80px;height:80px">';
												} ?>
												<span><?php echo $str_images;?></span><br/>
											</div>
										</div>
										<div class="row">	
                                            <div class="form-group col-md-6">
                                                <label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control" required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($categoryInfo[0]['category_status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($categoryInfo[0]['category_status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
												<div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
										<!-- </div> -->
                                            <div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptcategory" id="btn_uptcategory">Update</button>
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
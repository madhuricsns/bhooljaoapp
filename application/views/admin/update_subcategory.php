<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>EDIT SUB CATEGORY</h5>
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
						<?php $encodedValueId=base64_encode($userInfo[0]['id']); ?>
						<form class="needs-validation" name="frm_updateuser" id="frm_updateuser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/SubCategory/update_subcategory/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        	 <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Category</label>
												<select name="category" id="category" class="form-control  col-md-6" required onchange="showDiv(this)">

                                                            <option value="">Select Subcategory</option>
													<option value="Category 1" <?php if($userInfo[0]['category_id']=="Category 1"){ echo 'selected="selected"';}?>>Category 1</option>
													<option value="Category 2" <?php if($userInfo[0]['category_id']=="Category 2"){ echo 'selected="selected"';}?>>Category 2</option>


												</select>
                                            </div>

                                             <div class="form-group row">
                                                <label for="subcategoryfile" class="col-xl-3 col-md-4"><span>*</span> SubCategory Image</label>
                                                <input class="form-control col-xl-4 col-md-4" id="subcategoryfile" type="file" required="" name="subcategoryfile" />
												<div class="err_msg" id="err_banner_image"></div>
												<?php if($userInfo[0]['subcategory_image']!="")
												{
												$str_images='<img src="'.base_url().'uploads/subcategory/'.$userInfo[0]['subcategory_image'].'" style="width:110px;height:110px">';
												}?>
												<span><?php echo $str_images;?></span><br/>
												
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
                                            </div>





                                            <div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>SubCategory Name</label>
                                                <input type="text" class="form-control  col-md-6" id="subcategory_name" name="subcategory_name"  required value="<?php echo $userInfo[0]['subcategory_name'];?>">
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <input type="textarea" name="description" id="description" class="form-control  col-md-6" required value="<?php echo $userInfo[0]['description'];?>">
                                            </div>
                                            <!--  <div class="form-group row">
                                                <label for="username" class="col-xl-3 col-md-4"><span>*</span>User Name</label>
                                                <input type="text" class="form-control  col-md-6" id="username" name="username"  required value="">
												 <div id="err_username" class="error_msg"></div>
                                            </div> -->
                                            <div class="form-group row">
                                                <label for="password" class="col-xl-3 col-md-4"><span>*</span> Duration</label>
                                               <input type="text" name="duration" id="duration" class="form-control  col-md-6" required value="<?php echo $userInfo[0]['duration'];?>">
                                            </div>
                                            <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Price</label>
                                                <input type="text" name="price" id="price" class="form-control  col-md-6"required value="<?php echo $userInfo[0]['price'];?>">
                                            </div>
                                             <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Max-Price</label>
                                                <input type="text" name="maxprice" id="maxprice" class="form-control  col-md-6"required value="<?php echo $userInfo[0]['max_price'];?>">
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-6" required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($userInfo[0]['status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($userInfo[0]['status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>



                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_uptuser" id="btn_uptuser">Update</button>
													<a href="<?php echo base_url();?>backend/Users/index" class="btn btn-primary" >Cancel</a>
						                        </div>
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

<script type="text/javascript">
function showDiv(select){
	//alert("Hi");
   if(select.value=="Yes"){
    document.getElementById('daily_report').disabled  = true;
   } else{
   	document.getElementById('daily_report').disabled  = false;
   }
} 
</script>
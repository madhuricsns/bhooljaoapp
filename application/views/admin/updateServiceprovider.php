<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>UPDATE SERVICE PROVIDER</h5>
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
						<?php $encodedValueId=base64_encode($userInfo[0]['user_id']); ?>
						<form class="needs-validation" name="frm_updateuser" id="frm_updateuser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/users/updateServiceprovider/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <!-- <div class="row"> -->
                                        <div class="col-sm-12">
                                        	<div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="banner_image"><span>*</span> Profile</label>
                                               
                                                <?php 
                                                   if($userInfo[0]['profile_pic']!="")
												{
	
												$str_images='<img src="'.base_url().'uploads/service_provider/'.$userInfo[0]['profile_pic'].'" style="width:80px;height:80px">';
												}
												else
												{
												$str_images='<img src="'.base_url().'uploads/service_provider/default.png" style="width:80px;height:80px">';
												}
												?>
                                                <?php echo $str_images;?> 
												
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
												<div class="err_msg" id="err_banner_image"></div>
												
												 <input class="form-control col-xl-6 col-md-6" id="servicefile" type="file"  name="servicefile" />
                                            </div>
                                        </div>

                                      
                                           <div class="col-md-6">
                                            <div class="form-group ">
                                           
                                                <label for="full_name" ><span>*</span>Full Name</label>
                                                <input type="text" class="form-control " id="full_name" name="full_name"  required value="<?php echo $userInfo[0]['full_name'];?>">
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>


                                           <div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group ">
                                                <label for="email_address"><span>*</span> Email Address</label>
                                               <input type="email" name="email_address" id="email_address" class="form-control" value="<?php echo $userInfo[0]['email'];?>">
                                            </div>
                                        </div>
                                            
                                            
											
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mobile_number"><span>*</span>Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number"  required value="<?php echo $userInfo[0]['mobile'];?>">
												 <div id="err_mobile_number" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>

                                           <div class="row">
                                           <div class="col-md-6">
                                           	 <label for="mobile_number" ><span>*</span> Gender</label>
                                            <div class="form-group">
                                               
                                               <label class="col-md-3" > <input type="radio" name="gender" class="gender"value="Male" required <?php if($userInfo[0]['gender']=="Male"){ echo 'checked="checked"';}?>> Male</label>
                                               <label class="col-md-3" > <input type="radio" name="gender" class="gender"  value="Female" required <?php if($userInfo[0]['gender']=="Female"){ echo 'checked="checked"';}?>> Female</label>
                                               <label class="col-md-2" > <input type="radio" name="gender" class="gender"  value="Other" required <?php if($userInfo[0]['gender']=="Other"){ echo 'checked="checked"';}?>> Other</label>
                                            </div>
                                        </div>

                                           
                                           <div class="col-md-6">
                                            <div class="form-group ">
                                                <label ><span>*</span> Category</label>
												<select name="category_id" id="category_id" class="form-control" required onchange="showDiv(this)">

                                                            <option value="">Select Category</option>
                                                       <?php
													foreach($categoryList as $category){

													?>    
													<option value="<?php echo $category['category_id'] ?>" <?php if($userInfo[0]['category_id']==$category['category_id']){ echo 'selected="selected"';}?>><?php echo $category['category_name'] ?></option>
													<?php } ?>

												</select>
												 <div id="err_state_id" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>


                                             <div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span>*</span> Zone</label>
												<select name="zone_id" id="zone_id" class="form-control" required onchange="showDiv(this)">

                                                            <option value="">Select Zone</option>
                                                       <?php
													foreach($zoneList as $zone){

													?>    
													<option value="<?php echo $zone['zone_id'] ?>" <?php if($userInfo[0]['zone_id']==$zone['zone_id']){ echo 'selected="selected"';}?>><?php echo $zone['zone_name'] ?></option>
													<?php } ?>

												</select>
												 <div id="err_state_id" class="error_msg"></div>
                                            </div>
                                        </div>
                                            
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span>*</span>Address</label>
                                                <textarea name="address" id="address" class="form-control " required><?php echo $userInfo[0]['address'];?></textarea>
												
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span></span>Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($userInfo[0]['status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($userInfo[0]['status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>
                                        </div>
                                    </div>

                                            <div class="form-group">
                                            	<div class="offset-xl-8 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_uptsp" id="btn_uptsp">Update</button>
													<a href="<?php echo base_url();?>backend/Users/manageServiceProvider" class="btn btn-primary" >Cancel</a>
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
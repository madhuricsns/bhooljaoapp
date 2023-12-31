<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>UPDATE CUSTOMER</h5>
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
						<form class="needs-validation" name="frm_updateuser1" id="frm_updateuser1" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/users/updateUser/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <!-- <div class="row"> -->
                                        <div class="col-sm-12">
                                        	<div class="row">
                                           <div class="col-md-6">
                                           	 <div class="form-group ">
                                                <label for="full_name" ><span>*</span>Full Name</label>
                                                <input type="text" class="form-control " id="full_name" name="full_name"  required value="<?php echo $userInfo[0]['full_name'];?>">
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
                                           
                                        </div>

                                           
                                           <div class="col-md-6">
                                           	<div class="form-group">
                                                <label for="email_address"><span>*</span> Email Address</label>
                                               <input type="email" name="email_address" id="email_address" class="form-control" value="<?php echo $userInfo[0]['email'];?>">
                                            </div>
                                           
                                        </div>
                                    </div>
                                           <div class="row">
                                           <div class="col-md-6">
                                           	<div class="form-group ">
											
                                                <label for="mobile_number"><span>*</span>Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number"  required value="<?php echo $userInfo[0]['mobile'];?>">
												 <div id="err_mobile_number" class="error_msg"></div>
                                            </div>
                                            
                                        </div>
                                            
                                           <div class="col-md-6">
                                           <div class="form-group ">
                                           	<label for="gender" ><span>*</span> Gender</label>
                                             <br>
                                               <label> <input type="radio" name="gender" class="gender"value="Male" required <?php if($userInfo[0]['gender']=="Male"){ echo 'checked="checked"';}?>> Male</label>
                                               <label> <input type="radio" name="gender" class="gender"  value="Female" required <?php if($userInfo[0]['gender']=="Female"){ echo 'checked="checked"';}?>> Female</label>
                                               <label> <input type="radio" name="gender" class="gender"  value="Other" required <?php if($userInfo[0]['gender']=="Other"){ echo 'checked="checked"';}?>> Other</label>
                                            </div>
                                            
                                        </div>
                                    </div>

                                            <div class="row">
                                           <div class="col-md-6">
                                           	 <div class="form-group">
                                                <label for="address"><span>*</span>Address</label>
                                                <textarea name="address" id="address" class="form-control" required><?php echo $userInfo[0]['address'];?></textarea>
                                                <div id="err_address" class="error_msg"></div>
                                            </div>
                                            
                                        </div>
                                            <div class="col-md-6">
                                            	 <div class="form-group">
                                                <label ><span>*</span>Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($userInfo[0]['status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($userInfo[0]['status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label for="banner_image" ><span>*</span> Profile</label>
                                                <input class="form-control " id="servicefile1" type="file"  name="servicefile" />
                                                <span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
                                            </div>
                                        </div>    
                                        <div class="col-md-2">
                                               <?php 
                                                   if($userInfo[0]['profile_pic']!="")
												{
	
												$str_images='<img src="'.base_url().'./uploads/user_profile/default.png/'.$userInfo[0]['profile_pic'].'" style="width:80px;height:80px">';
												}
												else
												{
												$str_images='<img src="'.base_url().'./uploads/user_profile/default.png" style="width:80px;height:80px">';
												}
												?>
												<?php echo $str_images;?>
                                        </div>
                                           
                                    </div>

                                            <!-- <div class="form-group row"> -->
                                            	<div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_uptuser" id="btn_adduser">Update</button>
													<a href="<?php echo base_url();?>backend/Users/index" class="btn btn-primary" >Cancel</a>
						                        </div>
                                            <!-- </div> -->
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
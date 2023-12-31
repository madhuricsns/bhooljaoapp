<div class="page-body">
	<div class="page-header">                   
    </div>
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Edit Service Provider</h5>
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
						<form class="needs-validation" name="frm_updateuser" id="frm_updateuser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Service_provider/updateservice/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">


                                        	 <div class="form-group row">
                                                <label for="banner_image" class="col-xl-3 col-md-4"><span>*</span> Profile</label>
                                                <input class="form-control col-xl-4 col-md-4" id="servicefile" type="file" required="" name="servicefile" />
												<div class="err_msg" id="err_banner_image"></div>
												<?php if($userInfo[0]['profile_pic']!="")
												{
												$str_images='<img src="'.base_url().'uploads/service_provider/'.$userInfo[0]['profile_pic'].'" style="width:110px;height:110px">';
												}?>
												<span><?php echo $str_images;?></span><br/>
												
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
                                            </div>




                                            <div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span></span>Full Name</label>
                                                <input type="text" class="form-control  col-md-6" id="full_name" name="full_name"  required value="<?php echo $userInfo[0]['full_name'];?>">
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4"><span></span> Email Address</label>
                                               <input type="email" name="email_address" id="email_address" class="form-control  col-md-6" value="<?php echo $userInfo[0]['email'];?>">
                                            </div>
                                          
											<div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span></span>Mobile Number</label>
                                                <input type="text" class="form-control  col-md-6" id="mobile_number" name="mobile_number"  required value="<?php echo $userInfo[0]['mobile'];?>">
												 <div id="err_mobile_number" class="error_msg"></div>
                                            </div>
                                           

 <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> User Type</label>
												<select name="is_superadmin" id="is_superadmin" class="form-control  col-md-6" required onchange="showDiv(this)">
													
													<option value="Customer"<?php if($userInfo[0]['user_type']=="Customer"){ echo 'selected="selected"';}?>>Customer</option>
													<option value="Service Provider"<?php if($userInfo[0]['user_type']=="Service Provider"){ echo 'selected="selected"';}?>>Service Provider</option>
												</select>
                                            </div>
                                             <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Zone</label>
												<select name="zone_id" id="zone_id" class="form-control  col-md-6" required onchange="showDiv(this)">

                                                            <option value="">Select Zone</option>
                                                       <?php
													foreach($zoneList as $zone){

													?>    
													<option value="<?php echo $zone['zone_id'] ?>" <?php if($userInfo[0]['zone_id']==$zone['zone_id']){ echo 'selected="selected"';}?>><?php echo $zone['zone_name'] ?></option>
													<?php } ?>

												</select>
												 <div id="err_state_id" class="error_msg"></div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span>Address</label>
                                                <textarea name="address" id="address" class="form-control  col-md-6" required><?php echo $userInfo[0]['address'];?></textarea>
												
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
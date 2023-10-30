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
                                    <div class="row">
                                        <div class="col-sm-12">
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
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Gender</label>
                                               <label class="col-md-1" > <input type="radio" name="gender" class="gender"value="Male" required <?php if($userInfo[0]['gender']=="Male"){ echo 'checked="checked"';}?>> Male</label>
                                               <label class="col-md-2" > <input type="radio" name="gender" class="gender"  value="Female" required <?php if($userInfo[0]['gender']=="Female"){ echo 'checked="checked"';}?>> Female</label>
                                               <label class="col-md-1" > <input type="radio" name="gender" class="gender"  value="Other" required <?php if($userInfo[0]['gender']=="Other"){ echo 'checked="checked"';}?>> Other</label>
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
						                            <button type="submit" class="btn btn-primary" name="btn_uptsp" id="btn_uptsp">Update</button>
													<a href="<?php echo base_url();?>backend/Users/manageServiceProvider" class="btn btn-primary" >Cancel</a>
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
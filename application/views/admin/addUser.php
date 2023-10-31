<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD CUSTOMER</h5>
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
						<form class="needs-validation" name="frm_adduser" id="frm_adduser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/users/addUser">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        	<div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>Profile</label>
                                                <input type="file" class="form-control  col-md-6" id="servicefile" name="servicefile" >
												
                                            </div>
                                            <div class="form-group row">

                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>Full Name</label>
                                                <input type="text" class="form-control  col-md-6" id="full_name" name="full_name"  required>
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4"><span>*</span> Email Address</label>
                                               <input type="email" name="email_address" id="email_address" class="form-control  col-md-6" required>
                                               <div id="err_email_address" class="error_msg"></div>
                                            </div>
                                               <div class="form-group row">
                                                <label for="password" class="col-xl-3 col-md-4"><span>*</span> Password</label>
                                               <input type="password" name="password" id="password" class="form-control  col-md-6" required>
                                                <div id="err_password" class="error_msg"></div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Mobile Number</label>
                                                <input type="tel" name="mobile_number" id="mobile_number" class="form-control  col-md-6"required pattern="[0-9]{10}">
                                                <div id="err_mobile_number" class="error_msg"></div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Gender</label>
                                               <label class="col-md-1" > <input type="radio" name="gender" class="gender"value="Male" required > Male</label>
                                               <label class="col-md-1s" > <input type="radio" name="gender" class="gender"  value="Female" required > Female</label>
                                               <label class="col-md-1" > <input type="radio" name="gender" class="gender"  value="Other" required > Other</label>
                                               <div id="err_gender" class="error_msg"></div>
                                            </div>
                                             <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span>Address</label>
                                                <textarea name="address" id="address" class="form-control  col-md-6" required></textarea>
												 <div id="err_address" class="error_msg"></div>
                                            </div>
                                            
                                            
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Status</label>
												<select name="status" id="status" class="form-control  col-md-6" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
												 <div id="err_status" class="error_msg"></div>
                                            </div>
                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_adduser" id="btn_adduser">Add</button>
													<a href="<?php echo base_url();?>backend/Users/manageUsers" class="btn btn-primary" >Cancel</a>
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
<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD SERVICE PROVIDER</h5>
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
						<form class="needs-validation" name="frm_addcity" id="frm_addcity" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/City/addcity">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        	
                                            <div class="form-group row">
                                                <label for="city_name" class="col-xl-3 col-md-4"><span>*</span>City Name</label>
                                                <input type="text" class="form-control  col-md-6" id="city_name" name="city_name" placeholder="Enter City Name "  required>
												 <div id="err_city_name" class="error_msg"></div>
                                            </div>
											
											
                                            
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span>State</label>
												<select name="state_id" id="state_id" class="form-control  col-md-6" required onchange="showDiv(this)">
													<option value="">Select State </option>
													<?php
													foreach($stateList as $state){

													?>
													<option value="<?php echo $state['state_id'] ?>"><?php echo $state['state_name'] ?></option>
												<?php } ?>
												</select>
												 <div id="err_state_id" class="error_msg"></div>
                                            </div>
                                            
                                           
											
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-6" required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
												 <div id="err_status" class="error_msg"></div>
                                            </div>
                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_addcity" id="btn_addcity">Add</button>
													<a href="<?php echo base_url();?>backend/City/managescity" class="btn btn-primary" >Cancel</a>
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
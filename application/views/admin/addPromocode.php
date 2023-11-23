<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Add Promocode</h5>
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
						<form class="needs-validation" name="frm_addpromocode" id="frm_addpromocode" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Promocode/addPromocode">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    
                                        <div class="col-sm-12">
                                        	<div class="row">
                                        	<!-- 	<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="banner_title" ><span>*</span> Select Service</label>
                                              <select name="service_id" id="service_id" class="form-control" required>
													<option value="">Select Service</option>
													<?php
													//foreach($serviceList as $service){

													?>
													<option value="<?php //echo $service['service_id'] ?>"><?php //echo $service['service_name'] ?></option>
												<?php //} ?>
												</select>
												 <div id="err_service_id" class="error_msg"></div>
                                            </div>
                                        </div>
											 -->
											<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="banner_image" ><span>*</span> Promocode </label>
                                                <input type="text" class="form-control" id="promocode_code" name="promocode_code" required placeholder="Generate Code"readonly>
										 <div id="err_promocode_code" class="error_msg"></div>
												
                                            </div>
                                        </div>
                                        <div class="col-sm-6"><br>
	                                                <button class="btn btn-success" id="generate_code" type="button" required="" name="generate_code" onclick="Random();">Generate Code</button>
												</div>
                                     </div>
                                            <div class="row">
                                           	<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Promocode Description</label>
												<textarea name="promocode_description" id="promocode_description" class="form-control" required></textarea>
												 <div id="err_promocode_description" class="error_msg"></div>
                                            </div>
                                        </div>

                                       
                                        	
                                    
                                           	<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Promocode Type</label>
												<select name="promocode_type" id="promocode_type" class="form-control" required>
													<option value="">Select Promocode Type</option>
													<option value="Fixed Price">Fixed Price</option>
													<option value="Percentage">Percentage</option>
												</select>
												 <div id="err_promocode_type" class="error_msg"></div>
                                            </div>
                                        </div>
                                         </div>
											
                                           <div class="row">
                                        	<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Promocode Discount</label>
												 <input type="text" class="form-control" id="promocode_discount" name="promocode_discount"   required value="">
												 <div id="err_promocode_discount" class="error_msg"></div>
                                            </div>
                                        </div>
                                       
                                        		<div class="col-md-6">
                                            <div class="form-group">
                                                <label ><span>*</span> Status</label>
												<select name="status" id="status" class="form-control  " required>
													<option value="">Select Status</option>
													<option value="Active">Active</option>
													<option value="Inactive">Inactive</option>
												</select>
												 <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
                                    </div>

									<div class="pull-right">
										<button type="submit" class="btn btn-primary" name="btn_addPromocode" id="btn_addPromocode">Add</button>
										<a href="<?php echo base_url();?>backend/Promocode/managePromocode" class="btn btn-primary" >Cancel</a>
									</div>

                                            
                                        </div>
                                    </div>
                                
                            </div>
                       
                        
						</form>
						 </div>
                    </div>
                </div>
            <!-- </div> -->
	<!-- Container-fluid Ends-->
</div>
<script>
function Random() {
        var rnd = Math.random().toString(36).substring(3,9).toUpperCase();
        document.getElementById('promocode_code').value = rnd;
    }
</script>
<script>  
$(document).ready(function() {  
$('#generate_code').click(function() {  
 var number = 1 + Math.floor(Math.random() * 6);
  $('#promocode_code').text(number);
// Select the text box element using jQuery selectors  
var nameTextBox = $('#promocode_code');  
// Call the val() method on the selected element to retrieve its value  
var name = number.val();  
// Display the retrieved value  
alert(name);  
});  
});  
</script>  
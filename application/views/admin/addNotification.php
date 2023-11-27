<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD NOTIFICATION</h5>
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
						<form class="needs-validation" name="frm_addmaterial" id="frm_addmaterial" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Notifications/addnotification">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                   
                                        <div class="col-sm-12">
                                           <div class="row">
                                        	 	
											<div class="col-md-6" >
                                            <div class="form-group">
                                                <label ><span>*</span>Title</label>
                                                 <input type="text" name="title" id="title" class="form-control  "required >
												
                                                <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>
                              <div class="col-md-6" >
                                            <div class="form-group">
                                                <label ><span>*</span>Notification Massage</label>
                                                
												<textarea name="message" id="massage" class="form-control" required ></textarea>
                                                <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>

                                    </div>


                                        	 <div class="row">
                                        	 	
											<div class="col-md-6" >
                                            <div class="form-group1">
                                                <label ><span>*</span>Select Type</label>
												<select name="select_type" id="select_type" class="form-control" required >
													<option value="">Select Type</option>
													<option value="Service Provider">Service Provider</option>
													<option value="Customer">Customer</option>
												</select>
                                                <div id="err_status" class="error_msg"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6" id="customerDiv" style="display:none">
                                                <label ><span>*</span>Customer</label><br>
												<select name="user_ids[]" id="user" class="form-control js-example-basic-multiple"  data-placeholder="Select Customers"  multiple="multiple">
													<option value="">Select Customer</option>
													<?php
													// print_r($UserList);
														foreach($UserList as $user)
														{
													?>
													<option value="<?php echo $user['user_id']?>"><?php echo $user['full_name']?></option>
													<?php	}
													?>
												</select>
                                                <div id="err_status" class="error_msg"></div>
                                        </div>

										<div class="form-group col-md-6" style="display:none" id="serviceproviderDiv" >
                                                <label ><span>*</span>Service Provider</label><br>
												<select name="user_ids[]" id="user1" class="form-control js-example-basic-multiple" data-placeholder="Select Service Providers" multiple="multiple">
													<option value="">Select Service Provider</option>
													<?php
													// print_r($UserList);
													foreach($ServiceProviderList as $sp)
													{
													?>
													<option value="<?php echo $sp['user_id']?>"><?php echo $sp['full_name']?></option>
													<?php	} ?>
												</select>
                                                <div id="err_status" class="error_msg"></div>
                                        </div>
                              
                                    </div>
											<div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addnotification" id="btn_addnotification">Add</button>
													<a href="<?php echo base_url();?>backend/Notifications/manageNotifications" class="btn btn-primary" >Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        <!-- </div> -->
                        
						</form>
                    </div>
                </div>
            </div>
	<!-- Container-fluid Ends-->
</div>
<!-- <script>
$(document).ready(function(){
	alert();
	// $("#select_type").change(function(){
	// 	var type=$("#select_type").val();
	// 	alert();
	// // var values=$("#select_type option:selected").text();
	// // $("#selectedcontent").val(values);
	// // alert('Customer');
	// });
	$("#select_type").change(function () {                            
	   var category= $('select[name=select_type]').val() // Here we can get the value of selected item
	   alert(category); 
	});	
});

</script> -->
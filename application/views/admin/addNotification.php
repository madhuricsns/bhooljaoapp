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
						<form class="needs-validation" name="frm_addnotification" id="frm_addnotification" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Notifications/addnotification">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                   
                                        <div class="col-sm-12">
                                           <div class="row">
                                        	 	
											<div class="col-md-6" >
                                            <div class="form-group">
                                                <label ><span>*</span>Title</label>
                                                 <input type="text" name="title" id="title" class="form-control"required >
												
                                                <div id="err_title" class="error_msg"></div>
                                            </div>
                                        </div>
                              			<div class="col-md-6" >
                                            <div class="form-group">
                                                <label ><span>*</span>Notification Message</label>
												<textarea name="message" id="massage" class="form-control" required ></textarea>
                                                <div id="err_massage" class="error_msg"></div>
                                            </div>
                                        </div>

                                    </div>


                                        	 <div class="row">
                                        	 	
											<div class="col-md-6" >
                                            <div class="form-group">
                                                <label ><span>*</span>Select Type</label>
												<select name="select_type" id="select_type" class="form-control" required >
													<option value="">Select Type</option>
													<option value="Service Provider">Service Giver</option>
													<option value="Customer">Customer</option>
												</select>
                                                <div id="err_select_type" class="error_msg"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
										
                                            <div id="customerDiv">
											<div class="form-group">
                                                <label ><span>*</span>Customer</label>
												<select name="user_ids[]" id="user_ids_cust" class="form-control select2" multiple>
													<option value="">Select Customers</option>
													<option value="All">All</option>
												<?php 
												if(count($UserList) > 0) {
														foreach($UserList as $user) { ?>
												<option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>		
												<?php	}	
												} ?>
												</select>
                                                <div id="err_sp" class="error_msg"></div>
                                            </div>
											</div>
											
											<div id="serviceproviderDiv">
											<div class="form-group">
                                                <label ><span>*</span>Service Givers</label>
												<select name="user_ids[]" id="user_ids_sp" class="form-control select2" multiple>
													<option value="">Select Givers</option>
													<option value="All">All</option>
													<?php 
													if(count($ServiceProviderList) > 0) {
															foreach($ServiceProviderList as $user) { ?>
													<option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>		
														<?php	}	
														} ?>						
												</select>
                                                <div id="err_user" class="error_msg"></div>
                                            </div>
											</div>
											
                                        </div>
                              
                                    </div>
											<div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addnotification" id="btn_addnoti">Add</button>
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
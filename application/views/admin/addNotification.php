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
						<form class="needs-validation" name="frm_addmaterial" id="frm_addmaterial" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Material/addMaterial">
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
                                                <label ><span>*</span>Notification Massage</label>
                                                
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
													<option value="Service Provider">Service Provider</option>
													<option value="Customer">Customer</option>
												</select>
                                                <div id="err_select_type" class="error_msg"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <label ><span>*</span>Users</label>
												<select name="usertype" id="user" class="form-control" required >
													<option value="">Select Users</option>
													
												</select>
                                                <div id="err_user" class="error_msg"></div>
                                            </div>
                                        </div>
                              
                                    </div>
											<div class="pull-right">
						                            <button type="submit" class="btn btn-primary" name="btn_addnoti" id="btn_addnoti">Add</button>
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
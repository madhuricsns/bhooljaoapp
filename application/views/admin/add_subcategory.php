<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD SUB CATEGORY</h5>
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
						<form class="needs-validation" name="frm_adduser" id="frm_adduser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/SubCategory/addsubcategory">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        	 <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Category</label>
												<select name="category" id="category" class="form-control  col-md-6" required onchange="showDiv(this)">
													<option value="">Select Category </option>
													<option value="Category 1">Category 1</option>
													<option value="Category 2">Category 2</option>
												</select>
                                            </div>

											<div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>SubCategory Image</label>
                                                <input type="file" class="form-control  col-md-6" id="subcategoryfile" name="subcategoryfile"  required>
												 <div id="err_subcategoryfile" class="error_msg"></div>
                                            </div>




                                            <div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>SubCategory Name</label>
                                                <input type="text" class="form-control  col-md-6" id="subcategory_name" name="subcategory_name"  required>
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <input type="textarea" name="description" id="description" class="form-control  col-md-6" required>
                                            </div>
                                            <!--  <div class="form-group row">
                                                <label for="username" class="col-xl-3 col-md-4"><span>*</span>User Name</label>
                                                <input type="text" class="form-control  col-md-6" id="username" name="username"  required value="">
												 <div id="err_username" class="error_msg"></div>
                                            </div> -->
                                            <div class="form-group row">
                                                <label for="password" class="col-xl-3 col-md-4"><span>*</span> Duration</label>
                                               <input type="text" name="duration" id="duration" class="form-control  col-md-6" required>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Min-Price</label>
                                                <input type="text" name="price" id="price" class="form-control  col-md-6"required >
                                            </div>
                                             <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Max-Price</label>
                                                <input type="text" name="maxprice" id="maxprice" class="form-control  col-md-6"required >
                                            </div>
                                            
                                           
                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_adduser" id="btn_adduser">Add</button>
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
<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ADD SERVICE</h5>
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
						<form class="needs-validation" name="frm_adduser" id="frm_adduser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Service/addService">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        	 <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Category</label>
												<select name="category" id="category" class="form-control  col-md-6" required onchange="showDiv(this)">
													<option value="">Select Category </option>
													<?php
                                                    foreach($categoryList as $category){
                                                    ?>
                                                    <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
													<?php } ?>
												</select>
                                            </div>

											<div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>Service Image</label>
                                                <input type="file" class="form-control  col-md-6" id="servicefile" name="servicefile"  required>
												 <div id="err_subcategoryfile" class="error_msg"></div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>Service Name</label>
                                                <input type="text" class="form-control  col-md-6" id="service_name" name="service_name"  required>
												 <div id="err_full_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <textarea name="description" id="description" class="form-control  col-md-6" required></textarea>
                                            </div>
                                           
                                            <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Min-Price</label>
                                                <input type="text" name="minprice" id="minprice" class="form-control  col-md-6"required >
                                            </div>
                                             <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4"><span>*</span> Max-Price</label>
                                                <input type="text" name="maxprice" id="maxprice" class="form-control  col-md-6"required >
                                            </div>

                                            <div class="form-group row">
                                                <label for="option_label" class="col-xl-3 col-md-4"><span>*</span> Option Label Name</label>
                                                <input type="text" name="option_label" id="option_label" class="form-control  col-md-6"required >
                                            </div>
                                            
                                            <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Enter Options</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbody">
														<tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="text" class="form-control optionsArr" id="optionsArr" name="optionsArr[]" placeholder="Enter Option"  >
																<div id="err_optionsArr" class="error_msg err_optionsArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control amountArr" id="amountArr" name="amountArr[]" placeholder="Enter Amount"  >
																<div id="err_amountArr" class="error_msg err_amountArr"></div>
															</td>
															<td  class="text-center"><button class="btn btn-md btn-success" id="addBtn" type="button">
															<i class="fa fa-plus"></i>
															</button></td>
														</tr>
													</tbody>
													
												</table>
											</div>

                                            <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Add More option</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbodyLabel">
														<tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="text" class="form-control labelArr" id="labelArr" name="labelArr[]" placeholder="Enter Label"  >
																<div id="err_labelArr" class="error_msg err_labelArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control labelvalueArr" id="labelvalueArr" name="labelvalueArr[]" placeholder="Enter Values(ex.Yes,No)"  >
																<div id="err_labelvalueArr" class="error_msg err_labelvalueArr"></div>
															</td>
															<td  class="text-center"><button class="btn btn-md btn-success" id="addRow" type="button">
															<i class="fa fa-plus"></i>
															</button></td>
														</tr>
													</tbody>
													
												</table>
											</div>
                                           
                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_addService" id="btn_addService">Add</button>
													<a href="<?php echo base_url();?>backend/Service/manageService" class="btn btn-primary" >Cancel</a>
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
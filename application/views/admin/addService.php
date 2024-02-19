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
												<select name="category" id="category" class="form-control  col-md-6" required >
													<option value="">Select Category </option>
													<?php
                                                    foreach($categoryList as $category){
                                                    ?>
                                                    <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
													<?php } ?>
												</select>
												<div id="err_category" class="error_msg"></div>
                                            </div>

											<div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span> Sub Category</label>
												<select name="subcategory" id="subcategory" class="form-control  col-md-6">
													<option value="">Select Sub Category </option>
													<?php 
                                                    foreach($subcategoryList as $subcategory){
                                                    ?>
                                                    <option value="<?php echo $subcategory['category_id']?>"><?php echo $subcategory['category_name']?></option>
													<?php }  ?>
												</select>
												<div id="err_subcategory" class="error_msg"></div>
                                            </div>

											<div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>Service Image</label>
                                                <input type="file" class="form-control  col-md-6" id="servicefile" name="servicefile"  required>
												 <div id="err_subcategoryfile" class="error_msg"></div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"><span>*</span>Service Name</label>
                                                <input type="text" class="form-control  col-md-6" id="service_name" name="service_name"  required>
												 <div id="err_service_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="description" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <textarea name="description" id="description" class="form-control  col-md-6" required></textarea>
                                               <div id="err_description" class="error_msg"></div>
                                            </div>
                                           
                                            <div class="form-group row">
                                                <label for="mobile_pricenumber" class="col-xl-3 col-md-4"><span>*</span> Price</label>
                                                <input type="text" name="price" id="price" class="form-control  col-md-6" required >
                                                <div id="err_price" class="error_msg"></div>
                                            </div>
											<div class="form-group row">
                                                <label for="discount_price" class="col-xl-3 col-md-4"><span>*</span> Discount Price</label>
                                                <input type="text" name="discount_price" id="discount_price" class="form-control  col-md-6"required >
                                                <div id="err_discount_price" class="error_msg"></div>
                                            </div>

											<div class="form-group row">
                                                <label for="offer_percentage" class="col-xl-3 col-md-4"><span>*</span> Offer Percentage</label>
                                                <input type="text" name="offer_percentage" id="offer_percentage" class="form-control  col-md-6"required >
                                                <div id="err_offer_percentage" class="error_msg"></div>
                                            </div>

											<div class="form-group row">
                                                <label for="demo_price" class="col-xl-3 col-md-4"><span>*</span> Demo Price</label>
                                                <input type="text" name="demo_price" id="demo_price" class="form-control  col-md-6" required >
                                                 <div id="err_offer_percentage" class="error_msg"></div>
                                            </div>
											<div class="form-group row">
                                                <label for="demo_discount_price" class="col-xl-3 col-md-4"><span>*</span> Demo Discount Price</label>
                                                <input type="text" name="demo_discount_price" id="demo_discount_price" class="form-control  col-md-6"required >
                                                 <div id="err_demo_discount_price" class="error_msg"></div>
                                            </div>


                                            <!-- <div class="form-group row">
                                                <label for="option_label" class="col-xl-3 col-md-4"><span>*</span> Option Label Name</label>
                                                <input type="text" name="option_label" id="option_label" class="form-control  col-md-6"required >
                                            </div> -->
                                            
                                            <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Enter Options</label>
                                                
												<table class="table1 col-md-8" id="myTable" style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbody">
														<tr>
															<!-- <td> <input type="text" class="form-control service_type" id="service_type" name="service_typeArr[]" placeholder="Enter Service Type"  >
																<div id="err_service_type" class="error_msg err_service_type"></div>
															</td> -->
															<td> <input type="text" class="form-control option_label" id="option_label" name="option_label[]" placeholder="Enter Label Name"  >
																<div id="err_option_label" class="error_msg err_option_label"></div>
															</td>
                                                            <td> <select class="form-control " id="option_type" name="option_type[]" required>
																 <option value="">Select Option Type</option>
																 <option value="Dropdown">Dropdown</option>
																 <option value="Input">Input</option>
																 <option value="Radio">Radio</option>
																</select>
																<div id="err_option_type" class="error_msg err_option_type"></div>
															</td>
															<td  class="text-center"> <!--<button class="btn btn-md btn-success addLabel1" id="addLabel1" type="button" onclick="insert_Row()">
															 <i class="fa fa-plus"></i> Add Label
															</button>--> </td>
														</tr>
														<tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="text" class="form-control optionsArr" id="optionsArr" name="optionsArr_0[]" placeholder="Enter Option"  >
																<div id="err_optionsArr" class="error_msg err_optionsArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control amountArr" id="amountArr" name="amountArr_0[]" placeholder="Enter Amount"  >
																<div id="err_amountArr" class="error_msg err_amountArr"></div>
															</td>
															 <td  class="text-center"><button class="btn btn-md btn-success" id="addBtn" type="button" >
															<i class="fa fa-plus"></i> 
															</button> </td>
														</tr>
													</tbody>
													
												</table>
											</div>

											<!-- <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Add More Options</label>
                                                
												<table class="table1 col-md-8" id="myTable" style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbody">
														<tr>
															
															<td> <input type="text" class="form-control option_label" id="option_label" name="option_label[]" placeholder="Enter Label Name"  >
																<div id="err_option_label" class="error_msg err_option_label"></div>
															</td>
                                                            <td> <select class="form-control " id="option_type" name="option_type[]" required>
																 <option value="">Select Option Type</option>
																 <option value="Dropdown">Dropdown</option>
																 <option value="Input">Input</option>
																 <option value="Radio">Radio</option>
																</select>
																<div id="err_option_type" class="error_msg err_option_type"></div>
															</td>
															<td  class="text-center">  </td>
														</tr>
														<tr>
															<td> <input type="text" class="form-control optionsArr" id="optionsArr" name="optionsArr_0[]" placeholder="Enter Option"  >
																<div id="err_optionsArr" class="error_msg err_optionsArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control amountArr" id="amountArr" name="amountArr_0[]" placeholder="Enter Amount"  >
																<div id="err_amountArr" class="error_msg err_amountArr"></div>
															</td>
															 <td  class="text-center"><button class="btn btn-md btn-success" id="addBtn" type="button" >
															<i class="fa fa-plus"></i> 
															</button> </td>
														</tr>
													</tbody>
													
												</table>
											</div> -->

											<div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Why Choose Us</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbodywhychooswus">
														<tr>
															<td> <input type="text" class="form-control whychooswusArr" id="labelArr" name="whychooswusArr[]" placeholder="Enter why Choose Us"  >
																<div id="err_whychooswusArr" class="error_msg err_whychooswusArr"></div>
															</td>
															<td  class="text-center"><button class="btn btn-md btn-success" id="addwhychooswusRow" type="button">
															<i class="fa fa-plus"></i>
															</button></td>
														</tr>
													</tbody>
													
												</table>
											</div>

											<div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Add Vehicle</label>
                                                
												<table class="table1 col-md-8 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbodyvehicle">
														<tr>
															<td> <input type="text" class="form-control vehiclenameArr" id="vehiclenameArr" name="vehiclenameArr[]" placeholder="Enter Vehicle Name"  >
																<div id="err_vehicleArr" class="error_msg err_vehicleArr"></div>
															</td>
															<td> <input type="text" class="form-control vehicleamountArr" id="vehicleamountArr" name="vehicleamountArr[]" placeholder="Enter amount"  >
																<div id="err_vehicleamountArr" class="error_msg err_vehicleamountArr"></div>
															</td>
															<td> <input type="file" class="form-control vehicleimageArr" id="vehicleimageArr" name="vehicleimageArr[]"  >
																<div id="err_vehicleimageArr" class="error_msg err_vehicleimageArr"></div>
															</td>
															<td  class="text-center"><button class="btn btn-md btn-success" id="addVehicleRow" type="button">
															<i class="fa fa-plus"></i>
															</button></td>
														</tr>
													</tbody>
													
												</table>
											</div>

                                            <!-- <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Add More option</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbodyLabel">
														<tr>
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
											</div> -->


                                           
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

<!-- <script type="text/javascript">
function showDiv(select){
	//alert("Hi");
   if(select.value=="Yes"){
    document.getElementById('daily_report').disabled  = true;
   } else{
   	document.getElementById('daily_report').disabled  = false;
   }
} 
</script> -->
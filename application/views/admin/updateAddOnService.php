<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>UPDATE ADDON SERVICE</h5>
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
						<?php $encodedValueId=base64_encode($serviceInfo[0]['service_id']); ?>
						<form class="needs-validation" name="frm_updateuser" id="frm_updateuser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Service/updateAddOnService/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        	 <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span>*</span>Parent Service</label>
												<select name="parent_service_id" id="parent_service_id" class="form-control  col-md-6" required onchange="showDiv(this)">

                                                    <option value="">Parent Service</option>
													<?php
                                                    foreach($ServiceList as $service){
                                                    ?>
                                                    <option value="<?php echo $service['service_id']?>" <?php if($serviceInfo[0]['parent_service_id']==$service['service_id']){ echo 'selected="selected"';}?>><?php echo $service['service_name']?></option>
													<?php } ?>
                                                    
												</select>
                                            </div>

                                             <div class="form-group row">
                                                <label for="servicefile" class="col-xl-3 col-md-4"><span>*</span> Service Image</label>
                                                <input class="form-control col-xl-4 col-md-4" id="servicefile" type="file" name="servicefile" />
												<div class="err_msg" id="err_banner_image"></div>
												<?php 
												$str_images = '';
												if($serviceInfo[0]['service_image']!="")
												{
												$str_images='<img src="'.$serviceInfo[0]['service_image'].'" style="width:50px;height:50px">';
												}?>
												<span><?php echo $str_images;?></span><br/>
												
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span><br/>
                                            </div>

                                            <div class="form-group row">
                                                <label for="service_name" class="col-xl-3 col-md-4"><span>*</span>Service Name</label>
                                                <input type="text" class="form-control  col-md-6" id="service_name" name="service_name"  required value="<?php echo $serviceInfo[0]['service_name'];?>">
												 <div id="err_service_name" class="error_msg"></div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4"><span>*</span> Description</label>
                                               <input type="textarea" name="description" id="description" class="form-control  col-md-6" required value="<?php echo $serviceInfo[0]['service_description'];?>">
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="service_price" class="col-xl-3 col-md-4"><span>*</span> Price</label>
                                                <input type="text" name="service_price" id="service_price" class="form-control  col-md-6"required value="<?php echo $serviceInfo[0]['service_price'];?>">
                                            </div>
                                             <div class="form-group row">
                                                <label for="service_discount_price" class="col-xl-3 col-md-4"><span>*</span> Discount Price</label>
                                                <input type="text" name="service_discount_price" id="service_discount_price" class="form-control  col-md-6"required value="<?php echo $serviceInfo[0]['service_discount_price'];?>">
                                            </div>
                                            
											<div class="form-group row">
                                                <label for="service_demo_price" class="col-xl-3 col-md-4">Demo Price</label>
                                                <input type="text" name="service_demo_price" id="service_demo_price" class="form-control  col-md-6"required value="<?php echo $serviceInfo[0]['service_demo_price'];?>">
                                            </div>
                                             <div class="form-group row">
                                                <label for="service_demo_discount_price" class="col-xl-3 col-md-4">Demo Discount Price</label>
                                                <input type="text" name="service_demo_discount_price" id="service_demo_discount_price" class="form-control  col-md-6"required value="<?php echo $serviceInfo[0]['service_demo_discount_price'];?>">
                                            </div>
											
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"><span></span>Status</label>
												<select name="status" id="status" class="form-control  col-md-6" required>
													<option value="">Select Status</option>
													<option value="Active" <?php if($serviceInfo[0]['service_status']=="Active"){ echo 'selected="selected"';}?>>Active</option>
													<option value="Inactive" <?php if($serviceInfo[0]['service_status']=="Inactive"){ echo 'selected="selected"';}?>>Inactive</option>
												</select>
                                            </div>

                                            <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Enter Options</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbody">
                                                        <?php 
                                                        if(!empty($optionList)){
                                                           
                                                        ?>
                                                        <tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td></td> <td></td>
															<td  class="text-center">
                                                                <button class="btn btn-md btn-success" id="addBtn" type="button"><i class="fa fa-plus"></i>
															    </button>
                                                            </td>
														</tr>
                                                        <?php
                                                         $i=1;
                                                        foreach($optionList as $option){
                                                        ?>
														<tr  id="<?php echo "R".$i?>">
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="text" class="form-control optionsArr" id="optionsArr" name="optionsArr[]" placeholder="Enter Option" value="<?php echo $option['option_name']?>" >
																<div id="err_optionsArr" class="error_msg err_optionsArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control amountArr" id="amountArr" name="amountArr[]" placeholder="Enter Amount"  value="<?php echo $option['option_amount']?>">
																<div id="err_amountArr" class="error_msg err_amountArr"></div>
															</td>
															<td  class="text-center">
                                                             <button class="btn btn-danger remove" type="button"><i class="fa fa-remove"></i></button>
                                                            </td>
														</tr>
                                                        <?php $i++; }  } else {?>
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

                                                        <?php } ?>
													</tbody>
													
												</table>
											</div>

                                            <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Add More option</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbodyLabel">
                                                        <?php 
                                                        if(!empty($labelList)){
                                                        ?>
                                                        <tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td></td> <td></td>
															<td  class="text-center">
                                                                <button class="btn btn-md btn-success" id="addRow" type="button"><i class="fa fa-plus"></i>
															    </button>
                                                            </td>
														</tr>
                                                        <?php
                                                         $i=1;
                                                        foreach($labelList as $label){
                                                        ?>
														<tr  id="<?php echo "R".$i?>">
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="text" class="form-control labelArr" id="labelArr" name="labelArr[]" placeholder="Enter Label" value="<?php echo $label['option_name']?>" >
																<div id="err_labelArr" class="error_msg err_labelArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control labelvalueArr" id="labelvalueArr" name="labelvalueArr[]" placeholder="Enter Value(ex.Yes,No)"  value="<?php echo $label['option_value']?>">
																<div id="err_labelvalueArr" class="error_msg err_labelvalueArr"></div>
															</td>
															<td  class="text-center">
                                                             <button class="btn btn-danger removeRow" type="button"><i class="fa fa-remove"></i></button>
                                                            </td>
														</tr>
                                                        <?php $i++; }  } else {?>
                                                            <tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="text" class="form-control labelArr" id="labelArr" name="labelArr[]" placeholder="Enter Label"  >
																<div id="err_labelArr" class="error_msg err_labelArr"></div>
															</td>
                                                            <td> <input type="text" class="form-control labelvalueArr" id="labelvalueArr" name="labelvalueArr[]" placeholder="Enter Value(ex.Yes,No)"  >
																<div id="err_labelvalueArr" class="error_msg err_labelvalueArr"></div>
															</td>
															<td  class="text-center"><button class="btn btn-md btn-success" id="addRow" type="button">
															<i class="fa fa-plus"></i>
															</button></td>
														</tr>

                                                        <?php } ?>
													</tbody>
													
												</table>
											</div>
                                            

                                            <div class="form-group row">
                                            	<div class="offset-xl-3 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_uptuser" id="btn_uptuser">Update</button>
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
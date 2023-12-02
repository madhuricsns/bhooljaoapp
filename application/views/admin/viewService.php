<div class="page-body">
<?php //print_r($serviceinfo); exit; ?>
	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>SERVICE DETAILS</h5>
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
						<?php }
						// print_r($serviceinfo);
						?>
						<form class="needs-validation" name="frm_adduser" id="frm_adduser" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Service/addService">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">

                                        	 <div class="form-group row">
                                                <label class="col-xl-3 col-md-4"> 
													<img src="<?php echo $serviceinfo[0]['service_image']?>" width="80px"> 
												</label>
												<div class="col-md-6">
													
												</div>
                                            </div>

											<div class="form-group row">
                                                <label class="col-xl-3 col-md-4">  Category</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['category_name']?>
												</div>
                                            </div>

											
                                            <div class="form-group row">
                                                <label for="full_name" class="col-xl-3 col-md-4"> Service Name</label>
                                                <div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_name']?>
												</div>
                                            </div>
											
											<div class="form-group row">
                                                <label for="email_address" class="col-xl-3 col-md-4">  Description</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_description']?>
												</div>
                                            </div>
                                           
                                            <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">  Price</label>
                                                <div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_price']?>
												</div>
                                            </div>
                                             <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">  Discount Price</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_discount_price']?>
												</div>
                                            </div>
											<div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">  Offer Percentage</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['offer_percentage']?>
												</div>
                                            </div>
											<div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">  Demo Price</label>
                                                <div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_demo_price']?>
												</div>
                                            </div>
                                             <div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">  Demo Discount Price</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_demo_discount_price']?>
												</div>
                                            </div>
											<div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">Status</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_status']?>
												</div>
                                            </div>
											<div class="form-group row">
                                                <label for="mobile_number" class="col-xl-3 col-md-4">  Option Label Name</label>
												<div class="col-md-6">
													: <?php echo $serviceinfo[0]['service_option_name']?>
												</div>
                                            </div>
                                            
                                            <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"> Options</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
													<tbody id="tbody">
														<tr>
															<th> Option</th>
<th> Option Type</th>
<th> Amount</th>
														</tr>
														<?php
                                                         $i=1;
                                                        foreach($optionList as $option){
                                                        ?>
														<tr  id="<?php echo "R".$i?>">
															<!-- <td  class="row-index text-center"></td> -->
															<td> <?php echo $option['option_name']?></td>
<td> <?php echo $option['option_type']?></td>
<td><?php echo "₹".$option['option_amount']?></td>
														</tr>
                                                        <?php $i++; }  ?>
													</tbody>
													
												</table>
											</div>

											<div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"> More option</label>
                                                
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbodyLabel">
                                                        
                                                        <?php
                                                         $i=1;
                                                        foreach($labelList as $label){
                                                        ?>
														<tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td><?php echo $label['option_name']?></td>
                                                            <td><?php echo $label['option_value']?></td>
														</tr>
                                                        <?php $i++; } ?>
                                                            
													</tbody>
													
												</table>
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

<div class="page-body">
	<!-- Container-fluid starts-->
	
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>Add Multi Service Images</h5>
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
						
					<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Service/addmultiple_images/<?php echo base64_encode($service_id) ;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    
                                        <div class="col-sm-12">
                                        	
                                        	 
                                             
                                           <input type="hidden" class="form-control  col-md-6" id="service_id" name="service_id"  value="<?php echo $service_id;?>">
												
                                           <!-- <div class="row">
											
											<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="service_image" ><span>*</span> Service Multi Images</label>
                                        <input class="form-control " id="service_image" type="file"  name="service_image[]"  multiple="multiple"/>
                                                <div class="error_msg" id="err_service_image"></div>
												<span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span>
												
                                            </div>
                                        </div>
                                    </div> -->
                                           
                                     <div class="form-group row" id="show-div">
												<label class="col-xl-3 col-md-4"><span>*</span> Service Multi Images</label>
                                               
												<table class="table1 col-md-6 " style="width:100%;max-width: 100%;border-collapse: collapse;    display: table;">
												
													<tbody id="tbody">

														

														<tr>
															<!-- <td  class="row-index text-center"></td> -->
															<td> <input type="file" class="form-control optionsArr" id="service_image" name="service_image[]"   >
																<div id="err_optionsArr" class="error_msg err_optionsArr"></div>
															</td>
                                                           
															 <td  class="text-center"><button class="btn btn-md btn-success" id="addimagesBtn" type="button">
															<i class="fa fa-plus"></i> 
															</button> </td>
														</tr>
													</tbody>
													
												</table>
												 <span style="color:red">Note:Upload only jpg|png|bmp|jpeg</span>
											</div>

                                        		

									<div class="pull-right">
										<button type="submit" class="btn btn-primary" name="btn_addmultipleimages" id="btn_addmultipleimages">Add</button>
										<a href="<?php echo base_url();?>backend/Banners/manageBanner" class="btn btn-primary" >Cancel</a>
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
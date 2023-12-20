<div class="page-body">
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
	<!-- Container-fluid starts-->
	<div class="container-fluid">
	<?php if(isset($groupInfo) && count($groupInfo)>0)									
			{ //print_r($groupInfo); //print_r($orderInfo);?>
                <div class="row">
                    <!-- Service Provider Basic details -->
                    
                    <div class="col-sm-6">
                    <div class="card tab2-card">
                            <div class="card-header" style="background-color: #9cabfb;">
							<h5 style="color: #121111;"><i  class="fa fa-user-circle" ></i> Group Info </h5>
                            </div>
                        <div class="card-body">
							
							<?php
							if(isset($groupInfo) && count($groupInfo)>0 )									
							{
                                // print_r($groupInfo);
							?>
                                <div class="tab-content" id="myTabContent">
                                    <div class="active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                        <div class="booking_details row">
											<div class="col-sm-12">

												<div class="form-group row">
													<label class="col-xl-4 col-md-4">  Category</label>
													<div class="col-md-8">
														: <?php echo $groupInfo[0]['category_name']?>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-xl-4 col-md-4">  Group</label>
													<div class="col-md-8">
														: <?php echo $groupInfo[0]['group_name']?>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-xl-4 col-md-4">  Status</label>
													<div class="col-md-8">
														: <?php echo $groupInfo[0]['group_status']?>
													</div>
												</div>
												
												

												<div class="table-responsive mt-3">
				                                    <table class="table ">
														<?php
														$spList=$this->Group_model->getGroupSP($groupInfo[0]['group_id'],1);
														// echo $this->db->last_query();
														?>
				                                        <tbody>
				                                           <?php
															$serviceproviderArr =array();
															// $serviceproviderArr = explode(",",$weekendArr) ;
														   foreach($spList as $sp){
															$serviceproviderArr[]=$sp['service_provider_id'];
														   ?>                                                
				                                            <tr>
				                                                <td><i class="fa fa-user"></i> <?php echo $sp['full_name'];?></td>
				                                            </tr>
															<?php } ?>

				                                        </tbody>
				                                    </table>
				                                </div>
											</div>
										</div>
									</div>
								</div>
								<?php }  ?>
								 
                            </div>
                        </div>

                    </div>
				
                
                
					<div class="col-sm-6">
                        <div class="card tab2-card">
                            <div class="card-header" style="background-color: #ded9d9">
                                <h5 style="color: #121111;"> Update Service Provider List </h5>
                            </div>
                            <div class="card-body">
							<form class="needs-validation" name="frm_addbanner" id="frm_addbanner" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Group/ViewGroup/<?php echo base64_encode($groupInfo[0]['group_id']); ?>">
								<div class="tab-content" >
									<div class="tab-pane fade active show">
										<div class="row">
											
											<div class="form-group  col-md-12">
												<input type="hidden" name="group_id" value="<?php echo $groupInfo[0]['group_id'];?>">
                                                 <label for="category_id"> Service Providers </label>
												<select name="sp_ids[]" id="sp_id" class="form-control select2" multiple required>
													<option value="">Select  </option>
													<?php
													$serviceproviders=$this->Group_model->getAllServiceproviders($groupInfo[0]['group_category_id'],1);
													// echo $this->db->last_query();
														// $spArr=explode(",",$serviceproviderArr);
                                                    foreach($serviceproviders as $servicegiver){
                                                    ?>
                                                    <option value="<?php echo $servicegiver['user_id']?>" <?php echo (isset($serviceproviderArr) && in_array($servicegiver['user_id'], $serviceproviderArr) ) ? "selected" : "" ?>><?php echo $servicegiver['full_name']?></option>
													<?php } ?>
												</select>
												<div id="err_category_id" class="error_msg"></div>
                                            </div>

											<div class="pull-right  col-md-12">
													<button type="submit" class="btn btn-primary" name="btn_addsp" id="btn_addsp">Update</button>

											</div>
										</div>
									</div>
								</div>
							</form>

							
                            </div>
                        </div>

                    </div>
                </div>
                
				<?php } else 
				{?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
				</div>									
				<?php }?>
            </div>
	<!-- Container-fluid Ends-->
</div>

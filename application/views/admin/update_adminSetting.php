<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>UPDATE SETTING</h5>
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
						<?php $encodedValueId=base64_encode($SettingInfo[0]['setting_id']); ?>
						<form class="needs-validation" name="frm_updatecity" id="frm_updatecity" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Setting/updateSetting/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">

                                       <div class="row">
                                           <div class="col-md-6">
                                           	<label><span></span>Date</label><br>
                                            <div class="form-group ">
                                            	<?php
                                            	foreach($SettingInfo as $setting)
										{
											?>		
                                                <input type="text" class="form-control " readonly id="commission_type" value="<?php echo $setting['commission_type'];?>" >
												<?php }?>
                                            </div>
                                        </div>
                                  
                                     <div class="col-md-6">
                                           	<label><span></span>Assing Time</label><br>
                                            <div class="form-group ">
                                            	
                                                <input type="text" id="commission" class="form-control "name="commission" value="<?php echo $setting['commission'];?>" >
												
                                            </div>
                                        </div>
                                    </div>
				  								

                				





                	                            <div class="form-group row">
                                            	<div class="offset-xl-9 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_upsettig" id="btn_upsettig">Update</button>
													<a href="<?php echo base_url();?>backend/Setting/manageSetting" class="btn btn-primary" >Cancel</a>
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
$('#timepicker1').timepicker({
             format : 'hh:mm a'   
        }); 	
</script>

<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5>ASSIGN DATE TIME</h5>
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
						<?php $encodedValueId=base64_encode($bokingInfo[0]['booking_id']); ?>
						<form class="needs-validation" name="frm_updatecity" id="frm_updatecity" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Booking/AssingDateTime/<?php echo $encodedValueId;?>">
                        <div class="tab-content" >
                            <div class="tab-pane fade active show">
                                    <div class="row">
                                        <div class="col-sm-12">

                                       <div class="row">
                                           <div class="col-md-6">
                                           	<label><span></span>Date</label><br>
                                            <div class="form-group ">
                                            	<?php
                                            	foreach($bokingInfo as $booking)
										{
                                             $booking['booking_date']= new DateTime($booking['booking_date']);
                                            $booking['booking_date']=$booking['booking_date']->format('d-M-Y');
											?>		
                                                <input type="text" class="form-control " readonly id="servicefile" value="<?php echo $booking['booking_date'];?>" >
												<?php }?>
                                            </div>
                                        </div>
                                  
                                     <div class="col-md-6">
                                           	<label><span></span>Assing Time</label><br>
                                            <div class="form-group ">
                                            	
                                                <input type="time" id="timepicker1" class="form-control "name="assingtime" >
												
                                            </div>
                                        </div>
                                    </div>
				  								

                				





                	                            <div class="form-group row">
                                            	<div class="offset-xl-9 offset-sm-4">
						                            <button type="submit" class="btn btn-primary" name="btn_upAssing" id="btn_uptcity">Assign</button>
													<a href="<?php echo base_url();?>backend/Booking/manageBookingDemo" class="btn btn-primary" >Cancel</a>
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

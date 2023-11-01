<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
	<?php if(isset($userinfo) && count($userinfo)>0)									
			{ //print_r($userinfo); //print_r($orderInfo);?>
                <div class="row">
                    <!-- Service Provider Basic details -->
                    
                    <div class="col-sm-4">
                    <div class="card tab2-card">
                            <div class="card-header" style="background-color: #9cabfb;">
							<h5 style="color: #121111;"><i  class="fa fa-user-circle" ></i> Service Provider Info </h5>
                            </div>
                        <div class="card-body">
							<?php
							 if(isset($userinfo) && count($userinfo)>0 )									
							{
                                //print_r($orderInfo);
							?>
                                <div class="tab-content" id="myTabContent">
								
                                    <div class="active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                       
                                        <div class="booking_details row">
										
											<div class="col-sm-12">
												<h4>
												<?php if(isset($userinfo[0]['profile_pic']) && $userinfo[0]['profile_pic']!=""){ ?>
													<img src="<?php echo base_url()."./uploads/service_provider/".$userinfo[0]['profile_pic']?>" width="30px" height="30px" style="border-radius:100%">
													<?php } else { ?>
														<img src="<?php echo base_url()?>./uploads/service_provider/default.png" alt="" class="rounded-circle" width="32" height="32">
													<?php } ?>
													<?php  echo $userinfo[0]['full_name'];?>
												</h4>

												<p class="info"><i class="fa fa-envelope"></i> <?php echo $userinfo[0]['email'];?></p>
												<p class="info"><i class="fa fa-phone"></i> <?php echo $userinfo[0]['mobile'];?></p>
												<p class="info"><i class="fa fa-user"></i> <?php echo $userinfo[0]['gender'];?></p>
												<p class="info"><i class="fa fa-map-marker"></i> <?php echo $userinfo[0]['address'];?></p>
											</div>
										</div>
									</div>
								</div>
								<?php }  ?>
								 
                            </div>
                        </div>

                    </div>
				
                
                
					<div class="col-sm-8">
                        <div class="card tab2-card">
                            <div class="card-header" style="background-color: #ded9d9">
                                <h5 style="color: #121111;"> Booking List </h5>
                            </div>
                            <div class="card-body">


							<?php
							// echo "<pre>";
							// print_r($bookingList);
							// exit();
							 if(isset($bookingList) && count($bookingList)>0)									
							{
							?>
								
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped mb-0" id="datatable-default">
                                                <thead>
                                                    <tr>
                                                        <th>Order No</th>
                                                        <th>Booking Date</th>
                                                        <th>Time</th>
                                                        <th>Service Name</th>
                                                        <th>Customer</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>	
                                                    </tr>
                                                </thead>	
                                                <tbody>			
                                                    <?php 
                                                    foreach($bookingList as $booking)
                                                    {
                                                        $booking['booking_date']= new DateTime($booking['booking_date']);
                                                        $booking['booking_date']=$booking['booking_date']->format('d-M-Y');
                                                        ?>		
                                                    <tr>
                                                            <td><?php echo $booking['order_no'];?></td>
                                                            <td><?php echo $booking['booking_date'];?></td>
                                                            <td><?php echo $booking['time_slot'];?></td>
                                                            <td><?php echo $booking['category_name'];?></td>
                                                            <td><?php echo $booking['full_name'];?></td>
                                                            <td><?php echo $booking['booking_status'];?></td>
                                                            <td class="actions">
                                                                <a href="<?php echo base_url();?>backend/Booking/viewBookingDetails/<?php echo base64_encode($booking['booking_id']);?>"><i data-feather="eye"></i></a>
                                                        </td>				
                                                        </tr>											
                                                        <?php  }?>
                                                </tbody>									
                                            </table>
                                            <div class="dataTables_paginate paging_simple_numbers" id="datatable-default_paginate" style="margin-top:10px;">
                                                <?php //echo $links; ?>
                                            </div>	
											
											
                                        
                                </div>
								<?php } else 
								{?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>
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

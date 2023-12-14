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
												<div class="profile-details text-center" style="background-color:transparent;">
												<?php if(isset($userinfo[0]['profile_pic']) && $userinfo[0]['profile_pic']!=""){ ?>
													<img src="<?php echo base_url()."./uploads/user_profile/".$userinfo[0]['profile_pic']?>" class="img-fluid img-90 rounded-circle  lazyloaded">
													<?php } else { ?>
														<img src="<?php echo base_url()?>./uploads/user_profile/default.png" alt="" class="img-fluid img-90 rounded-circle  lazyloaded">
													<?php } ?>
													<h5 class="f-w-600 mb-0"><?php  echo $userinfo[0]['full_name'];?></h5>
												</div>

												<div class="table-responsive mt-3">
				                                    <table class="table ">
				                                        <tbody>
				                                                                                           
				                                            <tr>
				                                                <td><i class="fa fa-id-card"></i> <?php echo $userinfo[0]['profile_id'];?></td>
				                                            </tr>
															<tr>
				                                                <td><i class="fa fa-envelope"></i> <?php echo $userinfo[0]['email'];?></td>
				                                            </tr>
				                                            <tr>
				                                                <td><i class="fa fa-phone"></i> <?php echo $userinfo[0]['mobile'];?></td>
				                                            </tr>                                                
				                                            
				                                            <tr>
				                                                <td><i class="fa fa-user"></i> <?php echo $userinfo[0]['gender'];?></td>
				                                            </tr>
				                                            <tr>
				                                                <td><i class="fa fa-map-marker"></i> <?php echo $userinfo[0]['address'];?></td>
				                                            </tr>
				                                            <tr>
				                                                <td><i class="fa fa-area-chart"> Zone :-</i> <?php echo $userinfo[0]['zone_name'];?></td>
				                                            </tr>
				                                            <tr>
				                                                <td><i class="fa fa-list-alt"> Category :-</i> <?php echo $userinfo[0]['category_name'];?></td>
				                                            </tr>
															<style>.checked {  color: orange;} .unchecked {  color: gray;}
															/* The bar container */
																.bar-container {
																width: 100%;
																/* background-color: #f1f1f1; */
																/* text-align: center; */
																/* color: white; */
																}
																.bar-container-label {
																width: 20%;
																float: left;
																height: 15px ;
																}
																.bar-container-rating {
																width: 80%;
																background-color: #f1f1f1;
																text-align: center;
																color: white;
																float: right;
																height: 15px 
																}
															</style>
															<tr>
				                                                <td><span style="background-color: #1fed1f;padding: 3px;"><?php echo $rating_avg;?></span>
																<?php if($rating_avg==0) { ?> 
																<i class="fa fa-star unchecked"></i><i class="fa fa-star unchecked"></i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i>
																<?php } if($rating_avg>=1 && $rating_avg<2) { ?> 
																<i class="fa fa-star checked"></i> <i class="fa fa-star "></i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i>
																<?php } if($rating_avg>=2 && $rating_avg<3) { ?>
																	<i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i>
																<?php } if($rating_avg>=3 && $rating_avg<4) {?>
																	<i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star unchecked"> </i><i class="fa fa-star unchecked"> </i>
																<?php } if($rating_avg>=4 && $rating_avg<5) {?>
																	<i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star unchecked"></i>
																<?php } if($rating_avg>=5 ) {?>
																	<i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i><i class="fa fa-star checked"> </i>
																<?php } ?>
																<?php echo $total_rating;?> Rating
																<br><br>
																<div class="bar-container"><div class="bar-container-label">5 Star</div><div class="bar-container-rating"><div style="width:<?php echo $star5;?>%;height: 15px ; background-color: #04AA6D;">&nbsp;</div></div></div><br>
																<div class="bar-container"><div class="bar-container-label">4 Star</div><div class="bar-container-rating"><div style="width:<?php echo $star4;?>%;height: 15px ; background-color: #2196F3;">&nbsp;</div></div></div><br>
																<div class="bar-container"><div class="bar-container-label">3 Star</div><div class="bar-container-rating"><div style="width:<?php echo $star3;?>%;height: 15px ; background-color: #00bcd4;">&nbsp;</div></div></div><br>
																<div class="bar-container"><div class="bar-container-label">2 Star</div><div class="bar-container-rating"><div style="width:<?php echo $star2;?>%;height: 15px ; background-color: #ff9800;">&nbsp;</div></div></div><br>
																<div class="bar-container"><div class="bar-container-label">1 Star</div><div class="bar-container-rating"><div style="width:<?php echo $star1;?>%;height: 15px ; background-color: #f44336;">&nbsp;</div></div></div>
															
																</td>

				                                            </tr>
															

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

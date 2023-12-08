<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
	<?php if(isset($orderInfo) && count($orderInfo)>0)									
			{ //print_r($orderInfo); print_r($orderInfo);?>
                <div class="row">
                    <!-- Service Provider Basic details -->
                    <div class="col-sm-12">
                        <div class="card tab2-card">
							<div class="card-header" style="background-color:white">
								<div class="row">
								<div class="col-md-3">
									<h5 style="color: #121111;padding-top: 10px;"><span style="font-weight: 500;">Order No : </span><label><?php if(isset($orderInfo[0]['order_no'])) echo $orderInfo[0]['order_no'];?></label>
									</h5>
								</div>
								<div class="col-md-5">
								
								</div>
								<div class="col-md-4" style="text-align:right">
									<h5 style="color: #121111;padding-top: 10px;"><span style="font-weight: 500;">Placed order : </span><label> <?php
										$orderInfo[0]['dateadded']=new DateTime($orderInfo[0]['dateadded']);
										$orderdate=$orderInfo[0]['dateadded']=$orderInfo[0]['dateadded']->format('M d,Y H:i:s');
										echo $orderdate;
										?></label>
									</h5>
								</div>
								</div>
							</div>
						</div>
					
					</div>

					<div class="col-sm-8">
                        <div class="card tab2-card">
                            <div class="card-header" style="background-color: #9cabfb;">
                                <h5 style="color: #121111;"> Booking Details </h5>
                            </div>
                            <div class="card-body">
							<?php
							 if(isset($orderInfo) && count($orderInfo)>0 && isset($orderInfo) && count($orderInfo)>0)									
							{
							?>
                                <div class="tab-content" id="myTabContent">
								
                                    <div class="tab-pane fade active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                       
                                        <div class="booking_details row">
											<div class="col-sm-3">
												<?php if(isset($orderInfo[0]['service_image'])) { ?>
												<img src="<?php  echo base_url()."uploads/service_img/".$orderInfo[0]['service_image']?>" class="img-fluid">
												<?php } else { ?>
												<img src="<?php  echo base_url()."template/admin/assets/images/avatar.jpg";?>" width="80px">
												<?php } ?>
											</div>
											<div class="col-sm-6">
												<h4><?php  echo $orderInfo[0]['category_name'];?></h4>

												<p><?php echo strtoupper($orderInfo[0]['booking_status']);?>
													<?php if($orderInfo[0]['booking_status']=='ongoing') { echo "- ".strtoupper($orderInfo[0]['booking_sub_status']); } ?>
												</p>
												<?php /* if($orderInfo[0]['service_category_id']=='3' ) { ?>
												<p><i class=""></i> Service Hrs : <?php echo $category->category_duration." Min";?></p>
												<?php } else { ?>
												<p><i class=""></i> Service Hrs : <?php echo $orderInfo[0]['no_of_hourse']." Hrs";?></p>
												<?php } */ ?>
												<p><i class=""></i> Date : <?php 
												$orderInfo[0]['booking_date']=new DateTime($orderInfo[0]['booking_date']);
												$booking_date=$orderInfo[0]['booking_date']=$orderInfo[0]['booking_date']->format('M d,Y');
												echo $booking_date;?>
												</p>
												<p><i class="fa fa-clock-o"></i> <?php echo $orderInfo[0]['time_slot'];?></p>
												<p>Expiry Date: <?php $expiry_date = '';
												if(isset($orderInfo[0]['expiry_date'])) { $orderInfo[0]['expiry_date']=new DateTime($orderInfo[0]['expiry_date']);
												$expiry_date=$orderInfo[0]['expiry_date']=$orderInfo[0]['expiry_date']->format('M d,Y'); }
												echo $expiry_date;?></p>
												<!-- <p> <i class="fa fa-map-marker"></i> Pickup : <?php //echo $orderInfo[0]['pickup_location'];?> </p> -->
												<!-- <p> <i class="fa fa-map-marker"></i> Drop : <?php //echo $orderInfo[0]['drop_location'];?> </p> -->
											</div>
											<div class="col-sm-3" style="text-align: right;">
												<label>Rs.<?php echo $orderInfo[0]['total_booking_amount'];?></label>
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
                        </div>

						<div class="card tab2-card">
                            <div class="card-header" style="background-color: white;">
                                <h5 style="color: #121111;"><i class="fa fa-credit-card"></i> Payment Info 
								<button class="btn btn-sm pull-right" style="padding:5px"><?php 
								//print_r($orderInfo);
								$discount="";
									if($orderInfo[0]['coupon_id']>0)
									{
										$promocode=$this->Booking_model->getPromocodeDetails($orderInfo[0]['coupon_id'],1); 
										if($promocode[0]['promocode_type']=='Fixed Price')
										{
											$discount.="( Discount Amount ".$promocode[0]['promocode_discount']." , Promo code - ".$promocode[0]['promocode_code']." )";
										}
										else if($promocode[0]['promocode_type']=='Percentage')
										{
											$discount.="( Discount ".$promocode[0]['promocode_discount']."% OFF  , Promo code - ".$promocode[0]['promocode_code']." )";
										}
									}
									// echo $orderInfo[0]['order_status'];
									
									?></button>
							</h5>
                            </div>
                            <div class="card-body">
							<table width="100%">
							<tr>
							<td colspan="2">
							<strong>Payment Method:</strong> </td>
							<td style="text-align:right"><?php 
							echo $orderInfo[0]['payment_type']; ?></td>
							</tr>
							<tr>
							<td colspan="2">
							<strong>Location: </strong></td>
							<td style="text-align:right"> <?php 
							echo $addressDetails->address1;
							?></td>
							</tr>
							<tr>
							<td colspan="2">
							<strong>Service Duration: </strong></td>
							<td style="text-align:right"><?php 
							echo $orderInfo[0]['duration']; ?></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
							<td>
<?php  echo $orderInfo[0]['category_name'];?>
							</td>
							</tr>
						<?php
							if(isset($servicePricing) && count($servicePricing) > 0) {
								foreach($servicePricing as $service) 
								{ ?>
								<tr>
								<td><?php echo $service['service_name'].' </td>';
								
								echo '<td>'.$service['option_label'].':</td><td> '.$service['option_value'].'</td>'; ?> 
								</tr>
							<?php }
							}
							?>
						<?php //print_r($serviceDetails);exit;
							if(isset($serviceDetails) && count($serviceDetails) > 0) {
								foreach($serviceDetails as $service) 
								{ 
								if($orderInfo[0]['is_demo'] == 'Yes') {
									$duration[0] = 0;
								} else {
								$duration=str_split($service['duration']); }
								?>
								<tr><td>
								<?php echo $service['service_name'];?>
								</td><td style="text-align:center;"> 
								<?php echo $service['option_amount'].' * '.$duration[0]; ?> 
								</td><td style="text-align:right">
								<?php echo $service['option_amount'] * $duration[0]; ?></td></tr>
							<?php }
							}
							?>
							</tr>
							<tr><td>&nbsp;</td></tr>
							</table>
							<?php
							 if(isset($orderInfo) && count($orderInfo)>0 && isset($orderInfo) && count($orderInfo)>0)									
							{
                               // print_r($orderInfo);
							?>
                                <div class="tab-content" id="myTabContent">
								
                                    <div class="tab-pane fade active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                       
                                        <div class="booking_details row">
										
											<div class="col-sm-12 payment-dtl">
												<p><strong><b>Total Amount</b></strong>  <?php //echo "HK$".$orderInfo[0]['booking_amount'].")";  ?>
												<span>Rs.<?php echo $orderInfo[0]['booking_amount'];?></span>	
												</p>
												<p><strong>Discount</strong>
												<?php if(isset($orderInfo[0]['coupon_code']) && $orderInfo[0]['coupon_code']!="") echo "(Coupon Code : ".$orderInfo[0]['coupon_code'].")";?> 
												 <span>Rs.<?php echo $orderInfo[0]['coupon_amount'];?></span><br></p>
												 <p><strong>Service tax</strong>
												<?php if(isset($orderInfo[0]['admin_commision']) && $orderInfo[0]['admin_commision']!="") //echo "(Coupon Code : ".$orderInfo[0]['coupon_code'].")";?> 
												 <span>Rs.<?php echo $orderInfo[0]['admin_commision'];?></span><br></p>
												  <p><strong>GST 18%</strong>
												<?php if(isset($orderInfo[0]['gst_amount']) && $orderInfo[0]['gst_amount']!="")// echo "(Coupon Code : ".$orderInfo[0]['gst_amount'].")";?> 
												 <span>Rs.<?php echo $orderInfo[0]['gst_amount'];?></span><br></p>
												<p><strong><b>Paid Amount</b></strong><span><strong>Rs.<?php echo $orderInfo[0]['total_booking_amount'];?></strong></span></p>
											</div>
											
										    </div>
                                        </div>
                                    </div>
								<?php }  ?>
								 
                            </div>
                        </div>
<?php if(count($workHistory) > 0) { ?>						
						<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Work History </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								
							</div>
							</div>
						</div>	 
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Sr.No</th>
											<th>Description</th>
											<th>Date</th>
											<th>Time</th>
											<th>Status</th>
											<th>Work Photo1</th>	
											<th>Work Photo2</th>
										</tr>
									</thead>	
									<tbody>			
										<?php 
										$i=1;
										foreach($workHistory as $history)
										{
											
											?>		
										<tr>
												<td><?php echo $i ;?></td>
												
												
												<td><?php echo $history['history_description'];?></td>
												<td><?php 
if($history['history_date'] == 0) echo "---"; else {
				
				$history['history_date']=new DateTime($history['history_date']);
										$historydate = $history['history_date']->format('d-m-Y');
echo $historydate; }?></td>
												<td><?php echo $history['history_time'];?></td>
												<td><?php echo $history['booking_status'];?></td>												
												<td><img src="<?php echo base_url().'/uploads/work_history/'.$history['work_photo1'];?>" style="width:80px;height:80px" /></td>												
												<td><img src="<?php echo base_url().'/uploads/work_history/'.$history['work_photo2'];?>" style="width:80px;height:80px" /></td>												
											</tr>											
											<?php $i++; }?>
									</tbody>									
								</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
	 
	
</div>

<?php } ?>


<?php if(count($transactionHistory) > 0) { ?>						
						<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Transaction History </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								
							</div>
							</div>
						</div>	 
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Sr.No</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Transaction Id</th>
											<th>Status</th>
										</tr>
									</thead>	
									<tbody>			
										<?php 
										$i=1;
										foreach($transactionHistory as $transhistory)
										{
											
											?>		
										<tr>
												<td><?php echo $i ;?></td>
												
												
												<td><?php $transhistory['dateadded']=new DateTime($transhistory['dateadded']);
										$transdate=$transhistory['dateadded']->format('d-m-Y');
												
												echo $transdate;
												?></td>
												<td><?php echo $transhistory['paid_amount'];?></td>
												<td><?php echo $transhistory['transaction_id'];?></td>
												<td><?php echo $transhistory['payment_status'];?></td>												
											</tr>											
											<?php $i++; }?>
									</tbody>									
								</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
	 
	
</div>

<?php } ?>
						
                    </div>

					<div class="col-sm-4">
                        <div class="card tab2-card">
                            <div class="card-header" style="background-color: white;">
							<h5 style="color: #121111;"><i data-feather="user"></i> Customer Info </h5>
                            </div>
                            <div class="card-body">
							<?php
							 if(isset($orderInfo) && count($orderInfo)>0 && isset($orderInfo) && count($orderInfo)>0)									
							{
                                //print_r($orderInfo);
							?>
                                <div class="tab-content" id="myTabContent">
								
                                    <div class="active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                       
                                        <div class="booking_details row">
										
											<div class="col-sm-12">
												<h4>
													<?php if(isset($orderInfo[0]['profile_pic']) && $orderInfo[0]['profile_pic']!=""){ ?>
													<img src="<?php echo base_url()."uploads/user_profile/".$orderInfo[0]['profile_pic']?>" width="30px" height="30px" style="border-radius:100%">
													<?php } else { ?>
														<img src="<?php echo base_url()?>uploads/user_profile/user.jpg" alt="" class="rounded-circle" width="32" height="32">
													<?php } ?>
													<?php  echo $orderInfo[0]['full_name'];?>
												</h4>

												<p class="info"><i class="fa fa-envelope"></i> <?php echo $orderInfo[0]['email'];?></p>
												<p class="info"><i class="fa fa-phone"></i> <?php echo $orderInfo[0]['mobile'];?></p>
											</div>
										</div>
									</div>
								</div>
								<?php }  ?>
								 
                            </div>
                        </div>


						<div class="card tab2-card">
                            <div class="card-header" style="background-color: white;">
                                <h5 style="color: #121111;"><i class="fa fa-user-circle-o"></i>  Service Provider Info </h5>
                            </div>
                            <div class="card-body">
						
								<div class="tab-content" id="myTabContent">
								
									<div class="active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
									
										<div class="booking_details row">
										
											<div class="col-sm-12">
												<?php
												if($orderInfo[0]['service_provider_id']>0 ){
												$user=$this->Booking_model->getServiceproviderDetails($orderInfo[0]['service_provider_id'],1);
												?>
													<h4>
														<?php if(isset($user[0]['profile_pic']) && $user[0]['profile_pic']!="") { ?>
														 <img src="<?php echo base_url()."uploads/user_profile/".$user[0]['profile_pic']?>" width="30px" height="30px" style="border-radius:100%">
													<?php } else { ?>
														 <img src="<?php echo base_url()?>uploads/user_profile/user.jpg" alt="" class="rounded-circle" width="32" height="32">
													<?php } ?>
														 <?php if(isset($user[0]['full_name'])) echo $user[0]['full_name'];?> 
													</h4> 
													<p class="info"><i class="fa fa-envelope"></i> <?php if(isset($user[0]['email'])) echo $user[0]['email'];?> </p>
													<p class="info"><i class="fa fa-phone"></i> <?php if(isset($user[0]['mobile'])) echo $user[0]['mobile'];?> </p>
												<?php } else { ?>
													<p class="info error_msg"><i class="fa fa-warning"></i> Not available service provider because booking status  still waiting</p>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								

								

								
							 
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-sm-12">
                        		<!--<a class="btn btn-primary custom-btn btn-block" target="_blank" href="<?php //echo site_url('backend/Booking/generatepdf/'.base64_encode($orderInfo[0]['booking_id']));?>">
									View Invoice</a>-->
                        	</div>
                        </div>
                    </div>
					<?php /*
					<div class="col-md-10">
						<div class="card tab2-card">
                            <div class="card-header" style="background-color: white;">
                                <h5 style="color: #121111;">Order Status </h5>
                            </div>
                            <div class="card-body">
							<?php
							 if(isset($orderInfo) && count($orderInfo)>0 && isset($orderInfo) && count($orderInfo)>0)									
							{
                                //print_r($orderInfo);
							?>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="basicinfo" role="tabpanel" aria-labelledby="basicinfo-tab">
                                        <div class="form-group row">
										
											<div class="col-sm-12">
									
												<div class="row justify-content-between">
													<?php
													$orderInfo[0]['booking_date']=new DateTime($orderInfo[0]['booking_date']);
													$orderInfo[0]['booking_date']=$orderInfo[0]['booking_date']->format('d M Y');
													?>
													<div class="order-tracking completed">
														<span class="is-complete"></span>
														<p>Ordered<br><span><?php echo $orderInfo[0]['booking_date'];?></span></p>
													</div>
													<?php 
													foreach($historyInfo as $history)
													{
														$history['history_date']=new DateTime($history['history_date']);
														$history['history_date']=$history['history_date']->format('d M Y H:i:s');
													?>
													<div class="order-tracking completed">
														<span class="is-complete"></span>
														<p><?php echo ucfirst($history['booking_status']);?><br>
														<span><?php echo $history['history_date'];?></span></p>
													</div>
													<?php } 
													if($history['booking_status']=='accepted')
													{ 
													?>
													<div class="order-tracking completed">
														<span class="is-complete"></span>
														<p>Accepted<br><span>Tue, June 25</span></p>
													</div>
													<?php } ?>
													<?php if($history['booking_status']=='ongoing')
													{ ?>
													<div class="order-tracking ">
														<span class="is-complete"></span>
														<p>Ongoing<br><span>Tue, June 25</span></p>
													</div>
													<?php } ?>
													<?php if($history['booking_status']=='accepted')
													{ ?>
													<div class="order-tracking ">
														<span class="is-complete"></span>
														<p>Start Journey<br><span>Tue, June 25</span></p>
													</div>
													<?php } ?>
													<?php if($history['booking_status']=='accepted')
													{ ?>
													<div class="order-tracking ">
														<span class="is-complete"></span>
														<p>Reached<br><span>Tue, June 25</span></p>
													</div>
													<?php } ?>
													<?php if($history['booking_status']=='accepted')
													{ ?>
													<div class="order-tracking ">
														<span class="is-complete"></span>
														<p>Start Service<br><span>Tue, June 25</span></p>
													</div>
													<?php } ?>
													<?php if($history['booking_status']=='accepted')
													{ ?>
													<div class="order-tracking">
														<span class="is-complete"></span>
														<p>Completed<br><span>Fri, June 28</span></p>
													</div>
													<?php }  ?>
												</div>
											</div>
											
											
										</div>
									</div>
								</div>
								<?php }  ?>
								 
                            </div>
                        </div>

					</div> */ ?>
<!--  List -->
                
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

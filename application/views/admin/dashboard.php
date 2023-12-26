<?php /*$sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_user_type=$sessiondata['user_type'];*/
?>
<div class="page-body">

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-12">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body" >
										<div class="card-header-dash">
											<h4> Overview</h4>
										</div>
										<div class="row">			
											<div class="col-lg-6 col-xl-3 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon total-booking" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Total Bookings</h5>
																		<h2 class="counter"><?php echo $Booking ;?></h2>
																	</div>									
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-lg-6 col-xl-3 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon service-pro-icon" >
														<div class="media1 static-top-widget row">	
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Total Service Givers</h5>
																		<h2 class="counter"><?php echo $ServiceProvider;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<!-- <div class="col-lg-6 col-xl-3 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon neurse-icon" >
														<div class="media1 static-top-widget row">
														
															<a href="https://lobabooking.csnsindia.com/backend/Nurse/manageNurse"  >
															<div class="media-body1 col-12 de-icon1">
																<div>
																	<h5 class="m-0" style="color: #000;">Total Nurses</h5>
																	<h2 class="counter">4</h2>
																</div>
															</div>
															</a>
														</div>
													</div>
												</div>
											</div> -->
											<div class="col-lg-6 col-xl-3 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon user-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Total Users</h5>
																		
																		<h2 class="counter"><?php  echo $User;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="card">
									<div class="card-body" >
										<div class="card-header-dash">
											<h4> Bookings 
							 				<!-- <select name="booking_filter" id="booking_filter">
												<option>All</option>
												<option>Todays</option>
												<option>Weekly</option>
												<option>Last Month</option>
											</select> -->
											</h4>
										</div>
										<div class="row">
											<!-- <div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon total-booking" >
														<div class="media1 static-top-widget row">	
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Total Bookings</h5>
																		<h2 class="counter"><?php echo $Booking ;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div> -->
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon pending-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Pending Bookings</h5>
																		<h2 class="counter"><?php echo $BookingWaiting ;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<!-- <div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon accepted-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Accepted Bookings</h5>
																		<h2 class="counter"><?php echo $BookingAccepted ;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div> -->
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon ongoing-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Ongoing Bookings</h5>
																		<h2 class="counter"><?php echo $BookingOngoing ;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon completed-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">Completed Bookings</h5>
																		<h2 class="counter"><?php echo $BookingCompleted ;?></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="col-md-12">
								<div class="card">
									<div class="card-body " >
										<div class="card-header-dash">
											<h4> Services wise Bookings </h4>
										</div>
										<div class="row">
									
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body  overviwe-icon service-pro-icon" >
														<div class="media1 static-top-widget row">
														
															<a href="https://lobabooking.csnsindia.com/backend/Booking/manageBooking?service=c2VydmljZXM="  >
															<div class="media-body1 col-12 de-icon1">
																<div>
																	<h5 class="m-0" style="color: #000;">Services Bookings</h5>
																	<h2 class="counter">197</h2>
																</div>
															</div>
															</a>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon doctor-icon" >
														<div class="media1 static-top-widget row">
														
															<a href="https://lobabooking.csnsindia.com/backend/Booking/manageBooking?service=ZG9jdG9y"  >
															<div class="media-body1 col-12 de-icon1">
																<div>
																	<h5 class="m-0" style="color: #000;">Doctors Bookings</h5>
																	<h2 class="counter">147</h2>
																</div>
															</div>
															</a>
														</div>
													</div>
												</div>
											</div>

											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body overviwe-icon neurse-icon" >
														<div class="media1 static-top-widget row">
															<a href="https://lobabooking.csnsindia.com/backend/Booking/manageBooking?service=bnVyc2U="  >
															<div class="media-body1 col-12 de-icon1">
																<div>
																	<h5 class="m-0" style="color: #000;">Nurses Bookings</h5>
																	<h2 class="counter">68</h2>
																</div>
															</div>
															</a>
														</div>
													</div>
												</div>
											</div>


										</div>
									</div>
								</div>
							</div> -->
							<div class="col-md-12">
								<div class="card">
									<div class="card-body" >
										<div class="card-header-dash">
											<h4 > Income 
											
												<!-- onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" -->
												<span class=" pull-right mb-3" style="width:20%,">
													<div class="income"><i class="fa fa-calendar"></i>
														<select name="booking_filter"  data-show-content="true" id="income_filter" class="form-control income-filter pull-right" aria-label="Filter select">
														
															<option selected value="Todays"> Todays </option>
															<option value="Last Month">Last Month</option>
															<option value="Last 6 Months">Last 6 Months</option>
															<option value="Last Year">Last Year</option>
														</select>
													</div>
												</span>
											</h4>
											<div class="clearfix"></div>
										</div>
										<div class="row">									
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body  overviwe-icon income-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;">All Income</h5>
																		<h2 style="font-size: 25px;">₹<span class="counter totalincome">0</span></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body  overviwe-icon paid-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;"> Paid</h5>
																		<h2 style="font-size: 25px;">₹<span class="counter totalpaid">0</span></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-4 xl-30">
												<div class="card card-border">
													<div class="card-body  overviwe-icon unpaid-icon" >
														<div class="media1 static-top-widget row">
															<a href="#"  >
																<div class="media-body1 col-12 de-icon1">
																	<div>
																		<h5 class="m-0" style="color: #000;"> Unpaid</h5>
																		<h2 style="font-size: 25px;">₹<span class="counter totalunpaid">0</span></h2>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>				
					</div>
				</div>
			</div>
		</div>
	<!-- Container-fluid Ends-->

	<!-- Container-fluid starts-->
	
	
	

</div>
</div>